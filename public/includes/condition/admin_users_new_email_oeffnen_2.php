<?php 

	$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . intval($_SESSION["email_template"]["id"]) . "'"), MYSQLI_ASSOC);

	$html_new_email = 	"				<hr />\n" . 

						($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<form action=\"" . $users_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_new_email').files.length;i++){sumsize+=document.getElementById('file_document_new_email').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"new_email_subject\" class=\"col-sm-3 col-form-label\">Betreff</label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"text\" id=\"new_email_subject\" name=\"new_email_subject\" value=\"" . (isset($_POST['new_email']) && $_POST['new_email'] == "öffnen" ? $row_template['subject'] : $row_template['subject']) . "\" class=\"form-control" . $inp_new_email_subject . "\" />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"shortcode\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
						"						<label for=\"shortcode\" class=\"col-sm-2 col-form-label\">Shortcode</label>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"							<select id=\"shortcode\" name=\"shortcode\" class=\"custom-select\">\n" . 
						"								<option value=\"[id]\">Auftragsnummer</option>\n" . 
						"								<option value=\"[status_id]\">Vorgangsnummer</option>\n" . 
						"								<option value=\"[status]\">Vorgangsname</option>\n" . 
						"								<option value=\"[date]\">Datum</option>\n" . 
						
						"								<option value=\"[files]\">Dateien</option>\n" . 
						
						"								<option value=\"[call_id]\">Sipgate-Call-ID</option>\n" . 
						"								<option value=\"[orig_call_id]\">Sipgate-Orig-Call-ID</option>\n" . 
						
						"								<option value=\"[companyname]\">Firma</option>\n" . 
						"								<option value=\"[gender]\">Anrede</option>\n" . 
						"								<option value=\"[sexual]\">Sexual</option>\n" . 
						"								<option value=\"[firstname]\">Vorname</option>\n" . 
						"								<option value=\"[lastname]\">Nachname</option>\n" . 
						"								<option value=\"[street]\">Straße</option>\n" . 
						"								<option value=\"[streetno]\">Hausnummer</option>\n" . 
						"								<option value=\"[zipcode]\">Postleitzahl</option>\n" . 
						"								<option value=\"[city]\">Ort</option>\n" . 
						"								<option value=\"[country]\">Land</option>\n" . 
						"								<option value=\"[phonenumber]\">Telefonnummer</option>\n" . 
						"								<option value=\"[mobilnumber]\">Mobilnummer</option>\n" . 
						"								<option value=\"[email]\">Email</option>\n" . 
						"								<option value=\"[differing_shipping_address]\">Abweichende Lieferadresse (komplett als Tabelle)</option>\n" . 
						"								<option value=\"[differing_companyname]\">Firma - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_firstname]\">Vorname - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_lastname]\">Nachname - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_street]\">Straße - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_streetno]\">Hausnummer - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[zipcode]\">Postleitzahl - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_city]\">Ort - Abweichende Lieferadresse</option>\n" . 
						"								<option value=\"[differing_country]\">Land - Abweichende Lieferadresse</option>\n" . 
						"							</select>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-3\">\n" . 
						"							<button type=\"button\" value=\"EINFÜGEN\" class=\"btn btn-primary\" onclick=\"$('#edit_content').summernote('insertText', $('#shortcode').children('option:selected').val());\">einfügen <i class=\"fa fa-caret-square-o-down\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-12\">\n" . 
						"							<textarea id=\"edit_content\" name=\"new_email_body\" style=\"width: 100%;height: 300px\" class=\"form-control" . $inp_new_email_body . "\">" . (isset($_POST['new_email']) && $_POST['new_email'] == "öffnen" ? $row_template['body'] : $row_template['body']) . "</textarea>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label class=\"col-sm-3 col-form-label\">Keine E-Mail senden</label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"								<input type=\"checkbox\" id=\"no_email\" name=\"no_email\" value=\"1\"" . ((isset($_POST['edit']) && $_POST['edit'] == "öffnen" ? $_POST['no_email'] : $_POST['no_email']) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"								<label class=\"custom-control-label\" for=\"no_email\">\n" . 
						"									Ja\n" . 
						"								</label>\n" . 
						"							</div>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"file_document_new_email\" class=\"col-sm-3 col-form-label\">Dateien hinzufügen</label>\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<strong>Sie können 5 Dateien hochladen.</strong><br />\n" . 
						"							<input type=\"file\" id=\"file_document_new_email\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-3\" align=\"right\">\n" . 
						"							&nbsp;\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-9\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<input type=\"hidden\" name=\"email_template\" value=\"" . intval($_SESSION["email_template"]["id"]) . "\" />\n" . 
						"							<button type=\"submit\" name=\"new_email\" value=\"senden\" class=\"btn btn-primary\">senden <i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
						"							<button type=\"submit\" name=\"new_email_close\" value=\"schließen\" class=\"btn btn-warning\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>";

?>