<?php
$preview = isset($settings['uri']) ? GC\Thumb::make($settings['uri'], 9999, 145) : $uri->assets($config['noImageUrl']);
?>
<div class="text-center">
    <img src="<?=e($preview)?>" class="img-responsive" style="margin:auto; max-height:145px"/>
</div>
