<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "admin";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

function writeHtpasswd($conn){

	$data = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin_roles`.`name` AS name FROM `admin_roles` WHERE `admin_roles`.`id`=`admin`.`role` AND `admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "') AS role_name 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
									ORDER BY 	CAST(`admin`.`role` AS UNSIGNED) ASC, CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row_admin = $result->fetch_array(MYSQLI_ASSOC)){

		$encrypted_password = password_hash($row_admin['pass'], PASSWORD_BCRYPT);
		 
		$data .= $row_admin['user'] . ":" . $encrypted_password . "\n";

	}

	$f = fopen("includes/.htpasswd", "w");
	fwrite($f, $data);
	fclose($f);

}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$admin_session = "admin_search";

if(isset($_POST["sorting_field"])){$_SESSION[$admin_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$admin_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$admin_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$admin_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$admin_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`admin`.`name`"
);
$sorting[] = array(
	"name" => "Loginname", 
	"value" => "`admin`.`user`"
);
$sorting[] = array(
	"name" => "Email", 
	"value" => "`admin`.`email`"
);
$sorting[] = array(
	"name" => "Rolle", 
	"value" => "role_name"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`admin`.`time` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$admin_session]["sorting_field"]) ? $sorting[$_SESSION[$admin_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$admin_session]["sorting_field"]) ? $_SESSION[$admin_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$admin_session]["sorting_direction"]) ? $directions[$_SESSION[$admin_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$admin_session]["sorting_direction"]) ? $_SESSION[$admin_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$admin_session]["rows"]) && $_SESSION[$admin_session]["rows"] > 0 ? $_SESSION[$admin_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_role = "";
$inp_name = "";
$inp_user= "";
$inp_pass = "";
$inp_email = "";
$inp_email_signature = "";

$role = 0;
$name = "";
$user = "";
$pass = "";
$email_signature = "";
$email = "";

$categories = array(
	0 => "Alte-Designs", 
	1 => "Neue-Designs"
);

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['role']) < 1 || strlen($_POST['role']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Benutzrolle wählen.</span><br />\n";
		$inp_role = " is-invalid";
	} else {
		$role = intval($_POST['role']);
	}

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Benutzername eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['user']) < 1 || strlen($_POST['user']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Loginname eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_user = " is-invalid";
	} else {
		$result = mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`user`='" . mysqli_real_escape_string($conn, strip_tags($_POST['user'])) . "' AND `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$user = strip_tags($_POST['user']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Loginname eingeben. (max. 128 Zeichen)</span><br />\n";
			$inp_user = " is-invalid";
		}
	}

	if(strlen($_POST['pass']) < 1 || strlen($_POST['pass']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_pass = " is-invalid";
	} else {
		$pass = strip_tags($_POST['pass']);
	}

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['email_signature']) > 65535){
		$emsg .= "<span class=\"error\">Bitte eine Email-Signatur eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_email_signature = " is-invalid";
	} else {
		$email_signature = $_POST['email_signature'];
	}

	if($emsg == ""){

		$row_design = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `design` WHERE `design`.`id`='" . intval($_POST['design_id']) . "' AND `design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	INSERT 	`admin` 
								SET 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`admin`.`role`='" . mysqli_real_escape_string($conn, intval(isset($_POST['role']) ? $_POST['role'] : 0)) . "', 
										`admin`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`admin`.`user`='" . mysqli_real_escape_string($conn, $user) . "', 
										`admin`.`pass`='" . mysqli_real_escape_string($conn, $pass) . "', 
										`admin`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`admin`.`email_signature`='" . mysqli_real_escape_string($conn, $email_signature) . "', 
										`admin`.`address_from`='" . mysqli_real_escape_string($conn, intval(isset($_POST['address_from']) ? $_POST['address_from'] : 0)) . "', 
										`admin`.`address_to`='" . mysqli_real_escape_string($conn, intval(isset($_POST['address_to']) ? $_POST['address_to'] : 0)) . "', 
										`admin`.`full_width`='" . mysqli_real_escape_string($conn, $row_design['full_width']) . "', 
										`admin`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_header_footer']) . "', 
										`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $row_design['border_header_footer']) . "', 
										`admin`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_navbar_burgermenu']) . "', 
										`admin`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_badge']) . "', 
										`admin`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_sidebar']) . "', 
										`admin`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_card']) . "', 
										`admin`.`color_card`='" . mysqli_real_escape_string($conn, $row_design['color_card']) . "', 
										`admin`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_table']) . "', 
										`admin`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_table_head']) . "', 
										`admin`.`color_table_head`='" . mysqli_real_escape_string($conn, $row_design['color_table_head']) . "', 
										`admin`.`color_link`='" . mysqli_real_escape_string($conn, $row_design['color_link']) . "', 
										`admin`.`color_text`='" . mysqli_real_escape_string($conn, $row_design['color_text']) . "', 
										`admin`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $row_design['bgcolor_select']) . "', 
										`admin`.`color_select`='" . mysqli_real_escape_string($conn, $row_design['color_select']) . "', 
										`admin`.`border_select`='" . mysqli_real_escape_string($conn, $row_design['border_select']) . "', 
										`admin`.`style`='" . mysqli_real_escape_string($conn, $row_design['style']) . "', 
										`admin`.`max_orders_target`='" . mysqli_real_escape_string($conn, intval(isset($_POST['max_orders_target']) ? $_POST['max_orders_target'] : 0)) . "', 
										`admin`.`time`='" . time() . "'");

		$_POST["id"] = $conn->insert_id;

//		writeHtpasswd($conn);

		$emsg = "<p>Der neue Benutzer wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['role']) < 1 || strlen($_POST['role']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Benutzrolle wählen.</span><br />\n";
		$inp_role = " is-invalid";
	} else {
		$role = intval($_POST['role']);
	}

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Benutzername eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['user']) < 1 || strlen($_POST['user']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Loginname eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_user = " is-invalid";
	} else {
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`admin` 
										WHERE 	`admin`.`user`='" . mysqli_real_escape_string($conn, strip_tags($_POST['user'])) . "' 
										AND 	`admin`.`id`!='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$user = strip_tags($_POST['user']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Loginname eingeben. (max. 128 Zeichen)</span><br />\n";
			$inp_user = " is-invalid";
		}
	}

	if(strlen($_POST['pass']) < 1 || strlen($_POST['pass']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_pass = " is-invalid";
	} else {
		$pass = strip_tags($_POST['pass']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['email_signature']) > 65535){
		$emsg .= "<span class=\"error\">Bitte eine Email-Signatur eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_email_signature = " is-invalid";
	} else {
		$email_signature = $_POST['email_signature'];
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`role`='" . mysqli_real_escape_string($conn, intval(isset($_POST['role']) ? $_POST['role'] : 0)) . "', 
										`admin`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`admin`.`user`='" . mysqli_real_escape_string($conn, $user) . "', 
										`admin`.`pass`='" . mysqli_real_escape_string($conn, $pass) . "', 
										`admin`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`admin`.`email_signature`='" . mysqli_real_escape_string($conn, $email_signature) . "', 
										`admin`.`address_from`='" . mysqli_real_escape_string($conn, intval(isset($_POST['address_from']) ? $_POST['address_from'] : 0)) . "', 
										`admin`.`address_to`='" . mysqli_real_escape_string($conn, intval(isset($_POST['address_to']) ? $_POST['address_to'] : 0)) . "', 
										`admin`.`max_orders_target`='" . mysqli_real_escape_string($conn, intval(isset($_POST['max_orders_target']) ? $_POST['max_orders_target'] : 0)) . "', 
										`admin`.`time`='" . mysqli_real_escape_string($conn, time()) . "' 
								WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		if($_SESSION["admin"]["id"] == intval($_POST['id'])){

			$_SESSION["admin"]["role"] = intval(isset($_POST['role']) ? $_POST['role'] : 0);

			$_SESSION["admin"]["name"] = $name;

			$_SESSION["admin"]["user"] = $user;

			$_SESSION["admin"]["email"] = $email;

			$_SESSION["admin"]["address_from"] = intval(isset($_POST['address_from']) ? $_POST['address_from'] : 0);

			$_SESSION["admin"]["address_to"] = intval(isset($_POST['address_to']) ? $_POST['address_to'] : 0);

			$_SESSION["admin"]["max_orders_target"] = intval(isset($_POST['max_orders_target']) ? $_POST['max_orders_target'] : 0);

			$result = mysqli_query($conn, "	SELECT 		`rights`.`authorization` AS authorization 
											FROM 		`admin_role_rights` 
											LEFT JOIN 	`rights` 
											ON 			`rights`.`id`=`admin_role_rights`.`right_id` 
											WHERE 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['role']) ? $_POST['role'] : 0)) . "' 
											AND 		`admin_role_rights`.`enable`='1' 
											ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

			while($row_rights = $result->fetch_array(MYSQLI_ASSOC)){

				$_SESSION["admin"]["roles"][$row_rights['authorization']] = 1;

			}

		}

//		writeHtpasswd($conn);

		$emsg = "<p>Der Benutzer wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	if(intval($maindata['supervisor_id']) != intval($_POST['id']) && intval($maindata['admin_id']) != intval($_POST['id']) && intval($maindata['storage_space_owner_id']) != intval($_POST['id'])){

		mysqli_query($conn, "	DELETE FROM	`admin` 
								WHERE 		`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		//	writeHtpasswd($conn);

	}else{

		$emsg = "<p>Dieser Benutzer kann nicht entfernt werden da er in Grunddaten zugewiesen wurde!</p>\n";

		$_POST['edit'] = "bearbeiten";

	}

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine admin.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 32){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`admin` 
													SET 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`admin`.`design_id`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`admin`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`admin`.`user`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`admin`.`pass`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`admin`.`email`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`admin`.`email_signature`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[7]))) . "', 
															`admin`.`role`='" . mysqli_real_escape_string($conn, (isset($_POST['role']) && intval($_POST['role']) > 0 ? intval($_POST['role']) : intval($data[8]))) . "', 
															`admin`.`address_from`='" . mysqli_real_escape_string($conn, intval($data[9])) . "', 
															`admin`.`address_to`='" . mysqli_real_escape_string($conn, intval($data[10])) . "', 
															`admin`.`full_width`='" . mysqli_real_escape_string($conn, intval($data[11])) . "', 
															`admin`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $data[12]) . "', 
															`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`admin`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`admin`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`admin`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`admin`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`admin`.`color_card`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`admin`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`admin`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`admin`.`color_table_head`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`admin`.`color_link`='" . mysqli_real_escape_string($conn, $data[22]) . "', 
															`admin`.`color_text`='" . mysqli_real_escape_string($conn, $data[23]) . "', 
															`admin`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $data[24]) . "', 
															`admin`.`color_select`='" . mysqli_real_escape_string($conn, $data[25]) . "', 
															`admin`.`border_select`='" . mysqli_real_escape_string($conn, $data[26]) . "', 
															`admin`.`style`='" . mysqli_real_escape_string($conn, $data[27]) . "', 
															`admin`.`ip`='" . mysqli_real_escape_string($conn, "") . "', 
															`admin`.`online`='" . mysqli_real_escape_string($conn, 0) . "', 
															`admin`.`login_date`='" . mysqli_real_escape_string($conn, 0) . "', 
															`admin`.`time`='" . time() . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`admin` 
													SET 	`admin`.`design_id`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`admin`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`admin`.`user`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`admin`.`pass`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`admin`.`email`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`admin`.`email_signature`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[7]))) . "', 
															`admin`.`role`='" . mysqli_real_escape_string($conn, (isset($_POST['role']) && intval($_POST['role']) > 0 ? intval($_POST['role']) : intval($data[8]))) . "', 
															`admin`.`address_from`='" . mysqli_real_escape_string($conn, intval($data[9])) . "', 
															`admin`.`address_to`='" . mysqli_real_escape_string($conn, intval($data[10])) . "', 
															`admin`.`full_width`='" . mysqli_real_escape_string($conn, intval($data[11])) . "', 
															`admin`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $data[12]) . "', 
															`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`admin`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`admin`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`admin`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`admin`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`admin`.`color_card`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`admin`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`admin`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`admin`.`color_table_head`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`admin`.`color_link`='" . mysqli_real_escape_string($conn, $data[22]) . "', 
															`admin`.`color_text`='" . mysqli_real_escape_string($conn, $data[23]) . "', 
															`admin`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $data[24]) . "', 
															`admin`.`color_select`='" . mysqli_real_escape_string($conn, $data[25]) . "', 
															`admin`.`border_select`='" . mysqli_real_escape_string($conn, $data[26]) . "', 
															`admin`.`style`='" . mysqli_real_escape_string($conn, $data[27]) . "', 
															`admin`.`ip`='" . mysqli_real_escape_string($conn, $data[28]) . "', 
															`admin`.`online`='" . mysqli_real_escape_string($conn, $data[29]) . "', 
															`admin`.`login_date`='" . mysqli_real_escape_string($conn, $data[30]) . "', 
															`admin`.`time`='" . $data[31] . "' 
													WHERE 	`admin`.`id`='" . intval($data[0]) . "' 
													AND 	`admin`.`company_id`='" . intval($_SESSION["admin"]["company_id"]) . "'");

						}

					}

				}

				$rows++;

			}

			fclose($handle);

		}

	}else{

		$_POST['data'] = "importieren";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$admin_session]["keyword"]) && $_SESSION[$admin_session]["keyword"] != "" ? 
			"WHERE 	(`admin`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$admin_session]["keyword"]) . "%' 
			OR		`admin`.`user` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$admin_session]["keyword"]) . "%' 
			OR		`admin`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$admin_session]["keyword"]) . "%') " : 
			"WHERE 	`admin`.`id`>0";

