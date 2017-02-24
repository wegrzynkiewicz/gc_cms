<?php $images = GC\Model\Module\File::joinAllWithKeyByForeign($module_id) ?>

<?php if (empty($images)): ?>
    <div class="text-center">
        <?=trans('Nie znaleziono zdjęć slajdera') ?>
    </div>
<?php else: ?>
    <div class="module-gallery-preview-row" data-gallery="photoswipe">
        <?php foreach ($images as $image): $is = json_decode($image['settings'], true) ?>
            <div class="module-gallery-preview-wrapper">
                <a href="<?=e($image['uri'])?>"
                    target="_blank"
                    title="<?=e($image['name'])?>"
                    data-photoswipe-item=""
                    data-width="<?=e($is['width'])?>"
                    data-height="<?=e($is['height'])?>"
                    class="thumb-wrapper">
                    <img src="<?=$uri->root(thumbnail($image['uri'], 120, 70))?>"
                        width="120"
                        width="70"
                        alt="<?=e($image['name'])?>"
                        class="module-gallery-preview-image">
                </a>
            </div>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php endif ?>
