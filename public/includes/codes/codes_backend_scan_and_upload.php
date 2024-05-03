<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "scan_and_upload";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$company = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	`companies`.`login_slug` AS login_slug 
													FROM 	`companies` 
													WHERE 	`companies`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$_SESSION['active_folder'] = isset($_POST['active_folder']) && $_POST['active_folder'] != "" ? strip_tags($_POST['active_folder']) : (isset($_SESSION['active_folder']) ? $_SESSION['active_folder'] : "img");

$emsg = "";

$path = "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/";

$folders = array();

$result = mysqli_query($conn, "	SELECT 		`folders`.`name` AS name,  
											`folders`.`description` AS description,  
											`folders`.`folder` AS folder, 
											`folders`.`erasable` AS erasable, 
											`folders`.`enable_uploads` AS enable_uploads 
								FROM 		`folders` 
								ORDER BY 	CAST(`folders`.`pos` AS UNSIGNED) ASC");

while($row_folders = $result->fetch_array(MYSQLI_ASSOC)){

	$folders[$row_folders['folder']] = $row_folders;

}

$lists = array();

$menulinks = "";

$contents = "";

$time = time();

$none_file_accept = explode(",", str_replace(".", "", str_replace(", ", ",", $systemdata['none_file_accept'])));

if(isset($_POST['distribute']) && $_POST['distribute'] == "verteilen"){

	$folder_scan = $path . "scan/";

	$handle = opendir($folder_scan);

	$allowed_documents = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	$allowed_audios = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_audio_accept'])));

	while(false !== ($entry = readdir($handle))){

		if($entry != "." && $entry != ".." && $entry != ".htaccess"){

			$filedata = explode(".", $entry);

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT id, mode, order_number, audio, files FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . $filedata[0] . "'"), MYSQLI_ASSOC);

			if(isset($row_order['id']) && $row_order['id'] > 0){

				$random = rand(1, 100000);

				if(in_array($filedata[1], $allowed_documents)){

					copy($folder_scan . $entry, "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . '_' . $entry));

					@unlink($folder_scan . $entry);

					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, basename($random . '_' . $entry)) . "'");

					mysqli_query($conn, "	UPDATE 	`order_orders` 
											SET 	`order_orders`.`files`='" . mysqli_real_escape_string($conn, ($row_order['files'] == "" ? basename($random . '_' . $entry) : $row_order['files'] . "\r\n" . basename($random . '_' . $entry))) . "' 
											WHERE 	`order_orders`.`id`='" . $row_order['id'] . "' 
											AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					if($row_order['mode'] == 0 || $row_order['mode'] == 1){
						
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Datei: [" . basename($random . '_' . $entry) . "]") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

					}else{

						mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
												SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
														`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "Datei: [" . basename($random . '_' . $entry) . "]") . "', 
														`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

					}

					$emsg .= "<p>Datei: " . $entry . " - Datei wurde an Auftrag [#" . $filedata[0] . "] verteilt!</p>\n";

				}

				if(in_array($filedata[1], $allowed_audios)){

					copy($folder_scan . $entry, "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/" . basename($random . '_' . $entry));

					@unlink($folder_scan . $entry);

					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, basename($random . '_' . $entry)) . "'");

					mysqli_query($conn, "	UPDATE 	`order_orders` 
											SET 	`order_orders`.`audio`='" . mysqli_real_escape_string($conn, ($row_order['audio'] == "" ? basename($random . '_' . $entry) : $row_order['audio'] . "\r\n" . basename($random . '_' . $entry))) . "' 
											WHERE 	`order_orders`.`id`='" . $row_order['id'] . "' 
											AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					if($row_order['mode'] == 0 || $row_order['mode'] == 1){
						
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Audio Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Audio Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Audio Datei: [" . basename($random . '_' . $entry) . "]") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

					}else{

						mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
												SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, $row_order['id']) . "', 
														`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Audio Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Audio Datei hochgeladen, ID [#" . $row_order['id'] . "]") . "', 
														`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "Audio Datei: [" . basename($random . '_' . $entry) . "]") . "', 
														`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

					}

					$emsg .= "<p>Datei: " . $entry . " - Datei wurde an Auftrag [#" . $filedata[0] . "] verteilt!</p>\n";

				}

			}else{

				$emsg .= "<p>Datei: " . $entry . " - Der Auftrag [#" . $filedata[0] . "] wurde nicht gefunden!</p>\n";

			}

		}

	}

	if($emsg == ""){

		$emsg = "<p>Der neue Dateianhang wurde erfolgreich hinzugefügt!</p>\n";

	}

}

foreach($folders as $folder => $row){

	if(isset($_POST['upload_' . $folder]) && $_POST['upload_' . $folder] == "hochladen"){

		foreach($_FILES["file"]["error"] as $key => $error) {

			$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);

			if(in_array($ext, $none_file_accept)){

				$emsg .= "<span class=\"error\">Die angegebene Datei-Erweiterung [" . $_FILES['file']['name'][$key] . "] ist nicht erlaubt.</span><br />\n";

			}else{

				if(isset($_FILES['file']['tmp_name'][$key]) && $_FILES['file']['tmp_name'][$key] != ""){

					$filename = filterFilename(basename($_FILES['file']['name'][$key]));

					if(file_exists($path . $folder . "/" . $filename)){

						$emsg .= "<span class=\"error\">Die angegebene Datei [" . $filename . "] existiert bereits.</span><br />\n";

					} else {

						move_uploaded_file($_FILES['file']['tmp_name'][$key], $path . $folder . "/" . $filename);

						$emsg .= "<p>Die Datei [" . $filename . "] wurde erfolgreich hochgeladen!</p>\n";

					}

				}else{

					$emsg .= "<p>Die hochzuladene/n Datei/en wurde/n nicht ausgewählt!</p>\n";

				}

			}

		}

	}

	if(isset($_POST['delete_' . $folder]) && $_POST['delete_' . $folder] == "entfernen"){

		$file = str_replace("/", "", str_replace("..", "", $_POST['id']));

		@unlink($path . $folder . "/" . urldecode($file));

		$emsg = "<p>Die Datei wurde erfolgreich entfernt!</p>\n";

	}

	$lists[$folder] = "";

	$files = scandir($path . $folder);

	foreach($files as $k => $filename){

		if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

			$file_date = date("d.m.Y", filemtime($path . $folder . "/" . $filename));

			$file_time = date("H:i", filemtime($path . $folder . "/" . $filename));

			$file_size = intval(filesize($path . $folder . "/" . $filename) / 1024);

			$lists[$folder] .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
								"	<tr>\n" . 
								"		<td>\n" . 
								"			<small>" . $file_date . "</small> \n" . 
								"			<small class=\"text-muted\">(" . $file_time . ")</small>\n" . 
								"		</td>\n" . 
								"		<td>\n" . 
								"			<a href=\"/" . $path . $folder . "/" . urlencode($filename) . "\" target=\"_blank\">" . ($filename) . "</a>\n" . 
								"		</td>\n" . 
								"		<td class=\"text-center\">\n" . 
								"			<span>" . $file_size . " kb</span>\n" . 
								"		</td>\n" . 
								(intval($_SESSION["admin"]["id"]) == intval($maindata['supervisor_id'] && $row['erasable'] == 1) ? 
									"		<td align=\"center\">\n" . 
									"			<input type=\"hidden\" name=\"id\" value=\"" . urlencode($filename) . "\" />\n" . 
									"			<div class=\"btn-group\">\n" . 
									"				<button type=\"submit\" name=\"delete_" . $folder . "\" value=\"entfernen\" class=\"btn btn-danger btn-sm\">entfernen <i class=\"fa fa-trash-o\"> </i></button>\n" . 
									"			</div>\n" . 
									"		</td>\n"
								: 
									""
								) . 
								"	</tr>\n" . 
								"</form>\n";
		}

	}

	$menulinks .=	"<a class=\"nav-link" . ($folder == $_SESSION['active_folder'] ? " active" : "") . "\" id=\"v-pills-" . $folder . "-tab\" data-toggle=\"pill\" href=\"#v-pills-" . $folder . "\" role=\"tab\" aria-controls=\"v-pills-" . $folder . "\" aria-selected=\"true\">" . $row['name'] . "</a>\n";

	$contents .=	"								<div class=\"tab-pane fade" . ($folder == $_SESSION['active_folder'] ? " show active" : "") . "\" id=\"v-pills-" . $folder . "\" role=\"tabpanel\" aria-labelledby=\"v-pills-" . $folder . "-tab\">\n" . 

					"									<h3>Verzeichnis " . $row['name'] . ": " . $row['description'] . "</h3>\n" . 

					"									<div class=\"table-responsive\">\n" . 
					"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
					"											<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
					"												<th width=\"120\" scope=\"col\">\n" . 
					"													<strong>Datum</strong>\n" . 
					"												</th>\n" . 
					"												<th scope=\"col\">\n" . 
					"													<strong>Datei</strong>\n" . 
					"												</th>\n" . 
					"												<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
					"													<strong>Größe</strong>\n" . 
					"												</th>\n" . 
					(intval($_SESSION["admin"]["id"]) == intval($maindata['supervisor_id'] && $row['erasable'] == 1) ? 
						"												<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
						"													<strong>Aktion</strong>\n" . 
						"												</th>\n"
					: 
						""
					) . 
					"											</tr></thead>\n" . 
			
					$lists[$folder] . 
			
					"										</table>\n" . 
					"									</div>\n" . 
			
					($row['enable_uploads'] == 1 ? 
						"									<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
						"										<div class=\"form-group row mt-3\">\n" . 
						"											<label for=\"name\" class=\"col-sm-2 col-form-label\">Neue Datei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie eine neue Datei hochladen. Klicken Sie dafür auf <u>hochladen</u>.\">?</span></label>\n" . 
						"											<div class=\"col-sm-3\">\n" . 
						"												<input type=\"file\" id=\"file\" name=\"file[]\" multiple=\"multiple\" value=\"\" class=\"form-control\" />\n" . 
						"											</div>\n" . 
						"											<div class=\"col-sm-7\">\n" . 
						"												<input type=\"hidden\" name=\"active_folder\" value=\"" . $folder . "\" />\n" . 
						"												<button type=\"submit\" name=\"upload_" . $folder . "\" value=\"hochladen\" class=\"btn btn-primary\">hochladen <i class=\"fa fa-upload\" aria-hidden=\"true\"></i></button>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"									</form>\n"
					: 
						""
					) . 
			
					"								</div>\n";

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Einstellungen - Scan &amp; Hochladen</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">\n" . 
		"		<p>Hier können Sie die Dateien / Scans hochladen.</p>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-6 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12 text-right\">\n" . 
		"					<button type=\"submit\" name=\"distribute\" value=\"verteilen\" class=\"btn btn-warning\">Dateien verteilen <i class=\"fa fa-share-square-o\" aria-hidden=\"true\"></i></button>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col\">\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Datei-Browser</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"					<div class=\"row mb-3\">\n" . 
		"						<div class=\"col-3 border-right\">\n" . 
		"							<div class=\"nav flex-column nav-pills\" id=\"v-pills-tab\" role=\"tablist\" aria-orientation=\"vertical\">\n" . 

		$menulinks . 

		"							</div>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-9\">\n" . 
		"							<div class=\"tab-content\" id=\"v-pills-tabContent\">\n" . 

		$contents . 

		"							</div>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br />\n<br />\n<br />\n";

?>