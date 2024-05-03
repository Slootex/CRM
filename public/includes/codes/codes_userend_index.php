<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

if($_SESSION["user"]["id"] < 1){
	header("Location: " . $systemdata['unuser_index']);
	exit();
}

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);

$emsg = "";

$orders = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS amount FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`user_id`='" . $_SESSION["user"]["id"] . "'"), MYSQLI_ASSOC);

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Kunden - Dashboard</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Willkommen zurück, " . $_SESSION["user"]["firstname"] . " " . $_SESSION["user"]["lastname"] . "</p>\n" . 
		"<p>Kundennummer: " . $_SESSION["user"]["user_number"] . "</p>\n" . 
		"<p>Aufträge: " . $orders['amount'] . "</p>\n" . 
		"<hr />\n" . 
		"<div class=\"card-deck mb-4\">\n" . 
		"	<div class=\"card bg-light text-dark\">\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h5 class=\"card-title\">Eigene Daten</h5>\n" . 
		"			<p class=\"card-text\">Hier können Sie ihre eigenen Daten ändern.</p>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-footer text-right\">\n" . 
		"			<a href=\"/kunden/daten\" class=\"btn btn-primary\">Mehr&nbsp;&nbsp;<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"card bg-light text-dark\">\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h5 class=\"card-title\">Kennwort ändern</h5>\n" . 
		"			<p class=\"card-text\">Hier können Sie ihr Kennwort ändern.</p>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-footer text-right\">\n" . 
		"			<a href=\"/kunden/kennwort\" class=\"btn btn-primary\">Mehr&nbsp;&nbsp;<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"card bg-light text-dark\">\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h5 class=\"card-title\">Meine Aufträge</h5>\n" . 
		"			<p class=\"card-text\">Hier können Sie ihre Aufträge einsehen.</p>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-footer text-right\">\n" . 
		"			<a href=\"/kunden/auftraege\" class=\"btn btn-primary\">Mehr&nbsp;&nbsp;<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<div class=\"card-deck mb-4\">\n" . 
		"	<div class=\"card bg-light text-dark\">\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h5 class=\"card-title\">Neuer Auftrag</h5>\n" . 
		"			<p class=\"card-text\">Hier können Sie ein neuen Auftrag erstellen.</p>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-footer text-right\">\n" . 
		"			<a href=\"/auftrag/schritt-1\" class=\"btn btn-primary\">Mehr&nbsp;&nbsp;<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"card bg-light text-dark\">\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h5 class=\"card-title\">Abmelden</h5>\n" . 
		"			<p class=\"card-text\">Hier können Sie sich abmelden.</p>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-footer text-right\">\n" . 
		"			<a href=\"/kunden/abmelden\" class=\"btn btn-primary\">Mehr&nbsp;&nbsp;<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-4\">\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br />\n" . 
		"<br />\n" . 
		"<br />\n";
	
?>