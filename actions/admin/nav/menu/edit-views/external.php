<?php

if ($menu_id) {
    $_POST = GC\Model\Menu\Menu::fetchByPrimaryId($menu_id);
}

?>

<?=GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'destination',
    'label' => 'Pełny adres do strony WWW',
    'help' => 'Wpisz adres strony do której węzeł ma przekierowywać',
])?>

<?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => GC\Container::get('config')['navNodeTargets'],
])?>
