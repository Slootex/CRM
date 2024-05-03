<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "statusses";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		`statuses_level`.`id` AS id, 
												`statuses_level`.`company_id` AS company_id, 
												`statuses_level`.`status_id` AS status_id, 
												`statuses_level`.`level` AS level, 
												`statuses_level`.`variant_1_text` AS variant_1_text, 
												`statuses_level`.`variant_1_time` AS variant_1_time, 
												`statuses_level`.`variant_2_text` AS variant_2_text, 
												`statuses_level`.`variant_2_time` AS variant_2_time, 
												`statuses_level`.`variant_3_text` AS variant_3_text, 
												`statuses_level`.`variant_3_time` AS variant_3_time, 
												`statuses_level`.`pos` AS pos 
									FROM 		`statuses_level` 
									WHERE 		`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`statuses_level`.`status_id` AS UNSIGNED) ASC, CAST(`statuses_level`.`pos` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"STATUS_ID\",\"LEVEL\",\"VARIANT_1_TEXT\",\"VARIANT_1_TIME\",\"VARIANT_2_TEXT\",\"VARIANT_2_TIME\",\"VARIANT_3_TEXT\",\"VARIANT_3_TIME\",\"POS\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['status_id'] . "\",\"" . $row['level'] . "\",\"" . $row['variant_1_text'] . "\",\"" . $row['variant_1_time'] . "\",\"" . $row['variant_2_text'] . "\",\"" . $row['variant_2_time'] . "\",\"" . $row['variant_3_text'] . "\",\"" . $row['variant_3_time'] . "\",\"" . $row['pos'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="status_level.csv"');
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