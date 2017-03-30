<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button id="select_images" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj zdjęcia')?>
                </button>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm"
            method="post"
            action="<?=$request->uri?>"
            class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
                    'name' => 'theme',
                    'label' => trans('Szablon'),
                    'help' => trans('Wybierz jeden z dostępnych szablonów slajdera zdjęć'),
                    'options' => $config['moduleThemes']['image-slider'],
                ])?>
            </div>

            <div class="row">
                <div id="images">
                </div>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz'),
            ])?>

        </form>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="editModalForm" method="post" action="<?=$request->uri?>" class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Edytujesz zdjęcie ')?>
                    <span id="editModalName"></span>
                </h2>
            </div>
            <div id="editModalContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok">
                    <?=trans('Zapisz')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="deleteModalForm"
            method="post"
            action="<?=$uri->make("/admin/module/{$module_id}/image/delete.json")?>"
            class="modal-content">
            <input name="file_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć ten slajd?')?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/assets/_footer.html.php"; ?>

<script>
$(function() {

    function refreshImages() {
        var url = "<?=$uri->make("/admin/module/{$module_id}/image/list.json")?>";
        $.get(url, function(data) {
            $('#images')
                .html(data)
                .photoswipe({
                    loop: false,
                    closeOnScroll: false,
                });
        });
    }

    $('#images').nestedSortable({
        handle: 'div',
        listType: 'div',
        items: 'div.sortable-container',
        toleranceElement: '> div',
    });

    $('#editModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#editModal').modal('hide');
        });
    });

    $('#editModal').on('show.bs.modal', function (event) {
        var url = "<?=$uri->make("/admin/module/{$module_id}/type/image-slider/slide/edit.json")?>/"+$(event.relatedTarget).data('id');
        $.get(url, function(data) {
            $('#editModalContent').html(data);
            $('#editModalForm').attr('action', url);
        });
    });

    $('#deleteModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('[name="file_id"]').val($(event.relatedTarget).data('id'));
    });

    $("#sortableForm").on('submit', function(event) {
        var url = "<?=$uri->make("/admin/module/{$module_id}/image/sort.json")?>";
        $.post(url, {
            positions: $("#images").sortable("toArray")
        });
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=trans('Wybierz wiele zdjęć')?>',
    }, function(urls) {
        $.post("<?=$uri->make("/admin/module/{$module_id}/image/add.json")?>", {
            urls: urls
        }, function() {
            refreshImages();
        });
    });

    refreshImages();
});
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
