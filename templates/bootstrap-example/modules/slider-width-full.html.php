<?php
    $images = GC\Model\ModuleFile::selectAllByModuleId($module_id);
?>

<div id="slider_<?=$module_id?>" class="swiper-container" style="height: 400px">
    <div class="swiper-wrapper">
        <?php foreach ($images as $image_id => $image): ?>
            <div class="swiper-slide"
                style="background-image: url('<?=GC\Thumb::make($image['url'], 1920, 9999)?>')">
            </div>
        <?php endforeach ?>
    </div>

    <div class="swiper-pagination"></div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<script>
$(function () {
    new Swiper('#slider_<?=$module_id?>', {
        loop: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
    });
});
</script>

<style>
.swiper-slide {
    background-size: cover;
    background-position: center center;
}
</style>
