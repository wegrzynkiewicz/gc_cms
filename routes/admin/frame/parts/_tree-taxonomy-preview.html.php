<ol class="list-unstyled" style="padding-left: 20px">
    <?php foreach ($tree->getChildren() as $node): ?>
        <?php $node_id = $node['frame_id']; ?>
        <li>
            <a href="<?=$uri->make("/admin/frame/{$node_id}/edit")?>"
                title="<?=trans('Edytuj ten węzeł')?>">
                <?=e($node['name'])?>
            </a>
            <?php if ($node->hasChildren()): ?>
                <?=render(__FILE__, [
                    'tree' => $node,
                ])?>
            <?php endif ?>
        </li>
    <?php endforeach?>
</ol>
