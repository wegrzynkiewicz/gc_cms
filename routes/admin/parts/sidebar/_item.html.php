<?php if (GC\Staff::getInstance()->hasPermissions($node['perms'])): ?>
    <li>
        <a href="<?=$uri->make($node['path'])?>" id="nav_<?=$node_id?>">

            <?php if ($node['icon']): ?>
                <i class="fa fa-<?=$node['icon']?> fa-fw"></i>
            <?php endif ?>

            <?=$node['name']?>

            <?php if (count($node['children'])): ?>
                <span class="fa arrow" style="margin-top:3px"></span>
            <?php endif ?>

            <?php if (isset($node['badge']) and $node['badge'] > 0): ?>
                <span class="label label-warning pull-right" style="margin-top:3px">
                    <?=$node['badge']?>
                </span>
            <?php endif ?>
        </a>

        <?php if (count($node['children'])): ?>
            <ul <?=$attr?>>
                <?php foreach ($node['children'] as $node_id => $child): ?>
                    <?=render(__FILE__, [
                        'node_id' => $node_id,
                        'node' => $child,
                        'attr' => 'class="nav nav-third-level collapse"',
                    ])?>
                <?php endforeach ?>
            </ul>

        <?php endif ?>
    </li>
<?php endif ?>
