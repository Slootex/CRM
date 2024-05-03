<?php 

	$ooq = array();

	$result_ooq = mysqli_query($conn, "	SELECT 		* 
										FROM 		`order_orders_questions` 
										WHERE 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'");

	while($row_ooq = $result_ooq->fetch_array(MYSQLI_ASSOC)){
		$ooq[$row_ooq['question_id']] = array();
		$ooq[$row_ooq['question_id']] = $row_ooq['answer_id'];
	}

	$questions = "";

	$result_pq = mysqli_query($conn, "	SELECT 		* 
										FROM 		`questions` 
										WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`questions`.`parent_id`='0' 
										AND 		`questions`.`category_id`='1' 
										AND 		`questions`.`enable`='1' 
										ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

	while($row_pq = $result_pq->fetch_array(MYSQLI_ASSOC)){

		$questions .=	"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-6 col-form-label\">" . $row_pq['title'] . "</label>\n" . 
						"								<div class=\"col-sm-6 mt-2\">\n";

		$result_sq = mysqli_query($conn, "	SELECT 		* 
											FROM 		`questions` 
											WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($row_pq['id'])) . "' 
											AND 		`questions`.`category_id`='1' 
											AND 		`questions`.`enable`='1' 
											ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

		$j = 0;

		$checked = 0;

		$q = array();

		while($row_sq = $result_sq->fetch_array(MYSQLI_ASSOC)){

			$q[$j] = array();
			$q[$j] = $row_sq;

			if(isset($ooq[$row_pq['id']]) && intval($ooq[$row_pq['id']]) == $row_sq['id']){
				$checked = $row_sq['id'];
			}

			$j++;

		}

		for($j = 0;$j < count($q);$j++){

			if($checked == 0){

				$questions .= 	"									<div class=\"custom-control custom-radio\">\n" . 
								"										<input type=\"radio\" id=\"question_" . $row_pq['id'] . "_" . $q[$j]['id'] . "\" name=\"q_" . $row_pq['id'] . "\" value=\"" . $q[$j]['id'] . "\"" . ($j == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"question_" . $row_pq['id'] . "_" . $q[$j]['id'] . "\">\n" . 
								"											" . $q[$j]['name'] . "\n" . 
								"										</label>\n" . 
								"									</div>\n";

			}else{

				$questions .= 	"									<div class=\"custom-control custom-radio\">\n" . 
								"										<input type=\"radio\" id=\"question_" . $row_pq['id'] . "_" . $q[$j]['id'] . "\" name=\"q_" . $row_pq['id'] . "\" value=\"" . $q[$j]['id'] . "\"" . (isset($ooq[$row_pq['id']]) && intval($ooq[$row_pq['id']]) == $q[$j]['id'] ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"question_" . $row_pq['id'] . "_" . $q[$j]['id'] . "\">\n" . 
								"											" . $q[$j]['name'] . "\n" . 
								"										</label>\n" . 
								"									</div>\n";

			}

		}

		$questions .=	"								</div>\n" . 
						"							</div>\n";

	}

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? (intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["component"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Fragen</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						$questions . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"user_ip\" class=\"col-sm-6 col-form-label\">IP-Adresse</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"user_ip\" name=\"user_ip\" value=\"" . (isset($_POST['questions']) && $_POST['questions'] == "speichern" ? $user_ip : $row_order["user_ip"]) . "\" class=\"form-control" . $inp_user_ip . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						
						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Gerätedaten</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"component\" class=\"col-sm-6 col-form-label\">Defektes Bauteil</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
						"										<option value=\"0\">Bitte auswählen</option>\n" . 

						$options_component . 

						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<br />\n" . 

						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-12\">\n" . 
						"							<strong>Fehlerbeschreibung</strong>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"reason\" class=\"col-sm-3 col-form-label\">Fehlerursache</label>\n" . 
						"						<div class=\"col-sm-9 text-right\">\n" . 
						"							<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $reason : $row_order["reason"]) . "</textarea>\n" . 
						"							<small>(<span id=\"reason_length\">" . strlen(isset($_POST['questions']) && $_POST['questions'] == "speichern" ? $reason : $row_order["reason"]) . "</span> von 700 Zeichen)</small>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Fehlerspeicher</label>\n" . 
						"						<div class=\"col-sm-9 text-right\">\n" . 
						"							<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $description : $row_order["description"]) . "</textarea>\n" . 
						"							<small>(<span id=\"description_length\">" . strlen(isset($_POST['questions']) && $_POST['questions'] == "speichern" ? $description : $row_order["description"]) . "</span> von 700 Zeichen)</small>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"questions\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"							<a href=\"/crm/tech-info-pdf/" . $row_order['id'] . "\" target=\"_blank\" class=\"btn btn-success\">Label <i class=\"fa fa-file-text-o\" aria-hidden=\"true\"></i></a>\n"  . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>