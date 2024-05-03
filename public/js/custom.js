(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
function enableCookie(){
	$.getScript("https://www.provenexpert.com/widget/richsnippet.js?u=18zZiuQBmS3ZiEQA5VGp4HQp48TA1LmA&v=2", function() {
	});
	$.getScript("https://www.google.com/recaptcha/api.js", function() {
		grecaptcha.ready(function(){grecaptcha.execute('6LclQV4bAAAAAFBfEwfk9mGjfwbXRaeBF7EaThnl', {action: 'homepage'});});
	});
}
function enableMarketing(){
	
}
function enablePersonal(){
}
function enableAnalyze(){
	$.getScript("https://www.googletagmanager.com/gtag/js?id=UA-46857457-1", function() {
		window.dataLayer = window.dataLayer || [];
		gtag('js', new Date());
		gtag('config', 'UA-46857457-1');
	});
	ga('create', 'UA-46857457-1', 'auto');
	ga('set', 'anonymizeIp', true);
	ga('send', 'pageview');
	$.getScript("/js/hotjar-tracking-code.js", function() {
	});
}
function gtag(){
	dataLayer.push(arguments);
}
window.cookieconsent.initialise({
	display_type: "modal", // modal | container
	container_backgroundColor: "bg-white", 
	modal_size: "modal-xl", 
	header_text: "<strong>&#127850;</strong> Frische Cookies", 
	header_tag: "h2", 
	header_color: "text-primary font-weight-bold", 
	header_close: true, 
	image_src: "/img/cookie.png", 
	image_class: "img-thumbnail border-0", 
	image_style: "width: 150px", 
	description_color: "text-dark", 
	description_text: "Cookies können einem auf den Keks gehen. Wir nutzen Sie um Ihnen noch passendere Angebote zu zeigen.<br>Cookies merken sich die Einstellungen, die auf unserer Seite durch Sie vorgenommen wurden.<br>Wenn das für Sie okay ist, stimmen Sie der Nutzung von Cookies einfach durch einen Klick auf &quot;Alle akzeptieren&quot; zu.<br><br>Weitere Optionen können Sie [options] anschauen und Informationen finden Sie auf unsere [link] Seite.", 
	options_label: "hier", 
	options_color: "text-primary", 
	link_label: "Datenschutz", 
	link_url: "/datenschutz", 
	link_color: "text-primary", 
	checkbox_label_color: "text-primary", 
	button_accept_label: "Cookies akzeptieren", 
	button_accept_label2: "Ausgewählte akzeptieren", 
	button_accept_backgroundColor: "btn-lg btn-primary py-2", 
	button_accept_color: "text-white", 
	button_close_enable: false, 
	button_close_label: "schließen", 
	button_close_backgroundColor: "btn-lg btn-outline-secondary", 
	button_close_color: "text-dark", 
	button_options_label: "Cookie-Optionen", 
	button_options_class: "btn btn-primary border border-white", 
	button_options_style: "position: fixed;bottom: -10px;left: 20px;border-radius: 15px;box-shadow: 0 0 4px rgba(0,0,0,.8);z-Index: 1001;display: none"
});
window.onscroll = function(){var currentScrollPos = window.pageYOffset;if(currentScrollPos > 55){$("#menu_1").css('top', '-56px');$("#header-sticky-wrapper").css('height', '83px');$("#header").css('height', '83px');$("#burger").css('display', 'block');$(".logo a img").css('width', '64px');$(".logo a img").css('padding', '6px 0 0 0');$("#phone_nr").css('font-size', '32px');$("#phone_nr").css('color', '#d9534f');$(".phone_number p.small").css('font-size', '16px');$(".phone_number p.small").css('display', 'none');$(".phone_number img").css('margin-top', '-6px');$(".phone_number img").css('width', '46px');}else{$("#menu_1").css('top', '0');$("#header-sticky-wrapper").css('height', '168px');$("#header").css('height', '168px');$("#burger").css('display', 'none');$(".logo a img").css('width', '130px');$(".logo a img").css('padding', '0 0 0 0');$("#phone_nr").css('font-size', '32px');$("#phone_nr").css('color', '#191919');$(".phone_number p.small").css('font-size', '16px');$(".phone_number p.small").css('display', 'block');$(".phone_number img").css('margin-top', '10px');$(".phone_number img").css('width', '53px');}};$(document).ready(function(){$("#burger").click(function(event){event.preventDefault();window.scrollTo(0, 0);$("#menu_1").css('top', '0');$("#header-sticky-wrapper").css('height', '168px');$("#header").css('height', '168px');$("#burger").css('display', 'none');$(".logo a img").css('width', '130px');$(".logo a img").css('padding', '0 0 0 0');$(".phone_number p").css('font-size', '32px');$(".phone_number p").css('color', '#191919');$(".phone_number p.small").css('font-size', '16px');$(".phone_number p.small").css('display', 'block');$(".phone_number img").css('margin-top', '10px');$(".phone_number img").css('width', '53px');});});$(document).ready(function(){$("#btn_new").click(function(){var data = $.trim($("#new_customer").val());if(data != "")window.location="/kontakt?type=new&number="+data;});$("#btn_existing").click(function(){var data = $.trim($("#existing_customer").val());if(data != "")window.location="/kontakt?type=existing&number="+data;});});$(document).ready(function(){if($(window).width() <= 480){var showChar = 0;var ellipsestext = "...";var moretext = "Zeige mehr >";var lesstext = "Zeige weniger";$('.more').each(function() {var content = $(this).html();if(content.length > showChar) {var c = content.substr(0, showChar);var h = content.substr(showChar, content.length - showChar);var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';$(this).html(html);}});$(".morelink").click(function(){if($(this).hasClass("less")) {$(this).removeClass("less");$(this).html(moretext);}else{$(this).addClass("less");$(this).html(lesstext);}$(this).parent().prev().toggle();$(this).prev().toggle();return false;});}});
$(	'<div class="modal fade" id="iframeImprint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
	'	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">' + 
	'		<div class="modal-content">' + 
	'			<div class="modal-header card-header">' + 
	'				<h5 class="modal-title font-weight-bold" id="exampleModalLabel">Impressum</h5>' + 
	'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
	'					<span aria-hidden="true">&times;</span>' + 
	'				</button>' + 
	'			</div>' + 
	'			<div class="modal-body">' + 
	'				<strong class="imprint">Angaben gemäß § 5 TMG</strong><br>' + 
	'				<p class="imprint">' + 
	'					NORWIG Verwaltungs GmbH<br>' +
	'					Strausberger Platz 13<br>' + 
	'					10243 Berlin' + 
	'				</p>' + 
	'				<strong class="imprint">Vertreten durch</strong><br>' + 
	'				<p class="imprint">Gazi Ahmad</p>' + 
	'				<strong class="imprint">Kontakt</strong><br>' + 
	'				<p class="imprint">' + 
	'					Telefon: 030- 847 111 99<br>' + 
	'					E-Mail: <a href="mailto: webmaster@ordergo.de" class="text-dark">webmaster@ordergo.de</a>' + 
	'				</p>' + 
	'				<strong class="imprint">Umsatzsteuer-ID</strong><br>' + 
	'				<p class="imprint">Umsatzsteuer-Identifikationsnummer gemäß §27a Umsatzsteuergesetz: DE284008608</p>' + 
	'				<strong class="imprint">Hinweis auf EU-Streitschlichtung</strong>' + 
	'				<p class="imprint">' + 
	'					Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit: <a href="http://ec.europa.eu/consumers/odr" target="_blank" class="text-dark">http://ec.europa.eu/consumers/odr</a>' + 
	'					Unsere E-Mail-Adresse finden Sie oben im Impressum.' + 
	'				</p>' + 
	'				<strong class="imprint">Verbraucherstreitbeilegung:</strong>' + 
	'				<p class="imprint">Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p><br>' + 
	'			</div>' + 
	'			<div class="modal-footer card-footer">' + 
	'				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen</button>' + 
	'			</div>' + 
	'		</div>' + 
	'	</div>' + 
	'</div>')
	.appendTo("body");

$(	'<div class="modal fade" id="iframeTerms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
	'	<div class="modal-dialog modal-xl" role="document">' + 
	'		<div class="modal-content">' + 
	'			<div class="modal-header card-header">' + 
	'				<h5 class="modal-title font-weight-bold" id="exampleModalLabel">Datenschutz</h5>' + 
	'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
	'					<span aria-hidden="true">&times;</span>' + 
	'				</button>' + 
	'			</div>' + 
	'			<div class="modal-body">' + 
	'				<iframe id="iframeTerms_iframe" src="/datenschutz-blank" width="100%" height="480" class="border"></iframe>' + 
	'			</div>' + 
	'			<div class="modal-footer card-footer">' + 
	'				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen</button>' + 
	'			</div>' + 
	'		</div>' + 
	'	</div>' + 
	'</div>')
	.appendTo("body");