<?php

namespace App\MessageHandler;

use App\Entity\Tile;
use App\Entity\Webhook;
use App\Service\WebhookService;
use Doctrine\ORM\EntityManagerInterface;
use ItkDev\MetricsBundle\Service\MetricsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WebhookHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MetricsService $metricsService,
        private readonly WebhookService $webhookService,
    ) {
    }

    public function __invoke(Webhook $message): void
    {
        $this->metricsService->counter('webhook_called_total', 'Webhook called counter', 1, ['type' => 'webhook']);

        // Throws exception that should not be caught, as not catching them will send the message into the failed queue
        // for later debugging.
        $data = $this->webhookService->getData($message);

        $tile = new Tile();
        $tile->setDescription($data['description'])
            ->setMail($data['mail'])
            ->setImage($data['image'])
            ->setTags($data['tags'])
            ->setAccepted($data['accepted'])
            ->setExtra($data['extra']);
        $this->em->persist($tile);
        $this->em->flush();

        $this->metricsService->counter('webhook_success_total', 'Webhook completed successful', 1, ['type' => 'webhook']);
    }
}
