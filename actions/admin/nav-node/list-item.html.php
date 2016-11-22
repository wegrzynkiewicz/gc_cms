<?php foreach ($menu as $node): $node_id = $node['node_id']; ?>

    <li id="node_<?=$node_id?>" data-id="<?=$node_id?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <?=escape($node['name'])?>
            </div>

            <div class="pull-right">
                <a data-toggle="modal"
                    data-id="<?=$node_id?>"
                    data-name="<?=$node['name']?>"
                    data-target="#deleteModal"
                    title="<?=trans('Usuń węzeł')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                </a>
            </div>

            <div class="pull-right" style="margin-right: 10px">
                <a href="<?=url("/admin/nav-node/edit/$node_id/$nav_id")?>" class="btn btn-primary btn-xs">
                    <i class="fa fa-cog fa-fw"></i>
                    <?=trans('Edytuj')?>
                </a>
            </div>

            <?php if ($node['type'] != 'empty'): ?>
                <div class="pull-right" style="margin-right: 30px">
                    <?=trans($config['navNodeTargets'][$node['target']])?>
                </div>
            <?php endif ?>

            <div class="pull-right" style="margin-right: 30px">
                <?=trans($config['nodeTypes'][$node['type']])?>
                <?=view('/admin/nav-node/list-preview/'.$node['type'].'.html.php', [
                    'node' => $node,
                    'pages' => $pages,
                ])?>
            </div>

            <div class="clearfix"></div>
        </div>

        <?php if (isset($node['children'])): ?>
            <ol>
                <?=view('/admin/nav-node/list-item.html.php', [
                    'menu' => $node['children'],
                    'nav_id' => $nav_id,
                    'pages' => $pages,
                ])?>
            </ol>
        <?php endif ?>

    </li>

<?php endforeach?>
