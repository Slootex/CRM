<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "storage_places";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0 && isset($_SESSION["room"]["id"]) && intval($_SESSION["room"]["id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`storage_places` 
									WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`storage_places`.`room_id`=" . mysqli_real_escape_string($conn, intval($_SESSION["room"]["id"])) . " 
									ORDER BY 	CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"ROOM_ID\",\"NAME\",\"PARTS\",\"USED\",\"POS\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['room_id'] . "\",\"" . $row['name'] . "\",\"" . $row['parts'] . "\",\"" . $row['used'] . "\",\"" . $row['pos'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="storage_places.csv"');
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