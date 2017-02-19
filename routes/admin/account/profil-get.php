<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/account/_import.php';

$_POST = GC\Staff::getInstance()->getData();

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask("/change-password")?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <?=trans('Zmień hasło')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/select2-language.html.php', [
                    'name' => 'lang',
                    'label' => trans('Język'),
                    'help' => trans('Wyświetla panel i komunikaty w tym języku'),
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz profil'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/footer.html.php'; ?>