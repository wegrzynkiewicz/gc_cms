<?php

namespace GC\Translation;

use GC\Disc;

class FileTranslator
{
    public $refresh = false;
    public $translations = [];
    public $translationPath = '';

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
            $json = json_encode($this->translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            Disc::makeFile($this->translationPath);
            file_put_contents($this->translationPath, $json);
        }
    }

    public function translate($text, array $params = [])
    {
        if (!isset($this->translations[$text])) {
            $this->translations[$text] = $text;
            $this->refresh = true;
        }

        return vsprintf($this->translations[$text], $params);
    }
}
