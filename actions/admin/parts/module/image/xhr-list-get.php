<?php $files = GC\Model\Module\File::joinAllWithKeyByForeign($module_id); ?>

<?php if (empty($files)): ?>
    <div class="col-md-12">    
        <div class="simple-box">
            <?=$trans('Nie znaleziono zdjęć')?>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($files as $file_id => $image): ?>
        <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/module/image/xhr-list-item.html.php', [
            'file_id' => $file_id,
            'image' => $image,
        ])?>
    <?php endforeach ?>
<?php endif ?>
