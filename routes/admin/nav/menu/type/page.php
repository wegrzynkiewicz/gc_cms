<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/nav/_import.php';
require ROUTES_PATH.'/admin/nav/menu/_import.php';

# pobierz strony gdzie kluczem jest $page_id, a elementem nazwa strony
$pageOptions = GC\Model\Frame::select()
    ->equals('type', 'page')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByMap('frame_id', 'name');

?>

<div class="simple-box">
    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
        'name' => 'frame_id',
        'label' => trans('Strona'),
        'help' => trans('Wybierz stronę do której wezeł ma kierować'),
        'options' => $pageOptions,
        'firstOption' => trans('Wybierz stronę'),
    ])?>

    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
        'name' => 'target',
        'label' => trans('Sposób załadowania adresu'),
        'options' => array_trans($config['navNodeTargets']),
    ])?>
</div>
