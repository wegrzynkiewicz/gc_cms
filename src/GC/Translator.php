<?php

declare(strict_types=1);

namespace GC;

class Translator
{
    private static $instance = null;

    private $translations = [];
    private $translationPath = '';
    public static $domain = 'visitor';

    private function __construct(string $translationPath)
    {
        $this->translationPath = $translationPath;

        if (is_readable($this->translationPath)) {
            $json = file_get_contents($this->translationPath);
            $this->translations = json_decode($json, true);
        }
    }

    public function dumpFile(): void
    {
        makeFile($this->translationPath);
        $json = json_encode($this->translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($this->translationPath, $json);
    }

    public function translate(string $text, array $params = []): string
    {
        if (!isset($this->translations[static::$domain])) {
            logger('[TRANSLATOR] Missing domain', [static::$domain]);
            $this->translations[static::$domain] = [];
        }

        if (!isset($this->translations[static::$domain][$text])) {
            $this->translations[static::$domain][$text] = $text;
            $this->dumpFile();
            logger('[TRANSLATOR] Missing translation', [static::$domain, $text]);
        }

        return vsprintf($this->translations[static::$domain][$text], $params);
    }

    /**
     * Pobiera instancję translatora. Tworzy ją w razie potrzeby i zapamiętuje
     */
    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static(
                $GLOBALS['config']['translator']['folder'].'/'.getVisitorLang().'.json'
            );
        }

        return static::$instance;
    }
}
