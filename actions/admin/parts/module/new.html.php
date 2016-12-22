<?php

$headTitle = trans('Dodawanie nowego modułu');
$breadcrumbs->push($request, $headTitle);

if(isPost()) {
    $moduleType = $_POST['type'];
	$module_id = GC\Model\Module::insertWithFrameId([
        'type' => $moduleType,
        'theme' => 'default',
        'settings' => json_encode([]),
    ], $frame_id);

    setNotice(trans("%s został utworzony. Edytujesz go teraz.", [$config['modules'][$moduleType]['name']]));

    GC\Response::redirect($surl("/{$module_id}/edit"));
}

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

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

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php')?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
