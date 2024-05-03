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

function showStatussesDialog(str_subject, str_body, str_shipments){
	$('#showStatussesDialog div div div.modal-body').html(str_subject.replace(/\*#039;/g, '\'')+str_body.replace(/\*#039;/g, '\'')+str_shipments.replace(/\*#039;/g, '\''));
	$('#showStatussesDialog').modal();
}

$(document).ready(function(){

	jQuery('[data-toggle="tooltip"]').tooltip({'animation': true, 'delay': { 'show': 0, 'hide': 0 }, 'html': true, 'template': '<div class="tooltip bs-tooltip-top" role="tooltip"><div class="arrow"></div><div class="tooltip-inner bg-primary border border-dark text-left"></div></div>'});
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

});

