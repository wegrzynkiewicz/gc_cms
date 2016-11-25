<?php
Staff::createFromSession()->redirectIfUnauthorized();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

        <style>
            body{
                margin:0; padding:0;
            }
        </style>
	</head>
	<body>

		<div id="elfinder"></div>

        <?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

		<script>
			$(document).ready(function() {
				$('#elfinder').elfinder({
                     height: $(window).height()-2,
				});
			});
		</script>

	</body>
</html>
