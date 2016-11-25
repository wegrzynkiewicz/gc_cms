<?php

$headTitle = trans('Dashboard');

Staff::createFromSession()->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
