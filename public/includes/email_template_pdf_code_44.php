<?php

	$filename = "begleitschein.pdf";

	$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo.png', 167, 5.6, 35.6, 27.6);

?>