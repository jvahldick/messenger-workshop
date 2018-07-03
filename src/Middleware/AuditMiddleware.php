<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class AuditMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle($message, callable $next)
    {
        try {
            echo sprintf('Started with message "%s"'."\n", get_class($message));

            return $next($message);
        } finally {
            echo sprintf('Ended with message "%s"'."\n", get_class($message));
        }
    }
}
