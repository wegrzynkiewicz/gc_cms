<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['filePaths'] as $file) {
    GC\Model\GalleryImage::insertWithGalleryId([
        'file' => uploadUrl($file),
    ], $gallery_id);
}
