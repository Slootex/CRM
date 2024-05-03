<div class="relative z-10" id="feiertage-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8  w-3/5 sm:p-6">
          
            <div class="">
                <div class="mt-8 flow-root">
                  <div class=" -my-2 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                      <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                          <tr>
                            <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Datum</th>
                            <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Name</th>
                            <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-0">
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          @foreach ($feiertage as $day)
                          <tr id="{{$day->id}}-feiertag">
                            <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$day->datum}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$day->bezeichnung}}</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 text-right text-s font-medium sm:pr-0">
                              <button type="button" onclick="document.getElementById('feiertag-delete-modal').classList.remove('hidden')" class="bg-red-600 hover:bg-red-400 rounded-md text-white font-medium text-md px-4 py-1 float-right">Löschen</button>
                            </td>
                          </tr>
                          @endforeach
              
                          <!-- More people... -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            <button onclick="document.getElementById('feiertage-modal').remove();" type="button" class="float-right border-gray-600 rounded-md px-4 py-2 text-md font-medium border mt-4">
                Zurück
            </button>
        </div>
      </div>
    </div>
  </div>


  <div class="relative hidden z-50" id="feiertag-delete-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Feiertag löschen</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">Möchten Sie sicher den Feiertag löschen?</p>
              </div>
            </div>
          </div>
          <div class=" mt-8">
            <button type="button"  onclick="deleteFeiertag('{{$day->id}}'); document.getElementById('feiertag-delete-modal').classList.add('hidden');" class="float-left w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Löschen</button>
            <button type="button" onclick="document.getElementById('feiertag-delete-modal').classList.add('hidden')" class="mt-3 float-right w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  