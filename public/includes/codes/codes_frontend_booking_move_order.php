<?php 

@session_start();

$company_id = 1;

if(isset($param['slug']) && isset($param['password']) && isset($param['id']) && isset($param['wawi_order_number'])){

	$company = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($param['slug'])) . "'"), MYSQLI_ASSOC);

	if(isset($company['id']) && intval($company['id']) > 0){

		$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company['id'])) . "' AND `maindata`.`url_password`='" . mysqli_real_escape_string($conn, strip_tags($param['password'])) . "'"), MYSQLI_ASSOC);
	
		if(isset($maindata['id']) && intval($maindata['id']) > 0){
	
			$company_id = $maindata['company_id'];
	
			mysqli_query($conn, "	UPDATE	`order_orders` 
									SET 	`order_orders`.`wawi_order_number`='" . mysqli_real_escape_string($conn, strip_tags($param['wawi_order_number'])) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");


		}else{
	
			echo "Fehlerhafte Anfrage!\n";
	
		}

	}else{

		echo "Fehlerhafte Anfrage!\n";

	}

}else{

	header("HTTP/1.0 404 Not Found");

	echo "Fehlerhafte Anfrage!\n";

}

?>