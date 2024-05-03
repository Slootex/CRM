
<div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
  
    <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
      <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
        <!--
          Modal panel, show/hide based on modal state.
  
          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 63.5rem">
          <div class="float-right">
            <button onclick="document.getElementById('uebersicht').classList.add('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-600 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
          <div class="py-2 mt-6">
            <div class="rounded-md bg-blue-50 p-4">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                  </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                  <p class="text-sm text-blue-700">Gesamt {{$allShelfes->count()}}, Belegt {{$usedShelfes->count()}} ({{number_format((float)100/$allShelfes->count() * $usedShelfes->count(), 2, '.', '')}}%), Leer {{$allShelfes->count() - $usedShelfes->count()}} ({{100 - number_format((float)$usedShelfes->count() / $allShelfes->count() * 100, 2, '.', '')}}%)</p>
                </div>
              </div>
            </div>
          </div>

          <div id="shelfeparent">
            @php
                $schrankCounter = 1;
                $regalCounter = 1;
                $packCounter = 1;
                $rowCounter = 1;
                $created = false;
            @endphp
            <script>
              let parent = document.getElementById("shelfeparent");
              let schrank;
              let shelfe;
              @foreach($allShelfes as $shelfe)
                @if($created == false)
                  shelfe = document.createElement("div");
                  @if($packCounter == 1)
                    shelfe.classList.add("grid", "grid-cols-1", "w-10", "float-left", "mt-6", "text-sm");
                    @php
                      $packCounter = 2;
                    @endphp
                    @else
                      @if($rowCounter == 7)
                        shelfe.classList.add("grid", "grid-cols-1", "w-10", "float-left", "mt-6", "text-sm");
                        @php
                          $rowCounter = 1;
                        @endphp
                        @else 
                        shelfe.classList.add("grid", "grid-cols-1", "w-10", "float-left", "mr-2", "mt-6", "text-sm");

                        @php
                          $rowCounter++;
                        @endphp
                      @endif
                    @php
                      $packCounter = 1;
                    @endphp
                  @endif
                  shelfe.setAttribute("id", "shelfe-{{$regalCounter}}");
                  parent.appendChild(shelfe);
                  @php
                    $created = true;
                  @endphp
                @endif

                schrank = document.createElement("div");
                schrank.classList.add("w-10", "border", "border-gray-200", "text-center", "text-sm" @if($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->count() > 1) , "bg-yellow-600" @endif @if($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->count() == 1) , "bg-green-600" @endif);
                schrank.innerHTML = "<a href='{{url("/")}}/crm/lagerplatübersicht/filter/{{$shelfe->shelfe_id}}'>{{ $shelfe->shelfe_id }}</a>";
                document.getElementById("shelfe-{{$regalCounter}}").appendChild(schrank);

                @if($schrankCounter == 11)
                  @php
                    $schrankCounter = 1;
                    $regalCounter++;
                    $created = false;
                  @endphp
                  @else
                  @php
                    $schrankCounter++;
                  @endphp
                @endif

                

              @endforeach

            </script>
          </div>
          
            <button type="button" onclick="document.getElementById('uebersicht').classList.add('hidden')" class=" bg-white text-black rounded-md border border-gray-600 px-4 py-2 absolute" style="right: 2rem; bottom: 2rem;">Zurück</button>

          </div>
         
        </div>
      </div>
    </div>
  </div>

