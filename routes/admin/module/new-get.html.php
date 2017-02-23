<?php

$headTitle = trans('Dodawanie nowego modułu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">
            <h3><?=trans('Dostępne moduły')?></h3>
            <div class="row">
                <?php foreach ($config['modules'] as $type => $module): ?>
                    <div class="col-lg-3">
                        <button name="type"
                            type="submit"
                            value="<?=$type?>"
                            class="btn btn-default btn-squared btn-block">
                            <strong>
                                <?=trans($module['name'])?>
                            </strong><br>
                            <br>
                            <?=removeOrphan(trans($module['description']))?>
                        </button>
                    </div>
                <?php endforeach ?>
            </div>
            <?php require ROUTES_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
