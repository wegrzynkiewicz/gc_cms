<?php

if ($menu_id) {
    $_POST = GC\Model\Menu\Menu::fetchByPrimaryId($menu_id);
}

# pobierz strony gdzie kluczem jest $page_id, a elementem nazwa strony
$pageOptions = GC\Model\Page::select()
    ->source('::frame')
    ->equals('lang', $staff->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByMap('page_id', 'name');

?>

<?=render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'destination',
    'label' => 'Strona',
    'help' => 'Wybierz stronę do której wezeł ma kierować',
    'options' => $pageOptions,
    'firstOption' => 'Wybierz stronę',
])?>

<?=render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'target',
    'label' => 'Sposób załadowania adresu',
    'options' => $config['navNodeTargets'],
])?>
