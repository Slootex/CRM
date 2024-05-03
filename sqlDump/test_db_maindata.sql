-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: test_db
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `maindata`
--

DROP TABLE IF EXISTS `maindata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maindata` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned DEFAULT NULL,
  `company` varchar(128) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `streetno` varchar(10) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `country` int unsigned DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `mobilnumber` varchar(100) DEFAULT NULL,
  `bank_name` varchar(128) DEFAULT NULL,
  `bank_iban` varchar(128) DEFAULT NULL,
  `bank_bic` varchar(20) DEFAULT NULL,
  `logo_url` varchar(256) DEFAULT NULL,
  `logout_index` varchar(256) DEFAULT NULL,
  `user_index` varchar(256) DEFAULT NULL,
  `input_file_accept` varchar(512) DEFAULT NULL,
  `input_file_audio_accept` varchar(512) DEFAULT NULL,
  `url_password` varchar(128) DEFAULT NULL,
  `super_password` varchar(128) DEFAULT NULL,
  `mwst` int DEFAULT NULL,
  `counter` int DEFAULT NULL,
  `customer_history_delay_time` int DEFAULT NULL,
  `smtp_host` varchar(256) DEFAULT NULL,
  `smtp_username` varchar(256) DEFAULT NULL,
  `smtp_password` varchar(256) DEFAULT NULL,
  `smtp_secure` varchar(256) DEFAULT NULL,
  `smtp_port` int DEFAULT NULL,
  `smtp_charset` varchar(256) DEFAULT NULL,
  `smtp_debug` tinyint(1) DEFAULT NULL,
  `vindecoder_url` varchar(256) DEFAULT NULL,
  `vindecoder_api_key` varchar(20) DEFAULT NULL,
  `vindecoder_secret` varchar(20) DEFAULT NULL,
  `ups_url` varchar(256) DEFAULT NULL,
  `ups_username` varchar(20) DEFAULT NULL,
  `ups_password` varchar(20) DEFAULT NULL,
  `ups_customer_number` varchar(20) DEFAULT NULL,
  `ups_access_license_number` varchar(20) DEFAULT NULL,
  `package` int unsigned DEFAULT NULL,
  `new_shipping_status` int unsigned DEFAULT NULL,
  `pickup_status` int unsigned DEFAULT NULL,
  `sleep_shipping_label` int DEFAULT NULL,
  `delete_temp_date` varchar(20) DEFAULT NULL,
  `supervisor_id` int unsigned DEFAULT NULL,
  `admin_id` int unsigned DEFAULT NULL,
  `storage_space_owner_id` int unsigned DEFAULT NULL,
  `order_status` int unsigned DEFAULT NULL,
  `order_status_intern` int unsigned DEFAULT NULL,
  `shipping_status` int unsigned DEFAULT NULL,
  `shipping_cancel_status` int unsigned DEFAULT NULL,
  `email_status` int unsigned DEFAULT NULL,
  `order_to_archive_status` int unsigned DEFAULT NULL,
  `archive_to_order_status` int unsigned DEFAULT NULL,
  `order_payed_status` int unsigned DEFAULT NULL,
  `order_to_booking_status` int unsigned DEFAULT NULL,
  `order_ending_status` int unsigned DEFAULT NULL,
  `order_claim_status` int unsigned DEFAULT NULL,
  `order_recall_status` int unsigned DEFAULT NULL,
  `order_in_checkout_status` int unsigned DEFAULT NULL,
  `order_extra_evaluation_status` int unsigned DEFAULT NULL,
  `order_inspection_process_status` int unsigned DEFAULT NULL,
  `order_extra_verification_status` int unsigned DEFAULT NULL,
  `order_extra_edit_status` int unsigned DEFAULT NULL,
  `order_extra_checkout_status` int unsigned DEFAULT NULL,
  `order_new_device_status` int unsigned DEFAULT NULL,
  `order_problem_status` int unsigned DEFAULT NULL,
  `order_packing_user_status` int unsigned DEFAULT NULL,
  `order_packing_technic_status` int unsigned DEFAULT NULL,
  `order_packing_extern_status` int unsigned DEFAULT NULL,
  `order_next_storage_status` int unsigned DEFAULT NULL,
  `order_relocate_status` int unsigned DEFAULT NULL,
  `order_labeling_status` int unsigned DEFAULT NULL,
  `order_photo_status` int unsigned DEFAULT NULL,
  `order_reset_status` int unsigned DEFAULT NULL,
  `order_extended_items` text,
  `user_status` int unsigned DEFAULT NULL,
  `user_status_intern` int unsigned DEFAULT NULL,
  `user_register_status` int unsigned DEFAULT NULL,
  `user_email_status` int unsigned DEFAULT NULL,
  `interested_status` int unsigned DEFAULT NULL,
  `interested_status_intern` int unsigned DEFAULT NULL,
  `interested_status_intern_orderform_per_mail` int unsigned DEFAULT NULL,
  `interested_email_status` int unsigned DEFAULT NULL,
  `interested_to_archive_status` int unsigned DEFAULT NULL,
  `archive_to_interested_status` int unsigned DEFAULT NULL,
  `order_to_interested_status` int unsigned DEFAULT NULL,
  `order_archive_to_interested_status` int unsigned DEFAULT NULL,
  `interested_to_order_status` int unsigned DEFAULT NULL,
  `interested_success_status` int unsigned DEFAULT NULL,
  `interested_new_device_status` int unsigned DEFAULT NULL,
  `interested_problem_status` int unsigned DEFAULT NULL,
  `interested_packing_user_status` int unsigned DEFAULT NULL,
  `interested_packing_technic_status` int unsigned DEFAULT NULL,
  `interested_packing_extern_status` int unsigned DEFAULT NULL,
  `interested_next_storage_status` int unsigned DEFAULT NULL,
  `interested_relocate_status` int unsigned DEFAULT NULL,
  `interested_labeling_status` int unsigned DEFAULT NULL,
  `interested_photo_status` int unsigned DEFAULT NULL,
  `interested_reset_status` int unsigned DEFAULT NULL,
  `shopping_status` int unsigned DEFAULT NULL,
  `shopping_to_archive_status` int unsigned DEFAULT NULL,
  `archive_to_shoppings_status` int unsigned DEFAULT NULL,
  `retoure_status` int unsigned DEFAULT NULL,
  `shopping_to_retoures_status` int unsigned DEFAULT NULL,
  `retoure_to_shoppings_status` int unsigned DEFAULT NULL,
  `packing_status` int unsigned DEFAULT NULL,
  `packing_to_archive_status` int unsigned DEFAULT NULL,
  `archive_to_packings_status` int unsigned DEFAULT NULL,
  `style_backend` longtext,
  `script_backend` longtext,
  `script_backend_activate` tinyint(1) DEFAULT NULL,
  `seal_days` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `secret_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maindata`
