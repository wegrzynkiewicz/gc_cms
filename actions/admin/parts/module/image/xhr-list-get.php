<?php $files = GC\Model\ModuleFile::joinAllWithKeyByForeign($module_id); ?>

<?php if (empty($files)): ?>
    <div class="simple-box">
        <?=trans('Nie znaleziono zdjęć')?>
    </div>
<?php else: ?>
    <div class="row">
        <div id="sortable">
            <?php foreach ($files as $file_id => $image): ?>
                <?=GC\Render::action('/admin/parts/module/image/xhr-list-item.html.php', [
                    'file_id' => $file_id,
                    'image' => $image,
                ])?>
            <?php endforeach ?>
        </div>
    </div>
    <script>
        $('#sortable').photoswipe({
            loop: false,
            closeOnScroll: false,
        });
        $('#sortable').nestedSortable({
            handle: 'div',
            listType: 'div',
            items: 'div.sortable-container',
            toleranceElement: '> div',
        });
    </script>
<?php endif ?>
