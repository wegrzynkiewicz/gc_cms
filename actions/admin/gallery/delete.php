<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $gallery_id = intval($_POST['gallery_id']);

    GrafCenter\CMS\Storage\Database::transaction(function() use ($gallery_id) {
        GrafCenter\CMS\Model\GalleryImage::deleteAllByGalleryId($gallery_id);
        GrafCenter\CMS\Model\Gallery::deleteByPrimaryId($gallery_id);
    });
}

redirect('/admin/gallery/list');
