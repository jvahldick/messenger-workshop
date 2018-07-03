<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Asynchronous\Transport\ReceivedMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\EnvelopeAwareInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class AuditMiddleware implements MiddlewareInterface, EnvelopeAwareInterface
{
    /**
     * @param Envelope $envelope
     *
     * {@inheritdoc}
     */
    public function handle($envelope, callable $next)
    {
        $message = $envelope->getMessage();

        if (null === $auditEnvelope = $envelope->get(AuditEnvelopeItem::class)) {
            $envelope = $envelope->with(
                $auditEnvelope = new AuditEnvelopeItem(uniqid())
            );
        }

        try {
            if (null !== $envelope->get(ReceivedMessage::class)) {
                echo sprintf('[%s] Received message "%s"' . "\n", $auditEnvelope->getUuid(), get_class($message));
            } else {
                echo sprintf('[%s] Started with message "%s"' . "\n", $auditEnvelope->getUuid(), get_class($message));
            }

            return $next($envelope);
        } finally {
            echo sprintf('[%s] Ended with message "%s"'."\n", $auditEnvelope->getUuid(), get_class($message));
        }
    }
}
