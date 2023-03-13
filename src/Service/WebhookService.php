<?php

namespace App\Service;

use App\Entity\Webhook;
use ItkDev\MetricsBundle\Service\MetricsService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @TODO: Fixed this service when OS2forms once more is installable.
 */
class WebhookService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly MetricsService $metricsService
    ) {
    }

    public function getData(Webhook $message): array
    {
        $this->metricsService->counter('webhook_download_total', 'Webhook download called counter', 1, ['type' => 'webhook']);

        $submissionUrl = $message->getSubmissionURL();
        $remoteApiKey = $message->getRemoteApiKey();

        return $this->getSubmission($submissionUrl, $remoteApiKey);
    }

    public function getSubmission(string $submissionUrl, string $remoteApiKey): array
    {
        try {
            $response = $this->client->request('GET', $submissionUrl, [
                'headers' => [
                    'api-key' => $remoteApiKey,
                ],
            ]);

            $data = $response->toArray();

            return $data['data'] ?? [];
        } catch (\Exception $exception) {
            // throw new WebformSubmissionRetrievalException($exception->getMessage(), $exception->getCode());
        }

        $this->metricsService->counter('webhook_download_failed_total', 'Webhook download failed counter', 1, ['type' => 'webhook']);

        return [];
    }
}
