<?php $preview = $uri->root(def($settings, 'uri', '')) ?>

<div id="photo_<?=e($module_id)?>" class="text-center">
    <img data-thumb="<?=lazyGenerate($preview)?>"
        alt="<?=e($content)?>"
        width="100%"
        class="img-responsive">
</div>
