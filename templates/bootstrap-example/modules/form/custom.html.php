<?php

$form_id = $content;
$formTemplate = TEMPLATE_PATH."/modules/form/custom/form-$form_id.html.php";
if (is_readable($formTemplate)) {
    require $formTemplate;
} else {
    require __DIR__.'/default.html.php';
}
