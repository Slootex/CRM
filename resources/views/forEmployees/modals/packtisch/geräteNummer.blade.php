<div class="relative hidden z-10" id="bignummer-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6" style="height: 40rem">
          <div>
            
            <div class="mt-60 text-center">
              <h3 class="text-3xl font-semibold leading-6 text-gray-900" id="auftragsnummer-big"></h3>
            </div>
          </div>
          <div class="mt-60">
            <button type="button" onclick="document.getElementById('bignummer-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-8 text-2xl font-semibold text-white shadow-sm hover:bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
            function showAuftragsnummer(id) {
          document.getElementById('auftragsnummer-big').innerHTML = id;
          document.getElementById('bignummer-modal').classList.remove('hidden');
        }
  </script>