<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "time_recording";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(isset($_POST['full_width']) && strlen($_POST['full_width']) > 1){
		$emsg .= "<span class=\"error\">Bitte die Layoutbreite angeben.</span><br />\n";
		$inp_full_width = " is-invalid";
	} else {
		$full_width = intval($_POST['full_width']);
	}

	if($emsg == ""){

		$emsg = "<p>Die Zeiterfassung wurden erfolgreich gespeichert!<p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . $_SESSION["admin"]["id"] . "'"), MYSQLI_ASSOC);

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Zeiterfassung</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Geben Sie hier ihre Stunden ein.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<iframe src=\"/zeiterfassung/" . ($_SESSION["admin"]["roles"]["time_recording_login_src"] == 0 ? "admin.php" : ($_SESSION["admin"]["roles"]["time_recording_login_src"] == 1 ? "index.php?group=-1" : "index.php?group=2")) . "\" width=\"100%\" height=\"1500\" frameborder=\"0\" wmode=\"transparent\"></iframe>\n" . 
		"<br /><br /><br />\n";
			
?>