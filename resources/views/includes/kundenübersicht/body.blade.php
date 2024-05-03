
<div class="relative @if ($order->sperre != "true") hidden  @endif  z-50" id="sperre-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Auftrag gesperrt!</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">Der Auftrag wurde gesperrt Sie können trotzdem fortfahren.</p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:ml-10 sm:mt-4 sm:flex sm:pl-4">
            <button type="button" onclick="document.getElementById('sperre-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Fortfahren</button>
          </div>
        </div>
      </div>
    </div>
  </div>


<div class="mt-4 border border-gray-300 rounded-md px-4">
    <style>
        .w-45 {
            width: 100%;
        }

        @media (min-width: 1024px) {
            .w-45-lg {
                width: 45%;
            }
        }
    </style>
    <div class="overflow-hidden rounded-lg bg-white py-4 flex">
        <div class=" @isset ($order->devices[0]->component_number) @else w-full @endisset " @isset ($order->devices[0]->component_number) style="width: 45%" @endisset>
            <form id="kundendaten-form" action="{{url("/")}}/crm/auftrag-aktiv/bearbeiten-{{$order->process_id}}/kundendaten-bearbeiten" method="POST">
                @CSRF
        <div class="grid grid-cols-3 gap-2">
            <div class="flex">
                <p class=" font-medium">Rechnungsinformationen</p>
                <button type="button" onclick="getStammdaten('{{$order->process_id}}')" class="ml-2 text-gray-400 hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                      </svg>
                      </button>
            </div>

            <div class="relative col-start-1 col-span-3">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                <input type="text" value="{{$order->company_name}}" name="company_name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <select id="kundendaten-home-gender" name="gender" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                <option value="">Anrede</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
            <script>
                document.getElementById("kundendaten-home-gender").value = "{{$order->gender}}";
            </script>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                <input type="text" @if($order->firstname == null && $order->lastname == null) value="{{$order->company_name}}" @else value="{{$order->firstname}}" @endif name="firstname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                <input type="text" value="{{$order->lastname}}" name="lastname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2 col-span-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                <input type="text" value="{{$order->home_street}}" name="home_street" id="kundendaten-street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Nr</label>
                <input type="text" value="{{$order->home_street_number}}" name="home_street_number" id="kundendaten-street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                <input type="text" value="{{$order->home_zipcode}}" name="home_zipcode" id="kundendaten-zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                <input type="text" value="{{$order->home_city}}" name="home_city" id="kundendaten-city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <select id="kundendaten-country" name="home_country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                <option value="">Land</option>
                @foreach ($countries as $country)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                @endforeach
            </select>
            <script>
                document.getElementById("kundendaten-country").value = "{{$order->home_country}}";
            </script>

            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Email</label>
                <input type="text" value="{{$order->email}}" name="email" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Mobil</label>
                <input type="text" value="{{$order->mobile_number}}" name="mobile_number" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Festnetz</label>
                <input type="text" value="{{$order->phone_number}}" name="phone_number" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2 col-start-1 mb-4">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">IP-Addresse</label>
                <input type="text" value="{{$order->ipadress}}" name="ipadress" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="col-start-1">
                <p class="">Abweichende Lieferaddresse?</p>
            </div>

            <input class="rounded-sm mt-2" name="toggle_diff_address" type="checkbox"@if($order->toggle_diff_address == "on") checked @endif id="kundendaten-abweichende-lieferaddresse-button" onclick="toggleKundendatenAbweichendeAddresse('{{$order->process_id}}')">
            
        </div>
        
        <script>

            function toggleKundendatenAbweichendeAddresse(id) {
                

                toggleAbweichendeAddresse();

                $.get("{{url('/')}}/crm/kundendaten-lieferaddresse-toggle-"+id, function(data) {
                    
                });

            }

        </script>

        <div class="grid grid-cols-3 gap-2 mt-5 pt-0.5 @if($order->toggle_diff_address != "on") hidden @endif" id="kundendaten-abweichende-lieferaddresse">
            <div class="relative col-start-1 col-span-3">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                <input value="{{$order->send_back_company_name}}" type="text" name="send_back_company_name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <select id="kundendaten-send-back-gender"  name="send_back_gender" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                <option value="">Anrede</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
            <script>
                document.getElementById("kundendaten-send-back-gender").value = "{{$order->send_back_gender}}";
            </script>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                <input  value="{{$order->send_back_firstname}}" type="text" name="send_back_firstname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                <input value="{{$order->send_back_lastname}}" type="text" name="send_back_lastname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2 col-span-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                <input value="{{$order->send_back_street}}" type="text" name="send_back_street" id="kundendaten-back-street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Nr</label>
                <input value="{{$order->send_back_street_number}}" type="text" name="send_back_street_number" id="kundendaten-back-street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                <input value="{{$order->send_back_zipcode}}" type="text" name="send_back_zipcode" id="kundendaten-back-zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                <input value="{{$order->send_back_city}}" type="text" name="send_back_city" id="kundendaten-back-city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
            </div>
            <select id="kundendaten-back-country" name="send_back_country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                <option value="">Land</option>
                @foreach ($countries as $country)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                @endforeach
            </select>
            <script>
                document.getElementById("kundendaten-back-country").value = "{{$order->send_back_country}}";
            </script>
        </div>
        <div>
            <button type="submit" onclick="saveAll('{{$order->process_id}}')" style="left: 3.5rem; bottom: 2.5rem;" class="absolute bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium text-sm py-2 px-4">Speichern</button>
            
        </div>
    </form>
    <br>
    <br>
    <br>
        </div>

     
    @isset ($order->devices[0]->component_number)
    <div class="lg:w-0.5 w-0 bg-gray-200 m-auto mt-16" style="height: 30rem">
    </div>

    <form @isset ($order->devices[0]->component_number) style="width: 45%" @endisset action="{{url("/")}}/crm/auftrag-aktiv/bearbeiten-{{$order->devices[0]->component_number}}/beipackzettel-bearbeiten" id="kundendaten-bpz-form" method="POST">
        @CSRF

        <div class="" >
            @if ($order->devices != null)


            <div class="grid grid-cols-3 gap-2">
                <div class="col-start-1 w-64">
                    <p class="float-left font-medium">Fahrzeuginformationen</p>
                    <button onclick="toggleKundendatenFahrzeuginformationen()" id="kundendaten-carinfo" type="button" class="float-right mr-4 @if($order->devices[0]->carinformation_state == false) bg-gray-200 @else bg-blue-600 @endif relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                        <span class="sr-only">Use setting</span>
                        <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                        <span id="kundendaten-carinfo-span" aria-hidden="true" class="@if($order->devices[0]->carinformation_state == false) translate-x-0 @else translate-x-5 @endif pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                    <input type="hidden" name="carinformation_state" id="kundendaten-carinformation-state" value="{{$order->devices[0]->carinformation_state}}">
                </div>

                <div class="relative col-start-1 ">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Automarke</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->car_company}}" @endif name="car_company" id="kundendaten-car_company" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>
                <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Automodell</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->car_model}}" @endif name="car_model" id="kundendaten-car_model" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>
                <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Fahrleistung(PS)</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->ps}}" @endif name="ps" id="kundendaten-ps" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>

                <div class="relative mt-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">FIN/VIN</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->fin}}" @endif name="fin" id="kundendaten-fin" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>
                <div class="relative mt-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Baujahr</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->prod_year}}" @endif name="prod_year" id="kundendaten-prod_year" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>
                <div class="relative mt-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Kilometerstand</label>
                    <input type="text" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->mileage}}" @endif name="mileage" id="kundendaten-mileage" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                </div>
                
                <div class="relative mt-2">

                    <div class="flex -space-x-px">
                        <div class="w-1/2 min-w-0 flex-1">
                          <input type="text" name="hsn" id="kundendaten-hsn" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->hsn}}" @endif class="relative block w-full rounded-none rounded-bl-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6" placeholder="HSN">
                        </div>
                        <div class="flex-1 ">
                            <div class="flex rounded-md shadow-sm">
                                <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                    <input type="text" name="tsn" @if($order->devices[0]->deviceData != null) value="{{$order->devices[0]->deviceData->tsn}}" @endif placeholder="TSN" id="kundendaten-tsn" class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                                </div>

                                <button type="button" onclick="searchHsnTsn(document.getElementById('kundendaten-hsn').value, document.getElementById('kundendaten-tsn').value);" class="relative -ml-px inline-flex items-center rounded-r-md px-1 py-2 text-sm font-semibold text-gray-400 hover:text-blue-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-ml-0.5 h-5 w-5">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                    </svg>                                  
                                </button>
                        </div>
                        </div>
                      </div>
                </div>
                <select id="kundendaten-fueltype" name="fueltype" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    <option value="">Kraftstoffart</option>
                    <option value="Benzin">Benzin</option>
                    <option value="Diesel">Diesel</option>
                </select>
                <script>
                    @if($order->devices[0]->deviceData != null)
                        if("" != "{{$order->devices[0]->deviceData->fueltype}}") {
                            document.getElementById("kundendaten-fueltype").value = "{{$order->devices[0]->deviceData->fueltype}}";
                        }
                    @endif
                </script>
                <select id="kundendaten-circuit" name="circuit" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    <option value="">Getriebe</option>
                    <option value="Automatik">Automatik</option>
                    <option value="Getriebe">Getriebe</option>
                </select>
                <script>
                    @if($order->devices[0]->deviceData != null)
                        if("" != "{{$order->devices[0]->deviceData->circuit}}") {
                            document.getElementById("kundendaten-circuit").value = "{{$order->devices[0]->deviceData->circuit}}";
                        }
                    @endif
                </script>
            </div>

            <div style="margin-top: 8.4rem" id="bpz-edit-div">
                <div class="grid grid-cols-2 gap-2 mt-6">
                    <div class="col-start-1">
                        <div class="w-72 pb-4">
                            <p class="float-left font-medium">Fehlerbeschreibung</p>
                            <button type="button" onclick="toggleKundendatenFehlernachricht()" id="kundendaten-carmessage" class="float-right mr-20 pr-2 bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span id="kundendaten-carmessage-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" id="kundendaten-carmessage-state" name="errormessage_state" >
                        </div>
                        <div class="mt-4">
                            <textarea rows="4" name="errormessage" id="kundendaten-errormessage" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div>
                        <div class="w-48 pb-4">
                            <p class="float-left font-medium">Fehlerspeicher</p>
                            <button type="button" onclick="toggleKundendatenFehlerspeicher()" id="kundendaten-carcache" class="float-right mr-4 bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span id="kundendaten-carcache-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" id="kundendaten-carcache-state" name="errorcache_state" >
                        </div>
                        <div class="mt-4">
                            <textarea rows="4" name="errorcache" id="kundendaten-errorcache" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
    
                    <div class="col-span-2 mt-4">
                        <div class="w-72 pb-4">
                            <p class="float-left font-medium">Hinweis an den Techniker</p>
                            <button type="button" onclick="toggleKundendatenAnTechniker()" id="kundendaten-tecinfo" class="float-right mr-4 bg-gray-200  relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span id="kundendaten-tecinfo-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="tec_info_state" id="kundendaten-tecinfo-state">
                        </div>
                        <div class="mt-4">
                            <textarea rows="4" name="tec_info" id="kundendaten-tec_info" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="bpz-newfile-inp" name="newfile" value="false">
                <input type="hidden" id="firstdevice" value="{{$deviceinfo->component_number}}">
                <input type="hidden" name="process_id" value="{{$deviceinfo->process_id}}">
                <input type="hidden" name="device"  id="kundendaten-selected-device" value="{{$deviceinfo->component_number}}">
                <button class="hidden" type="submit" id="bpz-submit"></button>
                <a target="_blank" href="#" id="bpz-label-get" class="float-right bg-blue-600 hover:bg-blue-400 text-white font-medium px-4 py-2 text-md rounded-md" style="margin-top: 3rem">Beipackzettel aufrufen</a>
            </div>
            @endif
        </div>

    </form>


    @endisset

        

    </div>
</div>

<div id="{{$order->process_id}}">

</div>

  
