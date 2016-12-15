<ol class="list-unstyled" style="padding-left: 20px">
    <?php foreach ($category->getChildren() as $node): $node_id = $node->getPrimaryId() ?>
        <li>
            <a href="<?=url("/admin/post/node/edit/$node_id/$tax_id")?>">
                <?=e($node['name'])?>
            </a>
            <?php if ($node->hasChildren()): ?>
                <?=view('/admin/post/list-tax-preview.html.php', [
                    'category' => $node,
                    'tax_id' => $tax_id,
                ])?>
            <?php endif ?>
        </li>
    <?php endforeach?>
</ol>
