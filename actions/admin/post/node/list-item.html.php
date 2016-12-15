<?php foreach ($category->getChildren() as $node): $node_id = $node['node_id']; ?>

    <li id="node_<?=e($node_id)?>" data-id="<?=e($node_id)?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=url("/admin/post/node/edit/$node_id/$tax_id")?>">
                    <?=e($node['name'])?>
                </a>
            </div>

            <div class="pull-right">
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
                <?=view('/admin/post/node/list-item.html.php', [
                    'category' => $node,
                    'tax_id' => $tax_id,
                ])?>
            </ol>
        <?php endif ?>
    </li>

<?php endforeach?>
