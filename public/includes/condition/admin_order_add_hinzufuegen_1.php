<?php 

	$show_autocomplete_script = 1;

	$parameter['link'] = "neuer-auftrag";

	$options_admin_id = "";

	$admin_name = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : ($_SESSION["admin"]["id"] == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['admin_id']) : $_SESSION["admin"]["id"]) == $row['id']){
			$admin_name = $row['name'];
		}
	}

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['component']) && $_POST['component'] == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";
	}

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['country']) && $_POST['country'] == $row['id'] ? " selected=\"selected\"" : "") : ($row['id'] == 1 ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['differing_country']) && $_POST['differing_country'] == $row['id'] ? " selected=\"selected\"" : "") : ($row['id'] == 1 ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"font-weight-bold mb-0\">Auftragserfassung</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_add').files.length;i++){sumsize+=document.getElementById('file_document_add').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"date\" class=\"col-sm-2 col-form-label\">Datum</label>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<input type=\"text\" id=\"date\" name=\"date_1\" value=\"" . date("d.m.Y", time()) . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-1\">\n" . 
				"								</div>\n" . 
				"								<label for=\"admin_id\" class=\"col-sm-2 col-form-label\">Mitarbeiter</label>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<select id=\"admin_id_1\" name=\"admin_id\" class=\"custom-select d-none\">\n" . 

				$options_admin_id . 

				"									</select>\n" . 
				"									<input type=\"text\" id=\"admin_id\" name=\"admin_id_1\" value=\"" . $admin_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-1\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Rechnungsanschrift</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"											Herr\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"											Frau\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-9\">\n" . 
				"									<input type=\"text\" id=\"route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('route')\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('postal_code')\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('locality')\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Andere Lieferadresse</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ($differing_shipping_address == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div id=\"differing_shipping_address_hide\" class=\"" . ($differing_shipping_address == 1 ? "d-block" : "d-none") . "\">\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-12\">\n" . 
				"										<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . $differing_companyname . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4 mt-2\">\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
				"												Herr\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
				"												Frau\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . $differing_firstname . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . $differing_lastname . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-9\">\n" . 
				"										<input type=\"text\" id=\"differing_route\" name=\"differing_street\" value=\"" . $differing_street . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('differing_route')\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-3\">\n" . 
				"										<input type=\"text\" id=\"differing_street_number\" name=\"differing_streetno\" value=\"" . $differing_streetno . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_postal_code\" name=\"differing_zipcode\" value=\"" . $differing_zipcode . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('differing_postal_code')\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_locality\" name=\"differing_city\" value=\"" . $differing_city . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('differing_locality')\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 

				$options_differing_countries . 

				"										</select>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"pricemwst\" class=\"col-sm-4 col-form-label\">Reparaturfreigabe bis</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<input type=\"text\" id=\"pricemwst\" name=\"pricemwst\" value=\"" . number_format($pricemwst, 2, ',', '') . "\" class=\"form-control" . $inp_pricemwst . "\" />\n" . 
				"										<div class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">&euro;</span>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				(
					$_SESSION["admin"]["roles"]["shipping_edit"] == 1 ? 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"										<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ($radio_shipping == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_shipping_standart\">\n" . 
					"											Standard\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"										<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ($radio_shipping == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_shipping_express\">\n" . 
					"											Express\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"										<input type=\"radio\" id=\"radio_shipping_international\" name=\"radio_shipping\" value=\"2\"" . ($radio_shipping == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_shipping_international\">\n" . 
					"											International\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline\">\n" . 
					"										<input type=\"radio\" id=\"radio_shipping_self\" name=\"radio_shipping\" value=\"3\"" . ($radio_shipping == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_shipping_self\">\n" . 
					"											Abholung\n" . 
					"										</label>\n" . 
					"									</div>\n" : 
					($radio_shipping == 0 ? "									Expressversand<input type=\"hidden\" name=\"radio_shipping\" value=\"0\" />\n" : "") . 
					($radio_shipping == 1 ? "									Standardversand<input type=\"hidden\" name=\"radio_shipping\" value=\"1\" />\n" : "") . 
					($radio_shipping == 2 ? "									International<input type=\"hidden\" name=\"radio_shipping\" value=\"2\" />\n" : "") . 
					($radio_shipping == 3 ? "									Abholung<input type=\"hidden\" name=\"radio_shipping\" value=\"3\" />\n" : "")
				) . 

				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				(
					$_SESSION["admin"]["roles"]["payment_edit"] == 1 ? 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"										<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ($radio_payment == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_payment_nachnahme\">\n" . 
					"											Nachnahme\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"										<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ($radio_payment == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_payment_ueberweisung\">\n" . 
					"											Überweisung\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline\">\n" . 
					"										<input type=\"radio\" id=\"radio_payment_bar\" name=\"radio_payment\" value=\"2\"" . ($radio_payment == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"radio_payment_bar\">\n" . 
					"											Bar\n" . 
					"										</label>\n" . 
					"									</div>\n" : 
					($radio_payment == 0 ? "									Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)<input type=\"hidden\" name=\"radio_payment\" value=\"0\" />\n" : "") . 
					($radio_payment == 1 ? "									Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"1\" />\n" : "") . 
					($radio_payment == 2 ? "									Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"2\" />\n" : "")
				) . 

				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Fahrzeugdaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"machine\" class=\"col-sm-4 col-form-label\">Automarke</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . $machine . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"model\" class=\"col-sm-4 col-form-label\">Automodell</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"model\" name=\"model\" value=\"" . $model . "\" class=\"form-control" . $inp_model . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"constructionyear\" class=\"col-sm-4 col-form-label\">Baujahr</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . $constructionyear . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"carid\" class=\"col-sm-4 col-form-label\">FIN / VIN</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . strtoupper($carid) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"kw\" class=\"col-sm-4 col-form-label\">Fahrleistung (PS)</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . $kw . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"mileage\" class=\"col-sm-4 col-form-label\">Kilometerstand</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group date\">\n" . 
				"										<input type=\"text\" id=\"mileage\" name=\"mileage\" value=\"" . number_format(intval($mileage), 0, '', '.') . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
				"									    <span class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">KM</span>\n" . 
				"										</span>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Getriebe</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ($mechanism == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
				"											Schaltung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ($mechanism == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
				"											Automatik\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Kraftstoffart</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ($fuel == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
				"											Benzin\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ($fuel == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
				"											Diesel\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\"><h5>Mit Gerät ?</h5></label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<button type=\"button\" name=\"switch_device\" value=\"yes_no\" class=\"btn btn-success\" onclick=\"\$('#with_device').slideToggle(0)\">öffnen <i class=\"fa fa-chevron-down\" aria-hidden=\"true\"></i></button>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div id=\"with_device\" style=\"display: none\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Gerätedaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"component\" class=\"col-sm-4 col-form-label\">Defektes Bauteil</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"										<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"manufacturer\" class=\"col-sm-4 col-form-label\">Hersteller</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . $manufacturer . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"serial\" class=\"col-sm-4 col-form-label\">Teile.-/Herstellernummer</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . $serial . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ($fromthiscar == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_yes\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ($fromthiscar == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_no\">\n" . 
				"											Nein\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Fehlerbeschreibung</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"reason\" class=\"col-sm-4 col-form-label\">Fehlerursache</label>\n" . 
				"								<div class=\"col-sm-8 text-right\">\n" . 
				"									<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . $reason . "</textarea>\n" . 
				"									<small>(<span id=\"reason_length\">" . strlen($reason) . "</span> von 700 Zeichen)</small>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"description\" class=\"col-sm-4 col-form-label\">Fehlerspeicher</label>\n" . 
				"								<div class=\"col-sm-8 text-right\">\n" . 
				"									<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . $description . "</textarea>\n" . 
				"									<small>(<span id=\"description_length\">" . strlen($description) . "</span> von 700 Zeichen)</small>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_document_add\" class=\"col-sm-12 col-form-label\">Datenupload</label>\n" . 
				"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
				"									<input type=\"file\" id=\"file_document_add\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"run_date\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['run_date']) : time()) . "\" />\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>