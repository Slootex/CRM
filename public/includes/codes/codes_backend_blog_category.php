<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "blog_category";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$blog_category_session = "blog_category_search";

if(isset($_POST["sorting_field"])){$_SESSION[$blog_category_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$blog_category_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$blog_category_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$blog_category_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$blog_category_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Slug", 
	"value" => "`blog_categories`.`slug`"
);
$sorting[] = array(
	"name" => "Title", 
	"value" => "`blog_categories`.`title`"
);
$sorting[] = array(
	"name" => "Text", 
	"value" => "`blog_categories`.`text`"
);

$sorting_field_name = isset($_SESSION[$blog_category_session]["sorting_field"]) ? $sorting[$_SESSION[$blog_category_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$blog_category_session]["sorting_field"]) ? $_SESSION[$blog_category_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$blog_category_session]["sorting_direction"]) ? $directions[$_SESSION[$blog_category_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$blog_category_session]["sorting_direction"]) ? $_SESSION[$blog_category_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$blog_category_session]["rows"]) && $_SESSION[$blog_category_session]["rows"] > 0 ? $_SESSION[$blog_category_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_slug = "";
$inp_title= "";
$inp_text = "";

$slug = "";
$title = "";
$text = "";

$time = time();

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['slug']) < 1 || strlen($_POST['slug']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_slug = " is-invalid";
	} else {
		$result = mysqli_query($conn, "SELECT * FROM `blog_categories` WHERE `blog_categories`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($_POST['slug'])) . "' AND `blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$slug = strip_tags($_POST['slug']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Slug eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_slug = " is-invalid";
		}
	}

	if(strlen($_POST['title']) < 1 || strlen($_POST['title']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Title eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = strip_tags($_POST['title']);
	}

	if(strlen($_POST['text']) < 1 || strlen($_POST['text']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Text eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_text = " is-invalid";
	} else {
		$text = strip_tags($_POST['text']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`blog_categories` 
								SET 	`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`blog_categories`.`slug`='" . mysqli_real_escape_string($conn, $slug) . "', 
										`blog_categories`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`blog_categories`.`text`='" . mysqli_real_escape_string($conn, $text) . "'");

		$_POST["id"] = $conn->insert_id;

		$emsg = "<p>Die neue Kategorie wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['slug']) < 1 || strlen($_POST['slug']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_slug = " is-invalid";
	} else {
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`blog_categories` 
										WHERE 	`blog_categories`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($_POST['slug'])) . "' 
										AND 	`blog_categories`.`id`!=" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 	`blog_categories`.`company_id`=" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$slug = strip_tags($_POST['slug']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Slug eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_slug = " is-invalid";
		}
	}

	if(strlen($_POST['title']) < 1 || strlen($_POST['title']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Title eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = strip_tags($_POST['title']);
	}

	if(strlen($_POST['text']) < 1 || strlen($_POST['text']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Text eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_text = " is-invalid";
	} else {
		$text = $_POST['text'];
	}

	if($emsg == ""){

		$category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_categories` WHERE `blog_categories`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

		if($category['slug'] != ""){
			mysqli_query($conn, "	UPDATE 	`blog_posts` 
									SET 	`blog_posts`.`category`=REPLACE(`blog_posts`.`category`, '" . mysqli_real_escape_string($conn, strip_tags($category['slug'])) . "', '" . mysqli_real_escape_string($conn, strip_tags($slug)) . "') 
									WHERE 	`blog_posts`.`category` LIKE '%" . mysqli_real_escape_string($conn, strip_tags($category['slug'])) . "%' 
									AND 	`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		}

		mysqli_query($conn, "	UPDATE 	`blog_categories` 
								SET 	`blog_categories`.`slug`='" . mysqli_real_escape_string($conn, $slug) . "', 
										`blog_categories`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`blog_categories`.`text`='" . mysqli_real_escape_string($conn, $text) . "' 
								WHERE 	`blog_categories`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Die Kategorie wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_categories` WHERE `blog_categories`.`id`='" . intval($_POST['id']) . "' AND `blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE 	`blog_posts` 
							SET 	`blog_posts`.`category`=REPLACE(REPLACE(`blog_posts`.`category`, '\r\n" . mysqli_real_escape_string($conn, strip_tags($category['slug'])) . "', ''), '" . mysqli_real_escape_string($conn, strip_tags($category['slug'])) . "', '') 
							WHERE 	`blog_posts`.`category` LIKE '%" . mysqli_real_escape_string($conn, strip_tags($category['slug'])) . "%' 
							AND 	`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`blog_categories` 
							WHERE 		`blog_categories`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$blog_categories_session]["keyword"]) && $_SESSION[$blog_categories_session]["keyword"] != "" ? 
			"WHERE 	(`blog_categories`.`slug` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_categories_session]["keyword"]) . "%'
			OR		`blog_categories`.`title` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_categories_session]["keyword"]) . "%'
			OR		`blog_categories`.`text` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$blog_categories_session]["keyword"]) . "%') " : 
			"WHERE 	`blog_categories`.`id`>0";

