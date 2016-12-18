<?php

if (isPost()) {
    $positions = json_decode($_POST['positions'], true);
    $positions = array_filter($positions, function ($node) {
        return isset($node['id']);
    });
    GC\Model\FormPosition::updatePositionByFormId($form_id, $positions);
    redirect($breadcrumbs->getBeforeLastUrl());
}

$fields = GC\Model\FormField::selectAllByFormId($form_id);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=url("/admin/form/field/new/$form_id")?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowe pole')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($fields)):?>
            <div class="simple-box">
                <?=trans('Brak pól w formularzu "%s"', [$form['name']])?>
            </div>
        <?php else:?>
            <ol id="sortable" class="sortable">
                <?=view('/admin/form/field/list-items.html.php', [
                    'fields' => $fields,
                    'form_id' => $form_id,
                ])?>
            </ol>
        <?php endif?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form id="savePosition" action="" method="post">

            <input name="positions" type="hidden"/>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz pozycję',
            ])?>

        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/form/field/delete/$form_id")?>" class="modal-content">
            <input name="field_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć pole")?>
                <span id="name" style="font-weight:bold; color:red;"></span>?
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
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="field_id"]').val($(e.relatedTarget).data('id'));
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

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
