<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    @vite('resources/js/app.js')


    @vite('resources/css/app.css')
</head>
<body>

    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    <div>

        <div class="p-10 rounded-md bg-white m-auto mt-10" style="width: 95%;">

            <div class="float-left">
                <div>
                    <h1 class="text-blue-600 font-semibold text-3xl">Inventur</h1>
                </div>
                <div class="mt-10 m-auto" style="width: 30rem">
                    <div>
                        <p class="text-2xl float-left">Gerätenummer</p>
                        <input oninput="checkInputs()" id="barcode" type="text" class="rounded-md h-12 w-60 border border-gray-600 text-2xl text-center float-right ml-10">
                    </div>
                    <div class="mt-10">
                        <p class="text-2xl mt-8 float-left">Lagerplatz</p>
                        <input oninput="checkInputs()" id="shelfe" type="text" class="rounded-md float-right h-12 w-60 border border-gray-600 text-2xl text-center ml-10 mt-4">
                    </div>
                </div>
            </div>

            <div>
                <div class="float-left ml-10" style="width: 56rem">
                    <h1 class="text-3xl font-semibold mb-8">Lagerplatz</h1>
                    @php
                    $allShelfes = $shelfes;
                    @endphp
                    @include('forEmployees.packtisch.inventurLagerplatzübersich')
                </div>
                
            </div>

            <div class=" float-right" style="overflow: auto; height: 40rem">
                <table>
                    <tr>
                        <th class="text-xl text-left pb-11">Lagerplatz</th>
                        <th class="text-xl text-left pl-5 pb-11">Gerätenummer</th>
                    </tr>

                    @foreach ($shelfes as $shelfe)
                        <tr class="">
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" id="{{$shelfe->shelfe_id}}" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block text-red-600">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>                                  
                                <p class="inline-block ml-1">{{$shelfe->shelfe_id}}</p>
                                </td>
                            <td class="pl-4">
                                <svg xmlns="http://www.w3.org/2000/svg" id="{{$shelfe->shelfe_id}}-devicesvg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block text-red-600">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                                @isset($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first()->component_number)
                                    <p class="inline-block ml-1" id="{{$shelfe->shelfe_id}}-device">{{$usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first()->component_number}}</p>
                                    @else
                                    <p class="inline-block ml-1" id="{{$shelfe->shelfe_id}}-device"></p>
                                @endisset
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
            <div class="h-96 w-96">

            </div>
            <div class="mt-60">
                <form action="{{url("/")}}/crm/finish/inventur" method="POST" id="inventur-form">
                    @CSRF

                    <button type="submit" class="px-6 py-3 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold">Inventur abschließen</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function checkInputs() {
            let shelfe = document.getElementById('shelfe').value;
            let device = document.getElementById('barcode').value;

            if(shelfe != "" && device != "") {
                if(shelfe.length == 3 && device.length == 14) {
                    document.getElementById(shelfe).classList.remove("text-red-600");
                    document.getElementById(shelfe).classList.add("text-green-600");
                    document.getElementById(shelfe + "-devicesvg").classList.remove("text-red-600");
                    document.getElementById(shelfe + "-devicesvg").classList.add("text-green-600");
                    document.getElementById(shelfe + "-device").innerHTML = device;

                    document.getElementById('schrank-' + shelfe).classList.remove("bg-red-200");
                    document.getElementById('schrank-' + shelfe).classList.add("bg-green-200");

                    let input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", shelfe);
                    input.setAttribute("value", device + ":" + shelfe);
                    document.getElementById("inventur-form").appendChild(input);

                    document.getElementById('shelfe').value = "";
                    document.getElementById('barcode').value = "";
                } else {
                    if(shelfe.length == 3 && device.length == 13 && device.includes("AT")) {
                    document.getElementById(shelfe).classList.remove("text-red-600");
                    document.getElementById(shelfe).classList.add("text-green-600");
                    document.getElementById(shelfe + "-devicesvg").classList.remove("text-red-600");
                    document.getElementById(shelfe + "-devicesvg").classList.add("text-green-600");
                    document.getElementById(shelfe + "-device").innerHTML = device;

                    document.getElementById('schrank-' + shelfe).classList.remove("bg-red-200");
                    document.getElementById('schrank-' + shelfe).classList.add("bg-green-200");

                    document.getElementById('shelfe').value = "";
                    document.getElementById('barcode').value = "";
                }
                }
            } 
        }
        </script>

</body>
</html>