<?php foreach ($menu->getChildren() as $node): $menu_id = $node['menu_id']; ?>

    <li id="node_<?=e($menu_id)?>" data-id="<?=e($menu_id)?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=$uri->mask("/$menu_id/edit")?>">
                    <?=e($node['name'])?>
                </a>
            </div>

            <div class="pull-right">
                <a data-toggle="modal"
                    data-id="<?=e($menu_id)?>"
                    data-name="<?=e($node['name'])?>"
                    data-target="#deleteModal"
                    title="<?=$trans('Usuń węzeł')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=$trans('Usuń')?>
                </a>
            </div>

            <div class="pull-right" style="margin-right: 30px">
                <?=render(ACTIONS_PATH.'/admin/nav/menu/list-preview/'.$node['type'].'.html.php', [
                    'node' => $node,
                    'frames' => $frames,
                ])?>
            </div>

            <div class="clearfix"></div>
        </div>

        <?php if ($node->hasChildren()): ?>
            <ol>
                <?=render(ACTIONS_PATH.'/admin/nav/menu/tree-items.html.php', [
                    'menu' => $node,
                    'frames' => $frames,
                ])?>
            </ol>
        <?php endif ?>

    </li>

<?php endforeach?>
