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

	$result = mysqli_query($conn, "	SELECT 		`statuses`.`id` AS id, 
												`statuses`.`company_id` AS company_id, 
												`statuses`.`type` AS type, 
												`statuses`.`name` AS name, 
												`statuses`.`color` AS color, 
												`statuses`.`email_template` AS email_template, 
												`statuses`.`extra_search` AS extra_search, 
												`statuses`.`multi_status` AS multi_status, 
												`statuses`.`usermail` AS usermail, 
												`statuses`.`adminmail` AS adminmail, 
												`statuses`.`public` AS public 
									FROM 		`statuses` 
									WHERE 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`statuses`.`type` AS UNSIGNED) ASC, CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"TYPE\",\"NAME\",\"COLOR\",\"EMAIL_TEMPLATE\",\"EXTRA_SEARCH\",\"MULTI_STATUS\",\"USERMAIL\",\"ADMINMAIL\",\"PUBLIC\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['type'] . "\",\"" . $row['name'] . "\",\"" . $row['color'] . "\",\"" . $row['email_template'] . "\",\"" . $row['extra_search'] . "\",\"" . $row['multi_status'] . "\",\"" . $row['usermail'] . "\",\"" . $row['adminmail'] . "\",\"" . $row['public'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="status.csv"');
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