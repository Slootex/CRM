<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_status = "";

$status = "";

$order_table = "order_orders";
$order_id_field = "order_id";
$type = 0;

if(isset($param['id']) && intval($param['id']) > 0){

	$_POST['id'] = intval($param['id']);

}else{

	header("Location: /crm/eingang");
	exit();

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	switch(intval($row_order['mode'])){
		case 0: 
			$order_table = "order_orders";
			$row_order = "order_id";
			$type = 1;
			break;
		case 1: 
			$order_table = "order_archive";
			$row_order = "order_id";
			$type = 1;
			break;
		case 2: 
			$order_table = "interested_interesteds";
			$row_order = "interested_id";
			$type = 4;
			break;
		case 3: 
			$order_table = "interested_archive";
			$row_order = "interested_id";
			$type = 4;
			break;
	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	$time = time();

	if(intval($_POST['status']) < 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Status aus.</small><br />\n";
		$inp_status = " is-invalid";
	} else {
		$status = intval($_POST['status']);
	}

	if($emsg == ""){

		$time = time();

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);
		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($status)) . "'"), MYSQLI_ASSOC);
		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
								SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $order_table . "_statuses`.`public`='1', 
										`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Verlauf, " . $row_status['name'] . ", ID [#" . $_SESSION["status"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der Status wurde erfolgreich durchgeführt!</p>\n";

	}

}

$emsg = $emsg != "" ? "<br />\n" . $emsg . "<br />\n" : "";

$options_status = "";

$result_statuses = mysqli_query($conn, "	SELECT 		* 
											FROM 		`statuses` 
											WHERE 		`statuses`.`type`='" . $type . "' 
											AND 		`statuses`.`multi_status`='1' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

while($row_statuses = $result_statuses->fetch_array(MYSQLI_ASSOC)){

	$options_status .= "												<option value=\"" . $row_statuses['id'] . "\">" . $row_statuses['name'] . "</option>\n";

}

$html = 	"<h4 class=\"text-center mt-3\">Status durchführen</h4>\n" . 

			($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

			"				<form action=\"" . $page['url'] . "/" . intval($_POST['id']) . "\" method=\"post\">\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<label for=\"status\" class=\"col-sm-12 col-form-label\">Status</label>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<select id=\"status\" name=\"status\" class=\"custom-select\">\n" . 

			$options_status . 

			"							</select>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
			"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"				</form>\n";

?>