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
<?php echo $row_design["style"]; ?>
<?php echo $maindata['style_backend']; ?>
</head>
<body>
<div id="header" class="bg-<?php echo $row_design["bgcolor_header_footer"]; ?> border-bottom border-<?php echo $row_design["border_header_footer"]; ?> mb-3">
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<nav class="navbar navbar-expand-lg navbar-<?php echo $row_design["bgcolor_header_footer"]; ?> p-0">
					<?php if($maindata['logo_url'] != ""){ ?><a href="<?php echo $maindata['logo_url']; ?>"<?php echo $maindata['logo_url'] == "#" ? " onclick=\"toggleFullscreen()\"" : ""; ?>><img src="/uploads/company/<?php echo intval($_SESSION["admin"]["company_id"]); ?>/img/logo_backend.png" alt="Logo" style="width: 32px;margin: 2px" /></a><?php } ?>
					<?php 
						$navigation = new navigation($conn, 2, "order_orders");
						echo $navigation->show();
					?>
					<button type="button" style="padding: 0 4px" class="navbar-toggler bg-<?php echo $row_design["bgcolor_navbar_burgermenu"]; ?> rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="navbar_1" class="navbar-collapse collapse justify-content-end">
						<ul id="menu-1" class="navbar-nav mr-0">
							<li class="nav-item"><span class="nav-link text-<?php echo $row_design["color_text"]; ?> pr-0">Willkommen, <?php echo $_SESSION["admin"]["company_name"]; ?> - </span></li>
							<li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-<?php echo $row_design["color_link"]; ?>"><?php echo $_SESSION["admin"]["name"] ?></a></li>
						</ul>
						<span class="text-<?php echo $row_design["color_text"]; ?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
						<ul id="menu-1" class="navbar-nav mr-0">
							<?php 
								$navigation = new navigation($conn, 1, "order_orders");
								echo $navigation->show();
							?>
							<li class="nav-item"><a href="<?php echo $maindata['logout_index']; ?>" title="Abmelden" class="nav-link text-<?php echo $row_design["color_link"]; ?> py-1">Abmelden <sup id="autologout"></sup></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
</div>
<section>
	<div class="<?php echo $row_design["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<?php include("includes/admin_alert.php"); ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
<?php echo $html; ?>
			</div>
		</div>
	</div>
</section>
<?php include("includes/admin_footer.php"); ?>
<?php include("includes/admin_script.php"); ?>
<?php echo $page['script']; ?>
<?php echo $maindata['script_backend_activate'] == 1 ? $maindata['script_backend'] : ""; ?>
</body>
</html>