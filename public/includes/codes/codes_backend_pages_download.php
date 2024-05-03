<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "pages";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_SESSION["admin"]["company_id"]) && intval($_SESSION["admin"]["company_id"]) > 0){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`pages` 
									ORDER BY 	`pages`.`name` ASC");

	$list = "\"ID\",\"NAME\",\"LINKNAME\",\"URL\",\"RULES\",\"CODE_ID\",\"TEMPLATE_ID\",\"TITLE\",\"META_TITLE\",\"META_DESCRIPTION\",\"META_KEYWORDS\",\"STYLE\",\"SCRIPT\";\n";

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$list .= "\"" . $row['id'] . "\",\"" . $row['name'] . "\",\"" . $row['linkname'] . "\",\"" . $row['url'] . "\",\"" . str_replace(array("\r\n", "\n", "\r"), array("\\n", "", ""), str_replace("\"", "&quot;", $row['rules'])) . "\",\"" . $row['code_id'] . "\",\"" . $row['template_id'] . "\",\"" . $row['title'] . "\",\"" . $row['meta_title'] . "\",\"" . $row['meta_description'] . "\",\"" . $row['meta_keywords'] . "\",\"" . $row['style'] . "\",\"" . $row['script'] . "\";\n";
	}

	header('Content-Type: text/html; charset=utf-8');
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="pages.csv"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . strlen($list));
	ob_clean();
	flush();
	echo $list;
	exit();

}

?>