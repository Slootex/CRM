<?php 

	$car_brand = strip_tags($param["brand"]);
	$steuergeraet = strip_tags($param["title"]);
	$carname = strip_tags($param["car"]);

	$description = "";
	$keywords = "";

	$ergebnis = mysqli_query($conn, "SELECT * FROM content WHERE car_title LIKE '" . mysqli_real_escape_string($conn, $carname) . "' AND title LIKE '" . mysqli_real_escape_string($conn, $steuergeraet) . "' AND brand_title LIKE '". mysqli_real_escape_string($conn, $car_brand) . "'");

	while($row = mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)){
		$description = $row['description_seo'];
		$keywords = $row['keywords_seo'];
	}

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Keywords" content="<?php echo $keywords; ?>" />
<meta name="Description" content="<?php echo $description; ?>" />