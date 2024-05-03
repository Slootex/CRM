<!DOCTYPE html>
<html lang="en" class="w-full h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script> 
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body onload="setCurrentTime()">
<script>
  function setCurrentTime() {
    @if(!isset($pickupContact))
    let date = new Date(); 
    if(date.getHours() <= 9) {
      document.getElementById("pickupStartHour").value = "0" + date.getHours();
    } else {
      document.getElementById("pickupStartHour").value = date.getHours();
    }

    document.getElementById("pickupEndHour").value = date.getHours() + 2;
     @endif

  }
</script>

    @include('layouts.error')
    @include('layouts.top-menu', ["menu" => "none"])
    @isset($pickup)
        <div id="pickupFinish">
            @include('forEmployees.modals.ABHOLUNGerfolgreich', ["pickup", $pickup])

        </div>
    @endisset

    <h1 class="py-6 text-4xl font-bold ml-8 text-black">UPS Abholauftrag</h1>
    

    <div class=" m-auto mt-2 h-auto">
      <form action="{{url("/")}}/crm/abholung/beauftragen" method="POST">
        @CSRF
        <div class="flex">
        <div style="width: 50%; " class=" grid grid-cols-3 gap-2 px-8">
        <div class="mt-6">
            <label for="price" class="block text-normal font-normal text-gray-700"></label>
            <div class="relative mt-1 rounded-md shadow-sm">

              <input type="date" required name="pickupDate" value="{{date('Y-m-d')}}" id="price" class="block w-full rounded-md border-blue-500 pl-2 pr-2 focus:border-blue-500 focus:ring-blue-500 text-normal" placeholder="16.12.2000" aria-describedby="price-currency">
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 pl-4 bg-blue-600 hover:bg-blue-500 rounded-md rounded-l-none">
                <p class="text-white">Datum</p>
              </div>
            </div>
        </div>
        <div class="col-span-2">
            <p class="block text-normal font-normal text-gray-700 mt-1">Abholuhrzeit</p>
            <div class="flex">
              <input type="time" required oninput="setTimeForward(this.value)" name="von" id="von-time" class="w-full rounded-md border-gray-400">
              <p class="px-2 mt-1 text-xl font-bold">-</p>
              <input type="time" required oninput="setTimeBackward(this.value)" name="bis" id="bis-time" class="w-full rounded-md border-gray-400">
            </div>
        </div>
        <script>
          function setTimeForward(von) {
            let parts = von.split(':'); 
            let hours = null;

            if(parseInt(parts[0])+2 >= 24) {
              hours = parseInt(parts[0])+2-24;
              hours = "0" + hours;

            } else {
              if(parseInt(parts[0])+2 <= 9) {
                hours = parseInt(parts[0])+2;
                hours = "0" + hours;
              } else {
                hours = parseInt(parts[0])+2;
              }
            }

            document.getElementById('bis-time').value = hours+':'+parts[1];
          }

          function setTimeBackward(bis) {
            let parts = bis.split(':'); 
            let hours = null;

if (parseInt(parts[0]) - 2 <= 0) {
  hours = parseInt(parts[0]) - 2 + 24;
  hours = "0" + hours;
} else if (parseInt(parts[0]) - 2 <= 9) {
  hours = parseInt(parts[0]) - 2;
  hours = "0" + hours;
} else {
  hours = parseInt(parts[0]) - 2;
}

document.getElementById('von-time').value = hours + ':' + parts[1];

if (parseInt(parts[0]) >= 0 && parseInt(parts[0]) <= 1) {
  document.getElementById('von-time').value = "23:" + parts[1];
} else if (parseInt(parts[0]) == 22) {
  document.getElementById('von-time').value = "00:" + parts[1];
}

          }
        </script>
        <div  class="mt-2">
            <label for="location" class="block text-normal font-normal text-gray-700">Versand</label>
            <select id="location" name="shippingType" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
              @isset($pickupContact)
              @if ($pickupContact->service == "65")
              <option value="65" selected>UPS Express</option>
              <option value="11">UPS Standard</option>
          @endif
          @if ($pickupContact->service == "11")
              <option value="65">UPS Express</option>
              <option value="11" selected>UPS Standard</option>
          @endif
          @else
          <option value="11">UPS Standard</option>
          <option value="65">UPS Express</option>

              @endisset

            </select>
        </div>
        <div  class="mt-2">
            <label for="location" class="block text-normal font-normal text-gray-700">Hinweis</label>
            <div class="mt-1">
              <input type="text" name="notice" id="email" value="{{date('Y_m_d_')}} @isset($pickupContact){{$pickupContact->shortcut}} @endisset" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
            </div>
        </div>
        <div  class="mt-2">
            <label for="location" class="block text-normal font-normal text-gray-700">Referenznummer</label>
            <div class="mt-1">
              <input type="text" name="refrenceNumber" value="{{date('Y_m_d_')}} @isset($pickupContact){{$pickupContact->shortcut}} @endisset" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
            </div>
        </div>

        <div  class="mt-2  ">
            <label for="price" class="block text-normal font-normal text-gray-700">Gesamtpakete</label>
            <div class="relative mt-1 rounded-md shadow-sm">

              <input type="text" required name="packageCount" @isset($pickupContact) value="{{$pickupContact->quantity}}" @endisset id="price" class="block w-full rounded-md border-gray-300 pl-2 pr-2 focus:border-blue-500 focus:ring-blue-500 text-normal" placeholder="1" aria-describedby="price-currency">
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 pl-4 bg-gray-200 rounded-md rounded-l-none">
                <p class="text-black">Stück</p>
              </div>
            </div>
        </div>
        <div class="mt-2  ">
            <label for="price" class="block text-normal font-normal text-gray-700">Gesamtgewicht</label>
            <div class="relative mt-1 rounded-md shadow-sm">

              <input type="text" required name="packageWeight" @isset($pickupContact) value="{{$pickupContact->weight}}" @endisset id="price" class="block w-full rounded-md border-gray-300 pl-2 pr-2 focus:border-blue-500 focus:ring-blue-500 text-normal" placeholder="1" aria-describedby="price-currency">
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 pl-4 bg-gray-200 rounded-md rounded-l-none">
                <p class="text-black">kg</p>
              </div>
            </div>
        </div>
        <div></div>
            <h1 class="mt-2  font-semibold text-lg">Abholadresse auswählen</h1>
            <div  class=" mt-4 float-left">
                <label for="location" class="block text-normal font-normal text-gray-700">Adressbuch</label>
                <select id="location" name="contact" onchange="window.location.href = '{{url('/')}}/crm/abholung/contact/' + this.value" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  <option value="">an Kunde</option>
                  @isset($pickupContact)
                        <option value="{{$pickupContact->id}}" selected>{{$pickupContact->shortcut}}</option>
                        @foreach ($contacts->sortBy("shortcut") as $contact)
                            <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                        @endforeach
                      @else
                        @foreach ($contacts->sortBy("shortcut") as $contact)
                            <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                        @endforeach
                  @endisset
                </select>
            </div>
            <div class="mt-4  ">
                <label for="location" class="block text-normal font-normal text-gray-700">Auftrag</label>
                <div class="mt-1">
                  <input type="text" name="auftrag" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="   col-span-3">
                <label for="location" class="block text-normal font-normal text-gray-700">Firma</label>
                <div class="mt-1">
                  <input type="text" name="companyName" id="email" @isset($pickupContact) value="{{$pickupContact->companyname}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class=" ">
                <label for="location" class="block text-normal font-normal text-gray-700">Anrede</label>
                <select id="location" name="gender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @isset($pickupContact) 
                        @if ($pickupContact->gender == "0")
                            <option value="Herr" selected>Herr</option>
                            <option value="Frau">Frau</option>
                            @else
                            <option value="Herr">Herr</option>
                            <option value="Frau" selected>Frau</option>
                        @endif

                        @else
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                    @endisset
                </select>
            </div>
            <div class=" ">
                <label for="location" class="block text-normal font-normal text-gray-700">Vorname</label>
                <div class="mt-1">
                  <input type="text" required name="firstname" id="email" @isset($pickupContact) value="{{$pickupContact->firstname}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Nachname</label>
                <div class="mt-1">
                  <input type="text" required name="lastname" id="email" @isset($pickupContact) value="{{$pickupContact->lastname}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <input type="hidden" name="lat">

