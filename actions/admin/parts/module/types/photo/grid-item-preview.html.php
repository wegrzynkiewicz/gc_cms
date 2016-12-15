<?php
$preview = isset($settings['url']) ? GC\Thumb::make($settings['url'], 9999, 145) : assetsUrl($config['noImageUrl']);
?>
<div class="text-center">
    <img src="<?=e($preview)?>" class="img-responsive" style="margin:auto; max-height:145px"/>
</div>
