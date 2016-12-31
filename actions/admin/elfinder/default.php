<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

        <?php require ACTIONS_PATH.'/admin/parts/assets/header.html.php'; ?>

        <style>
            body{
                margin:0; padding:0;
            }
        </style>
	</head>
	<body>

		<div id="elfinder"></div>

        <?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

		<script>
			$(function() {
				$('#elfinder').elfinder({
                     height: $(window).height()-2,
                     url: '<?=GC\Url::make('/admin/elfinder/connector')?>',
                     lang: '<?=getClientLang()?>',
				});
			});
		</script>

	</body>
</html>
