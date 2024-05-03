

  <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 40%; margin-top: -25rem; margin-left: -35rem">
            <h1 class="text-red-600 text-2xl font-semibold">Addresse nicht gefunden</h1>
            <p class="text-gray-600 mb-4">Die Addresse konnte nicht mit dem System abgeglichen werden. Bitte wählen sei eine der vorschläge aus</p>
    
    
            @php
                $alternativeAddressCounter = 0;
            @endphp
            @if ($response["status"] == "ZERO_RESULTS")
                <p class="text-2xl text-red-600 text-center font-bold">Keine validierte Adresse gefunden</p>
            @endif
            @foreach ($response["predictions"] as $item)
                <div class="rounded-md border border-gray-300 px-4 py-2 mb-4 flex">

                    <input onclick="alternativeAddress = '{{$alternativeAddressCounter}}'" type="radio" name="address" class=" mt-1">
                    <input type="hidden" id="alt-street-{{$alternativeAddressCounter}}" value="{{$item["terms"][0]["value"]}}">
                    <input type="hidden" id="alt-streetno-{{$alternativeAddressCounter}}" value="{{$item["terms"][1]["value"]}}">
                    <input type="hidden" id="alt-city-{{$alternativeAddressCounter}}" value="{{$item["terms"][2]["value"]}}">
                    <input type="hidden" id="alt-country-{{$alternativeAddressCounter}}" value="{{$item["terms"][3]["value"]}}">

                    <p class="ml-8">{{$item["description"]}}</p>
                </div>

                @php
                    $alternativeAddressCounter++;
                @endphp
            @endforeach


            @if ($response["status"] == "ZERO_RESULTS")
            <button onclick="document.getElementById('submit-kunden-versand').click(); document.getElementById('versand-kunde-address-check').innerHTML = '';" type="button" class="float-left text-white font-medium bg-blue-600 hover:bg-blue-400 rounded-md px-4 py-2 mt-8">Trotzdem vortfahren!</button>
            <button type="button" onclick="document.getElementById('versand-kunde-address-check').innerHTML = ''" class="float-right mt-8 rounded-md border border-gray-400 text-black font-medium px-4 py-2">Zurück</button>

            @else
            <button onclick="setAltAddrs()" type="button" class="float-left text-white font-medium bg-blue-600 hover:bg-blue-400 rounded-md px-4 py-2 mt-8">Addresse übernehmen</button>
            <button type="button" onclick="document.getElementById('versand-kunde-address-check').innerHTML = ''" class="float-right mt-8 rounded-md border border-gray-400 text-black font-medium px-4 py-2">Zurück</button>
            <button type="submit" onclick="loadData(); document.getElementById('submit-kunden-versand').click(); document.getElementById('versand-kunde-address-check').innerHTML = '';" class="float-right mt-8 text-white font-medium bg-red-600 hover:bg-red-400 px-4 py-2 rounded-md mr-4">Addresse nicht verändern</button>
                
            @endif
    
        </div>
      </div>
    </div>
  </div>