<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>

    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <div class="mt-10 px-10">
        <form action="{{url("/")}}/crm/kundenversand-ändern-{{$ausgänge[0]->id}}" method="POST"  enctype="multipart/form-data">
            @CSRF
        <h1 class="text-2xl font-bold">Warenausgang bearbeiten</h1>

        <div class=" ">
            <div class="grid grid-cols-3 col-span-2 mt-20 pt-1 float-left" style="width: 50%">
                <p class="font-semibold text-md">Geräte: </p>
    
                <div class="col-span-2">
                @foreach ($ausgänge as $as)
                    <div class="px-4 py-2 rounded-md border border-gray-300 text-center w-36 float-left ml-4">
                        <p class="text-center text-blue-600 font-medium text-sm">{{$as->component_number}}</p>
                    </div>
                @endforeach
                </div>
                @if ($ausgänge[0]->shortcut == null || $ausgänge[0]->shortcut == "")

                <p class="mt-8 col-start-1">Zusatzartikel</p>
            
            <div class="col-span-2">
                <button class="grid ml-4 mt-8 w-36 float-left" type="button" >
                    <div id="device-div-versand-kunde-gummi" onclick="toggleZusatzartikel('gummi')" class="h-8 w-full px-2 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                        <p class="float-left  text-sm">Gummibärchen</p>
                        <svg id="gummi-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5 ">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>
                    </div>
                    
                </button>
                <button type="button" class="mt-8 grid float-left w-36 ml-4">
                    <div id="device-div-versand-kunde-prot" onclick="toggleZusatzartikel('prot')" class=" w-full h-8 px-1 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                        <p class="float-left text-sm">Spannungsschutz</p>
                        <svg id="prot-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>
                    </div>
                </button>
                
                <button type="button" class=" col-start-2 w-36 grid float-left ml-4 mt-8">
                    <div id="device-div-versand-kunde-seal" onclick="toggleZusatzartikel('seal')" class="h-8 w-full px-2 py-1 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                        <p class="float-left text-sm">Versiegeln</p>
                        <svg id="seal-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>
                    </div>
                </button>
            </div>
            @endif

            @if ($ausgänge[0]->shortcut == null || $ausgänge[0]->shortcut == "")

            <p class="mt-8 col-start-1">Beipackzettel</p>
            <div class="col-span-2">
                <div class="ml-4 mt-8 w-36 float-left">
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 1</label>
                    <select id="location" name="bpz1" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                        @foreach ($bpzs as $bpz)
                            @if ($bpz->name == $ausgänge[0]->bpz1)
                                <option value="{{$bpz->name}}" selected>{{$bpz->name}}</option>
                            @else
                                <option value="{{$bpz->name}}">{{$bpz->name}}</option>
                            @endif
                        @endforeach
                    </select>
                  </div>
                <div class="mt-8 float-left w-36 ml-4">
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Beipackzettel 2</label>
                    <select id="location" name="bpz2" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                        @foreach ($bpzs as $bpz)
                        @if ($bpz->name == $ausgänge[0]->bpz2)
                            <option value="{{$bpz->name}}" selected>{{$bpz->name}}</option>
                        @else
                            <option value="{{$bpz->name}}">{{$bpz->name}}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>
            @endif


            <p class="mt-8  col-start-1">Zusatz / Dokumente</p>
            <div class="mt-8 ml-4" style="width: 19rem">
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

                    @foreach ($ausgänge[0]->file as $file)
                        <div onclick="this.remove()" class="px-4 py-2 rounded-md border border-blue-400 text-blue-400 hover:text-red-400 hover:border-red-400 cursor-pointer mt-2 ">
                            <p class="overflow-hidden text-center">{{$file->filename}}</p>
                            <input type="hidden" name="extrafile-{{$file->id}}" value="{{$file->filename}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="mt-8  col-start-1">Extra Bilder machen</p>
            <button type="button" onclick="toggleVersandkundeExtraPictures()" id="versand-kunde-extrapicture-button" class="ml-4 mt-8 bg-gray-200  relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                <span id="versand-kunde-extrapicture-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>

            <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>
              <textarea name="info" id="" class=" mt-8 rounded-md border border-gray-300 h-16 ml-4 mb-10"  style="width:19rem">{{$ausgänge[0]->info}}</textarea>
            </div>

            <div class="border border-gray-300 w-0.5 float-left" style="height: 35vw"></div>

            <div class="grid grid-cols-3 mt-8 pl-8 gap-4 float-left" style="width:49%" >
                <h1 class="text-lg font-semibold">Versandaddresse</h1>
                
                <div class="relative col-start-1 col-span-3 mt-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                    <input value="{{$ausgänge[0]->companyname}}" type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

                <div>
                    <select id="location" name="gender" class="mt-4 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @switch($ausgänge[0]->gender)
                          @case("Frau")
                                <option value="Frau" selected>Frau</option>
                                <option value="Herr">Herr</option>
                                @break
                          @case("Herr")
                                <option value="Herr" selected>Herr</option>
                                <option value="Frau">Frau</option>
                                @break
                          @default
                          <option value="">Nicht ausgewählt</option>
                          <option value="Frau">Frau</option>
                          <option value="Herr">Herr</option>
                      @endswitch
                    </select>
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                    <input value="{{$ausgänge[0]->firstname}}" type="text" name="firstname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                    <input value="{{$ausgänge[0]->lastname}}" type="text" name="lastname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>  

                <div class="relative mt-4 col-span-2">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                    <input value="{{$ausgänge[0]->street}}" type="text" name="street" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straßennummer</label>
                    <input value="{{$ausgänge[0]->streetno}}" type="text" name="streetno" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                    <input type="text" value="{{$ausgänge[0]->zipcode}}" name="zipcode" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                    <input type="text" value="{{$ausgänge[0]->city}}" name="city" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div>
                    <select id="location" name="country" class="mt-4 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @foreach ($countries as $c)
                          @if ($c->name == $ausgänge[0]->country)
                              <option value="{{$c->name}}" selected>{{$c->name}}</option>
                              @else
                              <option value="{{$c->name}}">{{$c->name}}</option>
                          @endif
                      @endforeach
                    </select>
                </div>

                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Email</label>
                    <input type="text" value="{{$ausgänge[0]->email}}" name="email" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Mobil</label>
                    <input type="text" value="{{$ausgänge[0]->mobilnumber}}" name="mobilnumber" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Festnetz</label>
                    <input type="text" value="{{$ausgänge[0]->phonenumber}}" name="phonenumber" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

                
                

            <div>
                <p class="mt-4 ml-1 float-left">Nachnahme</p>

                <button type="button" onclick="toggleVersandkundeNachnahme()" id="versand-kunde-nachnahme-button" class="mt-5 float-right bg-gray-200 col-start-3 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span id="versand-kunde-nachnahme-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>
            <div class="relative mt-4 rounded-md shadow-sm col-start-2 col-span-2">

                <input type="number" value="{{$ausgänge[0]->nachnahme_betrag}}" oninput="if(parseFloat(this.value.replace('.', ',')) <= 0.00 || this.value == '') { turnOffVersandkundeNachnahme() } else { turnOnVersandkundeNachnahme() }" name="nachnahme_betrag" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nachnahmebetrag">
                <div class="absolute inset-y-0 right-0 flex items-center">
                  <select id="currency" name="nachnahme_currency" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    <option selected>EUR</option>
                  </select>
                </div>
          </div>

          <select id="location" name="carrier" class="mt-4 h-10 block w-full rounded-md border-gray-300 py-1.5 border text-gray-900 sm:text-sm">
            <option>UPS Versand</option>
          </select>

          <div class="col-span-2 mt-4 grid grid-flow-col">
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
          <input type="hidden" name="shippingtype" id="shippingtype-kunde-versand" value="{{$ausgänge[0]->shipping_type}}">
            </div>
        </div>



        <button type="submit" class="float-right  mr-4 mt-16 bg-blue-600 hover:bg-blue-400 rounded-md text-md font-medium text-white px-4 py-2">Speichern</button>

        <a href="{{url("/")}}/crm/packtisch/warenausgang-löschen-{{$ausgänge[0]->id}}" class="float-right  mr-4 mt-16 bg-red-600 hover:bg-red-400 rounded-md text-md font-medium text-white px-4 py-2">Ausgang löschen!</a>
        <input type="hidden" name="gummi" id="versand-kunde-input-gummi" value="{{$ausgänge[0]->gummi}}">
        <input type="hidden" name="prot"  id="versand-kunde-input-prot"  value="{{$ausgänge[0]->protection}}">
        <input type="hidden" name="seal"  id="versand-kunde-input-seal"  value="{{$ausgänge[0]->seal}}">
        <input type="hidden" name="nachnahme" id="versand-kunde-input-nachnahme" value="{{$ausgänge[0]->nachnahme}}">

        <div id="versand-kunde-inputlist">
            @foreach ($ausgänge as $as)
            <input type="hidden" name="device-{{$as->component_number}}" value="{{$as->component_number}}">

            @endforeach
        </div>
        </form>
    </div>

    
  
    
   

    <script>
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

