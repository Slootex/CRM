<div class="relative z-10" id="change-profil-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6">
          <div class="float-right mr-4 mt-4">
            <button onclick="document.getElementById('change-profil-modal').classList.add('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-600 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
          <div class="w-full h-10">
            <h1 class="font-semibold">
                Profil bearbeiten
            </h1>
            <p class="text-gray-500">
                Zuletzt geändert <span class="text-gray-600">{{$changedUser->updated_at->format("d.m.Y")}}</span>
            </p>
          </div>

          <div class="mt-10">
            <form action="{{url("/")}}/crm/benutzer-speichern-{{$changedUser->id}}" enctype="multipart/form-data" method="POST" id="save-benutzer">
              @CSRF
            <div class="grid grid-cols-2">
                <div class="mr-6">
                    <div class="float-left w-20 h-20 mr-4">
                        <img src="{{url("/")}}/employee/{{$changedUser->id}}/profile.png" onerror="this.onerror=null; this.src='{{url("/")}}/test.png'" alt="" class="rounded-full w-20 h-20" >
                    </div>
                    <div class="">
                        <h1 class="font-semibold text-xl">Profilbild</h1>
                        <div class=" bg-grey-lighter ">
                            <label class="float-left ml-1 mr-4 flex flex-col items-center  py-1 bg-white text-blue rounded-lg tracking-wide cursor-pointer hover:bg-blue text-blue-600 hover:text-blue-400">
                                <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-6 h-6 float-right mt-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg></span>
                                <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value" class="hidden" name="file" id="emailvorlage-fileinput" />
                            </label>
                            <button type="button" class="float-left" id="emailvorlage-bearbeiten-remove-pdf">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 mt-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                              </svg>                    
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ml-6">
                    <label for="rolle">Rolle auswählen</label>
                    <select required name="role" id="rolle" class="w-full h-10 rounded-md border border-gray-600 text-lg" id="">
                        @if($changedUser->getRoleNames()->first() != null)
                            <option selected value="{{$rollen->where("name", $changedUser->getRoleNames()->first())->first()->id}}">{{$changedUser->getRoleNames()->first()}}</option>
                        @endif
                        @foreach ($rollen as $rolle)
                            @if($changedUser->getRoleNames()->first() != null)
                              @if($rolle->name != $changedUser->getRoleNames()->first())
                                <option value="{{$rolle->id}}">{{$rolle->name}}</option>
                              @endif
                            @else
                                <option value="{{$rolle->id}}">{{$rolle->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="mr-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Nutzername</label>
                  <div class="mt-2">
                    <input required type="text" name="username" id="email" value="{{$changedUser->username}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>
                <div class="ml-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                  <div class="mt-2">
                    <input required type="text" name="name" id="email" value="{{$changedUser->name}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>


                <div class="mr-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Passwort</label>
                  <div class="mt-2">
                    <input type="password" name="password" value="" id="soll" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>
                <div class="ml-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">E-Mail</label>
                  <div class="mt-2">
                    <input type="email" name="email" id="soll" value="{{$changedUser->email}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>

                <div class="mr-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Arbeitszeit</label>
                  <div class="mt-2">
                    <input type="text" name="workdays" value="{{$changedUser->workdays}}" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                    <input type="text" name="workhours" value="{{$changedUser->workhours}}" id="email" class="block w-full rounded-md border-0 py-1.5 mt-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>
                <div class="ml-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Stunden pro Tag</label>
                  <div class="mt-2">
                    <input type="time" name="soll" id="soll" value="{{$changedUser->soll}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>

                <div class="mr-6 mt-6">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Erlaubte Urlaubstage</label>
                  <div class="mt-2">
                    <input type="number" name="allowed_vacations" value="{{$changedUser->allowed_vacations}}" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="">
                  </div>
                </div>

                <div class="col-span-2 mt-6">
                  <label for="comment" class="block text-md font-medium leading-6 text-gray-900">E-Mail Signatur</label>
                  <label for="comment" class="block text-sm font-medium leading-6 text-gray-600">Speichern Sie die persönliche E-Mail Signatur ab</label>
                  <div class="mt-2">
                    <textarea name="signatur" id="signatur-edit-edit" class="">{{$changedUser->signatur}}</textarea>
                  </div>
                </div>


                
            </div>

            <div>
              <button type="submit" id="save-benutzer-submitbutton-change" class="w-0 h-0"></button>
              <button type="button" onclick="submitProfileChangeEdit()" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-md px-3 py-1.5 w-36 mt-10 float-left">
                Speichern
              </button>
             
              <button type="button" onclick="document.getElementById('change-profil-modal').classList.add('hidden')" class="text-black border border-gray-600 font-semibold rounded-md px-3 py-1.5 w-36 mt-10 float-right">
                Abbrechen
              </button>

              <a type="button" href="{{url("/")}}/crm/benutzer-löschen-{{$changedUser->id}}" class="bg-red-600 text-center mr-6 text-white font-semibold rounded-md px-3 py-1.5 w-36 mt-10 float-right">
                Löschen
              </a>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $.trumbowyg.svgPath = '/icons.svg';
    $('#signatur-edit-edit').trumbowyg();    

    function submitProfileChangeEdit() {
      document.getElementById('signatur-edit-edit').value = $('#signatur-edit-edit').trumbowyg('html');
      document.getElementById('save-benutzer-submitbutton-change').click();
    }
  </script>