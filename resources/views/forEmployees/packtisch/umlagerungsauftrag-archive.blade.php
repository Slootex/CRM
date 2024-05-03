<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="js/pdf.js"></script>
    @vite('resources/css/app.css')
</head>
<body>
   
    @include('layouts.top-menu', ["menu" => "packtisch"])
    @if($errors->any())
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 mt-8 flex items-end px-4 py-6 sm:items-start sm:p-6 animate__fadeInDown animate__animated" id="error">
      <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <!--
          Notification panel, dynamically insert this into the live region when it needs to be displayed
    
          Entering: "transform ease-out duration-300 transition"
            From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            To: "translate-y-0 opacity-100 sm:translate-x-0"
          Leaving: "transition ease-in duration-100"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 " >
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <!-- Heroicon name: outline/check-circle -->
              
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="h-6 w-6 text-red-400" >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">{{$errors->first()}}</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <!-- Heroicon name: mini/x-mark -->
                  <svg onclick="document.getElementById('error').classList.add('hidden')" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>
                  
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endisset
    <div class="w-full">
        <form action="{{url("/")}}/crm/umlagerungsauftrag-archive/{{$id}}" method="POST">
            @CSRF
            <div class="ml-36 drop-shadow-xl max-w-7xl sm:px-6 lg:px-8 bg-white mt-16 float-left" style="height: 40rem; width: 40rem">
            
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                      <li class="mt-10">
                        <div class="relative pb-8">
                          <span class="absolute top-4 left-8 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                          <div class="relative flex space-x-3">
                            <div>
                              <span class="h-16 w-16 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                <!-- Heroicon name: mini/user -->
                                <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                  </svg>
                              </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                              <div>
                                <p class="text-2xl text-gray-500 mt-2">Auftrag <a href="{{url("/")}}/files/aufträge/{{$process_id}}/{{$id}}.pdf" target="_blank"  rel="noopener noreferrer" class="font-medium text-blue-600">{{$id}}</a> gefunden!</p>
                              </div>
                             
                            </div>
                          </div>
                        </div>
                      </li>
                  
                      <li class="mt-16">
                        <div class="relative pb-8">
                          <span class="absolute top-4 left-8 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                          <div class="relative flex space-x-3">
                            <div>
                              <span id="barcodesvg"  class="h-16 w-16 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                <!-- Heroicon name: mini/hand-thumb-up -->
                                <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                  </svg>                         
                              </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4">
                              <div>
                                <div>
                                    <div class="" style="display: inline-block;">
                                      <input type="text" @isset($allow->setting)
                                          @if ($allow->setting == "false")
                                          disabled
                                          @endif
                                      @endisset  onkeydown="handle(event)" name="barcode" style="display: inline-block;" id="barcode" class="bg-slate-200 text-xl block w-96 h-16 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="| | | | | | | Barcode">
                                    </div>
                                    <div id="printJS-form" class="w-96 hidden" style="transform: rotate(270deg); margin-top: 20rem">
                                        <svg id="barcodee" class="w-96" style="transform: rotate(270deg);"></svg>
                                    </div>
                                    <div style="display: inline-block;" class="ml-3" onclick="printJS('printJS-form', 'html')">
                                        <span style="display: inline-block;" class="h-16 w-16 rounded-full bg-green-600 flex items-center justify-center ring-8 ring-white">
                                            <!-- Heroicon name: mini/hand-thumb-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg" style="display: inline-block;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-14 w-14 rounded-full flex items-center justify-center text-white p-1 ml-2 mt-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                              </svg>                
                                          </span>
                                    </div>
                                    <div style="display: inline-block;" class="ml-3">
                                        
                                        <span style="display: inline-block;">
                                            <!-- Heroicon name: mini/hand-thumb-up -->
                                            <p class="text-blue-500 text-center pt-1 text-xl">Derzeitiger Lagerplatz: <span style="color: coral">{{$shelfe->shelfe_id}}</span></p>          
                                          </span>
                                    </div>
                                  </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      </li>
                      <li id="shelfeli" class="hidden mt-16">
                        <div class="relative pb-8">
                          <span class="absolute top-4 left-8 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                          <div class="relative flex space-x-3">
                            <div>
                              <span id="shelfesvg"  class="h-16 w-16 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                <!-- Heroicon name: mini/hand-thumb-up -->
                                <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                  </svg>                         
                              </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 ">
                              <div>
                                <div>
                                    <div class="" style="display: inline-block;">
                                      <input type="text" name="shelfe" onkeydown="handleshelfe(event)" style="display: inline-block;" id="shelfe" class="text-xl block w-96 h-16 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="| | | | | | | Lagerplatz">
                                    </div>
                                    <div style="display: inline-block;" class="ml-3">
                                        
                                        <span style="display: inline-block;">
                                            <!-- Heroicon name: mini/hand-thumb-up -->
                                            <p class="text-blue-500 text-center pt-1 text-xl">Bitte suche selbst einen Lagerplatz aus</span></p>          
                                          </span>
                                    </div>
                                  </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      </li>
                  
                    </ul>
                  </div>
    
    
                            
    <script>
          
        var barcode = "";
      function checkInput(e) {
        if(e.keyCode == 16) {
          
        } else if(e.keyCode == 189) {  
          barcode     += "-";
        }  else {
          barcode     += String.fromCharCode(e.keyCode);
        }
        console.log(e.keyCode);
        var checkCode   = "{{$id}}";
        var checkCode3  = checkCode.slice(0,3);
        console.log(barcode);
        if(barcode.length >= 3) {
          if(barcode == checkCode3 || barcode.slice(0,3) == checkCode3) {
            checkBarcode(barcode);
          } else {
            barcode = "";
          }
        }
      }
    
    function handle(e){
            if(e.keyCode === 13){
                e.preventDefault(); // Ensure it is only this code that runs
    
                checkBarcode(document.getElementById("barcode").value);
            }
        }
    
        function handleshelfe(e){
            if(e.keyCode === 13){
                e.preventDefault(); // Ensure it is only this code that runs
                checkShelfe();
                
            }
        }
    function test() {
        var element = document.getElementById("barcodee");
        JsBarcode(element, "{{$id}}", {
            height: 45,
            fontSize: 20,
            width: 2,
            textMargin: -2,
            
    
        });
    }</script>
                                
                            
                    
                    <div id="finish" class="mt-16 text-center hidden">
                        <button type="submit" class="text-xl inline-flex m-auto w-full text-center items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <!-- Heroicon name: mini/envelope -->
                            <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                              <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                            </svg>
                            Auftrag durchführen
                          </button>
                      </div>
                  </div>
        
        </form>
        <div class=" drop-shadow-xl max-w-2xl sm:px-6 lg:px-8 bg-white mt-16 float-right mr-36" style="height: 40rem; width: 50rem">
            
            <embed type="text/html" src="/crm/auftrag/pdf/{{$id}}/{{$process_id}}#toolbar=0" class="w-full h-full">
    
        </div>
    </div>
    <script>
       function checkBarcode(barcode) {
          console.log(barcode);
            var code        = barcode;
            if(code == "{{$id}}") {
                document.getElementById("barcode").classList.remove("bg-red-100");
                document.getElementById("barcode").classList.add("bg-green-100");
                document.getElementById("barcodesvg").classList.remove("bg-red-500");
                document.getElementById("barcodesvg").classList.add("bg-green-500");
                document.getElementById("shelfeli").classList.remove("hidden");
                document.getElementById("shelfe").focus();
                checkShelfe();
            } else {
              document.getElementById("barcode").value = "";
                document.getElementById("barcode").classList.remove("bg-green-100");
                document.getElementById("barcode").classList.add("bg-red-100");
            }
            checkFinish();
        }
        function checkShelfe() {
            var code        = document.getElementById("shelfe").value;
            if(code == code && code != "") {
                document.getElementById("shelfe").classList.remove("bg-red-100");
                document.getElementById("shelfe").classList.add("bg-green-100");
                document.getElementById("shelfesvg").classList.remove("bg-red-500");
                document.getElementById("shelfesvg").classList.add("bg-green-500");
            } else {
                document.getElementById("shelfe").classList.remove("bg-green-100");
                document.getElementById("shelfe").classList.add("bg-red-100");
                document.getElementById("shelfe").value = "";
            }
            checkFinish();
        }

        function checkFinish() {
            if(document.getElementById("barcode").classList.contains("bg-green-100") && document.getElementById("shelfe").classList.contains("bg-green-100"))  {
                document.getElementById("finish").classList.remove("hidden");
            } else {
                document.getElementById("finish").classList.add("hidden");
            }
        }
    </script>

</body>
</html>