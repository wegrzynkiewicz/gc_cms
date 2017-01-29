<li>
    <a href="<?=$uri->make($node['path'])?>" id="nav_<?=($node_id)?>">

        <?php if ($node['icon']): ?>
            <i class="fa fa-<?=($node['icon'])?> fa-fw"></i>
        <?php endif ?>

        <?=($node['name'])?>

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
            <?=render(ACTIONS_PATH.'/admin/parts/sidebar/items.html.php', [
                'menu' => $node['children'],
                'staff' => $staff,
                'attr' => 'class="nav nav-third-level collapse"'
            ])?>
        </ul>
    <?php endif ?>
</li>
