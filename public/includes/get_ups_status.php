<?php 

function getUpsStatus($maindata, $tracking_number){

	$opts = array(
	  'http'=>array(
		'method'=>"GET",
		'header'=>"AccessLicenseNumber: " . $maindata['ups_access_license_number'] . "\r\n" .
				  "Password: " . $maindata['ups_password'] . "\r\n" .
				  "transactionSrc: " . $maindata['company'] . "\r\n" .
				  "transId: " . time() . "\r\n" .
				  "Content-Type: application/json\r\n" .
				  "Username: " . $maindata['ups_username'] . "\r\n" .
				  "Accept: application/json\r\n" .
				  "User-agent: BROWSER-DESCRIPTION-HERE\r\n"
	  )
	);

	$context = stream_context_create($opts);

	$result = file_get_contents($maindata['ups_url'] . '/track/v1/details/' . $tracking_number . '?locale=de_DE', false, $context);

	return json_decode($result);

}

?>