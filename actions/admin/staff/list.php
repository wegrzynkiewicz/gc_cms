<?php

$headTitle = trans("Pracownicy");

Staff::createFromSession()->redirectIfUnauthorized();

$staffList = StaffModel::selectAll();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/staff/new")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nowego pracownika')?>
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($staffList)): ?>
            <p>
                <?=trans('Nie znaleziono żadnych pracowników.')?>
            </p>
        <?php else: ?>
            <table class="table table-striped table-bordered table-hover" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-5 col-lg-4">
                            <?=trans('Pracownik')?>
                        </th>
                        <th class="col-md-7 col-lg-8 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staffList as $staff_id => $staff): ?>
                        <tr>
                            <td>
                                <img src="<?=Staff::getAvatarUrl($staff, 30)?>"
                                    height="30" style="margin-right:5px"/>

                                <a href="<?=url("/admin/staff/edit/$staff_id")?>"
                                    title="<?=trans('Edytuj pracownika')?>">
                                    <?=$staff['name']?>
                                </a>
                            </td>
                            <td class="text-right">
                                <a data-toggle="modal"
                                    data-id="<?=$staff_id?>"
                                    data-name="<?=$staff['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń pracownika')?>"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-times fa-fw"></i>
                                    <?=trans("Usuń")?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/staff/delete")?>" class="modal-content">
            <input name="id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć??")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć pracownika")?>
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

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function(){
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="id"]').val($(e.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
