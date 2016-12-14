<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" />
<link rel="stylesheet" href="<?=templateAssetsUrl("/styles/main.css")?>" />

<script src="//cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe-ui-default.min.js"></script>
<script src="<?=assetsUrl("/common/scripts/jquery.photoswipe.js")?>"></script>

<script>
    $('[data-thumb]').each(function(i, e){
        var $e = $(e);
        $e.attr('src', $e.attr('data-thumb')+'/'+$e.width()).removeAttr('data-thumb');
    });
</script>

<?php require TEMPLATE_PATH."/parts/photoswipe.html.php"; ?>

<script>
    $('[data-gallery="photoswipe"]').photoswipe({
        loop: false,
        closeOnScroll: false,
    });
</script>
