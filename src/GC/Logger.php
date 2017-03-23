<?php

declare(strict_types=1);

namespace GC;

class Logger
{
    private static $instance = null;

    private $filename = "";

    private function __construct($filename)
    {
        $this->filename = $filename;

        if (!is_readable($this->filename)) {
            makeDirRecursive(dirname($this->filename));
        }

        $log = '================='.PHP_EOL;
        file_put_contents($this->filename, $log, FILE_APPEND);
    }

    public function info($message, array $params = [])
    {
        $date = getMicroDateTime()->format('H:i:s.u');
        $log = "[{$date}] {$message}";

        if (!empty($params)) {
            $log .= ' :: '.json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        file_put_contents($this->filename, $log.PHP_EOL, FILE_APPEND);
    }

    /**
     * Pobiera instancję loggera. Tworzy ją w razie potrzeby i zapamiętuje
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static(
                $GLOBALS['config']['logger']['folder'].'/'.date('Y-m-d').'.log'
            );
        }

        return static::$instance;
    }
}
