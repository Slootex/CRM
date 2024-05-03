<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "text_modules";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_modules` 
									WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_modules`.`id` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"NAME\",\"TEXT\",\"TECH_INFO\",\"PRICE_TOTAL\",\"RADIO_PAYING\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['name'] . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['text'])) . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['tech_info'])) . "\",\"" . $row['price_total'] . "\",\"" . $row['radio_paying'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="text_modules.csv"');
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