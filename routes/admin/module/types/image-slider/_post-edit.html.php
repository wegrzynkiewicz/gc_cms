<?php

GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

flashBox(trans('Moduł slajdów ze zdjęciami został zaktualizowany.'));