<input type="hidden" name="long">
<script>

  google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {

      var input = document.getElementById('home_street');

      var autocomplete = new google.maps.places.Autocomplete(input);


      autocomplete.addListener('place_changed', function () {

                    
        var place = autocomplete.getPlace();
        
        let types = [];
        let names = [];
          
        place.address_components.forEach(comp => {
            types.push(comp.types[0]);
            names.push(comp["long_name"]);
        });
        console.log(types);
        console.log(names);
        let counter = 0
        document.getElementById("home_street").value = "";
        document.getElementById("home_street_number").value = "";
        document.getElementById("home_city").value = "";
        document.getElementById("home_zipcode").value = "";
        document.getElementById("home_country").value = "";
        console.log(types);
        types.forEach(type => {
          let name = names[counter];
          if(type == "route") {
            let street    = name;
            document.getElementById("home_street").value = street;
          }
          if(type == "street_number") {
            let number    = name;
            document.getElementById("home_street_number").value = number;
          }
          if(type == "postal_town") {
            let city    = name;
            document.getElementById("home_city").value = city;
          }
          if(type == "locality") {
            let city    = name;
            document.getElementById("home_city").value = city;
          }
          if(type == "postal_code") {
            let zipcode    = name;
            document.getElementById("home_zipcode").value = zipcode;
          }
          if(type == "country") {
            let country    = name;
            document.getElementById("home_country").value = country;
          }
          counter++;
        });
  
  

    });

  }

