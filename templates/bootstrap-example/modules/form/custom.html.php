<?php

$form_id = $content;
$template = TEMPLATE_PATH."/modules/form/custom/form-{$form_id}-{$request->method}.html.php";
if (!is_readable($template)) {
    $template = TEMPLATE_PATH."/modules/form/default-{$request->method}.html.php";
}

require $template;
