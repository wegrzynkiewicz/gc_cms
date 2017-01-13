<?php

namespace GC\Debug;

use GC\Disc;

class FileLogger
{
    private $filename = "";

    public function __construct($filename)
    {
        $this->filename = $filename;

        if (!is_readable($this->filename)) {
            Disc::makeDirRecursive(dirname($this->filename));
        }
    }

    public function __call($name, array $arguments)
    {
        $arguments[0] = sprintf('[%s] %s', strtoupper($name), $arguments[0]);
        call_user_func_array([$this, 'log'], $arguments);
    }

    private function log($message, array $params = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        array_shift($backtrace);
        array_shift($backtrace);
        $execution = array_shift($backtrace);

        $log = sprintf("[%s] %s :: %s :: %s:%s\n",
            static::getMicroDateTime()->format('H:i:s.u'),
            $message,
            json_encode($params, JSON_UNESCAPED_UNICODE),
            relativePath($execution['file']),
            $execution['line']
        );

        file_put_contents($this->filename, $log, FILE_APPEND);
    }

    /**
     * Zwraca obiekt DataTime z mikrosekundami
     */
    private static function getMicroDateTime()
    {
        $time = microtime(true);
        $micro = sprintf("%06d", ($time - floor($time)) * 1000000);

        return new \DateTime(date('Y-m-d H:i:s.'.$micro, $time));
    }
}
