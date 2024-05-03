<?php 

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings` 
							WHERE 		`shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_emails` 
							WHERE 		`shopping_shoppings_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_events` 
							WHERE 		`shopping_shoppings_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_statuses` 
							WHERE 		`shopping_shoppings_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_emails` 
							WHERE 		`shopping_retoures_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_events` 
							WHERE 		`shopping_retoures_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_statuses` 
							WHERE 		`shopping_retoures_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($_POST['id']) . ".pdf");

	unset($_POST['id']);

?>