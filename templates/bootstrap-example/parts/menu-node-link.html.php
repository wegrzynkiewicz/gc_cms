<?php

$extend = isset($extend) ? $extend : '';
$type = $node['type'];
$types = [
    'homepage' => $uri->root('/'),
    'external' => $node['destination'],
];
$href = in_array($type, $types) ? $types[$type] : $node['link'];

?>
<?php if ($type === 'empty'): ?>
    <div id="navNode_<?=$node['menu_id']?>" <?=$extend?>>
        <?=$node['name']?>
    </div>
<?php else: ?>
    <?php if ($type === '')?>
    <a id="navNode_<?=$node['menu_id']?>"
        <?=$extend?>
        href="<?=$href?>"
        target="<?=$node['target']?>"><?=$node['name']?></a>
<?php endif ?>
