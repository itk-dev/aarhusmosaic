<?php

namespace App\MessageHandler;

use App\Entity\Tags;
use App\Entity\Tile;
use App\Entity\Webhook;
use App\Repository\TagsRepository;
use App\Service\WebhookService;
use Doctrine\ORM\EntityManagerInterface;
use ItkDev\MetricsBundle\Service\MetricsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WebhookHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TagsRepository $tagsRepository,
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
            ->setAccepted($data['accepted'])
            ->setExtra($data['extra']);

        foreach ($data['tags'] as $tag) {
            $entity = $this->tagsRepository->findOneBy(['tag' => $tag]);
            if (is_null($entity)) {
                $entity = new Tags();
                $entity->setTag($tag);
                $this->em->persist($entity);

                // Need to flush data to ensure the findOneBy above now will find the new tag in next loop.
                $this->em->flush();
            }
            $tile->addTag($entity);
        }

        $this->em->persist($tile);
        $this->em->flush();

        $this->metricsService->counter('webhook_success_total', 'Webhook completed successful', 1, ['type' => 'webhook']);
    }
}
