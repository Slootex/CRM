
    <div class="relative hidden z-10" id="bookmark-files" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6" >
              <div class="float-right mr-4 mt-4">
                <button onclick="document.getElementById('bookmark-files').classList.add('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
             <table>
              <th class="">
                <td class="w-60 text-left font-semibold border border-t-0 border-l-0 border-r-0 border-gray-600">Name</td>
                <td class="w-60 text-left font-semibold border border-t-0 border-l-0 border-r-0 border-gray-600">Pfad</td>
              </th>
              
              @foreach ($files as $file)
                  @if ($file->dateimangager_system == "true")
                      <tr class="py-1">
                        <td class="py-1"></td>
                        <td class="py-1">{{$file->filename}}</td>
                        <td class="py-1 text-blue-600">{{public_path()}}\dateimanager\{{$file->filename}}</td>
                      </tr>
                  @endif
              @endforeach

             </table>

             <button onclick="document.getElementById('bookmark-files').classList.add('hidden')" class="float-left mt-6 bg-white text-black rounded-md border border-gray-600 font-semibold px-4 py-2">Zurück</button>
            </div>
          </div>
        </div>
      </div>

