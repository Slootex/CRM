<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "logindata";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

function writeHtpasswd($conn){

	$data = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin_roles`.`name` AS name FROM `admin_roles` WHERE `admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin_roles`.`id`=`admin`.`role`) AS role_name 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`role` AS UNSIGNED) ASC, CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row_admin = $result->fetch_array(MYSQLI_ASSOC)){

		$encrypted_password = password_hash($row_admin['pass'], PASSWORD_BCRYPT);
		 
		$data .= $row_admin['user'] . ":" . $encrypted_password . "\n";

	}

	$f = fopen("includes/.htpasswd", "w");
	fwrite($f, $data);
	fclose($f);

}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_user = "";
$inp_pass = "";

$user = "";
$pass = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['user']) < 1 || strlen($_POST['user']) > 16){
		$emsg .= "<span class=\"error\">Bitte Ihren Benutzernamen eingeben. (max. 16 Zeichen)</span><br />\n";
		$inp_user = " is-invalid";
	} else {
		$user = strip_tags($_POST['user']);
	}

	if(strlen($_POST['pass']) < 1 || strlen($_POST['pass']) > 16){
		$emsg .= "<span class=\"error\">Bitte Ihren Kennwort eingeben. (max. 16 Zeichen)</span><br />\n";
		$inp_pass = " is-invalid";
	} else {
		$pass = strip_tags($_POST['pass']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`user`='" . mysqli_real_escape_string($conn, $user) . "', 
										`admin`.`pass`='" . mysqli_real_escape_string($conn, $pass) . "' 
								WHERE 	`admin`.`id`='" . $_SESSION["admin"]["id"] . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		//writeHtpasswd($conn);

		$emsg = "<p>Die Zugangsdaten wurden erfolgreich geändert!<p>\n";
	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`admin`.`id` AS id, 
															`admin`.`company_id` AS company_id, 
															`admin`.`role` AS role, 
															`admin`.`name` AS name, 
															`admin`.`user` AS user, 
															`admin`.`email` AS email, 
															`admin`.`address_from` AS address_from, 
															`admin`.`address_to` AS address_to, 
															`admin`.`ip` AS ip, 
															`admin`.`full_width` AS full_width, 
															`admin`.`bgcolor_header_footer` AS bgcolor_header_footer, 
															`admin`.`border_header_footer` AS border_header_footer, 
															`admin`.`bgcolor_navbar_burgermenu` AS bgcolor_navbar_burgermenu, 
															`admin`.`bgcolor_badge` AS bgcolor_badge, 
															`admin`.`bgcolor_sidebar` AS bgcolor_sidebar, 
															`admin`.`bgcolor_card` AS bgcolor_card, 
															`admin`.`color_card` AS color_card, 
															`admin`.`bgcolor_table` AS bgcolor_table, 
															`admin`.`bgcolor_table_head` AS bgcolor_table_head, 
															`admin`.`color_table_head` AS color_table_head, 
															`admin`.`color_link` AS color_link, 
															`admin`.`color_text` AS color_text, 
															`admin`.`bgcolor_select` AS bgcolor_select, 
															`admin`.`color_select` AS color_select, 
															`admin`.`border_select` AS border_select, 
															`admin`.`style` AS style, 
															`admin`.`max_orders_target` AS max_orders_target, 
															`admin_roles`.`func` AS func, 
															`admin_roles`.`time_recording_login_src` AS time_recording_login_src, 
															`admin_roles`.`searchresult_rights` AS searchresult_rights 
												FROM 		`admin` 
												LEFT JOIN 	`admin_roles` 
												ON 			`admin`.`role`=`admin_roles`.`id` 
												WHERE 		`admin`.`id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "' 
												AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($row["id"]) && $row["id"] > 0){

	$_SESSION["admin"]["id"] = $row["id"];

	$_SESSION["admin"]["company_id"] = $row["company_id"];

	$_SESSION["admin"]["role"] = $row["role"];

	$_SESSION["admin"]["name"] = $row["name"];

	$_SESSION["admin"]["user"] = $row["user"];

	$_SESSION["admin"]["email"] = $row["email"];

	$_SESSION["admin"]["address_from"] = $row["address_from"];

	$_SESSION["admin"]["address_to"] = $row["address_to"];

	$_SESSION["admin"]["ip"] = $row["ip"];

	$_SESSION["admin"]["full_width"] = $row["full_width"];

	$_SESSION["admin"]["bgcolor_header_footer"] = $row["bgcolor_header_footer"];

	$_SESSION["admin"]["border_header_footer"] = $row["border_header_footer"];

	$_SESSION["admin"]["bgcolor_navbar_burgermenu"] = $row["bgcolor_navbar_burgermenu"];

	$_SESSION["admin"]["bgcolor_badge"] = $row["bgcolor_badge"];

	$_SESSION["admin"]["bgcolor_sidebar"] = $row["bgcolor_sidebar"];

	$_SESSION["admin"]["bgcolor_card"] = $row["bgcolor_card"];

	$_SESSION["admin"]["color_card"] = $row["color_card"];

	$_SESSION["admin"]["bgcolor_table"] = $row["bgcolor_table"];

	$_SESSION["admin"]["bgcolor_table_head"] =  $row["bgcolor_table_head"];

	$_SESSION["admin"]["color_table_head"] =  $row["color_table_head"];

	$_SESSION["admin"]["color_link"] = $row["color_link"];

	$_SESSION["admin"]["color_text"] = $row["color_text"];

	$_SESSION["admin"]["bgcolor_select"] =  $row["bgcolor_select"];

	$_SESSION["admin"]["color_select"] =  $row["color_select"];

	$_SESSION["admin"]["border_select"] =  $row["border_select"];

	$_SESSION["admin"]["style"] =  $row["style"];

	$_SESSION["admin"]["max_orders_target"] = $row["max_orders_target"];

	$_SESSION["admin"]["roles"] = array();

	$_SESSION["admin"]["roles"]["func"] = $row["func"];

	$_SESSION["admin"]["roles"]["time_recording_login_src"] = $row["time_recording_login_src"];

	$_SESSION["admin"]["roles"]["searchresult_rights"] = $row["searchresult_rights"];

	$result = mysqli_query($conn, "	SELECT 		`rights`.`authorization` AS authorization 
									FROM 		`admin_role_rights` 
									LEFT JOIN 	`rights` 
									ON 			`rights`.`id`=`admin_role_rights`.`right_id` 
									WHERE 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($row["company_id"])) . "' 
									AND 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($row["role"])) . "' 
									AND 		`admin_role_rights`.`enable`='1' 
									ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row_rights = $result->fetch_array(MYSQLI_ASSOC)){

		$_SESSION["admin"]["roles"][$row_rights['authorization']] = 1;

	}

}

$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . intval($_SESSION["admin"]["id"]) . "'"), MYSQLI_ASSOC);

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Zugangsdaten</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Geben Sie hier ihre gewünschten Zugangsdaten ein.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Zugangsdaten ändern</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"user\" class=\"col-sm-3 col-form-label\">Benutzername <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihren Benutzername ändern.\">?</span></label>\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<input type=\"text\" id=\"user\" name=\"user\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $user : strip_tags($row_admin["user"])) . "\" class=\"form-control" . $inp_user . "\" />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"pass\" class=\"col-sm-3 col-form-label\">Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihr Kennwort ändern.\">?</span></label>\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<input type=\"text\" id=\"pass\" name=\"pass\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $pass : strip_tags($row_admin["pass"])) . "\" class=\"form-control" . $inp_pass . "\" />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"row px-0 card-footer\">\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-sm-6\" align=\"right\">\n" . 
		"							&nbsp;\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</form>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"<br /><br /><br />\n";
			
?>