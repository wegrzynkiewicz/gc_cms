<?php foreach ($tree->getChildren() as $node): $primary_id = $node->getPrimaryId(); ?>

    <div id="node_container_<?=$primary_id?>" class="tree-checkbox-container">
        <div id="node_<?=$primary_id?>" class="checkbox">
            <label>
                <input
                    type="checkbox"
                    class="tree-checkbox"
                    name="<?=$name?>[]"
                    <?=checked(in_array($primary_id, $checkedValues))?>
                    value="<?=$primary_id?>">
                <?=escape($node['name'])?>
            </label>
        </div>
        <div id="node_wrapper_<?=$primary_id?>" class="tree-checkbox-wrapper">
            <?php if ($node->hasChildren()): ?>
                <?=view('/admin/parts/input/checkbox-tree-item.html.php', [
                    'tree' => $node,
                    'name' => $name,
                    'checkedValues' => $checkedValues,
                ])?>
            <?php endif ?>
        </div>
    </div>

<?php endforeach?>
