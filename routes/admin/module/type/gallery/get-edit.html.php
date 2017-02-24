<?php

require ROUTES_PATH."/admin/module/type/gallery/_import.php";

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>

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

<?php require ROUTES_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="saveForm"
            method="post"
            action=""
            class="form-horizontal">

            <input type="hidden" name="positions">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia galerii')?></legend>
                    <?=render(ROUTES_PATH.'/admin/parts/input/selectbox.html.php', [
                        'name' => 'theme',
                        'label' => trans('Szablon'),
                        'help' => trans('Szablon określa wygląd i zachowanie galerii'),
                        'options' => array_trans($config['modules']['gallery']['themes']),
                        'firstOption' => trans('Wybierz jeden z dostępnych szablonów galerii'),
                    ])?>
                </fieldset>
            </div>

            <div id="moduleTheme"></div>

            <div id="images" class="row"></div>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz'),
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
                    <?=trans('Edytujesz zdjęcie')?>
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
            action=""
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
                <?=trans('Czy jesteś pewien, że chcesz usunąć to zdjęcie?')?>
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

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script id="empty-template" type="text/html">
    <div class="col-md-12">
        <div class="simple-box">
            <?=trans('Nie znaleziono zdjęć w galerii.')?>
        </div>
    </div>
</script>

<script id="image-template" type="text/html">
    <div id="thumb_{{file_id}}"
        data-id="{{file_id}}"
        data-sortable-item=""
        class="col-lg-2 col-md-4 col-xs-6">

        <div class="thumbnail">

            <div class="thumb-wrapper">
                <a href="{{slug}}"
                    target="_blank"
                    title="{{name}}"
                    data-gallery-item=""
                    data-width="{{width}}"
                    data-height="{{height}}"
                    class="thumb-wrapper">
                    <img src="{{thumbnail}}"
                        alt="{{name}}"
                        class="img-responsive">
                </a>
            </div>

            <div class="pull-right">

                <a id="thumb_edit_{{file_id}}"
                    data-toggle="modal"
                    data-id="{{file_id}}"
                    data-name="{{name}}"
                    data-target="#editModal"
                    title="<?=trans('Edytuj zdjęcie')?>"
                    class="btn btn-primary btn-xs">
                    <i class="fa fa-cog fa-fw"></i>
                </a>

                <a id="thumb_delete_{{file_id}}"
                    data-toggle="modal"
                    data-id="{{file_id}}"
                    data-name="{{name}}"
                    data-target="#deleteModal"
                    title="<?=trans('Usuń zdjęcie')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                </a>
            </div>

            <div class="thumb-description" title="{{name}}">
                {{name}}
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</script>

<script>
$(function() {

    var imageTemplate       = $('#image-template').html();
    var emptyTemplate       = $('#empty-template').html();
    var editUri             = "<?=$uri->make("/admin/module/image/edit.json")?>/";
    var addUri              = "<?=$uri->make("/admin/module/{$module_id}/image/add.json")?>";
    var refreshImagesUri    = "<?=$uri->make("/admin/module/{$module_id}/image/list.json")?>";
    var deleteUri           = "<?=$uri->make("/admin/module/{$module_id}/image/delete.json")?>";
    var refreshThemeUri     = "<?=$uri->make("/admin/module/{$module_id}/type/gallery/theme")?>/";

    function refreshImages() {
        $.get(refreshImagesUri, function(data) {
            if (data.length) {
                var images = '';
                $(data).each(function(index, element) {
                    images += Mustache.render(imageTemplate, element)
                })
                $('#images').html(images);
            } else {
                $('#images').html(emptyTemplate);
            }
        });
    }

    function refreshTheme(theme) {
        $.get(refreshThemeUri+theme, function(data) {
            $('#moduleTheme').html(data);
        });
    }

    $('#images').nestedSortable({
       listType: 'div',
       excludeRoot: true,
       items: '[data-sortable-item]',
    });

    $('#images').magnificPopup({
        delegate: 'a[data-gallery-item]',
        type: 'image',
        gallery: {
            enabled: true,
        },
    });

    $('#theme').change(function() {
        refreshTheme($(this).val());
    });

    $('#editModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#editModal').modal('hide');
        });
    });

    $('#editModal').on('show.bs.modal', function (event) {
        var url = editUri + $(event.relatedTarget).data('id');
        $.get(url, function(data) {
            $('#editModalContent').html(data);
            $('#editModalForm').attr('action', url);
        });
    });

    $('#deleteModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post(deleteUri, $(this).serialize(), function() {
            refreshImages();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('[name="file_id"]').val($(event.relatedTarget).data('id'));
    });

    $("#saveForm").on('submit', function (event) {
        var sortabled = $('#images').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=trans('Wybierz wiele zdjęć')?>',
        url: '<?=$uri->make('/admin/elfinder/connector')?>',
        lang: '<?=getVisitorLang()?>',
    }, function(urls) {
        $.post(addUri, {
            urls: urls
        }, function() {
            refreshImages();
        });
    });

    refreshImages();
    refreshTheme("<?=$theme?>");
});
</script>

<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
