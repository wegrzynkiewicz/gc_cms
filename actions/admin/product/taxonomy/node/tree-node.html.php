<li id="node_<?=$frame_id?>" data-id="<?=$frame_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <a href="<?=$uri->mask("/{$frame_id}/edit")?>">
                <?=$name?>
            </a>
        </div>

        <div class="pull-right">

            <a href="<?=$uri->make("/post/node/{$frame_id}")?>"
                target="_blank"
                title="<?=$trans('Podejrzyj ten węzeł')?>"
                class="btn btn-primary btn-xs">
                <i class="fa fa-search fa-fw"></i>
                <?=$trans('Podgląd')?>
            </a>

            <a href="<?=$uri->mask("/{$frame_id}/module/grid")?>"
                title="<?=$trans('Wyświetl moduły węzła')?>"
                class="btn btn-success btn-xs">
                <i class="fa fa-file-text-o fa-fw"></i>
                <?=$trans('Moduły')?>
            </a>

            <a data-toggle="modal"
                data-id="<?=$frame_id?>"
                data-name="<?=$name?>"
                data-target="#deleteModal"
                title="<?=$trans('Usuń węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=$trans('Usuń')?>
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <?php if ($node->hasChildren()): ?>
        <ol>
            <?php foreach ($node->getChildren() as $node): ?>
                <?=render(ACTIONS_PATH.'/admin/product/taxonomy/node/tree-node.html.php', [
                    'node' => $node,
                    'name' => e($node['name']),
                    'frame_id' => $node['frame_id'],
                ])?>
            <?php endforeach?>
        </ol>
    <?php endif ?>
</li>
