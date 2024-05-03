<div>
    
     <form action="{{url("/")}}/crm/packtisch/neuer-kundenversand" id="packtisch-versand-kunde-form" class="flex" enctype="multipart/form-data" method="POST">
        @csrf
        <div id="versand-kunde-address-check-modal">

        </div>
        <div class="grid grid-cols-3 gap-2" style="width: 50rem;">
            
            <p class="mt-8">Versandartikel</p>


            @php
                $deviceCounterKundenVersand = 0;
            @endphp
            @foreach ($order->devices as $device)
            
            @if ($device->usedShelfes != null && $order->warenausgang->where("component_number", $device->component_number)->first() == null && $order->intern->where("component_number", $device->component_number)->first() == null)
            <button class="w-full" type="button" onclick="toggleKundenversandDevice('{{$device->component_number}}')" class="">
                <div id="device-div-versand-kunde-{{$device->component_number}}" class=" mt-8 px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                    <p class="text-center float-left text-sm">{{$device->component_number}}</p>
                    <svg id="versand-kunde-device-svg-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right ml-1 mt-0.5 hidden">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
     
    
        @php
            $deviceCounterKundenVersand++;
        @endphp
            @endif

            @endforeach

            @if ($deviceCounterKundenVersand == 0)
                <div>
                    <p class="text-xl text-red-600 mt-8">Keine Geräte verfügbar</p>
                </div>
            @endif


            <p class="mt-8 col-start-1">Zusatzartikel</p>
            
            <button class="grid mt-8  " type="button" >
                <div id="device-div-versand-kunde-gummi" onclick="toggleZusatzartikel('gummi')" class="  px-2 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                    <p class="float-left  text-sm">Gummibärchen</p>
                    <svg id="gummi-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5 ">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                      </svg>
                </div>
                
            </button>
            <button type="button" class="mt-8 grid   ">
                <div id="device-div-versand-kunde-prot" onclick="toggleZusatzartikel('prot')" class=" px-2 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                    <p class="float-left text-sm">Spannungsschutz</p>
                    <svg id="prot-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                      </svg>
                </div>
            </button>
            <button type="button" class="col-start-2 grid ">
                <div id="device-div-versand-kunde-seal" onclick="toggleZusatzartikel('seal')" class=" px-2 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                    <p class="float-left text-sm">Versiegeln</p>
                    <svg id="seal-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                      </svg>
                </div>
            </button>

            <p class="mt-8 col-start-1">Beipackzettel</p>
            <div class="  mt-8">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 1</label>
                <select id="location" name="bpz1" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    @foreach ($bpzs as $bpz)
                        <option value="{{$bpz->name}}">{{$bpz->name}}</option>
                    @endforeach
                </select>
              </div>
            <div class="  mt-8">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 2</label>
                <select id="location" name="bpz2" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                  @foreach ($bpzs as $bpz)
                          <option value="{{$bpz->name}}">{{$bpz->name}}</option>
                  @endforeach
                </select>
            </div>

            <p class="mt-8  col-start-1">Zusatz / Dokumente</p>
            <div class="mt-8  ">
                <label class="border border-gray-300 flex flex-col items-center px-4 py-1 bg-white rounded-lg tracking-wide uppercase cursor-pointer hover:bg-blue hover:text-blue-400">
                    
                    <span class="mt-0 text-base leading-normal">
                        <span class="float-left" id="emailvorlage-file"></span>  
                        <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                    </span>
                    <input type='file' oninput="uploadKundenversandDocuments()" multiple class="hidden" id="versand-kunde-fileinput" />
                </label>
                <div id="versand-kunde-files-div">
                    <input type="file" class="hidden" id="versand-kunde-extradatein">
                </div>
            </div>

            <p class="mt-8  col-start-1">Entsorgungsliste</p>

                @php
                $deviceCounterKundenVersand = 0;
            @endphp
            @foreach ($order->devices as $device)

            

                <div class="grid mt-8  ">
                    <div id="device-div-versand-kunde-entsorgung-{{$device->component_number}}" class="px-2 h-8 py-1 rounded-md border border-red-300 text-red-500 ">
                        <p class="text-center float-left text-xs 2xl:text-sm mt-0.5">{{$device->component_number}}</p>
                          <svg id="versand-kunde-device-svg-entsorgung-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right ml-1 mt-0.5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>
                          
                    </div>
                    <input type="hidden" name="entsorgung-{{$device->component_number}}" value="{{$device->component_number}}" id="entsorgung-input-{{$device->component_number}}">
                    
                </div>
         
        
            @php
                $deviceCounterKundenVersand++;
            @endphp
            @endforeach

            <p class="mt-8  col-start-1">Extra Bilder machen</p>

            <button type="button" onclick="toggleVersandkundeExtraPictures()" id="versand-kunde-extrapicture-button" class="mt-8  bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                <span id="versand-kunde-extrapicture-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>

            <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>
              <textarea onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" name="info" id="" class="mt-8  rounded-md border border-gray-300 h-16 col-span-2 mb-10" cols="30" rows="10"></textarea>
        </div>
        <div class="m-auto px-8">
            <div class="m-auto 2xl:w-0.5 bg-gray-200" style="height: 30rem">

            </div>
        </div>
        <div class="float-right"style="width: 50rem;">
        <div class="mt-8 grid grid-cols-3 gap-2">
            <p class="font-bold text-md col-start-1 mb-4">Empfängeraddresse</p>

            <div class="relative col-start-1 col-span-3">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" value="{{$order->send_back_company_name ?: $order->company_name}}" type="text" name="companyname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="mt-4">
                <select id="versand-kunde-gender"  name="gender" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Anrede</option>
                  <option value="Herr">Herr</option>
                  <option value="Frau">Frau</option>
                </select>
                <script>
                    document.getElementById("versand-kunde-gender").value = "{{$order->send_back_gender ?: $order->gender}}";
                </script>
            </div>
            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" required value="{{substr($order->send_back_firstname,0,34) ?: substr($order->firstname,0,34) ?: substr($order->send_back_company_name,0,34) ?: substr($order->company_name,0,34)}}" name="firstname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" required value="{{substr($order->send_back_lastname,0,34) ?: substr($order->lastname,0,35)}}" name="lastname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-4 col-start-1 col-span-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                @php
                    $send_back_street_kunde = $order->send_back_street ?: $order->home_street;
                    $send_back_street_kunde = str_replace("'", "", $send_back_street_kunde);
                @endphp
                <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" required value="{{$order->send_back_street ?: $order->home_street}}" name="street" id="versand-kunde-street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative col-start-3 mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straßennummer</label>
                @php
                    $send_back_street_number_kunde = $order->send_back_street_number ?: $order->home_street_number;
                    $send_back_street_number_kunde = str_replace("'", "", $send_back_street_number_kunde);
                @endphp
                <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" required value="{{$order->send_back_street_number ?: $order->home_street_number}}" name="street_number" id="versand-kunde-street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                @php
                    $send_back_zipcode_kunde = $order->send_back_zipcode ?: $order->home_zipcode;
                    $send_back_zipcode_kunde = str_replace("'", "", $send_back_zipcode_kunde);
                @endphp
                <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" required value="{{$order->send_back_zipcode ?: $order->home_zipcode}}" name="zipcode" id="versand-kunde-zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                @php
                    $send_back_city_kunde = $order->send_back_city ?: $order->home_city;
                    $send_back_city_kunde = str_replace("'", "", $send_back_city_kunde);
                 @endphp
                <input type="text" required onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" value="{{$order->send_back_city ?: $order->home_city}}" name="city" id="versand-kunde-city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="mt-4">
                <select id="versand-kunde-country" required name="country" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Land</option>
                  @foreach ($countries as $country)
                      <option value="{{$country->name}}">{{$country->name}}</option>
                  @endforeach
                </select>
                <script>
                    document.getElementById("versand-kunde-country").value = "{{$order->send_back_country ?: $order->home_country}}";
                </script>
            </div>

            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Email</label>
                <input type="text" value="{{$order->email}}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" name="email" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Mobil</label>
                <input type="text" value="{{$order->mobile_number}}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" name="mobil" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Festnetz</label>
                <input type="text" value="{{$order->phone_number}}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" name="phone" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
        </div>
        <div class="mt-8 grid grid-cols-3 gap-2">

            <div class=" col-start-1">
                <p class="mt-2 ml-1 float-left">Nachnahme</p>

                <button type="button" onclick="toggleVersandkundeNachnahme()" id="versand-kunde-nachnahme-button" class="mt-2 float-right bg-gray-200 col-start-3 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span id="versand-kunde-nachnahme-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>
            <div class="relative rounded-md shadow-sm col-start-2 col-span-2">

                <input type="number" oninput="if(parseFloat(this.value.replace('.', ',')) <= 0.00 || this.value == '') { turnOffVersandkundeNachnahme() } else { turnOnVersandkundeNachnahme() }" name="nachnahme_price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nachnahmebetrag">
                <div class="absolute inset-y-0 right-0 flex items-center -top-2">
                  <select id="currency" name="nachnahme_currency" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    <option selected>EUR</option>
                  </select>
                </div>
          </div>

          <select id="location" name="carrier" class=" h-10 block w-full rounded-md border-gray-300 py-1.5 border text-gray-900 sm:text-sm">
            <option>UPS Versand</option>
          </select>

          <div class="col-span-2 grid grid-flow-col">
            <button type="button" id="Standard-kunde-versand" onclick="setShippingKundenversand('Standard')" class=" rounded-md border border-blue-600 px-2 py-2">
              <div  >
              <h1>Standard</h1>
              <p>5,95€</p>
            </div>
          </button>
            <button type="button" id="Express-kunde-versand" onclick="setShippingKundenversand('Express')" class=" rounded-md border px-2 py-2 ml-2">
              <div >
              <h1>Express</h1>
              <p>8,95€</p>
            </div>
          </button>
            <button type="button" id="Samstag-kunde-versand" onclick="setShippingKundenversand('Samstag')" class=" bg-gray-100 rounded-md border px-2 py-2 ml-2">
              <div >
              <h1>Samstagszustellung</h1>
              <p>Nur mit Express möglich</p>
            </div>
          </button>
          </div>
          <input type="hidden" name="shippingtype" id="shippingtype-kunde-versand" value="Standard">


        </div>
        </div>
  


        
        <div id="versand-kunde-inputlist">

        </div>
        <input type="hidden" name="process_id" value="{{$order->process_id}}">
        <input type="hidden" name="gummi" id="versand-kunde-input-gummi" value="false">
        <input type="hidden" name="prot"  id="versand-kunde-input-prot"  value="false">
        <input type="hidden" name="seal"  id="versand-kunde-input-seal"  value="false">
        <input type="hidden" name="nachnahme" id="versand-kunde-input-nachnahme" value="false">

        <button type="submit" id="submit-kunden-versand" class="hidden"></button>
    </form>
