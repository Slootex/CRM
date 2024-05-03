<?php 

require_once('includes/class_dbbmailer.php');

include('includes/class_page_number.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 3;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$amount_rows = 10;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$html = "";

$emsg = "";

if(isset($_POST['absenden'])){ // Beitrag kommentieren

	$json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LclQV4bAAAAAGJifjwm2iYQouWWEgG6EOUtQgCm&response=' . strip_tags($_POST['g-recaptcha-response']));
	$data = json_decode($json);

	if($data->success == true){

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_blog = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($param["blog"])) . "'"), MYSQLI_ASSOC);

		$row_post = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_posts` WHERE `blog_post`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_post`.`post`='" . mysqli_real_escape_string($conn, strip_tags($param["post"])) . "'"), MYSQLI_ASSOC);

		$name = (!empty($_POST["name"])) ? strip_tags($_POST["name"]) : "Info";
		$email = (!empty($_POST["email"])) ? strip_tags($_POST["email"]) : "";
		$nachricht = (!empty($_POST["nachricht"])) ? strip_tags($_POST["nachricht"]) : "";

		$subject = "GZA MOTORS Webseite: Blog / Beitrag / Kommentar";
		$to = "info@gzamotors.de";
		$from = !empty($email) ? $email : $to;

		$body = "<strong>Kundendaten:</strong><br><br>";
		$body .= "Name: " . $name . "<br>";
		$body .= "E-Mail: " . $email . "<br>";
		$body .= "URL: <a href=\"" . $domain . $page['url'] . "/" . $row_blog['slug'] . "/mehr/" . $row_post['post'] . "\">Blog / " . strip_tags($row_blog['title']) . " / " . strip_tags($row_post['title']) . "</a><br>";
		$body .= "<strong>Folgende Nachricht schrieb der Kunde:</strong><br>" . $nachricht . "<br>";

		$row_admin = array();

		$row_admin['email'] = $from;

		$row_template = array();

		$row_template['subject'] = $subject;

		$row_template['body'] = $body;

		$mail = new dbbMailer();

		$mail->host = $maindata['smtp_host'];
		$mail->username = $maindata['smtp_username'];
		$mail->password = $maindata['smtp_password'];
		$mail->secure = $maindata['smtp_secure'];
		$mail->port = intval($maindata['smtp_port']);
		$mail->charset = $maindata['smtp_charset'];

		$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
		$mail->addAddress($email, $firstname . " " . $lastname);

		//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

		$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

		$mail->subject = strip_tags($row_template['subject']);

		$mail->body = str_replace("[track]", "", $row_template['body']);

		if(!$mail->send()){

		}

		mysqli_query($conn, "INSERT INTO `blog_comments` SET `blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', `blog_comments`.`post`='" . mysqli_real_escape_string($conn, $row_post['post']) . "', `blog_comments`.`name`='" . mysqli_real_escape_string($conn, $name) . "', `blog_comments`.`email`='" . mysqli_real_escape_string($conn, $email) . "', `blog_comments`.`comment`='" . mysqli_real_escape_string($conn, $nachricht) . "', `blog_comments`.`time`='" . time() . "'");

		$emsg = "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">\n" . 
				"	<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">\n" . 
				"		<div class=\"modal-content\">\n" . 
				"			<div class=\"modal-header\">\n" . 
				"				<h5 class=\"modal-title\" id=\"exampleModalLabel\">Kommentieren</h5>\n" . 
				"					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" . 
				"						<span aria-hidden=\"true\">&times;</span>\n" . 
				"					</button>\n" . 
				"				</div>\n" . 
				"				<div class=\"modal-body\">\n" . 
				"					Vielen Dank Ihr Kommentar wurde aufgenommen.\n" . 
				"				</div>\n" . 
				"				<div class=\"modal-footer\">\n" . 
				"					<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"</div>\n" . 
				"<script>\$(document).ready(function() {\$('#exampleModal').modal('show');});</script>\n";
		
	}else{

		$emsg = "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">\n" . 
				"	<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">\n" . 
				"		<div class=\"modal-content\">\n" . 
				"			<div class=\"modal-header\">\n" . 
				"				<h5 class=\"modal-title\" id=\"exampleModalLabel\">Kommentieren</h5>\n" . 
				"					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" . 
				"						<span aria-hidden=\"true\">&times;</span>\n" . 
				"					</button>\n" . 
				"				</div>\n" . 
				"				<div class=\"modal-body\">\n" . 
				"					Es ist ein Fehler aufgetreten. Bitte akzeptieren Sie Cookies!\n" . 
				"				</div>\n" . 
				"				<div class=\"modal-footer\">\n" . 
				"					<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"</div>\n" . 
				"<script>\$(document).ready(function() {\$('#exampleModal').modal('show');});</script>\n";

	}

}

