<?php 

	$parameter['link'] = "neuer-einkauf";

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

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"font-weight-bold mb-0\">Einkauferfassung</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $shopping_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_add').files.length;i++){sumsize+=document.getElementById('file_document_add').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

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
				"									<strong>Einkaufsdaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"order_number\">Auftragsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"order_number\" name=\"order_number\" value=\"" . $order_number . "\" class=\"form-control" . $inp_order_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"item_number\">Externe Auftragsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"item_number\" name=\"item_number\" value=\"" . $item_number . "\" class=\"form-control" . $inp_item_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Lieferanten</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_0\" name=\"suppliers\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['suppliers']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_0\">\n" . 
				"											eBAY\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_1\" name=\"suppliers\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['suppliers']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_1\">\n" . 
				"											Allegro\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_2\" name=\"suppliers\" value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['suppliers']) : 0) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_2\">\n" . 
				"											Webseite\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_3\" name=\"suppliers\" value=\"3\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['suppliers']) : 0) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_3\">\n" . 
				"											Amazon\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_4\" name=\"suppliers\" value=\"4\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['suppliers']) : 0) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_4\">\n" . 
				"											Technik\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"supplier\">Lieferant</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"supplier\" name=\"supplier\" value=\"" . $supplier . "\" class=\"form-control" . $inp_supplier . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"description\">Beschreibung</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"description\" name=\"description\" value=\"" . $description . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"contact_emails\">Angeschrieben</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"number\" id=\"contact_emails\" name=\"contact_emails\" min=\"0\" max=\"10000\" step=\"1\" value=\"" . $contact_emails . "\" class=\"form-control" . $inp_contact_emails . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"info\">Info</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"info\" name=\"info\" value=\"" . $info . "\" class=\"form-control" . $inp_info . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"price\">Preis</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<input type=\"text\" id=\"price\" name=\"price\" value=\"" . number_format($price, 2, ',', '') . "\" class=\"form-control" . $inp_price . "\" />\n" . 
				"										<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_0\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['radio_payment']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_0\">\n" . 
				"											PayPal\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_1\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['radio_payment']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_1\">\n" . 
				"											Kreditkarte\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_2\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['radio_payment']) : 0) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_2\">\n" . 
				"											Überweisung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_3\" name=\"radio_payment\" value=\"3\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['radio_payment']) : 0) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_3\">\n" . 
				"											Rechnung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_4\" name=\"radio_payment\" value=\"4\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['radio_payment']) : 0) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_4\">\n" . 
				"											Storniert\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"url\">Link</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"url\" name=\"url\" value=\"" . $url . "\" class=\"form-control" . $inp_url . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"file_image\">Screenshot (*.pdf)</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"file\" id=\"file_image\" name=\"file_image\" accept=\".pdf\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"email\">Lieferant E-Mail</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"phonenumber\">Lieferant Telefon</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"faxnumber\">Lieferant Fax</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"faxnumber\" name=\"faxnumber\" value=\"" . $faxnumber . "\" class=\"form-control" . $inp_faxnumber . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Retoure Versand</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_0\" name=\"retoure_carrier\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['retoure_carrier']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_0\">\n" . 
				"											DHL\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_1\" name=\"retoure_carrier\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['retoure_carrier']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_1\">\n" . 
				"											UPS\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_2\" name=\"retoure_carrier\" value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['retoure_carrier']) : 0) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_2\">\n" . 
				"											Hermes\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_3\" name=\"retoure_carrier\" value=\"3\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['retoure_carrier']) : 0) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_3\">\n" . 
				"											DPD\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
					"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_4\" name=\"retoure_carrier\" value=\"4\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['retoure_carrier']) : 0) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_4\">\n" . 
				"											TNT\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"shipping_id\">Sendungsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"shipping_id\" name=\"shipping_id\" value=\"" . $shipping_id . "\" class=\"form-control" . $inp_shipping_id . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				
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