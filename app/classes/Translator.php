<?php

namespace GC;

class Translator
{
    private static $instance = null;
    
    public $refresh = false;
    public $translations = [];
    public $translationPath = '';
    public static $domain = 'visitor';

    private function __construct($translationPath)
    {
        $this->translationPath = $translationPath;

        if (is_readable($this->translationPath)) {
            $json = file_get_contents($this->translationPath);
            $this->translations = json_decode($json, true);
        }
    }

    public function __destruct()
    {
        if ($this->refresh) {
            makeFile($this->translationPath);
            $json = json_encode($this->translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($this->translationPath, $json);
        }
    }

    public function translate($text, array $params = [])
    {
        if (!isset($this->translations[static::$domain])) {
            $this->translations[static::$domain] = [];
        }

        if (!isset($this->translations[static::$domain][$text])) {
            $this->translations[static::$domain][$text] = $text;
            $this->refresh = true;
        }

        return vsprintf($this->translations[static::$domain][$text], $params);
    }

    /**
     * Pobiera instancję translatora. Tworzy ją w razie potrzeby i zapamiętuje
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static(
                $GLOBALS['config']['translator']['folder'].'/'.getVisitorLang().'.php'
            );
        }

        return static::$instance;
    }
}
