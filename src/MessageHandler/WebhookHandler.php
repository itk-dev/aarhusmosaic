<?php
// api/src/Handler/PersonHandler.php

namespace App\MessageHandler;

use App\Entity\Webhook;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WebhookHandler
{
    public function __invoke(Webhook $hook): void
    {
        // do something with the resource
        $t=1;
    }
}
