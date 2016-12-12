<?php

$headTitle = trans("Edytowanie zdjęcia w module galerii");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$file_id = intval(array_shift($_SEGMENTS));
$module_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    ModuleFile::updateByPrimaryId($file_id, [
        'name' => $_POST['name'],
        'filepath' => $_POST['filepath'],
    ]);
    redirect($_SESSION['preview_url']);
}

$image = ModuleFile::selectByPrimaryId($file_id);

$_POST = $image;

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
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Krótki tytuł zdjęcia',
            ])?>

            <?=view('/admin/parts/input/image.html.php', [
                'name' => 'filepath',
                'label' => 'Zdjęcie',
                'placeholder' => 'Ścieżka do pliku zdjęcia',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => $_SESSION['preview_url'],
                'saveLabel' => 'Zapisz galerię',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
