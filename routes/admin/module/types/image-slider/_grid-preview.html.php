<?php

$images = GC\Model\Module\FileRelation::select()
    ->source('::files')
    ->equals('module_id', $module_id)
    ->order('position', 'asc')
    ->fetchByKey('file_id');

?>
<?php if (empty($images)): ?>
    <div class="text-center">
        <?=trans('Nie znaleziono zdjęć w sliderze') ?>
    </div>
<?php else: ?>
    <div id="image-slider_<?=$module_id?>" class="module-gallery-preview-row">
        <?php foreach ($images as $file_id => $image): ?>
            <?=render(ROUTES_PATH."/admin/module/types/image-slider/_grid-item.html.php", $image)?>
        <?php endforeach ?>
        <div class="clearfix"></div>
        <script type="text/javascript">
            $(function() {
                $('#image-slider_<?=$module_id?>').magnificPopup({
                    delegate: 'a[data-gallery-item]',
                    type: 'image',
                    gallery: {
                        enabled: true,
                    },
                });
            });
        </script>
    </div>
<?php endif ?>
