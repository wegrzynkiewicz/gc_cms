<?php

# pobierz liczbę odpowiednich rusztowań
$count = GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', $frameType)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];

echo render(ROUTES_PATH.'/admin/frame/_parts/list-frames.html.php', [
    'addCaption' => trans('Dodaj nowy wpis'),
    'nameCaption' => trans('Nazwa wpisu'),
    'notFoundCaption' => trans('Nie znaleziono żadnego wpisu w języku: '),
]);
