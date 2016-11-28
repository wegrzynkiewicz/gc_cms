<?php

$headTitle = trans("Nowy moduł na stronie");

$staff->redirectIfUnauthorized();

$page_id = intval(array_shift($_SEGMENTS));
$page = Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

if(wasSentPost()) {
	FrameModule::insert([
        'type' => $_POST['type'],
    ], $frame_id);

	redirect("/admin/module/list/$page_id");
}

$headTitle .= makeLink("/admin/page/edit/$page_id", $page['name']);

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
                'cancelHref' => "/admin/module/list/$page_id",
                'saveLabel' => 'Dodaj nowy moduł',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
