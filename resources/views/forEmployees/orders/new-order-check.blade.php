<div class="relative z-10" id="check-new-order" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 50rem">
        <div class="mb-4">
            <h1 class="text-2xl font-medium">Duplikat prüfen</h1>
        </div>

        @php
            $dupCounter = 0;
            $dupMax = $duplikate->count();
        @endphp

        @foreach ($duplikate as $dup)
        <div id="duplikat-div-{{$dup->process_id}}" class="border border-gray-300 rounded-md @if($dupCounter == 0) rounded-bl-none rounded-br-none @endif @if($dupCounter == $dupMax) rounded-tr-none rounded-tl-none @endif px-2 pt-2">
          <div class="float-left">
            <input id="duplikat" onclick="changeDuplikat('{{$dup->process_id}}')" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
          </div>
          <div class="ml-8 h-20">
            <p><span>{{$dup->firstname}}</span> <span>{{$dup->lastname}}</span> (<span>{{$dup->kunden_id}}</span>)</p>
            <p>BMW 323, E65 TDI, BJ 2023 <span class="text-gray-400">(0035 / ABD)</span></p>
            <div>
              <p class="text-gray-600 float-left"><span>{{$dup->home_street}}</span> <span>{{$dup->home_street_number}}</span>, <span>{{$dup->home_zipcode}}</span> <span>{{$dup->home_city}}</span></p>
              <p class="text-gray-600 float-right">Gefunden über {{$dup->found_at}}</p>
            </div>
          </div>
        </div>
        @php
            $dupCounter++;
        @endphp
        @endforeach

        <button type="button" onclick="setDuplikat()" class="mt-10 float-left bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium px-4 py-2">
          Kunde übernehmen
        </button>
        <button type="button" onclick="document.getElementById('submit-button').click()" class="mt-10 ml-8 float-left bg-red-600 hover:bg-red-400 rounded-md text-white font-medium px-4 py-2">
          Nicht übernehmen
        </button>
      </div>
    </div>
  </div>
</div>
