<?php 

	$list_audio = "";

	$arr_files = explode("\r\n", $row_user['audio']);

	for($i = 0;$i < count($arr_files);$i++){
		if($arr_files[$i] != ""){

			$preview_audio = "";

			$ext = pathinfo($arr_files[$i], PATHINFO_EXTENSION);

			if(in_array($ext, array('mp3', 'm4a'))){
				$preview_audio = 	"		<audio src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/audio/" . $arr_files[$i] . "\" type=\"audio/" . $ext . "\" id=\"audio_" . $i . "\" controls=\"\" style=\"width: 100%\"></audio>\n" . 
									"		<input type=\"range\" min=\"0.5\" max=\"3.0\" step=\"0.1\" value=\"1.0\" orient=\"horizontal\" oninput=\"document.getElementById('audio_" . $i . "').playbackRate=this.value;\$('#audio_rate_" . $i . "').text(this.value)\" /> <sup id=\"audio_rate_" . $i . "\">1.0</sup>\n";
			}

			$list_audio .= 	"<div class=\"row mb-4\">\n" . 
							"	<div class=\"col-sm-6\">\n" . 
							"		" . ($i + 1) . ") <a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/audio/" . $arr_files[$i] . "\" target=\"_blank\">" . $arr_files[$i] . "</a>\n" . 
							"	</div>\n" . 
							"	<div class=\"col-sm-5\">\n" . 
							$preview_audio . 
							"	</div>\n" . 
							"	<div class=\"col-sm-1\">\n" . 
							"		<form action=\"" . $users_action . "\" method=\"post\">\n" . 
							"			<input type=\"hidden\" name=\"id\" value=\"" . $row_user['id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"item\" value=\"" . $i . "\" />\n" . 
							"			<button type=\"submit\" name=\"audio_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
							"		</form>\n" . 
							"	</div>\n" . 
							"</div>\n";
		}
	}

	$tabs_contents .= 	($emsg_audio != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_audio . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-6 border-right\">\n" . 

						"						<form action=\"" . $users_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_audio').files.length;i++){sumsize+=document.getElementById('file_audio').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"file_audio\" class=\"col-sm-12 col-form-label\">Audio Dateien hinzufügen</label>\n" . 
						"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
						"									<input type=\"file\" id=\"file_audio\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_audio_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"									<button type=\"submit\" name=\"upload_audio\" value=\"hochladen\" class=\"btn btn-primary\">hochladen <i class=\"fa fa-sign-in\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 

						"					</div>\n" . 
						"					<div class=\"col-sm-6\">\n" . 

						$list_audio . 
						
						"					</div>\n" . 
						"				</div>\n";

?>