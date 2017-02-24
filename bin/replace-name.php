<?php

require_once __DIR__.'/_import.php';

foreach (globRecursive('routes/*.php') as $file) {

    $file = realpath(__DIR__.'/../'.$file);

    unset($target);

    $dirname = dirname($file);
    $filename = basename($file);

    if (preg_match('~xhr-(.*?)-?(get|post)?\.php~', $filename, $m)) {
        echo 'AJAX'.PHP_EOL;
        $method = isset($m[2]) ? $m[2] : '';
        $target = trim($method.'-'.$m[1].'.json.php', '-');
    } elseif (preg_match('~(.*?)-?(get|post)?\.html\.php~', $filename, $m) or preg_match('~(.*?)-(get|post)\.php~', $filename, $m)) {
        $method = isset($m[2]) ? $m[2] : '';
        $target = trim($method.'-'.$m[1].'.html.php', '-');
    }
    if (isset($target)) {
        echo PHP_EOL;
        echo $file.PHP_EOL;
        $target = $dirname.'/'.$target;
        echo $target.PHP_EOL;
        rename($file, $target);

    }
}
