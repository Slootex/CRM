<?php 

	$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT	*, 
																	(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
															FROM	`order_orders_devices` 
															WHERE	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$atot = $row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "");

	$row_device['storage_space'] = $row_device['storage_space'] == "" ? "kein" : $row_device['storage_space'];

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Wareneingang - Gerät in Benutzung</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_device['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"shopin_device_reset\" value=\"zuruecksetzen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie das Gerät wircklich zurücksetzen?')\">zurücksetzen <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 text-danger\"><h3 class=\"mt-2\">Gerät in benutzung</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 

				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span class=\"badge badge-danger\"><i id=\"check_order\" class=\"fa fa-times text-white\"> </i></span></h1>\n" . 
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
				if(document.getElementById('scan_device').checked && document.getElementById('old_scan_storage_space').checked && document.getElementById('scan_storage_space').checked && document.getElementById('scan_photo').checked){
					$('#store_button').removeClass('d-none');
				}else{
					$('#store_button').addClass('d-none');
				}\">\n" . 
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
				if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked){
					$('#store_button').removeClass('d-none');
				}else{
					$('#store_button').addClass('d-none');
				}\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\" id=\"inputGroup-device-number\">Lagerplatz</button>\n" . 
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
					}else{
						document.getElementById('scan_device').checked=false;
						$('#badge_device').removeClass('badge-success').addClass('badge-danger');
						$('#check_device').removeClass('fa-check').addClass('fa-plus-square');
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Das Gerät wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked){
						$('#store_button').removeClass('d-none');
					}else{
						$('#store_button').addClass('d-none');
					}
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
					if(document.getElementById('scan_device').checked && document.getElementById('scan_storage_space').checked){
						$('#store_button').removeClass('d-none');
					}else{
						$('#store_button').addClass('d-none');
					}
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span id=\"badge_storage_space\" class=\"badge badge-danger\"><i id=\"check_storage_space\" class=\"fa fa-plus-square text-white\"> </i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"scan_storage_space\" name=\"scan_storage_space\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Einlagern:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_storage'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">WE-Umlagern:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_shopin_relocate'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Beschriften:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_labeling'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Versandauftrag-Kunde:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_shipping_user'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Versandauftrag-Techniker:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_shipping_technic'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Versendet:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_send'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Umlagern:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_relocate'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-8 col-form-label\">Fotoauftrag:</label>\n" . 
				"										<div class=\"col-sm-4 text-center\">\n" . 
				"											<strong>" . ($row_device['is_photo'] == 0 ? "Nein" : "Ja") . "</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row mt-5\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<div id=\"store_button\" class=\"d-none\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_device['id']) . "\" />\n" . 
				"										<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_device['order_id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"shopin_device_reset\" value=\"zuruecksetzen\" class=\"btn btn-success btn-lg w-100\"><h1>zurücksetzen <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></h1></button>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6 text-center\">\n" . 

				"							<h1>Beispiel</h1>\n" . 

				"							<video width=\"600\" height=\"400\" controls>\n" . 
				"								<source src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/img/demo.mp4\" type=\"video/mp4\">\n" . 
				"							</video>\n" . 
	
				"						</div>\n" . 
				"					</div>\n" . 
	
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-12 text-right\">\n" . 
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