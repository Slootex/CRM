<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}elseif(isset($param['carid']) && strip_tags($param['carid']) != ""){
	$row_order['carid'] = strtoupper(strip_tags($param['carid']));
	$_POST['id'] = intval($param['id']);
}else{
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$row_order = array();

$row_order['carid'] = "";

$options = array(
	'http' => array(
		'method' => "GET",
		'header'=>array(
			"Referer: https://www.m-" . $time . ".de\r\n"
		)
	)
);

$context = stream_context_create($options);

$data = str_replace("\r\n", "", file_get_contents("https://de.vindecoder.pl/" . strtoupper($row_order['carid']), false, $context));

preg_match_all("/\<table class=\"table table-striped table-two-col\"\>(.*?)\<\/table\>/si", $data, $ergebnis);

$table = array();

for($i = 0;$i < count($ergebnis[1]);$i++){
	$table[] = "<table>\n" . $ergebnis[1][$i] . "</table>\n";
}

if(count($table) > 0){

	$html = /*"<br />\n" . 
			"<h4>Hersteller</h4>\n" . 
			$table[0] . 
			"<br />\n" . 
			"<h4>VIN auswerten</h4>\n" . 
			$table[1] . */
			"<br />\n" . 
			"<h4>Basisdaten</h4>\n" . 
			$table[2] . 
			"<br />\n" . 
			"<h4>Technische Angaben</h4>\n" . 
			$table[3] . 
			/*"<br />\n" . 
			"<h4>Standardausstattung</h4>\n" . 
			$table[4] . 
			"<br />\n" . 
			"<h4>Optionsausstattung</h4>\n" . 
			$table[5] . */
			"<br />\n";

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`vin_html`='" . mysqli_real_escape_string($conn, html_entity_decode($html)) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}else{

	$html = "<h1><strong>Notice!</strong> Your daily limit has been reached. </h1>\n";

}

?>