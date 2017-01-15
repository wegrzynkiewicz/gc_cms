<?php

$staffList = GC\Model\Staff\Staff::select()
    ->fields(['staff_id', 'name'])
    ->equals('root', 0)
    ->fetchByPrimaryKey();

$groups = GC\Model\Staff\Group::select()
    ->fields(['staff_id', 'name', 'group_id'])
    ->source('::staff_membership LEFT JOIN ::staff_groups USING(group_id)')
    ->sort('name', 'ASC')
    ->fetchAll();

$staffGroups = [];
foreach ($groups as $group) {
    $staffGroups[$group['staff_id']][$group['group_id']] = $group['name'];
}

$permissions = GC\Model\Staff\Permission::select()
    ->fields('DISTINCT name, staff_id')
    ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
    ->fetchAll();

$staffPermissions = [];
foreach ($permissions as $permission) {
    $staffPermissions[$permission['staff_id']][] = $permission['name'];
}

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=GC\Url::mask("/new")?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$trans('Dodaj nowego pracownika')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($staffList)): ?>
                <?=$trans('Nie znaleziono żadnych pracowników.')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th class="col-md-3 col-lg-3">
                                <?=$trans('Pracownik')?>
                            </th>
                            <th class="col-md-4 col-lg-4">
                                <?=$trans('Grupy')?>
                            </th>
                            <th class="col-md-4 col-lg-4">
                                <?=$trans('Uprawnienia')?>
                            </th>
                            <th class="col-md-1 col-lg-1 text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staffList as $staff_id => $row): ?>
                            <?=GC\Render::file(ACTIONS_PATH.'/admin/staff/list-item.html.php', [
                                'staff_id' => $staff_id,
                                'staff' => $row,
                                'groups' => def($staffGroups, $staff_id, []),
                                'permissions' => def($staffPermissions, $staff_id, []),
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=GC\Url::mask("/delete")?>" class="modal-content">
            <input name="staff_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć pracownika')?>
                <span id="name" style="font-weight:bold; color:red;"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=$trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=$trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function(){
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="staff_id"]').val($(e.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable({
        iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
