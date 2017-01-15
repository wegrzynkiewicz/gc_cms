<?php

if ($menu_id) {
    $_POST = GC\Model\Menu\Menu::fetchByPrimaryId($menu_id);
}

?>

<?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'destination',
    'label' => 'Pełny adres do strony WWW',
    'help' => 'Wpisz adres strony do której węzeł ma przekierowywać',
])?>

<?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>
