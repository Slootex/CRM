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

$inp_storage_space = "";

$storage_space = "";

if(isset($param['id']) && intval($param['id']) > 0){

	$_POST['id'] = intval($param['id']);

}else{

	header("Location: " . $systemdata['unlogin_index']);
	exit();

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	$time = time();

	if(strlen($_POST['storage_space']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Lagerplatz ein. (max. 256 Zeichen)</small><br />\n";
		$inp_storage_space = " is-invalid";
	} else {
		$storage_space = strip_tags($_POST['storage_space']);
	}

	if($emsg == ""){
		if(intval($_POST['storage_space_id']) < 0){
			$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen.</small><br />\n";
			$_POST['storage_space_id'] = 0;
		} else {
			if(intval($_POST['storage_space_id']) > 0 && intval($_POST['storage_space_id']) != $row_order['storage_space_id']){
				$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=" . intval($_POST['storage_space_id'])), MYSQLI_ASSOC);
				if($row_storage_place['used'] < $row_storage_place['parts']){
					if($row_order['storage_space_id'] > 0){
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . $row_order['storage_space_id'] . "'");
						mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
												SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
														`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz vorhandenen entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz vorhandenen entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");
					}
					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . intval($_POST['storage_space_id']) . "'");
					mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
											SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
													`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz-Teil hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
													`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz-Teil hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
													`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");
					$storage_space = $row_storage_place['name'];
				}else{
					$_POST['storage_space_id'] = 0;
					$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";
				}
			}elseif(intval($_POST['storage_space_id']) == 0){
				if($row_order['storage_space_id'] > 0){
					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . $row_order['storage_space_id'] . "'");
					mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
											SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
													`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz vorhandenen entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz vorhandenen entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");
				}
			}
		}
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`storage_space`='" . mysqli_real_escape_string($conn, $storage_space) . "', 
										`order_orders`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_id']) ? $_POST['storage_space_id'] : 0)) . "', 
										`order_orders`.`upd_date`='" . $time . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz), ID [#" . intval($_POST["id"]) . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert (Lagerplatz), ID [#" . intval($_POST["id"]) . "]") . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der Lagerplatz wurde erfolgreich geändert!</p>\n";

	}

}

$emsg = $emsg != "" ? "<br />\n" . $emsg . "<br />\n" : "";

$options_storage_places = "												<option value=\"0\">Bitte auswählen</option>\n";

$result_rooms = mysqli_query($conn, "	SELECT 		* 
										FROM 		`storage_rooms` 
										WHERE 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

while($row_room = $result_rooms->fetch_array(MYSQLI_ASSOC)){

	$options_storage_places .= "											<optgroup label=\"" . $row_room['name'] . "\">\n";

	$result_places = mysqli_query($conn, "	SELECT 		* 
											FROM 		`storage_places` 
											WHERE 		`storage_places`.`room_id`='" . $row_room['id'] . "' 
											AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

	while($row_place = $result_places->fetch_array(MYSQLI_ASSOC)){

		$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . ($row_place['id'] == $row_order['storage_space_id'] ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";

	}

	$options_storage_places .= "											</optgroup>\n";

}

$html = 	"<h4 class=\"text-center mt-3\">Lagerplatz bearbeiten</h4>\n" . 

			($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

			"				<form action=\"" . $page['url'] . "/" . intval($_POST['id']) . "\" method=\"post\">\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<label for=\"storage_space\" class=\"col-sm-12 col-form-label\">Lagerplatz</label>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<input type=\"text\" id=\"storage_space\" name=\"storage_space\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $storage_space : $row_order["storage_space"]) . "\" class=\"form-control" . $inp_storage_space . "\" />\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"form-group row\">\n" . 
			"						<div class=\"col-sm-12\">\n" . 
			"							<select id=\"storage_space_id\" name=\"storage_space_id\" class=\"custom-select\">\n" . 

			$options_storage_places . 

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