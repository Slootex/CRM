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

$inp_password = "";
$inp_password2 = "";

$password = "";
$password2 = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['password']) < 1 || strlen($_POST['password']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password = " is-invalid";
	} else {
		$password = strip_tags($_POST['password']);
	}

	if(strlen($_POST['password2']) < 1 || strlen($_POST['password2']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort wiederholt eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password2 = " is-invalid";
	} else {
		if($_POST['password'] != $_POST['password2']){
			$emsg .= "<span class=\"error\">Die Kennwörter sind unterschiedlich.</span><br />\n";
			$inp_password = " is-invalid";
			$inp_password2 = " is-invalid";
		} else {
			$password2 = strip_tags($_POST['password2']);
		}
	}

	if($emsg == ""){

		mysqli_query($conn, "UPDATE 	`user_users` 
								SET 	`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($password)) . "' 
								WHERE 	`user_users`.`id`='" . $_SESSION["user"]["id"] . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		$emsg = "<p>Ihr Kennwort wurde erfolgreich geändert!<p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`user_users`.`id` AS id, 
															`user_users`.`firstname` AS firstname, 
															`user_users`.`lastname` AS lastname,  
															`user_users`.`email` AS email,  
															`user_users`.`user_number` AS user_number  
												FROM 		`user_users` 
												WHERE 		`user_users`.`id`='" . mysqli_real_escape_string($conn, $_SESSION["user"]["id"]) . "' 
												AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Kunden - Kennwort ändern</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie ihr Kennwort ändern.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"card card-maximize bg-" . $row_admin["bgcolor_card"] . " text-" . $row_admin["color_card"] . "\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<h4 class=\"mb-0\">Kennwort ändern</h4>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"password\" class=\"col-sm-3 col-form-label\">Kennwort <span class=\"badge badge-pill badge-primary\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihr Kennwort ändern.\">?</span></label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"password\" id=\"password\" name=\"password\" value=\"\" class=\"form-control" . $inp_password . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"password2\" class=\"col-sm-3 col-form-label\">Kennwort wiederholen <span class=\"badge badge-pill badge-primary\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Geben Sie hier ihr Kennwort wiederholt ein.\">?</span></label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"password\" id=\"password2\" name=\"password2\" value=\"\" class=\"form-control" . $inp_password2 . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"			<div class=\"row px-0 card-footer\">\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\" />\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-6\" align=\"right\">\n" . 
		"					&nbsp;\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"		</form>\n" . 

		"	</div>\n" . 
		"</div>\n" . 
		"<br />\n" . 
		"<br />\n" . 
		"<br />\n";
	
?>