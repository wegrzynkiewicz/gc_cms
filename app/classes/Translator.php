<?php

namespace GC;

class Translator
{
    private static $instance;

    public $refresh = false;
    public $translations = [];
    public $translationFile = '';

    private function __construct()
    {
        $folder = getConfig()['translator']['folder'];
        $lang = getClientLang();

        $this->translationPath = "$folder/$lang.json";

        if (is_readable($this->translationPath)) {
            $json = file_get_contents($this->translationPath);
            $this->translations = json_decode($json, true);
        }
    }

    public function __destruct()
    {
        if ($this->refresh) {
            $json = json_encode($this->translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            createFile($this->translationPath);
            file_put_contents($this->translationPath, $json);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function translate($text, array $params = [])
    {
        if (!getConfig()['translator']['enabled']) {
            return vsprintf($text, $params);
        }

        if (!isset($this->translations[$text])) {
            $this->translations[$text] = $text;
            $this->refresh = true;
        }

        return vsprintf($this->translations[$text], $params);
    }
}
