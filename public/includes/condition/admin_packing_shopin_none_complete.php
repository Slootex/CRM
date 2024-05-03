<?php 

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Bitte die Fragen beantworten</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"shopin_none_undo\" value=\"rueckgaengig\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
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

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<small class=\"mt-3\">Öffnungsspuren?<br />Klebt ein Kleber einer anderen Firma drauf?</small>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"opening_marks\" name=\"opening_marks\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
				if(document.getElementById('opening_marks').checked && document.getElementById('other_components').checked){
					//$('#store_button').removeClass('d-none');
				}else{
					//$('#store_button').addClass('d-none');
				}\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"opening_marks\" onclick=\"
				if(document.getElementById('opening_marks').checked && document.getElementById('other_components').checked){
					//$('#store_button').removeClass('d-none');
				}else{
					//$('#store_button').addClass('d-none');
				}\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<small class=\"mt-3\">Andere Bauteile am Gerät (Halterung, Autoschlüssek etc) ?</small>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"other_components\" name=\"other_components\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
				if(document.getElementById('opening_marks').checked && document.getElementById('other_components').checked){
					//$('#store_button').removeClass('d-none');
				}else{
					//$('#store_button').addClass('d-none');
				}\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"other_components\" onclick=\"
				if(document.getElementById('opening_marks').checked && document.getElementById('other_components').checked){
					//$('#store_button').removeClass('d-none');
				}else{
					//$('#store_button').addClass('d-none');
				}\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12 mt-5\">\n" . 
				"									<div id=\"store_button\" class=\"no-d-none\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"shopin_none\" value=\"save\" class=\"btn btn-success btn-lg w-100\"><h1>abschliessen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></h1></button>\n" . 
				"									</div>\n" . 
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