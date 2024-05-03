<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/head.php"); ?>
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
					<div class="col">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb" style="margin-bottom: 0">
								<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
								<li class="breadcrumb-item"><a href="/kunden/kennwort-wiederherstellen">Kunden</a></li>
								<li class="breadcrumb-item active">Kennwort wiederherstellen</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">

<?php echo $html; ?>
<?php include('includes/content/content_' . $page['id'] . '.php'); ?>

					</div>
				<div>

			</div>
		</div>
	</div>
</div>
<?php echo $page['script']; ?>
</body>
</html>