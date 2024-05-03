<div class="relative z-50" id="checkbpz-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Beipackzettel speichern</h3>
              <div class="mt-4">
                <p>Dateiname</p>
                <input type="text" name="filename" id="bpz-newfile-name" class="mt-1 border border-gray-300 w-full rounded-md">
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-4 ">
            <button type="button" onclick="bpzNewFile()" class="mt-3 float-left w-full justify-center rounded-md bg-blue-600 hover:bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:mt-0 sm:w-auto">Speichern</button>
            <button type="button" onclick="document.getElementById('checkbpz-modal').classList.add('hidden'); newAlert('Daten gespeichert!', 'Die Kundendaten/Gerätedaten wurden erfolgreich gespeichert.');" class="mt-3 float-right w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    
  </script>