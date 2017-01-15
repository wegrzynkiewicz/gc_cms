<?php
$items = GC\Model\Module\Item::joinAllWithFrameByForeign($module_id);
?>

<?php if (empty($items)): ?>
    <div class="simple-box">
        <?=$trans('Nie znaleziono zakładek')?>
    </div>
<?php else: ?>
    <ol id="sortable" class="sortable">
        <?php foreach ($items as $item_id => $item): ?>
            <li id="item_<?=e($item_id)?>" data-id="<?=e($item_id)?>">
                <div class="sortable-content">
                    <div class="col-lg-4">
                        <a href="#"
                            data-toggle="modal"
                            data-id="<?=e($item_id)?>"
                            data-name="<?=e($item['name'])?>"
                            data-target="#editModal">
                            <?=e($item['name'])?>
                        </a>
                    </div>
                    <div class="pull-right">
                        <a href="<?=sprintf($_POST['moduleUrl'], $item_id   )?>"
                            title="<?=$trans('Wyświetl moduły zakładi')?>"
                            class="btn btn-success btn-xs">
                            <i class="fa fa-file-text-o fa-fw"></i>
                            <?=$trans('Moduły')?>
                        </a>
                        <a data-toggle="modal"
                            data-id="<?=e($item_id)?>"
                            data-name="<?=e($item['name'])?>"
                            data-target="#deleteModal"
                            title="<?=$trans('Usuń węzeł')?>"
                            class="btn btn-danger btn-xs">
                            <i class="fa fa-times fa-fw"></i>
                            <?=$trans('Usuń')?>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        <?php endforeach?>
    </ol>
    <script>
        $('#sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            maxLevels: 1
        });
    </script>
<?php endif ?>