--

LOCK TABLES `maindata` WRITE;
/*!40000 ALTER TABLE `maindata` DISABLE KEYS */;
INSERT INTO `maindata` VALUES (1,1,'GZA MOTORS',0,'Gazi','Ahmad','Strausberger Platz','13','10243','Berlin',1,'info@gzamotors.de','042159564922','015112336769','solarisBank Gf','DE75110101015665686305','SOBKDEB2XXX','#','/admin/abmelden','/kunden/dashboard','.gif,.jpg,.pdf,.jpeg,.png,.txt,.mov,.rar,.JPG,.mp4,.docx,.zip,.csv,.PDF','.mp3,.m4a','geheimercode8','Gähn',19,1,2880,'w01a1094.kasserver.com','service@gzamotors.de','UC8Xc9Fva2rET2RT','tls',587,'UTF-8',0,'','','','https://onlinetools.ups.com','GZAMOTORSAPI','3@4o.zZw%Qhr','A285F8','3D438DA31508F3ED',1,74,81,0,'1628425794',1,8,8,8,36,37,75,38,77,78,31,82,1,11,19,7,32,21,10,13,83,125,130,132,133,144,146,136,137,138,149,'gummi|Gummibärchen|1\r\nean|Überspannungsschutz|0\r\nvp-si|Versiegeln|0',42,43,151,44,45,46,73,47,79,80,107,108,76,72,126,131,134,135,145,147,139,140,141,150,110,111,112,113,114,115,127,128,129,'','<script>\r\n$(document).ready(function(){\r\n	//autologout_interval = window.setInterval(function (){setAutologout();}, 1000);\r\n});\r\n\r\n/*$(\'.card-maximize\')\r\n	.css({\r\n		\'top\': 0, \r\n		\'left\': 0, \r\n		\'width\': \'100%\', \r\n		\'max-height\': \'100%\', \r\n		\'overflow-x\': \'auto\'\r\n	})\r\n	.find(\'.card-header\')\r\n	.addClass(\'pr-3\')\r\n	.find(\'h4\')\r\n	.append(\'<div class=\"float-right text-primary bg-white border border-primary rounded expand mr-0 text-center\" style=\"font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer\"><i class=\"fa fa-arrows-alt\" aria-hidden=\"true\"></i></div>\')\r\n	.on(\'click\', \'.expand\', function(){\r\n		if(this.parentElement.parentElement.parentElement.style.position==\'static\'||this.parentElement.parentElement.parentElement.style.position==\'\'){\r\n			$(this).parent().parent().parent().css({\'position\': \'fixed\', \'z-index\': \'999\'}).find(\'.card-body\').removeClass(\'pb-0\').addClass(\'pb-5\');\r\n		}else{\r\n			$(this).parent().parent().parent().css({\'position\': \'static\', \'z-index\': \'1\'}).find(\'.card-body\').removeClass(\'pb-5\').addClass(\'pb-0\');\r\n		}\r\n	});*/\r\n\r\n/*$(\'.expand\')\r\n	.hover(\r\n		function() {\r\n			$(this).removeClass(\'text-primary bg-white\').addClass(\'text-white bg-primary\');\r\n		}, function() {\r\n			$(this).removeClass(\'text-white bg-primary\').addClass(\'text-primary bg-white\');\r\n		}\r\n	);*/\r\n\r\n/*$(\'.card-minimize\')\r\n	.find(\'.card-header\')\r\n	.addClass(\'pr-3\')\r\n	.find(\'h4\')\r\n	.append(\'<div class=\"float-right text-primary bg-white border border-primary rounded card-collapse mr-0 text-center\" style=\"font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer\"><i class=\"fa fa-caret-square-o-down\" aria-hidden=\"true\"></i></div>\')\r\n	.on(\'click\', \'.card-collapse\', function(){\r\n		$(this).parent().parent().parent().find(\'.card-body\').slideToggle(\'slow\');\r\n	});*/\r\n\r\n/*$(\'.card-collapse\')\r\n	.hover(\r\n		function() {\r\n			$(this).removeClass(\'text-primary bg-white\').addClass(\'text-white bg-primary\');\r\n		}, function() {\r\n			$(this).removeClass(\'text-white bg-primary\').addClass(\'text-primary bg-white\');\r\n		}\r\n	);*/\r\n\r\n/* Set marquee to userinfo */\r\n//$(\'#user_info\').html(\'<marquee behavior=\"alternate\">\' + $(\'#user_info\').html() + \'</marquee>\').addClass(\'w-75\');\r\n\r\n/* Scroll-Top-Button */\r\n/*$(document).ready(function(){\r\n	var back_to_top_button = [\'<a href=\"#top\" class=\"back-to-top btn btn-primary border border-white p-1\" style=\"position: fixed;bottom: 2px;left: 6px;border-radius: 50%;box-shadow: 0 0 4px rgba(0,0,0,.8);line-height: 6px;z-Index: 1001\"><i class=\"fa fa-arrow-up\" style=\"font-size: 10px\"> </i></a>\'].join(\"\");\r\n	$(\"body\").append(back_to_top_button);\r\n\r\n	$(\".back-to-top\").hide();\r\n\r\n	$(window).scroll(function () {\r\n		if ($(this).scrollTop() > 100) {\r\n			$(\'.back-to-top\').fadeIn();\r\n		} else {\r\n			$(\'.back-to-top\').fadeOut();\r\n		}\r\n	});\r\n\r\n	$(\'.back-to-top\').click(function () {\r\n		$(\'body,html\').animate({\r\n			scrollTop: 0\r\n		}, 800);\r\n		return false;\r\n	});\r\n\r\n});*/\r\n\r\n$(document).ready(function(){\r\n	var todayRecalls = 0;\r\n	var listRecalls = \'\';\r\n	var order_areas = [\'neue-auftraege\', \'auftrag-archiv\', \'neue-interessenten\', \'interessenten-archiv\'];\r\n	for (var i = 0; i < dates.length; i++) {\r\n		if (dates[i][\'today\'] === true) {\r\n			listRecalls += \'<tr><td><a href=\"/admin/\' + order_areas[dates[i][\'mode\']] + \'/bearbeiten/\' + dates[i][\'id\'] + \'\">\' + dates[i][\'date\'].replace(\" \", \" - \") + \' Uhr</a></td><td><a href=\"/admin/\' + order_areas[dates[i][\'mode\']] + \'/bearbeiten/\' + dates[i][\'id\'] + \'\" class=\"btn btn-sm btn-primary\">öffnen</a></td></tr>\';\r\n			todayRecalls++;\r\n		}\r\n	}\r\n	$(\'#navbar_1\').after($(\'<div onclick=\"$(\\\'.recalls-dropdown-menu\\\').slideToggle(0)\" onfocus=\"this.blur()\" style=\"cursor: pointer\" onmouseover=\"$(\\\'.stack_bell.fa.fa-circle.fa-stack-2x\\\').toggleClass(\\\'text-primary text-secondary\\\')\" onmouseout=\"$(\\\'.stack_bell.fa.fa-circle.fa-stack-2x\\\').toggleClass(\\\'text-primary text-secondary\\\')\"><span class=\"fa-stack fa-3x\' + (todayRecalls == 0 ? \' normal\' : \' active\') + \'\" data-count=\"\' + todayRecalls + \'\"><i class=\"stack_bell fa fa-circle fa-stack-2x text-primary\"></i><i class=\"stack_bell fa fa-bell fa-stack-1x fa-inverse\"></i></span></div><div class=\"recalls-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0\" style=\"position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 260px;width: 300px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000\"><h4 class=\"font-weight-bold\"><u>Heutige Rückrufe</u>:</h4><table style=\"width: 260px\">\' + listRecalls + \'</table></div>\'));\r\n});\r\n</script>\r\n<style>\r\n.fa-stack {font-size: 1.1em;}\r\n.stack {vertical-align: middle;}\r\n.fa-stack[data-count]:after {\r\n  position: absolute;\r\n  right: -10px;\r\n  top: 1%;\r\n  content: attr(data-count);\r\n  font-size: 0.5em;\r\n  padding: .6em;\r\n  border-radius: 100%;\r\n  line-height: .75em;\r\n  color: white;\r\n  text-align: center;\r\n  min-width: 2em;\r\n  font-weight: bold;\r\n}\r\n.fa-stack[data-count].normal:after {\r\n  background-color: var(--danger);\r\n}\r\n.fa-stack[data-count].active:after {\r\n  background-color: var(--success);\r\n}\r\n</style>\r\n<script>\r\n/*var alert_date = \"03/28\";\r\nvar alert_text = \"Sie müssen unter \'Einstellungen/Grunddaten/Systemdaten/Temporäre Dateien\' die \'Temporäre Dateien\' entfernen!\";\r\nvar alert_d = new Date();\r\nvar alert_today = new Date();\r\nvar alert_dd = alert_today.getDate();\r\nvar alert_mm = alert_today.getMonth()+1; \r\nvar alert_yyyy = alert_today.getFullYear();\r\n\r\nif(alert_dd<10){\r\n	alert_dd = \'0\'+alert_dd;\r\n} \r\n\r\nif(alert_mm<10){\r\n	alert_mm = \'0\'+alert_mm;\r\n} \r\n\r\nalert_today = alert_mm + \'/\' + alert_dd;\r\nif(alert_today == alert_date){\r\n	location.href = \'/admin/grunddaten#v-pills-systemdata\';\r\n}*/\r\n</script>\r\n<script>\r\nwindow.onload = ToDoInit;\r\nfunction ToDoInit(){\r\n	var button = document.getElementById(\'todo_new\');\r\n	button.onclick = ToDoAdd;\r\n	var clearButton = document.getElementById(\'todo_delete_all\');\r\n	clearButton.onclick = ToDoDeleteAll;\r\n	var entriesArray = ToDoGetEntries();\r\n	for(var i = 0;i < entriesArray.length; i++){\r\n		var nr = entriesArray[i];\r\n		var value = JSON.parse(localStorage[nr]);\r\n		ToDoAddToDOM(nr, value);\r\n	}	\r\n}\r\nfunction ToDoGetEntries(){\r\n	var entriesArray = localStorage.getItem(\'entriesArray\');\r\n	if(!entriesArray){\r\n		entriesArray = [];\r\n		localStorage.setItem(\'entriesArray\', JSON.stringify(entriesArray));\r\n	}else{\r\n		entriesArray = JSON.parse(entriesArray);\r\n	}\r\n	return entriesArray;\r\n}\r\nfunction ToDoAdd(){\r\n	var entriesArray = ToDoGetEntries();\r\n	var notes = document.getElementById(\'todo_input\').value;\r\n	if(notes != \'\'){\r\n		var currentDate = new Date();\r\n		var nr = \'todo_note_\' + currentDate.getTime()	\r\n		localStorage.setItem(nr, JSON.stringify(notes));	\r\n		entriesArray.push(nr);\r\n		localStorage.setItem(\'entriesArray\', JSON.stringify(entriesArray));\r\n		ToDoAddToDOM(nr, notes);\r\n		document.getElementById(\'todo_input\').value = \'\';\r\n		$(\'.stack_edit_count\').attr(\'data-count\', ToDoGetEntries().length).removeClass(\'normal active\').addClass((ToDoGetEntries().length == 0 ? \'normal\' : \'active\'));\r\n	}else{\r\n		alert(\'Bitte geben Sie eine Notiz ein!\');\r\n	}\r\n}\r\nfunction ToDoDelete(e){\r\n	var nr = e.target.id;\r\n	var entriesArray = ToDoGetEntries();\r\n	if(entriesArray){\r\n		for(var i = 0;i < entriesArray.length;i++){\r\n			if(nr == entriesArray[i]){\r\n				entriesArray.splice(i, 1);\r\n			}\r\n		}\r\n		localStorage.removeItem(nr);\r\n		localStorage.setItem(\'entriesArray\', JSON.stringify(entriesArray));\r\n		ToDoDeleteFromDOM(nr);\r\n	}\r\n	$(\'.stack_edit_count\').attr(\'data-count\', ToDoGetEntries().length).removeClass(\'normal active\').addClass((ToDoGetEntries().length == 0 ? \'normal\' : \'active\'));\r\n}\r\nfunction ToDoDeleteAll() {\r\n	localStorage.clear();\r\n	var items = document.getElementById(\'todo_entries\');\r\n	var entries = items.childNodes;\r\n	for(var i = entries.length - 1;i >= 0;i--){\r\n		items.removeChild(entries[i]);\r\n	}\r\n	var entriesArray = ToDoGetEntries();\r\n	$(\'.stack_edit_count\').attr(\'data-count\', 0).removeClass(\'normal active\').addClass(\'normal\');\r\n}\r\nfunction ToDoAddToDOM(nr, text) {\r\n	var entries = document.getElementById(\'todo_entries\');\r\n	var entry = document.createElement(\'li\');\r\n	entry.setAttribute(\'id\', nr);\r\n	entry.className = \'todo_entry mb-2\';\r\n	entry.style.cursor = \'pointer\';\r\n    entry.innerHTML = text;\r\n	entries.appendChild(entry);\r\n	entry.onclick = ToDoDelete;\r\n}\r\nfunction ToDoDeleteFromDOM(nr){\r\n	var entry = document.getElementById(nr);\r\n	entry.parentNode.removeChild(entry);\r\n}\r\n$(document).ready(function(){\r\n	var todayNotes = ToDoGetEntries().length;\r\n	$(\'#navbar_1\').after($(\'<div style=\"cursor: pointer\" class=\"mr-2\" onclick=\"$(\\\'.notes-dropdown-menu\\\').slideToggle(0)\" onfocus=\"this.blur()\" onmouseover=\"$(\\\'.stack_edit.fa.fa-circle.fa-stack-2x\\\').toggleClass(\\\'text-primary text-secondary\\\')\" onmouseout=\"$(\\\'.stack_edit.fa.fa-circle.fa-stack-2x\\\').toggleClass(\\\'text-primary text-secondary\\\')\"><span class=\"stack_edit_count fa-stack fa-3x\' + (todayNotes == 0 ? \' normal\' : \' active\') + \'\" data-count=\"\' + todayNotes + \'\"><i class=\"stack_edit fa fa-circle fa-stack-2x text-primary\"></i><i class=\"stack_edit fa fa-edit fa-stack-1x fa-inverse\"></i></span></div><div class=\"notes-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0\" style=\"position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 360px;width: 800px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000\"><h4 class=\"font-weight-bold\"><u>Eigene Notizen</u>:</h4><div class=\"row\"><div class=\"col-sm-6\"><ol id=\"todo_entries\" class=\"p-3\"></ol></div><div class=\"col-sm-6\"><label for=\"todo_input\">Neue Notiz: </label><br /><input type=\"text\" id=\"todo_input\" value=\"\" class=\"form-control mb-3\"> <button id=\"todo_new\" class=\"btn btn-primary\">hinzufügen</button> <button id=\"todo_delete_all\" class=\"btn btn-primary\">Alle Notizen löschen</button></div></div></div>\'));\r\n});\r\n</script>\r\n<style>\r\n.todo_entry {\r\n	color: var(--primary);\r\n}\r\n.todo_entry:hover {\r\n	color: var(--danger);\r\n}\r\n</style>',1,'123','2024-01-26 20:12:37',NULL,'1234'),(2,2,'Altersvorsorge-Einfach',0,'Altersvorsorge','Einfach','Strausberger Platz','13','10243','Berlin',1,'beratung@altersvorsorge-einfach.de','03020967165','015112336769','Musterbank','DE12500105170648489890','BENEDEPPYYY','','/admin/abmelden','/kunden/dashboard','.gif,.jpg,.pdf,.jpeg,.png,.txt','.mp3,.m4a','tedji','',19,2098,0,'','','','',0,'',0,'','','','https://onlinetools.ups.com','gzamotors8','3Da8r8K3','A285F8','3D438DA31508F3ED',1,0,1,0,'1612896019',0,14,14,1,1,1,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',1,1,0,1,85,86,86,87,86,86,0,0,86,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','<script>\r\n$(document).ready(function(){\r\n	//autologout_interval = window.setInterval(function (){setAutologout();}, 1000);\r\n});\r\n\r\n$(\'.card-maximize\')\r\n	.css({\r\n		\'top\': 0, \r\n		\'left\': 0, \r\n		\'width\': \'100%\', \r\n		\'max-height\': \'100%\', \r\n		\'overflow-x\': \'auto\'\r\n	})\r\n	.find(\'.card-header\')\r\n	.addClass(\'pr-3\')\r\n	.find(\'h4\')\r\n	.append(\'<div class=\"float-right text-primary bg-white border border-primary rounded expand mr-0 text-center\" style=\"font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer\"><i class=\"fa fa-arrows-alt\" aria-hidden=\"true\"></i></div>\')\r\n	.on(\'click\', \'.expand\', function(){\r\n		if(this.parentElement.parentElement.parentElement.style.position==\'static\'||this.parentElement.parentElement.parentElement.style.position==\'\'){\r\n			$(this).parent().parent().parent().css({\'position\': \'fixed\', \'z-index\': \'999\'}).find(\'.card-body\').removeClass(\'pb-0\').addClass(\'pb-5\');\r\n		}else{\r\n			$(this).parent().parent().parent().css({\'position\': \'static\', \'z-index\': \'1\'}).find(\'.card-body\').removeClass(\'pb-5\').addClass(\'pb-0\');\r\n		}\r\n	});\r\n\r\n$(\'.expand\')\r\n	.hover(\r\n		function() {\r\n			$(this).removeClass(\'text-primary bg-white\').addClass(\'text-white bg-primary\');\r\n		}, function() {\r\n			$(this).removeClass(\'text-white bg-primary\').addClass(\'text-primary bg-white\');\r\n		}\r\n	);\r\n\r\n$(\'.card-minimize\')\r\n	.find(\'.card-header\')\r\n	.addClass(\'pr-3\')\r\n	.find(\'h4\')\r\n	.append(\'<div class=\"float-right text-primary bg-white border border-primary rounded card-collapse mr-0 text-center\" style=\"font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer\"><i class=\"fa fa-caret-square-o-down\" aria-hidden=\"true\"></i></div>\')\r\n	.on(\'click\', \'.card-collapse\', function(){\r\n		$(this).parent().parent().parent().find(\'.card-body\').slideToggle(\'slow\');\r\n	});\r\n\r\n$(\'.card-collapse\')\r\n	.hover(\r\n		function() {\r\n			$(this).removeClass(\'text-primary bg-white\').addClass(\'text-white bg-primary\');\r\n		}, function() {\r\n			$(this).removeClass(\'text-white bg-primary\').addClass(\'text-primary bg-white\');\r\n		}\r\n	);\r\n\r\n/* Set marquee to userinfo */\r\n$(\'#user_info\').html(\'<marquee behavior=\"alternate\">\' + $(\'#user_info\').html() + \'</marquee>\').addClass(\'w-75\');\r\n\r\n/* Scroll-Top-Button */\r\n$(document).ready(function(){\r\n	var back_to_top_button = [\'<a href=\"#top\" class=\"back-to-top btn btn-primary border border-white p-1\" style=\"position: fixed;bottom: 2px;left: 6px;border-radius: 50%;box-shadow: 0 0 4px rgba(0,0,0,.8);line-height: 6px;z-Index: 1001\"><i class=\"fa fa-arrow-up\" style=\"font-size: 10px\"> </i></a>\'].join(\"\");\r\n	$(\"body\").append(back_to_top_button);\r\n\r\n	$(\".back-to-top\").hide();\r\n\r\n	$(window).scroll(function () {\r\n		if ($(this).scrollTop() > 100) {\r\n			$(\'.back-to-top\').fadeIn();\r\n		} else {\r\n			$(\'.back-to-top\').fadeOut();\r\n		}\r\n	});\r\n\r\n	$(\'.back-to-top\').click(function () {\r\n		$(\'body,html\').animate({\r\n			scrollTop: 0\r\n		}, 800);\r\n		return false;\r\n	});\r\n\r\n});\r\n</script>\r\n<script>\r\nvar alert_date = \"03/28\";\r\nvar alert_text = \"Sie müssen unter \'Einstellungen/Grunddaten/Systemdaten/Temporäre Dateien\' die \'Temporäre Dateien\' entfernen!\";\r\nvar alert_d = new Date();\r\nvar alert_today = new Date();\r\nvar alert_dd = alert_today.getDate();\r\nvar alert_mm = alert_today.getMonth()+1; \r\nvar alert_yyyy = alert_today.getFullYear();\r\n\r\nif(alert_dd<10){\r\n	alert_dd = \'0\'+alert_dd;\r\n} \r\n\r\nif(alert_mm<10){\r\n	alert_mm = \'0\'+alert_mm;\r\n} \r\n\r\nalert_today = alert_mm + \'/\' + alert_dd;\r\nif(alert_today == alert_date){\r\n	location.href = \'/admin/grunddaten#v-pills-systemdata\';\r\n}\r\n</script>',0,NULL,NULL,NULL,'1234'),(3,3,'OrderGo - CRM',0,'Gazi','Ahmad','Strausberger Platz','13','10243','Berlin',1,'info@gzamotors.de','','','','','','#','/admin/abmelden','/kunden/dashboard','.png,.pdf','.mp3,.mp4','geheimercode8','',19,1,0,'w01a1094.kasserver.com','info@gzamotors.de','+-p12wurzelzumqZ','tls',587,'UTF-8',0,'','','','','','','','',1,0,1,0,'1627155646',22,22,22,1,1,1,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',1,1,0,1,1,1,1,1,1,1,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','',0,NULL,NULL,NULL,'1234');
/*!40000 ALTER TABLE `maindata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:24
