<?php

/** Plik generuje mapę strony */

$root = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
$root->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

$frames = GC\Model\Frame::select()
    ->fields(['type', 'slug', 'modification_datetime'])
    ->order('slug', 'DESC')
    ->fetchAll();

foreach ($frames as $frame) {

    if (!$frame['slug']) {
        continue;
    }

    $loc = $uri->absolute($frame['slug']);
    $date = new DateTime($frame['modification_datetime']);

    $url = $root->addChild('url');
    $url->addChild('loc', $loc);
    $url->addChild('lastmod', $date->format('Y-m-d'));
}

echo $root->asXML();
