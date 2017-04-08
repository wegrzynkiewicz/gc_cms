<?php
    $meta = GC\Model\Module\Meta::fetchMeta($module_id);

?>

<?php

$width = $meta['width'];
$height = $meta['height'];

if($meta['width'] == 0){
    $width = 'auto';
}
if($meta['height'] == 0){
    $height = 'auto';
}

 ?>
<iframe width="<?= $width ?>" height="<?= $height?>" src="https://www.youtube.com/embed/<?=$content?>" frameborder="0" allowfullscreen></iframe>
