<?php

$module['images'] = [];
$settings = json_decode($module['settings'], true);

if (isset($settings['gallery_id'])) {
    $images = GalleryImageModel::selectAllByGroupId($settings['gallery_id']);
}

?>

<?php if (isset($settings['gallery_id'])): ?>
    <?php foreach ($images as $image): ?>
        <div class="col-md-2">
            <img src="<?=rootUrl($image['file'])?>" style="width:100%; height:auto" />
        </div>
    <?php endforeach ?>
<?php else: ?>
    <div class="text-center">
        <?=trans(isset($settings['gallery_id']) ? 'Nie znaleziono zdjęć w galerii' : 'Nie wybrano galerii zdjęć dla tego modułu') ?>
    </div>
<?php endif ?>
