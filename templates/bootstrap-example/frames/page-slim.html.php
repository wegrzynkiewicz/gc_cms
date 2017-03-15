<?php

$headTitle = $frame['name'];

?>
<?php require TEMPLATE_PATH.'/_parts/header.html.php'; ?>

<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">
            <?=$headTitle?>
        </h1>
    </div>

    <?=__FILE__?>
</div>

<?php require TEMPLATE_PATH.'/_parts/assets.html.php'; ?>
<?php require TEMPLATE_PATH.'/_parts/footer.html.php'; ?>
