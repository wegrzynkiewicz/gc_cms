<?php

$staff->redirectIfUnauthorized();

$menu_id = intval(array_shift($_SEGMENTS));
$node = NavMenuModel::selectByPrimaryId($menu_id);

$_POST = $node;

$pages = PageModel::selectAllWithFrames();
$pageOptions = [];
foreach($pages as $page_id => $page) {
    $pageOptions[$page_id] = $page['name'];
}
?>

<?=view('/admin/parts/input/selectbox.html.php', [
    'name' => 'destination',
    'label' => 'Strona',
    'help' => 'Wybierz stronę do której wezeł ma kierować',
    'options' => $pageOptions,
    'firstOption' => 'Wybierz stronę',
])?>

<?=view('/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>