<?php

$groups = GC\Model\StaffGroup::selectAllWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=url("/admin/staff/group/new")?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nową grupę pracowników')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($groups)): ?>
                <?=trans('Nie znaleziono żadnych grup pracowników.')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th class="col-md-4 col-lg-4">
                                <?=trans('Grupa pracowników')?>
                            </th>
                            <th class="col-md-7 col-lg-7">
                                <?=trans('Posiadane uprawnienia')?>
                            </th>
                            <th class="col-md-1 col-lg-1 text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group_id => $group): ?>
                            <tr>
                                <td>
                                    <a href="<?=url("/admin/staff/group/edit/$group_id")?>"
                                        title="<?=trans('Edytuj grupę')?>">
                                        <?=e($group['name'])?>
                                    </a>
                                </td>
                                <td>
                                    <?php $permissions = GC\Model\StaffPermission::selectPermissionsAsOptionsByGroupId($group_id) ?>
                                    <?php foreach ($permissions as $permission): ?>
                                        <?=trans($config['permissions'][$permission])?> <br>
                                    <?php endforeach ?>
                                </td>
                                <td class="text-right">
                                    <a data-toggle="modal"
                                        data-id="<?=e($group_id)?>"
                                        data-name="<?=e($group['name'])?>"
                                        data-target="#deleteModal"
                                        title="<?=trans('Usuń grupę')?>"
                                        class="btn btn-danger btn-md">
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
        <?=view('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/staff/group/delete")?>" class="modal-content">
            <input name="group_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć grupę pracowników")?>
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
$(function(){
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="group_id"]').val($(e.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
