<?php

if (wasSentPost()) {
    GC\Model\Staff::updateByPrimaryId($_SESSION['staff']['staff_id'], [
        'lang' => $_POST['lang'],
    ]);

	redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $staff->getData();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=url("/admin/account/change-password")?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Zmień hasło')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/select2-language.html.php', [
                'name' => 'lang',
                'label' => 'Język',
                'help' => 'Wyświetla panel i komunikaty w tym języku',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz profil',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
