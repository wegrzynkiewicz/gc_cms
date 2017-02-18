<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => post('content'),
]);

flashBox(trans('Widżet zdjęcia "%s" został zaktualizowany.', [$widget['name']]));
