<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "packtisch"])
    <div class="m-auto mt-12 w-full">
        <div class="mt-1 m-auto text-center">
          <input type="text" name="process_number" id="barcode" oninput="checkBarcode()" class="m-auto block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white" style="display: Inline-block;" placeholder="|||||| Barcode">
          </div>
    </div>
    <div class="drop-shadow-xl max-w-7xl sm:px-6 lg:px-8 bg-white mt-16 m-auto " style="height: auto; width: 40rem">
        <h1 class="text-red-400">{{$warenausgang[0]["info"]}}</h1>
    </div>
    <div class="w-full">
        <form action="/crm/shipping/new/{{$shortcut}}/tec/tec" method="POST">
            @CSRF
             <div class="ml-36 drop-shadow-xl max-w-7xl sm:px-6 lg:px-8 bg-white mt-16 float-left" style="height: auto; width: 40rem">
           
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @php
                        $devices    = array();
                        $shelfes    = array();
                    @endphp
                  @foreach ($warenausgang as $ausgang)
                  <li>
                      <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="flex min-w-0 flex-1 items-center">
                          <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" id="{{$ausgang->component_number}}-svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                              </svg>
                          </div>
                          <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                            <div>
                              <p class="truncate text-sm font-medium text-red-600 mt-3" id="{{$ausgang->component_number}}" onclick="showDoc('{{$ausgang->component_number}}-doc')" target="_blank" rel="noopener noreferrer">{{$ausgang->component_number}}</p>
                              <br>
                              <p class="truncate text-sm font-medium text-red-600 mt-1" id="{{$ausgang->shelfe->shelfe_id}}">{{$ausgang->shelfe->shelfe_id}}</p>
                            </div>
                            <div class="hidden md:block">
                              <div>
                               @if ($ausgang->bpz1 != "0" && $ausgang->bpz1 != null && $ausgang->bpz1 != "")
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                {{$ausgang->bpz1}}
                              </p>
                               @endif
                               @if ($ausgang->upload_file != null)
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="{{$ausgang->upload_file}}-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Extra BPZ
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1.5 h-9 w-9 p-1 flex-shrink-0 text-white bg-green-600 rounded-full" onclick="printJS('{{urL('/')}}/files/warenausgang/{{$ausgang->process_id}}/ex_file.pdf')">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                  </svg>
                              </p>
                              
                               @endif

                               @if ($ausgang->gummi == "on")
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="{{$ausgang->bpz2}}-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Gummibärchen 
                              </p>
                               @endif

                               @if ($ausgang->protection == "on")
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="{{$ausgang->bpz2}}-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Überspannungsschutz 
                              </p>
                               @endif
                                
                               @if ($ausgang->seal == "on")
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="{{$ausgang->bpz2}}-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Versiegeln 
                              </p>
                               @endif

                               <button type="button" onclick="printJS({printable:'/crm/label/get/{{$ausgang->process_id}}/{{$ausgang->shortcut}}', type:'pdf', showModal:true})" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                              </svg>
                              Label</button>

                                
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                  </li>
                  @php
                      array_push($shelfes, $ausgang->shelfe->shelfe_id);
                      array_push($devices, $ausgang->component_number);
                  @endphp
                  @endforeach
                  <li class="hidden" id="finish">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                      <div class="flex min-w-0 flex-1 items-center">
                        <button type="submit" class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-4">Verschicken</button>
                        <button type="button" class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-60">Verpacken</button>
                      </div>
                      
                    </div>
                </li>
                 
                </ul>
              </div>

        </div>
        </form>
        <script>
            function showDoc(dev) {
                
                var doc     = document.getElementById(dev).classList.remove("hidden");
                

                var list = [@foreach($devices as $device) "{{$device}}-doc", @endforeach]

                list.forEach(element => {
                    if(dev != element) {
                        document.getElementById(element).classList.add("hidden");
                    }
                });
            }
        </script>

        <div class=" drop-shadow-xl max-w-2xl sm:px-6 lg:px-8 bg-white mt-16 float-right mr-36" style="height: 40rem; width: 50rem">
            
            @foreach ($warenausgang as $ausgang)
                    <iframe id="{{$ausgang->component_number}}-doc" src="{{url("/")}}/crm/auftrag/pdf/{{$ausgang->component_number}}/{{$ausgang->process_id}}#toolbar=0&navpanes=0" frameborder="0" class="w-full h-full hidden"></iframe>      
                    @if ($ausgang->upload_file != null)
                        <embed src="{{url("/")}}/files/warenausgang/{{$ausgang->process_id}}/{{$ausgang->component_number}}.pdf" type="" id="{{$ausgang->component_number}}-ex_file">
                    @endif
                    @endforeach
           
        </div>

    </div>
    <script>
        function checkBarcode() {
            var code        = document.getElementById("barcode").value;
            
            @foreach($devices as $device)
                if(code == "{{$device}}") {
                    document.getElementById("{{$device}}").classList.remove("text-red-600");
                    document.getElementById("{{$device}}").classList.add("text-green-600");
                    document.getElementById("barcode").value = "";
                } else {
                    checkShelfe();
                }
            @endforeach
        }
        function checkShelfe() {
            var code        = document.getElementById("barcode").value;
            @foreach($shelfes as $shelfe)
                if(code == "{{$shelfe}}") {
                    document.getElementById("{{$shelfe}}").classList.remove("text-red-600");
                    document.getElementById("{{$shelfe}}").classList.add("text-green-600");
                    document.getElementById("barcode").value = "";
                }
            @endforeach
            checkFinish();
        }

        function checkFinish() {
            @foreach($shelfes as $shelfe)
                if(document.getElementById("{{$shelfe}}").classList.contains("text-green-600")) {
                    @foreach($devices as $device)
                    if(document.getElementById("{{$device}}").classList.contains("text-green-600")) {
                        document.getElementById("{{$device}}-svg").classList.remove("text-red-600");
                        document.getElementById("{{$device}}-svg").classList.add("text-green-600");
                    }
                    @endforeach
                }
            @endforeach
            var counter = 0;
            @foreach($devices as $device)
                if(document.getElementById("{{$device}}-svg").classList.contains("text-green-600")) {
                    counter++;
                }
            @endforeach
            if(counter >= {{count($devices)}}) {
                document.getElementById("finish").classList.remove("hidden");
            }
        }
    </script>

</body>
</html>