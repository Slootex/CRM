<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 0;

$inp_user = "";
$inp_pass = "";

$user = "";
$pass = "";

$emsg = "";

$logo = "<h3 class=\"text-white font-weight-bold\">ORDER GO</h3>";

if(isset($param['company_slug']) && $param['company_slug'] != ""){

	$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`companies`.`id` AS id, 
																`companies`.`login_slug` AS login_slug 
													FROM 		`companies` 
													WHERE 		`companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($param['company_slug'])) . "'"), MYSQLI_ASSOC);

	if(isset($row["id"]) && $row["id"] > 0){

		$page['url'] = "/" . $row['login_slug'] . $page['url'];

		$company_id = $row['id'];

	}

	$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($row['id'])) . "'"), MYSQLI_ASSOC);

	if(file_exists("uploads/company/" . $company_id . "/img/logo_login.png")){
		$logo = "<img src=\"/uploads/company/" . $company_id . "/img/logo_login.png\" width=\"120\" class=\"\" />";
	}

}

if(isset($_POST['login'])){

	if(strlen($_POST['user']) < 1 || strlen($_POST['user']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihren Benutzername eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_user = " is-invalid";
	} else {
		$user = strip_tags($_POST['user']);
	}

	if(strlen($_POST['pass']) < 1 || strlen($_POST['pass']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihren Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_pass = " is-invalid";
	} else {
		$pass = strip_tags($_POST['pass']);
	}

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
																`companies`.`name` AS company_name, 
																`companies`.`theme_id` AS theme_id, 
																`admin_roles`.`func` AS func, 
																`admin_roles`.`admin_index` AS admin_index, 
																`admin_roles`.`time_recording_login_src` AS time_recording_login_src, 
																`admin_roles`.`searchresult_rights` AS searchresult_rights, 
																`admin_roles`.`change_admin` AS change_admin 
													FROM 		`admin` 
													LEFT JOIN 	`admin_roles` 
													ON 			`admin`.`role`=`admin_roles`.`id` 
													LEFT JOIN 	`companies` 
													ON 			`companies`.`id`=`admin`.`company_id` 
													WHERE 		`admin`.`user`='" . mysqli_real_escape_string($conn, strip_tags($_POST['user'])) . "' 
													AND 		`admin`.`pass`='" . mysqli_real_escape_string($conn, strip_tags($_POST['pass'])) . "' 
													AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

	if(isset($row["id"]) && $row["id"] > 0){

		unset($_SESSION["admin"]);

		$time = time();

		$ip = strip_tags(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`ip`='" . mysqli_real_escape_string($conn, $ip) . "', 
										`admin`.`online`='1', 
										`admin`.`login_date`='" . $time . "' 
								WHERE 	`admin`.`id`='" . $row["id"] . "'");

		$_SESSION["admin"]["id"] = $row["id"];

		$_SESSION["admin"]["company_id"] = $row["company_id"];

		$_SESSION["admin"]["company_name"] = $row["company_name"];

		$_SESSION["admin"]["theme_id"] = $row["theme_id"];

		$_SESSION["admin"]["role"] = $row["role"];

		$_SESSION["admin"]["name"] = $row["name"];

		$_SESSION["admin"]["user"] = $row["user"];

		$_SESSION["admin"]["email"] = $row["email"];

		$_SESSION["admin"]["address_from"] = $row["address_from"];

		$_SESSION["admin"]["address_to"] = $row["address_to"];

		$_SESSION["admin"]["login_date"] = $time;

		$_SESSION["admin"]["ip"] = $ip;

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

		$_SESSION["admin"]["roles"]["admin_index"] = $row["admin_index"];

		$_SESSION["admin"]["roles"]["time_recording_login_src"] = $row["time_recording_login_src"];

		$_SESSION["admin"]["roles"]["searchresult_rights"] = $row["searchresult_rights"];

		$_SESSION["admin"]["roles"]["change_admin"] = $row["change_admin"];

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


		header("Location: " . $_SESSION["admin"]["roles"]["admin_index"]);
		exit();

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<br /><br /><br /><br /><br /><br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-sm-3 text-center\">\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-6 text-center\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"		<div class=\"card bg-primary\">\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0 text-left\">\n" . 
		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 text-center px-5\">\n" . 
		"							" . $logo . "\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5\">\n" . 
		"							<input type=\"text\" id=\"user\" name=\"user\" value=\"" . $user . "\" class=\"form-control" . $inp_user . " text-secondary\" placeholder=\"Benutzer\" />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5\">\n" . 
		"							<input type=\"password\" id=\"pass\" name=\"pass\" class=\"form-control" . $inp_pass . " text-secondary\" placeholder=\"Kennwort\" />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5\">\n" . 
		"							<button type=\"submit\" name=\"login\" value=\"anmelden\" class=\"btn btn-light border border-light text-primary\"><strong>Anmelden</strong></button>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5 text-right\">\n" . 
		"							<a href=\"/impressum\" class=\"text-white\" onclick=\"$('#iframeImprint').modal();return false;\">Impressum</a>&nbsp;&nbsp;&nbsp;<span class=\"text-white\">|</span>&nbsp;&nbsp;&nbsp;<a href=\"/datenschutz\" class=\"text-white\" onclick=\"$('#iframeTerms').modal();return false;\">Datenschutz</a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</form>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";

?>