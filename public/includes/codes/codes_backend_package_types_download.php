<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "package_types";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`package_templates` 
									ORDER BY 	CAST(`package_templates`.`id` AS UNSIGNED) ASC");

	$list = "\"ID\",\"NAME\",\"WEIGHT\",\"LENGTH\",\"WIDTH\",\"HEIGHT\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['name'] . "\",\"" . $row['weight'] . "\",\"" . $row['length'] . "\",\"" . $row['width'] . "\",\"" . $row['height'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="package_types.csv"');
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