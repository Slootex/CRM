<?php 

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`public`='" . mysqli_real_escape_string($conn, intval(isset($_POST['public']) ? $_POST['public'] : 0)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['edit'] = "bearbeiten";

?>