<?php

namespace GC;

class Thumb
{
    private $imageUrl = '';
    private $width = 0;
    private $height = 0;
    private $thumbUrl = '';
    private $extension = '';
    private $params = [];

    public function __construct($imageUrl, $width, $height)
    {
        $this->imageUrl = $imageUrl;
        $this->width = $width;
        $this->height = $height;
        $this->extension = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));

        $options = getConfig()['thumb']['options'];
        if (isset($options[$this->extension])) {
            $this->params = $options[$this->extension];
            $this->url = $this->makeUrl();
        } else {
            $this->url = $imageUrl;
        }
    }

    /**
     * Zwraca url miniaturki
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sprawdza czy miniaturka istnieje
     */
    public function exists()
    {
        return is_readable(".{$this->url}");
    }

    /**
     * Generuje url miniaturki na podstawie url obrazka
     */
    private function makeUrl()
    {
        $thumbsUrl      = getConfig()['thumb']['thumbsUrl'];
        $imageUrl       = urldecode($this->imageUrl);
        $sufix          = '/'.$this->width.'x'.$this->height;
        $normalized     = Normalizer::normalize($imageUrl);
        $filename       = pathinfo($normalized, PATHINFO_FILENAME);
        $folder         = dirname($normalized);

        return "{$thumbsUrl}{$folder}/{$filename}{$sufix}.{$this->extension}";
    }

    /**
     * Tworzy i zapisuje miniaturkę dla pliku
     */
    public function generate()
    {
        $imageUrl = urldecode($this->imageUrl);
        $destFilePath   = ".{$this->url}";
        $sourceFilePath = ".{$imageUrl}";

        if (is_readable($destFilePath)) {
            return true;
        }

        if (!is_readable($sourceFilePath)) {
            return false;
        }

        rmkdir(pathinfo($destFilePath, PATHINFO_DIRNAME));

        $loader = $this->params['loader'];
        $sourceImage = $loader($sourceFilePath);
        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        $distWidth = $this->width;
        $distHeight = $this->height;

        $ratio = $sourceWidth / $sourceHeight;

        if ($distWidth / $distHeight > $ratio) {
            $distWidth = $distHeight * $ratio;
        } else {
            $distHeight = $distWidth / $ratio;
        }

        $thumbImage = imagecreatetruecolor($distWidth, $distHeight);

        if ($this->params['transparent'] === true) {
            $backgroundColor = imagecolorallocate($thumbImage, 0, 0, 0);
            imagecolortransparent($thumbImage, $backgroundColor);
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $distWidth,
                           $distHeight, $sourceWidth, $sourceHeight);

        $saver = $this->params['saver'];
        $saver($thumbImage, $destFilePath, $this->params['quality']);
        chmod($destFilePath, 0775);

        return true;
    }

    public static function make($imageUrl, $width, $height)
    {
        $thumb = new static($imageUrl, $width, $height);

        return $thumb->generate() ? $thumb->getUrl() : $imageUrl;
    }
}
