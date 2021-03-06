<?php require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

        <?php require ROUTES_PATH."/admin/parts/_assets.html.php"; ?>

        <style>
            body{
                margin:0; padding:0;
            }
        </style>
	</head>
	<body>

		<div id="elfinder"></div>

        <?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

		<script>
			$(function() {
				$('#elfinder').elfinder({
                     height: $(window).height()-2,
                     url: '<?=$uri->make($config['elfinder']['uri'])?>',
                     lang: '<?=getVisitorLang()?>',
				});
			});
		</script>

	</body>
</html>
