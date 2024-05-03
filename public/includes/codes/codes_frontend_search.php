<?php 

@session_start();

include('includes/class_page_number.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 3;

$html = "";

if(isset($_GET['search']) && strip_tags($_GET['search']) == "suchen" && isset($_GET['searchword'])){
	header('Location: /suchen/stichwort/' . urlencode(strip_tags($_GET['searchword'])));
	exit();
}

$amount_rows = 50;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

//if(isset($param['search']) && strip_tags($param['search']) == "ok"){

	if(isset($param['searchword']) && strip_tags($param['searchword']) != ""){
		$logdatei = fopen("uploads/company/" . intval($company_id) . "/log/search.csv", "a");
		fputs(
			$logdatei,
			"\"" . date("d.m.Y, H:i:s",time()) .
			"\", \"" . addslashes(strip_tags($param['searchword'])) .
			"\", \"" . addslashes(strip_tags($_SERVER['REMOTE_ADDR'])) .
			"\", \"" . addslashes(strip_tags($_SERVER['REQUEST_METHOD'])) .
			"\", \"" . addslashes(strip_tags($_SERVER['PHP_SELF'])) .
			"\", \"" . addslashes(strip_tags($_SERVER['HTTP_USER_AGENT'])) .
			"\", \"" . addslashes(strip_tags($_SERVER['HTTP_REFERER'])) . "\"\n"
		);
		fclose($logdatei);
	}

	$_SESSION['searchword'] = isset($param['searchword']) ? strip_tags($param['searchword']) : (isset($_SESSION['searchword']) ? $_SESSION['searchword'] : "");

	$searchwords = explode(" ", $_SESSION['searchword']);

	$where = "";

	$list = "";

	for($i = 0;$i < count($searchwords);$i++){
		$where .= 	$where == "" ? 
					" 		`content`.`title` LIKE '%" . mysqli_real_escape_string($conn, $searchwords[$i]) . "%' 
					OR		`content`.`brand_title` LIKE '%" . mysqli_real_escape_string($conn, $searchwords[$i]) . "%' " : 
					"OR 	`content`.`title` LIKE '%" . mysqli_real_escape_string($conn, $searchwords[$i]) . "%' 
					OR		`content`.`brand_title` LIKE '%" . mysqli_real_escape_string($conn, $searchwords[$i]) . "%' ";
	}

	$query = 	"	SELECT 		`content`.`title` AS title, 
								`content`.`description` AS description, 
								`content`.`price` AS price,  
								`content`.`logo` AS logo, 
								`content`.`car_title` AS car_title, 
								`content`.`brand_title` AS brand_title 
					FROM 		`content` 
					WHERE " . $where . "
					ORDER BY 	`content`.`title` ASC, `content`.`car_title` ASC, `content`.`brand_title` ASC";

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										"/suchen", 
										$getParam="", 
										10, 
										1);

	$query .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	if($rows > 0){
		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$list .= 	"<div class=\"col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-4\">\n" . 
						"	<div class=\"card h-100 text-center\" style=\"border-radius: 0;\" itemscope itemtype=\"https://schema.org/Product\">\n" . 
						"		<a href=\"/auftrag/schritt-1\"><img class=\"card-img-top my-3\" src=\"/img/geraete/" . $row['logo'] . "\" alt=\"" . strip_tags($row['title']) . "\" style=\"border-radius: 15px 15px 0 0;width: 60%;height: 100%;overflow: hidden;\" itemprop=\"image\" /></a>\n" . 
						"		<div class=\"card-body\">\n" . 
						"			<p class=\"card-title\"><strong itemprop=\"name\">" . ucwords(str_replace("zue", "zü", str_replace("ae","ä", str_replace("-", " ", $row['title'])))) . "</strong></p>\n" . 
						"			<p class=\"card-title\"><small itemprop=\"category\"><strong>Typ</strong>: " . $row['car_title'] . "</small></p>\n" . 
						"			<p class=\"card-title\"><small itemprop=\"model\"><strong>Marke</strong>: " . $row['brand_title'] . "</small></p>\n" . 
						"			<p class=\"card-text\"><u><span class=\"text-danger font-weight-bold\" itemprop=\"price\" content=\"" . number_format($row['price'], 2, '.', '') . "\">" . number_format($row['price'], 2, ',', '') . "</span></u> <span class=\"text-danger font-weight-bold\" itemprop=\"priceCurrency\" content=\"EUR\">&euro;</span></p>\n" . 
						"			<p class=\"card-text\"><small class=\"text-muted\">inkl. MwSt</small></p>\n" . 
						"			<div class=\"card-text d-none\" itemprop=\"description\">" . $row['description'] . "</div>\n" . 
						"			<div class=\"card-text d-none\" itemprop=\"brand\">www.gzamotors.de</div>\n" . 
						"			<div itemprop=\"offers\" itemscope itemtype=\"https://schema.org/Offer\"><span itemprop=\"price\" content=\"" . number_format($row['price'], 2, '.', '') . "\"></span><span itemprop=\"priceCurrency\" content=\"EUR\"></span><link property=\"availability\" href=\"https://schema.org/InStock\" /><a href=\"/auftrag/schritt-1\" class=\"btn btn-primary\" itemprop=\"url\">Steuergerät prüfen lassen</a></div>\n" . 
						"			<div itemprop=\"review\" itemscope itemtype=\"https://schema.org/Review\">\n" . 
						"				<span itemprop=\"name\" class=\"d-none\">" . ucwords(str_replace("zue", "zü", str_replace("ae","ä", str_replace("-", " ", $row['title'])))) . "</span> <span class=\"d-none\">- by</span> <span itemprop=\"author\" class=\"d-none\">www.gzamotors.de</span><span class=\"d-none\">, </span><meta itemprop=\"datePublished\" content=\"" . date("Y-m-d", time()) . "\"><span class=\"d-none\">" . date("d.m.Y", time()) . "</span>\n" . 
						"				<div itemprop=\"reviewRating\" itemscope itemtype=\"https://schema.org/Rating\">\n" . 
						"					<meta itemprop=\"worstRating\" content=\"1\">\n" . 
						"					<span itemprop=\"ratingValue\">1</span>/<span itemprop=\"bestRating\">5</span> Sterne\n" . 
						"				</div>\n" . 
						"				<span itemprop=\"reviewBody\" class=\"d-none\">" . $row['description'] . "</span>\n" . 
						"			</div>\n" . 
						"		</div>\n" . 
						"	</div>\n" . 
						"</div>\n";

		}
	}

	$html = $pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi() . 

			"<div class=\"row\">\n" . 

			$list . 

			"</div>\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi() . 

			"<div class=\"row\">\n" . 
			"	<div class=\"col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4\">\n" . 
			"		<div id=\"map\"></div>\n" . 
			"		<div id=\"google-reviews\"></div>\n" . 
			"		<div id=\"schema\"></div>\n" . 
			"	</div>\n" . 
			"</div>\n";
	
//}

?>