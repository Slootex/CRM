<div id="cssmenu">
	<ul>
		<li><a href="/index">Startseite</a></li>
		<li><a href="/angebot/PKW/sonstige/motorsteuergeraet-reparatur">Motor Steuerger&auml;t</a></li>
		<li><a href="/angebot/PKW/sonstige/abs-esp-dsc-steuergeraet-reparatur">ABS / ESP Steuerger&auml;t</a></li>
		<li class="active">
			<a href="#">Fahrzeuge</a>
			<ul>
				<li><a href="/pkw">PKW</a></li>
				<li><a href="/lkw">LKW</a></li>
				<li><a href="/motorrad">Motorräder</a></li>
				<li><a href="/bus">Omnibusse</a></li>
				<li><a href="/landmaschine">Landmaschinen</a></li>
				<li><a href="/baumaschine">Baumaschinen</a></li>
				<li><a href="/schiff">Motorboote</a></li>
				<li><a href="/wohnmobil">Heizung</a></li>
			</ul>
		</li>
		<li><a href="/anleitung">Reparaturservice</a></li>
		<li><a href="/kontakt">Kontakt</a></li>
	</ul>
</div>
<div class="containergza">
	<div class="col-md-8 col-sm-12 col-xs-12 re_bg">
		<div class="phone_number">
			<a href="/kontakt"><img src="/img/phone_icon.png" alt="Telefonnummer GZA MOTORS" /></a>
			<p>0421 / 59 56 49 22</p>
			<p class="small">Mo-Fr. 08:00 - 18:00  Uhr</p>
		</div>
	</div>
</div> 
<div id="header" class="m_menu">
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-5 col-xs-12">
					<div class="logo">
						<div id="burger">
							<div class="burger_top"></div>
							<div class="burger_line"></div>
							<div class="burger_line"></div>
							<div class="burger_line"></div>
							<div class="burger_text">MENÜ</div>
						</div>
						<a href="/index"><img class="for_r" src="/uploads/company/1/img/logo_gzamotors.png" alt="GZA MOTORS" /></a>
					</div>
				</div>
				<div class="col-md-8 col-sm-7 col-xs-12 re_bg">
					<div class="phone_number">
						<a href="/kontakt"><img src="/img/phone_icon.png" alt="Telefonnummer GZA MOTORS" /></a>
						<p id="phone_nr">0421 / 59 56 49 22</p>
						<p class="small">Mo-Fr. 08:00 - 18:00  Uhr</p>
					</div>
				</div>
			</div>
		</div>
	</header>    
	<div class="container" id="menu_1" style="z-index: 1">
		<div class="row">
			<div class="col-md-12">
				<nav>
					<ul class="list-inline main_menu" id="menu">
						<li class="active">
							<i class="fa fa-caret-down fa-fw hover_arrow"></i>
							<a href="/angebot/PKW/sonstige/motorsteuergeraet-reparatur">Motor-Steuerger&auml;t</a>
						</li>
						<li>
							<i class="fa fa-caret-down fa-fw hover_arrow"></i>
							<a href="/angebot/PKW/sonstige/abs-esp-dsc-steuergeraet-reparatur">ABS-Steuerger&auml;t</a>
						</li>
						<li>
							<i class="fa fa-caret-down fa-fw hover_arrow"></i>
							<a href="#!">Fahrzeuge<i class="fa fa-caret-down fa-fw"></i></a>
							<ul class="list-unstyled">
								<li><a href="/pkw">PKW</a></li>
								<li><a href="/lkw">LKW</a></li>
								<li><a href="/motorrad">Motorräder</a></li>
								<li><a href="/bus">Omnibusse</a></li>
								<li><a href="/landmaschine">Landmaschinen</a></li>
								<li><a href="/baumaschine">Baumaschinen</a></li>
								<li><a href="/schiff">Motorboote</a></li>
								<li><a href="/wohnmobil">Heizung</a></li>
							</ul>
						</li>
						<li>
							<i class="fa fa-caret-down fa-fw hover_arrow"></i>
							<a href="/anleitung" class="btn btn-danger btn-lg rounded-0 text-white">Reparaturservice</a>
						</li>
						<li>
							<button type="button" class="btn btn-secondary btn-lg rounded-0 text-white" onclick="$('#searchbar').slideToggle('slow')"><i class="fa fa-search"> </i></button>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>
<div id="searchbar" class="mt-3" style="display: none;width: 100%">
	<div class="container">
		<div class="row">
			<div class="col">
				<form action="/suchen" method="get" autocomplete="off">
					<div class="row bg-white border rounded mx-1 py-2 shadow">
						<div class="col-sm-11 px-2">
							<input type="text" id="searchword" name="searchword" value="<?php echo isset($_SESSION['searchword']) ? $_SESSION['searchword'] : ""; ?>" class="form-control form-control-lg" placeholder="Suchbegriff" aria-label="Suchbegriff" aria-describedby="search">
						</div>
						<div class="col-sm-1 px-2">
							<button type="submit" id="search" name="search" value="suchen" class="btn btn-lg btn-secondary" onclick="if($('#searchword').val() == ''){alert('Bitte Suchbegriff eingeben!');return false;}">Suche</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>