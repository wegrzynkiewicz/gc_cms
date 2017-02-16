<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => post('content'),
]);

flashBox($trans('Widżet tekstowy "%s" został zaktualizowany.', [$widget['name']]));
