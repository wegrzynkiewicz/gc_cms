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

    GC\Model\Module::updateByPrimaryId($module_id, [
        'theme' => 'default',
        'content' => $name,
        'settings' => json_encode($settings),
    ]);

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $settings;
$_POST['content'] = $content;

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa zdjęcia',
                ])?>

                <?=GC\Render::action('/admin/parts/input/image.html.php', [
                    'name' => 'url',
                    'label' => 'Zdjęcie',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł zdjęcia',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
