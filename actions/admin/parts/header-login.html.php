<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=($headTitle.' - '.$config['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require ACTIONS_PATH.'/admin/parts/assets/header.html.php'; ?>

    <style media="screen">
        body {
            background-image: url('http://unsplash.it/1920/1080/?random');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }
        .panel {
            box-shadow: 0 0 30px rgba(0,0,0,1);
        }
    </style>

</head>
<body>
