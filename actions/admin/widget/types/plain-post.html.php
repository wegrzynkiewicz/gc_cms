<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => purifyHtml(post('content')),
]);

flashBox($trans('Widżet tekstowy "%s" został zaktualizowany.', [$widget['name']]));
