<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/staff/_import.php";

// pobierz pracowników, którzy nie są kontem roota
$users = GC\Model\Staff\Staff::select()
    ->fields(['staff_id', 'name'])
    ->equals('root', 0)
    ->fetchByPrimaryKey();

// pobierz wszystkie grupy pracowników
$groups = GC\Model\Staff\Group::select()
    ->fields(['staff_id', 'name', 'group_id'])
    ->source('::groups')
    ->order('name', 'ASC')
    ->fetchAll();

// przypisz każdemu pracownikowi jego grupy
foreach ($groups as $group) {
    $users[$group['staff_id']]['groups'][$group['group_id']] = $group['name'];
}

// pobierz wszystkie uprawnienia dla pracownika
$permissions = GC\Model\Staff\Permission::select()
    ->fields('DISTINCT name, staff_id')
    ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
    ->fetchAll();

// przypisz każdemu pracownikowi jego uprawnienia
foreach ($permissions as $permission) {
    $users[$permission['staff_id']]['permissions'][] = $permission['name'];
}

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make("/admin/staff/new")?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowego pracownika')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($users)): ?>
                <?=trans('Nie znaleziono żadnych pracowników.')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th>
                                <?=trans('Pracownik')?>
                            </th>
                            <th>
                                <?=trans('Grupy')?>
                            </th>
                            <th>
                                <?=trans('Uprawnienia')?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <?=render(ROUTES_PATH."/admin/staff/_list-item.html.php", $user)?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make("/admin/staff/delete")?>" class="modal-content">
            <input name="staff_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć pracownika')?>
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

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

<script>
$(function(){
    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('#name').html($(event.relatedTarget).data('name'));
        $(this).find('[name="staff_id"]').val($(event.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable({
        iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
    });
});
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
