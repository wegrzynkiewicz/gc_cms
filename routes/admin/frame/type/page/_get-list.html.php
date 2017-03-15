<?php

# pobierz liczbę odpowiednich rusztowań
$count = GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', $type)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];

display(ROUTES_PATH.'/admin/frame/_parts/list-frames.html.php', [
    'addCaption' => trans('Dodaj nową stronę'),
    'nameCaption' => trans('Nazwa strony'),
]);
