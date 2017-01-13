<?php

GC\Model\Checksum::deleteAll();

foreach($getFiles() as $file) {
    GC\Model\Checksum::insert([
        'file' => trim($file, '.'),
        'hash' => sha1(file_get_contents($file)),
    ]);
}

setNotice($trans('Odświeżono wszystkie pliki.'));
GC\Response::redirect($breadcrumbs->getLastUrl());
