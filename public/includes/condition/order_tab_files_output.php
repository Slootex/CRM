<?php 

	$file_types = array(
		0 => "Auftragsdokumente", 
		1 => "Undefiniert", 
		2 => "Bilder", 
		3 => "Reklamation", 
		4 => "Kundenupload", 
		5 => "Geräte-Hauptdokument", 
		6 => "Geräte-Dokumente" 
	);

	$list_files = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
									FROM 		`order_orders_files` 
									WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		(`order_orders_files`.`type`<'4' OR `order_orders_files`.`type`='5' OR `order_orders_files`.`type`='6') 
									ORDER BY 	CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

	while($row_files = $result->fetch_array(MYSQLI_ASSOC)){

		if($row_files['device_id'] > 0){
			
			$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_files['device_id'])) . "'"), MYSQLI_ASSOC);

		}

		$list_files .=	"	<tr>\n" . 
						"		<td align=\"center\"><span>" . date("d.m.Y", intval($row_files['upd_date'])) . "</span> <span class=\"text-muted\">" . date("(H:i)", intval($row_files['upd_date'])) . "</span></td>\n" . 
						"		<td>\n" . 
						"			<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\" target=\"_blank\">" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . "</a>\n" . 
						(($row_files['type'] == 5 || $row_files['type'] == 6) && $row_files['device_id'] > 0 && isset($row_device['id']) && $row_device['id'] > 0 ? 
							"			<br />\n" . 
							"			<small class=\"mute\">(" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ")</small>"
						: 
							""
						) . 
						"		</td>\n" . 
						"		<td><span>" . $row_files['admin_name'] . "</span></td>\n" . 
						"		<td><span>" . $file_types[$row_files['type']] . "</span></td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"				<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
						"				<input type=\"hidden\" name=\"item\" value=\"" . $row_files['id'] . "\" />\n" . 
						"				<div class=\"btn-group\">\n" . 
						"					<button type=\"submit\" name=\"file_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
						"					<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\" target=\"_blank\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></a>\n" . 
						"				</div>\n" . 
						"			</form>\n" . 
						"		</td>\n" . 
						"	</tr>\n";

	}

	$list_userdata = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
									FROM 		`order_orders_files` 
									WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_files`.`type`='4' 
									ORDER BY 	CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

	while($row_files = $result->fetch_array(MYSQLI_ASSOC)){

		$list_userdata .=	"	<tr>\n" . 
							"		<td align=\"center\"><span>" . date("d.m.Y", $row_files['upd_date']) . "</span> <span class=\"text-muted\">" . date("(H:i)", $row_files['upd_date']) . "</span></td>\n" . 
							"		<td><a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata/" . $row_files['file'] . "\" target=\"_blank\">" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . "</a></td>\n" . 
							"		<td><span>" . $row_files['admin_name'] . "</span></td>\n" . 
							"		<td><span>" . $file_types[$row_files['type']] . "</span></td>\n" . 
							"		<td align=\"center\">\n" . 
							"			<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"				<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"				<input type=\"hidden\" name=\"item\" value=\"" . $row_files['id'] . "\" />\n" . 
							"				<div class=\"btn-group\">\n" . 
							"					<button type=\"submit\" name=\"file_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
							"					<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata/" . $row_files['file'] . "\" target=\"_blank\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></a>\n" . 
							"				</div>\n" . 
							"			</form>\n" . 
							"		</td>\n" . 
							"	</tr>\n";

	}

	$tabs_contents .= 	($emsg_files != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_files . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-2 border-right\">\n" . 

						"						<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document').files.length;i++){sumsize+=document.getElementById('file_document').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"file_type\" class=\"col-sm-12 col-form-label\">Dateibeschreibung</label>\n" . 
						"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
						"									<select id=\"file_type\" name=\"file_type\" class=\"custom-select\">\n" . 
						"										<option value=\"\">Bitte wählen</option>\n" . 
						"										<option value=\"1\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 1 ? " selected=\"selected\"" : "") . ">Undefiniert</option>\n" . 
						"										<option value=\"0\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 0 ? " selected=\"selected\"" : "") . ">Auftragsdokumente</option>\n" . 
						"										<option value=\"2\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 2 ? " selected=\"selected\"" : "") . ">Bilder</option>\n" . 
						"										<option value=\"3\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 3 ? " selected=\"selected\"" : "") . ">Reklamation</option>\n" . 
						"										<option value=\"4\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 4 ? " selected=\"selected\"" : "") . ">Kundenupload</option>\n" . 
						//"										<option value=\"5\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 5 ? " selected=\"selected\"" : "") . ">Geräte-Hauptdokument</option>\n" . 
						//"										<option value=\"6\"" . (isset($_POST['file_type']) && intval($_POST['file_type']) == 6 ? " selected=\"selected\"" : "") . ">Geräte-Dokumente</option>\n" . 
						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
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
						"						<strong>Auftragsdaten:</strong>\n" . 

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
						"			<th width=\"80\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
						"				<strong>Aktion</strong>\n" . 
						"			</th>\n" . 
						"		</tr></thead>\n" . 

						$list_files . 

						"	</table>\n" . 
						"</div>\n" . 

						"					</div>\n" . 
						"					<div class=\"col-sm-5\">\n" . 
						"						<strong>Kundenupload:</strong>\n" . 

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
						"			<th width=\"80\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
						"				<strong>Aktion</strong>\n" . 
						"			</th>\n" . 
						"		</tr></thead>\n" . 

						$list_userdata . 

						"	</table>\n" . 
						"</div>\n" . 

						"					</div>\n" . 
						"				</div>\n" . 
						($document_open != "" ? "<script>window.open('" . $document_open . "');</script>" : "");

?>