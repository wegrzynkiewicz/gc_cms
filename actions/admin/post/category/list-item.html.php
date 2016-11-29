<?php foreach ($category->getChildren() as $node): $cat_id = $node['cat_id']; ?>

    <li id="node_<?=$cat_id?>" data-id="<?=$cat_id?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=url("/admin/post/category/edit/$cat_id/$tax_id")?>">
                    <?=escape($node['name'])?>
                </a>
            </div>

            <div class="pull-right">
                <a data-toggle="modal"
                    data-id="<?=$cat_id?>"
                    data-name="<?=$node['name']?>"
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
                <?=view('/admin/post/category/list-item.html.php', [
                    'category' => $node,
                    'tax_id' => $tax_id,
                ])?>
            </ol>
        <?php endif ?>
    </li>

<?php endforeach?>
