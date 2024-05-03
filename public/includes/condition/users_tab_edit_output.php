<?php 

	$options_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_user["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$options_admin_id = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_user["admin_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<form action=\"" . $users_action . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Rechnungsanschrift</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"companyname\" class=\"col-sm-6 col-form-label\">Firma <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Firma dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $companyname : $row_user["companyname"]) . "\" class=\"form-control" . $inp_companyname . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-6 col-form-label\">Anrede <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Anrede dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6 mt-2\">\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $_POST['gender'] : $row_user["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
						"											Herr\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $_POST['gender'] : $row_user["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
						"											Frau\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"firstname\" class=\"col-sm-6 col-form-label\">Vorname <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Vorname dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $firstname : $row_user["firstname"]) . "\" class=\"form-control" . $inp_firstname . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"lastname\" class=\"col-sm-6 col-form-label\">Nachname <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Nachname dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $lastname : $row_user["lastname"]) . "\" class=\"form-control" . $inp_lastname . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"route\" class=\"col-sm-6 col-form-label\">Straße <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Strasse dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"route\" name=\"street\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $street : $row_user["street"]) . "\" class=\"form-control" . $inp_street . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"street_number\" class=\"col-sm-6 col-form-label\">Hausnummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Hausnummer dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $streetno : $row_user["streetno"]) . "\" class=\"form-control" . $inp_streetno . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"postal_code\" class=\"col-sm-6 col-form-label\">PLZ <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Postleitzahl dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $zipcode : $row_user["zipcode"]) . "\" class=\"form-control" . $inp_zipcode . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"locality\" class=\"col-sm-6 col-form-label\">Ort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Ort dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $city : $row_user["city"]) . "\" class=\"form-control" . $inp_city . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"country\" class=\"col-sm-6 col-form-label\">Land <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Land dieses Kunden ändern\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

						$options_countries . 

						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"phonenumber\" class=\"col-sm-6 col-form-label\">Telefon <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Telefonnummer dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $phonenumber : $row_user["phonenumber"]) . "\" class=\"form-control" . $inp_phonenumber . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"mobilnumber\" class=\"col-sm-6 col-form-label\">Mobil <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Mobilnummer dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $mobilnumber : $row_user["mobilnumber"]) . "\" class=\"form-control" . $inp_mobilnumber . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"email\" class=\"col-sm-6 col-form-label\">Email <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Email-Adresse dieses Kunden ändern.\">?</span></label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $email : $row_user["email"]) . "\" class=\"form-control" . $inp_email . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"						</div>\n" . 
						"					</div>\n" . 


						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-12\">\n" . 
						"							<strong>Weitere Optionen</strong>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"admin_id\" class=\"col-sm-3 col-form-label\">Mitarbeiter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den zuständigen Mitarbeiter ändern.\">?</span></label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<select id=\"admin_id\" name=\"admin_id\" class=\"custom-select\">\n" . 

						$options_admin_id . 

						"							</select>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"ref_number\" class=\"col-sm-3 col-form-label\">Referenznummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Referenznummer dieses Kunden ändern.\">?</span></label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"text\" id=\"ref_number\" name=\"ref_number1\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $ref_number : $row_user["ref_number"]) . "\" disabled=\"desabled\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
						"							<input type=\"hidden\" id=\"ref_number1\" name=\"ref_number\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $ref_number : $row_user["ref_number"]) . "\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"password\" class=\"col-sm-3 col-form-label\">Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Kennwort dieses Kunden ändern.\">?</span></label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"text\" id=\"password\" name=\"password\" value=\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? $password : "") . "\" class=\"form-control" . $inp_password . "\" />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						
						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"							&nbsp;\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>