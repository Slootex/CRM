<?php 

@session_start();

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$html = "";

if(isset($param['shipment']) && $param['shipment'] != "" && isset($param['company_id']) && intval($param['company_id']) > 0 && isset($param['shipments_id']) && $param['shipments_id'] != ""){

	if($param['shipment'] == "label-blank"){

		$row_shipments = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																	FROM 		`shipping_history` 
																	WHERE 		`shipping_history`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($param['shipments_id'])) . "' 
																	AND 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($param['company_id'])) . "'"), MYSQLI_ASSOC);

	}else{

		$row_shipments = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																	FROM 		`order_orders_shipments` 
																	WHERE 		`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($param['shipments_id'])) . "' 
																	AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($param['company_id'])) . "'"), MYSQLI_ASSOC);

	}

	if(isset($row_shipments['id']) && $row_shipments['id'] > 0 && isset($param['shipment']) && ($param['shipment'] == "label" || $param['shipment'] == "label-blank")){

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

//		$pdf->Image('uploads/company/' . intval($param['company_id']) . '/img/logo_gzamotors.png', 130, 50, 50);

//		$pdf->Image('uploads/company/' . intval($param['company_id']) . '/img/logo.png', 8, 276, 20);

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);

	}

	if(isset($row_shipments['id']) && $row_shipments['id'] > 0 && isset($param['shipment']) && $param['shipment'] == "verfolgen"){

		$parts = parse_url($row_shipments['tracking_url']);
		$href = $parts['scheme'] . "://" . $parts['host'];
		$str = str_replace("\\n", "\\n", file_get_contents($row_shipments['tracking_url']));
		$str = str_replace("href=\"/", "href=\"" . $href . "/", $str);
		$str = str_replace("=\"\/assets", "=\"" . $href . "/assets", $str);
		$str = str_replace("/assets/logos", $href . "/assets/logos", $str);
		$replace  = "/<link rel=\"stylesheet\" media=\"screen\" href=\"([^\"]*)\" \/>/i";
		$str = preg_replace($replace, "<link rel=\"stylesheet\" media=\"screen\" href=\"$1\" />\n<link rel=\"stylesheet\" media=\"screen\" href=\"/css/font-awesome.min.css\" />\n<style>a, .link {\n\tcolor: #0F74BC;\n}\n.tracking-progress-beam .tracking-progress.tracking-progress-active .tracking-progress-text {\n\tcolor: #0F74BC;\n}\n.tracking-progress-beam .tracking-progress.tracking-progress-active .tracking-progress-icon .fa-stack-2x {\n\tcolor: #0F74BC;\n}\nbutton, [type=\"button\"], [type=\"reset\"], [type=\"submit\"], .button {\n\tbackground-color: #0F74BC;\n}\nhr {\n\tborder-bottom: 3px solid #0F74BC;\n}\n</style>\n", $str);
		$replace  = "/<div class='branded\-logo'>\\n<img(.*?)\/\>/i";
		$str = preg_replace($replace, "<div class=\"branded-logo\">\n<img src=\"/uploads/company/" . intval($param['company_id']) . "/img/logo_branded.png\" width=\"100\" />", $str);
		$replace  = "/<div class='powered\-by'>\\npowered by\\n<img(.*?)\/\>/i";
		$str = preg_replace($replace, "<div class=\"powered-by\">\npowered by\n<img src=\"/uploads/company/" . intval($param['company_id']) . "/img/logo_login.png\" width=\"60\" />", $str);
		$replace  = "/<link rel=\"shortcut icon\"(.*?)\/\>/i";
		$str = preg_replace($replace, "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"/uploads/company/" . intval($param['company_id']) . "/img/favicon.ico\" />", $str);
		$replace  = "/<link rel=\"apple\-touch\-icon\"(.*?)\/\>/i";
		$str = preg_replace($replace, "<link rel=\"apple-touch-icon\" type=\"image/png\" href=\"/uploads/company/" . intval($param['company_id']) . "/img/apple-icon.png\" />", $str);
		//$replace  = "/<script>s*(.*?)<\/script>/i";
		//$str = preg_replace($replace, "", $str);
		$str = str_replace("<script src=\"/assets/", "<script src=\"" . $href . "/assets/", $str);
		//$str = str_replace("</", "<\/", $str);
		$str = str_replace("'", "\"", $str);
		//$str = str_replace("\"", "\\\"", $str);

		echo $str;

	}

}

?>