$query = "	SELECT 		* 
			FROM 		`blog_categories` 
			" . $where . " 
			AND 		`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row['slug'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row['title'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . intval($row['id']) . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

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
		"				<a href=\"/crm/blog-kommentar\" class=\"nav-link\">Kommentare</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-kategorie\" class=\"nav-link active\">Kategorien</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-tag\" class=\"nav-link\">Tag's</a>\n" . 
		"			</li>\n" . 
		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$blog_categories_session]['keyword']) && $_SESSION[$blog_categories_session]['keyword'] != "" ? $_SESSION[$blog_categories_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"row\">\n" . 
		"		<div class=\"col-lg-3 col-md-3 col-sm-3 col-xs-3\">\n" . 
		"			<h3>Blog - Kategorien</h3>\n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-6 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n" . 
		"<p>Hier können Sie die Blog Kategorien bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 

		$pageNumberlist->getInfo() . 

		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		"<div class=\"table-responsive\">\n" . 
		"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"			<th width=\"220\" scope=\"col\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Slug</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th align=\"center\" scope=\"col\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Title</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Aktion</strong>\n" . 
		"			</th>\n" . 
		"		</tr></thead>\n" . 

		$list . 

		"	</table>\n" . 
		"</div>\n" . 
		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");


if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

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
				"						<label for=\"slug\" class=\"col-sm-2 col-form-label\">Slug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Slug der Kategorie ein. Er darf nur aus folgenden Zeichen bestehen [a bis z, Unterstrich und Bindestrich] und muß einmalig sein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"slug\" name=\"slug\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $slug : "") . "\" class=\"form-control" . $inp_slug . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"title\" class=\"col-sm-2 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Title der Kategorie ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $title : "") . "\" class=\"form-control" . $inp_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-2 col-form-label\">Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Text-Inhalt der Kategorie ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-10\">\n" . 
				"							<textarea id=\"edit_content\" name=\"text\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_text . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $text : "") . "</textarea>\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog_categories` WHERE id='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND company_id='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

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
				"						<label for=\"slug\" class=\"col-sm-2 col-form-label\">Slug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Slug der Kategorie ändern. Er darf nur aus folgenden Zeichen bestehen [a bis z, Unterstrich und Bindestrich] und muß einmalig sein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"slug\" name=\"slug\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $slug : strip_tags($row["slug"])) . "\" class=\"form-control" . $inp_slug . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"title\" class=\"col-sm-2 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Title der Kategorie ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $title : strip_tags($row["title"])) . "\" class=\"form-control" . $inp_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-2 col-form-label\">Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Text-Inhalt der Kategorie ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-10\">\n" . 
				"							<textarea id=\"edit_content\" name=\"text\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_text . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $text : $row["text"]) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">neu speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>