<?php 

	$file_types = array(
		0 => "Auftragsaufnahmen", 
		1 => "Undefiniert", 
		2 => "Heimlich", 
		3 => "Reklamation"
	);

	$list_audio = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_audios`.`admin_id`) AS admin_name 
									FROM 		`order_orders_audios` 
									WHERE 		`order_orders_audios`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_audios`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_audios`.`type`<'4' 
									ORDER BY 	CAST(`order_orders_audios`.`upd_date` AS UNSIGNED) ASC");

	while($row_audios = $result->fetch_array(MYSQLI_ASSOC)){

		$preview_audio = "";

		$speed_audio = "";

		$speed_value = "";

		$ext = pathinfo($row_audios['file'], PATHINFO_EXTENSION);

		if(in_array($ext, array('mp3', 'm4a'))){

			$preview_audio = "			<audio src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/" . $row_audios['file'] . "\" type=\"audio/" . $ext . "\" id=\"audio_" . $row_audios['id'] . "\" controls=\"\" style=\"height: 20px;width: 100%;margin: 4px 0 0 0\"></audio>\n";

			$speed_audio = "			<input type=\"range\" min=\"0.5\" max=\"3.0\" step=\"0.1\" value=\"1.0\" orient=\"horizontal\" oninput=\"document.getElementById('audio_" . $row_audios['id'] . "').playbackRate=this.value;\$('#audio_rate_" . $row_audios['id'] . "').text(parseFloat(this.value).toFixed(1))\" />\n";

			$speed_value = "			<span id=\"audio_rate_" . $row_audios['id'] . "\">1.0</span>\n";

		}

		$list_audio .=	"	<tr>\n" . 
						"		<td align=\"center\"><span>" . date("d.m.Y", $row_audios['upd_date']) . "</span> <span class=\"text-muted\">" . date("(H:i)", $row_audios['upd_date']) . "</span></td>\n" . 
						"		<td><span><a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/" . $row_audios['file'] . "\" target=\"_blank\">" . substr($row_audios['file'], strpos($row_audios['file'], "_") + 1) . "</a></span></td>\n" . 
						"		<td><span>" . $row_audios['admin_name'] . "</span></td>\n" . 
						"		<td><span>" . $file_types[$row_audios['type']] . "</span></td>\n" . 
						"		<td>\n" . 

						$preview_audio . 

						"		</td>\n" . 
						"		<td>\n" . 

						$speed_audio . 

						"		</td>\n" . 
						"		<td align=\"center\">\n" . 

						$speed_value . 

						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"				<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
						"				<input type=\"hidden\" name=\"item\" value=\"" . $row_audios['id'] . "\" />\n" . 
						"				<div class=\"btn-group\">\n" . 
						"					<button type=\"submit\" name=\"audio_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
						"					<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/" . $row_audios['file'] . "\" target=\"_blank\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></a>\n" . 
						"				</div>\n" . 
						"			</form>\n" . 
						"		</td>\n" . 
						"	</tr>\n";

	}

	$tabs_contents .= 	($emsg_audio != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_audio . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-2 border-right\">\n" . 

						"						<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_audio').files.length;i++){sumsize+=document.getElementById('file_audio').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"file_type\" class=\"col-sm-12 col-form-label\">Dateibeschreibung</label>\n" . 
						"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
						"									<select id=\"file_type\" name=\"file_type\" class=\"custom-select\">\n" . 
						"										<option value=\"\">Bitte wählen</option>\n" . 
						"										<option value=\"1\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 1 ? " selected=\"selected\"" : "") . ">Undefiniert</option>\n" . 
						"										<option value=\"0\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 0 ? " selected=\"selected\"" : "") . ">Auftragsaufnahmen</option>\n" . 
						"										<option value=\"2\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 2 ? " selected=\"selected\"" : "") . ">Heimlich</option>\n" . 
						"										<option value=\"3\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 3 ? " selected=\"selected\"" : "") . ">Reklamation</option>\n" . 
						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
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
						"					<div class=\"col-sm-10\">\n" . 

						"<div class=\"table-responsive\">\n" . 
						"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"			<th width=\"150\" scope=\"col\">\n" . 
						"				<strong>Datum</strong>\n" . 
						"			</th>\n" . 
						"			<th scope=\"col\">\n" . 
						"				<strong>Dateiname</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"160\" scope=\"col\">\n" . 
						"				<strong>Mitarbeiter</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"180\" scope=\"col\">\n" . 
						"				<strong>Beschreibung</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"360\" scope=\"col\">\n" . 
						"				<strong>Kontroll</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"180\" scope=\"col\">\n" . 
						"				<strong>Speed</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"30\" scope=\"col\">\n" . 
						"				<strong>Wert</strong>\n" . 
						"			</th>\n" . 
						"			<th width=\"80\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
						"				<strong>Aktion</strong>\n" . 
						"			</th>\n" . 
						"		</tr></thead>\n" . 

						$list_audio . 

						"	</table>\n" . 
						"</div>\n" . 
						
						"					</div>\n" . 
						"				</div>\n";

?>