<?php

require TEMPLATE_PATH."/_import.php";

$headTitle = $frame->getTitle();

?>
<?php require TEMPLATE_PATH."/parts/_doctype.html.php"; ?>
<head>
    <?php require TEMPLATE_PATH."/parts/_meta.html.php"; ?>
    <?php require TEMPLATE_PATH."/parts/_styles.html.php"; ?>
</head>
<body>
    <?php require TEMPLATE_PATH."/navigations/top/_nav.html.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php require TEMPLATE_PATH."/parts/_sidebar.html.php"; ?>
            </div>
            <div class="col-md-9">
                <?=render(TEMPLATE_PATH."/parts/_modules.html.php", [
                    'forceContainerType' => 'default',
                ])?>
            </div>
        </div>
    </div>
    <?php require TEMPLATE_PATH."/parts/_footer.html.php"; ?>
    <?php require TEMPLATE_PATH."/parts/_assets.html.php"; ?>
</body>
<?php require TEMPLATE_PATH."/parts/_end.html.php"; ?>
