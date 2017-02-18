<?php

GC\Model\Widget::updateByPrimaryId($widget_id, [
    'content' => purifyHtml(post('content')),
]);

flashBox($trans('Widżet formatowanego tekstu "%s" został zaktualizowany.', [$widget['name']]));
