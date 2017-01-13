<?php

$headTitle = $trans('Dodawanie nowego modułu');
$breadcrumbs->push($request->path, $headTitle);

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">
            <h3><?=$trans('Dostępne moduły')?></h3>
            <div class="row">
                <?php foreach (GC\Container::get('config')['modules'] as $type => $module): ?>
                    <div class="col-lg-3">
                        <button name="type"
                            type="submit"
                            value="<?=$type?>"
                            class="btn btn-default btn-squared btn-block">
                            <strong>
                                <?=$trans($module['name'])?>
                            </strong><br>
                            <br>
                            <?=removeOrphan($trans($module['description']))?>
                        </button>
                    </div>
                <?php endforeach ?>
            </div>
            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php')?>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
