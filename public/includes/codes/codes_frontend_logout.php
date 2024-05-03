<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

if($_SESSION["admin"]["id"] < 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$logo = "<h3 class=\"text-white font-weight-bold\">ORDER GO</h3>";

if(isset($maindata['id']) && intval($maindata['id']) > 0){
	$logo = "<img src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/img/logo_login.png\" width=\"120\" class=\"\" />";
}

$row_company = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`companies`.`id` AS id, 
																	`companies`.`login_slug` AS login_slug 
														FROM 		`companies` 
														WHERE 		`companies`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

mysqli_query($conn, "	UPDATE 	`admin` 
						SET 	`admin`.`online`='0' 
						WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "' 
						AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

$http_user_agent = strip_tags($_SERVER['HTTP_USER_AGENT']);

mysqli_query($conn, "	INSERT 	`admin_login_history` 
						SET 	`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
								`admin_login_history`.`name`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["name"]) . "', 
								`admin_login_history`.`admin_id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "', 
								`admin_login_history`.`ip`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["ip"]) . "', 
								`admin_login_history`.`http_user_agent`='" . mysqli_real_escape_string($conn, $http_user_agent) . "', 
								`admin_login_history`.`login_date`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["login_date"]) . "', 
								`admin_login_history`.`logout_date`='" . mysqli_real_escape_string($conn, time()) . "'");

session_destroy();

unset($_SESSION);

$html = "<br /><br /><br /><br /><br /><br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-sm-3 text-center\">\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-6 text-center\">\n" . 
		"		<div class=\"card bg-primary\">\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0 text-left\">\n" . 
		"				<form action=\"/" . $row_company['login_slug'] . "/admin\" method=\"post\">\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 text-center px-5\">\n" . 
		"							" . $logo . "\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5\">\n" . 
		"							<input type=\"text\" id=\"user\" name=\"user\" value=\"\" class=\"form-control text-secondary\" placeholder=\"Benutzer\" />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-12 px-5\">\n" . 
		"							<input type=\"password\" id=\"pass\" name=\"pass\" class=\"form-control text-secondary\" placeholder=\"Kennwort\" />\n" . 
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