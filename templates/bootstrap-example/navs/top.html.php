<?php $menu = GC\Model\Menu::buildTreeByWorkName("top", getClientLang()) ?>

<?php if ($menu->hasChildren()): ?>
    <div class="blog-masthead">
        <div class="container">
            <nav class="blog-nav">
                <?php foreach ($menu->getChildren() as $node): ?>
                    <?=$node->getOpenTag('class="blog-nav-item"')?>
                        <?=$node['name']?>
                    <?=$node->getCloseTag()?>
                <?php endforeach ?>
            </nav>
        </div>
    </div>
<?php else: ?>

<?php endif ?>
