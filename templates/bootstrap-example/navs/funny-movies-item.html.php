<li>
    <?=render(TEMPLATE_PATH.'/navs/node.html.php', [
        'node' => $node
    ])?>
    <ol class="list-unstyled" style="padding-left: 20px">
        <?php foreach ($node->getChildren() as $child): ?>
            <?=render(__FILE__, [
                'node' => $child,
            ])?>
        <?php endforeach ?>
    </ol>
</li>
