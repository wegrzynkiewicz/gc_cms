<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => $_POST['content'],
]);

setNotice(trans('Widżet tekstowy "%s" został zaktualizowany.', [$widget['name']]));
