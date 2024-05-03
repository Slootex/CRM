<?php 

	$parameter['link'] = "neuer-Packtisch";

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

	$options_file12 = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file12 .= "								<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"font-weight-bold mb-0\">Packtischerfassung</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_add').files.length;i++){sumsize+=document.getElementById('file_document_add').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

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
				"									<strong>Packtischdaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"order_number\">Auftragsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"order_number\" name=\"order_number\" value=\"" . $order_number . "\" class=\"form-control" . $inp_order_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"message\">Zusatzbemerkungen</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<textarea id=\"message\" name=\"description\" class=\"form-control" . $inp_message . "\">" . $message . "</textarea>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 


				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_packing\" class=\"col-sm-4 col-form-label\">Beipackzettel</label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"file1\" name=\"file1\" class=\"custom-select\">" . $options_file12 . "</select>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"file2\" name=\"file2\" class=\"custom-select\">" . $options_file12 . "</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_packing\" class=\"col-sm-4 col-form-label\">Dateien</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"file\" id=\"file_packing\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
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