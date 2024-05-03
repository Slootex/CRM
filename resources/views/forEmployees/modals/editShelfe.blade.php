
<div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="edit-shelfe-modal">
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
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6 " style="width: 28rem;">
        <div>
              <div>
                <h1 class="font-semibold text-xl inline-block">Gerät bearbeiten</h1>
                <button class="inline-block py-1 px-1 bg-red-600 rounded-md float-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </button>
              </div>

              <div class="mt-8">
                <p class="inline-block">Gerät</p>
                <a target="_blank" href="{{url("/")}}/crm/change/order/{{$editUsedShelfes->component_number}}" class="inline-block pl-12 text-blue-500">{{$editUsedShelfes->component_number}}</a>
                <button class="inline-block px-2 py-1 rounded-md bg-blue-600 hover:bg-blue-500 text-white float-right">Zuweisung ändern</button>
              </div>

              <div class="mt-4">
                <form action="{{url("/")}}/crm/change-shelfe" method="POST">
                  @CSRF
                  <input type="hidden" name="component_number" value="{{$editUsedShelfes->component_number}}">
                <p class="inline-block pr-12 mr-1.5">Lagerplatz</p>
                <select onchange="document.getElementById('change-shelfe-button').classList.remove('hidden')" class="inline-block w-20 rounded-md border-gray-600" name="" id="">
                  <option value="{{$editUsedShelfes->shelfe_id}}" selected>{{$editUsedShelfes->shelfe_id}}</option>
                  @foreach ($allShelfes as $shelfe)
                      @if ($shelfe->shelfe_id != $editUsedShelfes->shelfe_id)
                          <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                      @endif
                  @endforeach
                </select>

                <div class="relative hidden z-10" id="save-shelfe-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="sm:flex sm:items-start">
                          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                          </div>
                          <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Lagerplatz geändert</h3>
                            <div class="mt-2">
                              <p class="text-sm text-gray-500">Achtung: Bei Lagerplatzänderungen wird ein Umlagerungsauftrag am Packtisch erstellt.</p>
                            </div>
                          </div>
                        </div>
                        <div class="mt-5 sm:ml-10 sm:mt-4 sm:flex sm:pl-4">
                          <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Änderungen speichern</button>
                          <button type="button" onclick="document.getElementById('save-shelfe-modal').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Abbrechen</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <button type="button" id="change-shelfe-button" onclick="document.getElementById('save-shelfe-modal').classList.remove('hidden')" class="inline-block hidden ml-4 px-4 py-2 rounded-md bg-green-600 text-white font-medium float-right">Übernehmen</button>
              
                </form>
              </div>

              <div class="mt-4">
                <p class="inline-block pr-12 mr-1.5">Entsorgung</p>
                <p class="inline-block pl-4">
                  @if ($editUsedShelfes->entsorgungssperre == "yes")

                  <span class="text-red-600">Gesperrt</span>

                  @else
                @php
                  $createDate = $editUsedShelfes->created_at;
                  $nowDate = new DateTime();
                @endphp
                @if($editUsedShelfes->entsorgung != null)
                  {{90 - $createDate->diff($nowDate)->d + $editUsedShelfes->entsorgung->days}} Tage
                @else 
                  {{90 - $createDate->diff($nowDate)->d}} Tage
                @endif
              @endif
                </p>
                @isset($editUsedShelfes->entsorgung->days)
                  <a type="button" href="{{url("/")}}/crm/entsorgung/minustime/{{$editUsedShelfes->component_number}}" class="inline-block px-2 ml-2 py-1 rounded-md bg-red-600 text-white float-right">- 90 Tage</a>
                @endisset
                <a type="button" href="{{url("/")}}/crm/entsorgung/extendtime/{{$editUsedShelfes->component_number}}" class="inline-block px-2 py-1 rounded-md bg-green-600 text-white float-right">+ 90 Tage</a>
              </div>

              <div class="mt-4">
                @if ($editUsedShelfes->entsorgungssperre == "no" || $editUsedShelfes->entsorgungssperre == null)
                  <a href="{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-aktivieren/{{$editUsedShelfes->component_number}}" class="px-2 py-1 rounded-md bg-red-600 text-white float-right">Entsorgung sperren</a>
                  @else
                  <a href="{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-deaktivieren/{{$editUsedShelfes->component_number}}" class="px-2 py-1 rounded-md bg-green-600 text-white float-right">Entsorgungssperre aufheben</a>
                @endif
              </div>
        </div>
      
        <div class="mt-20">
          <button type="button" onclick="document.getElementById('edit-shelfe-modal').classList.add('hidden')" class="inline-block bg-white border border-gray-600 rounded-md px-2 py-1 float-right">Zurück</button>
        </div>
      
      </div>
    </div>
  </div>
</div>
