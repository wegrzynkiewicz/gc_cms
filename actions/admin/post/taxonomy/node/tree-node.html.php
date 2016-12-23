<?php foreach ($tree->getChildren() as $node): $node_id = $node->getPrimaryId(); ?>

    <li id="node_<?=e($node_id)?>" data-id="<?=e($node_id)?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=GC\Url::mask("/{$node_id}/edit")?>">
                    <?=e($node['name'])?>
                </a>
            </div>

            <div class="pull-right">

                <a href="<?=GC\Url::make("/post/node/{$node_id}")?>"
                    target="_blank"
                    title="<?=trans('Podejrzyj ten węzeł')?>"
                    class="btn btn-primary btn-xs">
                    <i class="fa fa-search fa-fw"></i>
                    <?=trans("Podgląd")?>
                </a>

                <a href="<?=GC\Url::mask("/{$node_id}/module/list")?>"
                    title="<?=trans('Wyświetl moduły węzła')?>"
                    class="btn btn-success btn-xs">
                    <i class="fa fa-file-text-o fa-fw"></i>
                    <?=trans("Moduły")?>
                </a>

                <a data-toggle="modal"
                    data-id="<?=e($node_id)?>"
                    data-name="<?=e($node['name'])?>"
                    data-target="#deleteModal"
                    title="<?=trans('Usuń węzeł')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=trans('Usuń')?>
                </a>
            </div>

            <div class="clearfix"></div>
        </div>

        <?php if ($node->hasChildren()): ?>
            <ol>
                <?=GC\Render::action('/admin/post/taxonomy/node/tree-node.html.php', [
                    'tree' => $node,
                ])?>
            </ol>
        <?php endif ?>
    </li>

<?php endforeach?>
