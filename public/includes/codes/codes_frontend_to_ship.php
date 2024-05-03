<?php 

@session_start();

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$html = "";

if(isset($param['label']) && $param['label'] != "" && isset($param['company_id']) && intval($param['company_id']) > 0 && isset($param['shipments_id']) && $param['shipments_id'] != ""){

	$row_shipments = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																FROM 		`shipping_history` 
																WHERE 		`shipping_history`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($param['shipments_id'])) . "' 
																AND 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($param['company_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_shipments['id']) && $row_shipments['id'] > 0 && isset($param['label']) && $param['label'] == "label"){

/*		$im = 'data:image/gif;base64,'. $row_shipments['graphic_image_jpeg'];

		$pdf = new Fpdi();

		$pdf->AddPage();

		$pdf->Image($im, 20, 20, 200, 100, 'gif');

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);*/

		$im = imagecreatefromstring(base64_decode($row_shipments['graphic_image_gif']));

		$im = imagerotate($im, -90, 0);

		ob_start(); 
		imagegif($im);
		$imageBase64 = "data:image/gif;base64," . base64_encode(ob_get_contents());
		ob_end_clean();

		$pdf = new Fpdi();

		$pdf->AddPage();

		$pdf->Image($imageBase64, 5, 5, 200, 335, 'gif');

//		$pdf->Image('uploads/company/' . intval($company_id) . '/img/logo_gzamotors.png', 130, 50, 50);

//		$pdf->Image('uploads/company/' . intval($company_id) . '/img/logo.png', 8, 276, 20);

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);

	}

}

?>