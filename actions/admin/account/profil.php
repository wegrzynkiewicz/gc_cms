<?php

if (isPost()) {
    GC\Model\Staff::updateByPrimaryId($_SESSION['staff']['entity']['staff_id'], [
        'lang' => $_POST['lang'],
    ]);

	redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $staff->getData();

require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=url("/admin/account/change-password")?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Zmień hasło')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?=view('/admin/parts/input/select2-language.html.php', [
                    'name' => 'lang',
                    'label' => 'Język',
                    'help' => 'Wyświetla panel i komunikaty w tym języku',
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz profil',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