if(isset($param['category']) && $param['category'] == ""){ // Kategorie

	$q = "SELECT * FROM `blog_categories` WHERE `blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' ORDER BY `blog_categories`.`title`";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/kategorie", 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>Kategorien</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>Unsere Kategorien, Unsere Kategorien, Unsere Kategorien, Unsere Kategorien, Unsere Kategorien, Unsere Kategorien, </p>\n" . 
			"<strong>Kategorien:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		Kategorie\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['title']) . "</h5>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['text']), 0, 30) . "</p>\n" . 
					"		<p class=\"text-right\"><a href=\"" . $page['url'] . "/kategorie/" . $row['slug'] . "\" class=\"btn btn-primary\">weiter</a></p>\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($param['category']) && $param['category'] != ""){ // Kategorie & Slug

	$row_category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_categories` WHERE `blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_categories`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($param["category"])) . "'"), MYSQLI_ASSOC);

	$q = "SELECT * FROM `blog_posts` WHERE `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_posts`.`category` LIKE '%" . mysqli_real_escape_string($conn, strip_tags($row_category["slug"])) . "%' ORDER BY CAST(`blog_posts`.`time` AS UNSIGNED) ASC";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/kategorie/" . $row_category['slug'], 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>" . $row_category['title'] . "</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>" . $row_category['text'] . "</p>\n" . 
			"<strong>Beiträge:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		// Kategorien
		$values = explode("\r\n", $row['category']);

		$where_categories = "";

		for($i = 0;$i < count($values);$i++){
			$where_categories .= $i == 0 ? "`blog_categories`.`slug`='" . $values[$i] . "' " : "OR `blog_categories`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_categories` WHERE " . $where_categories . " ORDER BY `blog_categories`.`title`";

		$result_categories = mysqli_query($conn, $q);

		$html_categories = "<i class=\"fa fa-folder-open fa-fw\"></i> ";

		$i = 0;
		while($row_categories = mysqli_fetch_array($result_categories, MYSQLI_ASSOC)){
			$html_categories .= $i == 0 ? "<a href=\"" . $page['url'] . "/kategorie/" . $row_categories['slug'] . "\">" . strip_tags($row_categories['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/kategorie/" . $row_categories['slug'] . "\">" . strip_tags($row_categories['title']) . "</a>";
			$i++;
		}

		// Tags
		$values = explode("\r\n", $row['tag']);

		$where_tags = "";

		for($i = 0;$i < count($values);$i++){
			$where_tags .= $i == 0 ? "`blog_tags`.`slug`='" . $values[$i] . "' " : "OR `blog_tags`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_tags` WHERE " . $where_tags . " ORDER BY `blog_tags`.`title`";
		$result_tags = mysqli_query($conn, $q);

		$html_tags = "<i class=\"fa fa-tags fa-fw\"></i> ";

		$i = 0;
		while($row_tags = mysqli_fetch_array($result_tags, MYSQLI_ASSOC)){
			$html_tags .= $i == 0 ? "<a href=\"" . $page['url'] . "/tag/" . $row_tags['slug'] . "\">" . strip_tags($row_tags['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/tag/" . $row_tags['slug'] . "\">" . strip_tags($row_tags['title']) . "</a>";
			$i++;
		}

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		" . $row['title'] . "\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['content_title']) . "</h5>\n" . 
					"		<p class=\"card-text\"><small>" . $html_categories . "</small></p>\n" . 
					"		<p class=\"card-text\"><small>" . $html_tags . "</small></p>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['content_text']), 0, 30) . "</p>\n" . 
					"		<p class=\"text-right\"><a href=\"" . $page['url'] . "/" . $row['blog'] . "/mehr/" . $row['post'] . "\" class=\"btn btn-primary\">weiter</a></p>\n" . 
					"	</div>\n" . 
					"	<div class=\"card-footer text-muted\">\n" . 
					"		" . strip_tags($row['footer']) . "\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($param['tag']) && $param['tag'] == ""){ // Tag

	$q = "SELECT * FROM `blog_tags` WHERE `blog_tags`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' ORDER BY `blog_tags`.`title`";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/kategorie", 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>Tag's</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>Unsere Tag's, Unsere Tag's, Unsere Tag's, Unsere Tag's, Unsere Tag's, Unsere Tag's, Unsere Tag's, Unsere Tag's, </p>\n" . 
			"<strong>Tag's:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		Tag\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['title']) . "</h5>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['text']), 0, 30) . "</p>\n" . 
					"		<p class=\"text-right\"><a href=\"" . $page['url'] . "/tag/" . $row['slug'] . "\" class=\"btn btn-primary\">weiter</a></p>\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($param['tag']) && $param['tag'] != ""){ // Tag & Slug

	$row_tag = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_tags` WHERE `blog_tags`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_tags`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($param["tag"])) . "'"), MYSQLI_ASSOC);

	$q = "SELECT * FROM `blog_posts` WHERE `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_posts`.`tag` LIKE '%" . mysqli_real_escape_string($conn, strip_tags($row_tag["slug"])) . "%' ORDER BY CAST(`blog_posts`.`time` AS UNSIGNED) ASC";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/tag/" . $row_tag['slug'], 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>" . $row_tag['title'] . "</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>" . $row_tag['text'] . "</p>\n" . 
			"<strong>Beiträge:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		// Kategorien
		$values = explode("\r\n", $row['category']);

		$where_categories = "";

		for($i = 0;$i < count($values);$i++){
			$where_categories .= $i == 0 ? "`blog_categories`.`slug`='" . $values[$i] . "' " : "OR `blog_categories`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_categories` WHERE " . $where_categories . " ORDER BY `blog_categories`.`title`";

		$result_categories = mysqli_query($conn, $q);

		$html_categories = "<i class=\"fa fa-folder-open fa-fw\"></i> ";

		$i = 0;

		while($row_categories = mysqli_fetch_array($result_categories, MYSQLI_ASSOC)){
			$html_categories .= $i == 0 ? "<a href=\"" . $page['url'] . "/kategorie/" . $row_categories['slug'] . "\">" . strip_tags($row_categories['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/kategorie/" . $row_categories['slug'] . "\">" . strip_tags($row_categories['title']) . "</a>";
			$i++;
		}

		// Tags
		$values = explode("\r\n", $row['tag']);

		$where_tags = "";

		for($i = 0;$i < count($values);$i++){
			$where_tags .= $i == 0 ? "`blog_tags`.`slug`='" . $values[$i] . "' " : "OR `blog_tags`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_tags` WHERE " . $where_tags . " ORDER BY `blog_tags`.`title`";
		$result_tags = mysqli_query($conn, $q);

		$html_tags = "<i class=\"fa fa-tags fa-fw\"></i> ";

		$i = 0;
		while($row_tags = mysqli_fetch_array($result_tags, MYSQLI_ASSOC)){
			$html_tags .= $i == 0 ? "<a href=\"" . $page['url'] . "/tag/" . $row_tags['slug'] . "\">" . strip_tags($row_tags['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/tag/" . $row_tags['slug'] . "\">" . strip_tags($row_tags['title']) . "</a>";
			$i++;
		}

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		" . $row['title'] . "\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['content_title']) . "</h5>\n" . 
					"		<p class=\"card-text\"><small>" . $html_categories . "</small></p>\n" . 
					"		<p class=\"card-text\"><small>" . $html_tags . "</small></p>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['content_text']), 0, 30) . "</p>\n" . 
					"		<p class=\"text-right\"><a href=\"" . $page['url'] . "/" . $row['blog'] . "/mehr/" . $row['post'] . "\" class=\"btn btn-primary\">weiter</a></p>\n" . 
					"	</div>\n" . 
					"	<div class=\"card-footer text-muted\">\n" . 
					"		" . strip_tags($row['footer']) . "\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($param['blog']) && !isset($param['post']) && !isset($param['comment'])){ // Beiträge

	$row_blog = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($param["blog"])) . "'"), MYSQLI_ASSOC);

	$q = "SELECT * FROM `blog_posts` WHERE `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_posts`.`blog`='" . mysqli_real_escape_string($conn, $row_blog["slug"]) . "' ORDER BY CAST(`blog_posts`.`time` AS UNSIGNED) ASC";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/" . $row_blog['slug'], 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>" . $row_blog['title'] . "</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>" . $row_blog['text'] . "</p>\n" . 
			"<strong>Beiträge:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		// Kategorien
		$values = explode("\r\n", $row['category']);

		$where_categories = "";

		for($i = 0;$i < count($values);$i++){
			$where_categories .= $i == 0 ? "`blog_categories`.`slug`='" . $values[$i] . "' " : "OR `blog_categories`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_categories` WHERE " . $where_categories . " ORDER BY `blog_categories`.`title`";

		$result_categories = mysqli_query($conn, $q);

		$html_categories = "<i class=\"fa fa-folder-open fa-fw\"></i> ";

		$i = 0;

		while($row_category = mysqli_fetch_array($result_categories, MYSQLI_ASSOC)){
			$html_categories .= $i == 0 ? "<a href=\"" . $page['url'] . "/kategorie/" . $row_category['slug'] . "\">" . strip_tags($row_category['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/kategorie/" . $row_category['slug'] . "\">" . strip_tags($row_category['title']) . "</a>";
			$i++;
		}

		// Tags
		$values = explode("\r\n", $row['tag']);

		$where_tags = "";

		for($i = 0;$i < count($values);$i++){
			$where_tags .= $i == 0 ? "`blog_tags`.`slug`='" . $values[$i] . "' " : "OR `blog_tags`.`slug`='" . $values[$i] . "' ";
		}

		$q = "SELECT * FROM `blog_tags` WHERE " . $where_tags . " ORDER BY `blog_tags`.`title`";
		$result_tags = mysqli_query($conn, $q);

		$html_tags = "<i class=\"fa fa-tags fa-fw\"></i> ";

		$i = 0;

		while($row_tag = mysqli_fetch_array($result_tags, MYSQLI_ASSOC)){
			$html_tags .= $i == 0 ? "<a href=\"" . $page['url'] . "/tag/" . $row_tag['slug'] . "\">" . strip_tags($row_tag['title']) . "</a>" : ", <a href=\"" . $page['url'] . "/tag/" . $row_tag['slug'] . "\">" . strip_tags($row_tag['title']) . "</a>";
			$i++;
		}

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		" . $row['title'] . "\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['content_title']) . "</h5>\n" . 
					"		<p class=\"card-text\"><small>" . $html_categories . "</small></p>\n" . 
					"		<p class=\"card-text\"><small>" . $html_tags . "</small></p>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['content_text']), 0, 30) . "</p>\n" . 
					"		<p class=\"text-right\"><a href=\"" . $page['url'] . "/" . strip_tags($param['blog']) . "/mehr/" . $row['post'] . "\" class=\"btn btn-primary\">weiter</a></p>\n" . 
					"	</div>\n" . 
					"	<div class=\"card-footer text-muted\">\n" . 
					"		" . strip_tags($row['footer']) . "\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($param['blog']) && isset($param['post']) && !isset($param['comment'])){ // Beitrag / Komentare

	$row_blog = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($param["blog"])) . "'"), MYSQLI_ASSOC);

	$row_post = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_posts` WHERE `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_posts`.`post`='" . mysqli_real_escape_string($conn, strip_tags($param["post"])) . "'"), MYSQLI_ASSOC);

	$q = "SELECT * FROM `blog_comments` WHERE `blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `blog_comments`.`post`='" . mysqli_real_escape_string($conn, $row_post["post"]) . "' ORDER BY CAST(`blog_comments`.`time` AS UNSIGNED) ASC";

	$result = mysqli_query($conn, $q);

	$rows = mysqli_num_rows($result);

	$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$pos, 
										$amount_rows, 
										"/pos", 
										$page['url'] . "/" . $row_blog['slug'] . "/mehr/" . $row_post['post'], 
										$getParam = "", 
										10, 
										1);

	$q .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $q);

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>" . $row_post['title'] . "</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p><small>" . $row_post['content_title'] . "</small></p>\n" . 
			"<p>" . $row_post['content_text'] . "</p>\n" . 
			"<strong>Komentare:</strong><br />\n" . 

			$pageNumberlist->getInfo() . 

			"<br />\n" . 

			$pageNumberlist->getNavi();

	$i = 0;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		$html .= 	"<div class=\"card" . ($i > 0 ? " mt-5" : "") . "\">\n" . 
					"	<div class=\"card-header\">\n" . 
					"		Datum: " . date("d.m.Y", $row['time']) . "\n" . 
					"	</div>\n" . 
					"	<div class=\"card-body\">\n" . 
					"		<h5 class=\"card-title\">" . strip_tags($row['name']) . "</h5>\n" . 
					"		<p class=\"card-text\">" . substr(strip_tags($row['comment']), 0, 30) . "</p>\n" . 
					"	</div>\n" . 
					"</div>\n";

		$i++;

	}

	$html .= 	"<br />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"contact_form_area\">\n" . 
				"	<h2>Kommentieren</h2>\n" . 
				"	<div class=\"contact_form_\">\n" . 
				"		<form action=\"" . $page['url'] . "/" . strip_tags($param['blog']) . "/mehr/" . $row_post['post'] . "\" method=\"POST\">\n" . 
				"			<div class=\"name_ clearfix\">\n" . 
				"				<p>Name: <span>*</span></p>\n" . 
				"				<input type=\"text\" name=\"name\" id=\"name\" required />\n" . 	
				"			</div>\n" . 
				"			<div class=\"email_ clearfix\">\n" . 
				"				<p>E-Mail-Adresse: <span>*</span></p>\n" . 
				"				<input type=\"mail\" name=\"email\" id=\"email\" required />\n" . 	
				"			</div>\n" . 
				"			<div class=\"mach clearfix\">\n" . 
				"				<p>Nachricht: <span>*</span></p>\n" . 
				"				<textarea name=\"nachricht\" id=\"nachricht\" cols=\"30\" rows=\"4\" required></textarea>\n" . 
				"			</div>\n" . 
				"			<div class=\"Antwort clearfix\">\n" . 
				"				<p>Captcha: <span>*</span><br /></p>\n" . 
				"				<div class=\"g-recaptcha\" data-sitekey=\"6LclQV4bAAAAAFBfEwfk9mGjfwbXRaeBF7EaThnl\" style=\"float: left;margin-bottom: 12px\"></div>\n" . 
				"			</div>\n" . 
				"			<div class=\"Antwort clearfix\">\n" . 
				"				<p>&nbsp;<br /></p>\n" . 
				"				<input type=\"submit\" name=\"absenden\" style=\"background:#3F99D5 none repeat scroll 0 0;border-radius: 0px;color: #ffffff;display: block;font-size: 20px;margin-left:185px;padding: 10px 15px;text-align: center;width: 137px;text-transform: uppercase;\" value=\"Absenden\" />\n" . 
				"			</div>\n" . 
				"		</form>\n" . 
				"	</div>\n" . 
				"</div>\n";

}

