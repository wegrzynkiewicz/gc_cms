<?php

namespace GC;

use GC\Request;

class Router
{
    public $method = '';
    public $slug = '';

    public $parts = [];
    public $parameters = [];
    public $segments = [];

    public function __construct($method, $slug)
    {
        $this->method = $method;
        $this->slug = $slug;

        $this->parts = explode('/', trim($this->slug, '/'));
        $this->parameters = array_filter($this->parts, 'ctype_digit');
    }

    public function resolve()
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
            ->fetch();

        # jeżeli nie uda się pobrać rusztowania
        if (!$frame) {
            return null;
        }

        # jeżeli istnieje niestandardowy plik w folderze z szablonem
        if ($file = $this->getFile(TEMPLATE_PATH, "custom/".$frame['frame_id'], $frame['theme'])) {
            return $file;
        }

        # jeżeli slug rusztowania wskazuje na stronę główną
        if ($frame['slug'] == '/' and $file = $this->getFile(TEMPLATE_PATH, 'homepage', $frame['theme'])) {
            return $file;
        }

        # jeżeli istnieje plik rusztowania w folderze z szablonem
        if ($file = $this->getFile(TEMPLATE_PATH, "frames/".$frame['type'], $frame['theme'])) {
            return $file;
        }

        return null;
    }

    protected function getFile($path, $name, $theme = 'default')
    {
        $files = [
            "{$path}/{$this->method}-{$name}-{$theme}.html.php",
            "{$path}/{$this->method}-{$name}-{$theme}.php",
            "{$path}/{$this->method}-{$name}.html.php",
            "{$path}/{$this->method}-{$name}.php",
            "{$path}/{$name}-{$theme}.html.php",
            "{$path}/{$name}-{$theme}.php",
            "{$path}/{$name}.html.php",
            "{$path}/{$name}.php",
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                return $file;
            }
        }

        return null;
    }
}
