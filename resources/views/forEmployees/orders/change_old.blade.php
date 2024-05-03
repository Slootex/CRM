<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     </head>
    <body @isset($tab)
    onload="changeTab('{{$tab}}')"
@endisset>

    @include('layouts.top-menu', ["menu" => "auftrag", "person" => $person])
<style>
   @import "~@geoapify/geocoder-autocomplete/styles/minimal.css";

  .autocomplete-container {
    position: relative;
}
</style>
<div>
  <button type="button" onclick="window.location.href='{{url('/')}}/crm/auftrag-zu-archive/{{$person->process_id}}'" class="float-right mr-36 mt-8 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">zum Archiv</button>
</div>
<input type="hidden" name="lat">

<input type="hidden" name="long">
<script>

  google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {

      var input = document.getElementById('home_street');
      var input2 = document.getElementById('send_back_street');

      var autocomplete = new google.maps.places.Autocomplete(input);
      var autocomplete2 = new google.maps.places.Autocomplete(input2);

      autocomplete2.addListener('place_changed', function () {

      var place = autocomplete2.getPlace();
      let types = [];
      let names = [];
        
      place.address_components.forEach(comp => {
          types.push(comp.types[0]);
          names.push(comp["long_name"]);
      });
      console.log(types);
      console.log(names);
      let counter = 0
      types.forEach(type => {
        let name = names[counter];
        if(type == "route") {
          let street    = name;
          document.getElementById("send_back_street").value = street;
        }
        if(type == "street_number") {
          let number    = name;
          document.getElementById("send_back_street_number").value = number;
        }
        if(type == "postal_town") {
          let city    = name;
          document.getElementById("send_back_city").value = city;
        }
        if(type == "locality") {
          let city    = name;
          document.getElementById("send_back_city").value = city;
        }
        if(type == "postal_code") {
          let zipcode    = name;
          document.getElementById("send_back_zipcode").value = zipcode;
        }
        if(type == "country") {
          let country    = name;
          document.getElementById("send_back_country").value = country;
        }
        counter++;
      });



      // place variable will have all the information you are looking for.

      $('#lat').val(place.geometry['location'].lat());

      $('#long').val(place.geometry['location'].lng());

    });


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



      // place variable will have all the information you are looking for.

      $('#lat').val(place.geometry['location'].lat());

      $('#long').val(place.geometry['location'].lng());

    });

  }

