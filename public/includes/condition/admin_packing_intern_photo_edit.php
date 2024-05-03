<?php 

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`intern_interns`.`id` AS id, 
																		`intern_interns`.`intern_number` AS intern_number, 
																		`intern_interns`.`order_id` AS order_id, 
																		`intern_interns`.`device_id` AS device_id, 
																		`intern_interns`.`message` AS message, 
																		`order_orders_devices`.`device_number` AS device_number, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
															FROM 		`intern_interns` 
															LEFT JOIN	`order_orders_devices` 
															ON			`intern_interns`.`device_id`=`order_orders_devices`.`id` 
															WHERE 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h4 class=\"mt-1 mb-0\">Intern Fotografieren bearbeiten " . $row_intern['intern_number'] . "</h4>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_intern['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"intern_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
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

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Wichtige Information<br />(An den Packtisch)</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<textarea name=\"message\" class=\"form-control\">" . $row_intern['message'] . "</textarea>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									&nbsp;\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-8 text-center\">\n" . 
				"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"									<button type=\"submit\" name=\"intern_photo_update\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-save\" aria-hidden=\"true\"></i></button>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
	
				"						</div>\n" . 
				"						<div class=\"col-6 text-center\">\n" . 

				"							<h1>Beispiel</h1>\n" . 

				"							<video width=\"600\" height=\"400\" controls>\n" . 
				"								<source src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/img/demo.mp4\" type=\"video/mp4\">\n" . 
				"							</video>\n" . 

				"							<br /><br />\n" . 

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