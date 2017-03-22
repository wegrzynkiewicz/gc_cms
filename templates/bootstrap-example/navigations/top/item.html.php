<li>
    <a href="<?=e($node->getHref())?>"
        id="navNode_<?=$node_id?>"
        data-type="<?=$type?>"
        role="button"
        target="<?=$node['target']?>"
        <?php if ($node->hasChildren()): ?>
            data-toggle="dropdown"
        <?php endif ?>
        class="<?=$node->hasChildren() ? 'dropdown-toggle' : ''?>">
        <?=e($node->getName())?>
        <?php if ($node->hasChildren()): ?>
            <span class="caret"></span>
        <?php endif ?>
    </a>
    <?php if ($node->getChildren()): ?>
        <ul class="dropdown-menu">
            <?php foreach ($node->getChildren() as $child): ?>
                <?=render(__FILE__, $child->getData())?>
            <?php endforeach ?>
        </ol>
    <?php endif ?>
</li>
