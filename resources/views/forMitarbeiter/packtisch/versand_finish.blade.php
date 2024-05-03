<html lang="de"><head><title>CRM P+</title>
    <title>ORDERGO-CRM - Packtisch</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="ORDERGO-CRM, Verwaltungssystem!">
    <meta name="Keywords" content="ORDERGO, CRM, Verwaltungssystem, Administration, Konfiguration, Versand">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,500" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/admin.bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/admin_style.css">
    <script src="/js/jquery-1.11.2-jquery.min.js"></script>
    <script src="/js/admin_script.js"></script><link rel="stylesheet" href="/includes/jquery-ui/themes/base/jquery-ui.css">
    <script src="/includes/jquery-ui/jquery-ui.js"></script>
    <script src="/js/popper.min.js"></script>
    <link href="/includes/summernote/summernote-bs4.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/includes/summernote/codemirror.min.css">
    <link rel="stylesheet" href="/includes/summernote/theme/blackboard.min.css">
    <link rel="stylesheet" href="/includes/summernote/theme/monokai.min.css">
    <style>
        input[type="checkbox"], input[type="radio"] {
            margin-top: .3rem;
            margin-left: -1.25rem;
        }
    
    #mouse_info {
        transition: all 0.5s ease_in-out;
        box-shadow: 0 0 10px 5px rgba(255,0,0,0.8);
        animation: cursorAnim 0.5s;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
    }
    
    @keyframes cursorAnim {
        0% {
            transform: scale(1);
            box-shadow: 0 0 10px 5px rgba(0,0,0,0.8);
        }
        25% {
            transform: scale(2);
            box-shadow: 0 0 20px 15px rgba(0,0,0,0.8);
        }
        50% {
            transform: scale(2.6);
            box-shadow: 0 0 10px 10px rgba(0,0,0,0.8);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 6px 2px rgba(0,0,0,0.8);
        }
    }
    </style><style>
    /! `Custom` Bootstrap 4 theme */@import url(https://fonts.googleapis.com/css?family=Segoe+UI:200,300,400,700);/!
     * Bootstrap v4.5.0 (https://getbootstrap.com/)
     * Copyright 2011-2020 The Bootstrap Authors
     * Copyright 2011-2020 Twitter, Inc.
     * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
    </style></head>
    <body>
    <div id="header" class="bg-white border-bottom border-primary mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <nav class="navbar navbar-expand-lg navbar-white p-0">
                        <a href="#" onclick="toggleFullscreen()"><img src="/uploads/company/1/img/logo_backend.png" alt="Logo" style="width: 32px;margin: 2px"></a>					<a href="/crm/neue-auftraege" title="Auftragsübersicht" style="font-size: 1rem" class="navbar-brand extra-hover text-primary p-0">Aufträge</a>
    <a href="/crm/neue-packtische" title="Packtischübersicht" style="font-size: 1rem" class="navbar-brand extra-link text-primary p-0">Packtisch</a>
                        <button type="button" style="padding: 0 4px" class="navbar-toggler bg-primary rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="navbar_1" class="navbar-collapse collapse justify-content-end">
                            <ul id="menu-1" class="navbar-nav mr-0">
                                <li class="nav-item"><span class="nav-link text-dark pr-0">Willkommen, GZA MOTORS - </span></li>
                                <li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-primary">Masterpacktisch</a></li>
                            </ul>
                            <span class="text-dark">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                            <ul id="menu-1" class="navbar-nav mr-0">
                                    <li class="nav-item dropdown">
            <a href="#" title="Admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Admin</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/index" title="Startseite" class="dropdown-item">Start</a></li>
                <li class="nav-item"><a href="/crm/styles" title="Styles" class="dropdown-item">Styles</a></li>
                <li class="nav-item"><a href="/crm/zeiterfassung" title="Zeiterfassung" class="dropdown-item">Zeiterfassung</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" title="Einstellungen" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Einstellungen</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/lagerplaetze" title="Lagerplätze" class="dropdown-item">Lagerplätze</a></li>
                <li class="nav-item"><a href="/crm/lagerplatzuebersicht" title="Lagerplatzübersicht" class="dropdown-item">Lagerplatzübersicht</a></li>
                <li class="nav-item"><a href="/crm/globale-suche" title="Globale suche" class="dropdown-item">Globale suche</a></li>
                <li class="nav-item"><a href="/crm/globale-einkaeufe-suche" title="Globale Einkäufe suche" class="dropdown-item">Globale Einkäufe suche</a></li>
                <li class="nav-item"><a href="/crm/globale-packtische-suche" title="Globale Packtische suche" class="dropdown-item">Globale Packtische suche</a></li>
            </ul>
        </li>
                                <li class="nav-item"><a href="/crm/abmelden" title="Abmelden" class="nav-link text-primary py-1">Abmelden <sup id="autologout"></sup></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container-fluid">
                    <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="/crm/neue-packtische" class="nav-link btn-lg active">Aktiv</a>
                </li>
                <li class="nav-item">
                    <a href="/crm/packtische-archiv" class="nav-link btn-lg">Archiv</a>
                </li>
                <li class="nav-item">
                    <a href="/crm/lagerplatzuebersicht" class="nav-link btn-lg">Lagerplatzübersicht</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-5 text-right">
            <form action="/crm/neue-packtische" method="post">
                <div class="btn-group btn-group-lg">
                    <input type="text" name="searchword" value="" class="form-control form-control-lg border border-success text-success" style="border-radius: .25rem 0 0 .25rem" placeholder="Suchbegriff / Barcode">
                    <button type="submit" name="search" value="suchen" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
                    <button type="submit" name="set_search_defaults" value="OK" class="btn btn-primary"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('.my-dropdown-menu').slideToggle(0)" onfocus="this.blur()">Filter</button>
                </div>
                <div class="my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3" style="position: absolute;top: 50px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000">
                    <h6 class="text-left">Einträge&nbsp;pro&nbsp;Seite</h6>
                    <select id="rows" name="rows" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="60">60</option>
                        <option value="80">80</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="400">400</option>
                        <option value="500" selected="selected">500</option>
                    </select>
                    <h6 class="text-left mt-2">Sortierrichtung</h6>
                    <select id="sorting_direction" name="sorting_direction" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                        <option value="0" selected="selected">Aufsteigend</option>
                        <option value="1">Absteigend</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-7">
            <h3>Packtisch</h3>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right">
            &nbsp;
        </div>
    </div>
    <script>var devices = ['63125-12-AT-1', 'BPZ-MSG', 'BPZ-HIN', 'GUMMI', 'VP-SI'];</script>
    <hr>
    <div class="row">
        <div class="col">
            <div class="card bg-white text-body">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mt-1 mb-0">Bitte das/die Gerät/e verpacken</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <form action="/crm/neue-packtische" method="post">
                                <input type="hidden" name="id" value="518">
                                <input type="hidden" name="order_id" value="5051">
                                <div class="btn-group">
                                    <button type="submit" name="packing_delete" value="entfernen" class="btn btn-danger" onclick="return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')">entfernen <i class="fa fa-ban" aria-hidden="true"></i></button>&nbsp;
                                    <button type="submit" name="error" value="melden" class="btn btn-warning">melden <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>&nbsp;
                                    <button type="submit" name="packing_close" value="schliessen" class="btn btn-secondary">schliessen <i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-3 pb-0">
    <div class="row"><div class="col-sm-6 text-center">					<div class="form-group row">
                            <div class="col-12 text-center">
                                <h2 class="text-success">
                                     Versandschein wird gedruckt ...
                                </h2>
                            </div>
                        </div>
    <button type="button" class="btn btn-lg btn-success" onclick="if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame').print();}else{document.getElementById('label_frame').contentWindow.print();}">Versandschein nachdrucken <i class="fa fa-print"> </i></button> 
    <iframe src="{{url("/")}}/temp/{{$process_id}}.png" id="label_frame" width="30" height="20" style="visibility: hidden"></iframe><br><br>
    <script>
    var labelWindow = document.getElementById('label_frame');
    setTimeout(function(){
        if(navigator.appName == 'Microsoft Internet Explorer'){
            labelWindow.print();
        }else{
            labelWindow.contentWindow.print();
        }
    }, 2000);
    </script>
    </div></div>
                    <form action="/crm/neue-packtische" method="post">
                        <div class="row">
                            <div class="col-6 border-right">
                                <div id="emsg"></div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" id="item" name="item" value="" class="form-control form-control-lg mt-1" placeholder="|||||||| Artikel" onkeypress="
                    if(event.keyCode == '13'){
                        if(document.getElementById('device_' + document.getElementById('item').value)){
                            $('#check_' + document.getElementById('item').value).removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                            document.getElementById('device_' + document.getElementById('item').value).checked=true;
                            document.getElementById('item').value='';
                            var check=true;
                            for(let i = 0;i < devices.length;i++){
                                if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                            }
                        }else{
                            document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                            $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                        }
                        if(check==true){
                            $('#packing_button').removeClass('d-none');
                        }else{
                            $('#packing_button').addClass('d-none');
                        }
                        return false;
                    }">
                                    </div>
                                    <div class="col-sm-6">
                                        <iframe src="/uploads/company/1/attachments/ALL_Hinweis.pdf" id="file1_frame" width="30" height="40" style="visibility: hidden"></iframe>
                                        <iframe src="/uploads/company/1/attachments/BPZ_Motor-Steuergerät.pdf" id="file2_frame" width="30" height="40" style="visibility: hidden"></iframe>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <small>Positionen des Auftrags</small><br>
                                        <table class="table table-white no-table-sm table-borderless table-hover border-bottom mb-0">
                                            <thead><tr class="bg-white text-primary border-bottom">
                                                <th scope="col" width="160"><h5 class="font-weight-bold mb-0">ArtNr.</h5></th>
                                                <th scope="col" width="120"><h5 class="font-weight-bold mb-0">Lagerplatz</h5></th>
                                                <th scope="col"><h5 class="font-weight-bold mb-0">Artikelname</h5></th>
                                                <th scope="col" width="40" class="text-center"><h5 class="font-weight-bold mb-0">Gescannt</h5></th>
                                            </tr></thead>
        <tbody><tr>
            <td><a href="Javascript: void(0)" no-ondblclick="
                                if(document.getElementById('device_63125-12-AT-1')){
                                    $('#check_63125-12-AT-1').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                                    document.getElementById('device_63125-12-AT-1').checked=true;
                                    var check=true;
                                    for(let i = 0;i < devices.length;i++){
                                        if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                                    }
                                }else{
                                    $('#check_63125-12-AT-1').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
                                    document.getElementById('device_63125-12-AT-1').checked=false;
                                    document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                                    $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                                }
                                if(check==true){
                                    $('#packing_button').removeClass('d-none');
                                }else{
                                    $('#packing_button').addClass('d-none');
                                }">63125-12-AT-1</a></td>
            <td></td>
            <td>-</td>
            <td align="center"><div class="custom-control custom-checkbox pl-0"><h4 class="mb-0"><i id="check_63125-12-AT-1" class="fa fa-plus-square text-danger"> </i></h4><div class="d-none"><input type="checkbox" id="device_63125-12-AT-1" name="device_63125-12-AT-1" value="1" class="custom-control-input"><label for="device_63125-12-AT-1" class="custom-control-label"></label></div></div></td>
        </tr>
                                            <tr>
                                                <td><a href="Javascript: void(0)" no-ondblclick="
                        if(document.getElementById('device_BPZ-MSG')){
                            $('#check_BPZ-MSG').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                            document.getElementById('device_BPZ-MSG').checked=true;
                            var check=true;
                            for(let i = 0;i < devices.length;i++){
                                if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                            }
                        }else{
                            $('#check_BPZ-MSG').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
                            document.getElementById('device_BPZ-MSG').checked=false;
                            document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                            $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                        }
                        if(check==true){
                            $('#packing_button').removeClass('d-none');
                        }else{
                            $('#packing_button').addClass('d-none');
                        }">BPZ-MSG</a></td>
                                                <td align="center">&nbsp;</td>
                                                <td><a href="Javascript: void(0)" class="btn btn-success btn-sm" onclick="
                    if(navigator.appName == 'Microsoft Internet Explorer'){
                        document.getElementById('file1_frame').print();
                    }else{
                        document.getElementById('file1_frame').contentWindow.print();
                    }"><i class="fa fa-print" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="/uploads/company/1/attachments/ALL_Hinweis.pdf" target="_blank">ALL Hinweis <i class="fa fa-external-link"> </i></a></td>
                                                <td align="center"><div class="custom-control custom-checkbox pl-0"><h4 class="mb-0"><i id="check_BPZ-MSG" class="fa fa-plus-square text-danger"> </i></h4><div class="d-none"><input type="checkbox" id="device_BPZ-MSG" name="device_BPZ-MSG" value="17" class="custom-control-input"><label for="device_BPZ-MSG" class="custom-control-label"></label></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><a href="Javascript: void(0)" no-ondblclick="
                        if(document.getElementById('device_BPZ-HIN')){
                            $('#check_BPZ-HIN').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                            document.getElementById('device_BPZ-HIN').checked=true;
                            var check=true;
                            for(let i = 0;i < devices.length;i++){
                                if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                            }
                        }else{
                            $('#check_BPZ-HIN').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
                            document.getElementById('device_BPZ-HIN').checked=false;
                            document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                            $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                        }
                        if(check==true){
                            $('#packing_button').removeClass('d-none');
                        }else{
                            $('#packing_button').addClass('d-none');
                        }">BPZ-HIN</a></td>
                                                <td align="center">&nbsp;</td>
                                                <td><a href="Javascript: void(0)" class="btn btn-success btn-sm" onclick="
                    if(navigator.appName == 'Microsoft Internet Explorer'){
                        document.getElementById('file2_frame').print();
                    }else{
                        document.getElementById('file2_frame').contentWindow.print();
                    }"><i class="fa fa-print" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="/uploads/company/1/attachments/BPZ_Motor-Steuergerät.pdf" target="_blank">BPZ Motor-Steuergerät <i class="fa fa-external-link"> </i></a></td>
                                                <td align="center"><div class="custom-control custom-checkbox pl-0"><h4 class="mb-0"><i id="check_BPZ-HIN" class="fa fa-plus-square text-danger"> </i></h4><div class="d-none"><input type="checkbox" id="device_BPZ-HIN" name="device_BPZ-HIN" value="9" class="custom-control-input"><label for="device_BPZ-HIN" class="custom-control-label"></label></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><a href="Javascript: void(0)" no-ondblclick="
                                                if(document.getElementById('device_GUMMI')){
                                                    $('#check_GUMMI').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                                                    document.getElementById('device_GUMMI').checked=true;
                                                    var check=true;
                                                    for(let i = 0;i < devices.length;i++){
                                                        if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                                                    }
                                                }else{
                                                    $('#check_GUMMI').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
                                                    document.getElementById('device_GUMMI').checked=false;
                                                    document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                                                    $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                                                }
                                                if(check==true){
                                                    $('#packing_button').removeClass('d-none');
                                                }else{
                                                    $('#packing_button').addClass('d-none');
                                                }">GUMMI</a></td>
                                                <td>&nbsp;</td>
                                                <td>Gummibärchen</td>
                                                <td align="center"><div class="custom-control custom-checkbox pl-0"><h4 class="mb-0"><i id="check_GUMMI" class="fa fa-plus-square text-danger"> </i></h4><div class="d-none"><input type="checkbox" id="device_GUMMI" name="device_GUMMI" value="1" class="custom-control-input"><label for="device_GUMMI" class="custom-control-label"></label></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><a href="Javascript: void(0)" no-ondblclick="
                                                if(document.getElementById('device_VP-SI')){
                                                    $('#check_VP-SI').removeClass('fa-plus-square text-danger').addClass('fa-check-square-o text-success');
                                                    document.getElementById('device_VP-SI').checked=true;
                                                    var check=true;
                                                    for(let i = 0;i < devices.length;i++){
                                                        if(document.getElementById('device_' + devices[i]).checked==false){check=false;}
                                                    }
                                                }else{
                                                    $('#check_VP-SI').removeClass('fa-check-square-o text-success').addClass('fa-plus-square text-danger');
                                                    document.getElementById('device_VP-SI').checked=false;
                                                    document.getElementById('emsg').innerHTML='<div class=\'alert alert-danger alert-dismissible fade show\' role=\'alert\'>Der Artikel wurde nicht gefunden! <button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>×</span></button></div>';
                                                    $('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function(){$('.alert-dismissible').alert('close');});
                                                }
                                                if(check==true){
                                                    $('#packing_button').removeClass('d-none');
                                                }else{
                                                    $('#packing_button').addClass('d-none');
                                                }">VP-SI</a></td>
                                                <td>&nbsp;</td>
                                                <td>Versiegeln</td>
                                                <td align="center"><div class="custom-control custom-checkbox pl-0"><h4 class="mb-0"><i id="check_VP-SI" class="fa fa-plus-square text-danger"> </i></h4><div class="d-none"><input type="checkbox" id="device_VP-SI" name="device_VP-SI" value="1" class="custom-control-input"><label for="device_VP-SI" class="custom-control-label"></label></div></div></td>
                                            </tr>
                                        </tbody></table>
                                    </div>
                                </div>
                                <div class="form-group row mt-5">
                                    <div class="col-sm-12 text-center">
                                        <h1 class="text-success">
                                            <div class="spinner-grow text-success mb-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            Das Paket wurde schon versendet!
                                        </h1>
                                        <iframe src="/sendung/label/1/1ZA285F86894430184" id="label" width="30" height="40" style="visibility: hidden"></iframe>
                                        <a href="Javascript: void(0)" class="btn btn-success btn-sm" onclick="
                        if(navigator.appName == 'Microsoft Internet Explorer'){
                            document.getElementById('label').print();
                        }else{
                            document.getElementById('label').contentWindow.print();
                        }"><i class="fa fa-print" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="{{url("/")}}/temp/{{$process_id}}.png" class="text-success" target="_blank">Versandschein nachdrucken</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                        <iframe src="/crm/tech-info-pdf/5051" id="files_frame_5051" width="30" height="40" style="visibility: hidden"></iframe>
                            </div>
                        </div>
                        <div class="row px-0 card-footer">
                            <div class="col-sm-12 text-right">
                                &nbsp;
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-white border-top border-primary fixed-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-xs-12 text-right">
                    <p class="copyright text-dark m-0">Copyright © 2022 <span><a href="/index" class="text-primary">Verwaltungssystem</a></span> All Right Of Reserved</p>
                </div>
            </div>
        </div>
    </footer><script src="/js/bootstrap-switch.js"></script>
    <script>
    var bootstrap_switches = '.bootstrap-switch';$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');
    $(bootstrap_switches).bootstrapSwitch({
        on: 'Ja',
        off: 'Nein ',
        onLabel: 'ja',
        offLabel: 'nein',
        same: true,
        size: 'sm',
        onClass: 'success',
        offClass: 'danger'
    });
    var bootstrap_switches = '.bootstrap-switch-access';$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');
    $(bootstrap_switches).bootstrapSwitch({
        on: 'Zugriff erlauben',
        off: 'Zugriff nicht erlauben',
        onLabel: 'ja',
        offLabel: 'nein',
        same: true,
        size: 'sm',
        onClass: 'success',
        offClass: 'danger'
    });
    var bootstrap_switches = '.bootstrap-switch-access-yes-no';$(bootstrap_switches).parent().addClass('pl-0').find('label').addClass('d-none');
    $(bootstrap_switches).bootstrapSwitch({
        on: 'Ja',
        off: 'Nein',
        onLabel: 'ja',
        offLabel: 'nein',
        same: true,
        size: 'lg',
        onClass: 'success',
        offClass: 'danger'
    });
    </script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    $(function(){
    
        $('body')
            .append('<div id="mouse_info" class="position-absolute d-none bg-white border border-primary rounded text-center px-2 pt-2 pb-0" style="opacity: 0.65"></div>')
            .mousemove(function(event){
                $('#mouse_info').css({'left': (parseInt(event.pageX) + 20) + 'px', 'top': (parseInt(event.pageY) - 20) + 'px'});
            });
    
        $('#order_sel_all_top, #order_sel_all_bottom, .packings_menu').on('click', function(){
            var countCkecked = 0;
            $('.order-list').each(function(){
                if($(this).prop('checked')){
                    countCkecked++;
                }
            });
            if(countCkecked > 1){
                $('#mouse_info').removeClass('d-none').html('<h3 class="text-primary">' + countCkecked + '<\/h3>');
            }else{
                $('#mouse_info').addClass('d-none');
            }
        });
    
        $('#datepicker, #call_date, #recall_date, #intern_datepicker').datepicker({
            prevText: '&#x3c;zurück', prevStatus: '',
            prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
            nextText: 'Vor&#x3e;', nextStatus: '',
            nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
            currentText: 'heute', currentStatus: '',
            todayText: 'heute', todayStatus: '',
            clearText: '-', clearStatus: '',
            closeText: 'schließen', closeStatus: '',
            monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
            dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            showMonthAfterYear: false,
            /showOn: 'both',/
            buttonImage: 'media/img/calendar.png',
            buttonImageOnly: true,
            dateFormat:'dd.mm.yy'
        });
        $.datepicker.setDefaults($.datepicker.regional["de"]);
    });
    </script>
    <script type="text/javascript" src="/includes/summernote/codemirror.js"></script>
    <script src="/includes/summernote/mode/xml/xml.min.js"></script>
    <script type="text/javascript" src="/includes/summernote/formatting.js"></script>
    <script src="/includes/summernote/summernote-bs4.js"></script>
    <script>
    $(document).ready(function() {
        $('#edit_content').summernote({
            height: 300,
            dialogsInBody: false,
            codemirror: {
                mode: 'text/html',
                htmlMode: true,
                lineNumbers: true,
                theme: 'monokai'
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['fontname', 'fontsize', 'color', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
            ],
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
                link: [
                    ['link', ['linkDialogShow', 'unlink']]
                ],
                table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                ],
                airMode: false,
                air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                ]
            }
        });
    });
    </script>
    <script src="/js/admin.js"></script><script>
    $(document).ready(function(){
        //autologout_interval = window.setInterval(function (){setAutologout();}, 1000);
    });
    
    /*$('.card-maximize')
        .css({
            'top': 0, 
            'left': 0, 
            'width': '100%', 
            'max-height': '100%', 
            'overflow-x': 'auto'
        })
        .find('.card-header')
        .addClass('pr-3')
        .find('h4')
        .append('<div class="float-right text-primary bg-white border border-primary rounded expand mr-0 text-center" style="font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer"><i class="fa fa-arrows-alt" aria-hidden="true"></i></div>')
        .on('click', '.expand', function(){
            if(this.parentElement.parentElement.parentElement.style.position=='static'||this.parentElement.parentElement.parentElement.style.position==''){
                $(this).parent().parent().parent().css({'position': 'fixed', 'z-index': '999'}).find('.card-body').removeClass('pb-0').addClass('pb-5');
            }else{
                $(this).parent().parent().parent().css({'position': 'static', 'z-index': '1'}).find('.card-body').removeClass('pb-5').addClass('pb-0');
            }
        });*/
    
    /*$('.expand')
        .hover(
            function() {
                $(this).removeClass('text-primary bg-white').addClass('text-white bg-primary');
            }, function() {
                $(this).removeClass('text-white bg-primary').addClass('text-primary bg-white');
            }
        );*/
    
    /*$('.card-minimize')
        .find('.card-header')
        .addClass('pr-3')
        .find('h4')
        .append('<div class="float-right text-primary bg-white border border-primary rounded card-collapse mr-0 text-center" style="font-size: 1.4rem;width: 2.0rem;height: 1.9rem;cursor: pointer"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></div>')
        .on('click', '.card-collapse', function(){
            $(this).parent().parent().parent().find('.card-body').slideToggle('slow');
        });*/
    
    /*$('.card-collapse')
        .hover(
            function() {
                $(this).removeClass('text-primary bg-white').addClass('text-white bg-primary');
            }, function() {
                $(this).removeClass('text-white bg-primary').addClass('text-primary bg-white');
            }
        );*/
    
    /* Set marquee to userinfo */
    //$('#user_info').html('<marquee behavior="alternate">' + $('#user_info').html() + '</marquee>').addClass('w-75');
    
    /* Scroll-Top-Button */
    /*$(document).ready(function(){
        var back_to_top_button = ['<a href="#top" class="back-to-top btn btn-primary border border-white p-1" style="position: fixed;bottom: 2px;left: 6px;border-radius: 50%;box-shadow: 0 0 4px rgba(0,0,0,.8);line-height: 6px;z-Index: 1001"><i class="fa fa-arrow-up" style="font-size: 10px"> </i></a>'].join("");
        $("body").append(back_to_top_button);
    
        $(".back-to-top").hide();
    
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });
    
        $('.back-to-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    
    });*/
    
    $(document).ready(function(){
        var todayRecalls = 0;
        var listRecalls = '';
        var order_areas = ['neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv'];
        for (var i = 0; i < dates.length; i++) {
            if (dates[i]['today'] === true) {
                listRecalls += '<tr><td><a href="/crm/' + order_areas[dates[i]['mode']] + '/bearbeiten/' + dates[i]['id'] + '">' + dates[i]['date'].replace(" ", " - ") + ' Uhr</a></td><td><a href="/crm/' + order_areas[dates[i]['mode']] + '/bearbeiten/' + dates[i]['id'] + '" class="btn btn-sm btn-primary">öffnen</a></td></tr>';
                todayRecalls++;
            }
        }
        $('#navbar_1').after($('<div onclick="$(\'.recalls-dropdown-menu\').slideToggle(0)" onfocus="this.blur()" style="cursor: pointer" onmouseover="$(\'.stack_bell.fa.fa-circle.fa-stack-2x\').toggleClass(\'text-primary text-secondary\')" onmouseout="$(\'.stack_bell.fa.fa-circle.fa-stack-2x\').toggleClass(\'text-primary text-secondary\')"><span class="fa-stack fa-3x' + (todayRecalls == 0 ? ' normal' : ' active') + '" data-count="' + todayRecalls + '"><i class="stack_bell fa fa-circle fa-stack-2x text-primary"></i><i class="stack_bell fa fa-bell fa-stack-1x fa-inverse"></i></span></div><div class="recalls-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 260px;width: 300px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000"><h4 class="font-weight-bold"><u>Heutige Rückrufe</u>:</h4><table style="width: 260px">' + listRecalls + '</table></div>'));
    });
    </script>
    <style>
    .fa-stack {font-size: 1.1em;}
    .stack {vertical-align: middle;}
    .fa-stack[data-count]:after {
      position: absolute;
      right: -10px;
      top: 1%;
      content: attr(data-count);
      font-size: 0.5em;
      padding: .6em;
      border-radius: 100%;
      line-height: .75em;
      color: white;
      text-align: center;
      min-width: 2em;
      font-weight: bold;
    }
    .fa-stack[data-count].normal:after {
      background-color: var(--danger);
    }
    .fa-stack[data-count].active:after {
      background-color: var(--success);
    }
    </style>
    <script>
    /*var alert_date = "03/28";
    var alert_text = "Sie müssen unter 'Einstellungen/Grunddaten/Systemdaten/Temporäre Dateien' die 'Temporäre Dateien' entfernen!";
    var alert_d = new Date();
    var alert_today = new Date();
    var alert_dd = alert_today.getDate();
    var alert_mm = alert_today.getMonth()+1; 
    var alert_yyyy = alert_today.getFullYear();
    
    if(alert_dd<10){
        alert_dd = '0'+alert_dd;
    } 
    
    if(alert_mm<10){
        alert_mm = '0'+alert_mm;
    } 
    
    alert_today = alert_mm + '/' + alert_dd;
    if(alert_today == alert_date){
        location.href = '/crm/grunddaten#v-pills-systemdata';
    }*/
    </script>
    <script>
    window.onload = ToDoInit;
    function ToDoInit(){
        var button = document.getElementById('todo_new');
        button.onclick = ToDoAdd;
        var clearButton = document.getElementById('todo_delete_all');
        clearButton.onclick = ToDoDeleteAll;
        var entriesArray = ToDoGetEntries();
        for(var i = 0;i < entriesArray.length; i++){
            var nr = entriesArray[i];
            var value = JSON.parse(localStorage[nr]);
            ToDoAddToDOM(nr, value);
        }	
    }
    function ToDoGetEntries(){
        var entriesArray = localStorage.getItem('entriesArray');
        if(!entriesArray){
            entriesArray = [];
            localStorage.setItem('entriesArray', JSON.stringify(entriesArray));
        }else{
            entriesArray = JSON.parse(entriesArray);
        }
        return entriesArray;
    }
    function ToDoAdd(){
        var entriesArray = ToDoGetEntries();
        var notes = document.getElementById('todo_input').value;
        if(notes != ''){
            var currentDate = new Date();
            var nr = 'todo_note_' + currentDate.getTime()	
            localStorage.setItem(nr, JSON.stringify(notes));	
            entriesArray.push(nr);
            localStorage.setItem('entriesArray', JSON.stringify(entriesArray));
            ToDoAddToDOM(nr, notes);
            document.getElementById('todo_input').value = '';
            $('.stack_edit_count').attr('data-count', ToDoGetEntries().length).removeClass('normal active').addClass((ToDoGetEntries().length == 0 ? 'normal' : 'active'));
        }else{
            alert('Bitte geben Sie eine Notiz ein!');
        }
    }
    function ToDoDelete(e){
        var nr = e.target.id;
        var entriesArray = ToDoGetEntries();
        if(entriesArray){
            for(var i = 0;i < entriesArray.length;i++){
                if(nr == entriesArray[i]){
                    entriesArray.splice(i, 1);
                }
            }
            localStorage.removeItem(nr);
            localStorage.setItem('entriesArray', JSON.stringify(entriesArray));
            ToDoDeleteFromDOM(nr);
        }
        $('.stack_edit_count').attr('data-count', ToDoGetEntries().length).removeClass('normal active').addClass((ToDoGetEntries().length == 0 ? 'normal' : 'active'));
    }
    function ToDoDeleteAll() {
        localStorage.clear();
        var items = document.getElementById('todo_entries');
        var entries = items.childNodes;
        for(var i = entries.length - 1;i >= 0;i--){
            items.removeChild(entries[i]);
        }
        var entriesArray = ToDoGetEntries();
        $('.stack_edit_count').attr('data-count', 0).removeClass('normal active').addClass('normal');
    }
    function ToDoAddToDOM(nr, text) {
        var entries = document.getElementById('todo_entries');
        var entry = document.createElement('li');
        entry.setAttribute('id', nr);
        entry.className = 'todo_entry mb-2';
        entry.style.cursor = 'pointer';
        entry.innerHTML = text;
        entries.appendChild(entry);
        entry.onclick = ToDoDelete;
    }
    function ToDoDeleteFromDOM(nr){
        var entry = document.getElementById(nr);
        entry.parentNode.removeChild(entry);
    }
    $(document).ready(function(){
        var todayNotes = ToDoGetEntries().length;
        $('#navbar_1').after($('<div style="cursor: pointer" class="mr-2" onclick="$(\'.notes-dropdown-menu\').slideToggle(0)" onfocus="this.blur()" onmouseover="$(\'.stack_edit.fa.fa-circle.fa-stack-2x\').toggleClass(\'text-primary text-secondary\')" onmouseout="$(\'.stack_edit.fa.fa-circle.fa-stack-2x\').toggleClass(\'text-primary text-secondary\')"><span class="stack_edit_count fa-stack fa-3x' + (todayNotes == 0 ? ' normal' : ' active') + '" data-count="' + todayNotes + '"><i class="stack_edit fa fa-circle fa-stack-2x text-primary"></i><i class="stack_edit fa fa-edit fa-stack-1x fa-inverse"></i></span></div><div class="notes-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 360px;width: 800px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000"><h4 class="font-weight-bold"><u>Eigene Notizen</u>:</h4><div class="row"><div class="col-sm-6"><ol id="todo_entries" class="p-3"></ol></div><div class="col-sm-6"><label for="todo_input">Neue Notiz: </label><br /><input type="text" id="todo_input" value="" class="form-control mb-3"> <button id="todo_new" class="btn btn-primary">hinzufügen</button> <button id="todo_delete_all" class="btn btn-primary">Alle Notizen löschen</button></div></div></div>'));
    });
    </script>
    <style>
    .todo_entry {
        color: var(--primary);
    }
    .todo_entry:hover {
        color: var(--danger);
    }
    </style>
    <div id="mouse_info" class="position-absolute d-none bg-white border border-primary rounded text-center px-2 pt-2 pb-0" style="opacity: 0.65; left: 1239px; top: 201px;"></div><div class="modal fade" id="showStatussesDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-xl" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> DETAILS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_iframe" src="/crm/blank" width="100%" height="480" class="border"></iframe>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal_xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-xl" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">TITLE</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_xl_iframe" src="/crm/blank" width="100%" height="740" class="border"></iframe>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_iframe2" src="/crm/blank" width="100%" height="1000" class="border"></iframe>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-success" onclick="if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframeModal_iframe2').print();}else{document.getElementById('iframeModal_iframe2').contentWindow.print();}">drucken <i class="fa fa-print" aria-hidden="true"></i></button> <button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-dialog-centered" role="document">		<div class="modal-content">			<div class="modal-body">				<br><br><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Loading...</h1></div></div><br><br>			</div>		</div>	</div></div><div class="modal fade" id="autologoutModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-dialog-centered" role="document">		<div class="modal-content">			<div class="modal-body">				<br><br><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Automatisches abmelden in <span id="autologout2">59</span> Sekunden</h1>Wollen Sie dies abbrechen?</div></div><br><br>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.clearInterval(autologout2_interval);autologout_interval = window.setInterval(function (){setAutologout();}, 1000);">abbrechen</button>			</div>		</div>	</div></div></body></html>