<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/form/_import.php";
require ROUTES_PATH."/admin/form/field/_import.php";

# pobierz posortowane pola formularzy
$fields = GC\Model\Form\Field::select()
    ->source('::fields')
    ->equals('form_id', $form_id)
    ->order('position', 'ASC')
    ->fetchByPrimaryKey();

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make("/admin/form/{$form_id}/field/new")?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowe pole')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <form id="savePosition" action="<?=$request->uri?>" method="post">
            <?php if (empty($fields)):?>
                <div class="simple-box">
                    <?=trans('Brak pól w formularzu: %s', [$form['name']])?>
                </div>
            <?php else:?>
                <input name="positions" type="hidden"/>
                <ol id="sortable" class="sortable">
                    <?php foreach ($fields as $field_id => $field): ?>
                        <?=render(ROUTES_PATH."/admin/form/field/_list-item.html.php", $field)?>
                    <?php endforeach?>
                </ol>
            <?php endif?>
            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz pozycję'),
            ])?>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make("/admin/form/delete")?>" class="modal-content">
            <input name="field_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć pole')?>
                <span id="name" style="font-weight:bold; color:red;"></span>?
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
    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('#name').html($(event.relatedTarget).data('name'));
        $(this).find('[name="field_id"]').val($(event.relatedTarget).data('id'));
    });
</script>

<script>
$(function(){
    $('#sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        maxLevels: 1
    });

    $("#savePosition").submit(function(event) {
        var sortabled = $('#sortable').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
    });
});
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
