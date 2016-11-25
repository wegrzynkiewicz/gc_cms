<?php

Staff::createFromSession()->redirectIfUnauthorized();

$image_id = intval($_POST['image_id']);
$gallery_id = intval(array_shift($_SEGMENTS));

if ($image_id) {
    GalleryImageModel::deleteAndUpdatePositionByPrimaryId($image_id);
}

redirect("/admin/gallery-images/list/$gallery_id");
