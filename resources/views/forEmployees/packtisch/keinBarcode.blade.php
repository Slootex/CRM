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
<body>
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <div>
      <form action="{{url("/")}}/crm/packtisch/unbekanntes-gerät-einlagern/{{$barcode}}" method="POST">
        @csrf
        <input type="hidden" id="g-fotos" name="g-fotos" value="off">
        <input type="hidden" id="a-fotos" name="a-fotos" value="off">
        @include('includes.packtisch.scan-history')

        <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Unbekanntes Gerät einlagern</h1>
                      </div>
                    <div class="w-full">
                        <div class="flow-root mt-6">
                        <ul role="list" class="-mb-8">



                          <li >
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
                                    <button type="button" onclick="printJS('printJS-form', 'html'); nextStep()">
                                        <p class="inline-block text-xl text-gray-500">Barcode drucken</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 inline-block text-white rounded-full bg-green-600 ml-4 p-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                      </svg>  
                                    </button>                                    
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-1">
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
                                    <p class="text-xl text-gray-500">Barcode scannen (<span class="text-green-600 font-semibold">{{$barcode}}</span>)</p>
                                    <input id="barcode-input" name="barcode" onkeypress="checkBarcode(event, this.value)" type="text" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

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
                                    <p class="text-xl text-gray-500" onclick="showAuftragsnummer('{{$kunde->process_id}}-a')"><span class="font-semibold">Auftragsdokumente</span> abspeichern unter <span class="text-green-600 font-semibold">{{$barcode}}-a</span></p>
                                    <p class="text-xl font-normal text-red-600 hidden" id="skip-orderdocs">Auftragsdokumente übersprungen</p>
                                    <button type="button" onclick="document.getElementById('step-4').classList.remove('hidden'); document.getElementById('skip-orderdocs').classList.remove('hidden');  document.getElementById('auftragsdokumente-svg').classList.add('text-red-600'); document.getElementById('auftragsdokumente-svg').classList.remove('text-green-600'); document.getElementById('auftragsdokumente-svg').classList.add('hidden'); document.getElementById('auftragsdokumente-svg-not').classList.remove('hidden')" class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                                    <button type="button" onclick="@isset($device->component_number) getOrderDocuments('{{$device->component_number}}', '{{$barcode}}') @else getOrderDocuments('{{$barcode}}', '{{$barcode}}') @endisset" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>
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
                                    <svg id="devicedokumente-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-10 h-10 text-green-600 hidden">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      <svg xmlns="http://www.w3.org/2000/svg" id="devicedokumente-svg-not" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white bg-red-600 rounded-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>  
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500" onclick="showAuftragsnummer('{{$kunde->process_id}}-g')"><span class="font-semibold">Gerätefotos</span> abspeichern unter <span class="font-semibold text-green-600">{{$barcode}}-g</span></p>
                                    <p class="text-xl font-normal text-red-600 hidden" id="skip-devicedocs">Gerätedokumente übersprungen</p>
                                    <button type="button" onclick="document.getElementById('step-5').classList.remove('hidden'); document.getElementById('skip-devicedocs').classList.remove('hidden'); document.getElementById('devicedokumente-svg').classList.add('text-red-600'); document.getElementById('devicedokumente-svg').classList.remove('text-green-600'); document.getElementById('lagerplatz-input').scrollIntoView();  document.getElementById('lagerplatz-input').focus();  document.getElementById('devicedokumente-svg').classList.add('hidden'); document.getElementById('devicedokumente-svg-not').classList.remove('hidden')" class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                                    <button type="button" onclick="@isset($device->component_number) getDeviceDocuments('{{$device->component_number}}', '{{$barcode}}') @else getDeviceDocuments('{{$barcode}}', '{{$barcode}}') @endisset" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>
                                    <button class="py-1 px-4 rounded-md bg-white text-white font-semibold mt-2 3xl:ml-4">Transportschaden melden</button>
                                    <style>
                                      @media (min-width: 2000px) {
                                      .\33xl\:ml-4 {
                                          margin-left: 1rem/* 16px */;
                                      }
                                  }
                                    </style>
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
                                  <div class="m-auto w-full">
                                    <button type="submit" id="einlagern-button" class="text-white inline-block font-semibold py-3 rounded-md bg-blue-600 hover:bg-blue-500 text-xl" style="width: 35rem">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white mr-4 inline-block">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                                        </svg>
                                        <p class="inline-block" id="submit-type-text">Unbekanntes Gerät einlagern</p>

                                      </button>
                                      
                                     
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


    @include('forEmployees.modals.packtisch.geräteNummer')

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
          iframe.src = "{{url("/")}}/files/aufträge/{{$barcode}}/{{$barcode}}-a.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }

        function lookupDevicesDocs() {
          document.getElementById("device-docs").innerHTML = "";
          document.getElementById("side-uploaded-docs").classList.remove('hidden');

          let iframe = document.createElement("iframe");
          iframe.src = "{{url("/")}}/files/aufträge/{{$barcode}}/{{$barcode}}-g.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }


        function checkBarcode(e, inp) {
          
          if(e.keyCode == 13) {
            e.preventDefault();
            if(inp != '') {  
            @isset($device->component_number) 

            if(inp == '{{$device->component_number}}') {
            
            @else 
            
            if(inp == '{{$barcode}}') {
            
            @endisset 
            
            document.getElementById('step-2').classList.remove('hidden'); 
            scanFound(inp, "Kein Barcode");
            }else { 
            document.getElementById('step-2').classList.add('hidden'); 
            scanNotFound(inp, "Kein Barcode");
            document.getElementById("barcode-input").value = "";
           
          }   
          }
          }
        }

        function checkShelfe(e, inp) {
          
          if(e.keyCode == 13) {
            e.preventDefault();
            if(inp != '') {  

            if(inp == '{{$shelfe->shelfe_id}}')  {
        
            
            document.getElementById('step-6').classList.remove('hidden');
            document.getElementById("step-6").scrollIntoView();
            scanFound(inp, "Kein Barcode");
          }   else { 
            document.getElementById('step-6').classList.add('hidden'); 
            scanNotFound(inp, "Kein Barcode");
            document.getElementById("lagerplatz-input").value = "";

          }
          }
        }
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
                  document.getElementById('no-files-error').classList.remove('hidden');
                }
            });

        }

        function saveOrderDocuments(device) {
            $.get("{{url('/')}}/crm/packtisch/get-order-documents/"+device, function(data){
                document.getElementById("auftragsdokumente-modal").classList.add("hidden");
                document.getElementById("step-4").classList.remove("hidden");

                document.getElementById('skip-orderdocs').classList.add('hidden');

                document.getElementById('auftragsdokumente-svg').classList.remove('hidden');
                document.getElementById('auftragsdokumente-svg-not').classList.add('hidden');

                document.getElementById('auftragsdokumente-svg').classList.remove('text-red-600'); 
                document.getElementById('auftragsdokumente-svg').classList.add('text-green-600');
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
                  iframe.src = "{{url("/")}}/employee/{{auth()->user()->id}}/" + process_id + "-a.pdf#toolbar=0&navpanes=0&scrollbar=0";
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
                document.getElementById("step-4").classList.remove("hidden");

                document.getElementById('skip-devicedocs').classList.add('hidden');
                
                document.getElementById('devicedokumente-svg').classList.remove('text-red-600'); 
                document.getElementById('devicedokumente-svg').classList.add('text-green-600');

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
    </script>

<div id="printJS-form" class=" hidden" style="transform: rotate(270deg); margin-top: 20rem">
  <svg id="barcodee" class="" style="transform: rotate(270deg);"></svg>
</div>

<script>
  function test() {
  var element = document.getElementById("barcodee");
  JsBarcode(element, "{{$barcode}}", {
      height: 60,
      fontSize: 20,
      width: 2.5,
      textMargin: -2,
      text: "{{$barcode}}"
      

  });
}
test()
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

@include('forEmployees.modals.newDeviceCheckAuftragsDokumente')
@include('forEmployees.modals.errors.packtisch.noFiles')

@include('forEmployees.modals.newDeviceCheckDeviceDokumente')
@include('forEmployees.modals.errors.packtisch.noFiles-device')


</body>
</html>