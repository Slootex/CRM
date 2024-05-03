<?php 

	$emsg_files = "";

	$time = time();

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if(isset($_FILES["file"]["error"])){
		foreach($_FILES["file"]["error"] as $key => $error) {
			//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
				$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$sumsize+=filesize($_FILES["file"]["tmp_name"][$key]);
				}
			//}
			$j++;
		}
		if($sumsize > $upload_max_filesize * 1024 * 1024){
			$emsg_files = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	$uploaddir = 'uploads/';

	$files = "";

	$j = 1;

	if($emsg_files == ""){
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
					}else{
						$emsg_files .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES["file"]["name"][$key] . "</p>\n";
					}
				//}
				$j++;
			}
		}
	}

	if($emsg_files == "" && $files != ""){

		mysqli_query($conn, "	UPDATE 	`packing_packings` 
								SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`files`='" . mysqli_real_escape_string($conn, ($row_order['files'] == "" ? $files : $row_packing['files'] . "\r\n" . $files)) . "', 
										`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $packing_table . "_events` 
								SET 	`" . $packing_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $packing_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $packing_table . "_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing["order_id"])) . "', 
										`" . $packing_table . "_events`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $packing_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $packing_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $packing_name . ", Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $packing_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $packing_name . ", Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $packing_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
										`" . $packing_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg_files = "<p>Der " . $packing_name . " wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>