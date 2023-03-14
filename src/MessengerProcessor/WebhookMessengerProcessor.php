<?php

namespace App\MessengerProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Symfony\Messenger\ContextStamp;
use App\Entity\ApiUser;
use App\Entity\Webhook;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Webhook message processor that add the current logged in API user before creating message with the data.
 */
class WebhookMessengerProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly Security $security,
    ) {
    }

    /**
     * Helper function to dispatch message.
     *
     * @param mixed $data
     * @param array $context
     *
     * @return mixed
     */
    private function persist(mixed $data, array $context = []): mixed
    {
        $envelope = $this->messageBus->dispatch(
            (new Envelope($data))
                ->with(new ContextStamp($context))
        );

        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp instanceof HandledStamp) {
            return $data;
        }

        return $handledStamp->getResult();
    }

    /**
     * {@inheritDoc}
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        /** @var ApiUser $user */
        $user = $this->security->getUser();

        /* @var Webhook $data */
        $data->setRemoteApiKey($user->getRemoteApiKey());

        return $this->persist($data, $context);
    }
}
