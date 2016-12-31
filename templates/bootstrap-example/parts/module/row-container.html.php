<?php

$rowHtml = GC\Render::template('/parts/module/row.html.php', [
    'row' => $row,
    'rowSettings' => $rowSettings,
]);

$widthType = def($rowSettings, 'widthType');

if ($widthType === 'fluid') {
} elseif ($widthType === 'wrap' and $container) {
    $rowHtml = sprintf('<div class="container">%s</div>', $rowHtml);
} elseif ($container) {
    $rowHtml = sprintf('<div class="container">%s</div>', $rowHtml);
}

$bgColor = def($rowSettings, 'bgColor');
$bgImage = def($rowSettings, 'bgImage');

?>

<div class="module-row" style="
    <?=$bgColor ? "background-color: $bgColor;" : ''?>;
    <?=$bgImage ? "background-image: url('$bgImage');" : ''?>;
">
    <?=$rowHtml?>
</div>
