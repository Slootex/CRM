<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$inp_user = "";
$inp_pass = "";

$user = "";
$pass = "";

$emsg = "";

$password_recover = "";

if(isset($_POST['login'])){

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['user']) && $_POST['user'] != ""){
		$user = $_POST['user'];
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihren Benutzername/Email eingeben.</span><br />\n";
		$inp_user = " is-invalid";
	}

	if(strlen($_POST['pass']) < 1 || strlen($_POST['pass']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihren Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_pass = " is-invalid";
	} else {
		$pass = strip_tags($_POST['pass']);
	}

	if($emsg == ""){

		$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`user_users`.`id` AS id, 
																	`user_users`.`user_number` AS user_number, 
																	`user_users`.`companyname` AS companyname, 
																	`user_users`.`firstname` AS firstname, 
																	`user_users`.`lastname` AS lastname, 
																	`user_users`.`email` AS email, 
																	`user_users`.`password` AS password 
														FROM 		`user_users` 
														WHERE 		`user_users`.`email`='" . mysqli_real_escape_string($conn, $user) . "' 
														AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
														AND 		`user_users`.`regverify`=1"), MYSQLI_ASSOC);

		if(isset($row["id"]) && $row["id"] > 0){

			if($row['password'] == sha1($pass)){

				$_SESSION["user"]["id"] = $row["id"];

				$_SESSION["user"]["user_number"] = $row["user_number"];

				$_SESSION["user"]["companyname"] = $row["companyname"];

				$_SESSION["user"]["firstname"] = $row["firstname"];

				$_SESSION["user"]["lastname"] = $row["lastname"];

				$_SESSION["user"]["email"] = $row["email"];

				header("Location: " . $maindata['user_index']);
				exit();

			}else{

				$password_recover = "					<div class=\"form-group row\">\n" . 
									"						<div class=\"col-sm-2\" align=\"right\">\n" . 
									"							&nbsp;\n" . 
									"						</div>\n" . 
									"						<div class=\"col-sm-6\">\n" . 
									"							<a href=\"/kunden/kennwort-wiederherstellen/" . $user . "\">Kennwort wiederherstellen</a>\n" . 
									"						</div>\n" . 
									"					</div>\n";

				$emsg .= "<span class=\"error\">Das angegebene Kennwort stimmt nicht.</span><br />\n";

				$inp_pass = " is-invalid";

			}

		}else{

			$emsg .= "<span class=\"error\">Kundenkonto mit der angegebenen Email existiert nicht.</span><br />\n";
			
		}

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<br />\n" . 
		"<div class=\"card\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<h4 class=\"mb-0\">Eingang</h4>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? $emsg : "") . 

		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"user\" class=\"col-sm-2 col-form-label\">Benutzer/Email</label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"email\" id=\"user\" name=\"user\" value=\"" . $user . "\" class=\"form-control" . $inp_user . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"pass\" class=\"col-sm-2 col-form-label\">Kennwort</label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"password\" id=\"pass\" name=\"pass\" class=\"form-control" . $inp_pass . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		$password_recover . 

		"			<div class=\"row px-0 card-footer\">\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"submit\" name=\"login\" value=\"anmelden\" class=\"btn btn-primary\" />\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-6\" align=\"right\">\n" . 
		"					&nbsp;\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";

?>