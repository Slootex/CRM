<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 50rem">
          <button type="button"  onclick="document.getElementById('wareneingang-edit-div').classList.add('hidden')" class="px-2 py-2 rounded-md float-right bg-red-600 hover:bg-red-400"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <div>
          <h1 class="text-2xl">Details zur Einlagerung des Gerätes <span class="text-blue-400 underline">{{$eingang->component_number}}</span></h1>
        </div>

        <div>
          <div class="w-full mt-8">
            <p class=" text-lg mb-2">Einlagerungsdaten</p>
            <div class="flex">
                <div class="px-2 py-1 rounded-md border border-gray-300 text-center w-40">
                  <p class="text-center text-gray-400">{{$eingang->created_at->format("d.m.Y (H:i)")}}</p>
                </div>

                <div class="px-2 py-1 rounded-md border border-gray-300 text-center w-40 ml-4">
                    <p class="text-center text-gray-400">{{$users->where("id", $eingang->employee)->first()->username}}</p>
                  </div>
              </div>

            <div class="mt-4">
              <p class=" text-lg mb-2">Einlagerungsartikel</p>
              <div class="px-2 py-1 rounded-md border border-gray-300 text-center w-40">
                <p class="text-center text-gray-400">{{$eingang->component_number}}</p>
              </div>
            </div>

            <div class="mt-4">
              <p class=" text-lg mb-2">Lagerplatz</p>
              <div class="px-2 py-1 rounded-md border border-gray-300 text-center w-40">
                <p class="text-center text-gray-400">{{$eingang->used_shelfe}}</p>
              </div>
            </div>

            <div class="mt-4">
              <p class=" text-lg mb-2">Fragen</p>
              <div class="flex"> 
                @if ($eingang->opened == "on")
                    <div class=" rounded-md border border-green-600 text-center flex px-2 py-1 float-left">
                        <p class="text-center text-green-600 ">Öffnungsspuren?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-green-600">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    @else
                    <div class=" rounded-md border border-red-600 text-center flex px-2 py-1 float-left">
                        <p class="text-center text-red-600 ">Öffnungsspuren?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-red-600">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                          </svg>
                          
                      </div>
                @endif

                @if ($eingang->sticker == "on")
                <div class=" rounded-md border border-green-600 text-center flex px-2 py-1 float-left ml-4">
                  <p class="text-center text-green-600 ">Fremde Kleber?</p>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-green-600">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                  </svg>
                </div>

                @else
                <div class=" rounded-md border border-red-600 text-center flex px-2 py-1 float-left ml-4">
                    <p class="text-center text-red-600 ">Fremde Kleber?</p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-red-600">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                      </svg>
                </div>
                @endif
              </div>
            </div>

            <div class="mt-4">
              <p class=" text-lg mb-2">Fotos</p>
              <div class="flex"> 
                @if ($eingang->auftragsfotos == "on")
                    <div onclick="showAuftragsfotos('{{$eingang->process_id}}', '{{$eingang->component_number}}')" class="rounded-md border border-green-600 text-center flex px-2 py-1 float-left cursor-pointer hover:border-green-400 hover:text-green-400 text-green-600">
                        <p class="text-center  ">Auftragsfotos?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 ">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    @else
                    <div class="rounded-md border border-red-600 text-center flex px-2 py-1 float-left">
                        <p class="text-center text-red-600 ">Auftragsfotos?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-red-600">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                          </svg>
                    </div>
                @endif

                @if ($eingang->gerätefotos == "on")
                <div onclick="showGerätedokumente('{{$eingang->process_id}}', '{{$eingang->component_number}}')" class="rounded-md border border-green-600 text-center flex px-2 py-1 float-left cursor-pointer hover:border-green-400 hover:text-green-400 text-green-600 ml-4">
                    <p class="text-center">Gerätesfotos?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    @else
                    <div class="rounded-md border border-red-600 text-center flex px-2 py-1 float-left ml-4">
                        <p class="text-center text-red-600 ">Gerätesfotos?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 ml-2 text-red-600">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                          </svg>
                    </div>
                @endif
              </div>
            </div>
          </div>

          <div class="w-full mt-8">
            <a href="{{url("/")}}/crm/packtisch/wareneingang-zurück-{{$eingang->id}}" class="float-right bg-red-600 hover:bg-red-400 text-white font-medium text-md px-4 py-2 rounded-md">Rückgängig machen</a>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <div id="dokumente-div" class="w-full hidden">

    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 80rem; height: 60rem;">
              <button type="button"  onclick="document.getElementById('dokumente-div').classList.add('hidden')" class=" mb-4 px-2 py-2 rounded-md float-right bg-red-600 hover:bg-red-400"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            <div class="mt-8" id="dokumente-append">

            </div>
            </div>
          </div>
        </div>
    </div>
  </div>