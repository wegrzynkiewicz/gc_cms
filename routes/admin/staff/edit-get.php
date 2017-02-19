<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/staff/_import.php';

$staff_id = intval(array_shift($_PARAMETERS));

# pobierz pracownika po kluczu głównym
$user = GC\Model\Staff\Staff::fetchByPrimaryId($staff_id);

$headTitle = trans('Edytowanie pracownika "%s"', [$user['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

# pobierz grupy uprawnień dla każdego pracownika
$groups = array_keys(GC\Model\Staff\Group::select()
    ->fields(['group_id', 'name'])
    ->source('::groups')
    ->order('name', 'ASC')
    ->fetchByMap('group_id', 'name'));

$_POST = $user;

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask("/{$staff_id}/force-change-password")?>" type="button" class="btn btn-success">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Wymuś zmianę hasła')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/breadcrumbs.html.php'; ?>
<?php require ROUTES_PATH.'/admin/staff/form.html.php'; ?>
