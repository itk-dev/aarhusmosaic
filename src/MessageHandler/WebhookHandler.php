<?php

// api/src/Handler/PersonHandler.php

namespace App\MessageHandler;

use App\Entity\Tile;
use App\Entity\Webhook;
use App\Service\WebhookService;
use Doctrine\ORM\EntityManagerInterface;
use ItkDev\MetricsBundle\Service\MetricsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
final class WebhookHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MetricsService $metricsService,
        private readonly WebhookService $webhookService,
    ) {
    }

    public function __invoke(Webhook $hook): void
    {
        $this->metricsService->counter('webhook_called_total', 'Webhook called counter', 1, ['type' => 'webhook']);

        /**
         * @TODO: User the webhook service to actually get data, when OS2Forms is installable once more.
         */
        $tile = new Tile();

        $this->em->persist($tile);
        $this->em->flush();

        $this->metricsService->counter('webhook_success_total', 'Webhook completed successful', 1, ['type' => 'webhook']);
    }
}

// throw new ReQueueMessageException('Cover store error - retry');
// throw new UnrecoverableMessageHandlingException('Cover store invalid resource error');
