<?php 

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['device_id'])) . "'"), MYSQLI_ASSOC);

	$atot = $row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "");

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Intern ansehen - Fotoauftrag wurde durchgeführt</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_intern['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"intern_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
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

				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 text-success\"><h3 class=\"mt-2\">Auftragsgerät fotografiert</h3></label>\n" . 
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
				"										<div class=\"input-group-append w-25\">\n" . 
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
				"										<div class=\"input-group-append w-25\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\" id=\"inputGroup-device-number\">Zielplatz</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				/*"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"device_barcode\" name=\"device_barcode\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Gerätenummer\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span id=\"badge_device\" class=\"badge badge-danger\"><i id=\"check_device\" class=\"fa fa-plus-square text-white\"> </i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"scan_device\" name=\"scan_device\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"storage_space_barcode\" name=\"storage_space_barcode\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Lagerplatz\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span id=\"badge_storage_space\" class=\"badge badge-danger\"><i id=\"check_storage_space\" class=\"fa fa-plus-square text-white\"> </i></span></h1><div class=\"d-none\"><input type=\"checkbox\" id=\"scan_storage_space\" name=\"scan_storage_space\" value=\"1\" class=\"custom-control-input\" /></div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<h3 class=\"mt-3\">Fotografiert ?</h3>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"scan_photo\" name=\"scan_photo\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . */

				"							<div class=\"form-group row mt-5\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									&nbsp;\n" . 
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