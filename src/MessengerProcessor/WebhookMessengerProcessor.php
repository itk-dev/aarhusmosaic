<?php

namespace App\MessengerProcessor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Symfony\Messenger\ContextStamp;
use ApiPlatform\Symfony\Messenger\RemoveStamp;
use App\Entity\Webhook;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class WebhookMessengerProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly Security $security,
    ) {
    }

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

    private function remove(mixed $data): void
    {
        $this->messageBus->dispatch((new Envelope($data))->with(new RemoveStamp()));
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $user = $this->security->getUser();
        /* @var Webhook $data */
        $data->setRemoteApiKey($user->getRemoteApiKey());
        if ($operation instanceof DeleteOperationInterface) {
            $this->remove($data);

            return $data;
        }

        return $this->persist($data, $context);
    }
}
