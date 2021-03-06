<?php

$headTitle = trans('Brak dostępu');

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/account/_import.php";

$permission = array_shift($_SEGMENTS);

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="simple-box">
            <?php if ($permission == 'default'): ?>
                <?=trans('Nie masz uprawnień do wykonania tej akcji.')?>
            <?php else: ?>
                <?=trans('Nie masz uprawnień do:')?>
                <strong>
                    <?=trans($config['permissions'][$permission])?>
                </strong>
            <?php endif ?>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
