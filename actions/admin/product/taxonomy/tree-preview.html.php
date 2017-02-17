<ol class="list-unstyled" style="padding-left: 20px">
    <?php foreach ($tree->getChildren() as $node): ?>
        <?php $node_id = $node['frame_id']; ?>
        <li>
            <a href="<?=$uri->mask("/{$tax_id}/node/{$node_id}/edit")?>">
                <?=e($node['name'])?>
            </a>
            <?php if ($node->hasChildren()): ?>
                <?=render(ACTIONS_PATH.'/admin/product/taxonomy/tree-preview.html.php', [
                    'tree' => $node,
                ])?>
            <?php endif ?>
        </li>
    <?php endforeach?>
</ol>
