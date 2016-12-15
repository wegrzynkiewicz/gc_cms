<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));
$image_id = intval($_POST['image_id']);

if ($image_id) {
    GCC\Model\GalleryImage::deleteByPrimaryId($image_id);
}

redirect("/admin/gallery/images/list/$gallery_id");
