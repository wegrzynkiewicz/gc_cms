<?php

if ($menu_id) {
    $_POST = GC\Model\Menu\Menu::fetchByPrimaryId($menu_id);
}

$pageOptions = GC\Model\Page::mapFramesWithPrimaryKeyBy('name');

?>

<?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'destination',
    'label' => 'Strona',
    'help' => 'Wybierz stronę do której wezeł ma kierować',
    'options' => $pageOptions,
    'firstOption' => 'Wybierz stronę',
])?>

<?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>
