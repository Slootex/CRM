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
<body onload="document.getElementById('shelfe-input').focus();">
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <div>
      <form action="{{url("/")}}/crm/packtisch/gerät-umlagern/{{$device->component_number}}" method="POST">
        @include('includes.packtisch.scan-history')

        @csrf
        <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
          @if ($device->info != "")
          <div class="w-full px-8">
            <div class="m-auto bg-red-100 rounded-md mt-6 px-4 py-2 w-full">
              <p class="text-2xl text-red-800">{{$device->info}}</p>
            </div>
          </div>
        @endif
            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Gerät umlagern</h1>
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

                          <li class="" id="step-1">
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
                                    <p class="text-xl text-gray-500">Aktueller Lagerplatz <span class="font-semibold text-green-600">{{$currentShelfe->shelfe_id}}</span></p>
                                    <input id="shelfe-input" name="barcode" onkeydown="checkCurrentShelfe(event, this.value)" type="text" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
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
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="dev-no"  fill="currentColor" class="w-10 h-10 text-red-600">
                                      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                    </svg>
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="dev-ok" class="w-10 h-10 text-green-600 hidden">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Aktuelle Gerätenummer <span class="font-semibold text-green-600">{{$currentShelfe->component_number}}</span></p>
                                    <input id="barcode-input" name="barcode" onkeydown="checkBarcode(event, this.value)" type="text" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="newshelfe-no"  fill="currentColor" class="w-10 h-10 text-red-600">
                                      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                    </svg>
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="newshelfe-ok" class="w-10 h-10 text-green-600 hidden">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                  </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                  <div>
                                    <p class="text-xl text-gray-500">Neuer Lagerplatz <span class="font-semibold text-green-600">{{$freeShelfe->shelfe_id}}</span></p>
                                    <input type="text" name="shelfe" id="newshelfe-input" onkeydown="checkNewShelfe(event, this.value)" class=" rounded-lg w-60 h-12 text-center border border-gray-600 text-xl">
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
                                        <p class="inline-block" id="submit-type-text">Gerät umlagern</p>
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
    <script>
        let currentStepCount = 1;
        function nextStep(){
            document.getElementById("step-"+currentStepCount).classList.remove("hidden");
            document.getElementById('barcode-input').focus();
        }

        function checkCurrentShelfe(e, input) {
              if(e.keyCode == 13) {
                e.preventDefault();
                if(input == '{{$currentShelfe->shelfe_id}}') {
                  document.getElementById('step-2').classList.remove('hidden') ;
                  document.getElementById("shelfe-no").classList.add("hidden");
                  document.getElementById("shelfe-ok").classList.remove("hidden");
                  scanFound(input, "Umlagerungsauftrag");
                  document.getElementById('barcode-input').focus();
                } else {
                  document.getElementById("shelfe-input").value = "";
                  scanNotFound(input, "Umlagerungsauftrag");

                }
              }
        }

        function checkBarcode(e, input) {
              if(e.keyCode == 13) {
                e.preventDefault();
                if(input == '{{$device->component_number}}') {
                  document.getElementById('step-3').classList.remove('hidden') ;
                  document.getElementById("dev-no").classList.add("hidden");
                  document.getElementById("dev-ok").classList.remove("hidden");
                  scanFound(input, "Umlagerungsauftrag");
                  document.getElementById('newshelfe-input').focus();

                } else {
                  document.getElementById("barcode-input").value = "";
                  scanNotFound(input, "Umlagerungsauftrag");

                }
              }
        }

        function checkNewShelfe(e, input) {
              if(e.keyCode == 13) {
                e.preventDefault();
                if(input == '{{$freeShelfe->shelfe_id}}') {
                  document.getElementById('step-6').classList.remove('hidden') ;
                  document.getElementById("newshelfe-no").classList.add("hidden");
                  document.getElementById("newshelfe-ok").classList.remove("hidden");
                  scanFound(input, "Umlagerungsauftrag");

                } else {
                  document.getElementById("newshelfe-input").value = "";
                  scanNotFound(input, "Umlagerungsauftrag");

                }
              }
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
    @include('forEmployees.modals.newDeviceCheckAuftragsDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles')

    @include('forEmployees.modals.newDeviceCheckDeviceDokumente')
    @include('forEmployees.modals.errors.packtisch.noFiles-device')

    @include('forEmployees.modals.packtisch.einlagernProblemMelden')
</body>
</html>