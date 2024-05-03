<?php 

	$time = time();

	$files = "";

	$arr_files = explode("\r\n", $row_order['userdata']);

	$file_id = 0;
	$file_name = "";

	for($i = 0;$i < count($arr_files);$i++){
		if($i == intval($_POST['item'])){
			@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i]);
			$file_id = ($i + 1);
			$file_name = $arr_files[$i];
		}else{
			$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
		}
	}

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, $files) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
							SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
									`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST['edit'] = "bearbeiten";

?>