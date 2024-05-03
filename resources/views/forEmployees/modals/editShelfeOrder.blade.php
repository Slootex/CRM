
<div class="relative  z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="edit-shelfe-modal">
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

  <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
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
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6 " style="width: 28rem;">
        <div>
              <div>
                <h1 class="font-semibold text-xl inline-block">Gerät bearbeiten</h1>
                <button onclick="document.getElementById('edit-shelfe-modal').classList.add('hidden')" type="button" class="inline-block py-1 px-1 bg-red-600 rounded-md float-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </button>
              </div>

              <div class="mt-8">
                <p class="inline-block">Gerät</p>
                <p target="_blank" class="inline-block pl-12">{{$editUsedShelfes->component_number}}</p>
              </div>

             

              <div class="mt-4">
                <p class="inline-block pr-12 mr-1.5">Entsorgung</p>
                <p class="inline-block pl-4">
                  @if ($editUsedShelfes->entsorgungssperre == "yes")

                  <span class="text-red-600">Gesperrt</span>

                  @else
                @php
                  $createDate = $editUsedShelfes->created_at;
                  $nowDate = new DateTime();
                @endphp
                @if($editUsedShelfes->entsorgung != null)
                  {{90 - $createDate->diff($nowDate)->d + $editUsedShelfes->entsorgung->days}} Tage
                @else 
                  {{90 - $createDate->diff($nowDate)->d}} Tage
                @endif
              @endif
                </p>
                @isset($editUsedShelfes->entsorgung->days)
                  <button onclick="getMinus('{{$editUsedShelfes->component_number}}')" type="button" class="inline-block px-2 ml-2 py-1 rounded-md bg-red-600 text-white float-right">- 90 Tage</button>
                @endisset
                <button type="button" onclick="getPlus('{{$editUsedShelfes->component_number}}')" class="inline-block px-2 py-1 rounded-md bg-green-600 text-white float-right">+ 90 Tage</button>
              </div>

              <div class="mt-4">
                @if ($editUsedShelfes->entsorgungssperre == "no" || $editUsedShelfes->entsorgungssperre == null)
                  <button type="button" onclick="getEntSperren('{{$editUsedShelfes->component_number}}')" class="px-2 py-1 rounded-md bg-red-600 text-white float-right">Entsorgung sperren</button>
                  @else
                  <button type="button" onclick="getEntSperrenAkt('{{$editUsedShelfes->component_number}}')" class="px-2 py-1 rounded-md bg-green-600 text-white float-right">Entsorgungssperre aufheben</button>
                @endif
              </div>
        </div>
      
        <div class="mt-20">
          <button type="button" onclick="document.getElementById('edit-shelfe-modal').classList.add('hidden')" class="inline-block bg-white border border-gray-600 rounded-md px-2 py-1 float-right">Zurück</button>
        </div>
      
      </div>
    </div>
  </div>
</div>
