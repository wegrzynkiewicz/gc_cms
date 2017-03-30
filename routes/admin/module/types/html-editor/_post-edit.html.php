<?php

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => post('content'),
    'theme' => 'default',
]);

flashBox(trans('Moduł tekstowy został zaktualizowany.'));
