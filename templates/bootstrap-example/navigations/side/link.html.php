<?php
$attr = isset($attr) ? $attr : '';
$extendClass = isset($extendClass) ? $extendClass : '';
?>

<?php if ($type === 'empty'): ?>
    <div id="navNode_<?=$node_id?>"
        class="<?=$extendClass?>"
        <?=$attr?>>
        <?=e($node->getName())?>
    </div>
<?php else: ?>
    <a href="<?=e($node->getHref())?>"
        id="navNode_<?=$node_id?>"
        role="button"
        target="<?=$node['target']?>"
        <?=$attr?>
        class="<?=$extendClass?>">
        <?=e($node->getName())?>
    </a>
<?php endif ?>
