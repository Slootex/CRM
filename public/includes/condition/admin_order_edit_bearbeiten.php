<?php 

	$show_autocomplete_script = 1;

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
																	(SELECT 	(SELECT `statuses`.`id` AS sid FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $order_table . "_statuses`.`status_id`) AS sid 
																		FROM 	`" . $order_table . "_statuses` 
																		WHERE 	`" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` 
																		AND 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		ORDER BY CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS last_status_id, 
																	(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $order_table . "_statuses`.`status_id`) AS name 
																		FROM 	`" . $order_table . "_statuses` 
																		WHERE 	`" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` 
																		AND 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		ORDER BY CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 
																	(SELECT COUNT(*) AS amount FROM `statuses_level` WHERE `statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses_level`.`status_id`=last_status_id) AS level_amount, 
																	(SELECT COUNT(*) AS a_d FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`=`order_orders`.`id`) AS devices_amount, 
																	(SELECT COUNT(*) AS a_p FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`mode`='0' AND `packing_packings`.`order_id`=`order_orders`.`id`) AS packings_amount, 
																	(SELECT COUNT(*) AS a_i FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `intern_interns`.`mode`='0' AND `intern_interns`.`order_id`=`order_orders`.`id`) AS interns_amount, 
																	(SELECT COUNT(*) AS a_s FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`mode`='0' AND `shopin_shopins`.`order_id`=`order_orders`.`id`) AS shopins_amount 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);

	$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

	$tabs_navigation = "";

	$tabs_contents = "";

	for($x = 0;$x < count($tabs);$x++){

		$tab_id = str_replace($order_right . "_tab_", "", $tabs[$x]['authorization']);

		$tab_name = $tabs[$x]['name'];

		if(
			(isset($_SESSION["admin"]["roles"][$tabs[$x]['authorization']]) && $_SESSION["admin"]["roles"][$tabs[$x]['authorization']] == 1 && $tab_id != "new_shipping_tab") || 
			(isset($_SESSION["admin"]["roles"][$tabs[$x]['authorization']]) && $_SESSION["admin"]["roles"][$tabs[$x]['authorization']] == 1 && $tab_id == "new_shipping_tab" && ((isset($row_last_paying['id']) && $row_last_paying["radio_payment"] == 1 && $row_last_paying["radio_shipping"] < 2) || (isset($row_last_paying['id']) && $row_last_paying["radio_payment"] == 0 && $row_last_paying["radio_shipping"] < 2 && $row_last_paying["payed"] == 1) || (isset($row_last_paying['id']) && $row_last_paying["radio_payment"] == 2 && $row_last_paying["radio_shipping"] < 2 && $row_last_paying["payed"] == 1)))
		){

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