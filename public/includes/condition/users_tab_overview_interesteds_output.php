<?php 

	$view_interested_list = "";

	$where = 	isset($_SESSION[$users_session]["view_interested_keyword"]) && $_SESSION[$users_session]["view_interested_keyword"] != "" ? 
				"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 

				OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 

				OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%' 
				OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["view_interested_keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `order_orders`.`mode`=2 " : " AND `order_orders`.`mode`=2 ";
	$and .= isset($_SESSION[$users_session]["view_interested_extra_search"]) && $_SESSION[$users_session]["view_interested_extra_search"] > 0 ? "AND (SELECT `statuses`.`id` AS id FROM `order_orders_statuses` LEFT JOIN `statuses` ON `statuses`.`id`=`order_orders_statuses`.`status_id` WHERE `order_orders_statuses`.`order_id`=`order_orders`.`id` AND `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION[$users_session]["view_interested_extra_search"] : "";

	$and .= "AND `order_orders`.`user_id`=" . $row_user['id'] . " ";

	$query = 	"	SELECT 		`order_orders`.`id` AS id, 
								`order_orders`.`order_number` AS order_number, 
								`order_orders`.`companyname` AS companyname, 
								`order_orders`.`firstname` AS firstname, 
								`order_orders`.`lastname` AS lastname, 
								`order_orders`.`upd_date` AS time, 

								(SELECT `order_orders_statuses`.`time` AS time FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) ASC limit 0, 1) AS status_time, 

								(SELECT `order_orders_statuses`.`subject` AS subject FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) ASC limit 0, 1) AS status_subject, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

								(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

								(SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS color 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

								(SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_id, 

								`order_orders`.`admin_id` AS admin_id 
								
					FROM 		`order_orders` 
					" . $where . $and . " 
					AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
					ORDER BY 	`status_name` ASC, CAST(`order_orders`.`upd_date` AS UNSIGNED) DESC";

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

	$view_interestedNumberlist->setParam(	array(	"page" 		=> "Seite", 
													"of" 		=> "von", 
													"start" 	=> "|&lt;&lt;", 
													"next" 		=> "Weiter", 
													"back" 		=> "Zur&uuml;ck", 
													"end" 		=> "&gt;&gt;|", 
													"seperator" => "| "), 
													$rows, 
													$view_interestedpage, 
													$view_interested_amount_rows, 
													"/auftraegeseite", 
													$users_action . "/" . intval($_POST['id']), 
													$getParam="", 
													10, 
													1);

	$query .= " limit " . $view_interestedpage . ", " . $view_interested_amount_rows;

	$result = mysqli_query($conn, $query);

	if($rows > 0){

		while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

			$view_interested_list .= 	"<form action=\"" . $users_action . "\" method=\"post\">\n" . 
										"	<tr>\n" . 
										"		<td scope=\"row\">\n" . 
										"			<small>" . $row_orders['order_number'] . "</small>\n" . 
										"		</td>\n" . 
										"		<td>\n" . 
										"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
										"		</td>\n" . 
										"		<td>\n" . 
										"			<small>" . $row_orders['admin_name'] . "</small>\n" . 
										"		</td>\n" . 
										"		<td align=\"center\">\n" . 
										"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_orders['status_color'] . "\">" . $row_orders['status_name'] . "</span>\n" . 
										"		</td>\n" . 
										"		<td>\n" . 
										"			<small>" . $row_orders['companyname'] . ", " . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small>\n" . 
										"		</td>\n" . 
										"		<td align=\"center\">\n" . 
										"			<a href=\"/crm/neue-interessenten/bearbeiten/" . $row_orders['id'] . "\" target=\"_blank\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>\n" . 
										"		</td>\n" . 
										"	</tr>\n" . 
										"</form>\n";

		}

	}else{

		$view_interested_list = isset($_POST['view_interested_search']) && $_POST['view_interested_search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$users_session]["interested_keyword"] . " - übereinstimmende Aufträge gefunden.')</script>\n" : "";

	}

	$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`type`=1 AND `statuses`.`extra_search`=1 ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$view_interested_extra_search_options = "						<option value=\"0\"" . (isset($_SESSION[$users_session]['interested_extra_search']) && $_SESSION[$users_session]['interested_extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

	while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
		$view_interested_extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION[$users_session]['interested_extra_search']) && $_SESSION[$users_session]['interested_extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
	}

	$html_view_interested = 	"		<form action=\"" . $user_action . "\" method=\"post\">\n" . 
								"			<div class=\"form-group row mb-0\">\n" . 
								"				<label for=\"view_interested_keyword\" class=\"col-sm-1 col-form-label\">Stichwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie mit Stichwörten nach Aufträgen suchen.\">?</span></label>\n" . 
								"				<div class=\"col-sm-3\">\n" . 
								"					<input type=\"text\" id=\"view_interested_keyword\" name=\"view_interested_keyword\" value=\"" . (isset($_SESSION['users']['view_interested_keyword']) && $_SESSION['users']['view_interested_keyword'] != "" ? $_SESSION['users']['view_interested_keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" />\n" . 
								"				</div>\n" . 
								"				<div class=\"col-sm-6\">\n" . 
								"					<select id=\"interested_extra_search\" name=\"interested_extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.view_interested_search.click()\">\n" . 

								$view_interested_extra_search_options . 

								"					</select>\n" . 
								"				</div>\n" . 
								"				<div class=\"col-sm-2\">\n" . 
								"					<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
								"					<button type=\"submit\" name=\"view_interested_search\" value=\"suchen\" class=\"btn btn-primary\">suchen <i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
								"				</div>\n" . 
								"			</div>\n" . 
								"		</form>\n" . 
								"		<hr />\n" . 

								$view_interestedNumberlist->getInfo() . 

								"		<br />\n" . 

								$view_interestedNumberlist->getNavi() . 

								"		<div class=\"table-responsive\">\n" . 
								"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
								"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
								"					<th width=\"110\" scope=\"col\">\n" . 
								"						<strong>Auftrags Nr.</strong>\n" . 
								"					</th>\n" . 
								"					<th width=\"130\" scope=\"col\">\n" . 
								"						<strong>Letzter Status</strong>\n" . 
								"					</th>\n" . 
								"					<th scope=\"col\">\n" . 
								"						<strong>Mitarbeiter</strong>\n" . 
								"					</th>\n" . 
								"					<th scope=\"col\">\n" . 
								"						<strong>Status</strong>\n" . 
								"					</th>\n" . 
								"					<th scope=\"col\">\n" . 
								"						<strong>Kunde</strong>\n" . 
								"					</th>\n" . 
								"					<th width=\"210\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
								"						<strong>Aktion</strong>\n" . 
								"					</th>\n" . 
								"				</tr></thead>\n" . 

								$view_interested_list . 

								"			</table>\n" . 
								"		</div>\n" . 
								"		<br />\n" . 

								$view_interestedNumberlist->getNavi();

	$tabs_contents .= $html_view_interested;

?>