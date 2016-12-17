<?php

$headTitle = trans("Edycja modułu galerii zdjęć");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    GC\Model\FrameModule::updateByPrimaryId($module_id, [
        'theme' => $_POST['theme'],
    ]);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $module;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button id="select_images" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj zdjęcia')?>
                </button>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm" action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => 'Szablon',
                    'help' => 'Wybierz jeden z dostępnych szablonów galerii',
                    'options' => $config['moduleThemes']['gallery'],
                ])?>
            </div>
            
            <div id="images" class="row"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="editModalForm" method="post" action="" class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Edytujesz zdjęcie ")?>
                    <span id="editModalName"></span>
                </h2>
            </div>
            <div id="editModalContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok" href="">
                    <?=trans('Zapisz')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="deleteModalForm" method="post" action="" class="modal-content">
            <input name="file_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć to zdjęcie?")?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-danger btn-ok" href="">
                    <?=trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(function() {

    function refreshImages() {
        $.get("<?=url("/admin/parts/module/images/xhr_list/$module_id")?>", function(data) {
            $('#images').html(data);
        });
    }

    $('#editModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshImages();
            $('#editModal').modal('hide');
        });
    });

    $('#editModal').on('show.bs.modal', function(e) {
        var url = "<?=url("/admin/parts/module/types/gallery/xhr_image-edit")?>/"+$(e.relatedTarget).data('id');
        $.get(url, function(data) {
            $('#editModalContent').html(data);
            $('#editModalForm').attr('action', url);
        });
    });

    $('#deleteModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post("<?=url("/admin/parts/module/images/xhr_delete")?>", $(this).serialize(), function() {
            refreshImages();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="file_id"]').val($(e.relatedTarget).data('id'));
    });

    $("#sortableForm").submit(function(event) {
        $.post("<?=url("/admin/parts/module/images/xhr_sort/$module_id")?>", {
            ids: $("#sortable").sortable("toArray", {
                attribute: "data-id"
            })
        });
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=trans('Wybierz wiele zdjęć')?>'
    }, function(urls) {
        $.post("<?=url("/admin/parts/module/images/xhr_new/$module_id")?>", {
            urls: urls
        }, function() {
            refreshImages();
        });
    });

    refreshImages();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
