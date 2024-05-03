<?php 

	$script_enable = true; // Switch script to true or false

	/* --------------------------------------------------- */

	if($script_enable == true){
		echo 	"<script src=\"/js/bootstrap-switch.js\"></script>\n" . 
				"<script>\n" . 
				"var bootstrap_switches = '.bootstrap-switch';" . 
				"$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');\n" . 
				"$(bootstrap_switches).bootstrapSwitch({\n" . 
				"	on: 'Ja',\n" . 
				"	off: 'Nein ',\n" . 
				"	onLabel: 'ja',\n" . 
				"	offLabel: 'nein',\n" . 
				"	same: true,\n" . 
				"	size: 'sm',\n" . 
				"	onClass: 'success',\n" . 
				"	offClass: 'danger'\n" . 
				"});\n" . 
				"var bootstrap_switches = '.bootstrap-switch-access';" . 
				"$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');\n" . 
				"$(bootstrap_switches).bootstrapSwitch({\n" . 
				"	on: 'Zugriff erlauben',\n" . 
				"	off: 'Zugriff nicht erlauben',\n" . 
				"	onLabel: 'ja',\n" . 
				"	offLabel: 'nein',\n" . 
				"	same: true,\n" . 
				"	size: 'sm',\n" . 
				"	onClass: 'success',\n" . 
				"	offClass: 'danger'\n" . 
				"});\n" . 
				"var bootstrap_switches = '.bootstrap-switch-access-yes-no';" . 
				"$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');\n" . 
				"$(bootstrap_switches).bootstrapSwitch({\n" . 
				"	on: 'Ja',\n" . 
				"	off: 'Nein',\n" . 
				"	onLabel: 'ja',\n" . 
				"	offLabel: 'nein',\n" . 
				"	same: true,\n" . 
				"	size: 'lg',\n" . 
				"	onClass: 'success',\n" . 
				"	offClass: 'danger'\n" . 
				"});\n" . 
				"</script>\n";
	}

?>