<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css" integrity="sha384-hxDEC7RshPmNKmLhPqQ9Nx7tq9n846eZCczfT28RrdyRCmKQAgYNlJRhyXy+6a1f" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" integrity="sha384-EAV0qjkNeoPc8RzwxkqwBzz/Q5qyV9dF3jL7fZ/8EZO8IDcmoOHfSeoj3w/LdYj+" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" integrity="sha384-MPpt1W7za5xYx/fOLYN2ArjgJeN9x7w9spvBInv/W5GG/w0fyN6N/0tsUSM8BNLg" crossorigin="anonymous">
<link rel="stylesheet" href="<?=GC\Url::templateAssets("/styles/main.css")?>" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js" integrity="sha384-SHb/knpyf6vmZuY7ONN68y9Z2/Up/WpaZgmcYFllx5pLmOkaPlq6IxeZAlp5AMk6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.jquery.min.js" integrity="sha384-gLvVm3G7jBTq9s3GmovecLBW1WXBb5pUw167JAXv0LPDkFeX8qVhC9gz8a8XshNO" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.js" integrity="sha384-bD5m2XNm9nP2xLhY13ZMvm73xzZvv/tfbPzYGjMLduzMLnDc9gzc1sVl3vufMg/U" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe-ui-default.min.js" integrity="sha384-DiTOB5DarLwdE9bzATOXhLQp6irFZIhtJreUNJiwMMDiHGu7LdRZeqZBveanC2zo" crossorigin="anonymous"></script>

<?php
$template = sprintf(TEMPLATE_PATH.'/parts/assets/footer-%s.html.php', GC\Auth\Client::getLang());
if (is_readable($template)) {
    require $template;
}
?>

<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="<?=GC\Url::assets("/common/scripts/jquery.photoswipe.js")?>"></script>

<script>
    $('[data-thumb]').each(function(i, e){
        var $e = $(e);
        $e.attr('src', $e.attr('data-thumb')+'/'+Math.ceil($e.width())).removeAttr('data-thumb');
    });
</script>

<?php require TEMPLATE_PATH."/parts/photoswipe.html.php"; ?>

<script>
    $('[data-gallery="photoswipe"]').photoswipe({
        loop: false,
        closeOnScroll: false,
    });
</script>

<script>
$.ajaxSetup({
    beforeSend: function(xhr, settings) {
        if (!settings.crossDomain) {
            xhr.setRequestHeader("X-CSRFToken", "<?=$_SESSION['csrf_token']?>")
        }
    }
});
$('form').append('<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>');
</script>
