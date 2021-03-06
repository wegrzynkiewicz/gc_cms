<?php foreach ($tree->getChildren() as $node): $primary_id = $node->getNodeId(); ?>

    <div id="node_container_<?=e($primary_id)?>" class="tree-checkbox-container">
        <div id="node_<?=e($primary_id)?>" class="checkbox">
            <label>
                <input
                    type="checkbox"
                    class="tree-checkbox"
                    name="<?=$name?>[]"
                    <?=checked(in_array($primary_id, $checkedValues))?>
                    value="<?=e($primary_id)?>">
                <?=e($node['name'])?>
            </label>
        </div>
        <div id="node_wrapper_<?=e($primary_id)?>" class="tree-checkbox-wrapper">
            <?php if ($node->hasChildren()): ?>
                <?=render(ROUTES_PATH."/admin/parts/input/_checkbox-tree-item.html.php", [
                    'tree' => $node,
                    'name' => $name,
                    'checkedValues' => $checkedValues,
                ])?>
            <?php endif ?>
        </div>
    </div>

<?php endforeach?>
