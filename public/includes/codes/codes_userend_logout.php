<?php 

@session_start();

session_destroy();

unset($_SESSION);

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$inp_user = "";
$inp_pass = "";

$user = "";
$pass = "";

$html = "<br />\n" . 
		"<div class=\"card\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<h4 class=\"mb-0\">Eingang</h4>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"		<form action=\"/kunden/eingang\" method=\"post\">\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"user\" class=\"col-sm-2 col-form-label\">Benutzer/Email</label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"email\" id=\"user\" name=\"user\" value=\"" . $user . "\" class=\"form-control" . $inp_user . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"pass\" class=\"col-sm-2 col-form-label\">Kennwort</label>\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"password\" id=\"pass\" name=\"pass\" class=\"form-control" . $inp_pass . "\" />\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"			<div class=\"row px-0 card-footer\">\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<input type=\"submit\" name=\"login\" value=\"anmelden\" class=\"btn btn-primary\" />\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-6\" align=\"right\">\n" . 
		"					&nbsp;\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";

?>