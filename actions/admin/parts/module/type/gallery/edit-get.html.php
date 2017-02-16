<?php

require ACTIONS_PATH."/admin/parts/module/type/gallery/_import.php";

$_POST = array_merge($module, $settings);

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button id="select_images" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$trans('Dodaj zdjęcia')?>
                </button>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm"
            method="post"
            action=""
            class="form-horizontal">

            <div class="simple-box">
                <fieldset>
                    <legend><?=$trans('Ustawienia galerii zdjęć')?></legend>
                    <?=render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
                        'name' => 'theme',
                        'label' => $trans('Szablon'),
                        'help' => $trans('Wybierz jeden z dostępnych szablonów galerii'),
                        'options' => $config['moduleThemes']['gallery'],
                    ])?>
                </fieldset>
            </div>


            <div class="simple-box">
                <fieldset>
                    <legend><?=$trans('Ustawienia szablonu')?></legend>
                    <div id="moduleTheme">
                        <?=$trans('Wybierz szablon galerii')?>
                    </div>
                </fieldset>
            </div>

            <div class="row">
                <div id="images">
                </div>
            </div>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => $trans('Zapisz'),
            ])?>

        </form>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="editModalForm" method="post" action="" class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Edytujesz zdjęcie ')?>
                    <span id="editModalName"></span>
                </h2>
            </div>
            <div id="editModalContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=$trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok">
                    <?=$trans('Zapisz')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="deleteModalForm"
            method="post"
            action="<?=$uri->make("/admin/parts/module/{$module_id}/image/xhr-delete")?>"
            class="modal-content">
            <input name="file_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć to zdjęcie?')?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=$trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=$trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function() {

    function refreshImages() {
        var url = "<?=$uri->make("/admin/parts/module/{$module_id}/image/xhr-list")?>";
        $.get(url, function(data) {
            $('#images')
                .html(data)
                .photoswipe({
                    loop: false,
                    closeOnScroll: false,
                });
        });
    }

    function refreshTheme(theme) {
        var url = "<?=$uri->make("/admin/parts/module/{$module_id}/type/gallery/theme")?>/";
        $.get(url+theme, function(data) {
            $('#moduleTheme').html(data);
        });
    }

    $('#theme').change(function() {
        refreshTheme($(this).val());
    });

    <?php if (isset($_POST['theme'])): ?>
        refreshTheme("<?=e($_POST['theme'])?>");
    <?php endif ?>

    $('#images').nestedSortable({
        handle: 'div',
        listType: 'div',
        items: 'div.sortable-container',
        toleranceElement: '> div',
    });

    $('#editModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#editModal').modal('hide');
        });
    });

    $('#editModal').on('show.bs.modal', function(e) {
        var url = "<?=$uri->make("/admin/parts/module/{$module_id}/type/gallery/image/xhr-edit")?>/"+$(e.relatedTarget).data('id');
        $.get(url, function(data) {
            $('#editModalContent').html(data);
            $('#editModalForm').attr('action', url);
        });
    });

    $('#deleteModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="file_id"]').val($(e.relatedTarget).data('id'));
    });

    $("#sortableForm").on('submit', function(event) {
        var url = "<?=$uri->make("/admin/parts/module/{$module_id}/image/xhr-sort")?>";
        $.post(url, {
            positions: $("#images").sortable("toArray")
        });
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=$trans('Wybierz wiele zdjęć')?>',
        url: '<?=$uri->make('/admin/elfinder/connector')?>',
        lang: '<?=GC\Auth\Visitor::getLang()?>',
    }, function(urls) {
        $.post("<?=$uri->make("/admin/parts/module/{$module_id}/image/xhr-add")?>", {
            urls: urls
        }, function() {
            refreshImages();
        });
    });

    refreshImages();
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
