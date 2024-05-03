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

$inp_firstname = "";
$inp_lastname = "";

$firstname = "";
$lastname = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihr Name eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihr Zuname eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "' 
								WHERE 	`user_users`.`id`='" . $_SESSION["user"]["id"] . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		$emsg = "<p>Ihre Daten wurden erfolgreich geändert!<p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`user_users`.`id` AS id, 
															`user_users`.`firstname` AS firstname, 
															`user_users`.`lastname` AS lastname,  
															`user_users`.`email` AS email,  
															`user_users`.`user_number` AS user_number  
												FROM 		`user_users` 
												WHERE 		`user_users`.`id`='" . mysqli_real_escape_string($conn, $_SESSION["user"]["id"]) . "' 
												AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

if(isset($row["id"]) && $row["id"] > 0){

	$_SESSION["user"]["id"] = $row["id"];

	$_SESSION["user"]["firstname"] = $row["firstname"];

	$_SESSION["user"]["lastname"] = $row["lastname"];

	$_SESSION["user"]["email"] = $row["email"];

	$_SESSION["user"]["user_number"] = $row["user_number"];

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Kunden - Eigene Daten</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie ihre Daten ändern.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"card card-maximize bg-" . $row_admin["bgcolor_card"] . " text-" . $row_admin["color_card"] . "\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<h4 class=\"mb-0\">Eigene Daten ändern</h4>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"firstname\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-primary\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihr Name ändern.\">?</span></label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $firstname : strip_tags($row["firstname"])) . "\" class=\"form-control" . $inp_firstname . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"lastname\" class=\"col-sm-3 col-form-label\">Zuname <span class=\"badge badge-pill badge-primary\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihr Kennwort ändern.\">?</span></label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $lastname : strip_tags($row["lastname"])) . "\" class=\"form-control" . $inp_lastname . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"			<div class=\"row px-0 card-footer\">\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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