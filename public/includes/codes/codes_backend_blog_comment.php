<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "blog_comment";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$blog_comment_session = "blog_comment_search";

if(isset($_POST["blog_slug"])){$_SESSION[$blog_comment_session]["blog"] = strip_tags($_POST["blog_slug"]);}
if(isset($_POST["post_slug"])){$_SESSION[$blog_comment_session]["post"] = strip_tags($_POST["post_slug"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$blog_comment_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$blog_comment_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$blog_comment_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$blog_comment_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$blog_comment_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`blog_comments`.`id` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Title", 
	"value" => "`blog_comments`.`name`"
);
$sorting[] = array(
	"name" => "Email", 
	"value" => "`blog_comments`.`email`"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`blog_comments`.`time` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$blog_comment_session]["sorting_field"]) ? $sorting[$_SESSION[$blog_comment_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$blog_comment_session]["sorting_field"]) ? $_SESSION[$blog_comment_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$blog_comment_session]["sorting_direction"]) ? $directions[$_SESSION[$blog_comment_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$blog_comment_session]["sorting_direction"]) ? $_SESSION[$blog_comment_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$blog_comment_session]["rows"]) && $_SESSION[$blog_comment_session]["rows"] > 0 ? $_SESSION[$blog_comment_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_post = "";
$inp_name = "";
$inp_email = "";
$inp_comment = "";

$post = "";
$name = "";
$email = "";
$comment = "";

$time = time();

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['post']) < 1 || strlen($_POST['post']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Post-Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_post = " is-invalid";
	} else {
		$post = strip_tags($_POST['post']);
	}

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = $_POST['email'];
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihre E-Mail-Adresse eingeben.</span><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['comment']) < 1 || strlen($_POST['comment']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Kommentar eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_comment = " is-invalid";
	} else {
		$comment = strip_tags($_POST['comment']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`blog_comments` 
								SET 	`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`blog_comments`.`post`='" . mysqli_real_escape_string($conn, $post) . "', 
										`blog_comments`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`blog_comments`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`blog_comments`.`comment`='" . mysqli_real_escape_string($conn, $comment) . "', 
										`blog_comments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		$_POST["edit"] = "bearbeiten";

		$emsg = "<p>Der neue Kommentar wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = $_POST['email'];
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihre E-Mail-Adresse eingeben.</span><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['comment']) < 1 || strlen($_POST['comment']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Kommentar eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_comment = " is-invalid";
	} else {
		$comment = strip_tags($_POST['comment']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`blog_comments` 
								SET 	`blog_comments`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`blog_comments`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`blog_comments`.`comment`='" . mysqli_real_escape_string($conn, $comment) . "', 
										`blog_comments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`blog_comments`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Der Kommentar wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`blog_comments` 
							WHERE 		`blog_comments`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

if(isset($_SESSION[$blog_comment_session]["blog"])){

	$result_pages = mysqli_query($conn, "SELECT * FROM `blog_posts` WHERE `blog_posts`.`blog`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION[$blog_comment_session]["blog"])) . "' AND `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY `blog_posts`.`title` ASC");

	$post_options = "";

	while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

		$post_options .= "				<option value=\"" . $p["post"] . "\"" . (isset($_SESSION[$blog_comment_session]["post"]) && $p["post"] == $_SESSION[$blog_comment_session]["post"] ? " selected=\"selected\"" : "") . ">" . substr($p['title'], 0, 80) . "</option>\n";

	}

}

if(isset($_SESSION[$blog_comment_session]["post"])){

	$blog = $_SESSION[$blog_comment_session]["post"] == "alle" ? "`blog_comments`.`id`>'0'" : "`blog_comments`.`post`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION[$blog_comment_session]["post"])) . "'";

	$where = 	isset($_SESSION[$blog_comment_session]["keyword"]) && $_SESSION[$blog_comment_session]["keyword"] != "" ? 
				"AND (`blog_comments`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_comment_session]["keyword"]) . "%' 
				OR		`blog_comments`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_comment_session]["keyword"]) . "%' 
				OR		`blog_comments`.`comment` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_comment_session]["keyword"]) . "%') " : 
				"AND	`blog_comments`.`id`>'0'";

	$query = 	"	SELECT 		* 
					FROM 		`blog_comments` 
					WHERE 		" . $blog . $where . " 
					AND 		`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	" . $sorting_field_name . " " . $sorting_direction_name;

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

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
										$page['url'], 
										$getParam = "", 
										10, 
										1);

	$query .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row_item['id'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row_item['name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row_item['email'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}

$result_pages = mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY `blog`.`title` ASC");

$blog_options = "";

while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$blog_options .= "				<option value=\"" . $p["slug"] . "\"" . (isset($_SESSION[$blog_comment_session]["blog"]) && $p["slug"] == $_SESSION[$blog_comment_session]["blog"] ? " selected=\"selected\"" : "") . ">" . substr($p['title'], 0, 80) . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-thema\" class=\"nav-link\">Themen</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-beitrag\" class=\"nav-link\">Beiträge</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-kommentar\" class=\"nav-link active\">Kommentare</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-kategorie\" class=\"nav-link\">Kategorien</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-tag\" class=\"nav-link\">Tag's</a>\n" . 
		"			</li>\n" . 
		"		</ul>\n" . 
		"	</div>\n" . 
		(isset($_SESSION[$blog_comment_session]["blog"]) ? 
			"	<div class=\"col-sm-5 text-right\">\n" . 
			"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
			"			<div class=\"btn-group btn-group-lg\">\n" . 
			"				<select id=\"post_slug\" name=\"post_slug\" class=\"custom-select custom-select-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\">\n" . 
			"					<option value=\"alle\">Alle Beiträge</option>\n" . 

			$post_options . 

			"				</select>\n" . 
			"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$blog_comment_session]['keyword']) && $_SESSION[$blog_comment_session]['keyword'] != "" ? $_SESSION[$blog_comment_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: 0\" />\n" . 
			"				<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-success\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
			"				<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
			"				<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
			"			</div>\n" . 
			"			<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 50px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
			"				<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
			"				<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
			"					<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
			"					<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
			"					<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
			"					<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
			"					<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
			"					<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
			"					<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
			"					<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
			"					<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
			"					<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
			"				</select>\n" . 
			"				<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
			"				<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

			$sorting_field_options . 

			"				</select>\n" . 
			"				<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
			"				<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
			"					<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
			"					<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
			"				</select>\n" . 
			"			</div>\n" . 
			"		</form>\n" . 
			"	</div>\n"
		: 
			""
		) . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Blog - Komentare</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Blog Themen Beiträge Komentare bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"blog_slug\" class=\"col-sm-2 col-form-label\">Thema <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ein Thema aus in dessen Beitrag ein Kommentare angelegt, bearbeitet oder entfernt werden sollen.\">?</span></label>\n" . 
		"		<div class=\"col-sm-3 text-left\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<select id=\"blog_slug\" name=\"blog_slug\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"width: 200px;border-radius: .25rem 0 0 .25rem\">\n" . 

		$blog_options . 

		"				</select>\n" . 
		"				<button type=\"submit\" name=\"open\" value=\"öffnen\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(isset($_SESSION[$blog_comment_session]["blog"])){

	$html .= 	"<hr />\n" . 
				"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<label for=\"post_slug\" class=\"col-sm-2 col-form-label\">Neuer Kommentar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ein neuen Kommentar hinzufügen. Wählen Sie ein Beitrag aus und klicken dann auf <u>hinzufügen</u>.\">?</span></label>\n" . 
				"		<div class=\"col-sm-3 text-left\">\n" . 
				"			<div class=\"btn-group\">\n" . 
				"				<select id=\"post_slug\" name=\"post_slug\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"width: 200px;border-radius: .25rem 0 0 .25rem\">\n" . 

				$post_options . 

				"				</select>\n" . 
				"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</form>\n";

}

if(isset($_SESSION[$blog_comment_session]["post"]) && !isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"70\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"220\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Title</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Email</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"	<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"		<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"			<tr class=\"text-primary\">\n" . 
				"				<td width=\"350\">\n" . 
				"					<label for=\"order_sel_all_bottom\" class=\"mt-1\">(" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"				</td>\n" . 
				"				<td>\n" . 
				"					&nbsp;\n" . 
				"				</td>\n" . 
				"			</tr>\n" . 
				"		</table>\n" . 
				"	</form>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$result_pages = mysqli_query($conn, "SELECT * FROM `blog_posts` WHERE `blog_posts`.`blog`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION[$blog_comment_session]["blog"])) . "' AND `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY `blog_posts`.`title` ASC");

	$post_options = "";

	while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

		$post_options .= "				<option value=\"" . $p["post"] . "\"" . (isset($_SESSION[$blog_comment_session]["post"]) && $p["post"] == (isset($_POST['save']) && $_POST['save'] == "speichern" ? $post : $_SESSION[$blog_comment_session]["post"]) ? " selected=\"selected\"" : "") . ">" . substr($p['title'], 0, 80) . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"post\" class=\"col-sm-2 col-form-label\">Beitrag <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie unter welchem Beitrag der Kommentar dargestellt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"post\" name=\"post\" class=\"custom-select\">\n" . 

				$post_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-2 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email\" class=\"col-sm-2 col-form-label\">Email <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Email des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $email : "") . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"comment\" class=\"col-sm-2 col-form-label\">Kommentar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Kommentar des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-10\">\n" . 
				"							<textarea id=\"comment\" name=\"comment\" class=\"form-control" . $inp_comment . "\" style=\"width: 100%;height: 300px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $comment : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_comments` WHERE id='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND company_id='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-2 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : $row_item["name"]) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email\" class=\"col-sm-2 col-form-label\">Email <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Email des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : strip_tags($row_item["email"])) . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"comment\" class=\"col-sm-2 col-form-label\">Kommentar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Kommentar des Kommentarauthors ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-10\">\n" . 
				"							<textarea id=\"comment\" name=\"comment\" class=\"form-control" . $inp_comment . "\" style=\"width: 100%;height: 300px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $comment : $row_item["comment"]) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

?>