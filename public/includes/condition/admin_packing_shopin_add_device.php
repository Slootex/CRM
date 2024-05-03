<?php 

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$atot = $row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "");

	$path = "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/";

	$folder = "scan/";

	$lists = "";

	$list_uploads = "";

	$docs_count = 0;

	$cards_count = 0;

	$files = scandir($path . $folder);

	foreach($files as $k => $filename){

		if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

			$order_number = explode("_", $filename);

			if($row_order['order_number'] == $order_number[0]){

				$file_date = date("d.m.Y", filemtime($path . $folder . "/" . $filename));

				$file_time = date("H:i", filemtime($path . $folder . "/" . $filename));

				$file_size = intval(filesize($path . $folder . "/" . $filename) / 1024);

				if($cards_count == 0){
					$list_uploads .= "<div class=\"card-deck mb-3\">";
				}

				$list_uploads .=	"	<div class=\"card\">\n" . 
									"		<div class=\"card-body\">\n" . 
									"			<div class=\"row\">\n" . 
									"				<div class=\"col-sm-9\">\n" . 
									"					<h4 class=\"card-title mb-0\"><b>" . substr($filename, strpos($filename, "_") + 1) . "</b><br />Ansehen?</h4>\n" . 
									"				</div>\n" . 
									"				<div class=\"col-sm-3 text-right\">\n" . 
									"					<button type=\"button\" name=\"shopin_add\" value=\"voransicht\" class=\"btn btn-success btn-lg mt-1\" onclick=\"document.getElementById('preview').src='/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename . "'\">\n" . 
									"						<i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i>\n" . 
									"					</button>\n" . 
									"				</div>\n" . 
									"			</div>\n" . 
									"		</div>\n" . 
									"	</div>\n";

				if($cards_count == 1){
					$list_uploads .= "</div>";
				}

				$cards_count = $cards_count == 1 ? 0 : $cards_count + 1;

				$docs_count++;


			}

		}

	}

	if($cards_count == 1){
		$list_uploads .= "<div class=\"card bg-light\"></div></div>\n";
	}

	$maindoc = file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") ? "true" : "false";

	$page['script'] .= 	"<script>\n" . 
						"function showStoreButton(){
							if(" . $docs_count . " == 0 && " . $maindoc . " == false){
								if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked && document.getElementById('without_documents').checked){
									$('#store_button').removeClass('d-none');
								}else{
									$('#store_button').addClass('d-none');
								}
							}else if((" . $docs_count . " > 0 || " . $maindoc . " == true) && document.getElementById('with_documents').checked == false){
								if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked && document.getElementById('scan_photo').checked && document.getElementById('with_documents').checked == false){
									$('#store_button').removeClass('d-none');
								}else{
									$('#store_button').addClass('d-none');
								}
							}else if((" . $docs_count . " > 0 || " . $maindoc . " == true) && document.getElementById('with_documents').checked == true){
								if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked){
									$('#store_button').removeClass('d-none');
								}else{
									$('#store_button').addClass('d-none');
								}
							}
						}
						</script>\n";

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Bitte das Gerät einlagern</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_shopin['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"shopin_add_undo\" value=\"rueckgaengig\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 


				"				<div class=\"row\">\n" . 
				"					<div class=\"col-6 border-right\">\n" . 

				"						<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document').files.length;i++){sumsize+=document.getElementById('file_document').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 text-success\"><h3 class=\"mt-2\">Auftrag gefunden</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 

				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span class=\"badge badge-success\"><i id=\"check_order\" class=\"fa fa-check text-white\"> </i></span></h1>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group input-group-lg\">\n" . 
				"										<input type=\"text\" id=\"de_nu\" name=\"de_nu\" value=\"" . $row_device['device_number'] . $atot . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"										<input type=\"hidden\" name=\"device_number\" value=\"" . $row_device['device_number'] . $atot . "\" />\n" . 
				"										<div class=\"input-group-append w-25\" ondblclick=\"
				document.getElementById('device_barcode').value=document.getElementById('de_nu').value;
				if(document.getElementById('device_barcode').value=='" . $row_device['device_number'] . $atot . "'){
					document.getElementById('scan_device').checked=true;
					$('#badge_device').removeClass('badge-danger').addClass('badge-success');
					$('#check_device').removeClass('fa-plus-square').addClass('fa-check');
				}else{
					document.getElementById('scan_device').checked=false;
					$('#badge_device').removeClass('badge-success').addClass('badge-danger');
					$('#check_device').removeClass('fa-check').addClass('fa-plus-square');
					document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Das Gerät wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
					$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
				}
				showStoreButton()\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\">Barcode</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<a href=\"Javascript: void(0)\" class=\"btn btn-success btn-lg\" onclick=\"
				if(navigator.appName == 'Microsoft Internet Explorer'){
					document.getElementById('label_frame').print();
				}else{
					document.getElementById('label_frame').contentWindow.print();
				}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<iframe src=\"/crm/geraete-beschriftung-pdf/" . $row_device['id'] . "\" id=\"label_frame\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group input-group-lg\">\n" . 
				"										<input type=\"text\" id=\"st_sp\" name=\"st_sp\" value=\"" . $row_device['storage_space'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"										<input type=\"hidden\" name=\"storage_space\" value=\"" . $row_device['storage_space'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" />\n" . 
				"										<div class=\"input-group-append w-25\" ondblclick=\"
				document.getElementById('storage_space_barcode').value=document.getElementById('st_sp').value;
				if(document.getElementById('storage_space_barcode').value=='" . $row_device['storage_space'] . "'){
					document.getElementById('scan_storage_space').checked=true;
					$('#badge_storage_space').removeClass('badge-danger').addClass('badge-success');
					$('#check_storage_space').removeClass('fa-plus-square').addClass('fa-check');
				}else{
					document.getElementById('scan_storage_space').checked=false;
					$('#badge_storage_space').removeClass('badge-success').addClass('badge-danger');
					$('#check_storage_space').removeClass('fa-check').addClass('fa-plus-square');
					document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Lagerplatz wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
					$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
				}
				showStoreButton()\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\" id=\"inputGroup-device-number\">Zielplatz</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"device_barcode\" name=\"device_barcode\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Gerätenummer\" onkeypress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('device_barcode').value=='" . $row_device['device_number'] . $atot . "'){
						document.getElementById('scan_device').checked=true;
						$('#badge_device').removeClass('badge-danger').addClass('badge-success');
						$('#check_device').removeClass('fa-plus-square').addClass('fa-check');
						document.getElementById('storage_space_barcode').focus();
					}else{
						document.getElementById('scan_device').checked=false;
						$('#badge_device').removeClass('badge-success').addClass('badge-danger');
						$('#check_device').removeClass('fa-check').addClass('fa-plus-square');
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Das Gerät wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
						document.getElementById('device_barcode').value='';
						document.getElementById('device_barcode').focus();
					}
					showStoreButton();
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span id=\"badge_device\" class=\"badge badge-danger\"><i id=\"check_device\" class=\"fa fa-plus-square text-white\"> </i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"scan_device\" name=\"scan_device\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"storage_space_barcode\" name=\"storage_space_barcode\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Lagerplatz\" onkeypress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('storage_space_barcode').value=='" . $row_device['storage_space'] . "'){
						document.getElementById('scan_storage_space').checked=true;
						$('#badge_storage_space').removeClass('badge-danger').addClass('badge-success');
						$('#check_storage_space').removeClass('fa-plus-square').addClass('fa-check');
					}else{
						document.getElementById('scan_storage_space').checked=false;
						$('#badge_storage_space').removeClass('badge-success').addClass('badge-danger');
						$('#check_storage_space').removeClass('fa-check').addClass('fa-plus-square');
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Lagerplatz wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					showStoreButton();
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span id=\"badge_storage_space\" class=\"badge badge-danger\"><i id=\"check_storage_space\" class=\"fa fa-plus-square text-white\"> </i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"scan_storage_space\" name=\"scan_storage_space\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				($docs_count > 0 || file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") ? 
					"							<div id=\"question_photo\" class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-8\">\n" . 
					"									<h3 class=\"mt-3\">Alles fotografiert ?</h3>\n" . 
					"								</div>\n" . 
					"								<div class=\"col-sm-4\">\n" . 
					"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
					"										<input type=\"checkbox\" id=\"scan_photo\" name=\"scan_photo\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
					showStoreButton()\" />\n" . 
					"										<label class=\"custom-control-label\" for=\"scan_photo\" onclick=\"
					showStoreButton()\">\n" . 
					"											Ja\n" . 
					"										</label>\n" . 
					"									</div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . 

				"							<div class=\"row my-3" . ($docs_count == 0 && !file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") ? "" : " d-none") . "\">\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<h3 class=\"text-danger mt-3\">Ohne Dokumente fortfahren</h3>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-1\">\n" . 
				"										<input type=\"checkbox\" id=\"without_documents\" name=\"without_documents\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
				if(document.getElementById('without_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"prints_ready\" onclick=\"
				if(document.getElementById('without_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row mt-5\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<div id=\"store_button\" class=\"d-none\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"										<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_shopin['order_id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"shopin_add\" value=\"store\" class=\"btn btn-success btn-lg w-100\"><h1>einlagern <i class=\"fa fa-tasks\" aria-hidden=\"true\"></i></h1></button>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</form>\n" . 

				"					</div>\n" . 
				"					<div class=\"col-6\">\n" . 

				"						<div class=\"row mb-3\">\n" . 
				"							<div class=\"col-sm-10\">\n" . 
				"								<h3 class=\"font-weight-bold mt-1\">" . (file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") == true ? "Das Haupt- und " . $docs_count . " Dokumente wurden gefunden!" : $docs_count . " Dokumente wurden gefunden!") . "</h3>\n" . 
				"							</div>\n" . 
				"							<div class=\"col-sm-2 text-right mb-1\">\n" . 
				"								<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"									<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"									<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_shopin['order_id']) . "\" />\n" . 
				"									<button type=\"submit\" name=\"shopin_add\" value=\"aktualisieren\" class=\"btn btn-secondary btn-lg\"><i class=\"fa fa-refresh\"></i></button>\n" . 
				"								</form>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				(file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") == true ? 
					"						<div class=\"row mb-3\">\n" . 
					"							<div class=\"col-sm-12\">\n" . 
	
					"								<div class=\"card\">\n" . 
					"									<div class=\"card-body\">\n" . 
					"										<div class=\"row\">\n" . 
					"											<div class=\"col-sm-9\">\n" . 
					"												<h4 class=\"card-title mb-0\"><b>Haupt Dokument</b><br />Ansehen?</h4>\n" . 
					"											</div>\n" . 
					"											<div class=\"col-sm-3 text-right\">\n" . 
					"												<button type=\"button\" name=\"shopin_add\" value=\"voransicht\" class=\"btn btn-success btn-lg mt-1\" onclick=\"document.getElementById('preview').src='/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf'\">\n" . 
					"													<i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i>\n" . 
					"												</button>\n" . 
					"											</div>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 
					"								</div>\n" . 
	
					"							</div>\n" . 
					"						</div>\n"
				: 
					""
				) . 

				($docs_count > 0 ? 
					"						<div class=\"row\">\n" . 
					"							<div class=\"col-sm-12\">\n" . 

					$list_uploads . 

					"							</div>\n" . 
					"						</div>\n"
				: 
					""
				) . 

				"						<div id=\"show_print_button\" class=\"row my-3" . ($docs_count == 0 && !file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") ? " d-none" : "") . "\">\n" . 
				"							<div class=\"col-sm-6\">\n" . 
				"								<h3 class=\"mt-3\">Ohne Dokumente fortfahren</h3>\n" . 
				"							</div>\n" . 
				"							<div class=\"col-sm-6\">\n" . 
				"								<div class=\"custom-control custom-checkbox mt-1\">\n" . 
				"									<input type=\"checkbox\" id=\"with_documents\" name=\"with_documents\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
				if(document.getElementById('with_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\" />\n" . 
				"									<label class=\"custom-control-label\" for=\"prints_ready\" onclick=\"
				if(document.getElementById('with_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\">\n" . 
				"										Ja\n" . 
				"									</label>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 

				"						<div class=\"row my-3\">\n" . 
				"							<div class=\"col-sm-12\">\n" . 
				"								<iframe id=\"preview\" src=\"" . (file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf") ? "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf" : "/crm/blank") . "\" width=\"100%\" height=\"800\" class=\"border\"></iframe>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 

				"					</div>\n" . 
				"				</div>\n" . 
	
				"				<div class=\"row px-0 card-footer\">\n" . 
				"					<div class=\"col-sm-12 text-right\">\n" . 
				"						&nbsp;\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
	
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>