<?php 

	$alert_message = "<strong>Feiertag</strong> Wir wünschen einen schönen 1.Mai!"; // place here your Alert message
	
	$alert_show = false; // Switch alert to true or false

	$alert_type = "info"; // primary, secondary, success, danger, warning, info, light, dark

	$type = "dialog"; // dialog, alert

	/* ------------------------------------------------------------------------------------------------------------- */

	if($type == "alert"){

		if($alert_show == true){

			echo 	"<div class=\"1row\">\n" . 
					"	<div class=\"col-12\">\n" . 
					"		<div class=\"alert alert-" . $alert_type . " alert-dismissible fade show\" role=\"alert\">\n" . 
					"			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" . 
					"			" . $alert_message . "\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n";

		}

	}

	if($type == "dialog"){

		if($alert_show == true){

			echo 	"<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">\n" . 
					"	<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">\n" . 
					"		<div class=\"modal-content\">\n" . 
					"			<div class=\"modal-header\">\n" . 
					"				<h5 class=\"modal-title\" id=\"exampleModalLabel\">Information</h5>\n" . 
					"					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" . 
					"						<span aria-hidden=\"true\">&times;</span>\n" . 
					"					</button>\n" . 
					"				</div>\n" . 
					"				<div class=\"modal-body\">\n" . 
					"					" . $alert_message . "\n" . 
					"				</div>\n" . 
					"				<div class=\"modal-footer\">\n" . 
					"					<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
					"				</div>\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"</div>\n" . 
					"<script>\$(document).ready(function() {\$('#exampleModal').modal('show');});</script>\n";

		}

	}

?>