<?php $preview = GC\Url::root(def($settings, 'url', '')) ?>

<div id="photo_<?=e($module_id)?>" class="text-center">
    <img data-thumb="<?=generateThumb($preview)?>"
        alt="<?=e($content)?>"
        width="100%"
        class="img-responsive">
</div>
