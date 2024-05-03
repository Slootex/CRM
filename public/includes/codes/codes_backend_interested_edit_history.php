<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "interested_interesteds";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_message = "";

$message = "";

if(isset($param['id']) && intval($param['id']) > 0){

	$_POST['id'] = intval($param['id']);

}else{

	header("Location: /crm/eingang");
	exit();

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_interested = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['history']) && $_POST['history'] == "speichern"){

	if(strlen($_POST['message']) < 1 || strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = $_POST['message'];
	}

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	INSERT 	`interested_interesteds_history` 
								SET 	`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`interested_interesteds_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`interested_interesteds_history`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`interested_interesteds_history`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`interested_interesteds_history`.`time`='" . $time . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, History, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, History, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Die Nachricht wurde erfolgreich gespeichert.</p>\n";

		$message = "";

	}

}

$emsg = $emsg != "" ? "<br />\n" . $emsg . "<br />\n" : "";

$html = 	"<h4 class=\"text-center mt-3\">Neue Nachricht</h4>\n" . 

			($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

			"				<form action=\"" . $page['url'] . "/" . intval($_POST['id']) . "\" method=\"post\">\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<label for=\"message\" class=\"col-sm-12 col-form-label\">Nachricht</label>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
			"							<button type=\"submit\" name=\"history\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"				</form>\n";


?>