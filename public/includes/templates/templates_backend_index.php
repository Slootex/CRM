<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/admin_head.php"); ?>
<?php echo $page['style']; ?>
<?php echo $_SESSION["admin"]["style"]; ?>
<?php echo $maindata['style_backend']; ?>
</head>
<body>
<div id="header" class="bg-<?php echo $_SESSION["admin"]["bgcolor_header_footer"]; ?> border-bottom border-<?php echo $_SESSION["admin"]["border_header_footer"]; ?> mb-3">
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<nav class="navbar navbar-expand-lg navbar-<?php echo $_SESSION["admin"]["bgcolor_header_footer"]; ?> p-0">
					<?php if($maindata['logo_url'] != ""){ ?><a href="<?php echo $maindata['logo_url']; ?>"<?php echo $maindata['logo_url'] == "#" ? " onclick=\"toggleFullscreen()\"" : ""; ?>><img src="/uploads/company/<?php echo intval($_SESSION["admin"]["company_id"]); ?>/img/logo_backend.png" alt="Logo" style="width: 32px;margin: 2px" /></a><?php } ?>
					<?php 
						$navigation = new navigation($conn, 2, "start");
						echo $navigation->show();
					?>
					<button type="button" style="padding: 0 4px" class="navbar-toggler bg-<?php echo $_SESSION["admin"]["bgcolor_navbar_burgermenu"]; ?> rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="navbar_1" class="navbar-collapse collapse justify-content-end">
						<ul id="menu-1" class="navbar-nav mr-0">
							<li class="nav-item"><span class="nav-link text-<?php echo $_SESSION["admin"]["color_text"]; ?> pr-0">Willkommen, <?php echo $_SESSION["admin"]["company_name"]; ?> - </span></li>
							<li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-<?php echo $_SESSION["admin"]["color_link"]; ?>"><?php echo $_SESSION["admin"]["name"] ?></a></li>
						</ul>
						<span class="text-<?php echo $_SESSION["admin"]["color_text"]; ?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
						<ul id="menu-1" class="navbar-nav mr-0">
							<?php 
								$navigation = new navigation($conn, 1, "start");
								echo $navigation->show();
							?>
							<li class="nav-item"><a href="<?php echo $maindata['logout_index']; ?>" title="Abmelden" class="nav-link text-<?php echo $_SESSION["admin"]["color_link"]; ?> py-1">Abmelden <sup id="autologout"></sup></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
</div>
<section>
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<?php include("includes/admin_alert.php"); ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
<?php echo $html; ?>
			</div>
		</div>
	</div>
</section>
<?php include("includes/admin_footer.php"); ?>
<?php include("includes/admin_script.php"); ?>
<?php echo getScriptRecallDates($conn); ?>
<?php echo $page['script']; ?>
<?php echo $maindata['script_backend_activate'] == 1 ? $maindata['script_backend'] : ""; ?>
<script>

var chartData = {
	labels: [<?php echo $labels; ?>],
	datasets: [
		<?php echo $datasets; ?>
	]

};

var config = {
	type: 'doughnut',
	data: {
		datasets: [{
			data: [
				<?php echo $row_year['orders_by_interesteds']; ?>,
				<?php echo $row_year['interesteds']; ?>,
				<?php echo $row_year['interesteds_archiv']; ?>
			],
			backgroundColor: [
				'#1DAB47',
				'#FCAE3F',
				'#FC413F'
			],
			label: 'Dataset 1'
		}],
		labels: [
			'Konvertierte Aufträge',
			'Offene Interessenten',
			'Verlorene Interessenten'
		]
	},
	options: {
		responsive: true,
		legend: {
			position: 'top',
		},
		title: {
			display: false,
			text: 'Chart.js Doughnut Chart'
		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	}
};

window.onload = function() {

	var ctx = document.getElementById('canvas').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 4,
					bottom: 0
				}
			},
			title: {
				display: true,
				text: 'Überblick, <?php echo strip_tags($_POST['set_date']); ?>',
				fontSize: 18,
				fontStyle: 'bold',
				position: 'top'
			},
			tooltips: {
				mode: 'index',
				intersect: true,
				callbacks: {
					title: function(tooltipItems, data) {
						return 'Tag ' + tooltipItems[0]['label'];
					},
					label: function(tooltipItem, data) {
						var maxVal = data.datasets[tooltipItem.datasetIndex].data[0];
						var value = Number(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]).toFixed(0).replace(/./g, function(c, i, a) {
							return c;
						});
						return ' ' + data.datasets[tooltipItem.datasetIndex].label2 + ': ' + data.datasets[tooltipItem.datasetIndex].values[tooltipItem.index] + ' \u2259 ' + value + '%';
					},
					footer: function(tooltipItems, data) {
						return 'Hello';
					},
				},
				footerFontStyle: 'normal'
			}
		}
	});

	var ctxDoughnut = document.getElementById('chart-area').getContext('2d');
	window.myDoughnut = new Chart(ctxDoughnut, config);
	
};
</script>
</body>
</html>