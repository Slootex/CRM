<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/head.php"); ?>
<?php echo $systemdata['style_frontend']; ?>
<?php echo $page['style']; ?>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<br /><br />
			<h1>Kontakt</h1>
			<br />
<?php echo $html; ?>
<?php echo $emsg_text; ?>
			<form action="<?php echo $page['url']; ?>" method="POST">
				<div class="">
					<p>Nachricht: <span>*</span></p>
					<textarea name="nachricht" id="nachricht" cols="30" rows="4" required></textarea>
				</div>
				<div class="">
					<p>Name: <span>*</span></p>
					<input type="text" name="name" id="name" required />	
				</div>
				<div class="">
					<p>E-Mail-Adresse: <span>*</span></p>
					<input type="mail" name="email" id="email" required />	
				</div>
				<div class="">
					<p>Tel.-Nr.:<br /></p>
					<input type="text" name="number" id="number" />
				</div>
				<div class="">
					<p>Captcha: <span>*</span><br /></p>
					<div class="g-recaptcha" data-sitekey="6LclQV4bAAAAAFBfEwfk9mGjfwbXRaeBF7EaThnl" style="float: left;margin-bottom: 12px"></div>
				</div>
				<div class="">
					<p>&nbsp;<br /></p>
					<input type="submit" name="absenden" style="background:#3F99D5 none repeat scroll 0 0;border-radius: 0px;color: #ffffff;display: block;font-size: 20px;margin-left:185px;padding: 10px 15px;text-align: center;width: 137px;text-transform: uppercase;" value="Absenden" />
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo $systemdata['script_frontend']; ?>
<?php echo $page['script']; ?>
</body>
</html>