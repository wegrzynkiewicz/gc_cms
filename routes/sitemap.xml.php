<?php

/** Plik generuję mapę strony */

$root = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
$root->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

$frames = GC\Model\Frame::select()
    ->fields(['type', 'slug', 'modify_datetime'])
    ->order('slug', 'DESC')
    ->fetchAll();

foreach ($frames as $frame) {

    $loc = $uri->absolute($frame['slug']);
    $date = new DateTime($frame['modify_datetime']);

    $url = $root->addChild('url');
    $url->addChild('loc', $loc);
    $url->addChild('lastmod', $date->format('Y-m-d'));
}

header('Content-type: text/xml; charset=UTF-8');
echo $root->asXML();
