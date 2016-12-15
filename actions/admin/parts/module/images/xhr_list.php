<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));
$files = GC\Model\ModuleFile::selectAllByModuleId($module_id);

?>
<?php if (empty($files)): ?>
    <div class="col-lg-12">
        <hr>
        <p>
            <?=trans('Nie znaleziono zdjęć')?>
        </p>
    </div>
<?php else: ?>
    <div id="sortable">
        <?php foreach ($files as $file_id => $image): ?>
            <?=view('/admin/parts/module/images/xhr_list-item.html.php', [
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
        $('#sortable').sortable();
    </script>
<?php endif ?>
