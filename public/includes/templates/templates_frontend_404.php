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
			<h1>Fehler 404</h1>
			<p>Die gewünschte Seite konnte leider nicht gefunden werden:</p>
			<p>Leider konnte die von Ihnen angegebene Seite nicht gefunden werden. Sie existiert nicht oder ist zur Zeit nicht erreichbar. Bitte versuchen Sie es zu einem späteren Zeitpunkt erneut. Bitte entschuldigen Sie eventuell Unannehmlichkeiten.</p>
			<br />
			<p>Nutzen Sie unseren Wegweiser, um in die ORDER GO Webseite und Ihre einzelnen Bereiche einzusteigen.</p>
			<br />
			<div class="contact_form_area">
				<h2>Fehler melden</h2>
				<?php if($emsg_text != ""){ ?><p><?php echo $emsg_text; ?></p><?php } ?>
	
				<div class="contact_form_">
					<form action="<?php echo $page['url']; ?>" method="POST">
						<div class="name_ clearfix">
							<p>Name: <span>*</span></p>
							<input type="text" name="name" id="name" required />	
						</div>
						<div class="email_ clearfix">
							<p>E-Mail-Adresse: <span>*</span></p>
							<input type="mail" name="email" id="email" required />	
						</div>
						<div class="mach clearfix">
							<p>Nachricht: <span>*</span></p>
							<textarea name="nachricht" id="nachricht" cols="30" rows="4" required></textarea>
						</div>
						<div class="Antwort clearfix">
							<p>Captcha: <span>*</span><br /></p>
							<div class="g-recaptcha" data-sitekey="6LclQV4bAAAAAFBfEwfk9mGjfwbXRaeBF7EaThnl" style="float: left;margin-bottom: 12px"></div>
						</div>
						<div class="Antwort clearfix">
							<p>&nbsp;<br /></p>
							<input type="submit" name="absenden" style="background:#3F99D5 none repeat scroll 0 0;border-radius: 0px;color: #ffffff;display: block;font-size: 20px;margin-left:185px;padding: 10px 15px;text-align: center;width: 137px;text-transform: uppercase;" value="Absenden" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $systemdata['script_frontend']; ?>
<?php echo $page['script']; ?>
</body>
</html>