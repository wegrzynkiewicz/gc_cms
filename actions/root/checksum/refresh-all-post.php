<?php

GC\Model\Checksum::delete()->execute();

foreach($getFiles() as $file) {
    GC\Model\Checksum::insert([
        'file' => trim($file, '.'),
        'hash' => sha1(file_get_contents($file)),
    ]);
}

flashBox($trans('Odświeżono wszystkie pliki.'));
redirect($breadcrumbs->getLast('uri'));
