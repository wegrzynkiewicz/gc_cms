<?php
$preview = isset($settings['url']) ? Thumb::make($settings['url'], 9999, 145) : assetsUrl($config['noImageUrl']);
?>
<div class="text-center">
    <img src="<?=$preview?>" class="img-responsive" style="margin:auto; max-height:145px"/>
</div>
