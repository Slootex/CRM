<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}elseif(isset($param['id']) && strip_tags($param['id']) != ""){
	$_POST['id'] = intval($param['id']);
}else{
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$row_order = array();

$row_order['carid'] = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`vin_html`='" . mysqli_real_escape_string($conn, html_entity_decode($_POST['html'])) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$html = "<br />\n" . 
		"<form action=\"" . $page['url'] . "/" . intval($_POST['id']) . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12\">\n" . 
		"			<textarea id=\"edit_content\" name=\"html\" style=\"width: 100%;height: 400px\" class=\"form-control\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $_POST['html'] : htmlentities($row_order['vin_html'])) . "</textarea>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
		"			<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n" . 
		"<br />\n";

?>