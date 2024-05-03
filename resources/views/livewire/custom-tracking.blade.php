<div class="relative z-50" id="custom-tracking-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 py-4 text-left shadow-xl transition-all sm:my-8 " style="width: 50rem">
          <div class="h-10 w-full">
            <p class="text-xl font-medium float-left">Sendungsverfolgung Auftrag <span onclick="showOrderChangeModal('{{$trackingOrder}}'); document.getElementById('custom-tracking-modal').remove()" class="cursor-pointer text-blue-600 hover:text-blue-400">{{$trackingOrder}}</span></p>
            <button type="button" onclick="document,getElementById('custom-tracking-modal').classList.add('hidden')" class="float-right bg-red-600 text-white p-1 rounded-md hover:bg-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>                  
            </button>
          </div>

          <div class="border border-gray-300 rounded-md p-2 " id="trackings-table">
            @foreach ($trackings as $track)
            <div id="tracking-div-{{$track->trackingnumber}}" onclick="getSendungsverlaufTable('{{$track->trackingnumber}}', '{{$track->created_at->format('d.m.Y (H:i)')}}')" class="w-full hover:bg-blue-100 cursor-pointer text-blue-700 p-1 font-normal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-left mt-0.5 mr-1 text-blue-500">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                  </svg>                  
                <p class="inline-block truncate overflow-hidden  max-w-xs md:max-w-xl">
                  @isset($trackingStatus)
                  @if($codes->where("status", $trackingStatus[$tracking->trackingnumber])->first() != null)
                    <span class="rounded-md py-1 px-2 text-white font-medum" style="background-color: {{$codes->where("status", $trackingStatus[$track->trackingnumber])->first()->color}}">{{$codes->where("status", $trackingStatus[$track->trackingnumber])->first()->bezeichnung}} </span>
                  @endif
                  @endisset
                  
                 @isset($track->trackings->sortBy("event_date")->first()->event_date)
                      @php
                      $firstdate = new DateTime($track->trackings->sortBy("event_date")->first()->event_date);
                      if($track->trackings->sortByDesc("event_date")->first()->code->bezeichnung != "Zugestellt") {
                        $seconddate = new DateTime();
                      } else {
                        $seconddate = new DateTime($track->trackings->sortByDesc("event_date")->first()->event_date);
                        
                      
                      }
                      $diff = $firstdate->diff($seconddate);
                  @endphp
                  
                  Sdg. {{$track->trackingnumber}}, {{$track->trackings->sortByDesc("event_date")->first()->code->bezeichnung}}, ({{$diff->days}} Tage)
                  @else
                  <span class="text-red-600">Sendungsnummer nicht gefunden</span>
                 @endisset</p>
            </div>
            @endforeach

            @if (!isset($trackings[0]))
                <p class="text-red-800 font-bold text-lg text-center">Bitte Sendungsnummer hinzufügen</p>
            @endif
          </div>

          <div class="hidden" id="error-tracking">
            <div class="mt-4">
                <p class="text-xl font-medium text-red-600">Sendungsverfolgung konnte nicht gefunden werden</p>

            </div>
          </div>

          <div class="hidden w-full" id="sendungsverlauf-div">
            <div class="mt-4">
                <p class="text-xl font-medium">Details zur Sendungsnummer <span id="tracking-trackingnumber">124129041204</span></p>
                <p class="text-blue text-2xl text-blue-700 font-medium -ml-1 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                      </svg>
                    <span id="tracking-carrier">UPS Standard</span>
                </p>
              </div>
    
              <div class="mt-8">
                <p class="font-semibold">Sendungsverlauf</p>
    
                <ul role="list" class="space-y-6 mt-2">
                    <li class="relative flex gap-x-4">
                      <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                        <div class="w-px bg-gray-200"></div>
                      </div>
                      <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                        <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                      </div>
                      <p class=" py-0.5 text-md leading-5 font-semibold float-left">Sendungsnummer</p>
                      <div class="flex-auto py-0.5 text-md leading-5 float-left">
                        <div class="rounded-lg border border-gray-400 px-2">
                            <p class="rounded-full bg-blue-500 w-2 h-2 inline-block"></p>
                            <p class="ml-2 inline-block font-medium " id="sendungsverlauf-sendungsnummer">1Z182hbda9891</p>
                        </div>
                      </div>
                      <time datetime="2023-01-23T10:32" class="flex-none py-0.5 text-md leading-5 text-gray-500" id="tracking-created_at"></time>
                    </li>
                    <div id="sendungsverlauf-liste">
                        
                    </div>
                    
                  </ul>
                  
               
              </div>
          </div>

          <div class="mt-8">
            <button onclick="document.getElementById('neue-sendungsnummer-modal').classList.remove('hidden')" type="button" class="text-white bg-blue-600 hover:bg-blue-500 rounded-md border-none text-sm font-medium px-4 py-2 float-left">Sendungsnummer hinzufügen</button>
            <a href="" id="delete-tracking" class="text-white hidden ml-10 bg-red-600 hover:bg-red-500 rounded-md border-none text-sm font-medium px-4 py-2 float-left">Sendungsnummer löschen</a>
        </div>
        </div>
      </div>
    </div>
  </div>



  <div class="relative hidden z-50" id="neue-sendungsnummer-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
           <form action="{{url("/")}}/crm/tracking/neue-sendungsnummer" id="newTrackingIdForm" method="POST">
                @CSRF
                <input type="text" name="sendungsnummer" id="sendungsnummer" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Sendungsnummer">
                <input type="hidden" name="process_id" id="custom-tracking-process_id" value="{{$trackingOrder}}">
                <div class="mt-4">
                    <button type="submit" onclick="finishNewTrackingnumberSubmit(document.getElementById('sendungsnummer').value); loadData()" class="text-white bg-blue-600 hover:bg-blue-600 rounded-md border-none text-sm font-medium px-4 py-2 float-left">Speichern</button>
                    <button type="button" onclick="document.getElementById('neue-sendungsnummer-modal').classList.add('hidden')" class="text-black border border-gray-600 rounded-md px-4 py-2 font-medium text-sm float-right">Zurück</button>
                </div>
           </form>
        </div>
      </div>
    </div>
  </div>

  <script>

    function finishNewTrackingnumberSubmit(id) {
      loadData();

      let table = document.getElementById("trackings-table");

      let div = document.createElement("div");
      div.setAttribute("id", "tracking-div-"+id);
      div.innerHTML = '<div class="w-full bg-blue-50 text-blue-700 p-1 font-normal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-left mt-0.5 mr-1 text-blue-500">   <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" /> </svg>                  <p class="inline-block truncate overflow-hidden text-red-600 max-w-xs md:max-w-xl">Nr <span>'+ id +'</span> | Sendungsdaten werden abgerufen...</p>     <button type="button" onclick="getSendungsverlaufTable('+"'"+ id +"'"+', '+"'"+ 'Sendungsverfolgung updated...' +"'"+')" class="inline-block float-right font-medium">Details -></button> </div>'

      table.appendChild(div);
      document.getElementById("neue-sendungsnummer-modal").classList.add("hidden");

      let process_id = document.getElementById("custom-tracking-process_id").value;

      document.getElementById("tracking-counter-row-"+process_id).innerHTML = parseInt(document.getElementById("tracking-counter-row-"+process_id).innerHTML) + 1;

    }
      
  </script>