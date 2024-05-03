<?php 

	$show_autocomplete_script = 1;

	$row_user = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
																	(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $users_table . "_statuses`.`status_id`) AS name 
																		FROM 	`" . $users_table . "_statuses` 
																		WHERE 	`" . $users_table . "_statuses`.`" . $users_id_field . "`=`user_users`.`id` 
																		AND 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		ORDER BY CAST(`" . $users_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name 
															FROM 	`user_users` 
															WHERE 	`user_users`.`id`='" . intval($_POST['id']) . "' 
															AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$options_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];
	}

	$tabs_navigation = "";

	$tabs_contents = "";

	for($x = 0;$x < count($tabs);$x++){

		$tab_id = str_replace($users_right . "_tab_", "", $tabs[$x]['authorization']);

		$tab_name = $tabs[$x]['name'];

		if(isset($_SESSION["admin"]["roles"][$tabs[$x]['authorization']]) && $_SESSION["admin"]["roles"][$tabs[$x]['authorization']] == 1){

			$tabs_navigation .= "					<li class=\"nav-item\">\n" . 
								"						<a class=\"nav-link text-" . $_SESSION["admin"]["color_link"] . ($parameter['tab'] == $tab_id ? " active" : "") . "\" id=\"" . $tab_id . "-tab\" data-toggle=\"tab\" href=\"#" . $tab_id . "\" role=\"tab\" aria-controls=\"edit\" aria-selected=\"" . ($parameter['tab'] == $tab_id ? "true" : "false") . "\">" . $tab_name . "</a>\n" . 
								"					</li>\n";

			$tabs_contents .= "			<div class=\"card-body tab-pane fade px-3 pt-3 pb-0" . ($parameter['tab'] == $tab_id ? " show active" : "") . "\" id=\"" . $tab_id . "\" role=\"tabpanel\" aria-labelledby=\"" . $tab_id . "-tab\">\n";

			include("includes/condition/" . $tabs[$x]['output']);

			$tabs_contents .= "			</div>\n";

		}

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<ul class=\"nav nav-tabs card-header-tabs\" id=\"myTab\" role=\"tablist\">\n" . 

				$tabs_navigation . 

				"				</ul>\n" . 
				"			</div>\n" . 
				"			<div class=\"tab-content\" id=\"myTabContent\">\n" . 

				$tabs_contents . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>