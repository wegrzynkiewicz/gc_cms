<?php
    $mail->Subject = trans("Utworzyliśmy dla Ciebie konto pracownika");    
?>
<!DOCTYPE html>
<html lang="<?=getClientLang()?>">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="telephone=no" name="format-detection">
	<title>Single Column</title>
</head>
<body bgcolor="#F0F0F0">
	<table bgcolor="#F0F0F0" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center" bgcolor="#F0F0F0" style="background-color: #F0F0F0;" valign="top">
				<br>
				<table border="0" cellpadding="0" cellspacing="0" class="container" width="600">
					<tr>
						<td align="left" class="container-padding header">Antwort v1.0</td>
					</tr>
					<tr>
						<td align="left" class="container-padding content">
							<br>
							<div class="title">
								Single Column Fluid Layout
							</div><br>
							<div class="body-text">
								This is an example of a single column fluid layout. There are no columns. Because the container table width is set to 100%, it automatically resizes itself to all devices. The magic of good old fashioned HTML.<br>
								<br>
								The media query change we make is to decrease the content margin from 24px to 12px for devices up to max width of 400px.<br>
								<br>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" class="container-padding footer-text">
							<br>
							<br>
							Sample Footer text: &copy; 2015 Acme, Inc.<br>
							<br>
							You are receiving this email because you opted in on our website. Update your <a href="#">email preferences</a> or <a href="#">unsubscribe</a>.<br>
							<br>
							<strong>Acme, Inc.</strong><br>
							<span class="ios-footer">123 Main St.<br>
							Springfield, MA 12345<br></span> <a href="http://www.acme-inc.com">www.acme-inc.com</a><br>
							<br>
							<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
