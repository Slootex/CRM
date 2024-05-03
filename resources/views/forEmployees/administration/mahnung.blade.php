<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <script src="{{url('/')}}/js/barcode.js"></script>

    @vite('resources/css/app.css')
</head>
<body onload="createBarcode()">

    

    <button onclick="printJS('main', 'html')">awd</button>
    
    <div id="main">
        <div style="position: absolute">
            <img src="{{url("/")}}/img/logo.png" alt="" style="width: 300px; height: 140px;">
        </div>
        <div style="margin-right: 75px; margin-top: 50px;">
            <p style="text-align: right; font-family: Arial; font-size: 13px;">GZA MOTORS</p>
            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -12px">Strausberger Platz 13</p>       

            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -11px">10243 Berlin</p>       

            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -4px;">Deutschland</p>       

            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -4px;">Telefon: 042159564922</p>       

            <p style="text-align: right; font-family: Arial; font-size: 13px; padding-bottom: 10px; margin-top: -12px">Telefax: 042117668953</p>       


            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -12px">info@gzamotors.de</p>       

            <p style="text-align: right; font-family: Arial; font-size: 13px; margin-top: -12px">www.gzamotors.de</p>

        </div>
        <div style="width: 40px; height: .1vw; border: solid black .1vw; border-top: none; border-left: none; border-right: none; position: absolute; margin-top: 48px; margin-left: 80px"></div>
        <div style="width: 40px; height: .1vw; border: solid black .1vw; border-top: none; border-left: none; border-right: none; position: absolute; margin-top: 48px; margin-left: 320px;"></div>

        <div style="width: 40px; height: .1vw; border: solid black .1vw; border-top: none; border-left: none; border-right: none; position: absolute; margin-top: 228px; margin-left: 80px"></div>
        <div style="width: 40px; height: .1vw; border: solid black .1vw; border-top: none; border-left: none; border-right: none; position: absolute; margin-top: 228px; margin-left: 320px;"></div>

        <div style="width: .1vw; height: 40px; border-top: none; border-left: solid black .1vw; border-right: none; position: absolute; margin-top: 190px; margin-left: 80px"></div>
        <div style="width: .1vw; height: 40px; border-top: none; border-left: solid black .1vw; border-right: none; position: absolute; margin-top: 190px; margin-left: 360px;"></div>

        <div style="width: .1vw; height: 40px; border-top: none; border-left: solid black .1vw; border-right: none; position: absolute; margin-top: 49px;margin-left: 80px"></div>
        <div style="width: .1vw; height: 40px; border-top: none; border-left: solid black .1vw; border-right: none; position: absolute; margin-top: 49px; margin-left: 360px;"></div>

        <div style="margin-top: 50px; margin-left: 80px;  width: 290px; padding: 15px; position: absolute">
            <p style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; letter-spacing: -.5px; text-decoration: underline">GZA MOTORS - Strausberger Platz 13 - 10243 Berlin</p>
            <p style="font-family: Arial, Helvetica, sans-serif; margin-top: -5px">RKG Markenwelt GmbH & Co. KG</p>
            <p style="font-family: Arial, Helvetica, sans-serif; margin-top: -13px">Herr Ralph Hüskes</p>
            <p style="font-family: Arial, Helvetica, sans-serif; margin-top: -13px">Friedenstraße 51</p>
            <p style="font-family: Arial, Helvetica, sans-serif; ">53229 Bonn</p>
        </div>
        <div style="width: 360px; height: 280px; border: solid black .1vw; margin-left: 425px; margin-top: 100px;">
            <img src="{{url("/")}}/img/gray.png" alt="" style="position: absolute; width: 358px; height: 278px; margin-top: 1px; margin-left: 1px; z-index: 1">
            <p style="z-index: 100; position: absolute; margin-top: 10px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;"><b>Rechnungs Nr:</b></p>
            <div style="position: absolute; z-index: 100; width: 170px; height: 15px; background-color: white; margin-left: 180px; margin-top: 10px;"></div>
            <p style="z-index: 100; position: absolute; margin-top: 30px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Rechnungs Datum:</p>
            <div style="position: absolute; z-index: 100; width: 170px; height: 15px; background-color: white; margin-left: 180px; margin-top: 30px;"></div>
            <div style="position: absolute; z-index: 100; width: 360px; height: .1vw;  margin-left: 0px; margin-top: 50px; border: solid black .1vw; border-top: none"></div>
            <p style="z-index: 100; position: absolute; margin-top: 54px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Auftragsnummer</p>
            <div style="position: absolute; z-index: 100; width: 160px; height: 15px; background-color: white; margin-left: 7px; margin-top: 75px;"></div>
            <p style="z-index: 100; position: absolute; margin-top: 54px; margin-left: 180px; font-family: Arial, Helvetica, sans-serif;">Ihr Bestelldatum</p>
            <div style="position: absolute; z-index: 100; width: 170px; height: 15px; background-color: white; margin-left: 180px; margin-top: 75px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 95px; margin-left: 180px; font-family: Arial, Helvetica, sans-serif;">Seite</p>
            <div style="position: absolute; z-index: 100; width: 170px; height: 15px; background-color: white; margin-left: 180px; margin-top: 115px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 134px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Zahlungsart:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 137px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 160px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Versandart:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 164px;"></div>
            
            <p style="z-index: 100; position: absolute; margin-top: 184px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Bestellt durch:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 188px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 208px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Bearbeiter:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 214px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 232px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Bearbeiter Tel:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 236px;"></div>

            <p style="z-index: 100; position: absolute; margin-top: 256px; margin-left: 7px; font-family: Arial, Helvetica, sans-serif;">Bearbeiter Mail:</p>
            <div style="position: absolute; z-index: 100; width: 230px; height: 15px; background-color: white; margin-left: 120px; margin-top: 260px;"></div>
        </div>
        <div style="position: absolute; width: 100vw; margin-left: 70px;">
            <h3 style="margin-top: -100px; font-family: Arial, Helvetica, sans-serif; font-size: 24px;">Rechnung</h3>
            <div style="position: absolute; z-index: 100; width: 320px; height: .1vw;  margin-left: 0px; margin-top: -15px; border: solid black .1vw; border-top: none"></div>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: -10px;">Lieferanschrift:</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: -12px; margin-left: 115px;">RKG Markenwelt GmbH & Co. KG</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 4px; margin-left: 115px;">Herr Ralph Hüskes</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 21px; margin-left: 115px;">Friedenstraße 51</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 36px; margin-left: 115px;">53229 Bonn</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 49px; margin-left: 115px;">Deutschland</p>
        </div>

        <div style="position: absolute; width: 100%; margin-top: 55px; margin-left: -10px;"  >


            <p id="mahnungstext"></p>
            
        </div>
        <script>
            function loadMahnungsText() {
            }
        </script>
        <div style="position: absolute; width: 710px; margin-top: 250px; margin-left: 71px; border: solid black .1vw; height: 80px; border-right-width: .54w;">
            <img src="{{url("/")}}/img/gray.png" alt="" style="position: absolute; width: 99.8%; height: 78px; margin-top: 1px; margin-left: 1px; z-index: 1">

            <p style="position: absolute; margin-top: 1px; margin-left: 4px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; z-index: 100"><b>Hinweis:</b></p>
            <p style="position: absolute; margin-top: 18px; margin-left: 4px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; z-index: 100">Der Zahlungseingang muß vor dem Versand Ihres Auftrags erfolgt sein. Die Ware bleibt bis zur restlosen
                Bezahlung unser Eigentum.</p>
                <p style="position: absolute; margin-top: 60px; margin-left: 4px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; z-index: 100">Das Leistungsdatum ist gleich das Rechnungsdatum.</p>
        </div>
        <div style="position: absolute; width: 100%; margin-top: 50px;">

           
            <div style="position: absolute; z-index: 100; width: 100vw; height: .1vw;  margin-left: -10px; margin-top: 400px; border: solid black .1vw; border-top: none"></div>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 0px; margin-top: 403px; font-size: 11.5px;">GZA MOTORS</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 0px; margin-top: 415px; font-size: 11.5px;">Strausberger Platz 13</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 0px; margin-top: 429px; font-size: 11.5px;">10243 Berlin</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 0px; margin-top: 442px; font-size: 11.5px;">Deutschland</p>

            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 140px; margin-top: 403px; font-size: 11.5px;">Telefon: 042159564922</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 140px; margin-top: 415px; font-size: 11.5px;">Telefax: 042117668953</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 140px; margin-top: 429px; font-size: 11.5px;">E-Mail: info@gzamotors.de</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 140px; margin-top: 442px; font-size: 11.5px;">Internet: www.gzamotors.de</p>
        
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 340px; margin-top: 403px; font-size: 11.5px;">Ust.-IdentNr: DE284008608</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 340px; margin-top: 415px; font-size: 11.5px;">SteuerNr: 111420200914</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 340px; margin-top: 429px; font-size: 11.5px;">Gläubiger-IdNr</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 340px; margin-top: 442px; font-size: 11.5px;">DE19ZZZ00002093275</p>
        
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 540px; margin-top: 403px; font-size: 11.5px;">solarisBank Berlin</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 540px; margin-top: 415px; font-size: 11.5px;">IBAN: DE75110101015665686305</p>
            <p style="position: absolute; font-family: Arial, Helvetica, sans-serif; font-size: 16px; margin-left: 540px; margin-top: 429px; font-size: 11.5px;">BIC: SOBKDEB2XXX</p>
        
        </div>
        <svg id="barcode"></svg>

    </div>
    <script>
        function createBarcode() {
            JsBarcode("#barcode", "12341", {
                height: 10,
                width: 2.5,
                displayValue: false
            });

            loadMahnungsText()

            document.getElementById("barcode").style.marginTop = "200px";
            document.getElementById("barcode").style.marginLeft = "83%";
            document.getElementById("barcode").style.transform = "rotate(90deg)";

        }
    </script>
</body>
</html>