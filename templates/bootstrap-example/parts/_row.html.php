<?php
$previousWidth = 0;
$preview = $bg_image
    ? $uri->root(thumbnail($bg_image, 1920, 9999, 'inset'))
    : null;
$half = ceil($gutter/2);
?>

<?php ob_start() ?>
    <div class="row"
        style="
            margin-left: -<?=$half?>px;
            margin-right: -<?=$half?>px;
            <?=$bg_color ? "background-color: {$bg_color};" : ''?>
            <?=$bg_image ? "background-image: url('{$preview}');" : ''?>
        ">
        <?php foreach ($modules as $module): ?>
            <?php $offset = $module['x'] - $previousWidth; ?>
            <?php $previousWidth = $module['x'] + $module['w']; ?>
            <div class="col-md-<?=$module['w']?> col-md-offset-<?=$offset?>"
                style="padding-left: <?=$half?>px; padding-right: <?=$half?>px;">
                <div id="module_<?=$module['module_id']?>"
                    data-type="<?=$module['type']?>"
                    data-theme="<?=$module['theme']?>">
                    <?=render($module['template'], $module)?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php $htmlRow = ob_get_clean() ?>

<div id="row_<?=$frame_id?>_<?=$position?>" class="module-row" data-type="<?=$type?>">
    <?php if ($type === 'fluid'): ?>
        <div class="container-fluid" style="padding-left: <?=$half?>px; padding-right: <?=$half?>px;">
            <?=$htmlRow?>
        </div>
    <?php elseif ($type === 'wrap'): ?>
        <div class="container">
            <?=$htmlRow?>
        </div>
    <?php else: ?>
        <?=$htmlRow?>
    <?php endif ?>
</div>
