<?php $images = GCC\Model\ModuleFile::selectAllByModuleId($module_id) ?>

<?php if (empty($images)): ?>
    <div class="text-center">
        <?=trans('Nie znaleziono zdjęć w galerii') ?>
    </div>
<?php else: ?>
    <div class="module-gallery-preview-row" data-gallery="photoswipe">
        <?php foreach ($images as $image): $is = json_decode($image['settings'], true) ?>
            <div class="module-gallery-preview-wrapper">
                <a href="<?=$image['url']?>"
                    target="_blank"
                    title="<?=escape($image['name'])?>"
                    data-photoswipe-item=""
                    data-width="<?=$is['width']?>"
                    data-height="<?=$is['height']?>"
                    class="thumb-wrapper">
                    <img src="<?=GCC\Thumb::make($image['url'], 120, 70)?>"
                        width="120"
                        width="70"
                        alt="<?=escape($image['name'])?>"
                        class="module-gallery-preview-image">
                </a>
            </div>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php endif ?>
