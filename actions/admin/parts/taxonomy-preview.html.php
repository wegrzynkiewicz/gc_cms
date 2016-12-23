<ol class="list-unstyled" style="padding-left: 20px">
    <?php foreach ($tree->getChildren() as $node): ?>
        <?php $node_id = $node->getPrimaryId() ?>
        <li>
            <a href="<?=$taxonomyUrl("/{$node_id}/edit")?>">
                <?=e($node['name'])?>
            </a>
            <?php if ($node->hasChildren()): ?>
                <?=GC\Render::action('/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $node,
                    'taxonomyUrl' => $taxonomyUrl,
                ])?>
            <?php endif ?>
        </li>
    <?php endforeach?>
</ol>
