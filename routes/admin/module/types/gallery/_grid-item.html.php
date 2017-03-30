<div class="module-gallery-preview-wrapper">
    <a href="<?=$uri->root($slug)?>"
        target="_blank"
        title="<?=e($name)?>"
        data-gallery-item=""
        data-width="<?=$width?>"
        data-height="<?=$height?>"
        class="thumb-wrapper">
        <img src="<?=$uri->root(thumbnail($slug, 120, 70))?>"
            width="120"
            width="70"
            alt="<?=e($name)?>"
            class="module-gallery-preview-image">
    </a>
</div>
