<?php

$headTitle = trans('Dodawanie nowego modułu');
$breadcrumbs->push($request, $headTitle);

if(wasSentPost()) {
	$module_id = GC\Model\FrameModule::insert([
        'type' => $_POST['type'],
        'theme' => 'default',
    ], $frame_id);

    redirect($breadcrumbs->getBeforeLastUrl());
}

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'type',
                'label' => 'Typ modułu',
                'options' => $config['modules'],
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Dodaj nowy moduł',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
