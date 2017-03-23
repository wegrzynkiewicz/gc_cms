<?php

declare(strict_types=1);

namespace GC;

use Katzgrau\KLogger\Logger as BaseLogger;
use Psr\Log\LogLevel;

class Logger extends BaseLogger
{
    private static $instance = null;

    /**
     * Pobiera instancję loggera. Tworzy ją w razie potrzeby i zapamiętuje
     */
    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static(
                $GLOBALS['config']['logger']['folder'], LogLevel::DEBUG, [
                    'dateFormat' => 'H:i:s.u',
                    'filename' => date('Y-m-d').'.log',
                    'appendContext' => false,
                    'logFormat' => "[{date}] {message} :: {context}",
                ]
            );
            static::$instance->write("=================\n");
        }

        return static::$instance;
    }
}
