/* DBB: overfutz@yahoo.com, File: dbbcookieconsent.js, Date: 09.01.2021 */
window.cookieconsent = {
	defaults: {
		display_type: "modal", 
		cookieDate: new Date(), 
		cookieLifeTime: 31104000000, 
		container_backgroundColor: "bg-primary", 
		modal_size: "modal-xl", 
		header_text: "Cookie bestätigung", 
		header_tag: "h2", 
		header_color: "text-primary", 
		header_close: true, 
		image_src: "/img/cookies_modal_dialog.jpg", 
		image_class: "img-thumbnail", 
		image_style: "width: 150px", 
		description_color: "text-warning", 
		description_text: "Cookies<br>.... [options] ... [link] ....", 
		options_label: "Optionen", 
		options_color: "text-white", 
		link_url: "/datenschutz", 
		link_color: "text-white", 
		checkbox_label_color: "text-white", 
		button_accept_label: "Alle akzeptieren", 
		button_accept_label2: "Ausgewählte akzeptieren", 
		button_accept_backgroundColor: "btn-warning", 
		button_accept_color: "text-dark", 
		button_close_enable: true, 
		button_close_label: "schließen", 
		button_close_backgroundColor: "btn-warning", 
		button_close_color: "text-dark", 
		button_options_label: "Cookie-Optionen", 
		button_options_class: "btn btn-primary border border-white", 
		button_options_style: "position: fixed;bottom: -10px;left: 20px;border-radius: 15px;box-shadow: 0 0 4px rgba(0,0,0,.8);z-Index: 1001;display: none", 
		elements: {
			cookieconsent_container: {}, 
			cookieconsent_header_close: {}, 
			cookieconsent_button_close: {}, 
			cookieconsent_button_accept: {}, 
			cookieconsent_link_options: {}, 
			cookieconsent_checkbox_marketing: {}, 
			cookieconsent_checkbox_personal: {}, 
			cookieconsent_checkbox_analize: {}, 
			cookieconsent_show_options: {}
		}
	}, 
	settings: {}, 
	initialise: function (options){
		this.settings = $.extend({}, this.defaults, options);
		this.append();
	}, 
	append: function (){
		var self = this;
		var settings = this.settings;
		var elements = settings.elements;
		var header_close = settings.header_close ? '<button type="button" id="cookieconsent_header_close" class="close"><span aria-hidden="true">&times;</span></button>' : '';
		var footer_close = settings.button_close_enable ? '<button type="button" id="cookieconsent_button_close" class="btn '+settings.button_close_backgroundColor+' '+settings.button_close_color+'" data-dismiss="modal">'+settings.button_close_label+'</button>' : '';
		var options = '<a href="Javascript:void 0" id="cookieconsent_link_options" class="'+settings.options_color+'">'+settings.options_label+'</a>';
		var link = '<a href="'+settings.link_url+'" target="_blank" class="'+settings.link_color+'">'+settings.link_label+'</a>';
		if(settings.display_type == "container"){
			$('<div id=\'cookieconsent_container\' class=\'container-fluid fixed-bottom '+settings.container_backgroundColor+'\'><div class="row my-3"><div id="cookieconsent_div_image" class="col-sm-2 text-center align-self-center pr-0"><img src="'+settings.image_src+'" class="'+settings.image_class+'" style="'+settings.image_style+'" /></div><div id="cookieconsent_div_content" class="col-sm-10"><span class="'+settings.description_color+'">'+settings.description_text.replace('[link]', link).replace('[options]', options)+'</span></div><div id="cookieconsent_div_options" class="d-none"><div class="custom-control custom-checkbox mt-3"><input type="checkbox" id="cookieconsent_checkbox_marketing" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_marketing" class="custom-control-label '+settings.checkbox_label_color+'">Marketing</label></div><div class="custom-control custom-checkbox"><input type="checkbox" id="cookieconsent_checkbox_personal" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_personal" class="custom-control-label '+settings.checkbox_label_color+'">Personalisierung</label></div><div class="custom-control custom-checkbox"><input type="checkbox" id="cookieconsent_checkbox_analize" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_analize" class="custom-control-label '+settings.checkbox_label_color+'">Analysen</label></div></div></div><div class="row my-3"><div class=\'col-sm-12 text-right\'><span>'+footer_close+' <button id=\'cookieconsent_button_accept\' class=\'btn '+settings.button_accept_backgroundColor+' '+settings.button_accept_color+'\'>'+settings.button_accept_label+'</button></span></div></div></div>').appendTo('body');
		}
		if(settings.display_type == "modal"){
			$('<div class="modal fade" id="cookieconsent_container" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"><div class="modal-dialog '+settings.modal_size+' modal-dialog-centered"><div class="modal-content '+settings.container_backgroundColor+'"><div class="modal-header"><'+settings.header_tag+' class="modal-title '+settings.header_color+' mt-0" id="staticBackdropLabel">'+settings.header_text+'</'+settings.header_tag+'>'+header_close+'</div><div class="modal-body"><div class="row"><div id="cookieconsent_div_image" class="col-sm-2 text-center align-self-center pr-0"><img src="'+settings.image_src+'" class="'+settings.image_class+'" style="'+settings.image_style+'" /></div><div id="cookieconsent_div_content" class="col-sm-10"><span class="'+settings.description_color+'">'+settings.description_text.replace('[link]', link).replace('[options]', options)+'</span></div><div id="cookieconsent_div_options" class="d-none"><div class="custom-control custom-checkbox mt-3"><input type="checkbox" id="cookieconsent_checkbox_marketing" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_marketing" class="custom-control-label '+settings.checkbox_label_color+'">Marketing</label></div>&nbsp;&nbsp;&nbsp;<div class="custom-control custom-checkbox"><input type="checkbox" id="cookieconsent_checkbox_personal" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_personal" class="custom-control-label '+settings.checkbox_label_color+'">Personalisierung</label></div>&nbsp;&nbsp;&nbsp;<div class="custom-control custom-checkbox"><input type="checkbox" id="cookieconsent_checkbox_analize" value="1" checked="checked" class="custom-control-input" /> <label for="cookieconsent_checkbox_analize" class="custom-control-label '+settings.checkbox_label_color+'">Analysen</label></div></div></div></div><div class="modal-footer">'+footer_close+'<button id="cookieconsent_button_accept" class="btn '+settings.button_accept_backgroundColor+' '+settings.button_accept_color+'">'+settings.button_accept_label+'</button></div></div></div></div>').appendTo('body');
		}
		$('<a href="Javascript:void 0" id="cookieconsent_show_options" class="'+settings.button_options_class+'" style="'+settings.button_options_style+'">'+settings.button_options_label+'</span></a>').appendTo('body');
		elements.cookieconsent_container = document.getElementById('cookieconsent_container');
		elements.cookieconsent_header_close = document.getElementById('cookieconsent_header_close');
		elements.cookieconsent_button_close = document.getElementById('cookieconsent_button_close');
		elements.cookieconsent_button_accept = document.getElementById('cookieconsent_button_accept');
		elements.cookieconsent_link_options = document.getElementById('cookieconsent_link_options');
		elements.cookieconsent_checkbox_marketing = document.getElementById('cookieconsent_checkbox_marketing');
		elements.cookieconsent_checkbox_personal = document.getElementById('cookieconsent_checkbox_personal');
		elements.cookieconsent_checkbox_analize = document.getElementById('cookieconsent_checkbox_analize');
		elements.cookieconsent_show_options = document.getElementById('cookieconsent_show_options');
		if(elements.cookieconsent_header_close){
			elements.cookieconsent_header_close.onclick = function(e){
				self.hide();
			};
		}
		if(elements.cookieconsent_button_close){
			elements.cookieconsent_button_close.onclick = function(e){
				settings.cookieDate.setTime(new Date().getTime() + settings.cookieLifeTime);
				document.cookie = 'dbbCookieconsent=42; path=/; expires=' + settings.cookieDate.toUTCString();
				self.hide();
			};
		}
		elements.cookieconsent_button_accept.onclick = function(e){
			settings.cookieDate.setTime(new Date().getTime() + settings.cookieLifeTime);
			var val = $('#cookieconsent_div_options').hasClass('col-sm-3') ? self.checkToNumber[''+(elements.cookieconsent_checkbox_marketing.checked?1:0)+(elements.cookieconsent_checkbox_personal.checked?1:0)+(elements.cookieconsent_checkbox_analize.checked?1:0)] : self.checkToNumber['111'];
			document.cookie = 'dbbCookieconsent='+val+'; path=/; expires=' + settings.cookieDate.toUTCString();
			self.hide();
			if(elements.cookieconsent_checkbox_marketing.checked){enableMarketing();}
			if(elements.cookieconsent_checkbox_personal.checked){enablePersonal();}
			if(elements.cookieconsent_checkbox_analize.checked){enableAnalyze();}
			enableCookie();
		};
		if(elements.cookieconsent_link_options){
			elements.cookieconsent_link_options.onclick = function(e){
				if(settings.display_type == "container"){
					$('#cookieconsent_div_content').toggleClass('col-sm-8 col-sm-10');
					$('#cookieconsent_div_options').toggleClass('d-none col-sm-2');
				}
				if(settings.display_type == "modal"){
					$('#cookieconsent_div_content').toggleClass('col-sm-7 col-sm-10');
					$('#cookieconsent_div_options').toggleClass('d-none col-sm-3');
				}
				elements.cookieconsent_button_accept.innerHTML = $('#cookieconsent_div_options').hasClass('col-sm-3') ? settings.button_accept_label2 : settings.button_accept_label;
			};
		}
		elements.cookieconsent_show_options.onclick = function(e){
			self.setOptions();
			self.show();
		};
		elements.cookieconsent_show_options.onmouseover = function(e){
			$('#cookieconsent_show_options').animate({bottom: '10px'}, 400);
		};
		elements.cookieconsent_show_options.onmouseout = function(e){
			$('#cookieconsent_show_options').animate({bottom: '-10px'}, 400);
		};
		if(document.cookie.indexOf('dbbCookieconsent=') == -1){
			this.show();
		}else{
			this.setOptions();
			this.hide();
		}
	}, 
	show: function(){
		var settings = this.settings;
		var elements = settings.elements;
		if(settings.display_type == "container"){
			elements.cookieconsent_container.style.display = 'block';
		}
		if(settings.display_type == "modal"){
			$('#cookieconsent_container').modal('show');
		}
		elements.cookieconsent_show_options.style.display = 'none';
	}, 
	hide: function(){
		var settings = this.settings;
		var elements = settings.elements;
		if(settings.display_type == "container"){
			elements.cookieconsent_container.style.display = 'none';
		}
		if(settings.display_type == "modal"){
			$('#cookieconsent_container').modal('hide');
		}
		elements.cookieconsent_show_options.style.display = 'block';
	}, 
	setOptions: function(){
		var settings = this.settings;
		var elements = settings.elements;
		const b = document.cookie.match('(^|;)\\s*dbbCookieconsent\\s*=\\s*([^;]+)');
		var val = b ? b.pop() : 42;
		if(val >= 0 && val < 8){
			var chk = this.numberToCheck[val];
			if(chk.a == 1){elements.cookieconsent_checkbox_marketing.checked = true;enableMarketing();}else{elements.cookieconsent_checkbox_marketing.checked = false;}
			if(chk.b == 1){elements.cookieconsent_checkbox_personal.checked = true;enablePersonal();}else{elements.cookieconsent_checkbox_personal.checked = false;}
			if(chk.c == 1){elements.cookieconsent_checkbox_analize.checked = true;enableAnalyze();}else{elements.cookieconsent_checkbox_analize.checked = false;}
			enableCookie();
		}
	}, 
	checkToNumber: {
		'000': 0, 
		'001': 1, 
		'010': 2, 
		'011': 3, 
		'100': 4, 
		'101': 5, 
		'110': 6, 
		'111': 7
	}, 
	numberToCheck: {
		0: {a: 0, b: 0, c: 0}, 
		1: {a: 0, b: 0, c: 1}, 
		2: {a: 0, b: 1, c: 0}, 
		3: {a: 0, b: 1, c: 1}, 
		4: {a: 1, b: 0, c: 0}, 
		5: {a: 1, b: 0, c: 1}, 
		6: {a: 1, b: 1, c: 0}, 
		7: {a: 1, b: 1, c: 1}
	}
};