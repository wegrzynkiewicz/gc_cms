<?php

$staff->redirectIfUnauthorized();

if (isPost()) {
    $gallery_id = intval($_POST['gallery_id']);

    GC\Storage\Database::transaction(function() use ($gallery_id) {
        GC\Model\GalleryImage::deleteAllByGalleryId($gallery_id);
        GC\Model\Gallery::deleteByPrimaryId($gallery_id);
    });
}

redirect('/admin/gallery/list');
