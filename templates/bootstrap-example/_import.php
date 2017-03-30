<?php

/** Inicjalizacyjny plik dla plików szablonu */

require TEMPLATE_PATH."/functions.php";

# ustawienie katalogu dla nowych translacji
GC\Translator::$domain = 'template-'.TEMPLATE;

# pobranie wszystkich widgetów
$widgets = GC\Model\Widget::select()
    ->equals('lang', getVisitorLang())
    ->fetchByKey('workname');
