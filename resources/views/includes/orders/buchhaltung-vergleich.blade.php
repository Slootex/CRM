<div class="relative hidden z-50" id="vergleich-div-main" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 40rem;">
          <h1 class="py-2 text-xl font-semibold">Neuen Vergleich erstellen</h1>
          <div class="flex">

            <select id="location" name="location" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
              <option>Vergleich</option>
              <option selected>Canada</option>
              <option>Mexico</option>
            </select>

            <div class="relative mt-2 rounded-md shadow-sm ml-4">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm">€</span>
              </div>
              <input type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00" aria-describedby="price-currency">
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <span class="text-gray-500 sm:text-sm" id="price-currency">EUR</span>
              </div>
            </div> 
            
            <button class="ml-4 text-white bg-blue-600 hover:bg-blue-500 rounded-md px-4 py-1 font-medium text-sm">
              Speichern
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>