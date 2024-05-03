<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "address_addresses";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`address_addresses` 
									WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	`address_addresses`.`shortcut` ASC");

	$list = "\"ID\",\"COMPANY_ID\",\"ADMIN_ID\",\"SHORTCUT\",\"COMPANYNAME\",\"GENDER\",\"FIRSTNAME\",\"LASTNAME\",\"STREET\",\"STREETNO\",\"ZIPCODE\",\"CITY\",\"COUNTRY\",\"PHONENUMBER\",\"MOBILNUMBER\",\"EMAIL\",\"READYTIME_HOURS\",\"READYTIME_MINUTES\",\"CLOSETIME_HOURS\",\"CLOSETIME_MINUTES\",\"WEIGHT\",\"QUANTITY\",\"SERVICECODE\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['company_id'] . "\",\"" . $row['admin_id'] . "\",\"" . $row['shortcut'] . "\",\"" . $row['companyname'] . "\",\"" . $row['gender'] . "\",\"" . $row['firstname'] . "\",\"" . $row['lastname'] . "\",\"" . $row['street'] . "\",\"" . $row['streetno'] . "\",\"" . $row['zipcode'] . "\",\"" . $row['city'] . "\",\"" . $row['country'] . "\",\"" . $row['phonenumber'] . "\",\"" . $row['mobilnumber'] . "\",\"" . $row['email'] . "\",\"" . $row['readytime_hours'] . "\",\"" . $row['readytime_minutes'] . "\",\"" . $row['closetime_hours'] . "\",\"" . $row['closetime_minutes'] . "\",\"" . $row['weight'] . "\",\"" . $row['quantity'] . "\",\"" . $row['servicecode'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="addresses.csv"');
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