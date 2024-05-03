<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "optimize";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

if(isset($_POST['optimize']) && $_POST['optimize'] == "durchführen"){

	if($emsg == ""){

		// admin_login_history

		if(isset($_POST['admin_login_history']) && intval($_POST['admin_login_history']) == 1){

			$admin_login_history = array();

			$result = mysqli_query($conn, "	SELECT 		`admin_login_history`.`company_id` AS company_id, 
														`admin_login_history`.`name` AS name, 
														`admin_login_history`.`admin_id` AS admin_id, 
														`admin_login_history`.`ip` AS ip, 
														`admin_login_history`.`http_user_agent` AS http_user_agent, 
														`admin_login_history`.`login_date` AS login_date, 
														`admin_login_history`.`logout_date` AS logout_date 
											FROM 		`admin_login_history` 
											ORDER BY 	CAST(`admin_login_history`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$admin_login_history[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `admin_login_history`");

			for($i = 0;$i < count($admin_login_history);$i++){

				mysqli_query($conn, "	INSERT 	`admin_login_history` 
										SET 	`admin_login_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($admin_login_history[$i]['company_id'])) . "', 
												`admin_login_history`.`name`='" . mysqli_real_escape_string($conn, ($admin_login_history[$i]['name'])) . "', 
												`admin_login_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($admin_login_history[$i]['admin_id'])) . "', 
												`admin_login_history`.`ip`='" . mysqli_real_escape_string($conn, ($admin_login_history[$i]['ip'])) . "', 
												`admin_login_history`.`http_user_agent`='" . mysqli_real_escape_string($conn, ($admin_login_history[$i]['http_user_agent'])) . "', 
												`admin_login_history`.`login_date`='" . mysqli_real_escape_string($conn, intval($admin_login_history[$i]['login_date'])) . "', 
												`admin_login_history`.`logout_date`='" . mysqli_real_escape_string($conn, intval($admin_login_history[$i]['logout_date'])) . "'");

			}

		}

		// admin_role_rights

		if(isset($_POST['admin_role_rights']) && intval($_POST['admin_role_rights']) == 1){

			$admin_role_rights = array();

			$result = mysqli_query($conn, "	SELECT 		`admin_role_rights`.`company_id` AS company_id, 
														`admin_role_rights`.`role_id` AS role_id, 
														`admin_role_rights`.`right_id` AS right_id, 
														`admin_role_rights`.`enable` AS enable 
											FROM 		`admin_role_rights` 
											ORDER BY 	CAST(`admin_role_rights`.`company_id` AS UNSIGNED) ASC, CAST(`admin_role_rights`.`role_id` AS UNSIGNED) ASC, CAST(`admin_role_rights`.`right_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$admin_role_rights[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `admin_role_rights`");

			for($i = 0;$i < count($admin_role_rights);$i++){

				mysqli_query($conn, "	INSERT 	`admin_role_rights` 
										SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($admin_role_rights[$i]['company_id'])) . "', 
												`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($admin_role_rights[$i]['role_id'])) . "', 
												`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($admin_role_rights[$i]['right_id'])) . "', 
												`admin_role_rights`.`enable`='" . mysqli_real_escape_string($conn, intval($admin_role_rights[$i]['enable'])) . "'");

			}

		}

		// attachments_matrix

		if(isset($_POST['attachments_matrix']) && intval($_POST['attachments_matrix']) == 1){

			$attachments_matrix = array();

			$result = mysqli_query($conn, "	SELECT 		`attachments_matrix`.`company_id` AS company_id, 
														`attachments_matrix`.`component` AS component, 
														`attachments_matrix`.`text_module` AS text_module, 
														`attachments_matrix`.`file1` AS file1, 
														`attachments_matrix`.`file2` AS file2, 
														`attachments_matrix`.`pos` AS pos 
											FROM 		`attachments_matrix` 
											ORDER BY 	CAST(`attachments_matrix`.`company_id` AS UNSIGNED) ASC, CAST(`attachments_matrix`.`component` AS UNSIGNED) ASC, CAST(`attachments_matrix`.`pos` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$attachments_matrix[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `attachments_matrix`");

			for($i = 0;$i < count($attachments_matrix);$i++){

				mysqli_query($conn, "	INSERT 	`attachments_matrix` 
										SET 	`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['company_id'])) . "', 
												`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['component'])) . "', 
												`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['text_module'])) . "', 
												`attachments_matrix`.`file1`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['file1'])) . "', 
												`attachments_matrix`.`file2`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['file2'])) . "', 
												`attachments_matrix`.`pos`='" . mysqli_real_escape_string($conn, intval($attachments_matrix[$i]['pos'])) . "'");

			}

		}

		// blog

		if(isset($_POST['blog']) && intval($_POST['blog']) == 1){

			$blog = array();

			$result = mysqli_query($conn, "	SELECT 		`blog`.`company_id` AS company_id, 
														`blog`.`slug` AS slug, 
														`blog`.`title` AS title, 
														`blog`.`text` AS text, 
														`blog`.`pos` AS pos 
											FROM 		`blog` 
											ORDER BY 	CAST(`blog`.`company_id` AS UNSIGNED) ASC, CAST(`blog`.`pos` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$blog[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `blog`");

			for($i = 0;$i < count($blog);$i++){

				mysqli_query($conn, "	INSERT 	`blog` 
										SET 	`blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($blog[$i]['company_id'])) . "', 
												`blog`.`slug`='" . mysqli_real_escape_string($conn, ($blog[$i]['slug'])) . "', 
												`blog`.`title`='" . mysqli_real_escape_string($conn, ($blog[$i]['title'])) . "', 
												`blog`.`text`='" . mysqli_real_escape_string($conn, ($blog[$i]['text'])) . "', 
												`blog`.`pos`='" . mysqli_real_escape_string($conn, intval($blog[$i]['pos'])) . "'");

			}

		}

		// blog_posts

		if(isset($_POST['blog_posts']) && intval($_POST['blog_posts']) == 1){

			$blog_posts = array();

			$result = mysqli_query($conn, "	SELECT 		`blog_posts`.`company_id` AS company_id, 
														`blog_posts`.`blog` AS blog, 
														`blog_posts`.`post` AS post, 
														`blog_posts`.`category` AS category, 
														`blog_posts`.`tag` AS tag, 
														`blog_posts`.`title` AS title, 
														`blog_posts`.`content_title` AS content_title, 
														`blog_posts`.`content_text` AS content_text, 
														`blog_posts`.`footer` AS footer, 
														`blog_posts`.`time` AS time 
											FROM 		`blog_posts` 
											ORDER BY 	CAST(`blog_posts`.`company_id` AS UNSIGNED) ASC, CAST(`blog_posts`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$blog_posts[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `blog_posts`");

			for($i = 0;$i < count($blog_posts);$i++){

				mysqli_query($conn, "	INSERT 	`blog_posts` 
										SET 	`blog_posts`.`company_id`='" . mysqli_real_escape_string($conn, intval($blog_posts[$i]['company_id'])) . "', 
												`blog_posts`.`blog`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['blog'])) . "', 
												`blog_posts`.`post`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['post'])) . "', 
												`blog_posts`.`category`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['category'])) . "', 
												`blog_posts`.`tag`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['tag'])) . "', 
												`blog_posts`.`title`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['title'])) . "', 
												`blog_posts`.`content_title`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['content_title'])) . "', 
												`blog_posts`.`content_text`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['content_text'])) . "', 
												`blog_posts`.`footer`='" . mysqli_real_escape_string($conn, ($blog_posts[$i]['footer'])) . "', 
												`blog_posts`.`time`='" . mysqli_real_escape_string($conn, intval($blog_posts[$i]['time'])) . "'");

			}

		}

		// blog_comments

		if(isset($_POST['blog_comments']) && intval($_POST['blog_comments']) == 1){

			$blog_comments = array();

			$result = mysqli_query($conn, "	SELECT 		`blog_comments`.`company_id` AS company_id, 
														`blog_comments`.`post` AS post, 
														`blog_comments`.`name` AS name, 
														`blog_comments`.`email` AS email, 
														`blog_comments`.`comment` AS comment, 
														`blog_comments`.`time` AS time 
											FROM 		`blog_comments` 
											ORDER BY 	CAST(`blog_comments`.`company_id` AS UNSIGNED) ASC, CAST(`blog_comments`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$blog_comments[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `blog_comments`");

			for($i = 0;$i < count($blog_comments);$i++){

				mysqli_query($conn, "	INSERT 	`blog_comments` 
										SET 	`blog_comments`.`company_id`='" . mysqli_real_escape_string($conn, intval($blog_comments[$i]['company_id'])) . "', 
												`blog_comments`.`post`='" . mysqli_real_escape_string($conn, ($blog_comments[$i]['post'])) . "', 
												`blog_comments`.`name`='" . mysqli_real_escape_string($conn, ($blog_comments[$i]['name'])) . "', 
												`blog_comments`.`email`='" . mysqli_real_escape_string($conn, ($blog_comments[$i]['email'])) . "', 
												`blog_comments`.`comment`='" . mysqli_real_escape_string($conn, ($blog_comments[$i]['comment'])) . "', 
												`blog_comments`.`time`='" . mysqli_real_escape_string($conn, intval($blog_comments[$i]['time'])) . "'");

			}

		}

		// blog_categories

		if(isset($_POST['blog_categories']) && intval($_POST['blog_categories']) == 1){

			$blog_categories = array();

			$result = mysqli_query($conn, "	SELECT 		`blog_categories`.`company_id` AS company_id, 
														`blog_categories`.`slug` AS slug, 
														`blog_categories`.`title` AS title, 
														`blog_categories`.`text` AS text 
											FROM 		`blog_categories` 
											ORDER BY 	CAST(`blog_categories`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$blog_categories[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `blog_categories`");

			for($i = 0;$i < count($blog_categories);$i++){

				mysqli_query($conn, "	INSERT 	`blog_categories` 
										SET 	`blog_categories`.`company_id`='" . mysqli_real_escape_string($conn, intval($blog_categories[$i]['company_id'])) . "', 
												`blog_categories`.`slug`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['slug'])) . "', 
												`blog_categories`.`title`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['title'])) . "', 
												`blog_categories`.`text`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['text'])) . "'");

			}

		}

		// blog_tags

		if(isset($_POST['blog_tags']) && intval($_POST['blog_tags']) == 1){

			$blog_tags = array();

			$result = mysqli_query($conn, "	SELECT 		`blog_tags`.`company_id` AS company_id, 
														`blog_tags`.`slug` AS slug, 
														`blog_tags`.`title` AS title, 
														`blog_tags`.`text` AS text 
											FROM 		`blog_tags` 
											ORDER BY 	CAST(`blog_tags`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$blog_tags[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `blog_tags`");

			for($i = 0;$i < count($blog_tags);$i++){

				mysqli_query($conn, "	INSERT 	`blog_tags` 
										SET 	`blog_tags`.`company_id`='" . mysqli_real_escape_string($conn, intval($blog_categories[$i]['company_id'])) . "', 
												`blog_tags`.`slug`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['slug'])) . "', 
												`blog_tags`.`title`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['title'])) . "', 
												`blog_tags`.`text`='" . mysqli_real_escape_string($conn, ($blog_categories[$i]['text'])) . "'");

			}

		}

		// company_rights

		if(isset($_POST['company_rights']) && intval($_POST['company_rights']) == 1){

			$company_rights = array();

			$result = mysqli_query($conn, "	SELECT 		`company_rights`.`company_id` AS company_id, 
														`company_rights`.`right_id` AS right_id, 
														`company_rights`.`enable` AS enable 
											FROM 		`company_rights` 
											ORDER BY 	CAST(`company_rights`.`company_id` AS UNSIGNED) ASC, CAST(`company_rights`.`right_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$company_rights[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `company_rights`");

			for($i = 0;$i < count($company_rights);$i++){

				mysqli_query($conn, "	INSERT 	`company_rights` 
										SET 	`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_rights[$i]['company_id'])) . "', 
												`company_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($company_rights[$i]['right_id'])) . "', 
												`company_rights`.`enable`='" . mysqli_real_escape_string($conn, intval($company_rights[$i]['enable'])) . "'");

			}

		}

		// design

		if(isset($_POST['design']) && intval($_POST['design']) == 1){

			$design = array();

			$result = mysqli_query($conn, "	SELECT 		`design`.`company_id` AS company_id, 
														`design`.`category_id` AS category_id, 
														`design`.`name` AS name, 
														`design`.`description` AS description, 
														`design`.`full_width` AS full_width, 
														`design`.`bgcolor_header_footer` AS bgcolor_header_footer, 
														`design`.`border_header_footer` AS border_header_footer, 
														`design`.`bgcolor_navbar_burgermenu` AS bgcolor_navbar_burgermenu, 
														`design`.`bgcolor_badge` AS bgcolor_badge, 
														`design`.`bgcolor_sidebar` AS bgcolor_sidebar, 
														`design`.`bgcolor_card` AS bgcolor_card, 
														`design`.`color_card` AS color_card, 
														`design`.`bgcolor_table` AS bgcolor_table, 
														`design`.`bgcolor_table_head` AS bgcolor_table_head, 
														`design`.`color_table_head` AS color_table_head, 
														`design`.`color_link` AS color_link, 
														`design`.`color_text` AS color_text, 
														`design`.`bgcolor_select` AS bgcolor_select, 
														`design`.`color_select` AS color_select, 
														`design`.`border_select` AS border_select, 
														`design`.`color_palette` AS color_palette, 
														`design`.`style` AS style 
											FROM 		`design` 
											ORDER BY 	CAST(`design`.`company_id` AS UNSIGNED) ASC, CAST(`design`.`category_id` AS UNSIGNED) ASC, `design`.`name` ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$design[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `design`");

			for($i = 0;$i < count($design);$i++){

				mysqli_query($conn, "	INSERT 	`design` 
										SET 	`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($design[$i]['company_id'])) . "', 
												`design`.`category_id`='" . mysqli_real_escape_string($conn, intval($design[$i]['category_id'])) . "', 
												`design`.`name`='" . mysqli_real_escape_string($conn, intval($design[$i]['name'])) . "', 
												`design`.`description`='" . mysqli_real_escape_string($conn, intval($design[$i]['description'])) . "', 
												`design`.`full_width`='" . mysqli_real_escape_string($conn, intval($design[$i]['full_width'])) . "', 
												`design`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_header_footer'])) . "', 
												`design`.`border_header_footer`='" . mysqli_real_escape_string($conn, intval($design[$i]['border_header_footer'])) . "', 
												`design`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_navbar_burgermenu'])) . "', 
												`design`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_badge'])) . "', 
												`design`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_sidebar'])) . "', 
												`design`.`bgcolor_card`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_card'])) . "', 
												`design`.`color_card`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_card'])) . "', 
												`design`.`bgcolor_table`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_table'])) . "', 
												`design`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_table_head'])) . "', 
												`design`.`color_table_head`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_table_head'])) . "', 
												`design`.`color_link`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_link'])) . "', 
												`design`.`color_text`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_text'])) . "', 
												`design`.`bgcolor_select`='" . mysqli_real_escape_string($conn, intval($design[$i]['bgcolor_select'])) . "', 
												`design`.`color_select`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_select'])) . "', 
												`design`.`border_select`='" . mysqli_real_escape_string($conn, intval($design[$i]['border_select'])) . "', 
												`design`.`color_palette`='" . mysqli_real_escape_string($conn, intval($design[$i]['color_palette'])) . "', 
												`design`.`style`='" . mysqli_real_escape_string($conn, $design[$i]['style']) . "'");

			}

		}

		// interested_interesteds_customer_messages

		if(isset($_POST['interested_interesteds_customer_messages']) && intval($_POST['interested_interesteds_customer_messages']) == 1){

			$interested_interesteds_customer_messages = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_customer_messages`.`company_id` AS company_id, 
														`interested_interesteds_customer_messages`.`interested_id` AS interested_id, 
														`interested_interesteds_customer_messages`.`admin_id` AS admin_id, 
														`interested_interesteds_customer_messages`.`message` AS message, 
														`interested_interesteds_customer_messages`.`time` AS time 
											FROM 		`interested_interesteds_customer_messages` 
											ORDER BY 	CAST(`interested_interesteds_customer_messages`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_customer_messages`.`interested_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_customer_messages`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_customer_messages[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_customer_messages`");

			for($i = 0;$i < count($interested_interesteds_customer_messages);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_customer_messages` 
										SET 	`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_customer_messages[$i]['company_id'])) . "', 
												`interested_interesteds_customer_messages`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_customer_messages[$i]['interested_id'])) . "', 
												`interested_interesteds_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_customer_messages[$i]['admin_id'])) . "', 
												`interested_interesteds_customer_messages`.`message`='" . mysqli_real_escape_string($conn, ($interested_interesteds_customer_messages[$i]['message'])) . "', 
												`interested_interesteds_customer_messages`.`time`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_customer_messages[$i]['time'])) . "'");

			}

		}

		// interested_interesteds_emails

		if(isset($_POST['interested_interesteds_emails']) && intval($_POST['interested_interesteds_emails']) == 1){

			$interested_interesteds_emails = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_emails`.`company_id` AS company_id, 
														`interested_interesteds_emails`.`admin_id` AS admin_id, 
														`interested_interesteds_emails`.`interested_id` AS interested_id, 
														`interested_interesteds_emails`.`subject` AS subject, 
														`interested_interesteds_emails`.`body` AS body, 
														`interested_interesteds_emails`.`time` AS time 
											FROM 		`interested_interesteds_emails` 
											ORDER BY 	CAST(`interested_interesteds_emails`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_emails`.`interested_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_emails`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_emails[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_emails`");

			for($i = 0;$i < count($interested_interesteds_emails);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_emails` 
										SET 	`interested_interesteds_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_emails[$i]['company_id'])) . "', 
												`interested_interesteds_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_emails[$i]['admin_id'])) . "', 
												`interested_interesteds_emails`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_emails[$i]['interested_id'])) . "', 
												`interested_interesteds_emails`.`subject`='" . mysqli_real_escape_string($conn, ($interested_interesteds_emails[$i]['subject'])) . "', 
												`interested_interesteds_emails`.`body`='" . mysqli_real_escape_string($conn, ($interested_interesteds_emails[$i]['body'])) . "', 
												`interested_interesteds_emails`.`time`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_emails[$i]['time'])) . "'");

			}

		}

		// interested_interesteds_events

		if(isset($_POST['interested_interesteds_events']) && intval($_POST['interested_interesteds_events']) == 1){

			$interested_interesteds_events = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_events`.`company_id` AS company_id, 
														`interested_interesteds_events`.`admin_id` AS admin_id, 
														`interested_interesteds_events`.`interested_id` AS interested_id, 
														`interested_interesteds_events`.`type` AS type, 
														`interested_interesteds_events`.`message` AS message, 
														`interested_interesteds_events`.`subject` AS subject, 
														`interested_interesteds_events`.`body` AS body, 
														`interested_interesteds_events`.`time` AS time 
											FROM 		`interested_interesteds_events` 
											ORDER BY 	CAST(`interested_interesteds_events`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_events`.`interested_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_events`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_events[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_events`");

			for($i = 0;$i < count($interested_interesteds_events);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
										SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_events[$i]['company_id'])) . "', 
												`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_events[$i]['admin_id'])) . "', 
												`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_events[$i]['interested_id'])) . "', 
												`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_events[$i]['type'])) . "', 
												`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, ($interested_interesteds_events[$i]['message'])) . "', 
												`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, ($interested_interesteds_events[$i]['subject'])) . "', 
												`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, ($interested_interesteds_events[$i]['body'])) . "', 
												`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_events[$i]['time'])) . "'");

			}

		}

		// interested_interesteds_files

		if(isset($_POST['interested_interesteds_files']) && intval($_POST['interested_interesteds_files']) == 1){

			$interested_interesteds_files = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_files`.`company_id` AS company_id, 
														`interested_interesteds_files`.`interested_id` AS interested_id, 
														`interested_interesteds_files`.`file` AS file 
											FROM 		`interested_interesteds_files` 
											ORDER BY 	CAST(`interested_interesteds_files`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_files`.`interested_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_files[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_files`");

			for($i = 0;$i < count($interested_interesteds_files);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_files` 
										SET 	`interested_interesteds_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_files[$i]['company_id'])) . "', 
												`interested_interesteds_files`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_files[$i]['interested_id'])) . "', 
												`interested_interesteds_files`.`file`='" . mysqli_real_escape_string($conn, ($interested_interesteds_files[$i]['file'])) . "'");

			}

		}

		// interested_interesteds_history

		if(isset($_POST['interested_interesteds_history']) && intval($_POST['interested_interesteds_history']) == 1){

			$interested_interesteds_history = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_history`.`company_id` AS company_id, 
														`interested_interesteds_history`.`interested_id` AS interested_id, 
														`interested_interesteds_history`.`admin_id` AS admin_id, 
														`interested_interesteds_history`.`message` AS message, 
														`interested_interesteds_history`.`status` AS status, 
														`interested_interesteds_history`.`time` AS time 
											FROM 		`interested_interesteds_history` 
											ORDER BY 	CAST(`interested_interesteds_history`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_history`.`interested_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_history`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_history[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_history`");

			for($i = 0;$i < count($interested_interesteds_history);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_history` 
										SET 	`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_history[$i]['company_id'])) . "', 
												`interested_interesteds_history`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_history[$i]['interested_id'])) . "', 
												`interested_interesteds_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_history[$i]['admin_id'])) . "', 
												`interested_interesteds_history`.`message`='" . mysqli_real_escape_string($conn, ($interested_interesteds_history[$i]['message'])) . "', 
												`interested_interesteds_history`.`status`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_history[$i]['status'])) . "', 
												`interested_interesteds_history`.`time`='" . mysqli_real_escape_string($conn, ($interested_interesteds_history[$i]['time'])) . "'");

			}

		}

		// interested_interesteds_statuses

		if(isset($_POST['interested_interesteds_statuses']) && intval($_POST['interested_interesteds_statuses']) == 1){

			$interested_interesteds_statuses = array();

			$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_statuses`.`company_id` AS company_id, 
														`interested_interesteds_statuses`.`interested_id` AS interested_id, 
														`interested_interesteds_statuses`.`status_number` AS status_number, 
														`interested_interesteds_statuses`.`admin_id` AS admin_id, 
														`interested_interesteds_statuses`.`status_id` AS status_id, 
														`interested_interesteds_statuses`.`template` AS template, 
														`interested_interesteds_statuses`.`subject` AS subject, 
														`interested_interesteds_statuses`.`body` AS body, 
														`interested_interesteds_statuses`.`public` AS public, 
														`interested_interesteds_statuses`.`endtime` AS endtime, 
														`interested_interesteds_statuses`.`time` AS time 
											FROM 		`interested_interesteds_statuses` 
											ORDER BY 	CAST(`interested_interesteds_statuses`.`company_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_statuses`.`interested_id` AS UNSIGNED) ASC, CAST(`interested_interesteds_statuses`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$interested_interesteds_statuses[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `interested_interesteds_statuses`");

			for($i = 0;$i < count($interested_interesteds_statuses);$i++){

				mysqli_query($conn, "	INSERT 	`interested_interesteds_statuses` 
										SET 	`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['company_id'])) . "', 
												`interested_interesteds_statuses`.`interested_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['interested_id'])) . "', 
												`interested_interesteds_statuses`.`status_number`='" . mysqli_real_escape_string($conn, ($interested_interesteds_statuses[$i]['status_number'])) . "', 
												`interested_interesteds_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['admin_id'])) . "', 
												`interested_interesteds_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['status_id'])) . "', 
												`interested_interesteds_statuses`.`template`='" . mysqli_real_escape_string($conn, ($interested_interesteds_statuses[$i]['template'])) . "', 
												`interested_interesteds_statuses`.`subject`='" . mysqli_real_escape_string($conn, ($interested_interesteds_statuses[$i]['subject'])) . "', 
												`interested_interesteds_statuses`.`body`='" . mysqli_real_escape_string($conn, ($interested_interesteds_statuses[$i]['body'])) . "', 
												`interested_interesteds_statuses`.`public`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['public'])) . "', 
												`interested_interesteds_statuses`.`endtime`='" . mysqli_real_escape_string($conn, intval($interested_interesteds_statuses[$i]['endtime'])) . "', 
												`interested_interesteds_statuses`.`time`='" . mysqli_real_escape_string($conn, ($interested_interesteds_statuses[$i]['time'])) . "'");

			}

		}

		// maindata

		if(isset($_POST['maindata']) && intval($_POST['maindata']) == 1){

			$maindata = array();

			$result = mysqli_query($conn, "	SELECT 		`maindata`.`company_id` AS company_id, 
														`maindata`.`company` AS company, 
														`maindata`.`gender` AS gender, 
														`maindata`.`firstname` AS firstname, 
														`maindata`.`lastname` AS lastname, 
														`maindata`.`street` AS street, 
														`maindata`.`streetno` AS streetno, 
														`maindata`.`zipcode` AS zipcode, 
														`maindata`.`city` AS city, 
														`maindata`.`country` AS country, 
														`maindata`.`email` AS email, 
														`maindata`.`phonenumber` AS phonenumber, 
														`maindata`.`mobilnumber` AS mobilnumber, 
														`maindata`.`bank_name` AS bank_name, 
														`maindata`.`bank_iban` AS bank_iban, 
														`maindata`.`bank_bic` AS bank_bic, 
														`maindata`.`logo_url` AS logo_url, 
														`maindata`.`admin_index` AS admin_index, 
														`maindata`.`user_index` AS user_index, 
														`maindata`.`input_file_accept` AS input_file_accept, 
														`maindata`.`input_file_audio_accept` AS input_file_audio_accept, 
														`maindata`.`url_password` AS url_password, 
														`maindata`.`mwst` AS mwst, 
														`maindata`.`vindecoder_url` AS vindecoder_url, 
														`maindata`.`vindecoder_api_key` AS vindecoder_api_key, 
														`maindata`.`vindecoder_secret` AS vindecoder_secret, 
														`maindata`.`ups_url` AS ups_url, 
														`maindata`.`ups_username` AS ups_username, 
														`maindata`.`ups_password` AS ups_password, 
														`maindata`.`ups_customer_number` AS ups_customer_number, 
														`maindata`.`ups_access_license_number` AS ups_access_license_number, 
														`maindata`.`package` AS package, 
														`maindata`.`new_shipping_status` AS new_shipping_status, 
														`maindata`.`pickup_status` AS pickup_status, 
														`maindata`.`sleep_shipping_label` AS sleep_shipping_label, 
														`maindata`.`delete_temp_date` AS delete_temp_date, 
														`maindata`.`admin_id` AS admin_id, 
														`maindata`.`storage_space_owner_id` AS storage_space_owner_id, 
														`maindata`.`order_status` AS order_status, 
														`maindata`.`order_status_intern` AS order_status_intern, 
														`maindata`.`shipping_status` AS shipping_status, 
														`maindata`.`shipping_cancel_status` AS shipping_cancel_status, 
														`maindata`.`email_status` AS email_status, 
														`maindata`.`interested_to_order_status` AS interested_to_order_status, 
														`maindata`.`order_to_archive_status` AS order_to_archive_status, 
														`maindata`.`archive_to_order_status` AS archive_to_order_status, 
														`maindata`.`order_payed_status` AS order_payed_status, 
														`maindata`.`order_to_booking_status` AS order_to_booking_status, 
														`maindata`.`order_ending_status` AS order_ending_status, 
														`maindata`.`user_status` AS user_status, 
														`maindata`.`user_status_intern` AS user_status_intern, 
														`maindata`.`user_email_status` AS user_email_status, 
														`maindata`.`interested_status` AS interested_status, 
														`maindata`.`interested_status_intern` AS interested_status_intern, 
														`maindata`.`interested_status_intern_orderform_per_mail` AS interested_status_intern_orderform_per_mail, 
														`maindata`.`interested_email_status` AS interested_email_status, 
														`maindata`.`interested_to_archive_status` AS interested_to_archive_status, 
														`maindata`.`archive_to_interested_status` AS archive_to_interested_status, 
														`maindata`.`script_backend` AS script_backend, 
														`maindata`.`script_backend_activate` AS script_backend_activate 
											FROM 		`maindata` 
											ORDER BY 	CAST(`maindata`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$maindata[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `maindata`");

			for($i = 0;$i < count($maindata);$i++){

				mysqli_query($conn, "	INSERT 	`maindata` 
										SET 	`maindata`.`company_id`='" . mysqli_real_escape_string($conn, ($maindata[$i]['company_id'])) . "', 
												`maindata`.`company`='" . mysqli_real_escape_string($conn, ($maindata[$i]['company'])) . "', 
												`maindata`.`gender`='" . mysqli_real_escape_string($conn, ($maindata[$i]['gender'])) . "', 
												`maindata`.`firstname`='" . mysqli_real_escape_string($conn, ($maindata[$i]['firstname'])) . "', 
												`maindata`.`lastname`='" . mysqli_real_escape_string($conn, ($maindata[$i]['lastname'])) . "', 
												`maindata`.`street`='" . mysqli_real_escape_string($conn, ($maindata[$i]['street'])) . "', 
												`maindata`.`streetno`='" . mysqli_real_escape_string($conn, ($maindata[$i]['streetno'])) . "', 
												`maindata`.`zipcode`='" . mysqli_real_escape_string($conn, ($maindata[$i]['zipcode'])) . "', 
												`maindata`.`city`='" . mysqli_real_escape_string($conn, ($maindata[$i]['city'])) . "', 
												`maindata`.`country`='" . mysqli_real_escape_string($conn, ($maindata[$i]['country'])) . "', 
												`maindata`.`email`='" . mysqli_real_escape_string($conn, ($maindata[$i]['email'])) . "', 
												`maindata`.`phonenumber`='" . mysqli_real_escape_string($conn, ($maindata[$i]['phonenumber'])) . "', 
												`maindata`.`mobilnumber`='" . mysqli_real_escape_string($conn, ($maindata[$i]['mobilnumber'])) . "', 
												`maindata`.`bank_name`='" . mysqli_real_escape_string($conn, ($maindata[$i]['bank_name'])) . "', 
												`maindata`.`bank_iban`='" . mysqli_real_escape_string($conn, ($maindata[$i]['bank_iban'])) . "', 
												`maindata`.`bank_bic`='" . mysqli_real_escape_string($conn, ($maindata[$i]['bank_bic'])) . "', 
												`maindata`.`logo_url`='" . mysqli_real_escape_string($conn, ($maindata[$i]['logo_url'])) . "', 
												`maindata`.`admin_index`='" . mysqli_real_escape_string($conn, ($maindata[$i]['admin_index'])) . "', 
												`maindata`.`user_index`='" . mysqli_real_escape_string($conn, ($maindata[$i]['user_index'])) . "', 
												`maindata`.`input_file_accept`='" . mysqli_real_escape_string($conn, ($maindata[$i]['input_file_accept'])) . "', 
												`maindata`.`input_file_audio_accept`='" . mysqli_real_escape_string($conn, ($maindata[$i]['input_file_audio_accept'])) . "', 
												`maindata`.`url_password`='" . mysqli_real_escape_string($conn, ($maindata[$i]['url_password'])) . "', 
												`maindata`.`mwst`='" . mysqli_real_escape_string($conn, ($maindata[$i]['mwst'])) . "', 
												`maindata`.`vindecoder_url`='" . mysqli_real_escape_string($conn, ($maindata[$i]['vindecoder_url'])) . "', 
												`maindata`.`vindecoder_api_key`='" . mysqli_real_escape_string($conn, ($maindata[$i]['vindecoder_api_key'])) . "', 
												`maindata`.`vindecoder_secret`='" . mysqli_real_escape_string($conn, ($maindata[$i]['vindecoder_secret'])) . "', 
												`maindata`.`ups_url`='" . mysqli_real_escape_string($conn, ($maindata[$i]['ups_url'])) . "', 
												`maindata`.`ups_username`='" . mysqli_real_escape_string($conn, ($maindata[$i]['ups_username'])) . "', 
												`maindata`.`ups_password`='" . mysqli_real_escape_string($conn, ($maindata[$i]['ups_password'])) . "', 
												`maindata`.`ups_customer_number`='" . mysqli_real_escape_string($conn, ($maindata[$i]['ups_customer_number'])) . "', 
												`maindata`.`ups_access_license_number`='" . mysqli_real_escape_string($conn, ($maindata[$i]['ups_access_license_number'])) . "', 
												`maindata`.`package`='" . mysqli_real_escape_string($conn, ($maindata[$i]['package'])) . "', 
												`maindata`.`new_shipping_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['new_shipping_status'])) . "', 
												`maindata`.`pickup_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['pickup_status'])) . "', 
												`maindata`.`sleep_shipping_label`='" . mysqli_real_escape_string($conn, ($maindata[$i]['sleep_shipping_label'])) . "', 
												`maindata`.`delete_temp_date`='" . mysqli_real_escape_string($conn, ($maindata[$i]['delete_temp_date'])) . "', 
												`maindata`.`admin_id`='" . mysqli_real_escape_string($conn, ($maindata[$i]['admin_id'])) . "', 
												`maindata`.`storage_space_owner_id`='" . mysqli_real_escape_string($conn, ($maindata[$i]['storage_space_owner_id'])) . "', 
												`maindata`.`order_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_status'])) . "', 
												`maindata`.`order_status_intern`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_status_intern'])) . "', 
												`maindata`.`shipping_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['shipping_status'])) . "', 
												`maindata`.`shipping_cancel_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['shipping_cancel_status'])) . "', 
												`maindata`.`email_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['email_status'])) . "', 
												`maindata`.`interested_to_order_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_to_order_status'])) . "', 
												`maindata`.`order_to_archive_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_to_archive_status'])) . "', 
												`maindata`.`archive_to_order_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['archive_to_order_status'])) . "', 
												`maindata`.`order_payed_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_payed_status'])) . "', 
												`maindata`.`order_to_booking_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_to_booking_status'])) . "', 
												`maindata`.`order_ending_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['order_ending_status'])) . "', 
												`maindata`.`user_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['user_status'])) . "', 
												`maindata`.`user_status_intern`='" . mysqli_real_escape_string($conn, ($maindata[$i]['user_status_intern'])) . "', 
												`maindata`.`user_email_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['user_email_status'])) . "', 
												`maindata`.`interested_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_status'])) . "', 
												`maindata`.`interested_status_intern`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_status_intern'])) . "', 
												`maindata`.`interested_status_intern_orderform_per_mail`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_status_intern_orderform_per_mail'])) . "', 
												`maindata`.`interested_email_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_email_status'])) . "', 
												`maindata`.`interested_to_archive_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['interested_to_archive_status'])) . "', 
												`maindata`.`archive_to_interested_status`='" . mysqli_real_escape_string($conn, ($maindata[$i]['archive_to_interested_status'])) . "', 
												`maindata`.`script_backend`='" . mysqli_real_escape_string($conn, ($maindata[$i]['script_backend'])) . "', 
												`maindata`.`script_backend_activate`='" . mysqli_real_escape_string($conn, ($maindata[$i]['script_backend_activate'])) . "'");

			}

		}

		// order_orders_customer_messages

		if(isset($_POST['order_orders_customer_messages']) && intval($_POST['order_orders_customer_messages']) == 1){

			$order_orders_customer_messages = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_customer_messages`.`company_id` AS company_id, 
														`order_orders_customer_messages`.`order_id` AS order_id, 
														`order_orders_customer_messages`.`admin_id` AS admin_id, 
														`order_orders_customer_messages`.`message` AS message, 
														`order_orders_customer_messages`.`time` AS time 
											FROM 		`order_orders_customer_messages` 
											ORDER BY 	CAST(`order_orders_customer_messages`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_customer_messages`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_customer_messages`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_customer_messages[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_customer_messages`");

			for($i = 0;$i < count($order_orders_customer_messages);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_customer_messages` 
										SET 	`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_customer_messages[$i]['company_id'])) . "', 
												`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_customer_messages[$i]['order_id'])) . "', 
												`order_orders_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_customer_messages[$i]['admin_id'])) . "', 
												`order_orders_customer_messages`.`message`='" . mysqli_real_escape_string($conn, ($order_orders_customer_messages[$i]['message'])) . "', 
												`order_orders_customer_messages`.`time`='" . mysqli_real_escape_string($conn, intval($order_orders_customer_messages[$i]['time'])) . "'");

			}

		}

		// order_orders_emails

		if(isset($_POST['order_orders_emails']) && intval($_POST['order_orders_emails']) == 1){

			$order_orders_emails = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_emails`.`company_id` AS company_id, 
														`order_orders_emails`.`admin_id` AS admin_id, 
														`order_orders_emails`.`order_id` AS order_id, 
														`order_orders_emails`.`subject` AS subject, 
														`order_orders_emails`.`body` AS body, 
														`order_orders_emails`.`time` AS time 
											FROM 		`order_orders_emails` 
											ORDER BY 	CAST(`order_orders_emails`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_emails`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_emails`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_emails[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_emails`");

			for($i = 0;$i < count($order_orders_emails);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_emails` 
										SET 	`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_emails[$i]['company_id'])) . "', 
												`order_orders_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_emails[$i]['admin_id'])) . "', 
												`order_orders_emails`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_emails[$i]['order_id'])) . "', 
												`order_orders_emails`.`subject`='" . mysqli_real_escape_string($conn, ($order_orders_emails[$i]['subject'])) . "', 
												`order_orders_emails`.`body`='" . mysqli_real_escape_string($conn, ($order_orders_emails[$i]['body'])) . "', 
												`order_orders_emails`.`time`='" . mysqli_real_escape_string($conn, intval($order_orders_emails[$i]['time'])) . "'");

			}

		}

		// order_orders_events

		if(isset($_POST['order_orders_events']) && intval($_POST['order_orders_events']) == 1){

			$order_orders_events = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_events`.`company_id` AS company_id, 
														`order_orders_events`.`admin_id` AS admin_id, 
														`order_orders_events`.`order_id` AS order_id, 
														`order_orders_events`.`type` AS type, 
														`order_orders_events`.`message` AS message, 
														`order_orders_events`.`subject` AS subject, 
														`order_orders_events`.`body` AS body, 
														`order_orders_events`.`time` AS time 
											FROM 		`order_orders_events` 
											ORDER BY 	CAST(`order_orders_events`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_events`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_events`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_events[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_events`");

			for($i = 0;$i < count($order_orders_events);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_events` 
										SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_events[$i]['company_id'])) . "', 
												`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_events[$i]['admin_id'])) . "', 
												`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_events[$i]['order_id'])) . "', 
												`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, intval($order_orders_events[$i]['type'])) . "', 
												`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, ($order_orders_events[$i]['message'])) . "', 
												`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, ($order_orders_events[$i]['subject'])) . "', 
												`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, ($order_orders_events[$i]['body'])) . "', 
												`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($order_orders_events[$i]['time'])) . "'");

			}

		}

		// order_orders_files

		if(isset($_POST['order_orders_files']) && intval($_POST['order_orders_files']) == 1){

			$order_orders_files = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_files`.`company_id` AS company_id, 
														`order_orders_files`.`order_id` AS order_id, 
														`order_orders_files`.`file` AS file 
											FROM 		`order_orders_files` 
											ORDER BY 	CAST(`order_orders_files`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_files`.`order_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_files[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_files`");

			for($i = 0;$i < count($order_orders_files);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_files[$i]['company_id'])) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_files[$i]['order_id'])) . "', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, ($order_orders_files[$i]['file'])) . "'");

			}

		}

		// order_orders_history

		if(isset($_POST['order_orders_history']) && intval($_POST['order_orders_history']) == 1){

			$order_orders_history = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_history`.`company_id` AS company_id, 
														`order_orders_history`.`order_id` AS order_id, 
														`order_orders_history`.`admin_id` AS admin_id, 
														`order_orders_history`.`message` AS message, 
														`order_orders_history`.`status` AS status, 
														`order_orders_history`.`time` AS time 
											FROM 		`order_orders_history` 
											ORDER BY 	CAST(`order_orders_history`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_history`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_history`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_history[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_history`");

			for($i = 0;$i < count($order_orders_history);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_history` 
										SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_history[$i]['company_id'])) . "', 
												`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_history[$i]['order_id'])) . "', 
												`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_history[$i]['admin_id'])) . "', 
												`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, ($order_orders_history[$i]['message'])) . "', 
												`order_orders_history`.`status`='" . mysqli_real_escape_string($conn, intval($order_orders_history[$i]['status'])) . "', 
												`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, ($order_orders_history[$i]['time'])) . "'");

			}

		}

		// order_orders_payings

		if(isset($_POST['order_orders_payings']) && intval($_POST['order_orders_payings']) == 1){

			$order_orders_payings = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_payings`.`company_id` AS company_id, 
														`order_orders_payings`.`admin_id` AS admin_id, 
														`order_orders_payings`.`order_id` AS order_id, 
														`order_orders_payings`.`radio_purpose` AS radio_purpose, 
														`order_orders_payings`.`radio_shipping` AS radio_shipping, 
														`order_orders_payings`.`radio_payment` AS radio_payment, 
														`order_orders_payings`.`radio_saturday` AS radio_saturday, 
														`order_orders_payings`.`radio_paying_netto` AS radio_paying_netto, 
														`order_orders_payings`.`price_total` AS price_total, 
														`order_orders_payings`.`mwst` AS mwst, 
														`order_orders_payings`.`payed` AS payed, 
														`order_orders_payings`.`shipping` AS shipping, 
														`order_orders_payings`.`time` AS time 
											FROM 		`order_orders_shipments` 
											ORDER BY 	CAST(`order_orders_payings`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_payings`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_payings`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_payings[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_payings`");

			for($i = 0;$i < count($order_orders_payings);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_payings` 
										SET 	`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['company_id'])) . "', 
												`order_orders_payings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['admin_id'])) . "', 
												`order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['order_id'])) . "', 
												`order_orders_payings`.`radio_purpose`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['radio_purpose'])) . "', 
												`order_orders_payings`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['radio_shipping'])) . "', 
												`order_orders_payings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['radio_payment'])) . "', 
												`order_orders_payings`.`radio_saturday`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['radio_saturday'])) . "', 
												`order_orders_payings`.`radio_paying_netto`='" . mysqli_real_escape_string($conn, intval([$i]['radio_paying_netto'])) . "', 
												`order_orders_payings`.`price_total`='" . mysqli_real_escape_string($conn, ($order_orders_payings[$i]['price_total'])) . "', 
												`order_orders_payings`.`mwst`='" . mysqli_real_escape_string($conn, ($order_orders_payings[$i]['mwst'])) . "', 
												`order_orders_payings`.`payed`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['payed'])) . "', 
												`order_orders_payings`.`shipping`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['shipping'])) . "', 
												`order_orders_payings`.`time`='" . mysqli_real_escape_string($conn, intval($order_orders_payings[$i]['time'])) . "'");

			}

		}

		// order_orders_questions

		if(isset($_POST['order_orders_questions']) && intval($_POST['order_orders_questions']) == 1){

			$order_orders_questions = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_questions`.`company_id` AS company_id, 
														`order_orders_questions`.`order_id` AS order_id, 
														`order_orders_questions`.`question_id` AS question_id, 
														`order_orders_questions`.`answer_id` AS answer_id 
											FROM 		`order_orders_questions` 
											ORDER BY 	CAST(`order_orders_questions`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_questions`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_questions`.`question_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_questions[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_questions`");

			for($i = 0;$i < count($order_orders_questions);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_questions` 
										SET 	`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_questions[$i]['company_id'])) . "', 
												`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_questions[$i]['order_id'])) . "', 
												`order_orders_questions`.`question_id`='" . mysqli_real_escape_string($conn, intval($order_orders_questions[$i]['question_id'])) . "', 
												`order_orders_questions`.`answer_id`='" . mysqli_real_escape_string($conn, intval($order_orders_questions[$i]['answer_id'])) . "'");

			}

		}

		// order_orders_shipments

		if(isset($_POST['order_orders_shipments']) && intval($_POST['order_orders_shipments']) == 1){

			$order_orders_shipments = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`company_id` AS company_id, 
														`order_orders_shipments`.`order_id` AS order_id, 
														`order_orders_shipments`.`admin_id` AS admin_id, 
														`order_orders_shipments`.`status_id` AS status_id, 
														`order_orders_shipments`.`shipments_id` AS shipments_id, 
														`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
														`order_orders_shipments`.`label_url` AS label_url, 
														`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
														`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
														`order_orders_shipments`.`price` AS price, 
														`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
														`order_orders_shipments`.`carrier` AS carrier, 
														`order_orders_shipments`.`service` AS service, 
														`order_orders_shipments`.`reference_number` AS reference_number, 
														`order_orders_shipments`.`notification_email` AS notification_email, 
														`order_orders_shipments`.`create_shipping_label` AS create_shipping_label, 
														`order_orders_shipments`.`component` AS component, 
														`order_orders_shipments`.`companyname` AS companyname, 
														`order_orders_shipments`.`firstname` AS firstname, 
														`order_orders_shipments`.`lastname` AS lastname, 
														`order_orders_shipments`.`street` AS street, 
														`order_orders_shipments`.`streetno` AS streetno, 
														`order_orders_shipments`.`zipcode` AS zipcode, 
														`order_orders_shipments`.`city` AS city, 
														`order_orders_shipments`.`country` AS country, 
														`order_orders_shipments`.`weight` AS weight, 
														`order_orders_shipments`.`length` AS length, 
														`order_orders_shipments`.`width` AS width, 
														`order_orders_shipments`.`height` AS height, 
														`order_orders_shipments`.`status` AS status, 
														`order_orders_shipments`.`time` AS time 
											FROM 		`order_orders_shipments` 
											ORDER BY 	CAST(`order_orders_shipments`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_shipments`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_shipments`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_shipments[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_shipments`");

			for($i = 0;$i < count($order_orders_shipments);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_shipments` 
										SET 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['company_id'])) . "', 
												`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['order_id'])) . "', 
												`order_orders_shipments`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['admin_id'])) . "', 
												`order_orders_shipments`.`status_id`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['status_id'])) . "', 
												`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['shipments_id'])) . "', 
												`order_orders_shipments`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['carrier_tracking_no'])) . "', 
												`order_orders_shipments`.`label_url`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['label_url'])) . "', 
												`order_orders_shipments`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['graphic_image_jpeg'])) . "', 
												`order_orders_shipments`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['graphic_image_gif'])) . "', 
												`order_orders_shipments`.`price`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['price'])) . "', 
												`order_orders_shipments`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['total_charges_with_taxes'])) . "', 
												`order_orders_shipments`.`carrier`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['carrier'])) . "', 
												`order_orders_shipments`.`service`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['service'])) . "', 
												`order_orders_shipments`.`reference_number`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['reference_number'])) . "', 
												`order_orders_shipments`.`notification_email`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['notification_email'])) . "', 
												`order_orders_shipments`.`create_shipping_label`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['create_shipping_label'])) . "', 
												`order_orders_shipments`.`component`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['component'])) . "', 
												`order_orders_shipments`.`companyname`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['companyname'])) . "', 
												`order_orders_shipments`.`firstname`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['firstname'])) . "', 
												`order_orders_shipments`.`lastname`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['lastname'])) . "', 
												`order_orders_shipments`.`street`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['street'])) . "', 
												`order_orders_shipments`.`streetno`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['streetno'])) . "', 
												`order_orders_shipments`.`zipcode`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['zipcode'])) . "', 
												`order_orders_shipments`.`city`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['city'])) . "', 
												`order_orders_shipments`.`country`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['country'])) . "', 
												`order_orders_shipments`.`weight`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['weight'])) . "', 
												`order_orders_shipments`.`length`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['length'])) . "', 
												`order_orders_shipments`.`width`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['width'])) . "', 
												`order_orders_shipments`.`height`='" . mysqli_real_escape_string($conn, ($order_orders_shipments[$i]['height'])) . "', 
												`order_orders_shipments`.`status`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['status'])) . "', 
												`order_orders_shipments`.`time`='" . mysqli_real_escape_string($conn, intval($order_orders_shipments[$i]['time'])) . "'");

			}

		}

		// order_orders_statuses

		if(isset($_POST['order_orders_statuses']) && intval($_POST['order_orders_statuses']) == 1){

			$order_orders_statuses = array();

			$result = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`company_id` AS company_id, 
														`order_orders_statuses`.`order_id` AS order_id, 
														`order_orders_statuses`.`status_number` AS status_number, 
														`order_orders_statuses`.`admin_id` AS admin_id, 
														`order_orders_statuses`.`status_id` AS status_id, 
														`order_orders_statuses`.`template` AS template, 
														`order_orders_statuses`.`subject` AS subject, 
														`order_orders_statuses`.`body` AS body, 
														`order_orders_statuses`.`public` AS public, 
														`order_orders_statuses`.`time` AS time 
											FROM 		`order_orders_statuses` 
											ORDER BY 	CAST(`order_orders_statuses`.`company_id` AS UNSIGNED) ASC, CAST(`order_orders_statuses`.`order_id` AS UNSIGNED) ASC, CAST(`order_orders_statuses`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$order_orders_statuses[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `order_orders_statuses`");

			for($i = 0;$i < count($order_orders_statuses);$i++){

				mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
										SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($order_orders_statuses[$i]['company_id'])) . "', 
												`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_orders_statuses[$i]['order_id'])) . "', 
												`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, ($order_orders_statuses[$i]['status_number'])) . "', 
												`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($order_orders_statuses[$i]['admin_id'])) . "', 
												`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($order_orders_statuses[$i]['status_id'])) . "', 
												`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, ($order_orders_statuses[$i]['template'])) . "', 
												`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, ($order_orders_statuses[$i]['subject'])) . "', 
												`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, ($order_orders_statuses[$i]['body'])) . "', 
												`order_orders_statuses`.`public`='" . mysqli_real_escape_string($conn, intval($order_orders_statuses[$i]['public'])) . "', 
												`order_orders_statuses`.`time`='" . mysqli_real_escape_string($conn, ($order_orders_statuses[$i]['time'])) . "'");

			}

		}

		// pickup_pickups

		if(isset($_POST['pickup_pickups']) && intval($_POST['pickup_pickups']) == 1){

			$pickup_pickups = array();

			$result = mysqli_query($conn, "	SELECT 		`pickup_pickups`.`company_id` AS company_id, 
														`pickup_pickups`.`admin_id` AS admin_id, 
														`pickup_pickups`.`referencenumber` AS referencenumber, 
														`pickup_pickups`.`description` AS description, 
														`pickup_pickups`.`pickupdate` AS pickupdate, 
														`pickup_pickups`.`readytime_hours` AS readytime_hours, 
														`pickup_pickups`.`readytime_minutes` AS readytime_minutes, 
														`pickup_pickups`.`closetime_hours` AS closetime_hours, 
														`pickup_pickups`.`closetime_minutes` AS closetime_minutes, 
														`pickup_pickups`.`shortcut` AS shortcut, 
														`pickup_pickups`.`companyname` AS companyname, 
														`pickup_pickups`.`contactname` AS contactname, 
														`pickup_pickups`.`addressline` AS addressline, 
														`pickup_pickups`.`postalcode` AS postalcode, 
														`pickup_pickups`.`city` AS city, 
														`pickup_pickups`.`countrycode` AS countrycode, 
														`pickup_pickups`.`email` AS email, 
														`pickup_pickups`.`phone` AS phone, 
														`pickup_pickups`.`room` AS room, 
														`pickup_pickups`.`floor` AS floor, 
														`pickup_pickups`.`pickuppoint` AS pickuppoint, 
														`pickup_pickups`.`weight` AS weight, 
														`pickup_pickups`.`servicecode` AS servicecode, 
														`pickup_pickups`.`paymentmethod` AS paymentmethod, 
														`pickup_pickups`.`transactionidentifier` AS transactionidentifier, 
														`pickup_pickups`.`prn` AS prn, 
														`pickup_pickups`.`status` AS status 
											FROM 		`pickup_pickups` 
											ORDER BY 	CAST(`pickup_pickups`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$pickup_pickups[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `pickup_pickups`");

			for($i = 0;$i < count($pickup_pickups);$i++){
				
				mysqli_query($conn, "	INSERT 	`pickup_pickups` 
										SET 	`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($pickup_pickups[$i]['company_id'])) . "', 
												`pickup_pickups`.`admin_id`='" . mysqli_real_escape_string($conn, intval($pickup_pickups[$i]['admin_id'])) . "', 
												`pickup_pickups`.`referencenumber`='" . mysqli_real_escape_string($conn, intval($pickup_pickups[$i]['referencenumber'])) . "', 
												`pickup_pickups`.`description`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['description'])) . "', 
												`pickup_pickups`.`pickupdate`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['pickupdate'])) . "', 
												`pickup_pickups`.`readytime_hours`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['readytime_hours'])) . "', 
												`pickup_pickups`.`readytime_minutes`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['readytime_minutes'])) . "', 
												`pickup_pickups`.`closetime_hours`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['closetime_hours'])) . "', 
												`pickup_pickups`.`closetime_minutes`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['closetime_minutes'])) . "', 
												`pickup_pickups`.`shortcut`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['shortcut'])) . "', 
												`pickup_pickups`.`companyname`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['companyname'])) . "', 
												`pickup_pickups`.`contactname`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['contactname'])) . "', 
												`pickup_pickups`.`addressline`='" . mysqli_real_escape_string($conn, intval($pickup_pickups[$i]['addressline'])) . "', 
												`pickup_pickups`.`postalcode`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['postalcode'])) . "', 
												`pickup_pickups`.`city`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['city'])) . "', 
												`pickup_pickups`.`countrycode`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['countrycode'])) . "', 
												`pickup_pickups`.`email`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['email'])) . "', 
												`pickup_pickups`.`phone`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['phone'])) . "', 
												`pickup_pickups`.`room`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['room'])) . "', 
												`pickup_pickups`.`floor`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['floor'])) . "', 
												`pickup_pickups`.`pickuppoint`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['pickuppoint'])) . "', 
												`pickup_pickups`.`weight`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['weight'])) . "', 
												`pickup_pickups`.`servicecode`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['servicecode'])) . "', 
												`pickup_pickups`.`paymentmethod`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['paymentmethod'])) . "', 
												`pickup_pickups`.`transactionidentifier`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['transactionidentifier'])) . "', 
												`pickup_pickups`.`prn`='" . mysqli_real_escape_string($conn, intval($pickup_pickups[$i]['prn'])) . "', 
												`pickup_pickups`.`status`='" . mysqli_real_escape_string($conn, ($pickup_pickups[$i]['status'])) . "'");

			}

		}

		// shipping_messages

		if(isset($_POST['shipping_messages']) && intval($_POST['shipping_messages']) == 1){

			$shipping_messages = array();

			$result = mysqli_query($conn, "	SELECT 		`shipping_messages`.`company_id` AS company_id, 
														`shipping_messages`.`searchstring` AS searchstring, 
														`shipping_messages`.`replacestring` AS replacestring, 
														`shipping_messages`.`bgcolor` AS bgcolor 
											FROM 		`shipping_messages` 
											ORDER BY 	CAST(`shipping_messages`.`company_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$shipping_messages[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `shipping_messages`");

			for($i = 0;$i < count($shipping_messages);$i++){

				mysqli_query($conn, "	INSERT 	`shipping_messages` 
										SET 	`shipping_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($shipping_messages[$i]['company_id'])) . "', 
												`shipping_messages`.`searchstring`='" . mysqli_real_escape_string($conn, ($shipping_messages[$i]['searchstring'])) . "', 
												`shipping_messages`.`replacestring`='" . mysqli_real_escape_string($conn, ($shipping_messages[$i]['replacestring'])) . "', 
												`shipping_messages`.`bgcolor`='" . mysqli_real_escape_string($conn, intval($shipping_messages[$i]['bgcolor'])) . "'");

			}

		}

		// text_history

		if(isset($_POST['text_history']) && intval($_POST['text_history']) == 1){

			$text_history = array();

			$result = mysqli_query($conn, "	SELECT 		`text_history`.`company_id` AS company_id, 
														`text_history`.`name` AS name, 
														`text_history`.`text` AS text, 
														`text_history`.`area` AS area, 
														`text_history`.`enable` AS enable, 
														`text_history`.`pos` AS pos 
											FROM 		`text_history` 
											ORDER BY 	CAST(`text_history`.`company_id` AS UNSIGNED) ASC, CAST(`text_history`.`area` AS UNSIGNED) ASC, CAST(`text_history`.`pos` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$text_history[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `text_history`");

			for($i = 0;$i < count($text_history);$i++){

				mysqli_query($conn, "	INSERT 	`text_history` 
										SET 	`text_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($text_history[$i]['company_id'])) . "', 
												`text_history`.`name`='" . mysqli_real_escape_string($conn, ($text_history[$i]['name'])) . "', 
												`text_history`.`text`='" . mysqli_real_escape_string($conn, ($text_history[$i]['text'])) . "', 
												`text_history`.`area`='" . mysqli_real_escape_string($conn, intval($text_history[$i]['area'])) . "', 
												`text_history`.`enable`='" . mysqli_real_escape_string($conn, intval($text_history[$i]['enable'])) . "', 
												`text_history`.`pos`='" . mysqli_real_escape_string($conn, intval($text_history[$i]['pos'])) . "'");

			}

		}

		// user_users_customer_messages

		if(isset($_POST['user_users_customer_messages']) && intval($_POST['user_users_customer_messages']) == 1){

			$user_users_customer_messages = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_customer_messages`.`company_id` AS company_id, 
														`user_users_customer_messages`.`user_id` AS user_id, 
														`user_users_customer_messages`.`admin_id` AS admin_id, 
														`user_users_customer_messages`.`message` AS message, 
														`user_users_customer_messages`.`time` AS time 
											FROM 		`user_users_customer_messages` 
											ORDER BY 	CAST(`user_users_customer_messages`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_customer_messages`.`user_id` AS UNSIGNED) ASC, CAST(`user_users_customer_messages`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_customer_messages[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_customer_messages`");

			for($i = 0;$i < count($user_users_customer_messages);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_customer_messages` 
										SET 	`user_users_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_customer_messages[$i]['company_id'])) . "', 
												`user_users_customer_messages`.`user_id`='" . mysqli_real_escape_string($conn, intval($user_users_customer_messages[$i]['user_id'])) . "', 
												`user_users_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($user_users_customer_messages[$i]['admin_id'])) . "', 
												`user_users_customer_messages`.`message`='" . mysqli_real_escape_string($conn, ($user_users_customer_messages[$i]['message'])) . "', 
												`user_users_customer_messages`.`time`='" . mysqli_real_escape_string($conn, intval($user_users_customer_messages[$i]['time'])) . "'");

			}

		}

		// user_users_emails

		if(isset($_POST['user_users_emails']) && intval($_POST['user_users_emails']) == 1){

			$user_users_emails = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_emails`.`company_id` AS company_id, 
														`user_users_emails`.`admin_id` AS admin_id, 
														`user_users_emails`.`user_id` AS user_id, 
														`user_users_emails`.`subject` AS subject, 
														`user_users_emails`.`body` AS body, 
														`user_users_emails`.`time` AS time 
											FROM 		`user_users_emails` 
											ORDER BY 	CAST(`user_users_emails`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_emails`.`user_id` AS UNSIGNED) ASC, CAST(`user_users_emails`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_emails[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_emails`");

			for($i = 0;$i < count($user_users_emails);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_emails` 
										SET 	`user_users_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_emails[$i]['company_id'])) . "', 
												`user_users_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($user_users_emails[$i]['admin_id'])) . "', 
												`user_users_emails`.`user_id`='" . mysqli_real_escape_string($conn, intval($user_users_emails[$i]['user_id'])) . "', 
												`user_users_emails`.`subject`='" . mysqli_real_escape_string($conn, ($user_users_emails[$i]['subject'])) . "', 
												`user_users_emails`.`body`='" . mysqli_real_escape_string($conn, ($user_users_emails[$i]['body'])) . "', 
												`user_users_emails`.`time`='" . mysqli_real_escape_string($conn, intval($user_users_emails[$i]['time'])) . "'");

			}

		}

		// user_users_events

		if(isset($_POST['user_users_events']) && intval($_POST['user_users_events']) == 1){

			$user_users_events = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_events`.`company_id` AS company_id, 
														`user_users_events`.`admin_id` AS admin_id, 
														`user_users_events`.`user_id` AS user_id, 
														`user_users_events`.`type` AS type, 
														`user_users_events`.`message` AS message, 
														`user_users_events`.`subject` AS subject, 
														`user_users_events`.`body` AS body, 
														`user_users_events`.`time` AS time 
											FROM 		`user_users_events` 
											ORDER BY 	CAST(`user_users_events`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_events`.`user_id` AS UNSIGNED) ASC, CAST(`user_users_events`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_events[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_events`");

			for($i = 0;$i < count($user_users_events);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_events` 
										SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_events[$i]['company_id'])) . "', 
												`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($user_users_events[$i]['admin_id'])) . "', 
												`user_users_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($user_users_events[$i]['order_id'])) . "', 
												`user_users_events`.`type`='" . mysqli_real_escape_string($conn, intval($user_users_events[$i]['type'])) . "', 
												`user_users_events`.`message`='" . mysqli_real_escape_string($conn, ($user_users_events[$i]['message'])) . "', 
												`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, ($user_users_events[$i]['subject'])) . "', 
												`user_users_events`.`body`='" . mysqli_real_escape_string($conn, ($user_users_events[$i]['body'])) . "', 
												`user_users_events`.`time`='" . mysqli_real_escape_string($conn, intval($user_users_events[$i]['time'])) . "'");

			}

		}

		// user_users_files

		if(isset($_POST['user_users_files']) && intval($_POST['user_users_files']) == 1){

			$user_users_files = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_files`.`company_id` AS company_id, 
														`user_users_files`.`user_id` AS user_id, 
														`user_users_files`.`file` AS file 
											FROM 		`user_users_files` 
											ORDER BY 	CAST(`user_users_files`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_files`.`user_id` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_files[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_files`");

			for($i = 0;$i < count($user_users_files);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_files` 
										SET 	`user_users_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_files[$i]['company_id'])) . "', 
												`user_users_files`.`user_id`='" . mysqli_real_escape_string($conn, intval($user_users_files[$i]['user_id'])) . "', 
												`user_users_files`.`file`='" . mysqli_real_escape_string($conn, ($user_users_files[$i]['file'])) . "'");

			}

		}

		// user_users_history

		if(isset($_POST['user_users_history']) && intval($_POST['user_users_history']) == 1){

			$user_users_history = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_history`.`company_id` AS company_id, 
														`user_users_history`.`user_id` AS user_id, 
														`user_users_history`.`admin_id` AS admin_id, 
														`user_users_history`.`message` AS message, 
														`user_users_history`.`status` AS status, 
														`user_users_history`.`time` AS time 
											FROM 		`user_users_history` 
											ORDER BY 	CAST(`user_users_history`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_history`.`user_id` AS UNSIGNED) ASC, CAST(`user_users_history`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_history[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_history`");

			for($i = 0;$i < count($user_users_history);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_history` 
										SET 	`user_users_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_history[$i]['company_id'])) . "', 
												`user_users_history`.`user_id`='" . mysqli_real_escape_string($conn, intval($user_users_history[$i]['user_id'])) . "', 
												`user_users_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($user_users_history[$i]['admin_id'])) . "', 
												`user_users_history`.`message`='" . mysqli_real_escape_string($conn, ($user_users_history[$i]['message'])) . "', 
												`user_users_history`.`status`='" . mysqli_real_escape_string($conn, intval($user_users_history[$i]['status'])) . "', 
												`user_users_history`.`time`='" . mysqli_real_escape_string($conn, ($user_users_history[$i]['time'])) . "'");

			}

		}

		// user_users_statuses

		if(isset($_POST['user_users_statuses']) && intval($_POST['user_users_statuses']) == 1){

			$user_users_statuses = array();

			$result = mysqli_query($conn, "	SELECT 		`user_users_statuses`.`company_id` AS company_id, 
														`user_users_statuses`.`user_id` AS user_id, 
														`user_users_statuses`.`status_number` AS status_number, 
														`user_users_statuses`.`admin_id` AS admin_id, 
														`user_users_statuses`.`status_id` AS status_id, 
														`user_users_statuses`.`template` AS template, 
														`user_users_statuses`.`subject` AS subject, 
														`user_users_statuses`.`body` AS body, 
														`user_users_statuses`.`endtime` AS endtime, 
														`user_users_statuses`.`time` AS time 
											FROM 		`user_users_statuses` 
											ORDER BY 	CAST(`user_users_statuses`.`company_id` AS UNSIGNED) ASC, CAST(`user_users_statuses`.`user_id` AS UNSIGNED) ASC, CAST(`user_users_statuses`.`time` AS UNSIGNED) ASC");

			while($row = $result->fetch_array(MYSQLI_ASSOC)){

				$user_users_statuses[] = $row;

			}

			mysqli_query($conn, "TRUNCATE `user_users_statuses`");

			for($i = 0;$i < count($user_users_statuses);$i++){

				mysqli_query($conn, "	INSERT 	`user_users_statuses` 
										SET 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['company_id'])) . "', 
												`user_users_statuses`.`user_id`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['user_id'])) . "', 
												`user_users_statuses`.`status_number`='" . mysqli_real_escape_string($conn, ($user_users_statuses[$i]['status_number'])) . "', 
												`user_users_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['admin_id'])) . "', 
												`user_users_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['status_id'])) . "', 
												`user_users_statuses`.`template`='" . mysqli_real_escape_string($conn, ($user_users_statuses[$i]['template'])) . "', 
												`user_users_statuses`.`subject`='" . mysqli_real_escape_string($conn, ($user_users_statuses[$i]['subject'])) . "', 
												`user_users_statuses`.`body`='" . mysqli_real_escape_string($conn, ($user_users_statuses[$i]['body'])) . "', 
												`user_users_statuses`.`endtime`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['endtime'])) . "', 
												`user_users_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($user_users_statuses[$i]['time'])) . "'");

			}

		}

		$emsg = "<p>Die Datenbank wurde erfolgreich optimiert!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Optimieren</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Datenbank optimieren.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"name\" class=\"col-sm-2 col-form-label\">Optimierung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Wählen Sie ein Bereich aus und klicken dann auf <u>bearbeiten</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-3\">\n" . 
		"			&nbsp;\n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-7\">\n" . 
		"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n" . 
		"<hr />\n";

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$html .= 	"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Optimierungen auswählen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"admin_login_history\" class=\"col-sm-3 col-form-label\">admin_login_history <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"admin_login_history\" name=\"admin_login_history\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['admin_login_history']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"admin_login_history\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"admin_role_rights\" class=\"col-sm-3 col-form-label\">admin_role_rights <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"admin_role_rights\" name=\"admin_role_rights\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['admin_role_rights']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"admin_role_rights\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"attachments_matrix\" class=\"col-sm-3 col-form-label\">attachments_matrix <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"attachments_matrix\" name=\"attachments_matrix\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['attachments_matrix']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"attachments_matrix\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"blog\" class=\"col-sm-3 col-form-label\">blog <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"blog\" name=\"blog\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['blog']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"blog\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"blog_posts\" class=\"col-sm-3 col-form-label\">blog_posts <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"blog_posts\" name=\"blog_posts\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['blog_posts']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"blog_posts\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"blog_comments\" class=\"col-sm-3 col-form-label\">blog_comments <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"blog_comments\" name=\"blog_comments\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['blog_comments']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"blog_comments\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"blog_categories\" class=\"col-sm-3 col-form-label\">blog_categories <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"blog_categories\" name=\"blog_categories\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['blog_categories']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"blog_categories\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"blog_tags\" class=\"col-sm-3 col-form-label\">blog_tags <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"blog_tags\" name=\"blog_tags\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['blog_tags']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"blog_tags\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"company_rights\" class=\"col-sm-3 col-form-label\">company_rights <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"company_rights\" name=\"company_rights\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['company_rights']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"company_rights\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"design\" class=\"col-sm-3 col-form-label\">design <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"design\" name=\"design\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['design']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"design\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_customer_messages\" class=\"col-sm-3 col-form-label\">interested_interesteds_customer_messages <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_customer_messages\" name=\"interested_interesteds_customer_messages\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_customer_messages']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_customer_messages\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_emails\" class=\"col-sm-3 col-form-label\">interested_interesteds_emails <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_emails\" name=\"interested_interesteds_emails\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_emails']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_emails\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_events\" class=\"col-sm-3 col-form-label\">interested_interesteds_events <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_events\" name=\"interested_interesteds_events\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_events']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_events\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_files\" class=\"col-sm-3 col-form-label\">interested_interesteds_files <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_files\" name=\"interested_interesteds_files\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_files']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_files\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_history\" class=\"col-sm-3 col-form-label\">interested_interesteds_history <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_history\" name=\"interested_interesteds_history\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_history']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_history\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"interested_interesteds_statuses\" class=\"col-sm-3 col-form-label\">interested_interesteds_statuses <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"interested_interesteds_statuses\" name=\"interested_interesteds_statuses\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['interested_interesteds_statuses']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"interested_interesteds_statuses\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"maindata\" class=\"col-sm-3 col-form-label\">maindata <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"maindata\" name=\"maindata\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['maindata']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"maindata\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_customer_messages\" class=\"col-sm-3 col-form-label\">order_orders_customer_messages <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_customer_messages\" name=\"order_orders_customer_messages\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_customer_messages']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_customer_messages\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_emails\" class=\"col-sm-3 col-form-label\">order_orders_emails <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_emails\" name=\"order_orders_emails\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_emails']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_emails\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_events\" class=\"col-sm-3 col-form-label\">order_orders_events <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_events\" name=\"order_orders_events\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_events']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_events\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_files\" class=\"col-sm-3 col-form-label\">order_orders_files <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_files\" name=\"order_orders_files\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_files']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_files\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_history\" class=\"col-sm-3 col-form-label\">order_orders_history <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_history\" name=\"order_orders_history\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_history']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_history\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_payings\" class=\"col-sm-3 col-form-label\">order_orders_payings <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_payings\" name=\"order_orders_payings\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_payings']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_payings\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_questions\" class=\"col-sm-3 col-form-label\">order_orders_questions <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_questions\" name=\"order_orders_questions\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_questions']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_questions\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_shipments\" class=\"col-sm-3 col-form-label\">order_orders_shipments <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_shipments\" name=\"order_orders_shipments\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_shipments']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_shipments\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"order_orders_statuses\" class=\"col-sm-3 col-form-label\">order_orders_statuses <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"order_orders_statuses\" name=\"order_orders_statuses\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['order_orders_statuses']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"order_orders_statuses\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"pickup_pickups\" class=\"col-sm-3 col-form-label\">pickup_pickups <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"pickup_pickups\" name=\"pickup_pickups\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['pickup_pickups']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"pickup_pickups\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"shipping_messages\" class=\"col-sm-3 col-form-label\">shipping_messages <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"shipping_messages\" name=\"shipping_messages\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['shipping_messages']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"shipping_messages\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"text_history\" class=\"col-sm-3 col-form-label\">text_history <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"text_history\" name=\"text_history\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['text_history']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"text_history\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_customer_messages\" class=\"col-sm-3 col-form-label\">user_users_customer_messages <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_customer_messages\" name=\"user_users_customer_messages\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_customer_messages']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_customer_messages\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_emails\" class=\"col-sm-3 col-form-label\">user_users_emails <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_emails\" name=\"user_users_emails\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_emails']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_emails\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_events\" class=\"col-sm-3 col-form-label\">user_users_events <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_events\" name=\"user_users_events\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_events']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_events\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_files\" class=\"col-sm-3 col-form-label\">user_users_files <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_files\" name=\"user_users_files\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_files']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_files\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_history\" class=\"col-sm-3 col-form-label\">user_users_history <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_history\" name=\"user_users_history\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_history']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_history\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label for=\"user_users_statuses\" class=\"col-sm-3 col-form-label\">user_users_statuses <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob die Tabelle optimiert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-1\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"user_users_statuses\" name=\"user_users_statuses\" value=\"1\"" . ((isset($_POST['optimize']) && $_POST['optimize'] == "durchführen" ? intval($_POST['user_users_statuses']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"user_users_statuses\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"optimize\" value=\"durchführen\" class=\"btn btn-primary\">Optimierung durchführen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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