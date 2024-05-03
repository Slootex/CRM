<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

if(isset($param['hash'])){

	$exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `user_users`.`reghash`='" . mysqli_real_escape_string($conn, strip_tags($param['hash'])) . "' limit 0, 1"), MYSQLI_ASSOC);

	if(isset($exist_user['id'])){

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`regverify`='1', 
										`user_users`.`reghash`='' 
								WHERE 	`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($exist_user['id'])) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		$_SESSION["user"]["id"] = $exist_user["id"];
		$_SESSION["user"]["firstname"] = $exist_user["firstname"];
		$_SESSION["user"]["lastname"] = $exist_user["lastname"];
		$_SESSION["user"]["email"] = $exist_user["email"];

		header('Location: /kunden/dashboard');
		exit();

	}else{

		header("Location: " . $systemdata['unuser_index']);
		exit();
	}

}else{

	header("Location: " . $systemdata['unuser_index']);
	exit();
}

?>
