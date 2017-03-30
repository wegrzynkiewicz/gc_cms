<?php

GC\Model\Module\Meta::updateMeta($module_id, [
    'gutter'            => post('gutter'),
    'thumbnailsPerRow'  => post('thumbnailsPerRow'),
]);
