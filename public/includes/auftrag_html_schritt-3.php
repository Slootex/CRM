<?php 

	$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

	$html .= 	"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card rounded-0\">\n" . 
				"			<div class=\"card-header border-bottom border-primary p-0\">\n" . 

				$pagination . 

				"			</div>\n" . 
				"			<div class=\"card-body bg-primary px-3 pt-3 pb-0\">\n" . 
				"				<div class=\"form-group row\">\n" . 
				"					<div class=\"col-sm-12 px-5\">\n" . 
				"						<div class=\"form-group row\">\n" . 
				"							<div class=\"col-sm-12 px-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"				<form action=\"/auftrag/" . $steps[$i]['slug'] . "\" method=\"post\" enctype=\"multipart/form-data\" class=\"mb-0\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12 px-5\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12 px-5 py-3 alert-primary text-dark\">\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Rückversand</label>\n" . 
				"										<div class=\"col-sm-8 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio\">\n" . 
				"												<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ($radio_shipping == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"radio_shipping_standart\">\n" . 
				"													Standardversand\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio\">\n" . 
				"												<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ($radio_shipping == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"radio_shipping_express\">\n" . 
				"													Expressversand\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"										<div class=\"col-sm-8 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio\">\n" . 
				"												<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ($radio_payment == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"radio_payment_nachnahme\">\n" . 
				"													Nachnahme\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio\">\n" . 
				"												<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ($radio_payment == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"radio_payment_ueberweisung\">\n" . 
				"													Überweisung\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">AGB und Beauftragung *</label>\n" . 
				"										<div class=\"col-sm-8\">\n" . 
				"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"												<input type=\"checkbox\" id=\"terms\" name=\"terms\" value=\"1\"" . ($terms == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"terms\">\n" . 
				"													Ich versichere, dass die vorstehenden Angaben der Wahrheit entsprechen. Ich habe die <a href=\"" . $domain . "/save/agb.pdf\" target=\"_blank\">AGB</a> / Kundeninformationen der Fa. GZA MOTORS gelesen und erkläre mit dem Absenden des Formulars mein Auftrag zur Fehelerdiagnose für das/die beiligende/n Gerät/e.<br />Die Wiederrufsbelehrung(en) / das <a href=\"" . $domain . "/save/widerrufsformular-gza.pdf\" target=\"_blank\">Muster-Wiederufsformular</a> habe ich zur Kenntnis genommen.\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Datenschutz *</label>\n" . 
				"										<div class=\"col-sm-8\">\n" . 
				"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"												<input type=\"checkbox\" id=\"dsgvo\" name=\"dsgvo\" value=\"1\"" . ($dsgvo == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label font-weight-light\" for=\"dsgvo\">\n" . 
				"													Die <a href=\"" . $domain . "/datenschutz\" target=\"_blank\">Datenschutzerklärung</a> habe ich zur Kenntnis genommen.\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Captcha *</label>\n" . 
				"										<div class=\"col-sm-8\">\n" . 
				"											<div class=\"g-recaptcha\" data-sitekey=\"6LfvPKAUAAAAAOq8sFC2MIh7_0K7vPvSV7EeotIp\" style=\"float: left;margin-bottom: 12px\"></div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer bg-primary\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<a href=\"/auftrag/schritt-2\" class=\"btn btn-lg btn-danger ml-3\">Zurück zu Schritt 2</a>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"WEITER\" class=\"btn btn-lg btn-danger mr-3\">Auftrag erteilen</button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";


?>