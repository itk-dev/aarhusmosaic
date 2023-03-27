<?php

namespace App\Service;

use App\Entity\Webhook;
use App\Exception\InvalidDataException;
use App\Exception\WebhookException;
use ItkDev\MetricsBundle\Service\MetricsService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WebhookService
{
    public function __construct(
        private readonly string $projectDir,
        private readonly HttpClientInterface $client,
        private readonly MetricsService $metricsService
    ) {
    }

    /**
     * Get submission data (validated).
     *
     * Side-effect: image is downloaded.
     *
     * @param string $submissionUrl
     *   The remote submission URL to fetch data from
     * @param string $remoteApiKey
     *   Remote API key to access submission data
     *
     * @return array
     *   Validate data array that matches the webhook entity
     *
     * @throws InvalidDataException
     * @throws TransportExceptionInterface
     * @throws WebhookException
     */
    private function getSubmission(string $submissionUrl, string $remoteApiKey): array
    {
        try {
            $response = $this->client->request('GET', $submissionUrl, [
                'headers' => [
                    'api-key' => $remoteApiKey,
                ],
            ]);

            $data = $response->toArray();
        } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $exception) {
            $this->metricsService->counter('webhook_download_failed_total', 'Webhook download failed counter', 1, ['type' => 'webhook']);

            throw new WebhookException('Fail to fetch submission data: '.$exception->getMessage(), $exception->getCode(), $exception);
        }

        $data = $this->validateAndTransformData($data['data'] ?? []);
        $data['image'] = $this->downloadImage($data['image'], $remoteApiKey);

        return $data;
    }

    /**
     * Download image form remote server (os2forms).
     *
     * @param string $url
     *   URL to download image from
     * @param string $remoteApiKey
     *   Remote API key to access submission data
     *
     * @return string
     *   The downloaded image path (destination)
     *
     * @throws WebhookException
     * @throws TransportExceptionInterface
     */
    private function downloadImage(string $url, string $remoteApiKey): string
    {
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'api-key' => $remoteApiKey,
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            $this->metricsService->counter('webhook_image_failed_total', 'Webhook download image failed counter', 1, ['type' => 'webhook']);

            throw new WebhookException('Fail to fetch image (dode: '.$response->getStatusCode().')');
        }

        $uri = '/tiles/'.basename($url);
        $dest = $this->projectDir.'/public'.$uri;
        $fileHandler = fopen($dest, 'w');
        foreach ($this->client->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        $this->metricsService->counter('webhook_image_completed_total', 'Webhook download image successful downloaded counter', 1, ['type' => 'webhook']);

        return $uri;
    }

    /**
     * Validate and transform submission data into format matching webhook entity.
     *
     * @param array $data
     *   Raw submission data
     *
     * @return array
     *   Validate data array that matches the webhook entity
     *
     * @throws InvalidDataException
     */
    private function validateAndTransformData(array $data): array
    {
        $output = [
            'accepted' => false,
            'extra' => [],
        ];

        // Check for required data (and fail fast by throwing exception thereby sending the message to failed queue).
        $required = ['description', 'mail', 'image', 'tags'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new InvalidDataException('Missing "'.$field.'" data in payload');
            }

            if ('image' === $field) {
                $output['image'] = $data['linked']['image'][$data['image']]['url'];
                unset($data['linked']);
            } else {
                $output[$field] = $data[$field];
            }
            unset($data[$field]);
        }

        // Move data left into extra field.
        foreach ($data as $field => $datum) {
            $data['extra'][$field] = $datum;
        }

        return $output;
    }

    /**
     * Fetch data from remote server, transform and validate it.
     *
     * @param webhook $message
     *   Webhook message with callback information
     *
     * @return array
     *   Array with validate data
     *
     * @throws InvalidDataException
     * @throws TransportExceptionInterface
     * @throws WebhookException
     */
    public function getData(Webhook $message): array
    {
        $this->metricsService->counter('webhook_download_total', 'Webhook download called counter', 1, ['type' => 'webhook']);

        $submissionUrl = $message->getSubmissionURL();
        $remoteApiKey = $message->getRemoteApiKey();

        return $this->getSubmission($submissionUrl, $remoteApiKey);
    }
}
