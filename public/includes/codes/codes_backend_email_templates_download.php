<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "templates";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["company"]["id"]) && intval($_SESSION["company"]["id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`templates` 
									WHERE 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "' 
									ORDER BY 	CAST(`templates`.`type` AS UNSIGNED) ASC, CAST(`templates`.`id` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"TYPE\",\"NAME\",\"FROM\",\"SUBJECT\",\"ADMIN_MAIL_SUBJECT\",\"BODY\",\"PDF_PHP_CODE\",\"MAIL_WITH_PDF\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['type'] . "\",\"" . $row['name'] . "\",\"" .  $row['from'] . "\",\"" . $row['subject'] . "\",\"" . $row['admin_mail_subject'] . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['body'])) . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['pdf_php_code'])) . "\",\"" . intval($row['mail_with_pdf']) . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="templates.csv"');
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