<?php

$headTitle = trans("Edycja modułu pojedyńczego zdjęcia");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

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

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $settings;
$_POST['content'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa zdjęcia',
                ])?>

                <?=view('/admin/parts/input/image.html.php', [
                    'name' => 'url',
                    'label' => 'Zdjęcie',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł zdjęcia',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
