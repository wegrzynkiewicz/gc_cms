<?php $images = GalleryImage::selectAllByGalleryId($module['content']) ?>
<?php if ($module['content']): ?>
    <div class="module-gallery-preview-row">
        <?php foreach ($images as $image): ?>
            <div class="module-gallery-preview-wrapper">
                <img src="<?=thumb($image['file'], 120, 70)?>"
                    width="120"
                    width="70"
                    class="module-gallery-preview-image"/>
            </div>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <div class="text-center">
        <?=trans($module['content'] ? 'Nie znaleziono zdjęć w galerii' : 'Nie wybrano galerii zdjęć dla tego modułu') ?>
    </div>
<?php endif ?>
