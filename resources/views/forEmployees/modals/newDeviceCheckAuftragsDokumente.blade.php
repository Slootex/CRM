<div class="relative hidden z-10" id="auftragsdokumente-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6" style="height: 70%">
          <div class="float-right mr-4 mt-4">
            <button onclick="document.getElementById('auftragsdokumente-modal').classList.add('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-600 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
          <br>
          <br>
          <div>

            <div class="">
              <div class="m-auto ml-4">
                <div class=" flex h-12 w-12 items-center justify-center rounded-full bg-green-100 m-auto">
                  <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                </div>
              </div>
              <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-sm text-gray-500 ml-4" id="modal-title">Datei Erfolgreich hochgeladen</h3>
                <div class="mt-2 ml-4">
                  <p class="text-base text-gray-900 font-semibold leading-6">Bitte Dokumente vor <span class="font-bold text-lg text-red-600">Bestätigung</span> überprüfen</p>
                </div>
                <div class="w-full h-full mt-4" id="auftragsdokument-pdf">
  
                </div>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6">
            @isset($barcode)
              <button type="button" onclick="saveOrderDocuments('{{$barcode}}', '{{$barcode}}')" class="float-left px-6 py-3 rounded-md bg-green-600 text-xl text-white font-semibold">Bestätigen</button>
            @else
              <button type="button" onclick="@isset($device->component_number) saveOrderDocuments('{{$device->component_number}}', '{{$kunde->process_id}}') @else saveOrderDocuments('{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}', '{{$kunde->process_id}}') @endisset" class="float-left px-6 py-3 rounded-md bg-green-600 text-xl text-white font-semibold">Bestätigen</button>
            @endisset
            <button type="button" onclick="document.getElementById('auftragsdokumente-modal').classList.add('hidden')" class="float-right px-6 py-3 rounded-md bg-white text-xl text-black border border-gray-600 font-semibold">Abbrechen</button>

          </div>
        </div>
      </div>
    </div>
  </div>