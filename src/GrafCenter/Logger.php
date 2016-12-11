<?php

class Logger
{
    private $filename = "";
    private static $instance;

    public function __construct()
    {
        $folder = getConfig()['logger']['folder'];
        $this->filename = sprintf("%s/%s.log", $folder, date('Y-m-d'));

        if (!is_readable($this->filename)) {
            rmkdir(dirname($this->filename));
        }
    }

    public static function __callStatic($methodName, array $arguments)
    {
        if (getConfig()['logger']['enabled']) {
            $arguments[0] = sprintf('[%s] %s', strtoupper($methodName), $arguments[0]);
            call_user_func_array([static::getInstance(), 'log'], $arguments);
        }
    }

    private function log($message, array $params = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        array_shift($backtrace);
        array_shift($backtrace);
        $execution = array_shift($backtrace);

        $log = sprintf("[%s] %s :: %s :: %s:%s\n",
            self::getMicroDateTime()->format('H:i:s.u'),
            $message,
            json_encode($params),
            relativePath($execution['file']),
            $execution['line']
        );

        file_put_contents($this->filename, $log, FILE_APPEND);
    }

    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
            $content = "=================\n";
            file_put_contents(self::$instance->filename, $content, FILE_APPEND);
        }

        return self::$instance;
    }

    /**
     * Zwraca obiekt DataTime z mikrosekundami
     */
    private static function getMicroDateTime()
    {
        $time = microtime(true);
        $micro = sprintf("%06d", ($time - floor($time)) * 1000000);

        return new DateTime(date('Y-m-d H:i:s.'.$micro, $time));
    }
}
