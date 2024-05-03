<?php 

	$show_autocomplete_script = 1;

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (intval($country) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (intval($differing_country) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
	}

	$html .= 	"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card rounded-0\">\n" . 
				"			<div class=\"card-header border-bottom border-primary p-0\">\n" . 

				$pagination . 

				"			</div>\n" . 
				"			<div class=\"card-body bg-primary px-3 pt-3 pb-0\">\n" . 
				"				<div class=\"form-group row\">\n" . 
				"					<div class=\"col-sm-12 px-5\">\n" . 
				"						<div class=\"form-group row\">\n" . 
				"							<div class=\"col-sm-12 px-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"				<form action=\"/auftrag/" . $steps[$i]['slug'] . "\" method=\"post\" enctype=\"multipart/form-data\" class=\"mb-0\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12 px-5\">\n" . 
				"							<div class=\"form-group row alert-primary text-dark\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Ich beauftrage als</label>\n" . 
				"								<div class=\"col-sm-6 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"order_as_0\" name=\"order_as\" value=\"0\"" . ($order_as == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"$('#company').hide()\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"order_as_0\">\n" . 
				"											Privatperson\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"order_as_1\" name=\"order_as\" value=\"1\"" . ($order_as == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"$('#company').show()\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"order_as_1\">\n" . 
				"											Unternehmen\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12 px-5 py-3 alert-primary text-dark\">\n" . 

				"									<div id=\"company\" class=\"form-group row\" style=\"" . ($order_as == 0 ? "display: none;" : "") . "\">\n" . 
				"										<label for=\"companyname\" class=\"col-sm-6 col-form-label\">Firma *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Anrede</label>\n" . 
				"										<div class=\"col-sm-6 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ($gender == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"													Herr\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ($gender == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"													Frau\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Name *</label>\n" . 
				"										<div class=\"col-sm-3\">\n" . 
				"											<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-3\">\n" . 
				"											<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"email\" class=\"col-sm-6 col-form-label\">Email *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"phonenumber\" class=\"col-sm-6 col-form-label\">Telefon</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Telefon\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"mobilnumber\" class=\"col-sm-6 col-form-label\">Mobil</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"route\" class=\"col-sm-6 col-form-label\">Adresse *</label>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('route')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-2\">\n" . 
				"											<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"postal_code\" class=\"col-sm-6 col-form-label\">&nbsp;</label>\n" . 
				"										<div class=\"col-sm-2\">\n" . 
				"											<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('postal_code')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('locality')\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"country\" class=\"col-sm-6 col-form-label\">&nbsp;</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"											</select>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Abweichende Rücksendeanschrift</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"												<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ($differing_shipping_address == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
				"													Ja\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div id=\"differing_shipping_address_hide\" class=\"" . ($differing_shipping_address == 1 ? "d-block" : "d-none") . "\">\n" . 

				"									<div id=\"differing_company\" class=\"form-group row\">\n" . 
				"										<label for=\"differing_companyname\" class=\"col-sm-6 col-form-label\">Firma</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . $differing_companyname . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Anrede</label>\n" . 
				"										<div class=\"col-sm-6 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ($differing_gender == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
				"													Herr\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ($differing_gender == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
				"													Frau\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"differing_firstname\" class=\"col-sm-6 col-form-label\">Name</label>\n" . 
				"										<div class=\"col-sm-3\">\n" . 
				"											<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . $differing_firstname . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-3\">\n" . 
				"											<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . $differing_lastname . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"differing_route\" class=\"col-sm-6 col-form-label\">Adresse</label>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"differing_route\" name=\"differing_street\" value=\"" . $differing_street . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('differing_route')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-2\">\n" . 
				"											<input type=\"text\" id=\"differing_street_number\" name=\"differing_streetno\" value=\"" . $differing_streetno . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"differing_postal_code\" class=\"col-sm-6 col-form-label\">&nbsp;</label>\n" . 
				"										<div class=\"col-sm-2\">\n" . 
				"											<input type=\"text\" id=\"differing_postal_code\" name=\"differing_zipcode\" value=\"" . $differing_zipcode . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('differing_postal_code')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"differing_locality\" name=\"differing_city\" value=\"" . $differing_city . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('differing_locality')\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"differing_country\" class=\"col-sm-6 col-form-label\">&nbsp;</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 

				$options_differing_countries . 

				"											</select>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer bg-primary\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<input type=\"hidden\" name=\"run_date\" value=\"" . intval($run_date) . "\" />\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"WEITER\" class=\"btn btn-lg btn-danger mr-3\">Weiter zu Schritt 2</button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";


?>