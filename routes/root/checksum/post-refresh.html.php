<?php

require ROUTES_PATH.'/root/_only-debug.php';
require ROUTES_PATH.'/root/_only-root.php';
require ROUTES_PATH.'/root/_import.php';
require ROUTES_PATH.'/root/checksum/_import.php';

$file = $_POST['file'];
$filepath = ROOT_PATH.$file;

$hash = sha1(file_get_contents($filepath));

GC\Model\Checksum::deleteByPrimaryId($file);
GC\Model\Checksum::insert([
    'file' => $file,
    'hash' => $hash,
]);

flashBox(trans('Plik "%s" został odświeżony.', [$file]));
redirect($breadcrumbs->getLast('uri'));
