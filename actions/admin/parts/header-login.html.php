<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=($headTitle.' - '.$config['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require ACTIONS_PATH.'/admin/parts/assets/header.html.php'; ?>
    <link rel="stylesheet" href="<?=GC\Url::assets("/admin/styles/login.css")?>">

</head>
<body>
