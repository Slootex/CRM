<?php 

/**
 * @package DBB-System\Includes
 * @author Dirk Binnenböse <overfutz@yahoo.com>
 * @copyright 2021 DBB-System
 * @license http://opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 */

function getPage($conn, $param, $page_selection){

	$result = $conn->query("SELECT 	`pages`.*, 
									`pages_codes`.`name` AS `code_name`, 
									`pages_templates`.`name` AS `template_name` 
							FROM 	`pages`,
									`pages_codes`,
									`pages_templates`
							WHERE 	`pages`.`id`='" . $page_selection . "' 
							AND 	`pages_codes`.`id`=`pages`.`code_id` 
							AND 	`pages_templates`.`id`=`pages`.`template_id`");

	$page = $result->fetch_array(MYSQLI_ASSOC);

	include('includes/codes/' . $page['code_name'] . '.php');

	include('includes/templates/' . $page['template_name'] . '.php');

}

function getScriptRecallDates($conn){

	$time = time();

	$time_min = strtotime(date("d.m.Y", $time));

	$time_max = $time_min + 86400;

	$script =	"<script>\n" . 
				"var dates = [\n";

	$result = mysqli_query($conn, "	SELECT 		`order_orders`.`id` AS  id, 
												`order_orders`.`mode` AS  mode, 
												`order_orders`.`recall_date` AS  recall_date 
									FROM 		`order_orders` 
									WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
									AND 		`order_orders`.`mode`>='2' 
									AND			`order_orders`.`recall_date`!='' 
									AND 		`order_orders`.`recall_date`>='" . mysqli_real_escape_string($conn, $time_min) . "' 
									ORDER BY	CAST(`order_orders`.`recall_date` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$script .= "	{\"id\": " . $row['id'] . ", \"mode\": " . $row['mode'] . ", \"today\": " . ($row['recall_date'] >= $time_min && $row['recall_date'] < $time_max ? "true" : "false") . ", \"date\": \"" . date("d.m.Y H:i", $row['recall_date']) . "\"}, \n"; //[1, 2, 21.09.2021 11:00]
	}

	$script .=	"];\n" . 
				"</script>\n";

	return $script;

}

function filterFilename($filename, $length = 255){

	$search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");

	$replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");

	$filename = str_replace($search, $replace, $filename);

	$filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

	$filename = strtolower($filename);

	if(strlen($filename) > $length){

		$filename = substr($filename, (strlen($filename) - $length));

	}

	return $filename;

}

?>