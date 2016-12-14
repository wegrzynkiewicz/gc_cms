<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$file_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {

    $filePath = "./".$_POST['url'];
    list($width, $height) = getimagesize($filePath);
    $settings = [
        'width' => $width,
        'height' => $height,
    ];

    ModuleFile::updateByPrimaryId($file_id, [
        'name' => $_POST['name'],
        'url' => $_POST['url'],
        'settings' => json_encode($settings),
    ]);
    redirect($_SESSION['preview_url']);
}

$image = ModuleFile::selectByPrimaryId($file_id);

$_POST = $image;

?>

<?=view('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Krótki tytuł zdjęcia',
])?>

<?=view('/admin/parts/input/image.html.php', [
    'name' => 'url',
    'label' => 'Zdjęcie',
    'placeholder' => 'Ścieżka do pliku zdjęcia',
])?>
