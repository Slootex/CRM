<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

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
        <form action="/crm/packtisch/entsorgung/complete" onsubmit="submitForm(event)" method="POST" id="shipform">
            @CSRF
             <div class="ml-36 drop-shadow-xl max-w-7xl sm:px-6 lg:px-8 bg-white mt-16 float-left" style="height: auto; width: 40rem">
           
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @php
                        $devices = array();
                        $shelfes = array();
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
                              @if (isset($ausgang->shelfe->shelfe_id))
                                <p class="truncate text-sm font-medium text-red-600 mt-1" id="{{$ausgang->shelfe->shelfe_id}}">{{$ausgang->shelfe->shelfe_id}}</p>
                              @else
                                <p class="truncate text-sm font-medium text-red-600 mt-1">Kein Lagerplatz gefunden</p>
                              @endif
                            </div>
                            <div class=" md:block">
                              
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                  </li>
                  @php
                  if(isset($ausgang->shelfe->shelfe_id)) {
                    array_push($shelfes, $ausgang->shelfe->shelfe_id);
                  }
                      array_push($devices, $ausgang->component_number);
                  @endphp
                  @endforeach
                  <li class="hidden" id="finish">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                      <div class="flex min-w-0 flex-1 items-center">
                        <button type="submit"  class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-4">Verschicken</button>
                        <button type="button" onclick="window.location.href = '{{url('/')}}/crm/entsorgung/verpacken'" class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-60">Verpacken</button>
                      </div>
                      
                    </div>
                </li>
                 
                </ul>
              </div>

        </div>
        </form>

        <script>
          function submitForm(event) {
            event.preventDefault();
            $.get("{{url('/')}}/crm/check/labelcount/{{$devices[0]}}", function(data, status){
               if(data == "ok") {
                document.getElementById("shipform").submit();

               } else {
                console.log(data);
                var answer = window.confirm("Es Exestieren bereits 2 Label für den Kunden!! TROTZDEM VERSENDEN??");
              if (answer) {
                  document.getElementById("shipform").submit();
              }
              else {
                  //some code
              }
               }
          });
          }


    
          
        </script>

        @foreach ($devices as $dev)
        <div class="relative z-10 hidden" id="{{$dev}}-doc" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!--
              Background backdrop, show/hide based on modal state.
          
              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
          
            <div class="fixed inset-0 z-10 overflow-y-auto">
              <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!--
                  Modal panel, show/hide based on modal state.
          
                  Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-3/5 sm:p-6 " style="height: 50rem">
                  <div>
                   
                    <div class="mt-3 text-center sm:mt-5"  style="height: 40rem">

                        @php
                            $parts = explode("-", $dev); 
                        @endphp

                        <iframe src="{{url("/")}}/crm/auftrag/pdf/{{$dev}}/{{$parts[0]}}/get#toolbar=0&navpanes=0" frameborder="0" class="w-full h-full"></iframe>      

                    
                    </div>
                  </div>
                  <div class="mt-5 sm:mt-6">
                    <button type="button" onclick="document.getElementById('{{$dev}}-doc').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-sm">Zurück</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach

        <script>
            function showDoc(dev) {
                
                var doc     = document.getElementById(dev).classList.remove("hidden");
                

                var list = [@foreach($devices as $device) "{{$device}}-doc", @endforeach]

                list.forEach(element => {
                    if(dev != element) {
                        document.getElementById(element).classList.add("hidden");
                    } else {
                        document.getElementById(element).classList.remove("hidden");
                    }
                });
            }
        </script>

        
    </div>
    @php
        $old = array(); 
    @endphp
    <script>
       var st = true;
       var awd = 0;
        function checkBarcode() {
            var code        = document.getElementById("barcode").value;
            
          
           
            
            @foreach($devices as $device)
                if(code == "{{$device}}") {
                    document.getElementById("{{$device}}").classList.remove("text-red-600");
                    document.getElementById("{{$device}}").classList.add("text-green-600");
                    document.getElementById("barcode").value = "";
                    console.log("awd");
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
            if(document.getElementById("{{$shelfe}}") != null) {
              if(document.getElementById("{{$shelfe}}").classList.contains("text-green-600")) {
                    @foreach($devices as $device)
                    if(document.getElementById("{{$device}}") != null) {
                      if(document.getElementById("{{$device}}").classList.contains("text-green-600")) {
                        document.getElementById("{{$device}}-svg").classList.remove("text-red-600");
                        document.getElementById("{{$device}}-svg").classList.add("text-green-600");
                    }
                    }
                    
                    
                    @endforeach
                }
            }
                
            @endforeach
          
           @foreach($devices as $device)

            if(document.getElementById("{{$device}}").classList.contains("text-green-600")) {
              awd++;
            }

           @endforeach

           if(awd >= {{count($devices)}}) {
            document.getElementById("finish").classList.remove("hidden");
           }
        }
    </script>
 

</body>
</html>