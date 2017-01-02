<?php

$user = GC\Model\Staff\Staff::selectByPrimaryId($staff_id);
$headTitle = trans('Edytowanie pracownika "%s"', [$user['name']]);
$breadcrumbs->push($request->path, $headTitle);

$groups = array_keys(GC\Model\Staff\Group::mapNameByStaffId($staff_id));
$_POST = $user;

require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=GC\Url::mask("/{$staff_id}/force-change-password")?>" type="button" class="btn btn-success">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Wymuś zmianę hasła')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
