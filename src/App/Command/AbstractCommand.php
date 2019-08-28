<?php

declare(strict_types = 1);

namespace App\Command;

use App\Logger\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    use LoggerAwareTrait;

    /**
     * @var null|float
     */
    protected $startTime;

    /**
     * Called when project is started
     */
    public function onStarted()
    {
        $this->startTime = microtime(true);

        $userInfo = posix_getpwuid(posix_geteuid());

        $this->notice(
            sprintf(
                '%s started (PHP: %s, USR: %s, PID: %s)',
                $this->getName(),
                PHP_VERSION,
                $userInfo['name'],
                getmypid()
            )
        );
    }

    /**
     * Called when project is going to shutwdown
     */
    public function onShutdown()
    {
        $this->notice(
            sprintf(
                '%s stopped (RUNTIME: %g)',
                $this->getName(),
                microtime(true) - $this->startTime
            )
        );
    }
}
