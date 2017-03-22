<?php

require TEMPLATE_PATH."/_import.php";

$headTitle = $frame->getTitle();

?>
<?php require TEMPLATE_PATH."/_parts/doctype.html.php"; ?>
<head>
    <?php require TEMPLATE_PATH."/_parts/meta.html.php"; ?>
    <?php require TEMPLATE_PATH."/_parts/styles.html.php"; ?>
</head>
<body>
    <?php require TEMPLATE_PATH."/navigations/top/nav.html.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php require TEMPLATE_PATH."/_parts/sidebar.html.php"; ?>
            </div>
            <div class="col-md-9">
                <?=render(TEMPLATE_PATH."/_parts/modules.html.php", [
                    'forceContainerType' => 'default',
                ])?>
            </div>
        </div>
    </div>
    <?php require TEMPLATE_PATH."/_parts/footer.html.php"; ?>
    <?php require TEMPLATE_PATH."/_parts/assets.html.php"; ?>
</body>
<?php require TEMPLATE_PATH."/_parts/end.html.php"; ?>
