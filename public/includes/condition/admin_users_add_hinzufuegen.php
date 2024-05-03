<?php 

	$show_autocomplete_script = 1;

	$options_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['country']) && $_POST['country'] == $row['id'] ? " selected=\"selected\"" : "") : ($row['id'] == 1 ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"font-weight-bold mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $users_action . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"ref_number\" class=\"col-sm-3 col-form-label\">Referenznummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Referensnummer des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"ref_number\" name=\"ref_number\" value=\"" . $ref_number . "\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"companyname\" class=\"col-sm-3 col-form-label\">Firma * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Firmenname des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Anrede <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Anrede des Kunden an.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"									Herr\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"									Frau\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"firstname\" class=\"col-sm-3 col-form-label\">Vorname * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Vorname des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"lastname\" class=\"col-sm-3 col-form-label\">Nachname * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Nachname des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"route\" class=\"col-sm-3 col-form-label\">Straße * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Straßenname des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"street_number\" class=\"col-sm-3 col-form-label\">Hausnummer * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Hausnummer des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"streetno\" name=\"street_number\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"postal_code\" class=\"col-sm-3 col-form-label\">PLZ * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Postleitzahl des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"locality\" class=\"col-sm-3 col-form-label\">Ort * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Ort des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"country\" class=\"col-sm-3 col-form-label\">Land <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie das Land des Kunden aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"phonenumber\" class=\"col-sm-3 col-form-label\">Telefon <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Telefonnummer des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"mobilnumber\" class=\"col-sm-3 col-form-label\">Mobil <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Mobilnummer des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email\" class=\"col-sm-3 col-form-label\">Email * <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Email-Adresse des Kunden ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" />\n" . 
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
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

?>