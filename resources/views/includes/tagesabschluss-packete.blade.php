<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
    <script src="{{url('/')}}/js/text.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="js/test.js"></script>

</head>
<body onload="printJS('print', 'html')">
    @include('layouts.top-menu', ["menu" => "auftrag"])

    <div id="print">
        <h4 class="text-3xl text-center mt-4">Materialinventur</h4>

    <h4 class="float-left mt-4 ml-5" style="float: left; margin-top: 1rem; margin-left: 1rem;">Absender:</h4>
    <h4 class="ml-60 mt-4" style="margin-left: 15rem; margin-top: 5px">GZA MOTORS</h4>
    <h4 class="ml-60" style="margin-left: 15rem; margin-top: 0px">Inh. Gazi Ahmad</h4>
    <h4 class="ml-60" style="margin-left: 15rem; margin-top: 0px">Strausbergerplatz. 13</h4>
    <h4 class="ml-60" style="margin-left: 15rem; margin-top: 0px">10243 Berlin</h4>
    <h4 class="ml-60" style="margin-left: 15rem; margin-top: 0px">Deutschland</h4>
    @php
        $packets = 0;
    @endphp
    <table class="mt-10 m-auto">
        <th class=" ">
            <td class="px-6 border-2 border-black" style="font-size: 20px; padding-left: 10px; padding-right: 10px">Name</td>
            <td class="px-6 border-2 border-black" style="font-size: 20px; padding-left: 10px; padding-right: 10px">Auftragsnummer</td>
            <td class="px-6 border-2 border-black" style="font-size: 20px; padding-left: 10px; padding-right: 10px">Sendungsnummer</td>
        </th>
        @foreach ($ausgang as $as)
        <tr class="">
            <td></td>
            <td class="text-center border-2 border-black" style="font-size: 15px; text-align: center">{{$as->firstname}} {{$as->lastname}}</td>
            <td class="text-center border-2 border-black" style="font-size: 15px; text-align: center">{{$as->process_id}}</td>
            <td class="text-center border-2 border-black" style="font-size: 15px; text-align: center">{{$as->label}}</td>
        </tr>
        @php
            $packets++;
        @endphp
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="border: solid black 1px; border-left: none; border-right: none">Packete: {{$packets}}</td>
        </tr>
    </table>

<h4 class="mt-36 ml-4">Hiermit bestätige ich die Übernahme der oben <br>
    aufgeführten Pakete in einem äußerlich unversehrten Zustand.</h4>

    <h4 class="mt-16 ml-4">@php echo date("d.m.Y") @endphp, Berlin</h4>
    <p style="margin-top: -1vw;">_____________________________________________________________________________________</p>
    <h4 class="ml-4 float-left mr-60" style="float: left; margin-right: 20rem;">Datum, Ort</h4>
    <h4>Unterschrift</h4>
<br>
    <h4 class="mt-16 ml-4">Hinweis: Bitte nehmen Sie diesen Beleg zu Ihren Unterlagen. <br>
        Er dient als Übergabenachweis im Schadens-bzw.Verlustfall.</h4>


    </div>

    <button onclick="printJS('print', 'html')" style="margin-top: 5rem; margin-left: 5rem; background-color: lightgray">Neu Drucken</button>
</body>
</html>