<?php $preview = $uri->root($settings['uri'] ?? '') ?>

<div id="photo_<?=e($module_id)?>" class="text-center" data-gallery="photoswipe">
    <a href="<?=e($preview)?>"
        target="_blank"
        title="<?=e($content)?>"
        data-photoswipe-item=""
        data-width="<?=$settings['width'] ?? 800?>"
        data-height="<?=$settings['height'] ?? 800?>">

        <img data-thumb="<?=$preview?>"
            alt="<?=e($content)?>"
            width="100%"
            class="img-responsive">
    </a>
</div>
