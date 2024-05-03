<?php 

	$time = time();

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['id'])) . "'");

	unset($_POST['id']);

?>