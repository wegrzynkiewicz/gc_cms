<?php

$headTitle = trans("Edytujesz moduł tekstowy");

if (wasSentPost()) {

    $url = $_POST['url'];
    $name = $_POST['name'];

    $filePath = "./$url";
    list($width, $height) = getimagesize($filePath);
    $settings = [
        'url' => $url,
        'width' => $width,
        'height' => $height,
    ];

    GC\Model\FrameModule::updateByPrimaryId($module_id, [
        'theme' => 'default',
        'content' => $name,
        'settings' => json_encode($settings),
    ]);
    redirect("/admin/$frame/module/list/$parent_id");
}

$_POST = $settings;
$_POST['content'] = $content;

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

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Nazwa zdjęcia',
            ])?>

            <?=view('/admin/parts/input/image.html.php', [
                'name' => 'url',
                'label' => 'Zdjęcie',
                'placeholder' => 'Ścieżka do pliku zdjęcia',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/$frame/module/list/$parent_id",
                'saveLabel' => 'Zapisz moduł zdjęcia',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