</script>
            <div  class=" col-span-2">
                <label for="location" class="block text-normal font-normal text-gray-700">Straße</label>
                <div class="mt-1">
                  <input type="text" required name="street" id="home_street" @isset($pickupContact) value="{{$pickupContact->street}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class=" ">
                <label for="location" class="block text-normal font-normal text-gray-700">Straßennummer</label>
                <div class="mt-1">
                  <input type="text" required name="streetNumber" id="home_street_number" @isset($pickupContact) value="{{$pickupContact->streetno}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Postleitzahl</label>
                <div class="mt-1">
                  <input type="text" required name="zipcode" id="home_zipcode" @isset($pickupContact) value="{{$pickupContact->zipcode}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>

            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Stadt</label>
                <div class="mt-1">
                  <input type="text" required name="city" id="home_city" @isset($pickupContact) value="{{$pickupContact->city}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="">
                <label for="home_country" class="block text-normal font-normal text-gray-700">Land</label>
                <select required name="country" id="home_country" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  @isset($pickupContact)
                      <option value="{{$pickupContact->country}}" selected>{{$countries->where("id", $pickupContact->country)->first()->name}}/option>
                      @php
                      $mostUsedCountries = array("Großbritannien", 
                              "Italien", "Litauen", 
                              "Luxemburg", "Niederlande", 
                              "Österreich", "Polen", 
                              "Schweden", "Schweiz", 
                              "Spanien", "Ungarn");
                  @endphp
                  @foreach ($countries->sortBy('name') as $country)
                    @if (in_array($country->name, $mostUsedCountries))
                        @if ($country->id != $pickupContact->country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endif
                    @endif
                  @endforeach
                  <option value="" class="font-bold">Andere Länder</option>
                  @foreach ($countries->sortBy('name') as $country)
                    @if (!in_array($country->name, $mostUsedCountries))
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endif
                  @endforeach
                      @else
                      <option value="Deutschland">Deutschland</option>

                      <option value="" class="font-bold">Häufigste Länder</option>


                      @php
                          $mostUsedCountries = array("Großbritannien", 
                                  "Italien", "Litauen", 
                                  "Luxemburg", "Niederlande", 
                                  "Österreich", "Polen", 
                                  "Schweden", "Schweiz", 
                                  "Spanien", "Ungarn");
                      @endphp
                      @foreach ($countries->sortBy('name') as $country)
                        @if (in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endif
                      @endforeach
                      <option value="" class="font-bold">Andere Länder</option>
                      @foreach ($countries->sortBy('name') as $country)
                        @if (!in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endif
                      @endforeach
                  @endisset
                 
                </select>
            </div>
            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Email</label>
                <div class="mt-1">
                  <input type="email" required name="email" id="email" @isset($pickupContact) value="{{$pickupContact->email}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Mobil</label>
                <div class="mt-1">
                  <input type="text" required name="mobilNumber" id="email" @isset($pickupContact) value="{{$pickupContact->mobilnumber}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
            <div class="">
                <label for="location" class="block text-normal font-normal text-gray-700">Festnetz</label>
                <div class="mt-1">
                  <input type="text" name="phoneNumber" id="email" @isset($pickupContact) value="{{$pickupContact->phonenumber}}" @endisset class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                </div>
            </div>
           
    </div>
    <div style="height: 50rem; width: .1vw" class="bg-gray-300 border border-gray-300 m-auto"></div>
    <div style="width: 48%" class="ml-4">
        <div class=" w-full">
            <h1 class="text-lg font-semibold">Erstellte Abholaufträge</h1>
            <button type="button" onclick="refreshPickups()" class="float-right text-right mr-6 bg-blue-600 hover:bg-blue-400 p-1 rounded-md text-white" style="margin-top: -1.3rem">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
              </svg>
            </button>

        </div>

        <div class="mt-7 flow-root" id="contacts-table">
                
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Erstellt</th>
                      <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                      <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Adresse</th>
                      <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Referenz</th>
                      <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Zeit</th>
                      <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Status</th>
                      <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
                        <p class="text-right">Aktion</p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($pickups->sortByDesc("created_at") as $p)
                    <tr>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">{{$p->created_at->format("d.m.Y (H:i)")}}</td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">@if($users->where("id", $p->employee)->first() != null) {{$users->where("id", $p->employee)->first()->username}} @endif</td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">
                        @if ($p->shortcut == null)
                          {{$p->street}} {{$p->streetno}}
                        @else
                          {{$p->shortcut}}
                        @endif
                      </td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">{{$p->refrence}}</td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">{{$p->date}} ({{$p->von}} - {{$p->bis}})</td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-left">
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">abgeholt</span>
                      </td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm  text-left">
                        <div class=" rounded-lg px-2" >
                          <a href="{{url('/')}}/crm/abholung/delete/{{$p->id}}" class="text-red-600 hover:text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-right p-1 rounded">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                          </a>
                          </div>
                        <div class=" rounded-lg m-auto" >
                          <a href="{{url('/')}}/crm/abholung/get/{{$p->id}}" class="float-right text-blue-600 hover:text-blue-400">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7  p-1 float-right rounded">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                        </svg>
                      </a>
                        </div>

                      </td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>

    </div>
    <div class="mt-8 ml-8 mb-4">
      <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Abholung beauftragen</button>
  </div>
  </form>
    </div>

    <script>
      function refreshPickups() {
        $.ajax({
          url: "{{url('/')}}/crm/abholung/refresh",
          type: "GET",
          success: function(data) {
            window.location.href = "{{url('/')}}/crm/abholung";
          }
        });
      }
    </script>
</body>
</html>