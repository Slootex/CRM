<?php 

	$row_packing = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);

	$tabs_navigation = "";

	$tabs_contents = "";

	for($x = 0;$x < count($tabs);$x++){

		$tab_id = str_replace($packing_right . "_tab_", "", $tabs[$x]['authorization']);

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
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-10\">\n" . 
				"						<ul class=\"nav nav-tabs card-header-tabs\" id=\"myTab\" role=\"tablist\">\n" . 

				$tabs_navigation . 

				"						</ul>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-2 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-danger btn-sm\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"melden\" title=\"\" style=\"font-size: .825rem;\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger btn-sm\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"schliessen\" title=\"\" style=\"font-size: .825rem;\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
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