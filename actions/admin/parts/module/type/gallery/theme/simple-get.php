<?php

$module = GC\Model\Module\Module::selectByPrimaryId($module_id);
$settings = json_decode($module['settings'], true);

if (!isset($settings['gutter'])) {
    $settings['gutter'] = 20;
}

$_POST = $settings;

?>

<?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
    'name' => 'thumbsPerRow',
    'label' => 'Ilość miniaturek na wiersz galerii',
    'options' => [
        12 => 12,
        6 => 6,
        4 => 4,
        3 => 3,
        2 => 2,
        1 => 1,
    ]
])?>

<?=GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'gutter',
    'label' => 'Odstęp pomiędzy miniaturkami (w pikselach)',
    'help' => 'Ustawia odstęp w pikselach pomiędzy miniaturkami w wierszu.',
])?>