</div>
<div class="w-full h-10">
    <hr>
    <button type="button" onclick="checkKundenVersandBeforePost();" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60  mt-7">An Packtisch senden</button>
</div>
<br>
<br>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function checkKundenVersandBeforePost() {

        loadData();

        let street = document.getElementById("versand-kunde-street").value;

        if(deviceCounterKundenVersand != 0 && street != "") {
            checkKundenVersandAddress();
        } else {
            if(deviceCounterKundenVersand == 0) {
                newErrorAlert("Kein Gerät!", "Achtung es wurde kein Gerät ausgewählt!");
                savedPOST();
            }
            if(street == "") {
                newErrorAlert("Keine Versandaddresse", "Achtung es wurde keine Versandaddresse ausgewählt");
                savedPOST();
            }
        }
    }

    function checkKundenVersandAddress() {

        let v_street    = document.getElementById("versand-kunde-street").value;
        let v_streetno  = document.getElementById("versand-kunde-street_number").value;
        let v_city      = document.getElementById("versand-kunde-city").value;
        let v_zipcode   = document.getElementById("versand-kunde-zipcode").value;
        let v_country   = document.getElementById("versand-kunde-country").value;


        $.post("{{url("/")}}/crm/packtisch/versand-checkaddress", { 
            street: v_street,
            streetno: v_streetno,
            city: v_city,
            zipcode: v_zipcode,
            country: v_country,
            type: "versand-kunde"
         })
            .done(function( data ) {
              if(data == "ok") {
                document.getElementById("submit-kunden-versand").click();
              } else {
                document.getElementById("versand-kunde-address-check").innerHTML = data;
                adrType = "kunde";
                savedPOST();
              }
              
        });
    }


        var optionsVersand = {
        error: function() {
            let title = "Unbekannter Fehler!";
            let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte schau das du ein Gerät so wie eine Versandaddresse ausgewählt hast.";
            newErrorAlert(title, text);
        },
        success: function() {
            let title = "Versandauftrag (Kunde) erfolgreich!";
            let text = "Der Versandauftrag (Kunde) wurde erfolgreich an den Packtisch gesendet."; 
            newAlert(title, text);
            savedPOST();
        }
    };

    let alternativeAddress = "";
    let adrType = "";
    function setAltAddrs() {

        if(adrType == "kunde") {
            document.getElementById("versand-kunde-street").value = document.getElementById("alt-street-"+alternativeAddress).value;
            document.getElementById("versand-kunde-street_number").value = document.getElementById("alt-streetno-"+alternativeAddress).value;
            document.getElementById("versand-kunde-city").value = document.getElementById("alt-city-"+alternativeAddress).value;
            
            if( document.getElementById("alt-country-"+alternativeAddress).value == "Germany") {
                document.getElementById("versand-kunde-country").value = "Deutschland";
            } else {
                document.getElementById("versand-kunde-country").value = document.getElementById("alt-country-"+alternativeAddress).value;
            }

            document.getElementById('versand-kunde-address-check').innerHTML = '';
            document.getElementById("submit-kunden-versand").click();
        } else {
            document.getElementById("tec_street").value = document.getElementById("alt-street-"+alternativeAddress).value;
            document.getElementById("tec_street_number").value = document.getElementById("alt-streetno-"+alternativeAddress).value;
            document.getElementById("tec_city").value = document.getElementById("alt-city-"+alternativeAddress).value;
            
            if( document.getElementById("alt-country-"+alternativeAddress).value == "Germany") {
                document.getElementById("versand-techniker-country").value = "Deutschland";
            } else {
                document.getElementById("versand-techniker-country").value = document.getElementById("alt-country-"+alternativeAddress).value;
            }

            document.getElementById('versand-kunde-address-check').innerHTML = '';
            document.getElementById("submit-techniker-versand").click();
        } 
    }



        function uploadKundenversandDocuments() {
        let parent = document.getElementById("versand-kunde-files-div");
        let fileCounter = 0;
        Array.from(document.getElementById("versand-kunde-fileinput").files)
          .forEach(parentFile => {
            let button      = document.createElement("button");
            button.classList.add("px-3", "py-1", "rounded-md", "border", "border-blue-400", "hover:border-red-400", "hover:text-red-400", "h-8", "text-blue-500", "mt-2");
            button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left sm:hidden xl:hidden 2xl:block">  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>      <p class="overflow-hidden truncate">'+ parentFile["name"] + "</p>";
            button.setAttribute("onclick", "deleteKundenversandFile('"+ parentFile["name"] +"')");
            button.setAttribute("id", "versand-kunde-filebutton-"+ parentFile["name"]);

            let br = document.createElement("br");
            br.setAttribute("id", "versand-kunde-br-"+ parentFile["name"]);

            let input = document.createElement("input");
            input.type = "file";
            input.setAttribute("id", "versand-kunde-fileinput-"+ parentFile["name"] );
            input.name = "extrafile-"+fileCounter + "[]";
            input.files = document.getElementById("versand-kunde-fileinput").files;
            input.classList.add("hidden");

            let name = document.createElement("input");
            name.type = "hidden";
            name.setAttribute("id", "versand-kunde-filename-"+ parentFile["name"] );
            name.name = "filename-"+fileCounter + fileCounter;
            name.value = parentFile["name"];

            parent.appendChild(input);   
            parent.appendChild(br);
            parent.appendChild(button);
            parent.appendChild(name);
            fileCounter++;
        });
    }

    function deleteKundenversandFile(id) {
        document.getElementById("versand-kunde-filebutton-"+id).remove();
        document.getElementById("versand-kunde-fileinput-"+id).remove();
        document.getElementById("versand-kunde-br-"+id).remove();
        document.getElementById("versand-kunde-filename-"+id).remove();
    }

    function toggleVersandkundeExtraPictures() {

        if(!document.getElementById("versand-kunde-extrapicture"))  {
            let input = document.createElement("input");
            input.type  = "hidden";
            input.name  = "extrapicture";
            input.value = "true";
            input.setAttribute("id", "versand-kunde-extrapicture");
            
            document.getElementById("versand-kunde-inputlist").appendChild(input);

            document.getElementById("versand-kunde-extrapicture-button").classList.add("bg-blue-600");
            document.getElementById("versand-kunde-extrapicture-button").classList.remove("bg-gray-200");

            document.getElementById("versand-kunde-extrapicture-span").classList.add("translate-x-5");
            document.getElementById("versand-kunde-extrapicture-span").classList.remove("translate-x-0");
        } else {
            document.getElementById("versand-kunde-extrapicture").remove();

            document.getElementById("versand-kunde-extrapicture-button").classList.remove("bg-blue-600");
            document.getElementById("versand-kunde-extrapicture-button").classList.add("bg-gray-200");

            document.getElementById("versand-kunde-extrapicture-span").classList.remove("translate-x-5");
            document.getElementById("versand-kunde-extrapicture-span").classList.add("translate-x-0");
        }
    }

    let oldshipping = "Standard";
    let shipcounter = 0;
    function setShippingKundenversand(typ) {
      
      
      if(typ == "Samstag") {
        if(oldshipping == "Express") {
          if(shipcounter == 0) {
          document.getElementById("Samstag-kunde-versand").classList.add("border-blue-600");

          document.getElementById("shippingtype-kunde-versand").value = typ;
          shipcounter = 1;
        } else {
          document.getElementById("Samstag-kunde-versand").classList.remove("border-blue-600");


          document.getElementById("shippingtype-kunde-versand").value = oldshipping;
          shipcounter = 0;
        }
        }
      } else {
        document.getElementById("Standard-kunde-versand").classList.remove("border-blue-600");
        document.getElementById("Express-kunde-versand").classList.remove("border-blue-600");
        document.getElementById(typ+"-kunde-versand").classList.add("border-blue-600");
        document.getElementById("shippingtype-kunde-versand").value = typ;

        if(typ == "Standard") {
          document.getElementById("Samstag-kunde-versand").classList.remove("border-blue-600");
          document.getElementById("Samstag-kunde-versand").classList.add("bg-gray-100");
          shipcounter = 1;

        }
        if(typ == "Express") {
          document.getElementById("Samstag-kunde-versand").classList.remove("bg-gray-100");

        }

        oldshipping = typ;
      }
    }
    let deviceCounterKundenVersand = 0;
    function toggleKundenversandDevice(id) {

        if(document.getElementById("device-input-versand-kunde-"+id)) {
            document.getElementById("device-input-versand-kunde-"+id).remove();
            document.getElementById("device-div-versand-kunde-"+id).classList.add("border-gray-300");
            document.getElementById("device-div-versand-kunde-"+id).classList.remove("border-blue-400");
            document.getElementById("device-div-versand-kunde-"+id).classList.add("text-gray-500");
            document.getElementById("device-div-versand-kunde-"+id).classList.remove("text-blue-500");
            document.getElementById("versand-kunde-device-svg-"+id).classList.add("hidden");

            document.getElementById("entsorgung-input-"+id).value = id;

            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.add("border-red-300");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.add("text-red-500");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.remove("border-gray-300");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.remove("text-gray-500");
            document.getElementById("versand-kunde-device-svg-entsorgung-"+id).classList.remove("hidden");

            deviceCounterKundenVersand--;
        } else {
            document.getElementById("entsorgung-input-"+id).value = "";



            let div = document.getElementById("versand-kunde-inputlist");

            let input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("id", "device-input-versand-kunde-"+id);
            input.value = id;
            input.setAttribute("name", "device-"+id);

            div.appendChild(input);

            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.remove("border-red-300");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.remove("text-red-500");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.add("border-gray-300");
            document.getElementById("device-div-versand-kunde-entsorgung-"+id).classList.add("text-gray-500");
            document.getElementById("versand-kunde-device-svg-entsorgung-"+id).classList.add("hidden");

            document.getElementById("device-div-versand-kunde-"+id).classList.remove("border-gray-300");
            document.getElementById("device-div-versand-kunde-"+id).classList.add("border-blue-400");
            document.getElementById("device-div-versand-kunde-"+id).classList.remove("text-gray-500");
            document.getElementById("device-div-versand-kunde-"+id).classList.add("text-blue-500");
            document.getElementById("versand-kunde-device-svg-"+id).classList.remove("hidden");
            deviceCounterKundenVersand++;
        }

    }

    function selectAllKundenversandDevices() {

            let devices = [@foreach($order->devices as $device) "{{$device->component_number}}", @endforeach , "last"];

            devices.forEach(device => {
                if(!document.getElementById("device-input-versand-kunde-"+device)) {

                    if(device != "last") {
                        let div = document.getElementById("versand-kunde-inputlist");

                        let input = document.createElement("input");
                        input.setAttribute("type", "hidden");
                        input.setAttribute("id", "device-input-versand-kunde-"+device);
                        input.value = device;
                        input.setAttribute("name", "device-"+device);

                        div.appendChild(input);

                        document.getElementById("device-div-versand-kunde-"+device).classList.remove("border-gray-300");
                        document.getElementById("device-div-versand-kunde-"+device).classList.add("border-blue-400");
                        document.getElementById("device-div-versand-kunde-"+device).classList.remove("text-gray-500");
                        document.getElementById("device-div-versand-kunde-"+device).classList.add("text-blue-500");
                        document.getElementById("versand-kunde-device-svg-"+device).classList.remove("hidden");
                        deviceCounterKundenVersand++;

                        document.getElementById("versand-kunde-select-text").innerHTML = "Alle abwählen";
                    }
                } else {
                    if(device != "last") {

                        document.getElementById("device-div-versand-kunde-"+device).classList.add("border-gray-300");
                        document.getElementById("device-div-versand-kunde-"+device).classList.remove("border-blue-400");
                        document.getElementById("device-div-versand-kunde-"+device).classList.add("text-gray-500");
                        document.getElementById("device-div-versand-kunde-"+device).classList.remove("text-blue-500");
                        document.getElementById("versand-kunde-device-svg-"+device).classList.add("hidden");
                        deviceCounterKundenVersand--;

                        document.getElementById("device-input-versand-kunde-"+device).remove();

                        document.getElementById("versand-kunde-select-text").innerHTML = "Alle Teile auswählen";

                        
                    }
                }
            });
    }

    function toggleZusatzartikel(artikel) {

        let div = document.getElementById("device-div-versand-kunde-"+artikel);

        if(div.classList.contains("border-gray-300")) {
            document.getElementById("device-div-versand-kunde-"+artikel).classList.remove("border-gray-300");
            document.getElementById("device-div-versand-kunde-"+artikel).classList.remove("text-gray-500");

            document.getElementById("device-div-versand-kunde-"+artikel).classList.add("border-blue-400");
            document.getElementById("device-div-versand-kunde-"+artikel).classList.add("text-blue-500");

            document.getElementById("versand-kunde-input-"+artikel).value = "true";
            document.getElementById(artikel+"-svg").classList.remove("hidden");
        } else {
            document.getElementById("device-div-versand-kunde-"+artikel).classList.add("border-gray-300");
            document.getElementById("device-div-versand-kunde-"+artikel).classList.add("text-gray-500");

            document.getElementById("device-div-versand-kunde-"+artikel).classList.remove("border-blue-400");
            document.getElementById("device-div-versand-kunde-"+artikel).classList.remove("text-blue-500");

            document.getElementById("versand-kunde-input-"+artikel).value = "false";
            document.getElementById(artikel+"-svg").classList.add("hidden");

        }
    }

    function toggleVersandkundeNachnahme() {

        if(document.getElementById("versand-kunde-input-nachnahme").value == "false") {
            document.getElementById("versand-kunde-nachnahme-button").classList.add("bg-blue-600");
            document.getElementById("versand-kunde-nachnahme-button").classList.remove("bg-gray-200");

            document.getElementById("versand-kunde-nachnahme-span").classList.add("translate-x-5");
            document.getElementById("versand-kunde-nachnahme-span").classList.remove("translate-x-0");

            document.getElementById("versand-kunde-input-nachnahme").value = "true";
        } else {
            document.getElementById("versand-kunde-nachnahme-button").classList.remove("bg-blue-600");
            document.getElementById("versand-kunde-nachnahme-button").classList.add("bg-gray-200");

            document.getElementById("versand-kunde-nachnahme-span").classList.remove("translate-x-5");
            document.getElementById("versand-kunde-nachnahme-span").classList.add("translate-x-0");

            document.getElementById("versand-kunde-input-nachnahme").value = "false";
        }
    }

     function turnOffVersandkundeNachnahme() {

            document.getElementById("versand-kunde-nachnahme-button").classList.remove("bg-blue-600");
            document.getElementById("versand-kunde-nachnahme-button").classList.add("bg-gray-200");

            document.getElementById("versand-kunde-nachnahme-span").classList.remove("translate-x-5");
            document.getElementById("versand-kunde-nachnahme-span").classList.add("translate-x-0");

            document.getElementById("versand-kunde-input-nachnahme").value = "false";
    }

    function turnOnVersandkundeNachnahme() {

            document.getElementById("versand-kunde-nachnahme-button").classList.add("bg-blue-600");
            document.getElementById("versand-kunde-nachnahme-button").classList.remove("bg-gray-200");

            document.getElementById("versand-kunde-nachnahme-span").classList.add("translate-x-5");
            document.getElementById("versand-kunde-nachnahme-span").classList.remove("translate-x-0");

            document.getElementById("versand-kunde-input-nachnahme").value = "true";
    }

    initializeVersandKunde();
    function initializeVersandKunde() {

      var input2 = document.getElementById('versand-kunde-street');

      var autocomplete2 = new google.maps.places.Autocomplete(input2);

      autocomplete2.addListener('place_changed', function () {

        if(confirm("Soll die Addresse wirklich geändert werden?")) {
            var place2 = autocomplete2.getPlace();

        let types = [];
        let names = [];

        place2.address_components.forEach(comp => {
            types.push(comp.types[0]);
            names.push(comp["long_name"]);
        });

        let counter = 0
        document.getElementById("versand-kunde-street").value = "";
        document.getElementById("versand-kunde-street_number").value = "";
        document.getElementById("versand-kunde-city").value = "";
        document.getElementById("versand-kunde-zipcode").value = "";
        document.getElementById("versand-kunde-country").value = "";
        console.log(types);
        types.forEach(type => {
          let name = names[counter];
          if(type == "route") {
            let street    = name;
            document.getElementById("versand-kunde-street").value = street;
          }
          if(type == "street_number") {
            let number    = name;
            document.getElementById("versand-kunde-street_number").value = number;
          }
          if(type == "postal_town") {
            let city    = name;
            document.getElementById("versand-kunde-city").value = city;
          }
          if(type == "locality") {
            let city    = name;
            document.getElementById("versand-kunde-city").value = city;
          }
          if(type == "postal_code") {
            let zipcode    = name;
            document.getElementById("versand-kunde-zipcode").value = zipcode;
          }
          if(type == "country") {
            let country    = name;
            document.getElementById("versand-kunde-country").value = country;
          }
          counter++;
        });

        } else {
            if(document.getElementById("kundendaten-back-street").value == "") {
                document.getElementById("versand-kunde-street").value = document.getElementById("kundendaten-street").value;

            } else {
                document.getElementById("versand-kunde-street").value = document.getElementById("kundendaten-back-street").value;
            }

        }

});
}

</script>


