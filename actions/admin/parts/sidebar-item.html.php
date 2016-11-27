<?php foreach($menu as $name => $node): ?>
    <?php if (empty($node['perms']) or $staff->hasPermissions($node['perms'])): ?>
        <li>
            <a href="<?=empty($node['path']) ? '#' : url($node['path'])?>"
                <?=isset($node['id']) ? sprintf('id="%s"', $node['id']) : '' ?> >
                <i class="<?=$node['icon']?>"></i>
                <?=trans($name)?>

                <?php if (isset($node['children'])): ?>
                    <span class="fa arrow"></span>
                <?php endif ?>
            </a>

            <?php if (isset($node['children'])): ?>
                <ul class="<?=$level?> collapse">
                    <?=view('/admin/parts/sidebar-item.html.php', [
                        'menu' => $node['children'],
                        'staff' => $staff,
                        'level' => 'nav nav-third-level'
                    ])?>
                </ul>
            <?php endif ?>
        </li>
    <?php endif ?>
<?php endforeach ?>
