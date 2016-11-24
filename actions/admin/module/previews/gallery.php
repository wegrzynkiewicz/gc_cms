<?php

$settings = json_decode($module['settings'], true);

if (isset($settings['gallery_id'])) {
    $images = GalleryImageModel::selectAllByGroupId($settings['gallery_id']);
}

?>
<?php if (isset($settings['gallery_id'])): ?>
    <div class="module-gallery-preview-row">
        <?php foreach ($images as $image): ?>
            <div class="module-gallery-preview-wrapper">
                <img src="<?=rootUrl(thumb($image['file'], 120, 70))?>"
                    class="module-gallery-preview-image"/>
            </div>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <div class="text-center">
        <?=trans(isset($settings['gallery_id']) ? 'Nie znaleziono zdjęć w galerii' : 'Nie wybrano galerii zdjęć dla tego modułu') ?>
    </div>
<?php endif ?>
