<!DOCTYPE html>
<html lang="<?=getVisitorLang()?>">
<head>
    <meta charset="utf-8">
	<title><?=$headTitle.' - '.$config['adminHeadTitleBase']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require ROUTES_PATH."/admin/parts/_assets.html.php"; ?>
</head>
<body>
    <div id="wrapper">
        <?=render(ROUTES_PATH."/admin/parts/navbar/_main.html.php")?>
        <div id="page-wrapper">
