
    <div class="relative hidden z-10" id="mwst-setting-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
      
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-6" >
              <div class="float-right mr-4 mt-4">
                <button onclick="document.getElementById('mwst-setting-modal').classList.add('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
              <form action="{{url("/")}}/crm/change/mwst-setting" method="POST">
                @CSRF
                <div class="relative">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Mwst</label>
                  <input type="number" name="mwst" id="mwst-setting" value="{{$mwst}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>
                <button class="bg-blue-600 hover:bg-blue-500 rounded-md px-2 py-1 text-white mt-6">Speichern</button>
              </form>
            </div>
          </div>
        </div>
      </div>
