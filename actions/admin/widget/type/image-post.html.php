<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => post('content'),
]);

setNotice($trans('Widżet zdjęcia "%s" został zaktualizowany.', [$widget['name']]));
