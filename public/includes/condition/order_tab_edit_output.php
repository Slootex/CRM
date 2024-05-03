<?php 

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern") || (isset($_POST['intern']) && $_POST['intern'] == "speichern") ? (intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern") || (isset($_POST['intern']) && $_POST['intern'] == "speichern") ? (intval($_POST['differing_country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["differing_country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$options_creator_id = "";
	$options_admin_id = "";
	$options_agent_id = "";

	$creator_name = "Noch nicht zugewiesen";
	$admin_name = "";
	$agent_name = "Noch nicht zugewiesen";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_creator_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['creator_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["creator_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["admin_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_agent_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['agent_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["agent_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if(intval($row_order["creator_id"]) == $row['id']){
			$creator_name = $row['name'];
		}
		if(intval($row_order["admin_id"]) == $row['id']){
			$admin_name = $row['name'];
		}
		if(intval($row_order["agent_id"]) == $row['id']){
			$agent_name = $row['name'];
		}
	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Rechnungsanschrift</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $companyname : $row_order["companyname"]) . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4 mt-2\">\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
						"											Herr\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
						"											Frau\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $firstname : $row_order["firstname"]) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $lastname : $row_order["lastname"]) . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-9\">\n" . 
						"									<input type=\"text\" id=\"route\" name=\"street\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $street : $row_order["street"]) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('route')\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $streetno : $row_order["streetno"]) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $zipcode : $row_order["zipcode"]) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('postal_code')\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $city : $row_order["city"]) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('locality')\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 
						$options_countries . 
						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : $row_order["email"]) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<div class=\"input-group date\">\n" . 
						"										<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $mobilnumber : $row_order["mobilnumber"]) . "\" class=\"form-control d-none" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
						"										<div id=\"mobilnumber_text\" style=\"position: relative;flex: 1 1 auto;height: calc(1.5em + .75rem + 2px);border: 1px solid #ced4da;border-radius: .25rem 0 0 .25rem;\"><div class=\"m-2\"><span>" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $mobilnumber : $row_order["mobilnumber"]) . "</span></div></div>\n" . 
						"									    <div class=\"input-group-append\">\n" . 
						"											<button type=\"button\" class=\"btn btn-primary\" onclick=\"\$('#mobilnumber').toggleClass('d-normal d-none');\$('#mobilnumber_text').toggleClass('d-normal d-none');\$('#mobilnumber_button').toggleClass('fa-pencil fa-eye');\" role=\"button\"><i id=\"mobilnumber_button\" class=\"fa fa-pencil\"> </i></button>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<div class=\"input-group date\">\n" . 
						"										<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $phonenumber : $row_order["phonenumber"]) . "\" class=\"form-control d-none" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
						"										<div id=\"phonenumber_text\" style=\"position: relative;flex: 1 1 auto;height: calc(1.5em + .75rem + 2px);border: 1px solid #ced4da;border-radius: .25rem 0 0 .25rem;\"><div class=\"m-2\"><span>" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $phonenumber : $row_order["phonenumber"]) . "</span></div></div>\n" . 
						"									    <div class=\"input-group-append\">\n" . 
						"											<button type=\"button\" class=\"btn btn-primary\" onclick=\"\$('#phonenumber').toggleClass('d-normal d-none');\$('#phonenumber_text').toggleClass('d-normal d-none');\$('#phonenumber_button').toggleClass('fa-pencil fa-eye');\" role=\"button\"><i id=\"phonenumber_button\" class=\"fa fa-pencil\"> </i></button>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Andere Lieferadresse</label>\n" . 
						"								<div class=\"col-sm-7\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div id=\"differing_shipping_address_hide\" class=\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? "d-block" : "d-none") . "\">\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-12\">\n" . 
						"										<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_companyname : $row_order["differing_companyname"]) . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
						"												Herr\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
						"												Frau\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_firstname : $row_order["differing_firstname"]) . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_lastname : $row_order["differing_lastname"]) . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-9\">\n" . 
						"										<input type=\"text\" id=\"differing_route\" name=\"differing_street\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_street : $row_order["differing_street"]) . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('differing_route')\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-3\">\n" . 
						"										<input type=\"text\" id=\"differing_street_number\" name=\"differing_streetno\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_streetno : $row_order["differing_streetno"]) . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_postal_code\" name=\"differing_zipcode\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_zipcode : $row_order["differing_zipcode"]) . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('differing_postal_code')\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_locality\" name=\"differing_city\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_city : $row_order["differing_city"]) . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('differing_locality')\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 
						$options_differing_countries . 
						"										</select>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Weitere Optionen</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"creator_id\" class=\"col-sm-4 col-form-label\">Ersteller</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<select id=\"creator_id_1\" name=\"creator_id\" class=\"custom-select" . ($_SESSION["admin"]["roles"]["change_admin"] == 1 ? "" : " d-none") . "\">\n" . 

						$options_creator_id . 

						"									</select>\n" . 
						"									<input type=\"text\" id=\"creator_id\" name=\"creator_id_1\" value=\"" . $creator_name . "\" disabled=\"disabled\" class=\"form-control" . ($_SESSION["admin"]["roles"]["change_admin"] == 1 ? " d-none" : "") . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"admin_id\" class=\"col-sm-4 col-form-label\">Zuletzt bearbeitet</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<select id=\"admin_id_1\" name=\"admin_id\" class=\"custom-select d-none\">\n" . 

						$options_admin_id . 

						"									</select>\n" . 
						"									<input type=\"text\" id=\"admin_id\" name=\"admin_id_1\" value=\"" . $admin_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"admin_id\" class=\"col-sm-4 col-form-label\">Agent</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<select id=\"agent_id_1\" name=\"agent_id\" class=\"custom-select d-none\">\n" . 

						$options_agent_id . 

						"									</select>\n" . 
						"									<input type=\"text\" id=\"agentn_id\" name=\"agent_id_1\" value=\"" . $agent_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"ref_number\" class=\"col-sm-4 col-form-label\">Referenznummer</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"text\" id=\"ref_number\" name=\"ref_number1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $ref_number : $row_order["ref_number"]) . "\" disabled=\"disabled\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
						"									<input type=\"hidden\" id=\"ref_number1\" name=\"ref_number\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $ref_number : $row_order["ref_number"]) . "\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"ref_number\" class=\"col-sm-4 col-form-label\">Datum</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"text\" id=\"date\" name=\"date\" value=\"" . date("d.m.Y", $row_status_time_first['time']) . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"call_date\" class=\"col-sm-4 col-form-label\">Termin</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"input-group date\">\n" . 
						"										<input type=\"text\" id=\"datepicker\" name=\"call_date\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? date("d.m.Y", intval($call_date)) : date("d.m.Y", intval($row_order["call_date"]))) . "\" placeholder=\"00.00.0000\" class=\"form-control" . $inp_call_date . "\" />\n" . 
						"									    <div class=\"input-group-append\">\n" . 
						"											<span class=\"input-group-text\">Datum</span>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Terminzeit</label>\n" . 
						"								<label class=\"col-sm-2 col-form-label\">" . $row_order["call_from"] . "</label>\n" . 
						"								<label class=\"col-sm-1 col-form-label text-center\">-</label>\n" . 
						"								<label class=\"col-sm-2 col-form-label\">" . $row_order["call_to"] . "</label>\n" . 
						"								<label class=\"col-sm-1 col-form-label\">Uhr</label>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"pricemwst\" class=\"col-sm-4 col-form-label\">Reparaturfreigabe bis</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"input-group\">\n" . 
						"										<input type=\"hidden\" id=\"pricemwst_1\" name=\"pricemwst\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($pricemwst, 2, ',', '') : number_format($row_order["pricemwst"], 2, ',', '')) . "\" />\n" . 
						"										<input type=\"text\" id=\"pricemwst\" name=\"pricemwst_1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($pricemwst, 2, ',', '') : number_format($row_order["pricemwst"], 2, ',', '')) . "\" class=\"form-control" . $inp_pricemwst . "\" disabled=\"disabled\" />\n" . 
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
							"										<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_shipping_standart\">\n" . 
							"											Standard\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : intval($row_order["radio_shipping"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_shipping_express\">\n" . 
							"											Express\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"radio_shipping_international\" name=\"radio_shipping\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_shipping_international\">\n" . 
							"											International\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline\">\n" . 
							"										<input type=\"radio\" id=\"radio_shipping_self\" name=\"radio_shipping\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_shipping_self\">\n" . 
							"											Abholung\n" . 
							"										</label>\n" . 
							"									</div>\n" : 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 0 ? "									Expressversand<input type=\"hidden\" name=\"radio_shipping\" value=\"0\" />\n" : "") . 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 1 ? "									Standardversand<input type=\"hidden\" name=\"radio_shipping\" value=\"1\" />\n" : "") . 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 2 ? "									International<input type=\"hidden\" name=\"radio_shipping\" value=\"2\" />\n" : "") . 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 3 ? "									Abholung<input type=\"hidden\" name=\"radio_shipping\" value=\"3\" />\n" : "")
						) . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
						"								<div class=\"col-sm-8 mt-2\">\n" . 
						(
							$_SESSION["admin"]["roles"]["payment_edit"] == 1 ? 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_payment_nachnahme\">\n" . 
							"											Nachnahme\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_payment_ueberweisung\">\n" . 
							"											Überweisung\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline\">\n" . 
							"										<input type=\"radio\" id=\"radio_payment_bar\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_payment_bar\">\n" . 
							"											Bar\n" . 
							"										</label>\n" . 
							"									</div>\n" : 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 0 ? "									Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)<input type=\"hidden\" name=\"radio_payment\" value=\"0\" />\n" : "") . 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 1 ? "									Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"1\" />\n" : "") . 
							((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 2 ? "									Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"2\" />\n" : "")
						) . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Letzte Zahlung</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									" . (!isset($row_last_paying['id']) ? "noch keine" : ($row_last_paying['payed'] == 1 && $row_last_paying['shipping'] == 1 ? "bezahlt und versendet" : ($row_last_paying['payed'] == 1 && $row_last_paying['shipping'] == 0 ? "bezahlt" : "nicht bezahlt"))) . "\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>