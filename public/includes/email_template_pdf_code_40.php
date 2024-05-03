<?php 

	$filename = "begleitschein.pdf";

	$im = imagecreatefromstring(base64_decode(strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)));

	$im = imagerotate($im, -90, 0);

	ob_start(); 
	imagegif($im);
	$imageBase64 = "data:image/gif;base64," . base64_encode(ob_get_contents());
	ob_end_clean();

	$pdf->Image($imageBase64, 5, 5, 200, 335, 'gif');

	$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo_gzamotors.png', 130, 50, 50);

	$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo.png', 8, 276, 20);

?>