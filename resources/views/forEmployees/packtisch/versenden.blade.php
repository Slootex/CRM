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
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link
href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"
rel="stylesheet"
/>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body onload="setCurrentTime()" >
<script>
  function setCurrentTime() {
    @if(!isset($versandContact))
    let date = new Date(); 
    document.getElementById("pickupStartHour").value = date.getHours();

    document.getElementById("pickupEndHour").value = date.getHours() + 2;
     @endif

  }
</script>

    @include('layouts.top-menu', ["menu" => "none"])


    
    <hr style=" margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">
    <h1 class="py-6 text-4xl font-bold ml-10 text-black">Versand (Extern)</h1>
    <div style="width: 80%" class=" m-auto sm:px-6 lg:px-8">
      <form action="{{url("/")}}/crm/versand/packtisch" id="versandform" method="POST" enctype="multipart/form-data">
        @CSRF
      <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="inline-block align-top pt-4" style="width: 48%">
        <div class="">
          <div class="px-6">
            <h1 class="font-bold text-xl">Versandartikel suchen</h1>
          </div>
          <div>
            <div class="mt-2 py-2 px-6 grid-flow-row grid grid-cols-2 gap-10 col-start-2">
              <input type="text" name="email" id="artikelsearch" style="width: 120%" class="block h-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Suchen">
              <button type="button" class="ml-8 xl:ml-16 text-white font-medium py-2 px-4 rounded-md bg-blue-600 hover:bg-blue-500 " onclick="searchOrders(document.getElementById('artikelsearch').value)">Suchen</button>
            </div>
          </div>
          <script>
            const form = document.getElementById('artikelsearch');
  form.addEventListener('keypress', function(e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      searchOrders(document.getElementById('artikelsearch').value);
    }
  });
          </script>
          <div class="pt-6" >
            <p class="text-gray-600 pl-6">Suchergebnisse</p>
            <div class=" ml-8" style="width: 90%">
              <table  id="orders-table" style="overflow-y:scroll;
              height:10rem;
              display:block;
              max-height: 10rem">
              <thead>
                <tr class="border border-t-0 border-l-0 border-r-0">
                  <td class="font-semibold w-60 text-left">Auftrag</td>
                  <td class="font-semibold w-60 text-left">Kunde</td>
                  <td class="font-semibold w-60 text-right ">Aktion</td>
                </tr>
              </thead>
              <tbody class="">
                @foreach ($persons as $person)
                    <tr class="border border-t-0 border-l-0 border-r-0">
                      <td>{{$person->process_id}}</td>
                      <td class="text-left">{{$person->firstname}} {{$person->lastname}}</td>
                      <td class="text-right"><button type="button" onclick="addOrder('{{$person->process_id}}')">+ <span class="font-semibold">Ger&auml;t anzeigen</span></button></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            </div>
          </div>
          
        </div>
        <div class="pt-10 ">
          <p class="text-gray-600 pl-6">Verfügbare Geräte für den Versand</p>
          <div class=" ml-8" style="width: 90%">
            <table class=" " style="overflow-y:scroll;
            height:10rem;
            display:block;
            max-height: 10rem" id="versandDevices">
            <thead>
              <tr class="border border-t-0 border-l-0 border-r-0">
                <td class="font-semibold w-60 text-left">Gerät</td>
                <td class="font-semibold w-60 "></td>
                <td class="font-semibold w-60 text-right">Aktion</td>
              </tr>
            </thead>
            <tbody class="">
              
            </tbody>
          </table>
          </div>
        </div>
        </div>
        

        <div class=" w-0.5 border inline-block border-gray-600 border-l-0 m-auto ml-6 mr-2 align-top mt-8" style=" height: 40rem;"></div>
        <div style="width:45%" class="inline-block right-0 float-right mt-4" >
          <div class=" buttonwidth">
            <h1 class="font-bold text-xl mb-3">Ausgewählte Geräte</h1>
            
            <div id="selDevices">
  
            </div>
  
  
          </div>
  
          
  
          <div class=" buttonwidth" >
            <h1 class="font-bold text-xl mb-3">Dokumente</h1>
  
            <div class="grid-flow-row grid grid-cols-3 gap-10 pr-10" >
              <h1>Beipackzettel</h1>
              <div>
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 1</label>
                <select id="location" name="bpz1" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                  <option value=""></option>
                  @foreach ($bpzs as $bpz)
                      <option value="{{$bpz->id}}">{{$bpz->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 2</label>
                <select id="location" name="bpz2" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                  <option value=""></option>
                  @foreach ($bpzs as $bpz)
                      <option value="{{$bpz->id}}">{{$bpz->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="grid-flow-row grid grid-cols-3 gap-10 mt-6 pr-10">
              <h1>Zusatz / Dokumente</h1>
              <div>
                <label class="float-left w-full mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                        
                  <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                  </svg></span>
                  <input type='file' multiple oninput="addFile(this.value)" class="hidden" name="filee" id="fileinput" />
              </label>
              </div>
             
  
          
  
              <div class="relative hidden z-10" id="absendermodal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
                <!--
                  Background backdrop, show/hide based on modal state.
              
                  Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
              
                <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
                  <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
                    <!--
                      Modal panel, show/hide based on modal state.
              
                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-96  sm:p-6">
                      <div>
                        <div class="mt-3 text-center sm:mt-5">
                          <div>
                            <div>
                              <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Kontakte</label>
                              <select id="location" onclick="changeAbsenderContact(this.value)" name="location" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                <option selected value="">Auswählen</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div>
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Vorname</label>
                              <div class="mt-2">
                                <input type="text" value="Gazi" name="ab_firstname" id="ab_firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Nachname</label>
                              <div class="mt-2">
                                <input type="text" value="Ahmad" name="ab_lastname" id="ab_lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                              <div class="mt-2">
                                <input type="text" name="ab_email" value="intern@steubel.de" id="ab_email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Telefonnummer</label>
                              <div class="mt-2">
                                <input type="text" name="ab_phone" value="017683412237" id="ab_phone" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Straße</label>
                              <div class="mt-2">
                                <input type="text" value="Strausberger Platz" name="ab_street" id="ab_street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Straßennummer</label>
                              <div class="mt-2">
                                <input type="text" name="ab_streetno" value="13" id="ab_streetno" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Postleitzahl</label>
                              <div class="mt-2">
                                <input type="text" name="ab_zipcode" value="10243" id="ab_zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Stadt</label>
                              <div class="mt-2">
                                <input type="text" name="ab_city" value="Berlin" id="ab_city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                              </div>
                            </div>
                            <div class="mt-2">
                              <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Land</label>
                              <select id="ab_country" name="ab_country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                @foreach ($countries as $country)
                                @if ($country->name == "Deutschland")
                                  <option selected value="{{$country->id}}">{{$country->name}}</option>
                                  @else
                                  <option value="{{$country->id}}">{{$country->name}}</option>
                                @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="mt-2">
                          </div>
                        </div>
                      </div>
                      <div class="mt-5 sm:mt-6 ">
                        <button type="button" onclick="document.getElementById('absendermodal').classList.add('hidden')" class="inline-flex w-36 justify-center rounded-md border px-4 py-2 text-base font-medium text-black shadow-sm  focus:outline-none focus:ring-2cus:ring-offset-2 sm:col-start-2 sm:text-sm sm:float-left">Zurück</button>
                        <button type="button" onclick="setAbsender()" class="inline-flex w-36 justify-center rounded-md border px-4 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-500 shadow-sm  focus:outline-none focus:ring-2cus:ring-offset-2 sm:col-start-2 sm:text-sm sm:">Speichern</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
  
             
              
            </div>
            <div class="grid-flow-row grid grid-cols-3 ml-5 mt-6 pr-10" id="selFiles">
              
            </div>
            <div class=" border buttonwidth mr-6" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
            </div>
            <h1 class="col-start-1 col-span-1 font-bold text-xl">Absender</h1>
              
              <div class="flex" style="width: 95.5%">
                <div class="relative mt-2 items-center flex-auto">
                  <input type="text" name="search" id="absender" value="Gazi Ahmad, Strausberger Platz 13, 10243, Berlin" disabled class="block text-md h-12 w-full text-gray-400 rounded-md border-0 py-1.5 pr-14 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:leading-6">
                  <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                    <kbd class="inline-flex items-center rounded px-1 font-sans text-xs text-blue-400 underline"><button type="button" onclick="document.getElementById('absendermodal').classList.remove('hidden')">ändern</button></kbd>
                  </div>
                </div>
              </div>
  
            <div class=" mt-10" >
              <h1 class="col-start-1 col-span-1 font-bold text-xl">Empfängeradresse auswählen</h1>
              <div class="grid grid-cols-3 grid-rows-4 gap-x-10 mt-2 pr-10">
                <div>
                  <label for="location" class="block text-md font-medium leading-6 text-gray-900">Addressbuch</label>
                  <select onchange="changeContact(this.value)" id="location" name="contact" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    @foreach ($contacts as $contact)
                        <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Vorname</label>
                  <div class="mt-2">
                    <input type="text" name="firstname" id="firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div>
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Nachname</label>
                  <div class="mt-2">
                    <input type="text" name="lastname" id="lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
  
                <div class="col-span-2 mt-0.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Straße</label>
                  <div class="mt-2">
                    <input type="text" name="street" id="street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="mt-0.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Straßennummer</label>
                  <div class="mt-2">
                    <input type="text" name="streetno" id="streetno" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
  
                <div class="mt-1.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Postleitzahl</label>
                  <div class="mt-2">
                    <input type="text" name="zipcode" id="zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="mt-1.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Stadt</label>
                  <div class="mt-2">
                    <input type="text" name="city" id="city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="mt-1.5">
                  <label for="location" class="block text-md font-medium leading-6 text-gray-900">Land</label>
                  <select id="country" name="country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                  </select>
                </div>
  
                <div class="mt-1.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Email</label>
                  <div class="mt-2">
                    <input type="text" name="email" id="email-e" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="mt-1.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Mobil</label>
                  <div class="mt-2">
                    <input type="text" name="mobil" id="mobil" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="mt-1.5">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Festnetz</label>
                  <div class="mt-2">
                    <input type="text" name="phone" id="phone" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
  
                <div class="mt-9">
                  <div class="mt-2">
                    <h1 class="float-left">Nachnahme</h1>
                    <input type="hidden" value="no" id="nachnahme" name="nachnahme">
                    <button type="button" onclick="if(document.getElementById('nachnahme').value == 'yes') { document.getElementById('nachnahme').value = 'no' } else { document.getElementById('nachnahme').value = 'yes' }; this.classList.toggle('bg-green-400'); this.classList.toggle('bg-gray-200'); document.getElementById('nachnahmebutton').classList.toggle('translate-x-5'); document.getElementById('nachnahmebutton').classList.toggle('translate-x-0');" class=" bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                      <span class="sr-only">Use setting</span>
                      <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                      <span aria-hidden="true" id="nachnahmebutton" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                  </div>
              </div>
              <div class="col-span-2 mt-1.5">
                <label for="email" class="block text-md font-medium leading-6 text-gray-900">Nachnahmebetrag</label>
                <div class="mt-2">
                  <input type="text" name="nachnahmebetrag" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>
              </div>
  
              <div class="mt-8">
                <h1>Versand</h1>
              </div>
              <div class="col-span-2 mt-4" style="width: 120%">
                <input type="hidden" name="shippingtype" id="shippingtype" value="Standard">
                <button type="button" class="" onclick="setShipping('Standard')">
                  <div id="Standard" class="inline-block rounded-md border border-blue-600 px-2 py-2">
                  <h1>Standard</h1>
                  <p>5,95€</p>
                </div>
              </button>
                <button type="button" onclick="setShipping('Express')">
                  <div id="Express" class="inline-block rounded-md border px-2 py-2 ml-2">
                  <h1>Express</h1>
                  <p>8,95€</p>
                </div>
              </button>
                <button type="button" onclick="setShipping('Samstag')">
                  <div id="Samstag" class="inline-block bg-gray-100 rounded-md border px-2 py-2 ml-2">
                  <h1>Samstagszustellung</h1>
                  <p>Nur mit Express möglich</p>
                </div>
              </button>
              </div>
  
              <div class="col-span-3 mt-4">           
  
                <label for="email" class="block font-bold text-xl leading-6 text-gray-900">Zusatzkommentar Packtisch</label>
                <div class="mt-2">
                  <input type="text" name="extcomment" id="email" class="block w-full h-12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                </div>
              </div>
  
              
            </div>
            <div class="mt-10">
              <button type="button" onclick="versandschein()" class="text-white bg-blue-600 hover:bg-blue-500 font-medium px-4 py-2 rounded-md float-right mr-10">Versandschein sofort drucken</button>
              <button class="text-white bg-blue-600 hover:bg-blue-500  font-medium px-4 py-2 rounded-md float-right mr-8">an Packtisch senden</button>
            </div>
            <br>
            <br>
            </div>
  
        </div>
      </div>
        </div>
      </div>
    </div>
      </form>
  
    


    <script>
      
      function versandschein() {
        document.getElementById('versandform').action = '{{url("/")}}/crm/versand/druck';
        document.getElementById('versandform').submit();
      }

      let oldshipping = "Standard";
      let shipcounter = 0;
      function setShipping(typ) {
        
        
        if(typ == "Samstag") {
          if(oldshipping == "Express") {
            if(shipcounter == 0) {
            document.getElementById("Samstag").classList.add("border-blue-600");

            document.getElementById("shippingtype").value = typ;
            shipcounter = 1;
          } else {
            document.getElementById("Samstag").classList.remove("border-blue-600");


            document.getElementById("shippingtype").value = oldshipping;
            shipcounter = 0;
          }
          }
        } else {
          document.getElementById("Standard").classList.remove("border-blue-600");
          document.getElementById("Express").classList.remove("border-blue-600");
          document.getElementById(typ).classList.add("border-blue-600");
          document.getElementById("shippingtype").value = typ;

          if(typ == "Standard") {
            document.getElementById("Samstag").classList.remove("border-blue-600");
            document.getElementById("Samstag").classList.add("bg-gray-100");
            shipcounter = 1;

          }
          if(typ == "Express") {
            document.getElementById("Samstag").classList.remove("bg-gray-100");

          }

          oldshipping = typ;
        }


        

      }

      function changeContact(id) {

        $.get( "{{url("/")}}/versand-versenden/get-contact/" + id, function( data ) {
          document.getElementById("firstname").value = data["firstname"];
          document.getElementById("lastname").value = data["lastname"];
          document.getElementById("street").value = data["street"];
          document.getElementById("streetno").value = data["streetno"];
          document.getElementById("zipcode").value = data["zipcode"];
          document.getElementById("city").value = data["city"];
          document.getElementById("email-e").value = data["email"];
          if(data["servicecode"] == "065") {
            document.getElementById("Standard").classList.remove("border-blue-600");
            document.getElementById("Express").classList.add("border-blue-600");
            document.getElementById("shippingtype").value = "Express";

          }
          if(data["servicecode"] == "011") {
            document.getElementById("Standard").classList.add("border-blue-600");
            document.getElementById("Express").classList.remove("border-blue-600");
            document.getElementById("shippingtype").value = "Standard";

          }
          document.getElementById("country").value = data["country"];
          document.getElementById("phone").value = data["phonenumber"];
          document.getElementById("mobil").value = data["mobilnumber"];
        });
      }

      function changeAbsenderContact(id) {
        $.get( "{{url("/")}}/versand-versenden/get-contact/" + id, function( data ) {
          document.getElementById("ab_firstname").value = data["firstname"];
          document.getElementById("ab_lastname").value = data["lastname"];
          document.getElementById("ab_street").value = data["street"];
          document.getElementById("ab_streetno").value = data["streetno"];
          document.getElementById("ab_zipcode").value = data["zipcode"];
          document.getElementById("ab_city").value = data["city"];
          document.getElementById("ab_email").value = data["email"];
          document.getElementById("ab_country").value = data["country"];
          if(data["mobilnumber"] == null) {
            document.getElementById("ab_phone").value = data["phonenumber"];
          } else {
            document.getElementById("ab_phone").value = data["mobilnumber"];
          }

        });
      }

      function addFile(file) {
        if(file != null || file != "" || document.getElementById("fileinput").files == "" || document.getElementById("fileinput").files == null) {

          Array.from(document.getElementById("fileinput").files)
          .forEach(parentFile => {
            console.log(parentFile);
            let parent = document.getElementById("selFiles");

            let input = document.createElement("input");
            input.type = "file";
            input.classList.add("hidden");
            input.name = "file-" + parentFile["name"];
            input.file = parentFile;

            let div = document.createElement("div");
            div.classList.add("col-start-2", "col-span-2");
            let divID = Math.floor(Math.random() * 1111);
            div.setAttribute("id" , divID + "-div");
            div.innerHTML = '<button type="button" class="mt-2" onclick="removeFile(' + "'" + divID + "'" + ')"><div class="border border-blue-600 rounded-md px-2 py-0.5 hover:bg-red-200">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400 float-left mr-4">    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />  </svg><h1 class="inline-block">' + parentFile["name"] + '</h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600 inline-block ml-2">  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>  </div></button>'

            input.setAttribute("id", divID + "-input");

            parent.appendChild(div);
            parent.appendChild(input);
          });          
          
         


        }
      }

      function removeFile(file) {
        document.getElementById(file + "-div").remove();
        document.getElementById(file + "-input").remove();

      }

      function searchOrders(key) {
        if(key == "") {
          key = "null";
        }
        $.get('{{url("/")}}/crm/search-orders/' + key, function (data) {
          $("#orders-table tr").not(':first').remove();

          data.forEach(element => {
            var table = document.getElementById("orders-table");

            var row = table.insertRow(-1);
            row.classList.add("remove-row-animation");

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = element["process_id"];

            cell2.innerHTML = element["firstname"] + " " + element["lastname"];

            cell3.classList.add("text-right");
            cell3.innerHTML = '<button type="button" onclick="addOrder(' + "'" + element["process_id"] + "'" + ')">+ <span class="font-semibold">Ger&auml;t anzeigen</span></button>';
          });
        });
      }

      function addOrder(id) {

        $.get( "{{url("/")}}/versand-versenden/get-devices/" + id, function( data ) {
          $("#versandDevices tr").not(':first').remove();
          if(data.length == 0) {
            var table = document.getElementById("versandDevices");

            var row = table.insertRow(-1);
            row.classList.add("remove-row-animation");
                                                  
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
                        
            cell1.classList.add("text-left", "text-red-600")
            cell1.innerHTML = "Kein Ger\u00e4t gefunden";
                        
            cell2.innerHTML = "";
                        
            cell3.classList.add("text-center", "pr-2", "text-xl", "font-bold", "text-green-600");
            cell3.innerHTML = '';

          }
          data.forEach(dev => {
            if(!usedDevicesList.includes(dev["process_id"] + "-" + dev["component_id"] + "-" +dev["component_type"] + "-" +dev["component_count"])) {
              var table = document.getElementById("versandDevices");

              var row = table.insertRow(-1);
              row.classList.add("update-row-animation");

              row.setAttribute("id", "order-"+ dev["process_id"] + "-" + dev["component_id"] + "-" +dev["component_type"] + "-" +dev["component_count"]);
                          
              var cell2 = row.insertCell(0);
              var sp    = row.insertCell(1);

              var cell3 = row.insertCell(2);
                          
                          
              cell2.classList.add("text-left");
              cell2.innerHTML = dev["process_id"] + "-" + dev["component_id"] + "-" +dev["component_type"] + "-" +dev["component_count"];
                          
              cell3.classList.add("text-right", "w-96");
              cell3.innerHTML = '<button type="button" onclick="addDevice('+"'"+ dev["process_id"] + "-" + dev["component_id"] + "-" +dev["component_type"] + "-" +dev["component_count"] +"'"+')">+ <span class="font-semibold">Ger&auml;t hinzuf&uuml;gen</span></button>';
            } else {
              var table = document.getElementById("versandDevices");

              var row = table.insertRow(-1);
              row.classList.add("remove-row-animation");

              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              var cell3 = row.insertCell(2);

              cell1.classList.add("text-left", "text-red-600")
              cell1.innerHTML = "Ger\u00e4t " +  dev["process_id"] + "-" + dev["component_id"] + "-" +dev["component_type"] + "-" +dev["component_count"] + " bereits in Liste";

              cell2.innerHTML = "";

              cell3.classList.add("text-center", "pr-2", "text-xl", "font-bold", "text-green-600");
              cell3.innerHTML = '';
            }
          });
        });
      }
      let usedDevicesList = [];

      function addDevice(id) {
        console.log(usedDevicesList);
        if(!usedDevicesList.includes(id)) {
          let parent = document.getElementById("selDevices");

          let div = document.createElement("div");
          div.innerHTML = '<button onmouseleave="document.getElementById(' + "'" + id + "-xsvg'" +').classList.toggle(' + "'" + "hidden"  + "'" +'); document.getElementById(' + "'" + id + "-checksvg'" +').classList.toggle(' + "'" + "hidden"  + "'" +')" onmouseenter="document.getElementById(' + "'" + id + "-xsvg'" +').classList.toggle(' + "'" + "hidden"  + "'" +'); document.getElementById(' + "'" + id + "-checksvg'" +').classList.toggle(' + "'" + "hidden"  + "'" +')" class="float-left" id="'+ id +'-dev" type="button" onclick="removeDevice(' + "'" + id + "'" + ')"><div  class="w-52 h-16 border border-gray-300 float-left mr-4 hover:bg-red-200" style="border-radius: 2rem"> <div class="w-40 pl-6 pt-1.5 float-left">   <h2 class="font-bold text-left pl-2">ausgew&auml;hlt</h2>  <p class="text-gray-400 font-medium">' + id + '</p></div><div class="pt-4">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" id="'  + id + "-checksvg" + '" stroke="currentColor" class="w-7 h-7 text-gray-400">    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />  </svg><svg xmlns="http://www.w3.org/2000/svg" id="'  + id + "-xsvg" + '" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-gray-400 hidden"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></div></div></button>'
        
          parent.appendChild(div);

          let input = document.createElement("input");
          input.type = "hidden";
          input.name = "dev-" + id;
          input.id = "devinput-" + id;
          input.value = id;

          parent.appendChild(input);

          usedDevicesList.push(id);
        }
      }

      function removeDevice(id) {
        document.getElementById(id + "-dev").remove();
        document.getElementById("devinput-" + id).remove();
        var index = usedDevicesList.indexOf(id);
        if (index > -1) {
          usedDevicesList.splice(index, 1);
        }

        let counter = 0;
        usedDevicesList.forEach(element => {
          if(element == id) {
            usedDevicesList.splice(counter, 1);
          }
          counter++;
        });

      }

      function showDifferentVersand() {
        document.getElementById("differentAbsender").classList.toggle("hidden");
        document.getElementById("versandVVV").classList.toggle("mt-4");
        document.getElementById("versandVVV").classList.toggle("mt-4");

      }
    </script>








<script>
  function setAbsender() {
    document.getElementById("absendermodal").classList.add("hidden");
    document.getElementById("absender").value = document.getElementById("ab_firstname").value + " " + document.getElementById("ab_lastname").value + ", " + document.getElementById("ab_street").value + " " + document.getElementById("ab_streetno").value + ", " + document.getElementById("ab_zipcode").value + ", " + document.getElementById("ab_country").value;
  }
</script>

</body>
</html>