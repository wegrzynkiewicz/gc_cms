<?php

Staff::createFromSession()->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['filePaths'] as $file) {
    GalleryImageModel::insertToGroupId($gallery_id, [
        'file' => uploadUrl($file),
    ]);
}
