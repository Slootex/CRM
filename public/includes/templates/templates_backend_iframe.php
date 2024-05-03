<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/admin_head.php"); ?>
<?php echo $page['style']; ?>
<?php echo $_SESSION["admin"]["style"]; ?>
<?php echo $maindata['style_backend']; ?>
</head>
<body>
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
<?php echo $html; ?>
			</div>
		</div>
	</div>
</section>
<?php echo $page['script']; ?>
</body>
</html>