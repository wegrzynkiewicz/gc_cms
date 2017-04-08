<?php
    $meta = GC\Model\Module\Meta::fetchMeta($module_id);

?>

<?php
if($meta['width'] == 0){
    $width = 'auto';
}
if($meta['height'] == 0){
    $height = 'auto';
}
if($meta['width'] != 0 and $meta['height'] !=0){
    $width = $meta['width'];
    $height = $meta['height'];
}
 ?>
<iframe width="<?= $width ?>" height="<?= $height?>" src="https://www.youtube.com/embed/<?=$content?>" frameborder="0" allowfullscreen></iframe>
