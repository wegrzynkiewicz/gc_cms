<?php foreach($menu as $name => $node): ?>
    <?php if (empty($node['perms']) or $staff->hasPermissions($node['perms'])): ?>
        <li>
            <a href="<?=GC\Url::make($node['path'])?>" id="nav_<?=e($node['id'])?>">

                <?php if (isset($node['icon'])): ?>
                    <i class="<?=e($node['icon'])?>"></i>
                <?php endif ?>

                <?=trans($name)?>

                <?php if (isset($node['children'])): ?>
                    <span class="fa arrow" style="margin-top:3px"></span>
                <?php endif ?>

                <?php if (isset($node['badge']) and $node['badge'] > 0): ?>
                    <span class="label label-warning pull-right" style="margin-top:3px">
                        <?=$node['badge']?>
                    </span>
                <?php endif ?>
            </a>

            <?php if (isset($node['children'])): ?>
                <ul class="<?=e($level)?> collapse">
                    <?=GC\Render::action('/admin/parts/sidebar-item.html.php', [
                        'menu' => $node['children'],
                        'staff' => $staff,
                        'level' => 'nav nav-third-level'
                    ])?>
                </ul>
            <?php endif ?>
        </li>
    <?php endif ?>
<?php endforeach ?>
