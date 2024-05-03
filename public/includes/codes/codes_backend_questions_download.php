<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "questions";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0 && isset($_SESSION["questions_category"]["id"]) && intval($_SESSION["questions_category"]["id"]) > 0){

	$result_parent = mysqli_query($conn, "SELECT 		* 
											FROM 		`questions` 
											WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' 
											AND 		`questions`.`parent_id`='0' 
											ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"PARENT_ID\",\"CATEGORY_ID\",\"NAME\",\"TITLE\",\"IMAGEPATH\",\"HASH\",\"POS\",\"ENABLE\";\n";

	while($row_parent = $result_parent->fetch_array(MYSQLI_ASSOC)){

		$list .= "\"" . $row_parent['id'] . "\",\"" . $row_parent['company_id'] . "\",\"" . $row_parent['parent_id'] . "\",\"" . $row_parent['category_id'] . "\",\"" . $row_parent['name'] . "\",\"" . str_replace("\"", "&quot;", $row_parent['title']) . "\",\"" . $row_parent['imagepath'] . "\",\"" . $row_parent['hash'] . "\",\"" . $row_parent['pos'] . "\",\"" . $row_parent['enable'] . "\";\n";

		$result_sub = mysqli_query($conn, "SELECT 		* 
											FROM 		`questions` 
											WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' 
											AND 		`questions`.`parent_id`='" . $row_parent['id'] . "' 
											ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

		while($row_sub = $result_sub->fetch_array(MYSQLI_ASSOC)){

			$list .= "\"" . $row_sub['id'] . "\",\"" . $row_sub['company_id'] . "\",\"" . $row_sub['parent_id'] . "\",\"" . $row_sub['category_id'] . "\",\"" . $row_sub['name'] . "\",\"" . str_replace("\"", "&quot;", $row_sub['title']) . "\",\"" . $row_sub['imagepath'] . "\",\"" . $row_sub['hash'] . "\",\"" . $row_sub['pos'] . "\",\"" . $row_sub['enable'] . "\";\n";

		}

	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="questions.csv"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . strlen($list));
	ob_clean();
	flush();
	echo $list;
	exit();

}

?>