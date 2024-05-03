<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "templates";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["company"]["id"]) && intval($_SESSION["company"]["id"]) > 0){

	$tarFile = 'temp/condition.tar';

	$tar = new PharData($tarFile);

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`templates` 
									WHERE 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "' 
									ORDER BY 	CAST(`templates`.`type` AS UNSIGNED) ASC, CAST(`templates`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$tar->addFile('includes/email_template_pdf_code_' . $row['id'] . '.php', 'email_template_pdf_code_' . $row['id'] . '.php');
	}

	$dest = $tarFile . '.gz';
	$mode = 'wb9';
	$error = false;
	if($fp_out = gzopen($dest, $mode)){
		if($fp_in = fopen($tarFile, 'rb')){
			while(!feof($fp_in)){
				gzwrite($fp_out, fread($fp_in, 1024 * 512));
			}
			fclose($fp_in);
		}else{
			$error = true;
		}
		gzclose($fp_out);
		sleep(10);
		unlink($tarFile);
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="condition.tar.gz"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($dest));
	ob_clean();
	flush();
	readfile($dest);
	exit();

}

?>