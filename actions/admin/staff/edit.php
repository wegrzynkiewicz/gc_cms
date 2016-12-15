<?php

$staff_id = intval(array_shift($_SEGMENTS));
$user = GC\Model\Staff::selectByPrimaryId($staff_id);

$headTitle = trans('Edytowanie pracownika "%s"', [$user['name']]);
$breadcrumbs->push($request, $headTitle);

if (wasSentPost()) {

    $email = inputValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = trans('Adres email jest nieprawidłowy');
    }

    $existedStaff = GC\Model\Staff::selectSingleBy('email', $email);
    if ($existedStaff and $existedStaff['staff_id'] != $staff_id) {
        $error = trans('Taki adres email już istnieje');
    }

    if (!isset($error)) {
        $groups = isset($_POST['groups']) ? $_POST['groups'] : [];
        GC\Model\Staff::update($staff_id, $_POST, $groups);

        redirect($breadcrumbs->getBeforeLastUrl());
    }

} else {
    $_POST = $user;
}

$groups = array_keys(GC\Model\StaffGroup::selectAllAsOptionsByStaffId($staff_id));

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=url("/admin/staff/force-change-password/$staff_id")?>" type="button" class="btn btn-success">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Wymuś zmianę hasła')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
