<!DOCTYPE html>
<html lang="en" class="bg-white">
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
<body onload="document.getElementById('barcode-input').focus()" onclick="document.getElementById('barcode-input').focus()">
    <script>
        var barcodes = [];
    </script>
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    <div class="flex">
      <div class="float-right mt-10">
        @include('includes.packtisch.scan-history')
      </div>

      <div style="width: 40%" class=" h-60 rounded-md bg-white m-auto mt-10 p-4">
        @if ($ausgänge[0]->info != "")
        <div class="m-auto bg-red-100 rounded-md  px-4 py-2 w-full mb-4">
          <p class="text-2xl text-red-800">{{$ausgänge[0]->info}}</p>
        </div>
      @endif
          <div class="w-full">
              <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Warenausgang Techniker</h1>
              <button type="button" onclick="document.getElementById('problem-melden-modal').classList.remove('hidden')" class="float-right  mt-1 bg-red-400 rounded-md text-white font-semibold px-3 py-1">Problem melden</button>
            </div>
          <div class="w-60 m-auto mt-16">
              <input onkeypress="checkCode(event, this.value)" onload="this.focus()" id="barcode-input" type="text" class="w-60 h-12 rounded-md border border-gray-600 text-xl text-center bg-green-50">
              <h1 class="text-center font-semibold text-2xl text-blue-600 ml-2">Barcode scannen</h1>
          </div>
      </div>
    </div>
    <form action="{{url("/")}}/crm/shipping/new/{{$ausgänge[0]->shortcut}}/tec/tec" method="POST">
      @CSRF

      <div id="foto-inputs-div">

      </div>

    <script>
        let protCounter = 0;
        let gummiCounter = 0;
        var bpzs = [];
        let bpzCounter = 0;
        var scanMin = 0;
        var scanCounter = 0;
        let usedBarcodes = [];
        function checkCode(e, input) {
          var currentScans = scanCounter;
           if(e.keyCode == 13) {
            if(barcodes.includes(input) && !usedBarcodes.includes(input)){
                document.getElementById(input).classList.remove('text-red-600');
                document.getElementById(input).classList.add('text-green-600');
                document.getElementById('barcode-input').focus();
                scanCounter++
                usedBarcodes.push(input);
            } 

            if(bpzs.includes(input)) {
                if(document.getElementById(barcodes[bpzCounter] + '-' + input)) {
                    document.getElementById(barcodes[bpzCounter] + '-' + input).classList.remove("text-red-600");
                    document.getElementById(barcodes[bpzCounter] + '-' + input).classList.add("text-green-600");
                    document.getElementById('barcode-input').focus();
                    scanCounter++
                    bpzCounter++;
                } else {
                    bpzCounter = 333;
                }
            }
            if(scanCounter >= scanMin) {
                document.getElementById('last-step').classList.remove('hidden');
            }

            if(scanCounter == currentScans) {
              scanNotFound(input, "Versand Techniker");
              document.getElementById("barcode-input").value = "";
            } else {
              scanFound(input, "Versand Techniker");
            }

            document.getElementById('barcode-input').value = "";
           }
        }
    </script>
    <div style="width: 40%" class=" rounded-md bg-white m-auto mt-10 p-4">

        <div class="w-full">
            <div class="flow-root -mt-8">
            <ul role="list" class="mb-8">
                @foreach ($ausgänge as $ausgang)
                <script>
                    barcodes.push('{{$ausgang->component_number}}');
                    scanMin++;
                </script>
                <li class="mt-10">
                    <div class="relative pb-2">
                      <span class="absolute ml-4 top-6  h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg id="{{$ausgang->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 text-red-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                              </svg>
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-0.5">
                          <div>
                            <button type="button" onclick="getDeviceDocuments('{{$ausgang->component_number}}', '{{$ausgang->process_id}}')" class="inline-block text-xl">Gerätenummer <span class="font-medium text-blue-600">{{$ausgang->component_number}}</span></button>    
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 inline-block ml-6 -mt-1">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <p class="inline-block ml-2 text-xl">Lager <span class="font-medium text-blue-600">{{$ausgang->shelfe->shelfe_id}}</span></p>                                                        
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <script>
                    scanMin++;
                  </script>
                  <li >
                    <div class="relative pb-1">
                      <span class="absolute top-6 ml-4 h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg id="{{$ausgang->component_number}}-label" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 text-red-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                              </svg>
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-0.5">
                          <div>
                            <a target="_blank" onclick="document.getElementById('{{$ausgang->component_number}}-label').classList.remove('text-red-600'); document.getElementById('{{$ausgang->component_number}}-label').classList.add('text-green-600'); scanCounter++; checkCounter()" type="button" href="{{url("/")}}/crm/label/get/{{$ausgang->process_id}}/{{$ausgang->shortcut}}">
                              <p class="inline-block text-xl text-gray-500">Label drucken</p>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 inline-block text-white rounded-full bg-green-600 ml-4 p-1">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>  
                          </a>  
                          </div>
                          
                         
                        </div>
                      </div>
                    </div>
                  </li>


                  @isset($ausgang->fotoauftrag)
                  <script>
                    scanMin++;
                  </script>
                  <li >
                    <div class="relative pb-1">
                      <span class="absolute top-6 ml-4 h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg id="fotoauftrag-ok-{{$ausgang->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 text-red-600">
                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="fotoauftrag-no-{{$ausgang->component_number}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-white bg-red-600 rounded-full hidden">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>     
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-0.5">
                          <div>
                            <p class="text-xl text-gray-500"><span class="font-semibold">Gerätefotos</span> abspeichern unter <span class="font-semibold text-green-600">{{$ausgang->process_id}}-g</span></p>
                            <p class="text-xl text-red-500 hidden" id="skip-fotoauftrag-{{$ausgang->component_number}}">Gerätefotos übersprungen</p>
                            <button type="button" onclick="document.getElementById('skip-fotoauftrag-{{$ausgang->component_number}}').classList.remove('hidden'); document.getElementById('fotoauftrag-no-{{$ausgang->component_number}}').classList.remove('hidden'); document.getElementById('fotoauftrag-ok-{{$ausgang->component_number}}').classList.add('hidden');  scanCounter++;  checkCounter();" class="py-1 px-4 rounded-md bg-red-600 text-white font-semibold inline-block mt-2">Ohne Dokumente fortfahren!</button>
                            <button type="button" onclick="getDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}('{{$ausgang->component_number}}', '{{$ausgang->process_id}}')" class="py-1 px-4 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold inline-block ml-4 mt-2">Dokumente hochladen -></button>

                          </div>
                          
                         
                        </div>
                      </div>
                    </div>
                  </li>


                  

                  <script>

                    function checkCounter() {
                      if(scanCounter >= scanMin) {
                document.getElementById('last-step').classList.remove('hidden');
            }
                    }

                    function getDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}(device, process_id) {
               
               $.get("{{url('/')}}/crm/packtisch/check-device-documents/"+process_id, function(data){
                     if(data != "no-files") {
                       if(document.getElementById('devicedokumente-pdf-viewer{{$ausgang->process_id . $ausgang->component_id}}')) {
                         document.getElementById('devicedokumente-pdf-viewer{{$ausgang->process_id . $ausgang->component_id}}').remove();
                       }
                       let iframe = document.createElement("iframe");
                       iframe.src = "{{url("/")}}/employee/{{auth()->user()->id}}/" + process_id + "-g.pdf#toolbar=0&navpanes=0&scrollbar=0";
                       iframe.classList.add('m-auto', 'w-full');
                       iframe.style.height = "calc(100vh - 100px)";
                       iframe.setAttribute("id", "devicedokumente-pdf-viewer{{$ausgang->process_id . $ausgang->component_id}}");
               
                       let parent = document.getElementById("devicedokumente-pdf{{$ausgang->process_id . $ausgang->component_id}}");
                       parent.appendChild(iframe);
               
                       document.getElementById("devicedokumente-modal{{$ausgang->process_id . $ausgang->component_id}}").classList.remove("hidden");
                     } else {
                       document.getElementById('no-files-error-device{{$ausgang->process_id . $ausgang->component_id}}').classList.remove('hidden');
                     }
                 });
               
               }
               
               function saveDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}(device) {
                 $.get("{{url('/')}}/crm/packtisch/get-device-documents/{{$ausgang->component_number}}", function(data){
                     document.getElementById("devicedokumente-modal{{$ausgang->process_id . $ausgang->component_id}}").classList.add("hidden");
                     scanCounter++
                     document.getElementById('fotoauftrag-no-{{$ausgang->component_number}}').classList.add('hidden');
                      document.getElementById('fotoauftrag-ok-{{$ausgang->component_number}}').classList.remove('hidden', 'text-red-600');
                      document.getElementById('fotoauftrag-ok-{{$ausgang->component_number}}').classList.add('text-green-600');
                      document.getElementById('skip-fotoauftrag-{{$ausgang->component_number}}').classList.add('hidden');

                      let div = document.createElement("div");
                      div.innerHTML = '<div onclick="lookupDeviceDocs('+"'" + "{{$ausgang->component_number}}" + "'"+')" class="mt-6 cursor-pointer w-60 px-4 py-2 rounded-md border border-blue-600 text-blue-600 hover:border-blue-400 hover:text-blue-400 flex"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" /></svg><p class="text-center ml-4">'+"{{$ausgang->component_number}}"+'</p></div>'

                      if(!document.getElementById("foto-{{$ausgang->component_number}}")) {
                        let input = document.createElement("input");
                        input.value = "on";
                        input.type = "hidden";
                        input.name = "foto-{{$ausgang->component_number}}";
                        input.id = "foto-{{$ausgang->component_number}}";

                        document.getElementById("foto-inputs-div").appendChild(input);
                      } else {
                        document.getElementById("foto-{{$ausgang->component_number}}").value = "on";
                      }

                      document.getElementById("uploaded-docs").appendChild(div);

                      document.getElementById("side-uploaded-docs").classList.remove('hidden');

                     if(scanCounter >= scanMin) {
                document.getElementById('last-step').classList.remove('hidden');
            }
                 });
               }

               function lookupDeviceDocs(device) {
                  document.getElementById("device-docs").innerHTML = "";

                  let iframe = document.createElement("iframe");
                  iframe.src = "{{url("/")}}/files/aufträge/{{$ausgänge[0]->process_id}}/"+ device +"-g.pdf";
                  iframe.classList.add("w-full", "h-full", "mt-6");
                  iframe.style.height = "45rem";


                  document.getElementById("device-docs").appendChild(iframe);
                  document.getElementById("lookup-device-modal").classList.remove("hidden");
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
               
               <div class="relative hidden z-10" id="no-files-error-device{{$ausgang->process_id . $ausgang->component_id}}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                  <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                      <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                          <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                          </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                          <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Keine Dateien gefunden</h3>
                          <div class="mt-2">
                            <p class="text-sm text-gray-500">Das System konnte keine Hochgeladenen Dateien unter der folgenden Namen finden: <span class="text-red-600 font-semibold">{{$ausgang->process_id}}-g.pdf</span></p>
                          </div>
                        </div>
                      </div>
                      <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        @isset($barcode)
                          <button type="button" onclick="document.getElementById('no-files-error-device{{$ausgang->process_id . $ausgang->component_id}}').classList.add('hidden');  getDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}('{{$ausgang->process_id}}', '{{$ausgang->process_id}}')"  class="mt-3 inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white ml-4 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">erneut Laden</button>
                        @else
                          <button type="button" onclick="document.getElementById('no-files-error-device{{$ausgang->process_id . $ausgang->component_id}}').classList.add('hidden');  getDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}('{{$ausgang->component_number}}', '{{$ausgang->process_id}}')"  class="mt-3 inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white ml-4 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">erneut Laden</button>
                        @endisset
                        <button type="button" onclick="document.getElementById('no-files-error-device{{$ausgang->process_id . $ausgang->component_id}}').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Zurück</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

               <div class="relative hidden z-10" id="devicedokumente-modal{{$ausgang->process_id . $ausgang->component_id}}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                   <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                   <div class="fixed inset-0 z-10 overflow-y-auto">
                     <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                       <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6" style="height: 70%">
                         <div>
                           <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                             <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                             </svg>
                           </div>
                           <div class="mt-3 text-center sm:mt-5">
                             <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Datei Erfolgreich hochgeladen</h3>
                             <div class="mt-2">
                               <p class="text-sm text-gray-500">Bitte Dokumente vor bestätigung überprüfen</p>
                             </div>
                             <div class="w-full h-full mt-4" id="devicedokumente-pdf{{$ausgang->process_id . $ausgang->component_id}}">
               
                             </div>
                           </div>
                         </div>
                         <div class="mt-5 sm:mt-6">
                             <button type="button" onclick="saveDeviceDocuments{{$ausgang->process_id . $ausgang->component_id}}('{{$ausgang->process_id}}', '{{$ausgang->process_id}}')" class="float-left px-6 py-3 rounded-md bg-green-600 text-xl text-white font-semibold">Bestätigen</button>
                           <button type="button" onclick="document.getElementById('devicedokumente-modal{{$ausgang->process_id . $ausgang->component_id}}').classList.add('hidden')" class="float-right px-6 py-3 rounded-md bg-white text-xl text-black border border-gray-600 font-semibold">Ohne Änderungen zurück</button>
               
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>



                  @endisset
                @endforeach

                @isset($ausgänge[0]->file)
                
                <li>
                  <div class="relative pb-1">
                    <span class="absolute top-6 ml-4 h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    <div class="relative flex space-x-3">
                      <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-0.5">
                        <div class="ml-12">
                          @isset($ausgänge[0]->file[0])
                          <p class=" text-xl">Extra Dateien</p>    

                          @endisset
                          @foreach ($ausgänge[0]->file as $file)
                          <script>
                            scanMin++;
                          </script>
                            <div class="mt-2">
                              <a onclick="scanCounter++; document.getElementById('file-{{$file->id}}').classList.remove('bg-red-600'); document.getElementById('file-{{$file->id}}').classList.add('bg-green-600'); if(scanCounter >= scanMin) {    document.getElementById('last-step').classList.remove('hidden');}" href="{{url("/")}}/files/aufträge/{{$file->process_id}}/{{$file->filename}}" target="_blank" class="float-left">
                                <div id="file-{{$file->id}}" class="float-left bg-red-600 p-1 rounded-full text-white">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 float-left">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                  </svg>
                                </div>
                                <p class="text-sm text-gray-600 ml-4 float-left">{{$file->filename}}</p>

                              </a>
                                <br>
                            </div>
                              
                              
                          @endforeach
                        </div>
                        
                       
                      </div>
                    </div>
                  </div>
                </li>
                @endisset

                <li class="hidden" id="last-step">
                    <div class="relative pt-6">
                      <span class="absolute top-6 ml-4 h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-0.5">
                          <div class="mt-10">

                            <button type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 font-semibold text-2xl text-white px-6 py-3 inline-block ml-11">Versenden</button>
                            <button type="button" onclick="window.location.href = '{{url("/")}}/crm/packtisch/warenausgang-verpacken/{{$ausgänge[0]->packid}}'" class="rounded-md bg-blue-600 hover:bg-blue-500 font-semibold text-2xl text-white px-6 py-3 inline-block ml-8">Verpacken</button>
                          </div>
                          
                         
                        </div>
                      </div>
                    </div>
                  </li>
            </ul>
            </div>
        </div>
    </div>
    </form>
    <div class="absolute right-16 top-36 h-full hidden" id="side-uploaded-docs">
      <h1 class="text-3xl font-bold mt-2">Hochgeladene Dokumente</h1>
  
      <div class="mt-8" id="uploaded-docs">
      
  
      </div>
    </div>
  
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