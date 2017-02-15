<?php

namespace GC\Translation;

class FileTranslator
{
    public $refresh = false;
    public $translations = [];
    public $translationPath = '';
    public $domain = 'visitor';

    public function __construct($translationPath)
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
        if (!isset($this->translations[$this->domain])) {
            $this->translations[$this->domain] = [];
        }

        if (!isset($this->translations[$this->domain][$text])) {
            $this->translations[$this->domain][$text] = $text;
            $this->refresh = true;
        }

        return vsprintf($this->translations[$this->domain][$text], $params);
    }
}
