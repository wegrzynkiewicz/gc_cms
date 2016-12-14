<?php $images = ModuleFile::selectAllByModuleId($module_id) ?>

<?php if (empty($images)): ?>
    <div class="text-center">
        <?=trans('Nie znaleziono zdjęć w galerii') ?>
    </div>
<?php else: ?>
    <div class="module-gallery-preview-row">
        <?php foreach ($images as $image): ?>
            <div class="module-gallery-preview-wrapper">
                <img src="<?=Thumb::make($image['url'], 120, 70)?>"
                    width="120"
                    width="70"
                    class="module-gallery-preview-image"/>
            </div>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php endif ?>
