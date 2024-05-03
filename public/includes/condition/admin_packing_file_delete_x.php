<?php 

	$time = time();

	$files = "";

	$arr_files = explode("\r\n", $row_packing['files']);

	$file_id = 0;
	$file_name = "";

	for($i = 0;$i < count($arr_files);$i++){
		if($i == intval($_POST['item'])){
			@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document/" . $arr_files[$i]);
			$file_id = ($i + 1);
			$file_name = $arr_files[$i];
		}else{
			$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
		}
	}

	mysqli_query($conn, "	UPDATE 	`packing_packings` 
							SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`packing_packings`.`files`='" . mysqli_real_escape_string($conn, $files) . "', 
									`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`" . $packing_table . "_events` 
							SET 	`" . $packing_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $packing_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $packing_table . "_events`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`" . $packing_table . "_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing["order_id"])) . "', 
									`" . $packing_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`" . $packing_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`" . $packing_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`" . $packing_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
									`" . $packing_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST['edit'] = "bearbeiten";

?>