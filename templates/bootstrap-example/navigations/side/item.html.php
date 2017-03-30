<li>
    <?=render(TEMPLATE_PATH."/navigations/side/_link.html.php", $node->getData())?>
    <?php if ($node->getChildren()): ?>
        <ol class="list-unstyled" style="padding-left: 20px">
            <?php foreach ($node->getChildren() as $child): ?>
                <?=render(__FILE__, $child->getData())?>
            <?php endforeach ?>
        </ol>
    <?php endif ?>
</li>
