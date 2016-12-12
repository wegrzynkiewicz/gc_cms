<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['filePaths'] as $file) {
    GalleryImage::insert([
        'file' => uploadUrl($file),
    ], $gallery_id);
}
