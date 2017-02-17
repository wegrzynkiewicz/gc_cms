<ol class="list-unstyled" style="padding-left: 20px">
    <?php foreach ($tree->getChildren() as $node): ?>
        <?php $menu_id = $node['menu_id']; ?>
        <li>
            <a href="<?=$uri->mask("/{$nav_id}/menu/{$menu_id}/edit")?>">
                <?=e($node->getName())?>
            </a>
            <?php if ($node->hasChildren()): ?>
                <?=render(__FILE__, [
                    'tree' => $node,
                ])?>
            <?php endif ?>
        </li>
    <?php endforeach?>
</ol>
