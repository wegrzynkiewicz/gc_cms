<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=($headTitle.' - '.$config['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require_once ACTIONS_PATH.'/admin/parts/header-assets.html.php'; ?>
</head>
<body>
    <div id="wrapper">

        <?php require_once ACTIONS_PATH.'/admin/parts/navbar.html.php'; ?>

            <div id="page-wrapper">
                <div class="container-fluid">
