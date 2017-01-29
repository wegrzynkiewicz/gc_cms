<?php

$headTitle = $page['name'];

require TEMPLATE_PATH.'/parts/header.html.php'; ?>

<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">
            <?=($headTitle)?>
        </h1>
    </div>
</div>

<?=render(TEMPLATE_PATH.'/parts/module/wrapper.html.php', [
    'frame_id' => $frame_id,
    'frame' => $frame,
    'container' => true,
])?>

<?php require TEMPLATE_PATH.'/parts/assets/footer.html.php'; ?>
<?php require TEMPLATE_PATH.'/parts/footer.html.php'; ?>
