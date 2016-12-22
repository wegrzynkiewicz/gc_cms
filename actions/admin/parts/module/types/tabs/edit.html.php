<?php

require ACTIONS_PATH."/admin/parts/module/types/$moduleType/_import.php";

if (isPost()) {
    GC\Model\Module::updateByPrimaryId($module_id, [
        'content' => $_POST['content'],
        'theme' => 'default',
    ]);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST['content'] = $content;

require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button
                    data-toggle="modal"
                    data-target="#addModal"
                    class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj zakładkę')?>
                </button>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm" action="" method="post">
            <h3><?=trans('Zakładki')?></h3>

            <div id="items"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz położenie zakładek',
            ])?>
        </form>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="addModalForm" method="post" action="" class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Dodaj nową zakładkę")?>
                </h2>
            </div>
            <div id="addModalContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok" href="">
                    <?=trans('Dodaj')?>
                </button>
            </div>
        </form>
    </div>
</div>

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
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm"
            method="post"
            action="<?=$surl("/delete")?>"
            class="modal-content">
            <input name="item_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć zakładkę")?>
                <span id="deleteName" style="font-weight:bold; color:red;"></span>?
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

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>

<script>
$(function(){

    function refreshItems() {
        $.post("<?=url("/admin/parts/module/{$module_id}/types/tabs/xhr_item-list")?>", {
            moduleUrl: "<?=$surl("/$module_id/item/%s/module/list")?>"
        }, function(data) {
            $('#items').html(data);
        });
    }

    $('#addModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshItems();
            $('#addModal').modal('hide');
        });
    });

    $('#addModal').on('show.bs.modal', function(e) {
        var url = "<?=url("/admin/parts/module/types/tabs/xhr_item-add/$module_id")?>";
        $.get(url, function(data) {
            $('#addModalContent').html(data);
            $('#addModalForm').attr('action', url);
        });
    });

    $('#editModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            refreshItems();
            $('#editModal').modal('hide');
        });
    });

    $('#editModal').on('show.bs.modal', function(e) {
        var url = "<?=url("/admin/parts/module/types/tabs/xhr_item-edit")?>/"+$(e.relatedTarget).data('id');
        $.get(url, function(data) {
            $('#editModalContent').html(data);
            $('#editModalForm').attr('action', url);
        });
    });

    $('#deleteModalForm').on('submit', function(e) {
        e.preventDefault();
        $.post("<?=url("/admin/parts/module/items/xhr_delete")?>", $(this).serialize(), function() {
            refreshItems();
            $('#deleteModal').modal('hide');
        });
    });

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="item_id"]').val($(e.relatedTarget).data('id'));
        $(this).find('#deleteName').html($(e.relatedTarget).data('name'));
    });

    $("#sortableForm").submit(function(e) {
        $.post("<?=url("/admin/parts/module/items/xhr_sort/$module_id")?>", {
            positions: $("#sortable").sortable("toArray")
        });
    });

    refreshItems();
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
