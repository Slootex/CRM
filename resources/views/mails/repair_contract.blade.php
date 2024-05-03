<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<style>
    p {
        color: black;
        font-size: 40px:
    }
</style>
<body>
    <p>{{$lead->gender}} {{$lead->firstname}} {{$lead->lastname}}, [#{{$lead->process_id}}]<p>
    <p>vielen Dank für Ihre Anfrage.</p>
<br>
    <p>Auftragsnummer: <b>[#{{$lead->process_id}}]</b></p>
<br>
    <p>Um Ihren Auftrag zu bearbeiten benötigen wir:</p>
    <p><b>+Ihr defektes Bauteil</b></p>
    <p><b>+ein Auftragsformular</b></p>
<br>
    <p>Auftragsformular (Online): <a href="https://www.gzamotors.de/auftrag/schritt-1">https://www.gzamotors.de/auftrag/schritt-1</a></p>
    <p>Auftragsformular (PDF):   <a href="https://www.gzamotors.de/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf"> https://www.gzamotors.de/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf</a></p>
    <p>Auftrag aktualisieren:  <a href="https://www.gzamotors.de/auftrag/aktualisieren/{{$lead->process_id}}">https://www.gzamotors.de/auftrag/aktualisieren/{{$lead->process_id}}</a></p>
<br>
<p>Für Ihre persönliche Geräteabgabe oder den Versand bitte folgende Adresse nutzen:</p>
<br>
<p><b>GZA MOTORS - Mail Boxes Etc.</b></p>
<p><b>Violenstraße 37</b></p>
<p><b>28195 Bremen</b></p>
<br>
<p>(Mo - Fr : 08 - 18 Uhr)</p>
<br>
<p>Bei weiteren Fragen, rufen Sie uns gerne unter Tel.-Nr.: 0421-59564922 an.</p>
<br>
<p>Bei weiteren Fragen, rufen Sie uns gerne unter Tel.-Nr.: 0421-59564922 an.</p>
<br>
<p>--</p>
<p>Best regards / Mit freundlichen Grüßen</p>
</body>
</html>