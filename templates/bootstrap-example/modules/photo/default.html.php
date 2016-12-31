<?php $preview = GC\Url::root(def($settings, 'url', '')) ?>

<div id="photo_<?=e($module_id)?>" class="text-center" data-gallery="photoswipe">
    <a href="<?=e($preview)?>"
        target="_blank"
        title="<?=e($content)?>"
        data-photoswipe-item=""
        data-width="<?=def($settings, 'width', 800)?>"
        data-height="<?=def($settings, 'height', 800)?>">

        <img data-thumb="<?=GC\Thumb::lazyGenerate($preview)?>"
            alt="<?=e($content)?>"
            width="100%"
            class="img-responsive">
    </a>
</div>
