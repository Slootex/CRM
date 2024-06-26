
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
            <div class="relative transform overflow-hidden rounded-lg bg-white  pt-4 pb-4 text-left shadow-xl transition-all" style="height: 11rem; width: 20rem;">
              <form action="{{url("/")}}/crm/zeiterfassung/stoppen" method="POST">
                @CSRF
                <input type="hidden" name="employee" value="{{$selectedEmployee->id}}">
                <input type="hidden" name="id" id="stopZeiterfassungId">
                <div class="" style="padding-left: 1.1rem;">
                  <h1 class="font-bold pb-2">Zeit Stoppen</h1>
                  <div style="padding-right: 1.1rem;">
                    <input type="datetime-local" id="dateShowStop" name="date" class="w-full rounded-lg border-gray-600 mt-4 m-auto"  >
                  </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                  <button type="button" onclick="document.getElementById('stopZeiterfassung').classList.add('hidden')" class="float-left ml-4 px-2 py-1.5 border border-gray-600 font-semibold text-black rounded-md ml-2">Abbrechen</button>
                  <button type="submit" class="float-right px-2 py-1.5 bg-blue-600 hover:bg-blue-500 font-semibold text-white rounded-md mr-4">Zeit buchen</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>

      </script>
