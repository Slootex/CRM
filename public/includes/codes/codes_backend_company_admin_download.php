<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "company";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`role` AS UNSIGNED) ASC, CAST(`admin`.`id` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"NAME\",\"USER\",\"PASS\",\"EMAIL\",\"EMAIL_SIGNATURE\",\"ROLE\",\"ADDRESS_FROM\",\"ADDRESS_TO\",\"FULL_WIDTH\",\"BGCOLOR_HEADER_FOOTER\",\"BORDER_HEADER_FOOTER\",\"BGCOLOR_NAVBAR_BURGERMENU\",\"BGCOLOR_BADGE\",\"BGCOLOR_SIDEBAR\",\"BGCOLOR_CARD\",\"COLOR_CARD\",\"BGCOLOR_TABLE\",\"BGCOLOR_TABLE_HEAD\",\"COLOR_TABLE_HEAD\",\"COLOR_LINK\",\"COLOR_TEXT\",\"BGCOLOR_SELECT\",\"COLOR_SELECT\",\"BORDER_SELECT\",\"IP\",\"ONLINE\",\"LOGIN_DATE\",\"TIME\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['name'] . "\",\"" . $row['user'] . "\",\"" . $row['pass'] . "\",\"" . $row['email'] . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['email_signature'])) . "\",\"" . $row['role'] . "\",\"" . $row['address_from'] . "\",\"" . $row['address_to'] . "\",\"" . $row['full_width'] . "\",\"" . $row['bgcolor_header_footer'] . "\",\"" . $row['border_header_footer'] . "\",\"" . $row['bgcolor_navbar_burgermenu'] . "\",\"" . $row['bgcolor_badge'] . "\",\"" . $row['bgcolor_sidebar'] . "\",\"" . $row['bgcolor_card'] . "\",\"" . $row['color_card'] . "\",\"" . $row['bgcolor_table'] . "\",\"" . $row['bgcolor_table_head'] . "\",\"" . $row['color_table_head'] . "\",\"" . $row['color_link'] . "\",\"" . $row['color_text'] . "\",\"" . $row['bgcolor_select'] . "\",\"" . $row['color_select'] . "\",\"" . $row['border_select'] . "\",\"" . $row['ip'] . "\",\"" . $row['online'] . "\",\"" . $row['login_date'] . "\",\"" . $row['time'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="admin.csv"');
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