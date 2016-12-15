<?php

$positions = json_decode($_POST['ids'], true);
$gallery_id = intval(array_shift($_SEGMENTS));
GC\Model\GalleryPosition::updatePositionsByGalleryId($gallery_id, $positions);

redirect("/admin/gallery/list/$gallery_id");
