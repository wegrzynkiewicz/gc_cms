<li id="item_<?=$frame_id?>" data-id="<?=$frame_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <a href="#"
                data-toggle="modal"
                data-id="<?=$frame_id?>"
                data-name="<?=$name?>"
                data-target="#editModal">
                <?=$name?>
            </a>
        </div>
        <div class="pull-right">
            <a href="<?=$uri->make("/admin/module/grid/{$frame_id}")?>"
                title="<?=trans('Wyświetl moduły zakładi')?>"
                class="btn btn-primary btn-xs">
                <i class="fa fa-table fa-fw"></i>
                <?=trans('Moduły')?>
            </a>
            <a data-toggle="modal"
                data-id="<?=$frame_id?>"
                data-name="<?=$name?>"
                data-target="#deleteModal"
                title="<?=trans('Usuń węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=trans('Usuń')?>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</li>
