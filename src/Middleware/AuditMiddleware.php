<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class AuditMiddleware implements MiddlewareInterface
{
    /**
     * @param Envelope $envelope
     *
     * {@inheritdoc}
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (null === $auditEnvelope = $envelope->last(AuditEnvelopeItem::class)) {
            $envelope = $envelope->with(
                $auditEnvelope = new AuditEnvelopeItem(uniqid())
            );
        }

        try {
            if (null !== $envelope->last(ReceivedStamp::class)) {
                echo sprintf('[%s] Received message "%s"' . "\n", $auditEnvelope->getUuid(), get_class($message));
            } else {
                echo sprintf('[%s] Started with message "%s"' . "\n", $auditEnvelope->getUuid(), get_class($message));
            }

            return $stack->next()->handle($envelope, $stack);
        } finally {
            echo sprintf('[%s] Ended with message "%s"'."\n", $auditEnvelope->getUuid(), get_class($message));
        }
    }
}
