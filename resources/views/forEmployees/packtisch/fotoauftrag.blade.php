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
<body onload="document.getElementById('barcode').focus()">
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    <div>
      <form action="{{url("/")}}/crm/packtisch/fotoauftrag-abschließen/{{$intern->id}}" method="POST">
        @csrf
        @include('includes.packtisch.scan-history')
        <input type="hidden" id="g-fotos" name="g-fotos" value="off">

        <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
          @if ($intern->info != "")
          <div class="w-full px-8">
            <div class="m-auto bg-red-100 rounded-md mt-6 px-4 py-2 w-full">
              <p class="text-2xl text-red-800">{{$intern->info}}</p>
            </div>
          </div>
        @endif
            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Fotoauftrag</h1>
                        <button type="button" onclick="document.getElementById('problem-melden-modal').classList.remove('hidden')" class="float-right  mt-1 bg-red-400 rounded-md text-white font-semibold px-3 py-1">Problem melden</button>
                      </div>
                    <div class="w-full">
                        <div class="flow-root mt-6">
                        <ul role="list" class="-mb-8">


                          <li class="" id="step-2">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="barcode-no"  fill="currentColor" class="w-10 h-10 text-red-600">
                                      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                    </svg>
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="barcode-ok" class="w-10 h-10 text-green-600 hidden">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Aktueller Lagerplatz <span class="font-semibold text-green-600">{{$shelfe->shelfe_id}}</span></p>
                                    <p class="text-xl text-gray-500">Aktueller Barcode <span class="font-semibold text-green-600">{{$shelfe->component_number}}</span></p>
                                    <input id="barcode" name="barcode" onkeypress="checkBarcode(event, this.value)" type="text" class="mt-2 rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-3">
                            <div class="relative ">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    <svg id="devicedokumente-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-10 h-10 text-red-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      <svg xmlns="http://www.w3.org/2000/svg" id="devicedokumente-svg-not" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white bg-red-600 rounded-full hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>  
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500" onclick="showAuftragsnummer('{{$intern->process_id}}-g')"><span class="font-semibold">Gerätefotos</span> abspeichern unter <span class="font-semibold text-green-600">{{$intern->process_id}}-g</span></p>
                                    <p class="text-xl font-semibold text-red-400 hidden" id="skip-devicedocs">Gerätedokumente übersprungen</p>
                                    <button type="button" onclick="document.getElementById('step-4').classList.remove('hidden'); document.getElementById('skip-devicedocs').classList.remove('hidden'); document.getElementById('devicedokumente-svg').classList.add('text-red-600'); document.getElementById('devicedokumente-svg').classList.remove('text-green-600'); document.getElementById('new-shelfe').scrollIntoView();  document.getElementById('new-shelfe').focus();  document.getElementById('devicedokumente-svg').classList.add('hidden'); document.getElementById('devicedokumente-svg-not').classList.remove('hidden'); document.getElementById('new-shelfe').focus(); " class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                                    <button type="button" onclick="@isset($intern->component_number) getDeviceDocuments('{{$intern->component_number}}', '{{$intern->process_id}}') @else getDeviceDocuments('{{$intern->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}', '{{$kunde->process_id}}') @endisset" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>

                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden mt-10" id="step-4">
                            <div class="relative pb-8">
                              <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                              <div class="relative flex space-x-3">
                                <div>
                                  <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="shelfe-no"  fill="currentColor" class="w-10 h-10 text-red-600">
                                      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="shelfe-ok" class="w-10 h-10 text-green-600 hidden">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Neuer Lagerplatz <span class="font-semibold text-green-600">{{$shelfe->shelfe_id}}</span></p>
                                    <input type="text" name="shelfe" id="new-shelfe" onkeypress="checkNewShelfe(event, this.value)" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="hidden" id="step-5">
                            <div class="relative pb-8">
                              <div class="relative flex space-x-3">
                                
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div class="m-auto w-full">
                                    <button type="submit" id="einlagern-button" class="text-white inline-block font-semibold py-3 rounded-md bg-blue-600 hover:bg-blue-500 text-xl" style="width: 35rem">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white mr-4 inline-block">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                                        </svg>
                                        <p class="inline-block" id="submit-type-text">Fertig, fotografiert</p>
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


    <script>

        function lookupOrderDocs() {
          document.getElementById("device-docs").innerHTML = "";

          let iframe = document.createElement("iframe");
          iframe.src = "{{url("/")}}/files/aufträge/{{$intern->process_id}}/{{$intern->component_number}}-a.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }

        function lookupDevicesDocs() {
          document.getElementById("device-docs").innerHTML = "";
          document.getElementById("side-uploaded-docs").classList.remove('hidden');

          let iframe = document.createElement("iframe");
          iframe.src = "{{url("/")}}/files/aufträge/{{$intern->process_id}}/{{$intern->component_number}}-g.pdf";
          iframe.classList.add("w-full", "h-full", "mt-6");
          iframe.style.height = "45rem";

          document.getElementById("device-docs").appendChild(iframe);
          document.getElementById("lookup-device-modal").classList.remove("hidden");
        }


        function checkNewShelfe(e, inp) {
          if(e.keyCode == 13) {
            e.preventDefault();
            if(inp != '') { 
            
            if(inp == '{{$shelfe->shelfe_id}}') {
              
              document.getElementById('step-5').classList.remove('hidden'); 
              document.getElementById('einlagern-button').scrollIntoView()  
              document.getElementById("shelfe-no").classList.add("hidden");
            document.getElementById("shelfe-ok").classList.remove("hidden");
            scanFound(inp, "Fotoauftrag");
            } else {
              document.getElementById("new-shelfe").value = "";
              scanNotFound(inp, "Fotoauftrag");
            }
          } else {  

            document.getElementById('step-5').classList.add('hidden') 
          }
          }
        }


        function checkBarcode(e, inp) {
          if(e.keyCode == 13) {
            e.preventDefault();
          if(inp != '') { 
            if(inp == '{{$intern->component_number}}') {
            
            
            document.getElementById('step-3').classList.remove('hidden') 
            document.getElementById("barcode-no").classList.add("hidden");
            document.getElementById("barcode-ok").classList.remove("hidden");
            scanFound(inp, "Fotoauftrag");

          }   else { 
            document.getElementById('step-3').classList.add('hidden') 
            document.getElementById("barcode").value = "";
            scanNotFound(inp, "Fotoauftrag");

          }
        } else {
          document.getElementById("barcode").value = "";

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
            $.get("{{url('/')}}/crm/packtisch/get-devicedokumente-documents/"+device, function(data){
                document.getElementById("devicedokumente-modal").classList.add("hidden");
                document.getElementById("step-4").classList.remove("hidden");

                document.getElementById("new-shelfe").focus();
            });
        }


        function getDeviceDocuments(device, process_id) {

          $.get("{{url('/')}}/crm/packtisch/check-device-documents/"+process_id, function(data){
            console.log(data);
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
                document.getElementById("step-4").classList.remove("hidden");

                document.getElementById('devicedokumente-svg').classList.remove('text-red-600'); 
                document.getElementById('devicedokumente-svg').classList.add('text-green-600')

                document.getElementById('new-shelfe').scrollIntoView();
                document.getElementById('new-shelfe').focus();

                document.getElementById("g-fotos").value = "on";
                document.getElementById("devices-inspect").classList.remove('hidden');
                document.getElementById("side-uploaded-docs").classList.remove('hidden');
            });
        }
    </script>
    @include('forEmployees.modals.newDeviceCheckAuftragsDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles')

    @include('forEmployees.modals.newDeviceCheckDeviceDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles-device')

    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    @include('forEmployees.modals.packtisch.geräteNummer')


    <div class="relative hidden z-10" id="lookup-device-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6" style="height:50rem;">
            <div class="w-full">
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
</body>
</html>