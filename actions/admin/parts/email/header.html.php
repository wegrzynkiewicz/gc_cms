<!DOCTYPE html>
<html lang="<?=getVisitorLang()?>">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="telephone=no" name="format-detection">
	<title><?=e($mail->Subject)?></title>
</head>
<body bgcolor="#F0F0F0">
	<table bgcolor="#F0F0F0" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center" bgcolor="#F0F0F0" style="background-color: #F0F0F0;" valign="top">
				<br>
                <br>
				<table border="0" cellpadding="0" cellspacing="0" class="container" width="600">
					<tr>
						<td align="left" class="container-padding header">
                            <?=trans($config['mailer']['headerTitle'])?>
                        </td>
					</tr>
					<tr>
						<td align="left" class="container-padding content">
							<br>