</script>
<div >
    <div class="ml-16 mt-10">
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option>My Account</option>
      
            <option>Company</option>
      
            <option selected>Team Members</option>
      
            <option>Billing</option>
          </select>
        </div>
        <h1>Auftragsnummer: {{$person->process_id}}<br>Ansprechpartner: {{$person->firstname}} {{$person->lastname}}<br>Aktueller Status:@foreach ($statuses as $status) @if ($status->id == $order->current_status)<span class="rounded-xl px-2" >{{$status->name}}</span> @endif
      @endforeach</h1>
        <div class="hidden sm:block">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
              <!-- Current: "border-blue-500 text-blue-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
              <a href="#kundendatenn" onclick="changeTab('kundendaten')" id="kundendaten1" class="border-blue-500 text-blue-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                <!--
                  Heroicon name: mini/user
      
                  Current: "text-blue-500", Default: "text-gray-400 group-hover:text-gray-500"
                -->
                <svg id="kundendaten2" class="text-blue-500 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                </svg>
                <span>Kundendaten</span>
              </a>
      
              <a href="#auftragsdatenn" onclick="changeTab('auftragsdaten')" id="auftragsdaten1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/building-office -->
                <svg id="auftragsdaten2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z" />
                </svg>
                <span>Auftragsdaten</span>
              </a>
      
      
              <a href="#statusn" onclick="changeTab('status')" id="status1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/credit-card -->
                <svg id="status2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>                
                <span>Auftragsverlauf</span>
              </a>

              <a href="#auftragshistoriee" onclick="changeTab('auftragshistory')" id="auftragshistory1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/credit-card -->
                <svg xmlns="http://www.w3.org/2000/svg" id="auftragshistory2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                            
                <span>Auftraghistorie</span>
              </a>
              <a href="#internn" onclick="changeTab('intern')" id="intern1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/credit-card -->
                <svg xmlns="http://www.w3.org/2000/svg" id="intern2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                            
                <span>Intern</span>
              </a>
              <a href="#zahlungenn" onclick="changeTab('zahlungen')" id="zahlungen1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/credit-card -->
                <svg xmlns="http://www.w3.org/2000/svg" id="zahlungen2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                            
                            
                <span>Zahlungen</span>
              </a>
              <a href="#einkäufee" onclick="changeTab('einkäufe')" id="einkäufe1" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                <!-- Heroicon name: mini/credit-card -->
                <svg xmlns="http://www.w3.org/2000/svg" id="einkäufe2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                            
                            
                <span>Einkäufe</span>
              </a>
            </nav>
          </div>
        </div>
      </div>
      <script>
      function geolocate(id) {
      var elem = document.getElementById(id);
      var requestOptions = {
  method: 'GET',
};
var test;
fetch("https://api.geoapify.com/v1/geocode/autocomplete?text="+ elem.value +"&format=json&apiKey=678d18e9877b413492a30ac82eaa1b51", requestOptions)
  .then(response => response.json())
  .then(result => {
    Object.keys(result).forEach(key => {
      Object.keys(result[key]).forEach(key1 => {

        console.log(result[key][key1]["name"]);
    });
  });
  })
  .catch(error => console.log('error', error));


      }
      </script>
      
      <form action="/crm/change/order_data/{{$person->process_id}}" method="POST" >
        @CSRF
        <div id="kundendaten" class="">
          
       
    <div class="mt-5 m-auto" style="width: 93%;">
        <div class="bg-white px-8 py-8 shadow sm:rounded-lg sm:p-6 mt-6 pr-60 w-full" >
                
              <div class="mt-5 md:col-span-2 md:mt-0 float-left" style="width: 35%">
                <div class="grid grid-cols-6 gap-2">
                    <div class="col-span-4 sm:col-span-4">
                        <h3>Rechnungsinformationen</h3>
                    </div>
                  <div class="col-span-4 sm:col-span-4">
                    <input type="hidden" name="employee" id="" value="{{session()->get("username")}}">
                    <input type="hidden" name="pricemwst" value="19">
                      <label for="first-name" class="block text-sm font-normal text-gray-700">Firma</label>
                      <input type="text" name="companyname" value="{{$person->company_name}}" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="location" class="block text-sm font-normal text-gray-700">Anrede</label>
                      <select id="location" name="gender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @if ($person->gender == "Herr")
                        <option selected value="Herr">Herr</option>
                        @else
                        <option value="Herr">Herr</option>
                        @endif
                        @if ($person->gender == "Frau")
                        <option selected value="Frau">Frau</option>
                        @else
                        <option value="Frau">Frau</option>
                        @endif
                      </select>
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="first-name" class="block text-sm font-normal text-gray-700">Vorname</label>
                    <input type="text" value="{{$person->firstname}}" name="firstname" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-3">
                    <label for="last-name" class="block text-sm font-normal text-gray-700">Nachname</label>
                    <input type="text" name="lastname" value="{{$person->lastname}}" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-4">
                    <label for="email-address" class="block text-sm font-normal text-gray-700">Straße</label>
                    <input type="text"  name="home_street" value="{{$person->home_street}}" id="home_street"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  <div id="test">

                  </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-normal text-gray-700">Straßennummer</label>
                      <input type="text" name="home_street_number" value="{{$person->home_street_number}}" id="home_street_number" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-normal text-gray-700">Postleitzahl</label>
                      <input type="text" name="home_zipcode" id="home_zipcode" value="{{$person->home_zipcode}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-normal text-gray-700">Stadt</label>
                      <input type="text" name="home_city" id="home_city" value="{{$person->home_city}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-2">
                    <label for="home_country" class="block text-sm font-normal text-gray-700">Land</label>
                    <select id="home_country" name="home_country" value="{{$person->home_country}}" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @php
                            $mostUsedCountries = array("Großbritannien", 
                                  "Italien", "Litauen", 
                                  "Luxemburg", "Niederlande", 
                                  "Österreich", "Polen", 
                                  "Schweden", "Schweiz", 
                                  "Spanien", "Ungarn");
                        @endphp

                      @isset($person->home_country)
                          <option value="{{$countries->where('name', $person->home_country)->first()->name}}">{{$countries->where('name', $person->home_country)->first()->name}}</option>
                          @endisset
                        <option value="" class="font-bold">Häufigste Länder</option>
                        @isset($person->home_country)
                          @if ($person->home_country != "Deutschland")
                          <option value="Deutschland">Deutschland</option>
                          @endif
                        @endisset
                        @foreach ($countries->sortBy('name') as $country)
                          @if (in_array($country->name, $mostUsedCountries))
                              @isset($person->home_country)
                                  @if ($country->name != $person->home_country)
                                  <option value="{{$country->name}}">{{$country->name}}</option>
                                  @endif
                              @else
                              <option value="{{$country->name}}">{{$country->name}}</option>
                              @endisset
                          @endif
                        @endforeach
                        <option value="" class="font-bold">Andere Länder</option>
                        @foreach ($countries->sortBy('name') as $country)
                          @if (!in_array($country->name, $mostUsedCountries))
                              <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif
                        @endforeach
                    </select>
                  </div>
        
        
                  <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                    <label for="city" class="block text-sm font-normal text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{$person->email}}" autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <label for="region" class="block text-sm font-normal text-gray-700">Mobil</label>
                    <input type="text" name="mobil_number" id="region" value="{{$person->mobile_number}}" autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <label for="postal-code" class="block text-sm font-normal text-gray-700">Festnetz</label>
                    <input type="text" name="phone_number" id="postal-code" value="{{$person->phone_number}}" autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  
                  <div class="col-span-6 sm:col-span-5">
                    <div class="w-96">
                      <label for="diffrent_adress" class="block text-sm font-normal text-gray-700">Abweichende Adresse?</label>
                      <fieldset class="space-y-5">
                        
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            <input onclick="diff_street()" id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              
              <div style="margin-left: 35vw">
                <div style="border-left: 0.05vw solid rgb(197, 197, 197);height:500px; width: .1vw; margin-left: 15%;">

                <div class="col-span-5 sm:col-span-4 mt-8" style="margin-left: 5rem">
                    <label class="text-base font-normal text-gray-900">Versand</label>
                    <fieldset class="mt-4">
                      <legend class="sr-only">Notification method</legend>
                      <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center w-12 mt-0">
                          <input id="email" name="shipping_type" type="radio" value="standard" @if ($person->shipping_type == "standard")
                              checked
                          @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="email" class="ml-3 block text-sm font-normal text-gray-700">Standart</label>
                        </div>
                        <br>
                        <div class="flex items-center w-12">
                          <input id="sms" name="shipping_type" type="radio" value="express" @if ($person->shipping_type == "express")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="sms" class="ml-3 block text-sm font-normal text-gray-700">Express</label>
                        </div>
                        <br>
                        <div class="flex items-center w-20">
                          <input id="sms" name="shipping_type" type="radio" value="inernational" @if ($person->shipping_type == "inernational")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="sms" class="ml-3 block text-sm font-normal text-gray-700">International</label>
                        </div>
                        <br>
                        <div class="flex items-center w-12">
                          <input id="sms" name="shipping_type" type="radio" value="samstagszustellung" @if ($person->shipping_type == "samstagszustellung")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="sms" class="ml-3 block text-sm font-normal text-gray-700">Samstagszustellung</label>
                        </div>
                        <br>
                      </div>
                    </fieldset>
                  
                  <br>
                  <br>
                  <div class="col-span-6 sm:col-span-3">
                    <label class="text-base font-normal text-gray-900">Zahlart</label>
                    <fieldset class="mt-4">
                      <legend class="sr-only">Notification method</legend>
                      <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                          <input id="email" name="payment_type" type="radio" value="nachnahme" @if ($person->payment_type == "nachnahme")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="email" class="ml-3 block text-sm font-normal text-gray-700">Nachnahme</label>
                        </div>
                        <div class="flex items-center">
                          <input id="sms" name="payment_type" type="radio" value="transfer" @if ($person->payment_type == "transfer")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="sms" class="ml-3 block text-sm font-normal text-gray-700">Überweisung</label>
                        </div>
                        <div class="flex items-center">
                          <input id="sms" name="payment_type" type="radio" value="cash" @if ($person->payment_type == "cash")
                          checked
                      @endif class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                          <label for="sms" class="ml-3 block text-sm font-normal text-gray-700">Bar</label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  
                </div>
            </div>
              </div>
              <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>

            
            </div>
          </div>
        
        <br>
          <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6 hidden m-auto" style="width: 93%" id="different_street_div">
            <div class="md:grid md:grid-cols-3 md:gap-6">
              <div class="md:col-span-1">
                <h3 class="text-lg font-small leading-6 text-gray-900">Abweichende Rechnungsinformationen</h3>
              </div>
              <div class="mt-5 md:col-span-2 md:mt-0">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-4 sm:col-span-4">
                      <label for="first-name" class="block text-sm font-medium text-gray-700">Firma</label>
                      <input type="text" name="send_back_company_name" id="first-name" value="{{$person->send_back_company_name}}" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="location" class="block text-sm font-medium text-gray-700">Anrede</label>
                      <select id="location" name="send_back_gender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @if ($person->send_back_gender == "Herr")
                        <option selected value="Herr">Herr</option>
                        @else
                        <option>Herr</option>
                        @endif
                        @if ($person->send_back_gender == "Frau")
                        <option selected value="Frau">Frau</option>
                        @else
                        <option>Frau</option>
                        @endif
                      </select>
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Vorname</label>
                    <input type="text" name="send_back_firstname" value="{{$person->send_back_firstname}}" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium text-gray-700">Nachname</label>
                    <input type="text" name="send_back_lastname" value="{{$person->send_back_lastname}}" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-4">
                    <label for="email-address" class="block text-sm font-medium text-gray-700">Straße</label>
                    <input type="text" name="send_back_street" value="{{$person->send_back_street}}" id="send_back_street" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-medium text-gray-700">Straßennummer</label>
                      <input type="text" name="send_back_street_number" value="{{$person->send_back_street_number}}" id="send_back_street_number" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-medium text-gray-700">Postleitzahl</label>
                      <input type="text" name="send_back_zipcode" id="send_back_zipcode" value="{{$person->send_back_zipcode}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
                  <div class="col-span-2 sm:col-span-2">
                      <label for="email-address" class="block text-sm font-medium text-gray-700">Stadt</label>
                      <input type="text" name="send_back_city" id="send_back_city" value="{{$person->send_back_city}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                  </div>
        
                  <div class="col-span-6 sm:col-span-2">
                    <label for="send_back_country" class="block text-sm font-medium text-gray-700">Land</label>
                    <select id="send_back_country" name="send_back_country" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @isset($person->send_back_country)
                          <option value="{{$countries->where('name', $person->send_back_country)->first()->name}}">{{$countries->where('name', $person->send_back_country)->first()->name}}</option>
                        @endisset
                        <option value="" class="font-bold">Häufigste Länder</option>
                        @isset($person->send_back_country)
                        @if ($person->send_back_country != "Deutschland")
                        <option value="Deutschland">Deutschland</option>
                        @endif
                      @endisset
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
                            @if ($country->name != $person->send_back_country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                            @endif
                          @endif
                        @endforeach
                        <option value="" class="font-bold">Andere Länder</option>
                        @foreach ($countries->sortBy('name') as $country)
                          @if (!in_array($country->name, $mostUsedCountries))
                              <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif
                        @endforeach
                    </select>
                  </div>
                  <div class="col-span-6 sm:col-span-2">
                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
        <br>
        <br>
   
        <div id="new-device">
          </div> 










        <script>
          function loadDevice() {
            document.getElementById("new-device").classList.remove("hidden");
            document.getElementById("new-device").innerHTML = '<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="new-device"><div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div><div class="fixed inset-0 z-10 overflow-y-auto">  <div class="flex h-3/5 mt-40 items-end justify-center p-4 text-center sm:items-center sm:p-0">    <div class="relative transform overflow-hidden w-3/5 rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6">      <div>       <form class="space-y-8 divide-y divide-gray-200" action="{{url("/")}}/crm/auftraege-neues-geraet/{{$person->process_id}}" method="POST">         @CSRF         <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">                                                    <div class="space-y-6 sm:space-y-5">               <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Country</label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="shelfe_id" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     @foreach ($shelfes as $shelfe)                         @if ($shelfe->process_id == "0")                             <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} (0 von 1 Gerät)</option>                         @endif                     @endforeach                   </select>                 </div>               </div>               <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Gerätetyp</label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="component_type" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     <option value="1">Originalteil</option>                     <option value="2">Austauschteil</option>                   </select>                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Defektes Bauteil</label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="component" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     @foreach ($components as $comp)                         <option value="{{$comp->id}}">{{$comp->name}}</option>                     @endforeach                   </select>                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Hersteller</label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <input type="text" name="device_manufacturer" id="city" autocomplete="address-level2" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Teile.-/Herstellernummer</label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <input type="text" name="device_partnumber" id="city" autocomplete="address-level2" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Stammt das Gerät aus dem angegebenen Fahrzeug                 </label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="from_car" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     <option value="0">Nein</option>                     <option value="1">Ja</option>                   </select>                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Wurde durch Kunde geöffnet                 </label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="open_by_user" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     <option value="0">Nein</option>                     <option value="1">Ja</option>                   </select>                 </div>               </div>                      <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">                 <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Andere Bauteile am Gerät                 </label>                 <div class="mt-1 sm:col-span-2 sm:mt-0">                   <select id="country" name="other_components" autocomplete="country-name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs sm:text-sm">                     <option value="0">Nein</option>                     <option value="1">Ja</option>                   </select>                 </div>               </div>             </div>           </div>                  <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">             <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Speichern</button>             <button type="button" onclick="removeDevice()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm">Abbrechen</button>           </div>         </div>                      </div>           </div>         </div>                      </form>          </div>  </div>'
          }
          function removeDevice() {
            document.getElementById("new-device").classList.add("hidden");
          }
          
                     </script>
      
      
    <div class="mt-5 m-auto hidden"  id="auftragsdaten" style="width: 93%; margin-top: -2.78rem">
      <div class="bg-white px-8 py-8 shadow sm:rounded-lg sm:p-6 mt-6 pr-60 w-full">
        <div class="px-4 sm:px-6 lg:px-8 mb-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-normal text-gray-900">Gerätedaten</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <button type="button" onclick="loadDevice()" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
               neues Gerät</button>
            </div>
          </div>
          <div class="mt-3 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Gerät</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Bauteil</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Gerätetyp</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Hersteller</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Teile.-/Herstellernummer</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Info</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Lagerplatz</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">derzeitger Ort</th>
                        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Vorgänge</th>

                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                     
                      @foreach ($devices as $device)
                          @if (1 == 1)
                          <form action="{{url("/")}}/crm/change/device/{{$device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count}}">
                               <tr class="">
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$device->created_at->format("d.m.Y")}} ({{$device->created_at->format("H:i")}})</td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-blue-600" ><a href="{{url('/')}}/crm/auftrag/pdf/{{$device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count}}/{{$device->process_id}}/gerätedaten" >{{$device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count}}</a></td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                   <select name="component" id="" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                     @foreach ($components as $comp)
                                     @if ($comp->id == $device->component)
                                         <option selected value="{{$comp->id}}">{{$comp->name}}</option>
                                         @else
                                         <option value="{{$comp->id}}">{{$comp->name}}</option>
                                     @endif
                                   @endforeach
                                     </select></td>
                                     
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><select class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" name="typ" id="">
                                   @if (str_contains($device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, "ORG"))
                                   <option value="ORG" selected>ORG</option>
                                   <option value="AT">AT</option>
                                   @else
                                   <option value="AT" selected>AT</option>
                                   <option value="ORG" >ORG</option>
                                   @endif
                                 </select></td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><textarea name="device_manufacturer" id="" class="h-10 w-60 block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{$device->device_manufacturer}}</textarea></td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><textarea name="device_partnumber" id="" class="h-10 w-60 block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{$device->device_partnumber}}</textarea></td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><textarea name="info" id="" class="h-10 w-40 block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{$device->info}}</textarea></td>
                                 <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><select name="shelfe" id="" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                   
                                   <option value="delaawdete">Nicht im Lager</option>
                                   @foreach ($shelfes as $shelfe)
                                     @if ($shelfe->component_number == $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count)
                                     <option selected value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                     @endif
                                     @if ($shelfe->process_id == "0")
                                     <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                     @endif
                                 @endforeach
                               @foreach ($sh as $s)
                                   @if ($s->component_number == $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count)
                                       <option value="{{$s->shelfe_id}}" selected>{{$s->shelfe_id}}</option>
                                   @endif
                               @endforeach
                                   </select></td>
                                   <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                     @php
                                         $devs = false; 
                                     @endphp
                                     @foreach ($warenausgang as $ausgang)
                                         @if ($ausgang->component_number == $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count)
                                             @if ($devs == false)
                                                 Warenausgang
                                             @endif
                                             @php
                                                 $devs = true;
                                             @endphp
                                         @endif
                                     @endforeach
                                     
   
                                     @php
                                         $intern_ad = false;
                                     @endphp
                                     @foreach ($intern_auf as $interns)
                                     
                                         @if ($interns->process_id . "-" . $interns->component_id . "-" . $interns->component_type . "-" . $interns->component_count == $interns->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count)
                                         @if ($intern_ad == false)
                                         Intern
                                     @endif
                                     @php
                                         $intern_ad = true;
                                     @endphp
                                         @endif
                                     @endforeach
                                     
   
                                     @php
                                         $shipp = false;
                                     @endphp
                                     @foreach ($inshipping as $interns)
                                     
                                         @if ($interns->process_id . "-" . $interns->component_id . "-" . $interns->component_type . "-" . $interns->component_count == $interns->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count)
                                         @if ($shipp == false)
                                         im Versand
                                     @endif
                                     @php
                                         $shipp = true;
                                     @endphp
                                         @endif
                                     @endforeach
                                   </td>
                                 <td class="relative whitespace-nowraptext-right text-sm font-medium w-60">
                                   <button type="submit" class="float-left inline-flex items-center rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
                                   <button type="button" onclick="window.location.href='{{url('/')}}/crm/set/primarydevice/{{$device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count}}'" class="ml-6 inline-flex items-center rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Primär Gerät</button>
                                 </td>
                               </tr>
                           </form>
                           <!-- WENN KEIN TRANSPORTSACHDEN VORHANDEN IST
                                  WENN KEIN TRANSPORTSACHDEN VORHANDEN IST
                                WENN KEIN TRANSPORTSACHDEN VORHANDEN IST  -->
                            
                               
                          @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <form action="/crm/change/car/data/{{$person->process_id}}/auftragsdaten" method="POST">
          @CSRF
    <div class="mt-5 md:col-span-2 md:mt-0 float-left" style="width: 42.5%">
      <div class="grid grid-cols-6 gap-2">
          <div class="col-span-4 sm:col-span-4">
              <h3></h3>
          </div>
        
      
      </div>
    
