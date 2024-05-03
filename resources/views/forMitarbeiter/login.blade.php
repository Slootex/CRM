<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title>ORDERGO-CRM - Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="ORDERGO-CRM, Verwaltungssystem!" />
<meta name="Keywords" content="ORDERGO, CRM, Verwaltungssystem, Administration, Konfiguration, Versand" />
<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W569ZW8');</script><!-- End Google Tag Manager --><link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
<link rel="manifest" href="/img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,500" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
<link rel="stylesheet" href="/css/font-awesome.min.css" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/slicknav.css" />
<link rel="stylesheet" href="/css/owl.carousel.css" />
<link rel="stylesheet" href="/css/owl.theme.css" />
<link rel="stylesheet" href="/css/responsive.css" />
<script src="/js/jquery-1.11.2-jquery.min.js"></script>
<script src="/js/script.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]--></head>
<body>
<div class="container-fluid">

<br /><br /><br /><br /><br /><br />
<div class="row">
	<div class="col-sm-3 text-center">
	</div>
	<div class="col-sm-6 text-center">
		<div class="card bg-primary">
			<div class="card-body px-3 pt-3 pb-0 text-left">
				<form action="{{url("/")}}/employee/login" method="post">
					@CSRF
					<div class="form-group row">
						<div class="col-sm-12 text-center px-5">
							<h3 class="text-white font-weight-bold">ORDER GO</h3>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 px-5">
							<input type="text" id="slug" name="slug" value="gzamotors" class="form-control text-secondary" placeholder="Firma" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 px-5">
							<input type="text" id="user" name="username" value="" class="form-control text-secondary" placeholder="Benutzer" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 px-5">
							<input type="password" id="pass" name="password" class="form-control text-secondary" placeholder="Kennwort" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 px-5">
							<button type="submit" name="login" value="anmelden" class="btn btn-light border border-light text-primary"><strong>Anmelden</strong></button>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 px-5 text-right">
							<a href="/impressum" class="text-white" onclick="$('#iframeImprint').modal();return false;">Impressum</a>&nbsp;&nbsp;&nbsp;<span class="text-white">|</span>&nbsp;&nbsp;&nbsp;<a href="/datenschutz" class="text-white" onclick="$('#iframeTerms').modal();return false;">Datenschutz</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<br /><br /><br />
<p><br></p>
</div>
<script>
//alert('Admin Test');
</script><script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/dbbcookieconsent.js"></script>
<script src="/js/custom.js"></script></body>
</html>