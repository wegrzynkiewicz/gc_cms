<?php

if(wasSentPost()) {
	FrameModule::insert([
        'type' => $_POST['type'],
        'theme' => 'default',
    ], $frame_id);

	redirect("/admin/$frame/module/list/$parent_id");
}

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'type',
                'label' => 'Typ modułu',
                'options' => $config['modules'],
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/$frame/list",
                'saveLabel' => 'Dodaj nowy moduł',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
