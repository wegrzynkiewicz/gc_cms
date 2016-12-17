<?php

$headTitle = trans("Zdjęcia w galerii");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));
$gallery = GC\Model\Gallery::selectByPrimaryId($gallery_id);

$headTitle .= makeLink("/admin/gallery/list", $gallery['name']);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=($headTitle)?>
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

<div id="images" class="row"></div>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm" action="<?=url("/admin/gallery/images/sort/$gallery_id")?>" method="post" class="form-horizontal">
            <input name="ids" type="hidden"/>
            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz położenie zdjęć',
            ])?>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/gallery/images/delete/$gallery_id")?>" class="modal-content">
            <input name="image_id" type="hidden" value="">
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

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script>
$(function() {

    function refreshImages() {
        $.get("<?=url("/admin/gallery/images/api/list/$gallery_id")?>", function(data) {
            $('#images').html(data);
        });
    }

    function updatePositions(callback) {
        var sortedIDs = $("#images").sortable("toArray", {
            attribute: "data-id"
        });
        $.post("<?=url("/admin/gallery/images/api/sort/$gallery_id")?>", {
            ids: sortedIDs
        }).done(function() {
            callback();
        });
    }

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="image_id"]').val($(e.relatedTarget).data('id'));
    });

    $("#sortableForm").submit(function(event) {
        var sortedIDs = $("#images").sortable("toArray", {
            attribute: "data-id"
        });
        $('[name=ids]').val(JSON.stringify(sortedIDs));
    });

    $('#select_images').elfinderInputMultiple({
        title: '<?=trans('Wybierz wiele zdjęć')?>'
    }, function(filePaths) {
        $.post("<?=url("/admin/gallery/images/api/new/$gallery_id")?>", {
            filePaths: filePaths
        }, function(data) {
            refreshImages();
        });
    });

    $('#images').sortable();

    refreshImages();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
