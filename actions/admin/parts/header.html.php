<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
    <meta charset="utf-8" >
	<title><?=($headTitle.' - '.$config['adminHeadTitleBase'])?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
</head>
<body>
    <div id="wrapper">

        <?php require_once ACTIONS_PATH.'/admin/parts/navbar.html.php'; ?>

            <div id="page-wrapper">
                <div class="container-fluid">