if(!isset($param['blog']) && !isset($param['post']) && !isset($param['comment']) && !isset($param['category']) && !isset($param['tag'])){ // Index

	$html = "<br />\n" . 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
			"		<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 bg-primary text-white\">\n" . 
			"			<h1>Willkommen zu Unserem Blog</h1>\n" . 
			"		</div>\n" . 
			"	</div>\n" . 
			"</div>\n" . 
			"<br />\n" . 
			"<p>Wählen Sie links ein Thema aus.</p>\n";

}

$title = "";

$description = "";

if(!isset($param['category']) && !isset($param['tag'])){

	$title .= "Blog";

	$description .= "Blog";

	if(isset($row_blog)){
		$title .= " / " . $row_blog['title'];
		$description .= " / " . $row_blog['title'];
	}

	if(isset($row_post)){
		$title .= " / " . $row_post['title'];
		$description .= " / " . strip_tags($row_post['content_text']);
	}

}

if(isset($param['category'])){

	if($param['category'] == ""){

		$title .= "Blog";
		$title .= " / Kategorie";
		$description .= "Blog";
		$description .= " / Kategorie";

	}else{

		$title .= "Blog";
		$title .= " / Kategorie";
		$title .= "	/ " . $row_category['title'];
		$description .= "Blog";
		$description .= " / Kategorie";
		$description .= " / " . strip_tags($row_category['text']);

	}

}

if(isset($param['tag'])){

	if($param['tag'] == ""){

		$title .= "Blog";
		$title .= " / Tag";
		$description .= "Blog";
		$description .= " / Tag";

	}else{

		$title .= "Blog";
		$title .= " / Tag";
		$title .= " / " . $row_tag['title'];
		$description .= "Blog";
		$description .= " / Tag";
		$description .= " / " . strip_tags($row_tag['text']);

	}

}

?>