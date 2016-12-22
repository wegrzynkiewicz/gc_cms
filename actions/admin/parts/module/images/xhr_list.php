<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));
$files = GC\Model\ModuleFile::joinAllWithKeyByForeign($module_id);

?>
<?php if (empty($files)): ?>
    <div class="col-lg-12">
        <div class="simple-box">
            <?=trans('Nie znaleziono zdjęć')?>
        </div>
    </div>
<?php else: ?>
    <div id="sortable">
        <?php foreach ($files as $file_id => $image): ?>
            <?=GC\Render::action('/admin/parts/module/images/xhr_list-item.html.php', [
                'file_id' => $file_id,
                'image' => $image,
            ])?>
        <?php endforeach ?>
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
