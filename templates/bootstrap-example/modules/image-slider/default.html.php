<?php
    $images = GC\Model\Module\File::joinAllWithKeyByForeign($module_id);
?>

<div id="slider_<?=e($module_id)?>" class="swiper-container" style="height: 21vw">
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
    new Swiper('#slider_<?=e($module_id)?>', {
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
