<?php

declare(strict_types=1);

namespace GC;

use GC\Request;
use GC\Exception\ResponseException;

class Router
{
    public $method = '';
    public $slug = '';
    public $extension = '';

    public $parts = [];
    public $parameters = [];
    public $segments = [];

    public function __construct(string $method, string $slug, string $extension)
    {
        $this->method = strtolower($method);
        $this->slug = $slug;
        $this->extension = $extension;

        $this->parts = explode('/', trim($this->slug, '/'));
        $this->parameters = array_filter($this->parts, 'ctype_digit');
    }

    public function resolve(): string
    {
        $this->segments = array_filter($this->parts, function ($segment) {
            return !ctype_digit($segment);
        });

        # wyszukaj plik w katalogu akcji, który pasuje do adresu uri
        $path = ROUTES_PATH;
        while (count($this->segments) > 0) {
            $segment = array_shift($this->segments);

            # jeżeli istnieje jakikolwiek z pasujących plików
            if ($file = $this->getFile($path, $segment)) {
                return $file;
            }

            # jeżeli istnieje folder, wtedy kontynuuj pętlę, ale nie wykonuj dalej
            $folder = "{$path}/{$segment}";
            if (is_dir($folder) and count($this->segments)) {
                $path = $folder;
                continue;
            }

            # jeżeli nie istnieje akcja to spróbuj załadować plik start
            if ($file = $this->getFile("{$path}/{$segment}", 'start')) {
                return $file;
            }

            break;
        }

        # jeżeli istnieje statyczna strona główna
        if ($this->slug === '/' and $file = $this->getFile(TEMPLATE_PATH, 'static/homepage')) {
            return $file;
        }

        # jeżeli istnieje statyczna strona o takim samym slugu
        if ($file = $this->getFile(TEMPLATE_PATH, "static{$this->slug}")) {
            return $file;
        }

        # pobierz rusztowanie po slugu
        $frame = \GC\Model\Frame::select()
            ->equals('slug', $this->slug)
            ->fetchObject();

        # jeżeli nie uda się pobrać rusztowania
        if (!$frame) {
            throw new ResponseException(sprintf(
                'Slug (%s) was not found', $this->slug
            ), 404);
        }

        extract($frame->getData());

        # dodanie rusztowania jako zmiennej globalnej
        $GLOBALS['frame'] = $frame;
        $GLOBALS['frame_id'] = $frame_id;

        # jeżeli istnieje niestandardowy plik w folderze z szablonem
        if ($file = $this->getFile(TEMPLATE_PATH, "custom/{$frame_id}", $theme)) {
            return $file;
        }

        # jeżeli slug rusztowania wskazuje na stronę główną
        if ($slug == '/' and $file = $this->getFile(TEMPLATE_PATH, 'homepage', $theme)) {
            return $file;
        }

        # jeżeli istnieje plik rusztowania w folderze z szablonem
        if ($file = $this->getFile(TEMPLATE_PATH."/frames/{$type}", '', $theme)) {
            return $file;
        }

        # jeżeli istnieje plik główny każdego rusztowania
        if ($file = $this->getFile(TEMPLATE_PATH, 'frame', $theme)) {
            return $file;
        }

        throw new ResponseException('Unknown frame type', 500);
    }

    protected function getFile(string $path, string $name, string $theme = 'default'): string
    {
        $files = [
            "{$path}/{$this->method}-{$name}-{$theme}.{$this->extension}.php",
            "{$path}/{$this->method}-{$name}-{$theme}.php",
            "{$path}/{$this->method}-{$name}.{$this->extension}.php",
            "{$path}/{$this->method}-{$name}.php",
            "{$path}/{$this->method}-{$theme}.{$this->extension}.php",
            "{$path}/{$this->method}-{$theme}.php",
            "{$path}/{$name}-{$theme}.{$this->extension}.php",
            "{$path}/{$name}-{$theme}.php",
            "{$path}/{$name}.{$this->extension}.php",
            "{$path}/{$name}.php",
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                return $file;
            }
        }

        return '';
    }
}
