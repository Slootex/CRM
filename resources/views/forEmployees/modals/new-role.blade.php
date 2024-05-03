<div class="relative hidden z-10" id="new-role-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
          <div class="float-right">
            <button onclick="document.getElementById('new-role-modal').classList.add('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-600 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
          <form action="{{url("/")}}/crm/neue-rolle-erstellen" method="POST">
            @CSRF
            <div>
                <h1 class="text-xl font-bold">Neue Rolle anlegen</h1>
                <div>
                    <input type="text" name="name" class="w-full rounded-md border border-gray-600 mt-4" placeholder="Rollenname">
                    <input type="text" name="description" class="w-full rounded-md border border-gray-600 mt-4" placeholder="Beschreibung">
                </div>
              </div>
              <div class="mt-5 sm:mt-6">
                <button type="submit" class="inline-block font-semibold text-white rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-1">Speichern</button>
                <button type="button" onclick="document.getElementById('new-role-modal').classList.add('hidden')" class="inline-block font-semibold text-black rounded-md border border-gray-600 px-3 py-1 float-right">Abbrechen</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>