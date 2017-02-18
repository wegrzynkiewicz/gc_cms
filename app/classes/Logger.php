<?php

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
        $log = sprintf("[%s] %s :: %s\n",
            getMicroDateTime()->format('H:i:s.u'),
            $message,
            json_encode($params, JSON_UNESCAPED_UNICODE)
        );

        file_put_contents($this->filename, $log, FILE_APPEND);
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
