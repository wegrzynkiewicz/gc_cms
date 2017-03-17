<li id="node_<?=$node_id?>" data-id="<?=$node_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <a href="<?=$uri->mask("/node/{$node_id}/edit")?>">
                <?=e($node->getName())?>
            </a>
        </div>

        <div class="pull-right">
            <a data-toggle="modal"
                data-id="<?=$node_id?>"
                data-name="<?=e($node->getName())?>"
                data-target="#deleteModal"
                title="<?=trans('Usuń węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=trans('Usuń')?>
            </a>
        </div>

        <div class="pull-right" style="margin-right: 30px">
            <?=render(ROUTES_PATH."/admin/navigation/node/_preview/{$type}.html.php", $node->getData())?>
        </div>

        <div class="clearfix"></div>
    </div>

    <?php if ($node->hasChildren()): ?>
        <ol>
            <?php foreach ($node->getChildren() as $child): ?>
                <?=render(__FILE__, $child->getData())?>
            <?php endforeach ?>
        </ol>
    <?php endif ?>
</li>
