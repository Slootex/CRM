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
	<br />
	<h1>ORDER GO - <?php echo $page['title']; ?></h1>
	<br />
	<div class="row">
		<div class="col-md-12">
			<div class="container">

				<div class="row">
					<div class="col-sm-9">
						<h1>Suche</h1>
						<br />

<?php echo $html; ?>
<?php include('includes/content/content_' . $page['id'] . '.php'); ?>

					</div>
					<div class="col-sm-3">
				
						<h2><u>Sitemap</u>:</h2>
						<i class="fa fa-angle-right fa-fw"></i><a href="/">Homepage</a><br />
						<i class="fa fa-angle-right fa-fw"></i><a href="/kontakt">Kontakt</a><br />
						<i class="fa fa-angle-right fa-fw"></i><a href="/impressum">Impressum</a><br />
						<i class="fa fa-angle-right fa-fw"></i><a href="/datenschutz">Datenschutz</a><br />

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<?php echo $systemdata['script_frontend']; ?>
<?php echo $page['script']; ?>
</body>
</html>