<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/staff/_import.php";
require ROUTES_PATH."/admin/staff/group/_import.php";

// pobierz wszystkie grupy
$groups = GC\Model\Staff\Group::select()
    ->fields(['group_id', 'name'])
    ->fetchByPrimaryKey();

// pobierz wszystkie uprawnienia
$groupPermissions = GC\Model\Staff\Permission::select()
    ->fields(['group_id', 'name'])
    ->fetchAll();

// przyporządkuj każdej grupie własne uprawnienia
foreach ($groupPermissions as $permission) {
    $groups[$permission['group_id']]['permissions'][] = $permission['name'];
}

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make('/admin/staff/group/new')?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nową grupę pracowników')?>
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
                        <?php foreach ($groups as $group): ?>
                            <?=render(ROUTES_PATH."/admin/staff/group/_list-item.html.php", $group)?>
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
        <form id="deleteModalForm" method="post" action="<?=$uri->make('/admin/staff/group/delete')?>" class="modal-content">
            <input name="group_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć grupę pracowników')?>
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
        $(this).find('[name="group_id"]').val($(event.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable({
        iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
    });
});
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
