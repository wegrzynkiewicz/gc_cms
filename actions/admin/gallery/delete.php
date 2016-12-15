<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $gallery_id = intval($_POST['gallery_id']);

    GCC\Storage\Database::transaction(function() use ($gallery_id) {
        GCC\Model\GalleryImage::deleteAllByGalleryId($gallery_id);
        GCC\Model\Gallery::deleteByPrimaryId($gallery_id);
    });
}

redirect('/admin/gallery/list');
