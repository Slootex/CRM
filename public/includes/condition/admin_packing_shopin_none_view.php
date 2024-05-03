<?php 

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "	SELECT		*, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
															FROM		`shopin_shopins` 
															LEFT JOIN	`order_orders_devices` 
															ON			`order_orders_devices`.`id`=`shopin_shopins`.`device_id` 
															WHERE		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Wareneingang ansehen - Einlagern</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"shopin_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
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
				"								<label class=\"col-sm-8 text-danger\"><h3 class=\"mt-2\">Auftrag nicht zugeordnet</h3></label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<h1><span class=\"badge badge-danger\"><i id=\"check_order\" class=\"fa fa-exclamation-triangle text-white\"> </i></span></h1>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group input-group-lg\">\n" . 
				"										<input type=\"text\" id=\"de_nu\" name=\"de_nu\" value=\"" . $row_shopin['help_device_number'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"										<input type=\"hidden\" name=\"device_number\" value=\"" . $row_shopin['help_device_number'] . "\" />\n" . 
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
				"									<iframe src=\"/crm/temporaere-geraete-beschriftung-pdf/" . $row_shopin['id'] . "\" id=\"label_frame\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group input-group-lg\">\n" . 
				"										<input type=\"text\" id=\"storage_space\" name=\"storage_space\" value=\"" . $row_shopin['storage_space'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"										<input type=\"hidden\" name=\"storage_space\" value=\"" . $row_shopin['storage_space'] . "\" />\n" . 
				"										<div class=\"input-group-append w-25\">\n" . 
				"											<button type=\"button\" class=\"btn btn-primary w-100\">Zielplatz</button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

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