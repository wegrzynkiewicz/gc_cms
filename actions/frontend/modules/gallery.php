<?php

$content = json_decode($module['settings'], true);
$module['images'] = GalleryImageModel::selectAllByGroupId($content['gallery_id']);
