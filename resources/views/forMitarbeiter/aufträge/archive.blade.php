<html lang="de"><head><title>CRM P+</title>
    <title>ORDERGO-CRM - Auftragsarchiv</title>
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
    </style><!-- style>
    /*! `Tequila` Bootstrap 4 theme */@import url(https://fonts.googleapis.com/css?family=Segoe+UI:200,300,400,700);@import url(https://fonts.googleapis.com/css?family=Voltaire:200,300,400,700);/*!
     * Bootstrap v4.5.0 (https://getbootstrap.com/)
     * Copyright 2011-2020 The Bootstrap Authors
     * Copyright 2011-2020 Twitter, Inc.
     * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
     */:root{--blue: #007bff;--indigo: #6610f2;--purple: #6f42c1;--pink: #e83e8c;--red: #dc3545;--orange: #fd7e14;--yellow: #ffc107;--green: #28a745;--teal: #20c997;--cyan: #17a2b8;--white: #fff;--gray: #6c757d;--gray-dark: #343a40;--primary: #2F414A;--secondary: #F47B53;--success: #420084;--info: #7ebcfa;--warning: #f93;--danger: #f2460d;--light: #eef0f2;--dark: #000633;--breakpoint-xs: 0;--breakpoint-sm: 576px;--breakpoint-md: 768px;--breakpoint-lg: 992px;--breakpoint-xl: 1200px;--font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";--font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}*,*::before,*::after{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0,0,0,0)}article,aside,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}body{margin:0;font-family:Segoe UI;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}[tabindex="-1"]:focus:not(:focus-visible){outline:0 !important}hr{box-sizing:content-box;height:0;overflow:visible}h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}abbr[title],abbr[data-original-title]{text-decoration:underline;text-decoration:underline dotted;cursor:help;border-bottom:0;text-decoration-skip-ink:none}address{margin-bottom:1rem;font-style:normal;line-height:inherit}ol,ul,dl{margin-top:0;margin-bottom:1rem}ol ol,ul ul,ol ul,ul ol{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}blockquote{margin:0 0 1rem}b,strong{font-weight:bolder}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}a{color:#2F414A;text-decoration:none;background-color:transparent}a:hover{color:#11181b;text-decoration:underline}a:not([href]){color:inherit;text-decoration:none}a:not([href]):hover{color:inherit;text-decoration:none}pre,code,kbd,samp{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}figure{margin:0 0 1rem}img{vertical-align:middle;border-style:none}svg{overflow:hidden;vertical-align:middle}table{border-collapse:collapse}caption{padding-top:.75rem;padding-bottom:.75rem;color:#6c757d;text-align:left;caption-side:bottom}th{text-align:inherit}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}input,button,select,optgroup,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}[role="button"]{cursor:pointer}select{word-wrap:normal}button,[type="button"],[type="reset"],[type="submit"]{-webkit-appearance:button}button:not(:disabled),[type="button"]:not(:disabled),[type="reset"]:not(:disabled),[type="submit"]:not(:disabled){cursor:pointer}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner{padding:0;border-style:none}input[type="radio"],input[type="checkbox"]{box-sizing:border-box;padding:0}textarea{overflow:auto;resize:vertical}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}progress{vertical-align:baseline}[type="number"]::-webkit-inner-spin-button,[type="number"]::-webkit-outer-spin-button{height:auto}[type="search"]{outline-offset:-2px;-webkit-appearance:none}[type="search"]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}output{display:inline-block}summary{display:list-item;cursor:pointer}template{display:none}[hidden]{display:none !important}h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{margin-bottom:.5rem;font-family:Voltaire;font-weight:500;line-height:1.2}h1,.h1{font-size:2.5rem}h2,.h2{font-size:2rem}h3,.h3{font-size:1.75rem}h4,.h4{font-size:1.5rem}h5,.h5{font-size:1.25rem}h6,.h6{font-size:1rem}.lead{font-size:1.25rem;font-weight:300}.display-1{font-size:6rem;font-weight:300;line-height:1.2}.display-2{font-size:5.5rem;font-weight:300;line-height:1.2}.display-3{font-size:4.5rem;font-weight:300;line-height:1.2}.display-4{font-size:3.5rem;font-weight:300;line-height:1.2}hr{margin-top:1rem;margin-bottom:1rem;border:0;border-top:1px solid rgba(0,0,0,0.1)}small,.small{font-size:80%;font-weight:400}mark,.mark{padding:.2em;background-color:#fcf8e3}.list-unstyled{padding-left:0;list-style:none}.list-inline{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:.5rem}.initialism{font-size:90%;text-transform:uppercase}.blockquote{margin-bottom:1rem;font-size:1.25rem}.blockquote-footer{display:block;font-size:80%;color:#6c757d}.blockquote-footer::before{content:"\2014\00A0"}.img-fluid{max-width:100%;height:auto}.img-thumbnail{padding:.25rem;background-color:#fff;border:1px solid #dee2e6;border-radius:.25rem;max-width:100%;height:auto}.figure{display:inline-block}.figure-img{margin-bottom:.5rem;line-height:1}.figure-caption{font-size:90%;color:#6c757d}code{font-size:87.5%;color:#e83e8c;word-wrap:break-word}a>code{color:inherit}kbd{padding:.2rem .4rem;font-size:87.5%;color:#fff;background-color:#212529;border-radius:.2rem}kbd kbd{padding:0;font-size:100%;font-weight:700}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.pre-scrollable{max-height:340px;overflow-y:scroll}.table{width:100%;margin-bottom:1rem;color:#212529}.table th,.table td{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table-sm th,.table-sm td{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered th,.table-bordered td{border:1px solid #dee2e6}.table-bordered thead th,.table-bordered thead td{border-bottom-width:2px}.table-borderless th,.table-borderless td,.table-borderless thead th,.table-borderless tbody+tbody{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,0.05)}.table-hover tbody tr:hover{color:#212529;background-color:rgba(0,0,0,0.075)}.table-primary,.table-primary>th,.table-primary>td{background-color:#c5cacc}.table-primary th,.table-primary td,.table-primary thead th,.table-primary tbody+tbody{border-color:#939ca1}.table-hover .table-primary:hover{background-color:#b7bec0}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#b7bec0}.table-secondary,.table-secondary>th,.table-secondary>td{background-color:#fcdacf}.table-secondary th,.table-secondary td,.table-secondary thead th,.table-secondary tbody+tbody{border-color:#f9baa6}.table-hover .table-secondary:hover{background-color:#fbc8b7}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#fbc8b7}.table-success,.table-success>th,.table-success>td{background-color:#cab8dd}.table-success th,.table-success td,.table-success thead th,.table-success tbody+tbody{border-color:#9d7abf}.table-hover .table-success:hover{background-color:#bda7d5}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#bda7d5}.table-info,.table-info>th,.table-info>td{background-color:#dbecfe}.table-info th,.table-info td,.table-info thead th,.table-info tbody+tbody{border-color:#bcdcfc}.table-hover .table-info:hover{background-color:#c2dffd}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#c2dffd}.table-warning,.table-warning>th,.table-warning>td{background-color:#ffe2c6}.table-warning th,.table-warning td,.table-warning thead th,.table-warning tbody+tbody{border-color:#ffca95}.table-hover .table-warning:hover{background-color:#ffd5ad}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffd5ad}.table-danger,.table-danger>th,.table-danger>td{background-color:#fbcbbb}.table-danger th,.table-danger td,.table-danger thead th,.table-danger tbody+tbody{border-color:#f89f81}.table-hover .table-danger:hover{background-color:#fab9a3}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#fab9a3}.table-light,.table-light>th,.table-light>td{background-color:#fafbfb}.table-light th,.table-light td,.table-light thead th,.table-light tbody+tbody{border-color:#f6f7f8}.table-hover .table-light:hover{background-color:#ecf0f0}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ecf0f0}.table-dark,.table-dark>th,.table-dark>td{background-color:#b8b9c6}.table-dark th,.table-dark td,.table-dark thead th,.table-dark tbody+tbody{border-color:#7a7e95}.table-hover .table-dark:hover{background-color:#aaabbb}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#aaabbb}.table-active,.table-active>th,.table-active>td{background-color:rgba(0,0,0,0.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,0.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,0.075)}.table .thead-dark th{color:#fff;background-color:#343a40;border-color:#454d55}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#343a40}.table-dark th,.table-dark td,.table-dark thead th{border-color:#454d55}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,0.05)}.table-dark.table-hover tbody tr:hover{color:#fff;background-color:rgba(255,255,255,0.075)}@media (max-width: 575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-sm>.table-bordered{border:0}}@media (max-width: 767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-md>.table-bordered{border:0}}@media (max-width: 991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-lg>.table-bordered{border:0}}@media (max-width: 1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive>.table-bordered{border:0}.form-control{display:block;width:100%;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out}@media (prefers-reduced-motion: reduce){.form-control{transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057}.form-control:focus{color:#495057;background-color:#fff;border-color:#618598;outline:0;box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.form-control::placeholder{color:#6c757d;opacity:1}.form-control:disabled,.form-control[readonly]{background-color:#e9ecef;opacity:1}input[type="date"].form-control,input[type="time"].form-control,input[type="datetime-local"].form-control,input[type="month"].form-control{appearance:none}select.form-control:focus::-ms-value{color:#495057;background-color:#fff}.form-control-file,.form-control-range{display:block;width:100%}.col-form-label{padding-top:calc(.375rem + 1px);padding-bottom:calc(.375rem + 1px);margin-bottom:0;font-size:inherit;line-height:1.5}.col-form-label-lg{padding-top:calc(.5rem + 1px);padding-bottom:calc(.5rem + 1px);font-size:1.25rem;line-height:1.5}.col-form-label-sm{padding-top:calc(.25rem + 1px);padding-bottom:calc(.25rem + 1px);font-size:.875rem;line-height:1.5}.form-control-plaintext{display:block;width:100%;padding:.375rem 0;margin-bottom:0;font-size:1rem;line-height:1.5;color:#212529;background-color:transparent;border:solid transparent;border-width:1px 0}.form-control-plaintext.form-control-sm,.form-control-plaintext.form-control-lg{padding-right:0;padding-left:0}.form-control-sm{height:calc(1.5em + .5rem + 2px);padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.form-control-lg{height:calc(1.5em + 1rem + 2px);padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}select.form-control[size],select.form-control[multiple]{height:auto}textarea.form-control{height:auto}.form-group{margin-bottom:1rem}.form-text{display:block;margin-top:.25rem}.form-row{display:flex;flex-wrap:wrap;margin-right:-5px;margin-left:-5px}.form-row>.col,.form-row>[class*="col-"]{padding-right:5px;padding-left:5px}.form-check{position:relative;display:block;padding-left:1.25rem}.form-check-input{position:absolute;margin-top:.3rem;margin-left:-1.25rem}.form-check-input[disabled] ~ .form-check-label,.form-check-input:disabled ~ .form-check-label{color:#6c757d}.form-check-label{margin-bottom:0}.form-check-inline{display:inline-flex;align-items:center;padding-left:0;margin-right:.75rem}.form-check-inline .form-check-input{position:static;margin-top:0;margin-right:.3125rem;margin-left:0}.valid-feedback{display:none;width:100%;margin-top:.25rem;font-size:80%;color:#420084}.valid-tooltip{position:absolute;top:100%;z-index:5;display:none;max-width:100%;padding:.25rem .5rem;margin-top:.1rem;font-size:.875rem;line-height:1.5;color:#fff;background-color:rgba(66,0,132,0.9);border-radius:.25rem}.was-validated :valid ~ .valid-feedback,.was-validated :valid ~ .valid-tooltip,.is-valid ~ .valid-feedback,.is-valid ~ .valid-tooltip{display:block}.was-validated .form-control:valid,.form-control.is-valid{border-color:#420084;padding-right:calc(1.5em + .75rem);background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23420084' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right calc(.375em + .1875rem) center;background-size:calc(.75em + .375rem) calc(.75em + .375rem)}.was-validated .form-control:valid:focus,.form-control.is-valid:focus{border-color:#420084;box-shadow:0 0 0 .2rem rgba(66,0,132,0.25)}.was-validated textarea.form-control:valid,textarea.form-control.is-valid{padding-right:calc(1.5em + .75rem);background-position:top calc(.375em + .1875rem) right calc(.375em + .1875rem)}.was-validated .custom-select:valid,.custom-select.is-valid{border-color:#420084;padding-right:calc(.75em + 2.3125rem);background:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px,url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23420084' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") #fff no-repeat center right 1.75rem/calc(.75em + .375rem) calc(.75em + .375rem)}.was-validated .custom-select:valid:focus,.custom-select.is-valid:focus{border-color:#420084;box-shadow:0 0 0 .2rem rgba(66,0,132,0.25)}.was-validated .form-check-input:valid ~ .form-check-label,.form-check-input.is-valid ~ .form-check-label{color:#420084}.was-validated .form-check-input:valid ~ .valid-feedback,.was-validated .form-check-input:valid ~ .valid-tooltip,.form-check-input.is-valid ~ .valid-feedback,.form-check-input.is-valid ~ .valid-tooltip{display:block}.was-validated .custom-control-input:valid ~ .custom-control-label,.custom-control-input.is-valid ~ .custom-control-label{color:#420084}.was-validated .custom-control-input:valid ~ .custom-control-label::before,.custom-control-input.is-valid ~ .custom-control-label::before{border-color:#420084}.was-validated .custom-control-input:valid:checked ~ .custom-control-label::before,.custom-control-input.is-valid:checked ~ .custom-control-label::before{border-color:#5c00b7;background-color:#5c00b7}.was-validated .custom-control-input:valid:focus ~ .custom-control-label::before,.custom-control-input.is-valid:focus ~ .custom-control-label::before{box-shadow:0 0 0 .2rem rgba(66,0,132,0.25)}.was-validated .custom-control-input:valid:focus:not(:checked) ~ .custom-control-label::before,.custom-control-input.is-valid:focus:not(:checked) ~ .custom-control-label::before{border-color:#420084}.was-validated .custom-file-input:valid ~ .custom-file-label,.custom-file-input.is-valid ~ .custom-file-label{border-color:#420084}.was-validated .custom-file-input:valid:focus ~ .custom-file-label,.custom-file-input.is-valid:focus ~ .custom-file-label{border-color:#420084;box-shadow:0 0 0 .2rem rgba(66,0,132,0.25)}.invalid-feedback{display:none;width:100%;margin-top:.25rem;font-size:80%;color:#f2460d}.invalid-tooltip{position:absolute;top:100%;z-index:5;display:none;max-width:100%;padding:.25rem .5rem;margin-top:.1rem;font-size:.875rem;line-height:1.5;color:#fff;background-color:rgba(242,70,13,0.9);border-radius:.25rem}.was-validated :invalid ~ .invalid-feedback,.was-validated :invalid ~ .invalid-tooltip,.is-invalid ~ .invalid-feedback,.is-invalid ~ .invalid-tooltip{display:block}.was-validated .form-control:invalid,.form-control.is-invalid{border-color:#f2460d;padding-right:calc(1.5em + .75rem);background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23f2460d' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23f2460d' stroke='none'/%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right calc(.375em + .1875rem) center;background-size:calc(.75em + .375rem) calc(.75em + .375rem)}.was-validated .form-control:invalid:focus,.form-control.is-invalid:focus{border-color:#f2460d;box-shadow:0 0 0 .2rem rgba(242,70,13,0.25)}.was-validated textarea.form-control:invalid,textarea.form-control.is-invalid{padding-right:calc(1.5em + .75rem);background-position:top calc(.375em + .1875rem) right calc(.375em + .1875rem)}.was-validated .custom-select:invalid,.custom-select.is-invalid{border-color:#f2460d;padding-right:calc(.75em + 2.3125rem);background:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px,url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23f2460d' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23f2460d' stroke='none'/%3e%3c/svg%3e") #fff no-repeat center right 1.75rem/calc(.75em + .375rem) calc(.75em + .375rem)}.was-validated .custom-select:invalid:focus,.custom-select.is-invalid:focus{border-color:#f2460d;box-shadow:0 0 0 .2rem rgba(242,70,13,0.25)}.was-validated .form-check-input:invalid ~ .form-check-label,.form-check-input.is-invalid ~ .form-check-label{color:#f2460d}.was-validated .form-check-input:invalid ~ .invalid-feedback,.was-validated .form-check-input:invalid ~ .invalid-tooltip,.form-check-input.is-invalid ~ .invalid-feedback,.form-check-input.is-invalid ~ .invalid-tooltip{display:block}.was-validated .custom-control-input:invalid ~ .custom-control-label,.custom-control-input.is-invalid ~ .custom-control-label{color:#f2460d}.was-validated .custom-control-input:invalid ~ .custom-control-label::before,.custom-control-input.is-invalid ~ .custom-control-label::before{border-color:#f2460d}.was-validated .custom-control-input:invalid:checked ~ .custom-control-label::before,.custom-control-input.is-invalid:checked ~ .custom-control-label::before{border-color:#f56b3d;background-color:#f56b3d}.was-validated .custom-control-input:invalid:focus ~ .custom-control-label::before,.custom-control-input.is-invalid:focus ~ .custom-control-label::before{box-shadow:0 0 0 .2rem rgba(242,70,13,0.25)}.was-validated .custom-control-input:invalid:focus:not(:checked) ~ .custom-control-label::before,.custom-control-input.is-invalid:focus:not(:checked) ~ .custom-control-label::before{border-color:#f2460d}.was-validated .custom-file-input:invalid ~ .custom-file-label,.custom-file-input.is-invalid ~ .custom-file-label{border-color:#f2460d}.was-validated .custom-file-input:invalid:focus ~ .custom-file-label,.custom-file-input.is-invalid:focus ~ .custom-file-label{border-color:#f2460d;box-shadow:0 0 0 .2rem rgba(242,70,13,0.25)}.form-inline{display:flex;flex-flow:row wrap;align-items:center}.form-inline .form-check{width:100%}@media (min-width: 576px){.form-inline label{display:flex;align-items:center;justify-content:center;margin-bottom:0}.form-inline .form-group{display:flex;flex:0 0 auto;flex-flow:row wrap;align-items:center;margin-bottom:0}.form-inline .form-control{display:inline-block;width:auto;vertical-align:middle}.form-inline .form-control-plaintext{display:inline-block}.form-inline .input-group,.form-inline .custom-select{width:auto}.form-inline .form-check{display:flex;align-items:center;justify-content:center;width:auto;padding-left:0}.form-inline .form-check-input{position:relative;flex-shrink:0;margin-top:0;margin-right:.25rem;margin-left:0}.form-inline .custom-control{align-items:center;justify-content:center}.form-inline .custom-control-label{margin-bottom:0}}.btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out}@media (prefers-reduced-motion: reduce){.btn{transition:none}}.btn:hover{color:#212529;text-decoration:none}.btn:focus,.btn.focus{outline:0;box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.btn.disabled,.btn:disabled{opacity:.65}.btn:not(:disabled):not(.disabled){cursor:pointer}a.btn.disabled,fieldset:disabled a.btn{pointer-events:none}.btn-primary{color:#fff;background-color:#2F414A;border-color:#2F414A}.btn-primary:hover{color:#fff;background-color:#202c33;border-color:#1b262b}.btn-primary:focus,.btn-primary.focus{color:#fff;background-color:#202c33;border-color:#1b262b;box-shadow:0 0 0 .2rem rgba(78,94,101,0.5)}.btn-primary.disabled,.btn-primary:disabled{color:#fff;background-color:#2F414A;border-color:#2F414A}.btn-primary:not(:disabled):not(.disabled):active,.btn-primary:not(:disabled):not(.disabled).active,.show>.btn-primary.dropdown-toggle{color:#fff;background-color:#1b262b;border-color:#161f23}.btn-primary:not(:disabled):not(.disabled):active:focus,.btn-primary:not(:disabled):not(.disabled).active:focus,.show>.btn-primary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(78,94,101,0.5)}.btn-secondary{color:#212529;background-color:#F47B53;border-color:#F47B53}.btn-secondary:hover{color:#fff;background-color:#f25f2f;border-color:#f15623}.btn-secondary:focus,.btn-secondary.focus{color:#fff;background-color:#f25f2f;border-color:#f15623;box-shadow:0 0 0 .2rem rgba(212,110,77,0.5)}.btn-secondary.disabled,.btn-secondary:disabled{color:#212529;background-color:#F47B53;border-color:#F47B53}.btn-secondary:not(:disabled):not(.disabled):active,.btn-secondary:not(:disabled):not(.disabled).active,.show>.btn-secondary.dropdown-toggle{color:#fff;background-color:#f15623;border-color:#f04d17}.btn-secondary:not(:disabled):not(.disabled):active:focus,.btn-secondary:not(:disabled):not(.disabled).active:focus,.show>.btn-secondary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(212,110,77,0.5)}.btn-success{color:#fff;background-color:#420084;border-color:#420084}.btn-success:hover{color:#fff;background-color:#2f005e;border-color:#290051}.btn-success:focus,.btn-success.focus{color:#fff;background-color:#2f005e;border-color:#290051;box-shadow:0 0 0 .2rem rgba(94,38,150,0.5)}.btn-success.disabled,.btn-success:disabled{color:#fff;background-color:#420084;border-color:#420084}.btn-success:not(:disabled):not(.disabled):active,.btn-success:not(:disabled):not(.disabled).active,.show>.btn-success.dropdown-toggle{color:#fff;background-color:#290051;border-color:#204}.btn-success:not(:disabled):not(.disabled):active:focus,.btn-success:not(:disabled):not(.disabled).active:focus,.show>.btn-success.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(94,38,150,0.5)}.btn-info{color:#212529;background-color:#7ebcfa;border-color:#7ebcfa}.btn-info:hover{color:#212529;background-color:#59a9f9;border-color:#4da3f8}.btn-info:focus,.btn-info.focus{color:#212529;background-color:#59a9f9;border-color:#4da3f8;box-shadow:0 0 0 .2rem rgba(112,165,219,0.5)}.btn-info.disabled,.btn-info:disabled{color:#212529;background-color:#7ebcfa;border-color:#7ebcfa}.btn-info:not(:disabled):not(.disabled):active,.btn-info:not(:disabled):not(.disabled).active,.show>.btn-info.dropdown-toggle{color:#fff;background-color:#4da3f8;border-color:#419cf8}.btn-info:not(:disabled):not(.disabled):active:focus,.btn-info:not(:disabled):not(.disabled).active:focus,.show>.btn-info.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(112,165,219,0.5)}.btn-warning{color:#212529;background-color:#f93;border-color:#f93}.btn-warning:hover{color:#212529;background-color:#ff860d;border-color:#ff8000}.btn-warning:focus,.btn-warning.focus{color:#212529;background-color:#ff860d;border-color:#ff8000;box-shadow:0 0 0 .2rem rgba(222,136,50,0.5)}.btn-warning.disabled,.btn-warning:disabled{color:#212529;background-color:#f93;border-color:#f93}.btn-warning:not(:disabled):not(.disabled):active,.btn-warning:not(:disabled):not(.disabled).active,.show>.btn-warning.dropdown-toggle{color:#212529;background-color:#ff8000;border-color:#f27900}.btn-warning:not(:disabled):not(.disabled):active:focus,.btn-warning:not(:disabled):not(.disabled).active:focus,.show>.btn-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(222,136,50,0.5)}.btn-danger{color:#fff;background-color:#f2460d;border-color:#f2460d}.btn-danger:hover{color:#fff;background-color:#ce3c0b;border-color:#c2380a}.btn-danger:focus,.btn-danger.focus{color:#fff;background-color:#ce3c0b;border-color:#c2380a;box-shadow:0 0 0 .2rem rgba(244,98,49,0.5)}.btn-danger.disabled,.btn-danger:disabled{color:#fff;background-color:#f2460d;border-color:#f2460d}.btn-danger:not(:disabled):not(.disabled):active,.btn-danger:not(:disabled):not(.disabled).active,.show>.btn-danger.dropdown-toggle{color:#fff;background-color:#c2380a;border-color:#b6350a}.btn-danger:not(:disabled):not(.disabled):active:focus,.btn-danger:not(:disabled):not(.disabled).active:focus,.show>.btn-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(244,98,49,0.5)}.btn-light{color:#212529;background-color:#eef0f2;border-color:#eef0f2}.btn-light:hover{color:#212529;background-color:#d8dde1;border-color:#d1d7dc}.btn-light:focus,.btn-light.focus{color:#212529;background-color:#d8dde1;border-color:#d1d7dc;box-shadow:0 0 0 .2rem rgba(207,210,212,0.5)}.btn-light.disabled,.btn-light:disabled{color:#212529;background-color:#eef0f2;border-color:#eef0f2}.btn-light:not(:disabled):not(.disabled):active,.btn-light:not(:disabled):not(.disabled).active,.show>.btn-light.dropdown-toggle{color:#212529;background-color:#d1d7dc;border-color:#cad0d6}.btn-light:not(:disabled):not(.disabled):active:focus,.btn-light:not(:disabled):not(.disabled).active:focus,.show>.btn-light.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(207,210,212,0.5)}.btn-dark{color:#fff;background-color:#000633;border-color:#000633}.btn-dark:hover{color:#fff;background-color:#00020d;border-color:#000}.btn-dark:focus,.btn-dark.focus{color:#fff;background-color:#00020d;border-color:#000;box-shadow:0 0 0 .2rem rgba(38,43,82,0.5)}.btn-dark.disabled,.btn-dark:disabled{color:#fff;background-color:#000633;border-color:#000633}.btn-dark:not(:disabled):not(.disabled):active,.btn-dark:not(:disabled):not(.disabled).active,.show>.btn-dark.dropdown-toggle{color:#fff;background-color:#000;border-color:#000}.btn-dark:not(:disabled):not(.disabled):active:focus,.btn-dark:not(:disabled):not(.disabled).active:focus,.show>.btn-dark.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(38,43,82,0.5)}.btn-outline-primary{color:#2F414A;border-color:#2F414A}.btn-outline-primary:hover{color:#fff;background-color:#2F414A;border-color:#2F414A}.btn-outline-primary:focus,.btn-outline-primary.focus{box-shadow:0 0 0 .2rem rgba(47,65,74,0.5)}.btn-outline-primary.disabled,.btn-outline-primary:disabled{color:#2F414A;background-color:transparent}.btn-outline-primary:not(:disabled):not(.disabled):active,.btn-outline-primary:not(:disabled):not(.disabled).active,.show>.btn-outline-primary.dropdown-toggle{color:#fff;background-color:#2F414A;border-color:#2F414A}.btn-outline-primary:not(:disabled):not(.disabled):active:focus,.btn-outline-primary:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-primary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(47,65,74,0.5)}.btn-outline-secondary{color:#F47B53;border-color:#F47B53}.btn-outline-secondary:hover{color:#212529;background-color:#F47B53;border-color:#F47B53}.btn-outline-secondary:focus,.btn-outline-secondary.focus{box-shadow:0 0 0 .2rem rgba(244,123,83,0.5)}.btn-outline-secondary.disabled,.btn-outline-secondary:disabled{color:#F47B53;background-color:transparent}.btn-outline-secondary:not(:disabled):not(.disabled):active,.btn-outline-secondary:not(:disabled):not(.disabled).active,.show>.btn-outline-secondary.dropdown-toggle{color:#212529;background-color:#F47B53;border-color:#F47B53}.btn-outline-secondary:not(:disabled):not(.disabled):active:focus,.btn-outline-secondary:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-secondary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(244,123,83,0.5)}.btn-outline-success{color:#420084;border-color:#420084}.btn-outline-success:hover{color:#fff;background-color:#420084;border-color:#420084}.btn-outline-success:focus,.btn-outline-success.focus{box-shadow:0 0 0 .2rem rgba(66,0,132,0.5)}.btn-outline-success.disabled,.btn-outline-success:disabled{color:#420084;background-color:transparent}.btn-outline-success:not(:disabled):not(.disabled):active,.btn-outline-success:not(:disabled):not(.disabled).active,.show>.btn-outline-success.dropdown-toggle{color:#fff;background-color:#420084;border-color:#420084}.btn-outline-success:not(:disabled):not(.disabled):active:focus,.btn-outline-success:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-success.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(66,0,132,0.5)}.btn-outline-info{color:#7ebcfa;border-color:#7ebcfa}.btn-outline-info:hover{color:#212529;background-color:#7ebcfa;border-color:#7ebcfa}.btn-outline-info:focus,.btn-outline-info.focus{box-shadow:0 0 0 .2rem rgba(126,188,250,0.5)}.btn-outline-info.disabled,.btn-outline-info:disabled{color:#7ebcfa;background-color:transparent}.btn-outline-info:not(:disabled):not(.disabled):active,.btn-outline-info:not(:disabled):not(.disabled).active,.show>.btn-outline-info.dropdown-toggle{color:#212529;background-color:#7ebcfa;border-color:#7ebcfa}.btn-outline-info:not(:disabled):not(.disabled):active:focus,.btn-outline-info:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-info.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(126,188,250,0.5)}.btn-outline-warning{color:#f93;border-color:#f93}.btn-outline-warning:hover{color:#212529;background-color:#f93;border-color:#f93}.btn-outline-warning:focus,.btn-outline-warning.focus{box-shadow:0 0 0 .2rem rgba(255,153,51,0.5)}.btn-outline-warning.disabled,.btn-outline-warning:disabled{color:#f93;background-color:transparent}.btn-outline-warning:not(:disabled):not(.disabled):active,.btn-outline-warning:not(:disabled):not(.disabled).active,.show>.btn-outline-warning.dropdown-toggle{color:#212529;background-color:#f93;border-color:#f93}.btn-outline-warning:not(:disabled):not(.disabled):active:focus,.btn-outline-warning:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(255,153,51,0.5)}.btn-outline-danger{color:#f2460d;border-color:#f2460d}.btn-outline-danger:hover{color:#fff;background-color:#f2460d;border-color:#f2460d}.btn-outline-danger:focus,.btn-outline-danger.focus{box-shadow:0 0 0 .2rem rgba(242,70,13,0.5)}.btn-outline-danger.disabled,.btn-outline-danger:disabled{color:#f2460d;background-color:transparent}.btn-outline-danger:not(:disabled):not(.disabled):active,.btn-outline-danger:not(:disabled):not(.disabled).active,.show>.btn-outline-danger.dropdown-toggle{color:#fff;background-color:#f2460d;border-color:#f2460d}.btn-outline-danger:not(:disabled):not(.disabled):active:focus,.btn-outline-danger:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(242,70,13,0.5)}.btn-outline-light{color:#eef0f2;border-color:#eef0f2}.btn-outline-light:hover{color:#212529;background-color:#eef0f2;border-color:#eef0f2}.btn-outline-light:focus,.btn-outline-light.focus{box-shadow:0 0 0 .2rem rgba(238,240,242,0.5)}.btn-outline-light.disabled,.btn-outline-light:disabled{color:#eef0f2;background-color:transparent}.btn-outline-light:not(:disabled):not(.disabled):active,.btn-outline-light:not(:disabled):not(.disabled).active,.show>.btn-outline-light.dropdown-toggle{color:#212529;background-color:#eef0f2;border-color:#eef0f2}.btn-outline-light:not(:disabled):not(.disabled):active:focus,.btn-outline-light:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-light.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(238,240,242,0.5)}.btn-outline-dark{color:#000633;border-color:#000633}.btn-outline-dark:hover{color:#fff;background-color:#000633;border-color:#000633}.btn-outline-dark:focus,.btn-outline-dark.focus{box-shadow:0 0 0 .2rem rgba(0,6,51,0.5)}.btn-outline-dark.disabled,.btn-outline-dark:disabled{color:#000633;background-color:transparent}.btn-outline-dark:not(:disabled):not(.disabled):active,.btn-outline-dark:not(:disabled):not(.disabled).active,.show>.btn-outline-dark.dropdown-toggle{color:#fff;background-color:#000633;border-color:#000633}.btn-outline-dark:not(:disabled):not(.disabled):active:focus,.btn-outline-dark:not(:disabled):not(.disabled).active:focus,.show>.btn-outline-dark.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(0,6,51,0.5)}.btn-link{font-weight:400;color:#2F414A;text-decoration:none}.btn-link:hover{color:#11181b;text-decoration:underline}.btn-link:focus,.btn-link.focus{text-decoration:underline}.btn-link:disabled,.btn-link.disabled{color:#6c757d;pointer-events:none}.btn-lg,.btn-group-lg>.btn{padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}.btn-sm,.btn-group-sm>.btn{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.btn-block{display:block;width:100%}.btn-block+.btn-block{margin-top:.5rem}input[type="submit"].btn-block,input[type="reset"].btn-block,input[type="button"].btn-block{width:100%}.fade{transition:opacity 0.15s linear}@media (prefers-reduced-motion: reduce){.fade{transition:none}}.fade:not(.show){opacity:0}.collapse:not(.show){display:none}.collapsing{position:relative;height:0;overflow:hidden;transition:height 0.35s ease}@media (prefers-reduced-motion: reduce){.collapsing{transition:none}}.dropup,.dropright,.dropdown,.dropleft{position:relative}.dropdown-toggle{white-space:nowrap}.dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-toggle:empty::after{margin-left:0}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,0.15);border-radius:.25rem}.dropdown-menu-left{right:auto;left:0}.dropdown-menu-right{right:0;left:auto}@media (min-width: 576px){.dropdown-menu-sm-left{right:auto;left:0}.dropdown-menu-sm-right{right:0;left:auto}}@media (min-width: 768px){.dropdown-menu-md-left{right:auto;left:0}.dropdown-menu-md-right{right:0;left:auto}}@media (min-width: 992px){.dropdown-menu-lg-left{right:auto;left:0}.dropdown-menu-lg-right{right:0;left:auto}}@media (min-width: 1200px){.dropdown-menu-xl-left{right:auto;left:0}.dropdown-menu-xl-right{right:0;left:auto}}.dropup .dropdown-menu{top:auto;bottom:100%;margin-top:0;margin-bottom:.125rem}.dropup .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:0;border-right:.3em solid transparent;border-bottom:.3em solid;border-left:.3em solid transparent}.dropup .dropdown-toggle:empty::after{margin-left:0}.dropright .dropdown-menu{top:0;right:auto;left:100%;margin-top:0;margin-left:.125rem}.dropright .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid transparent;border-right:0;border-bottom:.3em solid transparent;border-left:.3em solid}.dropright .dropdown-toggle:empty::after{margin-left:0}.dropright .dropdown-toggle::after{vertical-align:0}.dropleft .dropdown-menu{top:0;right:100%;left:auto;margin-top:0;margin-right:.125rem}.dropleft .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:""}.dropleft .dropdown-toggle::after{display:none}.dropleft .dropdown-toggle::before{display:inline-block;margin-right:.255em;vertical-align:.255em;content:"";border-top:.3em solid transparent;border-right:.3em solid;border-bottom:.3em solid transparent}.dropleft .dropdown-toggle:empty::after{margin-left:0}.dropleft .dropdown-toggle::before{vertical-align:0}.dropdown-menu[x-placement^="top"],.dropdown-menu[x-placement^="right"],.dropdown-menu[x-placement^="bottom"],.dropdown-menu[x-placement^="left"]{right:auto;bottom:auto}.dropdown-divider{height:0;margin:.5rem 0;overflow:hidden;border-top:1px solid #e9ecef}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.dropdown-item:hover,.dropdown-item:focus{color:#16181b;text-decoration:none;background-color:#f8f9fa}.dropdown-item.active,.dropdown-item:active{color:#fff;text-decoration:none;background-color:#2F414A}.dropdown-item.disabled,.dropdown-item:disabled{color:#6c757d;pointer-events:none;background-color:transparent}.dropdown-menu.show{display:block}.dropdown-header{display:block;padding:.5rem 1.5rem;margin-bottom:0;font-size:.875rem;color:#6c757d;white-space:nowrap}.dropdown-item-text{display:block;padding:.25rem 1.5rem;color:#212529}.btn-group,.btn-group-vertical{position:relative;display:inline-flex;vertical-align:middle}.btn-group>.btn,.btn-group-vertical>.btn{position:relative;flex:1 1 auto}.btn-group>.btn:hover,.btn-group-vertical>.btn:hover{z-index:1}.btn-group>.btn:focus,.btn-group>.btn:active,.btn-group>.btn.active,.btn-group-vertical>.btn:focus,.btn-group-vertical>.btn:active,.btn-group-vertical>.btn.active{z-index:1}.btn-toolbar{display:flex;flex-wrap:wrap;justify-content:flex-start}.btn-toolbar .input-group{width:auto}.btn-group>.btn:not(:first-child),.btn-group>.btn-group:not(:first-child){margin-left:-1px}.btn-group>.btn:not(:last-child):not(.dropdown-toggle),.btn-group>.btn-group:not(:last-child)>.btn{border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn:not(:first-child),.btn-group>.btn-group:not(:first-child)>.btn{border-top-left-radius:0;border-bottom-left-radius:0}.dropdown-toggle-split{padding-right:.5625rem;padding-left:.5625rem}.dropdown-toggle-split::after,.dropup .dropdown-toggle-split::after,.dropright .dropdown-toggle-split::after{margin-left:0}.dropleft .dropdown-toggle-split::before{margin-right:0}.btn-sm+.dropdown-toggle-split,.btn-group-sm>.btn+.dropdown-toggle-split{padding-right:.375rem;padding-left:.375rem}.btn-lg+.dropdown-toggle-split,.btn-group-lg>.btn+.dropdown-toggle-split{padding-right:.75rem;padding-left:.75rem}.btn-group-vertical{flex-direction:column;align-items:flex-start;justify-content:center}.btn-group-vertical>.btn,.btn-group-vertical>.btn-group{width:100%}.btn-group-vertical>.btn:not(:first-child),.btn-group-vertical>.btn-group:not(:first-child){margin-top:-1px}.btn-group-vertical>.btn:not(:last-child):not(.dropdown-toggle),.btn-group-vertical>.btn-group:not(:last-child)>.btn{border-bottom-right-radius:0;border-bottom-left-radius:0}.btn-group-vertical>.btn:not(:first-child),.btn-group-vertical>.btn-group:not(:first-child)>.btn{border-top-left-radius:0;border-top-right-radius:0}.btn-group-toggle>.btn,.btn-group-toggle>.btn-group>.btn{margin-bottom:0}.btn-group-toggle>.btn input[type="radio"],.btn-group-toggle>.btn input[type="checkbox"],.btn-group-toggle>.btn-group>.btn input[type="radio"],.btn-group-toggle>.btn-group>.btn input[type="checkbox"]{position:absolute;clip:rect(0, 0, 0, 0);pointer-events:none}.input-group{position:relative;display:flex;flex-wrap:wrap;align-items:stretch;width:100%}.input-group>.form-control,.input-group>.form-control-plaintext,.input-group>.custom-select,.input-group>.custom-file{position:relative;flex:1 1 auto;width:1%;min-width:0;margin-bottom:0}.input-group>.form-control+.form-control,.input-group>.form-control+.custom-select,.input-group>.form-control+.custom-file,.input-group>.form-control-plaintext+.form-control,.input-group>.form-control-plaintext+.custom-select,.input-group>.form-control-plaintext+.custom-file,.input-group>.custom-select+.form-control,.input-group>.custom-select+.custom-select,.input-group>.custom-select+.custom-file,.input-group>.custom-file+.form-control,.input-group>.custom-file+.custom-select,.input-group>.custom-file+.custom-file{margin-left:-1px}.input-group>.form-control:focus,.input-group>.custom-select:focus,.input-group>.custom-file .custom-file-input:focus ~ .custom-file-label{z-index:3}.input-group>.custom-file .custom-file-input:focus{z-index:4}.input-group>.form-control:not(:last-child),.input-group>.custom-select:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.form-control:not(:first-child),.input-group>.custom-select:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.input-group>.custom-file{display:flex;align-items:center}.input-group>.custom-file:not(:last-child) .custom-file-label,.input-group>.custom-file:not(:last-child) .custom-file-label::after{border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.custom-file:not(:first-child) .custom-file-label{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-prepend,.input-group-append{display:flex}.input-group-prepend .btn,.input-group-append .btn{position:relative;z-index:2}.input-group-prepend .btn:focus,.input-group-append .btn:focus{z-index:3}.input-group-prepend .btn+.btn,.input-group-prepend .btn+.input-group-text,.input-group-prepend .input-group-text+.input-group-text,.input-group-prepend .input-group-text+.btn,.input-group-append .btn+.btn,.input-group-append .btn+.input-group-text,.input-group-append .input-group-text+.input-group-text,.input-group-append .input-group-text+.btn{margin-left:-1px}.input-group-prepend{margin-right:-1px}.input-group-append{margin-left:-1px}.input-group-text{display:flex;align-items:center;padding:.375rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.25rem}.input-group-text input[type="radio"],.input-group-text input[type="checkbox"]{margin-top:0}.input-group-lg>.form-control:not(textarea),.input-group-lg>.custom-select{height:calc(1.5em + 1rem + 2px)}.input-group-lg>.form-control,.input-group-lg>.custom-select,.input-group-lg>.input-group-prepend>.input-group-text,.input-group-lg>.input-group-append>.input-group-text,.input-group-lg>.input-group-prepend>.btn,.input-group-lg>.input-group-append>.btn{padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}.input-group-sm>.form-control:not(textarea),.input-group-sm>.custom-select{height:calc(1.5em + .5rem + 2px)}.input-group-sm>.form-control,.input-group-sm>.custom-select,.input-group-sm>.input-group-prepend>.input-group-text,.input-group-sm>.input-group-append>.input-group-text,.input-group-sm>.input-group-prepend>.btn,.input-group-sm>.input-group-append>.btn{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.input-group-lg>.custom-select,.input-group-sm>.custom-select{padding-right:1.75rem}.input-group>.input-group-prepend>.btn,.input-group>.input-group-prepend>.input-group-text,.input-group>.input-group-append:not(:last-child)>.btn,.input-group>.input-group-append:not(:last-child)>.input-group-text,.input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle),.input-group>.input-group-append:last-child>.input-group-text:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.input-group>.input-group-append>.btn,.input-group>.input-group-append>.input-group-text,.input-group>.input-group-prepend:not(:first-child)>.btn,.input-group>.input-group-prepend:not(:first-child)>.input-group-text,.input-group>.input-group-prepend:first-child>.btn:not(:first-child),.input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.custom-control{position:relative;display:block;min-height:1.5rem;padding-left:1.5rem}.custom-control-inline{display:inline-flex;margin-right:1rem}.custom-control-input{position:absolute;left:0;z-index:-1;width:1rem;height:1.25rem;opacity:0}.custom-control-input:checked ~ .custom-control-label::before{color:#fff;border-color:#2F414A;background-color:#2F414A}.custom-control-input:focus ~ .custom-control-label::before{box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.custom-control-input:focus:not(:checked) ~ .custom-control-label::before{border-color:#618598}.custom-control-input:not(:disabled):active ~ .custom-control-label::before{color:#fff;background-color:#7e9ead;border-color:#7e9ead}.custom-control-input[disabled] ~ .custom-control-label,.custom-control-input:disabled ~ .custom-control-label{color:#6c757d}.custom-control-input[disabled] ~ .custom-control-label::before,.custom-control-input:disabled ~ .custom-control-label::before{background-color:#e9ecef}.custom-control-label{position:relative;margin-bottom:0;vertical-align:top}.custom-control-label::before{position:absolute;top:.25rem;left:-1.5rem;display:block;width:1rem;height:1rem;pointer-events:none;content:"";background-color:#fff;border:#adb5bd solid 1px}.custom-control-label::after{position:absolute;top:.25rem;left:-1.5rem;display:block;width:1rem;height:1rem;content:"";background:no-repeat 50% / 50% 50%}.custom-checkbox .custom-control-label::before{border-radius:.25rem}.custom-checkbox .custom-control-input:checked ~ .custom-control-label::after{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3e%3c/svg%3e")}.custom-checkbox .custom-control-input:indeterminate ~ .custom-control-label::before{border-color:#2F414A;background-color:#2F414A}.custom-checkbox .custom-control-input:indeterminate ~ .custom-control-label::after{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3e%3cpath stroke='%23fff' d='M0 2h4'/%3e%3c/svg%3e")}.custom-checkbox .custom-control-input:disabled:checked ~ .custom-control-label::before{background-color:rgba(47,65,74,0.5)}.custom-checkbox .custom-control-input:disabled:indeterminate ~ .custom-control-label::before{background-color:rgba(47,65,74,0.5)}.custom-radio .custom-control-label::before{border-radius:50%}.custom-radio .custom-control-input:checked ~ .custom-control-label::after{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e")}.custom-radio .custom-control-input:disabled:checked ~ .custom-control-label::before{background-color:rgba(47,65,74,0.5)}.custom-switch{padding-left:2.25rem}.custom-switch .custom-control-label::before{left:-2.25rem;width:1.75rem;pointer-events:all;border-radius:.5rem}.custom-switch .custom-control-label::after{top:calc(.25rem + 2px);left:calc(-2.25rem + 2px);width:calc(1rem - 4px);height:calc(1rem - 4px);background-color:#adb5bd;border-radius:.5rem;transition:transform 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out}@media (prefers-reduced-motion: reduce){.custom-switch .custom-control-label::after{transition:none}}.custom-switch .custom-control-input:checked ~ .custom-control-label::after{background-color:#fff;transform:translateX(.75rem)}.custom-switch .custom-control-input:disabled:checked ~ .custom-control-label::before{background-color:rgba(47,65,74,0.5)}.custom-select{display:inline-block;width:100%;height:calc(1.5em + .75rem + 2px);padding:.375rem 1.75rem .375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;vertical-align:middle;background:#fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px;border:1px solid #ced4da;border-radius:.25rem;appearance:none}.custom-select:focus{border-color:#618598;outline:0;box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.custom-select:focus::-ms-value{color:#495057;background-color:#fff}.custom-select[multiple],.custom-select[size]:not([size="1"]){height:auto;padding-right:.75rem;background-image:none}.custom-select:disabled{color:#6c757d;background-color:#e9ecef}.custom-select::-ms-expand{display:none}.custom-select:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057}.custom-select-sm{height:calc(1.5em + .5rem + 2px);padding-top:.25rem;padding-bottom:.25rem;padding-left:.5rem;font-size:.875rem}.custom-select-lg{height:calc(1.5em + 1rem + 2px);padding-top:.5rem;padding-bottom:.5rem;padding-left:1rem;font-size:1.25rem}.custom-file{position:relative;display:inline-block;width:100%;height:calc(1.5em + .75rem + 2px);margin-bottom:0}.custom-file-input{position:relative;z-index:2;width:100%;height:calc(1.5em + .75rem + 2px);margin:0;opacity:0}.custom-file-input:focus ~ .custom-file-label{border-color:#618598;box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.custom-file-input[disabled] ~ .custom-file-label,.custom-file-input:disabled ~ .custom-file-label{background-color:#e9ecef}.custom-file-input:lang(en) ~ .custom-file-label::after{content:"Browse"}.custom-file-input ~ .custom-file-label[data-browse]::after{content:attr(data-browse)}.custom-file-label{position:absolute;top:0;right:0;left:0;z-index:1;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;border:1px solid #ced4da;border-radius:.25rem}.custom-file-label::after{position:absolute;top:0;right:0;bottom:0;z-index:3;display:block;height:calc(1.5em + .75rem);padding:.375rem .75rem;line-height:1.5;color:#495057;content:"Browse";background-color:#e9ecef;border-left:inherit;border-radius:0 .25rem .25rem 0}.custom-range{width:100%;height:1.4rem;padding:0;background-color:transparent;appearance:none}.custom-range:focus{outline:none}.custom-range:focus::-webkit-slider-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(47,65,74,0.25)}.custom-range:focus::-moz-range-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(47,65,74,0.25)}.custom-range:focus::-ms-thumb{box-shadow:0 0 0 1px #fff,0 0 0 .2rem rgba(47,65,74,0.25)}.custom-range::-moz-focus-outer{border:0}.custom-range::-webkit-slider-thumb{width:1rem;height:1rem;margin-top:-.25rem;background-color:#2F414A;border:0;border-radius:1rem;transition:background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;appearance:none}@media (prefers-reduced-motion: reduce){.custom-range::-webkit-slider-thumb{transition:none}}.custom-range::-webkit-slider-thumb:active{background-color:#7e9ead}.custom-range::-webkit-slider-runnable-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:#dee2e6;border-color:transparent;border-radius:1rem}.custom-range::-moz-range-thumb{width:1rem;height:1rem;background-color:#2F414A;border:0;border-radius:1rem;transition:background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;appearance:none}@media (prefers-reduced-motion: reduce){.custom-range::-moz-range-thumb{transition:none}}.custom-range::-moz-range-thumb:active{background-color:#7e9ead}.custom-range::-moz-range-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:#dee2e6;border-color:transparent;border-radius:1rem}.custom-range::-ms-thumb{width:1rem;height:1rem;margin-top:0;margin-right:.2rem;margin-left:.2rem;background-color:#2F414A;border:0;border-radius:1rem;transition:background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;appearance:none}@media (prefers-reduced-motion: reduce){.custom-range::-ms-thumb{transition:none}}.custom-range::-ms-thumb:active{background-color:#7e9ead}.custom-range::-ms-track{width:100%;height:.5rem;color:transparent;cursor:pointer;background-color:transparent;border-color:transparent;border-width:.5rem}.custom-range::-ms-fill-lower{background-color:#dee2e6;border-radius:1rem}.custom-range::-ms-fill-upper{margin-right:15px;background-color:#dee2e6;border-radius:1rem}.custom-range:disabled::-webkit-slider-thumb{background-color:#adb5bd}.custom-range:disabled::-webkit-slider-runnable-track{cursor:default}.custom-range:disabled::-moz-range-thumb{background-color:#adb5bd}.custom-range:disabled::-moz-range-track{cursor:default}.custom-range:disabled::-ms-thumb{background-color:#adb5bd}.custom-control-label::before,.custom-file-label,.custom-select{transition:background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out}@media (prefers-reduced-motion: reduce){.custom-control-label::before,.custom-file-label,.custom-select{transition:none}}.nav{display:flex;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-link:hover,.nav-link:focus{text-decoration:none}.nav-link.disabled{color:#6c757d;pointer-events:none;cursor:default}.nav-tabs{border-bottom:1px solid #dee2e6}.nav-tabs .nav-item{margin-bottom:-1px}.nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.25rem;border-top-right-radius:.25rem}.nav-tabs .nav-link:hover,.nav-tabs .nav-link:focus{border-color:#e9ecef #e9ecef #dee2e6}.nav-tabs .nav-link.disabled{color:#6c757d;background-color:transparent;border-color:transparent}.nav-tabs .nav-link.active,.nav-tabs .nav-item.show .nav-link{color:#495057;background-color:#fff;border-color:#dee2e6 #dee2e6 #fff}.nav-tabs .dropdown-menu{margin-top:-1px;border-top-left-radius:0;border-top-right-radius:0}.nav-pills .nav-link{border-radius:.25rem}.nav-pills .nav-link.active,.nav-pills .show>.nav-link{color:#fff;background-color:#2F414A}.nav-fill .nav-item{flex:1 1 auto;text-align:center}.nav-justified .nav-item{flex-basis:0;flex-grow:1;text-align:center}.tab-content>.tab-pane{display:none}.tab-content>.active{display:block}.navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}.navbar .container,.navbar .container-fluid,.navbar>.container-sm,.navbar>.container-md,.navbar>.container-lg,.navbar>.container-xl{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-brand:hover,.navbar-brand:focus{text-decoration:none}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-text{display:inline-block;padding-top:.5rem;padding-bottom:.5rem}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:hover,.navbar-toggler:focus{text-decoration:none}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media (max-width: 575.98px){.navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-xl{padding-right:0;padding-left:0}}@media (min-width: 576px){.navbar-expand-sm{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-sm .navbar-nav{flex-direction:row}.navbar-expand-sm .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-sm .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-xl{flex-wrap:nowrap}.navbar-expand-sm .navbar-collapse{display:flex !important;flex-basis:auto}.navbar-expand-sm .navbar-toggler{display:none}}@media (max-width: 767.98px){.navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-md,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-xl{padding-right:0;padding-left:0}}@media (min-width: 768px){.navbar-expand-md{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-md .navbar-nav{flex-direction:row}.navbar-expand-md .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-md .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-md,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-xl{flex-wrap:nowrap}.navbar-expand-md .navbar-collapse{display:flex !important;flex-basis:auto}.navbar-expand-md .navbar-toggler{display:none}}@media (max-width: 991.98px){.navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-xl{padding-right:0;padding-left:0}}@media (min-width: 992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-xl{flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:flex !important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}@media (max-width: 1199.98px){.navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-xl{padding-right:0;padding-left:0}}@media (min-width: 1200px){.navbar-expand-xl{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-xl .navbar-nav{flex-direction:row}.navbar-expand-xl .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-xl .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-xl{flex-wrap:nowrap}.navbar-expand-xl .navbar-collapse{display:flex !important;flex-basis:auto}.navbar-expand-xl .navbar-toggler{display:none}}.navbar-expand{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-sm,.navbar-expand>.container-md,.navbar-expand>.container-lg,.navbar-expand>.container-xl{padding-right:0;padding-left:0}.navbar-expand .navbar-nav{flex-direction:row}.navbar-expand .navbar-nav .dropdown-menu{position:absolute}.navbar-expand .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-sm,.navbar-expand>.container-md,.navbar-expand>.container-lg,.navbar-expand>.container-xl{flex-wrap:nowrap}.navbar-expand .navbar-collapse{display:flex !important;flex-basis:auto}.navbar-expand .navbar-toggler{display:none}.navbar-light .navbar-brand{color:rgba(0,0,0,0.9)}.navbar-light .navbar-brand:hover,.navbar-light .navbar-brand:focus{color:rgba(0,0,0,0.9)}.navbar-light .navbar-nav .nav-link{color:rgba(0,0,0,0.5)}.navbar-light .navbar-nav .nav-link:hover,.navbar-light .navbar-nav .nav-link:focus{color:rgba(0,0,0,0.7)}.navbar-light .navbar-nav .nav-link.disabled{color:rgba(0,0,0,0.3)}.navbar-light .navbar-nav .show>.nav-link,.navbar-light .navbar-nav .active>.nav-link,.navbar-light .navbar-nav .nav-link.show,.navbar-light .navbar-nav .nav-link.active{color:rgba(0,0,0,0.9)}.navbar-light .navbar-toggler{color:rgba(0,0,0,0.5);border-color:rgba(0,0,0,0.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280,0,0,0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")}.navbar-light .navbar-text{color:rgba(0,0,0,0.5)}.navbar-light .navbar-text a{color:rgba(0,0,0,0.9)}.navbar-light .navbar-text a:hover,.navbar-light .navbar-text a:focus{color:rgba(0,0,0,0.9)}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-brand:hover,.navbar-dark .navbar-brand:focus{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,0.5)}.navbar-dark .navbar-nav .nav-link:hover,.navbar-dark .navbar-nav .nav-link:focus{color:rgba(255,255,255,0.75)}.navbar-dark .navbar-nav .nav-link.disabled{color:rgba(255,255,255,0.25)}.navbar-dark .navbar-nav .show>.nav-link,.navbar-dark .navbar-nav .active>.nav-link,.navbar-dark .navbar-nav .nav-link.show,.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,0.5);border-color:rgba(255,255,255,0.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")}.navbar-dark .navbar-text{color:rgba(255,255,255,0.5)}.navbar-dark .navbar-text a{color:#fff}.navbar-dark .navbar-text a:hover,.navbar-dark .navbar-text a:focus{color:#fff}.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,0.125);border-radius:.25rem}.card>hr{margin-right:0;margin-left:0}.card>.list-group{border-top:inherit;border-bottom:inherit}.card>.list-group:first-child{border-top-width:0;border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.card>.list-group:last-child{border-bottom-width:0;border-bottom-right-radius:calc(.25rem - 1px);border-bottom-left-radius:calc(.25rem - 1px)}.card-body{flex:1 1 auto;min-height:1px;padding:1.25rem}.card-title{margin-bottom:.75rem}.card-subtitle{margin-top:-.375rem;margin-bottom:0}.card-text:last-child{margin-bottom:0}.card-link:hover{text-decoration:none}.card-link+.card-link{margin-left:1.25rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,0.03);border-bottom:1px solid rgba(0,0,0,0.125)}.card-header:first-child{border-radius:calc(.25rem - 1px) calc(.25rem - 1px) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.card-footer{padding:.75rem 1.25rem;background-color:rgba(0,0,0,0.03);border-top:1px solid rgba(0,0,0,0.125)}.card-footer:last-child{border-radius:0 0 calc(.25rem - 1px) calc(.25rem - 1px)}.card-header-tabs{margin-right:-.625rem;margin-bottom:-.75rem;margin-left:-.625rem;border-bottom:0}.card-header-pills{margin-right:-.625rem;margin-left:-.625rem}.card-img-overlay{position:absolute;top:0;right:0;bottom:0;left:0;padding:1.25rem}.card-img,.card-img-top,.card-img-bottom{flex-shrink:0;width:100%}.card-img,.card-img-top{border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.card-img,.card-img-bottom{border-bottom-right-radius:calc(.25rem - 1px);border-bottom-left-radius:calc(.25rem - 1px)}.card-deck .card{margin-bottom:15px}@media (min-width: 576px){.card-deck{display:flex;flex-flow:row wrap;margin-right:-15px;margin-left:-15px}.card-deck .card{flex:1 0 0%;margin-right:15px;margin-bottom:0;margin-left:15px}}.card-group>.card{margin-bottom:15px}@media (min-width: 576px){.card-group{display:flex;flex-flow:row wrap}.card-group>.card{flex:1 0 0%;margin-bottom:0}.card-group>.card+.card{margin-left:0;border-left:0}.card-group>.card:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.card-group>.card:not(:last-child) .card-img-top,.card-group>.card:not(:last-child) .card-header{border-top-right-radius:0}.card-group>.card:not(:last-child) .card-img-bottom,.card-group>.card:not(:last-child) .card-footer{border-bottom-right-radius:0}.card-group>.card:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.card-group>.card:not(:first-child) .card-img-top,.card-group>.card:not(:first-child) .card-header{border-top-left-radius:0}.card-group>.card:not(:first-child) .card-img-bottom,.card-group>.card:not(:first-child) .card-footer{border-bottom-left-radius:0}}.card-columns .card{margin-bottom:.75rem}@media (min-width: 576px){.card-columns{column-count:3;column-gap:1.25rem;orphans:1;widows:1}.card-columns .card{display:inline-block;width:100%}}.accordion>.card{overflow:hidden}.accordion>.card:not(:last-of-type){border-bottom:0;border-bottom-right-radius:0;border-bottom-left-radius:0}.accordion>.card:not(:first-of-type){border-top-left-radius:0;border-top-right-radius:0}.accordion>.card>.card-header{border-radius:0;margin-bottom:-1px}.breadcrumb{display:flex;flex-wrap:wrap;padding:.75rem 1rem;margin-bottom:1rem;list-style:none;background-color:#e9ecef;border-radius:.25rem}.breadcrumb-item{display:flex}.breadcrumb-item+.breadcrumb-item{padding-left:.5rem}.breadcrumb-item+.breadcrumb-item::before{display:inline-block;padding-right:.5rem;color:#6c757d;content:"/"}.breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:underline}.breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:none}.breadcrumb-item.active{color:#6c757d}.pagination{display:flex;padding-left:0;list-style:none;border-radius:.25rem}.page-link{position:relative;display:block;padding:.5rem .75rem;margin-left:-1px;line-height:1.25;color:#2F414A;background-color:#fff;border:1px solid #dee2e6}.page-link:hover{z-index:2;color:#11181b;text-decoration:none;background-color:#e9ecef;border-color:#dee2e6}.page-link:focus{z-index:3;outline:0;box-shadow:0 0 0 .2rem rgba(47,65,74,0.25)}.page-item:first-child .page-link{margin-left:0;border-top-left-radius:.25rem;border-bottom-left-radius:.25rem}.page-item:last-child .page-link{border-top-right-radius:.25rem;border-bottom-right-radius:.25rem}.page-item.active .page-link{z-index:3;color:#fff;background-color:#2F414A;border-color:#2F414A}.page-item.disabled .page-link{color:#6c757d;pointer-events:none;cursor:auto;background-color:#fff;border-color:#dee2e6}.pagination-lg .page-link{padding:.75rem 1.5rem;font-size:1.25rem;line-height:1.5}.pagination-lg .page-item:first-child .page-link{border-top-left-radius:.3rem;border-bottom-left-radius:.3rem}.pagination-lg .page-item:last-child .page-link{border-top-right-radius:.3rem;border-bottom-right-radius:.3rem}.pagination-sm .page-link{padding:.25rem .5rem;font-size:.875rem;line-height:1.5}.pagination-sm .page-item:first-child .page-link{border-top-left-radius:.2rem;border-bottom-left-radius:.2rem}.pagination-sm .page-item:last-child .page-link{border-top-right-radius:.2rem;border-bottom-right-radius:.2rem}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem;transition:color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out}@media (prefers-reduced-motion: reduce){.badge{transition:none}}a.badge:hover,a.badge:focus{text-decoration:none}.badge:empty{display:none}.btn .badge{position:relative;top:-1px}.badge-pill{padding-right:.6em;padding-left:.6em;border-radius:10rem}.badge-primary{color:#fff;background-color:#2F414A}a.badge-primary:hover,a.badge-primary:focus{color:#fff;background-color:#1b262b}a.badge-primary:focus,a.badge-primary.focus{outline:0;box-shadow:0 0 0 .2rem rgba(47,65,74,0.5)}.badge-secondary{color:#212529;background-color:#F47B53}a.badge-secondary:hover,a.badge-secondary:focus{color:#212529;background-color:#f15623}a.badge-secondary:focus,a.badge-secondary.focus{outline:0;box-shadow:0 0 0 .2rem rgba(244,123,83,0.5)}.badge-success{color:#fff;background-color:#420084}a.badge-success:hover,a.badge-success:focus{color:#fff;background-color:#290051}a.badge-success:focus,a.badge-success.focus{outline:0;box-shadow:0 0 0 .2rem rgba(66,0,132,0.5)}.badge-info{color:#212529;background-color:#7ebcfa}a.badge-info:hover,a.badge-info:focus{color:#212529;background-color:#4da3f8}a.badge-info:focus,a.badge-info.focus{outline:0;box-shadow:0 0 0 .2rem rgba(126,188,250,0.5)}.badge-warning{color:#212529;background-color:#f93}a.badge-warning:hover,a.badge-warning:focus{color:#212529;background-color:#ff8000}a.badge-warning:focus,a.badge-warning.focus{outline:0;box-shadow:0 0 0 .2rem rgba(255,153,51,0.5)}.badge-danger{color:#fff;background-color:#f2460d}a.badge-danger:hover,a.badge-danger:focus{color:#fff;background-color:#c2380a}a.badge-danger:focus,a.badge-danger.focus{outline:0;box-shadow:0 0 0 .2rem rgba(242,70,13,0.5)}.badge-light{color:#212529;background-color:#eef0f2}a.badge-light:hover,a.badge-light:focus{color:#212529;background-color:#d1d7dc}a.badge-light:focus,a.badge-light.focus{outline:0;box-shadow:0 0 0 .2rem rgba(238,240,242,0.5)}.badge-dark{color:#fff;background-color:#000633}a.badge-dark:hover,a.badge-dark:focus{color:#fff;background-color:#000}a.badge-dark:focus,a.badge-dark.focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,6,51,0.5)}.jumbotron{padding:2rem 1rem;margin-bottom:2rem;background-color:#e9ecef;border-radius:.3rem}@media (min-width: 576px){.jumbotron{padding:4rem 2rem}}.jumbotron-fluid{padding-right:0;padding-left:0;border-radius:0}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-heading{color:inherit}.alert-link{font-weight:700}.alert-dismissible{padding-right:4rem}.alert-dismissible .close{position:absolute;top:0;right:0;padding:.75rem 1.25rem;color:inherit}.alert-primary{color:#182226;background-color:#d5d9db;border-color:#c5cacc}.alert-primary hr{border-top-color:#b7bec0}.alert-primary .alert-link{color:#040607}.alert-secondary{color:#7f402b;background-color:#fde5dd;border-color:#fcdacf}.alert-secondary hr{border-top-color:#fbc8b7}.alert-secondary .alert-link{color:#592d1e}.alert-success{color:#220045;background-color:#d9cce6;border-color:#cab8dd}.alert-success hr{border-top-color:#bda7d5}.alert-success .alert-link{color:#090012}.alert-info{color:#426282;background-color:#e5f2fe;border-color:#dbecfe}.alert-info hr{border-top-color:#c2dffd}.alert-info .alert-link{color:#314960}.alert-warning{color:#85501b;background-color:#ffebd6;border-color:#ffe2c6}.alert-warning hr{border-top-color:#ffd5ad}.alert-warning .alert-link{color:#5b3712}.alert-danger{color:#7e2407;background-color:#fcdacf;border-color:#fbcbbb}.alert-danger hr{border-top-color:#fab9a3}.alert-danger .alert-link{color:#4e1604}.alert-light{color:#7c7d7e;background-color:#fcfcfc;border-color:#fafbfb}.alert-light hr{border-top-color:#ecf0f0}.alert-light .alert-link{color:#636464}.alert-dark{color:#00031b;background-color:#cccdd6;border-color:#b8b9c6}.alert-dark hr{border-top-color:#aaabbb}.alert-dark .alert-link{color:#000}@keyframes progress-bar-stripes{from{background-position:1rem 0}to{background-position:0 0}}.progress{display:flex;height:1rem;overflow:hidden;line-height:0;font-size:.75rem;background-color:#e9ecef;border-radius:.25rem}.progress-bar{display:flex;flex-direction:column;justify-content:center;overflow:hidden;color:#fff;text-align:center;white-space:nowrap;background-color:#2F414A;transition:width 0.6s ease}@media (prefers-reduced-motion: reduce){.progress-bar{transition:none}}.progress-bar-striped{background-image:linear-gradient(45deg, rgba(255,255,255,0.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.15) 75%, transparent 75%, transparent);background-size:1rem 1rem}.progress-bar-animated{animation:progress-bar-stripes 1s linear infinite}@media (prefers-reduced-motion: reduce){.progress-bar-animated{animation:none}}.media{display:flex;align-items:flex-start}.media-body{flex:1}.list-group{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;border-radius:.25rem}.list-group-item-action{width:100%;color:#495057;text-align:inherit}.list-group-item-action:hover,.list-group-item-action:focus{z-index:1;color:#495057;text-decoration:none;background-color:#f8f9fa}.list-group-item-action:active{color:#212529;background-color:#e9ecef}.list-group-item{position:relative;display:block;padding:.75rem 1.25rem;background-color:#fff;border:1px solid rgba(0,0,0,0.125)}.list-group-item:first-child{border-top-left-radius:inherit;border-top-right-radius:inherit}.list-group-item:last-child{border-bottom-right-radius:inherit;border-bottom-left-radius:inherit}.list-group-item.disabled,.list-group-item:disabled{color:#6c757d;pointer-events:none;background-color:#fff}.list-group-item.active{z-index:2;color:#fff;background-color:#2F414A;border-color:#2F414A}.list-group-item+.list-group-item{border-top-width:0}.list-group-item+.list-group-item.active{margin-top:-1px;border-top-width:1px}.list-group-horizontal{flex-direction:row}.list-group-horizontal>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal>.list-group-item.active{margin-top:0}.list-group-horizontal>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}@media (min-width: 576px){.list-group-horizontal-sm{flex-direction:row}.list-group-horizontal-sm>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-sm>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-sm>.list-group-item.active{margin-top:0}.list-group-horizontal-sm>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-sm>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media (min-width: 768px){.list-group-horizontal-md{flex-direction:row}.list-group-horizontal-md>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-md>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-md>.list-group-item.active{margin-top:0}.list-group-horizontal-md>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-md>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media (min-width: 992px){.list-group-horizontal-lg{flex-direction:row}.list-group-horizontal-lg>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-lg>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-lg>.list-group-item.active{margin-top:0}.list-group-horizontal-lg>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-lg>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}@media (min-width: 1200px){.list-group-horizontal-xl{flex-direction:row}.list-group-horizontal-xl>.list-group-item:first-child{border-bottom-left-radius:.25rem;border-top-right-radius:0}.list-group-horizontal-xl>.list-group-item:last-child{border-top-right-radius:.25rem;border-bottom-left-radius:0}.list-group-horizontal-xl>.list-group-item.active{margin-top:0}.list-group-horizontal-xl>.list-group-item+.list-group-item{border-top-width:1px;border-left-width:0}.list-group-horizontal-xl>.list-group-item+.list-group-item.active{margin-left:-1px;border-left-width:1px}}.list-group-flush{border-radius:0}.list-group-flush>.list-group-item{border-width:0 0 1px}.list-group-flush>.list-group-item:last-child{border-bottom-width:0}.list-group-item-primary{color:#182226;background-color:#c5cacc}.list-group-item-primary.list-group-item-action:hover,.list-group-item-primary.list-group-item-action:focus{color:#182226;background-color:#b7bec0}.list-group-item-primary.list-group-item-action.active{color:#fff;background-color:#182226;border-color:#182226}.list-group-item-secondary{color:#7f402b;background-color:#fcdacf}.list-group-item-secondary.list-group-item-action:hover,.list-group-item-secondary.list-group-item-action:focus{color:#7f402b;background-color:#fbc8b7}.list-group-item-secondary.list-group-item-action.active{color:#fff;background-color:#7f402b;border-color:#7f402b}.list-group-item-success{color:#220045;background-color:#cab8dd}.list-group-item-success.list-group-item-action:hover,.list-group-item-success.list-group-item-action:focus{color:#220045;background-color:#bda7d5}.list-group-item-success.list-group-item-action.active{color:#fff;background-color:#220045;border-color:#220045}.list-group-item-info{color:#426282;background-color:#dbecfe}.list-group-item-info.list-group-item-action:hover,.list-group-item-info.list-group-item-action:focus{color:#426282;background-color:#c2dffd}.list-group-item-info.list-group-item-action.active{color:#fff;background-color:#426282;border-color:#426282}.list-group-item-warning{color:#85501b;background-color:#ffe2c6}.list-group-item-warning.list-group-item-action:hover,.list-group-item-warning.list-group-item-action:focus{color:#85501b;background-color:#ffd5ad}.list-group-item-warning.list-group-item-action.active{color:#fff;background-color:#85501b;border-color:#85501b}.list-group-item-danger{color:#7e2407;background-color:#fbcbbb}.list-group-item-danger.list-group-item-action:hover,.list-group-item-danger.list-group-item-action:focus{color:#7e2407;background-color:#fab9a3}.list-group-item-danger.list-group-item-action.active{color:#fff;background-color:#7e2407;border-color:#7e2407}.list-group-item-light{color:#7c7d7e;background-color:#fafbfb}.list-group-item-light.list-group-item-action:hover,.list-group-item-light.list-group-item-action:focus{color:#7c7d7e;background-color:#ecf0f0}.list-group-item-light.list-group-item-action.active{color:#fff;background-color:#7c7d7e;border-color:#7c7d7e}.list-group-item-dark{color:#00031b;background-color:#b8b9c6}.list-group-item-dark.list-group-item-action:hover,.list-group-item-dark.list-group-item-action:focus{color:#00031b;background-color:#aaabbb}.list-group-item-dark.list-group-item-action.active{color:#fff;background-color:#00031b;border-color:#00031b}.close{float:right;font-size:1.5rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}.close:hover{color:#000;text-decoration:none}.close:not(:disabled):not(.disabled):hover,.close:not(:disabled):not(.disabled):focus{opacity:.75}button.close{padding:0;background-color:transparent;border:0}a.close.disabled{pointer-events:none}.toast{max-width:350px;overflow:hidden;font-size:.875rem;background-color:rgba(255,255,255,0.85);background-clip:padding-box;border:1px solid rgba(0,0,0,0.1);box-shadow:0 0.25rem 0.75rem rgba(0,0,0,0.1);backdrop-filter:blur(10px);opacity:0;border-radius:.25rem}.toast:not(:last-child){margin-bottom:.75rem}.toast.showing{opacity:1}.toast.show{display:block;opacity:1}.toast.hide{display:none}.toast-header{display:flex;align-items:center;padding:.25rem .75rem;color:#6c757d;background-color:rgba(255,255,255,0.85);background-clip:padding-box;border-bottom:1px solid rgba(0,0,0,0.05)}.toast-body{padding:.75rem}.modal-open{overflow:hidden}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal{position:fixed;top:0;left:0;z-index:1050;display:none;width:100%;height:100%;overflow:hidden;outline:0}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:transform 0.3s ease-out;transform:translate(0, -50px)}@media (prefers-reduced-motion: reduce){.modal.fade .modal-dialog{transition:none}}.modal.show .modal-dialog{transform:none}.modal.modal-static .modal-dialog{transform:scale(1.02)}.modal-dialog-scrollable{display:flex;max-height:calc(100% - 1rem)}.modal-dialog-scrollable .modal-content{max-height:calc(100vh - 1rem);overflow:hidden}.modal-dialog-scrollable .modal-header,.modal-dialog-scrollable .modal-footer{flex-shrink:0}.modal-dialog-scrollable .modal-body{overflow-y:auto}.modal-dialog-centered{display:flex;align-items:center;min-height:calc(100% - 1rem)}.modal-dialog-centered::before{display:block;height:calc(100vh - 1rem);height:min-content;content:""}.modal-dialog-centered.modal-dialog-scrollable{flex-direction:column;justify-content:center;height:100%}.modal-dialog-centered.modal-dialog-scrollable .modal-content{max-height:none}.modal-dialog-centered.modal-dialog-scrollable::before{content:none}.modal-content{position:relative;display:flex;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,0.2);border-radius:.3rem;outline:0}.modal-backdrop{position:fixed;top:0;left:0;z-index:1040;width:100vw;height:100vh;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:flex;align-items:flex-start;justify-content:space-between;padding:1rem 1rem;border-bottom:1px solid #dee2e6;border-top-left-radius:calc(.3rem - 1px);border-top-right-radius:calc(.3rem - 1px)}.modal-header .close{padding:1rem 1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;flex:1 1 auto;padding:1rem}.modal-footer{display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;padding:.75rem;border-top:1px solid #dee2e6;border-bottom-right-radius:calc(.3rem - 1px);border-bottom-left-radius:calc(.3rem - 1px)}.modal-footer>*{margin:.25rem}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width: 576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-dialog-scrollable{max-height:calc(100% - 3.5rem)}.modal-dialog-scrollable .modal-content{max-height:calc(100vh - 3.5rem)}.modal-dialog-centered{min-height:calc(100% - 3.5rem)}.modal-dialog-centered::before{height:calc(100vh - 3.5rem);height:min-content}.modal-sm{max-width:300px}}@media (min-width: 992px){.modal-lg,.modal-xl{max-width:800px}}@media (min-width: 1200px){.modal-xl{max-width:1140px}}.tooltip{position:absolute;z-index:1070;display:block;margin:0;font-family:Segoe UI;font-style:normal;font-weight:400;line-height:1.5;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;white-space:normal;line-break:auto;font-size:.875rem;word-wrap:break-word;opacity:0}.tooltip.show{opacity:.9}.tooltip .arrow{position:absolute;display:block;width:.8rem;height:.4rem}.tooltip .arrow::before{position:absolute;content:"";border-color:transparent;border-style:solid}.bs-tooltip-top,.bs-tooltip-auto[x-placement^="top"]{padding:.4rem 0}.bs-tooltip-top .arrow,.bs-tooltip-auto[x-placement^="top"] .arrow{bottom:0}.bs-tooltip-top .arrow::before,.bs-tooltip-auto[x-placement^="top"] .arrow::before{top:0;border-width:.4rem .4rem 0;border-top-color:#000}.bs-tooltip-right,.bs-tooltip-auto[x-placement^="right"]{padding:0 .4rem}.bs-tooltip-right .arrow,.bs-tooltip-auto[x-placement^="right"] .arrow{left:0;width:.4rem;height:.8rem}.bs-tooltip-right .arrow::before,.bs-tooltip-auto[x-placement^="right"] .arrow::before{right:0;border-width:.4rem .4rem .4rem 0;border-right-color:#000}.bs-tooltip-bottom,.bs-tooltip-auto[x-placement^="bottom"]{padding:.4rem 0}.bs-tooltip-bottom .arrow,.bs-tooltip-auto[x-placement^="bottom"] .arrow{top:0}.bs-tooltip-bottom .arrow::before,.bs-tooltip-auto[x-placement^="bottom"] .arrow::before{bottom:0;border-width:0 .4rem .4rem;border-bottom-color:#000}.bs-tooltip-left,.bs-tooltip-auto[x-placement^="left"]{padding:0 .4rem}.bs-tooltip-left .arrow,.bs-tooltip-auto[x-placement^="left"] .arrow{right:0;width:.4rem;height:.8rem}.bs-tooltip-left .arrow::before,.bs-tooltip-auto[x-placement^="left"] .arrow::before{left:0;border-width:.4rem 0 .4rem .4rem;border-left-color:#000}.tooltip-inner{max-width:200px;padding:.25rem .5rem;color:#fff;text-align:center;background-color:#000;border-radius:.25rem}.popover{position:absolute;top:0;left:0;z-index:1060;display:block;max-width:276px;font-family:Segoe UI;font-style:normal;font-weight:400;line-height:1.5;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;white-space:normal;line-break:auto;font-size:.875rem;word-wrap:break-word;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,0.2);border-radius:.3rem}.popover .arrow{position:absolute;display:block;width:1rem;height:.5rem;margin:0 .3rem}.popover .arrow::before,.popover .arrow::after{position:absolute;display:block;content:"";border-color:transparent;border-style:solid}.bs-popover-top,.bs-popover-auto[x-placement^="top"]{margin-bottom:.5rem}.bs-popover-top>.arrow,.bs-popover-auto[x-placement^="top"]>.arrow{bottom:calc(-.5rem - 1px)}.bs-popover-top>.arrow::before,.bs-popover-auto[x-placement^="top"]>.arrow::before{bottom:0;border-width:.5rem .5rem 0;border-top-color:rgba(0,0,0,0.25)}.bs-popover-top>.arrow::after,.bs-popover-auto[x-placement^="top"]>.arrow::after{bottom:1px;border-width:.5rem .5rem 0;border-top-color:#fff}.bs-popover-right,.bs-popover-auto[x-placement^="right"]{margin-left:.5rem}.bs-popover-right>.arrow,.bs-popover-auto[x-placement^="right"]>.arrow{left:calc(-.5rem - 1px);width:.5rem;height:1rem;margin:.3rem 0}.bs-popover-right>.arrow::before,.bs-popover-auto[x-placement^="right"]>.arrow::before{left:0;border-width:.5rem .5rem .5rem 0;border-right-color:rgba(0,0,0,0.25)}.bs-popover-right>.arrow::after,.bs-popover-auto[x-placement^="right"]>.arrow::after{left:1px;border-width:.5rem .5rem .5rem 0;border-right-color:#fff}.bs-popover-bottom,.bs-popover-auto[x-placement^="bottom"]{margin-top:.5rem}.bs-popover-bottom>.arrow,.bs-popover-auto[x-placement^="bottom"]>.arrow{top:calc(-.5rem - 1px)}.bs-popover-bottom>.arrow::before,.bs-popover-auto[x-placement^="bottom"]>.arrow::before{top:0;border-width:0 .5rem .5rem .5rem;border-bottom-color:rgba(0,0,0,0.25)}.bs-popover-bottom>.arrow::after,.bs-popover-auto[x-placement^="bottom"]>.arrow::after{top:1px;border-width:0 .5rem .5rem .5rem;border-bottom-color:#fff}.bs-popover-bottom .popover-header::before,.bs-popover-auto[x-placement^="bottom"] .popover-header::before{position:absolute;top:0;left:50%;display:block;width:1rem;margin-left:-.5rem;content:"";border-bottom:1px solid #f7f7f7}.bs-popover-left,.bs-popover-auto[x-placement^="left"]{margin-right:.5rem}.bs-popover-left>.arrow,.bs-popover-auto[x-placement^="left"]>.arrow{right:calc(-.5rem - 1px);width:.5rem;height:1rem;margin:.3rem 0}.bs-popover-left>.arrow::before,.bs-popover-auto[x-placement^="left"]>.arrow::before{right:0;border-width:.5rem 0 .5rem .5rem;border-left-color:rgba(0,0,0,0.25)}.bs-popover-left>.arrow::after,.bs-popover-auto[x-placement^="left"]>.arrow::after{right:1px;border-width:.5rem 0 .5rem .5rem;border-left-color:#fff}.popover-header{padding:.5rem .75rem;margin-bottom:0;font-size:1rem;background-color:#f7f7f7;border-bottom:1px solid #ebebeb;border-top-left-radius:calc(.3rem - 1px);border-top-right-radius:calc(.3rem - 1px)}.popover-header:empty{display:none}.popover-body{padding:.5rem .75rem;color:#212529}.carousel{position:relative}.carousel.pointer-event{touch-action:pan-y}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:""}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;backface-visibility:hidden;transition:transform .6s ease-in-out}@media (prefers-reduced-motion: reduce){.carousel-item{transition:none}}.carousel-item.active,.carousel-item-next,.carousel-item-prev{display:block}.carousel-item-next:not(.carousel-item-left),.active.carousel-item-right{transform:translateX(100%)}.carousel-item-prev:not(.carousel-item-right),.active.carousel-item-left{transform:translateX(-100%)}.carousel-fade .carousel-item{opacity:0;transition-property:opacity;transform:none}.carousel-fade .carousel-item.active,.carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right{z-index:1;opacity:1}.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right{z-index:0;opacity:0;transition:opacity 0s .6s}@media (prefers-reduced-motion: reduce){.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right{transition:none}}.carousel-control-prev,.carousel-control-next{position:absolute;top:0;bottom:0;z-index:1;display:flex;align-items:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5;transition:opacity 0.15s ease}@media (prefers-reduced-motion: reduce){.carousel-control-prev,.carousel-control-next{transition:none}}.carousel-control-prev:hover,.carousel-control-prev:focus,.carousel-control-next:hover,.carousel-control-next:focus{color:#fff;text-decoration:none;outline:0;opacity:.9}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-prev-icon,.carousel-control-next-icon{display:inline-block;width:20px;height:20px;background:no-repeat 50% / 100% 100%}.carousel-control-prev-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e")}.carousel-control-next-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e")}.carousel-indicators{position:absolute;right:0;bottom:0;left:0;z-index:15;display:flex;justify-content:center;padding-left:0;margin-right:15%;margin-left:15%;list-style:none}.carousel-indicators li{box-sizing:content-box;flex:0 1 auto;width:30px;height:3px;margin-right:3px;margin-left:3px;text-indent:-999px;cursor:pointer;background-color:#fff;background-clip:padding-box;border-top:10px solid transparent;border-bottom:10px solid transparent;opacity:.5;transition:opacity 0.6s ease}@media (prefers-reduced-motion: reduce){.carousel-indicators li{transition:none}}.carousel-indicators .active{opacity:1}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center}@keyframes spinner-border{to{transform:rotate(360deg)}}.spinner-border{display:inline-block;width:2rem;height:2rem;vertical-align:text-bottom;border:.25em solid currentColor;border-right-color:transparent;border-radius:50%;animation:spinner-border .75s linear infinite}.spinner-border-sm{width:1rem;height:1rem;border-width:.2em}@keyframes spinner-grow{0%{transform:scale(0)}50%{opacity:1;transform:none}}.spinner-grow{display:inline-block;width:2rem;height:2rem;vertical-align:text-bottom;background-color:currentColor;border-radius:50%;opacity:0;animation:spinner-grow .75s linear infinite}.spinner-grow-sm{width:1rem;height:1rem}.align-baseline{vertical-align:baseline !important}.align-top{vertical-align:top !important}.align-middle{vertical-align:middle !important}.align-bottom{vertical-align:bottom !important}.align-text-bottom{vertical-align:text-bottom !important}.align-text-top{vertical-align:text-top !important}.bg-primary{background-color:#2F414A !important}a.bg-primary:hover,a.bg-primary:focus,button.bg-primary:hover,button.bg-primary:focus{background-color:#1b262b !important}.bg-secondary{background-color:#F47B53 !important}a.bg-secondary:hover,a.bg-secondary:focus,button.bg-secondary:hover,button.bg-secondary:focus{background-color:#f15623 !important}.bg-success{background-color:#420084 !important}a.bg-success:hover,a.bg-success:focus,button.bg-success:hover,button.bg-success:focus{background-color:#290051 !important}.bg-info{background-color:#7ebcfa !important}a.bg-info:hover,a.bg-info:focus,button.bg-info:hover,button.bg-info:focus{background-color:#4da3f8 !important}.bg-warning{background-color:#f93 !important}a.bg-warning:hover,a.bg-warning:focus,button.bg-warning:hover,button.bg-warning:focus{background-color:#ff8000 !important}.bg-danger{background-color:#f2460d !important}a.bg-danger:hover,a.bg-danger:focus,button.bg-danger:hover,button.bg-danger:focus{background-color:#c2380a !important}.bg-light{background-color:#eef0f2 !important}a.bg-light:hover,a.bg-light:focus,button.bg-light:hover,button.bg-light:focus{background-color:#d1d7dc !important}.bg-dark{background-color:#000633 !important}a.bg-dark:hover,a.bg-dark:focus,button.bg-dark:hover,button.bg-dark:focus{background-color:#000 !important}.bg-white{background-color:#fff !important}.bg-transparent{background-color:transparent !important}.border{border:1px solid #dee2e6 !important}.border-top{border-top:1px solid #dee2e6 !important}.border-right{border-right:1px solid #dee2e6 !important}.border-bottom{border-bottom:1px solid #dee2e6 !important}.border-left{border-left:1px solid #dee2e6 !important}.border-0{border:0 !important}.border-top-0{border-top:0 !important}.border-right-0{border-right:0 !important}.border-bottom-0{border-bottom:0 !important}.border-left-0{border-left:0 !important}.border-primary{border-color:#2F414A !important}.border-secondary{border-color:#F47B53 !important}.border-success{border-color:#420084 !important}.border-info{border-color:#7ebcfa !important}.border-warning{border-color:#f93 !important}.border-danger{border-color:#f2460d !important}.border-light{border-color:#eef0f2 !important}.border-dark{border-color:#000633 !important}.border-white{border-color:#fff !important}.rounded-sm{border-radius:.2rem !important}.rounded{border-radius:.25rem !important}.rounded-top{border-top-left-radius:.25rem !important;border-top-right-radius:.25rem !important}.rounded-right{border-top-right-radius:.25rem !important;border-bottom-right-radius:.25rem !important}.rounded-bottom{border-bottom-right-radius:.25rem !important;border-bottom-left-radius:.25rem !important}.rounded-left{border-top-left-radius:.25rem !important;border-bottom-left-radius:.25rem !important}.rounded-lg{border-radius:.3rem !important}.rounded-circle{border-radius:50% !important}.rounded-pill{border-radius:50rem !important}.rounded-0{border-radius:0 !important}.clearfix::after{display:block;clear:both;content:""}.d-none{display:none !important}.d-inline{display:inline !important}.d-inline-block{display:inline-block !important}.d-block{display:block !important}.d-table{display:table !important}.d-table-row{display:table-row !important}.d-table-cell{display:table-cell !important}.d-flex{display:flex !important}.d-inline-flex{display:inline-flex !important}@media (min-width: 576px){.d-sm-none{display:none !important}.d-sm-inline{display:inline !important}.d-sm-inline-block{display:inline-block !important}.d-sm-block{display:block !important}.d-sm-table{display:table !important}.d-sm-table-row{display:table-row !important}.d-sm-table-cell{display:table-cell !important}.d-sm-flex{display:flex !important}.d-sm-inline-flex{display:inline-flex !important}}@media (min-width: 768px){.d-md-none{display:none !important}.d-md-inline{display:inline !important}.d-md-inline-block{display:inline-block !important}.d-md-block{display:block !important}.d-md-table{display:table !important}.d-md-table-row{display:table-row !important}.d-md-table-cell{display:table-cell !important}.d-md-flex{display:flex !important}.d-md-inline-flex{display:inline-flex !important}}@media (min-width: 992px){.d-lg-none{display:none !important}.d-lg-inline{display:inline !important}.d-lg-inline-block{display:inline-block !important}.d-lg-block{display:block !important}.d-lg-table{display:table !important}.d-lg-table-row{display:table-row !important}.d-lg-table-cell{display:table-cell !important}.d-lg-flex{display:flex !important}.d-lg-inline-flex{display:inline-flex !important}}@media (min-width: 1200px){.d-xl-none{display:none !important}.d-xl-inline{display:inline !important}.d-xl-inline-block{display:inline-block !important}.d-xl-block{display:block !important}.d-xl-table{display:table !important}.d-xl-table-row{display:table-row !important}.d-xl-table-cell{display:table-cell !important}.d-xl-flex{display:flex !important}.d-xl-inline-flex{display:inline-flex !important}}@media print{.d-print-none{display:none !important}.d-print-inline{display:inline !important}.d-print-inline-block{display:inline-block !important}.d-print-block{display:block !important}.d-print-table{display:table !important}.d-print-table-row{display:table-row !important}.d-print-table-cell{display:table-cell !important}.d-print-flex{display:flex !important}.d-print-inline-flex{display:inline-flex !important}}.embed-responsive{position:relative;display:block;width:100%;padding:0;overflow:hidden}.embed-responsive::before{display:block;content:""}.embed-responsive .embed-responsive-item,.embed-responsive iframe,.embed-responsive embed,.embed-responsive object,.embed-responsive video{position:absolute;top:0;bottom:0;left:0;width:100%;height:100%;border:0}.embed-responsive-21by9::before{padding-top:42.85714%}.embed-responsive-16by9::before{padding-top:56.25%}.embed-responsive-4by3::before{padding-top:75%}.embed-responsive-1by1::before{padding-top:100%}.flex-row{flex-direction:row !important}.flex-column{flex-direction:column !important}.flex-row-reverse{flex-direction:row-reverse !important}.flex-column-reverse{flex-direction:column-reverse !important}.flex-wrap{flex-wrap:wrap !important}.flex-nowrap{flex-wrap:nowrap !important}.flex-wrap-reverse{flex-wrap:wrap-reverse !important}.flex-fill{flex:1 1 auto !important}.flex-grow-0{flex-grow:0 !important}.flex-grow-1{flex-grow:1 !important}.flex-shrink-0{flex-shrink:0 !important}.flex-shrink-1{flex-shrink:1 !important}.justify-content-start{justify-content:flex-start !important}.justify-content-end{justify-content:flex-end !important}.justify-content-center{justify-content:center !important}.justify-content-between{justify-content:space-between !important}.justify-content-around{justify-content:space-around !important}.align-items-start{align-items:flex-start !important}.align-items-end{align-items:flex-end !important}.align-items-center{align-items:center !important}.align-items-baseline{align-items:baseline !important}.align-items-stretch{align-items:stretch !important}.align-content-start{align-content:flex-start !important}.align-content-end{align-content:flex-end !important}.align-content-center{align-content:center !important}.align-content-between{align-content:space-between !important}.align-content-around{align-content:space-around !important}.align-content-stretch{align-content:stretch !important}.align-self-auto{align-self:auto !important}.align-self-start{align-self:flex-start !important}.align-self-end{align-self:flex-end !important}.align-self-center{align-self:center !important}.align-self-baseline{align-self:baseline !important}.align-self-stretch{align-self:stretch !important}@media (min-width: 576px){.flex-sm-row{flex-direction:row !important}.flex-sm-column{flex-direction:column !important}.flex-sm-row-reverse{flex-direction:row-reverse !important}.flex-sm-column-reverse{flex-direction:column-reverse !important}.flex-sm-wrap{flex-wrap:wrap !important}.flex-sm-nowrap{flex-wrap:nowrap !important}.flex-sm-wrap-reverse{flex-wrap:wrap-reverse !important}.flex-sm-fill{flex:1 1 auto !important}.flex-sm-grow-0{flex-grow:0 !important}.flex-sm-grow-1{flex-grow:1 !important}.flex-sm-shrink-0{flex-shrink:0 !important}.flex-sm-shrink-1{flex-shrink:1 !important}.justify-content-sm-start{justify-content:flex-start !important}.justify-content-sm-end{justify-content:flex-end !important}.justify-content-sm-center{justify-content:center !important}.justify-content-sm-between{justify-content:space-between !important}.justify-content-sm-around{justify-content:space-around !important}.align-items-sm-start{align-items:flex-start !important}.align-items-sm-end{align-items:flex-end !important}.align-items-sm-center{align-items:center !important}.align-items-sm-baseline{align-items:baseline !important}.align-items-sm-stretch{align-items:stretch !important}.align-content-sm-start{align-content:flex-start !important}.align-content-sm-end{align-content:flex-end !important}.align-content-sm-center{align-content:center !important}.align-content-sm-between{align-content:space-between !important}.align-content-sm-around{align-content:space-around !important}.align-content-sm-stretch{align-content:stretch !important}.align-self-sm-auto{align-self:auto !important}.align-self-sm-start{align-self:flex-start !important}.align-self-sm-end{align-self:flex-end !important}.align-self-sm-center{align-self:center !important}.align-self-sm-baseline{align-self:baseline !important}.align-self-sm-stretch{align-self:stretch !important}}@media (min-width: 768px){.flex-md-row{flex-direction:row !important}.flex-md-column{flex-direction:column !important}.flex-md-row-reverse{flex-direction:row-reverse !important}.flex-md-column-reverse{flex-direction:column-reverse !important}.flex-md-wrap{flex-wrap:wrap !important}.flex-md-nowrap{flex-wrap:nowrap !important}.flex-md-wrap-reverse{flex-wrap:wrap-reverse !important}.flex-md-fill{flex:1 1 auto !important}.flex-md-grow-0{flex-grow:0 !important}.flex-md-grow-1{flex-grow:1 !important}.flex-md-shrink-0{flex-shrink:0 !important}.flex-md-shrink-1{flex-shrink:1 !important}.justify-content-md-start{justify-content:flex-start !important}.justify-content-md-end{justify-content:flex-end !important}.justify-content-md-center{justify-content:center !important}.justify-content-md-between{justify-content:space-between !important}.justify-content-md-around{justify-content:space-around !important}.align-items-md-start{align-items:flex-start !important}.align-items-md-end{align-items:flex-end !important}.align-items-md-center{align-items:center !important}.align-items-md-baseline{align-items:baseline !important}.align-items-md-stretch{align-items:stretch !important}.align-content-md-start{align-content:flex-start !important}.align-content-md-end{align-content:flex-end !important}.align-content-md-center{align-content:center !important}.align-content-md-between{align-content:space-between !important}.align-content-md-around{align-content:space-around !important}.align-content-md-stretch{align-content:stretch !important}.align-self-md-auto{align-self:auto !important}.align-self-md-start{align-self:flex-start !important}.align-self-md-end{align-self:flex-end !important}.align-self-md-center{align-self:center !important}.align-self-md-baseline{align-self:baseline !important}.align-self-md-stretch{align-self:stretch !important}}@media (min-width: 992px){.flex-lg-row{flex-direction:row !important}.flex-lg-column{flex-direction:column !important}.flex-lg-row-reverse{flex-direction:row-reverse !important}.flex-lg-column-reverse{flex-direction:column-reverse !important}.flex-lg-wrap{flex-wrap:wrap !important}.flex-lg-nowrap{flex-wrap:nowrap !important}.flex-lg-wrap-reverse{flex-wrap:wrap-reverse !important}.flex-lg-fill{flex:1 1 auto !important}.flex-lg-grow-0{flex-grow:0 !important}.flex-lg-grow-1{flex-grow:1 !important}.flex-lg-shrink-0{flex-shrink:0 !important}.flex-lg-shrink-1{flex-shrink:1 !important}.justify-content-lg-start{justify-content:flex-start !important}.justify-content-lg-end{justify-content:flex-end !important}.justify-content-lg-center{justify-content:center !important}.justify-content-lg-between{justify-content:space-between !important}.justify-content-lg-around{justify-content:space-around !important}.align-items-lg-start{align-items:flex-start !important}.align-items-lg-end{align-items:flex-end !important}.align-items-lg-center{align-items:center !important}.align-items-lg-baseline{align-items:baseline !important}.align-items-lg-stretch{align-items:stretch !important}.align-content-lg-start{align-content:flex-start !important}.align-content-lg-end{align-content:flex-end !important}.align-content-lg-center{align-content:center !important}.align-content-lg-between{align-content:space-between !important}.align-content-lg-around{align-content:space-around !important}.align-content-lg-stretch{align-content:stretch !important}.align-self-lg-auto{align-self:auto !important}.align-self-lg-start{align-self:flex-start !important}.align-self-lg-end{align-self:flex-end !important}.align-self-lg-center{align-self:center !important}.align-self-lg-baseline{align-self:baseline !important}.align-self-lg-stretch{align-self:stretch !important}}@media (min-width: 1200px){.flex-xl-row{flex-direction:row !important}.flex-xl-column{flex-direction:column !important}.flex-xl-row-reverse{flex-direction:row-reverse !important}.flex-xl-column-reverse{flex-direction:column-reverse !important}.flex-xl-wrap{flex-wrap:wrap !important}.flex-xl-nowrap{flex-wrap:nowrap !important}.flex-xl-wrap-reverse{flex-wrap:wrap-reverse !important}.flex-xl-fill{flex:1 1 auto !important}.flex-xl-grow-0{flex-grow:0 !important}.flex-xl-grow-1{flex-grow:1 !important}.flex-xl-shrink-0{flex-shrink:0 !important}.flex-xl-shrink-1{flex-shrink:1 !important}.justify-content-xl-start{justify-content:flex-start !important}.justify-content-xl-end{justify-content:flex-end !important}.justify-content-xl-center{justify-content:center !important}.justify-content-xl-between{justify-content:space-between !important}.justify-content-xl-around{justify-content:space-around !important}.align-items-xl-start{align-items:flex-start !important}.align-items-xl-end{align-items:flex-end !important}.align-items-xl-center{align-items:center !important}.align-items-xl-baseline{align-items:baseline !important}.align-items-xl-stretch{align-items:stretch !important}.align-content-xl-start{align-content:flex-start !important}.align-content-xl-end{align-content:flex-end !important}.align-content-xl-center{align-content:center !important}.align-content-xl-between{align-content:space-between !important}.align-content-xl-around{align-content:space-around !important}.align-content-xl-stretch{align-content:stretch !important}.align-self-xl-auto{align-self:auto !important}.align-self-xl-start{align-self:flex-start !important}.align-self-xl-end{align-self:flex-end !important}.align-self-xl-center{align-self:center !important}.align-self-xl-baseline{align-self:baseline !important}.align-self-xl-stretch{align-self:stretch !important}}.float-left{float:left !important}.float-right{float:right !important}.float-none{float:none !important}@media (min-width: 576px){.float-sm-left{float:left !important}.float-sm-right{float:right !important}.float-sm-none{float:none !important}}@media (min-width: 768px){.float-md-left{float:left !important}.float-md-right{float:right !important}.float-md-none{float:none !important}}@media (min-width: 992px){.float-lg-left{float:left !important}.float-lg-right{float:right !important}.float-lg-none{float:none !important}}@media (min-width: 1200px){.float-xl-left{float:left !important}.float-xl-right{float:right !important}.float-xl-none{float:none !important}}.user-select-all{user-select:all !important}.user-select-auto{user-select:auto !important}.user-select-none{user-select:none !important}.overflow-auto{overflow:auto !important}.overflow-hidden{overflow:hidden !important}.position-static{position:static !important}.position-relative{position:relative !important}.position-absolute{position:absolute !important}.position-fixed{position:fixed !important}.position-sticky{position:sticky !important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.fixed-bottom{position:fixed;right:0;bottom:0;left:0;z-index:1030}@supports (position: sticky){.sticky-top{position:sticky;top:0;z-index:1020}}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0, 0, 0, 0);white-space:nowrap;border:0}.sr-only-focusable:active,.sr-only-focusable:focus{position:static;width:auto;height:auto;overflow:visible;clip:auto;white-space:normal}.shadow-sm{box-shadow:0 0.125rem 0.25rem rgba(0,0,0,0.075) !important}.shadow{box-shadow:0 0.5rem 1rem rgba(0,0,0,0.15) !important}.shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,0.175) !important}.shadow-none{box-shadow:none !important}.w-25{width:25% !important}.w-50{width:50% !important}.w-75{width:75% !important}.w-100{width:100% !important}.w-auto{width:auto !important}.h-25{height:25% !important}.h-50{height:50% !important}.h-75{height:75% !important}.h-100{height:100% !important}.h-auto{height:auto !important}.mw-100{max-width:100% !important}.mh-100{max-height:100% !important}.min-vw-100{min-width:100vw !important}.min-vh-100{min-height:100vh !important}.vw-100{width:100vw !important}.vh-100{height:100vh !important}.m-0{margin:0 !important}.mt-0,.my-0{margin-top:0 !important}.mr-0,.mx-0{margin-right:0 !important}.mb-0,.my-0{margin-bottom:0 !important}.ml-0,.mx-0{margin-left:0 !important}.m-1{margin:.25rem !important}.mt-1,.my-1{margin-top:.25rem !important}.mr-1,.mx-1{margin-right:.25rem !important}.mb-1,.my-1{margin-bottom:.25rem !important}.ml-1,.mx-1{margin-left:.25rem !important}.m-2{margin:.5rem !important}.mt-2,.my-2{margin-top:.5rem !important}.mr-2,.mx-2{margin-right:.5rem !important}.mb-2,.my-2{margin-bottom:.5rem !important}.ml-2,.mx-2{margin-left:.5rem !important}.m-3{margin:1rem !important}.mt-3,.my-3{margin-top:1rem !important}.mr-3,.mx-3{margin-right:1rem !important}.mb-3,.my-3{margin-bottom:1rem !important}.ml-3,.mx-3{margin-left:1rem !important}.m-4{margin:1.5rem !important}.mt-4,.my-4{margin-top:1.5rem !important}.mr-4,.mx-4{margin-right:1.5rem !important}.mb-4,.my-4{margin-bottom:1.5rem !important}.ml-4,.mx-4{margin-left:1.5rem !important}.m-5{margin:3rem !important}.mt-5,.my-5{margin-top:3rem !important}.mr-5,.mx-5{margin-right:3rem !important}.mb-5,.my-5{margin-bottom:3rem !important}.ml-5,.mx-5{margin-left:3rem !important}.p-0{padding:0 !important}.pt-0,.py-0{padding-top:0 !important}.pr-0,.px-0{padding-right:0 !important}.pb-0,.py-0{padding-bottom:0 !important}.pl-0,.px-0{padding-left:0 !important}.p-1{padding:.25rem !important}.pt-1,.py-1{padding-top:.25rem !important}.pr-1,.px-1{padding-right:.25rem !important}.pb-1,.py-1{padding-bottom:.25rem !important}.pl-1,.px-1{padding-left:.25rem !important}.p-2{padding:.5rem !important}.pt-2,.py-2{padding-top:.5rem !important}.pr-2,.px-2{padding-right:.5rem !important}.pb-2,.py-2{padding-bottom:.5rem !important}.pl-2,.px-2{padding-left:.5rem !important}.p-3{padding:1rem !important}.pt-3,.py-3{padding-top:1rem !important}.pr-3,.px-3{padding-right:1rem !important}.pb-3,.py-3{padding-bottom:1rem !important}.pl-3,.px-3{padding-left:1rem !important}.p-4{padding:1.5rem !important}.pt-4,.py-4{padding-top:1.5rem !important}.pr-4,.px-4{padding-right:1.5rem !important}.pb-4,.py-4{padding-bottom:1.5rem !important}.pl-4,.px-4{padding-left:1.5rem !important}.p-5{padding:3rem !important}.pt-5,.py-5{padding-top:3rem !important}.pr-5,.px-5{padding-right:3rem !important}.pb-5,.py-5{padding-bottom:3rem !important}.pl-5,.px-5{padding-left:3rem !important}.m-n1{margin:-.25rem !important}.mt-n1,.my-n1{margin-top:-.25rem !important}.mr-n1,.mx-n1{margin-right:-.25rem !important}.mb-n1,.my-n1{margin-bottom:-.25rem !important}.ml-n1,.mx-n1{margin-left:-.25rem !important}.m-n2{margin:-.5rem !important}.mt-n2,.my-n2{margin-top:-.5rem !important}.mr-n2,.mx-n2{margin-right:-.5rem !important}.mb-n2,.my-n2{margin-bottom:-.5rem !important}.ml-n2,.mx-n2{margin-left:-.5rem !important}.m-n3{margin:-1rem !important}.mt-n3,.my-n3{margin-top:-1rem !important}.mr-n3,.mx-n3{margin-right:-1rem !important}.mb-n3,.my-n3{margin-bottom:-1rem !important}.ml-n3,.mx-n3{margin-left:-1rem !important}.m-n4{margin:-1.5rem !important}.mt-n4,.my-n4{margin-top:-1.5rem !important}.mr-n4,.mx-n4{margin-right:-1.5rem !important}.mb-n4,.my-n4{margin-bottom:-1.5rem !important}.ml-n4,.mx-n4{margin-left:-1.5rem !important}.m-n5{margin:-3rem !important}.mt-n5,.my-n5{margin-top:-3rem !important}.mr-n5,.mx-n5{margin-right:-3rem !important}.mb-n5,.my-n5{margin-bottom:-3rem !important}.ml-n5,.mx-n5{margin-left:-3rem !important}.m-auto{margin:auto !important}.mt-auto,.my-auto{margin-top:auto !important}.mr-auto,.mx-auto{margin-right:auto !important}.mb-auto,.my-auto{margin-bottom:auto !important}.ml-auto,.mx-auto{margin-left:auto !important}@media (min-width: 576px){.m-sm-0{margin:0 !important}.mt-sm-0,.my-sm-0{margin-top:0 !important}.mr-sm-0,.mx-sm-0{margin-right:0 !important}.mb-sm-0,.my-sm-0{margin-bottom:0 !important}.ml-sm-0,.mx-sm-0{margin-left:0 !important}.m-sm-1{margin:.25rem !important}.mt-sm-1,.my-sm-1{margin-top:.25rem !important}.mr-sm-1,.mx-sm-1{margin-right:.25rem !important}.mb-sm-1,.my-sm-1{margin-bottom:.25rem !important}.ml-sm-1,.mx-sm-1{margin-left:.25rem !important}.m-sm-2{margin:.5rem !important}.mt-sm-2,.my-sm-2{margin-top:.5rem !important}.mr-sm-2,.mx-sm-2{margin-right:.5rem !important}.mb-sm-2,.my-sm-2{margin-bottom:.5rem !important}.ml-sm-2,.mx-sm-2{margin-left:.5rem !important}.m-sm-3{margin:1rem !important}.mt-sm-3,.my-sm-3{margin-top:1rem !important}.mr-sm-3,.mx-sm-3{margin-right:1rem !important}.mb-sm-3,.my-sm-3{margin-bottom:1rem !important}.ml-sm-3,.mx-sm-3{margin-left:1rem !important}.m-sm-4{margin:1.5rem !important}.mt-sm-4,.my-sm-4{margin-top:1.5rem !important}.mr-sm-4,.mx-sm-4{margin-right:1.5rem !important}.mb-sm-4,.my-sm-4{margin-bottom:1.5rem !important}.ml-sm-4,.mx-sm-4{margin-left:1.5rem !important}.m-sm-5{margin:3rem !important}.mt-sm-5,.my-sm-5{margin-top:3rem !important}.mr-sm-5,.mx-sm-5{margin-right:3rem !important}.mb-sm-5,.my-sm-5{margin-bottom:3rem !important}.ml-sm-5,.mx-sm-5{margin-left:3rem !important}.p-sm-0{padding:0 !important}.pt-sm-0,.py-sm-0{padding-top:0 !important}.pr-sm-0,.px-sm-0{padding-right:0 !important}.pb-sm-0,.py-sm-0{padding-bottom:0 !important}.pl-sm-0,.px-sm-0{padding-left:0 !important}.p-sm-1{padding:.25rem !important}.pt-sm-1,.py-sm-1{padding-top:.25rem !important}.pr-sm-1,.px-sm-1{padding-right:.25rem !important}.pb-sm-1,.py-sm-1{padding-bottom:.25rem !important}.pl-sm-1,.px-sm-1{padding-left:.25rem !important}.p-sm-2{padding:.5rem !important}.pt-sm-2,.py-sm-2{padding-top:.5rem !important}.pr-sm-2,.px-sm-2{padding-right:.5rem !important}.pb-sm-2,.py-sm-2{padding-bottom:.5rem !important}.pl-sm-2,.px-sm-2{padding-left:.5rem !important}.p-sm-3{padding:1rem !important}.pt-sm-3,.py-sm-3{padding-top:1rem !important}.pr-sm-3,.px-sm-3{padding-right:1rem !important}.pb-sm-3,.py-sm-3{padding-bottom:1rem !important}.pl-sm-3,.px-sm-3{padding-left:1rem !important}.p-sm-4{padding:1.5rem !important}.pt-sm-4,.py-sm-4{padding-top:1.5rem !important}.pr-sm-4,.px-sm-4{padding-right:1.5rem !important}.pb-sm-4,.py-sm-4{padding-bottom:1.5rem !important}.pl-sm-4,.px-sm-4{padding-left:1.5rem !important}.p-sm-5{padding:3rem !important}.pt-sm-5,.py-sm-5{padding-top:3rem !important}.pr-sm-5,.px-sm-5{padding-right:3rem !important}.pb-sm-5,.py-sm-5{padding-bottom:3rem !important}.pl-sm-5,.px-sm-5{padding-left:3rem !important}.m-sm-n1{margin:-.25rem !important}.mt-sm-n1,.my-sm-n1{margin-top:-.25rem !important}.mr-sm-n1,.mx-sm-n1{margin-right:-.25rem !important}.mb-sm-n1,.my-sm-n1{margin-bottom:-.25rem !important}.ml-sm-n1,.mx-sm-n1{margin-left:-.25rem !important}.m-sm-n2{margin:-.5rem !important}.mt-sm-n2,.my-sm-n2{margin-top:-.5rem !important}.mr-sm-n2,.mx-sm-n2{margin-right:-.5rem !important}.mb-sm-n2,.my-sm-n2{margin-bottom:-.5rem !important}.ml-sm-n2,.mx-sm-n2{margin-left:-.5rem !important}.m-sm-n3{margin:-1rem !important}.mt-sm-n3,.my-sm-n3{margin-top:-1rem !important}.mr-sm-n3,.mx-sm-n3{margin-right:-1rem !important}.mb-sm-n3,.my-sm-n3{margin-bottom:-1rem !important}.ml-sm-n3,.mx-sm-n3{margin-left:-1rem !important}.m-sm-n4{margin:-1.5rem !important}.mt-sm-n4,.my-sm-n4{margin-top:-1.5rem !important}.mr-sm-n4,.mx-sm-n4{margin-right:-1.5rem !important}.mb-sm-n4,.my-sm-n4{margin-bottom:-1.5rem !important}.ml-sm-n4,.mx-sm-n4{margin-left:-1.5rem !important}.m-sm-n5{margin:-3rem !important}.mt-sm-n5,.my-sm-n5{margin-top:-3rem !important}.mr-sm-n5,.mx-sm-n5{margin-right:-3rem !important}.mb-sm-n5,.my-sm-n5{margin-bottom:-3rem !important}.ml-sm-n5,.mx-sm-n5{margin-left:-3rem !important}.m-sm-auto{margin:auto !important}.mt-sm-auto,.my-sm-auto{margin-top:auto !important}.mr-sm-auto,.mx-sm-auto{margin-right:auto !important}.mb-sm-auto,.my-sm-auto{margin-bottom:auto !important}.ml-sm-auto,.mx-sm-auto{margin-left:auto !important}}@media (min-width: 768px){.m-md-0{margin:0 !important}.mt-md-0,.my-md-0{margin-top:0 !important}.mr-md-0,.mx-md-0{margin-right:0 !important}.mb-md-0,.my-md-0{margin-bottom:0 !important}.ml-md-0,.mx-md-0{margin-left:0 !important}.m-md-1{margin:.25rem !important}.mt-md-1,.my-md-1{margin-top:.25rem !important}.mr-md-1,.mx-md-1{margin-right:.25rem !important}.mb-md-1,.my-md-1{margin-bottom:.25rem !important}.ml-md-1,.mx-md-1{margin-left:.25rem !important}.m-md-2{margin:.5rem !important}.mt-md-2,.my-md-2{margin-top:.5rem !important}.mr-md-2,.mx-md-2{margin-right:.5rem !important}.mb-md-2,.my-md-2{margin-bottom:.5rem !important}.ml-md-2,.mx-md-2{margin-left:.5rem !important}.m-md-3{margin:1rem !important}.mt-md-3,.my-md-3{margin-top:1rem !important}.mr-md-3,.mx-md-3{margin-right:1rem !important}.mb-md-3,.my-md-3{margin-bottom:1rem !important}.ml-md-3,.mx-md-3{margin-left:1rem !important}.m-md-4{margin:1.5rem !important}.mt-md-4,.my-md-4{margin-top:1.5rem !important}.mr-md-4,.mx-md-4{margin-right:1.5rem !important}.mb-md-4,.my-md-4{margin-bottom:1.5rem !important}.ml-md-4,.mx-md-4{margin-left:1.5rem !important}.m-md-5{margin:3rem !important}.mt-md-5,.my-md-5{margin-top:3rem !important}.mr-md-5,.mx-md-5{margin-right:3rem !important}.mb-md-5,.my-md-5{margin-bottom:3rem !important}.ml-md-5,.mx-md-5{margin-left:3rem !important}.p-md-0{padding:0 !important}.pt-md-0,.py-md-0{padding-top:0 !important}.pr-md-0,.px-md-0{padding-right:0 !important}.pb-md-0,.py-md-0{padding-bottom:0 !important}.pl-md-0,.px-md-0{padding-left:0 !important}.p-md-1{padding:.25rem !important}.pt-md-1,.py-md-1{padding-top:.25rem !important}.pr-md-1,.px-md-1{padding-right:.25rem !important}.pb-md-1,.py-md-1{padding-bottom:.25rem !important}.pl-md-1,.px-md-1{padding-left:.25rem !important}.p-md-2{padding:.5rem !important}.pt-md-2,.py-md-2{padding-top:.5rem !important}.pr-md-2,.px-md-2{padding-right:.5rem !important}.pb-md-2,.py-md-2{padding-bottom:.5rem !important}.pl-md-2,.px-md-2{padding-left:.5rem !important}.p-md-3{padding:1rem !important}.pt-md-3,.py-md-3{padding-top:1rem !important}.pr-md-3,.px-md-3{padding-right:1rem !important}.pb-md-3,.py-md-3{padding-bottom:1rem !important}.pl-md-3,.px-md-3{padding-left:1rem !important}.p-md-4{padding:1.5rem !important}.pt-md-4,.py-md-4{padding-top:1.5rem !important}.pr-md-4,.px-md-4{padding-right:1.5rem !important}.pb-md-4,.py-md-4{padding-bottom:1.5rem !important}.pl-md-4,.px-md-4{padding-left:1.5rem !important}.p-md-5{padding:3rem !important}.pt-md-5,.py-md-5{padding-top:3rem !important}.pr-md-5,.px-md-5{padding-right:3rem !important}.pb-md-5,.py-md-5{padding-bottom:3rem !important}.pl-md-5,.px-md-5{padding-left:3rem !important}.m-md-n1{margin:-.25rem !important}.mt-md-n1,.my-md-n1{margin-top:-.25rem !important}.mr-md-n1,.mx-md-n1{margin-right:-.25rem !important}.mb-md-n1,.my-md-n1{margin-bottom:-.25rem !important}.ml-md-n1,.mx-md-n1{margin-left:-.25rem !important}.m-md-n2{margin:-.5rem !important}.mt-md-n2,.my-md-n2{margin-top:-.5rem !important}.mr-md-n2,.mx-md-n2{margin-right:-.5rem !important}.mb-md-n2,.my-md-n2{margin-bottom:-.5rem !important}.ml-md-n2,.mx-md-n2{margin-left:-.5rem !important}.m-md-n3{margin:-1rem !important}.mt-md-n3,.my-md-n3{margin-top:-1rem !important}.mr-md-n3,.mx-md-n3{margin-right:-1rem !important}.mb-md-n3,.my-md-n3{margin-bottom:-1rem !important}.ml-md-n3,.mx-md-n3{margin-left:-1rem !important}.m-md-n4{margin:-1.5rem !important}.mt-md-n4,.my-md-n4{margin-top:-1.5rem !important}.mr-md-n4,.mx-md-n4{margin-right:-1.5rem !important}.mb-md-n4,.my-md-n4{margin-bottom:-1.5rem !important}.ml-md-n4,.mx-md-n4{margin-left:-1.5rem !important}.m-md-n5{margin:-3rem !important}.mt-md-n5,.my-md-n5{margin-top:-3rem !important}.mr-md-n5,.mx-md-n5{margin-right:-3rem !important}.mb-md-n5,.my-md-n5{margin-bottom:-3rem !important}.ml-md-n5,.mx-md-n5{margin-left:-3rem !important}.m-md-auto{margin:auto !important}.mt-md-auto,.my-md-auto{margin-top:auto !important}.mr-md-auto,.mx-md-auto{margin-right:auto !important}.mb-md-auto,.my-md-auto{margin-bottom:auto !important}.ml-md-auto,.mx-md-auto{margin-left:auto !important}}@media (min-width: 992px){.m-lg-0{margin:0 !important}.mt-lg-0,.my-lg-0{margin-top:0 !important}.mr-lg-0,.mx-lg-0{margin-right:0 !important}.mb-lg-0,.my-lg-0{margin-bottom:0 !important}.ml-lg-0,.mx-lg-0{margin-left:0 !important}.m-lg-1{margin:.25rem !important}.mt-lg-1,.my-lg-1{margin-top:.25rem !important}.mr-lg-1,.mx-lg-1{margin-right:.25rem !important}.mb-lg-1,.my-lg-1{margin-bottom:.25rem !important}.ml-lg-1,.mx-lg-1{margin-left:.25rem !important}.m-lg-2{margin:.5rem !important}.mt-lg-2,.my-lg-2{margin-top:.5rem !important}.mr-lg-2,.mx-lg-2{margin-right:.5rem !important}.mb-lg-2,.my-lg-2{margin-bottom:.5rem !important}.ml-lg-2,.mx-lg-2{margin-left:.5rem !important}.m-lg-3{margin:1rem !important}.mt-lg-3,.my-lg-3{margin-top:1rem !important}.mr-lg-3,.mx-lg-3{margin-right:1rem !important}.mb-lg-3,.my-lg-3{margin-bottom:1rem !important}.ml-lg-3,.mx-lg-3{margin-left:1rem !important}.m-lg-4{margin:1.5rem !important}.mt-lg-4,.my-lg-4{margin-top:1.5rem !important}.mr-lg-4,.mx-lg-4{margin-right:1.5rem !important}.mb-lg-4,.my-lg-4{margin-bottom:1.5rem !important}.ml-lg-4,.mx-lg-4{margin-left:1.5rem !important}.m-lg-5{margin:3rem !important}.mt-lg-5,.my-lg-5{margin-top:3rem !important}.mr-lg-5,.mx-lg-5{margin-right:3rem !important}.mb-lg-5,.my-lg-5{margin-bottom:3rem !important}.ml-lg-5,.mx-lg-5{margin-left:3rem !important}.p-lg-0{padding:0 !important}.pt-lg-0,.py-lg-0{padding-top:0 !important}.pr-lg-0,.px-lg-0{padding-right:0 !important}.pb-lg-0,.py-lg-0{padding-bottom:0 !important}.pl-lg-0,.px-lg-0{padding-left:0 !important}.p-lg-1{padding:.25rem !important}.pt-lg-1,.py-lg-1{padding-top:.25rem !important}.pr-lg-1,.px-lg-1{padding-right:.25rem !important}.pb-lg-1,.py-lg-1{padding-bottom:.25rem !important}.pl-lg-1,.px-lg-1{padding-left:.25rem !important}.p-lg-2{padding:.5rem !important}.pt-lg-2,.py-lg-2{padding-top:.5rem !important}.pr-lg-2,.px-lg-2{padding-right:.5rem !important}.pb-lg-2,.py-lg-2{padding-bottom:.5rem !important}.pl-lg-2,.px-lg-2{padding-left:.5rem !important}.p-lg-3{padding:1rem !important}.pt-lg-3,.py-lg-3{padding-top:1rem !important}.pr-lg-3,.px-lg-3{padding-right:1rem !important}.pb-lg-3,.py-lg-3{padding-bottom:1rem !important}.pl-lg-3,.px-lg-3{padding-left:1rem !important}.p-lg-4{padding:1.5rem !important}.pt-lg-4,.py-lg-4{padding-top:1.5rem !important}.pr-lg-4,.px-lg-4{padding-right:1.5rem !important}.pb-lg-4,.py-lg-4{padding-bottom:1.5rem !important}.pl-lg-4,.px-lg-4{padding-left:1.5rem !important}.p-lg-5{padding:3rem !important}.pt-lg-5,.py-lg-5{padding-top:3rem !important}.pr-lg-5,.px-lg-5{padding-right:3rem !important}.pb-lg-5,.py-lg-5{padding-bottom:3rem !important}.pl-lg-5,.px-lg-5{padding-left:3rem !important}.m-lg-n1{margin:-.25rem !important}.mt-lg-n1,.my-lg-n1{margin-top:-.25rem !important}.mr-lg-n1,.mx-lg-n1{margin-right:-.25rem !important}.mb-lg-n1,.my-lg-n1{margin-bottom:-.25rem !important}.ml-lg-n1,.mx-lg-n1{margin-left:-.25rem !important}.m-lg-n2{margin:-.5rem !important}.mt-lg-n2,.my-lg-n2{margin-top:-.5rem !important}.mr-lg-n2,.mx-lg-n2{margin-right:-.5rem !important}.mb-lg-n2,.my-lg-n2{margin-bottom:-.5rem !important}.ml-lg-n2,.mx-lg-n2{margin-left:-.5rem !important}.m-lg-n3{margin:-1rem !important}.mt-lg-n3,.my-lg-n3{margin-top:-1rem !important}.mr-lg-n3,.mx-lg-n3{margin-right:-1rem !important}.mb-lg-n3,.my-lg-n3{margin-bottom:-1rem !important}.ml-lg-n3,.mx-lg-n3{margin-left:-1rem !important}.m-lg-n4{margin:-1.5rem !important}.mt-lg-n4,.my-lg-n4{margin-top:-1.5rem !important}.mr-lg-n4,.mx-lg-n4{margin-right:-1.5rem !important}.mb-lg-n4,.my-lg-n4{margin-bottom:-1.5rem !important}.ml-lg-n4,.mx-lg-n4{margin-left:-1.5rem !important}.m-lg-n5{margin:-3rem !important}.mt-lg-n5,.my-lg-n5{margin-top:-3rem !important}.mr-lg-n5,.mx-lg-n5{margin-right:-3rem !important}.mb-lg-n5,.my-lg-n5{margin-bottom:-3rem !important}.ml-lg-n5,.mx-lg-n5{margin-left:-3rem !important}.m-lg-auto{margin:auto !important}.mt-lg-auto,.my-lg-auto{margin-top:auto !important}.mr-lg-auto,.mx-lg-auto{margin-right:auto !important}.mb-lg-auto,.my-lg-auto{margin-bottom:auto !important}.ml-lg-auto,.mx-lg-auto{margin-left:auto !important}}@media (min-width: 1200px){.m-xl-0{margin:0 !important}.mt-xl-0,.my-xl-0{margin-top:0 !important}.mr-xl-0,.mx-xl-0{margin-right:0 !important}.mb-xl-0,.my-xl-0{margin-bottom:0 !important}.ml-xl-0,.mx-xl-0{margin-left:0 !important}.m-xl-1{margin:.25rem !important}.mt-xl-1,.my-xl-1{margin-top:.25rem !important}.mr-xl-1,.mx-xl-1{margin-right:.25rem !important}.mb-xl-1,.my-xl-1{margin-bottom:.25rem !important}.ml-xl-1,.mx-xl-1{margin-left:.25rem !important}.m-xl-2{margin:.5rem !important}.mt-xl-2,.my-xl-2{margin-top:.5rem !important}.mr-xl-2,.mx-xl-2{margin-right:.5rem !important}.mb-xl-2,.my-xl-2{margin-bottom:.5rem !important}.ml-xl-2,.mx-xl-2{margin-left:.5rem !important}.m-xl-3{margin:1rem !important}.mt-xl-3,.my-xl-3{margin-top:1rem !important}.mr-xl-3,.mx-xl-3{margin-right:1rem !important}.mb-xl-3,.my-xl-3{margin-bottom:1rem !important}.ml-xl-3,.mx-xl-3{margin-left:1rem !important}.m-xl-4{margin:1.5rem !important}.mt-xl-4,.my-xl-4{margin-top:1.5rem !important}.mr-xl-4,.mx-xl-4{margin-right:1.5rem !important}.mb-xl-4,.my-xl-4{margin-bottom:1.5rem !important}.ml-xl-4,.mx-xl-4{margin-left:1.5rem !important}.m-xl-5{margin:3rem !important}.mt-xl-5,.my-xl-5{margin-top:3rem !important}.mr-xl-5,.mx-xl-5{margin-right:3rem !important}.mb-xl-5,.my-xl-5{margin-bottom:3rem !important}.ml-xl-5,.mx-xl-5{margin-left:3rem !important}.p-xl-0{padding:0 !important}.pt-xl-0,.py-xl-0{padding-top:0 !important}.pr-xl-0,.px-xl-0{padding-right:0 !important}.pb-xl-0,.py-xl-0{padding-bottom:0 !important}.pl-xl-0,.px-xl-0{padding-left:0 !important}.p-xl-1{padding:.25rem !important}.pt-xl-1,.py-xl-1{padding-top:.25rem !important}.pr-xl-1,.px-xl-1{padding-right:.25rem !important}.pb-xl-1,.py-xl-1{padding-bottom:.25rem !important}.pl-xl-1,.px-xl-1{padding-left:.25rem !important}.p-xl-2{padding:.5rem !important}.pt-xl-2,.py-xl-2{padding-top:.5rem !important}.pr-xl-2,.px-xl-2{padding-right:.5rem !important}.pb-xl-2,.py-xl-2{padding-bottom:.5rem !important}.pl-xl-2,.px-xl-2{padding-left:.5rem !important}.p-xl-3{padding:1rem !important}.pt-xl-3,.py-xl-3{padding-top:1rem !important}.pr-xl-3,.px-xl-3{padding-right:1rem !important}.pb-xl-3,.py-xl-3{padding-bottom:1rem !important}.pl-xl-3,.px-xl-3{padding-left:1rem !important}.p-xl-4{padding:1.5rem !important}.pt-xl-4,.py-xl-4{padding-top:1.5rem !important}.pr-xl-4,.px-xl-4{padding-right:1.5rem !important}.pb-xl-4,.py-xl-4{padding-bottom:1.5rem !important}.pl-xl-4,.px-xl-4{padding-left:1.5rem !important}.p-xl-5{padding:3rem !important}.pt-xl-5,.py-xl-5{padding-top:3rem !important}.pr-xl-5,.px-xl-5{padding-right:3rem !important}.pb-xl-5,.py-xl-5{padding-bottom:3rem !important}.pl-xl-5,.px-xl-5{padding-left:3rem !important}.m-xl-n1{margin:-.25rem !important}.mt-xl-n1,.my-xl-n1{margin-top:-.25rem !important}.mr-xl-n1,.mx-xl-n1{margin-right:-.25rem !important}.mb-xl-n1,.my-xl-n1{margin-bottom:-.25rem !important}.ml-xl-n1,.mx-xl-n1{margin-left:-.25rem !important}.m-xl-n2{margin:-.5rem !important}.mt-xl-n2,.my-xl-n2{margin-top:-.5rem !important}.mr-xl-n2,.mx-xl-n2{margin-right:-.5rem !important}.mb-xl-n2,.my-xl-n2{margin-bottom:-.5rem !important}.ml-xl-n2,.mx-xl-n2{margin-left:-.5rem !important}.m-xl-n3{margin:-1rem !important}.mt-xl-n3,.my-xl-n3{margin-top:-1rem !important}.mr-xl-n3,.mx-xl-n3{margin-right:-1rem !important}.mb-xl-n3,.my-xl-n3{margin-bottom:-1rem !important}.ml-xl-n3,.mx-xl-n3{margin-left:-1rem !important}.m-xl-n4{margin:-1.5rem !important}.mt-xl-n4,.my-xl-n4{margin-top:-1.5rem !important}.mr-xl-n4,.mx-xl-n4{margin-right:-1.5rem !important}.mb-xl-n4,.my-xl-n4{margin-bottom:-1.5rem !important}.ml-xl-n4,.mx-xl-n4{margin-left:-1.5rem !important}.m-xl-n5{margin:-3rem !important}.mt-xl-n5,.my-xl-n5{margin-top:-3rem !important}.mr-xl-n5,.mx-xl-n5{margin-right:-3rem !important}.mb-xl-n5,.my-xl-n5{margin-bottom:-3rem !important}.ml-xl-n5,.mx-xl-n5{margin-left:-3rem !important}.m-xl-auto{margin:auto !important}.mt-xl-auto,.my-xl-auto{margin-top:auto !important}.mr-xl-auto,.mx-xl-auto{margin-right:auto !important}.mb-xl-auto,.my-xl-auto{margin-bottom:auto !important}.ml-xl-auto,.mx-xl-auto{margin-left:auto !important}}.stretched-link::after{position:absolute;top:0;right:0;bottom:0;left:0;z-index:1;pointer-events:auto;content:"";background-color:rgba(0,0,0,0)}.text-monospace{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace !important}.text-justify{text-align:justify !important}.text-wrap{white-space:normal !important}.text-nowrap{white-space:nowrap !important}.text-truncate{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.text-left{text-align:left !important}.text-right{text-align:right !important}.text-center{text-align:center !important}@media (min-width: 576px){.text-sm-left{text-align:left !important}.text-sm-right{text-align:right !important}.text-sm-center{text-align:center !important}}@media (min-width: 768px){.text-md-left{text-align:left !important}.text-md-right{text-align:right !important}.text-md-center{text-align:center !important}}@media (min-width: 992px){.text-lg-left{text-align:left !important}.text-lg-right{text-align:right !important}.text-lg-center{text-align:center !important}}@media (min-width: 1200px){.text-xl-left{text-align:left !important}.text-xl-right{text-align:right !important}.text-xl-center{text-align:center !important}}.text-lowercase{text-transform:lowercase !important}.text-uppercase{text-transform:uppercase !important}.text-capitalize{text-transform:capitalize !important}.font-weight-light{font-weight:300 !important}.font-weight-lighter{font-weight:lighter !important}.font-weight-normal{font-weight:400 !important}.font-weight-bold{font-weight:700 !important}.font-weight-bolder{font-weight:bolder !important}.font-italic{font-style:italic !important}.text-white{color:#fff !important}.text-primary{color:#2F414A !important}a.text-primary:hover,a.text-primary:focus{color:#11181b !important}.text-secondary{color:#F47B53 !important}a.text-secondary:hover,a.text-secondary:focus{color:#eb460f !important}.text-success{color:#420084 !important}a.text-success:hover,a.text-success:focus{color:#1c0038 !important}.text-info{color:#7ebcfa !important}a.text-info:hover,a.text-info:focus{color:#3496f7 !important}.text-warning{color:#f93 !important}a.text-warning:hover,a.text-warning:focus{color:#e67300 !important}.text-danger{color:#f2460d !important}a.text-danger:hover,a.text-danger:focus{color:#a93109 !important}.text-light{color:#eef0f2 !important}a.text-light:hover,a.text-light:focus{color:#c3cad1 !important}.text-dark{color:#000633 !important}a.text-dark:hover,a.text-dark:focus{color:#000 !important}.text-body{color:#212529 !important}.text-muted{color:#6c757d !important}.text-black-50{color:rgba(0,0,0,0.5) !important}.text-white-50{color:rgba(255,255,255,0.5) !important}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.text-decoration-none{text-decoration:none !important}.text-break{word-wrap:break-word !important}.text-reset{color:inherit !important}.visible{visibility:visible !important}.invisible{visibility:hidden !important}@media print{*,*::before,*::after{text-shadow:none !important;box-shadow:none !important}a:not(.btn){text-decoration:underline}abbr[title]::after{content:" (" attr(title) ")"}pre{white-space:pre-wrap !important}pre,blockquote{border:1px solid #adb5bd;page-break-inside:avoid}thead{display:table-header-group}tr,img{page-break-inside:avoid}p,h2,h3{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px !important}.container{min-width:992px !important}.navbar{display:none}.badge{border:1px solid #000}.table{border-collapse:collapse !important}.table td,.table th{background-color:#fff !important}.table-bordered th,.table-bordered td{border:1px solid #dee2e6 !important}.table-dark{color:inherit}.table-dark th,.table-dark td,.table-dark thead th,.table-dark tbody+tbody{border-color:#dee2e6}.table .thead-dark th{color:inherit;border-color:#dee2e6}}
    </style -->
    <style>
    h3, button, .badge {transition: transform 250ms ease-in-out;}
    </style>
    <script>
    $(document).ready(function(){
        var cycleAniApp = {
            speedFrom: 95, 
            speedTo: 41, 
            steps: 63, 
            link_normal_color: 'var(--primary)', 
            link_hover_color: 'var(--gray)', 
            clone_normal_color: 'var(--primary)', 
            posX: ["+=0", "-=12", "+=0", "+=12"], 
            posY: ["+=12", "+=0", "-=12", "+=0"], 
            cycleAni: function(obj, pos, posI){
                var speed = cycleAniApp.speedFrom - ((cycleAniApp.speedFrom - cycleAniApp.speedTo) / cycleAniApp.steps * pos);
                $(obj).stop().animate({
                    top: cycleAniApp.posY[posI],
                    left: cycleAniApp.posX[posI]
                }, speed, function() {
                    if(pos == 0){
                        $(this).hide(100, function(){
                            $(this).parent().css({color: cycleAniApp.link_normal_color});
                            $(this).remove();
                        });
                    }else{
                        if(posI == 0){
                            posI = 3;
                        }else{
                            posI--;
                        }
                        var pI = posI;
                        var p = pos - 1;
                        cycleAniApp.cycleAni(this, p, pI);
                    }
                });
            }, 
            startAni: function(obj){
                var offset = $(obj).offset();
                var x = offset.left + 0;
                var y = offset.top + 0;
                var clonetext = $("<div>"+$(obj).text()+"</div>").addClass('ctext position-fixed').css({'top': y + 'px', 'left': x + 'px', 'color': cycleAniApp.clone_normal_color});
                $(obj).css({color: cycleAniApp.link_hover_color}).append(clonetext);
                $('.ctext').stop().animate({
                    top: "+=6",
                    left: "-=6"
                }, 50, function() {
                    cycleAniApp.cycleAni(this, cycleAniApp.steps, 3);
                });
            }
        }
    
        // navbar-brand Links
        $('.navbar-brand').mouseenter(function(){
            cycleAniApp.steps = 23;
            cycleAniApp.speedFrom = 39;
            cycleAniApp.speedTo = 39;
            cycleAniApp.link_normal_color = 'var(--primary)';
            cycleAniApp.link_hover_color = 'var(--gray)';
            cycleAniApp.clone_normal_color = 'var(--success)';
            cycleAniApp.startAni(this);
        }).mouseleave(function(){
            $('.ctext').remove();
            $(this).css({color: '#000'});
        });
    
        // dropdown-item
        $('.dropdown-item').mouseenter(function(){
            cycleAniApp.steps = 23;
            cycleAniApp.speedFrom = 127;
            cycleAniApp.speedTo = 39;
            cycleAniApp.link_normal_color = 'var(--primary)';
            cycleAniApp.link_hover_color = 'var(--gray)';
            cycleAniApp.clone_normal_color = 'var(--warning)';
            cycleAniApp.startAni(this);
        }).mouseleave(function(){
            $('.ctext').remove();
            $(this).css({color: 'var(--primary)'});
        });
    
        // H4 Überschriften
        cycleAniApp.steps = 23;
        cycleAniApp.speedFrom = 95;
        cycleAniApp.speedTo = 39;
        cycleAniApp.link_normal_color = 'var(--primary)';
        cycleAniApp.link_hover_color = 'var(--gray)';
        cycleAniApp.clone_normal_color = 'var(--primary)';
        $('h4').each(function(){
    //		cycleAniApp.startAni($(this));
        });
    
        // H3 Überschriften
        /*$('h3').each(function(){
            var self = $(this);
            self.stop().animate({
                marginLeft: "+=200"
            }, 500, function() {
                self.css({'transform': 'scale(20%)'});
                self.stop().animate({
                    marginLeft: "-=200"
                }, 250, function() {
                    self.css({'transform': 'scale(100%)'});
                });
            });
        });*/
    
        // BUTTON
        $('.btn').mouseenter(function(){
            $(this).css({'transform': 'scale(120%)'});
        }).mouseleave(function(){
            $(this).css({'transform': 'scale(100%)'});
        });
    
        // BADGE
        $('.badge').mouseenter(function(){
            $(this).css({'transform': 'scale(130%)'});
        }).mouseleave(function(){
            $(this).css({'transform': 'scale(100%)'});
        });
    
        // RADIO
        //$('#navbar_1').after($('<audio id="radio" src="http://stream.laut.fm/goa-base" type="audio/mp3" controls="" style="width: 240px"></audio><div class="btn-group"><button type="button" class="btn btn-secondary dropdown-toggle rounded-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$(\'.radio-dropdown-menu\').slideToggle(0)" onfocus="this.blur()">Sender</button></div><div class="radio-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000"><h6 class="text-left">Auswahl</h6><select id="sends" name="sends" class="custom-select text-primary border border-primary" onchange="document.getElementById(\'radio\').src=this.value"><option value="http://stream.laut.fm/goa-base">GOA Base</option><option value="http://stream.laut.fm/goa-channel-one">GOA Channel One</option><option value="http://nrj.de/berlin">Energy Berlin</option><option value="http://rbb-fritz-live.cast.addradio.de/rbb/fritz/live/mp3/128/stream.mp3">Fritz</option><option value="http://stream.sunshine-live.de/2000er/mp3-192/stream.sunshine-live.de/">Sunshine Live</option><option value="http://stream.kissfm.de/kissfm/mp3-128/internetradio/">Kiss FM</option></select></div>'));
    
        // BACKGROUND
        // https://images.pexels.com/photos/3377414/pexels-photo-3377414.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260
        // https://images.pexels.com/photos/2117937/pexels-photo-2117937.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260
        // https://images.pexels.com/photos/2341290/pexels-photo-2341290.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260
        // https://images.pexels.com/photos/695657/pexels-photo-695657.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260
    //	$('body').css({'background': 'url(https://images.pexels.com/photos/2341290/pexels-photo-2341290.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260)', ' background-repeat': 'no-repeat', 'background-size': 'auto'});
    });
    </script>
    <!-- style>
    .dropplet {
        position: absolute;
        z-index: 99999;
    }
    .dropplet:nth-child(1) {
        top: 10px;
        left: calc(50% - 110px);
        width: 40px;
        height: 32px;
        border-radius: 50% 50% 50% 50% / 50% 50% 45% 45%;
        background: radial-gradient(ellipse at center, white 40%, transparent 70%) no-repeat 60% 25% / 16% 15%;
        box-shadow: inset 7px 0 2px -5px rgba(0, 0, 0, .2), inset 6px 0 1px -5px rgba(0, 0, 0, .2), inset 0 -1px 2px rgba(250, 241, 220, .5), inset 0 -10px 5px 1px rgba(255, 255, 255, .3), inset -10px 5px 2px -10px rgba(0, 0, 0, .3), inset -10px 7px 5px -10px rgba(0, 0, 0, .2), inset 0 10px 15px -2px rgba(0, 0, 0, .3), 0 2px 1px -1px rgba(245, 227, 183, .5), -1px 8px 1px -2px rgba(0, 0, 0, .5), -1px 10px 2px -2px rgba(0, 0, 0, .4), 1px -1px 2px 0 rgba(50, 50, 50, .5);
    }
    .dropplet:nth-child(2) {
        top: 55px;
        left: calc(50% - 60px);
        width: 50px;
        height: 40px;
        border-radius: 50% 50% 50% 50% / 45% 45% 55% 55%;
        background: radial-gradient(ellipse at center, rgba(0, 0, 0, .1) 0%, white 10%, white 40%, transparent 60%) no-repeat 60% 25% / 18% 16%;
        box-shadow: inset 0 1px 5px rgba(0, 0, 0, .2), inset 7px 2px 1px -5px rgba(169, 168, 168, .7), inset 0 -1px 2px rgba(250, 241, 220, .1), inset 0 -2px 10px rgba(255, 255, 255, .1), inset -1px 1px 1px rgba(169, 168, 168, .5), inset -11px 3px 1px -10px rgba(169, 168, 168, .3), inset -10px 7px 5px -10px rgba(0, 0, 0, .3), inset 0 1px rgba(58, 2, 2, .3), inset 0 15px 15px rgba(0, 0, 0, .2), 0 1px 1px -1px rgba(245, 227, 183, .6), 0 2px 1px -1px rgba(131, 131, 131, .5), -10px -2px 2px -10px #666, -11px 4px 2px -10px #666, -10px 8px 2px -10px #666, 8px 6px 2px -10px #666, 7px 9px 2px -10px #6c6c6c, -1px 8px 1px -2px rgba(0, 0, 0, .5), -1px 10px 2px -2px rgba(0, 0, 0, .3), 0 0 1px rgba(0, 0, 0, .1);
    }
    .dropplet:nth-child(3) {
        top: 0px;
        left: calc(50% + 90px);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: radial-gradient(ellipse at center, white 30%, transparent 60%) no-repeat 60% 25% / 12.5% 12.5%;
        box-shadow: inset 15px 0 5px -10px rgba(0, 0, 0, .2), inset 13px 0 2px -10px rgba(0, 0, 0, .2), inset 0 -3px 5px 0 rgba(250, 241, 220, .5), inset 0 -20px 10px 1px rgba(255, 255, 255, .3), inset -23px 10px 5px -20px rgba(0, 0, 0, .3), inset -20px 15px 10px -20px rgba(0, 0, 0, .2), inset 0 25px 20px -5px rgba(0, 0, 0, .3), 0 2px 1px -1px rgba(245, 227, 183, .8), -17px 10px 5px -20px black, 14px 20px 5px -20px black, 16px 14px 5px -20px black, -2px 27px 5px -20px rgba(255, 255, 255, .3), -1px 14px 3px -5px rgba(0, 0, 0, .5), -1px 18px 3px -5px rgba(0, 0, 0, .4), 0 -1px 5px 0 rgba(85, 85, 85, .5);
        transform: scale(.5);
    }
    .dropplet:nth-child(4) {
        bottom: 10px;
        left: 20%;
        width: 65px; height: 68px;
        border-radius: 50% 50% 50% 50% / 50% 50% 45% 45%;
        background: radial-gradient(ellipse at center, white 40%, transparent 60%) no-repeat 60% 25% / 10px 6px;
        box-shadow: inset 12px 5px 5px -10px rgba(0, 0, 0, .3), inset 10px 5px 2px -10px rgba(0, 0, 0, .2), inset -1px -3px 5px 0 rgba(250, 241, 220, .5), inset -1px -20px 10px 1px rgba(255, 255, 255, .3), inset -20px 10px 5px -20px rgba(0, 0, 0, .4), inset -20px 15px 10px -20px rgba(0, 0, 0, .4), inset 0 20px 30px -5px rgba(0, 0, 0, .3), 0 2px 1px -1px rgba(245, 227, 183, .8), -18px 11px 5px -20px rgba(0, 0, 0, .9), -17px 19px 5px -20px rgba(0, 0, 0, .6), 17px 12px 5px -20px rgba(0, 0, 0, .9), 15px 18px 5px -20px rgba(0, 0, 0, .9), -4px 30px 1px -25px rgba(0, 0, 0, .4), -4px 32px 3px -25px rgba(255, 255, 255, .1), -1px 14px 3px -5px rgba(0, 0, 0, .5), -1px 19px 3px -5px rgba(0, 0, 0, .4), 1px -1px 5px 0 rgba(50, 50, 50, .5);
        transform: scale(.5);
    }
    .dropplet:nth-child(5) {
        bottom: 0px;
        left: 70%;
        width: 120px;
        height: 120px;
        border-radius: 90% 60% 100% 50% / 90% 50% 100% 45%;
        background: radial-gradient(ellipse at center, white 40%, transparent 60%) no-repeat 60% 25% / 10% 10%;
        box-shadow: inset 13px -4px 4px -10px rgba(0, 0, 0, .4), inset 14px -4px 10px -10px rgba(0, 0, 0, .2), inset 0 -3px 10px 1px rgba(250, 241, 220, .8), inset 0 -15px 10px 0 rgba(0, 0, 0, .2), inset -20px 10px 5px -20px rgba(0, 0, 0, .2), inset -20px 15px 10px -20px rgba(0, 0, 0, .2), inset 0 3px 2px 1px rgba(0, 0, 0, .2), inset 0 30px 20px -5px rgba(0, 0, 0, .3), 0 2px 1px -1px rgba(245, 227, 183, .8), -16px 13px 5px -20px black, 17px 13px 5px -20px black, 15px 19px 5px -20px black, -1px 16px 3px -5px rgba(0, 0, 0, .4), -1px 21px 3px -5px rgba(0, 0, 0, .3), 1px -1px 1px rgba(50, 50, 50, .1);
        transform: scale(.4);
    }
    </style>
    <script>
    $(document).ready(function(){
        for(var p = 0;p < 5;p++){
            $("body").prepend('<div class="dropplet position-absolute"></div>');
        }
    });
    </script --></head>
    <body>
    <div id="header" class="bg-white border-bottom border-primary mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <nav class="navbar navbar-expand-lg navbar-white p-0">
                        <a href="#" onclick="toggleFullscreen()"><img src="/uploads/company/1/img/logo_backend.png" alt="Logo" style="width: 32px;margin: 2px"></a>					<a href="/crm/neue-auftraege" title="Auftragsübersicht" style="font-size: 1rem" class="navbar-brand extra-link text-primary p-0">Aufträge</a>
    <a href="/crm/neue-kunden" title="Kundenübersicht" style="font-size: 1rem" class="navbar-brand extra-hover text-primary p-0">Kunden</a>
    <a href="/crm/neue-interessenten" title="Interessentenübersicht" style="font-size: 1rem" class="navbar-brand extra-hover text-primary p-0">Interessenten</a>
    <a href="/crm/neue-einkaeufe" title="Einkäufsübersicht" style="font-size: 1rem" class="navbar-brand extra-hover text-primary p-0">Einkäufe</a>
    <a href="/crm/neue-packtische" title="Packtischübersicht" style="font-size: 1rem" class="navbar-brand extra-hover text-primary p-0">Packtisch</a>
                        <button type="button" style="padding: 0 4px" class="navbar-toggler bg-primary rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="navbar_1" class="navbar-collapse collapse justify-content-end">
                            <ul id="menu-1" class="navbar-nav mr-0">
                                <li class="nav-item"><span class="nav-link text-dark pr-0">Willkommen, GZA MOTORS - </span></li>
                                <li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-primary">Dummy Mitarbeiter</a></li>
                            </ul>
                            <span class="text-dark">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                            <ul id="menu-1" class="navbar-nav mr-0">
                                    <li class="nav-item dropdown">
            <a href="#" title="Admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Admin</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/index" title="Startseite" class="dropdown-item">Start</a></li>
                <li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="dropdown-item">Zugangsdaten</a></li>
                <li class="nav-item"><a href="/crm/styles" title="Styles" class="dropdown-item">Styles</a></li>
                <li class="nav-item"><a href="/crm/zeiterfassung" title="Zeiterfassung" class="dropdown-item">Zeiterfassung</a></li>
                <li class="nav-item"><a href="/crm/rollen" title="Rollen" class="dropdown-item">Rollen</a></li>
                <li class="nav-item"><a href="/crm/benutzer" title="Benutzer" class="dropdown-item">Benutzer</a></li>
                <li class="nav-item"><a href="/crm/aktivitaetsmonitor" title="Aktivitätsmonitor" class="dropdown-item">Aktivitätsmonitor</a></li>
                <li class="nav-item"><a href="/crm/firma" title="Firma" class="dropdown-item">Firma</a></li>
                <li class="nav-item"><a href="/crm/navigation" title="Navigation" class="dropdown-item">Navigation</a></li>
                <li class="nav-item"><a href="/crm/rechte" title="Rechte" class="dropdown-item">Rechte</a></li>
                <li class="nav-item"><a href="/crm/optimieren" title="Optimieren" class="dropdown-item">Optimieren</a></li>
                <li class="nav-item"><a href="/crm/design" title="Design" class="dropdown-item">Design</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" title="Einstellungen" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Einstellungen</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/grunddaten" title="Grunddaten" class="dropdown-item">Grunddaten</a></li>
                <li class="nav-item"><a href="/crm/email-vorlagen" title="Email Vorlagen" class="dropdown-item">Email Vorlagen</a></li>
                <li class="nav-item"><a href="/crm/status" title="Status" class="dropdown-item">Status</a></li>
                <li class="nav-item"><a href="/crm/geraete" title="Geräte" class="dropdown-item">Geräte</a></li>
                <li class="nav-item"><a href="/crm/laender" title="Länder" class="dropdown-item">Länder</a></li>
                <li class="nav-item"><a href="/crm/paket-vorlagen" title="Paketvorlagen" class="dropdown-item">Paketvorlagen</a></li>
                <li class="nav-item"><a href="/crm/adressen" title="Adressen" class="dropdown-item">Adressen</a></li>
                <li class="nav-item"><a href="/crm/textbausteine" title="Textbausteine" class="dropdown-item">Textbausteine</a></li>
                <li class="nav-item"><a href="/crm/vergleichtexte" title="Vergleichtexte" class="dropdown-item">Vergleichtexte</a></li>
                <li class="nav-item"><a href="/crm/historietexte" title="Historietexte" class="dropdown-item">Historietexte</a></li>
                <li class="nav-item"><a href="/crm/lagerplaetze" title="Lagerplätze" class="dropdown-item">Lagerplätze</a></li>
                <li class="nav-item"><a href="/crm/lagerplatzuebersicht" title="Lagerplatzübersicht" class="dropdown-item">Lagerplatzübersicht</a></li>
                <li class="nav-item"><a href="/crm/versandinformationen" title="Versandinformationen" class="dropdown-item">Versandinformationen</a></li>
                <li class="nav-item"><a href="/crm/globale-suche" title="Globale suche" class="dropdown-item">Globale suche</a></li>
                <li class="nav-item"><a href="/crm/globale-einkaeufe-suche" title="Globale Einkäufe suche" class="dropdown-item">Globale Einkäufe suche</a></li>
                <li class="nav-item"><a href="/crm/globale-packtische-suche" title="Globale Packtische suche" class="dropdown-item">Globale Packtische suche</a></li>
                <li class="nav-item"><a href="/crm/dateianhaenge" title="Dateianhänge" class="dropdown-item">Dateianhänge</a></li>
                <li class="nav-item"><a href="/crm/anhaengematrix" title="Anhängematrix" class="dropdown-item">Anhängematrix</a></li>
                <li class="nav-item"><a href="/crm/scan-und-hochladen" title="Scan &amp; Hochladen" class="dropdown-item">Scan &amp; Hochladen</a></li>
                <li class="nav-item"><a href="/crm/fragen" title="Verwaltung der Fragen zum Auftrag" class="dropdown-item">Fragen</a></li>
                <li class="nav-item"><a href="/crm/seiten" title="Seiten" class="dropdown-item">Seiten</a></li>
                <li class="nav-item"><a href="/crm/seiten-codes" title="Seiten-Codes" class="dropdown-item">Seiten-Codes</a></li>
                <li class="nav-item"><a href="/crm/seiten-vorlagen" title="Seiten-Vorlagen" class="dropdown-item">Seiten-Vorlagen</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" title="Versand" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Versand</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/versenden" title="Versenden" class="dropdown-item">Versenden</a></li>
                <li class="nav-item"><a href="/crm/sendungen" title="Sendungen" class="dropdown-item">Sendungen</a></li>
                <li class="nav-item"><a href="/crm/abholen" title="Abholen" class="dropdown-item">Abholen</a></li>
                <li class="nav-item"><a href="/crm/abholungen" title="Abholungen" class="dropdown-item">Abholungen</a></li>
                <li class="nav-item"><a href="/crm/tagesabschluss" title="Materialinventur" class="dropdown-item">Materialinventur</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" title="Blog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link text-primary py-1">Blog</a>
            <ul class="dropdown-menu" role="menu">
                <li class="nav-item"><a href="/crm/blog-thema" title="Blog Themen" class="dropdown-item">Themen</a></li>
                <li class="nav-item"><a href="/crm/blog-beitrag" title="Blog Beiträge" class="dropdown-item">Beiträge</a></li>
                <li class="nav-item"><a href="/crm/blog-kommentar" title="Blog Kommentare" class="dropdown-item">Kommentare</a></li>
                <li class="nav-item"><a href="/crm/blog-kategorie" title="Blog Kategorien" class="dropdown-item">Kategorien</a></li>
                <li class="nav-item"><a href="/crm/blog-tag" title="Blog Tag's" class="dropdown-item">Tag's</a></li>
            </ul>
        </li>
                                <li class="nav-item"><a href="/crm/abmelden" title="Abmelden" class="nav-link text-primary py-1">Abmelden <sup id="autologout"></sup></a></li>
                            </ul>
                        </div><div style="cursor: pointer" class="mr-2" onclick="$('.notes-dropdown-menu').slideToggle(0)" onfocus="this.blur()" onmouseover="$('.stack_edit.fa.fa-circle.fa-stack-2x').toggleClass('text-primary text-secondary')" onmouseout="$('.stack_edit.fa.fa-circle.fa-stack-2x').toggleClass('text-primary text-secondary')"><span class="stack_edit_count fa-stack fa-3x normal" data-count="0"><i class="stack_edit fa fa-circle fa-stack-2x text-primary"></i><i class="stack_edit fa fa-edit fa-stack-1x fa-inverse"></i></span></div><div class="notes-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 360px;width: 800px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000"><h4 class="font-weight-bold"><u>Eigene Notizen</u>:</h4><div class="row"><div class="col-sm-6"><ol id="todo_entries" class="p-3"></ol></div><div class="col-sm-6"><label for="todo_input">Neue Notiz: </label><br><input type="text" id="todo_input" value="" class="form-control mb-3"> <button id="todo_new" class="btn btn-primary">hinzufügen</button> <button id="todo_delete_all" class="btn btn-primary">Alle Notizen löschen</button></div></div></div><div onclick="$('.recalls-dropdown-menu').slideToggle(0)" onfocus="this.blur()" style="cursor: pointer" onmouseover="$('.stack_bell.fa.fa-circle.fa-stack-2x').toggleClass('text-primary text-secondary')" onmouseout="$('.stack_bell.fa.fa-circle.fa-stack-2x').toggleClass('text-primary text-secondary')"><span class="fa-stack fa-3x active" data-count="18"><i class="stack_bell fa fa-circle fa-stack-2x text-primary"></i><i class="stack_bell fa fa-bell fa-stack-1x fa-inverse"></i></span></div><div class="recalls-dropdown-menu bg-white rounded-bottom border border-primary p-3 m-0" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;max-height: 260px;width: 300px;display: none;box-shadow: 0 0 4px #000;overflow-x: auto;z-Index: 1000"><h4 class="font-weight-bold"><u>Heutige Rückrufe</u>:</h4><table style="width: 260px"><tbody><tr><td><a href="/crm/neue-interessenten/bearbeiten/5302">11.11.2022 - 09:20 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5302" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5265">11.11.2022 - 09:30 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5265" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5278">11.11.2022 - 09:40 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5278" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5284">11.11.2022 - 09:45 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5284" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5232">11.11.2022 - 09:50 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5232" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5220">11.11.2022 - 10:00 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5220" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5277">11.11.2022 - 10:05 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5277" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5295">11.11.2022 - 10:10 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5295" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5276">11.11.2022 - 10:15 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5276" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5294">11.11.2022 - 10:20 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5294" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5204">11.11.2022 - 10:22 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5204" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5279">11.11.2022 - 10:30 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5279" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5289">11.11.2022 - 10:45 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5289" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5247">11.11.2022 - 10:50 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5247" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5129">11.11.2022 - 10:50 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5129" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5262">11.11.2022 - 11:15 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5262" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/5297">11.11.2022 - 11:20 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/5297" class="btn btn-sm btn-primary">öffnen</a></td></tr><tr><td><a href="/crm/neue-interessenten/bearbeiten/4917">11.11.2022 - 11:30 Uhr</a></td><td><a href="/crm/neue-interessenten/bearbeiten/4917" class="btn btn-sm btn-primary">öffnen</a></td></tr></tbody></table></div>
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
                    <a href="/crm/neue-auftraege" class="nav-link">Aktive</a>
                </li>
                <li class="nav-item">
                    <a href="/crm/auftrag-archiv" class="nav-link active">Archiv</a>
                </li>
                <li class="nav-item">
                    <a href="/crm/neue-auftraege/neuer-auftrag" class="nav-link">Neuer Auftrag</a>
                </li>
                <li class="nav-item">
                    <a href="/crm/alte-auftraege" class="nav-link">Alte Aufträge</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-5 text-right">
            <form action="/crm/globale-suche" method="post">
                <div class="form-group row mb-1">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <input type="text" id="global_keyword" name="global_keyword" value="" placeholder="Suchbegriff / Barcode" aria-label="Suchbegriff / Barcode" class="form-control bg-white text-primary border border-primary" style="border-radius: .25rem 0 0 .25rem">
                            <button type="submit" name="search" value="suchen" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        <button type="button" class="btn btn-secondary dropdown-toggle d-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('.global-dropdown-menu').slideToggle(0)" onfocus="this.blur()"></button>
                        <div class="global-dropdown-menu bg-white rounded-bottom border border-primary p-3" style="position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000">
                            <h6 class="text-left">Einträge&nbsp;pro&nbsp;Seite</h6>
                            <select id="global_rows" name="global_rows" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="80">80</option>
                                <option value="100">100</option>
                                <option value="200" selected="selected">200</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                            </select>
                            <h6 class="text-left mt-2">Sortierfeld</h6>
                            <select id="global_sorting_field" name="global_sorting_field" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
    <option value="0">Bereich</option>
    <option value="1">Aktualisierungsdatum</option>
    <option value="2" selected="selected">Übertragen</option>
    <option value="3">Erstelldatum</option>
    <option value="4">Auftragsnummer</option>
                            </select>
                            <h6 class="text-left mt-2">Sortierrichtung</h6>
                            <select id="sorting_direction" name="sorting_direction" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                                <option value="0">Aufsteigend</option>
                                <option value="1" selected="selected">Absteigend</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 text-center">
    <style>
    .card_lb_success {
        display: inline-block;
        width: calc(25% - 10px);
        border-top: 1px solid rgba(0,0,0,0.125);
        border-right: 1px solid rgba(0,0,0,0.125);
        border-bottom: 1px solid rgba(0,0,0,0.125);
        border-left: 4px solid var(--success);
        border-radius: .35rem;
        padding: 18px 10px 18px 20px;
        margin: 0 10px 0 0;
    }
    .card_lb_warning {
        display: inline-block;
        width: calc(25% - 20px);
        border-top: 1px solid rgba(0,0,0,0.125);
        border-right: 1px solid rgba(0,0,0,0.125);
        border-bottom: 1px solid rgba(0,0,0,0.125);
        border-left: 4px solid var(--warning);
        border-radius: .35rem;
        padding: 18px 10px 18px 20px;
        margin: 0 10px;
    }
    .card_lb_danger {
        display: inline-block;
        width: calc(25% - 20px);
        border-top: 1px solid rgba(0,0,0,0.125);
        border-right: 1px solid rgba(0,0,0,0.125);
        border-bottom: 1px solid rgba(0,0,0,0.125);
        border-left: 4px solid var(--danger);
        border-radius: .35rem;
        padding: 18px 10px 18px 20px;
        margin: 0 10px;
    }
    .card_lb_info {
        display: inline-block;
        width: calc(24% - 10px);
        border-top: 1px solid rgba(0,0,0,0.125);
        border-right: 1px solid rgba(0,0,0,0.125);
        border-bottom: 1px solid rgba(0,0,0,0.125);
        border-left: 4px solid var(--info);
        border-radius: .35rem;
        padding: 18px 10px 18px 20px;
        margin: 0 0 0 10px;
    }
    .card_lb_content {
        float: left;
        width: calc(100% - 60px);
    }
    .card_lb_title {
        font-size: 11pt;
        font-weight: 600;
    }
    .card_lb_percent {
        font-size: 13pt;
        font-weight: 600;
        margin: 0 0 0 30px;
    }
    .card_lb_value_div {
        display: block;
    }
    .card_lb_value_content {
        display: inline-block;
    }
    .card_lb_value {
        font-size: 18pt;
    }
    .card_lb_progress {
        display: inline-block;
        height: 8px;
        background-color: var(--light);
        width: 80%;
        border-radius: 5px;
        padding: 1px;
        margin: 0 0 4px 8px;
    }
    .card_lb_progress_bar {
        float: left;
        height: 6px;
        background-color: var(--info);
        border-radius: 4px;
        padding: 0;
        margin: 0 0 2px 0;
    }
    .card_lb_logo {
        width: 60px;
        float: left;
    }
    .card_lb_logo_size {
        font-size: 48px;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    </style>
    <div>
            <form action="/crm/auftrag-archiv" method="post">
                <div class="text-right mb-3">
                    <div class="form-group row mb-0">
                        <div class="col-sm-5 text-left">
                            <h2>Persönliche Übersicht</h2>
                        </div>
    <div class="col-sm-7 text-right"><input type="hidden" name="admin_id" value="8">
                            <button type="submit" name="set_date" value="Heute" class="btn btn-sm btn-success">Heute <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="1 Tag" class="btn btn-sm btn-primary">1 Tag <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="2 Tag(e)" class="btn btn-sm btn-primary">2 Tag(e) <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="3 Tag(e)" class="btn btn-sm btn-primary">3 Tag(e) <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="1 Woche" class="btn btn-sm btn-primary" style="transform: scale(1);">1 Woche <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="2 Wochen" class="btn btn-sm btn-primary">2 Wochen <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="3 Wochen" class="btn btn-sm btn-primary">3 Wochen <i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <button type="submit" name="set_date" value="1 Monat" class="btn btn-sm btn-primary">1 Monat <i class="fa fa-calendar" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        <div>
    <div class="card_lb_success bg-white text-left shadow">
        <div class="card_lb_content">
            <span class="card_lb_title text-success">Neuaufträge</span><span class="card_lb_percent">1%</span><br>
            <span class="card_lb_value">1 von 53</span>
        </div>
        <div class="card_lb_logo text-center mt-1">
            <i class="fa fa-cart-arrow-down fa_icon card_lb_logo_size text-light"></i>
        </div>
    </div>
    <div class="card_lb_danger bg-white text-left shadow">
        <div class="card_lb_content">
            <span class="card_lb_title text-danger">Prüfungen</span><span class="card_lb_percent">0%</span><br>
            <span class="card_lb_value">0 von 53</span>
        </div>
        <div class="card_lb_logo text-center mt-1">
            <i class="fa fa-check-square fa_icon card_lb_logo_size text-light"></i>
        </div>
    </div>
    <div class="card_lb_warning bg-white text-left shadow">
        <div class="card_lb_content">
            <span class="card_lb_title text-warning">Versand</span><span class="card_lb_percent"></span><br>
            <span class="card_lb_value"><a href="#" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<table class='table table-white table-sm table-bordered text-white m-0'>
        <tr><th><b>Datum</b></th><th><b>Auftrag/Sendungen</b></th><th><b>Versand/Sendungen</b></th><th><b>Gesamt</b></th></tr>
    <tr><td>11.11.2022</td><td class='text-center'>0</td><td class='text-center'>0</td><td class='text-center'>0</td></tr>
    </table>">0</a></span>
        </div>
        <div class="card_lb_logo text-center mt-1">
            <i class="fa fa-truck fa_icon card_lb_logo_size text-light"></i>
        </div>
    </div>
    <div class="card_lb_info bg-white text-left shadow">
        <div class="card_lb_content">
            <span class="card_lb_title text-info">Zentrale</span><span class="card_lb_percent">&nbsp;</span><br>
            <div class="card_lb_value_div"><div class="card_lb_value_content"><span class="card_lb_value"><a href="#" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<table class='table table-white table-sm table-bordered text-white m-0'>
        <tr><th><b>Name</b></th><th><b>Rückruf</b></th><th><b>Reklamation</b></th></tr>
        <tr class='text-light'><td><b>Martin Luber (IH)</b></td><td class='text-center'>2</td><td class='text-center'>0</td></tr>
    </table>">ansehen</a></span></div></div>
        </div>
        <div class="card_lb_logo text-center mt-1">
            <i class="fa fa-list fa_icon card_lb_logo_size text-light"></i>
        </div>
    </div>
        </div>
    </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-7">
            <h3>Auftragsarchiv</h3>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right">
                    <form id="order_search" action="/crm/auftrag-archiv" method="post">
                <div class="form-group row mb-1">
                    <div class="col-sm-12">
                        <input type="hidden" id="keyword" name="keyword" value="" placeholder="Suchbegriff / Barcode" aria-label="Suchbegriff / Barcode" class="form-control bg-white text-primary border border-primary" style="border-radius: .25rem 0 0 .25rem">
                        <button type="submit" name="search" value="suchen" class="btn btn-primary d-none"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <div class="btn-group">
                            <button type="submit" name="set_search_defaults" value="OK" class="btn btn-primary">Löschen <i class="fa fa-eraser" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('.my-dropdown-menu').slideToggle(0)" onfocus="this.blur()">Filter</button>
                        </div>
                        <div class="my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3" style="position: absolute;top: 40px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000">
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
                            <h6 class="text-left mt-2">Sortierfeld</h6>
                            <select id="sorting_field" name="sorting_field" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
    <option value="0" selected="selected">Status</option>
    <option value="1">Aktualisierungsdatum</option>
    <option value="2">Übertragen</option>
    <option value="3">Erstelldatum</option>
    <option value="4">Auftragsnummer</option>
                            </select>
                            <h6 class="text-left mt-2">Sortierrichtung</h6>
                            <select id="sorting_direction" name="sorting_direction" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                                <option value="0" selected="selected">Aufsteigend</option>
                                <option value="1">Absteigend</option>
                            </select>
                            <hr>
                            <select id="extra_search" name="extra_search" class="custom-select text-primary border border-primary" onchange="this.form.submit()">
                            <option value="0">Alle Vorgänge</option>
                            <option value="4">In Bearbeitung (Abteilung Technik)</option>
                            <option value="5">Angebot versendet</option>
                            <option value="7">Auftrag in Prüfung</option>
                            <option value="10">Auftrag in gesonderter Überprüfung</option>
                            <option value="13">Auftrag in gesonderter Bearbeitung</option>
                            <option value="14">Reklamation bearbeitet</option>
                            <option value="19">Rückruf</option>
                            <option value="21">Auftrag im Prüfprozess</option>
                            <option value="25">Auftrag in der Dokumentierung (Auswertung)</option>
                            <option value="32">Auftrag in gesonderter Auswertung</option>
                            <option value="35">In Bearbeitung (Zusätzliche Handhabung)</option>
                            <option value="36">Auftrag erfasst (intern)</option>
                            <option value="83">Auftrag in gesonderter Prüfung</option>
                            <option value="102">Bearbeitung abgeschlossen, Zahlung per Nachnahme</option>
                            <option value="142">Zahlungsverzug</option>
                            <option value="148">Auftrag in Nachprüfung</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
    
        </div>
    </div>
    <hr>
    <br>
    <div class="table-responsive">
        <table class="table table-white table-sm table-bordered table-hover mb-0">
            <thead><tr class="bg-white text-primary">
                <th width="40" scope="col">
                    <div class="custom-control custom-checkbox mt-0 ml-2">
                        <input type="checkbox" id="order_sel_all_top" class="custom-control-input" onclick="var check = $('#order_sel_all_bottom').prop('checked');$('#order_sel_all_bottom').prop('checked', this.checked);$('.order-list').each(function(){$(this).prop('checked', !check);if(check == true){$(this).closest('tr').removeClass('active');}else{$(this).closest('tr').addClass('active');}});">
                        <label class="custom-control-label" for="order_sel_all_top"></label>
                    </div>
                </th>
                <th width="40" scope="col" align="center">
                    <div style="width: 40px;height: 24px;font-size: 1rem" class="text-primary text-center"><i class="fa fa-clock-o"> </i></div>
                </th>
                <th width="120" scope="col">
                    <div class="d-block text-nowrap">
                        <div class="d-inline">
                            <div class="d-inline" style="width: 10px">
                                <a href="#" onclick="orderSearchDirection(2, 0)"><i class="fa fa-caret-up"> </i></a><a href="#" onclick="orderSearchDirection(2, 1)"><i class="fa fa-caret-down"> </i></a>
                            </div>
                        </div>
                        <div class="d-inline"><strong>Erstellt</strong></div>
                    </div>
                </th>
                <th width="40" scope="col" align="center">
                    <div style="width: 40px;height: 24px;font-size: 1rem" class="text-primary text-center"><i class="fa fa-music"> </i></div>
                </th>
                <th width="60" scope="col" class="text-center">
                    <div class="d-block text-nowrap">
                        <div class="d-inline">
                            <div class="d-inline" style="width: 10px">
                                <a href="#" onclick="orderSearchDirection(4, 0)"><i class="fa fa-caret-up"> </i></a><a href="#" onclick="orderSearchDirection(4, 1)"><i class="fa fa-caret-down"> </i></a>
                            </div>
                        </div>
                        <div class="d-inline"><strong>Nr</strong></div>
                    </div>
                </th>
                <th scope="col">
                    <strong>Kunde</strong>
                </th>
                <th scope="col">
                    <div class="d-block text-nowrap">
                        <div class="d-inline">
                            <div class="d-inline" style="width: 10px">
                                <a href="#" onclick="orderSearchDirection(0, 0)"><i class="fa fa-caret-up"> </i></a><a href="#" onclick="orderSearchDirection(0, 1)"><i class="fa fa-caret-down"> </i></a>
                            </div>
                        </div>
                        <div class="d-inline"><strong>Status</strong></div>
                    </div>
                </th>
                <th width="120" scope="col">
                    <div class="d-block text-nowrap">
                        <div class="d-inline">
                            <div class="d-inline" style="width: 10px">
                                <a href="#" onclick="orderSearchDirection(2, 0)"><i class="fa fa-caret-up"> </i></a><a href="#" onclick="orderSearchDirection(2, 1)"><i class="fa fa-caret-down"> </i></a>
                            </div>
                        </div>
                        <div class="d-inline text-nowrap"><strong>Geändert</strong></div>
                    </div>
                </th>
                <th scope="col">
                    <strong>Mitarbeiter</strong>
                </th>
                <th width="150" scope="col">
                    <strong>Zuteilung</strong>
                </th>
                <th width="140" scope="col">
                    <strong>Telefonnummer</strong>
                </th>
                <th width="140" scope="col">
                    <strong>Letzte Zahlung</strong>
                </th>
                <th width="140" align="center" scope="col" class="text-center">
                    <strong>Aktion</strong>
                </th>
            </tr></thead>
    <form action="/crm/auftrag-archiv" method="post"></form>
        <tbody>
            @foreach ($person as $p)
            <tr class="orders_archiv_menu" onclick="if($(this).hasClass('active')){$(this).removeClass('active');}else{$(this).addClass('active');}$('#order_list_5121').prop('checked', !$('#order_list_5121').prop('checked'))" data-id="5121" data-order_number="42828">
                <td scope="row">
                    <div class="custom-control custom-checkbox mt-1 ml-2">
                        <input type="checkbox" id="order_list_5121" data-id="5121" class="custom-control-input order-list" onclick="if($(this).closest('tr').hasClass('active')){$(this).closest('tr').removeClass('active');}else{$(this).closest('tr').addClass('active');}">
                        <label class="custom-control-label" for="order_list_5121"></label>
                    </div>
                </td>
                <td scope="row" align="center">
                    NAN
                </td>
                <td class="text-nowrap">
                    <small>{{$p->created_at->format("d.m.Y")}}</small> <small class="text-muted">({{$p->created_at->format("h:m")}})</small>
                </td>
                <td scope="row">
                    <div style="width: 40px;height: 30px;font-size: 1rem" class="text-primary text-center pt-1"><i class="fa fa-ban"> </i></div>
                </td>
                <td scope="row" align="center">
                    <small>{{$p->process_id}}</small>
                </td>
                <td>
                    <div style="width: 250px;white-space: nowrap;overflow-x: hidden"><small>{{$p->firstname}} {{$p->lastname}}</small></div>
                </td>
                <td align="center">
                    @foreach ($statuses as $status)
                        @foreach ($orders as $order)
                            @if ($order->process_id == $p->process_id)
                                @if ($status->id == $order->current_status)
                                <span class="badge badge-pill" style="background-color: {{$status->color}}">{{$status->name}}</span>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td class="text-nowrap">
                    <small>{{$p->updated_at->format("d.m.Y")}}</small> <small class="text-muted">({{$p->updated_at->format("h:m")}})</small>
                </td>
                <td>
                    <div style="width: 120px;white-space: nowrap;overflow-x: hidden"><small>@foreach ($employees as $emp)
                        @if ($emp->id == $p->employee)
                            {{$emp->name}}
                        @endif
                    @endforeach</small></div>
                </td>
                <td>
                    <small>@foreach ($orders as $order)
                        @if ($order->process_id == $p->process_id)
                            {{$order->zuteilung}}
                        @endif
                    @endforeach</small>
                </td>
                <td>
                    <small>{{$p->phone_number}}</small>
                </td>
                <td>
                    <div style="width: 140px;white-space: nowrap;overflow-x: hidden"><small>{{$p->last_payment}}</small></div>
                </td>
                <td align="center">
                    <div style="white-space: nowrap">
                        <input type="hidden" name="id" value="5121">
                        <button type="button" name="edit" value="bearbeiten" class="btn btn-sm btn-success" onclick="window.location.href = '{{url('/')}}/crm/archive/order/{{$p->process_id}}'">bearbeiten <i class="fa fa-pencil" aria-hidden="true"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
    
    
    
        </tbody></table>
    </div>
    <form action="/crm/auftrag-archiv" method="post">
        <table class="table table-white table-sm mb-0">
            <tbody><tr class="text-primary">
                <td width="40">
                    <div class="custom-control custom-checkbox mt-1 ml-2">
                        <input type="checkbox" id="order_sel_all_bottom" class="custom-control-input" onclick="var check = $('#order_sel_all_top').prop('checked');$('#order_sel_all_top').prop('checked', this.checked);$('.order-list').each(function(){$(this).prop('checked', !check);if(check == true){$(this).closest('tr').removeClass('active');}else{$(this).closest('tr').addClass('active');}});">
                        <label class="custom-control-label" for="order_sel_all_bottom"></label>
                    </div>
                </td>
                <td width="350">
                    <label for="order_sel_all_bottom" class="mt-1">alle auswählen (1 bis 292 von 292 Einträgen)</label>
                </td>
                <td width="260">
                    <select name="status" class="custom-select custom-select-sm text-primary border border-primary" style="width: 200px">
                            <option value="1">Auftrag abgeschlossen und versendet</option>
                            <option value="3">Austausch abgeschlossen</option>
                            <option value="4">In Bearbeitung (Abteilung Technik)</option>
                            <option value="5">Angebot versendet</option>
                            <option value="6">In Bearbeitung (Auftrag freigegeben)</option>
                            <option value="7">Auftrag in Prüfung</option>
                            <option value="9">In Bearbeitung (Endprüfung und Freigabe)</option>
                            <option value="10">Auftrag in gesonderter Überprüfung</option>
                            <option value="11">Reklamation eingegangen</option>
                            <option value="12">In Bearbeitung (Abteilung Technik - Teile im Zulauf)</option>
                            <option value="13">Auftrag in gesonderter Bearbeitung</option>
                            <option value="14">Reklamation bearbeitet</option>
                            <option value="15">Reklamation abgeschlossen</option>
                            <option value="17">In Bearbeitung (zusätzliche Bearbeitung)</option>
                            <option value="18">In Bearbeitung (Angebot abgelehnt)</option>
                            <option value="19">Rückruf</option>
                            <option value="20">In Bearbeitung (Rechnung per Mail versendet)</option>
                            <option value="21">Auftrag im Prüfprozess</option>
                            <option value="22">In Bearbeitung (Reklamation bearbeitet, Gerät wird versendet)</option>
                            <option value="23">In Bearbeitung (Auftragsprüfung abgeschlossen)</option>
                            <option value="24">In Bearbeitung (Auftrag Angebot per E-Mail)</option>
                            <option value="25">Auftrag in der Dokumentierung (Auswertung)</option>
                            <option value="26">In Bearbeitung (Auftrag Teilrückerstattung)</option>
                            <option value="27">Auftrag wird priorisiert bearbeitet</option>
                            <option value="28">In Bearbeitung (Abteilung Verarbeitungstechnik)</option>
                            <option value="29">In Bearbeitung (Abteilung Speichertechnik)</option>
                            <option value="30">Bearbeitung abgeschlossen, warte auf Zahlungseingang</option>
                            <option value="31">Zahlungseingang</option>
                            <option value="32">Auftrag in gesonderter Auswertung</option>
                            <option value="33">warte auf eine Fehlerbeschreibung!</option>
                            <option value="34">warte auf zusätzliche Bauteile</option>
                            <option value="35">In Bearbeitung (Zusätzliche Handhabung)</option>
                            <option value="83">Auftrag in gesonderter Prüfung</option>
                            <option value="100">Angebot versandt</option>
                            <option value="101">warte auf Kundenrückmeldung</option>
                            <option value="142">Zahlungsverzug</option>
                            <option value="148">Auftrag in Nachprüfung</option>
                    </select> 
                    <input type="hidden" id="ids" name="ids" value="">
                    <button type="submit" name="multi_status" value="durchführen" class="btn btn-sm btn-primary" onclick="var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich den gewählten Status für die ausgewählten Einträge durchführen?');}"><i class="fa fa-check" aria-hidden="true"></i></button>
                </td>
                <td width="200">
                    <div class="custom-control custom-checkbox mt-1 ml-2">
                        <input type="checkbox" id="no_email" name="no_email" value="1" class="custom-control-input">
                        <label class="custom-control-label" for="no_email">Keine E-Mail senden</label>
                    </div>
                </td>
                <td align="right">
                </td>
            </tr>
        </tbody></table>
    </form>
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
    <script>
    var dates = [
        {"id": 5302, "mode": 2, "today": true, "date": "11.11.2022 09:20"}, 
        {"id": 5265, "mode": 2, "today": true, "date": "11.11.2022 09:30"}, 
        {"id": 5278, "mode": 2, "today": true, "date": "11.11.2022 09:40"}, 
        {"id": 5284, "mode": 2, "today": true, "date": "11.11.2022 09:45"}, 
        {"id": 5232, "mode": 2, "today": true, "date": "11.11.2022 09:50"}, 
        {"id": 5220, "mode": 2, "today": true, "date": "11.11.2022 10:00"}, 
        {"id": 5277, "mode": 2, "today": true, "date": "11.11.2022 10:05"}, 
        {"id": 5295, "mode": 2, "today": true, "date": "11.11.2022 10:10"}, 
        {"id": 5276, "mode": 2, "today": true, "date": "11.11.2022 10:15"}, 
        {"id": 5294, "mode": 2, "today": true, "date": "11.11.2022 10:20"}, 
        {"id": 5204, "mode": 2, "today": true, "date": "11.11.2022 10:22"}, 
        {"id": 5279, "mode": 2, "today": true, "date": "11.11.2022 10:30"}, 
        {"id": 5289, "mode": 2, "today": true, "date": "11.11.2022 10:45"}, 
        {"id": 5247, "mode": 2, "today": true, "date": "11.11.2022 10:50"}, 
        {"id": 5129, "mode": 2, "today": true, "date": "11.11.2022 10:50"}, 
        {"id": 5262, "mode": 2, "today": true, "date": "11.11.2022 11:15"}, 
        {"id": 5297, "mode": 2, "today": true, "date": "11.11.2022 11:20"}, 
        {"id": 4917, "mode": 2, "today": true, "date": "11.11.2022 11:30"}, 
        {"id": 5309, "mode": 2, "today": false, "date": "14.11.2022 09:45"}, 
        {"id": 5112, "mode": 2, "today": false, "date": "14.11.2022 10:00"}, 
        {"id": 5285, "mode": 2, "today": false, "date": "14.11.2022 10:10"}, 
        {"id": 5253, "mode": 2, "today": false, "date": "14.11.2022 10:15"}, 
        {"id": 5308, "mode": 2, "today": false, "date": "14.11.2022 10:20"}, 
        {"id": 5286, "mode": 2, "today": false, "date": "14.11.2022 10:30"}, 
        {"id": 5304, "mode": 2, "today": false, "date": "14.11.2022 10:35"}, 
        {"id": 5245, "mode": 2, "today": false, "date": "14.11.2022 10:45"}, 
        {"id": 5306, "mode": 2, "today": false, "date": "14.11.2022 10:50"}, 
        {"id": 5026, "mode": 2, "today": false, "date": "14.11.2022 11:00"}, 
        {"id": 5207, "mode": 2, "today": false, "date": "14.11.2022 11:10"}, 
        {"id": 5303, "mode": 2, "today": false, "date": "14.11.2022 11:20"}, 
        {"id": 5115, "mode": 2, "today": false, "date": "14.11.2022 11:45"}, 
        {"id": 5311, "mode": 2, "today": false, "date": "15.11.2022 09:30"}, 
        {"id": 5272, "mode": 2, "today": false, "date": "15.11.2022 10:45"}, 
        {"id": 5161, "mode": 2, "today": false, "date": "15.11.2022 12:00"}, 
        {"id": 5263, "mode": 2, "today": false, "date": "16.11.2022 09:35"}, 
        {"id": 5300, "mode": 2, "today": false, "date": "16.11.2022 10:00"}, 
        {"id": 5270, "mode": 2, "today": false, "date": "17.11.2022 10:15"}, 
        {"id": 5239, "mode": 2, "today": false, "date": "17.11.2022 10:45"}, 
        {"id": 5257, "mode": 2, "today": false, "date": "23.11.2022 12:23"}, 
        {"id": 5218, "mode": 2, "today": false, "date": "24.11.2022 10:00"}, 
        {"id": 4966, "mode": 2, "today": false, "date": "24.11.2022 11:00"}, 
        {"id": 5156, "mode": 2, "today": false, "date": "24.11.2022 12:30"}, 
        {"id": 5195, "mode": 2, "today": false, "date": "28.11.2022 11:45"}, 
        {"id": 5293, "mode": 2, "today": false, "date": "05.12.2022 09:45"}, 
        {"id": 5221, "mode": 2, "today": false, "date": "04.01.2023 12:20"}, 
    ];
    </script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    $(function(){
    
        $('body')
            .append('<div id="mouse_info" class="position-absolute d-none bg-white border border-primary rounded text-center px-2 pt-2 pb-0" style="opacity: 0.65"></div>')
            .mousemove(function(event){
                $('#mouse_info').css({'left': (parseInt(event.pageX) + 20) + 'px', 'top': (parseInt(event.pageY) - 20) + 'px'});
            });
    
        $('#order_sel_all_top, #order_sel_all_bottom, .orders_archiv_menu').on('click', function(){
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
            /*showOn: 'both',*/
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
    <div id="mouse_info" class="position-absolute d-none bg-white border border-primary rounded text-center px-2 pt-2 pb-0" style="opacity: 0.65; left: 2270px; top: 86px;"></div><div class="modal fade" id="showStatussesDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-xl" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> DETAILS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_iframe" src="/crm/blank" width="100%" height="480" class="border"></iframe>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal_xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-xl" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">TITLE</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_xl_iframe" src="/crm/blank" width="100%" height="740" class="border"></iframe>			</div>		</div>	</div></div><div class="modal fade" id="iframeModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog" role="document">		<div class="modal-content">			<div class="modal-header card-header">				<h5 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">EXTRA-TOOLS</h5>				<button type="button" class="close" data-dismiss="modal" aria-label="Close">					<span aria-hidden="true">×</span>				</button>			</div>			<div class="modal-body">				<iframe id="iframeModal_iframe2" src="/crm/blank" width="100%" height="1000" class="border"></iframe>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-success" onclick="if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframeModal_iframe2').print();}else{document.getElementById('iframeModal_iframe2').contentWindow.print();}">drucken <i class="fa fa-print" aria-hidden="true"></i></button> <button type="button" class="btn btn-secondary" data-dismiss="modal">schließen <i class="fa fa-times" aria-hidden="true"></i></button>			</div>		</div>	</div></div><div class="modal fade" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-dialog-centered" role="document">		<div class="modal-content">			<div class="modal-body">				<br><br><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Loading...</h1></div></div><br><br>			</div>		</div>	</div></div><div class="modal fade" id="autologoutModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	<div class="modal-dialog modal-dialog-centered" role="document">		<div class="modal-content">			<div class="modal-body">				<br><br><div class="row"><div class="col-sm-2"></div><div class="col-sm-2"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div><div class="col-sm-8"><h1>Automatisches abmelden in <span id="autologout2">59</span> Sekunden</h1>Wollen Sie dies abbrechen?</div></div><br><br>			</div>			<div class="modal-footer card-footer">				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.clearInterval(autologout2_interval);autologout_interval = window.setInterval(function (){setAutologout();}, 1000);">abbrechen</button>			</div>		</div>	</div></div></body></html>