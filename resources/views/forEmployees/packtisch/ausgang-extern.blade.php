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
        <form action="{{url("/")}}/crm/packtisch/extern/complete" onsubmit="submitForm(event)" method="POST" id="shipform">
            @CSRF
             <div class="ml-36 drop-shadow-xl max-w-7xl sm:px-6 lg:px-8 bg-white mt-16 float-left" style="height: auto; width: 40rem">
           
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @php
                        $devices    = array();
                        $shelfes    = array();
                        $bpzs    = array();
                        $ex_bpzs = array();
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
                            <div class=" md:block">
                              <div>
                               @if ($ausgang->bpz1 != "0" && $ausgang->bpz1 != null)
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                               
                                @if (in_array($ausgang->bpz1, $bpzs))
                                @php
                                    $c = 0;
                                @endphp
                                @foreach ($bpzs as $bpz)
                                    @if ($bpz == $ausgang->bpz1)
                                        @php
                                            $c++;
                                        @endphp
                                    @endif
                                @endforeach
                                <svg id="{{$ausgang->bpz1}}-{{$c}}-{{$ausgang->component_number}}" class=" h-5 w-5 flex-shrink-0 text-red-600 float-left " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                    @else 
                                    <svg id="{{$ausgang->bpz1}}-0-{{$ausgang->component_number}}" class=" h-5 w-5 flex-shrink-0 text-red-600 float-left " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <p onclick="document.getElementById('{{$ausgang->bpz1}}').classList.remove('hidden')" class="float-left">{{$attach->where("barcode", $ausgang->bpz1)->first()->name}} </p>

                               
                                
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-left ml-1.5 h-9 w-9 p-1 flex-shrink-0 text-white bg-green-600 rounded-full" onclick="
                                    printJS('{{urL('/')}}/pdf/{{str_replace(' ', '_', $ausgang->bpz1)}}.PDF'); 
                                    document.getElementById('{{$ausgang->bpz1}}-{{$ausgang->component_number}}').classList.remove('text-red-600'); 
                                    document.getElementById('{{$ausgang->bpz1}}-{{$ausgang->component_number}}').classList.add('text-green-600');
                                ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                  </svg>
                              </p>
                              <br>
                              <br>
                              @php
                                  array_push($bpzs, $ausgang->bpz1)
                              @endphp
                               @endif
                               
                               @if ($ausgang->upload_file != null)
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="{{$ausgang->upload_file}}-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <p onclick="document.getElementById('{{$ausgang->upload_file}}').classList.remove('hidden')" class="float-left">Extra BPZ</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1.5 h-9 w-9 p-1 flex-shrink-0 text-white bg-green-600 rounded-full" onclick="
                                    printJS('{{urL('/')}}/files/warenausgang/{{$ausgang->process_id}}/ex_file.pdf'); 
                                    document.getElementById('{{$ausgang->upload_file}}-{{$ausgang->component_number}}').classList.remove('text-red-600'); 
                                    document.getElementById('{{$ausgang->upload_file}}-{{$ausgang->component_number}}').classList.add('text-green-600');
                                ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                  </svg>
                              </p>
                             @php
                                 array_push($ex_bpzs, $ausgang->upload_file);
                             @endphp
                               @endif

                               @if ($ausgang->bpz2 != "0" && $ausgang->bpz1 != null)
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                               
                                @if (in_array($ausgang->bpz2, $bpzs))
                                  @php
                                  $c = 0;
                                  @endphp
                                  @foreach ($bpzs as $bpz)
                                      @if ($bpz == $ausgang->bpz2)
                                          @php
                                              $c++;
                                          @endphp
                                      @endif
                                  @endforeach
                                  <svg id="{{$ausgang->bpz2}}-{{$c}}-{{$ausgang->component_number}}" class=" h-5 w-5 flex-shrink-0 text-red-600 float-left " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                  </svg>
                                  @else
                                  <svg id="{{$ausgang->bpz2}}-{{$c}}-{{$ausgang->component_number}}" class=" h-5 w-5 flex-shrink-0 text-red-600 float-left " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                  </svg>
  
                                @endif
                               
                               
                               
                                <p onclick="document.getElementById('{{$ausgang->bpz2}}').classList.remove('hidden')" class="float-left">{{$attach->where("barcode", $ausgang->bpz2)->first()->name}}  </p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-left mr-2 ml-1.5 h-9 w-9 p-1 flex-shrink-0 text-white bg-green-600 rounded-full" onclick="
                                printJS('{{urL('/')}}/pdf/{{str_replace(' ', '_', $ausgang->bpz1)}}.PDF');
                                document.getElementById('{{$ausgang->bpz2}}-{{$ausgang->component_number}}').classList.remove('text-red-600'); 
                                    document.getElementById('{{$ausgang->bpz2}}-{{$ausgang->component_number}}').classList.add('text-green-600');">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                  </svg>
                                  
                              </p>
                              @php
                              array_push($bpzs, $ausgang->bpz2)
                            @endphp
                               @endif

                               @if ($ausgang->gummi == "on")
                               @php
                                    array_push($bpzs, "gummi")
                               @endphp
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="gummi-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Gummibärchen 
                              </p>
                               @endif

                               @if ($ausgang->protection == "on")
                               @php
                                    array_push($bpzs, "prot")
                               @endphp
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="prot-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Überspannungsschutz 
                              </p>
                               @endif
                                
                               @if ($ausgang->seal == "on")
                               @php
                                    array_push($bpzs, "seal")
                               @endphp
                               <p class="mt-2 flex items-center text-sm text-gray-500">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="seal-{{$ausgang->component_number}}" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Versiegeln 
                              </p>
                               @endif

                               @if($ausgang->fotoauftrag == "on")
                               <p class="mt-2 flex items-center text-sm text-gray-500 w-96">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg id="fotoauftrag" class="mr-1.5 h-5 w-5 flex-shrink-0 text-red-600 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <p class="float-left">Fotoauftrag</p>
                              </p>

                              
                              @endif
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
                        <button type="submit"  class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-4">Verschicken</button>
                        <button type="button" onclick="window.location.href = '{{url('/')}}/crm/verpacken/{{$id}}'" class="float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-60">Verpacken</button>
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


          $.get("{{url("/")}}/crm/auftrag/pdf/warenausgang/{{$id}}/get#toolbar=0", function(data, status){
                          if(data == "Keine Datei gefunden") {
                              document.getElementById("fotoauftrag").classList.add("text-red-600");
                              document.getElementById("fotoauftrag").classList.remove("text-green-600");
                                    
                            
                          } else {
                            document.getElementById("fotoauftrag").classList.remove("text-red-600");
                              document.getElementById("fotoauftrag").classList.add("text-green-600");
                                    

                              
                          }
                      });

          
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

        <div class=" drop-shadow-xl max-w-2xl sm:px-6 lg:px-8 bg-white mt-16 float-right mr-36" style="height: 40rem; width: 50rem">
          <form action="{{url("/")}}/crm/warenausgang/fotoauftrag/refresh/{{$id}}" method="post">
            @CSRF
            <input type="hidden" name="component_id" value="{{$ausgang->component_name}}">
            <button type="submit"  class="float-right mt-6 inline-flex items-center rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
              </svg>
              </button>
        </form>
        
                  <embed type="text/html" src="/crm/auftrag/pdf/warenausgang/{{$id}}#toolbar=0" class="w-full h-full">
           
        </div>
    </div>
    @php
        $old = array(); 
    @endphp
    <script>
       var st = true;
        function checkBarcode() {
            var code        = document.getElementById("barcode").value;
            
            @foreach($devices as $device)
            if(code == "gummi") {
                document.getElementById("gummi-{{$device}}").classList.remove("text-red-600");
                document.getElementById("gummi-{{$device}}").classList.add("text-green-600");
                code = "";
            }
            if(code == "seal") {
                document.getElementById("seal-{{$device}}").classList.remove("text-red-600");
                document.getElementById("seal-{{$device}}").classList.add("text-green-600");
                code = "";
            }
            if(code == "prot") {
                document.getElementById("prot-{{$device}}").classList.remove("text-red-600");
                document.getElementById("prot-{{$device}}").classList.add("text-green-600");
                code = "";
            }
            @endforeach

            @php
            $doubles = array();
            @endphp
           
            @foreach($bpzs as $bpz) 
                @foreach($devices as $device)

                @if(in_array($bpz. "-". $device, $doubles))
                @php
                  $c = 0;
                  $cc = 0;
                  @endphp
                  @foreach ($bpzs as $bpzt)
                      @if ($bpz == $bpzt)
                          @php
                              $c++;
                          @endphp
                      @endif
                  @endforeach
                @while($cc <= $c)
                if(code == "{{$bpz}}") {
                  el  = document.getElementById("{{$bpz}}-{{$cc}}-{{$device}}");
                  @php 
                  $t = $cc - 1;
                  @endphp
                    if(el != null) {
                      @if($cc == 0)  
                       if(st == true) {
                        console.log(st);
                         
                        document.getElementById("{{$bpz}}-{{$cc}}-{{$device}}").classList.remove("text-red-600");
                        document.getElementById("{{$bpz}}-{{$cc}}-{{$device}}").classList.add("text-green-600");
                        document.getElementById("barcode").value = "";
                        st = "awdawd";
                        return;
                       }
                      @else
                      
                        var cc = {{$cc}};
                        if(document.getElementById('{{$bpz}}-0-{{$device}}') != null) {
                          if(document.getElementById('{{$bpz}}-0-{{$device}}').classList.contains("text-green-600")) {
                        document.getElementById("{{$bpz}}-{{$cc}}-{{$device}}").classList.remove("text-red-600");
                        document.getElementById("{{$bpz}}-{{$cc}}-{{$device}}").classList.add("text-green-600");
                        document.getElementById("barcode").value = "";
                      
                      }
                        }
                    
                      @endif
                    }
                } else {
                    checkShelfe();
                }
                @php
                $cc++;
                @endphp
                @endwhile
                @else 
                
                if(code == "{{$bpz}}") {
                  el  = document.getElementById("{{$bpz}}-0-{{$device}}");

                  if(el != null) {
                      if(document.getElementById('{{$bpz}}-0-{{$device}}').classList.contains("text-green-600")) {
                        document.getElementById("{{$bpz}}-0-{{$device}}").classList.remove("text-red-600");
                        document.getElementById("{{$bpz}}-0-{{$device}}").classList.add("text-green-600");
                        document.getElementById("barcode").value = "";
                      }
                    }
                } else {
                    checkShelfe();
                }
                @endif
                @php array_push($doubles, $bpz . "-". $device) @endphp
                @endforeach
            @endforeach
           
          
           

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
            var counter = 1;
            @foreach($devices as $device)
            if(document.getElementById("{{$device}}-svg") != null) {
              if(document.getElementById("{{$device}}-svg").classList.contains("text-green-600")) {
                    counter++;
                }
            }
              
            @endforeach
            if(counter >= {{count($devices)}}) {
                counter = 0;
                @foreach($devices as $device)
                @foreach($bpzs as $bpz)

                if(document.getElementById("{{$bpz}}-"+ counter +"-{{$device}}") != null) {
                  if(document.getElementById("{{$bpz}}-"+ counter +"-{{$device}}").classList.contains("text-green-600")) {
                        counter++;
                    }
                }
                if(document.getElementById("{{$bpz}}-{{$device}}") != null) {
                  if(document.getElementById("{{$bpz}}-{{$device}}").classList.contains("text-green-600")) {
                        counter++;
                    }
                }
                  
                    

                @endforeach
                
            @endforeach
                if(counter >= {{count($bpzs)}}) {
                    document.getElementById("finish").classList.remove("hidden");
                }
            }
        }
    </script>
  @php
      $donebpzs  = array();
  @endphp
    @foreach ($bpzs as $bpz)
      @if (!in_array($bpz, $donebpzs))
      <div id="{{$bpz}}" class="hidden" style="position: absolute;">
        @include('forEmployees/modals/dokumente', ["doc" => $bpz, "url" => $id])
      </div>
      @php
      array_push($donebpzs, $bpz);
      @endphp
      @endif
   
    @endforeach
    @foreach ($ex_bpzs as $bp)
    <div id="{{$bp}}" class="hidden">
      @include('forEmployees/modals/extrabpz', ["doc" => $bp, "id" => $id])
    </div>
    @endforeach

</body>
</html>