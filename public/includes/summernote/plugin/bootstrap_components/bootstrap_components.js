(function(factory) {
	/* global define */
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(window.jQuery);
	}
}(function($) {

	/**
	* @class plugin.bootstrap_components
	*
	* Initialize in the toolbar like so:
	*   toolbar: ['insert', ['bootstrap_components']]
	*
	* Bootstrap-Components Plugin
	*/

	$.extend(true,$.summernote.lang, {
		'en-US': {
			bootstrap_components: {
				exampleText: 'Bootstrap Components',
				dialogTitle: 'Bootstrap Components',
				okButton: 'OK'
			}
		}
	});

	$.extend($.summernote.options, {

		showButtonNames: false

	});

	$.extend($.summernote.plugins, {

		'fontawesome': function(context) {

			var self      = this,

				ui        = $.summernote.ui,
				$note     = context.layoutInfo.note,

				$editor   = context.layoutInfo.editor,
				$editable = context.layoutInfo.editable,
				$toolbar  = context.layoutInfo.toolbar,

				options   = context.options,

				lang      = options.langInfo;

			// add fontawesome button
			context.memo('button.fontawesome', function() {
				var $fontawesome = ui.button([
					ui.button({
						className: '',
						contents: '<span class="fa fa-exclamation"></span>' + (options.showButtonNames == true ? ' Fontawesome' : '') + '',
						tooltip: 'Fontawesome',
						click: function () {
							context.invoke('editor.saveRange');

							var html = 	'<div class="form-group row">' + 
										'	<label class="col-sm-6 col-form-label" for="fontawesome-dialog-color">Color</label><div class="col-sm-6"><select name="fontawesome-dialog-color" id="fontawesome-dialog-color">' + bootstrap_options_colors + '</select></div>' + 
										'	<label class="col-sm-6 col-form-label" for="fontawesome-dialog-background">Background</label><div class="col-sm-6"><select name="fontawesome-dialog-background" id="fontawesome-dialog-background">' + bootstrap_options_colors + '</select></div>' + 
										'	<label class="col-sm-6 col-form-label" for="fontawesome-dialog-size">Size</label><div class="col-sm-6"><input type="text" name="fontawesome-dialog-size" id="fontawesome-dialog-size" value="" placeholder="3rem" ondblclick="this.value=this.placeholder" /></div>' + 
										'	<label class="col-sm-6 col-form-label" for="fontawesome-dialog-icon">Icon</label>' + 
										'	<div class="col-sm-6">' + 
										'	<div class="border" style="height: 180px;overflow-y: scroll">' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-glass&quot;> </i>\')"><i class="fa fa-glass"> </i> Glass</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-music&quot;> </i>\')"><i class="fa fa-music"> </i> Music</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-search&quot;> </i>\')"><i class="fa fa-search"> </i> Search</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-envelope-o&quot;> </i>\')"><i class="fa fa-envelope-o"> </i> Envelope-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-heart&quot;> </i>\')"><i class="fa fa-heart"> </i> Heart</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-star&quot;> </i>\')"><i class="fa fa-star"> </i> Star</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-star-o&quot;> </i>\')"><i class="fa fa-star-o"> </i> Star-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-user&quot;> </i>\')"><i class="fa fa-user"> </i> User</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-film&quot;> </i>\')"><i class="fa fa-film"> </i> Film</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-th-large&quot;> </i>\')"><i class="fa fa-th-large"> </i> Th-Large</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-th&quot;> </i>\')"><i class="fa fa-th"> </i> Th</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-th-list&quot;> </i>\')"><i class="fa fa-th-list"> </i> Th-List</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-check&quot;> </i>\')"><i class="fa fa-check"> </i> Check</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-times&quot;> </i>\')"><i class="fa fa-times"> </i> Times</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-search-plus&quot;> </i>\')"><i class="fa fa-search-plus"> </i> Search-Plus</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-search-minus&quot;> </i>\')"><i class="fa fa-search-minus"> </i> Search-Minus</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-power-off&quot;> </i>\')"><i class="fa fa-power-off"> </i> Power-Off</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-signal&quot;> </i>\')"><i class="fa fa-signal"> </i> Signal</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cog&quot;> </i>\')"><i class="fa fa-cog"> </i> Cog</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-trash-o&quot;> </i>\')"><i class="fa fa-trash-o"> </i> Trash-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-home&quot;> </i>\')"><i class="fa fa-home"> </i> Home</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-file-o&quot;> </i>\')"><i class="fa fa-file-o"> </i> File-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-clock-o&quot;> </i>\')"><i class="fa fa-clock-o"> </i> Clock-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-road-o&quot;> </i>\')"><i class="fa fa-road-o"> </i> Road-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-download&quot;> </i>\')"><i class="fa fa-download"> </i> Download</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-o-down&quot;> </i>\')"><i class="fa fa-arrow-circle-o-down"> </i> Arrow-Circle-O-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-o-up&quot;> </i>\')"><i class="fa fa-arrow-circle-o-up"> </i> Arrow-Circle-O-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-inbox&quot;> </i>\')"><i class="fa fa-inbox"> </i> Inbox</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-play-circle-o&quot;> </i>\')"><i class="fa fa-play-circle-o"> </i> Play-Circle-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-repeat&quot;> </i>\')"><i class="fa fa-repeat"> </i> Repeat</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-refresh&quot;> </i>\')"><i class="fa fa-refresh"> </i> Refresh</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-list-alt&quot;> </i>\')"><i class="fa fa-list-alt"> </i> List-Alt</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-lock&quot;> </i>\')"><i class="fa fa-lock"> </i> Lock</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-flag&quot;> </i>\')"><i class="fa fa-flag"> </i> Flag</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-headphones&quot;> </i>\')"><i class="fa fa-headphones"> </i> Headphones</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-volume-off&quot;> </i>\')"><i class="fa fa-volume-off"> </i> Volume-Off</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-volume-down&quot;> </i>\')"><i class="fa fa-volume-down"> </i> Volume-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-volume-up&quot;> </i>\')"><i class="fa fa-volume-up"> </i> Volume-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-qrcode&quot;> </i>\')"><i class="fa fa-qrcode"> </i> QRcode</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tag&quot;> </i>\')"><i class="fa fa-tag"> </i> Tag</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tags&quot;> </i>\')"><i class="fa fa-tags"> </i> Tags</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-book&quot;> </i>\')"><i class="fa fa-book"> </i> Book</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bookmark&quot;> </i>\')"><i class="fa fa-bookmark"> </i> Bookmark</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-print&quot;> </i>\')"><i class="fa fa-print"> </i> Print</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-camera&quot;> </i>\')"><i class="fa fa-camera"> </i> Camera</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-font&quot;> </i>\')"><i class="fa fa-font"> </i> Font</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bold&quot;> </i>\')"><i class="fa fa-bold"> </i> Bold</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-italic&quot;> </i>\')"><i class="fa fa-italic"> </i> Italic</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-text-height&quot;> </i>\')"><i class="fa fa-text-height"> </i> Text-Height</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-text-width&quot;> </i>\')"><i class="fa fa-text-width"> </i> Text-Width</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-align-left&quot;> </i>\')"><i class="fa fa-align-left"> </i> Align-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-align-center&quot;> </i>\')"><i class="fa fa-align-center"> </i> Align-Center</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-align-right&quot;> </i>\')"><i class="fa fa-align-right"> </i> Align-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-align-justify&quot;> </i>\')"><i class="fa fa-align-justify"> </i> Align-Justify</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-list&quot;> </i>\')"><i class="fa fa-list"> </i> List</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-outdent&quot;> </i>\')"><i class="fa fa-outdent"> </i> Outdent</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-indent&quot;> </i>\')"><i class="fa fa-indent"> </i> Indent</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-video-camera&quot;> </i>\')"><i class="fa fa-video-camera"> </i> Video-Camera</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-picture-o&quot;> </i>\')"><i class="fa fa-picture-o"> </i> Picture-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pencil&quot;> </i>\')"><i class="fa fa-pencil"> </i> Pencil</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-map-marker&quot;> </i>\')"><i class="fa fa-map-marker"> </i> Map-Marker</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-adjust&quot;> </i>\')"><i class="fa fa-adjust"> </i> Adjust</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tint&quot;> </i>\')"><i class="fa fa-tint"> </i> Tint</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pencil-square-o&quot;> </i>\')"><i class="fa fa-pencil-square-o"> </i> Pencil-Square-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-share-square-o&quot;> </i>\')"><i class="fa fa-share-square-o"> </i> Share-Quare-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-check-square-o&quot;> </i>\')"><i class="fa fa-check-square-o"> </i> Check-Quare-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrows&quot;> </i>\')"><i class="fa fa-arrows"> </i> Arrows</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-step-backward&quot;> </i>\')"><i class="fa fa-step-backward"> </i> Step-Backward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-fast-backward&quot;> </i>\')"><i class="fa fa-fast-backward"> </i> Fast-Backward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-backward&quot;> </i>\')"><i class="fa fa-backward"> </i> Backward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-play&quot;> </i>\')"><i class="fa fa-play"> </i> Play</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pause&quot;> </i>\')"><i class="fa fa-pause"> </i> Pause</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-stop&quot;> </i>\')"><i class="fa fa-stop"> </i> Stop</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-forward&quot;> </i>\')"><i class="fa fa-forward"> </i> Forward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-fast-forward&quot;> </i>\')"><i class="fa fa-fast-forward"> </i> Fast-Forward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-step-forward&quot;> </i>\')"><i class="fa fa-step-forward"> </i> Step-Forward</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-eject&quot;> </i>\')"><i class="fa fa-eject"> </i> Eject</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-left&quot;> </i>\')"><i class="fa fa-chevron-left"> </i> Chevron-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-right&quot;> </i>\')"><i class="fa fa-chevron-right"> </i> Chevron-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-plus-circle&quot;> </i>\')"><i class="fa fa-plus-circle"> </i> Plus-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-minus-circle&quot;> </i>\')"><i class="fa fa-minus-circle"> </i> Minus-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-times-circle&quot;> </i>\')"><i class="fa fa-times-circle"> </i> Times-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-check-circle&quot;> </i>\')"><i class="fa fa-check-circle"> </i> Check-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-question-circle&quot;> </i>\')"><i class="fa fa-question-circle"> </i> Question-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-info-circle&quot;> </i>\')"><i class="fa fa-info-circle"> </i> Info-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-crosshairs&quot;> </i>\')"><i class="fa fa-crosshairs"> </i> Crosshairs</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-times-circle-o&quot;> </i>\')"><i class="fa fa-times-circle-o"> </i> Times-Circle-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-check-circle-o&quot;> </i>\')"><i class="fa fa-check-circle-o"> </i> Check-Circle-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-ban&quot;> </i>\')"><i class="fa fa-ban"> </i> Ban</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-left&quot;> </i>\')"><i class="fa fa-arrow-left"> </i> Arrow-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-right&quot;> </i>\')"><i class="fa fa-arrow-right"> </i> Arrow-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-up&quot;> </i>\')"><i class="fa fa-arrow-up"> </i> Arrow-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-down&quot;> </i>\')"><i class="fa fa-arrow-down"> </i> Arrow-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-share&quot;> </i>\')"><i class="fa fa-share"> </i> Share</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-expand&quot;> </i>\')"><i class="fa fa-expand"> </i> Expand</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-compress&quot;> </i>\')"><i class="fa fa-compress"> </i> Compress</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-plus&quot;> </i>\')"><i class="fa fa-plus"> </i> Plus</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-minus&quot;> </i>\')"><i class="fa fa-minus"> </i> Minus</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-asterisk&quot;> </i>\')"><i class="fa fa-asterisk"> </i> Asterisk</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-exclamation-circle&quot;> </i>\')"><i class="fa fa-exclamation-circle"> </i> Exclamation-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-gift&quot;> </i>\')"><i class="fa fa-gift"> </i> Gift</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-leaf&quot;> </i>\')"><i class="fa fa-leaf"> </i> Leaf</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-fire&quot;> </i>\')"><i class="fa fa-fire"> </i> Fire</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-eye&quot;> </i>\')"><i class="fa fa-eye"> </i> Eye</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-eye-slash&quot;> </i>\')"><i class="fa fa-eye-slash"> </i> Eye-Slash</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-exclamation-triangle&quot;> </i>\')"><i class="fa fa-exclamation-triangle"> </i> Exclamation-Triangle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-plane&quot;> </i>\')"><i class="fa fa-plane"> </i> Plane</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-calendar&quot;> </i>\')"><i class="fa fa-calendar"> </i> Calendar</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-random&quot;> </i>\')"><i class="fa fa-random"> </i> Random</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-comment&quot;> </i>\')"><i class="fa fa-comment"> </i> Comment</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-magnet&quot;> </i>\')"><i class="fa fa-magnet"> </i> Magnet</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-up&quot;> </i>\')"><i class="fa fa-chevron-up"> </i> Chevron-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-down&quot;> </i>\')"><i class="fa fa-chevron-down"> </i> Chevron-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-retweet&quot;> </i>\')"><i class="fa fa-retweet"> </i> Retweet</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-shopping-cart&quot;> </i>\')"><i class="fa fa-shopping-cart"> </i> Shopping-Cart</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-folder&quot;> </i>\')"><i class="fa fa-folder"> </i> Folder</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-folder-open&quot;> </i>\')"><i class="fa fa-folder-open"> </i> Folder-Open</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrows-v&quot;> </i>\')"><i class="fa fa-arrows-v"> </i> Arrows-V</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrows-h&quot;> </i>\')"><i class="fa fa-arrows-h"> </i> Arrows-H</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bar-chart&quot;> </i>\')"><i class="fa fa-bar-chart"> </i> Bar-Chart</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-twitter-square&quot;> </i>\')"><i class="fa fa-twitter-square"> </i> Twitter-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-facebook-square&quot;> </i>\')"><i class="fa fa-facebook-square"> </i> Facebook-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-camera-retro&quot;> </i>\')"><i class="fa fa-camera-retro"> </i> Camera-Retro</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-key&quot;> </i>\')"><i class="fa fa-key"> </i> Key</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cogs&quot;> </i>\')"><i class="fa fa-cogs"> </i> Cogs</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-comments&quot;> </i>\')"><i class="fa fa-comments"> </i> Comments</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-thumbs-o-up&quot;> </i>\')"><i class="fa fa-thumbs-o-up"> </i> Thumbs-O-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-thumbs-o-down&quot;> </i>\')"><i class="fa fa-thumbs-o-down"> </i> Thumbs-O-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-star-half&quot;> </i>\')"><i class="fa fa-star-half"> </i> Star-Half</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-heart-o&quot;> </i>\')"><i class="fa fa-heart-o"> </i> Heart-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sign-out&quot;> </i>\')"><i class="fa fa-sign-out"> </i> Sign-Out</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-linkedin-square&quot;> </i>\')"><i class="fa fa-linkedin-square"> </i> Linkedin-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-thumb-tack&quot;> </i>\')"><i class="fa fa-thumb-tack"> </i> Thumb-Tack</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-external-link&quot;> </i>\')"><i class="fa fa-external-link"> </i> External-Link</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sign-in&quot;> </i>\')"><i class="fa fa-sign-in"> </i> Sign-In</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-trophy&quot;> </i>\')"><i class="fa fa-trophy"> </i> Trophy</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-github-square&quot;> </i>\')"><i class="fa fa-github-square"> </i> Github-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-upload&quot;> </i>\')"><i class="fa fa-upload"> </i> Upload</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-lemon-o&quot;> </i>\')"><i class="fa fa-lemon-o"> </i> Lemon-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-phone&quot;> </i>\')"><i class="fa fa-phone"> </i> Phone</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-square-o&quot;> </i>\')"><i class="fa fa-square-o"> </i> Square-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bookmark-o&quot;> </i>\')"><i class="fa fa-bookmark-o"> </i> Bookmark-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-phone-square&quot;> </i>\')"><i class="fa fa-phone-square"> </i> Phone-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-twitter&quot;> </i>\')"><i class="fa fa-twitter"> </i> Twitter</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-facebook&quot;> </i>\')"><i class="fa fa-facebook"> </i> Facebook</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-github&quot;> </i>\')"><i class="fa fa-github"> </i> Github</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-unlock&quot;> </i>\')"><i class="fa fa-unlock"> </i> Unlock</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-credit-card&quot;> </i>\')"><i class="fa fa-credit-card"> </i> Credit-Card</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-rss&quot;> </i>\')"><i class="fa fa-rss"> </i> RSS</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hdd-o&quot;> </i>\')"><i class="fa fa-hdd-o"> </i> HDD-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bullhorn&quot;> </i>\')"><i class="fa fa-bullhorn"> </i> Bullhorn</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bell&quot;> </i>\')"><i class="fa fa-bell"> </i> Bell</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-certificate&quot;> </i>\')"><i class="fa fa-certificate"> </i> Certificate</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hand-o-right&quot;> </i>\')"><i class="fa fa-hand-o-right"> </i> Hand-O-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hand-o-left&quot;> </i>\')"><i class="fa fa-hand-o-left"> </i> Hand-O-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hand-o-up&quot;> </i>\')"><i class="fa fa-hand-o-up"> </i> Hand-O-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hand-o-down&quot;> </i>\')"><i class="fa fa-hand-o-down"> </i> Hand-O-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-left&quot;> </i>\')"><i class="fa fa-arrow-circle-left"> </i> Arrow-Circle-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-right&quot;> </i>\')"><i class="fa fa-arrow-circle-right"> </i> Arrow-Circle-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-up&quot;> </i>\')"><i class="fa fa-arrow-circle-up"> </i> Arrow-circle-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-down&quot;> </i>\')"><i class="fa fa-arrow-circle-down"> </i> Arrow-Circle-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-globe&quot;> </i>\')"><i class="fa fa-globe"> </i> Globe</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-wrench&quot;> </i>\')"><i class="fa fa-wrench"> </i> Wrench</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tasks&quot;> </i>\')"><i class="fa fa-tasks"> </i> Tasks</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-filter&quot;> </i>\')"><i class="fa fa-filter"> </i> Filter</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-briefcase&quot;> </i>\')"><i class="fa fa-briefcase"> </i> Briefcase</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrows-alt&quot;> </i>\')"><i class="fa fa-arrows-alt"> </i> Arrows-Alt</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-users&quot;> </i>\')"><i class="fa fa-users"> </i> Users</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-link&quot;> </i>\')"><i class="fa fa-link"> </i> Link</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cloud&quot;> </i>\')"><i class="fa fa-cloud"> </i> Cloud</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-flask&quot;> </i>\')"><i class="fa fa-flask"> </i> Flask</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-scissors&quot;> </i>\')"><i class="fa fa-scissors"> </i> Scissors</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-files-o&quot;> </i>\')"><i class="fa fa-files-o"> </i> Files-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-paperclip&quot;> </i>\')"><i class="fa fa-paperclip"> </i> Paperclip</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-floppy-o&quot;> </i>\')"><i class="fa fa-floppy-o"> </i> Floppy-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-square&quot;> </i>\')"><i class="fa fa-square"> </i> Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bars&quot;> </i>\')"><i class="fa fa-bars"> </i> bars</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-list-ul&quot;> </i>\')"><i class="fa fa-list-ul"> </i> List-UL</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-list-ol&quot;> </i>\')"><i class="fa fa-list-ol"> </i> List-OL</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-strikethrough&quot;> </i>\')"><i class="fa fa-strikethrough"> </i> Strikethrough</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-underline&quot;> </i>\')"><i class="fa fa-underline"> </i> Underline</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-table&quot;> </i>\')"><i class="fa fa-table"> </i> Table</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-magic&quot;> </i>\')"><i class="fa fa-magic"> </i> Magic</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-truck&quot;> </i>\')"><i class="fa fa-truck"> </i> Truck</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pinterest&quot;> </i>\')"><i class="fa fa-pinterest"> </i> PInterest</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pinterest-square&quot;> </i>\')"><i class="fa fa-pinterest-square"> </i> PInterest-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-google-plus-square&quot;> </i>\')"><i class="fa fa-google-plus-square"> </i> Google-Plus-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-google-plus&quot;> </i>\')"><i class="fa fa-google-plus"> </i> Google-Plus</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-money&quot;> </i>\')"><i class="fa fa-money"> </i> Money</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-down&quot;> </i>\')"><i class="fa fa-caret-down"> </i> Caret-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-up&quot;> </i>\')"><i class="fa fa-caret-up"> </i> Caret-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-left&quot;> </i>\')"><i class="fa fa-caret-left"> </i> Caret-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-right&quot;> </i>\')"><i class="fa fa-caret-right"> </i> Caret-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-columns&quot;> </i>\')"><i class="fa fa-columns"> </i> Columns</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort&quot;> </i>\')"><i class="fa fa-sort"> </i> Sort</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-desc&quot;> </i>\')"><i class="fa fa-sort-desc"> </i> Sort-DESC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-asc&quot;> </i>\')"><i class="fa fa-sort-asc"> </i> Sort-ASC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-envelope&quot;> </i>\')"><i class="fa fa-envelope"> </i> Envelope</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-linkedin&quot;> </i>\')"><i class="fa fa-linkedin"> </i> Linkedin</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-undo&quot;> </i>\')"><i class="fa fa-undo"> </i> Undo</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-gavel&quot;> </i>\')"><i class="fa fa-gavel"> </i> Gavel</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tachometer&quot;> </i>\')"><i class="fa fa-tachometer"> </i> Tachometer</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-comment-o&quot;> </i>\')"><i class="fa fa-comment-o"> </i> Comment-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-comments-o&quot;> </i>\')"><i class="fa fa-comments-o"> </i> Comments-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bolt&quot;> </i>\')"><i class="fa fa-bolt"> </i> Bolt</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sitemap&quot;> </i>\')"><i class="fa fa-sitemap"> </i> Sitemap</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-umbrella&quot;> </i>\')"><i class="fa fa-umbrella"> </i> Umbrella</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-clipboard&quot;> </i>\')"><i class="fa fa-clipboard"> </i> Clipboard</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-lightbulb-o&quot;> </i>\')"><i class="fa fa-lightbulb-o"> </i> Lightbulb-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-exchange&quot;> </i>\')"><i class="fa fa-exchange"> </i> Exchange</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cloud-download&quot;> </i>\')"><i class="fa fa-cloud-download"> </i> Cloud-Download</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cloud-upload&quot;> </i>\')"><i class="fa fa-cloud-upload"> </i> Cloud-Upload</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-user-md&quot;> </i>\')"><i class="fa fa-user-md"> </i> User-MD</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-stethoscope&quot;> </i>\')"><i class="fa fa-stethoscope"> </i> Stethoscope</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-suitcase&quot;> </i>\')"><i class="fa fa-suitcase"> </i> Suitcase</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bell-o&quot;> </i>\')"><i class="fa fa-bell-o"> </i> Bell-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-coffee&quot;> </i>\')"><i class="fa fa-coffee"> </i> Coffee</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-cutlery&quot;> </i>\')"><i class="fa fa-cutlery"> </i> Cutlery</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-file-text-o&quot;> </i>\')"><i class="fa fa-file-text-o"> </i> File-Text-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-building-o&quot;> </i>\')"><i class="fa fa-building-o"> </i> Building-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-hospital-o&quot;> </i>\')"><i class="fa fa-hospital-o"> </i> Hospital-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-ambulance&quot;> </i>\')"><i class="fa fa-ambulance"> </i> Ambulance</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-medkit&quot;> </i>\')"><i class="fa fa-medkit"> </i> Medkit</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-fighter-jet&quot;> </i>\')"><i class="fa fa-fighter-jet"> </i> Fighter-Jet</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-beer&quot;> </i>\')"><i class="fa fa-beer"> </i> Beer</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-h-square&quot;> </i>\')"><i class="fa fa-h-square"> </i> H-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-plus-square&quot;> </i>\')"><i class="fa fa-plus-square"> </i> Plus-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-double-left&quot;> </i>\')"><i class="fa fa-angle-double-left"> </i> Angle-Double-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-double-right&quot;> </i>\')"><i class="fa fa-angle-double-right"> </i> Angle-Double-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-double-up&quot;> </i>\')"><i class="fa fa-angle-double-up"> </i> Angle-Double-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-double-down&quot;> </i>\')"><i class="fa fa-angle-double-down"> </i> Angle-Double-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-left&quot;> </i>\')"><i class="fa fa-angle-left"> </i> Angle-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-right&quot;> </i>\')"><i class="fa fa-angle-right"> </i> Angle-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-up&quot;> </i>\')"><i class="fa fa-angle-up"> </i> Angle-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-angle-down&quot;> </i>\')"><i class="fa fa-angle-down"> </i> Angle-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-desktop&quot;> </i>\')"><i class="fa fa-desktop"> </i> Desktop</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-laptop&quot;> </i>\')"><i class="fa fa-laptop"> </i> Laptop</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tablet&quot;> </i>\')"><i class="fa fa-tablet"> </i> Tablet</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-mobile&quot;> </i>\')"><i class="fa fa-mobile"> </i> Mobile</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-circle-o&quot;> </i>\')"><i class="fa fa-circle-o"> </i> Circle-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-quote-left&quot;> </i>\')"><i class="fa fa-quote-left"> </i> Quote-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-quote-right&quot;> </i>\')"><i class="fa fa-quote-right"> </i> Quote-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-spinner&quot;> </i>\')"><i class="fa fa-spinner"> </i> Spinner</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-circle&quot;> </i>\')"><i class="fa fa-circle"> </i> Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-reply&quot;> </i>\')"><i class="fa fa-reply"> </i> Reply</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-github-alt&quot;> </i>\')"><i class="fa fa-github-alt"> </i> Github-Alt</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-folder-o&quot;> </i>\')"><i class="fa fa-folder-o"> </i> Folder-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-folder-open-o&quot;> </i>\')"><i class="fa fa-folder-open-o"> </i> Folder-Open-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-smile-o&quot;> </i>\')"><i class="fa fa-smile-o"> </i> Smile-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-frown-o&quot;> </i>\')"><i class="fa fa-frown-o"> </i> Frown-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-meh-o&quot;> </i>\')"><i class="fa fa-meh-o"> </i> Meh-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-gamepad&quot;> </i>\')"><i class="fa fa-gamepad"> </i> Gamepad</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-keyboard-o&quot;> </i>\')"><i class="fa fa-keyboard-o"> </i> Keyboard-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-flag-o&quot;> </i>\')"><i class="fa fa-flag-o"> </i> Flag-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-flag-checkered&quot;> </i>\')"><i class="fa fa-flag-checkered"> </i> Flag-Checkered</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-terminal&quot;> </i>\')"><i class="fa fa-terminal"> </i> Terminal</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-code&quot;> </i>\')"><i class="fa fa-code"> </i> Code</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-reply-all&quot;> </i>\')"><i class="fa fa-reply-all"> </i> Reply-All</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-star-half-o&quot;> </i>\')"><i class="fa fa-star-half-o"> </i> Star-Half-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-location-arrow&quot;> </i>\')"><i class="fa fa-location-arrow"> </i> Location-Arrow</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-crop&quot;> </i>\')"><i class="fa fa-crop"> </i> Crop</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-code-fork&quot;> </i>\')"><i class="fa fa-code-fork"> </i> Code-Fork</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chain-broken&quot;> </i>\')"><i class="fa fa-chain-broken"> </i> Chain-Broken</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-question&quot;> </i>\')"><i class="fa fa-question"> </i> Question</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-info&quot;> </i>\')"><i class="fa fa-info"> </i> Info</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-exclamation&quot;> </i>\')"><i class="fa fa-exclamation"> </i> Exclamation</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-superscript&quot;> </i>\')"><i class="fa fa-superscript"> </i> Superscript</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-subscript&quot;> </i>\')"><i class="fa fa-subscript"> </i> Subscript</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-eraser&quot;> </i>\')"><i class="fa fa-eraser"> </i> Eraser</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-puzzle-piece&quot;> </i>\')"><i class="fa fa-puzzle-piece"> </i> Puzzle-Piece</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-microphone&quot;> </i>\')"><i class="fa fa-microphone"> </i> Microphone</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-microphone-slash&quot;> </i>\')"><i class="fa fa-microphone-slash"> </i> Microphone-Slash</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-shield&quot;> </i>\')"><i class="fa fa-shield"> </i> Shield</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-calendar-o&quot;> </i>\')"><i class="fa fa-calendar-o"> </i> Calendar-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-fire-extinguisher&quot;> </i>\')"><i class="fa fa-fire-extinguisher"> </i> Fire-Extinguisher</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-rocket&quot;> </i>\')"><i class="fa fa-rocket"> </i> Rocket</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-maxcdn&quot;> </i>\')"><i class="fa fa-maxcdn"> </i> Maxcdn</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-circle-left&quot;> </i>\')"><i class="fa fa-chevron-circle-left"> </i> Chevron-Circle-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-circle-right&quot;> </i>\')"><i class="fa fa-chevron-circle-right"> </i> Chevron-Circle-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-circle-up&quot;> </i>\')"><i class="fa fa-chevron-circle-up"> </i> Chevron-Circle-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-chevron-circle-down&quot;> </i>\')"><i class="fa fa-chevron-circle-down"> </i> Chevron-Circle-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-html5&quot;> </i>\')"><i class="fa fa-html5"> </i> HTML5</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-css3&quot;> </i>\')"><i class="fa fa-css3"> </i> CSS3</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-anchor&quot;> </i>\')"><i class="fa fa-anchor"> </i> Anchor</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-unlock-alt&quot;> </i>\')"><i class="fa fa-unlock-alt"> </i> Unlock-Alt</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-ellipsis-v&quot;> </i>\')"><i class="fa fa-ellipsis-v"> </i> Ellipsis-V</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-rss-square&quot;> </i>\')"><i class="fa fa-rss-square"> </i> RSS-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-play-circle&quot;> </i>\')"><i class="fa fa-play-circle"> </i> Play-Circle</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-ticket&quot;> </i>\')"><i class="fa fa-ticket"> </i> Ticket</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-minus-square&quot;> </i>\')"><i class="fa fa-minus-square"> </i> Minus-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-minus-square-o&quot;> </i>\')"><i class="fa fa-minus-square-o"> </i> Minus-Square-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-level-up&quot;> </i>\')"><i class="fa fa-level-up"> </i> Level-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-level-down&quot;> </i>\')"><i class="fa fa-level-down"> </i> Level-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-check-square&quot;> </i>\')"><i class="fa fa-check-square"> </i> Check-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pencil-square&quot;> </i>\')"><i class="fa fa-pencil-square"> </i> Pencil-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-external-link-square&quot;> </i>\')"><i class="fa fa-external-link-square"> </i> External-Link-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-share-square&quot;> </i>\')"><i class="fa fa-share-square"> </i> Share-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-compass&quot;> </i>\')"><i class="fa fa-compass"> </i> Compass</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-square-o-down&quot;> </i>\')"><i class="fa fa-caret-square-o-down"> </i> Caret-Square-O-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-square-o-up&quot;> </i>\')"><i class="fa fa-caret-square-o-up"> </i> Caret-Square-O-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-square-o-right&quot;> </i>\')"><i class="fa fa-caret-square-o-right"> </i> Caret-Square-O-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-eur&quot;> </i>\')"><i class="fa fa-eur"> </i> EUR</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-gbp&quot;> </i>\')"><i class="fa fa-gbp"> </i> GBP</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-usd&quot;> </i>\')"><i class="fa fa-usd"> </i> USD</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-inr&quot;> </i>\')"><i class="fa fa-inr"> </i> INR</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-jpy&quot;> </i>\')"><i class="fa fa-jpy"> </i> JPY</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-rub&quot;> </i>\')"><i class="fa fa-rub"> </i> RUB</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-krw&quot;> </i>\')"><i class="fa fa-krw"> </i> KRW</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-btc&quot;> </i>\')"><i class="fa fa-btc"> </i> BTC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-file&quot;> </i>\')"><i class="fa fa-file"> </i> File</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-file-text&quot;> </i>\')"><i class="fa fa-file-text"> </i> File-Text</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-alpha-asc&quot;> </i>\')"><i class="fa fa-sort-alpha-asc"> </i> Sort-Alpha-ASC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-alpha-desc&quot;> </i>\')"><i class="fa fa-sort-alpha-desc"> </i> Sort-Alpha-DESC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-amount-asc&quot;> </i>\')"><i class="fa fa-sort-amount-asc"> </i> Sort-Amount-ASC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-amount-desc&quot;> </i>\')"><i class="fa fa-sort-amount-desc"> </i> Sort-Amount-DESC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-numeric-asc&quot;> </i>\')"><i class="fa fa-sort-numeric-asc"> </i> Sort-Numeric-ASC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sort-numeric-desc&quot;> </i>\')"><i class="fa fa-sort-numeric-desc"> </i> Sort-Numeric-DESC</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-thumbs-up&quot;> </i>\')"><i class="fa fa-thumbs-up"> </i> Thumbs-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-thumbs-dow&quot;> </i>\')"><i class="fa fa-thumbs-dow"> </i> Thumbs-Dow</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-youtube-square&quot;> </i>\')"><i class="fa fa-youtube-square"> </i> Youtube-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-youtube&quot;> </i>\')"><i class="fa fa-youtube"> </i> Youtube</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-xing&quot;> </i>\')"><i class="fa fa-xing"> </i> Xing</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-xing-square&quot;> </i>\')"><i class="fa fa-xing-square"> </i> Xing-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-youtube-play&quot;> </i>\')"><i class="fa fa-youtube-play"> </i> Youtube-Play</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-dropbox&quot;> </i>\')"><i class="fa fa-dropbox"> </i> Dropbox</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-stack-overflow&quot;> </i>\')"><i class="fa fa-stack-overflow"> </i> Stack-Overflow</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-instagram&quot;> </i>\')"><i class="fa fa-instagram"> </i> Instagram</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-flickr&quot;> </i>\')"><i class="fa fa-flickr"> </i> Flickr</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-adn&quot;> </i>\')"><i class="fa fa-adn"> </i> Adn</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bitbucket&quot;> </i>\')"><i class="fa fa-bitbucket"> </i> Bitbucket</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bitbucket-square&quot;> </i>\')"><i class="fa fa-bitbucket-square"> </i> Bitbucket-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tumblr&quot;> </i>\')"><i class="fa fa-tumblr"> </i> Tumblr</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-tumblr-square&quot;> </i>\')"><i class="fa fa-tumblr-square"> </i> Tumblr-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-long-arrow-down&quot;> </i>\')"><i class="fa fa-long-arrow-down"> </i> Long-Arrow-Down</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-long-arrow-up&quot;> </i>\')"><i class="fa fa-long-arrow-up"> </i> Long-Arrow-Up</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-long-arrow-left&quot;> </i>\')"><i class="fa fa-long-arrow-left"> </i> Long-Arrow-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-long-arrow-right&quot;> </i>\')"><i class="fa fa-long-arrow-right"> </i> Long-Arrow-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-apple&quot;> </i>\')"><i class="fa fa-apple"> </i> Apple</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-windows&quot;> </i>\')"><i class="fa fa-windows"> </i> Windows</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-android&quot;> </i>\')"><i class="fa fa-android"> </i> Android</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-linux&quot;> </i>\')"><i class="fa fa-linux"> </i> Linux</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-dribbble&quot;> </i>\')"><i class="fa fa-dribbble"> </i> Dribbble</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-skype&quot;> </i>\')"><i class="fa fa-skype"> </i> Skype</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-foursquare&quot;> </i>\')"><i class="fa fa-foursquare"> </i> Foursquare</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-trello&quot;> </i>\')"><i class="fa fa-trello"> </i> Trello</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-female&quot;> </i>\')"><i class="fa fa-female"> </i> Female</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-male&quot;> </i>\')"><i class="fa fa-male"> </i> Male</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-gittip&quot;> </i>\')"><i class="fa fa-gittip"> </i> Gittip</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-sun-o&quot;> </i>\')"><i class="fa fa-sun-o"> </i> Sun-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-moon-o&quot;> </i>\')"><i class="fa fa-moon-o"> </i> Moon-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-archive&quot;> </i>\')"><i class="fa fa-archive"> </i> Archive</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-bug&quot;> </i>\')"><i class="fa fa-bug"> </i> Bug</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-vk&quot;> </i>\')"><i class="fa fa-vk"> </i> VK</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-weibo&quot;> </i>\')"><i class="fa fa-weibo"> </i> Weibo</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-renren&quot;> </i>\')"><i class="fa fa-renren"> </i> Renren</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-pagelines&quot;> </i>\')"><i class="fa fa-pagelines"> </i> Pagelines</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-stack-exchange&quot;> </i>\')"><i class="fa fa-stack-exchange"> </i> Stack-Exchange</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-o-right&quot;> </i>\')"><i class="fa fa-arrow-circle-o-right"> </i> Arrow-Circle-O-Right</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-arrow-circle-o-left&quot;> </i>\')"><i class="fa fa-arrow-circle-o-left"> </i> Arrow-Circle-O-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-caret-square-o-left&quot;> </i>\')"><i class="fa fa-caret-square-o-left"> </i> Caret-Square-O-Left</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-dot-circle-o&quot;> </i>\')"><i class="fa fa-dot-circle-o"> </i> Dot-Circle-O</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-wheelchair&quot;> </i>\')"><i class="fa fa-wheelchair"> </i> Wheelchair</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-vimeo-square&quot;> </i>\')"><i class="fa fa-vimeo-square"> </i> Vimeo-Square</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-try&quot;> </i>\')"><i class="fa fa-try"> </i> Try</a><br />' + 
										'		<a href="Javascript:void(0)" class="text-primary bg-light w-100 d-inline-block pl-2" style="font-size: 1.2rem;cursor: pointer" onclick="$(\'#fontawesome-dialog-content\').val(\'<i class=&quot;fa fa-plus-square-o&quot;> </i>\')"><i class="fa fa-plus-square-o"> </i> Plus-Square-O</a><br />' + 
										'	</div>' + 
										'	</div>' + 
										'	<label class="col-sm-6 col-form-label" for="fontawesome-dialog-content">Content</label><div class="col-sm-6"><input type="text" name="fontawesome-dialog-content" id="fontawesome-dialog-content" value="" placeholder="&lt;i class=&quot;fa fa-home&quot;&gt;&nbsp;&lt;/i&gt;" ondblclick="this.value=this.placeholder" /></div>' + 
										'</div>';

							self.$fontawesome_dialog.find('.modal-header').addClass('bg-primary text-white');
							self.$fontawesome_dialog.find('.modal-title').text('Fontawesome');
							self.$fontawesome_dialog.find('.modal-body').html(html);
							self.$fontawesome_dialog.find('.note-fontawesome-btn').unbind("click").click(function(){
								context.invoke('editor.restoreRange');
								context.invoke('editor.focus');

								var color = jQuery('#fontawesome-dialog-color').val();
								var background = jQuery('#fontawesome-dialog-background').val();
								var size = jQuery('#fontawesome-dialog-size').val();
								var class_color = color != '' ? ' text-' + color : '';
								var class_bgcolor = background != '' ? ' bg-' + background : '';
								var attr_style = size != '' ? ' style="font-size: ' + size + '"' : '';

								if(jQuery('#fontawesome-dialog-content').val() != ""){
									context.invoke("editor.insertNode", $('<span class="' + class_color + class_bgcolor + '"' + attr_style + '>\n\t' + jQuery('#fontawesome-dialog-content').val() + '\n</span>\n')[0]);
									self.$fontawesome_dialog.modal('hide');
								}else{
									alert('Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.');
								}
							});
							self.$fontawesome_dialog.modal('show');

						}
					})
				]).render();
				return $fontawesome;
			});

			this.initialize = function() {
			}

			this.$fontawesome_dialog = ui.dialog({
				title: 'Fontawesome',
				body: 'PLACEHOLDER',
				footer: '<button type="button" class="btn btn-primary note-fontawesome-btn">' + lang.bootstrap_components.okButton + '</button>'
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.events = {
				'summernote.init': function(we, e) {
					//console.log('summernote initialized', we, e);
				},
				'summernote.keyup': function(we, e) {
					//console.log('summernote keyup', we, e);
				}
			};

			this.destroy = function() {

				ui.hideDialog(this.$fontawesome_dialog);
				this.$fontawesome_dialog.remove();

			};

			this.bindEnterKey = function ($input, $btn) {
				$input.on('keypress', function (event) {
					if (event.keyCode === 13) $btn.trigger('click');
				});
			};

			this.bindLabels = function () {
				/*self.$fontawesome_dialog.find('.form-control:first').focus().select();
				self.$fontawesome_dialog.find('label').on('click', function () {
					$(this).parent().find('.form-control:first').focus();
				});*/
			};

			this.show = function () {
				var $img = $($editable.data('target'));
				var editorInfo = {

				};
				this.showBootstrapComponentsDialog(editorInfo).then(function (editorInfo) {
					ui.hideDialog(self.$fontawesome_dialog);
					$note.val(context.invoke('code'));
					$note.change();
				});
			};

			this.showBootstrapComponentsDialog = function(editorInfo) {
				return $.Deferred(function (deferred) {
					ui.onDialogShown(self.$fontawesome_dialog, function () {
						context.triggerEvent('fontawesome_dialog.shown');
					});
					ui.onDialogHidden(self.$fontawesome_dialog, function () {
						if (deferred.state() === 'pending') deferred.reject();
					});
					ui.showDialog(self.$fontawesome_dialog);
				});
			};

		}, 

		'dashicons': function(context) {

			var self      = this,

				ui        = $.summernote.ui,
				$note     = context.layoutInfo.note,

				$editor   = context.layoutInfo.editor,
				$editable = context.layoutInfo.editable,
				$toolbar  = context.layoutInfo.toolbar,

				options   = context.options,

				lang      = options.langInfo;

			// add dashicons button
			context.memo('button.dashicons', function() {
				var $dashicons = ui.button([
					ui.button({
						className: '',
						contents: '<span class="fa fa-exclamation-circle"></span>' + (options.showButtonNames == true ? ' Dashicons' : '') + '',
						tooltip: 'Dashicons',
						click: function () {

							context.invoke('editor.saveRange');

							self.$dashicons_dialog.find('.modal-header').addClass('bg-primary text-white');
							self.$dashicons_dialog.modal('show');

							jQuery(document).on('click', '#dashicons-admin-menu a, #dashicons-welcome-screen a, #dashicons-post-formats a, #dashicons-media a, #dashicons-image-editing a, #dashicons-tinymce a, #dashicons-posts-screen a, #dashicons-sorting a, #dashicons-social a, #dashicons-specific a, #dashicons-products a, #dashicons-taxonomies a, #dashicons-widgets a, #dashicons-notifications a, #dashicons-misc a', function(){
								var category_id = jQuery(this).parent().parent().parent().attr('id');
								var dashicon_name = jQuery(this).attr('id').replace(category_id + '-', '');
								var dashicon_alt = jQuery('#' + jQuery(this).attr('id') + ' > div').attr('alt');
								var dashicon_category = jQuery('#' + category_id + ' > p > strong').text();

								var html = 	'<h3><span alt="' + dashicon_alt + '" class="dashicons ' + dashicon_name + '"></span></h3>' + 
											'<div class="form-group row">' + 
											'	<label class="col-sm-6 col-form-label" for="dashicons-admin-menu-color">Color</label><div class="col-sm-6"><select name="dashicons-admin-menu-color" id="dashicons-admin-menu-color">' + bootstrap_options_colors + '</select></div>' + 
											'	<label class="col-sm-6 col-form-label" for="dashicons-admin-menu-background">Background</label><div class="col-sm-6"><select name="dashicons-admin-menu-background" id="dashicons-admin-menu-background">' + bootstrap_options_colors + '</select></div>' + 
											'	<label class="col-sm-6 col-form-label" for="dashicons-admin-menu-size">Size</label><div class="col-sm-6"><input type="text" name="dashicons-admin-menu-size" id="dashicons-admin-menu-size" value="" placeholder="3rem" ondblclick="this.value=this.placeholder" /></div>' + 
											'	<label class="col-sm-6 col-form-label" for="dashicons-admin-menu-content">Content</label><div class="col-sm-6"><input type="text" name="dashicons-admin-menu-content" id="dashicons-admin-menu-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
											'</div>';

								self.$dashicons_dialog.modal('hide');

								self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
								self.$bootstrap_dialog_form.find('.modal-title').text('Dashicon');
								self.$bootstrap_dialog_form.find('.modal-body').html(html);
								self.$bootstrap_dialog_form.find('.note-dashicons-btn').unbind("click").click(function(){
									context.invoke('editor.restoreRange');
									context.invoke('editor.focus');

									var color = jQuery('#dashicons-admin-menu-color').val();
									var background = jQuery('#dashicons-admin-menu-background').val();
									var size = jQuery('#dashicons-admin-menu-size').val();
									var class_color = color != '' ? ' text-' + color : '';
									var class_bgcolor = background != '' ? ' bg-' + background : '';
									var attr_style = size != '' ? ' style="font-size: ' + size + ';width: ' + size + ';height: ' + size + '"' : '';

									if(jQuery('#dashicons-admin-menu-size').val() != ""){
										context.invoke("editor.insertNode", $('<span alt="' + dashicon_alt + '" class="dashicons ' + dashicon_name + class_color + class_bgcolor + '"' + attr_style + '>\n\t' + jQuery('#dashicons-admin-menu-content').val() + '\n</span>\n')[0]);
										self.$bootstrap_dialog_form.modal('hide');
									}else{
										alert('Bitte geben Sie eine Größe ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.');
									}
								});

								self.$bootstrap_dialog_form.modal('show');

							});

						}
					})
				]).render();
				return $dashicons;
			});

			this.initialize = function() {
			}

			this.$dashicons_dialog = ui.dialog({
				title: 'Select a Icon-category',
				body: 	'<div id="dashicons-tabs">' + 
						'	<ul style="display: inline-block;padding: 5px 0px 0px 15px;list-style: square">' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-admin-menu">Admin Menu</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-welcome-screen">Welcome Screen</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-post-formats">Post Formats</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-media">Media</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-image-editing">Image Editing</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-tinymce">TinyMCE</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-posts-screen">Posts Screen</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-sorting">Sorting</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-social">Social</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-specific">Specific</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-products">Products</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-taxonomies">Taxonomies</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-widgets">Widgets</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-notifications">Notifications</a></li>' + 
						'		<li style="display: inline-block;width: 220px"><a href="#dashicons-misc">Misc</a></li>' + 
						'	</ul>' + 
						'	<div id="dashicons-admin-menu">' + 
						'		<p><strong>Admin Menu</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-menu" role="button"><div alt="f333" class="dashicons dashicons-menu"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-site" role="button"><div alt="f319" class="dashicons dashicons-admin-site"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-dashboard" role="button"><div alt="f226" class="dashicons dashicons-dashboard"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-post" role="button"><div alt="f109" class="dashicons dashicons-admin-post"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-media" role="button"><div alt="f104" class="dashicons dashicons-admin-media"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-links" role="button"><div alt="f103" class="dashicons dashicons-admin-links"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-page" role="button"><div alt="f105" class="dashicons dashicons-admin-page"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-comments" role="button"><div alt="f101" class="dashicons dashicons-admin-comments"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-appearance" role="button"><div alt="f100" class="dashicons dashicons-admin-appearance"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-plugins" role="button"><div alt="f106" class="dashicons dashicons-admin-plugins"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-users" role="button"><div alt="f110" class="dashicons dashicons-admin-users"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-tools" role="button"><div alt="f107" class="dashicons dashicons-admin-tools"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-settings" role="button"><div alt="f108" class="dashicons dashicons-admin-settings"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-network" role="button"><div alt="f112" class="dashicons dashicons-admin-network"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-home" role="button"><div alt="f102" class="dashicons dashicons-admin-home"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-generic" role="button"><div alt="f111" class="dashicons dashicons-admin-generic"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-collapse" role="button"><div alt="f148" class="dashicons dashicons-admin-collapse"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-filter" role="button"><div alt="f536" class="dashicons dashicons-filter"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-customizer" role="button"><div alt="f540" class="dashicons dashicons-admin-customizer"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-admin-menu-dashicons-admin-multisite" role="button"><div alt="f541" class="dashicons dashicons-admin-multisite"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-welcome-screen">' + 
						'		<p><strong>Welcome Screen</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-write-blog" role="button"><div alt="f119" class="dashicons dashicons-welcome-write-blog"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-add-page" role="button"><div alt="f133" class="dashicons dashicons-welcome-add-page"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-view-site" role="button"><div alt="f115" class="dashicons dashicons-welcome-view-site"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-widgets-menus" role="button"><div alt="f116" class="dashicons dashicons-welcome-widgets-menus"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-comments" role="button"><div alt="f117" class="dashicons dashicons-welcome-comments"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-welcome-screen-dashicons-welcome-learn-more" role="button"><div alt="f118" class="dashicons dashicons-welcome-learn-more"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-post-formats">' + 
						'		<p><strong>Post Formats</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-aside" role="button"><div alt="f123" class="dashicons dashicons-format-aside"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-image" role="button"><div alt="f128" class="dashicons dashicons-format-image"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-gallery" role="button"><div alt="f161" class="dashicons dashicons-format-gallery"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-video" role="button"><div alt="f126" class="dashicons dashicons-format-video"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-status" role="button"><div alt="f130" class="dashicons dashicons-format-status"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-quote" role="button"><div alt="f122" class="dashicons dashicons-format-quote"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-chat" role="button"><div alt="f125" class="dashicons dashicons-format-chat"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-format-audio" role="button"><div alt="f127" class="dashicons dashicons-format-audio"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-camera" role="button"><div alt="f306" class="dashicons dashicons-camera"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-images-alt" role="button"><div alt="f232" class="dashicons dashicons-images-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-images-alt2" role="button"><div alt="f233" class="dashicons dashicons-images-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-video-alt" role="button"><div alt="f234" class="dashicons dashicons-video-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-video-alt2" role="button"><div alt="f235" class="dashicons dashicons-video-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-post-formats-dashicons-video-alt3" role="button"><div alt="f236" class="dashicons dashicons-video-alt3"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-media">' + 
						'		<p><strong>Media</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-archive" role="button"><div alt="f501" class="dashicons dashicons-media-archive"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-audio" role="button"><div alt="f500" class="dashicons dashicons-media-audio"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-code" role="button"><div alt="f499" class="dashicons dashicons-media-code"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-default" role="button"><div alt="f498" class="dashicons dashicons-media-default"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-document" role="button"><div alt="f497" class="dashicons dashicons-media-document"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-interactive" role="button"><div alt="f496" class="dashicons dashicons-media-interactive"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-spreadsheet" role="button"><div alt="f495" class="dashicons dashicons-media-spreadsheet"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-text" role="button"><div alt="f491" class="dashicons dashicons-media-text"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-media-video" role="button"><div alt="f490" class="dashicons dashicons-media-video"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-playlist-audio" role="button"><div alt="f492" class="dashicons dashicons-playlist-audio"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-playlist-video" role="button"><div alt="f493" class="dashicons dashicons-playlist-video"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-play" role="button"><div alt="f522" class="dashicons dashicons-controls-play"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-pause" role="button"><div alt="f523" class="dashicons dashicons-controls-pause"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-forward" role="button"><div alt="f519" class="dashicons dashicons-controls-forward"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-skipforward" role="button"><div alt="f517" class="dashicons dashicons-controls-skipforward"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-back" role="button"><div alt="f518" class="dashicons dashicons-controls-back"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-skipback" role="button"><div alt="f516" class="dashicons dashicons-controls-skipback"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-repeat" role="button"><div alt="f515" class="dashicons dashicons-controls-repeat"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-volumeon" role="button"><div alt="f521" class="dashicons dashicons-controls-volumeon"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-media-dashicons-controls-volumeoff" role="button"><div alt="f520" class="dashicons dashicons-controls-volumeoff"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-image-editing">' + 
						'		<p><strong>Image Editing</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-crop" role="button"><div alt="f165" class="dashicons dashicons-image-crop"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-rotate" role="button"><div alt="f531" class="dashicons dashicons-image-rotate"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-rotate-left" role="button"><div alt="f166" class="dashicons dashicons-image-rotate-left"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-rotate-right" role="button"><div alt="f167" class="dashicons dashicons-image-rotate-right"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-flip-vertical" role="button"><div alt="f168" class="dashicons dashicons-image-flip-vertical"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-flip-horizontal" role="button"><div alt="f169" class="dashicons dashicons-image-flip-horizontal"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-image-filter" role="button"><div alt="f533" class="dashicons dashicons-image-filter"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-undo" role="button"><div alt="f171" class="dashicons dashicons-undo"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-image-editing-dashicons-redo" role="button"><div alt="f172" class="dashicons dashicons-redo"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-tinymce">' + 
						'		<p><strong>TinyMCE</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-bold" role="button"><div alt="f200" class="dashicons dashicons-editor-bold"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-italic" role="button"><div alt="f201" class="dashicons dashicons-editor-italic"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-ul" role="button"><div alt="f203" class="dashicons dashicons-editor-ul"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-ol" role="button"><div alt="f204" class="dashicons dashicons-editor-ol"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-quote" role="button"><div alt="f205" class="dashicons dashicons-editor-quote"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-alignleft" role="button"><div alt="f206" class="dashicons dashicons-editor-alignleft"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-aligncenter" role="button"><div alt="f207" class="dashicons dashicons-editor-aligncenter"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-alignright" role="button"><div alt="f208" class="dashicons dashicons-editor-alignright"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-insertmore" role="button"><div alt="f209" class="dashicons dashicons-editor-insertmore"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-spellcheck" role="button"><div alt="f210" class="dashicons dashicons-editor-spellcheck"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-expand" role="button"><div alt="f211" class="dashicons dashicons-editor-expand"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-contract" role="button"><div alt="f506" class="dashicons dashicons-editor-contract"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-kitchensink" role="button"><div alt="f212" class="dashicons dashicons-editor-kitchensink"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-underline" role="button"><div alt="f213" class="dashicons dashicons-editor-underline"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-justify" role="button"><div alt="f214" class="dashicons dashicons-editor-justify"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-textcolor" role="button"><div alt="f215" class="dashicons dashicons-editor-textcolor"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-paste-word" role="button"><div alt="f216" class="dashicons dashicons-editor-paste-word"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-paste-text" role="button"><div alt="f217" class="dashicons dashicons-editor-paste-text"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-removeformatting" role="button"><div alt="f218" class="dashicons dashicons-editor-removeformatting"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-video" role="button"><div alt="f219" class="dashicons dashicons-editor-video"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-customchar" role="button"><div alt="f220" class="dashicons dashicons-editor-customchar"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-outdent" role="button"><div alt="f221" class="dashicons dashicons-editor-outdent"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-indent" role="button"><div alt="f222" class="dashicons dashicons-editor-indent"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-help" role="button"><div alt="f223" class="dashicons dashicons-editor-help"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-strikethrough" role="button"><div alt="f224" class="dashicons dashicons-editor-strikethrough"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-unlink" role="button"><div alt="f225" class="dashicons dashicons-editor-unlink"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-rtl" role="button"><div alt="f320" class="dashicons dashicons-editor-rtl"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-break" role="button"><div alt="f474" class="dashicons dashicons-editor-break"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-code" role="button"><div alt="f475" class="dashicons dashicons-editor-code"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-paragraph" role="button"><div alt="f476" class="dashicons dashicons-editor-paragraph"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-tinymce-dashicons-editor-table" role="button"><div alt="f535" class="dashicons dashicons-editor-table"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-posts-screen">' + 
						'		<p><strong>Posts Screen</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-align-left" role="button"><div alt="f135" class="dashicons dashicons-align-left"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-align-right" role="button"><div alt="f136" class="dashicons dashicons-align-right"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-align-center" role="button"><div alt="f134" class="dashicons dashicons-align-center"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-align-none" role="button"><div alt="f138" class="dashicons dashicons-align-none"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-lock" role="button"><div alt="f160" class="dashicons dashicons-lock"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-unlock" role="button"><div alt="f528" class="dashicons dashicons-unlock"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-calendar" role="button"><div alt="f145" class="dashicons dashicons-calendar"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-calendar-alt" role="button"><div alt="f508" class="dashicons dashicons-calendar-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-visibility" role="button"><div alt="f177" class="dashicons dashicons-visibility"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-hidden" role="button"><div alt="f530" class="dashicons dashicons-hidden"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-post-status" role="button"><div alt="f173" class="dashicons dashicons-post-status"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-edit" role="button"><div alt="f464" class="dashicons dashicons-edit"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-trash" role="button"><div alt="f182" class="dashicons dashicons-trash"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-posts-screen-dashicons-sticky" role="button"><div alt="f537" class="dashicons dashicons-sticky"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-sorting">' + 
						'		<p><strong>Sorting</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-external" role="button"><div alt="f504" class="dashicons dashicons-external"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-up" role="button"><div alt="f142" class="dashicons dashicons-arrow-up"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-down" role="button"><div alt="f140" class="dashicons dashicons-arrow-down"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-right" role="button"><div alt="f139" class="dashicons dashicons-arrow-right"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-left" role="button"><div alt="f141" class="dashicons dashicons-arrow-left"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-up-alt" role="button"><div alt="f342" class="dashicons dashicons-arrow-up-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-down-alt" role="button"><div alt="f346" class="dashicons dashicons-arrow-down-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-right-alt" role="button"><div alt="f344" class="dashicons dashicons-arrow-right-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-left-alt" role="button"><div alt="f340" class="dashicons dashicons-arrow-left-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-up-alt2" role="button"><div alt="f343" class="dashicons dashicons-arrow-up-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-down-alt2" role="button"><div alt="f347" class="dashicons dashicons-arrow-down-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-right-alt2" role="button"><div alt="f345" class="dashicons dashicons-arrow-right-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-arrow-left-alt2" role="button"><div alt="f341" class="dashicons dashicons-arrow-left-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-sort" role="button"><div alt="f156" class="dashicons dashicons-sort"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-leftright" role="button"><div alt="f229" class="dashicons dashicons-leftright"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-randomize" role="button"><div alt="f503" class="dashicons dashicons-randomize"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-list-view" role="button"><div alt="f163" class="dashicons dashicons-list-view"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-exerpt-view" role="button"><div alt="f164" class="dashicons dashicons-exerpt-view"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-grid-view" role="button"><div alt="f509" class="dashicons dashicons-grid-view"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-sorting-dashicons-move" role="button"><div alt="f545" class="dashicons dashicons-move"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-social">' + 
						'		<p><strong>Social</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-share" role="button"><div alt="f237" class="dashicons dashicons-share"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-share-alt" role="button"><div alt="f240" class="dashicons dashicons-share-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-share-alt2" role="button"><div alt="f242" class="dashicons dashicons-share-alt2"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-twitter" role="button"><div alt="f301" class="dashicons dashicons-twitter"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-rss" role="button"><div alt="f303" class="dashicons dashicons-rss"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-email" role="button"><div alt="f465" class="dashicons dashicons-email"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-email-alt" role="button"><div alt="f466" class="dashicons dashicons-email-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-facebook" role="button"><div alt="f304" class="dashicons dashicons-facebook"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-facebook-alt" role="button"><div alt="f305" class="dashicons dashicons-facebook-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-googleplus" role="button"><div alt="f462" class="dashicons dashicons-googleplus"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-social-dashicons-networking" role="button"><div alt="f325" class="dashicons dashicons-networking"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-specific">' + 
						'		<p><strong>Specific</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-hammer" role="button"><div alt="f308" class="dashicons dashicons-hammer"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-art" role="button"><div alt="f309" class="dashicons dashicons-art"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-migrate" role="button"><div alt="f310" class="dashicons dashicons-migrate"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-performance" role="button"><div alt="f311" class="dashicons dashicons-performance"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-universal-access" role="button"><div alt="f483" class="dashicons dashicons-universal-access"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-universal-access-alt" role="button"><div alt="f507" class="dashicons dashicons-universal-access-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-tickets" role="button"><div alt="f486" class="dashicons dashicons-tickets"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-nametag" role="button"><div alt="f484" class="dashicons dashicons-nametag"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-clipboard" role="button"><div alt="f481" class="dashicons dashicons-clipboard"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-heart" role="button"><div alt="f487" class="dashicons dashicons-heart"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-megaphone" role="button"><div alt="f488" class="dashicons dashicons-megaphone"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-specific-dashicons-schedule" role="button"><div alt="f489" class="dashicons dashicons-schedule"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-products">' + 
						'		<p><strong>Products</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-wordpress" role="button"><div alt="f120" class="dashicons dashicons-wordpress"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-wordpress-alt" role="button"><div alt="f324" class="dashicons dashicons-wordpress-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-pressthis" role="button"><div alt="f157" class="dashicons dashicons-pressthis"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-update" role="button"><div alt="f463" class="dashicons dashicons-update"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-screenoptions" role="button"><div alt="f180" class="dashicons dashicons-screenoptions"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-info" role="button"><div alt="f348" class="dashicons dashicons-info"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-cart" role="button"><div alt="f174" class="dashicons dashicons-cart"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-feedback" role="button"><div alt="f175" class="dashicons dashicons-feedback"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-cloud" role="button"><div alt="f176" class="dashicons dashicons-cloud"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-products-dashicons-translation" role="button"><div alt="f326" class="dashicons dashicons-translation"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-taxonomies">' + 
						'		<p><strong>Taxonomies</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-taxonomies-dashicons-tag" role="button"><div alt="f323" class="dashicons dashicons-tag"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-taxonomies-dashicons-category" role="button"><div alt="f318" class="dashicons dashicons-category"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-widgets">' + 
						'		<p><strong>Widgets</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-widgets-dashicons-archive" role="button"><div alt="f480" class="dashicons dashicons-archive"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-widgets-dashicons-tagcloud" role="button"><div alt="f479" class="dashicons dashicons-tagcloud"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-widgets-dashicons-text" role="button"><div alt="f478" class="dashicons dashicons-text"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-notifications">' + 
						'		<p><strong>Notifications</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-yes" role="button"><div alt="f147" class="dashicons dashicons-yes"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-no" role="button"><div alt="f158" class="dashicons dashicons-no"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-no-alt" role="button"><div alt="f335" class="dashicons dashicons-no-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-plus" role="button"><div alt="f132" class="dashicons dashicons-plus"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-plus-alt" role="button"><div alt="f502" class="dashicons dashicons-plus-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-minus" role="button"><div alt="f460" class="dashicons dashicons-minus"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-dismiss" role="button"><div alt="f153" class="dashicons dashicons-dismiss"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-marker" role="button"><div alt="f159" class="dashicons dashicons-marker"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-star-filled" role="button"><div alt="f155" class="dashicons dashicons-star-filled"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-star-half" role="button"><div alt="f459" class="dashicons dashicons-star-half"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-star-empty" role="button"><div alt="f154" class="dashicons dashicons-star-empty"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-flag" role="button"><div alt="f227" class="dashicons dashicons-flag"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-notifications-dashicons-warning" role="button"><div alt="f534" class="dashicons dashicons-warning"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'	<div id="dashicons-misc">' + 
						'		<p><strong>Misc</strong></p>' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: none">' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-location" role="button"><div alt="f230" class="dashicons dashicons-location"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-location-alt" role="button"><div alt="f231" class="dashicons dashicons-location-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-vault" role="button"><div alt="f178" class="dashicons dashicons-vault"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-shield" role="button"><div alt="f332" class="dashicons dashicons-shield"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-shield-alt" role="button"><div alt="f334" class="dashicons dashicons-shield-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-sos" role="button"><div alt="f468" class="dashicons dashicons-sos"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-search" role="button"><div alt="f179" class="dashicons dashicons-search"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-slides" role="button"><div alt="f181" class="dashicons dashicons-slides"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-analytics" role="button"><div alt="f183" class="dashicons dashicons-analytics"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-chart-pie" role="button"><div alt="f184" class="dashicons dashicons-chart-pie"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-chart-bar" role="button"><div alt="f185" class="dashicons dashicons-chart-bar"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-chart-line" role="button"><div alt="f238" class="dashicons dashicons-chart-line"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-chart-area" role="button"><div alt="f239" class="dashicons dashicons-chart-area"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-groups" role="button"><div alt="f307" class="dashicons dashicons-groups"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-businessman" role="button"><div alt="f338" class="dashicons dashicons-businessman"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-id" role="button"><div alt="f336" class="dashicons dashicons-id"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-id-alt" role="button"><div alt="f337" class="dashicons dashicons-id-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-products" role="button"><div alt="f312" class="dashicons dashicons-products"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-awards" role="button"><div alt="f313" class="dashicons dashicons-awards"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-forms" role="button"><div alt="f314" class="dashicons dashicons-forms"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-testimonial" role="button"><div alt="f473" class="dashicons dashicons-testimonial"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-portfolio" role="button"><div alt="f322" class="dashicons dashicons-portfolio"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-book" role="button"><div alt="f330" class="dashicons dashicons-book"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-book-alt" role="button"><div alt="f331" class="dashicons dashicons-book-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-download" role="button"><div alt="f316" class="dashicons dashicons-download"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-upload" role="button"><div alt="f317" class="dashicons dashicons-upload"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-backup" role="button"><div alt="f321" class="dashicons dashicons-backup"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-clock" role="button"><div alt="f469" class="dashicons dashicons-clock"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-lightbulb" role="button"><div alt="f339" class="dashicons dashicons-lightbulb"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-microphone" role="button"><div alt="f482" class="dashicons dashicons-microphone"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-desktop" role="button"><div alt="f472" class="dashicons dashicons-desktop"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-laptop" role="button"><div alt="f547" class="dashicons dashicons-laptop"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-tablet" role="button"><div alt="f471" class="dashicons dashicons-tablet"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-smartphone" role="button"><div alt="f470" class="dashicons dashicons-smartphone"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-phone" role="button"><div alt="f525" class="dashicons dashicons-phone"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-index-card" role="button"><div alt="f510" class="dashicons dashicons-index-card"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-carrot" role="button"><div alt="f511" class="dashicons dashicons-carrot"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-building" role="button"><div alt="f512" class="dashicons dashicons-building"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-store" role="button"><div alt="f513" class="dashicons dashicons-store"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-album" role="button"><div alt="f514" class="dashicons dashicons-album"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-palmtree" role="button"><div alt="f527" class="dashicons dashicons-palmtree"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-tickets-alt" role="button"><div alt="f524" class="dashicons dashicons-tickets-alt"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-money" role="button"><div alt="f526" class="dashicons dashicons-money"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-smiley" role="button"><div alt="f328" class="dashicons dashicons-smiley"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-thumbs-up" role="button"><div alt="f529" class="dashicons dashicons-thumbs-up"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-thumbs-down" role="button"><div alt="f542" class="dashicons dashicons-thumbs-down"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-layout" role="button"><div alt="f538" class="dashicons dashicons-layout"></div></a></li>' + 
						'			<li style="display: inline-block;width: 25%"><a href="#" id="dashicons-misc-dashicons-paperclip" role="button"><div alt="f546" class="dashicons dashicons-paperclip"></div></a></li>' + 
						'		</ol>' + 
						'	</div>' + 
						'</div>',
				footer: ''
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog_form = ui.dialog({
				title: 'Forms',
				body: 'PLACEHOLDER',
				footer: '<button type="button" class="btn btn-primary note-dashicons-btn">' + lang.bootstrap_components.okButton + '</button>', 
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.events = {
				'summernote.init': function(we, e) {
					//console.log('summernote initialized', we, e);
				},
				'summernote.keyup': function(we, e) {
					//console.log('summernote keyup', we, e);
				}
			};

			this.destroy = function() {

				ui.hideDialog(this.$dashicons_dialog);
				this.$dashicons_dialog.remove();

				ui.hideDialog(this.$bootstrap_dialog_form);
				this.$bootstrap_dialog_form.remove();

			};

			this.bindEnterKey = function ($input, $btn) {
				$input.on('keypress', function (event) {
					if (event.keyCode === 13) $btn.trigger('click');
				});
			};

			this.bindLabels = function () {
				/*self.$dialog.find('.form-control:first').focus().select();
				self.$dialog.find('label').on('click', function () {
					$(this).parent().find('.form-control:first').focus();
				});*/
			};

			this.show = function () {
				var $img = $($editable.data('target'));
				var editorInfo = {

				};
				this.showBootstrapComponentsDialog(editorInfo).then(function (editorInfo) {
					ui.hideDialog(self.$dashicons_dialog);
					$note.val(context.invoke('code'));
					$note.change();
				});
			};

			this.showBootstrapComponentsDialog = function(editorInfo) {
				return $.Deferred(function (deferred) {
					ui.onDialogShown(self.$dashicons_dialog, function () {
						context.triggerEvent('dasicons_dialog.shown');
					});
					ui.onDialogHidden(self.$dasicons_dialog, function () {
						if (deferred.state() === 'pending') deferred.reject();
					});
					ui.showDialog(self.$dashicons_dialog);
				});
			};

		}, 

		'bootstrap': function(context) {
			var self      = this,

				ui        = $.summernote.ui,
				$note     = context.layoutInfo.note,

				$editor   = context.layoutInfo.editor,
				$editable = context.layoutInfo.editable,
				$toolbar  = context.layoutInfo.toolbar,

				options   = context.options,

				lang      = options.langInfo;

			context.memo('button.bootstrap', function() {

				var button = ui.button({
					contents: '<i class="fa fa-cogs"/>' + (options.showButtonNames == true ? ' Bootstrap' : '') + '',
					tooltip: 'Bootstrap',
					click: function() {
						self.$bootstrap_dialog.find('.modal-header').addClass('bg-primary text-white');
						self.$bootstrap_dialog.find('.modal-dialog').css({'width': '1000px'});
						self.$bootstrap_dialog.find('.modal-content').css({'width': '1000px'});
						context.invoke('bootstrap.show');
					},
				});

				var $bootstrap = button.render();
				return $bootstrap;
			});

			this.$bootstrap_dialog = ui.dialog({
				fade: true,
				title: 'Select a type',
				body: 	'<div class="card bg-white text-black-50">' + 
						'	<div class="card-header">' + 
						'		<ul class="nav nav-tabs card-header-tabs" id="bootstrapTab" role="tablist">' + 
						'			<li class="nav-item"><a href="#bootstrap_dialog_layout" class="nav-link active" data-toggle="tab" role="tab" aria-controls="bootstrap_dialog_layout" aria-selected="true">Layout</a></li>' + 
						'			<li class="nav-item"><a href="#bootstrap_dialog_content" class="nav-link" data-toggle="tab" role="tab" aria-controls="bootstrap_dialog_content" aria-selected="false">Content</a></li>' + 
						'			<li class="nav-item"><a href="#bootstrap_dialog_component" class="nav-link" data-toggle="tab" role="tab" aria-controls="bootstrap_dialog_component" aria-selected="false">Component</a></li>' + 
						'		</ul>' + 
						'	</div>' + 
						'<div class="tab-content" id="botstrapTabContent">' + 
						'	<div id="bootstrap_dialog_layout" class="card-body tab-pane fade show active" role="tabpanel">' + 
						'		<div class="row">' + 
						'			<div class="col-sm-6">' + 
						'				<p><strong>Layout-Containers</strong></p>' + 
						'				<ol style="padding: 5px 0px 0px 20px;list-style: normal">' + 
						'					<li><a href="#" id="bootstrap-layout-containers-container" role="button">Container</a></li>' + 
						'					<li><a href="#" id="bootstrap-layout-containers-container-fluid" role="button">Container-Fluid</a></li>' + 
						'				</ol>' + 
						'			</div>' + 
						'			<div class="col-sm-6">' + 
						'				<p><strong>Layout-Grid</strong></p>' + 
						'				<ol style="padding: 5px 0px 0px 20px;list-style: normal">' + 
						'					<li><a href="#" id="bootstrap-layout-grid-row" role="button">Row</a></li>' + 
						'					<li><a href="#" id="bootstrap-layout-grid-col" role="button">Col</a></li>' + 
						'					<li><a href="#" id="bootstrap-layout-grid-w-100" role="button">W-100</a></li>' + 
						'				</ol>' + 
						'			</div>' + 
						'		</div>' + 
						'		<br />' + 
						'		<br />' + 
						'	</div>' + 
						'	<div id="bootstrap_dialog_content" class="card-body tab-pane fade" role="tabpanel">' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: square">' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-h1-6" role="button">H1-6 - Headings</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-ul-ol" role="button">UL | OL - Lists (li)</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-dl" role="button">Dl - Definitions-list (Dt, Dd)</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-pre" role="button">PRE - Preformatted text</a></li>' + 
						'			<li style="float: left;width: 25%;">' + 
						'				<strong style="cursor: pointer" onclick="jQuery(\'#bootstrap_forms\').toggle()"><a href="Javascript:void(0)">Form-Elements</a></strong>' + 
						'				<ol id="bootstrap_forms" style="display: none;padding: 5px 0px 0px 15px;list-style: circle">' + 
						'					<li><a href="#" id="bootstrap-content-form-fieldset" role="button">Fieldset</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-legend" role="button">Legend</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-label" role="button">Label</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-input" role="button">Input</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-select" role="button">Select</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-textarea" role="button">Textarea</a></li>' + 
						'					<li><a href="#" id="bootstrap-content-form-button" role="button">Button</a></li>' + 
						'				</ol>' + 
						'			</li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-main" role="button">Main</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-header" role="button">Header</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-footer" role="button">Footer</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-section" role="button">Section</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-aside" role="button">Aside</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-nav" role="button">Nav</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-address" role="button">Address</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-blockquote" role="button">Blockquote</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-abbr" role="button">Abbr - <abbr>Example</abbr></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-cite" role="button">Cite - <cite>Example</cite></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-code" role="button">Code - <code>Example</code></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-var" role="button">Var - <var>Example</var></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-kbd" role="button">Kbd - <kbd>Keyboard</kbd></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-samp" role="button">Samp - <samp>Sample</samp></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-summary" role="button">Summary</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-mark" role="button">Mark - <mark>Example</mark></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-del" role="button">Del - <del>Delete</del></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-s" role="button">S - <s>Strike</s></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-ins" role="button">Ins - <ins>Insert</ins></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-u" role="button">U - <u>Underline</u></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-small" role="button">Small - <small>Example</small></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-strong" role="button">Strong - <strong>Example</strong></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-em" role="button">Em - <em>Cursive</em></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-i" role="button">I - <i>Italic</i></a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-img" role="button">Img - Image</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-picture" role="button">Picture - Picture</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-table" role="button">Table - Table</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-tr" role="button">Tr - Table-Row</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-th" role="button">Th - Table-Head</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-td" role="button">Td - Table-Data</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-content-figure" role="button">Figure - Figure (Img, Figcaption)</a></li>' + 
						'		</ol>' + 
						'		<br />' + 
						'		<br />' + 
						'	</div>' + 
						'	<div id="bootstrap_dialog_component" class="card-body tab-pane fade" role="tabpanel">' + 
						'		<ol style="display: inline-block;padding: 5px 0px 0px 15px;list-style: square">' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-alerts" role="button">Alerts</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-badge" role="button">Badge</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-breadcrumb" role="button">Breadcrumb</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-buttons" role="button">Buttons</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-button-group" role="button">Button group</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-card" role="button">Card</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-carousel" role="button">Carousel</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-collapse" role="button">Collapse</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-dropdowns" role="button">Dropdowns</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-forms" role="button">Forms</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-input-group" role="button">Input group</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-jumbotron" role="button">Jumbotron</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-list-group" role="button">List group</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-media-object" role="button">Media object</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-modal" role="button">Modal</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-navs" role="button">Navs</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-navbar" role="button">Navbar</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-pagination" role="button">Pagination</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-popovers" role="button">Popovers</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-progress" role="button">Progress</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-scrollspy" role="button">Scrollspy</a></li>' + 
						'			<li style="float: left;width: 25%;"><a href="#" id="bootstrap-component-tooltips" role="button">Tooltips</a></li>' + 
						'		</ol>' + 
						'		<br />' + 
						'		<br />' + 
						'	</div>' + 
						'	</div>' + 
						'</div>',
				footer: ''
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog_form = ui.dialog({
				fade: true,
				title: 'Forms',
				body: 'PLACEHOLDER',
				footer: '<button type="button" class="btn btn-primary note-bootstrap_components_form-btn">' + lang.bootstrap_components.okButton + '</button>', 
				callback: function ($node) {
					$node.find('.modal-body').css({
						'max-height': 300,
						'overflow-x': 'auto'
					});
				}
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog_input = ui.dialog({
				title: 'Input',
				body: 'PLACEHOLDER',
				footer: '<button type="button" class="btn btn-primary note-bootstrap_components_input-btn">' + lang.bootstrap_components.okButton + '</button>', 
				callback: function ($node) {
					$node.find('.modal-body').css({
						'max-height': 300,
						'overflow-x': 'auto'
					});
				}
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.events = {
				'summernote.init': function(we, e) {
					console.log('summernote initialized', we, e);
				},
				'summernote.keyup': function(we, e) {
					console.log('summernote keyup', we, e);
				},
			};

			this.initialize = function() {

				/* Layout */
				jQuery(document).on('click', '#bootstrap-layout-containers-container', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['container']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['container']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['container'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['container'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['container'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-layout-containers-container-fluid', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['container_fluid']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['container_fluid']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['container_fluid'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['container_fluid'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['container_fluid'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-layout-grid-row', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['row']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['row']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['row'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['row'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['row'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-layout-grid-col', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['col']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['col']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['col'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['col'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['col'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-layout-grid-w-100', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['w_100']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['w_100']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['w_100'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['w_100'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['w_100'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				/* Content */
				jQuery(document).on('click', '#bootstrap-content-h1-6', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['h1_6']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['h1_6']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['h1_6'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['h1_6'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['h1_6'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-ul-ol', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['ul_ol']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['ul_ol']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['ul_ol'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['ul_ol'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['ul_ol'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-dl', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['dl']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['dl']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['dl'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['dl'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['dl'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-pre', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['pre']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['pre']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['pre'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['pre'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['pre'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-fieldset', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['form_fieldset']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['form_fieldset']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['form_fieldset'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['form_fieldset'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['form_fieldset'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-legend', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['form_legend']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['form_legend']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['form_legend'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['form_legend'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['form_legend'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-label', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['form_label']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['form_label']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['form_label'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['form_label'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['form_label'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-input', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['form_input']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['form_input']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['form_input'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['form_input'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['form_input'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-select', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['select']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['select']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['select'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['select'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['select'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-textarea', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['textarea']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['textarea']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['textarea'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['textarea'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['textarea'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-form-button', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['button']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['button']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['button'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['button'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['button'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-main', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['main']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['main']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['main'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['main'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['main'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-header', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['header']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['header']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['header'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['header'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['header'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-footer', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['footer']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['footer']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['footer'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['footer'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['footer'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-section', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['section']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['section']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['section'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['section'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['section'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-aside', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['aside']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['aside']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['aside'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['aside'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['aside'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-nav', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['nav']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['nav']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['nav'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['nav'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['nav'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-address', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['address']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['address']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['address'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['address'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['address'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-blockquote', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['blockquote']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['blockquote']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['blockquote'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['blockquote'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['blockquote'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-abbr', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['abbr']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['abbr']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['abbr'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['abbr'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['abbr'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-cite', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['cite']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['cite']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['cite'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['cite'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['cite'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-code', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['code']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['code']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['code'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['code'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['code'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-var', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['var']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['var']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['var'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['var'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['var'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-kbd', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['kbd']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['kbd']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['kbd'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['kbd'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['kbd'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-samp', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['samp']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['samp']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['samp'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['samp'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['samp'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-summary', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['summary']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['summary']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['summary'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['summary'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['summary'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-mark', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['mark']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['mark']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['mark'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['mark'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['mark'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-del', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['del']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['del']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['del'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['del'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['del'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-s', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['s']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['s']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['s'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['s'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['s'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-ins', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['ins']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['ins']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['ins'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['ins'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['ins'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-u', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['u']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['u']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['u'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['u'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['u'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-small', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['small']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['small']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['small'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['small'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['small'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-strong', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['strong']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['strong']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['strong'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['strong'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['strong'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-em', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['em']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['em']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['em'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['em'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['em'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-i', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['i']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['i']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['i'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['i'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['i'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-img', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['img']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['img']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['img'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['img'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['img'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-picture', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['picture']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['picture']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['picture'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['picture'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['picture'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-table', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['table']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['table']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['table'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['table'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['table'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-tr', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['tr']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['tr']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['tr'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['tr'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['tr'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-th', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['th']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['th']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['th'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['th'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['th'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-td', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['td']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['td']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['td'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['td'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['td'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-content-figure', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['figure']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['figure']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['figure'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['figure'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['figure'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				/* Component */
				jQuery(document).on('click', '#bootstrap-component-alerts', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['alerts']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['alerts']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['alerts'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['alerts'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['alerts'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-badge', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['badge']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['badge']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['badge'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['badge'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['badge'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-breadcrumb', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['breadcrumb']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['breadcrumb']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['breadcrumb'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['breadcrumb'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['breadcrumb'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-buttons', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['button']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['button']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['button'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['button'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['button'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-button-group', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['button_group']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['button_group']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['button_group'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['button_group'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['button_group'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-card', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['card']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['card']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['card'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['card'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['card'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-carousel', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['carousel']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['carousel']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['carousel'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['carousel'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['carousel'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-collapse', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['collapse']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['collapse']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['collapse'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['collapse'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['collapse'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-dropdowns', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['dropdowns']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['dropdowns']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['dropdowns'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['dropdowns'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['dropdowns'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-forms', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['forms']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['forms']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['forms'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['forms'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['forms'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');

					jQuery(document).on('click', '#bootstrap-component-forms-content-button', function(){
						var html = '';
						var selected_value = jQuery('#bootstrap-component-forms-content-select option:selected').val();

						self.$bootstrap_dialog_input.find('.modal-title').text('Forms - '+bootstrap_components_modal_forms['forms_'+selected_value]['title']);
						self.$bootstrap_dialog_input.find('.modal-header').addClass('bg-primary text-white');
						self.$bootstrap_dialog_input.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['forms_'+selected_value]['title']);
						self.$bootstrap_dialog_input.find('.modal-body').html(bootstrap_components_modal_forms['forms_'+selected_value]['form']);
						self.$bootstrap_dialog_input.find('.note-bootstrap_components_input-btn').unbind("click").click(function(){
							context.invoke('editor.restoreRange');
							context.invoke('editor.focus');
							if(bootstrap_components_modal_forms['forms_'+selected_value].checkFormMessage() == ""){
//								context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['forms_'+selected_value].html())[0]);
								var html = bootstrap_components_modal_forms['forms_'+selected_value].html();
								self.$bootstrap_dialog_input.modal('hide');
								self.$bootstrap_dialog_form.modal('show');
							}else{
								alert(bootstrap_components_modal_forms['forms_'+selected_value].checkFormMessage());
							}
						});

						//context.invoke('bootstrap.show');
						self.$bootstrap_dialog_input.modal('show');

						self.$bootstrap_dialog_form.modal('hide');

					});
					jQuery('#bootstrap-component-forms-insert-html').on('click', function(){
						var id = jQuery('#bootstrap-component-forms-id').val();
						var action = jQuery('#bootstrap-component-forms-action').val();
						var method = jQuery('#bootstrap-component-forms-method').val();
						var enctype = jQuery('#bootstrap-component-forms-enctype').val();
						var target = jQuery('#bootstrap-component-forms-target').val();
						var autocomplete = jQuery('#bootstrap-component-forms-autocomplete').val();
						var novalidate = jQuery('#bootstrap-component-forms-novalidate').val();
						var inline = jQuery('#bootstrap-component-forms-inline').val();
						var onsubmit = jQuery('#bootstrap-component-forms-onsubmit').val();

						var column_sizing = jQuery('#bootstrap-component-forms-column-sizing').val();

						var label_sizing = jQuery('#bootstrap-component-forms-label-sizing').val();
						var control_sizing = jQuery('#bootstrap-component-forms-control-sizing').val();

						var tooltips = jQuery('#bootstrap-component-forms-tooltips').val();

						var margin_top = jQuery('#bootstrap-component-forms-margin-top').val();
						var margin_right = jQuery('#bootstrap-component-forms-margin-right').val();
						var margin_bottom = jQuery('#bootstrap-component-forms-margin-bottom').val();
						var margin_left = jQuery('#bootstrap-component-forms-margin-left').val();

						var padding_top = jQuery('#bootstrap-component-forms-padding-top').val();
						var padding_right = jQuery('#bootstrap-component-forms-padding-right').val();
						var padding_bottom = jQuery('#bootstrap-component-forms-padding-bottom').val();
						var padding_left = jQuery('#bootstrap-component-forms-padding-left').val();

						var color = jQuery('#bootstrap-component-forms-color').val();
						var bgcolor = jQuery('#bootstrap-component-forms-bgcolor').val();
						var border_color = jQuery('#bootstrap-component-forms-border-color').val();
						var border_types = jQuery('#bootstrap-component-forms-border-types').val();
						var border_radius = jQuery('#bootstrap-component-forms-border-radius').val();

						var button_label = jQuery('#bootstrap-component-forms-button-label').val();
						var button_onclick = jQuery('#bootstrap-component-forms-button-onclick').val();

						var button_color = jQuery('#bootstrap-component-forms-button-color').val();
						var button_bgcolor = jQuery('#bootstrap-component-forms-button-bgcolor').val();
						var button_border_color = jQuery('#bootstrap-component-forms-button-border-color').val();
						var button_border_types = jQuery('#bootstrap-component-forms-button-border-types').val();
						var button_border_radius = jQuery('#bootstrap-component-forms-button-border-radius').val();

						var style = jQuery('#bootstrap-component-forms-style').val();
						var forms_class = jQuery('#bootstrap-component-forms-class').val();

						var attr_id = id != '' ? ' id="' + id + '"' : '';
						var attr_name = id != '' ? ' name="' + id + '"' : '';
						var attr_action = action != '' ? ' action="' + action + '"' : '';
						var attr_method = method != '' ? ' method="' + method + '"' : '';
						var attr_style = style != '' ? ' style="' + style + '"' : '';
						var attr_novalidate = novalidate != '' ? ' novalidate="' + novalidate + '"' : '';
						var attr_onsubmit = onsubmit != '' ? ' onsubmit="' + onsubmit + '"' : '';

						var attr_button_onclick = button_onclick != '' ? ' onclick="' + button_onclick + '"' : '';

						var class_inline = inline != '' ? ' ' + inline : '';

						var class_label_sizing = label_sizing != '' ? ' ' + label_sizing : '';
						var class_control_sizing = control_sizing != '' ? ' ' + control_sizing : '';

						var class_margin_top = margin_top != '' ? ' ' + margin_top : '';
						var class_margin_right = margin_right != '' ? ' ' + margin_right : '';
						var class_margin_bottom = margin_bottom != '' ? ' ' + margin_bottom : '';
						var class_margin_left = margin_left != '' ? ' ' + margin_left : '';

						var class_padding_top = padding_top != '' ? ' ' + padding_top : '';
						var class_padding_right = padding_right != '' ? ' ' + padding_right : '';
						var class_padding_bottom = padding_bottom != '' ? ' ' + padding_bottom : '';
						var class_padding_left = padding_left != '' ? ' ' + padding_left : '';

						var class_form_color = color != '' ? ' text-' + color : '';
						var class_form_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
						var class_form_border_color = border_color != '' ? ' border-' + border_color : '';
						var class_form_border_types = border_types != '' ? ' ' + border_types : '';
						var class_form_border_radius = border_radius != '' ? ' ' + border_radius : '';

						var class_button_color = button_color != '' ? ' text-' + button_color : '';
						var class_button_bgcolor = button_bgcolor != '' ? ' btn-' + button_bgcolor : '';
						var class_button_border_color = button_border_color != '' ? ' border-' + button_border_color : '';
						var class_button_border_types = button_border_types != '' ? ' ' + button_border_types : '';
						var class_button_border_radius = button_border_radius != '' ? ' ' + button_border_radius : '';

						var content = jQuery('#bootstrap-component-forms-content').val();
						var content_arr = content.split('\n');
						var content_str = '';
						var content_hidden = '';
						for(var i = 0;i < content_arr.length;i++){
							var keyArr = content_arr[i].split('|');
							switch (keyArr[0]){
								case 'text': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'textarea': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_rows = keyArr[12] != '' ? ' rows="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<textarea id="' + keyArr[1] + '" name="' + keyArr[2] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_rows + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '">' + keyArr[4] + '</textarea>\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'search': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'password': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'tel': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'url': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'email': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'date': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'datetime-local': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'week': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'month': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'time': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{2}:[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'number': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_step = keyArr[14] != '' ? ' step="' + keyArr[14] + '"' : '';
									var attr_onkeyup = keyArr[15] != '' ? ' onkeyup="' + keyArr[15] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[16] != '' ? ' font-weight-' + keyArr[16] : '';
									var class_font_italic = keyArr[17] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[18] != '' ? ' text-' + keyArr[18] : '';
									var class_bgcolor = keyArr[19] != '' ? ' bg-' + keyArr[19] : '';
									var class_border_color = keyArr[20] != '' ? ' border-' + keyArr[20] : '';
									var class_border_types = keyArr[21] != '' ? ' ' + keyArr[21] : '';
									var class_border_radius = keyArr[22] != '' ? ' ' + keyArr[22] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'range': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
									var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
									var attr_step = keyArr[14] != '' ? ' step="' + keyArr[14] + '"' : '';
									var attr_onkeyup = keyArr[15] != '' ? ' onkeyup="' + keyArr[15] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[16] != '' ? ' font-weight-' + keyArr[16] : '';
									var class_font_italic = keyArr[17] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[18] != '' ? ' text-' + keyArr[18] : '';
									var class_bgcolor = keyArr[19] != '' ? ' bg-' + keyArr[19] : '';
									var class_border_color = keyArr[20] != '' ? ' border-' + keyArr[20] : '';
									var class_border_types = keyArr[21] != '' ? ' ' + keyArr[21] : '';
									var class_border_radius = keyArr[22] != '' ? ' ' + keyArr[22] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'radio': 

									var attr_disabled = keyArr[3] == 'checked' ? ' disabled="disabled"' : '';
									var attr_required = keyArr[4] == 'checked' ? ' required="required"' : '';
									var class_disabled = keyArr[3] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[8] != '' ? ' font-weight-' + keyArr[8] : '';
									var class_font_italic = keyArr[9] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[10] != '' ? ' text-' + keyArr[10] : '';
									var class_bgcolor = keyArr[11] != '' ? ' bg-' + keyArr[11] : '';
									var class_border_color = keyArr[12] != '' ? ' border-' + keyArr[12] : '';
									var class_border_types = keyArr[13] != '' ? ' ' + keyArr[13] : '';
									var class_border_radius = keyArr[14] != '' ? ' ' + keyArr[14] : '';

									var tag_help = keyArr[5] != '' ? 	'			<small class="form-text text-muted">\n' + 
																		'				' + keyArr[5] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[6] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[6] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[7] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[7] + '\n' + 
																			'			</div>\n' : '';
									radios_str = '';
									var radiosArr = keyArr[15].split('^');
									for(var i = 0;i < radiosArr.length;i++){
										var radios_opt = radiosArr[i].split('~');
										var tag_label = radios_opt[1] != '' ? 	'				<label for="' + radios_opt[0] + '" class="custom-control-label">\n' + 
																				'					' + radios_opt[1] + '\n' + 
																				'				</label>\n' : '';
										var attr_checked = radios_opt[3] == 'checked' ? ' checked="checked"' : '';
										radios_str += 	'			<div class="custom-control custom-radio">\n' + 
														'				<input type="' + keyArr[0] + '" name="' + keyArr[1] + '" id="' + radios_opt[0] + '" value="' + radios_opt[2] + '"' + attr_disabled + attr_required + attr_checked + ' class="custom-control-input' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
														tag_label + 
														tag_valid + 
														tag_invalid + 
														'			</div>\n';
									}
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<div class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[2] + '</div>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													radios_str + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'checkbox': 
									var attr_disabled = keyArr[2] == 'checked' ? ' disabled="disabled"' : '';
									var attr_required = keyArr[3] == 'checked' ? ' required="required"' : '';
									var class_disabled = keyArr[2] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[7] != '' ? ' font-weight-' + keyArr[7] : '';
									var class_font_italic = keyArr[8] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[9] != '' ? ' text-' + keyArr[9] : '';
									var class_bgcolor = keyArr[10] != '' ? ' bg-' + keyArr[10] : '';
									var class_border_color = keyArr[11] != '' ? ' border-' + keyArr[11] : '';
									var class_border_types = keyArr[12] != '' ? ' ' + keyArr[12] : '';
									var class_border_radius = keyArr[13] != '' ? ' ' + keyArr[13] : '';

									var tag_help = keyArr[4] != '' ? 	'			<small class="form-text text-muted">\n' + 
																		'				' + keyArr[4] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[5] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[5] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[6] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[6] + '\n' + 
																			'			</div>\n' : '';
									radios_str = '';
									var radiosArr = keyArr[14].split('^');
									for(var i = 0;i < radiosArr.length;i++){
										var radios_opt = radiosArr[i].split('~');
										var tag_label = radios_opt[2] != '' ? 	'				<label for="' + radios_opt[1] + '" class="custom-control-label">\n' + 
																				'					' + radios_opt[2] + '\n' + 
																				'				</label>\n' : '';
										var attr_checked = radios_opt[4] == 'checked' ? ' checked="checked"' : '';
										radios_str += 	'			<div class="custom-control custom-checkbox">\n' + 
														'				<input type="' + keyArr[0] + '" name="' + radios_opt[0] + '" id="' + radios_opt[1] + '" value="' + radios_opt[3] + '"' + attr_disabled + attr_required + attr_checked + ' class="custom-control-input' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
														tag_label + 
														tag_valid + 
														tag_invalid + 
														'			</div>\n';
									}
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<div class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[1] + '</div>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													radios_str + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'select': 

									var attr_disabled = keyArr[4] == 'checked' ? ' disabled="disabled"' : '';
									var attr_required = keyArr[5] == 'checked' ? ' required="required"' : '';
									var attr_size = keyArr[9] != '' ? ' size="' + keyArr[9] + '"' : '';
									var attr_multiple = keyArr[10] == 'checked' ? ' multiple="multiple"' : '';
									var attr_onchange = keyArr[11] != '' ? ' onchange="' + keyArr[11] + '"' : '';
									var class_disabled = keyArr[4] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[12] != '' ? ' font-weight-' + keyArr[12] : '';
									var class_font_italic = keyArr[13] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[14] != '' ? ' text-' + keyArr[14] : '';
									var class_bgcolor = keyArr[15] != '' ? ' bg-' + keyArr[15] : '';
									var class_border_color = keyArr[16] != '' ? ' border-' + keyArr[16] : '';
									var class_border_types = keyArr[17] != '' ? ' ' + keyArr[17] : '';
									var class_border_radius = keyArr[18] != '' ? ' ' + keyArr[18] : '';

									var tag_help = keyArr[6] != '' ? 	'			<small class="form-text text-muted">\n' + 
																		'				' + keyArr[6] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[7] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[7] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[8] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[8] + '\n' + 
																			'			</div>\n' : '';
									options_str = '';
									var optionsArr = keyArr[19].split('^');
									for(var i = 0;i < optionsArr.length;i++){
										var options_opt = optionsArr[i].split('~');
										var options_selected = options_opt[2] == 'selected' ? ' selected="selected"' : '';
										options_str += 	'			<option value="' + options_opt[1] + '"' + options_selected + '>\n' + 
														'				' + options_opt[0] + '\n' + 
														'			</option>\n';
									}
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<select name="' + keyArr[2] + '" id="' + keyArr[1] + '"' + attr_disabled + attr_required + attr_size + attr_multiple + attr_onchange + ' class="custom-select' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '">\n' + 
													options_str + 
													'			</select>\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'file': 
									var attr_disabled = keyArr[5] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[6] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[7] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[8] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_accept = keyArr[11] != '' ? ' accept="' + keyArr[11] + '"' : '';
									var attr_multiple = keyArr[12] == 'checked' ? ' multiple="multiple"' : '';
									var attr_onchange = keyArr[13] != '' ? ' onchange="' + keyArr[13] + '"' : '';
									var class_disabled = keyArr[5] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[14] != '' ? ' font-weight-' + keyArr[14] : '';
									var class_font_italic = keyArr[15] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[16] != '' ? ' text-' + keyArr[16] : '';
									var class_bgcolor = keyArr[17] != '' ? ' bg-' + keyArr[17] : '';
									var class_border_color = keyArr[18] != '' ? ' border-' + keyArr[18] : '';
									var class_border_types = keyArr[19] != '' ? ' ' + keyArr[19] : '';
									var class_border_radius = keyArr[20] != '' ? ' ' + keyArr[20] : '';

									var tag_help = keyArr[8] != '' ? 	'				<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'					' + keyArr[8] + '\n' + 
																		'				</small>\n' : '';
									var tag_valid = keyArr[9] != '' ? 	'				<div class="valid-' + tooltips + '">\n' + 
																		'					' + keyArr[9] + '\n' + 
																		'				</div>\n' : '';
									var tag_invalid = keyArr[10] != '' ? 	'				<div class="invalid-' + tooltips + '">\n' + 
																			'					' + keyArr[10] + '\n' + 
																			'				</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<div class="custom-file">\n' + 
													'				<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value=""' + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_accept + attr_multiple + attr_onchange + ' class="custom-file-input' + class_control_sizing + '" />\n' + 
													'				<label class="custom-file-label' + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" for="' + keyArr[1] + '">' + keyArr[4] + '</label>\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'			</div>\n' + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'color': 
									var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
									var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
									var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
									var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
									var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
									var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
									var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
									var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
									var attr_onchange = keyArr[14] != '' ? ' onchange="' + keyArr[14] + '"' : '';
									var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

									var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
									var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

									var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
									var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
									var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
									var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
									var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

									var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																		'				' + keyArr[9] + '\n' + 
																		'			</small>\n' : '';
									var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																		'				' + keyArr[10] + '\n' + 
																		'			</div>\n' : '';
									var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																			'				' + keyArr[11] + '\n' + 
																			'			</div>\n' : '';
													
									content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
													'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
													'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
													'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onchange + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" style="padding: .3rem;height: 2.5rem" />\n' + 
													tag_valid + 
													tag_invalid + 
													tag_help + 
													'		</div>\n' + 
													'	</div>\n';
									break;
								case 'hidden': 
									var attr_required = keyArr[4] == 'checked' ? ' required="required"' : '';
									var attr_minlength = keyArr[5] != '' ? ' minlength="' + keyArr[5] + '"' : '';
									var attr_maxlength = keyArr[6] != '' ? ' maxlength="' + keyArr[6] + '"' : '';
									
									content_hidden += 	'	<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[3] + '"' + attr_required + attr_minlength + attr_maxlength + ' />\n';
									break;
							}
						}
						var button = button_label != '' ? '	<button type="submit"' + attr_button_onclick + ' class="btn' + class_button_color + class_button_bgcolor + class_button_border_types + class_button_border_color + class_button_border_radius + '">' + button_label + '</button>\n' : '';
						editor.insertContent('<form' + attr_id + attr_name + attr_action + attr_method + attr_style + attr_novalidate + attr_onsubmit + ' enctype="' + enctype + '" target="' + target + '" autocomplete="' + autocomplete + '" class="' + forms_class + class_inline + class_margin_top + class_margin_right + class_margin_bottom + class_margin_left + class_padding_top + class_padding_right + class_padding_bottom + class_padding_left + class_form_color + class_form_bgcolor + class_form_border_types + class_form_border_color + class_form_border_radius + '">' + content_hidden + content_str + button + '</form>\n');
						jQuery('#bootstrap-dialog-form').dialog('close');
					});

				});

				jQuery(document).on('click', '#bootstrap-component-jumbotron', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['jumbotron']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['jumbotron']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['jumbotron'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['jumbotron'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['jumbotron'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-list-group', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['list_group']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['list_group']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['list_group'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['list_group'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['list_group'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-media-object', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['media_object']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['media_object']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['media_object'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['media_object'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['media_object'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-modal', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['modal']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['modal']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['modal'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['modal'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['modal'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-navs', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['navs']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['navs']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['navs'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['navs'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['navs'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-navbar', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['navbar']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['navbar']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['navbar'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['navbar'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['navbar'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-pagination', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['pagination']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['pagination']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['pagination'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['pagination'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['pagination'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-popovers', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['popovers']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['popovers']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['popovers'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['popovers'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['popovers'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-progress', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['progress']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['progress']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['progress'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['progress'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['progress'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-scrollspy', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['scrollspy']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['scrollspy']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['scrollspy'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['scrollspy'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['scrollspy'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});

				jQuery(document).on('click', '#bootstrap-component-tooltips', function(){
					self.$bootstrap_dialog_form.find('.modal-header').addClass('bg-primary text-white');
					self.$bootstrap_dialog_form.find('.modal-title').text('Components - '+bootstrap_components_modal_forms['tooltips']['title']);
					self.$bootstrap_dialog_form.find('.modal-body').html(bootstrap_components_modal_forms['tooltips']['form']);
					self.$bootstrap_dialog_form.find('.note-bootstrap_components_form-btn').unbind("click").click(function(){
						context.invoke('editor.restoreRange');
						context.invoke('editor.focus');
						if(bootstrap_components_modal_forms['tooltips'].checkFormMessage() == ""){
							context.invoke("editor.insertNode", $(bootstrap_components_modal_forms['tooltips'].html())[0]);
							self.$bootstrap_dialog_form.modal('hide');
						}else{
							alert(bootstrap_components_modal_forms['tooltips'].checkFormMessage());
						}
					});
					//context.invoke('bootstrap.show');
					self.$bootstrap_dialog_form.modal('show');

					self.$bootstrap_dialog.modal('hide');
				});
			};

			this.show = function () {
				var $img = $($editable.data('target'));
				var editorInfo = {

				};
				this.showBootstrapDialog(editorInfo).then(function (editorInfo) {
					ui.hideDialog(self.$bootstrap_dialog);
					$note.val(context.invoke('code'));
					$note.change();
				});
			};

			this.showBootstrapDialog = function(editorInfo) {
				return $.Deferred(function (deferred) {
					ui.onDialogShown(self.$bootstrap_dialog, function () {
						context.triggerEvent('dialog.shown');
					});
					ui.onDialogHidden(self.$bootstrap_dialog, function () {
						if (deferred.state() === 'pending') deferred.reject();
					});
					ui.showDialog(self.$bootstrap_dialog);
				});
			};

			this.destroy = function() {

				this.$bootstrap_dialog.remove();
				this.$bootstrap_dialog = null;

				this.$bootstrap_dialog_form.remove();
				this.$bootstrap_dialog_form = null;

				this.$bootstrap_dialog_input.remove();
				this.$bootstrap_dialog_input = null;

			};
		},

		'bootstrap_components': function(context) {

			var self      = this,

				ui        = $.summernote.ui,
				$note     = context.layoutInfo.note,

				$editor   = context.layoutInfo.editor,
				$editable = context.layoutInfo.editable,
				$toolbar  = context.layoutInfo.toolbar,

				options   = context.options,

				lang      = options.langInfo;

			// add bootstrap_components button
			context.memo('button.bootstrap_components', function() {
				var components = {
					'card_with_nav_tabs': 'Card Nav Tabs'
				}
				var list = "";
				for(key in components){
					list+='<a href="Javascript:void(0)" class="dropdown-item" data-value="'+key+'" role="listitem" aria-label="'+bootstrap_components_modal_forms[key]['title']+'">'+bootstrap_components_modal_forms[key]['title']+'</a>';
				}
				var $bootstrap_components = ui.buttonGroup([
					ui.button({
						className: 'dropdown-toggle',
						contents: '<span class="fa fa-gem"></span>' + (options.showButtonNames == true ? ' Components ' : '') + '<span class="caret"></span>',
						tooltip: 'Components',
						data: {
							toggle: 'dropdown'
						},
						click: function () {
							context.invoke('editor.saveRange');
						}
					}),
					ui.dropdown({
						className: 'dropdown-style',
						contents: list,
						callback: function($dropdown) {
							$dropdown.find('a').each(function() {
								var s = this;
								$(this).click(function() {
									self.$dialog.find('.modal-header').addClass('bg-primary text-white');
									self.$dialog.find('.modal-title').text('Components - '+bootstrap_components_modal_forms[$(this).data("value")]['title']);
									self.$dialog.find('.modal-body').html(bootstrap_components_modal_forms[$(this).data("value")]['form']);
									self.$dialog.find('.note-bootstrap_components-btn').unbind("click").click(function(){
										context.invoke('editor.restoreRange');
										context.invoke('editor.focus');
										if(bootstrap_components_modal_forms[$(s).data("value")].checkFormMessage() == ""){
											context.invoke("editor.insertNode", $(bootstrap_components_modal_forms[$(s).data("value")].html())[0]);
											self.$dialog.modal('hide');
										}else{
											alert(bootstrap_components_modal_forms[$(s).data("value")].checkFormMessage());
										}
									});
									context.invoke('bootstrap_components.show');
								});
							});
						}
					})
				]).render();
				return $bootstrap_components;
			});

			this.initialize = function() {
			}

			this.$dialog = ui.dialog({
				title: lang.bootstrap_components.dialogTitle,
				body: 'PLACEHOLDER',
				footer: '<button type="button" class="btn btn-primary note-bootstrap_components-btn">' + lang.bootstrap_components.okButton + '</button>'
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog = ui.dialog({
				title: 'Select a type',
				body: 	'<ul class="nav nav-tabs" id="myTab" role="tablist">' + 
						'	<li class="nav-item">' + 
						'		<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>' + 
						'	</li>' + 
						'	<li class="nav-item">' + 
						'		<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>' + 
						'	</li>' + 
						'	<li class="nav-item">' + 
						'		<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>' + 
						'	</li>' + 
						'</ul>' + 
						'<div class="tab-content" id="myTabContent">' + 
						'	<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>' + 
						'	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>' + 
						'	<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>' + 
						'</div>',
				footer: ''
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog_form = ui.dialog({
				title: 'Forms',
				body: 'PLACEHOLDER',
				footer: '<input type="submit" name="bootstrap-component-forms-insert-html" id="bootstrap-component-forms-insert-html" value="Insert HTML" class="button button-primary button-large" />'
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.$bootstrap_dialog_input = ui.dialog({
				title: 'Input',
				body: 'PLACEHOLDER',
				footer: ''
			}).render().appendTo(options.dialogsInBody ? $(document.body) : $editor);

			this.events = {
				'summernote.init': function(we, e) {
					//console.log('summernote initialized', we, e);
				},
				'summernote.keyup': function(we, e) {
					//console.log('summernote keyup', we, e);
				}
			};

			this.destroy = function() {

				ui.hideDialog(this.$dialog);
				this.$dialog.remove();

				ui.hideDialog(this.$bootstrap_dialog);
				this.$bootstrap_dialog.remove();

				ui.hideDialog(this.$bootstrap_dialog_form);
				this.$bootstrap_dialog_form.remove();

				ui.hideDialog(this.$bootstrap_dialog_input);
				this.$bootstrap_dialog_input.remove();

			};

			this.bindEnterKey = function ($input, $btn) {
				$input.on('keypress', function (event) {
					if (event.keyCode === 13) $btn.trigger('click');
				});
			};

			this.bindLabels = function () {
				self.$dialog.find('.form-control:first').focus().select();
				self.$dialog.find('label').on('click', function () {
					$(this).parent().find('.form-control:first').focus();
				});
			};

			this.show = function () {
				var $img = $($editable.data('target'));
				var editorInfo = {

				};
				this.showBootstrapComponentsDialog(editorInfo).then(function (editorInfo) {
					ui.hideDialog(self.$dialog);
					$note.val(context.invoke('code'));
					$note.change();
				});
			};

			this.showBootstrapComponentsDialog = function(editorInfo) {
				return $.Deferred(function (deferred) {
					ui.onDialogShown(self.$dialog, function () {
						context.triggerEvent('dialog.shown');
					});
					ui.onDialogHidden(self.$dialog, function () {
						if (deferred.state() === 'pending') deferred.reject();
					});
					ui.showDialog(self.$dialog);
				});
			};

		}, 

	});

	var bootstrap_options_colors = 	'<option value="">None</option>' + 
									'<option value="primary" class="text-primary">Primary</option>' + 
									'<option value="secondary" class="text-secondary">Secondary</option>' + 
									'<option value="success" class="text-success">Success</option>' + 
									'<option value="danger" class="text-danger">Danger</option>' + 
									'<option value="warning" class="text-warning">Warning</option>' + 
									'<option value="info" class="text-info">Info</option>' + 
									'<option value="light bg-dark" class="text-light bg-dark">Light</option>' + 
									'<option value="dark" class="text-dark">Dark</option>' + 
									'<option value="body" class="text-body">Body</option>' + 
									'<option value="muted" class="text-muted">Muted</option>' + 
									'<option value="white bg-dark" class="text-white bg-dark">White</option>' + 
									'<option value="black-50" class="text-black-50">Black-50</option>' + 
									'<option value="white-50 bg-dark" class="text-white-50 bg-dark">White-50</option>';

	var bootstrap_options_bgcolors = 	'<option value="">None</option>' + 
										'<option value="primary" class="bg-primary">Primary</option>' + 
										'<option value="secondary" class="bg-secondary">Secondary</option>' + 
										'<option value="success" class="bg-success">Success</option>' + 
										'<option value="danger" class="bg-danger">Danger</option>' + 
										'<option value="warning" class="bg-warning">Warning</option>' + 
										'<option value="info" class="bg-info">Info</option>' + 
										'<option value="light" class="bg-light">Light</option>' + 
										'<option value="dark" class="bg-dark">Dark</option>' + 
										'<option value="white" class="bg-white">White</option>' + 
										'<option value="transparent" class="bg-transparent">Transparent</option>';

	var bootstrap_options_btncolors = 	'<option value="">None</option>' + 
										'<option value="primary" class="bg-primary">Primary</option>' + 
										'<option value="secondary" class="bg-secondary">Secondary</option>' + 
										'<option value="success" class="bg-success">Success</option>' + 
										'<option value="danger" class="bg-danger">Danger</option>' + 
										'<option value="warning" class="bg-warning">Warning</option>' + 
										'<option value="info" class="bg-info">Info</option>' + 
										'<option value="light" class="bg-light">Light</option>' + 
										'<option value="dark" class="bg-dark">Dark</option>' + 
										'<option value="link" class="bg-link">Link</option>';

	var bootstrap_options_border_types = 	'<option value="">None</option>' + 
											'<option value="border">Border</option>' + 
											'<option value="border-top">Border-Top</option>' + 
											'<option value="border-right">Border-Right</option>' + 
											'<option value="border-bottom">Border-Bottom</option>' + 
											'<option value="border-left">Border-Left</option>' + 
											'<option value="border-0">Border-0</option>' + 
											'<option value="border-top-0">Border-Top-0</option>' + 
											'<option value="border-right-0">Border-Right-0</option>' + 
											'<option value="border-bottom-0">Border-Bottom-0</option>' + 
											'<option value="border-left-0">Border-Left-0</option>';

	var bootstrap_options_border_radius = 	'<option value="">None</option>' + 
											'<option value="rounded">Rounded</option>' + 
											'<option value="rounded-top">Rounded-Top</option>' + 
											'<option value="rounded-right">Rounded-Right</option>' + 
											'<option value="rounded-bottom">Rounded-Bottom</option>' + 
											'<option value="rounded-left">Rounded-Left</option>' + 
											'<option value="rounded-circle">Rounded-Circle</option>' + 
											'<option value="rounded-0">Rounded-0</option>';

	var bootstrap_options_list_style = 	'<option value="none">None</option>' + 
										'<option value="circle">Circle</option>' + 
										'<option value="disc">Disc</option>' + 
										'<option value="square">Square</option>' + 
										'<option value="armenian">Armenian</option>' + 
										'<option value="cjk-ideographic">CJK-Ideographic</option>' + 
										'<option value="decimal">Decimal</option>' + 
										'<option value="decimal-leading-zero">Decimal-Leading-Zero</option>' + 
										'<option value="georgian">Georgian</option>' + 
										'<option value="hebrew">Hebrew</option>' + 
										'<option value="hiragana">Hiragana</option>' + 
										'<option value="hiragana-iroha">Hiragana-Iroha</option>' + 
										'<option value="katakana">Katakana</option>' + 
										'<option value="katakana-iroha">Katakana-Iroha</option>' + 
										'<option value="lower-alpha">Lower-Alpha</option>' + 
										'<option value="lower-greek">Lower-Greek</option>' + 
										'<option value="lower-latin">Lower-Latin</option>' + 
										'<option value="lower-roman">Lower-Roman</option>' + 
										'<option value="upper-alpha">Upper-Alpha</option>' + 
										'<option value="upper-greek">Upper-Greek</option>' + 
										'<option value="upper-latin">Upper-Latin</option>' + 
										'<option value="upper-roman">Upper-Roman</option>' + 
										'<option value="none">None</option>' + 
										'<option value="inherit">Inherit</option>';

	var bootstrap_options_1_12 = 	'<option value="">None</option>' + 
									'<option value="1">1</option>' + 
									'<option value="2">2</option>' + 
									'<option value="3">3</option>' + 
									'<option value="4">4</option>' + 
									'<option value="5">5</option>' + 
									'<option value="6">6</option>' + 
									'<option value="7">7</option>' + 
									'<option value="8">8</option>' + 
									'<option value="9">9</option>' + 
									'<option value="10">10</option>' + 
									'<option value="11">11</option>' + 
									'<option value="12">12</option>';

	var bootstrap_options_justify_content = '<option value="">None</option>' + 
											'<option value="start">Start</option>' + 
											'<option value="center">Center</option>' + 
											'<option value="end">End</option>' + 
											'<option value="around">Around</option>' + 
											'<option value="between">Between</option>';

	var bootstrap_options_align_items = '<option value="">None</option>' + 
										'<option value="start">Start</option>' + 
										'<option value="center">Center</option>' + 
										'<option value="end">End</option>' + 
										'<option value="baseline">Baseline</option>' + 
										'<option value="stretch">Stretch</option>';

	var bootstrap_options_display = '<option value="">None</option>' + 
									'<option value="row">Row</option>' + 
									'<option value="d-flex">D-Flex</option>' + 
									'<option value="d-flex flex-row">D-Flex Flex-Row</option>' + 
									'<option value="d-flex flex-row-reverse">D-Flex Flex-Row-Reverse</option>' + 
									'<option value="d-flex flex-column">D-Flex Flex-Column</option>' + 
									'<option value="d-flex flex-column-reverse">D-Flex Flex-Column-Reverse</option>';

	var bootstrap_options_display_sm = 	'<option value="">None</option>' + 
										'<option value="d-flex flex-sm-row">D-Flex Flex-SM-Row</option>' + 
										'<option value="d-flex flex-sm-row-reverse">D-Flex Flex-SM-Row-Reverse</option>' + 
										'<option value="d-flex flex-sm-column">D-Flex Flex-SM-Column</option>' + 
										'<option value="d-flex flex-sm-column-reverse">D-Flex Flex-SM-Column-Reverse</option>';

	var bootstrap_options_display_md = 	'<option value="">None</option>' + 
										'<option value="d-flex flex-md-row">D-Flex Flex-MD-Row</option>' + 
										'<option value="d-flex flex-md-row-reverse">D-Flex Flex-MD-Row-Reverse</option>' + 
										'<option value="d-flex flex-md-column">D-Flex Flex-MD-Column</option>' + 
										'<option value="d-flex flex-md-column-reverse">D-Flex Flex-MD-Column-Reverse</option>';

	var bootstrap_options_display_lg = 	'<option value="">None</option>' + 
										'<option value="d-flex flex-lg-row">D-Flex Flex-LG-Row</option>' + 
										'<option value="d-flex flex-lg-row-reverse">D-Flex Flex-LG-Row-Reverse</option>' + 
										'<option value="d-flex flex-lg-column">D-Flex Flex-LG-Column</option>' + 
										'<option value="d-flex flex-lg-column-reverse">D-Flex Flex-LG-Column-Reverse</option>';

	var bootstrap_options_display_xl = 	'<option value="">None</option>' + 
										'<option value="d-flex flex-xl-row">D-Flex Flex-XL-Row</option>' + 
										'<option value="d-flex flex-xl-row-reverse">D-Flex Flex-XL-Row-Reverse</option>' + 
										'<option value="d-flex flex-xl-column">D-Flex Flex-XL-Column</option>' + 
										'<option value="d-flex flex-xl-column-reverse">D-Flex Flex-XL-Column-Reverse</option>';

	var bootstrap_options_d = 	'<option value="">None</option>' + 
								'<option value="d-none">D-None</option>' + 
								'<option value="d-inline">D-Inline</option>' + 
								'<option value="d-inline-block">D-Inline-Block</option>' + 
								'<option value="d-block">D-Block</option>' + 
								'<option value="d-table">D-Table</option>' + 
								'<option value="d-table-row">D-Table-Row</option>' + 
								'<option value="d-table-col">D-Table-Col</option>' + 
								'<option value="d-inline-flex">D-Inline-Flex</option>';

	var bootstrap_options_d_sm = 	'<option value="">None</option>' + 
									'<option value="d-sm-none">D-SM-None</option>' + 
									'<option value="d-sm-inline">D-SM-Inline</option>' + 
									'<option value="d-sm-inline-block">D-SM-Inline-Block</option>' + 
									'<option value="d-sm-block">D-SM-Block</option>' + 
									'<option value="d-sm-table">D-SM-Table</option>' + 
									'<option value="d-sm-table-row">D-SM-Table-Row</option>' + 
									'<option value="d-sm-table-col">D-SM-Table-Col</option>' + 
									'<option value="d-sm-inline-flex">D-SM-Inline-Flex</option>';

	var bootstrap_options_d_md = 	'<option value="">None</option>' + 
									'<option value="d-md-none">D-MD-None</option>' + 
									'<option value="d-md-inline">D-MD-Inline</option>' + 
									'<option value="d-md-inline-block">D-MD-Inline-Block</option>' + 
									'<option value="d-md-block">D-MD-Block</option>' + 
									'<option value="d-md-table">D-MD-Table</option>' + 
									'<option value="d-md-table-row">D-MD-Table-Row</option>' + 
									'<option value="d-md-table-col">D-MD-Table-Col</option>' + 
									'<option value="d-md-inline-flex">D-MD-Inline-Flex</option>';

	var bootstrap_options_d_lg = 	'<option value="">None</option>' + 
									'<option value="d-lg-none">D-LG-None</option>' + 
									'<option value="d-lg-inline">D-LG-Inline</option>' + 
									'<option value="d-lg-inline-block">D-LG-Inline-Block</option>' + 
									'<option value="d-lg-block">D-LG-Block</option>' + 
									'<option value="d-lg-table">D-LG-Table</option>' + 
									'<option value="d-lg-table-row">D-LG-Table-Row</option>' + 
									'<option value="d-lg-table-col">D-LG-Table-Col</option>' + 
									'<option value="d-lg-inline-flex">D-LG-Inline-Flex</option>';

	var bootstrap_options_d_xl = 	'<option value="">None</option>' + 
									'<option value="d-xl-none">D-XL-None</option>' + 
									'<option value="d-xl-inline">D-XL-Inline</option>' + 
									'<option value="d-xl-inline-block">D-XL-Inline-Block</option>' + 
									'<option value="d-xl-block">D-XL-Block</option>' + 
									'<option value="d-xl-table">D-XL-Table</option>' + 
									'<option value="d-xl-table-row">D-XL-Table-Row</option>' + 
									'<option value="d-xl-table-col">D-XL-Table-Col</option>' + 
									'<option value="d-xl-inline-flex">D-XL-Inline-Flex</option>';

	var bootstrap_options_d_print = '<option value="">None</option>' + 
									'<option value="d-print-none">D-Print-None</option>' + 
									'<option value="d-print-inline">D-Print-Inline</option>' + 
									'<option value="d-print-inline-block">D-Print-Inline-Block</option>' + 
									'<option value="d-print-block">D-Print-Block</option>' + 
									'<option value="d-print-table">D-Print-Table</option>' + 
									'<option value="d-print-table-row">D-Print-Table-Row</option>' + 
									'<option value="d-print-table-col">D-Print-Table-Col</option>' + 
									'<option value="d-print-inline-flex">D-Print-Inline-Flex</option>';

	var bootstrap_options_input_types = '<option value="text">Text</option>' + 
										'<option value="password">Password</option>' + 
										'<option value="submit">Submit</option>' + 
										'<option value="reset">Reset</option>' + 
										'<option value="radio">Radio</option>' + 
										'<option value="checkbox">Checkbox</option>' + 
										'<option value="button">Button</option>' + 
										'<option value="color">Color</option>' + 
										'<option value="date">Date</option>' + 
										'<option value="datetime-local">Datetime-Local</option>' + 
										'<option value="email">Email</option>' + 
										'<option value="month">Month</option>' + 
										'<option value="number">Number</option>' + 
										'<option value="range">Range</option>' + 
										'<option value="search">Search</option>' + 
										'<option value="tel">Tel</option>' + 
										'<option value="time">Time</option>' + 
										'<option value="url">Url</option>' + 
										'<option value="week">Week</option>' + 
										'<option value="file">File</option>' + 
										'<option value="hidden">Hidden</option>';

	var bootstrap_options_button_types = 	'<option value="button">Button</option>' + 
											'<option value="submit">Submit</option>' + 
											'<option value="reset">Reset</option>';

	var bootstrap_options_theadcolor = 	'<option value="">None</option>' + 
										'<option value="light">Light</option>' + 
										'<option value="dark">Dark</option>';

	var bootstrap_options_text_align = 	'<option value="">None</option>' + 
										'<option value="left">Left</option>' + 
										'<option value="center">Center</option>' + 
										'<option value="right">Right</option>' + 
										'<option value="justify">Justify</option>';

	var bootstrap_forms_options_types = '<option value="text">Text</option>' + 
										'<option value="textarea">Textarea</option>' + 
										'<option value="search">Search</option>' + 
										'<option value="password">Password</option>' + 
										'<option value="tel">Tel</option>' + 
										'<option value="url">Url</option>' + 
										'<option value="email">Email</option>' + 
										'<option value="date">Date</option>' + 
										'<option value="datetime-local">Datetime-Local</option>' + 
										'<option value="week">Week</option>' + 
										'<option value="month">Month</option>' + 
										'<option value="time">Time</option>' + 
										'<option value="number">Number</option>' + 
										'<option value="range">Range</option>' + 
										'<option value="radio">Radio</option>' + 
										'<option value="checkbox">Checkbox</option>' + 
										'<option value="select">Select</option>' + 
										'<option value="file">File</option>' + 
										'<option value="color">Color</option>' + 
										'<option value="hidden">Hidden</option>';

	var bootstrap_options_direction = 	'<option value="top">Top</option>' + 
										'<option value="right">Right</option>' + 
										'<option value="bottom">Bottom</option>' + 
										'<option value="left">Left</option>';

	var bootstrap_components_modal_forms = {
		'container': {
			'title': 'Container', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-background">Background</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-background" id="bootstrap-layout-containers-container-background">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-border-color" id="bootstrap-layout-containers-container-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-border-types" id="bootstrap-layout-containers-container-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-border-radius" id="bootstrap-layout-containers-container-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-layout-containers-container-content" id="bootstrap-layout-containers-container-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-layout-containers-container-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var background = jQuery('#bootstrap-layout-containers-container-background').val();
				var border_color = jQuery('#bootstrap-layout-containers-container-border-color').val();
				var border_types = jQuery('#bootstrap-layout-containers-container-border-types').val();
				var border_radius = jQuery('#bootstrap-layout-containers-container-border-radius').val();
				var class_bgcolor = background != '' ? ' bg-' + background : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_color = border_color != '' && border_types != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' && border_types != '' ? ' ' + border_radius : '';

				return 	'<div class="container' + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">\n\t' + jQuery('#bootstrap-layout-containers-container-content').val() + '\n</div>\n';
			}
		}, 
		'container_fluid': {
			'title': 'Container-Fluid', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-fluid-background">Background</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-fluid-background" id="bootstrap-layout-containers-container-fluid-background">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-fluid-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-fluid-border-color" id="bootstrap-layout-containers-container-fluid-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-fluid-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-fluid-border-types" id="bootstrap-layout-containers-container-fluid-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-fluid-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-layout-containers-container-fluid-border-radius" id="bootstrap-layout-containers-container-fluid-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-containers-container-fluid-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-layout-containers-container-fluid-content" id="bootstrap-layout-containers-container-fluid-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-layout-containers-container-fluid-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var background = jQuery('#bootstrap-layout-containers-container-fluid-background').val();
				var border_color = jQuery('#bootstrap-layout-containers-container-fluid-border-color').val();
				var border_types = jQuery('#bootstrap-layout-containers-container-fluid-border-types').val();
				var border_radius = jQuery('#bootstrap-layout-containers-container-fluid-border-radius').val();
				var class_bgcolor = background != '' ? ' bg-' + background : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_color = border_color != '' && border_types != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' && border_types != '' ? ' ' + border_radius : '';

				return 	'<div class="container-fluid' + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">\n\t' + jQuery('#bootstrap-layout-containers-container-fluid-content').val() + '\n</div>\n';
			}
		}, 
		'row': {
			'title': 'Row', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-display">Display</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-display" id="bootstrap-layout-grid-row-display">' + bootstrap_options_display + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-display-sm">Display-SM</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-display-sm" id="bootstrap-layout-grid-row-display-sm">' + bootstrap_options_display_sm + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-display-md">Display-MD</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-display-md" id="bootstrap-layout-grid-row-display-md">' + bootstrap_options_display_md + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-display-lg">Display-LG</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-display-lg" id="bootstrap-layout-grid-row-display-lg">' + bootstrap_options_display_lg + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-display-xl">Display-XL</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-display-xl" id="bootstrap-layout-grid-row-display-xl">' + bootstrap_options_display_xl + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-background">Background</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-background" id="bootstrap-layout-grid-row-background">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-border-color" id="bootstrap-layout-grid-row-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-border-types" id="bootstrap-layout-grid-row-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-border-radius" id="bootstrap-layout-grid-row-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-justify-content">Justify-Content</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-justify-content" id="bootstrap-layout-grid-row-justify-content">' + bootstrap_options_justify_content + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-justify-content-sm">Justify-Content-SM</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-justify-content-sm" id="bootstrap-layout-grid-row-justify-content-sm">' + bootstrap_options_justify_content + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-justify-content-md">Justify-Content-MD</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-justify-content-md" id="bootstrap-layout-grid-row-justify-content-md">' + bootstrap_options_justify_content + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-justify-content-lg">Justify-Content-LG</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-justify-content-lg" id="bootstrap-layout-grid-row-justify-content-lg">' + bootstrap_options_justify_content + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-justify-content-xl">Justify-Content-XL</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-justify-content-xl" id="bootstrap-layout-grid-row-justify-content-xl">' + bootstrap_options_justify_content + '</select></div>' + 
					
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-items">Align-Items</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-items" id="bootstrap-layout-grid-row-align-items">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-items-sm">Align-Items-SM</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-items-sm" id="bootstrap-layout-grid-row-align-items-sm">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-items-md">Align-Items-MD</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-items-md" id="bootstrap-layout-grid-row-align-items-md">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-items-lg">Align-Items-LG</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-items-lg" id="bootstrap-layout-grid-row-align-items-lg">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-items-xl">Align-Items-XL</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-items-xl" id="bootstrap-layout-grid-row-align-items-xl">' + bootstrap_options_align_items + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-self">Align-Self</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-self" id="bootstrap-layout-grid-row-align-self">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-self-sm">Align-Self-SM</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-self-sm" id="bootstrap-layout-grid-row-align-self-sm">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-self-md">Align-Self-MD</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-self-md" id="bootstrap-layout-grid-row-align-self-md">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-self-lg">Align-Self-LG</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-self-lg" id="bootstrap-layout-grid-row-align-self-lg">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-align-self-xl">Align-Self-XL</label><div class="col-sm-6"><select name="bootstrap-layout-grid-row-align-self-xl" id="bootstrap-layout-grid-row-align-self-xl">' + bootstrap_options_align_items + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-row-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-layout-grid-row-content" id="bootstrap-layout-grid-row-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-layout-grid-row-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var display = jQuery('#bootstrap-layout-grid-row-display').val();
				var display_sm = jQuery('#bootstrap-layout-grid-row-display-sm').val();
				var display_md = jQuery('#bootstrap-layout-grid-row-display-md').val();
				var display_lg = jQuery('#bootstrap-layout-grid-row-display-lg').val();
				var display_xl = jQuery('#bootstrap-layout-grid-row-display-xl').val();

				var background = jQuery('#bootstrap-layout-grid-row-background').val();
				var border_color = jQuery('#bootstrap-layout-grid-row-border-color').val();
				var border_types = jQuery('#bootstrap-layout-grid-row-border-types').val();
				var border_radius = jQuery('#bootstrap-layout-grid-row-border-radius').val();

				var justify_content = jQuery('#bootstrap-layout-grid-row-justify-content').val();
				var justify_content_sm = jQuery('#bootstrap-layout-grid-row-justify-content-sm').val();
				var justify_content_md = jQuery('#bootstrap-layout-grid-row-justify-content-md').val();
				var justify_content_lg = jQuery('#bootstrap-layout-grid-row-justify-content-lg').val();
				var justify_content_xl = jQuery('#bootstrap-layout-grid-row-justify-content-xl').val();

				var align_items = jQuery('#bootstrap-layout-grid-row-align-items').val();
				var align_items_sm = jQuery('#bootstrap-layout-grid-row-align-items-sm').val();
				var align_items_md = jQuery('#bootstrap-layout-grid-row-align-items-md').val();
				var align_items_lg = jQuery('#bootstrap-layout-grid-row-align-items-lg').val();
				var align_items_xl = jQuery('#bootstrap-layout-grid-row-align-items-xl').val();

				var align_self = jQuery('#bootstrap-layout-grid-row-align-self').val();
				var align_self_sm = jQuery('#bootstrap-layout-grid-row-align-self-sm').val();
				var align_self_md = jQuery('#bootstrap-layout-grid-row-align-self-md').val();
				var align_self_lg = jQuery('#bootstrap-layout-grid-row-align-self-lg').val();
				var align_self_xl = jQuery('#bootstrap-layout-grid-row-align-self-xl').val();

				var class_display = display != '' ? display : '';
				var class_display_sm = display_sm != '' ? display_sm : '';
				var class_display_md = display_md != '' ? display_md : '';
				var class_display_lg = display_lg != '' ? display_lg : '';
				var class_display_xl = display_xl != '' ? display_xl : '';

				var class_bgcolor = background != '' ? ' bg-' + background : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_color = border_color != '' && border_types != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' && border_types != '' ? ' ' + border_radius : '';

				var class_justify_content = justify_content != '' ? ' justify-content-' + justify_content : '';
				var class_justify_content_sm = justify_content_sm != '' ? ' justify-content-sm-' + justify_content_sm : '';
				var class_justify_content_md = justify_content_md != '' ? ' justify-content-md-' + justify_content_md : '';
				var class_justify_content_lg = justify_content_lg != '' ? ' justify-content-lg-' + justify_content_lg : '';
				var class_justify_content_xl = justify_content_xl != '' ? ' justify-content-xl-' + justify_content_xl : '';
				
				var class_align_items = align_items != '' ? ' align-items-' + align_items : '';
				var class_align_items_sm = align_items_sm != '' ? ' align-items-sm-' + align_items_sm : '';
				var class_align_items_md = align_items_md != '' ? ' align-items-md-' + align_items_md : '';
				var class_align_items_lg = align_items_lg != '' ? ' align-items-lg-' + align_items_lg : '';
				var class_align_items_xl = align_items_xl != '' ? ' align-items-xl-' + align_items_xl : '';

				var class_align_self = align_self != '' ? ' align-self-' + align_self : '';
				var class_align_self_sm = align_self_sm != '' ? ' align-self-sm-' + align_self_sm : '';
				var class_align_self_md = align_self_md != '' ? ' align-self-md-' + align_self_md : '';
				var class_align_self_lg = align_self_lg != '' ? ' align-self-lg-' + align_self_lg : '';
				var class_align_self_xl = align_self_xl != '' ? ' align-self-xl-' + align_self_xl : '';

				return 	'<div class="' + class_display + class_display_sm + class_display_md + class_display_lg + class_display_xl + class_bgcolor + class_border_types + class_border_color + class_border_radius + class_justify_content + class_justify_content_sm + class_justify_content_md + class_justify_content_lg + class_justify_content_xl + class_align_items + class_align_items_sm + class_align_items_md + class_align_items_lg + class_align_items_xl + class_align_self + class_align_self_sm + class_align_self_md + class_align_self_lg + class_align_self_xl + '">\n\t' + jQuery('#bootstrap-layout-grid-row-content').val() + '\n</div>\n';
			}
		}, 
		'col': {
			'title': 'Col', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-col">Col-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-col" id="bootstrap-layout-grid-col-col">' + bootstrap_options_1_12 + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-col-sm">Col-sm-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-col-sm" id="bootstrap-layout-grid-col-col-sm">' + bootstrap_options_1_12 + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-col-md">Col-md-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-col-md" id="bootstrap-layout-grid-col-col-md">' + bootstrap_options_1_12 + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-col-lg">Col-lg-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-col-lg" id="bootstrap-layout-grid-col-col-lg">' + bootstrap_options_1_12 + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-col-xl">Col-xl-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-col-xl" id="bootstrap-layout-grid-col-col-xl">' + bootstrap_options_1_12 + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-background">Background</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-background" id="bootstrap-layout-grid-col-background">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-border-color" id="bootstrap-layout-grid-col-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-border-types" id="bootstrap-layout-grid-col-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-border-radius" id="bootstrap-layout-grid-col-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-align-self">Align-Self</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-align-self" id="bootstrap-layout-grid-col-align-self">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-align-self-sm">Align-Self-SM</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-align-self-sm" id="bootstrap-layout-grid-col-align-self-sm">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-align-self-md">Align-Self-MD</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-align-self-md" id="bootstrap-layout-grid-col-align-self-md">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-align-self-lg">Align-Self-LG</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-align-self-lg" id="bootstrap-layout-grid-col-align-self-lg">' + bootstrap_options_align_items + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-align-self-xl">Align-Self-XL</label><div class="col-sm-6"><select name="bootstrap-layout-grid-col-align-self-xl" id="bootstrap-layout-grid-col-align-self-xl">' + bootstrap_options_align_items + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-col-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-layout-grid-col-content" id="bootstrap-layout-grid-col-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-layout-grid-col-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var col = jQuery('#bootstrap-layout-grid-col-col').val();
				var col_sm = jQuery('#bootstrap-layout-grid-col-col-sm').val();
				var col_md = jQuery('#bootstrap-layout-grid-col-col-md').val();
				var col_lg = jQuery('#bootstrap-layout-grid-col-col-lg').val();
				var col_xl = jQuery('#bootstrap-layout-grid-col-col-xl').val();

				var background = jQuery('#bootstrap-layout-grid-col-background').val();
				var border_color = jQuery('#bootstrap-layout-grid-col-border-color').val();
				var border_types = jQuery('#bootstrap-layout-grid-col-border-types').val();
				var border_radius = jQuery('#bootstrap-layout-grid-col-border-radius').val();

				var align_self = jQuery('#bootstrap-layout-grid-col-align-self').val();
				var align_self_sm = jQuery('#bootstrap-layout-grid-col-align-self-sm').val();
				var align_self_md = jQuery('#bootstrap-layout-grid-col-align-self-md').val();
				var align_self_lg = jQuery('#bootstrap-layout-grid-col-align-self-lg').val();
				var align_self_xl = jQuery('#bootstrap-layout-grid-col-align-self-xl').val();

				var class_col = col != '' ? 'col-' + col : '';
				var class_col_sm = col_sm != '' ? ' col-sm-' + col_sm : '';
				var class_col_md = col_md != '' ? ' col-md-' + col_md : '';
				var class_col_lg = col_lg != '' ? ' col-lg-' + col_lg : '';
				var class_col_xl = col_xl != '' ? ' col-xl-' + col_xl : '';
				var class_col_all = col != '' && col_sm != '' && col_md != '' && col_lg != '' && col_xl != '' ? class_col + class_col_sm + class_col_md + class_col_lg + class_col_xl : 'col';
				
				var class_bgcolor = background != '' ? ' bg-' + background : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_color = border_color != '' && border_types != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' && border_types != '' ? ' ' + border_radius : '';

				var class_align_self = align_self != '' ? ' align-self-' + align_self : '';
				var class_align_self_sm = align_self_sm != '' ? ' align-self-sm-' + align_self_sm : '';
				var class_align_self_md = align_self_md != '' ? ' align-self-md-' + align_self_md : '';
				var class_align_self_lg = align_self_lg != '' ? ' align-self-lg-' + align_self_lg : '';
				var class_align_self_xl = align_self_xl != '' ? ' align-self-xl-' + align_self_xl : '';

				return 	'<div class="' + class_col_all + class_bgcolor + class_border_types + class_border_color + class_border_radius + class_align_self + class_align_self_sm + class_align_self_md + class_align_self_lg + class_align_self_xl + '">\n\t' + jQuery('#bootstrap-layout-grid-col-content').val() + '\n</div>\n';
			}
		}, 
		'w_100': {
			'title': 'W-100', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100_class">W-100|empty</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-class" id="bootstrap-layout-grid-w-100-class"><option value="">None</option><option value="w-100">W-100</option></select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d">D-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d" id="bootstrap-layout-grid-w-100-d">' + bootstrap_options_d + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d-sm">D-sm-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d-sm" id="bootstrap-layout-grid-w-100-d-sm">' + bootstrap_options_d_sm + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d-md">D-md-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d-md" id="bootstrap-layout-grid-w-100-d-md">' + bootstrap_options_d_md + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d-lg">D-lg-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d-lg" id="bootstrap-layout-grid-w-100-d-lg">' + bootstrap_options_d_lg + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d-xl">D-xl-</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d-xl" id="bootstrap-layout-grid-w-100-d-xl">' + bootstrap_options_d_xl + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-d-print">D-Print</label><div class="col-sm-6"><select name="bootstrap-layout-grid-w-100-d-print" id="bootstrap-layout-grid-w-100-d-print">' + bootstrap_options_d_print + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-layout-grid-w-100-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-layout-grid-w-100-content" id="bootstrap-layout-grid-w-100-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-layout-grid-w-100-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var w_100 = jQuery('#bootstrap-layout-grid-w-100-class').val();

				var d = jQuery('#bootstrap-layout-grid-w-100-d').val();
				var d_sm = jQuery('#bootstrap-layout-grid-w-100-d-sm').val();
				var d_md = jQuery('#bootstrap-layout-grid-w-100-d-md').val();
				var d_lg = jQuery('#bootstrap-layout-grid-w-100-d-lg').val();
				var d_xl = jQuery('#bootstrap-layout-grid-w-100-d-xl').val();

				var d_print = jQuery('#bootstrap-layout-grid-w-100-d-print').val();

				var class_w_100 = w_100 != '' ? w_100 : '';

				var class_d = d != '' ? ' ' + d : '';
				var class_d_sm = d_sm != '' ? ' ' + d_sm : '';
				var class_d_md = d_md != '' ? ' ' + d_md : '';
				var class_d_lg = d_lg != '' ? ' ' + d_lg : '';
				var class_d_xl = d_xl != '' ? ' ' + d_xl : '';

				var class_d_print = d_print != '' ? ' ' + d_print : '';

				return 	'<div class="' + class_w_100 + class_d + class_d_sm + class_d_md + class_d_lg + class_d_xl + class_d_print + '">' + jQuery('#bootstrap-layout-grid-w-100-content').val() + '</div>\n';
			}
		}, 
		'h1_6': {
			'title': 'H1-6', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-tag">H1-6</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-tag" id="bootstrap-content-h1-6-tag"><option value="h1">H1</option><option value="h2">H2</option><option value="h3">H3</option><option value="h4">H4</option><option value="h5">H5</option><option value="h6">H6</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-color" id="bootstrap-content-h1-6-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-bgcolor" id="bootstrap-content-h1-6-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-border-color" id="bootstrap-content-h1-6-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-border-types" id="bootstrap-content-h1-6-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-h1-6-border-radius" id="bootstrap-content-h1-6-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-h1-6-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-content-h1-6-content" id="bootstrap-content-h1-6-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-h1-6-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var h1_6 = jQuery('#bootstrap-content-h1-6-tag').val();
				var color = jQuery('#bootstrap-content-h1-6-color').val();
				var bgcolor = jQuery('#bootstrap-content-h1-6-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-h1-6-border-color').val();
				var border_types = jQuery('#bootstrap-content-h1-6-border-types').val();
				var border_radius = jQuery('#bootstrap-content-h1-6-border-radius').val();

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<' + h1_6 + ' class="' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-h1-6-content').val() + '</' + h1_6 + '>\n';
			}
		}, 
		'ul_ol': {
			'title': 'UL|OL', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-tag">UL|OL</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-tag" id="bootstrap-content-ul-ol-tag"><option value="ul">UL</option><option value="ol">OL</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-color" id="bootstrap-content-ul-ol-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-bgcolor" id="bootstrap-content-ul-ol-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-border-color" id="bootstrap-content-ul-ol-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-border-types" id="bootstrap-content-ul-ol-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-border-radius" id="bootstrap-content-ul-ol-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-list-style">List-Style</label><div class="col-sm-6"><select name="bootstrap-content-ul-ol-list-style" id="bootstrap-content-ul-ol-list-style">' + bootstrap_options_list_style + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ul-ol-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-ul-ol-content" id="bootstrap-content-ul-ol-content" cols="20" rows="8" placeholder="Content-1\r\nContent-2\r\n..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-ul-ol-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var ul_ol = jQuery('#bootstrap-content-ul-ol-tag').val();
				var color = jQuery('#bootstrap-content-ul-ol-color').val();
				var bgcolor = jQuery('#bootstrap-content-ul-ol-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-ul-ol-border-color').val();
				var border_types = jQuery('#bootstrap-content-ul-ol-border-types').val();
				var border_radius = jQuery('#bootstrap-content-ul-ol-border-radius').val();
				var content = jQuery('#bootstrap-content-ul-ol-content').val();
				var content_arr = content.split('\n');
				var content_li = '<li>' + content_arr.join('</li><li>') + '</li>';
				var list_style = jQuery('#bootstrap-content-ul-ol-list-style').val();

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';
				var style_list_style = list_style != '' ? ' style="list-style: ' + list_style + '"' : '';

				return 	'<' + ul_ol + style_list_style + ' class="' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + content_li + '</' + ul_ol + '>\n';
			}
		}, 
		'dl': {
			'title': 'DL', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-dl-color" id="bootstrap-content-dl-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-dl-bgcolor" id="bootstrap-content-dl-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-dl-border-color" id="bootstrap-content-dl-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-dl-border-types" id="bootstrap-content-dl-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-dl-border-radius" id="bootstrap-content-dl-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-dt-width">DT - Width</label><div class="col-sm-6"><input type="text" name="bootstrap-content-dl-dt-width" id="bootstrap-content-dl-dt-width" value="120px" placeholder="120px" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-dl-content">Content - DT & DD</label><div class="col-sm-6"><textarea name="bootstrap-content-dl-content" id="bootstrap-content-dl-content" cols="20" rows="8" placeholder="Label-1|Content-1\r\nLabel-2|Content-2\r\n...|..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-dl-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-dl-color').val();
				var bgcolor = jQuery('#bootstrap-content-dl-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-dl-border-color').val();
				var border_types = jQuery('#bootstrap-content-dl-border-types').val();
				var border_radius = jQuery('#bootstrap-content-dl-border-radius').val();
				var dt_width = jQuery('#bootstrap-content-dl-dt-width').val();
				var content = jQuery('#bootstrap-content-dl-content').val();
				var content_arr = content.split('\n');
				var content_str = '';
				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					content_str += '<dt style="float: left;margin-right: 6px;width: ' + dt_width + '">' + keyArr[0] + '</dt><dd>' + keyArr[1] + '</dd>\n';
				}

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<dl class="dl-horizontal' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + content_str + '</dl>\n';
			}
		}, 
		'pre': {
			'title': 'Pre', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-pre-color" id="bootstrap-content-pre-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-pre-bgcolor" id="bootstrap-content-pre-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-pre-border-color" id="bootstrap-content-pre-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-pre-border-types" id="bootstrap-content-pre-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-pre-border-radius" id="bootstrap-content-pre-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-pre-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-pre-content" id="bootstrap-content-pre-content" cols="20" rows="8" placeholder="<code>\n\tContent...\n\t...\n</code>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-pre-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-pre-color').val();
				var bgcolor = jQuery('#bootstrap-content-pre-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-pre-border-color').val();
				var border_types = jQuery('#bootstrap-content-pre-border-types').val();
				var border_radius = jQuery('#bootstrap-content-pre-border-radius').val();

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<pre class="' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-pre-content').val() + '</pre>\n';
			}
		}, 
		'form_fieldset': {
			'title': 'Form - Fieldset', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-fieldset-color" id="bootstrap-content-form-fieldset-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-fieldset-bgcolor" id="bootstrap-content-form-fieldset-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-fieldset-border-color" id="bootstrap-content-form-fieldset-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-fieldset-border-types" id="bootstrap-content-form-fieldset-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-fieldset-border-radius" id="bootstrap-content-form-fieldset-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-fieldset-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-form-fieldset-content" id="bootstrap-content-form-fieldset-content" cols="20" rows="8" placeholder="<legend>\n\tContent...\n\t...\n</legend>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-fieldset-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-form-fieldset-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-fieldset-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-fieldset-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-fieldset-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-fieldset-border-radius').val();

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<fieldset style="padding: 15px" class="' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-form-fieldset-content').val() + '</fieldset>\n';
			}
		}, 
		'form_legend': {
			'title': 'Form - Legend', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-legend-color" id="bootstrap-content-form-legend-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-legend-bgcolor" id="bootstrap-content-form-legend-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-legend-border-color" id="bootstrap-content-form-legend-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-legend-border-types" id="bootstrap-content-form-legend-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-legend-border-radius" id="bootstrap-content-form-legend-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-legend-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-form-legend-content" id="bootstrap-content-form-legend-content" cols="20" rows="8" placeholder="<div>\n\tContent...\n\t...\n</div>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-legend-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-form-legend-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-legend-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-legend-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-legend-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-legend-border-radius').val();

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<legend style="margin-left: 15px;width: 120px" class="' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-form-legend-content').val() + '</legend>\n';
			}
		}, 
		'form_label': {
			'title': 'Form - Label', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-label-color" id="bootstrap-content-form-label-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-label-bgcolor" id="bootstrap-content-form-label-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-label-border-color" id="bootstrap-content-form-label-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-label-border-types" id="bootstrap-content-form-label-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-label-border-radius" id="bootstrap-content-form-label-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-for">For</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-label-for" id="bootstrap-content-form-label-for" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-label-style" id="bootstrap-content-form-label-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-label-class" id="bootstrap-content-form-label-class" value="" placeholder="col-form-label-lg" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-label-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-form-label-content" id="bootstrap-content-form-label-content" cols="20" rows="8" placeholder="Firstname..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-label-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-form-label-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-label-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-label-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-label-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-label-border-radius').val();
				var label_for = jQuery('#bootstrap-content-form-label-for').val();
				var style = jQuery('#bootstrap-content-form-label-style').val();
				var label_class = jQuery('#bootstrap-content-form-label-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<label for="' + label_for + '"' + attr_style + ' class="' + label_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-form-label-content').val() + '</label>\n';
			}
		}, 
		'form_input': {
			'title': 'Form - Input', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-type">Type</label><div class="col-sm-6"><select name="bootstrap-content-form-input-type" id="bootstrap-content-form-input-type">' + bootstrap_options_input_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-name" id="bootstrap-content-form-input-name" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-input-color" id="bootstrap-content-form-input-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-input-bgcolor" id="bootstrap-content-form-input-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-input-border-color" id="bootstrap-content-form-input-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-input-border-types" id="bootstrap-content-form-input-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-input-border-radius" id="bootstrap-content-form-input-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-style" id="bootstrap-content-form-input-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-class" id="bootstrap-content-form-input-class" value="" placeholder="form-control-lg" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-size">Size</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-size" id="bootstrap-content-form-input-size" value="" placeholder="20" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-maxlength">Maxlength</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-maxlength" id="bootstrap-content-form-input-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-min">Min</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-min" id="bootstrap-content-form-input-min" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-max">Max</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-max" id="bootstrap-content-form-input-max" value="" placeholder="16" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-step">Step</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-step" id="bootstrap-content-form-input-step" value="" placeholder="0.5" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-pattern">Pattern</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-pattern" id="bootstrap-content-form-input-pattern" value="" placeholder="[A-Za-z]{3}" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-placeholder" id="bootstrap-content-form-input-placeholder" value="" placeholder="..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-onclick">Click</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-onclick" id="bootstrap-content-form-input-onclick" value="" placeholder="alert(this.value)" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-onmouseover">MouseOver</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-onmouseover" id="bootstrap-content-form-input-onmouseover" value="" placeholder="this.style.border=\'1px solid #ff0000\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-onmouseout">MouseOut</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-onmouseout" id="bootstrap-content-form-input-onmouseout" value="" placeholder="this.style.border=\'1px solid #00ff00\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-tabindex">Tabindex</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-tabindex" id="bootstrap-content-form-input-tabindex" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-aria-label">Aria-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-aria-label" id="bootstrap-content-form-input-aria-label" value="" placeholder="User input..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-aria-describedby">Aria-Describedby</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-input-aria-describedby" id="bootstrap-content-form-input-aria-describedby" value="" placeholder="span_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-input-disabled" id="bootstrap-content-form-input-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-input-readonly" id="bootstrap-content-form-input-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-input-required" id="bootstrap-content-form-input-required" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-input-content">Value</label><div class="col-sm-6"><textarea name="bootstrap-content-form-input-content" id="bootstrap-content-form-input-content" cols="20" rows="8" placeholder="Firstname..." ondblclick="this.value=this.placeholder"></textarea></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-input-name').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var input_type = jQuery('#bootstrap-content-form-input-type').val();
				var name = jQuery('#bootstrap-content-form-input-name').val();

				var color = jQuery('#bootstrap-content-form-input-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-input-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-input-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-input-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-input-border-radius').val();

				var style = jQuery('#bootstrap-content-form-input-style').val();
				var input_class = jQuery('#bootstrap-content-form-input-class').val();

				var size = jQuery('#bootstrap-content-form-input-size').val();
				var maxlength = jQuery('#bootstrap-content-form-input-maxlength').val();
				var min = jQuery('#bootstrap-content-form-input-min').val();
				var max = jQuery('#bootstrap-content-form-input-max').val();
				var step = jQuery('#bootstrap-content-form-input-step').val();
				var pattern = jQuery('#bootstrap-content-form-input-pattern').val();
				var placeholder = jQuery('#bootstrap-content-form-input-placeholder').val();
				var click = jQuery('#bootstrap-content-form-input-onclick').val();
				var mouseover = jQuery('#bootstrap-content-form-input-onmouseover').val();
				var mouseout = jQuery('#bootstrap-content-form-input-onmouseout').val();
				var tabindex = jQuery('#bootstrap-content-form-input-tabindex').val();
				var aria_label = jQuery('#bootstrap-content-form-input-aria-label').val();
				var aria_describedby = jQuery('#bootstrap-content-form-input-aria-describedby').val();
				var disabled = jQuery('#bootstrap-content-form-input-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-content-form-input-readonly').attr("checked");
				var required = jQuery('#bootstrap-content-form-input-required').attr("checked");

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var attr_size = size != '' ? ' size="' + size + '"' : '';
				var attr_maxlength = maxlength != '' ? ' maxlength="' + maxlength + '"' : '';
				var attr_min = min != '' ? ' min="' + min + '"' : '';
				var attr_max = max != '' ? ' max="' + max + '"' : '';
				var attr_step = step != '' ? ' step="' + step + '"' : '';
				var attr_pattern = pattern != '' ? ' pattern="' + pattern + '"' : '';
				var attr_placeholder = placeholder != '' ? ' placeholder="' + placeholder + '"' : '';
				var attr_onclick = click != '' ? ' onclick="' + click + '"' : '';
				var attr_onmouseover = mouseover != '' ? ' onmouseover="' + mouseover + '"' : '';
				var attr_onmouseout = mouseout != '' ? ' onmouseout="' + mouseout + '"' : '';
				var attr_tabindex = tabindex != '' ? ' tabindex="' + tabindex + '"' : '';
				var attr_aria_label = aria_label != '' ? ' aria-label="' + aria_label + '"' : '';
				var attr_aria_describedby = aria_describedby != '' ? ' aria-describedby="' + aria_describedby + '"' : '';

				var attr_disabled = disabled == 'checked' ? ' disabled="disabled"' : '';
				var attr_readonly = readonly == 'checked' ? ' readonly="readonly"' : '';
				var attr_required = required == 'checked' ? ' required="required"' : '';

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<input type="' + input_type + '" name="' + name + '" id="' + name + '"' + attr_style + attr_size + attr_maxlength + attr_min + attr_max + attr_step + attr_pattern + ' value="' + jQuery('#bootstrap-content-form-input-content').val() + '" class="form-control ' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + ' ' + input_class + '"' + attr_placeholder + attr_onclick + attr_onmouseover + attr_onmouseout + attr_tabindex + attr_aria_label + attr_aria_describedby + attr_disabled + attr_readonly + attr_required + ' />\n';
			}
		}, 
		'select': {
			'title': 'Select', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-name" id="bootstrap-content-form-select-name" value="" placeholder="select_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-select-color" id="bootstrap-content-form-select-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-select-bgcolor" id="bootstrap-content-form-select-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-select-border-color" id="bootstrap-content-form-select-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-select-border-types" id="bootstrap-content-form-select-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-select-border-radius" id="bootstrap-content-form-select-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-style" id="bootstrap-content-form-select-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-class" id="bootstrap-content-form-select-class" value="" placeholder="form-control-lg" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-size">Size</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-size" id="bootstrap-content-form-select-size" value="" placeholder="5" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-onmouseover">MouseOver</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-onmouseover" id="bootstrap-content-form-select-onmouseover" value="" placeholder="this.style.border=\'1px solid #ff0000\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-onmouseout">MouseOut</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-onmouseout" id="bootstrap-content-form-select-onmouseout" value="" placeholder="this.style.border=\'1px solid #00ff00\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-onchange">Change</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-onchange" id="bootstrap-content-form-select-onchange" value="" placeholder="alert(this.value)" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-tabindex">Tabindex</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-select-tabindex" id="bootstrap-content-form-select-tabindex" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-multiple">Multiple</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-select-multiple" id="bootstrap-content-form-select-multiple" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-select-content">Content - Option</label><div class="col-sm-6"><textarea name="bootstrap-content-form-select-content" id="bootstrap-content-form-select-content" cols="20" rows="8" placeholder="Value-1|Option-1|selected\r\nValue-2|Option-2\r\n...|..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-select-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var name = jQuery('#bootstrap-content-form-select-name').val();

				var color = jQuery('#bootstrap-content-form-select-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-select-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-select-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-select-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-select-border-radius').val();

				var style = jQuery('#bootstrap-content-form-select-style').val();
				var input_class = jQuery('#bootstrap-content-form-select-class').val();

				var size = jQuery('#bootstrap-content-form-select-size').val();
				var mouseover = jQuery('#bootstrap-content-form-select-onmouseover').val();
				var mouseout = jQuery('#bootstrap-content-form-select-onmouseout').val();
				var change = jQuery('#bootstrap-content-form-select-onchange').val();
				var tabindex = jQuery('#bootstrap-content-form-select-tabindex').val();

				var multiple = jQuery('#bootstrap-content-form-select-multiple').attr("checked");

				var content = jQuery('#bootstrap-content-form-select-content').val();
				var content_arr = content.split('\n');
				var content_str = '';
				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					var selected = keyArr[2] == 'selected' ? ' selected="selected"' : '';
					content_str += '<option value="' + keyArr[0] + '"' + selected + '>' + keyArr[1] + '</option>\n';
				}

				var attr_style = style != '' ? ' style="' + style + '"' : '';
				var attr_size = size != '' ? ' size="' + size + '"' : '';
				var attr_onmouseover = mouseover != '' ? ' onmouseover="' + mouseover + '"' : '';
				var attr_onmouseout = mouseout != '' ? ' onmouseout="' + mouseout + '"' : '';
				var attr_onchange = change != '' ? ' onchange="' + change + '"' : '';
				var attr_tabindex = tabindex != '' ? ' tabindex="' + tabindex + '"' : '';

				var attr_multiple = multiple == 'checked' ? ' multiple="multiple"' : '';

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<select name="' + name + '" id="' + name + '"' + attr_style + attr_size + attr_onmouseover + attr_onmouseout + attr_onchange + attr_tabindex + attr_multiple + ' class="form-control ' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + ' ' + input_class + '">' + content_str + '</select>\n';
			}
		}, 
		'textarea': {
			'title': 'Textarea', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-name" id="bootstrap-content-form-textarea-name" value="" placeholder="select_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-textarea-color" id="bootstrap-content-form-textarea-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-textarea-bgcolor" id="bootstrap-content-form-textarea-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-textarea-border-color" id="bootstrap-content-form-textarea-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-textarea-border-types" id="bootstrap-content-form-textarea-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-textarea-border-radius" id="bootstrap-content-form-textarea-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-style" id="bootstrap-content-form-textarea-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-class" id="bootstrap-content-form-textarea-class" value="" placeholder="input form-controll" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-cols">Cols</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-cols" id="bootstrap-content-form-textarea-cols" value="" placeholder="40" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-rows">Rows</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-rows" id="bootstrap-content-form-textarea-rows" value="" placeholder="6" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-onmouseover">MouseOver</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-onmouseover" id="bootstrap-content-form-textarea-onmouseover" value="" placeholder="this.style.border=\'1px solid #ff0000\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-onmouseout">MouseOut</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-onmouseout" id="bootstrap-content-form-textarea-onmouseout" value="" placeholder="this.style.border=\'1px solid #00ff00\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-onkeyup">KeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-onkeyup" id="bootstrap-content-form-textarea-onkeyup" value="" placeholder="alert(this.value.length)" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-tabindex">Tabindex</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-tabindex" id="bootstrap-content-form-textarea-tabindex" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-aria-label">Aria-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-aria-label" id="bootstrap-content-form-textarea-aria-label" value="" placeholder="User input..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-aria-describedby">Aria-Describedby</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-textarea-aria-describedby" id="bootstrap-content-form-textarea-aria-describedby" value="" placeholder="span_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-textarea-disabled" id="bootstrap-content-form-textarea-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-textarea-readonly" id="bootstrap-content-form-textarea-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-textarea-required" id="bootstrap-content-form-textarea-required" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-textarea-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-form-textarea-content" id="bootstrap-content-form-textarea-content" cols="20" rows="8" placeholder="Write here..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-textarea-name').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var name = jQuery('#bootstrap-content-form-textarea-name').val();

				var color = jQuery('#bootstrap-content-form-textarea-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-textarea-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-textarea-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-textarea-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-textarea-border-radius').val();

				var style = jQuery('#bootstrap-content-form-textarea-style').val();
				var input_class = jQuery('#bootstrap-content-form-textarea-class').val();

				var cols = jQuery('#bootstrap-content-form-textarea-cols').val();
				var rows = jQuery('#bootstrap-content-form-textarea-rows').val();
				var mouseover = jQuery('#bootstrap-content-form-textarea-onmouseover').val();
				var mouseout = jQuery('#bootstrap-content-form-textarea-onmouseout').val();
				var keyup = jQuery('#bootstrap-content-form-textarea-onkeyup').val();
				var tabindex = jQuery('#bootstrap-content-form-textarea-tabindex').val();

				var aria_label = jQuery('#bootstrap-content-form-textarea-aria-label').val();
				var aria_describedby = jQuery('#bootstrap-content-form-textarea-aria-describedby').val();
				var disabled = jQuery('#bootstrap-content-form-textarea-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-content-form-textarea-readonly').attr("checked");
				var required = jQuery('#bootstrap-content-form-textarea-required').attr("checked");

				var content = jQuery('#bootstrap-content-form-textarea-content').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';
				var attr_cols = cols != '' ? ' cols="' + cols + '"' : '';
				var attr_rows = rows != '' ? ' rows="' + rows + '"' : '';
				var attr_onmouseover = mouseover != '' ? ' onmouseover="' + mouseover + '"' : '';
				var attr_onmouseout = mouseout != '' ? ' onmouseout="' + mouseout + '"' : '';
				var attr_onkeyup = keyup != '' ? ' onkeyup="' + keyup + '"' : '';
				var attr_tabindex = tabindex != '' ? ' tabindex="' + tabindex + '"' : '';
				var attr_aria_label = aria_label != '' ? ' aria-label="' + aria_label + '"' : '';
				var attr_aria_describedby = aria_describedby != '' ? ' aria-describedby="' + aria_describedby + '"' : '';

				var attr_disabled = disabled == 'checked' ? ' disabled="disabled"' : '';
				var attr_readonly = readonly == 'checked' ? ' readonly="readonly"' : '';
				var attr_required = required == 'checked' ? ' required="required"' : '';

				var class_color = color != '' ? 'text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<textarea name="' + name + '" id="' + name + '"' + attr_style + attr_cols + attr_rows + attr_onmouseover + attr_onmouseout + attr_onkeyup + attr_tabindex + attr_aria_label + attr_aria_describedby + attr_disabled + attr_readonly + attr_required + ' class="form-control ' + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + ' ' + input_class + '">' + content + '</textarea>\n';
			}
		}, 
		'button': {
			'title': 'Button', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-type">Type</label><div class="col-sm-6"><select name="bootstrap-content-form-button-type" id="bootstrap-content-form-button-type">' + bootstrap_options_button_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-name" id="bootstrap-content-form-button-name" value="" placeholder="button_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-btncolor">Btn-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-btncolor" id="bootstrap-content-form-button-btncolor">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-color" id="bootstrap-content-form-button-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-bgcolor" id="bootstrap-content-form-button-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-color" id="bootstrap-content-form-button-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-types" id="bootstrap-content-form-button-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-radius" id="bootstrap-content-form-button-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-style" id="bootstrap-content-form-button-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-class" id="bootstrap-content-form-button-class" value="" placeholder="input form-controll" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-onmouseover">MouseOver</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onmouseover" id="bootstrap-content-form-button-onmouseover" value="" placeholder="this.style.border=\'1px solid #ff0000\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-onmouseout">MouseOut</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onmouseout" id="bootstrap-content-form-button-onmouseout" value="" placeholder="this.style.border=\'1px solid #00ff00\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-onclick">Click</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onclick" id="bootstrap-content-form-button-onclick" value="" placeholder="alert(\'Form submit...\')" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-tabindex">Tabindex</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-tabindex" id="bootstrap-content-form-button-tabindex" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-aria-label">Aria-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-aria-label" id="bootstrap-content-form-button-aria-label" value="" placeholder="User input..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-aria-describedby">Aria-Describedby</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-aria-describedby" id="bootstrap-content-form-button-aria-describedby" value="" placeholder="span_id" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-button-disabled" id="bootstrap-content-form-button-disabled" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-form-button-content">Content</label><textarea name="bootstrap-content-form-button-content" id="bootstrap-content-form-button-content" cols="20" rows="8" placeholder="Label\n&lt;span class=&quot;badge badge-light&quot;&gt;9&lt;\/span&gt;\n&lt;span class=&quot;sr-only&quot;&gt;unread messages&lt;\/span&gt;\n" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-button-name').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var button_type = jQuery('#bootstrap-content-form-button-type').val();
				var name = jQuery('#bootstrap-content-form-button-name').val();

				var btncolor = jQuery('#bootstrap-content-form-button-btncolor').val();
				var color = jQuery('#bootstrap-content-form-button-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-button-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-button-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-button-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-button-border-radius').val();

				var style = jQuery('#bootstrap-content-form-button-style').val();
				var input_class = jQuery('#bootstrap-content-form-button-class').val();

				var mouseover = jQuery('#bootstrap-content-form-button-onmouseover').val();
				var mouseout = jQuery('#bootstrap-content-form-button-onmouseout').val();
				var click = jQuery('#bootstrap-content-form-button-onclick').val();
				var tabindex = jQuery('#bootstrap-content-form-button-tabindex').val();

				var aria_label = jQuery('#bootstrap-content-form-button-aria-label').val();
				var aria_describedby = jQuery('#bootstrap-content-form-button-aria-describedby').val();
				var disabled = jQuery('#bootstrap-content-form-button-disabled').attr("checked");

				var content = jQuery('#bootstrap-content-form-button-content').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var attr_onmouseover = mouseover != '' ? ' onmouseover="' + mouseover + '"' : '';
				var attr_onmouseout = mouseout != '' ? ' onmouseout="' + mouseout + '"' : '';
				var attr_onclick = click != '' ? ' onclick="' + click + '"' : '';
				var attr_tabindex = tabindex != '' ? ' tabindex="' + tabindex + '"' : '';
				var attr_aria_label = aria_label != '' ? ' aria-label="' + aria_label + '"' : '';
				var attr_aria_describedby = aria_describedby != '' ? ' aria-describedby="' + aria_describedby + '"' : '';

				var attr_disabled = disabled == 'checked' ? ' disabled="disabled"' : '';

				var class_btncolor = btncolor != '' ? ' btn-' + btncolor : '';
				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<button type="' + button_type + '" name="' + name + '" id="' + name + '"' + attr_style + attr_onmouseover + attr_onmouseout + attr_onclick + attr_tabindex + attr_aria_label + attr_aria_describedby + attr_disabled + ' class="form-control btn' + class_btncolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + ' ' + input_class + '">' + content + '</button>\n';
			}
		}, 
		'main': {
			'title': 'Main', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-main-color" id="bootstrap-content-main-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-main-bgcolor" id="bootstrap-content-main-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-main-border-color" id="bootstrap-content-main-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-main-border-types" id="bootstrap-content-main-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-main-border-radius" id="bootstrap-content-main-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-main-style" id="bootstrap-content-main-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-main-class" id="bootstrap-content-main-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-main-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-main-content" id="bootstrap-content-main-content" cols="20" rows="8" placeholder="Main-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-main-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-main-color').val();
				var bgcolor = jQuery('#bootstrap-content-main-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-main-border-color').val();
				var border_types = jQuery('#bootstrap-content-main-border-types').val();
				var border_radius = jQuery('#bootstrap-content-main-border-radius').val();

				var style = jQuery('#bootstrap-content-main-style').val();
				var main_class = jQuery('#bootstrap-content-main-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<main' + attr_style + ' class="' + main_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-main-content').val() + '</main>\n';
			}
		}, 
		'header': {
			'title': 'Header', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-header-color" id="bootstrap-content-header-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-header-bgcolor" id="bootstrap-content-header-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-header-border-color" id="bootstrap-content-header-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-header-border-types" id="bootstrap-content-header-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-header-border-radius" id="bootstrap-content-header-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-header-style" id="bootstrap-content-header-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-header-class" id="bootstrap-content-header-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-header-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-header-content" id="bootstrap-content-header-content" cols="20" rows="8" placeholder="Header-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-header-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-header-color').val();
				var bgcolor = jQuery('#bootstrap-content-header-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-header-border-color').val();
				var border_types = jQuery('#bootstrap-content-header-border-types').val();
				var border_radius = jQuery('#bootstrap-content-header-border-radius').val();

				var style = jQuery('#bootstrap-content-header-style').val();
				var header_class = jQuery('#bootstrap-content-header-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<header' + attr_style + ' class="' + header_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-header-content').val() + '</header>\n';
			}
		}, 
		'footer': {
			'title': 'Footer', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label><div class="col-sm-6"><textarea id="bootstrap_components_alerts_text" placeholder="&lt;h4 class=&quot;alert-heading&quot;&gt;Header text...&lt;\/h4&gt;\r\n&lt;p&gt;Text...&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;an example link&lt;\/a&gt;...&lt;\/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;mb-0&quot;&gt;Footer Text...&lt;\/p&gt;" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-footer-color" id="bootstrap-content-footer-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-footer-bgcolor" id="bootstrap-content-footer-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-footer-border-color" id="bootstrap-content-footer-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-footer-border-types" id="bootstrap-content-footer-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-footer-border-radius" id="bootstrap-content-footer-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-footer-style" id="bootstrap-content-footer-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-footer-class" id="bootstrap-content-footer-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-footer-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-footer-content" id="bootstrap-content-footer-content" cols="20" rows="8" placeholder="Footer-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-footer-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-footer-color').val();
				var bgcolor = jQuery('#bootstrap-content-footer-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-footer-border-color').val();
				var border_types = jQuery('#bootstrap-content-footer-border-types').val();
				var border_radius = jQuery('#bootstrap-content-footer-border-radius').val();

				var style = jQuery('#bootstrap-content-footer-style').val();
				var footer_class = jQuery('#bootstrap-content-footer-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<footer' + attr_style + ' class="' + footer_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-footer-content').val() + '</footer>\n';
			}
		}, 
		'section': {
			'title': 'Section', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-section-color" id="bootstrap-content-section-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-section-bgcolor" id="bootstrap-content-section-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-section-border-color" id="bootstrap-content-section-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-section-border-types" id="bootstrap-content-section-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-section-border-radius" id="bootstrap-content-section-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-section-style" id="bootstrap-content-section-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-section-class" id="bootstrap-content-section-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-section-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-section-content" id="bootstrap-content-section-content" cols="20" rows="8" placeholder="Footer-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-section-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-section-color').val();
				var bgcolor = jQuery('#bootstrap-content-section-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-section-border-color').val();
				var border_types = jQuery('#bootstrap-content-section-border-types').val();
				var border_radius = jQuery('#bootstrap-content-section-border-radius').val();

				var style = jQuery('#bootstrap-content-section-style').val();
				var section_class = jQuery('#bootstrap-content-section-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<section' + attr_style + ' class="' + section_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-section-content').val() + '</section>\n';
			}
		}, 
		'aside': {
			'title': 'Aside', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-aside-color" id="bootstrap-content-aside-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-aside-bgcolor" id="bootstrap-content-aside-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-aside-border-color" id="bootstrap-content-aside-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-aside-border-types" id="bootstrap-content-aside-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-aside-border-radius" id="bootstrap-content-aside-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-aside-style" id="bootstrap-content-aside-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-aside-class" id="bootstrap-content-aside-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-aside-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-aside-content" id="bootstrap-content-aside-content" cols="20" rows="8" placeholder="Aside-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-aside-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-aside-color').val();
				var bgcolor = jQuery('#bootstrap-content-aside-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-aside-border-color').val();
				var border_types = jQuery('#bootstrap-content-aside-border-types').val();
				var border_radius = jQuery('#bootstrap-content-aside-border-radius').val();

				var style = jQuery('#bootstrap-content-aside-style').val();
				var aside_class = jQuery('#bootstrap-content-aside-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<aside' + attr_style + ' class="' + aside_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-aside-content').val() + '</aside>\n';
			}
		}, 
		'nav': {
			'title': 'Nav', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-nav-color" id="bootstrap-content-nav-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-nav-bgcolor" id="bootstrap-content-nav-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-nav-border-color" id="bootstrap-content-nav-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-nav-border-types" id="bootstrap-content-nav-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-nav-border-radius" id="bootstrap-content-nav-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-nav-style" id="bootstrap-content-nav-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-nav-class" id="bootstrap-content-nav-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-nav-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-nav-content" id="bootstrap-content-nav-content" cols="20" rows="8" placeholder="Nav-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-nav-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-nav-color').val();
				var bgcolor = jQuery('#bootstrap-content-nav-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-nav-border-color').val();
				var border_types = jQuery('#bootstrap-content-nav-border-types').val();
				var border_radius = jQuery('#bootstrap-content-nav-border-radius').val();

				var style = jQuery('#bootstrap-content-nav-style').val();
				var nav_class = jQuery('#bootstrap-content-nav-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<nav' + attr_style + ' class="' + nav_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-nav-content').val() + '</nav>\n';
			}
		}, 
		'navbar': {
			'title': 'Navbar', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-theming">Theming</label><div class="col-sm-6"><select name="bootstrap-content-navbar-theming" id="bootstrap-content-navbar-theming"><option value="light">Light</option><option value="dark">Dark</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-navbar-color" id="bootstrap-content-navbar-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-navbar-bgcolor" id="bootstrap-content-navbar-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-navbar-border-color" id="bootstrap-content-navbar-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-navbar-border-types" id="bootstrap-content-navbar-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-navbar-border-radius" id="bootstrap-content-navbar-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-navbar-style" id="bootstrap-content-navbar-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-navbar-class" id="bootstrap-content-navbar-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-navbar-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-navbar-content" id="bootstrap-content-navbar-content" cols="20" rows="8" placeholder="#|Link 1\n#|Link 2\n#|Link 3" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-navbar-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var theming = jQuery('#bootstrap-content-navbar-theming').val();
				var color = jQuery('#bootstrap-content-navbar-color').val();
				var bgcolor = jQuery('#bootstrap-content-navbar-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-navbar-border-color').val();
				var border_types = jQuery('#bootstrap-content-navbar-border-types').val();
				var border_radius = jQuery('#bootstrap-content-navbar-border-radius').val();

				var style = jQuery('#bootstrap-content-navbar-style').val();
				var nav_class = jQuery('#bootstrap-content-navbar-class').val();

				var class_theming = theming != '' ? ' navbar-' + theming : '';

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var content = jQuery('#bootstrap-content-navbar-content').val();
				var content_arr = content.split('\n');

				var nav_items = '';

				for(var i = 0;i < content_arr.length;i++){

					var keyArr = content_arr[i].split('|');

					nav_items += 	i == 0 ? 
									'			<li class="nav-item active">' + 
									'				<a class="nav-link" href="' + keyArr[0] + '">' + keyArr[1] + ' <span class="sr-only">(current)</span></a>' + 
									'			</li>' : 
									'			<li class="nav-item">' + 
									'				<a class="nav-link" href="' + keyArr[0] + '">' + keyArr[1] + '</a>' + 
									'			</li>';

				}

				return 	'<nav class="navbar navbar-expand-lg' + class_theming + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '"' + attr_style + '>' + 
						'	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">' + 
						'		<span class="navbar-toggler-icon"></span>' + 
						'	</button>' + 
						'	<a class="navbar-brand" href="#">Navbar</a>' + 
						'	<div class="collapse navbar-collapse" id="navbarTogglerDemo03">' + 
						'		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">' + 
						nav_items + 
						'		</ul>' + 
						'		<form class="form-inline my-2 my-lg-0">' + 
						'			<input type="search" placeholder="Search" class="form-control mr-sm-2" aria-label="Search">' + 
						'			<button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>' + 
						'		</form>' + 
						'	</div>' + 
						'</nav>';
			}
		}, 
		'address': {
			'title': 'Address', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-address-color" id="bootstrap-content-address-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-address-bgcolor" id="bootstrap-content-address-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-address-border-color" id="bootstrap-content-address-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-address-border-types" id="bootstrap-content-address-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-address-border-radius" id="bootstrap-content-address-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-address-style" id="bootstrap-content-address-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-address-class" id="bootstrap-content-address-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-address-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-address-content" id="bootstrap-content-address-content" cols="20" rows="8" placeholder="Address-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-address-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-address-color').val();
				var bgcolor = jQuery('#bootstrap-content-address-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-address-border-color').val();
				var border_types = jQuery('#bootstrap-content-address-border-types').val();
				var border_radius = jQuery('#bootstrap-content-address-border-radius').val();

				var style = jQuery('#bootstrap-content-address-style').val();
				var address_class = jQuery('#bootstrap-content-address-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<address' + attr_style + ' class="' + address_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-address-content').val() + '</address>\n';
			}
		}, 
		'blockquote': {
			'title': 'Blockquote', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-blockquote-color" id="bootstrap-content-blockquote-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-blockquote-bgcolor" id="bootstrap-content-blockquote-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-blockquote-border-color" id="bootstrap-content-blockquote-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-blockquote-border-types" id="bootstrap-content-blockquote-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-blockquote-border-radius" id="bootstrap-content-blockquote-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-blockquote-style" id="bootstrap-content-blockquote-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-blockquote-class" id="bootstrap-content-blockquote-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-blockquote-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-blockquote-content" id="bootstrap-content-blockquote-content" cols="20" rows="8" placeholder="Blockquote-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-blockquote-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-blockquote-color').val();
				var bgcolor = jQuery('#bootstrap-content-blockquote-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-blockquote-border-color').val();
				var border_types = jQuery('#bootstrap-content-blockquote-border-types').val();
				var border_radius = jQuery('#bootstrap-content-blockquote-border-radius').val();

				var style = jQuery('#bootstrap-content-blockquote-style').val();
				var blockquote_class = jQuery('#bootstrap-content-blockquote-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<blockquote' + attr_style + ' class="' + blockquote_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-blockquote-content').val() + '</blockquote>\n';
			}
		}, 
		'abbr': {
			'title': 'Abbr', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-abbr-color" id="bootstrap-content-abbr-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-abbr-bgcolor" id="bootstrap-content-abbr-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-abbr-border-color" id="bootstrap-content-abbr-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-abbr-border-types" id="bootstrap-content-abbr-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-abbr-border-radius" id="bootstrap-content-abbr-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-abbr-style" id="bootstrap-content-abbr-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-abbr-class" id="bootstrap-content-abbr-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-abbr-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-abbr-content" id="bootstrap-content-abbr-content" cols="20" rows="8" placeholder="Abbr-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-abbr-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-abbr-color').val();
				var bgcolor = jQuery('#bootstrap-content-abbr-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-abbr-border-color').val();
				var border_types = jQuery('#bootstrap-content-abbr-border-types').val();
				var border_radius = jQuery('#bootstrap-content-abbr-border-radius').val();

				var style = jQuery('#bootstrap-content-abbr-style').val();
				var abbr_class = jQuery('#bootstrap-content-abbr-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<abbr' + attr_style + ' class="' + abbr_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-abbr-content').val() + '</abbr>\n';
			}
		}, 
		'cite': {
			'title': 'Cite', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-cite-color" id="bootstrap-content-cite-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-cite-bgcolor" id="bootstrap-content-cite-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-cite-border-color" id="bootstrap-content-cite-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-cite-border-types" id="bootstrap-content-cite-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-cite-border-radius" id="bootstrap-content-cite-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-cite-style" id="bootstrap-content-cite-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-cite-class" id="bootstrap-content-cite-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-cite-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-cite-content" id="bootstrap-content-cite-content" cols="20" rows="8" placeholder="Cite-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-cite-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-cite-color').val();
				var bgcolor = jQuery('#bootstrap-content-cite-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-cite-border-color').val();
				var border_types = jQuery('#bootstrap-content-cite-border-types').val();
				var border_radius = jQuery('#bootstrap-content-cite-border-radius').val();

				var style = jQuery('#bootstrap-content-cite-style').val();
				var cite_class = jQuery('#bootstrap-content-cite-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<cite' + attr_style + ' class="' + cite_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-cite-content').val() + '</cite>\n';
			}
		}, 
		'code': {
			'title': 'Code', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-code-color" id="bootstrap-content-code-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-code-bgcolor" id="bootstrap-content-code-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-code-border-color" id="bootstrap-content-code-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-code-border-types" id="bootstrap-content-code-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-code-border-radius" id="bootstrap-content-code-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-code-style" id="bootstrap-content-code-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-code-class" id="bootstrap-content-code-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-code-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-code-content" id="bootstrap-content-code-content" cols="20" rows="8" placeholder="Code-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-code-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-code-color').val();
				var bgcolor = jQuery('#bootstrap-content-code-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-code-border-color').val();
				var border_types = jQuery('#bootstrap-content-code-border-types').val();
				var border_radius = jQuery('#bootstrap-content-code-border-radius').val();

				var style = jQuery('#bootstrap-content-code-style').val();
				var code_class = jQuery('#bootstrap-content-code-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<code' + attr_style + ' class="' + code_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-code-content').val() + '</code>\n';
			}
		}, 
		'var': {
			'title': 'Var', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-var-color" id="bootstrap-content-var-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-var-bgcolor" id="bootstrap-content-var-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-var-border-color" id="bootstrap-content-var-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-var-border-types" id="bootstrap-content-var-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-var-border-radius" id="bootstrap-content-var-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-var-style" id="bootstrap-content-var-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-var-class" id="bootstrap-content-var-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-var-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-var-content" id="bootstrap-content-var-content" cols="20" rows="8" placeholder="Code-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-var-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-var-color').val();
				var bgcolor = jQuery('#bootstrap-content-var-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-var-border-color').val();
				var border_types = jQuery('#bootstrap-content-var-border-types').val();
				var border_radius = jQuery('#bootstrap-content-var-border-radius').val();

				var style = jQuery('#bootstrap-content-var-style').val();
				var var_class = jQuery('#bootstrap-content-var-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<var' + attr_style + ' class="' + var_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-var-content').val() + '</var>\n';
			}
		}, 
		'kbd': {
			'title': 'Kbd', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-kbd-color" id="bootstrap-content-kbd-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-kbd-bgcolor" id="bootstrap-content-kbd-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-kbd-border-color" id="bootstrap-content-kbd-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-kbd-border-types" id="bootstrap-content-kbd-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-kbd-border-radius" id="bootstrap-content-kbd-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-kbd-style" id="bootstrap-content-kbd-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-kbd-class" id="bootstrap-content-kbd-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-kbd-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-kbd-content" id="bootstrap-content-kbd-content" cols="20" rows="8" placeholder="Kbd-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-kbd-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-kbd-color').val();
				var bgcolor = jQuery('#bootstrap-content-kbd-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-kbd-border-color').val();
				var border_types = jQuery('#bootstrap-content-kbd-border-types').val();
				var border_radius = jQuery('#bootstrap-content-kbd-border-radius').val();

				var style = jQuery('#bootstrap-content-kbd-style').val();
				var kbd_class = jQuery('#bootstrap-content-kbd-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<kbd' + attr_style + ' class="' + kbd_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-kbd-content').val() + '</kbd>\n';
			}
		}, 
		'samp': {
			'title': 'Samp', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-samp-color" id="bootstrap-content-samp-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-samp-bgcolor" id="bootstrap-content-samp-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-samp-border-color" id="bootstrap-content-samp-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-samp-border-types" id="bootstrap-content-samp-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-samp-border-radius" id="bootstrap-content-samp-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-samp-style" id="bootstrap-content-samp-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-samp-class" id="bootstrap-content-samp-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-samp-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-samp-content" id="bootstrap-content-samp-content" cols="20" rows="8" placeholder="Samp-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-samp-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-samp-color').val();
				var bgcolor = jQuery('#bootstrap-content-samp-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-samp-border-color').val();
				var border_types = jQuery('#bootstrap-content-samp-border-types').val();
				var border_radius = jQuery('#bootstrap-content-samp-border-radius').val();

				var style = jQuery('#bootstrap-content-samp-style').val();
				var samp_class = jQuery('#bootstrap-content-samp-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<samp' + attr_style + ' class="' + samp_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-samp-content').val() + '</samp>\n';
			}
		}, 
		'summary': {
			'title': 'Summary', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-summary-color" id="bootstrap-content-summary-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-summary-bgcolor" id="bootstrap-content-summary-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-summary-border-color" id="bootstrap-content-summary-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-summary-border-types" id="bootstrap-content-summary-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-summary-border-radius" id="bootstrap-content-summary-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-summary-style" id="bootstrap-content-summary-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-summary-class" id="bootstrap-content-summary-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-summary-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-summary-content" id="bootstrap-content-summary-content" cols="20" rows="8" placeholder="Summary-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-summary-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-summary-color').val();
				var bgcolor = jQuery('#bootstrap-content-summary-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-summary-border-color').val();
				var border_types = jQuery('#bootstrap-content-summary-border-types').val();
				var border_radius = jQuery('#bootstrap-content-summary-border-radius').val();

				var style = jQuery('#bootstrap-content-summary-style').val();
				var summary_class = jQuery('#bootstrap-content-summary-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<summary' + attr_style + ' class="' + summary_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-summary-content').val() + '</summary>\n';
			}
		}, 
		'mark': {
			'title': 'Mark', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-mark-color" id="bootstrap-content-mark-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-mark-bgcolor" id="bootstrap-content-mark-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-mark-border-color" id="bootstrap-content-mark-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-mark-border-types" id="bootstrap-content-mark-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-mark-border-radius" id="bootstrap-content-mark-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-mark-style" id="bootstrap-content-mark-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-mark-class" id="bootstrap-content-mark-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-mark-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-mark-content" id="bootstrap-content-mark-content" cols="20" rows="8" placeholder="Mark-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-mark-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-mark-color').val();
				var bgcolor = jQuery('#bootstrap-content-mark-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-mark-border-color').val();
				var border_types = jQuery('#bootstrap-content-mark-border-types').val();
				var border_radius = jQuery('#bootstrap-content-mark-border-radius').val();

				var style = jQuery('#bootstrap-content-mark-style').val();
				var mark_class = jQuery('#bootstrap-content-mark-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<mark' + attr_style + ' class="' + mark_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-mark-content').val() + '</mark>\n';
			}
		}, 
		'del': {
			'title': 'Del', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-del-color" id="bootstrap-content-del-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-del-bgcolor" id="bootstrap-content-del-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-del-border-color" id="bootstrap-content-del-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-del-border-types" id="bootstrap-content-del-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-del-border-radius" id="bootstrap-content-del-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-del-style" id="bootstrap-content-del-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-del-class" id="bootstrap-content-del-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-del-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-del-content" id="bootstrap-content-del-content" cols="20" rows="8" placeholder="Del-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-del-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-del-color').val();
				var bgcolor = jQuery('#bootstrap-content-del-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-del-border-color').val();
				var border_types = jQuery('#bootstrap-content-del-border-types').val();
				var border_radius = jQuery('#bootstrap-content-del-border-radius').val();

				var style = jQuery('#bootstrap-content-del-style').val();
				var del_class = jQuery('#bootstrap-content-del-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<del' + attr_style + ' class="' + del_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-del-content').val() + '</del>\n';
			}
		}, 
		's': {
			'title': 'S', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-s-color" id="bootstrap-content-s-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-s-bgcolor" id="bootstrap-content-s-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-s-border-color" id="bootstrap-content-s-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-s-border-types" id="bootstrap-content-s-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-s-border-radius" id="bootstrap-content-s-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-s-style" id="bootstrap-content-s-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-s-class" id="bootstrap-content-s-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-s-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-s-content" id="bootstrap-content-s-content" cols="20" rows="8" placeholder="S-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-s-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-s-color').val();
				var bgcolor = jQuery('#bootstrap-content-s-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-s-border-color').val();
				var border_types = jQuery('#bootstrap-content-s-border-types').val();
				var border_radius = jQuery('#bootstrap-content-s-border-radius').val();

				var style = jQuery('#bootstrap-content-s-style').val();
				var s_class = jQuery('#bootstrap-content-s-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<s' + attr_style + ' class="' + s_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-s-content').val() + '</s>\n';
			}
		}, 
		'ins': {
			'title': 'Ins', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-ins-color" id="bootstrap-content-ins-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-ins-bgcolor" id="bootstrap-content-ins-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-ins-border-color" id="bootstrap-content-ins-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-ins-border-types" id="bootstrap-content-ins-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-ins-border-radius" id="bootstrap-content-ins-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-ins-style" id="bootstrap-content-ins-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-ins-class" id="bootstrap-content-ins-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-ins-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-ins-content" id="bootstrap-content-ins-content" cols="20" rows="8" placeholder="Ins-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-ins-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-ins-color').val();
				var bgcolor = jQuery('#bootstrap-content-ins-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-ins-border-color').val();
				var border_types = jQuery('#bootstrap-content-ins-border-types').val();
				var border_radius = jQuery('#bootstrap-content-ins-border-radius').val();

				var style = jQuery('#bootstrap-content-ins-style').val();
				var ins_class = jQuery('#bootstrap-content-ins-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<ins' + attr_style + ' class="' + ins_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-ins-content').val() + '</ins>\n';
			}
		}, 
		'u': {
			'title': 'U', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-u-color" id="bootstrap-content-u-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-u-bgcolor" id="bootstrap-content-u-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-u-border-color" id="bootstrap-content-u-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-u-border-types" id="bootstrap-content-u-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-u-border-radius" id="bootstrap-content-u-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-u-style" id="bootstrap-content-u-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-u-class" id="bootstrap-content-u-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-u-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-u-content" id="bootstrap-content-u-content" cols="20" rows="8" placeholder="U-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-u-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-u-color').val();
				var bgcolor = jQuery('#bootstrap-content-u-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-u-border-color').val();
				var border_types = jQuery('#bootstrap-content-u-border-types').val();
				var border_radius = jQuery('#bootstrap-content-u-border-radius').val();

				var style = jQuery('#bootstrap-content-u-style').val();
				var u_class = jQuery('#bootstrap-content-u-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<u' + attr_style + ' class="' + u_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-u-content').val() + '</u>\n';
			}
		}, 
		'small': {
			'title': 'Small', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-small-color" id="bootstrap-content-small-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-small-bgcolor" id="bootstrap-content-small-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-small-border-color" id="bootstrap-content-small-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-small-border-types" id="bootstrap-content-small-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-small-border-radius" id="bootstrap-content-small-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-small-style" id="bootstrap-content-small-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-small-class" id="bootstrap-content-small-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-small-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-small-content" id="bootstrap-content-small-content" cols="20" rows="8" placeholder="Small-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-small-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-small-color').val();
				var bgcolor = jQuery('#bootstrap-content-small-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-small-border-color').val();
				var border_types = jQuery('#bootstrap-content-small-border-types').val();
				var border_radius = jQuery('#bootstrap-content-small-border-radius').val();

				var style = jQuery('#bootstrap-content-small-style').val();
				var small_class = jQuery('#bootstrap-content-small-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<small' + attr_style + ' class="' + small_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-small-content').val() + '</small>\n';
			}
		}, 
		'strong': {
			'title': 'Strong', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-strong-color" id="bootstrap-content-strong-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-strong-bgcolor" id="bootstrap-content-strong-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-strong-border-color" id="bootstrap-content-strong-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-strong-border-types" id="bootstrap-content-strong-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-strong-border-radius" id="bootstrap-content-strong-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-strong-style" id="bootstrap-content-strong-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-strong-class" id="bootstrap-content-strong-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-strong-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-strong-content" id="bootstrap-content-strong-content" cols="20" rows="8" placeholder="Strong-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-strong-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-strong-color').val();
				var bgcolor = jQuery('#bootstrap-content-strong-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-strong-border-color').val();
				var border_types = jQuery('#bootstrap-content-strong-border-types').val();
				var border_radius = jQuery('#bootstrap-content-strong-border-radius').val();

				var style = jQuery('#bootstrap-content-strong-style').val();
				var strong_class = jQuery('#bootstrap-content-strong-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<strong' + attr_style + ' class="' + strong_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-strong-content').val() + '</strong>\n';
			}
		}, 
		'em': {
			'title': 'Em', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-em-color" id="bootstrap-content-em-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-em-bgcolor" id="bootstrap-content-em-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-em-border-color" id="bootstrap-content-em-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-em-border-types" id="bootstrap-content-em-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-em-border-radius" id="bootstrap-content-em-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-em-style" id="bootstrap-content-em-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-em-class" id="bootstrap-content-em-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-em-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-em-content" id="bootstrap-content-em-content" cols="20" rows="8" placeholder="Em-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-em-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-em-color').val();
				var bgcolor = jQuery('#bootstrap-content-em-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-em-border-color').val();
				var border_types = jQuery('#bootstrap-content-em-border-types').val();
				var border_radius = jQuery('#bootstrap-content-em-border-radius').val();

				var style = jQuery('#bootstrap-content-em-style').val();
				var em_class = jQuery('#bootstrap-content-em-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<em' + attr_style + ' class="' + em_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-em-content').val() + '</em>\n';
			}
		}, 
		'i': {
			'title': 'I', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-i-color" id="bootstrap-content-i-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-i-bgcolor" id="bootstrap-content-i-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-i-border-color" id="bootstrap-content-i-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-i-border-types" id="bootstrap-content-i-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-i-border-radius" id="bootstrap-content-i-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-i-style" id="bootstrap-content-i-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-i-class" id="bootstrap-content-i-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-i-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-i-content" id="bootstrap-content-i-content" cols="20" rows="8" placeholder="I-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-i-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-i-color').val();
				var bgcolor = jQuery('#bootstrap-content-i-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-i-border-color').val();
				var border_types = jQuery('#bootstrap-content-i-border-types').val();
				var border_radius = jQuery('#bootstrap-content-i-border-radius').val();

				var style = jQuery('#bootstrap-content-i-style').val();
				var i_class = jQuery('#bootstrap-content-i-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<i' + attr_style + ' class="' + i_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-i-content').val() + '</i>\n';
			}
		}, 
		'img': {
			'title': 'Img', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-src">Src</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-src" id="bootstrap-content-img-src" value="" placeholder="http://www...de/...jpg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-width">Width</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-width" id="bootstrap-content-img-width" value="" placeholder="200" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-height">Height</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-height" id="bootstrap-content-img-height" value="" placeholder="200" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-alt">Alt</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-alt" id="bootstrap-content-img-alt" value="" placeholder="Logo..." ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-img-color" id="bootstrap-content-img-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-img-bgcolor" id="bootstrap-content-img-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-img-border-color" id="bootstrap-content-img-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-img-border-types" id="bootstrap-content-img-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-img-border-radius" id="bootstrap-content-img-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-fluid">Fluid</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-img-fluid" id="bootstrap-content-img-fluid" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-style" id="bootstrap-content-img-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-img-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-img-class" id="bootstrap-content-img-class" value="" placeholder="float-right...|mx-auto d-block..." ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-img-src').val() == '' ? 'Bitte geben Sie eine SRC ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var src = jQuery('#bootstrap-content-img-src').val();
				var width = jQuery('#bootstrap-content-img-width').val();
				var height = jQuery('#bootstrap-content-img-height').val();
				var alt = jQuery('#bootstrap-content-img-alt').val();

				var color = jQuery('#bootstrap-content-img-color').val();
				var bgcolor = jQuery('#bootstrap-content-img-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-img-border-color').val();
				var border_types = jQuery('#bootstrap-content-img-border-types').val();
				var border_radius = jQuery('#bootstrap-content-img-border-radius').val();

				var fluid = jQuery('#bootstrap-content-img-fluid').attr("checked");

				var style = jQuery('#bootstrap-content-img-style').val();
				var img_class = jQuery('#bootstrap-content-img-class').val();

				var attr_width = width != '' ? ' width="' + width + '"' : '';
				var attr_height = height != '' ? ' height="' + height + '"' : '';
				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_fluid = fluid == 'checked' ? ' img-fluid' : '';

				return 	'<img src="' + src + '"' + attr_width + attr_height + attr_style + ' border="0" alt="' + alt + '" class="' + img_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + class_fluid + '" />\n';
			}
		}, 
		'picture': {
			'title': 'Picture', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-picture-color" id="bootstrap-content-picture-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-picture-bgcolor" id="bootstrap-content-picture-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-picture-border-color" id="bootstrap-content-picture-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-picture-border-types" id="bootstrap-content-picture-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-picture-border-radius" id="bootstrap-content-picture-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-picture-style" id="bootstrap-content-picture-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-picture-class" id="bootstrap-content-picture-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-picture-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-picture-content" id="bootstrap-content-picture-content" cols="20" rows="8" placeholder="Picture-Content..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-picture-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-content-picture-color').val();
				var bgcolor = jQuery('#bootstrap-content-picture-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-picture-border-color').val();
				var border_types = jQuery('#bootstrap-content-picture-border-types').val();
				var border_radius = jQuery('#bootstrap-content-picture-border-radius').val();

				var style = jQuery('#bootstrap-content-picture-style').val();
				var picture_class = jQuery('#bootstrap-content-picture-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<picture' + attr_style + ' class="' + picture_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-picture-content').val() + '</picture>\n';
			}
		}, 
		'table': {
			'title': 'Table', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-width">Width</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-width" id="bootstrap-content-table-width" value="" placeholder="100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-cellspacing">CellPadding</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-cellspacing" id="bootstrap-content-table-cellspacing" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-cellpadding">CellSpacing</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-cellpadding" id="bootstrap-content-table-cellpadding" value="" placeholder="3" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-caption">Caption</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-caption" id="bootstrap-content-table-caption" value="" placeholder="Caption-Text" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-table-bgcolor">Table-Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-table-table-bgcolor" id="bootstrap-content-table-table-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-table-color" id="bootstrap-content-table-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-table-bgcolor" id="bootstrap-content-table-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-table-border-color" id="bootstrap-content-table-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-table-border-types" id="bootstrap-content-table-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-table-border-radius" id="bootstrap-content-table-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-bordered">Bordered</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-table-bordered" id="bootstrap-content-table-bordered" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-small">Small</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-table-small" id="bootstrap-content-table-small" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-hover">Hover</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-table-hover" id="bootstrap-content-table-hover" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-striped">Zebra-Striping</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-table-striped" id="bootstrap-content-table-striped" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-responsive">Responsive</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-table-responsive" id="bootstrap-content-table-responsive" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-style" id="bootstrap-content-table-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-table-class" id="bootstrap-content-table-class" value="" placeholder="table-sm" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-thead">tHead</label><div class="col-sm-6"><textarea name="bootstrap-content-table-thead" id="bootstrap-content-table-thead" cols="20" rows="8" placeholder="<tr>...</tr>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-theadcolor">tHead-Color</label><div class="col-sm-6"><select name="bootstrap-content-table-theadcolor" id="bootstrap-content-table-theadcolor">' + bootstrap_options_theadcolor + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-tbody">tBody</label><div class="col-sm-6"><textarea name="bootstrap-content-table-tbody" id="bootstrap-content-table-tbody" cols="20" rows="8" placeholder="<tr>...</tr>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-table-tfoot">tFoot</label><div class="col-sm-6"><textarea name="bootstrap-content-table-tfoot" id="bootstrap-content-table-tfoot" cols="20" rows="8" placeholder="<tr>...</tr>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-table-tbody').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var caption = jQuery('#bootstrap-content-table-caption').val();
				var cellspacing = jQuery('#bootstrap-content-table-cellspacing').val();
				var cellpadding = jQuery('#bootstrap-content-table-cellpadding').val();
				var width = jQuery('#bootstrap-content-table-width').val();

				var tablebgcolor = jQuery('#bootstrap-content-table-table-bgcolor').val();

				var color = jQuery('#bootstrap-content-table-color').val();
				var bgcolor = jQuery('#bootstrap-content-table-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-table-border-color').val();
				var border_types = jQuery('#bootstrap-content-table-border-types').val();
				var border_radius = jQuery('#bootstrap-content-table-border-radius').val();

				var small = jQuery('#bootstrap-content-table-small').attr("checked");
				var bordered = jQuery('#bootstrap-content-table-bordered').attr("checked");
				var hover = jQuery('#bootstrap-content-table-hover').attr("checked");
				var striped = jQuery('#bootstrap-content-table-striped').attr("checked");
				var responsive = jQuery('#bootstrap-content-table-responsive').attr("checked");

				var style = jQuery('#bootstrap-content-table-style').val();
				var table_class = jQuery('#bootstrap-content-table-class').val();

				var thead = jQuery('#bootstrap-content-table-thead').val();
				var theadcolor = jQuery('#bootstrap-content-table-theadcolor').val();
				var tfoot = jQuery('#bootstrap-content-table-tfoot').val();

				var tag_caption = caption == 'checked' ? '<caption>' + caption + '</caption>\n' : '';
				var tag_responsive_start = responsive == 'checked' ? '<div class="table-responsive">\n' : '';
				var tag_responsive_end = responsive == 'checked' ? '</div>\n' : '';

				var attr_class_theadcolor = theadcolor != '' ? ' class="thead-' + theadcolor + '"' : '';
				
				var tag_thead = thead != '' ? '<thead' + attr_class_theadcolor + '>\n' + thead + '</thead>\n' : '';
				var tag_tfoot = tfoot != '' ? '<tfoot>\n' + tfoot + '</tfoot>\n' : '';

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_tablebgcolor = tablebgcolor != '' ? ' table-' + tablebgcolor : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_small = small == 'checked' ? ' table-sm' : '';
				var class_bordered = bordered == 'checked' ? ' table-bordered' : '';
				var class_hover = hover == 'checked' ? ' table-hover' : '';
				var class_striped = striped == 'checked' ? ' table-striped' : '';

				return 	tag_responsive_start + '<table width="' + width + '" cellspacing="' + cellspacing + '" cellpadding="' + cellpadding + '"' + attr_style + ' class="table ' + table_class + class_tablebgcolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + class_small + class_bordered + class_hover + class_striped + '">' + tag_caption + tag_thead + '<tbody>\n' + jQuery('#bootstrap-content-table-tbody').val() + '</tbody>\n' + tag_tfoot + '</table>\n' + tag_responsive_end;
			}
		}, 
		'tr': {
			'title': 'Tr', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-table-bgcolor">Table-Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-tr-table-bgcolor" id="bootstrap-content-tr-table-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-tr-color" id="bootstrap-content-tr-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-tr-bgcolor" id="bootstrap-content-tr-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-tr-border-color" id="bootstrap-content-tr-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-tr-border-types" id="bootstrap-content-tr-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-tr-border-radius" id="bootstrap-content-tr-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-tr-style" id="bootstrap-content-tr-style" value="" placeholder="border-bottom: 1px solid #f00" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-tr-class" id="bootstrap-content-tr-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-tr-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-tr-content" id="bootstrap-content-tr-content" cols="20" rows="8" placeholder="<th>...</th><td>...</td>" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-tr-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var tablebgcolor = jQuery('#bootstrap-content-tr-table-bgcolor').val();

				var color = jQuery('#bootstrap-content-tr-color').val();
				var bgcolor = jQuery('#bootstrap-content-tr-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-tr-border-color').val();
				var border_types = jQuery('#bootstrap-content-tr-border-types').val();
				var border_radius = jQuery('#bootstrap-content-tr-border-radius').val();

				var style = jQuery('#bootstrap-content-tr-style').val();
				var tr_class = jQuery('#bootstrap-content-tr-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_tablebgcolor = tablebgcolor != '' ? ' table-' + tablebgcolor : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<tr' + attr_style + ' class="' + tr_class + class_tablebgcolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-tr-content').val() + '</tr>\n';
			}
		}, 
		'th': {
			'title': 'Th', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-scope">Scope</label><div class="col-sm-6"><select name="bootstrap-content-th-scope" id="bootstrap-content-th-scope"><option value="">None</option><option value="col">Col</option><option value="row">Row</option></select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-table-bgcolor">Table-Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-th-table-bgcolor" id="bootstrap-content-th-table-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-th-color" id="bootstrap-content-th-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-th-bgcolor" id="bootstrap-content-th-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-th-border-color" id="bootstrap-content-th-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-th-border-types" id="bootstrap-content-th-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-th-border-radius" id="bootstrap-content-th-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-th-style" id="bootstrap-content-th-style" value="" placeholder="border-bottom: 1px solid #f00" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-th-class" id="bootstrap-content-th-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-th-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-th-content" id="bootstrap-content-th-content" cols="20" rows="8" placeholder="Th - Content" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-th-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var scope = jQuery('#bootstrap-content-th-scope').val();

				var tablebgcolor = jQuery('#bootstrap-content-th-table-bgcolor').val();

				var color = jQuery('#bootstrap-content-th-color').val();
				var bgcolor = jQuery('#bootstrap-content-th-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-th-border-color').val();
				var border_types = jQuery('#bootstrap-content-th-border-types').val();
				var border_radius = jQuery('#bootstrap-content-th-border-radius').val();

				var style = jQuery('#bootstrap-content-th-style').val();
				var th_class = jQuery('#bootstrap-content-th-class').val();

				var attr_scope = scope != '' ? ' scope="' + scope + '"' : '';

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_tablebgcolor = tablebgcolor != '' ? ' table-' + tablebgcolor : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<th' + attr_scope + attr_style + ' class="' + th_class + class_tablebgcolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-th-content').val() + '</th>\n';
			}
		}, 
		'td': {
			'title': 'Td', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-table-bgcolor">Table-Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-td-table-bgcolor" id="bootstrap-content-td-table-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-color">Color</label><div class="col-sm-6"><select name="bootstrap-content-td-color" id="bootstrap-content-td-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-td-bgcolor" id="bootstrap-content-td-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-td-border-color" id="bootstrap-content-td-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-td-border-types" id="bootstrap-content-td-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-td-border-radius" id="bootstrap-content-td-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-td-style" id="bootstrap-content-td-style" value="" placeholder="border-bottom: 1px solid #f00" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-td-class" id="bootstrap-content-td-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-td-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-td-content" id="bootstrap-content-td-content" cols="20" rows="8" placeholder="Td - Content" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-td-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var tablebgcolor = jQuery('#bootstrap-content-td-table-bgcolor').val();

				var color = jQuery('#bootstrap-content-td-color').val();
				var bgcolor = jQuery('#bootstrap-content-td-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-td-border-color').val();
				var border_types = jQuery('#bootstrap-content-td-border-types').val();
				var border_radius = jQuery('#bootstrap-content-td-border-radius').val();

				var style = jQuery('#bootstrap-content-td-style').val();
				var td_class = jQuery('#bootstrap-content-td-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_tablebgcolor = tablebgcolor != '' ? ' table-' + tablebgcolor : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<td' + attr_style + ' class="' + td_class + class_tablebgcolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + jQuery('#bootstrap-content-td-content').val() + '</td>\n';
			}
		}, 
		'figure': {
			'title': 'Figure', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-style">Figure - Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-style" id="bootstrap-content-figure-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-class">Figure - Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-class" id="bootstrap-content-figure-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-src">Img - Src</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-src" id="bootstrap-content-figure-src" value="" placeholder="https://www...de/...jpg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-width">Img - Width</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-width" id="bootstrap-content-figure-width" value="" placeholder="400" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-height">Img - Height</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-height" id="bootstrap-content-figure-height" value="" placeholder="300" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-alt">Img - Alt</label><div class="col-sm-6"><input type="text" name="bootstrap-content-figure-alt" id="bootstrap-content-figure-alt" value="" placeholder="Alternative-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-fluid">Img - Fluid</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-figure-fluid" id="bootstrap-content-figure-fluid" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-bgcolor">Img - Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-figure-bgcolor" id="bootstrap-content-figure-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-border-color">Img - Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-figure-border-color" id="bootstrap-content-figure-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-border-types">Img - Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-figure-border-types" id="bootstrap-content-figure-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-border-radius">Img - Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-figure-border-radius" id="bootstrap-content-figure-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-content">Figcaption - Content</label><div class="col-sm-6"><textarea name="bootstrap-content-figure-content" id="bootstrap-content-figure-content" cols="20" rows="8" placeholder="FigCaption-Text..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-color">Figcaption - Color</label><div class="col-sm-6"><select name="bootstrap-content-figure-color" id="bootstrap-content-figure-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-content-figure-text-align">Figcaption - Text-Align</label><div class="col-sm-6"><select name="bootstrap-content-figure-text-align" id="bootstrap-content-figure-text-align">' + bootstrap_options_text_align + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-figure-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var style = jQuery('#bootstrap-content-figure-style').val();
				var figure_class = jQuery('#bootstrap-content-figure-class').val();

				var src = jQuery('#bootstrap-content-figure-src').val();
				var width = jQuery('#bootstrap-content-figure-width').val();
				var height = jQuery('#bootstrap-content-figure-height').val();
				var alt = jQuery('#bootstrap-content-figure-alt').val();

				var fluid = jQuery('#bootstrap-content-figure-fluid').attr("checked");

				var bgcolor = jQuery('#bootstrap-content-figure-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-figure-border-color').val();
				var border_types = jQuery('#bootstrap-content-figure-border-types').val();
				var border_radius = jQuery('#bootstrap-content-figure-border-radius').val();

				var color = jQuery('#bootstrap-content-figure-color').val();
				var text_align = jQuery('#bootstrap-content-figure-text-align').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';
				var attr_width = width != '' ? ' width="' + width + '"' : '';
				var attr_height = height != '' ? ' height="' + height + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_text_align = text_align != '' ? ' text-' + text_align : '';

				var class_fluid = fluid == 'checked' ? ' img-fluid' : '';

				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<figure class="figure ' + figure_class + '"' + attr_style + '>\n<img src="' + src + '"' + attr_width + attr_height + ' alt="' + alt + '" class="figure-img' + class_fluid + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '" />\n<figcaption class="figure-caption' + class_color + class_text_align + '">' + jQuery('#bootstrap-content-figure-content').val() + '</figcaption>\n</figure>\n';
			}
		}, 
		'alerts': {
			'title': 'Alerts', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label><div class="col-sm-6"><textarea id="bootstrap_components_alerts_text" placeholder="&lt;h4 class=&quot;alert-heading&quot;&gt;Header text...&lt;\/h4&gt;\r\n&lt;p&gt;Text...&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;an example link&lt;\/a&gt;...&lt;\/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;mb-0&quot;&gt;Footer Text...&lt;\/p&gt;" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label">Farbe</label><div class="col-sm-6"><select id="bootstrap_components_alerts_bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap_components_alerts_close" class="col-sm-6 col-form-label">Mit schließen Button</label><div class="col-sm-6"><input type="checkbox" name="bootstrap_components_alerts_close" id="bootstrap_components_alerts_close" value="1" checked="checked" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap_components_alerts_text').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var close_button = 	$('#bootstrap_components_alerts_close').prop('checked') == true ? 
									'	<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
									'		<span aria-hidden="true">&times;</span>' + 
									'	</button>' : 
									'';
				return 	'<div class="alert alert-'+$('#bootstrap_components_alerts_bgcolor').children('option:selected').val()+' fade show" role="alert">' + 
						close_button + 
						$('#bootstrap_components_alerts_text').val() + 
						'</div>';
			}
		}, 
		'badge': {
			'title': 'Badge', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label>' + 
					'	<div class="col-sm-6"><input type="text" id="bootstrap_components_badge_text" value="" placeholder="Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label">Farbe</label>' + 
					'	<div class="col-sm-6"><select id="bootstrap_components_badge_bgcolor">' + 
					bootstrap_options_bgcolors + 
					'	</select></div>' + 
					'	<label class="col-sm-12 col-form-label">' + 
					'		<input type="checkbox" id="bootstrap_components_badge_pill" value="1" checked="checked" />' + 
					'		Pill badges' + 
					'	</label>' + 
					'	<label class="col-sm-12 col-form-label">' + 
					'		<input type="checkbox" id="bootstrap_components_badge_as_link" value="1" checked="checked" />' + 
					'		Als Link' + 
					'	</label>' + 
					'	<label class="col-sm-6 col-form-label">Link-URL</label>' + 
					'	<div class="col-sm-6"><input type="text" id="bootstrap_components_badge_link_url" value="" placeholder="https://www.beispiel.de/link/25" ondblclick="this.value=this.placeholder" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap_components_badge_text').val() == '' || ($('#bootstrap_components_badge_as_link').prop('checked') == true && $('#bootstrap_components_badge_link_url').val() == '') ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				if($('#bootstrap_components_badge_as_link').prop('checked') == true){
					var tag = 'a';
					var href = ' href="'+$('#bootstrap_components_badge_link_url').val()+'"';
				}else{
					var tag = 'span';
					var href = '';
				}
				return 	'<'+tag+href+' class="badge badge-'+$('#bootstrap_components_badge_bgcolor').children('option:selected').val()+($('#bootstrap_components_badge_pill').prop('checked') == true ? ' badge-pill' : '')+'">' + 
						$('#bootstrap_components_badge_text').val() + 
						'</'+tag+'>';
			}
		}, 
		'breadcrumb': {
			'title': 'Breadcrumb', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label>' + 
					'	<div class="col-sm-6"><textarea id="bootstrap_components_breadcrumb_links" placeholder="/home|Home\r\n/library|Library\r\n/data|Data" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label">Farbe</label>' + 
					'	<div class="col-sm-6"><select id="bootstrap_components_breadcrumb_bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap_components_breadcrumb_links').val() == '' ? 'Bitte geben Sie ein Paar Links ein (href|name). Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var links = $('#bootstrap_components_breadcrumb_links').val();
				var links_arr = links.split('\n');
				var links_li = '';
				for(i = 0;i < links_arr.length;i++){
					var link = links_arr[i].split('|');
					links_li += i == links_arr.length-1 ? '<li class="breadcrumb-item active" aria-current="page">'+link[1]+'</li>' : '<li class="breadcrumb-item"><a href="'+link[0]+'">'+link[1]+'</a></li>';
				}
				return 	'<nav aria-label="breadcrumb">' + 
						'	<ol class="breadcrumb bg-'+$('#bootstrap_components_breadcrumb_bgcolor').children('option:selected').val()+'">' + 
						links_li + 
						'	</ol>' + 
						'</nav>';
			}
		}, 
		'button': {
			'title': 'Button', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-content-form-button-type" class="col-sm-6 col-form-label">Type</label><div class="col-sm-6"><select name="bootstrap-content-form-button-type" id="bootstrap-content-form-button-type">' + bootstrap_options_button_types + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-name" class="col-sm-6 col-form-label">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-name" id="bootstrap-content-form-button-name" value="" placeholder="button_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-btncolor" class="col-sm-6 col-form-label">Btn-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-btncolor" id="bootstrap-content-form-button-btncolor">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-color" id="bootstrap-content-form-button-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-bgcolor" id="bootstrap-content-form-button-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-color" id="bootstrap-content-form-button-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-types" id="bootstrap-content-form-button-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-content-form-button-border-radius" id="bootstrap-content-form-button-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-content-form-button-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-style" id="bootstrap-content-form-button-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-class" id="bootstrap-content-form-button-class" value="" placeholder="input form-controll" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-onmouseover" class="col-sm-6 col-form-label">MouseOver</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onmouseover" id="bootstrap-content-form-button-onmouseover" value="" placeholder="this.style.border=\'1px solid #ff0000\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-onmouseout" class="col-sm-6 col-form-label">MouseOut</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onmouseout" id="bootstrap-content-form-button-onmouseout" value="" placeholder="this.style.border=\'1px solid #00ff00\'" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-onclick" class="col-sm-6 col-form-label">Click</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-onclick" id="bootstrap-content-form-button-onclick" value="" placeholder="alert(\'Form submit...\')" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-tabindex" class="col-sm-6 col-form-label">Tabindex</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-tabindex" id="bootstrap-content-form-button-tabindex" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-aria-label" class="col-sm-6 col-form-label">Aria-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-aria-label" id="bootstrap-content-form-button-aria-label" value="" placeholder="User input..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-aria-describedby" class="col-sm-6 col-form-label">Aria-Describedby</label><div class="col-sm-6"><input type="text" name="bootstrap-content-form-button-aria-describedby" id="bootstrap-content-form-button-aria-describedby" value="" placeholder="span_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-content-form-button-disabled" class="col-sm-6 col-form-label">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-content-form-button-disabled" id="bootstrap-content-form-button-disabled" value="1" /></div>' + 
					'	<label for="bootstrap-content-form-button-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-content-form-button-content" id="bootstrap-content-form-button-content" cols="20" rows="8" placeholder="Label\n&lt;span class=&quot;badge badge-light&quot;&gt;9&lt;\/span&gt;\n&lt;span class=&quot;sr-only&quot;&gt;unread messages&lt;\/span&gt;\n" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-button-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var button_type = jQuery('#bootstrap-content-form-button-type').val();
				var name = jQuery('#bootstrap-content-form-button-name').val();

				var btncolor = jQuery('#bootstrap-content-form-button-btncolor').val();
				var color = jQuery('#bootstrap-content-form-button-color').val();
				var bgcolor = jQuery('#bootstrap-content-form-button-bgcolor').val();
				var border_color = jQuery('#bootstrap-content-form-button-border-color').val();
				var border_types = jQuery('#bootstrap-content-form-button-border-types').val();
				var border_radius = jQuery('#bootstrap-content-form-button-border-radius').val();

				var style = jQuery('#bootstrap-content-form-button-style').val();
				var input_class = jQuery('#bootstrap-content-form-button-class').val();

				var mouseover = jQuery('#bootstrap-content-form-button-onmouseover').val();
				var mouseout = jQuery('#bootstrap-content-form-button-onmouseout').val();
				var click = jQuery('#bootstrap-content-form-button-onclick').val();
				var tabindex = jQuery('#bootstrap-content-form-button-tabindex').val();

				var aria_label = jQuery('#bootstrap-content-form-button-aria-label').val();
				var aria_describedby = jQuery('#bootstrap-content-form-button-aria-describedby').val();
				var disabled = jQuery('#bootstrap-content-form-button-disabled').attr("checked");

				var content = jQuery('#bootstrap-content-form-button-content').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var attr_onmouseover = mouseover != '' ? ' onmouseover="' + mouseover + '"' : '';
				var attr_onmouseout = mouseout != '' ? ' onmouseout="' + mouseout + '"' : '';
				var attr_onclick = click != '' ? ' onclick="' + click + '"' : '';
				var attr_tabindex = tabindex != '' ? ' tabindex="' + tabindex + '"' : '';
				var attr_aria_label = aria_label != '' ? ' aria-label="' + aria_label + '"' : '';
				var attr_aria_describedby = aria_describedby != '' ? ' aria-describedby="' + aria_describedby + '"' : '';

				var attr_disabled = disabled == 'checked' ? ' disabled="disabled"' : '';

				var class_btncolor = btncolor != '' ? ' btn-' + btncolor : '';
				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<button type="' + button_type + '" name="' + name + '" id="' + name + '"' + attr_style + attr_onmouseover + attr_onmouseout + attr_onclick + attr_tabindex + attr_aria_label + attr_aria_describedby + attr_disabled + ' class="form-control btn' + class_btncolor + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + ' ' + input_class + '">' + content + '</button>';
			}
		}, 
		'button_group': {
			'title': 'Button Group', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-button-group-btncolor" class="col-sm-6 col-form-label">Btn-Color</label><div class="col-sm-6"><select name="bootstrap-component-button-group-btncolor" id="bootstrap-component-button-group-btncolor">' + bootstrap_options_btncolors + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-button-group-color" id="bootstrap-component-button-group-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-button-group-bgcolor" id="bootstrap-component-button-group-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-button-group-border-color" id="bootstrap-component-button-group-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-button-group-border-types" id="bootstrap-component-button-group-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-button-group-border-radius" id="bootstrap-component-button-group-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-button-group-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-button-group-style" id="bootstrap-component-button-group-style" value="" placeholder="width: 80%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-button-group-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-button-group-class" id="bootstrap-component-button-group-class" value="" placeholder="extra-class" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-button-group-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-button-group-content" id="bootstrap-component-button-group-content" cols="20" rows="8" placeholder="button|active|name_01|id_01|Label 1|alert(this.id)\nbutton||name_01|id_02|Label 2|alert(this.id)\nbutton||name_01|id_03|Label 3|alert(this.id)" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-button-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var btncolor = jQuery('#bootstrap-component-button-group-btncolor').val();

				var color = jQuery('#bootstrap-component-button-group-color').val();
				var bgcolor = jQuery('#bootstrap-component-button-group-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-button-group-border-color').val();
				var border_types = jQuery('#bootstrap-component-button-group-border-types').val();
				var border_radius = jQuery('#bootstrap-component-button-group-border-radius').val();

				var style = jQuery('#bootstrap-component-button-group-style').val();
				var button_group_class = jQuery('#bootstrap-component-button-group-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';
				
				var class_btncolor = btncolor != '' ? ' btn-' + btncolor : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';
				
				var content = jQuery('#bootstrap-component-button-group-content').val();
				var content_arr = content.split('\n');
				var content_str = '';

				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					var class_active = keyArr[1] != '' ? ' ' + keyArr[1] : '';
					var attr_onclick = keyArr[5] != '' ? ' onclick="' + keyArr[5] + '"' : '';
					content_str += '<button type="' + keyArr[0] + '" name="' + keyArr[2] + '" id="' + keyArr[3] + '"' + attr_style + attr_onclick + ' class="btn ' + button_group_class + class_btncolor + class_active + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">' + keyArr[4] + '</button>\n';
				}

				return 	'<div class="btn-group-toggle" data-toggle="buttons">\n' + content_str + '</div>';
			}
		}, 
		'card': {
			'title': 'Card', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-card-group" class="col-sm-6 col-form-label">Card-Group</label><div class="col-sm-6"><select name="bootstrap-component-card-group" id="bootstrap-component-card-group"><option value="">None Group</option><option value="card-group">Card-Group</option><option value="card-deck">Card-Deck</option><option value="card-columns">Card-Columns</option></select></div>' + 
					'	<label for="bootstrap-component-card-amount" class="col-sm-6 col-form-label">Card-Amount</label><div class="col-sm-6"><input type="number" name="bootstrap-component-card-amount" id="bootstrap-component-card-amount" value="1" /></div>' + 
					'	<label for="bootstrap-component-card-src-header" class="col-sm-6 col-form-label">Header-Img - Src</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-src-header" id="bootstrap-component-card-src-header" value="" placeholder="https://www...de/...jpg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-alt-header" class="col-sm-6 col-form-label">Header-Img - Alt</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-alt-header" id="bootstrap-component-card-alt-header" value="" placeholder="Alternative-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-overlay-header" class="col-sm-6 col-form-label">Header-Img - Overlay</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-card-overlay-header" id="bootstrap-component-card-overlay-header" value="1" /></div>' + 
					'	<label for="bootstrap-component-card-src-footer" class="col-sm-6 col-form-label">Footer-Img - Src</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-src-footer" id="bootstrap-component-card-src-footer" value="" placeholder="https://www...de/...jpg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-alt-footer" class="col-sm-6 col-form-label">Footer-Img - Alt</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-alt-footer" id="bootstrap-component-card-alt-footer" value="" placeholder="Alternative-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-header" class="col-sm-6 col-form-label">Card - Header</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-header" id="bootstrap-component-card-header" value="" placeholder="Header-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-title" class="col-sm-6 col-form-label">Card - Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-title" id="bootstrap-component-card-title" value="" placeholder="Title-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-subtitle" class="col-sm-6 col-form-label">Card - Sub-Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-subtitle" id="bootstrap-component-card-subtitle" value="" placeholder="SubTitle-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-text" class="col-sm-6 col-form-label">Card - Text</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-text" id="bootstrap-component-card-text" value="" placeholder="Text-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-footer" class="col-sm-6 col-form-label">Card - Footer</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-footer" id="bootstrap-component-card-footer" value="" placeholder="Footer-Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-text-align" class="col-sm-6 col-form-label">Card - Text-Align</label><div class="col-sm-6"><select name="bootstrap-component-card-text-align" id="bootstrap-component-card-text-align">' + bootstrap_options_text_align + '</select></div>' + 
					'	<label for="bootstrap-component-card-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-card-color" id="bootstrap-component-card-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-card-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-card-bgcolor" id="bootstrap-component-card-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-card-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-card-border-color" id="bootstrap-component-card-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-card-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-card-border-types" id="bootstrap-component-card-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-card-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-card-border-radius" id="bootstrap-component-card-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-card-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-style" id="bootstrap-component-card-style" value="" placeholder="width: 18rem" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-card-class" id="bootstrap-component-card-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-card-content" class="col-sm-6 col-form-label">Buttons</label><div class="col-sm-6"><textarea name="bootstrap-component-card-content" id="bootstrap-component-card-content" cols="20" rows="8" placeholder="#|primary|Label 1\n#|primary|Label 2" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label for="bootstrap-component-card-listgroup" class="col-sm-6 col-form-label">List-Group</label><div class="col-sm-6"><textarea name="bootstrap-component-card-listgroup" id="bootstrap-component-card-listgroup" cols="20" rows="8" placeholder="LiLable 1\nLiLabel 2\nLiLabel 3" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return 	$('#bootstrap-component-card-header').val() == '' && 
						$('#bootstrap-component-card-title').val() == '' && 
						$('#bootstrap-component-card-subtitle').val() == '' && 
						$('#bootstrap-component-card-text').val() == '' && 
						$('#bootstrap-component-card-footer').val() == '' && 
						$('#bootstrap-component-card-content').val() == '' && 
						$('#bootstrap-component-card-listgroup').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var card_group = jQuery('#bootstrap-component-card-group').val();
				var card_amount = jQuery('#bootstrap-component-card-amount').val();
				var src_header = jQuery('#bootstrap-component-card-src-header').val();
				var alt_header = jQuery('#bootstrap-component-card-alt-header').val();
				var overlay_header = jQuery('#bootstrap-component-card-overlay-header').attr('checked');

				var src_footer = jQuery('#bootstrap-component-card-src-footer').val();
				var alt_footer = jQuery('#bootstrap-component-card-alt-footer').val();

				var header = jQuery('#bootstrap-component-card-header').val();
				var title = jQuery('#bootstrap-component-card-title').val();
				var subtitle = jQuery('#bootstrap-component-card-subtitle').val();
				var text = jQuery('#bootstrap-component-card-text').val();
				var footer = jQuery('#bootstrap-component-card-footer').val();
				var text_align = jQuery('#bootstrap-component-card-text-align').val();

				var color = jQuery('#bootstrap-component-card-color').val();
				var bgcolor = jQuery('#bootstrap-component-card-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-card-border-color').val();
				var border_types = jQuery('#bootstrap-component-card-border-types').val();
				var border_radius = jQuery('#bootstrap-component-card-border-radius').val();

				var style = jQuery('#bootstrap-component-card-style').val();
				var card_class = jQuery('#bootstrap-component-card-class').val();

				var listgroup = jQuery('#bootstrap-component-card-listgroup').val();
				var listgroup_arr = listgroup.split('\n');
				var listgroup_str = '';

				for(var i = 0;i < listgroup_arr.length;i++){
					listgroup_str += listgroup_arr[i] != '' ? '<li class="list-group-item">' + listgroup_arr[i] + '</li>\n' : '';
				}

				listgroup_str = listgroup_str != '' ? '<ul class="list-group list-group-flush">' + listgroup_str + '</ul>\n' : '';
				var content = jQuery('#bootstrap-component-card-content').val();
				var content_arr = content.split('\n');
				var content_str = '';

				for(var i = 0;i < content_arr.length;i++){
					if(content_arr[i] != ''){
						var keyArr = content_arr[i].split('|');
						content_str += '<a href="' + keyArr[0] + '" class="btn btn-' + keyArr[1] + '">' + keyArr[2] + '</a>\n';
					}
				}

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_overlay_header = overlay_header == 'checked' ? ' card-img-overlay' : '';

				var class_text_align = text_align != '' ? ' text-' + text_align : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var tag_card_group_start = card_group != '' ? '<div class="' + card_group + '">\n' : '';
				var tag_card_group_end = card_group != '' ? '</div>\n' : '';

				var tag_img_header = src_header != '' ? '<img src="' + src_header + '" alt="' + alt_header + '" class="card-img-top" />\n' : '';
				var tag_header = header != '' ? '<h5 class="card-header">' + header + '</h5>\n' : '';
				var tag_title = title != '' ? '<h5 class="card-title">' + title + '</h5>\n' : '';
				var tag_subtitle = subtitle != '' ? '<h6 class="card-subtitle mb-2 text-muted">' + subtitle + '</h6>\n' : '';
				var tag_text = text != '' ? '<p class="card-text">' + text + '</p>\n' : '';
				var tag_footer = footer != '' ? '<div class="card-footer text-muted">\n' + footer + '</div>\n' : '';

				var tag_card_body = tag_header + 
									'<div class="card-body' + class_overlay_header + '">' + 
									tag_title + 
									tag_subtitle + 
									tag_text + 
									listgroup_str + 
									content_str + 
									'</div>' + 
									tag_footer;

				var tag_img_footer = src_footer != '' ? '<img src="' + src_footer + '" alt="' + alt_footer + '" class="card-img-bottom" />\n' : '';

				var card_content = '';

				for(var i = 0;i < card_amount;i++){
					card_content += '<div class="card ' + card_class + class_text_align + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '"' + attr_style + '>\n' + tag_img_header + tag_card_body + tag_img_footer + '</div>\n';
				}

				return 	tag_card_group_start + card_content + tag_card_group_end;
			}
		}, 
		'carousel': {
			'title': 'Carousel', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-carousel-id" class="col-sm-6 col-form-label">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-carousel-id" id="bootstrap-component-carousel-id" value="" placeholder="carousel_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-carousel-interval" class="col-sm-6 col-form-label">Interval</label><div class="col-sm-6"><input type="text" name="bootstrap-component-carousel-interval" id="bootstrap-component-carousel-interval" value="" placeholder="5000" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-carousel-keyboard" class="col-sm-6 col-form-label">Keyboard</label><div class="col-sm-6"><select name="bootstrap-component-carousel-keyboard" id="bootstrap-component-carousel-keyboard"><option value="true">True</option><option value="false">False</option></select></div>' + 
					'	<label for="bootstrap-component-carousel-pause" class="col-sm-6 col-form-label">Pause</label><div class="col-sm-6"><select name="bootstrap-component-carousel-pause" id="bootstrap-component-carousel-pause"><option value="hover">Hover</option><option value="false">False</option></select></div>' + 
					'	<label for="bootstrap-component-carousel-wrap" class="col-sm-6 col-form-label">Wrap</label><div class="col-sm-6"><select name="bootstrap-component-carousel-wrap" id="bootstrap-component-carousel-wrap"><option value="true">True</option><option value="false">False</option></select></div>' + 
					'	<label for="bootstrap-component-carousel-indicators" class="col-sm-6 col-form-label">Indicators</label><div class="col-sm-6"><select name="bootstrap-component-carousel-indicators" id="bootstrap-component-carousel-indicators"><option value="true">True</option><option value="false">False</option></select></div>' + 
					'	<label for="bootstrap-component-carousel-control" class="col-sm-6 col-form-label">Control</label><div class="col-sm-6"><select name="bootstrap-component-carousel-control" id="bootstrap-component-carousel-control"><option value="true">True</option><option value="false">False</option></select></div>' + 
					'	<label for="bootstrap-component-carousel-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-carousel-color" id="bootstrap-component-carousel-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-carousel-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-carousel-bgcolor" id="bootstrap-component-carousel-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-carousel-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-carousel-border-color" id="bootstrap-component-carousel-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-carousel-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-carousel-border-types" id="bootstrap-component-carousel-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-carousel-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-carousel-border-radius" id="bootstrap-component-carousel-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-carousel-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-carousel-style" id="bootstrap-component-carousel-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-carousel-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-carousel-class" id="bootstrap-component-carousel-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-carousel-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-carousel-content" id="bootstrap-component-carousel-content" cols="20" rows="8" placeholder="http://localhost/wordpress/wp-content/themes/bootstrap/img/carousel_1.jpg|Altanative 1...|Title 1...|Text 1...\nhttp://localhost/wordpress/wp-content/themes/bootstrap/img/carousel_2.jpg|Altanative 2...|Title 2...|Text 3...\nhttp://localhost/wordpress/wp-content/themes/bootstrap/img/carousel_3.jpg|Altanative 3...|Title 3...|Text 3..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-carousel-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-carousel-id').val();
				var interval = jQuery('#bootstrap-component-carousel-interval').val();
				var interval_ms = interval != '' ? interval : '5000';
				var keyboard = jQuery('#bootstrap-component-carousel-keyboard').val();
				var pause = jQuery('#bootstrap-component-carousel-pause').val();
				var wrap = jQuery('#bootstrap-component-carousel-wrap').val();
				var indicators = jQuery('#bootstrap-component-carousel-indicators').val();
				var control = jQuery('#bootstrap-component-carousel-control').val();

				var color = jQuery('#bootstrap-component-carousel-color').val();
				var bgcolor = jQuery('#bootstrap-component-carousel-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-carousel-border-color').val();
				var border_types = jQuery('#bootstrap-component-carousel-border-types').val();
				var border_radius = jQuery('#bootstrap-component-carousel-border-radius').val();

				var style = jQuery('#bootstrap-component-carousel-style').val();
				var carousel_class = jQuery('#bootstrap-component-carousel-class').val();

				var content = jQuery('#bootstrap-component-carousel-content').val();
				var content_arr = content.split('\n');
				var content_str = '';
				var content_indicators = '';
				var content_inner = '';
				var content_control = 	'	<a href="#' + id + '" class="carousel-control-prev" role="button" data-slide="prev">\n' + 
										'		<span style="background-color: black" class="carousel-control-prev-icon" aria-hidden="true"></span>\n' + 
										'		<span class="sr-only">Previous</span>\n' + 
										'	</a>\n' + 
										'	<a href="#' + id + '" class="carousel-control-next" role="button" data-slide="next">\n' + 
										'		<span style="background-color: black" class="carousel-control-next-icon" aria-hidden="true"></span>\n' + 
										'		<span class="sr-only">Next</span>\n' + 
										'	</a>\n';

				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					var attr_active = i == 0 ? ' class="active"' : '';
					var class_active = i == 0 ? ' active' : '';

					content_indicators += '	<li data-target="#' + id + '" data-slide-to="' + i + '"' + attr_active + '></li>\n';

					content_inner += 	'	<div class="carousel-item' + class_active + '">\n' + 
										'		<img src="' + keyArr[0] + '" alt="' + keyArr[1] + '" class="d-block w-100" \/>\n';
					content_inner += keyArr[2] != '' || keyArr[3] != '' ? '		<div class="carousel-caption d-none d-md-block">\n' : '';
					content_inner += keyArr[2] != '' ? '			<h5>' + keyArr[2] + '</h5>\n' : '';
					content_inner += keyArr[3] != '' ? '			<span>' + keyArr[3] + '</span>\n' : '';
					content_inner += keyArr[2] != '' || keyArr[3] != '' ? '		</div>\n' : '';
					content_inner += 	'	<\/div>\n';
				}

				content_str += content_indicators != '' && indicators == 'true' ? '	<ol class="carousel-indicators">\n' + content_indicators + '</ol>\n' : '';
				content_str += content_inner != '' ? 	'	<div class="carousel-inner">\n' + 
														content_inner + 
														'	</div>\n' : '';
				content_str += control == 'true' ? content_control : '';

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				return 	'<div id="' + id + '"' + attr_style + ' class="carousel slide ' + carousel_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '" data-interval="' + interval_ms + '" data-keyboard="' + keyboard + '" data-pause="' + pause + '" data-ride="carousel" data-wrap="' + wrap + '">' + content_str + '</div>';
			}
		}, 
		'collapse': {
			'title': 'Collapse', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-collapse-id" class="col-sm-6 col-form-label">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-collapse-id" id="bootstrap-component-collapse-id" value="" placeholder="collapse_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-collapse-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-collapse-color" id="bootstrap-component-collapse-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-collapse-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-collapse-bgcolor" id="bootstrap-component-collapse-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-collapse-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-collapse-border-color" id="bootstrap-component-collapse-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-collapse-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-collapse-border-types" id="bootstrap-component-collapse-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-collapse-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-collapse-border-radius" id="bootstrap-component-collapse-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-collapse-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-collapse-style" id="bootstrap-component-collapse-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-collapse-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-collapse-class" id="bootstrap-component-collapse-class" value="" placeholder="" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-collapse-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-collapse-content" id="bootstrap-component-collapse-content" cols="20" rows="8" placeholder="true|headingId_1|collapseId_1|Label 1...|Text 1...\nfalse|headingId_2|collapseId_2|Label 2...|Text 2...\nfalse|headingId_3|collapseId_3|Label 3...|Text 3..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-collapse-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-collapse-id').val();

				var color = jQuery('#bootstrap-component-collapse-color').val();
				var bgcolor = jQuery('#bootstrap-component-collapse-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-collapse-border-color').val();
				var border_types = jQuery('#bootstrap-component-collapse-border-types').val();
				var border_radius = jQuery('#bootstrap-component-collapse-border-radius').val();

				var style = jQuery('#bootstrap-component-collapse-style').val();
				var collapse_class = jQuery('#bootstrap-component-collapse-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var content = jQuery('#bootstrap-component-collapse-content').val();
				var content_arr = content.split('\n');
				var content_str = '';

				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					var show = keyArr[0] == 'true' ? ' show' : '';

					content_str += 	'  <div class="card">\n' + 
									'		<div class="card-header ' + collapse_class + class_bgcolor + class_border_types + class_border_color + class_border_radius + '" id="' + keyArr[1] + '">\n' + 
									'			<h5 class="mb-0">\n' + 
									'				<button class="btn btn-link" data-toggle="collapse" data-target="#' + keyArr[2] + '" aria-expanded="' + keyArr[0] + '" aria-controls="' + keyArr[2] + '">\n' + 
									'					' + keyArr[3] + '\n' + 
									'				</button>\n' + 
									'			</h5>\n' + 
									'		</div>\n' + 
									'		<div id="' + keyArr[2] + '" class="collapse' + show + '" aria-labelledby="' + keyArr[1] + '" data-parent="#' + id + '">\n' + 
									'			<div class="card-body' + class_color + '">\n' + 
									'				' + keyArr[4] + '\n' + 
									'			</div>\n' + 
									'		</div>\n' + 
									'	</div>\n';
				}

				return 	'<div id="' + id + '"' + attr_style + '>\n' + content_str + '</div>';
			}
		}, 
		'dropdown': {
			'title': 'Dropdown', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-dropdowns-label" class="col-sm-6 col-form-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-dropdowns-label" id="bootstrap-component-dropdowns-label" value="" placeholder="Button 1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-dropdowns-id" class="col-sm-6 col-form-label">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-dropdowns-id" id="bootstrap-component-dropdowns-id" value="" placeholder="dropdown_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-dropdowns-btncolor" class="col-sm-6 col-form-label">Button-Color</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-btncolor" id="bootstrap-component-dropdowns-btncolor">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-drop" class="col-sm-6 col-form-label">Drop</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-drop" id="bootstrap-component-dropdowns-drop"><option value="dropup">Up</option><option value="dropright">Right</option><option value="dropdown">Down</option><option value="dropleft">Left</option></select></div>' + 
					'	<label for="bootstrap-component-dropdowns-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-color" id="bootstrap-component-dropdowns-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-bgcolor" id="bootstrap-component-dropdowns-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-border-color" id="bootstrap-component-dropdowns-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-border-types" id="bootstrap-component-dropdowns-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-dropdowns-border-radius" id="bootstrap-component-dropdowns-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-dropdowns-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-dropdowns-style" id="bootstrap-component-dropdowns-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-dropdowns-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-dropdowns-class" id="bootstrap-component-dropdowns-class" value="" placeholder="btn-lg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-dropdowns-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-dropdowns-content" id="bootstrap-component-dropdowns-content" cols="20" rows="8" placeholder="item|active|enabled|#|Link 1...\nitem|normal|enabled|#|Link 2...\nitem|normal|disabled|#|Link 3...\ndivider||||\nheader||||Header 4" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-dropdowns-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var label = jQuery('#bootstrap-component-dropdowns-label').val();
				var id = jQuery('#bootstrap-component-dropdowns-id').val();
				var btncolor = jQuery('#bootstrap-component-dropdowns-btncolor').val();
				var drop = jQuery('#bootstrap-component-dropdowns-drop').val();

				var color = jQuery('#bootstrap-component-dropdowns-color').val();
				var bgcolor = jQuery('#bootstrap-component-dropdowns-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-dropdowns-border-color').val();
				var border_types = jQuery('#bootstrap-component-dropdowns-border-types').val();
				var border_radius = jQuery('#bootstrap-component-dropdowns-border-radius').val();

				var style = jQuery('#bootstrap-component-dropdowns-style').val();
				var dropdowns_class = jQuery('#bootstrap-component-dropdowns-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_btncolor = btncolor != '' ? ' btn-' + btncolor : '';
				var class_drop = drop != '' ? ' ' + drop : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var content = jQuery('#bootstrap-component-dropdowns-content').val();
				var content_arr = content.split('\n');
				var content_str = '';

				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					switch (keyArr[0]){
						case 'item': 
							var active = keyArr[1] == 'active' ? ' active' : '';
							var disabled = keyArr[2] == 'disabled' ? ' disabled' : '';
							content_str += '		<a class="dropdown-item' + active + disabled + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" href="' + keyArr[3] + '">' + keyArr[4] + '</a>\n';
							break;
						case 'header': 
							content_str += '		<h6 class="dropdown-header' + class_color + '">' + keyArr[4] + '</h6>\n';
							break;
						case 'divider': 
							content_str += '		<div class="dropdown-divider' + class_border_color + '"></div>\n';
							break;
					}
				}

				return 	'<div class="btn-group' + class_drop + '" id="' + id + '"' + attr_style + '>\n  <button type="button" class="btn dropdown-toggle ' + dropdowns_class + class_btncolor + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n		' + label + '\n  </button>\n  <div class="dropdown-menu">\n' + content_str + '	</div>\n</div>\n';
			}
		}, 
		'forms': {
			'title': 'Forms', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-component-forms-id" class="col-sm-6 col-form-label">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-id" id="bootstrap-component-forms-id" value="" placeholder="form_id" /></div>' + 
					'	<label for="bootstrap-component-forms-action" class="col-sm-6 col-form-label">Action</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-action" id="bootstrap-component-forms-action" value="" placeholder="/send..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-forms-method" class="col-sm-6 col-form-label">Method</label><div class="col-sm-6"><select name="bootstrap-component-forms-method" id="bootstrap-component-forms-method"><option value="post">Post</option><option value="get">Get</option></select></div>' + 
					'	<label for="bootstrap-component-forms-enctype" class="col-sm-6 col-form-label">EncType</label><div class="col-sm-6"><select name="bootstrap-component-forms-enctype" id="bootstrap-component-forms-enctype"><option value="text/plain">Text/Plain</option><option value="multipart/form-data">Multipart/Form-Data</option></select></div>' + 
					'	<label for="bootstrap-component-forms-target" class="col-sm-6 col-form-label">Target</label><div class="col-sm-6"><select name="bootstrap-component-forms-target" id="bootstrap-component-forms-target"><option value="_self">Self</option><option value="_blank">Blank</option><option value="_parent">Parent</option><option value="_top">Top</option></select></div>' + 
					'	<label for="bootstrap-component-forms-autocomplete" class="col-sm-6 col-form-label">Autocomplete</label><div class="col-sm-6"><select name="bootstrap-component-forms-autocomplete" id="bootstrap-component-forms-autocomplete"><option value="on">On</option><option value="off">Off</option></select></div>' + 
					'	<label for="bootstrap-component-forms-novalidate" class="col-sm-6 col-form-label">Validate</label><div class="col-sm-6"><select name="bootstrap-component-forms-novalidate" id="bootstrap-component-forms-novalidate"><option value="">Yes</option><option value="novalidate">No</option></select></div>' + 
					'	<label for="bootstrap-component-forms-inline" class="col-sm-6 col-form-label">InLine</label><div class="col-sm-6"><select name="bootstrap-component-forms-inline" id="bootstrap-component-forms-inline"><option value="">No</option><option value="form-inline">Yes</option></select></div>' + 
					'	<label for="bootstrap-component-forms-onsubmit" class="col-sm-6 col-form-label">OnSubmit</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-onsubmit" id="bootstrap-component-forms-onsubmit" value="" placeholder="checkForm_01()" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-forms-column-sizing" class="col-sm-6 col-form-label">Column - Sizing</label><div class="col-sm-6"><select name="bootstrap-component-forms-column-sizing" id="bootstrap-component-forms-column-sizing"><option value="1">&nbsp;1 - 11</option><option value="2">&nbsp;2 - 10</option><option value="3">&nbsp;3 -&nbsp;&nbsp;9</option><option value="4">&nbsp;4 -&nbsp;&nbsp;8</option><option value="5">&nbsp;5 -&nbsp;&nbsp;7</option><option value="6">&nbsp;6 -&nbsp;&nbsp;6</option><option value="7">&nbsp;7 -&nbsp;&nbsp;5</option><option value="8">&nbsp;8 -&nbsp;&nbsp;4</option><option value="9">&nbsp;9 -&nbsp;&nbsp;3</option><option value="10">10 -&nbsp;&nbsp;2</option><option value="11">11 -&nbsp;&nbsp;1</option></select></div>' + 
					'	<label for="bootstrap-component-forms-label-sizing" class="col-sm-6 col-form-label">Label - Sizing</label><div class="col-sm-6"><select name="bootstrap-component-forms-label-sizing" id="bootstrap-component-forms-label-sizing"><option value="">None</option><option value="col-form-label-sm">Small</option><option value="col-form-label-lg">Large</option></select></div>' + 
					'	<label for="bootstrap-component-forms-control-sizing" class="col-sm-6 col-form-label">Control - Sizing</label><div class="col-sm-6"><select name="bootstrap-component-forms-control-sizing" id="bootstrap-component-forms-control-sizing"><option value="">None</option><option value="form-control-sm">Small</option><option value="form-control-lg">Large</option></select></div>' + 
					'	<label for="bootstrap-component-forms-tooltips" class="col-sm-6 col-form-label">Tooltips</label><div class="col-sm-6"><select name="bootstrap-component-forms-tooltips" id="bootstrap-component-forms-tooltips"><option value="feedback">Feedback</option><option value="tooltip">Tooltip</option></select></div>' + 
					'	<label for="bootstrap-component-forms-margin-top" class="col-sm-6 col-form-label">Margin - Top</label><div class="col-sm-6"><select name="bootstrap-component-forms-margin-top" id="bootstrap-component-forms-margin-top"><option value="">None</option><option value="mt-0">0</option><option value="mt-1">jQueryspacer * .25</option><option value="mt-2">jQueryspacer * .5</option><option value="mt-3">jQueryspacer</option><option value="mt-4">jQueryspacer * 1.5</option><option value="mt-5">jQueryspacer * 3</option><option value="mt-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-margin-right" class="col-sm-6 col-form-label">Margin - Right</label><div class="col-sm-6"><select name="bootstrap-component-forms-margin-right" id="bootstrap-component-forms-margin-right"><option value="">None</option><option value="mr-0">0</option><option value="mr-1">jQueryspacer * .25</option><option value="mr-2">jQueryspacer * .5</option><option value="mr-3">jQueryspacer</option><option value="mr-4">jQueryspacer * 1.5</option><option value="mr-5">jQueryspacer * 3</option><option value="mr-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-margin-bottom" class="col-sm-6 col-form-label">Margin - Bottom</label><div class="col-sm-6"><select name="bootstrap-component-forms-margin-bottom" id="bootstrap-component-forms-margin-bottom"><option value="">None</option><option value="mb-0">0</option><option value="mb-1">jQueryspacer * .25</option><option value="mb-2">jQueryspacer * .5</option><option value="mb-3">jQueryspacer</option><option value="mb-4">jQueryspacer * 1.5</option><option value="mb-5">jQueryspacer * 3</option><option value="mb-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-margin-left" class="col-sm-6 col-form-label">Margin - Left</label><div class="col-sm-6"><select name="bootstrap-component-forms-margin-left" id="bootstrap-component-forms-margin-left"><option value="">None</option><option value="ml-0">0</option><option value="ml-1">jQueryspacer * .25</option><option value="ml-2">jQueryspacer * .5</option><option value="ml-3">jQueryspacer</option><option value="ml-4">jQueryspacer * 1.5</option><option value="ml-5">jQueryspacer * 3</option><option value="ml-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-padding-top" class="col-sm-6 col-form-label">Padding - Top</label><div class="col-sm-6"><select name="bootstrap-component-forms-padding-top" id="bootstrap-component-forms-padding-top"><option value="">None</option><option value="pt-0">0</option><option value="pt-1">jQueryspacer * .25</option><option value="pt-2">jQueryspacer * .5</option><option value="pt-3">jQueryspacer</option><option value="pt-4">jQueryspacer * 1.5</option><option value="pt-5">jQueryspacer * 3</option><option value="pt-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-padding-right" class="col-sm-6 col-form-label">Padding - Right</label><div class="col-sm-6"><select name="bootstrap-component-forms-padding-right" id="bootstrap-component-forms-padding-right"><option value="">None</option><option value="pr-0">0</option><option value="pr-1">jQueryspacer * .25</option><option value="pr-2">jQueryspacer * .5</option><option value="pr-3">jQueryspacer</option><option value="pr-4">jQueryspacer * 1.5</option><option value="pr-5">jQueryspacer * 3</option><option value="pr-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-padding-bottom" class="col-sm-6 col-form-label">Padding - Bottom</label><div class="col-sm-6"><select name="bootstrap-component-forms-padding-bottom" id="bootstrap-component-forms-padding-bottom"><option value="">None</option><option value="pb-0">0</option><option value="pb-1">jQueryspacer * .25</option><option value="pb-2">jQueryspacer * .5</option><option value="pb-3">jQueryspacer</option><option value="pb-4">jQueryspacer * 1.5</option><option value="pb-5">jQueryspacer * 3</option><option value="pb-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-padding-left" class="col-sm-6 col-form-label">Padding - Left</label><div class="col-sm-6"><select name="bootstrap-component-forms-padding-left" id="bootstrap-component-forms-padding-left"><option value="">None</option><option value="pl-0">0</option><option value="pl-1">jQueryspacer * .25</option><option value="pl-2">jQueryspacer * .5</option><option value="pl-3">jQueryspacer</option><option value="pl-4">jQueryspacer * 1.5</option><option value="pl-5">jQueryspacer * 3</option><option value="pl-auto">Auto</option></select></div>' + 
					'	<label for="bootstrap-component-forms-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-color" id="bootstrap-component-forms-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-bgcolor" id="bootstrap-component-forms-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-border-color" id="bootstrap-component-forms-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-forms-border-types" id="bootstrap-component-forms-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-forms-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-forms-border-radius" id="bootstrap-component-forms-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-forms-button-label" class="col-sm-6 col-form-label">Button - Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-button-label" id="bootstrap-component-forms-button-label" value="" placeholder="Submit..." /></div>' + 
					'	<label for="bootstrap-component-forms-button-onclick" class="col-sm-6 col-form-label">Button - OnClick</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-button-onclick" id="bootstrap-component-forms-button-onclick" value="" placeholder="jQuery(\'#form_01\').on(\'submit\', function(event){if (this.checkValidity() === false) {event.preventDefault();event.stopPropagation();}this.classList.add(\'was-validated\');});" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-forms-button-color" class="col-sm-6 col-form-label">Button - Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-button-color" id="bootstrap-component-forms-button-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-button-bgcolor" class="col-sm-6 col-form-label">Button - Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-button-bgcolor" id="bootstrap-component-forms-button-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-button-border-color" class="col-sm-6 col-form-label">Button - Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-forms-button-border-color" id="bootstrap-component-forms-button-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-component-forms-button-border-types" class="col-sm-6 col-form-label">Button - Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-forms-button-border-types" id="bootstrap-component-forms-button-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-component-forms-button-border-radius" class="col-sm-6 col-form-label">Button - Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-forms-button-border-radius" id="bootstrap-component-forms-button-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-component-forms-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-style" id="bootstrap-component-forms-style" value="" placeholder="width: 60%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-forms-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-forms-class" id="bootstrap-component-forms-class" value="" placeholder="needs-validation" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-component-forms-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><select id="bootstrap-component-forms-content-select" style="width: 160px">' + bootstrap_forms_options_types + '</select><input type="button" id="bootstrap-component-forms-content-button" value="Add" style="width: 40px" /><br /><textarea name="bootstrap-component-forms-content" id="bootstrap-component-forms-content" cols="20" rows="8" placeholder="text|input_01|input_01|Label 01|||undefined|undefined|checked|Help...|Valid...|Invalid|2|10||normal|checked|||||\ntext|input_02|input_02|Label 02|||undefined|undefined|checked|Help...|Valid...|Invalid...|2|10||light|checked|warning||||" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-forms-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-forms-id').val();
				var action = jQuery('#bootstrap-component-forms-action').val();
				var method = jQuery('#bootstrap-component-forms-method').val();
				var enctype = jQuery('#bootstrap-component-forms-enctype').val();
				var target = jQuery('#bootstrap-component-forms-target').val();
				var autocomplete = jQuery('#bootstrap-component-forms-autocomplete').val();
				var novalidate = jQuery('#bootstrap-component-forms-novalidate').val();
				var inline = jQuery('#bootstrap-component-forms-inline').val();
				var onsubmit = jQuery('#bootstrap-component-forms-onsubmit').val();

				var column_sizing = jQuery('#bootstrap-component-forms-column-sizing').val();

				var label_sizing = jQuery('#bootstrap-component-forms-label-sizing').val();
				var control_sizing = jQuery('#bootstrap-component-forms-control-sizing').val();

				var tooltips = jQuery('#bootstrap-component-forms-tooltips').val();

				var margin_top = jQuery('#bootstrap-component-forms-margin-top').val();
				var margin_right = jQuery('#bootstrap-component-forms-margin-right').val();
				var margin_bottom = jQuery('#bootstrap-component-forms-margin-bottom').val();
				var margin_left = jQuery('#bootstrap-component-forms-margin-left').val();

				var padding_top = jQuery('#bootstrap-component-forms-padding-top').val();
				var padding_right = jQuery('#bootstrap-component-forms-padding-right').val();
				var padding_bottom = jQuery('#bootstrap-component-forms-padding-bottom').val();
				var padding_left = jQuery('#bootstrap-component-forms-padding-left').val();

				var color = jQuery('#bootstrap-component-forms-color').val();
				var bgcolor = jQuery('#bootstrap-component-forms-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-forms-border-color').val();
				var border_types = jQuery('#bootstrap-component-forms-border-types').val();
				var border_radius = jQuery('#bootstrap-component-forms-border-radius').val();

				var button_label = jQuery('#bootstrap-component-forms-button-label').val();
				var button_onclick = jQuery('#bootstrap-component-forms-button-onclick').val();

				var button_color = jQuery('#bootstrap-component-forms-button-color').val();
				var button_bgcolor = jQuery('#bootstrap-component-forms-button-bgcolor').val();
				var button_border_color = jQuery('#bootstrap-component-forms-button-border-color').val();
				var button_border_types = jQuery('#bootstrap-component-forms-button-border-types').val();
				var button_border_radius = jQuery('#bootstrap-component-forms-button-border-radius').val();

				var style = jQuery('#bootstrap-component-forms-style').val();
				var forms_class = jQuery('#bootstrap-component-forms-class').val();

				var attr_id = id != '' ? ' id="' + id + '"' : '';
				var attr_name = id != '' ? ' name="' + id + '"' : '';
				var attr_action = action != '' ? ' action="' + action + '"' : '';
				var attr_method = method != '' ? ' method="' + method + '"' : '';
				var attr_style = style != '' ? ' style="' + style + '"' : '';
				var attr_novalidate = novalidate != '' ? ' novalidate="' + novalidate + '"' : '';
				var attr_onsubmit = onsubmit != '' ? ' onsubmit="' + onsubmit + '"' : '';

				var attr_button_onclick = button_onclick != '' ? ' onclick="' + button_onclick + '"' : '';

				var class_inline = inline != '' ? ' ' + inline : '';

				var class_label_sizing = label_sizing != '' ? ' ' + label_sizing : '';
				var class_control_sizing = control_sizing != '' ? ' ' + control_sizing : '';

				var class_margin_top = margin_top != '' ? ' ' + margin_top : '';
				var class_margin_right = margin_right != '' ? ' ' + margin_right : '';
				var class_margin_bottom = margin_bottom != '' ? ' ' + margin_bottom : '';
				var class_margin_left = margin_left != '' ? ' ' + margin_left : '';

				var class_padding_top = padding_top != '' ? ' ' + padding_top : '';
				var class_padding_right = padding_right != '' ? ' ' + padding_right : '';
				var class_padding_bottom = padding_bottom != '' ? ' ' + padding_bottom : '';
				var class_padding_left = padding_left != '' ? ' ' + padding_left : '';

				var class_form_color = color != '' ? ' text-' + color : '';
				var class_form_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_form_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_form_border_types = border_types != '' ? ' ' + border_types : '';
				var class_form_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_button_color = button_color != '' ? ' text-' + button_color : '';
				var class_button_bgcolor = button_bgcolor != '' ? ' btn-' + button_bgcolor : '';
				var class_button_border_color = button_border_color != '' ? ' border-' + button_border_color : '';
				var class_button_border_types = button_border_types != '' ? ' ' + button_border_types : '';
				var class_button_border_radius = button_border_radius != '' ? ' ' + button_border_radius : '';

				var content = jQuery('#bootstrap-component-forms-content').val();
				var content_arr = content.split('\n');
				var content_str = '';
				var content_hidden = '';
				for(var i = 0;i < content_arr.length;i++){
					var keyArr = content_arr[i].split('|');
					switch (keyArr[0]){
						case 'text': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'textarea': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_rows = keyArr[12] != '' ? ' rows="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<textarea id="' + keyArr[1] + '" name="' + keyArr[2] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_rows + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '">' + keyArr[4] + '</textarea>\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'search': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'password': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'tel': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'url': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'email': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'date': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'datetime-local': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'week': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'month': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'time': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_onkeyup = keyArr[14] != '' ? ' onkeyup="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' pattern="[0-9]{2}:[0-9]{2}" class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'number': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_step = keyArr[14] != '' ? ' step="' + keyArr[14] + '"' : '';
							var attr_onkeyup = keyArr[15] != '' ? ' onkeyup="' + keyArr[15] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[16] != '' ? ' font-weight-' + keyArr[16] : '';
							var class_font_italic = keyArr[17] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[18] != '' ? ' text-' + keyArr[18] : '';
							var class_bgcolor = keyArr[19] != '' ? ' bg-' + keyArr[19] : '';
							var class_border_color = keyArr[20] != '' ? ' border-' + keyArr[20] : '';
							var class_border_types = keyArr[21] != '' ? ' ' + keyArr[21] : '';
							var class_border_radius = keyArr[22] != '' ? ' ' + keyArr[22] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'range': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_min = keyArr[12] != '' ? ' min="' + keyArr[12] + '"' : '';
							var attr_max = keyArr[13] != '' ? ' max="' + keyArr[13] + '"' : '';
							var attr_step = keyArr[14] != '' ? ' step="' + keyArr[14] + '"' : '';
							var attr_onkeyup = keyArr[15] != '' ? ' onkeyup="' + keyArr[15] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[16] != '' ? ' font-weight-' + keyArr[16] : '';
							var class_font_italic = keyArr[17] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[18] != '' ? ' text-' + keyArr[18] : '';
							var class_bgcolor = keyArr[19] != '' ? ' bg-' + keyArr[19] : '';
							var class_border_color = keyArr[20] != '' ? ' border-' + keyArr[20] : '';
							var class_border_types = keyArr[21] != '' ? ' ' + keyArr[21] : '';
							var class_border_radius = keyArr[22] != '' ? ' ' + keyArr[22] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_min + attr_max + attr_onkeyup + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'radio': 

							var attr_disabled = keyArr[3] == 'checked' ? ' disabled="disabled"' : '';
							var attr_required = keyArr[4] == 'checked' ? ' required="required"' : '';
							var class_disabled = keyArr[3] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[8] != '' ? ' font-weight-' + keyArr[8] : '';
							var class_font_italic = keyArr[9] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[10] != '' ? ' text-' + keyArr[10] : '';
							var class_bgcolor = keyArr[11] != '' ? ' bg-' + keyArr[11] : '';
							var class_border_color = keyArr[12] != '' ? ' border-' + keyArr[12] : '';
							var class_border_types = keyArr[13] != '' ? ' ' + keyArr[13] : '';
							var class_border_radius = keyArr[14] != '' ? ' ' + keyArr[14] : '';

							var tag_help = keyArr[5] != '' ? 	'			<small class="form-text text-muted">\n' + 
																'				' + keyArr[5] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[6] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[6] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[7] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[7] + '\n' + 
																	'			</div>\n' : '';
							radios_str = '';
							var radiosArr = keyArr[15].split('^');
							for(var i = 0;i < radiosArr.length;i++){
								var radios_opt = radiosArr[i].split('~');
								var tag_label = radios_opt[1] != '' ? 	'				<label for="' + radios_opt[0] + '" class="custom-control-label">\n' + 
																		'					' + radios_opt[1] + '\n' + 
																		'				</label>\n' : '';
								var attr_checked = radios_opt[3] == 'checked' ? ' checked="checked"' : '';
								radios_str += 	'			<div class="custom-control custom-radio">\n' + 
												'				<input type="' + keyArr[0] + '" name="' + keyArr[1] + '" id="' + radios_opt[0] + '" value="' + radios_opt[2] + '"' + attr_disabled + attr_required + attr_checked + ' class="custom-control-input' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
												tag_label + 
												tag_valid + 
												tag_invalid + 
												'			</div>\n';
							}
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<div class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[2] + '</div>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											radios_str + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'checkbox': 
							var attr_disabled = keyArr[2] == 'checked' ? ' disabled="disabled"' : '';
							var attr_required = keyArr[3] == 'checked' ? ' required="required"' : '';
							var class_disabled = keyArr[2] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[7] != '' ? ' font-weight-' + keyArr[7] : '';
							var class_font_italic = keyArr[8] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[9] != '' ? ' text-' + keyArr[9] : '';
							var class_bgcolor = keyArr[10] != '' ? ' bg-' + keyArr[10] : '';
							var class_border_color = keyArr[11] != '' ? ' border-' + keyArr[11] : '';
							var class_border_types = keyArr[12] != '' ? ' ' + keyArr[12] : '';
							var class_border_radius = keyArr[13] != '' ? ' ' + keyArr[13] : '';

							var tag_help = keyArr[4] != '' ? 	'			<small class="form-text text-muted">\n' + 
																'				' + keyArr[4] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[5] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[5] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[6] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[6] + '\n' + 
																	'			</div>\n' : '';
							radios_str = '';
							var radiosArr = keyArr[14].split('^');
							for(var i = 0;i < radiosArr.length;i++){
								var radios_opt = radiosArr[i].split('~');
								var tag_label = radios_opt[2] != '' ? 	'				<label for="' + radios_opt[1] + '" class="custom-control-label">\n' + 
																		'					' + radios_opt[2] + '\n' + 
																		'				</label>\n' : '';
								var attr_checked = radios_opt[4] == 'checked' ? ' checked="checked"' : '';
								radios_str += 	'			<div class="custom-control custom-checkbox">\n' + 
												'				<input type="' + keyArr[0] + '" name="' + radios_opt[0] + '" id="' + radios_opt[1] + '" value="' + radios_opt[3] + '"' + attr_disabled + attr_required + attr_checked + ' class="custom-control-input' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" />\n' + 
												tag_label + 
												tag_valid + 
												tag_invalid + 
												'			</div>\n';
							}
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<div class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[1] + '</div>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											radios_str + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'select': 

							var attr_disabled = keyArr[4] == 'checked' ? ' disabled="disabled"' : '';
							var attr_required = keyArr[5] == 'checked' ? ' required="required"' : '';
							var attr_size = keyArr[9] != '' ? ' size="' + keyArr[9] + '"' : '';
							var attr_multiple = keyArr[10] == 'checked' ? ' multiple="multiple"' : '';
							var attr_onchange = keyArr[11] != '' ? ' onchange="' + keyArr[11] + '"' : '';
							var class_disabled = keyArr[4] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[12] != '' ? ' font-weight-' + keyArr[12] : '';
							var class_font_italic = keyArr[13] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[14] != '' ? ' text-' + keyArr[14] : '';
							var class_bgcolor = keyArr[15] != '' ? ' bg-' + keyArr[15] : '';
							var class_border_color = keyArr[16] != '' ? ' border-' + keyArr[16] : '';
							var class_border_types = keyArr[17] != '' ? ' ' + keyArr[17] : '';
							var class_border_radius = keyArr[18] != '' ? ' ' + keyArr[18] : '';

							var tag_help = keyArr[6] != '' ? 	'			<small class="form-text text-muted">\n' + 
																'				' + keyArr[6] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[7] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[7] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[8] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[8] + '\n' + 
																	'			</div>\n' : '';
							options_str = '';
							var optionsArr = keyArr[19].split('^');
							for(var i = 0;i < optionsArr.length;i++){
								var options_opt = optionsArr[i].split('~');
								var options_selected = options_opt[2] == 'selected' ? ' selected="selected"' : '';
								options_str += 	'			<option value="' + options_opt[1] + '"' + options_selected + '>\n' + 
												'				' + options_opt[0] + '\n' + 
												'			</option>\n';
							}
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label pt-0' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<select name="' + keyArr[2] + '" id="' + keyArr[1] + '"' + attr_disabled + attr_required + attr_size + attr_multiple + attr_onchange + ' class="custom-select' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '">\n' + 
											options_str + 
											'			</select>\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'file': 
							var attr_disabled = keyArr[5] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[6] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[7] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[8] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_accept = keyArr[11] != '' ? ' accept="' + keyArr[11] + '"' : '';
							var attr_multiple = keyArr[12] == 'checked' ? ' multiple="multiple"' : '';
							var attr_onchange = keyArr[13] != '' ? ' onchange="' + keyArr[13] + '"' : '';
							var class_disabled = keyArr[5] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[14] != '' ? ' font-weight-' + keyArr[14] : '';
							var class_font_italic = keyArr[15] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[16] != '' ? ' text-' + keyArr[16] : '';
							var class_bgcolor = keyArr[17] != '' ? ' bg-' + keyArr[17] : '';
							var class_border_color = keyArr[18] != '' ? ' border-' + keyArr[18] : '';
							var class_border_types = keyArr[19] != '' ? ' ' + keyArr[19] : '';
							var class_border_radius = keyArr[20] != '' ? ' ' + keyArr[20] : '';

							var tag_help = keyArr[8] != '' ? 	'				<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'					' + keyArr[8] + '\n' + 
																'				</small>\n' : '';
							var tag_valid = keyArr[9] != '' ? 	'				<div class="valid-' + tooltips + '">\n' + 
																'					' + keyArr[9] + '\n' + 
																'				</div>\n' : '';
							var tag_invalid = keyArr[10] != '' ? 	'				<div class="invalid-' + tooltips + '">\n' + 
																	'					' + keyArr[10] + '\n' + 
																	'				</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<div class="custom-file">\n' + 
											'				<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value=""' + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_accept + attr_multiple + attr_onchange + ' class="custom-file-input' + class_control_sizing + '" />\n' + 
											'				<label class="custom-file-label' + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" for="' + keyArr[1] + '">' + keyArr[4] + '</label>\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'			</div>\n' + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'color': 
							var attr_placeholder = keyArr[5] != '' ? ' placeholder="' + keyArr[5] + '"' : '';
							var attr_disabled = keyArr[6] == 'checked' ? ' disabled="disabled"' : '';
							var attr_readonly = keyArr[7] == 'checked' ? ' readonly="readonly"' : '';
							var attr_required = keyArr[8] == 'checked' ? ' required="required"' : '';
							var attr_aria_label = keyArr[3] != '' ? ' aria-label="' + keyArr[3] + '"' : '';
							var attr_aria_describedby = keyArr[9] != '' ? ' aria-describedby="' + keyArr[1] + 'HelpBlock"' : '';
							var attr_minlength = keyArr[12] != '' ? ' minlength="' + keyArr[12] + '"' : '';
							var attr_maxlength = keyArr[13] != '' ? ' maxlength="' + keyArr[13] + '"' : '';
							var attr_onchange = keyArr[14] != '' ? ' onchange="' + keyArr[14] + '"' : '';
							var class_disabled = keyArr[6] == 'checked' ? ' disabled' : '';

							var class_font_weight = keyArr[15] != '' ? ' font-weight-' + keyArr[15] : '';
							var class_font_italic = keyArr[16] == 'checked' ? ' font-italic' : '';

							var class_color = keyArr[17] != '' ? ' text-' + keyArr[17] : '';
							var class_bgcolor = keyArr[18] != '' ? ' bg-' + keyArr[18] : '';
							var class_border_color = keyArr[19] != '' ? ' border-' + keyArr[19] : '';
							var class_border_types = keyArr[20] != '' ? ' ' + keyArr[20] : '';
							var class_border_radius = keyArr[21] != '' ? ' ' + keyArr[21] : '';

							var tag_help = keyArr[9] != '' ? 	'			<small id="' + keyArr[1] + 'HelpBlock" class="form-text text-muted">\n' + 
																'				' + keyArr[9] + '\n' + 
																'			</small>\n' : '';
							var tag_valid = keyArr[10] != '' ? 	'			<div class="valid-' + tooltips + '">\n' + 
																'				' + keyArr[10] + '\n' + 
																'			</div>\n' : '';
							var tag_invalid = keyArr[11] != '' ? 	'			<div class="invalid-' + tooltips + '">\n' + 
																	'				' + keyArr[11] + '\n' + 
																	'			</div>\n' : '';
											
							content_str += 	'	<div class="form-group row' + class_disabled + '">\n' + 
											'		<label for="' + keyArr[1] + '" class="col-sm-' + column_sizing + ' col-form-label' + class_label_sizing + class_font_weight + class_font_italic + class_color + '">' + keyArr[3] + '</label>\n' + 
											'		<div class="col-sm-' + (12 - column_sizing) + '">\n' + 
											'			<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[4] + '"' + attr_placeholder + attr_readonly + attr_required + attr_aria_label + attr_aria_describedby + attr_minlength + attr_maxlength + attr_onchange + ' class="form-control' + class_control_sizing + class_font_weight + class_font_italic + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" style="padding: .3rem;height: 2.5rem" />\n' + 
											tag_valid + 
											tag_invalid + 
											tag_help + 
											'		</div>\n' + 
											'	</div>\n';
							break;
						case 'hidden': 
							var attr_required = keyArr[4] == 'checked' ? ' required="required"' : '';
							var attr_minlength = keyArr[5] != '' ? ' minlength="' + keyArr[5] + '"' : '';
							var attr_maxlength = keyArr[6] != '' ? ' maxlength="' + keyArr[6] + '"' : '';
							
							content_hidden += 	'	<input type="' + keyArr[0] + '" id="' + keyArr[1] + '" name="' + keyArr[2] + '" value="' + keyArr[3] + '"' + attr_required + attr_minlength + attr_maxlength + ' />\n';
							break;
					}
				}
				var button = button_label != '' ? '	<button type="submit"' + attr_button_onclick + ' class="btn' + class_button_color + class_button_bgcolor + class_button_border_types + class_button_border_color + class_button_border_radius + '">' + button_label + '</button>\n' : '';

				return 	'<form' + attr_id + attr_name + attr_action + attr_method + attr_style + attr_novalidate + attr_onsubmit + ' enctype="' + enctype + '" target="' + target + '" autocomplete="' + autocomplete + '" class="' + forms_class + class_inline + class_margin_top + class_margin_right + class_margin_bottom + class_margin_left + class_padding_top + class_padding_right + class_padding_bottom + class_padding_left + class_form_color + class_form_bgcolor + class_form_border_types + class_form_border_color + class_form_border_radius + '">' + content_hidden + content_str + button + '</form>\n';
			}
		}, 
		'forms_text': {
			'title': 'Forms Text', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-id" id="bootstrap-forms-text-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-name" id="bootstrap-forms-text-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-label" id="bootstrap-forms-text-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-value" id="bootstrap-forms-text-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-placeholder" id="bootstrap-forms-text-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-text-disabled" id="bootstrap-forms-text-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-text-readonly" id="bootstrap-forms-text-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-text-required" id="bootstrap-forms-text-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-help" id="bootstrap-forms-text-help" value="" placeholder="Help..." /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-valid" id="bootstrap-forms-text-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-invalid" id="bootstrap-forms-text-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-minlength" id="bootstrap-forms-text-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-maxlength" id="bootstrap-forms-text-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-text-onkeyup" id="bootstrap-forms-text-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-text-font-weight" id="bootstrap-forms-text-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-text-font-italic" id="bootstrap-forms-text-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-text-color" id="bootstrap-forms-text-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-text-bgcolor" id="bootstrap-forms-text-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-text-border-color" id="bootstrap-forms-text-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-text-border-types" id="bootstrap-forms-text-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-text-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-text-border-radius" id="bootstrap-forms-text-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-text-name').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-text-id').val();
				var name = jQuery('#bootstrap-forms-text-name').val();
				var label = jQuery('#bootstrap-forms-text-label').val();
				var value = jQuery('#bootstrap-forms-text-value').val();
				var placeholder = jQuery('#bootstrap-forms-text-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-text-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-text-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-text-required').attr("checked");
				var help = jQuery('#bootstrap-forms-text-help').val();
				var valid = jQuery('#bootstrap-forms-text-valid').val();
				var invalid = jQuery('#bootstrap-forms-text-invalid').val();
				var minlength = jQuery('#bootstrap-forms-text-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-text-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-text-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-text-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-text-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-text-color').val();
				var bgcolor = jQuery('#bootstrap-forms-text-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-text-border-color').val();
				var border_types = jQuery('#bootstrap-forms-text-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-text-border-radius').val();

				var content = 'text|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);
				return 	'';
			}
		}, 
		'forms_textarea': {
			'title': 'Forms Textarea', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-id" id="bootstrap-forms-textarea-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-name" id="bootstrap-forms-textarea-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-label" id="bootstrap-forms-textarea-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-value" id="bootstrap-forms-textarea-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-placeholder" id="bootstrap-forms-textarea-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-textarea-disabled" id="bootstrap-forms-textarea-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-textarea-readonly" id="bootstrap-forms-textarea-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-textarea-required" id="bootstrap-forms-textarea-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-help" id="bootstrap-forms-textarea-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-valid" id="bootstrap-forms-textarea-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-invalid" id="bootstrap-forms-textarea-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-rows">Rows</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-rows" id="bootstrap-forms-textarea-rows" value="" placeholder="6" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-maxlength" id="bootstrap-forms-textarea-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-textarea-onkeyup" id="bootstrap-forms-textarea-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-font-weight" id="bootstrap-forms-textarea-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-textarea-font-italic" id="bootstrap-forms-textarea-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-color" id="bootstrap-forms-textarea-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-bgcolor" id="bootstrap-forms-textarea-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-border-color" id="bootstrap-forms-textarea-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-border-types" id="bootstrap-forms-textarea-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-textarea-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-textarea-border-radius" id="bootstrap-forms-textarea-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-textarea-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-textarea-id').val();
				var name = jQuery('#bootstrap-forms-textarea-name').val();
				var label = jQuery('#bootstrap-forms-textarea-label').val();
				var value = jQuery('#bootstrap-forms-textarea-value').val();
				var placeholder = jQuery('#bootstrap-forms-textarea-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-textarea-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-textarea-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-textarea-required').attr("checked");
				var help = jQuery('#bootstrap-forms-textarea-help').val();
				var valid = jQuery('#bootstrap-forms-textarea-valid').val();
				var invalid = jQuery('#bootstrap-forms-textarea-invalid').val();
				var rows = jQuery('#bootstrap-forms-textarea-rows').val();
				var maxlength = jQuery('#bootstrap-forms-textarea-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-textarea-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-textarea-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-textarea-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-textarea-color').val();
				var bgcolor = jQuery('#bootstrap-forms-textarea-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-textarea-border-color').val();
				var border_types = jQuery('#bootstrap-forms-textarea-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-textarea-border-radius').val();

				var content = 'textarea|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + rows + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_search': {
			'title': 'Forms Search', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-id" id="bootstrap-forms-search-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-name" id="bootstrap-forms-search-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-label" id="bootstrap-forms-search-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-value" id="bootstrap-forms-search-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-placeholder" id="bootstrap-forms-search-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-search-disabled" id="bootstrap-forms-search-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-search-readonly" id="bootstrap-forms-search-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-search-required" id="bootstrap-forms-search-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-help" id="bootstrap-forms-search-help" value="" placeholder="Help..." /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-valid" id="bootstrap-forms-search-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-invalid" id="bootstrap-forms-search-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-minlength" id="bootstrap-forms-search-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-maxlength" id="bootstrap-forms-search-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-search-onkeyup" id="bootstrap-forms-search-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-search-font-weight" id="bootstrap-forms-search-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-search-font-italic" id="bootstrap-forms-search-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-search-color" id="bootstrap-forms-search-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-search-bgcolor" id="bootstrap-forms-search-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-search-border-color" id="bootstrap-forms-search-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-search-border-types" id="bootstrap-forms-search-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-search-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-search-border-radius" id="bootstrap-forms-search-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-search-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-search-id').val();
				var name = jQuery('#bootstrap-forms-search-name').val();
				var label = jQuery('#bootstrap-forms-search-label').val();
				var value = jQuery('#bootstrap-forms-search-value').val();
				var placeholder = jQuery('#bootstrap-forms-search-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-search-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-search-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-search-required').attr("checked");
				var help = jQuery('#bootstrap-forms-search-help').val();
				var valid = jQuery('#bootstrap-forms-search-valid').val();
				var invalid = jQuery('#bootstrap-forms-search-invalid').val();
				var minlength = jQuery('#bootstrap-forms-search-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-search-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-search-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-search-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-search-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-search-color').val();
				var bgcolor = jQuery('#bootstrap-forms-search-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-search-border-color').val();
				var border_types = jQuery('#bootstrap-forms-search-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-search-border-radius').val();

				var content = 'search|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_tel': {
			'title': 'Forms Tel', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-id">Id</label><<div class="col-sm-6">input type="text" name="bootstrap-forms-tel-id" id="bootstrap-forms-tel-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-name" id="bootstrap-forms-tel-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-label" id="bootstrap-forms-tel-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-value" id="bootstrap-forms-tel-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-placeholder" id="bootstrap-forms-tel-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-tel-disabled" id="bootstrap-forms-tel-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-tel-readonly" id="bootstrap-forms-tel-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-tel-required" id="bootstrap-forms-tel-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-help" id="bootstrap-forms-tel-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-valid" id="bootstrap-forms-tel-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-invalid" id="bootstrap-forms-tel-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-minlength" id="bootstrap-forms-tel-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-maxlength" id="bootstrap-forms-tel-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-tel-onkeyup" id="bootstrap-forms-tel-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-tel-font-weight" id="bootstrap-forms-tel-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-tel-font-italic" id="bootstrap-forms-tel-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-tel-color" id="bootstrap-forms-tel-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-tel-bgcolor" id="bootstrap-forms-tel-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-tel-border-color" id="bootstrap-forms-tel-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-tel-border-types" id="bootstrap-forms-tel-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-tel-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-tel-border-radius" id="bootstrap-forms-tel-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-tel-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-tel-id').val();
				var name = jQuery('#bootstrap-forms-tel-name').val();
				var label = jQuery('#bootstrap-forms-tel-label').val();
				var value = jQuery('#bootstrap-forms-tel-value').val();
				var placeholder = jQuery('#bootstrap-forms-tel-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-tel-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-tel-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-tel-required').attr("checked");
				var help = jQuery('#bootstrap-forms-tel-help').val();
				var valid = jQuery('#bootstrap-forms-tel-valid').val();
				var invalid = jQuery('#bootstrap-forms-tel-invalid').val();
				var minlength = jQuery('#bootstrap-forms-tel-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-tel-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-tel-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-tel-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-tel-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-tel-color').val();
				var bgcolor = jQuery('#bootstrap-forms-tel-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-tel-border-color').val();
				var border_types = jQuery('#bootstrap-forms-tel-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-tel-border-radius').val();

				var content = 'tel|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_url': {
			'title': 'Forms URL', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-id" id="bootstrap-forms-url-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-name" id="bootstrap-forms-url-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-label" id="bootstrap-forms-url-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-value" id="bootstrap-forms-url-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-placeholder" id="bootstrap-forms-url-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-url-disabled" id="bootstrap-forms-url-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-url-readonly" id="bootstrap-forms-url-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-url-required" id="bootstrap-forms-url-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-help" id="bootstrap-forms-url-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-valid" id="bootstrap-forms-url-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-invalid" id="bootstrap-forms-url-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-minlength" id="bootstrap-forms-url-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-maxlength" id="bootstrap-forms-url-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-url-onkeyup" id="bootstrap-forms-url-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-url-font-weight" id="bootstrap-forms-url-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-url-font-italic" id="bootstrap-forms-url-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-url-color" id="bootstrap-forms-url-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-url-bgcolor" id="bootstrap-forms-url-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-url-border-color" id="bootstrap-forms-url-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-url-border-types" id="bootstrap-forms-url-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-url-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-url-border-radius" id="bootstrap-forms-url-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-url-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-url-id').val();
				var name = jQuery('#bootstrap-forms-url-name').val();
				var label = jQuery('#bootstrap-forms-url-label').val();
				var value = jQuery('#bootstrap-forms-url-value').val();
				var placeholder = jQuery('#bootstrap-forms-url-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-url-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-url-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-url-required').attr("checked");
				var help = jQuery('#bootstrap-forms-url-help').val();
				var valid = jQuery('#bootstrap-forms-url-valid').val();
				var invalid = jQuery('#bootstrap-forms-url-invalid').val();
				var minlength = jQuery('#bootstrap-forms-url-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-url-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-url-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-url-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-url-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-url-color').val();
				var bgcolor = jQuery('#bootstrap-forms-url-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-url-border-color').val();
				var border_types = jQuery('#bootstrap-forms-url-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-url-border-radius').val();

				var content = 'url|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_email': {
			'title': 'Forms Email', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-id" id="bootstrap-forms-email-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-name" id="bootstrap-forms-email-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-label" id="bootstrap-forms-email-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-value" id="bootstrap-forms-email-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-placeholder" id="bootstrap-forms-email-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-email-disabled" id="bootstrap-forms-email-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-email-readonly" id="bootstrap-forms-email-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-email-required" id="bootstrap-forms-email-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-help" id="bootstrap-forms-email-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-valid" id="bootstrap-forms-email-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-invalid" id="bootstrap-forms-email-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-minlength" id="bootstrap-forms-email-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-maxlength" id="bootstrap-forms-email-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-email-onkeyup" id="bootstrap-forms-email-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-email-font-weight" id="bootstrap-forms-email-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-email-font-italic" id="bootstrap-forms-email-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-email-color" id="bootstrap-forms-email-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-email-bgcolor" id="bootstrap-forms-email-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-email-border-color" id="bootstrap-forms-email-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-email-border-types" id="bootstrap-forms-email-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-email-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-email-border-radius" id="bootstrap-forms-email-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-email-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-email-id').val();
				var name = jQuery('#bootstrap-forms-email-name').val();
				var label = jQuery('#bootstrap-forms-email-label').val();
				var value = jQuery('#bootstrap-forms-email-value').val();
				var placeholder = jQuery('#bootstrap-forms-email-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-email-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-email-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-email-required').attr("checked");
				var help = jQuery('#bootstrap-forms-email-help').val();
				var valid = jQuery('#bootstrap-forms-email-valid').val();
				var invalid = jQuery('#bootstrap-forms-email-invalid').val();
				var minlength = jQuery('#bootstrap-forms-email-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-email-maxlength').val();
				var onkeyup = jQuery('#bootstrap-forms-email-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-email-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-email-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-email-color').val();
				var bgcolor = jQuery('#bootstrap-forms-email-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-email-border-color').val();
				var border_types = jQuery('#bootstrap-forms-email-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-email-border-radius').val();

				var content = 'email|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_date': {
			'title': 'Forms Date', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-id" id="bootstrap-forms-date-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-name" id="bootstrap-forms-date-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-label" id="bootstrap-forms-date-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-value">Value</label><div class="col-sm-6"><input type="date" name="bootstrap-forms-date-value" id="bootstrap-forms-date-value" value="" placeholder="2017-01-01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-placeholder">Placeholder</label><div class="col-sm-6"><input type="date" name="bootstrap-forms-date-placeholder" id="bootstrap-forms-date-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-date-disabled" id="bootstrap-forms-date-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-date-readonly" id="bootstrap-forms-date-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-date-required" id="bootstrap-forms-date-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-help" id="bootstrap-forms-date-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-valid" id="bootstrap-forms-date-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-invalid" id="bootstrap-forms-date-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-min">Min</label><div class="col-sm-6"><input type="date" name="bootstrap-forms-date-min" id="bootstrap-forms-date-min" value="" placeholder="2017-01-01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-max">Max</label><div class="col-sm-6"><input type="date" name="bootstrap-forms-date-max" id="bootstrap-forms-date-max" value="" placeholder="2018-01-01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-date-onkeyup" id="bootstrap-forms-date-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-date-font-weight" id="bootstrap-forms-date-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-date-font-italic" id="bootstrap-forms-date-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-date-color" id="bootstrap-forms-date-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-date-bgcolor" id="bootstrap-forms-date-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-date-border-color" id="bootstrap-forms-date-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-date-border-types" id="bootstrap-forms-date-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-date-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-date-border-radius" id="bootstrap-forms-date-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-date-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-date-id').val();
				var name = jQuery('#bootstrap-forms-date-name').val();
				var label = jQuery('#bootstrap-forms-date-label').val();
				var value = jQuery('#bootstrap-forms-date-value').val();
				var placeholder = jQuery('#bootstrap-forms-date-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-date-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-date-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-date-required').attr("checked");
				var help = jQuery('#bootstrap-forms-date-help').val();
				var valid = jQuery('#bootstrap-forms-date-valid').val();
				var invalid = jQuery('#bootstrap-forms-date-invalid').val();
				var min = jQuery('#bootstrap-forms-date-min').val();
				var max = jQuery('#bootstrap-forms-date-max').val();
				var onkeyup = jQuery('#bootstrap-forms-date-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-date-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-date-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-date-color').val();
				var bgcolor = jQuery('#bootstrap-forms-date-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-date-border-color').val();
				var border_types = jQuery('#bootstrap-forms-date-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-date-border-radius').val();

				var content = 'date|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_datetime-local': {
			'title': 'Forms Datetime Local', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-id" id="bootstrap-forms-datetime-local-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-name" id="bootstrap-forms-datetime-local-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-label" id="bootstrap-forms-datetime-local-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-value">Value</label><div class="col-sm-6"><input type="datetime-local" name="bootstrap-forms-datetime-local-value" id="bootstrap-forms-datetime-local-value" value="" placeholder="2017-06-01T08:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-placeholder">Placeholder</label><div class="col-sm-6"><input type="datetime-local" name="bootstrap-forms-datetime-local-placeholder" id="bootstrap-forms-datetime-local-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-datetime-local-disabled" id="bootstrap-forms-datetime-local-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-datetime-local-readonly" id="bootstrap-forms-datetime-local-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-datetime-local-required" id="bootstrap-forms-datetime-local-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-help" id="bootstrap-forms-datetime-local-help" value="" placeholder="Help..." /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-valid" id="bootstrap-forms-datetime-local-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-invalid" id="bootstrap-forms-datetime-local-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-min">Min</label><div class="col-sm-6"><input type="datetime-local" name="bootstrap-forms-datetime-local-min" id="bootstrap-forms-datetime-local-min" value="" placeholder="2017-06-01T08:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-max">Max</label><div class="col-sm-6"><input type="datetime-local" name="bootstrap-forms-datetime-local-max" id="bootstrap-forms-datetime-local-max" value="" placeholder="2018-06-01T08:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-datetime-local-onkeyup" id="bootstrap-forms-datetime-local-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-font-weight" id="bootstrap-forms-datetime-local-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-datetime-local-font-italic" id="bootstrap-forms-datetime-local-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-color" id="bootstrap-forms-datetime-local-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-bgcolor" id="bootstrap-forms-datetime-local-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-border-color" id="bootstrap-forms-datetime-local-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-border-types" id="bootstrap-forms-datetime-local-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-datetime-local-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-datetime-local-border-radius" id="bootstrap-forms-datetime-local-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-datetime-local-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-datetime-local-id').val();
				var name = jQuery('#bootstrap-forms-datetime-local-name').val();
				var label = jQuery('#bootstrap-forms-datetime-local-label').val();
				var value = jQuery('#bootstrap-forms-datetime-local-value').val();
				var placeholder = jQuery('#bootstrap-forms-datetime-local-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-datetime-local-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-datetime-local-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-datetime-local-required').attr("checked");
				var help = jQuery('#bootstrap-forms-datetime-local-help').val();
				var valid = jQuery('#bootstrap-forms-datetime-local-valid').val();
				var invalid = jQuery('#bootstrap-forms-datetime-local-invalid').val();
				var min = jQuery('#bootstrap-forms-datetime-local-min').val();
				var max = jQuery('#bootstrap-forms-datetime-local-max').val();
				var onkeyup = jQuery('#bootstrap-forms-datetime-local-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-datetime-local-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-datetime-local-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-datetime-local-color').val();
				var bgcolor = jQuery('#bootstrap-forms-datetime-local-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-datetime-local-border-color').val();
				var border_types = jQuery('#bootstrap-forms-datetime-local-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-datetime-local-border-radius').val();

				var content = 'datetime-local|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_week': {
			'title': 'Forms Week', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-id" id="bootstrap-forms-week-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-name" id="bootstrap-forms-week-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-label" id="bootstrap-forms-week-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-value">Value</label><div class="col-sm-6"><input type="week" name="bootstrap-forms-week-value" id="bootstrap-forms-week-value" value="" placeholder="2017-W01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-placeholder">Placeholder</label><div class="col-sm-6"><input type="week" name="bootstrap-forms-week-placeholder" id="bootstrap-forms-week-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-week-disabled" id="bootstrap-forms-week-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-week-readonly" id="bootstrap-forms-week-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-week-required" id="bootstrap-forms-week-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-help" id="bootstrap-forms-week-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-valid" id="bootstrap-forms-week-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-invalid" id="bootstrap-forms-week-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-min">Min</label><div class="col-sm-6"><input type="week" name="bootstrap-forms-week-min" id="bootstrap-forms-week-min" value="" placeholder="2017-W01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-max">Max</label><div class="col-sm-6"><input type="week" name="bootstrap-forms-week-max" id="bootstrap-forms-week-max" value="" placeholder="2018-W01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-week-onkeyup" id="bootstrap-forms-week-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-week-font-weight" id="bootstrap-forms-week-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-week-font-italic" id="bootstrap-forms-week-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-week-color" id="bootstrap-forms-week-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-week-bgcolor" id="bootstrap-forms-week-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-week-border-color" id="bootstrap-forms-week-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-week-border-types" id="bootstrap-forms-week-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-week-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-week-border-radius" id="bootstrap-forms-week-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-week-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-week-id').val();
				var name = jQuery('#bootstrap-forms-week-name').val();
				var label = jQuery('#bootstrap-forms-week-label').val();
				var value = jQuery('#bootstrap-forms-week-value').val();
				var placeholder = jQuery('#bootstrap-forms-week-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-week-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-week-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-week-required').attr("checked");
				var help = jQuery('#bootstrap-forms-week-help').val();
				var valid = jQuery('#bootstrap-forms-week-valid').val();
				var invalid = jQuery('#bootstrap-forms-week-invalid').val();
				var min = jQuery('#bootstrap-forms-week-min').val();
				var max = jQuery('#bootstrap-forms-week-max').val();
				var onkeyup = jQuery('#bootstrap-forms-week-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-week-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-week-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-week-color').val();
				var bgcolor = jQuery('#bootstrap-forms-week-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-week-border-color').val();
				var border_types = jQuery('#bootstrap-forms-week-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-week-border-radius').val();

				var content = 'week|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_month': {
			'title': 'Forms Month', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-id" id="bootstrap-forms-month-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-name" id="bootstrap-forms-month-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-label" id="bootstrap-forms-month-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-value">Value</label><div class="col-sm-6"><input type="month" name="bootstrap-forms-month-value" id="bootstrap-forms-month-value" value="" placeholder="2017-06" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-placeholder">Placeholder</label><div class="col-sm-6"><input type="month" name="bootstrap-forms-month-placeholder" id="bootstrap-forms-month-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-month-disabled" id="bootstrap-forms-month-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-month-readonly" id="bootstrap-forms-month-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-month-required" id="bootstrap-forms-month-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-help" id="bootstrap-forms-month-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-valid" id="bootstrap-forms-month-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-invalid" id="bootstrap-forms-month-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-min">Min</label><div class="col-sm-6"><input type="month" name="bootstrap-forms-month-min" id="bootstrap-forms-month-min" value="" placeholder="2017-06" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-max">Max</label><div class="col-sm-6"><input type="month" name="bootstrap-forms-month-max" id="bootstrap-forms-month-max" value="" placeholder="2018-06" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-month-onkeyup" id="bootstrap-forms-month-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-month-font-weight" id="bootstrap-forms-month-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-month-font-italic" id="bootstrap-forms-month-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-month-color" id="bootstrap-forms-month-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-month-bgcolor" id="bootstrap-forms-month-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-month-border-color" id="bootstrap-forms-month-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-month-border-types" id="bootstrap-forms-month-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-month-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-month-border-radius" id="bootstrap-forms-month-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-month-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-month-id').val();
				var name = jQuery('#bootstrap-forms-month-name').val();
				var label = jQuery('#bootstrap-forms-month-label').val();
				var value = jQuery('#bootstrap-forms-month-value').val();
				var placeholder = jQuery('#bootstrap-forms-month-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-month-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-month-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-month-required').attr("checked");
				var help = jQuery('#bootstrap-forms-month-help').val();
				var valid = jQuery('#bootstrap-forms-month-valid').val();
				var invalid = jQuery('#bootstrap-forms-month-invalid').val();
				var min = jQuery('#bootstrap-forms-month-min').val();
				var max = jQuery('#bootstrap-forms-month-max').val();
				var onkeyup = jQuery('#bootstrap-forms-month-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-month-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-month-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-month-color').val();
				var bgcolor = jQuery('#bootstrap-forms-month-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-month-border-color').val();
				var border_types = jQuery('#bootstrap-forms-month-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-month-border-radius').val();

				var content = 'month|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_time': {
			'title': 'Forms Time', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-id" id="bootstrap-forms-time-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-name" id="bootstrap-forms-time-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-label" id="bootstrap-forms-time-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-value">Value</label><div class="col-sm-6"><input type="time" name="bootstrap-forms-time-value" id="bootstrap-forms-time-value" value="" placeholder="13:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-placeholder">Placeholder</label><div class="col-sm-6"><input type="time" name="bootstrap-forms-time-placeholder" id="bootstrap-forms-time-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-time-disabled" id="bootstrap-forms-time-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-time-readonly" id="bootstrap-forms-time-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-time-required" id="bootstrap-forms-time-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-help" id="bootstrap-forms-time-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-valid" id="bootstrap-forms-time-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-invalid" id="bootstrap-forms-time-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-min">Min</label><div class="col-sm-6"><input type="time" name="bootstrap-forms-time-min" id="bootstrap-forms-time-min" value="" placeholder="13:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-max">Max</label><div class="col-sm-6"><input type="time" name="bootstrap-forms-time-max" id="bootstrap-forms-time-max" value="" placeholder="23:30" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-time-onkeyup" id="bootstrap-forms-time-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-time-font-weight" id="bootstrap-forms-time-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-time-font-italic" id="bootstrap-forms-time-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-time-color" id="bootstrap-forms-time-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-time-bgcolor" id="bootstrap-forms-time-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-time-border-color" id="bootstrap-forms-time-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-time-border-types" id="bootstrap-forms-time-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-time-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-time-border-radius" id="bootstrap-forms-time-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-time-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-time-id').val();
				var name = jQuery('#bootstrap-forms-time-name').val();
				var label = jQuery('#bootstrap-forms-time-label').val();
				var value = jQuery('#bootstrap-forms-time-value').val();
				var placeholder = jQuery('#bootstrap-forms-time-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-time-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-time-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-time-required').attr("checked");
				var help = jQuery('#bootstrap-forms-time-help').val();
				var valid = jQuery('#bootstrap-forms-time-valid').val();
				var invalid = jQuery('#bootstrap-forms-time-invalid').val();
				var min = jQuery('#bootstrap-forms-time-min').val();
				var max = jQuery('#bootstrap-forms-time-max').val();
				var onkeyup = jQuery('#bootstrap-forms-time-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-time-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-time-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-time-color').val();
				var bgcolor = jQuery('#bootstrap-forms-time-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-time-border-color').val();
				var border_types = jQuery('#bootstrap-forms-time-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-time-border-radius').val();

				var content = 'time|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_number': {
			'title': 'Forms Number', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-id" id="bootstrap-forms-number-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-name" id="bootstrap-forms-number-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-label" id="bootstrap-forms-number-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-value">Value</label><div class="col-sm-6"><input type="number" name="bootstrap-forms-number-value" id="bootstrap-forms-number-value" value="" placeholder="3" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-placeholder">Placeholder</label><div class="col-sm-6"><input type="number" name="bootstrap-forms-number-placeholder" id="bootstrap-forms-number-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-number-disabled" id="bootstrap-forms-number-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-number-readonly" id="bootstrap-forms-number-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-number-required" id="bootstrap-forms-number-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-help" id="bootstrap-forms-number-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-valid" id="bootstrap-forms-number-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-invalid" id="bootstrap-forms-number-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-min">Min</label><div class="col-sm-6"><input type="number" name="bootstrap-forms-number-min" id="bootstrap-forms-number-min" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-max">Max</label><div class="col-sm-6"><input type="number" name="bootstrap-forms-number-max" id="bootstrap-forms-number-max" value="" placeholder="100" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-step">Step</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-step" id="bootstrap-forms-number-step" value="" placeholder="0.01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-number-onkeyup" id="bootstrap-forms-number-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-number-font-weight" id="bootstrap-forms-number-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-number-font-italic" id="bootstrap-forms-number-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-number-color" id="bootstrap-forms-number-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-number-bgcolor" id="bootstrap-forms-number-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-number-border-color" id="bootstrap-forms-number-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-number-border-types" id="bootstrap-forms-number-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-number-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-number-border-radius" id="bootstrap-forms-number-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-number-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-number-id').val();
				var name = jQuery('#bootstrap-forms-number-name').val();
				var label = jQuery('#bootstrap-forms-number-label').val();
				var value = jQuery('#bootstrap-forms-number-value').val();
				var placeholder = jQuery('#bootstrap-forms-number-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-number-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-number-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-number-required').attr("checked");
				var help = jQuery('#bootstrap-forms-number-help').val();
				var valid = jQuery('#bootstrap-forms-number-valid').val();
				var invalid = jQuery('#bootstrap-forms-number-invalid').val();
				var min = jQuery('#bootstrap-forms-number-min').val();
				var max = jQuery('#bootstrap-forms-number-max').val();
				var step = jQuery('#bootstrap-forms-number-step').val();
				var onkeyup = jQuery('#bootstrap-forms-number-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-number-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-number-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-number-color').val();
				var bgcolor = jQuery('#bootstrap-forms-number-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-number-border-color').val();
				var border_types = jQuery('#bootstrap-forms-number-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-number-border-radius').val();

				var content = 'number|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + step + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_range': {
			'title': 'Forms Range', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-id" id="bootstrap-forms-range-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-name" id="bootstrap-forms-range-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-label" id="bootstrap-forms-range-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-value">Value</label><div class="col-sm-6"><input type="range" name="bootstrap-forms-range-value" id="bootstrap-forms-range-value" value="" placeholder="3" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-placeholder">Placeholder</label><div class="col-sm-6"><input type="range" name="bootstrap-forms-range-placeholder" id="bootstrap-forms-range-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-range-disabled" id="bootstrap-forms-range-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-range-readonly" id="bootstrap-forms-range-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-range-required" id="bootstrap-forms-range-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-help" id="bootstrap-forms-range-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-valid" id="bootstrap-forms-range-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-invalid" id="bootstrap-forms-range-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-min">Min</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-min" id="bootstrap-forms-range-min" value="" placeholder="1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-max">Max</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-max" id="bootstrap-forms-range-max" value="" placeholder="100" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-step">Step</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-step" id="bootstrap-forms-range-step" value="" placeholder="0.01" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-range-onkeyup" id="bootstrap-forms-range-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-range-font-weight" id="bootstrap-forms-range-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-range-font-italic" id="bootstrap-forms-range-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-range-color" id="bootstrap-forms-range-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-range-bgcolor" id="bootstrap-forms-range-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-range-border-color" id="bootstrap-forms-range-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-range-border-types" id="bootstrap-forms-range-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-range-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-range-border-radius" id="bootstrap-forms-range-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-range-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-range-id').val();
				var name = jQuery('#bootstrap-forms-range-name').val();
				var label = jQuery('#bootstrap-forms-range-label').val();
				var value = jQuery('#bootstrap-forms-range-value').val();
				var placeholder = jQuery('#bootstrap-forms-range-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-range-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-range-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-range-required').attr("checked");
				var help = jQuery('#bootstrap-forms-range-help').val();
				var valid = jQuery('#bootstrap-forms-range-valid').val();
				var invalid = jQuery('#bootstrap-forms-range-invalid').val();
				var min = jQuery('#bootstrap-forms-range-min').val();
				var max = jQuery('#bootstrap-forms-range-max').val();
				var step = jQuery('#bootstrap-forms-range-step').val();
				var onkeyup = jQuery('#bootstrap-forms-range-onkeyup').val();

				var font_weight = jQuery('#bootstrap-forms-range-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-range-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-range-color').val();
				var bgcolor = jQuery('#bootstrap-forms-range-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-range-border-color').val();
				var border_types = jQuery('#bootstrap-forms-range-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-range-border-radius').val();

				var content = 'range|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + min + '|' + max + '|' + step + '|' + onkeyup + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_radio': {
			'title': 'Forms Radio', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-radio-name" id="bootstrap-forms-radio-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-radio-label" id="bootstrap-forms-radio-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-radio-disabled" id="bootstrap-forms-radio-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-radio-required" id="bootstrap-forms-radio-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-radio-help" id="bootstrap-forms-radio-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-radio-valid" id="bootstrap-forms-radio-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-radio-invalid" id="bootstrap-forms-radio-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-radio-font-weight" id="bootstrap-forms-radio-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-radio-font-italic" id="bootstrap-forms-radio-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-radio-color" id="bootstrap-forms-radio-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-radio-bgcolor" id="bootstrap-forms-radio-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-radio-border-color" id="bootstrap-forms-radio-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-radio-border-types" id="bootstrap-forms-radio-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-radio-border-radius" id="bootstrap-forms-radio-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-radio-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-forms-radio-content" id="bootstrap-forms-radio-content" cols="20" rows="8" placeholder="id_1|Label 1|Value 1|checked\nid_2|Label 2|Value 2|" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-radio-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var name = jQuery('#bootstrap-forms-radio-name').val();
				var label = jQuery('#bootstrap-forms-radio-label').val();
				var disabled = jQuery('#bootstrap-forms-radio-disabled').attr("checked");
				var required = jQuery('#bootstrap-forms-radio-required').attr("checked");
				var help = jQuery('#bootstrap-forms-radio-help').val();
				var valid = jQuery('#bootstrap-forms-radio-valid').val();
				var invalid = jQuery('#bootstrap-forms-radio-invalid').val();

				var font_weight = jQuery('#bootstrap-forms-radio-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-radio-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-radio-color').val();
				var bgcolor = jQuery('#bootstrap-forms-radio-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-radio-border-color').val();
				var border_types = jQuery('#bootstrap-forms-radio-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-radio-border-radius').val();
				var radios = jQuery('#bootstrap-forms-radio-content').val();
				radios = radios.replace(/\n|\r/g, '^').replace(/\|/g, '~');

				var content = 'radio|' + name + '|' + label + '|' + disabled + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius + '|' + radios;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_checkbox': {
			'title': 'Forms Checkbox', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-checkbox-label" id="bootstrap-forms-checkbox-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-checkbox-disabled" id="bootstrap-forms-checkbox-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-checkbox-required" id="bootstrap-forms-checkbox-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-checkbox-help" id="bootstrap-forms-checkbox-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-checkbox-valid" id="bootstrap-forms-checkbox-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-checkbox-invalid" id="bootstrap-forms-checkbox-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-onkeyup">OnKeyUp</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-checkbox-onkeyup" id="bootstrap-forms-checkbox-onkeyup" value="" placeholder="alert(this.value.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-font-weight" id="bootstrap-forms-checkbox-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-checkbox-font-italic" id="bootstrap-forms-checkbox-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-color" id="bootstrap-forms-checkbox-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-bgcolor" id="bootstrap-forms-checkbox-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-border-color" id="bootstrap-forms-checkbox-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-border-types" id="bootstrap-forms-checkbox-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-checkbox-border-radius" id="bootstrap-forms-checkbox-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-checkbox-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-forms-checkbox-content" id="bootstrap-forms-checkbox-content" cols="20" rows="8" placeholder="name_1|id_1|Label 1|Value 1|checked\nname_2|id_2|Label 2|Value 2|"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-checkbox-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var label = jQuery('#bootstrap-forms-checkbox-label').val();
				var disabled = jQuery('#bootstrap-forms-checkbox-disabled').attr("checked");
				var required = jQuery('#bootstrap-forms-checkbox-required').attr("checked");
				var help = jQuery('#bootstrap-forms-checkbox-help').val();
				var valid = jQuery('#bootstrap-forms-checkbox-valid').val();
				var invalid = jQuery('#bootstrap-forms-checkbox-invalid').val();

				var font_weight = jQuery('#bootstrap-forms-checkbox-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-checkbox-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-checkbox-color').val();
				var bgcolor = jQuery('#bootstrap-forms-checkbox-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-checkbox-border-color').val();
				var border_types = jQuery('#bootstrap-forms-checkbox-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-checkbox-border-radius').val();
				var radios = jQuery('#bootstrap-forms-checkbox-content').val();
				radios = radios.replace(/\n|\r/g, '^').replace(/\|/g, '~');

				var content = 'checkbox|' + label + '|' + disabled + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius + '|' + radios;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_select': {
			'title': 'Forms Select', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label><div class="col-sm-6"><textarea id="bootstrap_components_alerts_text" placeholder="&lt;h4 class=&quot;alert-heading&quot;&gt;Header text...&lt;\/h4&gt;\r\n&lt;p&gt;Text...&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;an example link&lt;\/a&gt;...&lt;\/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;mb-0&quot;&gt;Footer Text...&lt;\/p&gt;" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-id" id="bootstrap-forms-select-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-name" id="bootstrap-forms-select-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-label" id="bootstrap-forms-select-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-select-disabled" id="bootstrap-forms-select-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-select-required" id="bootstrap-forms-select-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-help" id="bootstrap-forms-select-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-valid" id="bootstrap-forms-select-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-invalid" id="bootstrap-forms-select-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-size">Size</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-size" id="bootstrap-forms-select-size" value="" placeholder="3" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-multiple">Multiple</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-select-multiple" id="bootstrap-forms-select-multiple" value="1" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-onchange">OnChange</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-select-onchange" id="bootstrap-forms-select-onchange" value="" placeholder="alert(this.value);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-select-font-weight" id="bootstrap-forms-select-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-select-font-italic" id="bootstrap-forms-select-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-select-color" id="bootstrap-forms-select-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-select-bgcolor" id="bootstrap-forms-select-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-select-border-color" id="bootstrap-forms-select-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-select-border-types" id="bootstrap-forms-select-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-select-border-radius" id="bootstrap-forms-select-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label for="bootstrap-forms-select-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-forms-select-content" id="bootstrap-forms-select-content" cols="20" rows="8" placeholder="Label 1|Value 1|selected\nLabel 2|Value 2|" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-select-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-select-id').val();
				var name = jQuery('#bootstrap-forms-select-name').val();
				var label = jQuery('#bootstrap-forms-select-label').val();
				var disabled = jQuery('#bootstrap-forms-select-disabled').attr("checked");
				var required = jQuery('#bootstrap-forms-select-required').attr("checked");
				var help = jQuery('#bootstrap-forms-select-help').val();
				var valid = jQuery('#bootstrap-forms-select-valid').val();
				var invalid = jQuery('#bootstrap-forms-select-invalid').val();
				var size = jQuery('#bootstrap-forms-select-size').val();
				var multiple = jQuery('#bootstrap-forms-select-multiple').attr("checked");
				var onchange = jQuery('#bootstrap-forms-select-onchange').val();

				var font_weight = jQuery('#bootstrap-forms-select-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-select-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-select-color').val();
				var bgcolor = jQuery('#bootstrap-forms-select-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-select-border-color').val();
				var border_types = jQuery('#bootstrap-forms-select-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-select-border-radius').val();
				var options = jQuery('#bootstrap-forms-select-content').val();
				options = options.replace(/\n|\r/g, '^').replace(/\|/g, '~');

				var content = 'select|' + id + '|' + name + '|' + label + '|' + disabled + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + size + '|' + multiple + '|' + onchange + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius + '|' + options;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_file': {
			'title': 'Forms File', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-id" id="bootstrap-forms-file-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-name" id="bootstrap-forms-file-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-label" id="bootstrap-forms-file-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-placeholder" id="bootstrap-forms-file-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-file-disabled" id="bootstrap-forms-file-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-file-readonly" id="bootstrap-forms-file-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-file-required" id="bootstrap-forms-file-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-help" id="bootstrap-forms-file-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-valid" id="bootstrap-forms-file-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-invalid" id="bootstrap-forms-file-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-accept">Accept</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-accept" id="bootstrap-forms-file-accept" value="" placeholder=".jpg" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-multiple">Multiple</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-file-multiple" id="bootstrap-forms-file-multiple" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-onchange">OnChange</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-file-onchange" id="bootstrap-forms-file-onchange" value="" placeholder="alert(this.files.length);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-file-font-weight" id="bootstrap-forms-file-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-file-font-italic" id="bootstrap-forms-file-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-file-color" id="bootstrap-forms-file-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-file-bgcolor" id="bootstrap-forms-file-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-file-border-color" id="bootstrap-forms-file-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-file-border-types" id="bootstrap-forms-file-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-file-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-file-border-radius" id="bootstrap-forms-file-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-file-label').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-file-id').val();
				var name = jQuery('#bootstrap-forms-file-name').val();
				var label = jQuery('#bootstrap-forms-file-label').val();
				var placeholder = jQuery('#bootstrap-forms-file-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-file-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-file-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-file-required').attr("checked");
				var help = jQuery('#bootstrap-forms-file-help').val();
				var valid = jQuery('#bootstrap-forms-file-valid').val();
				var invalid = jQuery('#bootstrap-forms-file-invalid').val();
				var accept = jQuery('#bootstrap-forms-file-accept').val();
				var multiple = jQuery('#bootstrap-forms-file-multiple').attr("checked");
				var onchange = jQuery('#bootstrap-forms-file-onchange').val();

				var font_weight = jQuery('#bootstrap-forms-file-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-file-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-file-color').val();
				var bgcolor = jQuery('#bootstrap-forms-file-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-file-border-color').val();
				var border_types = jQuery('#bootstrap-forms-file-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-file-border-radius').val();

				var content = 'file|' + id + '|' + name + '|' + label + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + accept + '|' + multiple + '|' + onchange + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_color': {
			'title': 'Forms Color', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-id" id="bootstrap-forms-color-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-name" id="bootstrap-forms-color-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-label" id="bootstrap-forms-color-label" value="" placeholder="Label..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-value" id="bootstrap-forms-color-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-placeholder">Placeholder</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-placeholder" id="bootstrap-forms-color-placeholder" value="" placeholder="Placeholder..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-disabled">Disabled</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-color-disabled" id="bootstrap-forms-color-disabled" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-readonly">Readonly</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-color-readonly" id="bootstrap-forms-color-readonly" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-color-required" id="bootstrap-forms-color-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-help">Help</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-help" id="bootstrap-forms-color-help" value="" placeholder="Help..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-valid">Valid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-valid" id="bootstrap-forms-color-valid" value="" placeholder="Valid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-invalid">InValid</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-invalid" id="bootstrap-forms-color-invalid" value="" placeholder="Invalid..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-minlength" id="bootstrap-forms-color-minlength" value="" placeholder="7" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-maxlength" id="bootstrap-forms-color-maxlength" value="" placeholder="7" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-onchange">OnChange</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-color-onchange" id="bootstrap-forms-color-onchange" value="" placeholder="alert(this.value);" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-font-weight">Font - Weight</label><div class="col-sm-6"><select name="bootstrap-forms-color-font-weight" id="bootstrap-forms-color-font-weight"><option value="">Auto</option><option value="bold">Bold</option><option value="normal">Normal</option><option value="light">Light</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-font-italic">Font - Italic</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-color-font-italic" id="bootstrap-forms-color-font-italic" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-color">Color</label><div class="col-sm-6"><select name="bootstrap-forms-color-color" id="bootstrap-forms-color-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-forms-color-bgcolor" id="bootstrap-forms-color-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-forms-color-border-color" id="bootstrap-forms-color-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-forms-color-border-types" id="bootstrap-forms-color-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-color-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-forms-color-border-radius" id="bootstrap-forms-color-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-color-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-color-id').val();
				var name = jQuery('#bootstrap-forms-color-name').val();
				var label = jQuery('#bootstrap-forms-color-label').val();
				var value = jQuery('#bootstrap-forms-color-value').val();
				var placeholder = jQuery('#bootstrap-forms-color-placeholder').val();
				var disabled = jQuery('#bootstrap-forms-color-disabled').attr("checked");
				var readonly = jQuery('#bootstrap-forms-color-readonly').attr("checked");
				var required = jQuery('#bootstrap-forms-color-required').attr("checked");
				var help = jQuery('#bootstrap-forms-color-help').val();
				var valid = jQuery('#bootstrap-forms-color-valid').val();
				var invalid = jQuery('#bootstrap-forms-color-invalid').val();
				var minlength = jQuery('#bootstrap-forms-color-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-color-maxlength').val();
				var onchange = jQuery('#bootstrap-forms-color-onchange').val();

				var font_weight = jQuery('#bootstrap-forms-color-font-weight').val();
				var font_italic = jQuery('#bootstrap-forms-color-font-italic').attr("checked");

				var color = jQuery('#bootstrap-forms-color-color').val();
				var bgcolor = jQuery('#bootstrap-forms-color-bgcolor').val();
				var border_color = jQuery('#bootstrap-forms-color-border-color').val();
				var border_types = jQuery('#bootstrap-forms-color-border-types').val();
				var border_radius = jQuery('#bootstrap-forms-color-border-radius').val();

				var content = 'color|' + id + '|' + name + '|' + label + '|' + value + '|' + placeholder + '|' + disabled + '|' + readonly + '|' + required + '|' + help + '|' + valid + '|' + invalid + '|' + minlength + '|' + maxlength + '|' + onchange + '|' + font_weight + '|' + font_italic + '|' + color + '|' + bgcolor + '|' + border_color + '|' + border_types + '|' + border_radius;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'forms_hidden': {
			'title': 'Forms Hidden', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label><div class="col-sm-6"><textarea id="bootstrap_components_alerts_text" placeholder="&lt;h4 class=&quot;alert-heading&quot;&gt;Header text...&lt;\/h4&gt;\r\n&lt;p&gt;Text...&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;an example link&lt;\/a&gt;...&lt;\/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;mb-0&quot;&gt;Footer Text...&lt;\/p&gt;" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-hidden-id" id="bootstrap-forms-hidden-id" value="" placeholder="input_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-name">Name</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-hidden-name" id="bootstrap-forms-hidden-name" value="" placeholder="input_name" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-value">Value</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-hidden-value" id="bootstrap-forms-hidden-value" value="" placeholder="Value..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-required">Required</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-forms-hidden-required" id="bootstrap-forms-hidden-required" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-minlength">MinLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-hidden-minlength" id="bootstrap-forms-hidden-minlength" value="" placeholder="2" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-forms-hidden-maxlength">MaxLength</label><div class="col-sm-6"><input type="text" name="bootstrap-forms-hidden-maxlength" id="bootstrap-forms-hidden-maxlength" value="" placeholder="10" ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-forms-hidden-name').val() == '' ? 'Bitte geben Sie ein Name ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-forms-hidden-id').val();
				var name = jQuery('#bootstrap-forms-hidden-name').val();
				var value = jQuery('#bootstrap-forms-hidden-value').val();
				var required = jQuery('#bootstrap-forms-hidden-required').attr("checked");
				var minlength = jQuery('#bootstrap-forms-hidden-minlength').val();
				var maxlength = jQuery('#bootstrap-forms-hidden-maxlength').val();

				var content = 'hidden|' + id + '|' + name + '|' + value + '|' + required + '|' + minlength + '|' + maxlength;
				var form_content = jQuery('#bootstrap-component-forms-content').val();
				form_content += form_content != '' ? '\n' + content : content;
				jQuery('#bootstrap-component-forms-content').val(form_content);

				return 	'';
			}
		}, 
		'alerts': {
			'title': 'Alerts', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label">Text</label><div class="col-sm-6"><textarea id="bootstrap_components_alerts_text" placeholder="&lt;h4 class=&quot;alert-heading&quot;&gt;Header text...&lt;\/h4&gt;\r\n&lt;p&gt;Text...&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;an example link&lt;\/a&gt;...&lt;\/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;mb-0&quot;&gt;Footer Text...&lt;\/p&gt;" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'	<label class="col-sm-6 col-form-label">Farbe</label><div class="col-sm-6"><select id="bootstrap_components_alerts_bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap_components_alerts_close" class="col-sm-6 col-form-label">Mit schließen Button</label><div class="col-sm-6"><input type="checkbox" name="bootstrap_components_alerts_close" id="bootstrap_components_alerts_close" value="1" checked="checked" /></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap_components_alerts_text').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var close_button = 	$('#bootstrap_components_alerts_close').prop('checked') == true ? 
									'	<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
									'		<span aria-hidden="true">&times;</span>' + 
									'	</button>' : 
									'';
				return 	'<div class="alert alert-'+$('#bootstrap_components_alerts_bgcolor').children('option:selected').val()+' fade show" role="alert">' + 
						close_button + 
						$('#bootstrap_components_alerts_text').val() + 
						'</div>';
			}
		}, 
		'jumbotron': {
			'title': 'Jumbotron', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-title">Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-title" id="bootstrap-component-jumbotron-title" value="" placeholder="Title, Text..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-subtitle">SubTitle</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-subtitle" id="bootstrap-component-jumbotron-subtitle" value="" placeholder="Subtitle..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-description">Description</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-description" id="bootstrap-component-jumbotron-description" value="" placeholder="Description..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-footer">Footer</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-footer" id="bootstrap-component-jumbotron-footer" value="" placeholder="&lt;a class=&quot;btn btn-primary btn-lg&quot; href=&quot;#&quot; role=&quot;button&quot;&gt;Button 01&lt;/a&gt;" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-jumbotron-color" id="bootstrap-component-jumbotron-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-jumbotron-bgcolor" id="bootstrap-component-jumbotron-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-jumbotron-border-color" id="bootstrap-component-jumbotron-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-jumbotron-border-types" id="bootstrap-component-jumbotron-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-jumbotron-border-radius" id="bootstrap-component-jumbotron-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-style" id="bootstrap-component-jumbotron-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-jumbotron-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-jumbotron-class" id="bootstrap-component-jumbotron-class" value="" placeholder="jumbotron-fluid" ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-jumbotron-description').val() == '' ? 'Bitte geben Sie eine Description ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var title = jQuery('#bootstrap-component-jumbotron-title').val();
				var subtitle = jQuery('#bootstrap-component-jumbotron-subtitle').val();
				var description = jQuery('#bootstrap-component-jumbotron-description').val();
				var footer = jQuery('#bootstrap-component-jumbotron-footer').val();

				var color = jQuery('#bootstrap-component-jumbotron-color').val();
				var bgcolor = jQuery('#bootstrap-component-jumbotron-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-jumbotron-border-color').val();
				var border_types = jQuery('#bootstrap-component-jumbotron-border-types').val();
				var border_radius = jQuery('#bootstrap-component-jumbotron-border-radius').val();

				var style = jQuery('#bootstrap-component-jumbotron-style').val();
				var jumbotron_class = jQuery('#bootstrap-component-jumbotron-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var tag_title = title != '' ? '	<h1 class="display-4">' + title + '</h1>\n' : '';
				var tag_subtitle = subtitle != '' ? '	<p class="lead">' + subtitle + '</p>\n' : '';
				var tag_description = description != '' ? '	<p class="nolead">' + description + '</p>\n' : '';
				var tag_footer = footer != '' ? '	<p class="lead">' + footer + '</p>\n' : '';

				var content_str = 	tag_title + 
									tag_subtitle + 
									'	<hr class="my-4" />\n' + 
									tag_description + 
									tag_footer;

				return 	'<div' + attr_style + ' class="jumbotron ' + jumbotron_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '">\n' + content_str + '</div>\n';
			}
		}, 
		'list_group': {
			'title': 'List-Group', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-arrange">Arrange</label><div class="col-sm-6"><select name="bootstrap-component-list-group-arrange" id="bootstrap-component-list-group-arrange"><option value="0">Content besides</option><option value="1">Content among them</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-list-group-color" id="bootstrap-component-list-group-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-list-group-bgcolor" id="bootstrap-component-list-group-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-list-group-border-color" id="bootstrap-component-list-group-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-list-group-border-types" id="bootstrap-component-list-group-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-list-group-border-radius" id="bootstrap-component-list-group-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-list-group-style" id="bootstrap-component-list-group-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-list-group-class" id="bootstrap-component-list-group-class" value="" placeholder="list-group-fluid" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-list-group-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-list-group-content" id="bootstrap-component-list-group-content" cols="20" rows="8" placeholder="active|list_01|List 01|Text 01...|primary|flex-column align-items-start\n|list_02|List 02|Text 02...|primary|flex-column align-items-start\n|list_03|List 03|Text 03...|primary|flex-column align-items-start" ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-list-group-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var arrange = jQuery('#bootstrap-component-list-group-arrange').val();
				var color = jQuery('#bootstrap-component-list-group-color').val();
				var bgcolor = jQuery('#bootstrap-component-list-group-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-list-group-border-color').val();
				var border_types = jQuery('#bootstrap-component-list-group-border-types').val();
				var border_radius = jQuery('#bootstrap-component-list-group-border-radius').val();

				var style = jQuery('#bootstrap-component-list-group-style').val();
				var list_group_class = jQuery('#bootstrap-component-list-group-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var content = jQuery('#bootstrap-component-list-group-content').val();
				var contentArr = content.split('\n');
				var content_tablist = '';
				var content_tabpanel = '';
				for(var i = 0; i < contentArr.length;i++){
					var keyArr = contentArr[i].split('|');
					var active = keyArr[0] == 'active' ? ' active' : '';
					var show = keyArr[0] == 'active' ? ' show' : '';
					var list_group_item_color = keyArr[4] != '' ? ' list-group-item-' + keyArr[4] : '';
					var list_group_item_class = keyArr[5] != '' ? ' ' + keyArr[5] : '';
					content_tablist += '			<a class="list-group-item list-group-item-action' + list_group_item_color + list_group_item_class + active + '" id="list-' + keyArr[1] + '-list" data-toggle="list" href="#list-' + keyArr[1] + '" role="tab" aria-controls="' + keyArr[1] + '">' + keyArr[2] + '</a>\n';
					content_tabpanel += '			<div class="tab-pane fade' + show + active + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '" id="list-' + keyArr[1] + '" role="tabpanel" aria-labelledby="list-' + keyArr[1] + '-list">' + keyArr[3] + '</div>\n';
				}

				return 	'<div class="row">\n	<div class="col-' + (arrange == 0 ? '4' : '12') + '">\n		<div' + attr_style + ' id="list-tab" class="list-group ' + list_group_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '" role="tablist">\n' + content_tablist + '		</div>\n	</div>\n	<div class="col-' + (arrange == 0 ? '8' : '12') + '">\n		<div class="tab-content" id="nav-tabContent">\n' + content_tabpanel + '		</div>\n	</div>\n</div>\n';
			}
		}, 
		'media_object': {
			'title': 'Media-Object', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-media-object-color" id="bootstrap-component-media-object-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-media-object-bgcolor" id="bootstrap-component-media-object-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-media-object-border-color" id="bootstrap-component-media-object-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-media-object-border-types" id="bootstrap-component-media-object-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-media-object-border-radius" id="bootstrap-component-media-object-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-media-object-style" id="bootstrap-component-media-object-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-media-object-class" id="bootstrap-component-media-object-class" value="" placeholder="extra" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-media-object-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-media-object-content" id="bootstrap-component-media-object-content" cols="20" rows="8" placeholder="bild_01.jpg|Alt 01|Header 01|Text 01...\nbild_02.jpg|Alt 02|Header 02|Text 02...\nbild_03.jpg|Alt 03|Header 03|Text 03..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-list-group-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var color = jQuery('#bootstrap-component-media-object-color').val();
				var bgcolor = jQuery('#bootstrap-component-media-object-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-media-object-border-color').val();
				var border_types = jQuery('#bootstrap-component-media-object-border-types').val();
				var border_radius = jQuery('#bootstrap-component-media-object-border-radius').val();

				var style = jQuery('#bootstrap-component-media-object-style').val();
				var media_object_class = jQuery('#bootstrap-component-media-object-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var content = jQuery('#bootstrap-component-media-object-content').val();
				var contentArr = content.split('\n');
				var content_list = '';
				for(var i = 0; i < contentArr.length;i++){
					var keyArr = contentArr[i].split('|');
					var mb = i == 0 ? '' : ' mt-4';
					content_list += '	<li class="media' + mb + '">\n		<img src="' + keyArr[0] + '" alt="' + keyArr[1] + '" class="mr-3" />\n		<div class="media-body">\n			<h5 class="mt-0 mb-1">' + keyArr[2] + '</h5>\n			' + keyArr[3] + '\n		</div>\n	</li>\n';
				}

				return 	'<ul class="list-unstyled ' + media_object_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '"' + attr_style + '>\n' + content_list + '</ul>\n';
			}
		}, 
		'modal': {
			'title': 'Modal', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-id" id="bootstrap-component-modal-id" value="" placeholder="modal_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-title">Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-title" id="bootstrap-component-modal-title" value="" placeholder="Title..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-trigger-label">Button-Trigger-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-button-trigger-label" id="bootstrap-component-modal-button-trigger-label" value="" placeholder="Trigger..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-trigger-type">Button-Trigger-Type</label><div class="col-sm-6"><select name="bootstrap-component-modal-button-trigger-type" id="bootstrap-component-modal-button-trigger-type">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-close-label">Button-Close-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-button-close-label" id="bootstrap-component-modal-button-close-label" value="" placeholder="Close..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-close-type">Button-Close-Type</label><div class="col-sm-6"><select name="bootstrap-component-modal-button-close-type" id="bootstrap-component-modal-button-close-type">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-save-label">Button-Save-Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-button-save-label" id="bootstrap-component-modal-button-save-label" value="" placeholder="Save..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-button-save-type">Button-Save-Type</label><div class="col-sm-6"><select name="bootstrap-component-modal-button-save-type" id="bootstrap-component-modal-button-save-type">' + bootstrap_options_colors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-footer-text">Footer-Text</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-footer-text" id="bootstrap-component-modal-footer-text" value="" placeholder="Footer..." ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-modal-color" id="bootstrap-component-modal-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-modal-bgcolor" id="bootstrap-component-modal-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-modal-border-color" id="bootstrap-component-modal-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-modal-border-types" id="bootstrap-component-modal-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-modal-border-radius" id="bootstrap-component-modal-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-sizing">Sizing</label><div class="col-sm-6"><select name="bootstrap-component-modal-sizing" id="bootstrap-component-modal-sizing"><option value="">Normal</option><option value="modal-sm">Small</option><option value="modal-lg">Large</option></select></div>' + 
					
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-style" id="bootstrap-component-modal-style" value="" placeholder="width: 100%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-modal-class" id="bootstrap-component-modal-class" value="" placeholder="modal-fluid" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-fade">Fade</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-modal-fade" id="bootstrap-component-modal-fade" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-modal-body">Body</label><div class="col-sm-6"><textarea name="bootstrap-component-modal-body" id="bootstrap-component-modal-body" cols="20" rows="8" placeholder="&lt;span class=&quot;d-inline-block&quot; tabindex=&quot;0&quot; data-toggle=&quot;tooltip&quot; title=&quot;SPAN - Tooltip&quot;&gt;Body&lt;/span&gt;...&lt;a href=&quot;#&quot; title=&quot;Tooltip...&quot; data-toggle=&quot;tooltip&quot;&gt;This link&lt;/a&gt;...&lt;button type=&quot;button&quot; class=&quot;btn btn-secondary&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&quot; data-original-title=&quot;Tooltip on bottom&quot;&gt;Tooltip on bottom&lt;/button&gt;...&lt;button type=&quot;button&quot; class=&quot;btn btn-secondary&quot; data-toggle=&quot;tooltip&quot; data-html=&quot;true&quot; title=&quot;&amp;lt;em&amp;gt;Tooltip&amp;lt;/em&amp;gt; &amp;lt;u&amp;gt;with&amp;lt;/u&amp;gt; &amp;lt;b&amp;gt;HTML&amp;lt;/b&amp;gt;&quot;&gt;Tooltip with HTML&lt;/button&gt;...&lt;button type=&quot;button&quot; class=&quot;btn btn-lg btn-danger&quot; data-toggle=&quot;popover&quot; title=&quot;Popover title&quot; data-content=&quot;And here\'s some amazing content. It\'s very engaging. Right?&quot;&gt;Click to toggle popover&lt;/button&gt;..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-modal-body').val() == '' ? 'Bitte geben Sie ein Body ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-modal-id').val();
				var title = jQuery('#bootstrap-component-modal-title').val();

				var button_trigger_label = jQuery('#bootstrap-component-modal-button-trigger-label').val();
				var button_trigger_type = jQuery('#bootstrap-component-modal-button-trigger-type').val();
				var button_close_label = jQuery('#bootstrap-component-modal-button-close-label').val();
				var button_close_type = jQuery('#bootstrap-component-modal-button-close-type').val();
				var button_save_label = jQuery('#bootstrap-component-modal-button-save-label').val();
				var button_save_type = jQuery('#bootstrap-component-modal-button-save-type').val();

				var footer_text = jQuery('#bootstrap-component-modal-footer-text').val();

				var color = jQuery('#bootstrap-component-modal-color').val();
				var bgcolor = jQuery('#bootstrap-component-modal-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-modal-border-color').val();
				var border_types = jQuery('#bootstrap-component-modal-border-types').val();
				var border_radius = jQuery('#bootstrap-component-modal-border-radius').val();

				var sizing = jQuery('#bootstrap-component-modal-sizing').val();

				var style = jQuery('#bootstrap-component-modal-style').val();
				var modal_class = jQuery('#bootstrap-component-modal-class').val();

				var fade = jQuery('#bootstrap-component-modal-fade').attr('checked');

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_button_trigger_type = button_trigger_type != '' ? ' btn-' + button_trigger_type : '';
				var class_button_close_type = button_close_type != '' ? ' btn-' + button_close_type : '';
				var class_button_save_type = button_save_type != '' ? ' btn-' + button_save_type : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_sizing = sizing != '' ? ' ' + sizing : '';
				var class_modal_class = modal_class != '' ? ' ' + modal_class : '';

				var class_fade = fade == 'checked' ? ' fade' : '';

				var body = jQuery('#bootstrap-component-modal-body').val();
				var content_str = '';
				content_str += button_trigger_label != '' ? '<button type="button" class="btn' + class_button_trigger_type + '" data-toggle="modal" data-target="#' + id + '">' + button_trigger_label + '</button>\n' : '';
				var tag_close = button_close_label != '' ? '				<button type="button" class="btn' + class_button_close_type + '" data-dismiss="modal">' + button_close_label + '</button>\n' : ''
				var tag_save = button_save_label != '' ? '				<button type="button" class="btn' + class_button_save_type + '">' + button_save_label + '</button>\n' : ''
				var tag_footer_text = footer_text != '' ? '				<span>' + footer_text + '</span>\n' : '';
				content_str += 	'<div class="modal' + class_fade + '" id="' + id + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">\n' + 
								'	<div class="modal-dialog modal-dialog-centered' + class_sizing + '" role="document">\n' + 
								'		<div class="modal-content' + class_modal_class + class_color + class_bgcolor + class_border_types + class_border_color + class_border_radius + '"' + attr_style + '>\n' + 
								'			<div class="modal-header">\n' + 
								'				<h5 class="modal-title" id="exampleModalLongTitle">' + title + '</h5>\n' + 
								'				<button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' + 
								'					<span aria-hidden="true">&times;</span>\n' + 
								'				</button>\n' + 
								'			</div>\n' + 
								'			<div class="modal-body">\n' + 
								'				' + body + '\n' + 
								'			</div>\n' + 
								'			<div class="modal-footer">\n' + 
								tag_close + 
								tag_save + 
								tag_footer_text + 
								'			</div>\n' + 
								'		</div>\n' + 
								'	</div>\n' + 
								'</div>\n';

				return 	content_str;
			}
		}, 
		'navs': {
			'title': 'Navs', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-navs-id" id="bootstrap-component-navs-id" value="" placeholder="navs_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-display">Display</label><div class="col-sm-6"><select name="bootstrap-component-navs-display" id="bootstrap-component-navs-display"><option value="">Normal</option><option value="tab">Tabs</option><option value="pill">Pills</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-align">Nav - Align</label><div class="col-sm-6"><select name="bootstrap-component-navs-align" id="bootstrap-component-navs-align"><option value="">Left</option><option value="justify-content-center">Center</option><option value="justify-content-end">Right</option><option value="nav-justified">Justify</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-column-sizing">Column - Sizing</label><div class="col-sm-6"><select name="bootstrap-component-navs-column-sizing" id="bootstrap-component-navs-column-sizing"><option value="">No Colums</option><option value="1">&nbsp;1 - 11</option><option value="2">&nbsp;2 - 10</option><option value="3">&nbsp;3 -&nbsp;&nbsp;9</option><option value="4">&nbsp;4 -&nbsp;&nbsp;8</option><option value="5">&nbsp;5 -&nbsp;&nbsp;7</option><option value="6">&nbsp;6 -&nbsp;&nbsp;6</option><option value="7">&nbsp;7 -&nbsp;&nbsp;5</option><option value="8">&nbsp;8 -&nbsp;&nbsp;4</option><option value="9">&nbsp;9 -&nbsp;&nbsp;3</option><option value="10">10 -&nbsp;&nbsp;2</option><option value="11">11 -&nbsp;&nbsp;1</option></select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-nav-border-color">Nav-Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-navs-nav-border-color" id="bootstrap-component-navs-nav-border-color">' + bootstrap_options_colors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-navs-color" id="bootstrap-component-navs-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-navs-bgcolor" id="bootstrap-component-navs-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-navs-border-color" id="bootstrap-component-navs-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-navs-border-types" id="bootstrap-component-navs-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-navs-border-radius" id="bootstrap-component-navs-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-navs-style" id="bootstrap-component-navs-style" value="" placeholder="height: 400px;box-shadow: 1px 1px 3px #000" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-navs-class" id="bootstrap-component-navs-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-navs-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-navs-content" id="bootstrap-component-navs-content" cols="20" rows="8" placeholder="active|link_01|Link 01|Text 01...\n|link_02|Link 02|Text 02...\n|link_03|Link 03|Text 03..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-navs-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-navs-id').val();
				var display = jQuery('#bootstrap-component-navs-display').val();
				var align = jQuery('#bootstrap-component-navs-align').val();
				var column_sizing = jQuery('#bootstrap-component-navs-column-sizing').val();

				var nav_border_color = jQuery('#bootstrap-component-navs-nav-border-color').val();

				var color = jQuery('#bootstrap-component-navs-color').val();
				var bgcolor = jQuery('#bootstrap-component-navs-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-navs-border-color').val();
				var border_types = jQuery('#bootstrap-component-navs-border-types').val();
				var border_radius = jQuery('#bootstrap-component-navs-border-radius').val();

				var style = jQuery('#bootstrap-component-navs-style').val();
				var nav_class = jQuery('#bootstrap-component-navs-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_display = display != '' ? ' nav-' + display + 's' : '';
				var class_align = align != '' ? ' ' + align : '';
				var class_nav_item = align == 'nav-justified' ? ' nav-item' : '';

				var class_nav_border_color = nav_border_color != '' ? ' border-' + nav_border_color : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' border ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_nav_class = nav_class != '' ? ' ' + nav_class : '';
				var attr_data_toggle = display != '' ? ' data-toggle="' + display + '"' : ' data-toggle="tab"';

				var row_open = column_sizing != '' ? '<div class="row">\n' : '<div>\n';
				var row_close = column_sizing != '' ? '</div>\n' : '</div>\n';
				var col_tablist_open = column_sizing != '' ? '<div class="col-' + column_sizing + '">\n' : '';
				var col_tablist_close = column_sizing != '' ? '</div>\n' : '';
				var col_tabcontent_open = column_sizing != '' ? '<div class="col-' + (12 - column_sizing) + '">\n' : '';
				var col_tabcontent_close = column_sizing != '' ? '</div>\n' : '';
				var class_flex_column = column_sizing != '' ? ' flex-sm-column' : '';

				var content = jQuery('#bootstrap-component-navs-content').val();
				var contentArr = content.split('\n');
				var content_tablist = '';
				var content_tabpanel = '';
				for(var i = 0; i < contentArr.length;i++){
					var keyArr = contentArr[i].split('|');
					var active = keyArr[0] == 'active' ? ' active' : '';
					var selected = keyArr[0] == 'active' ? 'true' : 'false';
					var show = keyArr[0] == 'active' ? ' show' : '';
					content_tablist += '	<a class="nav-link' + class_nav_item + active + '" id="nav-' + keyArr[1] + '-tab"' + attr_data_toggle + ' href="#nav-' + keyArr[1] + '" role="tab" aria-controls="nav-' + keyArr[1] + '" aria-selected="' + selected + '">' + keyArr[2] + '</a>\n';
					content_tabpanel += '	<div class="p-3 tab-pane fade' + show + active + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '" id="nav-' + keyArr[1] + '" role="tabpanel" aria-labelledby="nav-' + keyArr[1] + '-tab"' + attr_style + '>' + keyArr[3] + '</div>\n';
				}

				return 	row_open + col_tablist_open + '<nav class="nav' + class_display + class_flex_column + class_align + class_nav_class + class_nav_border_color + '" id="' + id + '" role="tablist">\n' + content_tablist + '</nav>\n' + col_tablist_close + col_tabcontent_open + '<div class="tab-content" id="' + id + 'Content">\n' + content_tabpanel + '</div>\n' + col_tabcontent_close + row_close;
			}
		}, 
		'pagination': {
			'title': 'Pagination', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-pagination-id" id="bootstrap-component-pagination-id" value="" placeholder="pagination_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-pagination-label" id="bootstrap-component-pagination-label" value="" placeholder="Pagination..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-sizing">Sizing</label><div class="col-sm-6"><select name="bootstrap-component-pagination-sizing" id="bootstrap-component-pagination-sizing"><option value="">Normal</option><option value="pagination-sm">Small</option><option value="pagination-lg">Large</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-align">Align</label><div class="col-sm-6"><select name="bootstrap-component-pagination-align" id="bootstrap-component-pagination-align"><option value="">Left</option><option value="justify-content-center">Center</option><option value="justify-content-end">Right</option><option value="nav-justified">Justify</option></select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-pagination-color" id="bootstrap-component-pagination-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-pagination-bgcolor" id="bootstrap-component-pagination-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-pagination-border-color" id="bootstrap-component-pagination-border-color">' + bootstrap_options_colors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-pagination-style" id="bootstrap-component-pagination-style" value="" placeholder="height: 400px;box-shadow: 1px 1px 3px #000" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-pagination-class" id="bootstrap-component-pagination-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-pagination-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-pagination-content" id="bootstrap-component-pagination-content" cols="20" rows="8" placeholder="disabled|Zur&uuml;ck|http://www...de/...\n|1|http://www...de/...\nactive|2|http://www...de/...\n|3|http://www...de/...\n|Weiter|http://www...de/..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-pagination-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-pagination-id').val();
				var label = jQuery('#bootstrap-component-pagination-label').val();
				var sizing = jQuery('#bootstrap-component-pagination-sizing').val();
				var align = jQuery('#bootstrap-component-pagination-align').val();

				var color = jQuery('#bootstrap-component-pagination-color').val();
				var bgcolor = jQuery('#bootstrap-component-pagination-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-pagination-border-color').val();

				var style = jQuery('#bootstrap-component-pagination-style').val();
				var nav_class = jQuery('#bootstrap-component-pagination-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_sizing = sizing != '' ? ' ' + sizing : '';
				var class_align = align != '' ? ' ' + align : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';

				var class_nav_class = nav_class != '' ? ' ' + nav_class : '';

				var content = jQuery('#bootstrap-component-pagination-content').val();
				var contentArr = content.split('\n');
				var content_li = '';
				for(var i = 0; i < contentArr.length;i++){
					var keyArr = contentArr[i].split('|');
					var active = keyArr[0] == 'active' ? ' active' : '';
					var disabled = keyArr[0] == 'disabled' ? ' disabled' : '';
					var tabindex = keyArr[0] == 'disabled' ? ' tabindex="-1"' : '';
					var class_bgcolor_noactive = keyArr[0] != 'active' ? class_bgcolor : '';
					content_li += 	'		<li class="page-item' + active + disabled + '">\n' + 
									'			<a class="page-link' + class_color + class_bgcolor_noactive + class_border_color + '" href="' + keyArr[2] + '"' + tabindex + '>' + keyArr[1] + '</a>\n' + 
									'		</li>\n';
				}

				return 	'<nav class="' + class_nav_class + '"' + attr_style + ' id="' + id + '" aria-label="' + label + '">\n	<ul class="pagination' + class_sizing + class_align + '">\n' + content_li + '	</ul>\n</nav>\n';
			}
		}, 
		'popovers': {
			'title': 'PopOvers', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-id" id="bootstrap-component-popovers-id" value="" placeholder="popover_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-label" id="bootstrap-component-popovers-label" value="" placeholder="PopOver..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-title">Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-title" id="bootstrap-component-popovers-title" value="" placeholder="Title..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-content">Content</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-content" id="bootstrap-component-popovers-content" value="" placeholder="Content..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-tabindex">TabIndex</label><div class="col-sm-6"><input type="number" name="bootstrap-component-popovers-tabindex" id="bootstrap-component-popovers-tabindex" value="" placeholder="0" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-direction">Direction</label><div class="col-sm-6"><select name="bootstrap-component-popovers-direction" id="bootstrap-component-popovers-direction">' + bootstrap_options_direction + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-btncolor">Btn-Color</label><div class="col-sm-6"><select name="bootstrap-component-popovers-btncolor" id="bootstrap-component-popovers-btncolor">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-outline">Outline</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-popovers-outline" id="bootstrap-component-popovers-outline" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-size">Btn-Size</label><div class="col-sm-6"><select name="bootstrap-component-popovers-size" id="bootstrap-component-popovers-size"><option value="">Normal</option><option value="btn-sm">Small</option><option value="btn-lg">Large</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-popovers-color" id="bootstrap-component-popovers-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-popovers-bgcolor" id="bootstrap-component-popovers-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-popovers-border-color" id="bootstrap-component-popovers-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-popovers-border-radius" id="bootstrap-component-popovers-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-style" id="bootstrap-component-popovers-style" value="" placeholder="pointer-events: none" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-popovers-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-popovers-class" id="bootstrap-component-popovers-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-popovers-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-popovers-id').val();
				var label = jQuery('#bootstrap-component-popovers-label').val();
				var title = jQuery('#bootstrap-component-popovers-title').val();
				var content = jQuery('#bootstrap-component-popovers-content').val();
				var tabindex = jQuery('#bootstrap-component-popovers-tabindex').val();
				var direction = jQuery('#bootstrap-component-popovers-direction').val();

				var btncolor = jQuery('#bootstrap-component-popovers-btncolor').val();
				var outline = jQuery('#bootstrap-component-popovers-outline').attr('checked');
				var size = jQuery('#bootstrap-component-popovers-size').val();
				var color = jQuery('#bootstrap-component-popovers-color').val();
				var bgcolor = jQuery('#bootstrap-component-popovers-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-popovers-border-color').val();
				var border_radius = jQuery('#bootstrap-component-popovers-border-radius').val();

				var style = jQuery('#bootstrap-component-popovers-style').val();
				var popovers_class = jQuery('#bootstrap-component-popovers-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var btn_selector_outline = outline == 'checked' ? 'outline-' : '';
				var class_btncolor = btncolor != '' ? ' btn-' + btn_selector_outline + btncolor : '';
				var class_size = size != '' ? ' ' + size : '';
				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_popovers_class = popovers_class != '' ? ' ' + popovers_class : '';

				return 	'<a href="#" id="' + id + '" tabindex="' + tabindex + '" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="' + direction + '" title="' + title + '" data-content="' + content + '" class="btn' + class_btncolor + class_size + class_color + class_bgcolor + class_border_color + class_border_radius + class_popovers_class + '"' + attr_style + ' role="button">' + label + '</a>\n';
			}
		}, 
		'progress': {
			'title': 'Progress', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-progress-id" id="bootstrap-component-progress-id" value="" placeholder="progress_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-progress-label" id="bootstrap-component-progress-label" value="" placeholder="25%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-value">Value</label><div class="col-sm-6"><input type="number" name="bootstrap-component-progress-value" id="bootstrap-component-progress-value" value="" placeholder="25" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-min">Min</label><div class="col-sm-6"><input type="number" name="bootstrap-component-progress-min" id="bootstrap-component-progress-min" value="" placeholder="0" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-max">Max</label><div class="col-sm-6"><input type="number" name="bootstrap-component-progress-max" id="bootstrap-component-progress-max" value="" placeholder="100" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-progress-color" id="bootstrap-component-progress-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-progress-bgcolor" id="bootstrap-component-progress-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-progress-border-color" id="bootstrap-component-progress-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-progress-border-types" id="bootstrap-component-progress-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-progress-border-radius" id="bootstrap-component-progress-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-striped">Striped</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-progress-striped" id="bootstrap-component-progress-striped" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-animated">Animated</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-progress-animated" id="bootstrap-component-progress-animated" value="1" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-progress-style" id="bootstrap-component-progress-style" value="" placeholder="height: 1px" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-progress-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-progress-class" id="bootstrap-component-progress-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-progress-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-progress-id').val();
				var label = jQuery('#bootstrap-component-progress-label').val();
				var value = jQuery('#bootstrap-component-progress-value').val();
				var min = jQuery('#bootstrap-component-progress-min').val();
				var max = jQuery('#bootstrap-component-progress-max').val();

				var color = jQuery('#bootstrap-component-progress-color').val();
				var bgcolor = jQuery('#bootstrap-component-progress-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-progress-border-color').val();
				var border_types = jQuery('#bootstrap-component-progress-border-types').val();
				var border_radius = jQuery('#bootstrap-component-progress-border-radius').val();

				var striped = jQuery('#bootstrap-component-progress-striped').attr('checked');
				var animated = jQuery('#bootstrap-component-progress-animated').attr('checked');

				var style = jQuery('#bootstrap-component-progress-style').val();
				var progress_class = jQuery('#bootstrap-component-progress-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_striped = striped == 'checked' ? ' progress-bar-striped' : '';
				var class_animated = animated == 'checked' ? ' progress-bar-animated' : '';

				var class_progress_class = progress_class != '' ? ' ' + progress_class : '';

				return 	'<div id="' + id + '" class="progress' + class_progress_class + '"' + attr_style + '>\n	<div class="progress-bar' + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + class_striped + class_animated + '" style="width: ' + value + '%" role="progressbar" aria-valuenow="' + value + '" aria-valuemin="' + min + '" aria-valuemax="' + max + '">' + label + '</div>\n</div>\n';
			}
		}, 
		'scrollspy': {
			'title': 'ScrollSpy', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-scrollspy-id" id="bootstrap-component-scrollspy-id" value="" placeholder="scrollspy_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-display">Display</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-display" id="bootstrap-component-scrollspy-display"><option value="">Normal</option><option value="tab">Tabs</option><option value="pill">Pills</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-align">Nav - Align</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-align" id="bootstrap-component-scrollspy-align"><option value="">Left</option><option value="justify-content-center">Center</option><option value="justify-content-end">Right</option><option value="nav-justified">Justify</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-column-sizing">Column - Sizing</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-column-sizing" id="bootstrap-component-scrollspy-column-sizing"><option value="">No Colums</option><option value="1">&nbsp;1 - 11</option><option value="2">&nbsp;2 - 10</option><option value="3">&nbsp;3 -&nbsp;&nbsp;9</option><option value="4">&nbsp;4 -&nbsp;&nbsp;8</option><option value="5">&nbsp;5 -&nbsp;&nbsp;7</option><option value="6">&nbsp;6 -&nbsp;&nbsp;6</option><option value="7">&nbsp;7 -&nbsp;&nbsp;5</option><option value="8">&nbsp;8 -&nbsp;&nbsp;4</option><option value="9">&nbsp;9 -&nbsp;&nbsp;3</option><option value="10">10 -&nbsp;&nbsp;2</option><option value="11">11 -&nbsp;&nbsp;1</option></select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-nav-border-color">Nav-Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-nav-border-color" id="bootstrap-component-scrollspy-nav-border-color">' + bootstrap_options_colors + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-color" id="bootstrap-component-scrollspy-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-bgcolor" id="bootstrap-component-scrollspy-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-border-color" id="bootstrap-component-scrollspy-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-border-types">Border-Types</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-border-types" id="bootstrap-component-scrollspy-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-scrollspy-border-radius" id="bootstrap-component-scrollspy-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-scrollspy-style" id="bootstrap-component-scrollspy-style" value="" placeholder="height: 200px;overflow-y: scroll;box-shadow: 1px 1px 3px #000" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-scrollspy-class" id="bootstrap-component-scrollspy-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-scrollspy-content">Content</label><div class="col-sm-6"><textarea name="bootstrap-component-scrollspy-content" id="bootstrap-component-scrollspy-content" cols="20" rows="8" placeholder="active|link_01|Link 01|Text 01...\n|link_02|Link 02|Text 02...\n|link_03|Link 03|Text 03..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-scrollspy-content').val() == '' ? 'Bitte geben Sie ein Text ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-scrollspy-id').val();
				var display = jQuery('#bootstrap-component-scrollspy-display').val();
				var align = jQuery('#bootstrap-component-scrollspy-align').val();
				var column_sizing = jQuery('#bootstrap-component-scrollspy-column-sizing').val();

				var nav_border_color = jQuery('#bootstrap-component-scrollspy-nav-border-color').val();

				var color = jQuery('#bootstrap-component-scrollspy-color').val();
				var bgcolor = jQuery('#bootstrap-component-scrollspy-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-scrollspy-border-color').val();
				var border_types = jQuery('#bootstrap-component-scrollspy-border-types').val();
				var border_radius = jQuery('#bootstrap-component-scrollspy-border-radius').val();

				var style = jQuery('#bootstrap-component-scrollspy-style').val();
				var nav_class = jQuery('#bootstrap-component-scrollspy-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var class_display = display != '' ? ' nav-' + display + 's' : '';
				var class_align = align != '' ? ' ' + align : '';
				var class_nav_item = align == 'nav-justified' ? ' nav-item' : '';

				var class_nav_border_color = nav_border_color != '' ? ' border-' + nav_border_color : '';

				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' border ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_nav_class = nav_class != '' ? ' ' + nav_class : '';

				var row_open = column_sizing != '' ? '<div class="row">\n' : '';
				var row_close = column_sizing != '' ? '</div>\n' : '';
				var col_tablist_open = column_sizing != '' ? '<div class="col-' + column_sizing + '">\n' : '';
				var col_tablist_close = column_sizing != '' ? '</div>\n' : '';
				var col_tabcontent_open = column_sizing != '' ? '<div class="col-' + (12 - column_sizing) + '">\n' : '';
				var col_tabcontent_close = column_sizing != '' ? '</div>\n' : '';
				var class_flex_column = column_sizing != '' ? ' flex-sm-column' : '';

				var content = jQuery('#bootstrap-component-scrollspy-content').val();
				var contentArr = content.split('\n');
				var content_tablist = '';
				var content_tabpanel = '';
				for(var i = 0; i < contentArr.length;i++){
					var keyArr = contentArr[i].split('|');
					var active = keyArr[0] == 'active' ? ' active' : '';
					var selected = keyArr[0] == 'active' ? 'true' : 'false';
					var show = keyArr[0] == 'active' ? ' show' : '';
					content_tablist += '	<a class="nav-link' + class_nav_item + active + '" id="nav-' + keyArr[1] + '-tab" href="#nav-' + keyArr[1] + '" role="tab" aria-controls="nav-' + keyArr[1] + '" aria-selected="' + selected + '">' + keyArr[2] + '</a>\n';
					content_tabpanel += '	<h4 id="nav-' + keyArr[1] + '">' + keyArr[2] + '</h4>\n' + 
										'	<div class="mb-1">' + keyArr[3] + '</div>\n';
				}

				return 	row_open + col_tablist_open + '<nav class="nav' + class_display + class_flex_column + class_align + class_nav_class + class_nav_border_color + '" id="' + id + '" role="tablist">\n' + content_tablist + '</nav>\n' + col_tablist_close + col_tabcontent_open + '<div data-spy="scroll" data-target="#' + id + '" data-offset="0" class="p-3' + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '"' + attr_style + '>\n' + content_tabpanel + '</div>\n' + col_tabcontent_close + row_close;
			}
		}, 
		'tooltips': {
			'title': 'ToolTips', 
			'form': '<div class="form-group row">' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-id">Id</label><div class="col-sm-6"><input type="text" name="bootstrap-component-tooltips-id" id="bootstrap-component-tooltips-id" value="" placeholder="tooltip_id" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-label">Label</label><div class="col-sm-6"><input type="text" name="bootstrap-component-tooltips-label" id="bootstrap-component-tooltips-label" value="" placeholder="ToolTip..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-title">Title</label><div class="col-sm-6"><input type="text" name="bootstrap-component-tooltips-title" id="bootstrap-component-tooltips-title" value="" placeholder="Title..." ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-tabindex">TabIndex</label><div class="col-sm-6"><input type="number" name="bootstrap-component-tooltips-tabindex" id="bootstrap-component-tooltips-tabindex" value="" placeholder="0" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-direction">Direction</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-direction" id="bootstrap-component-tooltips-direction">' + bootstrap_options_direction + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-btncolor">Btn-Color</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-btncolor" id="bootstrap-component-tooltips-btncolor">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-outline">Outline</label><div class="col-sm-6"><input type="checkbox" name="bootstrap-component-tooltips-outline" id="bootstrap-component-tooltips-outline" value="1" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-size">Btn-Size</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-size" id="bootstrap-component-tooltips-size"><option value="">Normal</option><option value="btn-sm">Small</option><option value="btn-lg">Large</option></select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-color">Color</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-color" id="bootstrap-component-tooltips-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-bgcolor">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-bgcolor" id="bootstrap-component-tooltips-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-border-color">Border-Color</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-border-color" id="bootstrap-component-tooltips-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-border-radius">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-component-tooltips-border-radius" id="bootstrap-component-tooltips-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 

					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-style">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-component-tooltips-style" id="bootstrap-component-tooltips-style" value="" placeholder="pointer-events: none" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label class="col-sm-6 col-form-label" for="bootstrap-component-tooltips-class">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-component-tooltips-class" id="bootstrap-component-tooltips-class" value="" placeholder="mb-3" ondblclick="this.value=this.placeholder" /></div>' + 

					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-component-tooltips-label').val() == '' ? 'Bitte geben Sie ein Label ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){
				var id = jQuery('#bootstrap-component-tooltips-id').val();
				var label = jQuery('#bootstrap-component-tooltips-label').val();
				var title = jQuery('#bootstrap-component-tooltips-title').val();
				var tabindex = jQuery('#bootstrap-component-tooltips-tabindex').val();
				var direction = jQuery('#bootstrap-component-tooltips-direction').val();

				var btncolor = jQuery('#bootstrap-component-tooltips-btncolor').val();
				var outline = jQuery('#bootstrap-component-tooltips-outline').attr('checked');
				var size = jQuery('#bootstrap-component-tooltips-size').val();
				var color = jQuery('#bootstrap-component-tooltips-color').val();
				var bgcolor = jQuery('#bootstrap-component-tooltips-bgcolor').val();
				var border_color = jQuery('#bootstrap-component-tooltips-border-color').val();
				var border_radius = jQuery('#bootstrap-component-tooltips-border-radius').val();

				var style = jQuery('#bootstrap-component-tooltips-style').val();
				var tooltips_class = jQuery('#bootstrap-component-tooltips-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';

				var btn_selector_outline = outline == 'checked' ? 'outline-' : '';
				var class_btncolor = btncolor != '' ? ' btn-' + btn_selector_outline + btncolor : '';
				var class_size = size != '' ? ' ' + size : '';
				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';

				var class_tooltips_class = tooltips_class != '' ? ' ' + tooltips_class : '';

				return 	'<a href="#" id="' + id + '" tabindex="' + tabindex + '" data-container="body" data-toggle="tooltip" data-trigger="focus" data-placement="' + direction + '" title="' + title + '" class="btn' + class_btncolor + class_size + class_color + class_bgcolor + class_border_color + class_border_radius + class_tooltips_class + '"' + attr_style + ' role="button">' + label + '</a>\n';
			}
		}, 
		'card_with_nav_tabs': {
			'title': 'Card Navs Tabs', 
			'form': '<div class="form-group row">' + 
					'	<label for="bootstrap-card_with_nav_tabs-color" class="col-sm-6 col-form-label">Color</label><div class="col-sm-6"><select name="bootstrap-card_with_nav_tabs-color" id="bootstrap-card_with_nav_tabs-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-bgcolor" class="col-sm-6 col-form-label">Bg-Color</label><div class="col-sm-6"><select name="bootstrap-card_with_nav_tabs-bgcolor" id="bootstrap-card_with_nav_tabs-bgcolor">' + bootstrap_options_bgcolors + '</select></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-border-color" class="col-sm-6 col-form-label">Border-Color</label><div class="col-sm-6"><select name="bootstrap-card_with_nav_tabs-border-color" id="bootstrap-card_with_nav_tabs-border-color">' + bootstrap_options_colors + '</select></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-border-types" class="col-sm-6 col-form-label">Border-Types</label><div class="col-sm-6"><select name="bootstrap-card_with_nav_tabs-border-types" id="bootstrap-card_with_nav_tabs-border-types">' + bootstrap_options_border_types + '</select></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-border-radius" class="col-sm-6 col-form-label">Border-Radius</label><div class="col-sm-6"><select name="bootstrap-card_with_nav_tabs-border-radius" id="bootstrap-card_with_nav_tabs-border-radius">' + bootstrap_options_border_radius + '</select></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-style" class="col-sm-6 col-form-label">Style</label><div class="col-sm-6"><input type="text" name="bootstrap-card_with_nav_tabs-style" id="bootstrap-card_with_nav_tabs-style" value="" placeholder="width: 80%" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-class" class="col-sm-6 col-form-label">Class</label><div class="col-sm-6"><input type="text" name="bootstrap-card_with_nav_tabs-class" id="bootstrap-card_with_nav_tabs-class" value="" placeholder="extra-class" ondblclick="this.value=this.placeholder" /></div>' + 
					'	<label for="bootstrap-card_with_nav_tabs-content" class="col-sm-6 col-form-label">Content</label><div class="col-sm-6"><textarea name="bootstrap-card_with_nav_tabs-content" id="bootstrap-card_with_nav_tabs-content" cols="20" rows="8" placeholder="card_nav_tab_01|Nav Tab 01|Tab Content 01 ...\ncard_nav_tab_02|Nav Tab 02|Tab Content 02 ...\ncard_nav_tab_03|Nav Tab 03|Tab Content 03 ..." ondblclick="this.value=this.placeholder"></textarea></div>' + 
					'</div>', 
			'checkFormMessage': function (){
				return $('#bootstrap-content-form-button-content').val() == '' ? 'Bitte geben Sie ein Content ein. Sie können auch doppelt in das Textfeld klicken um den Platzhalter-Inhalt zu übernehmen.' : '';
			},
			'html': function (){

				var color = jQuery('#bootstrap-card_with_nav_tabs-color').val();
				var bgcolor = jQuery('#bootstrap-card_with_nav_tabs-bgcolor').val();
				var border_color = jQuery('#bootstrap-card_with_nav_tabs-border-color').val();
				var border_types = jQuery('#bootstrap-card_with_nav_tabs-border-types').val();
				var border_radius = jQuery('#bootstrap-card_with_nav_tabs-border-radius').val();

				var style = jQuery('#bootstrap-card_with_nav_tabs-style').val();
				var div_class = jQuery('#bootstrap-card_with_nav_tabs-class').val();

				var attr_style = style != '' ? ' style="' + style + '"' : '';
				
				var class_color = color != '' ? ' text-' + color : '';
				var class_bgcolor = bgcolor != '' ? ' bg-' + bgcolor : '';
				var class_border_color = border_color != '' ? ' border-' + border_color : '';
				var class_border_types = border_types != '' ? ' ' + border_types : '';
				var class_border_radius = border_radius != '' ? ' ' + border_radius : '';
				
				div_class = div_class != '' ? ' ' + div_class : '';
				
				var content = jQuery('#bootstrap-card_with_nav_tabs-content').val();
				var content_arr = content.split('\n');

				var nav_items = '';
				var tabs_content = '';

				for(var i = 0;i < content_arr.length;i++){

					var keyArr = content_arr[i].split('|');

					nav_items += 	i == 0 ? 
									'			<li class="nav-item"><a href="#' + keyArr[0] + '" class="nav-link active show" data-toggle="tab" role="tab" aria-controls="' + keyArr[0] + '" aria-selected="true">' + keyArr[1] + '</a></li>' : 
									'			<li class="nav-item"><a href="#' + keyArr[0] + '" class="nav-link" data-toggle="tab" role="tab" aria-controls="' + keyArr[0] + '" aria-selected="false">' + keyArr[1] + '</a></li>';

					tabs_content += i == 0 ? 
									'		<div id="' + keyArr[0] + '" class="card-body tab-pane fade active show" role="tabpanel">' + 
									'			' + keyArr[2] + 
									'		</div>' : 
									'		<div id="' + keyArr[0] + '" class="card-body tab-pane fade" role="tabpanel">' + 
									'			' + keyArr[2] + 
									'		</div>';

				}

				return 	'<div class="card' + div_class + class_color + class_bgcolor + class_border_color + class_border_types + class_border_radius + '"' + attr_style + '>' + 
						'	<div class="card-header">' + 
						'		<ul class="nav nav-tabs card-header-tabs" id="bootstrapTab" role="tablist">' + 
						nav_items + 
						'		</ul>' + 
						'	</div>' + 
						'	<div class="tab-content" id="bootstrapTabContent">' + 
						tabs_content + 
						'	</div>' + 
						'</div>';
			}
		}, 
	};

}));