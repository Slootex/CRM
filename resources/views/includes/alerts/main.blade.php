<div class="relative hidden z-50" id="alert-main" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
          <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
              <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
              <h3 class="text-base font-semibold leading-6 text-gray-900"  id="alert-title"></h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500" id="alert-text"></p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6">
            <button type="button" onclick="document.getElementById('alert-main').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function newAlert(title, text) {
        document.getElementById("alert-title").innerHTML = title;
        document.getElementById("alert-text").innerHTML = text;

        document.getElementById("alert-main").classList.remove("hidden");
    }
  </script>