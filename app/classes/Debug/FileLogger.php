<?php

namespace GC\Debug;

class FileLogger
{
    private $filename = "";

    public function __construct($filename)
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
}