$query = 	"	SELECT 		*, 
							(SELECT `admin_roles`.`name` AS name FROM `admin_roles` WHERE `admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin_roles`.`id`=`admin`.`role`) AS role_name 
				FROM 		`admin` 
				" . $where . "
				AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
				ORDER BY 	" . $sorting_field_name . " " . $sorting_direction_name;

$result = mysqli_query($conn, $query);

$rows = $result->num_rows;

$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
									"of" 		=> "von", 
									"start" 	=> "|&lt;&lt;", 
									"next" 		=> "Weiter", 
									"back" 		=> "Zur&uuml;ck", 
									"end" 		=> "&gt;&gt;|", 
									"seperator" => "| "), 
									$rows, 
									$pos, 
									$amount_rows, 
									"/pos", 
									$page['url'], 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

	$checkIsInMaindata = (	
		$maindata['supervisor_id'] != $row_item['id'] && 
		$maindata['admin_id'] != $row_item['id'] && 
		$maindata['storage_space_owner_id'] != $row_item['id']
	) ? "" : 
	" class=\"bg-danger text-white\"";

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : $checkIsInMaindata) . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row_item['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . date("d.m.Y", $row_item['time']) . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['user'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<a href=\"mailto: " . $row_item['email'] . "\">" . $row_item['email'] . "</a>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['role_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . ($row_item['full_width'] == 1 ? "Volle Breite" : "Normal") . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Benutzer</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$admin_session]['keyword']) && $_SESSION[$admin_session]['keyword'] != "" ? $_SESSION[$admin_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"				<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-success\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
		"			</div>\n" . 
		"			<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 50px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"				<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"				<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"					<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"					<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"					<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"					<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"					<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"					<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"					<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"					<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"					<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"				</select>\n" . 
		"				<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"				<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"				</select>\n" . 
		"				<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"				<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"					<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"				</select>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Benutzer bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/benutzer-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

$html .= 	"<hr />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi() . 

			"<div class=\"table-responsive\">\n" . 
			"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
			"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
			"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>ID</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Datum</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Name</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"120\" scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Loginname</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Email</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"160\" scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Rolle</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\">\n" . 
			"				<strong>Layout</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Aktion</strong>\n" . 
			"			</th>\n" . 
			"		</tr></thead>\n" . 

			$list . 

			"	</table>\n" . 
			"</div>\n" . 
			"<br />\n" . 

			$pageNumberlist->getNavi() . 

			((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") || (isset($_POST['data']) && $_POST['data'] == "importieren") ? "" : "<br />\n<br />\n<br />\n");

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$options_roles = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin_roles` 
									WHERE 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin_roles`.`id` AS UNSIGNED) ASC");

	while($row_role = $result->fetch_array(MYSQLI_ASSOC)){
		$options_roles .= "								<option value=\"" . $row_role['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['role']) && intval($_POST['role']) == $row_role['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row_role['name'] . "</option>\n";
	}

	$and = "";

	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

		case 0:
			$and .= "AND `address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
			break;

		case 1:
			$and .= "AND (`address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `address_addresses`.`admin_id`=" . $maindata['admin_id'] . ") ";
			break;
		
	}

	$result_address_addresses = mysqli_query($conn, "	SELECT 		* 
														FROM 		`address_addresses` 
														WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
														" . $and . " 
														ORDER BY 	CAST(`address_addresses`.`id` AS UNSIGNED) ASC");

	$options_from_addresses = "";
	$options_to_addresses = "";

	while($row = $result_address_addresses->fetch_array(MYSQLI_ASSOC)){

		$options_from_addresses .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['address_from']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['shortcut'] . "</option>\n";
		$options_to_addresses .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['address_to']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['shortcut'] . "</option>\n";

	}

	$options_design = array(
		0 => "", 
		1 => ""
	);

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`design` 
									WHERE 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`design`.`active`='1' 
									ORDER BY 	CAST(`design`.`category_id` AS UNSIGNED) ASC, `design`.`name` ASC");

	while($row_design = $result->fetch_array(MYSQLI_ASSOC)){

		$badge_color_palette = "";

		$arr_colors = explode(",", str_replace(" ", "", $row_design['color_palette']));

		for($i = 0;$i < count($arr_colors) && $row_design['color_palette'] != "";$i++){

			$badge_color_palette .= $badge_color_palette == "" ? "<i style='color: " . $arr_colors[$i] . "'>&#9632;</i>" : " <i style='color: " . $arr_colors[$i] . "'>&#9632;</i>";

		}

		$badge_color_palette = $badge_color_palette == "" ? "<i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i>" : $badge_color_palette;

		$options_design[$row_design['category_id']] .= "			<option data-code=\"" . $badge_color_palette . "\" value=\"" . $row_design['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['design_id']) && intval($_POST['design_id']) == $row_design['id'] ? " selected=\"selected\"" : "") : (20 == $row_design['id'] ? " selected=\"selected\"" : "")) . ">" . $row_design['name'] . "</option>\n";

	}

	$options_designs = $options_design[0] . $options_design[1];

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"role\" class=\"col-sm-3 col-form-label\">Rolle <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Benutzerrolle auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"role\" name=\"role\" class=\"custom-select\">\n" . 

				$options_roles . 

				"							</select>\n" . 
				"						</div>\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name des Benutzers ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"user\" class=\"col-sm-3 col-form-label\">Loginname <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Loginname des Benutzers ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"user\" name=\"user\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $user : "") . "\" class=\"form-control" . $inp_user . "\" />\n" . 
				"						</div>\n" . 
				"						<label for=\"pass\" class=\"col-sm-3 col-form-label\">Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie das Kennwort des Benutzers ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"pass\" name=\"pass\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $pass : "") . "\" class=\"form-control" . $inp_pass . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email\" class=\"col-sm-3 col-form-label\">Email <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Email-Adresse des Benutzers ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $email : "") . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-12 col-form-label\">Email-Signatur <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Email-Signatur des Benutzers ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<textarea id=\"edit_content\" name=\"email_signature\" class=\"" . $inp_email_signature . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $email_signature : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"address_from\" class=\"col-sm-3 col-form-label\">Standard Absenderadresse <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die standard Absenderadresse ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"address_from\" name=\"address_from\" class=\"custom-select\">\n" . 

				$options_from_addresses . 

				"							</select>\n" . 
				"						</div>\n" . 
				"						<label for=\"address_to\" class=\"col-sm-3 col-form-label\">Standard Empfängeradresse <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die standard Empfängeradresse ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"address_to\" name=\"address_to\" class=\"custom-select\">\n" . 

				$options_to_addresses . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"design_id\" class=\"col-sm-3 col-form-label\">Design <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Design auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"design-id\" name=\"design_id\" class=\"custom-select\">\n" . 

				$options_designs . 

				"							</select>\n" . 
				"						</div>\n" . 
				"						<label for=\"max_orders_target\" class=\"col-sm-3 col-form-label\">Zielsetzung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie für die Zielsetzung den Wert der maximalen zu erreichenden Aufträge ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"number\" id=\"max_orders_target\" name=\"max_orders_target\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['max_orders_target']) ? intval($_POST['max_orders_target']) : 0) : 0) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
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

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$options_roles = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin_roles` 
									WHERE 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin_roles`.`id` AS UNSIGNED) ASC");

	while($row_role = $result->fetch_array(MYSQLI_ASSOC)){

		$options_roles .= "								<option value=\"" . $row_role['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['role']) == $row_role['id'] ? " selected=\"selected\"" : "") : (intval($row_item["role"]) == $row_role['id'] ? " selected=\"selected\"" : "")) . ">" . $row_role['name'] . "</option>\n";

	}

	$and = "";

	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

		case 0:
			$and .= "AND `address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
			break;

		case 1:
			$and .= "AND (`address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `address_addresses`.`admin_id`=" . $maindata['admin_id'] . ") ";
			break;
		
	}

	$result_address_addresses = mysqli_query($conn, "	SELECT 		* 
														FROM 		`address_addresses` 
														WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
														" . $and . " 
														ORDER BY 	CAST(`address_addresses`.`id` AS UNSIGNED) ASC");

	$options_from_addresses = "";
	$options_to_addresses = "";

	while($row = $result_address_addresses->fetch_array(MYSQLI_ASSOC)){

		$options_from_addresses .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['address_from']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_item["address_from"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['shortcut'] . "</option>\n";
		$options_to_addresses .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['address_to']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_item["address_to"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['shortcut'] . "</option>\n";

	}

	$colors = array(
		"primary" => "Primary", 
		"secondary" => "Secondary", 
		"success" => "Success", 
		"danger" => "Danger", 
		"warning" => "Warning", 
		"info" => "Info", 
		"light" => "Light", 
		"dark" => "Dark", 
		"body" => "Body", 
		"muted" => "Muted", 
		"white" => "White", 
		"black-50" => "Black-50", 
		"white-50" => "White-50" 
	);

	$options_color_card = "";
	$options_color_link = "";
	$options_color_text = "";
	$options_color_table_head = "";
	$options_color_select = "";

	foreach($colors as $key => $val){
		$options_color_card .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_card']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_card"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_color_link .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_link']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_link"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_color_text .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_text']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_text"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_color_table_head .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_table_head']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_table_head"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_color_select .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	}

	$bgcolors = array(
		"primary" => "Primary", 
		"secondary" => "Secondary", 
		"success" => "Success", 
		"danger" => "Danger", 
		"warning" => "Warning", 
		"info" => "Info", 
		"light" => "Light", 
		"dark" => "Dark", 
		"white" => "White", 
		"transparent" => "Transparent"
	);

	$options_bgcolor_header_footer = "";
	$options_bgcolor_navbar_burgermenu = "";
	$options_bgcolor_badge = "";
	$options_bgcolor_sidebar = "";
	$options_bgcolor_card = "";
	$options_bgcolor_table = "";
	$options_bgcolor_table_head = "";
	$options_bgcolor_select = "";

	foreach($bgcolors as $key => $val){
		$options_bgcolor_header_footer .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_header_footer']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_header_footer"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_navbar_burgermenu .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_navbar_burgermenu']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_navbar_burgermenu"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_badge .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_badge']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_badge"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_sidebar .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_sidebar']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_sidebar"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_card .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_card']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_card"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_table .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_table']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_table"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_table_head .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_table_head']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_table_head"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
		$options_bgcolor_select .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	}

	$bordercolors = array(
		"primary" => "Primary", 
		"secondary" => "Secondary", 
		"success" => "Success", 
		"danger" => "Danger", 
		"warning" => "Warning", 
		"info" => "Info", 
		"light" => "Light", 
		"dark" => "Dark", 
		"white" => "White"
	);

	$options_border_header_footer = "";

	$options_border_select = "";

	foreach($bordercolors as $key => $val){

		$options_border_header_footer .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['border_header_footer']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["border_header_footer"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";

		$options_border_select .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['border_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["border_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"role\" class=\"col-sm-3 col-form-label\">Benutzerrolle <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Benutzerrolle ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"role\" name=\"role\" class=\"custom-select\">\n" . 

				$options_roles . 

				"							</select>\n" . 
				"						</div>\n" . 

				"						<label for=\"max_orders_target\" class=\"col-sm-3 col-form-label\">Zielsetzung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"number\" id=\"max_orders_target\" name=\"max_orders_target\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['max_orders_target']) ? intval($_POST['max_orders_target']) : intval($row_item["max_orders_target"])) : intval($row_item["max_orders_target"])) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 

				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_item["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"						<label for=\"user\" class=\"col-sm-3 col-form-label\">Loginname <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Loginname dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"user\" name=\"user\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $user : strip_tags($row_item["user"])) . "\" class=\"form-control" . $inp_user . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email\" class=\"col-sm-3 col-form-label\">Email <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Email-Adresse dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : strip_tags($row_item["email"])) . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"						</div>\n" . 
				"						<label for=\"pass\" class=\"col-sm-3 col-form-label\">Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Kennwort dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"pass\" name=\"pass\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $pass : strip_tags($row_item["pass"])) . "\" class=\"form-control" . $inp_pass . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-12 col-form-label\">Email-Signatur <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Email-Signatur dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<textarea id=\"edit_content\" name=\"email_signature\" class=\"" . $inp_email_signature . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email_signature : $row_item["email_signature"]) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"address_from\" class=\"col-sm-3 col-form-label\">Standard Absenderadresse <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die standard Absenderadresse ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"address_from\" name=\"address_from\" class=\"custom-select\">\n" . 

				$options_from_addresses . 

				"							</select>\n" . 
				"						</div>\n" . 
				"						<label for=\"address_to\" class=\"col-sm-3 col-form-label\">Standard Empfängeradresse <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die standard Empfängeradresse ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"address_to\" name=\"address_to\" class=\"custom-select\">\n" . 

				$options_to_addresses . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
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

}

if(isset($_POST['data']) && $_POST['data'] == "importieren"){

	$options_roles = "								<option value=\"0\">nicht ändern</option>\n";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin_roles` 
									WHERE 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin_roles`.`id` AS UNSIGNED) ASC");

	while($row_role = $result->fetch_array(MYSQLI_ASSOC)){

		$options_roles .= "								<option value=\"" . $row_role['id'] . "\">" . $row_role['name'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Importieren</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Datei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die CSV-Datei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Mode <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_0\" name=\"mode\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_0\">\n" . 
				"									aktualisieren\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_1\" name=\"mode\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_1\">\n" . 
				"									hinzufügen\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"role\" class=\"col-sm-3 col-form-label\">Rolle <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Benutzerrolle auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"role\" name=\"role\" class=\"custom-select\">\n" . 

				$options_roles . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"data\" class=\"btn btn-primary\">Import durchführen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
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

}

?>