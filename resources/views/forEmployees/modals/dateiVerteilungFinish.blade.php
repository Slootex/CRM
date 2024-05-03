    <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="finishFiles">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8  sm:w-96 ">
              <div class="float-right mr-4 mt-4">
                <button onclick="document.getElementById('finishFiles').classList.add('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
              <div class="pt-4 pl-4">
                <h1 class="text-normal font-normal text-black">Verteilte Dateien</h1>
                <h2 class="text-sm font-ligh text-gray-600">Hier werden die gerade Verteilte dateien in den zugewieseenen Aufträgen angezeigt</h2>
              </div>
              <div class="py-6">
                <hr class="w-96">
              </div>
              @if (!empty($deletedFiles))
                <table class="pl-4">
                  <th class="text-normal font-normal px-8">Name</th>
                  <th class="text-normal font-normal px-8">Auftrag</th>
                  @foreach ($deletedFiles as $file)
                  <tr class="border border-l-0 border-r-0">
                    <td class="text-left pl-4"><p class="text-blue-600">{{$file->filename}}</p></td>
                    <td class="text-left pl-4"><p class="text-blue-600">{{$file->process_id}}</p></td>
                  </tr>
                  @endforeach
                </table>
               

                @else

                <h1 class="text-center text-normal font-normal text-red-600">Keine Datein verteilt.</h1>
                
              @endif
              <div class="py-6 pl-4">
                <hr class="w-96">
              </div>

              <div class="pt-0 pl-4">
                <h1 class="text-normal font-normal text-black"><span class="text-red-600">Nicht</span> Verteilte Dateien</h1>
                <h2 class="text-sm font-ligh text-gray-600">Hier werden die Dateien angezeigt nicht nicht zugeteilt werden konnten</h2>
              </div>
              <div class="py-6 pl-4">
                <hr class="w-96">
              </div>
              @if (!empty($notFoundFiles))
                <table class="pl-4">
                  <th class="text-normal font-normal text-left pl-4">Name</th>
                  @foreach ($notFoundFiles as $file)
                  <tr class="border border-l-0 border-r-0 pl-4">
                    <td class="text-left pl-4"><p class="text-blue-600">{{$file->filename}}</p></td>
                  </tr>
                  @endforeach
                </table>
               

                @else

                <h1 class="text-center text-normal font-normal text-green-600">Alles gefunden</h1>
                
              @endif
              <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 py-2 pr-2">
                <button type="button" onclick="closeFinish()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function closeFinish() {
          document.getElementById('finishFiles').classList.add("hidden");
        }
      </script>
