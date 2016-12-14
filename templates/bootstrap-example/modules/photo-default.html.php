<?php
$url = def($settings, 'url', null);
$preview = $url ? rootUrl($url) : assetsUrl($config['noImageUrl']);
?>

<div id="photo_<?=$module_id?>" class="text-center" data-gallery="photoswipe">    
    <a href="<?=$preview?>"
        title="<?=escape($content)?>"
        data-width="<?=def($settings, 'width', 800)?>"
        data-height="<?=def($settings, 'height', 800)?>">

        <img data-thumb="<?=generateThumb($preview)?>"
            alt="<?=escape($content)?>"
            class="img-responsive">
    </a>
</div>
