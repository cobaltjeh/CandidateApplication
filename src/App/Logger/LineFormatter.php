<?php

declare(strict_types = 1);

namespace App\Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Formatter\LineFormatter as MonologLineFormatter;

/**
 * Custom logger format, so we can add some information
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class LineFormatter extends MonologLineFormatter
{
    const FORMAT = "%datetime% [%level_name%] [%channel%] [%pid%] %message% %context% %extra%\n";

    const DATE_FORMAT = "Y-m-d\TH:i:s.uO";

    /**
     * @var array
     */
    private $logLevels = [
        MonologLogger::DEBUG => "\033[1;32mdebug\033[0m",
        MonologLogger::INFO => 'informational',
        MonologLogger::NOTICE => 'notice',
        MonologLogger::WARNING => "\033[0;31mwarning\033[0m ",
        MonologLogger::ERROR => "\033[1;31merror\033[0m",
        MonologLogger::CRITICAL => 'critical',
        MonologLogger::ALERT => 'alert',
        MonologLogger::EMERGENCY => 'emergency',
    ];

    /**
     * constructor
     *
     * @param string $format     The format of the message
     * @param string $dateFormat The format of the timestamp: one supported by DateTime::format
     */
    public function __construct(string $format = null, string $dateFormat = null)
    {
        $format = $format ? : static::FORMAT;
        $dateFormat = $dateFormat ? : static::DATE_FORMAT;

        parent::__construct($format, $dateFormat, true);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record The record to save
     */
    public function format(array $record)
    {
        $record['level_name'] = $this->logLevels[$record['level']];
        $record['pid'] = getmypid();

        return parent::format($record);
    }
}
