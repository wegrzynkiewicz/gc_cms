<?php $images = GalleryImage::selectAllByGalleryId($module['content']) ?>
<?php foreach ($images as $image_id => $image): ?>
    <img src="<?=thumb($image['file'], 200, 200)?>" alt="">
<?php endforeach ?>
