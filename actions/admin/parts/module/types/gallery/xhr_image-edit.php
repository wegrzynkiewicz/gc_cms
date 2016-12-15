<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$file_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {

    $filePath = "./".$_POST['url'];
    list($width, $height) = getimagesize($filePath);
    $settings = [
        'width' => $width,
        'height' => $height,
    ];

    GCC\Model\ModuleFile::updateByPrimaryId($file_id, [
        'name' => $_POST['name'],
        'url' => $_POST['url'],
        'settings' => json_encode($settings),
    ]);

    return http_response_code(204);
}

$image = GCC\Model\ModuleFile::selectByPrimaryId($file_id);

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
