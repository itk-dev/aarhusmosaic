<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(status: 202, output: false, messenger: true),
    ],
    security: "is_granted('ROLE_API_USER')"
)]
final class Webhook
{
    #[Assert\NotBlank]
    public array $data = [
        'webform' => [
            'id' => '',
        ],
        'submission' => [
            'uuid' => '',
        ],
    ];

    #[Assert\NotBlank]
    public array $links = [
        'sender' => '',
        'get_submission_url' => '',
    ];
}
