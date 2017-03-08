<?php $caption = $name.' - '.$config['frames'][$type]['name']; ?>

<li id="item_<?=$frame_id?>" data-id="<?=$frame_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <?=$caption?>
        </div>
        <div class="pull-right">
            <a data-toggle="modal"
                data-id="<?=$frame_id?>"
                data-name="<?=$name?>"
                data-target="#deleteModal"
                title="<?=trans('Wyłącz ten węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=trans('Zaprzestań wyświetlania')?>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</li>
