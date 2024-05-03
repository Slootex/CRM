<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "daily_closing";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

function getRow($time, $conn){

	$date = date("d.m.Y", $time);
	$day = strtotime($date);

	$order_shippings = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM `order_orders_shipments` WHERE `order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_shipments`.`time`>='" . $day . "' AND `order_orders_shipments`.`time`<'" . ($day + 86400) . "'"), MYSQLI_ASSOC);

	$shipping_shippings = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`time`>='" . $day . "' AND `shipping_history`.`time`<'" . ($day + 86400) . "'"), MYSQLI_ASSOC);

	return "<tr><td>" . $date . "</td><td class=\"text-center\">" . $order_shippings['cnt'] . "</td><td class=\"text-center\">" . $shipping_shippings['cnt'] . "</td><td class=\"text-center\">" . ($order_shippings['cnt'] + $shipping_shippings['cnt']) . "</td><td class=\"text-center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-sm btn-success\" onclick=\"\$('#iframeModal2 > .modal-dialog').addClass('modal-xl');\$('#iframeModal2 div div div .modal-title').text('Materialinventur: " . $date . "');\$('#iframeModal2 div div div iframe').attr('src', '/crm/tagesabschluss-drucken/" . $day . "');\$('#iframeModal2').modal();\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";

}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Versand - Materialinventur</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie den Materialinventur einsehen und gegebenfalls ausdrucken.</p>\n" . 
		"<hr />\n";

if(!isset($_POST['set_order'])){
	$html .=	"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"100\" scope=\"col\">\n" . 
				"				<strong>Datum</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Auftrag/Sendungen</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Versand/Sendungen</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"80\" scope=\"col\">\n" . 
				"				<strong>Gesamt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"80\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 
				getRow($time - (86400 * 0), $conn) . 
				getRow($time - (86400 * 1), $conn) . 
				getRow($time - (86400 * 2), $conn) . 
				getRow($time - (86400 * 3), $conn) . 
				getRow($time - (86400 * 4), $conn) . 
				getRow($time - (86400 * 5), $conn) . 
				getRow($time - (86400 * 6), $conn) . 
				getRow($time - (86400 * 7), $conn) . 
				getRow($time - (86400 * 8), $conn) . 
				getRow($time - (86400 * 9), $conn) . 
				getRow($time - (86400 * 10), $conn) . 
				getRow($time - (86400 * 11), $conn) . 
				getRow($time - (86400 * 12), $conn) . 
				getRow($time - (86400 * 13), $conn) . 
				getRow($time - (86400 * 14), $conn) . 
				getRow($time - (86400 * 15), $conn) . 
				getRow($time - (86400 * 16), $conn) . 
				getRow($time - (86400 * 17), $conn) . 
				getRow($time - (86400 * 18), $conn) . 
				getRow($time - (86400 * 19), $conn) . 
				getRow($time - (86400 * 20), $conn) . 
				getRow($time - (86400 * 21), $conn) . 
				getRow($time - (86400 * 22), $conn) . 
				getRow($time - (86400 * 23), $conn) . 
				getRow($time - (86400 * 24), $conn) . 
				getRow($time - (86400 * 25), $conn) . 
				getRow($time - (86400 * 26), $conn) . 
				getRow($time - (86400 * 27), $conn) . 
				getRow($time - (86400 * 28), $conn) . 
				getRow($time - (86400 * 29), $conn) . 
				getRow($time - (86400 * 30), $conn) . 
				"	</table>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten" ? "" : "<br />\n<br />\n<br />\n");
}

?>