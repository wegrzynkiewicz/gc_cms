<?php

if ($menu_id) {
    $_POST = GC\Model\Menu\Menu::fetchByPrimaryId($menu_id);
}

?>

<?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'destination',
    'label' => 'Pełny adres do strony WWW',
    'help' => 'Wpisz adres strony do której węzeł ma przekierowywać',
])?>

<?=render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>
