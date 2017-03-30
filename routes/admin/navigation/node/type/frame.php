<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/navigation/node/type/_import.php';

# pobierz wszystkie rusztowania i dopisz typ do nazwy
$frames = GC\Model\Frame::select()
    ->fields(['frame_id', 'name', 'type'])
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetchByPrimaryKey();

foreach ($frames as &$frame) {
    $frame = sprintf('%s - %s', $frame['name'], $config['frame']['types'][$frame['type']]['name']);
}
unset($frame);

?>

<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia typu węzła')?></legend>

        <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
            'name' => 'name',
            'label' => trans('Nazwa węzła'),
            'help' => trans('Zostaw pustą, aby używać nazwy docelowej strony'),
        ])?>

        <?=render(ROUTES_PATH.'/admin/_parts/input/select2-single.html.php', [
            'name' => 'frame_id',
            'label' => trans('Strona'),
            'help' => trans('Wybierz stronę do której wezeł ma kierować'),
            'options' => $frames,
            'placeholder' => trans('Wybierz jedną z dostępnych stron'),
        ])?>

        <?=render(ROUTES_PATH.'/admin/_parts/input/select2-single.html.php', [
            'name' => 'target',
            'label' => trans('Sposób przekierowania'),
            'options' => $config['navigation']['nodeTargets'],
            'hideSearch' => true,
        ])?>
    </fieldset>
</div>
