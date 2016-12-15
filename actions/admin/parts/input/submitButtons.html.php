<?php

global $breadcrumbs;

if (!isset($cancelHref)) {
    $cancelHref = $breadcrumbs->getBeforeLastUrl();
}

?>

<hr>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
        <a href="<?=url($cancelHref)?>" class="btn btn-warning btn-lg ">
            <i class="fa fa-arrow-left fa-fw"></i>
            <?=trans('Wstecz')?>
        </a>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
        <button type="submit" class="btn btn-success btn-lg ">
            <i class="fa fa-floppy-o fa-fw"></i>
            <?=trans($saveLabel)?>
        </button>
    </div>
</div>
