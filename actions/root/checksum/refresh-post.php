<?php

$file = $_POST['file'];
$filepath = ROOT_PATH.$file;

$hash = sha1(file_get_contents($filepath));

GC\Model\Checksum::deleteByPrimaryId($file);
GC\Model\Checksum::insert([
    'file' => $file,
    'hash' => $hash,
]);

setNotice($trans('Plik "%s" został odświeżony.', [$file]));
GC\Response::redirect($breadcrumbs->getLastUrl());
