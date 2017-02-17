<?php

extract($node->getData());
$extend = isset($extend) ? $extend : '';

?>
<?php if ($type === 'empty'): ?>
    <div id="navNode_<?=$menu_id?>"
        <?=$extend?>>
        <?=e($node->getName())?>
    </div>
<?php else: ?>
    <a id="navNode_<?=$menu_id?>"
        <?=$extend?>
        href="<?=$node->getUri()?>"
        target="<?=$target?>"><?=e($node->getName())?></a>
<?php endif ?>
