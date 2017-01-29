<?php

$staff_id = intval(array_shift($_PARAMETERS));
$user = GC\Model\Staff\Staff::fetchByPrimaryId($staff_id);
$headTitle = $trans('Edytowanie pracownika "%s"', [$user['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$groups = array_keys(GC\Model\Staff\Group::select()
    ->fields(['group_id', 'name'])
    ->source('::staff_membership LEFT JOIN ::staff_groups USING(group_id)')
    ->order('name', 'ASC')
    ->fetchByMap('group_id', 'name'));

$_POST = $user;

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask("/{$staff_id}/force-change-password")?>" type="button" class="btn btn-success">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=$trans('Wymuś zmianę hasła')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
