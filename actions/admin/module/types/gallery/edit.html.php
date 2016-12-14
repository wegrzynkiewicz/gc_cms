<?php

$headTitle = trans("Edytujesz moduł galerii");

if (wasSentPost()) {
    FrameModule::updateByPrimaryId($module_id, [
        'theme' => $_POST['theme'],
    ]);
    redirect("/admin/$parentSegment/module/list/$parent_id");
}

$_SESSION['preview_url'] = $request;
$_POST = $module;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <button id="select_images" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj zdjęcia')?>
            </button>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm" action="" method="post" class="form-horizontal">

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'theme',
                'label' => 'Szablon',
                'help' => 'Wybierz jeden z dostępnych szablonów galerii',
                'options' => $config['moduleThemes']['gallery'],
            ])?>

            <div id="images" class="row"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/gallery/list",
                'saveLabel' => 'Zapisz',
            ])?>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
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

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function() {

    function refreshImages() {
        $.get("<?=url("/admin/module/types/gallery/images/list/$module_id/$parentSegment")?>", function(data) {
            $('#images').html(data);
        });
    }

    $('#deleteModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post("<?=url("/admin/module/types/gallery/images/delete")?>", {
            file_id: $(this).find('[name="file_id"]').val()
        }, function() {
            refreshImages();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="file_id"]').val($(e.relatedTarget).data('id'));
    });

    $("#sortableForm").submit(function(event) {
        $.post("<?=url("/admin/module/types/gallery/images/sort/$module_id")?>", {
            ids: $("#images").sortable("toArray", {
                attribute: "data-id"
            })
        });
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=trans('Wybierz wiele zdjęć')?>'
    }, function(urls) {
        $.post("<?=url("/admin/module/types/gallery/images/new/$module_id")?>", {
            urls: urls
        }, function() {
            refreshImages();
        });
    });

    $('#images').sortable();

    refreshImages();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
