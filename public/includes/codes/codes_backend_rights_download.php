<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "rights";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["right_category"]["id"]) && intval($_SESSION["right_category"]["id"]) > 0){

	$result_parent = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='0' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

	$list = "\"ID\",\"PARENT_ID\",\"AREA_ID\",\"NAME\",\"AUTHORIZATION\",\"POS\";\n";

	while($row_parent = $result_parent->fetch_array(MYSQLI_ASSOC)){

		$list .= "\"" . $row_parent['id'] . "\",\"" . $row_parent['parent_id'] . "\",\"" . $row_parent['area_id'] . "\",\"" . $row_parent['name'] . "\",\"" . $row_parent['authorization'] . "\",\"" . $row_parent['pos'] . "\";\n";
					

		$result_sub = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='" . $row_parent['id'] . "' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row_sub = $result_sub->fetch_array(MYSQLI_ASSOC)){

			$list .= "\"" . $row_sub['id'] . "\",\"" . $row_sub['parent_id'] . "\",\"" . $row_sub['area_id'] . "\",\"" . $row_sub['name'] . "\",\"" . $row_sub['authorization'] . "\",\"" . $row_sub['pos'] . "\";\n";

		}

	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="rights_' . intval($_SESSION["right_category"]["id"]) . '.csv"');
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