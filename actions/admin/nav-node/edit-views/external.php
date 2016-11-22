<?php

checkPermissions();

$node_id = intval(array_shift($_SEGMENTS));
$node = NavNodeModel::selectByPrimaryId($node_id);

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
