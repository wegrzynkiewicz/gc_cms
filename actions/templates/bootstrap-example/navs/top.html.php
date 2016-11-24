<?php if ($topMenu->hasChildren()): ?>
    <div class="blog-masthead">
        <div class="container">
            <nav class="blog-nav">
                <?php foreach ($topMenu->getChildren() as $node): ?>
                    <?=startlinkAttributesFromMenuNode($node, 'class="blog-nav-item"')?>
                        <?=$node['name']?>
                    <?=endlinkAttributesFromMenuNode($node)?>
                <?php endforeach ?>
            </nav>
        </div>
    </div>
<?php else: ?>

<?php endif ?>
