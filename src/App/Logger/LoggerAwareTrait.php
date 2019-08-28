<?php

declare(strict_types = 1);

namespace App\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait as PsrLogLoggerTrait;

/**
 * Trait for Logger awareness
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
trait LoggerAwareTrait
{
    use PsrLogLoggerTrait;

    /**
     * @var LoggerInterface|Logger
     */
    protected $logger;

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, string $message, array $context = []): void
    {
        if ($this->logger === null) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }

    /**
     * Sets a logger.
     *
     * @required
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
