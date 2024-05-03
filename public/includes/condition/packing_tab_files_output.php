<?php 

	$list_files = "";

	$arr_files = explode("\r\n", $row_packing['files']);

	for($i = 0;$i < count($arr_files);$i++){
		if($arr_files[$i] != ""){

			$preview_image = "		<div style=\"width: 64px;height: 64px;overflow: hidden\" class=\"border border-white\"></div>\n";

			$ext = pathinfo($arr_files[$i], PATHINFO_EXTENSION);

			if(in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'tiff'))){
				$preview_image = "		<div style=\"width: 64px;height: 64px;overflow: hidden\" class=\"border border-primary\"><a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $arr_files[$i] . "\" target=\"_blank\"><img src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $arr_files[$i] . "\" width=\"64\" border=\"0\" /></a></div>\n";
			}

			$file_name = 

			$list_files .= 	"<div class=\"row mb-4\">\n" . 
							"	<div class=\"col-sm-9\">\n" . 
							"		" . ($i + 1) . ") <a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document/" . $arr_files[$i] . "\" target=\"_blank\">" . substr($arr_files[$i], strpos($arr_files[$i], "_") + 1) . "</a>\n" . 
							"	</div>\n" . 
							"	<div class=\"col-sm-2\">\n" . 
							$preview_image . 
							"	</div>\n" . 
							"	<div class=\"col-sm-1\">\n" . 
							"		<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
							"			<input type=\"hidden\" name=\"id\" value=\"" . $row_packing['id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"item\" value=\"" . $i . "\" />\n" . 
							"			<button type=\"submit\" name=\"file_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
							"		</form>\n" . 
							"	</div>\n" . 
							"</div>\n";
		}
	}

	$tabs_contents .= 	($emsg_files != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_files . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-2 border-right\">\n" . 

						"						<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document').files.length;i++){sumsize+=document.getElementById('file_document').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"file_document\" class=\"col-sm-12 col-form-label\">Dateien hinzufügen</label>\n" . 
						"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
						"									<input type=\"file\" id=\"file_document\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"									<button type=\"submit\" name=\"upload\" value=\"hochladen\" class=\"btn btn-primary\">hochladen <i class=\"fa fa-sign-in\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 

						"					</div>\n" . 
						"					<div class=\"col-sm-5 border-right\">\n" . 
						"						<strong>Packtischdaten:</strong>\n" . 

						$list_files . 

						"					</div>\n" . 
						"					<div class=\"col-sm-5\">\n" . 

						"					</div>\n" . 
						"				</div>\n" . 

						"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-12 text-right\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . $row_packing['id'] . "\" />\n" . 
						"							<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n";

?>