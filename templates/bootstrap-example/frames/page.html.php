<?php

$headTitle = $page['name'];

require TEMPLATE_PATH."/parts/header.html.php"; ?>

<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<?php require TEMPLATE_PATH."/parts/modules.html.php"; ?>

<?php require TEMPLATE_PATH."/parts/assets.html.php"; ?>
<?php require TEMPLATE_PATH."/parts/footer.html.php"; ?>
