<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$menu_id = intval(array_shift($_SEGMENTS));
$node = GrafCenter\CMS\Model\Menu::selectByPrimaryId($menu_id);

$_POST = $node;
?>

<?=view('/admin/parts/input/editbox.html.php', [
    'name' => 'destination',
    'label' => 'Pełny adres do strony WWW',
    'help' => 'Wpisz adres strony do której węzeł ma przekierowywać',
])?>

<?=view('/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>
