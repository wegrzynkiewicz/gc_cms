<?php

# aktualizuj galerię zdjęć
GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

# dekoduj nadesłaną wartość positions
$relations = json_decode(post('positions', []), true);
GC\Model\Module\FileRelation::updateRelations($module_id, $relations);

flashBox(trans('Moduł galerii zdjęć został zaktualizowany.'));
