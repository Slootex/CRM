<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "navigation";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["menu"]["id"]) && intval($_SESSION["menu"]["id"]) > 0){

	$result_parent = mysqli_query($conn, "SELECT * FROM `navigation` WHERE `navigation`.`menu_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["menu"]["id"])) . "' AND `navigation`.`parent_id`='0' ORDER BY CAST(`navigation`.`pos` AS UNSIGNED) ASC");

	$list = "\"ID\",\"PARENT_ID\",\"MENU_ID\",\"NAME\",\"TITLE\",\"HREF\",\"AUTHORIZATION\",\"AUTHORIZATION2\",\"POS\",\"ENABLE\";\n";

	while($row_parent = $result_parent->fetch_array(MYSQLI_ASSOC)){

		$list .= "\"" . $row_parent['id'] . "\",\"" . $row_parent['parent_id'] . "\",\"" . $row_parent['menu_id'] . "\",\"" . $row_parent['name'] . "\",\"" . $row_parent['title'] . "\",\"" . $row_parent['href'] . "\",\"" . $row_parent['authorization'] . "\",\"" . $row_parent['authorization2'] . "\",\"" . $row_parent['pos'] . "\",\"" . $row_parent['enable'] . "\";\n";
					

		$result_sub = mysqli_query($conn, "SELECT * FROM `navigation` WHERE `navigation`.`menu_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["menu"]["id"])) . "' AND `navigation`.`parent_id`='" . $row_parent['id'] . "' ORDER BY CAST(`navigation`.`pos` AS UNSIGNED) ASC");

		while($row_sub = $result_sub->fetch_array(MYSQLI_ASSOC)){

			$list .= "\"" . $row_sub['id'] . "\",\"" . $row_sub['parent_id'] . "\",\"" . $row_sub['menu_id'] . "\",\"" . $row_sub['name'] . "\",\"" . $row_sub['title'] . "\",\"" . $row_sub['href'] . "\",\"" . $row_sub['authorization'] . "\",\"" . $row_sub['authorization2'] . "\",\"" . $row_sub['pos'] . "\",\"" . $row_sub['enable'] . "\";\n";

		}

	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="navigation_' . intval($_SESSION["menu"]["id"]) . '.csv"');
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