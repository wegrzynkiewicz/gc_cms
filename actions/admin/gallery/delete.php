<?php

checkPermissions();

if (wasSentPost()) {
    $gallery_id = intval($_POST['id']);
    GalleryModel::deleteByPrimaryId($gallery_id);
}

redirect('/admin/gallery/list');
