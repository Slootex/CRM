<div class="relative z-10" style="" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" id="dropdownMenuu">
    <!-- Background backdrop, show/hide lgd on slide-over state. -->
    <div class="fixed inset-0"></div>
  
    <div class="fixed inset-0 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden">
        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
          <!--
            Slide-over panel, show/hide lgd on slide-over state.
  
            Entering: "transform transition ease-in-out duration-500 base:duration-700"
              From: "translate-x-full"
              To: "translate-x-0"
            Leaving: "transform transition ease-in-out duration-500 base:duration-700"
              From: "translate-x-0"
              To: "translate-x-full"
          -->
          <div class="pointer-events-auto  max-w-md">
            <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl px-6">
              <div class="px-4 base:px-6">
                <div class="flex items-start justify-between">
                  <h2 class="text-lg font-semibold leading-6 text-gray-900" id="slide-over-title">Profileinstellungen</h2>
                  <div class="ml-3 flex h-7 items-center">
                    <button onclick="closeMenu()" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                      <span class="sr-only">Close panel</span>
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                  <script>
                    function closeMenu() {
                      document.getElementById('profileSettings').classList.toggle("hidden");
                    }
                  </script>
                  
                </div>
                <h2 class="text-base font-light leading-6 text-gray-600" id="slide-over-title">Hier können Sie ihren Account bearbeiten</h2>
              </div>
              <div class="relative mt-6 flex-1 px-2 base:px-6">
                <div>
                    <img src="{{url("/")}}/employee/{{auth()->user()->id}}/profile.png" class="m-auto rounded-full border border-gray-600 w-44 h-44" onerror="this.onerror=null; this.src='{{url("/")}}/img/santa.png'" >
                </div>
                
                <div class="mt-6">
                    <h2 class="text-lg font-semibold leading-6 text-gray-900" id="slide-over-title">Profilbild</h2>
                    <label class=" flex flex-col items-center text-base italic text-blue-600 mt-1 float-left">
                      
                        <span class="mt-0 text-base leading-normal"><span class="float-left" id="filename">Datei</span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg></span>
                        <input type='file' oninput="document.getElementById('filename').innerHTML = this.value" class="hidden" name="file" />
                    </label>
                    <h3 class="text-base italic text-blue-600 mt-1 float-left"></h3>
                    <h3 class="text-base italic text-blue-600 mt-1 float-left ml-6"><a href="{{url("/")}}/crm/profile/picture/delete/{{auth()->user()->id}}">Löschen</a></h3>
                </div>
                <script>
                    let changeUserEdit = false;
                    function changeProfileEditMode() {
                        if(changeUserEdit == false) {
                            document.getElementById("name-p").classList.add("hidden");
                            document.getElementById("name").classList.remove("hidden");

                            document.getElementById("user-p").classList.add("hidden");
                            document.getElementById("user").classList.remove("hidden");

                            document.getElementById("pw-p").classList.add("hidden");
                            document.getElementById("pw").classList.remove("hidden");

                            changeUserEdit = true;
                        } else {
                            document.getElementById("name-p").classList.remove("hidden");
                            document.getElementById("name").classList.add("hidden");

                            document.getElementById("user-p").classList.remove("hidden");
                            document.getElementById("user").classList.add("hidden");

                            document.getElementById("pw-p").classList.remove("hidden");
                            document.getElementById("pw").classList.add("hidden");

                            changeUserEdit = false;
                        }

                    }
                </script>
                <div class="mt-16 w-full">
                    <table class="w-full">
                            <tr class="">
                                <td class="text-left font-semibold">Profil</td>
                            <td class="text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" onclick="changeProfileEditMode()" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 text-right float-right">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                              </svg>
                              </td>
                            </tr>

                            <tr class="border border-l-0 border-r-0  ">
                                <td class="text-base py-2 text-left text-gray-600">Name</td>
                                <td class="text-base font-normal py-2 text-right"><p id="name-p">{{auth()->user()->name}}</p>
                                    <input type="text" id="name" value="{{auth()->user()->name}}" name="name" class="hidden h-6 w-36 text-base font-normal py-2 text-center rounded-md border-gray-600">
                                </td>
                            </tr>
                            <tr class="border border-l-0 border-r-0  ">
                                <td class="text-base py-2 text-left text-gray-600">Username</td>
                                <td class="text-base font-normal py-2 text-right"><p id="user-p">{{auth()->user()->username}}</p>
                                    <input type="text" id="user" value="{{auth()->user()->username}}" name="username" class="hidden h-6 w-36 text-base font-normal py-2 text-center rounded-md border-gray-600">
                                </td>
                            </tr>
                            <tr class="border border-l-0 border-r-0  ">
                                <td class="text-base py-2 text-left text-gray-600">Passwort</td>
                                <td class="text-base font-normal py-2 text-right"><p id="pw-p">********</p>
                                    <input type="text" id="pw" value="" name="password" class="hidden h-6 w-36 text-base font-normal py-2 text-center rounded-md border-gray-600">
                                </td>
                            </tr>
                            <tr class="border border-l-0 border-r-0  ">
                                <td class="text-base py-2 text-left text-gray-600">Zuletzt geändert</td>
                                <td class="text-base font-normal py-2 text-right">{{auth()->user()->updated_at->format("d")}} {{auth()->user()->updated_at->format("M")}} {{auth()->user()->updated_at->format("Y")}}</td>
                            </tr>
                    </table>
                </div>
                <div class="mt-16 w-full">
                    <h2 class="text-lg font-semibold leading-6 text-gray-900" id="slide-over-title">E-Mail Signatur</h2>
                    <h2 class="text-base font-light leading-6 text-gray-600 italic w-60 float-left">Speichern Sie die HTML Code und Datei speichern</h2>
                    <h2 class="float-right"> <svg onclick="changeEmailSignatur()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 text-right float-right">
                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                      </svg></h2>
                </div>
                <div class="mt-20 w-full">
                    <h2 class="text-lg font-semibold leading-6 text-gray-900 pb-4" id="slide-over-title">E-Mail Adresse</h2>
                    <hr class="py-2">
                    <h2 id="email-p" class="text-base font-normal leading-6 w-60 float-left">{{auth()->user()->email}}</h2>
                    <input id="email" value="{{auth()->user()->email}}" type="text" name="email-input" class="hidden text-base font-normal leading-6 w-36 float-left rounded border-gray-600 h-6">
                    <h2 onclick="changeEmailUser()" class="text-base font-normal leading-6 float-right text-blue-600">ändern</h2>
                </div>
                <div class="mt-20">
                    <button class="float-left bg-blue-600 hover:bg-blue-500 text-white rounded-md px-10 font-semibold py-1 border border-blue-600 mr-2">Speichern</button>
                    <button type="button" onclick="closeMenu()" class="float-right bg-white text-black border border-gray-600 rounded-md px-10 font-semibold py-1 ml-2">Abbrechen</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    let emailUserState = false;
    function changeEmailUser() {
        if(emailUserState == false) {
            document.getElementById("email-p").classList.add("hidden");
            document.getElementById("email").classList.remove("hidden");
            emailUserState = true;
        } else {
            document.getElementById("email-p").classList.remove("hidden");
            document.getElementById("email").classList.add("hidden");
            emailUserState = false;
        }
    }

    function changeEmailSignatur() {
      document.getElementById("email-signatur").classList.toggle("hidden");
    }
  </script>

