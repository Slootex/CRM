<?php 

$html_devices = "";

$js_devices = "";

$bpz_html = "";
$bpz_iframes = "";

$is_next = false;

$row_packing = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
																(SELECT `countries`.`name` AS c_n FROM `countries` WHERE `countries`.`id`=`packing_packings`.`country`) AS country_name, 
																(SELECT `file_attachments`.`id` AS f1i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_id, 
																(SELECT `file_attachments`.`name` AS f1n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_name, 
																(SELECT `file_attachments`.`file` AS f1f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_file, 
																(SELECT `file_attachments`.`id` AS f2i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_id, 
																(SELECT `file_attachments`.`name` AS f2n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_name, 
																(SELECT `file_attachments`.`file` AS f2f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_file 
														FROM 	`packing_packings` 
														WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
														AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$result_packings = mysqli_query($conn, "	SELECT 		*, 
														(SELECT `countries`.`name` AS c_n FROM `countries` WHERE `countries`.`id`=`packing_packings`.`country`) AS country_name, 
														(SELECT `file_attachments`.`id` AS f1i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_id, 
														(SELECT `file_attachments`.`name` AS f1n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_name, 
														(SELECT `file_attachments`.`file` AS f1f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_file, 
														(SELECT `file_attachments`.`id` AS f2i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_id, 
														(SELECT `file_attachments`.`name` AS f2n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_name, 
														(SELECT `file_attachments`.`file` AS f2f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_file 
											FROM 		`packing_packings` 
											WHERE 		`packing_packings`.`address_id`='" . mysqli_real_escape_string($conn, intval($row_packing['address_id'])) . "' 
											AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`packing_packings`.`mode`='0' 
											AND 		`packing_packings`.`adding`='1' 
											AND 		`packing_packings`.`type`='5' 
											ORDER BY 	`packing_packings`.`packing_number` ASC");

$packings_i = 0;

while($row_packing = $result_packings->fetch_array(MYSQLI_ASSOC)){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$result = mysqli_query($conn, "	SELECT 		`packing_packings_devices`.`id` AS id, 
												`packing_packings_devices`.`device_id` AS device_id, 
												`packing_packings_devices`.`device_number` AS device_number, 
												(SELECT `order_orders_devices`.`storage_space` AS ss FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`=`packing_packings_devices`.`device_number`) AS storage_space, 
												(SELECT `order_orders_devices`.`atot_mode` AS ood_am FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`=`packing_packings_devices`.`device_number`) AS atot_mode, 
												(SELECT `order_orders_devices`.`at` AS ood_at FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`=`packing_packings_devices`.`device_number`) AS at, 
												(SELECT `order_orders_devices`.`ot` AS ood_ot FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`=`packing_packings_devices`.`device_number`) AS ot 
									FROM 		`packing_packings_devices` 
									LEFT JOIN	`order_orders_devices` 
									ON			`order_orders_devices`.`id`=`packing_packings_devices`.`device_id` 
									WHERE 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
									AND 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_devices`.`is_storage`='0' 
									AND 		`order_orders_devices`.`is_shopin_relocate`='0' 
									AND 		`order_orders_devices`.`is_labeling`='0' 
									AND 		`order_orders_devices`.`is_photo`='0' 
									AND 		`order_orders_devices`.`is_relocate`='0' 
									ORDER BY 	`packing_packings_devices`.`device_number` ASC");

	$devices_i = 0;

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

		$html_devices .= 	"	<tr" . ($packings_i > 0 && $devices_i == 0 ? " class=\"border-top\"" : "") . ">\n" . 
							"		<td align=\"center\">\n" . 
							"			<div class=\"custom-control custom-radio mt-1 ml-2\"" . ($is_next == false ? " checked=\"checked\"" : "") . " data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Firma: " . $row_packing['companyname'] . "<br /><br />" . $row_packing['firstname'] . " " . $row_packing['lastname'] . "<br />" . $row_packing['street'] . " " . $row_packing['streetno'] . "<br />" . $row_packing['zipcode'] . " " . $row_packing['city'] . "<br /><br />" . $row_packing['email'] . "<br /><br />" . $row_packing['country_name'] . "\" title=\"\">\n" . 
							"				<input type=\"radio\" id=\"packing_" . $row_device['id'] . "\" name=\"recipient\" value=\"" . $row_packing['id'] . "\" class=\"custom-control-input\"" . ($is_next == false ? " checked=\"checked\"" : "") . " />\n" . 
							"				<label class=\"custom-control-label\" for=\"packing_" . $row_device['id'] . "\"></label>\n" . 
							"			</div>\n" . 
							"		</td>\n" . 
							"		<td>" . $row_packing['packing_number'] . "</td>\n" . 
							"		<td><a href=\"Javascript: void(0)\" ondblclick=\"
							if(document.getElementById('device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "')){
								\$('#check_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
								document.getElementById('device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "').checked=true;
								var check=true;
								for(let i = 0;i < devices.length;i++){
									if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
								}
							}else{
								\$('#check_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
								document.getElementById('device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "').checked=false;
								document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
								$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
							}
							if(check==true){
								\$('#packing_button').removeClass('d-none');
							}else{
								\$('#packing_button').addClass('d-none');
							}\">" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "</a></td>\n" . 
							"		<td>" . $row_device['storage_space'] . "</td>\n" . 
							"		<td>-</td>\n" . 
							"		<td align=\"center\"><div class=\"custom-control custom-checkbox pl-0\"><h4 class=\"mb-0\"><i id=\"check_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\" class=\"fa fa-plus-square text-danger\"> </i></h4><div class=\"d-none\"><input type=\"checkbox\" id=\"device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\" name=\"device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\" value=\"1\" class=\"custom-control-input\" /><label for=\"device_" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\" class=\"custom-control-label\"></label></div></div></td>\n" . 
							"	</tr>\n";

		$js_devices .= $js_devices == "" ? "'" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "'" : ", '" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "'";

		$is_next = true;

		$devices_i++;

	}

	if($row_packing['file1_file'] != ""){
		$js_devices .= $js_devices == "" ? "'BPZ-MSG-" . ($packings_i + 1) . "'" : ", 'BPZ-MSG-" . ($packings_i + 1) . "'";
	}

	if($row_packing['file2_file'] != ""){
		$js_devices .= $js_devices == "" ? "'BPZ-HIN-" . ($packings_i + 1) . "'" : ", 'BPZ-HIN-" . ($packings_i + 1) . "'";
	}

	$html_devices .= ($row_packing['file1_file'] != "" || $row_packing['file2_file'] != "" ? 
					"										<tr>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td><strong>Beipackzettel</strong></td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"										</tr>\n"
				: 
					""
				);

	$html_devices .= ($row_packing['file1_file'] != "" ? 
					"										<tr>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td><a href=\"Javascript: void(0)\" ondblclick=\"
					if(document.getElementById('device_BPZ-MSG-" . ($packings_i + 1) . "')){
						\$('#check_BPZ-MSG-" . ($packings_i + 1) . "').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
						document.getElementById('device_BPZ-MSG-" . ($packings_i + 1) . "').checked=true;
						var check=true;
						for(let i = 0;i < devices.length;i++){
							if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
						}
					}else{
						\$('#check_BPZ-MSG-" . ($packings_i + 1) . "').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
						document.getElementById('device_BPZ-MSG-" . ($packings_i + 1) . "').checked=false;
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(check==true){
						\$('#packing_button').removeClass('d-none');
					}else{
						\$('#packing_button').addClass('d-none');
					}\">BPZ-MSG-" . ($packings_i + 1) . "</a></td>\n" . 
					"											<td align=\"center\">&nbsp;</td>\n" . 
					"											<td><a href=\"Javascript: void(0)\" class=\"btn btn-success btn-sm\" onclick=\"
					if(navigator.appName == 'Microsoft Internet Explorer'){
						document.getElementById('file1_frame_" . ($packings_i + 1) . "').print();
					}else{
						document.getElementById('file1_frame_" . ($packings_i + 1) . "').contentWindow.print();
					}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_packing['file1_file'] . "\" target=\"_blank\">" . $row_packing['file1_name'] . " <i class=\"fa fa-external-link\"> </i></a></td>\n" . 
					"											<td align=\"center\"><div class=\"custom-control custom-checkbox pl-0\"><h4 class=\"mb-0\"><i id=\"check_BPZ-MSG-" . ($packings_i + 1) . "\" class=\"fa fa-plus-square text-danger\"> </i></h4><div class=\"d-none\"><input type=\"checkbox\" id=\"device_BPZ-MSG-" . ($packings_i + 1) . "\" name=\"device_BPZ-MSG-" . ($packings_i + 1) . "\" value=\"" . $row_packing['file1_id'] . "\" class=\"custom-control-input\" /><label for=\"device_BPZ-MSG-" . ($packings_i + 1) . "\" class=\"custom-control-label\"></label></div></div></td>\n" . 
					"										</tr>\n"
				: 
					""
				) . 

				($row_packing['file2_file'] != "" ? 
					"										<tr>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td><a href=\"Javascript: void(0)\" ondblclick=\"
					if(document.getElementById('device_BPZ-HIN-" . ($packings_i + 1) . "')){
						\$('#check_BPZ-HIN-" . ($packings_i + 1) . "').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
						document.getElementById('device_BPZ-HIN-" . ($packings_i + 1) . "').checked=true;
						var check=true;
						for(let i = 0;i < devices.length;i++){
							if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
						}
					}else{
						\$('#check_BPZ-HIN-" . ($packings_i + 1) . "').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
						document.getElementById('device_BPZ-HIN-" . ($packings_i + 1) . "').checked=false;
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(check==true){
						\$('#packing_button').removeClass('d-none');
					}else{
						\$('#packing_button').addClass('d-none');
					}\">BPZ-HIN-" . ($packings_i + 1) . "</a></td>\n" . 
					"											<td align=\"center\">&nbsp;</td>\n" . 
					"											<td><a href=\"Javascript: void(0)\" class=\"btn btn-success btn-sm\" onclick=\"
					if(navigator.appName == 'Microsoft Internet Explorer'){
						document.getElementById('file2_frame_" . ($packings_i + 1) . "').print();
					}else{
						document.getElementById('file2_frame_" . ($packings_i + 1) . "').contentWindow.print();
					}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_packing['file2_file'] . "\" target=\"_blank\">" . $row_packing['file2_name'] . " <i class=\"fa fa-external-link\"> </i></a></td>\n" . 
					"											<td align=\"center\"><div class=\"custom-control custom-checkbox pl-0\"><h4 class=\"mb-0\"><i id=\"check_BPZ-HIN-" . ($packings_i + 1) . "\" class=\"fa fa-plus-square text-danger\"> </i></h4><div class=\"d-none\"><input type=\"checkbox\" id=\"device_BPZ-HIN-" . ($packings_i + 1) . "\" name=\"device_BPZ-HIN-" . ($packings_i + 1) . "\" value=\"" . $row_packing['file2_id'] . "\" class=\"custom-control-input\" /><label for=\"device_BPZ-HIN-" . ($packings_i + 1) . "\" class=\"custom-control-label\"></label></div></div></td>\n" . 
					"										</tr>\n"
				: 
					""
				);

	$bpz_iframe .=	"									<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_packing['file1_file'] . "\" id=\"file1_frame_" . ($packings_i + 1) . "\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
					"									<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_packing['file2_file'] . "\" id=\"file2_frame_" . ($packings_i + 1) . "\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
									FROM 		`order_orders_files` 
									WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_files`.`type`<'4' 
									ORDER BY 	CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

	$count_i = 0;

	$files = "";

	while($row_files = $result->fetch_array(MYSQLI_ASSOC)){

		$bpz_iframe .=	"									<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\" id=\"files_frame_" . $row_files['id'] . "\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n";

		$files .=	"										<tr>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"											<td><a href=\"Javascript: void(0)\" class=\"btn btn-success btn-sm\" onclick=\"
					if(navigator.appName == 'Microsoft Internet Explorer'){
						document.getElementById('files_frame_" . $row_files['id'] . "').print();
					}else{
						document.getElementById('files_frame_" . $row_files['id'] . "').contentWindow.print();
					}\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\" target=\"_blank\">" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . " <i class=\"fa fa-external-link\"> </i></a>\n" . 
					"											</td>\n" . 
					"											<td>&nbsp;</td>\n" . 
					"										</tr>\n";

		$count_i++;

	}

	$html_devices .=	$files != "" ? 
							"										<tr>\n" . 
							"											<td>&nbsp;</td>\n" . 
							"											<td>&nbsp;</td>\n" . 
							"											<td colspan=\"2\"><strong>Zusätzliche Dokumente</strong></td>\n" . 
							"											<td>\n" . 
							"												<u>Auftrag " . $row_order['order_number'] . "</u>:<br />\n" . 
							"											</td>\n" . 
							"											<td>&nbsp;</td>\n" . 
							"										</tr>\n" . 
							$files
						: 
							"";

	$packings_i++;

}

	$order_extended_items = "";

	$arr_order_extended_items = explode("\r\n", $maindata['order_extended_items']);

	if($maindata['order_extended_items'] != ""){

		for($item = 0;$item < count($arr_order_extended_items);$item++){

			$arr_item = explode("|", $arr_order_extended_items[$item]);

			if($arr_item[2] == 1){

				$order_extended_items .=	"										<tr" . ($item == 0 ? " class=\"border-top\"" : "") . ">\n" . 
											"											<td>&nbsp;</td>\n" . 
											"											<td>&nbsp;</td>\n" . 
											"											<td><a href=\"Javascript: void(0)\" ondblclick=\"
											if(document.getElementById('device_" . strtoupper($arr_item[0]) . "')){
												\$('#check_" . strtoupper($arr_item[0]) . "').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
												document.getElementById('device_" . strtoupper($arr_item[0]) . "').checked=true;
												var check=true;
												for(let i = 0;i < devices.length;i++){
													if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
												}
											}else{
												\$('#check_" . strtoupper($arr_item[0]) . "').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
												document.getElementById('device_" . strtoupper($arr_item[0]) . "').checked=false;
												document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
												$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
											}
											if(check==true){
												\$('#packing_button').removeClass('d-none');
											}else{
												\$('#packing_button').addClass('d-none');
											}\">" . strtoupper($arr_item[0]) . "</a></td>\n" . 
											"											<td>&nbsp;</td>\n" . 
											"											<td>" . $arr_item[1] . "</td>\n" . 
											"											<td align=\"center\"><div class=\"custom-control custom-checkbox pl-0\"><h4 class=\"mb-0\"><i id=\"check_" . strtoupper($arr_item[0]) . "\" class=\"fa fa-plus-square text-danger\"> </i></h4><div class=\"d-none\"><input type=\"checkbox\" id=\"device_" . strtoupper($arr_item[0]) . "\" name=\"device_" . strtoupper($arr_item[0]) . "\" value=\"1\" class=\"custom-control-input\" /><label for=\"device_" . strtoupper($arr_item[0]) . "\" class=\"custom-control-label\"></label></div></div></td>\n" . 
											"										</tr>\n";

				$js_devices .= $js_devices == "" ? "'" . strtoupper($arr_item[0]) . "'" : ", '" . strtoupper($arr_item[0]) . "'";

			}

		}

	}

	$js_devices = "<script>var devices = [" . $js_devices . "];</script>\n";

	$html .= 	$js_devices . 

				"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Bitte das/die Gerät/e verpacken</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_packing['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				//"								<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				//"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				$html_new_shipping_result . 

				($emsg_shipment != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_shipment . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
	
				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				/*($row_packing['message'] != "" ? 
					"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 
					"									<div class=\"bg-light border border-danger text-danger p-2\" style=\"min-height: 120px;font-size: 28pt;border-width: 4px !important\"><b>" . $row_packing['message'] . "</b></div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . */

				"							<div id=\"emsg\"></div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"item\" name=\"item\" value=\"\" class=\"form-control form-control-lg mt-1\" placeholder=\"|||||||| Artikel\" onKeyPress=\"
				if(event.keyCode == '13'){
					if(document.getElementById('device_' + document.getElementById('item').value)){
						\$('#check_' + document.getElementById('item').value).removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
						document.getElementById('device_' + document.getElementById('item').value).checked=true;
						document.getElementById('item').value='';
						var check=true;
						for(let i = 0;i < devices.length;i++){
							if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
						}
					}else{
						document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>';
						$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){\$('.alert-dismissible').alert('close');});
					}
					if(check==true){
						\$('#packing_button').removeClass('d-none');
					}else{
						\$('#packing_button').addClass('d-none');
					}
					return false;
				}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-6\">\n" . 

				$bpz_iframe . 

				"								</div>\n" . 
				"							</div>\n" . 
	
				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 

				"									<small>Positionen des Auftrags</small><br />\n" . 

				"									<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " no-table-sm table-borderless table-hover mb-0\">\n" . 
				"										<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . " border-bottom\">\n" . 
				"											<th scope=\"col\" width=\"120\" class=\"text-center\"><h5 class=\"font-weight-bold mb-0\">Empfänger</h5></th>\n" . 
				"											<th scope=\"col\" width=\"90\"><h5 class=\"font-weight-bold mb-0\">Paket</h5></th>\n" . 
				"											<th scope=\"col\" width=\"160\"><h5 class=\"font-weight-bold mb-0\">ArtNr.</h5></th>\n" . 
				"											<th scope=\"col\" width=\"120\"><h5 class=\"font-weight-bold mb-0\">Lagerplatz</h5></th>\n" . 
				"											<th scope=\"col\"><h5 class=\"font-weight-bold mb-0\">Artikelname</h5></th>\n" . 
				"											<th scope=\"col\" width=\"40\" class=\"text-center\"><h5 class=\"font-weight-bold mb-0\">Gescannt</h5></th>\n" . 
				"										</tr></thead>\n" . 

				$html_devices . 

				$order_extended_items . 


				"									</table>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row mt-5\">\n" . 
				"								<div class=\"col-sm-12 text-center\">\n" . 
				"									<div id=\"packing_button\" class=\"d-none\">\n" . 

				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"packing_adding_extern_shipping\" value=\"durchfuehren\" class=\"btn btn-success btn-lg w-100\"><h1>versenden <i class=\"fa fa-truck\" aria-hidden=\"true\"></i></h1></button><br />\n" . 

				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6 text-center\">\n" . 

				"							<h1>Beispiel</h1>\n" . 

				"							<video width=\"600\" height=\"400\" controls>\n" . 
				"								<source src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/img/demo.mp4\" type=\"video/mp4\">\n" . 
				"							</video>\n" . 
	
				"						</div>\n" . 
				"					</div>\n" . 
	
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-12 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
	
				"				</form>\n" . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>