<?php

namespace App\Dto;

/**
 * Handle payload from os2forms.
 */
final class TileInput
{
    public array $data = [
        'webform' => [
            'id' => '',
        ],
        'submission' => [
            'uuid' => '',
        ],
    ];

    public array $links = [
        'sender' => '',
        'get_submission_url' => '',
    ];
}