function uploadKundenversandDocuments() {
        let parent = document.getElementById("versand-kunde-files-div");
        let fileCounter = 0;
        Array.from(document.getElementById("versand-kunde-fileinput").files)
          .forEach(parentFile => {
            let button      = document.createElement("div");
            button.classList.add("px-3", "py-2", "rounded-md", 'cursor-pointer' ,"w-full" , "border", "border-blue-400", "hover:border-red-400", "hover:text-red-400", "text-blue-400", "mt-2");
            button.innerHTML = '<p class="overflow-hidden text-center truncate">'+ parentFile["name"] + '</p>';
            button.setAttribute("onclick", "deleteKundenversandFile('"+ parentFile["name"] +"')");
            button.setAttribute("id", "versand-kunde-filebutton-"+ parentFile["name"]);

          

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
            parent.appendChild(button);
            parent.appendChild(name);
            fileCounter++;
        });
    }

    function deleteKundenversandFile(id) {
        document.getElementById("versand-kunde-filebutton-"+id).remove();
        document.getElementById("versand-kunde-fileinput-"+id).remove();
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

    </script>
 @if ($ausgänge[0]->gummi == "true")
 <script>
     toggleZusatzartikel('gummi');
 </script>
@endif

@if ($ausgänge[0]->seal == "true")
 <script>
     toggleZusatzartikel('seal');
 </script>
@endif

@if ($ausgänge[0]->nachnahme == "true")
        <script>
            toggleVersandkundeNachnahme();
        </script>
@endif

@if ($ausgänge[0]->protection == "true")
 <script>
     toggleZusatzartikel('prot');
 </script>
@endif

@if ($ausgänge[0]->fotoauftrag == "true")
<script>
    toggleVersandkundeExtraPictures();
</script>
@endif

@if ($ausgänge[0]->nachnahme == "true")
    <script>
        toggleVersandkundeNachnahme();
    </script>
@endif

<script>
    setShippingKundenversand('{{$ausgänge[0]->shipping_type}}')
</script>
</body>
</html>