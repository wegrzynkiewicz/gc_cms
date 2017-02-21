<?php

$images = GC\Model\Module\File::select()
    ->source('::moduleFiles')
    ->equals('module_id', $module_id)
    ->order('position', 'asc')
    ->fetchByPrimaryKey();

?>
<?php if (empty($images)): ?>
    <div class="text-center">
        <?=trans('Nie znaleziono zdjęć w galerii') ?>
    </div>
<?php else: ?>
    <div class="module-gallery-preview-row" data-gallery="photoswipe">
        <?php foreach ($images as $file_id => $image): ?>
            <?=render(ROUTES_PATH.'/admin/parts/module/type/gallery/grid-item.html.php', $image)?>
        <?php endforeach ?>
        <div class="clearfix"></div>
    </div>
<?php endif ?>
