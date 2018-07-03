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

        try {
            if (null !== $envelope->get(ReceivedMessage::class)) {
                echo sprintf('Received message "%s"' . "\n", get_class($message));
            } else {
                echo sprintf('Started with message "%s"' . "\n", get_class($message));
            }

            return $next($message);
        } finally {
            echo sprintf('Ended with message "%s"'."\n", get_class($message));
        }
    }
}
