@php
        $currentKundenData = $editKunde->sortByDesc("updated_at")->first();
    @endphp  


<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        
        <div id="bg-red" class="relative transform overflow-hidden rounded-lg @if($currentKundenData->sperre == "true") bg-red-200 @else bg-white @endif px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 90%">
          
          <div>
                <p class="text-md font-bold">Kundennummer K-{{$currentKundenData->kunden_id}}</p>
            </div>
            <div class="float-left " style="width: 45%">
            <div class="mt-4  grid grid-cols-3 pb-4 gap-4">
         
            @isset($test)
            Kundennummer
            @endisset
              
                <div class="relative col-span-3">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Firma</label>
                  <input type="text" value="{{$currentKundenData->company_name}}" name="home_companyname" id="home_companyname" class="block w-full bg-white h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                </div>


                <div >
                  <select id="home_gender" name="gender" class=" block w-full w-11 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                    <option value="">Anrede</option>
                    <option value="Herr" @if($currentKundenData->gender == "Herr") selected @endif>Herr</option>
                    <option value="Frau" @if($currentKundenData->gender == "Frau") selected @endif>Frau</option>
                  </select>
                  <script>
                    document.getElementById('home_gender').value = "{{$currentKundenData->gender}}";
                  </script>
                </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Vorname</label>
                    <input type="text" value="{{$currentKundenData->firstname}}" name="firstname" id="firstname"  class="block h-11 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Name</label>
                    <input type="text" name="lastname" value="{{$currentKundenData->lastname}}" id="lastname" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>



                  <div class="relative col-span-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straße</label>
                    <input type="text" value="{{$currentKundenData->home_street}}" placeholder="Geben Sie eine Adresse ein" name="home_street" id="home_street" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straßennummer</label>
                    <input type="text" value="{{$currentKundenData->home_street_number}}" name="home_street_number" id="home_street_number" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>


                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Postleitzahl</label>
                    <input type="text" value="{{$currentKundenData->home_zipcode}}" name="home_zipcode" id="home_zipcode" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Stadt</label>
                    <input type="text" value="{{$currentKundenData->home_city}}" name="home_city" id="home_city" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                <div class="">
                  <select id="home_country" name="home_country" class=" block w-full rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
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
                            <option value="{{$country->name}}" @if($currentKundenData->home_country == $country->name) selected @endif>{{$country->name}}</option>
                        @endif
                      @endforeach
                      <option value="" class="font-bold">Andere Länder</option>
                      @foreach ($countries->sortBy('name') as $country)
                        @if (!in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}" @if($currentKundenData->home_country == $country->name) selected @endif>{{$country->name}}</option>
                        @endif
                      @endforeach
                  </select>
                </div>


                  <div class="relative">
                    <input type="hidden" name="id" value="{{$currentKundenData->process_id}}">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">E-Mail</label>
                    <input type="text" value="{{$currentKundenData->email}}" name="email" id="home_email" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Mobil</label>
                    <input type="text" value="{{$currentKundenData->mobile_number}}" name="mobil_number" id="mobil_number" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Festnetz</label>
                    <input type="text" value="{{$currentKundenData->phone_number}}" name="phone_number" id="phone_number" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>


                
              

              <script>

                function toggleAbweichendeAddresseDaten() {
                        document.getElementById("alt_adr").classList.toggle("hidden");
                        
                }

                function toggleDatenAbweichendeAddresse(id) {
                   
                    toggleAbweichendeAddresseDaten();
    
                    $.get("{{url('/')}}/crm/kundendaten-lieferaddresse-toggle-"+id, function(data) {
                        
                    });
    
                }
    
            </script>
            </div>


            <div class="flex ">
              <p class=" mt-4 mr-20">Abweichende Lieferaddresse?</p>
            
              <input class="rounded-sm mt-5 " type="checkbox"@if($currentKundenData->toggle_diff_address == "true") checked @endif id="daten-abweichende-lieferaddresse-button" onclick="toggleDatenAbweichendeAddresse('{{$currentKundenData->process_id}}')">
            </div>


              <div id="alt_adr" class=" @if($currentKundenData->toggle_diff_address != "true") hidden @endif w-full mt-10 float-left grid grid-cols-3 gap-4">

              
                  <div class="relative col-span-3">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Firma</label>
                    <input type="text" value="{{$currentKundenData->send_back_company_name}}" name="send_back_company_name" id="send_back_company_name" class="block w-full bg-white h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>


                    <div class="">
                      <select id="send_back_gender" name="send_back_gender" class=" block w-full w-11 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                        <option value="">Anrede</option>
                        <option value="Herr" @if($currentKundenData->send_back_gender == "Herr") selected @endif>Herr</option>
                        <option value="Frau" @if($currentKundenData->send_back_gender == "Frau") selected @endif>Frau</option>
                      </select>
                      <script>
                        document.getElementById("send_back_gender").value = "{{$currentKundenData->send_back_gender}}";
                      </script>
                    </div>
                      <div class="relative">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Vorname</label>
                        <input type="text" value="{{$currentKundenData->send_back_firstname}}" name="send_back_firstname" id="firstname"  class="block h-11 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                      </div>
                      <div class="relative">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Name</label>
                        <input type="text" value="{{$currentKundenData->send_back_lastname}}" name="send_back_lastname" id="lastname" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>


                      <div class="relative col-span-2">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straße</label>
                        <input type="text" value="{{$currentKundenData->send_back_street}}" placeholder="Geben Sie eine Adresse ein" name="send_back_street" id="send_back_street" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                      </div>
                      <div class="relative">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straßennummer</label>
                        <input type="text" value="{{$currentKundenData->send_back_street_number}}" name="send_back_street_number" id="send_back_street_number" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                      </div>


                      <div class="relative">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Postleitzahl</label>
                        <input type="text" value="{{$currentKundenData->send_back_zipcode}}" name="send_back_zipcode" id="send_back_zipcode" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                      </div>
                      <div class="relative">
                        <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Stadt</label>
                        <input type="text" value="{{$currentKundenData->send_back_city}}" name="send_back_city" id="send_back_city" class="block w-full h-11 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                      </div>
                    <div >
                      <select id="send_back_country" name="send_back_country" class=" block w-full rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
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
                      </select>
                      <script>
                        document.getElementById("send_back_country").value = "{{$currentKundenData->send_back_country}}";
                      </script>
                    </div>

              </div> 
            </div>

          <script>

            google.maps.event.addDomListener(window, 'load', initialize);
          
              function initialize() {
          
                var input = document.getElementById('home_street');
                var input2 = document.getElementById('send_back_street');
          
                var autocomplete = new google.maps.places.Autocomplete(input);
                var autocomplete2 = new google.maps.places.Autocomplete(input2);

                autocomplete2.addListener('place_changed', function () {
          
                  var place2 = autocomplete2.getPlace();
                  
                  let types = [];
                  let names = [];
                    
                  place2.address_components.forEach(comp => {
                      types.push(comp.types[0]);
                      names.push(comp["long_name"]);
                  });
                  console.log(types);
                  console.log(names);
                  let counter = 0
                  document.getElementById("send_back_street").value = "";
                  document.getElementById("send_back_street_number").value = "";
                  document.getElementById("send_back_city").value = "";
                  document.getElementById("send_back_zipcode").value = "";
                  document.getElementById("send_back_country").value = "";
                  console.log(types);
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
                document.getElementById("home_street").value = "";
                document.getElementById("home_street_number").value = "";
                document.getElementById("home_city").value = "";
                document.getElementById("home_zipcode").value = "";
                document.getElementById("home_country").value = "";

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
          <div class="float-right -mt-2" style="width: 45%;">
            <div class="w-full flow-root">
                <div class="w-full -mx-4 -my-2 overflow-auto h-96">
                  <div class="w-full inline-block  align-middle">
                    <p class="text-md text-black font-bold pb-2">Aufträge</p>
                    <table class="w-full divide-y divide-gray-300 float-right">
                      <thead>
                        <tr>
                          <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Erstellt</th>
                          <th scope="col" class="px-3  text-left text-sm font-semibold text-gray-900">Auftrag</th>
                          <th scope="col" class="px-3  text-left text-sm font-semibold text-gray-900">Fahrzeug</th>
                          <th scope="col" class="px-3  text-left text-sm font-semibold text-gray-900">Letzter Status</th>
                          <th scope="col" class=" font-semibold text-right pl-3 sm:pr-0">
                            Aktion
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200">
                        @foreach ($editKunde as $kunde)
                        <tr>
                          <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$kunde->created_at->format('d.m.Y (H:i)')}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$kunde->process_id}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$kunde->activeOrdersCarData->car_company}} {{$kunde->activeOrdersCarData->car_model}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500"><p class="rounded-xl w-fit px-2 py-1 text-left text-black font-semibold" style="background-color: {{$kunde->statuse->sortByDesc("created_at")->first()->statuseMain->color}}">{{$kunde->statuse->sortByDesc("created_at")->first()->statuseMain->name}}</p></td>
                          <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                           <button type="button" onclick="showOrderChangeModal('{{$kunde->process_id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  float-right text-blue-600 hover:text-blue-400">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                            </svg>  
                          </button>                          
                          </td>
                        </tr>
                        @endforeach
                        
            
                        <!-- More people... -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="w-full">
                
                <div class="w-full -mx-4 -my-2 overflow-auto inset-x-0 bottom-0">
                  <div class="inline-block  align-middle absolute bottom-0 right-0 mr-4" style="width: 45%; bottom: 7.9rem">
                    <p class="text-md text-black font-bold pb-3">Kundendaten Änderungen</p>
                    <div class="max-h-48 overflow-auto">
                      <table class="w-full divide-y divide-gray-300 float-right inset-x-0 bottom-0 max-h-48 overflow-auto">
                        <thead>
                          <tr>
                            <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Historie</th>
                            
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          @foreach ($editKundenHistory as $history)
                          <tr>
                            <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                              <div style="max-width: 90%" class=" px-2 w-fit py-0.5 text-sm rounded-xl text-center border border-gray-400  flex">
                                                       
                                <p class="pl-2 text-gray-600">RA</p>
                                <p class="px-2 text-green-600" >•</p>        
                                <p style="max-width: 100%" class=" truncate whitespace-nowrap text-gray-600 text-left">
                                  {{$history->created_at->format('d.m.Y (H:i)')}}, {{$history->company_name}} {{$history->firstname}} {{$history->lastname}}, {{$history->street}} {{$history->streetno}}, {{$history->zipcode}} {{$history->city}}, {{$history->country}}
                                </p>
                              </div>
  
                              @if ($history->la_street != null)
                              <div style="max-width: 90%" class="mt-1 w-fit px-2  py-0.5 text-sm rounded-xl text-center border border-gray-400  flex">
                                                       
                                <p class="pl-2 text-gray-600">LA</p>
                                <p class="px-2 text-green-600" >•</p>        
                                <p style="max-width: 100%" class=" truncate whitespace-nowrap text-gray-600 text-left">
                                  {{$history->created_at->format('d.m.Y (H:i)')}}, {{$history->la_company_name}} {{$history->la_firstname}} {{$history->la_lastname}}, {{$history->la_street}} {{$history->streetno}}, {{$history->la_zipcode}} {{$history->la_city}}, {{$history->la_country}}
                                </p>
                              </div>
                              @endif
                            </td>
                          </tr>
                          @endforeach
                          
              
                          <!-- More people... -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="w-full float-left mt-10">

                <hr class="py-2">
                
                
                <button type="submit" onclick="loadData()" class="float-left bg-blue-600 hover:bg-blue-500 font-medium text-sm px-4 py-2 rounded-md text-white">Speichern</button>                
              



              @if ($currentKundenData->sperre == "true")
                <button type="button" id="sperre-button" onclick="toggleSperre('{{$currentKundenData->kunden_id}}')" class="font-medium text-sm px-4 py-2 rounded-md bg-green-600 hover:bg-green-400 text-white float-right">Sperre aufheben</button>
              @else 
                <button type="button" id="sperre-button" onclick="toggleSperre('{{$currentKundenData->kunden_id}}')" class="font-medium text-sm px-4 py-2 rounded-md bg-red-600 hover:bg-red-400 text-white float-right">Kunde Sperren</button>
              @endif
              

                <button type="button" onclick="if(document.getElementById('change-kunde-modal')) { document.getElementById('change-kunde-modal').innerHTML = '' } else{ document.getElementById('stammdaten-modal').innerHTML = '' }" class="font-medium text-sm px-4 py-2 rounded-md border border-gray-600 float-right mr-4">Zurück</button>
            </div>
        </div>
        
      </div>
    </div>
  </div>