</div>
    </div>

<div class="mt-5 m-auto hidden"  id="dokumente" style="width: 93%; margin-top: -2.78rem">

</div>
<div class="mt-1 m-auto hidden"  id="status" style="width: 93%; margin-top: -2.78rem">
  <div class="bg-white px-8 py-2 shadow sm:rounded-lg sm:p-6 mt-0 pr-60 w-full">
    
   
    <div class=" flex flex-col mt-0">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div>
              <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  <option selected>Alle</option>
            
                  <option>Status & Email</option>
            
                  <option>Telefonhistorie</option>
            
                  <option>Auftragshistorie</option>
                </select>
              </div>
              <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                  <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <!-- Current: "border-blue-500 text-blue-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                    <a href="#" onclick="changeStatTab('all')" id="all-tab" class="border-transparent text-green-500 hover:text-green-700 hover:border-green-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Alle</a>
            
                    <a href="#" onclick="changeStatTab('status')" id="status-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Status</a>

                    <a href="#" onclick="changeStatTab('email')" id="email-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Email</a>
            
                    <a href="#" onclick="changeStatTab('phone')" id="phone-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Telefonhistorie</a>
            
                    <a href="#" onclick="changeStatTab('dokumente')" id="dokumente-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Dokumente</a>

                    <a href="#" onclick="changeStatTab('auftrag')" id="auftrag-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Auftragshistorie</a>
                  </nav>
                </div>
              </div>
            </div>

            <script>
              var now_tab = 'all';
              function changeStatTab(tab) {
                document.getElementById(now_tab + "-sm").classList.add("hidden");
                document.getElementById(now_tab + "-tab").classList.remove("text-green-500");
                document.getElementById(now_tab + "-tab").classList.remove("text-gray-500");

                document.getElementById(tab + "-sm").classList.remove("hidden");
                document.getElementById(tab + "-tab").classList.remove("text-gray-500");
                document.getElementById(tab + "-tab").classList.add("text-green-500");

                now_tab = tab;
              }
            </script>
            
            <div class="" id="all-sm">
              @include('includes.all_table_history')
            </div>
            <div class="hidden" id="status-sm">
              @include('includes.status_history')
            </div>
            <div class="hidden" id="email-sm">
              @include('includes.email_history')
            </div>
            <div class="hidden"  id="phone-sm">
              @include('includes.phone_history')
            </div>
            <div class="hidden"  id="dokumente-sm">
              @include('includes.dokumente')
            </div>
            <div class="hidden"  id="auftrag-sm">
              @include('includes.auftragshistory')
            </div>
          </div>
          <script>
            function readEmail(process_id, date) {
                var elem = document.getElementById('status-view-'+id);
                if(elem == null) {
                  var ifrm = document.createElement("iframe");
                  ifrm.setAttribute("src", "{{url("/")}}/crm/email-modal/"+process_id+"/"+date);
                  ifrm.setAttribute("id", "status-view-"+ id)

                  ifrm.style= "height:100%; background: none; border: 0px; bottom: 0px; float: none; left: 0px; margin: 0px; padding: 0px; position: absolute; right: 0px; width: 100%;";
                  document.body.appendChild(ifrm);
                } else {
                  console.log("awd");
                 document.getElementById('status-vieww-'+id).classList.remove("hidden");
                }
            }
          </script>
          <br>
          <script>
           window.addEventListener("message", (event) => {
              console.log("Wdawdaw");

              
            }, false);
            function readStatus(status, id) {
                var elem = document.getElementById('status-view-'+id);
                if(elem == null) {
                  var ifrm = document.createElement("iframe");
                  ifrm.setAttribute("src", "{{url("/")}}/crm/email-modal/"+status+"/"+id);
                  ifrm.setAttribute("id", "status-view-"+ id)

                  ifrm.style= "height:100%; background: none; border: 0px; bottom: 0px; float: none; left: 0px; margin: 0px; padding: 0px; position: absolute; right: 0px; width: 100%;";
                  document.body.appendChild(ifrm);
                } else {
                  console.log("awd");
                 document.getElementById('status-vieww-'+id).classList.remove("hidden");
                }
            }
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mt-5 m-auto hidden"  id="auftragshistory" style="width: 93%; margin-top: -2.78rem">
  <div class="bg-white px-8 py-8 shadow sm:rounded-lg sm:p-6 mt-6 pr-60 w-full">
    <form action="/crm/to/packtisch/{{$person->process_id}}" method="post" enctype="multipart/form-data">
      @CSRF
    <div class="px-4 sm:px-6 lg:px-8 mb-8">
      <div class="px-4 sm:px-6 lg:px-8 mb-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-normal text-gray-900">Packtisch</h1>
          </div>
        </div>
       
      <div class="mt-4">
        <label for="location" class="block text-sm font-medium text-gray-700">Aktion</label>
        <select onchange="changeAuftrag()" name="auftrag" id="auftrag" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
          @isset($contactt)
          <option value="Neuer Versandauftrag - Techniker" selected>Neuer Versandauftrag - Techniker</option>
              @else
              <option value="Neuer Versandauftrag - Techniker">Neuer Versandauftrag - Techniker</option>
              <option selected>Bitte wählen</option>
          @endisset
          <option value="Fotoauftrag">neuer Fotoauftrag</option>
          <option value="Umlagerungsauftrag">neuer Umlagerungsauftrag</option>
          <option value="Neuer Versandauftrag - Kunde">Neuer Versandauftrag - Kunde</option>
        </select>
      </div>
      <hr class="mt-5 mb-5">
      <div id="fotoauftrag" class="hidden" class="">
        <fieldset class="space-y-5">
          <legend class="sr-only">Notifications</legend>
        @isset($devices)
                    @php
                    $counter = 0;
                  @endphp
                  @foreach ($devices as $device)
                  <input type="hidden" name="order_id" value="{{$device->process_id}}">
                  
                    <div class="relative flex items-start">
                      <div class="flex h-5 items-center">
                        <input id="comments" aria-describedby="comments-description" name="fcompo-{{$counter}}" value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                      </div>
                      <div class="ml-3 text-sm">
                        <label for="comments" class="font-medium text-gray-700">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</label>
                        <span id="comments-description" class="text-gray-500"><span class="sr-only">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</span>
                      </div>
                    </div>
                  @php
                    $counter++;
                  @endphp
                  @endforeach
                  @endisset
            @isset($helpercodes)
            @php
            $counter = 0;
            @endphp
            @foreach ($helpercodes as $helpercode)
            <input type="hidden" name="order_id" value="{{$helpercode->helper_code}}">
            <div class="row mb-4">
              <label class="col-sm-5 col-form-label">
                {{$helpercode->helper_code}}
              </label>
              <div class="col-sm-2 text-right">
                <label>
                  <input type="checkbox" name="helpercode-{{$counter}}" value="{{$helpercode->helper_code}}">
                  Ja
                </label>
              </div>
              <div class="col-sm-5">
              </div>
            </div>
            @php
              $counter++;
            @endphp
            @endforeach
            @endisset
          </fieldset>
          <div class="mt-8">
            <label for="comment" class="block text-sm font-medium text-gray-700">Wichtige Information an den Packtisch</label>
            <div class="mt-1">
              <textarea rows="4" name="infofoto" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
          </div>

      </div>
      <div id="umlagerungsauftrag" class="hidden">
        <div class="px-4 sm:px-6 lg:px-8">
         
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-96 py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-96 divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Gerät</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Lagerplatz</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Zielplatz</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      @isset($devices)
                    @php
                    $counter = 0;
                  @endphp
                  @foreach ($devices as $device)
                  <tr class="text-center">
                    <td>{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</td>
                    @foreach ($shelfes as $shelfe)
                    @if ($shelfe->component_number == $device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count)
                    <td>{{$shelfe->shelfe_id}}</td>
                    @endif
                    @endforeach
                    <td><select name="compo-{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" id="">
                      <option selected value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}} (Aktueller Platz)</option>
                      @foreach ($shelfes as $shelfe)
                        @if ($shelfe->process_id == "0")
                          <option value="{{$shelfe->shelfe_id}}+{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}">{{$shelfe->shelfe_id}} (0 von 1)</option>
                        @endif
                      @endforeach
                      <option value="archiv+{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}">Ins Archiv</option>
                    </select></td>
                  </tr>
                  @php
                    $counter++;
                  @endphp
                  @endforeach
                  @endisset
        
                      <!-- More people... -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="versandkunde" class="hidden">
        <h1 id="outcountry" class="hidden text-xl text-red-600 font-bold">Drittland Sendungen “Achtung Internationale Sendung, Kundenrechnung muss 2-Fach an das Paket von außen geklebt werden</h1>
        <script>
          var countries = ["Belgien",
        "Bulgarien",
        "Dänemark",
        "Deutschland",
        "Estland",
        "Finnland",
        "Frankreich",
        "Griechenland",
        "Irland",
        "Italien",
        "Kroatien",
        "Lettland",
        "Litauen",
        "Luxemburg",
        "Malta",
        "Niederlande",
        "Österreich",
        "Polen",
        "Portugal",
        "Rumänien",
        "Schweden",
        "Slowakei",
        "Slowenien",
        "Spanien",
        "Tschechien",
        "Ungarn",
        "Vereinigtes Königreich",
        "Zypern"];

          if(!countries.includes("{{$person->send_back_country}}" || !countries.includes("{{$person->home_country}}"))) {
            document.getElementById("outcountry").classList.remove("hidden");
          }

        </script>
        <div class="px-4 sm:px-6 lg:px-8">
         
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-96 py-2 align-middle md:px-6 lg:px-8">
                @isset($devices)
                    @php
                    $counter = 0;
                  @endphp
                  @foreach ($devices as $device)
                  @isset($inshipping)
                  @if ($inshipping != "[]")
                      
                  
                      @foreach ($inshipping as $shipping)
                        @if ($shipping->component_number != $device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count)
                          <div class="mt-5"><input type="hidden" name="order_id" value="{{$device->process_id}}">
                          
                            <div class="relative flex items-start">
                              <div class="flex h-5 items-center">
                                <input id="comments" aria-describedby="comments-description" name="kcompon-{{$counter}}" value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              </div>
                              <div class="ml-3 text-sm">
                                <label for="comments" class="font-medium text-gray-700">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</label>
                                <span id="comments-description" class="text-gray-500"><span class="sr-only">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</span>
                              </div>
                            </div></div>
                            @endif
                            @endforeach
                            @else
                            <div class="mt-5"><input type="hidden" name="order_id" value="{{$device->process_id}}">
                          
                              <div class="relative flex items-start">
                                <div class="flex h-5 items-center">
                                  <input id="comments" aria-describedby="comments-description" name="kcompon-{{$counter}}" value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                  <label for="comments" class="font-medium text-gray-700">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</label>
                                  <span id="comments-description" class="text-gray-500"><span class="sr-only">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</span>
                                </div>
                              </div></div>
                              @endif
                              @endisset
                  @php
                    $counter++;
                  @endphp
                  @endforeach
                  @endisset
                  <div class="float-left mr-96">
                    <div class="mt-5 float-left">
                      <label for="comment" class="block text-sm font-medium text-gray-700">Wichtige Information an den Packtisch</label>
                      <div class="mt-1">
                        <textarea rows="4" name="kinfo" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="float-right w-3/5 ml-96" style="margin-top: -5rem">
                    <div class="grid grid-cols-6 gap-2 float-right w-full">
                      <div class="col-span-4 sm:col-span-4">
                          <h3>Rechnungsinformationen</h3>
                      </div>
                    @isset($person->send_back_street)
                    <div class="col-span-4 sm:col-span-4">
                      <input type="hidden" name="employee" id="" value="{{session()->get("username")}}">
                      <input type="hidden" name="pricemwst" value="19">
                        <label for="first-name" class="block text-sm font-normal text-gray-700">Firma</label>
                        <input type="text" name="kcompanyname" value="{{$person->send_back_company_name}}" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                      </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="location" class="block text-sm font-normal text-gray-700">Anrede</label>
                        <select id="location" name="kgender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          @if ($person->send_back_gender == "0")
                          <option selected value="Herr">Herr</option>
                          @else
                          <option value="Herr">Herr</option>
                          @endif
                          @if ($person->send_back_gender == "1")
                          <option selected value="Frau">Frau</option>
                          @else
                          <option value="Frau">Frau</option>
                          @endif
                        </select>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                      <label for="first-name" class="block text-sm font-normal text-gray-700">Vorname</label>
                      <input type="text" value="{{$person->send_back_firstname}}" name="kfirstname" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3">
                      <label for="last-name" class="block text-sm font-normal text-gray-700">Nachname</label>
                      <input type="text" name="klastname" value="{{$person->send_back_lastname}}" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-4">
                      <label for="email-address" class="block text-sm font-normal text-gray-700">Straße</label>
                      <input type="text" name="kstreet" value="{{$person->send_back_street}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Straßennummer</label>
                        <input type="text" name="kstreetno" value="{{$person->send_back_street_number}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Postleitzahl</label>
                        <input type="text" name="kzipcode" id="email-address" value="{{$person->send_back_zipcode}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Stadt</label>
                        <input type="text" name="kcity" id="email-address" value="{{$person->send_back_city}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-2">
                      <label for="country" class="block text-sm font-normal text-gray-700">Land</label>
                      <select id="country" name="kcountry" value="{{$person->send_back_country}}" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @isset($person->send_back_country)
                          <option value="{{$countries->where('name', $person->send_back_country)->first()->name}}">{{$countries->where('name', $person->send_back_country)->first()->name}}</option>
                        @endisset
                        <option value="" class="font-bold">Häufigste Länder</option>
                        @isset($person->send_back_country)
                        @if ($person->send_back_country != "Deutschland")
                        <option value="Deutschland">Deutschland</option>
                        @endif
                        @endisset

                        @php
                            $mostUsedCountries = array("Deutschland");
                        @endphp
                        @foreach ($countries->sortBy('name') as $country)
                          @if (in_array($country->name, $mostUsedCountries))
                          @if ($country->name != $person->send_back_country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif
                          @endif
                        @endforeach
                        <option value="" class="font-bold">Andere Länder</option>
                        @foreach ($countries->sortBy('name') as $country)
                          @if (!in_array($country->name, $mostUsedCountries))
                              <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
          
          
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                      <label for="city" class="block text-sm font-normal text-gray-700">Email</label>
                      <input type="text" name="kemail" id="city" value="{{$person->email}}" autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                      <label for="region" class="block text-sm font-normal text-gray-700">Mobil</label>
                      <input type="text" name="kmobilnumber" id="region" value="{{$person->mobile_number}}" autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                      <label for="postal-code" class="block text-sm font-normal text-gray-700">Festnetz</label>
                      <input type="text" name="kphonenumber" id="postal-code" value="{{$person->phone_number}}" autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                        @else
                        <div class="col-span-4 sm:col-span-4">
                          <input type="hidden" name="employee" id="" value="{{session()->get("username")}}">
                          <input type="hidden" name="pricemwst" value="19">
                            <label for="first-name" class="block text-sm font-normal text-gray-700">Firma</label>
                            <input type="text" name="kcompanyname" value="{{$person->company_name}}" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                          </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="location" class="block text-sm font-normal text-gray-700">Anrede</label>
                            <select id="location" name="kgender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                              @if ($person->gender == "0")
                              <option selected value="Herr">Herr</option>
                              @else
                              <option value="Herr">Herr</option>
                              @endif
                              @if ($person->gender == "1")
                              <option selected value="Frau">Frau</option>
                              @else
                              <option value="Frau">Frau</option>
                              @endif
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                          <label for="first-name" class="block text-sm font-normal text-gray-700">Vorname</label>
                          <input type="text" value="{{$person->firstname}}" name="kfirstname" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
              
                        <div class="col-span-6 sm:col-span-3">
                          <label for="last-name" class="block text-sm font-normal text-gray-700">Nachname</label>
                          <input type="text" name="klastname" value="{{$person->lastname}}" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
              
                        <div class="col-span-6 sm:col-span-4">
                          <label for="email-address" class="block text-sm font-normal text-gray-700">Straße</label>
                          <input type="text" name="kstreet" value="{{$person->home_street}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="email-address" class="block text-sm font-normal text-gray-700">Straßennummer</label>
                            <input type="text" name="kstreetno" value="{{$person->home_street_number}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="email-address" class="block text-sm font-normal text-gray-700">Postleitzahl</label>
                            <input type="text" name="kzipcode" id="email-address" value="{{$person->home_zipcode}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="email-address" class="block text-sm font-normal text-gray-700">Stadt</label>
                            <input type="text" name="kcity" id="email-address" value="{{$person->home_city}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
              
                        <div class="col-span-6 sm:col-span-2">
                          <label for="country" class="block text-sm font-normal text-gray-700">Land</label>
                          <select id="country" name="kcountry" value="{{$person->home_country}}" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            @isset($person->home_country)
                          <option value="{{$countries->where('name', $person->home_country)->first()->name}}">{{$countries->where('name', $person->home_country)->first()->name}}</option>
                        @endisset
                        <option value="" class="font-bold">Häufigste Länder</option>
                        @isset($person->home_country)
                        @if ($person->home_country != "Deutschland")
                        <option value="Deutschland">Deutschland</option>
                        @endif
                        @endisset
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
                          @if ($country->name != $person->home_country)
                          <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif                          @endif
                        @endforeach
                        <option value="" class="font-bold">Andere Länder</option>
                        @foreach ($countries->sortBy('name') as $country)
                          @if (!in_array($country->name, $mostUsedCountries))
                              <option value="{{$country->name}}">{{$country->name}}</option>
                          @endif
                        @endforeach
                          </select>
                        </div>
              
                       
                        

                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                          <label for="city" class="block text-sm font-normal text-gray-700">Email</label>
                          <input type="text" name="kemail" id="city" value="{{$person->email}}" autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
              
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                          <label for="region" class="block text-sm font-normal text-gray-700">Mobil</label>
                          <input type="text" name="kmobilnumber" id="region" value="{{$person->mobile_number}}" autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
              
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                          <label for="postal-code" class="block text-sm font-normal text-gray-700">Festnetz</label>
                          <input type="text" name="kphonenumber" id="postal-code" value="{{$person->phone_number}}" autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    @endisset
                    <div class="col-span-6 sm:col-span-2">
                      <label for="country" class="block text-sm font-normal text-gray-700">BPZ 1</label>
                      <select id="country" name="file1" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @isset($bpzs)
                        <option selected value="{{$bpzs->Datei_1}}">{{$bpzs->Datei_1}}</option>
                        @else 
                        <option value="0">Bitte auswählen</option>
                        @endisset
                        <option value="BPZ Sonstige">BPZ Sonstige</option>
                        <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                        <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                        <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                        <option value="BPZ Prüfung">BPZ Prüfung</option>
                        <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                        <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                        <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                        <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                        <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                        <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                        <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                        <option value="BPZ BSI">BPZ BSI</option>
                        <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                        <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                        <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                        <option value="ALL Hinweis">ALL Hinweis</option>
                      </select>
                    </div>
                    <input type="text" hidden value="Kunde" name="ktype">

                    <div class="col-span-6 sm:col-span-2">
                      <label for="country" class="block text-sm font-normal text-gray-700">BPZ 2</label>
                      <select id="country" name="file2" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @isset($bpzs)
                        <option selected value="{{$bpzs->Datei_2}}">{{$bpzs->Datei_2}}</option> 
                        @else
                        <option value="0">Bitte auswählen</option>
                        @endisset
                        <option value="BPZ Sonstige">BPZ Sonstige</option>
                        <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                        <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                        <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                        <option value="BPZ Prüfung">BPZ Prüfung</option>
                        <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                        <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                        <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                        <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                        <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                        <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                        <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                        <option value="BPZ BSI">BPZ BSI</option>
                        <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                        <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                        <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                        <option value="ALL Hinweis">ALL Hinweis</option>
                      </select>
                    </div>
                    <br>
                    <br>
                    <div class="col-span-6 sm:col-span-2">
                      <fieldset class="space-y-5">
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            <input id="candidates" aria-describedby="candidates-description" name="nachnahme" @if($person->payment_type == "nachnahme") checked @endif type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="candidates" class="font-medium text-gray-700">Nachnahme</label>
                          </div>
                        </div>                      
                      </fieldset>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                      <fieldset class="space-y-5">
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            <input id="candidates" aria-describedby="candidates-description" name="spannungsschutz" type="checkbox" class=" h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          </div>
                          <div class="ml-3 text-sm ">
                            <label for="candidates" class="font-medium text-gray-700">Überspannungsschutz</label>
                          </div>
                        </div>                      
                      </fieldset>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                      <fieldset class="space-y-5">
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            <input id="candidates" aria-describedby="candidates-description" name="gummi" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="candidates" class="font-medium text-gray-700">Gummibärchen</label>
                          </div>
                        </div>                      
                      </fieldset>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                      <fieldset class="space-y-5">
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            <input id="candidates" aria-describedby="candidates-description" name="fotoauftrag" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="candidates" class="font-medium text-gray-700">Fotoauftrag</label>
                          </div>
                        </div>                      
                      </fieldset>
                    </div>
                    
                    <div class="col-span-6 sm:col-span-2">
                      <fieldset class="space-y-5">
                        <div class="relative flex items-start">
                          <div class="flex h-5 items-center">
                            @isset($bpzs)
                            @if ($bpzs->seal == "0")
                            <input id="candidates" aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            @else
                            <input id="candidates" checked aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            @endif
                            @else
                            <input id="candidates" aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        @endisset
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="candidates" class="font-medium text-gray-700">Versiegeln</label>
                          </div>
                        </div>                      
                      </fieldset>
                     
                    </div>
                    
                    <div class="col-span-6 sm:col-span-2 mt-10 ml-16">
                      <input type="file" name="shipping-file" style="width: 18.5rem;" class="rounded-xl inline-flex items-center px-4 py-2 bg-gray-600 border border-gray-600 rounded-l font-semibold cursor-pointer text-sm text-white tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" >
                      
                    </div>
                    </div>
                   
                   
                    <select id="user_packing_carriers_service" hidden name="carriers_service" class="custom-select">
											<option value="11">UPS Standard - 0,00 €</option>
											<option value="65" selected>UPS Saver - 0,00 €</option>
										</select>
                    <label id="amount_label_user" class="col-sm-2 col-form-label" style="display: none" for="amount">Betrag</label>
									    <div id="amount_amount_user" class="col-sm-4" style="display: none">
									    	<div class="input-group">
									    		<input type="text" id="amount_amount_user" name="amount" value="0,00" class="form-control">
									    		<span class="input-group-append">
									    			<span class="input-group-text">€</span>
									    		</span>
									    	</div>
									    </div>
                      
                      <input type="text" name="process_id" value="{{$person->process_id}}" id="" hidden>
                      <div class="form-group row" hidden>
                        <label class="col-sm-4 col-form-label">Maße / Gewicht</label>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_length" name="length" step="1" value="30" class="form-control" placeholder="Länge" data-toggle="tooltip" data-placement="top" title="" data-original-title="Länge">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_width" name="width" step="1" value="20" class="form-control" placeholder="Breite" data-toggle="tooltip" data-placement="top" title="" data-original-title="Breite">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_height" name="height" step="1" value="10" class="form-control" placeholder="Höhe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Höhe">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_weight" name="weight" step="0.1" value="5.0" class="form-control" placeholder="Gewicht" data-toggle="tooltip" data-placement="top" title="" data-original-title="Gewicht">
                        </div>
                      </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="versandtechniker" class="@isset($contactt) @else hidden @endisset">
        <div class="px-4 sm:px-6 lg:px-8">
         
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-96 py-2 align-middle md:px-6 lg:px-8">
                @isset($devices)
                    @php
                    $counter = 0;
                  @endphp
                  @foreach ($devices as $device)
                    @isset($inshipping)
                    @if ($inshipping != "[]")
                        
                    
                        @foreach ($inshipping as $shipping)
                          @if ($shipping->component_number != $device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count)
                          <div class="mt-5"><input type="hidden" name="order_id" value="{{$device->process_id}}">
                          
                            <div class="relative flex items-start">
                              <div class="flex h-5 items-center">
                                <input id="comments" aria-describedby="comments-description" name="compon-{{$counter}}" value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              </div>
                              <div class="ml-3 text-sm">
                                <label for="comments" class="font-medium text-gray-700">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</label>
                                <span id="comments-description" class="text-gray-500"><span class="sr-only">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</span>
                              </div>
                            </div></div>
                          @endif
                    @endforeach
                    @else
                    <div class="mt-5"><input type="hidden" name="order_id" value="{{$device->process_id}}">
                          
                      <div class="relative flex items-start">
                        <div class="flex h-5 items-center">
                          <input id="comments" aria-describedby="comments-description" name="compon-{{$counter}}" value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </div>
                        <div class="ml-3 text-sm">
                          <label for="comments" class="font-medium text-gray-700">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</label>
                          <span id="comments-description" class="text-gray-500"><span class="sr-only">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</span>
                        </div>
                      </div></div>
                    @endif
                  @endisset
                    
                  
                  @php
                    $counter++;
                  @endphp
                  @endforeach
                  @endisset
                  <div>
                    <div class="mt-5">
                      <label for="comment" class="block text-sm font-medium text-gray-700">Wichtige Information an den Packtisch</label>
                      <div class="mt-1">
                        <textarea rows="4" name="info" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="float-left mr-96">
                    <label for="location" class="block text-sm font-medium text-gray-700">Techniker</label>
                    <script>
                      function changeContact() {
                        window.location.href = "{{url('/')}}/crm/change/order/{{$person->process_id}}/auftragshistory/"+document.getElementById('contactselect').value;
                      }
                    </script>
                    <select id="contactselect" onchange="changeContact()" name="location" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @isset($contactt)
                     
                        <option value="{{$contactt->id}}" selected>{{$contactt->shortcut}}</option>
                        @foreach ($techniker as $tech)
                        <option value="{{$tech->id}}">{{$tech->shortcut}}</option>
                    @endforeach
                          @else
                          @foreach ($techniker as $tech)
                          <option value="{{$tech->id}}">{{$tech->shortcut}}</option>
                      @endforeach
                      @endisset
                    
                    </select>
                  </div>
                  @isset($contactt)
                  <div class="float-right w-3/5" style="margin-top: -12rem">
                    <div class="grid grid-cols-6 gap-2 float-right">
                      <div class="col-span-4 sm:col-span-4">
                          <h3>Rechnungsinformationen</h3>
                      </div>
                    <div class="col-span-4 sm:col-span-4">
                      <input type="hidden" name="employee" id="" value="{{session()->get("username")}}">
                      <input type="hidden" name="pricemwst" value="19">
                        <label for="first-name" class="block text-sm font-normal text-gray-700">Firma</label>
                        <input type="text" name="companyname" value="{{$contactt->companyname}}" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                      </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="location" class="block text-sm font-normal text-gray-700">Anrede</label>
                        <select id="location" name="gender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          @if ($contactt->gender == "0")
                          <option selected value="Herr">Herr</option>
                          @else
                          <option value="Herr">Herr</option>
                          @endif
                          @if ($contactt->gender == "1")
                          <option selected value="Frau">Frau</option>
                          @else
                          <option value="Frau">Frau</option>
                          @endif
                        </select>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                      <label for="first-name" class="block text-sm font-normal text-gray-700">Vorname</label>
                      <input type="text" value="{{$contactt->firstname}}" name="firstname" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3">
                      <label for="last-name" class="block text-sm font-normal text-gray-700">Nachname</label>
                      <input type="text" name="lastname" value="{{$contactt->lastname}}" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-4">
                      <label for="email-address" class="block text-sm font-normal text-gray-700">Straße</label>
                      <input type="text" name="street" value="{{$contactt->street}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Straßennummer</label>
                        <input type="text" name="streetno" value="{{$contactt->streetno}}" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Postleitzahl</label>
                        <input type="text" name="zipcode" id="email-address" value="{{$contactt->zipcode}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-normal text-gray-700">Stadt</label>
                        <input type="text" name="city" id="email-address" value="{{$contactt->city}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-2">
                      <label for="country" class="block text-sm font-normal text-gray-700">Land</label>
                      <select id="country" name="country" value="{{$contactt->country}}" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @isset($contactt->country)
                          @foreach ($countries as $country)
                          @if ($country->id == $contactt->country)
                              <option selected value="{{$country->id}}">{{$country->name}}</option>
                          @endif
                          @endforeach
                        @endisset
                       
                        

                      
                      <option value="" class="font-bold">Häufigste Länder</option>
                      @isset($contactt->country)
                      @if ($contactt->country != "Deutschland")
                      <option value="Deutschland">Deutschland</option>
                      @endif
                      @endisset
                      @php
                          $mostUsedCountries = array("Deutschland");
                      @endphp
                      @foreach ($countries->sortBy('name') as $country)
                        @if (in_array($country->name, $mostUsedCountries))
                            @isset($contactt)
                            @if ($country->id != $contactt->country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                            @endif
                                @else
                            <option value="{{$country->name}}">{{$country->name}}</option>
                            
                            @endisset
                        @endif
                      @endforeach
                      <option value="" class="font-bold">Andere Länder</option>
                      @foreach ($countries->sortBy('name') as $country)
                        @if (!in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endif
                      @endforeach
                      </select>
                    </div>
          
          
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                      <label for="city" class="block text-sm font-normal text-gray-700">Email</label>
                      <input type="email" name="email" id="email" value="{{$contactt->email}}" autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                      <label for="region" class="block text-sm font-normal text-gray-700">Mobil</label>
                      <input type="text" name="mobilnumber" id="region" value="{{$contactt->mobilnumber}}" autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
          
                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                      <label for="postal-code" class="block text-sm font-normal text-gray-700">Festnetz</label>
                      <input type="text" name="phonenumber" id="postal-code" value="{{$contactt->phonenumber}}" autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <select id="user_packing_carriers_service" hidden name="carriers_service" class="custom-select">
											<option value="11">UPS Standard - 0,00 €</option>
											<option value="65" selected>UPS Saver - 0,00 €</option>
										</select>
                    <label id="amount_label_user" class="col-sm-2 col-form-label" style="display: none" for="amount">Betrag</label>
									    <div id="amount_amount_user" class="col-sm-4" style="display: none">
									    	<div class="input-group">
									    		<input type="text" id="amount_amount_user" name="amount" value="0,00" class="form-control">
									    		<span class="input-group-append">
									    			<span class="input-group-text">€</span>
									    		</span>
									    	</div>
									    </div>
                      <div class="col-span-6 sm:col-span-2">
                        <label for="country" class="block text-sm font-normal text-gray-700">BPZ 1</label>
                        <select id="country" name="kfile1" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          @isset($bpzs)
                          <option selected value="{{$bpzs->Datei_1}}">{{$bpzs->Datei_1}}</option>
                          @else 
                          <option value="0">Bitte auswählen</option>
                          @endisset
                          <option value="BPZ Sonstige">BPZ Sonstige</option>
                          <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                          <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                          <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                          <option value="BPZ Prüfung">BPZ Prüfung</option>
                          <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                          <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                          <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                          <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                          <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                          <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                          <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                          <option value="BPZ BSI">BPZ BSI</option>
                          <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                          <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                          <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                          <option value="ALL Hinweis">ALL Hinweis</option>
                        </select>
                      </div>
                      <input type="text" hidden value="Techniker" name="type">


                      <div class="col-span-6 sm:col-span-2">
                        <label for="country" class="block text-sm font-normal text-gray-700">BPZ 2</label>
                        <select id="country" name="kfile2" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          @isset($bpzs)
                          <option selected value="{{$bpzs->Datei_2}}">{{$bpzs->Datei_2}}</option> 
                          @else
                          <option value="0">Bitte auswählen</option>
                          @endisset
                          <option value="BPZ Sonstige">BPZ Sonstige</option>
                          <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                          <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                          <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                          <option value="BPZ Prüfung">BPZ Prüfung</option>
                          <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                          <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                          <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                          <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                          <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                          <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                          <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                          <option value="BPZ BSI">BPZ BSI</option>
                          <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                          <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                          <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                          <option value="ALL Hinweis">ALL Hinweis</option>
                        </select>
                      </div>
                      <br>
                      <br>
                      <div class="col-span-6 sm:col-span-2">
                        <fieldset class="space-y-5">
                          <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                              <input id="candidates" aria-describedby="candidates-description" name="spannungsschutz" type="checkbox" class=" h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="ml-3 text-sm ">
                              <label for="candidates" class="font-medium text-gray-700">Überspannungsschutz</label>
                            </div>
                          </div>                      
                        </fieldset>
                      </div>
                      <div class="col-span-6 sm:col-span-2">
                        <fieldset class="space-y-5">
                          <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                              <input id="candidates" aria-describedby="candidates-description" name="gummi" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="candidates" class="font-medium text-gray-700">Gummibärchen</label>
                            </div>
                          </div>                      
                        </fieldset>
                      </div>
                      
                      <div class="col-span-6 sm:col-span-2">
                        <fieldset class="space-y-5">
                          <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                              @isset($bpzs)
                              @if ($bpzs->seal == "0")
                              <input id="candidates" aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              @else
                              <input id="candidates" checked aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              @endif
                              @else
                              <input id="candidates" aria-describedby="candidates-description" name="vp_si" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                          @endisset
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="candidates" class="font-medium text-gray-700">Versiegeln</label>
                            </div>
                          </div>                      
                        </fieldset>
                       
                      </div>
                      <div class="col-span-6 sm:col-span-2 mt-5">
                        <input type="file" name="kshipping-file" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-gray-600 rounded-l font-semibold cursor-pointer text-sm text-white tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" >
                        
                      </div>

                      <input type="text" name="process_id" value="{{$person->process_id}}" id="" hidden>
                      <div class="form-group row" hidden>
                        <label class="col-sm-4 col-form-label">Maße / Gewicht</label>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_length" name="length" step="1" value="30" class="form-control" placeholder="Länge" data-toggle="tooltip" data-placement="top" title="" data-original-title="Länge">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_width" name="width" step="1" value="20" class="form-control" placeholder="Breite" data-toggle="tooltip" data-placement="top" title="" data-original-title="Breite">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_height" name="height" step="1" value="10" class="form-control" placeholder="Höhe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Höhe">
                        </div>
                        <div class="col-sm-2">
                          <input type="number" id="user_packing_weight" name="weight" step="0.1" value="5.0" class="form-control" placeholder="Gewicht" data-toggle="tooltip" data-placement="top" title="" data-original-title="Gewicht">
                        </div>
                      </div>
                  </div>
                  </div>
                  @endisset
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" class="mt-8 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <!-- Heroicon name: mini/envelope -->
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
          <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
        </svg>
        Absenden
      </button>
      <br>
      <br>
      <br>
      <br>
      </div>
    </div>
    <br>
    
  </form>
  </div>

<div class="mt-5 m-auto hidden"  id="intern" style="width: 93%; margin-top: -2.78rem">
  <form action="{{url("/")}}/crm/intern/add/{{$person->process_id}}" method="POST" enctype="multipart/form-data">
    @CSRF
  <div class="bg-white px-0 py-0 shadow sm:rounded-lg sm:p-6 mt-6  w-full">
    <div class="px-0 sm:px-6 lg:px-8 mb-8">
      <div class="px-0 sm:px-6 lg:px-8 mb-8">
        
       
        <div class="mt-3 flex flex-col">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 center">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              
              <div class="float-left mr-24">
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Vorraussichtliche Bearbeitungsdauer</label>
                  <div class="mt-1">
                    <input type="text" name="intern_time" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="5" @isset($intern) value="{{$intern->prox_time}}" @endisset>
                  </div>
                </div>
                <div class="mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">Ergebnis</label>
                  <select id="location" name="intern_text_module" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @isset($intern)
                        <option value="{{$intern->result}}" selected>{{$intern->result}}</option>
                        @else
                        <option value="0" selected>Bitte Wählen</option>
                    @endisset
                    <option value="Überholung">Überholung</option>
                    <option value="Ablehnung">Ablehnung</option>
                    <option value="Prüfung">Prüfung</option>
                    <option value="Gutschrift">Gutschrift</option>
                    <option value="Austausch">Austausch</option>
                  </select>
                </div>
                <div class="mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">An Telefonhistory</label>
                    @isset($intern)
                    <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_to_history" type="radio" value="0" @isset($intern) @if($intern->to_phonehistory == "0") style="background-color: green" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_to_history" type="radio" value="1" @isset($intern) @if($intern->to_phonehistory == "1") style="background-color: red" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                    @endisset
                    
                </div>
                <div class="mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">Aufnahmeverständniss 1</label>
                  <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_acceptance_agreement_1" type="radio" value="0" @isset($intern) @if($intern->allowness_1 == "0") style="background-color: green" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_acceptance_agreement_1" type="radio" value="1" @isset($intern) @if($intern->allowness_1 == "1") style="background-color: red" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                </div>
                <div class="mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">Mündlicher Vertrag
                  </label>
                 <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_verbal_contract" type="radio" value="0" @isset($intern) @if($intern->verbal_contract == "0")style="background-color: green"  checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_verbal_contract" type="radio" value="1" @isset($intern) @if($intern->verbal_contract == "1") style="background-color: red" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                </div>
                <div class="mt-5">
                  <label for="email" class="block text-sm font-medium text-gray-700">Gesprächspartner</label>
                  <div class="mt-1">
                    <input type="text" name="intern_conversation_partner" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="" @isset($intern->talked_partner) value="{{$intern->talked_partner}}" @endisset>
                  </div>
                </div>
                <div class="mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">Versand nach Zahlungseingang
                  </label>
                 <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_shipping_after_paying" type="radio" value="0" @isset($intern) @if($intern->shipping_after_payment == "0") style="background-color: green" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_shipping_after_paying" type="radio" value="1" @isset($intern) @if($intern->shipping_after_payment == "1") style="background-color: red" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                  <div class="mt-5">
                    <label for="location" class="block text-sm font-medium text-gray-700">Rücknahmebelehrung
                    </label>
                   <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_redemption_instruction" type="radio" value="0" @isset($intern) @if($intern->takeback_insturction == "0") style="background-color: green" checked @endif @endisset  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_redemption_instruction" type="radio" value="1" @isset($intern) @if($intern->takeback_insturction == "1") style="background-color: red" checked @endif @endisset  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="mt-5">
                    <label for="email" class="block text-sm font-medium text-gray-700">Geburtstag</label>
                    <div class="mt-1">
                      <input type="text" name="intern_birthday" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="" @isset($intern->birthday) value="{{$intern->birthday}}" @endisset>
                    </div>
                  </div>
                  <div class="mt-5">
                    <label for="location" class="block text-sm font-medium text-gray-700">Aufnahme Einverständnis 2
                    </label>
                    <div>
                      
                      <fieldset class="mt-4">
                        <legend class="sr-only">Notification method</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                          <div class="flex items-center">
                            <input id="email" name="intern_acceptance_agreement_2" type="radio" value="0" @isset($intern) @if($intern->allowness_2 == "0") style="background-color: green" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                          </div>
                    
                          <div class="flex items-center">
                            <input id="sms" name="intern_acceptance_agreement_2" type="radio" value="1" @isset($intern) @if($intern->allowness_2 == "1") style="background-color: red" checked @endif @endisset class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                          </div>
              
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <button type="submit" class="mt-8 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <!-- Heroicon name: mini/envelope -->
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                      <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                    </svg>
                    Absenden
                  </button>
                </div>
              </div>

              <div class="float-left">
                <div class="mt-5">
                  <label for="comment" class="block text-sm font-medium text-gray-700">Interner Vermerk</label>
                  <div class="mt-1">
                    <textarea rows="4" name="comment" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                  </div>
                </div>
                <div class="mt-5">
                  <label for="comment" class="block text-sm font-medium text-gray-700">Textbaustein</label>
                  <div class="mt-1">
                    <textarea rows="4" name="comment" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                  </div>
                </div>
                <div class="mt-5">
                  <label for="comment" class="block text-sm font-medium text-gray-700">Technikerinfo</label>
                  <div class="mt-1">
                    <textarea rows="4" name="comment" id="comment" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                  </div>
                </div>
                <div class="float-left mr-2 mt-5">
                  <label for="location" class="block text-sm font-medium text-gray-700">Zuteilung</label>
                  <select id="location" name="location" class="mt-1 block w-36 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    <option value="dirk">dirk</option>
										<option value="stelzhamer">stelzhamer</option>
										<option value="konstantinow">konstantinow</option>
										<option value="schanzer">schanzer</option>
										<option value="robert">robert</option>
										<option value="4_steffen">4_steffen</option>
										<option value="2_alex">2_alex</option>
										<option value="sergej">sergej</option>
										<option value="andreas_sbc">andreas_sbc</option>
										<option value="Ecu">Ecu</option>
										<option value="norwig">norwig</option>
										<option value="1_ecu_pl">1_ecu_pl</option>
										<option value="pream">pream</option>
										<option value="rainer_hutterer">rainer_hutterer</option>
										<option value="potschaske">potschaske</option>
										<option value="laatzen">laatzen</option>
										<option value="immo_gorzow">immo_gorzow</option>
										<option value="schuster">schuster</option>
										<option value="motology">motology</option>
										<option value="lichetx">lichetx</option>
										<option value="aer_service">aer_service</option>
										<option value="mbe0035">mbe0035</option>
										<option value="navirepcenter">navirepcenter</option>
										<option value="mmi">mmi</option>
										<option value="Rickim">Rickim</option>
										<option value="mosertronik">mosertronik</option>
										<option value="gland">gland</option>
										<option value="bartosz">bartosz</option>
										<option value="elserwis">elserwis</option>
										<option value="arpadbrandes">arpadbrandes</option>
										<option value="c3">c3</option>
										<option value="ag_wedding">ag_wedding</option>
										<option value="audi_sehnke">audi_sehnke</option>
										<option value="boschgmbh">boschgmbh</option>
										<option value="ecu_tech_uk">ecu_tech_uk</option>
										<option value="ecu_boost">ecu_boost</option>
										<option value="marta">marta</option>
										<option value="actronics">actronics</option>
										<option value="gerner">gerner</option>
										<option value="0_test">0_test</option>
										<option value="ecu spec">ecu spec</option>
										<option value="sender">sender</option>
										<option value="5_at">5_at</option>
										<option value="lischka">lischka</option>
										<option value="blue_me">blue_me</option>
										<option value="2_alex_at">2_alex_at</option>
										<option value="GMT">GMT</option>
										<option value="nowak">nowak</option>
										<option value="andrew">andrew</option>
										<option value="btec_lenkung">btec_lenkung</option>
										<option value="maciej">maciej</option>
										<option value="cojali">cojali</option>
										<option value="gomille">gomille</option>
										<option value="Ilgenfritz">Ilgenfritz</option>
										<option value="tender.pl">tender.pl</option>
										<option value="tacho_concept">tacho_concept</option>
										<option value="schmal">schmal</option>
										<option value="compramas">compramas</option>
										<option value="nordicon">nordicon</option>
										<option value="eps">eps</option>
										<option value="ra_grunow">ra_grunow</option>
										<option value="a_elektro_pl">a_elektro_pl</option>
										<option value="deutz">deutz</option>
										<option value="tolix">tolix</option>
										<option value="darek">darek</option>
										<option value="truckdoctor">truckdoctor</option>
										<option value="diemmax">diemmax</option>
										<option value="ons">ons</option>
										<option value="auto_electron">auto_electron</option>
										<option value="alex_nachbar">alex_nachbar</option>
										<option value="rafael">rafael</option>
										<option value="ics">ics</option>
										<option value="motoconnect">motoconnect</option>
										<option value="Kfz Schmal">Kfz Schmal</option>
										<option value="wolf_navi">wolf_navi</option>
										<option value="dvb">dvb</option>
										<option value="kfzpix">kfzpix</option>
										<option value="endera">endera</option>
										<option value="flashmasters_usa">flashmasters_usa</option>
										<option value="blue_me_dna">blue_me_dna</option>
										<option value="gomille_pl">gomille_pl</option>
										<option value="rezek">rezek</option>
										<option value="eLeven">eLeven</option>
                  </select>
                </div>
                <div class="float-left mt-5">
                  <label for="email" class="block text-sm font-medium text-white">.</label>
                  <div class="mt-1 ml-2">
                    <input type="email" name="email" id="email" class="block w-60 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
                  </div>
                </div>
                <div class=" mt-5">
                  <label for="email" class="block text-sm font-medium text-white">.</label>

                  <button type="button" class="mt-1.5 ml-4 inline-flex items-center rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                  </svg>
                   Speichern</button>

                </div>
              </div>
              </div>
              
          </div>
          
        </div>
      </div>
      
    </div>
  </form>
    <div class="ml-16 mt-16">
      <form action="{{url("/")}}/crm/comparison/{{$person->process_id}}" method="POST">
       @CSRF
       <div class="float-left mr-2">
         <label for="location" class="block text-sm font-medium text-gray-700">Vergleich</label>
         <select id="location" name="text" class="mt-1 block w-36 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
           @foreach ($vergleich as $v)
               <option value="{{$v->id}}">{{$v->title}}</option>
           @endforeach
         </select>
       </div>
       <div class="float-left">
         <label for="email" class="block text-sm font-medium text-white">.</label>
         <div class="mt-1 ml-2">
           <input type="text" name="intern_compare_price" id="email" class="block w-60 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="0,00">
         </div>
       </div>
       <div class="">
         <label for="email" class="block text-sm font-medium text-white">.</label>
    
         <button type="submit" class="mt-1.5 ml-4 inline-flex items-center rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
           <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
         </svg>
          Speichern</button>
    
       </div>
       <hr class="w-96 mt-5">       
     </form> 
     </div>
  </div>




<div class="mt-5 m-auto hidden"  id="einkäufe" style="width: 93%; margin-top: -2.78rem">
  <form action="{{url("/")}}/crm/upload/files/{{$person->process_id}}/dokumente" method="POST" enctype="multipart/form-data">
    @CSRF
  <div class="bg-white px-0 py-0 shadow sm:rounded-lg sm:p-6 mt-6  w-full">
    <div class="px-0 sm:px-6 lg:px-8 mb-8">
      <div class="mb-5">
        <label for="location" class="block text-sm font-medium text-gray-700">Bereich</label>
        <select id="location" name="location" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
          <option>United States</option>
          <option selected>Canada</option>
          <option>Mexico</option>
        </select>
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Lieferant</label>
          <legend class="sr-only">Notification method</legend>
          <div class="space-y-4" style="margin-top: -1.7rem">
            <div class="flex items-center float-left mr-5 mt-3.5">
              <input id="email" name="notification-method" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ebay</label>
            </div>
      
            <div class="flex items-center float-left mr-5">
              <input id="sms" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Allegro</label>
            </div>
  
            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">Websiten</label>
            </div>

            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">Amazon</label>
            </div>
            <div class="flex items-center mr-5">
              <input id="push" name="notification-method" type="radio" class="mt-4 h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700 mt-4">Stoniert</label>
            </div>
          </div>
        </fieldset>
      </div>
      <div class="mt-5">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Lieferant</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Beschreibung</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Angeschrieben</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5 mb-5 ">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Info</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Zahlart</label>
          <legend class="sr-only">Notification method</legend>
          <div class="space-y-4" style="margin-top: -1.7rem">
            <div class="flex items-center float-left mr-5 mt-3.5">
              <input id="email" name="notification-method" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="email" class="ml-3 block text-sm font-medium text-gray-700">PayPal</label>
            </div>
      
            <div class="flex items-center float-left mr-5">
              <input id="sms" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Kreditkarte</label>
            </div>
  
            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">Überweisung</label>
            </div>

            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">Rechnung</label>
            </div>
            <div class="flex items-center mr-5">
              <input id="push" name="notification-method" type="radio" class="mt-4 h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700 mt-4">Storniert</label>
            </div>
          </div>
        </fieldset>
      </div>
      <div class="mt-5 mb-5 ">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Link</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5 mb-5 ">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Lieferant E-Mail</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5 mb-5 ">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Lieferant Telefon</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div class="mt-5 mb-5 ">
        <label for="email" class="block text-sm font-medium text-gray-700 mt-5">Lieferant Fax</label>
        <div class="">
          <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
        </div>
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Zahlart</label>
          <legend class="sr-only">Notification method</legend>
          <div class="space-y-4" style="margin-top: -1.7rem">
            <div class="flex items-center float-left mr-5 mt-3.5">
              <input id="email" name="notification-method" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="email" class="ml-3 block text-sm font-medium text-gray-700">DHL</label>
            </div>
      
            <div class="flex items-center float-left mr-5">
              <input id="sms" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">UPS</label>
            </div>
  
            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">Hermes</label>
            </div>

            <div class="flex items-center float-left mr-5">
              <input id="push" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700">DPD</label>
            </div>
            <div class="flex items-center mr-5">
              <input id="push" name="notification-method" type="radio" class="mt-4 h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
              <label for="push" class="ml-3 block text-sm font-medium text-gray-700 mt-4">TNT</label>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</form>
</div>
 
  </div>
  <div class="mt-5 m-auto hidden"  id="zahlungen" style="width: 93%; margin-top: -2.78rem">
    <form action="{{url("/")}}/crm/new/booking/{{$person->process_id}}" method="POST" enctype="multipart/form-data">
      @CSRF
    <div class="bg-white px-0 py-0 shadow sm:rounded-lg sm:p-6 mt-6  w-full">
      <div class="px-0 sm:px-6 lg:px-8 mb-8">
        <div class="px-0 sm:px-6 lg:px-8 mb-8">
          <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Zweck</label>
            <select id="location" name="intern_radio_purpose" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
              <option value="rechnung">Rechnung</option>
              <option value="differenzrechnung">Differenzrechnung</option>
              <option value="angebot">Angebot</option>
              <option value="gutschrift">Gutschrift</option>
            </select>
          </div>
          <div class="mt-5 float-left mr-16">
            <label for="location" class="block text-sm font-medium text-gray-700">Versand</label>
            <select id="location" name="radio_shipping" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
              <option value="standard">Standart | 5,95€</option>
              <option value="express">Express | 8,95 €</option>
              <option value="international">International | 15,00 €</option>
              <option value="pickup">Abholung 0,00€</option>
            </select>
          </div>
          <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Kostenlos</label>
            <fieldset class="mt-2">
              <legend class="sr-only">Notification method</legend>
              <div class="space-y-4">
                <div class="flex items-center float-left">
                  <input id="email" name="shipping_free" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                </div>
          
                <div class="flex items-center ml-16">
                  <input id="sms" name="shipping_free" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                </div>
  
              </div>
            </fieldset>
          </div>
          <br>
          <div class="mt-5 float-left mr-16">
            <label for="location" class="block text-sm font-medium text-gray-700">Zahlart</label>
            <select id="location" name="radio_payment" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
              <option value="nachnahme">Nachnahme | 8,00€</option>
              <option value="transfer">Überweisung | 0,00€</option>
              <option value="cash">Bar | 0,00€</option>
            </select>
          </div>
          <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Kostenlos</label>
            <fieldset class="mt-2">
              <legend class="sr-only">Notification method</legend>
              <div class="space-y-4">
                <div class="flex items-center float-left">
                  <input id="email" name="payment_free" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Ja</label>
                </div>
          
                <div class="flex items-center ml-16">
                  <input id="sms" name="payment_free" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Nein</label>
                </div>
  
              </div>
            </fieldset>
          </div>
          <br>
          <div class="mt-5 float-left mr-16">
            <label for="account-number" class="block text-sm font-medium text-gray-700">Gesamtsumme</label>
            <div class="relative mt-1 rounded-md shadow-sm">
              <input type="text" oninput="changeNettoBrutto()" name="intern_price_total" id="totalamount" class="block w-96 rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="200">
              
            </div>
          </div>
          <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">BrNt</label>
            <fieldset class="mt-2">
              <legend class="sr-only">Notification method</legend>
              <div class="space-y-4">
                <div class="flex items-center float-left">
                  <input id="nettosel" name="notification-method" onclick="changeNettoBrutto()" type="radio" value="netto" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Netto</label>
                </div>
          
                <div class="flex items-center ml-24">
                  <input id="bruttosel" name="notification-method" onclick="changeNettoBrutto()" type="radio" value="brutto" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Brutto</label>
                </div>
  
              </div>
            </fieldset>
          </div>
  
          <script>
            function changeNettoBrutto() {
              
              var netto   = document.getElementById("nettoamount");
              var brutto   = document.getElementById("bruttoamount");
              var mwst   = document.getElementById("mwstamount");
              var amount  = document.getElementById("totalamount").value;
              if(document.getElementById("nettosel").checked) {
                netto.innerHTML   = amount;
                
                var mwst1    = roundTo(amount/100, 2);
                var mwstamount    = roundTo(mwst1*19, 2);
                mwst.innerHTML  = mwstamount;
  
          
  
                brutto.innerHTML  = parseFloat(amount)+parseFloat(mwstamount);
              }
  
              if(document.getElementById("bruttosel").checked) {
                brutto.innerHTML   = amount;
                var mwst1    = parseFloat(amount) - roundTo(amount/1.19, 2);
                var mwstamount    = roundTo(mwst1, 2);
                mwst.innerHTML  = mwstamount;
  
  
                netto.innerHTML  = roundTo(amount/1.19, 2);
              }
            }
  
            function roundTo(n, digits) {
            var negative = false;
            if (digits === undefined) {
                digits = 0;
            }
            if (n < 0) {
                negative = true;
                n = n * -1;
            }
            var multiplicator = Math.pow(10, digits);
            n = parseFloat((n * multiplicator).toFixed(11));
            n = (Math.round(n) / multiplicator).toFixed(digits);
            if (negative) {
                n = (n * -1).toFixed(digits);
            }
            return n;
  }
          </script>
  
          <br>
          <div>
            <p>Nettobetrag: <span id="nettoamount"></span> €</p>
            <p>MwSt.: <span id="mwstamount"></span> €</p>
            <p>Bruttobetrag: <span id="bruttoamount"></span></p>
          </div>
          <div class="mt-5">
            <label for="email" class="block text-sm font-medium text-gray-700">Offener Betrag</label>
            <div class="mt-1">
              <input type="text" name="email" id="email" class="block w-96 rounded-md border-gray-300  shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="400">
            </div>
          </div>
          <div class="mt-8">
            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
             neue Buchung</button>
            <button type="button" onclick="document.getElementById('booking-history').classList.remove('hidden');" class="ml-5 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
            </svg>
             Buchungen anzeigen</button>
          </div>
        </div>
        
      </div>
    </div>
  </form>
  </div>
</div>
<div id="booking-history" class="hidden">
  @include('forEmployees.modals.bookings')
</div>
</div>
    <br>
    <br>
    <br>
    <br>
    <script>

        function changeAuftrag() {
          var auftrag   = document.getElementById("auftrag").value;
          
          if(auftrag == "Fotoauftrag") {
            document.getElementById("fotoauftrag").classList.remove("hidden");
            document.getElementById("umlagerungsauftrag").classList.add("hidden");
            document.getElementById("versandtechniker").classList.add("hidden");
            document.getElementById("versandkunde").classList.add("hidden");
          }
          if(auftrag == "Umlagerungsauftrag") {
            document.getElementById("fotoauftrag").classList.add("hidden");
            document.getElementById("umlagerungsauftrag").classList.remove("hidden");
            document.getElementById("versandtechniker").classList.add("hidden");
            document.getElementById("versandkunde").classList.add("hidden");
          }
          if(auftrag == "Neuer Versandauftrag - Techniker") {
            document.getElementById("fotoauftrag").classList.add("hidden");
            document.getElementById("umlagerungsauftrag").classList.add("hidden");
            document.getElementById("versandtechniker").classList.remove("hidden");
            document.getElementById("versandkunde").classList.add("hidden");
          }
          if(auftrag == "Neuer Versandauftrag - Kunde") {
            document.getElementById("fotoauftrag").classList.add("hidden");
            document.getElementById("umlagerungsauftrag").classList.add("hidden");
            document.getElementById("versandtechniker").classList.add("hidden");
            document.getElementById("versandkunde").classList.remove("hidden");

          }
        }

        var counter = 0
        function diff_street() {
          var elem        = document.getElementById("different_street_div");
          if(counter == 0) {
            different_street_div.classList.remove("hidden");
            counter = 1;
          } else {
            different_street_div.classList.add("hidden");
            counter = 0;
          }
        }



        var current_tab = "kundendaten";
        
        function changeTab(tab) {
          

               if(current_tab == tab) {
                document.getElementById(tab).classList.remove("hidden");
                document.getElementById(tab + "1").classList.add("text-blue-600");
                document.getElementById(tab + "1").classList.add("border-blue-500");
                document.getElementById(tab + "2").classList.add("text-blue-500");


               } else {
                document.getElementById(tab).classList.remove("hidden");
                document.getElementById(tab + "1").classList.add("text-blue-600");
                document.getElementById(tab + "1").classList.add("border-blue-500");
                document.getElementById(tab + "2").classList.add("text-blue-500");


            document.getElementById(current_tab).classList.add("hidden");
                document.getElementById(current_tab + "1").classList.remove("text-blue-600");
                document.getElementById(current_tab + "2").classList.remove("text-blue-500");
                document.getElementById(current_tab + "1").classList.remove("border-blue-500");
               }

            current_tab = tab;

        }

        function dokumenteDateiText() {
          var doc = document.getElementById("file-upload");
          var docname = doc.value.split(/(\\|\/)/g).pop();
          if(!document.body.contains(document.getElementById("filename"))) {
            
            var parent  = document.getElementById("filenames");
            var file    = document.createElement("p");
            file.setAttribute("id", "filename");
            file.innerHTML = docname;
            file.classList.add("text-xs");
            file.classList.add("text-gray-500");
            parent.appendChild(file);
          } else {
            var file = document.getElementById("filename");
            filename.innerHTML = docname;
          }
        }
      </script>
</body>
</html>