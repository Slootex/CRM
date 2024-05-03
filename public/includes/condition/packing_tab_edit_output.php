<?php 

	$options_file1 = "<option value=\"0\">Bitte auswählen</option>\n";

	$options_file2 = "<option value=\"0\">Bitte auswählen</option>\n";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file1 .= "								<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_packing['file1'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

		$options_file2 .= "								<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_packing['file2'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_image').files.length;i++){sumsize+=document.getElementById('file_image').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\" for=\"message\">Zusatzbemerkungen</label>\n" . 
						"								<div class=\"col-sm-8\">\n" . 
						"									<textarea id=\"message\" name=\"message\" class=\"form-control" . $inp_message . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $message : $row_packing["message"]) . "</textarea>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"file_packing\" class=\"col-sm-4 col-form-label\">Beipackzettel</label>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<select id=\"file1\" name=\"file1\" class=\"custom-select\">" . $options_file1 . "</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<select id=\"file2\" name=\"file2\" class=\"custom-select\">" . $options_file2 . "</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"							<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>