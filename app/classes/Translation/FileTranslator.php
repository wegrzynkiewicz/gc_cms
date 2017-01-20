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
            $this->translations = require $this->translationPath;
        }
    }

    public function __destruct()
    {
        if ($this->refresh) {
            Disc::makeFile($this->translationPath);
            Disc::exportDataToPHPFile($this->translations, $this->translationPath);
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
