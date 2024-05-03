<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "company";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$company_session = "company_search";

if(isset($_POST["sorting_field"])){$_SESSION[$company_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$company_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$company_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$company_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$company_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`companies`.`name`"
);
$sorting[] = array(
	"name" => "Thema", 
	"value" => "`companies_themes`.`name`"
);
$sorting[] = array(
	"name" => "Anmelde-Slug", 
	"value" => "`companies`.`login_slug`"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`companies`.`time` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`companies`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$company_session]["sorting_field"]) ? $sorting[$_SESSION[$company_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$company_session]["sorting_field"]) ? $_SESSION[$company_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$company_session]["sorting_direction"]) ? $directions[$_SESSION[$company_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$company_session]["sorting_direction"]) ? $_SESSION[$company_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$company_session]["rows"]) && $_SESSION[$company_session]["rows"] > 0 ? $_SESSION[$company_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_login_slug = "";
$inp_theme = "";
$inp_admin_name = "";
$inp_admin_user = "";
$inp_admin_pass = "";
$inp_admin_email = "";
$inp_role = "";
$inp_admin_index = "";
$inp_logout_index = "";
$inp_user_index = "";

$name = "Firmenname";
$login_slug = "firmenname";
$theme = 0;
$admin_name = "Admin Administrator";
$admin_user = "admin";
$admin_pass = "admin";
$admin_email = "admin@firma.de";
$role = "Administrator";
$admin_index = "/crm/neue-auftraege";
$logout_index = "/crm/abmelden";
$user_index = "/kunden/dashboard";

$categories = array(
	0 => "Alte-Designs", 
	1 => "Neue-Designs"
);

$time = time();

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Firmenname eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$result = mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['name'])) . "'");
		if($result->num_rows == 0){
			$name = strip_tags($_POST['name']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Firmenname eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_name = " is-invalid";
		}
	}

	if(!isset($_POST['theme']) || (isset($_POST['theme']) && intval($_POST['theme']) < 1)){
		$emsg .= "<span class=\"error\">Bitte ein Thema auswählen.</span><br />\n";
		$inp_theme = " is-invalid";
	} else {
		$theme = intval($_POST['theme']);
	}

	if(strlen($_POST['login_slug']) < 1 || strlen($_POST['login_slug']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Anmelde-Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_login_slug = " is-invalid";
	} else {
		$result = mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($_POST['login_slug'])) . "'");
		if($result->num_rows == 0){
			$login_slug = strip_tags($_POST['login_slug']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Anmelde-Slug eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_login_slug = " is-invalid";
		}
	}

	if(strlen($_POST['admin_name']) < 1 || strlen($_POST['admin_name']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Name des Administrators eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_name = " is-invalid";
	} else {
		$admin_name = strip_tags($_POST['admin_name']);
	}

	if(strlen($_POST['admin_user']) < 1 || strlen($_POST['admin_user']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Anmeldename des Administrators eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_user = " is-invalid";
	} else {
		$admin_user = strip_tags($_POST['admin_user']);
	}

	if(strlen($_POST['admin_pass']) < 1 || strlen($_POST['admin_pass']) > 256){
		$emsg .= "<span class=\"error\">Bitte das Kennwort des Administrators eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_pass = " is-invalid";
	} else {
		$admin_pass = strip_tags($_POST['admin_pass']);
	}

	if($_POST['admin_email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['admin_email'])){
		$admin_email = strip_tags($_POST['admin_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die E-Mail-Adresse des Administrators ein.</small><br />\n";
		$inp_admin_email = " is-invalid";
	}

	if(strlen($_POST['role']) < 1 || strlen($_POST['role']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Name der Administrator-Rolle eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_role = " is-invalid";
	} else {
		$role = strip_tags($_POST['role']);
	}

	if(strlen($_POST['admin_index']) < 1 || strlen($_POST['admin_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte die URL für den Admin-Index eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_index = " is-invalid";
	} else {
		$admin_index = strip_tags($_POST['admin_index']);
	}

	if(strlen($_POST['logout_index']) < 1 || strlen($_POST['logout_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte die URL für den Abmelden-Index eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_logout_index = " is-invalid";
	} else {
		$logout_index = strip_tags($_POST['logout_index']);
	}

	if(strlen($_POST['user_index']) < 1 || strlen($_POST['user_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte die URL für den Kunden-Index eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_user_index = " is-invalid";
	} else {
		$user_index = strip_tags($_POST['user_index']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`companies` 
								SET 	`companies`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`companies`.`theme_id`='" . mysqli_real_escape_string($conn, $theme) . "', 
										`companies`.`login_slug`='" . mysqli_real_escape_string($conn, $login_slug) . "', 
										`companies`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		mkdir("uploads/company/" . intval($_POST["id"]), 0777);

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`folders` 
										ORDER BY 	`folders`.`name` ASC");
		
		while($row_folders = $result->fetch_array(MYSQLI_ASSOC)){

			mkdir("uploads/company/" . intval($_POST["id"]) . "/" . $row_folders['folder'], 0777);

			if($row_folders['htaccess'] == 1){
				
				copy("includes/.htaccess", "uploads/company/" . intval($_POST["id"]) . "/" . $row_folders['folder'] . "/.htaccess");

			}

		}

		mysqli_query($conn, "	INSERT 	`maindata` 
								SET 	`maindata`.`company`='" . mysqli_real_escape_string($conn, $name) . "', 
										`maindata`.`logout_index`='" . mysqli_real_escape_string($conn, $logout_index) . "', 
										`maindata`.`user_index`='" . mysqli_real_escape_string($conn, $user_index) . "', 
										`maindata`.`delete_temp_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		mysqli_query($conn, "	INSERT 	`admin_roles` 
								SET 	`admin_roles`.`name`='" . mysqli_real_escape_string($conn, $role) . "', 
										`admin_roles`.`admin_index`='" . mysqli_real_escape_string($conn, $admin_index) . "', 
										`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$role_id = $conn->insert_id;

		$row_design = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `design` WHERE `design`.`id`='" . intval($_POST['design_id']) . "' AND `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	INSERT 	`admin` 
								SET 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`admin`.`name`='" . mysqli_real_escape_string($conn, $admin_name) . "', 
										`admin`.`user`='" . mysqli_real_escape_string($conn, $admin_user) . "', 
										`admin`.`pass`='" . mysqli_real_escape_string($conn, $admin_pass) . "', 
										`admin`.`email`='" . mysqli_real_escape_string($conn, $admin_email) . "', 
										`admin`.`role`='" . mysqli_real_escape_string($conn, intval($role_id)) . "', 
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
										`admin`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`rights` 
										ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row_rights = $result->fetch_array(MYSQLI_ASSOC)){

			mysqli_query($conn, "	INSERT 	`company_rights` 
									SET 	`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`company_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($row_rights['id'])) . "', 
											`company_rights`.`enable`='" . mysqli_real_escape_string($conn, (isset($_POST[$row_rights['authorization']]) && intval($_POST[$row_rights['authorization']]) == 1 ? 1 : 0)) . "'");

			if(isset($_POST[$row_rights['authorization']]) && intval($_POST[$row_rights['authorization']]) == 1){

				mysqli_query($conn, "	INSERT 	`admin_role_rights` 
										SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($role_id)) . "', 
												`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($row_rights['id'])) . "', 
												`admin_role_rights`.`enable`='1'");

			}

		}

		$emsg = "<p>Die neue Firma wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Firmenname eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`companies` 
										WHERE 	`companies`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['name'])) . "' 
										AND 	`companies`.`id`!='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");
		if($result->num_rows == 0){
			$name = strip_tags($_POST['name']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Firmenname eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_name = " is-invalid";
		}
	}

	if(!isset($_POST['theme']) || (isset($_POST['theme']) && intval($_POST['theme']) < 1)){
		$emsg .= "<span class=\"error\">Bitte ein Thema auswählen.</span><br />\n";
		$inp_theme = " is-invalid";
	} else {
		$theme = intval($_POST['theme']);
	}

	if(strlen($_POST['login_slug']) < 1 || strlen($_POST['login_slug']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Anmelde-Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_login_slug = " is-invalid";
	} else {
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`companies` 
										WHERE 	`companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($_POST['login_slug'])) . "' 
										AND 	`companies`.`id`!='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");
		if($result->num_rows == 0){
			$login_slug = strip_tags($_POST['login_slug']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Anmelde-Slug eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_login_slug = " is-invalid";
		}
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`companies` 
								SET 	`companies`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`companies`.`theme_id`='" . mysqli_real_escape_string($conn, $theme) . "', 
										`companies`.`login_slug`='" . mysqli_real_escape_string($conn, $login_slug) . "' 
								WHERE 	`companies`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		mysqli_query($conn, "	DELETE FROM	`company_rights` 
								WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`rights` 
										ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row_rights = $result->fetch_array(MYSQLI_ASSOC)){

			mysqli_query($conn, "	INSERT 	`company_rights` 
									SET 	`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`company_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($row_rights['id'])) . "', 
											`company_rights`.`enable`='" . mysqli_real_escape_string($conn, (isset($_POST[$row_rights['authorization']]) && intval($_POST[$row_rights['authorization']]) == 1 ? 1 : 0)) . "'");

		}

		$emsg = "<p>Die Firma wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`address_addresses` 
							WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin` 
							WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin_login_history` 
							WHERE 		`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin_roles` 
							WHERE 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin_role_rights` 
							WHERE 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`attachments_matrix` 
							WHERE 		`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog` 
							WHERE 		`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog_categories` 
							WHERE 		`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog_comments` 
							WHERE 		`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog_posts` 
							WHERE 		`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog_tags` 
							WHERE 		`blog_tags`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`companies` 
							WHERE 		`companies`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`company_rights` 
							WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`design` 
							WHERE 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`file_attachments` 
							WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_customer_messages` 
							WHERE 		`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_emails` 
							WHERE 		`interested_interesteds_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_events` 
							WHERE 		`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_files` 
							WHERE 		`interested_interesteds_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_history` 
							WHERE 		`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_packing_history` 
							WHERE 		`interested_interesteds_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_statuses` 
							WHERE 		`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`maindata` 
							WHERE 		`maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_customer_messages` 
							WHERE 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	$result_devices = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

		if($row_device['storage_space_id'] > 0){
			// delete used part of a place
			mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
		}

	}

	mysqli_query($conn, "	DELETE FROM	`order_orders_audios` 
							WHERE 		`order_orders_audios`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices_events` 
							WHERE 		`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_emails` 
							WHERE 		`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_events` 
							WHERE 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_files` 
							WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_history` 
							WHERE 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_packing_history` 
							WHERE 		`order_orders_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_payings` 
							WHERE 		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_questions` 
							WHERE 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_shipments` 
							WHERE 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_statuses` 
							WHERE 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`pickup_pickups` 
							WHERE 		`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	$result_packings = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	while($row_packing = $result_packings->fetch_array(MYSQLI_ASSOC)){

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/packing/" . $row_packing['packing_number'] . "/document/*.*")));
	
		@unlink("uploads/company/" . intval($_POST['id']) . "/packing/" . $row_packing['packing_number'] . "/document/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/packing/" . $row_packing['packing_number'] . "/document");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/packing/" . $row_packing['packing_number']);

	}

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`intern_interns` 
							WHERE 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings` 
							WHERE 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
							WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_events` 
							WHERE 		`packing_packings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_statuses` 
							WHERE 		`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`reasons` 
							WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`questions` 
							WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shipping_history` 
							WHERE 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shipping_messages` 
							WHERE 		`shipping_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings` 
							WHERE 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_emails` 
							WHERE 		`shopping_shoppings_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_events` 
							WHERE 		`shopping_shoppings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_statuses` 
							WHERE 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_emails` 
							WHERE 		`shopping_retoures_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_events` 
							WHERE 		`shopping_retoures_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_statuses` 
							WHERE 		`shopping_retoures_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`statuses` 
							WHERE 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`storage_places` 
							WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`storage_rooms` 
							WHERE 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`templates` 
							WHERE 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`text_history` 
							WHERE 		`text_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`text_modules` 
							WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_customer_messages` 
							WHERE 		`user_users_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_emails` 
							WHERE 		`user_users_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_events` 
							WHERE 		`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_files` 
							WHERE 		`user_users_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_history` 
							WHERE 		`user_users_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users_statuses` 
							WHERE 		`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	$result_orders = mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	while($row_order = $result_orders->fetch_array(MYSQLI_ASSOC)){

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/userdata/*.*")));
	
		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/document/*.*")));
	
		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/audio/*.*")));

		@unlink("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/userdata/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/userdata");
		@unlink("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/document/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/document");
		@unlink("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/audio/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number'] . "/audio");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/order/" . $row_order['order_number']);

	}

	$result_users = mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	while($row_user = $result_users->fetch_array(MYSQLI_ASSOC)){

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/userdata/*.*")));

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/document/*.*")));

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/audio/*.*")));

		@unlink("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/userdata/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/userdata");
		@unlink("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/document/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/document");
		@unlink("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/audio/.htaccess");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number'] . "/audio");
		@rmdir("uploads/company/" . intval($_POST['id']) . "/user/" . $row_user['user_number']);

	}

	mysqli_query($conn, "	DELETE FROM	`order_orders` 
							WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`user_users` 
							WHERE 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`folders` 
									WHERE		`folders`.`folder`!='order' 
									AND			`folders`.`folder`!='packing' 
									AND			`folders`.`folder`!='user' 
									ORDER BY 	`folders`.`name` ASC");
	
	while($row_folders = $result->fetch_array(MYSQLI_ASSOC)){

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_POST['id']) . "/" . $row_folders['folder'] . "/*.*")));

		if($row_folders['htaccess'] == 1){
			
			@unlink("uploads/company/" . intval($_POST['id']) . "/" . $row_folders['folder'] . "/.htaccess");

		}

		@rmdir("uploads/company/" . intval($_POST['id']) . "/" . $row_folders['folder']);

	}

	@rmdir("uploads/company/" . intval($_POST['id']) . "/order");
	@rmdir("uploads/company/" . intval($_POST['id']) . "/packing");
	@rmdir("uploads/company/" . intval($_POST['id']) . "/user");
	@rmdir("uploads/company/" . intval($_POST['id']));

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$company_session]["keyword"]) && $_SESSION[$company_session]["keyword"] != "" ? 
			"WHERE 	(`companies`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$company_session]["keyword"]) . "%') " : 
			"WHERE 	`companies`.`id`>0";

$query = 	"	SELECT 		`companies`.`id` AS id, 
							`companies`.`name` AS name, 
							`companies`.`login_slug` AS login_slug, 
							`companies`.`time` AS time, 
							`companies_themes`.`name` AS theme_name 
				FROM 		`companies` 
				LEFT JOIN 	`companies_themes` 
				ON 			`companies_themes`.`id`=`companies`.`theme_id` 
				" . $where . "
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

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && intval($_POST['id']) == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row_item['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . date("d.m.Y", intval($row_item['time'])) . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['theme_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['login_slug'] . "</span>\n" . 
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
		"		<h3>Admin - Firma</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$company_session]['keyword']) && $_SESSION[$company_session]['keyword'] != "" ? $_SESSION[$company_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Firmen bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">Firma hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
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
			"			<th width=\"70\" scope=\"col\" class=\"text-center\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Datum</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
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
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Thema</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Anmelde-Slug</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
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

			((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$data = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights` 
									ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$data[] = $row;

	}

	$menu = array();

	for($i = 0;$i < count($data);$i++){

		if($data[$i]['parent_id'] == 0){

			if(!isset($menu[$data[$i]['area_id']])){
				$menu[$data[$i]['area_id']] = "";
			}

			$icon = "fa-minus";
			$attributes = "";

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id']){
					$icon = "fa-plus-square-o";
					$attributes = " style=\"cursor: pointer\" onclick=\"$('#sub_" . $data[$i]['id'] . "').slideToggle(400);if(\$('#sub_icon_" . $data[$i]['id'] . "').hasClass('fa-minus-square-o')){\$('#sub_icon_" . $data[$i]['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#sub_icon_" . $data[$i]['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\"";
				}

			}

			$menu[$data[$i]['area_id']] .= 	"					<div class=\"form-group row\">\n" . 
											"						<div class=\"col-sm-1\">&nbsp;</div>\n" . 
											"						<label class=\"col-sm-1 col-form-label text-center\"><i id=\"sub_icon_" . $data[$i]['id'] . "\" class=\"fa " . $icon . "\" aria-hidden=\"true\"" . $attributes . "></i></label>\n" . 
											"						<label class=\"col-sm-4 col-form-label\"" . $attributes . ">" . $data[$i]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Firma zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
											"						<div class=\"col-sm-6\">\n" . 
											"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
											"								<input type=\"checkbox\" id=\"" . $data[$i]['authorization'] . "\" name=\"" . $data[$i]['authorization'] . "\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST[$data[$i]['authorization']]) : intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : 1)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
											"								<label class=\"custom-control-label font-weight-light\" for=\"" . $data[$i]['authorization'] . "\">\n" . 
											"									Ja\n" . 
											"								</label>\n" . 
											"							</div>\n" . 
											"						</div>\n" . 
											"					</div>\n";

			if($attributes != ""){
				$menu[$data[$i]['area_id']] .= 	"					<div id=\"sub_" . $data[$i]['id'] . "\" style=\"display: none\">\n";
			}

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id']){

					$menu[$data[$i]['area_id']] .= 	"					<div class=\"form-group row\">\n" . 
													"						<div class=\"col-sm-2\">&nbsp;</div>\n" . 
													"						<label class=\"col-sm-1 col-form-label text-center\"><i class=\"fa fa-minus\" aria-hidden=\"true\"></i></label>\n" . 
													"						<label class=\"col-sm-3 col-form-label\">" . $data[$j]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Firma zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
													"						<div class=\"col-sm-6\">\n" . 
													"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
													"								<input type=\"checkbox\" id=\"" . $data[$j]['authorization'] . "\" name=\"" . $data[$j]['authorization'] . "\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST[$data[$j]['authorization']]) : intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : 1)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
													"								<label class=\"custom-control-label font-weight-light\" for=\"" . $data[$j]['authorization'] . "\">\n" . 
													"									Ja\n" . 
													"								</label>\n" . 
													"							</div>\n" . 
													"						</div>\n" . 
													"					</div>\n";

				}

			}

			if($attributes != ""){
				$menu[$data[$i]['area_id']] .= 	"					</div>\n";
			}

		}

	}

	$result = mysqli_query($conn, "SELECT * FROM `companies_themes` ORDER BY CAST(`companies_themes`.`id` AS UNSIGNED) ASC");

	$options_themes = "";

	while($t = $result->fetch_array(MYSQLI_ASSOC)){

		$options_themes .= "<option value=\"" . $t['id'] . "\"" . (isset($_POST["theme"]) && $t["id"] == intval($_POST["theme"]) ? " selected=\"selected\"" : "") . ">" . $t['name'] . "</option>\n";

	}

	$options_design = array(
		0 => "", 
		1 => ""
	);

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`design` 
									WHERE 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
									ORDER BY 	CAST(`design`.`category_id` AS UNSIGNED) ASC, `design`.`name` ASC");

	while($row_design = $result->fetch_array(MYSQLI_ASSOC)){

		$badge_color_palette = "";

		$arr_colors = explode(",", str_replace(" ", "", $row_design['color_palette']));

		for($i = 0;$i < count($arr_colors) && $row_design['color_palette'] != "";$i++){

			$badge_color_palette .= $badge_color_palette == "" ? "<i style='color: " . $arr_colors[$i] . "'>&#9632;</i>" : " <i style='color: " . $arr_colors[$i] . "'>&#9632;</i>";

		}

		$badge_color_palette = $badge_color_palette == "" ? "<i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i> <i style='color: #474747'>&#9632;</i>" : $badge_color_palette;

		$options_design[$row_design['category_id']] .= "			<option data-code=\"" . $badge_color_palette . "\" value=\"" . $row_design['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['design_id']) && intval($_POST['design_id']) == $row_design['id'] ? " selected=\"selected\"" : "") : (1 == $row_design['id'] ? " selected=\"selected\"" : "")) . ">" . $row_design['name'] . "</option>\n";

	}

	$options_designs = $options_design[0] . $options_design[1];

	$rights_categories = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights_categories` 
									ORDER BY 	CAST(`rights_categories`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$rights_categories .= 	"					<div class=\"form-group row\">\n" . 
								"						<div class=\"col-sm-1 text-right\"><i id=\"icon_" . $row['id'] . "\" class=\"fa fa-plus-square-o\" aria-hidden=\"true\" style=\"cursor: pointer\" onclick=\"\$('#t_" . $row['id'] . "').slideToggle(400);if(\$('#icon_" . $row['id'] . "').hasClass('fa-minus-square-o')){\$('#icon_" . $row['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#icon_" . $row['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\"></i></div>\n" . 
								"						<div class=\"col-sm-11\" style=\"cursor: pointer\" onclick=\"$('#t_" . $row['id'] . "').slideToggle(400);if(\$('#icon_" . $row['id'] . "').hasClass('fa-minus-square-o')){\$('#icon_" . $row['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#icon_" . $row['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\">\n" . 
								"							<strong>" . $row['name'] . "</strong>\n" . 
								"						</div>\n" . 
								"					</div>\n" . 

								"					<div id=\"t_" . $row['id'] . "\" style=\"display: none\">\n" . 
								
								$menu[$row['id']] . 
								
								"					</div>\n";

	}

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
				"						<div class=\"col-sm-12\">\n" . 
				"							<h4><u>Daten</u>:</h4>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"name\" class=\"col-sm-5 col-form-label\">Name der Firma <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name der Firma ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : $name) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"theme\" class=\"col-sm-5 col-form-label\">Thema <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie das Thema der Firma aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"theme\" name=\"theme\" class=\"custom-select\">" . $options_themes . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"login_slug\" class=\"col-sm-5 col-form-label\">Anmelde-Slug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Anmelde-Slug der Firma ein. (a-zA-Z0-9\\-\\_)\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"login_slug\" name=\"login_slug\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $login_slug : $login_slug) . "\" class=\"form-control" . $inp_login_slug . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"admin_name\" class=\"col-sm-5 col-form-label\">Name des Administrators <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name des Administrators ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_name\" name=\"admin_name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_name : $admin_name) . "\" class=\"form-control" . $inp_admin_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"admin_user\" class=\"col-sm-5 col-form-label\">Anmeldename des Administrators <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Anmeldename des Administrators ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_user\" name=\"admin_user\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_user : $admin_user) . "\" class=\"form-control" . $inp_admin_user . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"admin_pass\" class=\"col-sm-5 col-form-label\">Kennwort des Administrators <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie das Kennwort des Administrators ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_pass\" name=\"admin_pass\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_pass : $admin_pass) . "\" class=\"form-control" . $inp_admin_pass . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"theme\" class=\"col-sm-5 col-form-label\">Thema <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie das Thema der Firma aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"theme\" name=\"theme\" class=\"custom-select\">" . $options_themes . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"admin_email\" class=\"col-sm-5 col-form-label\">E-Mail-Adresse des Administrators <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die E-Mail-Adresse des Administrators ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_email\" name=\"admin_email\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_email : $admin_email) . "\" class=\"form-control" . $inp_admin_email . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"role\" class=\"col-sm-5 col-form-label\">Rolle des Administrators <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name der Administrator-Rolle ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"role\" name=\"role\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $role : $role) . "\" class=\"form-control" . $inp_role . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"design_id\" class=\"col-sm-5 col-form-label\">Design für den Administrator <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie das Design für den Administrator aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"design-id\" name=\"design_id\" class=\"custom-select\">\n" . 

				$options_designs . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"admin_index\" class=\"col-sm-5 col-form-label\">Admin-Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die URL für die Admin-Index-Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_index\" name=\"admin_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_index : $admin_index) . "\" class=\"form-control" . $inp_admin_index . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"logout_index\" class=\"col-sm-5 col-form-label\">Abmelden-Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die URL für die Abmelden-Index-Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"logout_index\" name=\"logout_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $logout_index : $logout_index) . "\" class=\"form-control" . $inp_logout_index . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"user_index\" class=\"col-sm-5 col-form-label\">Kunden-Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie die Kunden-Index-Seite aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"user_index\" name=\"user_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $user_index : $user_index) . "\" class=\"form-control" . $inp_user_index . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h4><u>Berechtigungen</u>:</h4>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				$rights_categories . 

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

	$_SESSION["company"]["id"] = intval($_POST['id']);

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$data = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights` 
									ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$data[] = $row;

	}

	$company_rights = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`company_rights` 
									WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
									ORDER BY 	CAST(`company_rights`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$company_rights[$row['right_id']] = $row;

	}

	$menu = array();

	for($i = 0;$i < count($data);$i++){

		if($data[$i]['parent_id'] == 0){

			if(!isset($menu[$data[$i]['area_id']])){

				$menu[$data[$i]['area_id']] = "";

			}

			$icon = "fa-minus";
			$attributes = "";

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id']){
					$icon = "fa-plus-square-o";
					$attributes = " style=\"cursor: pointer\" onclick=\"$('#sub_" . $data[$i]['id'] . "').slideToggle(400);if(\$('#sub_icon_" . $data[$i]['id'] . "').hasClass('fa-minus-square-o')){\$('#sub_icon_" . $data[$i]['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#sub_icon_" . $data[$i]['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\"";
				}

			}

			$menu[$data[$i]['area_id']] .= 	"					<div class=\"form-group row\">\n" . 
											"						<div class=\"col-sm-1\">&nbsp;</div>\n" . 
											"						<label class=\"col-sm-1 col-form-label text-center\"><i id=\"sub_icon_" . $data[$i]['id'] . "\" class=\"fa " . $icon . "\" aria-hidden=\"true\"" . $attributes . "></i></label>\n" . 
											"						<label class=\"col-sm-4 col-form-label\"" . $attributes . ">" . $data[$i]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Firma zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
											"						<div class=\"col-sm-6\">\n" . 
											"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
											"								<input type=\"checkbox\" id=\"" . $data[$i]['authorization'] . "\" name=\"" . $data[$i]['authorization'] . "\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST[$data[$i]['authorization']]) : intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : (isset($company_rights[$data[$i]['id']]) ? $company_rights[$data[$i]['id']]['enable'] : 0))) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
											"								<label class=\"custom-control-label font-weight-light\" for=\"" . $data[$i]['authorization'] . "\">\n" . 
											"									Ja\n" . 
											"								</label>\n" . 
											"							</div>\n" . 
											"						</div>\n" . 
											"					</div>\n";

			if($attributes != ""){
				$menu[$data[$i]['area_id']] .= 	"					<div id=\"sub_" . $data[$i]['id'] . "\" style=\"display: none\">\n";
			}

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id']){

					$menu[$data[$i]['area_id']] .= 	"					<div class=\"form-group row\">\n" . 
													"						<div class=\"col-sm-2\">&nbsp;</div>\n" . 
													"						<label class=\"col-sm-1 col-form-label text-center\"><i class=\"fa fa-minus\" aria-hidden=\"true\"></i></label>\n" . 
													"						<label class=\"col-sm-3 col-form-label\">" . $data[$j]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Firma zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
													"						<div class=\"col-sm-6\">\n" . 
													"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
													"								<input type=\"checkbox\" id=\"" . $data[$j]['authorization'] . "\" name=\"" . $data[$j]['authorization'] . "\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST[$data[$j]['authorization']]) : intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : (isset($company_rights[$data[$j]['id']]) ? $company_rights[$data[$j]['id']]['enable'] : 0))) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
													"								<label class=\"custom-control-label font-weight-light\" for=\"" . $data[$j]['authorization'] . "\">\n" . 
													"									Ja\n" . 
													"								</label>\n" . 
													"							</div>\n" . 
													"						</div>\n" . 
													"					</div>\n";

				}

			}

			if($attributes != ""){
				$menu[$data[$i]['area_id']] .= 	"					</div>\n";
			}

		}

	}

	$result = mysqli_query($conn, "SELECT * FROM `companies_themes` ORDER BY CAST(`companies_themes`.`id` AS UNSIGNED) ASC");

	$options_themes = "";

	while($t = $result->fetch_array(MYSQLI_ASSOC)){

		$options_themes .= "<option value=\"" . $t['id'] . "\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $theme : $row_item['theme_id']) == $t["id"] ? " selected=\"selected\"" : "") . ">" . $t['name'] . "</option>\n";

	}

	$rights_categories = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights_categories` 
									ORDER BY 	CAST(`rights_categories`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$rights_categories .= 	"					<div class=\"form-group row\">\n" . 
								"						<div class=\"col-sm-1 text-right\"><i id=\"icon_" . $row['id'] . "\" class=\"fa fa-plus-square-o\" aria-hidden=\"true\" style=\"cursor: pointer\" onclick=\"\$('#t_" . $row['id'] . "').slideToggle(400);if(\$('#icon_" . $row['id'] . "').hasClass('fa-minus-square-o')){\$('#icon_" . $row['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#icon_" . $row['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\"></i></div>\n" . 
								"						<div class=\"col-sm-11\" style=\"cursor: pointer\" onclick=\"$('#t_" . $row['id'] . "').slideToggle(400);if(\$('#icon_" . $row['id'] . "').hasClass('fa-minus-square-o')){\$('#icon_" . $row['id'] . "').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');}else{\$('#icon_" . $row['id'] . "').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');}\">\n" . 
								"							<strong>" . $row['name'] . "</strong>\n" . 
								"						</div>\n" . 
								"					</div>\n" . 

								"					<div id=\"t_" . $row['id'] . "\" style=\"display: none\">\n" . 
								
								$menu[$row['id']] . 
								
								"					</div>\n";

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
				"						<div class=\"col-sm-12\">\n" . 
				"							<h4><u>Daten</u>:</h4>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"name\" class=\"col-sm-5 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieser Firma ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_item["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"theme\" class=\"col-sm-5 col-form-label\">Thema <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie das Thema der Firma aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"theme\" name=\"theme\" class=\"custom-select\">" . $options_themes . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;</label>\n" . 
				"						<label for=\"login_slug\" class=\"col-sm-5 col-form-label\">Anmelde-Slug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Anmelde-Slug dieser Firma ändern. (a-zA-Z0-9-_)\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"login_slug\" name=\"login_slug\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $login_slug : strip_tags($row_item["login_slug"])) . "\" class=\"form-control" . $inp_login_slug . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h4><u>Berechtigungen</u>:</h4>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				$rights_categories . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<a href=\"/crm/firma-benutzer-herunterladen\" class=\"btn btn-primary\">Benutzer herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>\n" . 
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

?>