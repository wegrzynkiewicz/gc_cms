<?php foreach ($module['images'] as $image_id => $image): ?>
    <img src="<?=thumb($image['file'], 200, 200)?>" alt="">
<?php endforeach ?>
