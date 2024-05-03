
    <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
            <div class="relative transform overflow-hidden rounded-lg bg-white  pt-4 pb-4 text-left shadow-xl transition-all" style="height: 28rem; width: 24rem;">
              <div class="float-right mr-4 mt-4">
                <button onclick="document.getElementById('bearbeitenZeiterfassung').classList.add('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
              <form action="{{url("/")}}/crm/zeiterfassung/bearbeiten" method="POST">
                @CSRF
                <input type="hidden" name="employee" value="{{$selectedEmployee->id}}">
                <input type="hidden" name="id" id="bearbeiteZeiterfassungId">
                <div class="" style="padding-left: 1.1rem;">
                  <h1 class="font-bold pb-2">Zeit ändern</h1>
                  <div style="padding-right: 1.1rem;" class="pt-3">
                    <label for="date">Start</label>
                    <input type="datetime-local" name="start" id="start" class="w-full rounded-lg border-gray-600 mt-1 m-auto"  value="{{date('Y-m-d H:i')}}">
                  </div>
                  <div style="padding-right: 1.1rem;" class="pt-3">
                    <label for="date">Ende</label>
                    <input type="datetime-local" name="end" id="end" class="w-full rounded-lg border-gray-600 mt-1 m-auto"  value="{{date('Y-m-d H:i')}}">
                  </div>
                  <div>
                    <div style="padding-right: 1.1rem;" class="pt-3">
                    <label for="date">Hinweis</label>
                    <input type="input" maxlength="20" name="info" id="infochangeChange" class="border px-4 h-10 w-full rounded-lg border-gray-600 mt-1 m-auto">
                    </div>
                  </div>
                  <div>
                    <div style="padding-right: 1.1rem;" class="pt-3">
                      <label for="reason">Grund</label>
                      <select name="reason" id="reason" class="border px-4 h-10 w-full rounded-lg border-gray-600 mt-1 m-auto">
                        <option value="Urlaub">Urlaub</option>
                        <option value="Unfall">Unfall</option>
                      </select>
                      </div>
                  </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                  <div style="padding-left: .64rem;">
                    <button type="button" onclick="document.getElementById('bearbeitenZeiterfassung').classList.add('hidden')" class="float-left w-36 px-1 py-1.5 border border-gray-600 font-semibold text-black rounded-md ml-2">Abbrechen</button>

                  </div>
                  <div style="padding-right: .64rem;">
                    <button type="submit" class="float-right px-1 py-1.5 w-36 bg-blue-600 hover:bg-blue-500 font-semibold text-white rounded-md mr-2">Zeit updaten</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>

      </script>
