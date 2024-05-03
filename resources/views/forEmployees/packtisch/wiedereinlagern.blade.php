<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="js/test.js"></script>
    <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    @vite('resources/js/app.js')


    @vite('resources/css/app.css')
</head> 
<body onload="test(); document.getElementById('barcode-input').focus()">
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <div>
      @include('includes.packtisch.scan-history')
      @include('forEmployees.modals.packtisch.einlagernProblemMelden')
      <form action="{{url("/")}}/crm/packtisch/neues-gerät-einlagern/{{$kunde->process_id}}" method="POST">
        @csrf
        <input type="hidden" id="g-fotos" name="g-fotos" value="off">
        <input type="hidden" id="a-fotos" name="a-fotos" value="off">

        <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Wiedereinlagern</h1>
                        <button type="button" onclick="document.getElementById('problem-melden-modal').classList.remove('hidden')" class="float-right  mt-1 bg-red-400 rounded-md text-white font-semibold px-3 py-1">Problem melden</button>
                      </div>
                    <div class="w-full">
                        <div class="flow-root mt-6">
                        <ul role="list" class="-mb-8">
                          @isset($device->component_number)
                            <input type="hidden" name="componentid" value="{{$device->component_id}}">
                            <input type="hidden" name="componenttype" value="{{$device->component_type}}">
                            <input type="hidden" name="componentcount" value="{{$device->component_count}}">
                            @else
                            <input type="hidden" name="componentid" value="{{$device[0]}}">
                            <input type="hidden" name="componenttype" value="{{$device[1]}}">
                            <input type="hidden" name="componentcount" value="{{$device[2]}}">
                          @endisset

                          <li>
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Auftrag <span class="text-blue-600 font-medium">{{$kunde->process_id}}</span></p>
                                    @isset($device->component_number)
                                        <p class="text-xl text-gray-500 cursor-pointer" onclick="getDeviceDocuments('{{$device->component_number}}', '{{$device->process_id}}')">Aktuelle Gerätenummer <span class="text-blue-600 font-medium">{{$device->component_number}}</span></p>
                                        @else
                                        @if (!is_array($device))
                                        <p class="text-xl text-gray-500 cursor-pointer" onclick="getDeviceDocuments('{{$device}}', '{{$kunde->process_id}}')">Aktuelle Gerätenummer <span class="text-blue-600 font-medium">{{$device}}</span></p>
                                        @else 
                                        <p class="text-xl text-gray-500 cursor-pointer" onclick="getDeviceDocuments('{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}', '{{$kunde->process_id}}')">Aktuelle Gerätenummer <span class="text-blue-600 font-medium">{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}</span></p>
                                        @endif
                                    @endisset
                                    <p class="text-xl text-gray-500">Kunde <span class="text-blue-600 font-medium">{{$kunde->firstname}} {{$kunde->lastname}}</span></p>
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>


                          <li class="" id="step-1">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Barcode scannen</p>
                                    <input id="barcode-input"  name="barcode" onkeypress="checkBarcode(event, this.value)" type="text" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <script>
                            function checkBarcode(e, input) {
                              
                              if(e.keyCode == 13) {
                                e.preventDefault();
                                if(input != '') { 
                                @isset($device->component_number) 
                                  if(input == '{{$device->component_number}}') {

                                  @else 

                                  if(input == '{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}') {
                                  
                                  @endisset 
                                  scanFound(input, "Neues Gerät");
                                  document.getElementById("step-2").classList.remove("hidden");

                                  } else { 

                                    document.getElementById("step-2").classList.add("hidden");
                                    scanNotFound(input, "Neues Gerät");
                                    document.getElementById("barcode-input").value = "";

                                  }
                                }
                            }
                          }

                          function checkShelfe(e, input) {
                              
                              if(e.keyCode == 13) {
                                e.preventDefault();
                                if(input != '') { 
                                  if(input == '{{$shelfe->shelfe_id}}') {

                                 
                                  scanFound(input, "Neues Gerät");
                                  document.getElementById('step-6').classList.remove('hidden');
                                  document.getElementById('einlagern-button').scrollIntoView()
                                  } else { 

                                    document.getElementById('step-6').classList.add('hidden');
                                    scanNotFound(input, "Neuest Gerät");
                                    document.getElementById("lagerplatz-input").value = "";
                                  }
                                }
                            }
                          }
                          
                          </script>

                          <li class="hidden" id="step-2">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class=" min-w-0  pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500 inline-block">Öffnungsspuren?</p>
                                    <div class="inline-block">
                                        <input type="radio" onclick="checkOpen(); newErrorAlert('Alles Fotografieren', 'Bitte Fotografiere im nächsten Punkt auch die besagten Öffnungsspuren!');" value="on" id="opend-yes" name="öffnung" class="w-8 h-8 inline-block ml-8">
                                        <p class="inline-block ml-2 text-xl">Ja</p>
                                        <input type="radio" onclick="checkOpen()" value="off" id="opend-no" name="öffnung" class="w-8 h-8 inline-block ml-4">
                                        <p class="inline-block ml-2 text-xl">Nein</p>
                                    </div>
                                  </div>
                                  <div class=" mt-4">
                                    <p class="text-xl text-gray-500 inline-block">Fremde Kleber?</p>
                                    <div class="inline-block float-right">
                                        <input type="radio" onclick="checkOpen(); newErrorAlert('Alles Fotografieren', 'Bitte Fotografiere im nächsten Punkt auch die besagten Kleber!');" value="on" name="stickers" id="sticker-yes" class="w-8 h-8 inline-block ml-8">
                                        <p class="inline-block ml-2 text-xl">Ja</p>
                                        <input type="radio" onclick="checkOpen()" value="off" name="stickers" id="sticker-no" class="w-8 h-8 inline-block ml-4">
                                        <p class="inline-block ml-2 text-xl">Nein</p>
                                    </div>
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-3">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg id="auftragsdokumente-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-red-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      <svg xmlns="http://www.w3.org/2000/svg" id="auftragsdokumente-svg-not" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white bg-red-600 rounded-full hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500" onclick="showAuftragsnummer('{{$kunde->process_id}}-a')"><span class="font-semibold">Auftragsdokumente</span> abspeichern unter <span class="text-green-600 font-semibold">{{$kunde->process_id}}-a</span></p>
                                    <p class="text-xl font-semibold text-red-400 hidden" id="skip-orderdocs">Auftragsdokumente übersprungen</p>
                                    <button type="button" onclick="document.getElementById('step-4').classList.remove('hidden'); document.getElementById('skip-orderdocs').classList.remove('hidden'); document.getElementById('auftragsdokumente-svg').classList.add('text-red-600'); document.getElementById('auftragsdokumente-svg').classList.remove('text-green-600'); document.getElementById('auftragsdokumente-svg').classList.add('hidden'); document.getElementById('auftragsdokumente-svg-not').classList.remove('hidden')" class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                                    <button type="button" onclick="@isset($device->component_number) getOrderDocuments('{{$device->component_number}}', '{{$kunde->process_id}}') @else getOrderDocuments('{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}', '{{$kunde->process_id}}') @endisset" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-4">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg id="devicedokumente-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-red-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      <svg xmlns="http://www.w3.org/2000/svg" id="devicedokumente-svg-not" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white bg-red-600 rounded-full hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>  
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500" onclick="showAuftragsnummer('{{$kunde->process_id}}-g')"><span class="font-semibold">Gerätefotos</span> abspeichern unter <span class="font-semibold text-green-600">{{$kunde->process_id}}-g</span></p>
                                    <p class="text-xl font-semibold text-red-400 hidden" id="skip-devicedocs">Gerätedokumente übersprungen</p>
                                    <button type="button" onclick="document.getElementById('step-5').classList.remove('hidden'); document.getElementById('skip-devicedocs').classList.remove('hidden'); document.getElementById('devicedokumente-svg').classList.add('text-red-600'); document.getElementById('devicedokumente-svg').classList.remove('text-green-600'); document.getElementById('lagerplatz-input').scrollIntoView();  document.getElementById('lagerplatz-input').focus();  document.getElementById('devicedokumente-svg').classList.add('hidden'); document.getElementById('devicedokumente-svg-not').classList.remove('hidden')" class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                                    <button type="button" onclick="@isset($device->component_number) getDeviceDocuments('{{$device->component_number}}', '{{$kunde->process_id}}') @else getDeviceDocuments('{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}', '{{$kunde->process_id}}') @endisset" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>
                                    <button class="py-1 px-4 rounded-md bg-white text-white font-semibold mt-2">Transportschaden melden</button>

                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-5">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Neuer Lagerplatz <span class="font-semibold text-green-600">{{$shelfe->shelfe_id}}</span></p>
                                    <input type="text" name="shelfe" id="lagerplatz-input" onkeypress="checkShelfe(event, this.value)" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-6">
                            <div class="relative pb-8">
                              <div class="relative flex space-x-3">
                                
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div class="m-auto flex w-full">
                                    <button type="submit" id="einlagern-button" class="text-white font-semibold py-3 rounded-l-md rounded-r-none bg-blue-600 hover:bg-blue-500 text-xl" style="width: 35rem">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white mr-4 inline-block">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                                        </svg>
                                        <p class="inline-block" id="submit-type-text">Gerät wiedereinlagern</p>

                                      </button>
                                      <button type="button" onclick="document.getElementById('einlagern-options').classList.toggle('hidden')" class="float-right py-3 px-8 ml-4 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-r-md rounded-l-none text-xl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                      </svg>
                                      
                                      </button>
                                      <div id="einlagern-options" class="float-right hidden">
                                        <div class="relative i text-left">
                                         
                                        

                                          <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                            <div class="py-1" role="none">
                                              <button type="button" onclick="changeSubmitType('original')" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Weiteres Originalteil</button>
                                              <button type="button" onclick="changeSubmitType('austausch')" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">weiteres Austauschteil</button>
                                              <button type="button" onclick="changeSubmitType('normal')" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">Neues Gerät einlagern</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
                <input type="hidden" name="type" value="normal" id="submit-type-input">
            </div>
        </div>

        

      </form>
    </div>
    <div class="absolute right-16 top-36 h-full hidden" id="side-uploaded-docs">
      <h1 class="text-3xl font-bold mt-2">Hochgeladene Dokumente</h1>

      <div class="mt-8">
        <div onclick="lookupOrderDocs()" id="order-inspect" class="hidden cursor-pointer w-60 px-4 py-2 rounded-md border border-blue-600 text-blue-600 hover:border-blue-400 hover:text-blue-400 flex">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
          </svg>
          <p class="text-center ml-4">Auftragsdokumente</p>
        </div>

        <div onclick="lookupDevicesDocs()"  id="devices-inspect" class="hidden mt-6 cursor-pointer w-60 px-4 py-2 rounded-md border border-blue-600 text-blue-600 hover:border-blue-400 hover:text-blue-400 flex">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
          </svg>
          <p class="text-center ml-4">Gerätedokumente</p>
        </div>
      </div>
    </div>

    <script>
        let currentStepCount = 1;
        function nextStep(){
            document.getElementById("step-"+currentStepCount).classList.remove("hidden");
            document.getElementById('barcode-input').focus();
        }

        function checkOpen() {
            if(document.getElementById("opend-yes").checked || document.getElementById("opend-no").checked){
                if(document.getElementById("sticker-yes").checked || document.getElementById("sticker-no").checked){
                    document.getElementById("step-3").classList.remove("hidden");
            } 
            } 
        }

        function lookupOrderDocs() {
          document.getElementById("device-docs").innerHTML = "";

          let iframe = document.createElement("iframe");
          iframe.src = "{{url("/")}}/files/aufträge/{{$kunde->process_id}}/{{$device->component_number}}-a.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }

        function lookupDevicesDocs() {
          document.getElementById("device-docs").innerHTML = "";
          document.getElementById("side-uploaded-docs").classList.remove('hidden');

          let iframe = document.createElement("iframe");
          iframe.src = "{{url("/")}}/files/aufträge/{{$kunde->process_id}}/{{$device->component_number}}-g.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }

        function getOrderDocuments(device, process_id) {

          $.get("{{url('/')}}/crm/packtisch/check-order-documents/"+process_id, function(data){
                if(data != "no-files") {
                  if(document.getElementById('auftragsdokumente-pdf-viewer')) {
                    document.getElementById('auftragsdokumente-pdf-viewer').remove();

                  }
                  let iframe = document.createElement("iframe");
                  iframe.src = "{{url("/")}}/employee/{{auth()->user()->id}}/" + process_id + "-a.pdf#toolbar=0&navpanes=0&scrollbar=0";
                  iframe.classList.add('m-auto', 'w-full');
                  iframe.style.height = "calc(100vh - 100px)";
                  iframe.setAttribute("id", "auftragsdokumente-pdf-viewer");
                  

                  let parent = document.getElementById("auftragsdokument-pdf");
                  parent.appendChild(iframe);

                  document.getElementById("auftragsdokumente-modal").classList.remove("hidden");
                } else {
                  $.get("{{url("/")}}/crm/packtisch/exist-order-documents/"+process_id+"/"+device, function(data){
                      if(data == "no-files") {
                        document.getElementById('no-files-error').classList.remove('hidden');
                      } else {
                        document.getElementById('auftragsdokumente-pdf-viewer').remove();

                        let iframe = document.createElement("iframe");
                        iframe.src = "{{url("/")}}/files/auftr\u00e4ge/" + process_id + "/"+ device +"-a.pdf#toolbar=0&navpanes=0&scrollbar=0";
                        iframe.classList.add('m-auto', 'w-full');
                        iframe.style.height = "calc(100vh - 100px)";
                        iframe.setAttribute("id", "auftragsdokumente-pdf-viewer");

                        let parent = document.getElementById("auftragsdokument-pdf");
                        parent.appendChild(iframe);

                        document.getElementById("auftragsdokumente-modal").classList.remove("hidden");
                      }
                    });

                }
            });

        }

        function saveOrderDocuments(device) {
            $.get("{{url('/')}}/crm/packtisch/get-order-documents/"+device, function(data){
                document.getElementById("auftragsdokumente-modal").classList.add("hidden");
                document.getElementById("step-4").classList.remove("hidden");
                document.getElementById('skip-orderdocs').classList.add('hidden');
                document.getElementById('auftragsdokumente-svg').classList.remove('text-red-600'); 
                document.getElementById('auftragsdokumente-svg').classList.add('text-green-600')
                document.getElementById('auftragsdokumente-svg').classList.remove('hidden');
                document.getElementById('auftragsdokumente-svg-not').classList.add('hidden');
                document.getElementById("a-fotos").value = "on";

                document.getElementById("side-uploaded-docs").classList.remove('hidden');
                document.getElementById("order-inspect").classList.remove('hidden');
            });
        }


        function getDeviceDocuments(device, process_id) {

          $.get("{{url('/')}}/crm/packtisch/check-device-documents/"+process_id, function(data){
                if(data != "no-files") {
                  if(document.getElementById('devicedokumente-pdf-viewer')) {
                    document.getElementById('devicedokumente-pdf-viewer').remove();
                  }
                  let iframe = document.createElement("iframe");
                  iframe.src = "{{url("/")}}/employee/{{auth()->user()->id}}/" + process_id + "-g.pdf#toolbar=0&navpanes=0&scrollbar=0";
                  iframe.classList.add('m-auto', 'w-full');
                  iframe.style.height = "calc(100vh - 100px)";
                  iframe.setAttribute("id", "devicedokumente-pdf-viewer");

                  let parent = document.getElementById("devicedokumente-pdf");
                  parent.appendChild(iframe);

                  document.getElementById("devicedokumente-modal").classList.remove("hidden");
                } else {
                  document.getElementById('no-files-error-device').classList.remove('hidden');
                }
            });

        }

        function saveDeviceDocuments(device) {
            $.get("{{url('/')}}/crm/packtisch/get-device-documents/"+device, function(data){
                document.getElementById("devicedokumente-modal").classList.add("hidden");
                document.getElementById("step-5").classList.remove("hidden");
                
                document.getElementById('devicedokumente-svg').classList.remove('text-red-600'); 
                document.getElementById('devicedokumente-svg').classList.add('text-green-600');

                document.getElementById('skip-devicedocs').classList.add('hidden');

                document.getElementById('devicedokumente-svg').classList.remove('hidden');
                document.getElementById('devicedokumente-svg-not').classList.add('hidden');

                document.getElementById('lagerplatz-input').scrollIntoView();
                document.getElementById('lagerplatz-input').focus();
                document.getElementById("g-fotos").value = "on";

                document.getElementById("devices-inspect").classList.remove('hidden');
                document.getElementById("side-uploaded-docs").classList.remove('hidden');
            });
        }

        function changeSubmitType(type) {
          if(type == "austausch") {
            document.getElementById('submit-type-text').innerHTML = "Weiteres Austauschteil einlagern";
            document.getElementById('submit-type-input').value = "austausch";
          }
          if(type == "original") {
            document.getElementById('submit-type-text').innerHTML = "Weiteres Originalteil einlagern";
            document.getElementById('submit-type-input').value = "original";
          }
          if(type == "normal") {
            document.getElementById('submit-type-text').innerHTML = "Neues Ger"+unescape("%E4")+"t einlagern";
            document.getElementById('submit-type-input').value = "normal";
          }
          document.getElementById('einlagern-options').classList.add('hidden');

        }

        function getDeviceDocuments(device, process_id) {
      loadData();
               if(document.getElementById('devicedokumente')) {
                document.getElementById('devicedokumente').remove();
               }
               $.get("{{url('/')}}/crm/packtisch/get-device-documents/"+device, function(data){
                     if(data != "no-files") {

                       let iframe = document.createElement("iframe");
                       iframe.src = "{{url('/')}}/files/auftr\u00e4ge/"+process_id+"/"+device+"-g.pdf#toolbar=0&navpanes=0&scrollbar=0";
                       iframe.classList.add('m-auto', 'w-full');
                       iframe.style.height = "49rem";
                       iframe.setAttribute("id", "devicedokumente");
               
                       let parent = document.getElementById("device-documents-div");
                       parent.appendChild(iframe);
               
                       document.getElementById("device-documents-modal").classList.remove("hidden");
                     } else {
                      document.getElementById('error-files-modal').classList.remove('hidden');
                    }
                    savedPOST();
                 });
               
               }
    </script>
    @include('forEmployees.modals.newDeviceCheckAuftragsDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles')

    @include('forEmployees.modals.newDeviceCheckDeviceDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles-device')

    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    @include('forEmployees.modals.packtisch.geräteNummer')


    <div id="printJS-form" class=" hidden" style="transform: rotate(270deg); margin-top: 20rem">
      <svg id="barcodee" class="" style="transform: rotate(270deg);"></svg>
  </div>
<script>
function test() {
  var element = document.getElementById("barcodee");
  JsBarcode(element, "@isset($device->component_number) {{$device->component_number}} @else {{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}} @endisset", {
      height: 60,
      fontSize: 20,
      width: 2.5,
      textMargin: -2,
      text: "@isset($device->component_number) {{$device->component_number}} @else {{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}} @endisset"
      

  });
}
</script>

<div class="relative hidden z-10" id="lookup-device-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6" style="height:50rem;">
        <div class="w-full pb-4">
          <button type="button" onclick="document.getElementById('lookup-device-modal').classList.add('hidden')" class="float-right text-red-600 hover:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        <div id="device-docs" class="mt-6">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="relative z-10 hidden" id="device-documents-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5" style="height: 55rem;">
            <div id="device-documents-div">
              
            </div>
            <div class="mt-5 sm:mt-6">
              <button type="button" onclick="document.getElementById('device-documents-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Zurück</button>
            </div>
          </div>
        </div>
      </div>
    </div>

</body>
</html>