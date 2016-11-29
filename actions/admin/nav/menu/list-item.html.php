<?php foreach ($menu->getChildren() as $node): $menu_id = $node['menu_id']; ?>

    <li id="node_<?=$menu_id?>" data-id="<?=$menu_id?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=url("/admin/nav/menu/edit/$menu_id/$nav_id")?>">
                    <?=escape($node['name'])?>
                </a>
            </div>

            <div class="pull-right">
                <a data-toggle="modal"
                    data-id="<?=$menu_id?>"
                    data-name="<?=$node['name']?>"
                    data-target="#deleteModal"
                    title="<?=trans('Usuń węzeł')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=trans('Usuń')?>
                </a>
            </div>

            <?php if ($node['type'] != 'empty'): ?>
                <div class="pull-right" style="margin-right: 30px">
                    <?=trans($config['navNodeTargets'][$node['target']])?>
                </div>
            <?php endif ?>

            <div class="pull-right" style="margin-right: 30px">
                <?=view('/admin/nav/menu/list-preview/'.$node['type'].'.html.php', [
                    'node' => $node,
                    'pages' => $pages,
                ])?>
            </div>

            <div class="clearfix"></div>
        </div>

        <?php if ($node->hasChildren()): ?>
            <ol>
                <?=view('/admin/nav/menu/list-item.html.php', [
                    'menu' => $node,
                    'nav_id' => $nav_id,
                    'pages' => $pages,
                ])?>
            </ol>
        <?php endif ?>

    </li>

<?php endforeach?>
