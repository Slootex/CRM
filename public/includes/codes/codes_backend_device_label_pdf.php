<?php 

@session_start();

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "packing_packings";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$html = "";

if(isset($param['id']) && $param['id'] != ""){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		*, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
															FROM 		`order_orders_devices` 
															WHERE 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "' 
															AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	if(isset($row_device['id'])){

		$pdf = new Fpdi('P', 'mm', array(12, 55));

		$pdf->AddPage();

		//$pdf->Rect(0, 0, 11, 55, 'D');

		//$pdf->Code39_90_degree(1, 54, utf8_decode($row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))), 0.67, 10, 0);
		//$pdf->Code128(1, 1, utf8_decode($row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))), 53, 5);
		$pdf->Code128_90_degree(1, 48.5, utf8_decode($row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))), 6.5, 43);

		$pdf->SetFont('Arial', '', 11);
		$pdf->RotatedText(11.4, 42, utf8_decode($row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))), 90);

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);

	}

}

if(isset($param['shopin_id']) && $param['shopin_id'] != ""){

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		*, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`shopin_shopins`.`storage_space_id`) AS storage_space 
															FROM 		`shopin_shopins` 
															WHERE 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($param['shopin_id'])) . "' 
															AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	if(isset($row_shopin['id'])){

		$pdf = new Fpdi('P', 'mm', array(12, 55));

		$pdf->AddPage();

		//$pdf->Rect(0, 0, 11, 55, 'D');

		//$pdf->Code39_90_degree(1, 47, utf8_decode($row_shopin['help_device_number'] . "-" . $row_shopin['storage_space']), 0.6707317073170732, 5, 0);
		$pdf->Code128_90_degree(1, 48.5, utf8_decode($row_shopin['help_device_number'] . "-" . $row_shopin['storage_space']), 6.5, 43);

		$pdf->SetFont('Arial', '', 11);
		$pdf->RotatedText(11.4, 40, utf8_decode($row_shopin['help_device_number']), 90);

		$pdf->SetFont('Arial', '', 11);
		$pdf->RotatedText(11.4, 28, utf8_decode($row_shopin['storage_space']), 90);

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);

	}

}

?>