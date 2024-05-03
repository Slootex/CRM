<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "blog";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_slug = "";
$inp_title = "";
$inp_text = "";
$inp_pos = "";

$slug = "";
$title = "";
$text = "";
$pos = 0;

if(isset($_POST["id"])){$_SESSION["blog"]["id"] = intval($_POST["id"]);}

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['slug']) < 1 || strlen($_POST['slug']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Slug eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_slug = " is-invalid";
	} else {
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`blog` 
										WHERE 	`blog`.`slug`='" . mysqli_real_escape_string($conn, strip_tags($_POST['slug'])) . "' 
										AND 	`blog`.`id`!='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 	`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$slug = strip_tags($_POST['slug']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Slug eingeben. (max. 256 Zeichen)</span><br />\n";
			$inp_slug = " is-invalid";
		}
	}

	if(strlen($_POST['title']) < 1 || strlen($_POST['title']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Title eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = strip_tags($_POST['title']);
	}

	if(strlen($_POST['text']) < 1 || strlen($_POST['text']) > 65536){
		$emsg .= "<span class=\"error\">Bitte den Text-Inhalt eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_text = " is-invalid";
	} else {
		$text = $_POST['text'];
	}

	if(strlen($_POST['pos']) < 1 || strlen($_POST['pos']) > 1000){
		$emsg .= "<span class=\"error\">Bitte die Postion nach der sortiert wird eingeben. (max. 1000)</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if($emsg == ""){

		$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["blog"]["id"])) . "' AND `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE 	`blog` 
								SET 	`blog`.`slug`='" . mysqli_real_escape_string($conn, $slug) . "', 
										`blog`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`blog`.`text`='" . mysqli_real_escape_string($conn, $text) . "', 
										`blog`.`pos`='" . mysqli_real_escape_string($conn, intval($_POST['pos'])) . "' 
								WHERE 	`blog`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["blog"]["id"])) . "' 
								AND 	`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		if($row['slug'] != ""){
			mysqli_query($conn, "	UPDATE 	`blog_posts` 
									SET 	`blog_posts`.`blog`='" . mysqli_real_escape_string($conn, $slug) . "' 
									WHERE 	`blog_posts`.`blog`='" . mysqli_real_escape_string($conn, strip_tags($row['slug'])) . "' 
									AND 	`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		}

		$emsg = "<p>Das Thema wurden erfolgreich geändert!</p>\n";

	}

}

if(isset($_POST['page_select']) && $_POST['page_select'] == "entfernen"){

	$blog = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["blog"]["id"])) . "' AND `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$result_posts = mysqli_query($conn, "SELECT * FROM `blog_posts` WHERE `blog_posts`.`blog`='" . mysqli_real_escape_string($conn, strip_tags($blog['slug'])) . "' AND `blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$posts = array();

	while($post = $result_posts->fetch_array(MYSQLI_ASSOC)){
		$posts[] = $post['id'];
		mysqli_query($conn, "	DELETE FROM `blog_comments` 
								WHERE 		`blog_comments`.`post`='" . mysqli_real_escape_string($conn, strip_tags($post['post'])) . "' 
								AND 		`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	}

	for($i = 0;$i < count($posts);$i++){
		mysqli_query($conn, "	DELETE FROM `blog_posts` 
								WHERE 		`blog_posts`.`id`='" . mysqli_real_escape_string($conn, intval($posts[$i])) . "' 
								AND 		`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	}

	mysqli_query($conn, "	DELETE FROM `blog` 
							WHERE 		`blog`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["blog"]["id"])) . "' 
							AND 		`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['new_name'] = "";

}

if(isset($_POST['page_select']) && $_POST['page_select'] == "anlegen"){

	mysqli_query($conn, "	INSERT 	`blog` 
							SET 	`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`blog`.`title`='" . mysqli_real_escape_string($conn, strip_tags($_POST['new_name'])) . "'");
	
	$_SESSION["blog"]["id"] = $conn->insert_id;

	$_POST['new_name'] = "";

	$emsg = "<p>Das Blog-Thema wurden erfolgreich angelegt!</p>\n";

}

if((isset($_POST['page_select']) && $_POST['page_select'] == "öffnen") || (isset($_POST['save']) && $_POST['save'] == "speichern") || (isset($_POST['page_select']) && $_POST['page_select'] == "anlegen")){

	$row_page = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["blog"]["id"])) . "' AND `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$result_pages = mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY `blog`.`title` ASC");

$pages_options = "";

while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$pages_options .= "				<option value=\"" . $p["id"] . "\"" . (isset($_SESSION["blog"]["id"]) && $p["id"] == $_SESSION["blog"]["id"] ? " selected=\"selected\"" : "") . ">" . substr($p['title'], 0, 80) . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-thema\" class=\"nav-link active\">Themen</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-beitrag\" class=\"nav-link\">Beiträge</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-kommentar\" class=\"nav-link\">Kommentare</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-kategorie\" class=\"nav-link\">Kategorien</a>\n" . 
		"			</li>\n" . 
		"			<li class=\"nav-item\">\n" . 
		"				<a href=\"/crm/blog-tag\" class=\"nav-link\">Tag's</a>\n" . 
		"			</li>\n" . 
		"		</ul>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Blog - Themen</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Blog Themen bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"id\" class=\"col-sm-2 col-form-label\">Themen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ein Thema öffnen oder entfernen. Wählen Sie das Thema aus und klicken dann auf <u>öffnen</u> oder <u>entfernen</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-3\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<select id=\"id\" name=\"id\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"width: 200px;border-radius: .25rem 0 0 .25rem\">\n" . 

		$pages_options . 

		"				</select>\n" . 
		"				<button type=\"submit\" name=\"page_select\" value=\"öffnen\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"submit\" name=\"page_select\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<hr />\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"new_name\" class=\"col-sm-2 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ein neues Thema anlegen. Geben Sie dafür ein Title des Themas ein und klicken dann auf <u>anlegen</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-3\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<input type=\"text\" id=\"new_name\" name=\"new_name\" value=\"" . (isset($_POST['new_name']) ? strip_tags($_POST['new_name']) : "") . "\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"width: 200px;border-radius: .25rem 0 0 .25rem\" />\n" . 
		"				<button type=\"submit\" name=\"page_select\" value=\"anlegen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if((isset($row_page["id"]) && $row_page["id"] > 0) || (isset($_POST["save"]) && $_POST["save"] == "speichern") || (isset($param["edit"]) && $param["edit"] == "OK")){

	$html .= 	"<hr />" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"slug\" class=\"col-sm-2 col-form-label\">Slug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Slug des Themas ändern. Er darf nur aus folgenden Zeichen bestehen [a bis z, Unterstrich und Bindestrich] und muß einmalig sein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"slug\" name=\"slug\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $slug : strip_tags($row_page["slug"])) . "\" class=\"form-control" . $inp_slug . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"title\" class=\"col-sm-2 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Title des Themas ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $title : strip_tags($row_page["title"])) . "\" class=\"form-control" . $inp_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-2 col-form-label\">Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Text-Inhalt des Themas ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-10\">\n" . 
				"							<textarea id=\"edit_content\" name=\"text\" class=\"" . $inp_text . "\" style=\"width:100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? str_replace("<br />", "\r\n", $text) : str_replace("<br />", "\r\n", $row_page["text"])) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-2 col-form-label\">Position <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Postion des Themas ändern, nach dieser wird das Thema sortiert dargestellt.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $pos : intval($row_page["pos"])) . "\" class=\"form-control" . $inp_pos . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . intval($_SESSION["blog"]["id"]) . "\" />\n" . 
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

?>