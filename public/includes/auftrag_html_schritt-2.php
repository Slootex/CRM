<?php 

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$options_component .= "								<option value=\"" . $row['id'] . "\"" . (intval($component) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
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

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12 px-5 py-3 alert-primary text-dark\">\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12 text-secondary\">\n" . 
				"											<h3>Fahrzeugdaten</h3>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"machine\" class=\"col-sm-6 col-form-label\">Automarke *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . $machine . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"model\" class=\"col-sm-6 col-form-label\">Automodell *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"model\" name=\"model\" value=\"" . $model . "\" class=\"form-control" . $inp_model . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"constructionyear\" class=\"col-sm-6 col-form-label\">Baujahr *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . $constructionyear . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"carid\" class=\"col-sm-6 col-form-label\">Fahrzeug-Identifizierungsnummer</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . strtoupper($carid) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"kw\" class=\"col-sm-6 col-form-label\">Fahrleistung (PS)</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . $kw . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"mileage\" class=\"col-sm-6 col-form-label\">Kilometerstand</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<div class=\"input-group\">\n" . 
				"												<input type=\"number\" id=\"mileage\" name=\"mileage\" value=\"" . $mileage . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
				"												<div class=\"input-group-addon\">\n" . 
				"													<span>KM</span>\n" . 
				"												</div>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Getriebe</label>\n" . 
				"										<div class=\"col-sm-6 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ($mechanism == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
				"													Schaltung\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ($mechanism == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
				"													Automatik\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Kraftstoffart</label>\n" . 
				"										<div class=\"col-sm-6 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ($fuel == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
				"													Benzin\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ($fuel == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
				"													Diesel\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12 text-secondary\">\n" . 
				"											<h3>Gerätedaten</h3>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"component\" class=\"col-sm-6 col-form-label\">Defektes Bauteil *</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"												<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"											</select>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"manufacturer\" class=\"col-sm-6 col-form-label\">Gerätehersteller</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . $manufacturer . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"serial\" class=\"col-sm-6 col-form-label\">Geräte Teilenummer</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . $serial . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-6 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"										<div class=\"col-sm-6 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ($fromthiscar == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fromthiscar_yes\">\n" . 
				"													Ja\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline\">\n" . 
				"												<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ($fromthiscar == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fromthiscar_no\">\n" . 
				"													Nein\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12 text-secondary\">\n" . 
				"											<h3>Fehlerbeschreibung</h3>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"reason\" class=\"col-sm-6 col-form-label\">Fehlerursache/welche Funktionen gehen nicht? *</label>\n" . 
				"										<div class=\"col-sm-6 text-right\">\n" . 
				"											<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . $reason . "</textarea>\n" . 
				"											<small>(<span id=\"reason_length\">" . strlen($reason) . "</span> von 700 Zeichen)</small>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"description\" class=\"col-sm-6 col-form-label\">Was wurde bereits am Fahrzeug gemacht? *<br />Fehlerspeicher ausgelesen (Code/Text)?</label>\n" . 
				"										<div class=\"col-sm-6 text-right\">\n" . 
				"											<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . $description . "</textarea>\n" . 
				"											<small>(<span id=\"description_length\">" . strlen($description) . "</span> von 700 Zeichen)</small>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12 text-secondary\">\n" . 
				"											<h3>Datenupload</h3>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"file_document\" class=\"col-sm-6 col-form-label\">Dateien von der Festplatte hinzufügen</label>\n" . 
				"										<div class=\"col-sm-6\">\n" . 
				"											<strong>Sie können 5 Dateien hochladen.</strong><br />\n" . 
				"											" . (isset($_SESSION['form'][$steps[$i]['slug']]['file']['file_1']) && file_exists('temp/' . $_SESSION['form'][$steps[$i]['slug']]['file']['file_1']) ? "<small class=\"text-muted\">1. " . $_SESSION['form'][$steps[$i]['slug']]['file']['file_1'] . "</small><br />\n" : "") . 
				"											" . (isset($_SESSION['form'][$steps[$i]['slug']]['file']['file_2']) && file_exists('temp/' . $_SESSION['form'][$steps[$i]['slug']]['file']['file_2']) ? "<small class=\"text-muted\">2. " . $_SESSION['form'][$steps[$i]['slug']]['file']['file_2'] . "</small><br />\n" : "") . 
				"											" . (isset($_SESSION['form'][$steps[$i]['slug']]['file']['file_3']) && file_exists('temp/' . $_SESSION['form'][$steps[$i]['slug']]['file']['file_3']) ? "<small class=\"text-muted\">3. " . $_SESSION['form'][$steps[$i]['slug']]['file']['file_3'] . "</small><br />\n" : "") . 
				"											" . (isset($_SESSION['form'][$steps[$i]['slug']]['file']['file_4']) && file_exists('temp/' . $_SESSION['form'][$steps[$i]['slug']]['file']['file_4']) ? "<small class=\"text-muted\">4. " . $_SESSION['form'][$steps[$i]['slug']]['file']['file_4'] . "</small><br />\n" : "") . 
				"											" . (isset($_SESSION['form'][$steps[$i]['slug']]['file']['file_5']) && file_exists('temp/' . $_SESSION['form'][$steps[$i]['slug']]['file']['file_5']) ? "<small class=\"text-muted\">5. " . $_SESSION['form'][$steps[$i]['slug']]['file']['file_5'] . "</small><br />\n" : "") . 
				"											<input type=\"file\" id=\"file_document\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer bg-primary\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<a href=\"/auftrag/schritt-1\" class=\"btn btn-lg btn-danger ml-3\">Zurück zu Schritt 1</a>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"WEITER\" class=\"btn btn-lg btn-danger mr-3\">Weiter zu Schritt 3\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";


?>