function toggleFullscreen(elem) {
	elem = elem || document.documentElement;
	if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.msRequestFullscreen) {
			elem.msRequestFullscreen();
		} else if (elem.mozRequestFullScreen) {
			elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
			elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}
}

function changeOptions(id, saturday){
	var selectBox = document.getElementById(id);
	while(selectBox.options.length > 0){
		selectBox.remove(0);
	}
	if(saturday == true){
		var newOption = new Option('UPS Saver - 0,00 €', '65');
		selectBox.add(newOption, undefined);
	}else{
		var newOption0 = new Option('UPS Standard - 0,00 €', '11');
		selectBox.add(newOption0, undefined);
		var newOption1 = new Option('UPS Saver - 0,00 €', '65');
		selectBox.add(newOption1, undefined);
	}
}

function orderSearchDirection(field, direction){
	$('#sorting_field option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#sorting_field option[value=\''+field+'\']').prop('selected', true);
	$('#sorting_direction option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#sorting_direction option[value=\''+direction+'\']').prop('selected', true);
	$('#order_search').submit();
}

function orderSearchDirectionGlobal(field, direction){
	$('#global_sorting_field option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#global_sorting_field option[value=\''+field+'\']').prop('selected', true);
	$('#global_sorting_direction option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#global_sorting_direction option[value=\''+direction+'\']').prop('selected', true);
	$('#order_search').submit();
}

