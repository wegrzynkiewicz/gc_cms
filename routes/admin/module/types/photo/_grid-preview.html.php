<?php
$preview = empty($settings['uri'])
    ? $config['imageNotAvailableUri']
    : $settings['uri'];
?>
<div class="text-center">
    <img src="<?=$uri->root(thumbnail($preview, 9999, 145))?>"
        class="img-responsive"
        style="margin:auto; max-height:145px"/>
</div>
