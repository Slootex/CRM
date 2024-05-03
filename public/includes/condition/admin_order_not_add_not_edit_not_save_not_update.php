<?php 

	$parameter['checkbox_to_archiv'] = 	$parameter['checkbox_to_archiv'] != "" ? 
										"			<td width=\"150\">\n" . 
										"				<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
										"					<input type=\"checkbox\" id=\"to_archiv\" name=\"to_archiv\" value=\"1\" class=\"custom-control-input\" />\n" . 
										"					<label class=\"custom-control-label\" for=\"to_archiv\">Ins Archiv</label>\n" . 
										"				</div>\n" . 
										"			</td>\n" : 
										"";

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"40\" scope=\"col\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-0 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_top\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_bottom').prop('checked');\$('#order_sel_all_bottom').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_top\"></label>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"40\" scope=\"col\" align=\"center\">\n" . 
				"				<div style=\"width: 40px;height: 24px;font-size: 1rem\" class=\"text-" . $_SESSION["admin"]["color_table_head"] . " text-center\"><i class=\"fa fa-clock-o\"> </i></div>\n" . 
				"			</th>\n" . 
				/*"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Erstellt</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . */
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Erstellt</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"40\" scope=\"col\" align=\"center\">\n" . 
				"				<div style=\"width: 40px;height: 24px;font-size: 1rem\" class=\"text-" . $_SESSION["admin"]["color_table_head"] . " text-center\"><i class=\"fa fa-music\"> </i></div>\n" . 
				"			</th>\n" . 
				"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Nr</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Kunde</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Status</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Geändert</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"150\" scope=\"col\">\n" . 
				"				<strong>Zuteilung</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" scope=\"col\">\n" . 
				"				<strong>Telefonnummer</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" scope=\"col\">\n" . 
				"				<strong>Letzte Zahlung</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"		<tr class=\"text-primary\">\n" . 
				"			<td width=\"40\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_bottom\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_top').prop('checked');\$('#order_sel_all_top').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_bottom\"></label>\n" . 
				"				</div>\n" . 
				"			</td>\n" . 
				"			<td width=\"350\">\n" . 
				"				<label for=\"order_sel_all_bottom\" class=\"mt-1\">alle auswählen (" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"			</td>\n" . 
				"			<td width=\"260\">\n" . 
				"				<select name=\"status\" class=\"custom-select custom-select-sm text-primary border border-primary\" style=\"width: 200px\">\n" . 

				$multi_search_options . 

				"				</select> \n" . 
				"				<input type=\"hidden\" id=\"ids\" name=\"ids\" value=\"\" />\n" . 
				"				<button type=\"submit\" name=\"multi_status\" value=\"durchführen\" class=\"btn btn-sm btn-primary\" onclick=\"var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich den gewählten Status für die ausgewählten Einträge durchführen?');}\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
				"			</td>\n" . 
				"			<td width=\"200\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"no_email\" name=\"no_email\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"no_email\">Keine E-Mail senden</label>\n" . 
				"				</div>\n" . 
				"			</td>\n" . 

//				$parameter['checkbox_to_archiv'] . 

				($parameter['checkbox_to_archiv'] != "" ? 
					"			<td width=\"120\">\n" . 
					"				<button type=\"submit\" name=\"multi_to_archiv\" value=\"durchführen\" class=\"btn btn-sm btn-primary\" onclick=\"var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich die ausgewählten Einträge in das Archiv verschieben?');}\">zu Archiv <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
					"			</td>\n"
				: 
					""
				) . 
				"			<td align=\"right\">\n" . 
				"			</td>\n" . 
				"		</tr>\n" . 
				"	</table>\n" . 
				"</form>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

?>