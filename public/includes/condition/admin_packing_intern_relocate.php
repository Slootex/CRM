<?php 

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`intern_interns`.`id` AS id, 
																		`intern_interns`.`intern_number` AS intern_number, 
																		`intern_interns`.`order_id` AS order_id, 
																		`intern_interns`.`message` AS message, 
																		`order_orders_devices`.`device_number` AS device_number, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
																		(SELECT `storage_places`.`name` AS s_s_to_name FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_storage_space, 
																		(SELECT `storage_places`.`parts` AS s_s_to_parts FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_parts, 
																		(SELECT `storage_places`.`used` AS s_s_to_used FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_used 
															FROM 		`intern_interns` 
															LEFT JOIN	`order_orders_devices` 
															ON			`intern_interns`.`device_id`=`order_orders_devices`.`id` 
															WHERE		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Bitte das/die Gerät/e umlagern</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_intern['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"intern_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_image').files.length;i++){sumsize+=document.getElementById('file_image').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				($row_intern['message'] != "" ? 
					"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 
					"									<div class=\"bg-light border border-danger text-danger p-2\" style=\"min-height: 120px;font-size: 28pt;border-width: 4px !important\"><b>" . $row_intern['message'] . "</b></div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . 

				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5\"><h3 class=\"mt-2\">Gerätenummer</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"input-group input-group-lg mt-1\">\n" . 
				"										<input type=\"text\" id=\"device_number\" name=\"device_number\" value=\"" . $row_intern['device_number'] . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
				"										<div class=\"input-group-append w-50\" ondblclick=\"
				document.getElementById('item').value=document.getElementById('device_number').value;
				if(document.getElementById('item').value=='" . $row_intern['device_number'] . "'){
					\$('#badge_device_item').removeClass('badge-danger').addClass('badge-success');
					\$('#check_device_item').removeClass('fa-plus-square').addClass('fa-check-square-o');
					document.getElementById('device_item_check').checked=true;
				}else{
					\$('#badge_device_item').removeClass('badge-success').addClass('badge-danger');
					\$('#check_device_item').removeClass('fa-check-square-o').addClass('fa-plus-square');
					document.getElementById('device_item_check').checked=false;
					document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Das Gerät wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
					$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
				}
				if(document.getElementById('item').value=='" . $row_intern['device_number'] . "' && document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "' && document.getElementById('to_storage_space').classList.contains('bg-success')==true){
					\$('#photo_button').removeClass('d-none');
				}
				\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\">Barcode</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5\"><h3 class=\"mt-2\">Aktueller Lagerplatz</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"input-group input-group-lg mt-1\">\n" . 
				"										<input type=\"text\" name=\"storage_space\" value=\"" . $row_intern['storage_space'] . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
				"										<div class=\"input-group-append w-50\">\n" . 
				"											<span class=\"input-group-text w-100\">Lagerplatz</span>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5\"><h3 class=\"mt-2\">Zielplatz</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"input-group input-group-lg mt-1\">\n" . 
				"										<input type=\"text\" id=\"to_storage_space\" name=\"to_storage_space\" value=\"" . $row_intern['to_storage_space'] . "\" class=\"form-control text-white " . ($row_intern['to_used'] < $row_intern['to_parts'] ? "bg-success" : "bg-danger") . "\" disabled=\"disabled\" />\n" . 
				"										<div class=\"input-group-append w-50\" ondblclick=\"
				document.getElementById('place').value=document.getElementById('to_storage_space').value;
				if(document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "'){
					\$('#badge_device_place').removeClass('badge-danger').addClass('badge-success');
					\$('#check_device_place').removeClass('fa-plus-square').addClass('fa-check-square-o');
					document.getElementById('device_place_check').checked=true;
				}else{
					\$('#badge_device_place').removeClass('badge-success').addClass('badge-danger');
					\$('#check_device_place').removeClass('fa-check-square-o').addClass('fa-plus-square');
					document.getElementById('device_place_check').checked=false;
					document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Lagerplatz wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
					$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
				}
				if(document.getElementById('item').value=='" . $row_intern['device_number'] . "' && document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "' && document.getElementById('to_storage_space').classList.contains('bg-success')==true){
					\$('#photo_button').removeClass('d-none');
				}
				\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\">Zielplatz</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5\"><h3 class=\"mt-2\">Gerät scannen</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"item\" name=\"item\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Gerätenummer\" onKeyPress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('item').value=='" . $row_intern['device_number'] . "'){
						\$('#badge_device_item').removeClass('badge-danger').addClass('badge-success');
						\$('#check_device_item').removeClass('fa-plus-square').addClass('fa-check-square-o');
						document.getElementById('device_item_check').checked=true;
					}else{
						\$('#badge_device_item').removeClass('badge-success').addClass('badge-danger');
						\$('#check_device_item').removeClass('fa-check-square-o').addClass('fa-plus-square');
						document.getElementById('device_item_check').checked=false;
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Das Gerät wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(document.getElementById('item').value=='" . $row_intern['device_number'] . "' && document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "' && document.getElementById('to_storage_space').classList.contains('bg-success')==true){
						\$('#photo_button').removeClass('d-none');
					}
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<h1><span id=\"badge_device_item\" class=\"badge badge-danger\"><i id=\"check_device_item\" class=\"fa fa-plus-square text-white\"></i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"device_item_check\" name=\"device_item_check\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5\"><h3 class=\"mt-2\">Zielplatz scannen</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"place\" name=\"place\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Zielplatz\" onKeyPress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "'){
						\$('#badge_device_place').removeClass('badge-danger').addClass('badge-success');
						\$('#check_device_place').removeClass('fa-plus-square').addClass('fa-check-square-o');
						document.getElementById('device_place_check').checked=true;
					}else{
						\$('#badge_device_place').removeClass('badge-success').addClass('badge-danger');
						\$('#check_device_place').removeClass('fa-check-square-o').addClass('fa-plus-square');
						document.getElementById('device_place_check').checked=false;
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Lagerplatz wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(document.getElementById('item').value=='" . $row_intern['device_number'] . "' && document.getElementById('place').value=='" . $row_intern['to_storage_space'] . "' && document.getElementById('to_storage_space').classList.contains('bg-success')==true){
						\$('#photo_button').removeClass('d-none');
					}
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<h1><span id=\"badge_device_place\" class=\"badge badge-danger\"><i id=\"check_device_place\" class=\"fa fa-plus-square text-white\"></i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"device_place_check\" name=\"device_place_check\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row mt-5\">\n" . 
				"								<div id=\"photo_button\" class=\"col-sm-12 d-none\">\n" . 

				"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"									<button type=\"submit\" name=\"intern_relocate\" value=\"durchfuehren\" class=\"btn btn-success btn-lg w-100\"><h1>durchführen <i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></h1></button>\n" . 

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
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6 text-right\">\n" . 
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