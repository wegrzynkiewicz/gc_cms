<?php

require ROUTES_PATH."/admin/module/type/tabs/_import.php";

$tabs = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>

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
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="sortableForm" action="" method="post">
            <input type="hidden" name="positions">

            <h3><?=trans('Zakładki')?></h3>

            <?php if (empty($tabs)): ?>
                <div class="simple-box">
                    <?=trans('Nie znaleziono zakładek')?>
                </div>
            <?php else: ?>
                <ol id="sortable" class="sortable">
                    <?php foreach ($tabs as $tab): ?>
                        <?=render(ROUTES_PATH.'/admin/module/type/tabs/tab.html.php', $tab)?>
                    <?php endforeach?>
                </ol>
                <script>
                    $('#sortable').nestedSortable({
                        handle: 'div',
                        items: 'li',
                        toleranceElement: '> div',
                        maxLevels: 1
                    });
                </script>
            <?php endif ?>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz położenie zakładek'),
            ])?>
        </form>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="addModalForm"
            method="post"
            action=""
            class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Dodaj nową zakładkę')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa pojedyńczej zakładki'),
                ])?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok">
                    <?=trans('Dodaj')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="editModalForm"
            method="post"
            action=""
            class="modal-content form-horizontal">
            <input name="frame_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Edytujesz zakładkę')?>
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
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm"
            method="post"
            action=""
            class="modal-content">
            <input name="frame_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć zakładkę')?>
                <span id="deleteName" style="font-weight:bold; color:red;"></span>?
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

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
$(function(){

    var addUri    = '<?=$uri->make("/admin/module/{$module_id}/type/tabs/item/add.json")?>';
    var sortUri   = '<?=$uri->make("/admin/module/{$module_id}/type/tabs/item/sort.json")?>';
    var editUri   = '<?=$uri->make("/admin/module/type/tabs/item/edit.json")?>';
    var deleteUri = '<?=$uri->make("/admin/module/type/tabs/item/delete.json")?>';

    $('#addModalForm').on('submit', function (event) {
        $.post(addUri, $(this).serialize());
    });

    $('#editModalForm').on('submit', function (event) {
        $.post(editUri, $(this).serialize());
    });

    $('#editModal').on('show.bs.modal', function (event) {
        $.get(editUri, {
            frame_id: $(event.relatedTarget).data('id'),
        }, function(data) {
            $('#editModalContent').html(data);
            $('[name="frame_id"]').val($(event.relatedTarget).data('id'));
        });
    });

    $('#deleteModalForm').on('submit', function (event) {
        $.post(deleteUri, $(this).serialize());
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('[name="frame_id"]').val($(event.relatedTarget).data('id'));
        $(this).find('#deleteName').html($(event.relatedTarget).data('name'));
    });

    $("#sortableForm").submit(function (event) {
        $.post(sortUri, {
            positions: JSON.stringify($('#sortable').sortable('toArray')),
        });
    });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
