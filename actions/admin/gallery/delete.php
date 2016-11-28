<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $gallery_id = intval($_POST['gallery_id']);

    Database::transaction(function() use ($gallery_id) {
        GalleryImage::deleteAllByGalleryId($gallery_id);
        Gallery::deleteByPrimaryId($gallery_id);
    });
}

redirect('/admin/gallery/list');
