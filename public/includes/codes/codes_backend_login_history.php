<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "activity";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_POST["rows"])){$_SESSION["login"]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION["login"]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION["login"]["sorting_direction"] = intval($_POST["sorting_direction"]);}

$sorting = array();
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`admin_login_history`.`login_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Name", 
	"value" => "`admin_login_history`.`name`"
);
$sorting[] = array(
	"name" => "IP", 
	"value" => "`admin_login_history`.`ip`"
);
$sorting[] = array(
	"name" => "User-Agent", 
	"value" => "`admin_login_history`.`http_user_agent`"
);

$sorting_field_name = isset($_SESSION["login"]["sorting_field"]) ? $sorting[$_SESSION["login"]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION["login"]["sorting_field"]) ? $_SESSION["login"]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION["login"]["sorting_direction"]) ? $directions[$_SESSION["login"]["sorting_direction"]] : "DESC";
$sorting_direction_value = isset($_SESSION["login"]["sorting_direction"]) ? $_SESSION["login"]["sorting_direction"] : 1;

$amount_rows = isset($_SESSION["login"]["rows"]) && $_SESSION["login"]["rows"] > 0 ? $_SESSION["login"]["rows"] : 200;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`admin_login_history` 
							WHERE 		`admin_login_history`.`id`='" . intval($_POST['id']) . "' 
							AND 		`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list_online = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `admin`.`id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`admin`.`id`=" . $_SESSION["admin"]["id"] . " OR `admin`.`id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = "	SELECT 		`admin`.`id` AS id, 
						`admin`.`name` AS name, 
						`admin`.`ip` AS ip, 
						`admin`.`login_date` AS login_date 
						
			FROM 		`admin` 
			WHERE 		`admin`.`online`='1' 
			AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			" . $and . "
			ORDER BY 	CAST(`admin`.`login_date` AS UNSIGNED) DESC";

$result = mysqli_query($conn, $query);

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$condition = true;

	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

		case 0:
			$condition = $row['id'] == $_SESSION["admin"]["id"] ? true : false;
			break;

		case 1:
			$condition = $row['id'] == $_SESSION["admin"]["id"] || $row['id'] == $maindata['admin_id'] ? true : false;
			break;
		
	}

	$list_online .= 	"<form action=\"/crm/benutzer\" method=\"post\">\n" . 
						"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
						"		<td scope=\"row\">\n" . 
						"			<span>" . date("d.m.Y (H:i)", $row['login_date']) . "</span>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\">\n" . 
						"			<span>" . $row['name'] . "</span>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\">\n" . 
						"			<span>" . $row['ip'] . "</span>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 

						($_SESSION["admin"]["roles"]["admin"] == 1 && $condition == true ? 
						"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
						"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" : 
						"			-") . 

						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

}


$list = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and = "AND `admin_login_history`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and = "AND (`admin_login_history`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `admin_login_history`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}


$query = "	SELECT 		`admin_login_history`.`id` AS id, 
						`admin_login_history`.`admin_id` AS admin_id, 
						`admin_login_history`.`name` AS name, 
						`admin_login_history`.`ip` AS ip, 
						`admin_login_history`.`login_date` AS login_date, 
						`admin_login_history`.`logout_date` AS logout_date 
			FROM 		`admin_login_history` 
			WHERE 		`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			" . $and . " 
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

if($rows > 0){

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$duration = $row['logout_date'] - $row['login_date'];
		
		if($duration > 86400){
			$duration = intval($duration / 86400) . " Tage";
		}elseif($duration > 3600){
			$duration = intval($duration / 3600) . " Stunden";
		}elseif($duration > 60){
			$duration = intval($duration / 60) . " Minuten";
		}else{
			$duration = intval($duration / 1) . " Sekunden";
		}

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . date("d.m.Y (H:i)", $row['login_date']) . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . date("d.m.Y (H:i)", $row['logout_date']) . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['ip'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $duration . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"ansehen\" class=\"btn btn-sm btn-success\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Aktivitätsmonitor</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die angemeldeten Benutzer und Aktivitäten einsehen.</p>\n" . 
		"<hr />\n" . 
		"<strong><u>Online</u>:</strong><br />\n" . 
		"<br />\n" . 
		"<div class=\"table-responsive\">\n" . 
		"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"			<th width=\"140\" scope=\"col\">\n" . 
		"				<strong>Login-Datum</strong>\n" . 
		"			</th>\n" . 
		"			<th scope=\"col\">\n" . 
		"				<strong>Name</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"320\" scope=\"col\">\n" . 
		"				<strong>IP</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Aktion</strong>\n" . 
		"			</th>\n" . 
		"		</tr></thead>\n" . 

		$list_online . 

		"	</table>\n" . 
		"</div>\n" . 
		"<br />\n" . 
		"<strong><u>Aktivitäten</u>:</strong><br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-12 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\"></button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"							<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"							<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"								<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"								<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"								<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"								<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"								<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"								<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"								<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"								<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"								<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"							<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"							<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"								<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 

		$pageNumberlist->getInfo() . 

		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		"<div class=\"table-responsive\">\n" . 
		"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"			<th width=\"140\" scope=\"col\">\n" . 
		"				<strong>Login-Datum</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"140\" scope=\"col\">\n" . 
		"				<strong>Logout-Datum</strong>\n" . 
		"			</th>\n" . 
		"			<th scope=\"col\">\n" . 
		"				<strong>Name</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"320\" scope=\"col\">\n" . 
		"				<strong>IP</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"140\" scope=\"col\">\n" . 
		"				<strong>Dauer</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Aktion</strong>\n" . 
		"			</th>\n" . 
		"		</tr></thead>\n" . 

		$list . 

		"	</table>\n" . 
		"	<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"		<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
		"			<tr class=\"text-primary\">\n" . 
		"				<td width=\"350\">\n" . 
		"					<label for=\"order_sel_all_bottom\" class=\"mt-1\">(" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
		"				</td>\n" . 
		"				<td>\n" . 
		"					&nbsp;\n" . 
		"				</td>\n" . 
		"			</tr>\n" . 
		"		</table>\n" . 
		"	</form>\n" . 
		"</div>\n" . 
		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		(isset($_POST['edit']) && $_POST['edit'] == "ansehen" ? "" : "<br />\n<br />\n<br />\n");

if(isset($_POST['edit']) && $_POST['edit'] == "ansehen"){

	$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
													FROM 	`admin_login_history` 
													WHERE 	`admin_login_history`.`id`='" . intval($_POST['id']) . "' 
													AND 	`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$duration = $row['logout_date'] - $row['login_date'];
	
	if($duration > 86400){
		$duration = intval($duration / 86400) . " Tage";
	}elseif($duration > 3600){
		$duration = intval($duration / 3600) . " Stunden";
	}elseif($duration > 60){
		$duration = intval($duration / 60) . " Minuten";
	}else{
		$duration = intval($duration / 1) . " Sekunden";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Übersicht</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 
				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 

				"						<div class=\"col-sm-6\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Login-Datum</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . date("d.m.Y (H:i)", $row['login_date']) . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Logout-Datum</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . date("d.m.Y (H:i)", $row['logout_date']) . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Name</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . $row['name'] . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">IP</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . $row['ip'] . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">User-Agent</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . $row['http_user_agent'] . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Dauer</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									" . $duration . "\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 

				"						<div class=\"col-sm-6\">\n" . 


				"						</div>\n" . 

				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
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