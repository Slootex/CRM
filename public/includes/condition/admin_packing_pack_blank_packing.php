<?php 

	$row_packing = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
															AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);


	$html_devices = 	"	<tr>\n" . 
						"		<td><a href=\"Javascript: void(0)\" ondblclick=\"
						if(document.getElementById('device_" . $row_packing['packing_number'] . "')){
							\$('#check_" . $row_packing['packing_number'] . "').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
							document.getElementById('device_" . $row_packing['packing_number'] . "').checked=true;
							var check=true;
							for(let i = 0;i < devices.length;i++){
								if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
							}
						}else{
							\$('#check_" . $row_packing['packing_number'] . "').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
							document.getElementById('device_" . $row_packing['packing_number'] . "').checked=false;
							document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
							$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
						}
						if(check==true){
							\$('#packing_button').removeClass('d-none');
						}else{
							\$('#packing_button').addClass('d-none');
						}\">" . $row_packing['packing_number'] . "</a></td>\n" . 
						"		<td>-</td>\n" . 
						"		<td>-</td>\n" . 
						"		<td align=\"center\"><div class=\"custom-control custom-checkbox pl-0\"><h4 class=\"mb-0\"><i id=\"check_" . $row_packing['packing_number'] . "\" class=\"fa fa-plus-square text-danger\"> </i></h4><div class=\"d-none\"><input type=\"checkbox\" id=\"device_" . $row_packing['packing_number'] . "\" name=\"device_" . $row_packing['packing_number'] . "\" value=\"1\" class=\"custom-control-input\" /><label for=\"device_" . $row_packing['packing_number'] . "\" class=\"custom-control-label\"></label></div></div></td>\n" . 
						"	</tr>\n";

	$js_devices .= $js_devices == "" ? "'" . $row_packing['packing_number'] . "'" : ", '" . $row_packing['packing_number'] . "'";

	$js_devices = "<script>var devices = [" . $js_devices . "];</script>\n";

	$list_files = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
									FROM 		`order_orders_files` 
									WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_files`.`type`<'4' 
									ORDER BY 	CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

	$html .= 	$js_devices . 

				"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Bitte das/die Gerät/e verpacken</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_packing['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				$html_new_shipping_result . 

				($emsg_shipment != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_shipment . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
	
				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				($row_packing['message'] != "" ? 
					"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 
					"									<div class=\"bg-light border border-danger text-danger p-2\" style=\"min-height: 120px;font-size: 28pt;border-width: 4px !important\"><b>" . $row_packing['message'] . "</b></div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . 

				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"item\" name=\"item\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Artikel\" onKeyPress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('device_' + document.getElementById('item').value)){
						\$('#check_' + document.getElementById('item').value).removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
						document.getElementById('device_' + document.getElementById('item').value).checked=true;
						document.getElementById('item').value='';
						var check=true;
						for(let i = 0;i < devices.length;i++){
							if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
						}
					}else{
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(check==true){
						\$('#packing_button').removeClass('d-none');
					}else{
						\$('#packing_button').addClass('d-none');
					}
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-6\">\n" . 

				"								</div>\n" . 
				"							</div>\n" . 
	
				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 

				"									<small>Positionen des Auftrags</small><br />\n" . 

				"									<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " no-table-sm table-borderless table-hover border-bottom mb-0\">\n" . 
				"										<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . " border-bottom\">\n" . 
				"											<th scope=\"col\" width=\"160\"><h5 class=\"font-weight-bold mb-0\">ArtNr.</h5></th>\n" . 
				"											<th scope=\"col\" width=\"120\"><h5 class=\"font-weight-bold mb-0\">Lagerplatz</h5></th>\n" . 
				"											<th scope=\"col\"><h5 class=\"font-weight-bold mb-0\">Artikelname</h5></th>\n" . 
				"											<th scope=\"col\" width=\"40\" class=\"text-center\"><h5 class=\"font-weight-bold mb-0\">Gescannt</h5></th>\n" . 
				"										</tr></thead>\n" . 

				$html_devices . 

				"									</table>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				($row_packing['is_send'] == 1 ? 
					"							<div class=\"form-group row mt-5\">\n" . 
					"								<div class=\"col-sm-12 text-center\">\n" . 
					"									<h1 class=\"text-success\">\n" . 
					"										<div class=\"spinner-grow text-success mb-2\" role=\"status\">\n" . 
					"											<span class=\"sr-only\">Loading...</span>\n" . 
					"										</div>\n" . 
					"										Das Paket wurde schon versendet!\n" . 
					"									</h1>\n" . 
					"									<iframe src=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row_packing['shipments_id'] . "\" id=\"label\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
					"									<a href=\"Javascript: void(0)\" class=\"btn btn-success btn-sm\" onclick=\"
					if(navigator.appName == 'Microsoft Internet Explorer'){
						document.getElementById('label').print();
					}else{
						document.getElementById('label').contentWindow.print();
					}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;&nbsp;<a href=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row_packing['shipments_id'] . "\" class=\"text-success\" target=\"_blank\">Versandschein nachdrucken</a>\n" . 
	
					"								</div>\n" . 
					"							</div>\n"
				: 
					"							<div class=\"form-group row mt-5\">\n" . 
					"								<div class=\"col-sm-12 text-center\">\n" . 
					"									<div id=\"packing_button\" class=\"d-none\">\n" . 
	
					"										<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
					"										<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_packing['order_id']) . "\" />\n" . 
					"										<button type=\"submit\" name=\"packing_blank\" value=\"verpacken\" class=\"btn btn-success btn-lg w-100\"><h1>versenden <i class=\"fa fa-truck\" aria-hidden=\"true\"></i></h1></button><br />\n" . 
	
/*					"										<iframe src=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row_packing['shipments_id'] . "\" id=\"label\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
					"										<a href=\"Javascript: void(0)\" class=\"btn btn-success btn-sm\" onclick=\"
					if(navigator.appName == 'Microsoft Internet Explorer'){
						document.getElementById('label').print();
					}else{
						document.getElementById('label').contentWindow.print();
					}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;&nbsp;<a href=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row_packing['shipments_id'] . "\" class=\"text-success\" target=\"_blank\">Versandschein nachdrucken</a>\n" . 
*/
					"									</div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				) . 

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