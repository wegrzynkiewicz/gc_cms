<?php $name = e($name); ?>
<div class="module-gallery-preview-wrapper">
    <a href="<?=$slug?>"
        target="_blank"
        title="<?=$name?>"
        data-photoswipe-item=""
        data-width="<?=$width?>"
        data-height="<?=$height?>"
        class="thumb-wrapper">
        <img src="<?=$uri->root(thumbnail($slug, 120, 70))?>"
            width="120"
            width="70"
            alt="<?=$name?>"
            class="module-gallery-preview-image">
    </a>
</div>
