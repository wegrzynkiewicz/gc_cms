<?php

$getModuleTemplate = function ($type, $theme) use ($request) {

    $templates = [
        TEMPLATE_PATH."/modules/{$type}/{$theme}-{$request->method}.html.php",
        TEMPLATE_PATH."/modules/{$type}/{$theme}.html.php",
    ];

    foreach ($templates as $template) {
        if (is_readable($template)) {
            return $template;
        }
    }

    return false;
};

$previousWidth = 0;

$gutter = ceil(def($rowSettings, 'gutter', 20)/2)*2;
$gutterHalf = ceil($gutter/2);

?>

<style>
    .row.gutter-<?=$gutter?> {
        margin-left: -<?=$gutterHalf?>px;
        margin-right: -<?=$gutterHalf?>px;
    }
    .row.gutter-<?=$gutter?>>[class*="col-"] {
        padding-left: <?=$gutterHalf?>px;
        padding-right: <?=$gutterHalf?>px;
    }
</style>

<div class="row gutter-<?=$gutter?>">
    <?php foreach ($row as $module): ?>
        <?php list($x, $y, $width, $height) = $module['size']; ?>
        <?php $offset = $x - $previousWidth; ?>
            <div class="col-md-<?=$width?> col-md-offset-<?=$offset?>">
                <?=GC\Render::file(TEMPLATE_PATH.'/parts/module/item.html.php', [
                    'width' => $width,
                    'offset' => $offset,
                    'module' => $module,
                    'template' => $getModuleTemplate($module['type'], $module['theme']),
                ])?>
            </div>
        <?php $previousWidth = $x + $width; ?>
    <?php endforeach ?>
</div>
