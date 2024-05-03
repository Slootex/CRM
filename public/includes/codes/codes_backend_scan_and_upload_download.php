<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "scan_and_upload";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

if(!isset($param['company']) || !isset($param['file'])){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$row_company = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	`companies`.`id` AS id 
														FROM 	`companies` 
														WHERE 	`companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($param['company'])) . "'"), MYSQLI_ASSOC);

if(isset($row_company['id'])){

	$filepath = str_replace("..", "", "uploads/company/" . $row_company['id'] . "/scan/" . strip_tags($param['file']));

	if(file_exists($filepath)){

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"" . strip_tags($param['file']) . "\"");

		readfile($filepath);

	}

}

?>