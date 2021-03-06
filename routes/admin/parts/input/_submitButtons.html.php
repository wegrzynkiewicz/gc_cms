<?php

$cancelHref = isset($cancelHref)
    ? $uri->make($cancelHref)
    : $breadcrumbs->getBeforeLast()['uri'];

?>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
        <a href="<?=$cancelHref?>" class="btn btn-warning btn-md">
            <i class="fa fa-arrow-left fa-fw"></i>
            <?=trans('Wstecz')?>
        </a>
    </div>
    <?php if (isset($saveLabel) and $saveLabel): ?>
        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa fa-floppy-o fa-fw"></i>
                <?=$saveLabel?>
            </button>
        </div>
    <?php endif ?>
</div>
