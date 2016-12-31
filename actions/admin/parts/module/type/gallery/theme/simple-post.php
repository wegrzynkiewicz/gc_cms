<?php

$settings['gutter'] = $_POST['gutter'];
$settings['thumbsPerRow'] = intval($_POST['thumbsPerRow']);

if (empty($settings['gutter']) and $settings['gutter'] != 0) {
    $settings['gutter'] = 20;
}
