<?php 

	if($row_order['user_id'] > 0){

		$row_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `user_users`.`id`='" . intval($row_order['user_id']) . "'"), MYSQLI_ASSOC);

		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE id=" . intval($row_user['country'])), MYSQLI_ASSOC);

		$html_add_user = 	"				<h4>Zugewiesener Kunde: [#" . $row_user['user_number'] . "]</h4>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Firma</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['companyname'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Vorname</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['firstname'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Lastname</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['lastname'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Straße</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['street'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Hausnummer</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['streetno'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">PLZ</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['zipcode'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Stadt</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['city'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Ort</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['city'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Land</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_country['name'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Telefon</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['phonenumber'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Mobil</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['mobilnumber'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"form-group row\">\n" . 
							"					<label class=\"col-sm-6 col-form-label\">Email</label>\n" . 
							"					<div class=\"col-sm-6\">\n" . 
							"						" . $row_user['email'] . "\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<br />\n" . 
							"				<a href=\"/crm/neue-kunden/bearbeiten/" . $row_user['id'] . "\" target=\"_blank\" class=\"btn btn-success\">KUNDENDATEN bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>\n";

	}else{

		$user_list = "";

		$where = 	isset($_SESSION[$order_session]["user_keyword"]) && $_SESSION[$order_session]["user_keyword"] != "" ? 
					"WHERE 	(`user_users`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`user_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 

					OR		`user_users`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 

					OR		`user_users`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%' 
					OR		`user_users`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["user_keyword"]) . "%') " : 
					"";

		$and = $where == "" ? "WHERE `user_users`.`mode`=0 " : " AND `user_users`.`mode`=0 ";
		$and .= isset($_SESSION[$order_session]["user_extra_search"]) && $_SESSION[$order_session]["user_extra_search"] > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`user_users_statuses`.`status_id`) AS id FROM `user_users_statuses` WHERE `user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `user_users_statuses`.`user_id`=`user_users`.`id` ORDER BY CAST(`user_users_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION[$order_session]["user_extra_search"] : "";

		$query = 	"	SELECT 		`user_users`.`id` AS id, 
									`user_users`.`user_number` AS user_number, 
									`user_users`.`companyname` AS companyname, 
									`user_users`.`firstname` AS firstname, 
									`user_users`.`lastname` AS lastname, 
									`user_users`.`upd_date` AS time, 

									(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`user_users`.`admin_id`) AS admin_name, 

									(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`user_users_statuses`.`status_id`) AS name 
										FROM 	`user_users_statuses` 
										WHERE 	`user_users_statuses`.`user_id`=`user_users`.`id` 
										AND 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY CAST(`user_users_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

									(SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`user_users_statuses`.`status_id`) AS color 
										FROM 	`user_users_statuses` 
										WHERE 	`user_users_statuses`.`user_id`=`user_users`.`id` 
										AND 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY CAST(`user_users_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

									(SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`user_users_statuses`.`status_id`) AS id 
										FROM 	`user_users_statuses` 
										WHERE 	`user_users_statuses`.`user_id`=`user_users`.`id` 
										AND 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY CAST(`user_users_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_id, 

									`user_users`.`admin_id` AS admin_id 
									
						FROM 		`user_users` 
						" . $where . $and . " 
						AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
						ORDER BY 	`status_name` ASC, CAST(`user_users`.`upd_date` AS UNSIGNED) DESC";

		$result = mysqli_query($conn, $query);

		$rows = $result->num_rows;

		$userNumberlist->setParam(	array(	"page" 		=> "Seite", 
											"of" 		=> "von", 
											"start" 	=> "|&lt;&lt;", 
											"next" 		=> "Weiter", 
											"back" 		=> "Zur&uuml;ck", 
											"end" 		=> "&gt;&gt;|", 
											"seperator" => "| "), 
											$rows, 
											$userpage, 
											$user_amount_rows, 
											"/kundenseite", 
											$order_action . "/" . intval($_POST['id']), 
											$getParam="", 
											10, 
											1);

		$query .= " limit " . $userpage . ", " . $user_amount_rows;

		$result = mysqli_query($conn, $query);

		if($rows > 0){

			while($row_users = $result->fetch_array(MYSQLI_ASSOC)){

				$user_list .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
								"	<tr>\n" . 
								"		<td scope=\"row\">\n" . 
								"			<small>" . $row_users['user_number'] . "</small>\n" . 
								"		</td>\n" . 
								"		<td>\n" . 
								"			<small>" . date("d.m.Y", $row_users['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_users['time']) . "</small>\n" . 
								"		</td>\n" . 
								"		<td>\n" . 
								"			<small>" . $row_users['admin_name'] . "</small>\n" . 
								"		</td>\n" . 
								"		<td align=\"center\">\n" . 
								"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_users['status_color'] . "\">" . $row_users['status_name'] . "</span>\n" . 
								"		</td>\n" . 
								"		<td>\n" . 
								"			<small>" . ($row_users['companyname'] != "" ? $row_users['companyname'] . ", " : "") . $row_users['firstname'] . " " . $row_users['lastname'] . "</small>\n" . 
								"		</td>\n" . 
								"		<td align=\"center\">\n" . 
								"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
								"			<input type=\"hidden\" name=\"user_id\" value=\"" . $row_users['id'] . "\" />\n" . 
								"			<button type=\"submit\" name=\"add_user\" value=\"zuweisen\" class=\"btn btn-sm btn-success\">zuweisen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></button>\n" . 
								"		</td>\n" . 
								"	</tr>\n" . 
								"</form>\n";

			}

		}else{

			$user_list = isset($_POST['user_search']) && $_POST['user_search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$order_session]["user_keyword"] . " - übereinstimmende Kunden gefunden.')</script>\n" : "";

		}

		$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`type`=3 AND `statuses`.`extra_search`=1 ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

		$user_extra_search_options = "						<option value=\"0\"" . (isset($_SESSION[$order_session]['user_extra_search']) && $_SESSION[$order_session]['user_extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

		while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

			$user_extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION[$order_session]['user_extra_search']) && $_SESSION[$order_session]['user_extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

		}

		$html_add_user = 	"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"			<div class=\"form-group row mb-0\">\n" . 
							"				<label for=\"user_keyword\" class=\"col-sm-1 col-form-label\">Stichwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie mit Stichwörten nach Kunden suchen.\">?</span></label>\n" . 
							"				<div class=\"col-sm-3\">\n" . 
							"					<input type=\"text\" id=\"user_keyword\" name=\"user_keyword\" value=\"" . (isset($_SESSION['orders']['user_keyword']) && $_SESSION['orders']['user_keyword'] != "" ? $_SESSION['orders']['user_keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" />\n" . 
							"				</div>\n" . 
							"				<div class=\"col-sm-6\">\n" . 
							"					<select id=\"user_extra_search\" name=\"user_extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.user_search.click()\">\n" . 

							$user_extra_search_options . 

							"					</select>\n" . 
							"				</div>\n" . 
							"				<div class=\"col-sm-2\">\n" . 
							"					<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
							"					<button type=\"submit\" name=\"user_search\" value=\"suchen\" class=\"btn btn-primary\">suchen <i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
							"				</div>\n" . 
							"			</div>\n" . 
							"		</form>\n" . 
							"		<hr />\n" . 

							$userNumberlist->getInfo() . 

							"		<br />\n" . 

							$userNumberlist->getNavi() . 

							"		<div class=\"table-responsive\">\n" . 
							"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"					<th width=\"110\" scope=\"col\">\n" . 
							"						<strong>Kunden Nr.</strong>\n" . 
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

							$user_list . 

							"			</table>\n" . 
							"			<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"				<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
							"					<tr class=\"text-primary\">\n" . 
							"						<td width=\"350\">\n" . 
							"							<label for=\"order_sel_all_bottom\" class=\"mt-1\">(" . (1+($userpage > $rows ? $rows : $userpage)) . " bis " . (($userpage + $user_amount_rows) > $rows ? $rows : ($userpage + $user_amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
							"						</td>\n" . 
							"						<td>\n" . 
							"							&nbsp;\n" . 
							"						</td>\n" . 
							"					</tr>\n" . 
							"				</table>\n" . 
							"			</form>\n" . 
							"		</div>\n" . 
							"		<br />\n" . 

							$userNumberlist->getNavi();

	}

	$tabs_contents .= $html_add_user;

?>