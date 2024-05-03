<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/user_head.php"); ?>
<?php echo $page['style']; ?>
</head>
<body>
<div id="header" class="bg-<?php echo $row_admin["bgcolor_header_footer"]; ?> border-bottom border-<?php echo $row_admin["border_header_footer"]; ?> mb-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<nav class="navbar navbar-expand-lg navbar-dark p-0">
					<?php if($maindata['logo_url'] != ""){ ?><a href="<?php echo $maindata['logo_url']; ?>"<?php echo $maindata['logo_url'] == "#" ? " onclick=\"toggleFullscreen()\"" : ""; ?>><img src="/img/admin_gzamotors_logo.png" alt="GZA MOTORS" style="width: 32px;margin: 2px" /></a><?php } ?>
					<a href="/" style="font-size: 1rem" class="navbar-brand text-<?php echo $row_admin["color_link"]; ?> p-0">Zurück zu GZA motors</a>
					<button type="button" style="padding: 0 4px" class="navbar-toggler bg-<?php echo $row_admin["bgcolor_navbar_burgermenu"]; ?> rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="navbar_1" class="navbar-collapse collapse justify-content-end">
						<ul id="menu-1" class="navbar-nav mr-0">
							<li class="nav-item"><span class="nav-link text-success pr-0">Willkommen, <?php echo $_SESSION["user"]["firstname"] . " " . $_SESSION["user"]["lastname"]; ?></span></li>
							<li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-<?php echo $_SESSION["admin"]["color_link"]; ?>"><?php echo $_SESSION["admin"]["name"] ?></a></li>
						</ul>
						<span class="text-<?php echo $_SESSION["admin"]["color_text"]; ?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
						<ul id="menu-1" class="navbar-nav mr-0">
							<li class="nav-item dropdown">
								<a href="#" title="Admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-<?php echo $row_admin["color_link"]; ?> py-1"><u>Einstellungen</u></a>
								<ul class="dropdown-menu" role="menu">
									<li class="nav-item"><a href="/kunden/dashboard" title="Startseite" class="dropdown-item">Dashboard</a></li>
									<li class="nav-item"><a href="/kunden/daten" title="Eigene Daten" class="dropdown-item">Eigene Daten</a></li>
									<li class="nav-item"><a href="/kunden/kennwort" title="Kennwort ändern" class="dropdown-item bg-<?php echo $row_admin["color_link"]; ?> active">Kennwort ändern</a></li>
									<li class="nav-item"><a href="/kunden/auftraege" title="Meine Aufträge" class="dropdown-item">Meine Aufträge</a></li>
									<li class="nav-item"><a href="/auftrag/schritt-1" title="Neuer Auftrag" class="dropdown-item">Neuer Auftrag</a></li>
								</ul>
							</li>
							<li class="nav-item"><a href="/kunden/abmelden" title="Abmelden" class="nav-link text-<?php echo $row_admin["color_link"]; ?> py-1">Abmelden</a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
</div>
<section>
	<div class="<?php echo $row_admin["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<?php include("includes/user_alert.php"); ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">

<?php echo $html; ?>
<?php include('includes/content/content_' . $page['id'] . '.php'); ?>

			</div>
		</div>
	</div>
</section>
<?php include("includes/user_footer.php");?>
<?php include("includes/user_script.php"); ?>
<?php echo $page['script']; ?>
</body>
</html>