function showStatussesDialog(str_subject, str_body, str_shipments){
	$('#showStatussesDialog div div div.modal-header h5').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> DETAILS');
	$('#showStatussesDialog div div div.modal-body').html(str_subject.replace(/\*#039;/g, '\'')+str_body.replace(/\*#039;/g, '\'')+str_shipments.replace(/\*#039;/g, '\''));
	$('#showStatussesDialog').modal();
}

function showShippingDialog(str_title, str_body){
	$('#showStatussesDialog div div div.modal-header h5').html(str_title.replace(/\*#039;/g, '\''));
	$('#showStatussesDialog div div div.modal-body').html(str_body.replace(/\*#039;/g, '\''));
	$('#showStatussesDialog').modal();
}

function setToTimeAfter2Hours(){
	var from_hour = parseInt($('#readytime_hours').find(':selected').val());
	var from_minute = parseInt($('#readytime_minutes').find(':selected').val());
	var to = 2 + from_hour;
	if(to <= 9){
		to = '0' + to;
	}
	if(from_minute <= 9){
		from_minute = '0' + from_minute;
	}
	if(from_hour < 22){
		$('#closetime_hours option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#closetime_hours option[value=\'' + to + '\']').prop('selected', true);
	}
	$('#closetime_minutes option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#closetime_minutes option[value=\'' + from_minute + '\']').prop('selected', true);
}

function setToTimeAfter2HoursPickup(){
	var from_hour = parseInt($('#pickup_readytime_hours').find(':selected').val());
	var from_minute = parseInt($('#pickup_readytime_minutes').find(':selected').val());
	var to = 2 + from_hour;
	if(to <= 9){
		to = '0' + to;
	}
	if(from_minute <= 9){
		from_minute = '0' + from_minute;
	}
	if(from_hour < 22){
		$('#pickup_closetime_hours option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#pickup_closetime_hours option[value=\'' + to + '\']').prop('selected', true);
	}
	$('#pickup_closetime_minutes option:selected').each(function(){
		$(this).removeAttr('selected');
	});
	$('#pickup_closetime_minutes option[value=\'' + from_minute + '\']').prop('selected', true);
}

function setAutologout(){
	if(autologout_seconds == 0){
		autologout_seconds = 59;
		if(autologout_minutes == 0){
			autologout_minutes = autologout_max - 1;
			window.clearInterval(autologout_interval);
			autologout2_seconds = 59;
			$('#autologout2').html(autologout2_seconds);
			$('#autologoutModal').modal();
			autologout2_interval = window.setInterval(function (){setAutologout2();}, 1000);
		}else{
			autologout_minutes--;
		}
	}else{
		autologout_seconds--;
	}
	var minutes = autologout_minutes <= 9 ? "0" + autologout_minutes : autologout_minutes;
	var seconds = autologout_seconds <= 9 ? "0" + autologout_seconds : autologout_seconds;
	$('#autologout').html(minutes + ':' + seconds);
}

function setAutologout2(){
	if(autologout2_seconds == 0){
		location.href = "/crm/abmelden";
	}else{
		autologout2_seconds--;
	}
	var seconds = autologout2_seconds <= 9 ? "0" + autologout2_seconds : autologout2_seconds;
	$('#autologout2').html(seconds);
}

var autologout_interval = {};
var autologout_max = 5;
var autologout_minutes = 5;
var autologout_seconds = 0;
var autologout2_interval = {};
var autologout2_max = 59;
var autologout2_seconds = 0;


$(document).ready(function(){

/*	$(window).unload(function (){
		location.href = "/crm/abmelden";
	});

	window.onclose = function(){
		location.href = "/crm/abmelden";
	}*/

	$('body').on('unload', function(){
		$.ajax({
			url: "/crm/abmelden",
			success: function (result) {

			}
		});
	});
/*
    window.addEventListener("beforeunload", function (e) {        
      location.href = "/crm/abmelden";
      return;
    });*/

/*	window.onbeforeunload = function() {
		location.href = "/crm/abmelden";
		return "Do you really want to close?";
	}

	window.addEventListener("beforeunload", function (e) {
		var confirmationMessage = "\o/";
		location.href = "/crm/abmelden";
		(e || window.event).returnValue = confirmationMessage; //Gecko + IE
		return confirmationMessage;                            //Webkit, Safari, Chrome
	});*/

	// autologout_interval = window.setInterval(function (){setAutologout();}, 1000);

	jQuery('[data-toggle="tooltip"]').tooltip({'animation': true, 'sanitize': false, 'delay': { 'show': 0, 'hide': 0 }, 'html': true, 'container': 'body', 'template': '<div class="tooltip bs-tooltip-top" role="tooltip"><div class="arrow"></div><div style="max-width: 1200px !important" class="tooltip-inner bg-primary border border-dark text-left"></div></div>'});
	jQuery('[data-toggle="popover"]').popover({'animation': true, 'delay': { 'show': 0, 'hide': 0 }, 'html': true});

	$(	'<div class="modal fade" id="showStatussesDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog modal-xl" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-header card-header">' + 
		'				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> DETAILS</h5>' + 
		'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
		'					<span aria-hidden="true">&times;</span>' + 
		'				</button>' + 
		'			</div>' + 
		'			<div class="modal-body">' + 
		'			</div>' + 
		'			<div class="modal-footer card-footer">' + 
		'				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>' + 
		'			</div>' + 
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert-dismissible").alert('close');
	});

	$('input[type=text], textarea').keyup(function(event){
		event.preventDefault();
		if (event.keyCode == 83 && event.altKey){
			$(this).closest('form').find('button[value=speichern]').click();
		}
		if (event.keyCode == 70 && event.altKey){
			$(this).closest('form').find('button[value=suchen]').click();
		}
		return false;
	});

	//$('tr.orders_menu, tr.orders_menu td, tr.orders_menu td span, tr.orders_menu td small').css({'-moz-user-select': 'none', '-webkit-user-select': 'none', '-ms-user-select': 'none', 'user-select': 'none'});

	$(	'<div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-header card-header">' + 
		'				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>' + 
		'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
		'					<span aria-hidden="true">&times;</span>' + 
		'				</button>' + 
		'			</div>' + 
		'			<div class="modal-body">' + 
		'				<iframe id="iframeModal_iframe" src="/crm/blank" width="100%" height="480" class="border"></iframe>' + 
		'			</div>' + 
		'			<div class="modal-footer card-footer">' + 
		'				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>' + 
		'			</div>' + 
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$(	'<div class="modal fade" id="iframeModal_xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog modal-xl" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-header card-header">' + 
		'				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">TITLE</h5>' + 
		'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
		'					<span aria-hidden="true">&times;</span>' + 
		'				</button>' + 
		'			</div>' + 
		'			<div class="modal-body">' + 
		'				<iframe id="iframeModal_xl_iframe" src="/crm/blank" width="100%" height="740" class="border"></iframe>' + 
		'			</div>' + 
	/*	'			<div class="modal-footer card-footer">' + 
		'				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>' + 
		'			</div>' + */
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$(	'<div class="modal fade" id="iframeModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-header card-header">' + 
		'				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>' + 
		'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + 
		'					<span aria-hidden="true">&times;</span>' + 
		'				</button>' + 
		'			</div>' + 
		'			<div class="modal-body">' + 
		'				<iframe id="iframeModal_iframe2" src="/crm/blank" width="100%" height="1000" class="border"></iframe>' + 
		'			</div>' + 
		'			<div class="modal-footer card-footer">' + 
		'				<button type="button" class="btn btn-success" onclick="if(navigator.appName == \'Microsoft Internet Explorer\'){document.getElementById(\'iframeModal_iframe2\').print();}else{document.getElementById(\'iframeModal_iframe2\').contentWindow.print();}">drucken <i class=\"fa fa-print\" aria-hidden=\"true\"></i></button> <button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>' + 
		'			</div>' + 
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$('.orders_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"		<a href='/crm/neue-auftraege/bearbeiten/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>bearbeiten</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/lagerplatz/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Lagerplatz</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/kundenhistorie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Telefonhistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/historie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Auftragshistorie</a>" + 
					"		<a href='/crm/neue-auftraege/archiv/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>Archiv</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/status-durchfuehren/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Status</a>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.orders_archiv_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"		<a href='/crm/auftrag-archiv/bearbeiten/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>bearbeiten</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/lagerplatz/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Lagerplatz</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/kundenhistorie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Telefonhistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/historie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Auftragshistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/status-durchfuehren/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Status</a>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.interesteds_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"		<a href='/crm/neue-interessenten/bearbeiten/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>bearbeiten</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/lagerplatz/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Lagerplatz</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/kundenhistorie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Telefonhistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/historie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Interessentenhistorie</a>" + 
					"		<a href='/crm/neue-interessenten/verschieben/archiv/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>archiv</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/status-durchfuehren/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Status</a>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.interesteds_archiv_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"		<a href='/crm/interessenten-archiv/bearbeiten/" + $(this).data('id') + "' class='list-group-item list-group-item-action list-group-item-primary'>bearbeiten</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/lagerplatz/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Lagerplatz</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/kundenhistorie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Telefonhistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/interessenten/historie/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Interessentenhistorie</a>" + 
					"		<a href='#' class='list-group-item list-group-item-action list-group-item-primary' onclick='$(\"#iframeModal div div div .modal-title\").html(\"<i class=\\&quot;fa fa-thumb-tack\\&quot; aria-hidden=\\&quot;true\\&quot;></i> Referenznummer: " + $(this).data('order_number') + "\");$(\"#iframeModal div div div iframe\").attr(\"src\", \"/crm/auftraege/status-durchfuehren/" + $(this).data('id') + "\");$(\"#iframeModal\").modal();'>Status</a>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.shoppings_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.shoppings_archiv_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$('.retoures_menu').bind("dblclick", function(event){
		event.preventDefault();
		var menu = 	"<div class='row'>" + 
					"	<div class='col card-header mb-3 text-center'>" + 
					"		<h4 class='mb-0'>Schnellmenü</h4>" + 
					"	</div>" + 
					"</div>" + 
					"<div class='row'>" + 
					"	<div class='col list-group px-3'>" + 
					"	</div>" + 
					"</div>";
		if($(".custom-menu").length){
			$(".custom-menu")
				.html(menu)
				.css({
					top: event.pageY + "px", 
					left: event.pageX + "px"
				})
				.show();
		}else{
			$("<div class='custom-menu bg-white border border-light rounded px-3 pb-3'>" + menu + "</div>")
				.appendTo("body")
				.css({
					"z-index": 1000, 
					"box-shadow": "0px 0px 5px #000", 
					position: "absolute", 
					top: event.pageY + "px", 
					left: event.pageX + "px"
				});
		}
	});

	$(document).bind("click", function(event){
		$("div.custom-menu").hide();
	});

	$(document).keyup(function(e){
		e = e || window.event;
		var isEscape = false;
		if("key" in e){
			isEscape = (e.key === "Escape" || e.key === "Esc");
		}else{
			isEscape = (e.keyCode === 27);
		}
		if(isEscape){
			$("div.custom-menu").hide();
		}
	});

    $("form").submit(function (){
        var btn = $(this).find("button[type=submit]:focus");
		btn.html("<span>" + btn.text() + "<\/span> <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"><\/span>");
		$('#loadingModal').modal();
    });

	$(	'<div class="modal fade" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog modal-dialog-centered" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-body">' + 
		'				<br /><br /><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Loading...</h1></div></div><br /><br />' + 
		'			</div>' + 
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$(	'<div class="modal fade" id="autologoutModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' + 
		'	<div class="modal-dialog modal-dialog-centered" role="document">' + 
		'		<div class="modal-content">' + 
		'			<div class="modal-body">' + 
		'				<br /><br /><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Automatisches abmelden in <span id="autologout2">59</span> Sekunden</h1>Wollen Sie dies abbrechen?</div></div><br /><br />' + 
		'			</div>' + 
		'			<div class="modal-footer card-footer">' + 
		'				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.clearInterval(autologout2_interval);autologout_interval = window.setInterval(function (){setAutologout();}, 1000);">abbrechen</button>' + 
		'			</div>' + 
		'		</div>' + 
		'	</div>' + 
		'</div>')
		.appendTo("body");

	$('select.select-colors').each(function(index){
		$(this)
			.removeClass('bg-danger bg-success bg-warning text-white')
			.addClass($(this).find('option:selected').attr('class'))
			.attr({'style': $(this).find('option:selected').attr('style')});
	}).change(function(index){
		$(this)
			.removeClass('bg-danger bg-success bg-warning text-white')
			.addClass($(this).find('option:selected').attr('class'))
			.attr({'style': $(this).find('option:selected').attr('style')});
	});

	$('#design-id').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select custom-control px-0" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;height: 100px;overflow-x: auto;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><span data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" data-text="'+self.text()+'" style="margin-left: 10px;cursor: pointer;">'+self.attr('data-code')+' - '+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="list-style: none;'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="list-style: none;width: 100%;float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#differing_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#packing_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#shipping_from_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#shipping_to_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#intern_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#intern_differing_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#from_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#to_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#pickup_country').each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$(this)
			.addClass('d-none')
			.after('<div class="'+this.id+'-lang-select" style=""><button type="button" value="" class="'+this.id+'-btn-select px-0" style="width: 100%;padding: 0;border-radius: 5px;background-color: #fff;border: 1px solid #ccc;" onfocus="this.blur()"></button><div class="'+this.id+'-b" style="display: none;position: absolute;width: 100%;max-width: 350px;box-shadow: 0 6px 12px rgba(0,0,0,.175);border: 1px solid rgba(0,0,0,.15);border-radius: 5px;z-index: 1000"><ul id="'+this.id+'-a" style="margin-bottom: 0;padding-left: 0px;"></ul></div></div>');
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			$(a).html($(a).html()+'<li style="'+item);
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});

	$('#design-id-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><span data-value="'+self.find('span').attr('data-value')+'" value="'+self.find('span').attr('data-value')+'" style="margin-left: 10px;cursor: pointer;">'+self.find('span').attr('data-code')+' - '+self.find('span').attr('data-text')+'</span></li>';
		$('.design-id-btn-select').html(item);
		$('.design-id-btn-select').attr('value', self.find('span').attr('data-value'));
		$(".design-id-b").toggle();
		$('#design-id option')
			.removeAttr('selected')
				.filter('[value=' + self.find('span').attr('data-value') + ']')
					.prop('selected', true).change();
	});

	$('#country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.country-btn-select').html(item);
		$('.country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".country-b").toggle();
		$('#country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#differing_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.differing_country-btn-select').html(item);
		$('.differing_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".differing_country-b").toggle();
		$('#differing_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#differing_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#shipping_from_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.shipping_from_country-btn-select').html(item);
		$('.shipping_from_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".shipping_from_country-b").toggle();
		$('#shipping_from_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#shipping_from_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#packing_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.packing_country-btn-select').html(item);
		$('.packing_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".packing_country-b").toggle();
		$('#packing_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#packing_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#shipping_to_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.shipping_to_country-btn-select').html(item);
		$('.shipping_to_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".shipping_to_country-b").toggle();
		$('#shipping_to_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#shipping_to_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#intern_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.intern_country-btn-select').html(item);
		$('.intern_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".intern_country-b").toggle();
		$('#intern_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#intern_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#intern_differing_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.intern_differing_country-btn-select').html(item);
		$('.intern_differing_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".intern_differing_country-b").toggle();
		$('#intern_differing_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#intern_differing_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#from_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.from_country-btn-select').html(item);
		$('.from_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".from_country-b").toggle();
		$('#from_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#from_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#to_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.to_country-btn-select').html(item);
		$('.to_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".to_country-b").toggle();
		$('#to_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#to_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$('#pickup_country-a li').click(function(){
		var self = $(this);
		var item = '<li style="float: left;list-style: none;width: 100%;border-radius: 5px;text-align: left;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.find('img').attr('data-code')+'.png" alt="" value="'+self.find('img').val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
		$('.pickup_country-btn-select').html(item);
		$('.pickup_country-btn-select').attr('value', self.find('img').attr('data-value'));
		$(".pickup_country-b").toggle();
		$('#pickup_country option:selected').each(function(){
			$(this).removeAttr('selected');
			$(this).prop('selected', false);
		});
		$('#pickup_country option[value=\'' + self.find('img').attr('data-value') + '\']').attr('selected', 'selected');
	});

	$(".design-id-btn-select").click(function(){
		$(".design-id-b").toggle();
	});

	$(".country-btn-select").click(function(){
		$(".country-b").toggle();
	});

	$(".differing_country-btn-select").click(function(){
		$(".differing_country-b").toggle();
	});

	$(".packing_country-btn-select").click(function(){
		$(".packing_country-b").toggle();
	});

	$(".shipping_from_country-btn-select").click(function(){
		$(".shipping_from_country-b").toggle();
	});

	$(".shipping_to_country-btn-select").click(function(){
		$(".shipping_to_country-b").toggle();
	});

	$(".intern_country-btn-select").click(function(){
		$(".intern_country-b").toggle();
	});

	$(".intern_differing_country-btn-select").click(function(){
		$(".intern_differing_country-b").toggle();
	});

	$(".from_country-btn-select").click(function(){
		$(".from_country-b").toggle();
	});

	$(".to_country-btn-select").click(function(){
		$(".to_country-b").toggle();
	});

	$(".pickup_country-btn-select").click(function(){
		$(".pickup_country-b").toggle();
	});

});

function setSelect(self){
	$(self).each(function(){
		var a = '#'+this.id+'-a';
		var btn_select = '.'+this.id+'-btn-select';
		$('option', this).each(function(){
			var self = $(this);
			var item = 'list-style: none;width: 100%;border-radius: 5px;text-align: left;background-color: #fff;padding-top: 0.3rem;padding-bottom: 0.3rem;cursor: pointer;" onmouseover="this.style.backgroundColor=\'#0F74BC\';this.style.color=\'#fff\';" onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';"><img src="/img/flags/'+self.attr('data-code')+'.png" alt="" data-code="'+self.attr('data-code')+'" data-value="'+self.val()+'" style="width: 20px;margin: 5px;" /><span style="margin-left: 30px;cursor: pointer;">'+self.text()+'</span></li>';
			if(self.attr('selected') == 'selected'){
				$(btn_select).html('<li style="float: left;'+item);
				$(btn_select).attr('value', this.value);
			}
		});
	});
}