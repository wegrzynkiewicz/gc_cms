<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$positions = json_decode($_POST['ids'], true);
$gallery_id = intval(array_shift($_SEGMENTS));
GalleryPosition::updatePositionsByGalleryId($gallery_id, $positions);

redirect("/admin/gallery/list/$gallery_id");
