<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['filePaths'] as $file) {
    GCC\Model\GalleryImage::insert([
        'file' => uploadUrl($file),
    ], $gallery_id);
}
