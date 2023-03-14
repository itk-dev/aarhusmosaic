<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\MessengerProcessor\WebhookMessengerProcessor;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(status: 202, output: false, messenger: true, processor: WebhookMessengerProcessor::class),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    security: "is_granted('ROLE_API_USER')"
)]
final class Webhook
{
    #[Assert\NotBlank]
    #[Groups('write')]
    public array $data = [
        'webform' => [
            'id' => '',
        ],
        'submission' => [
            'uuid' => '',
        ],
    ];

    #[Assert\NotBlank]
    #[Groups('write')]
    public array $links = [
        'sender' => '',
        'get_submission_url' => '',
    ];

    /**
     * Internal key used in callback.
     */
    public string $remoteApiKey;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getRemoteApiKey(): string
    {
        return $this->remoteApiKey;
    }

    public function setRemoteApiKey(string $remoteApiKey): self
    {
        $this->remoteApiKey = $remoteApiKey;

        return $this;
    }

    public function getSubmissionURL(): string
    {
        $url = $this->links['get_submission_url'];

        // Hack to use when during local testing between containers.
        // $url = str_replace('http://default', 'http://selvbetjening-nginx-1.frontend:8080', $url);

        return $url;
    }
}
