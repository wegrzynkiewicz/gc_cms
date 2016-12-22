<?php
$url = def($settings, 'url', null);
$preview = $url ? GC\Url::root($url) : assetsUrl($config['noImageUrl']);
?>

<div id="photo_<?=e($module_id)?>" class="text-center" data-gallery="photoswipe">
    <a href="<?=e($preview)?>"
        target="_blank"
        title="<?=e($content)?>"
        data-photoswipe-item=""
        data-width="<?=def($settings, 'width', 800)?>"
        data-height="<?=def($settings, 'height', 800)?>">

        <img data-thumb="<?=generateThumb($preview)?>"
            alt="<?=e($content)?>"
            class="img-responsive">
    </a>
</div>
