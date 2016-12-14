<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=strip_tags($headTitle.' - '.$config['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
    <div id="wrapper">

        <?php require_once ACTIONS_PATH.'/admin/parts/navbar.html.php'; ?>

            <div id="page-wrapper">
                <div class="container-fluid">
