<?php
$preview = empty($settings['uri'])
    ? $config['noImageUri']
    : $settings['uri'];
?>
<div class="text-center">
    <img src="<?=$uri->root(GC\Thumb::make($preview, 9999, 145))?>"
        class="img-responsive"
        style="margin:auto; max-height:145px"/>
</div>
