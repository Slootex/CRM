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
<div class="container-fluid">

<?php echo $html; ?>
<?php include('includes/content/content_' . $page['id'] . '.php'); ?>

</div>
<?php echo $systemdata['script_frontend']; ?>
<?php echo $page['script']; ?>
</body>
</html>