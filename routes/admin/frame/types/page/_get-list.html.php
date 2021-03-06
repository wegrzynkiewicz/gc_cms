<?php

// pobierz liczbę odpowiednich rusztowań
$count = GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', $frameType)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];

echo render(ROUTES_PATH."/admin/frame/parts/_list-frames.html.php", [
    'addCaption' => trans('Dodaj nową stronę'),
    'nameCaption' => trans('Nazwa strony'),
    'notFoundCaption' => trans('Nie znaleziono żadnej strony w języku: '),
]);
