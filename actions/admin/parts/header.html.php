<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=($headTitle.' - '.GC\Container::get('config')['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require ACTIONS_PATH.'/admin/parts/assets/header.html.php'; ?>
</head>
<body>
    <div id="wrapper">
        <?php require ACTIONS_PATH.'/admin/parts/navbar/main.html.php'; ?>
            <div id="page-wrapper">
