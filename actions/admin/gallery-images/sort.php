<?php

checkPermissions();

$positions = json_decode($_POST['ids'], true);
$gallery_id = intval(array_shift($_SEGMENTS));
GalleryImageModel::updatePositionsByGroupId($gallery_id, $positions);

redirect("/admin/gallery/list/$gallery_id");
