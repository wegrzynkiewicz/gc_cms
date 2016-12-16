<?php

$headTitle = trans("Edytowanie zdjęcia w galerii");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$image_id = intval(array_shift($_SEGMENTS));
$gallery_id = intval(array_shift($_SEGMENTS));

if (isPost()) {
    GC\Model\GalleryImage::updateByPrimaryId($image_id, [
        'name' => $_POST['name'],
        'file' => $_POST['file'],
    ]);
    redirect("/admin/gallery/images/list/$gallery_id");
}

$gallery = GC\Model\Gallery::selectByPrimaryId($gallery_id);
$image = GC\Model\GalleryImage::selectByPrimaryId($image_id);
$headTitle .= makeLink("/admin/gallery/images/list/$gallery_id", $gallery['name']);

$_POST = $image;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=($headTitle)?>
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
                'name' => 'file',
                'label' => 'Zdjęcie',
                'placeholder' => 'Ścieżka do pliku zdjęcia',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz galerię',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
