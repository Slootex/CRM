<form action="{{url("/")}}/crm/rechnung/change-audiofile" method="POST" enctype="multipart/form-data">
  @CSRF
    <div class="relative z-50" id="audiofile-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <div class=" transform overflow-hidden rounded-lg bg-white px-4 pt-4 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-6" style="width: 30rem">
              <div>
                <div class="">
                  <div>
                  </div>
                  <div class="">
                    <input type="hidden" name="rechnungsnummer" id="audio-rechnungsnummer">
                    <h1>Kundenadresse</h1>
                    <div class="border border-gray-300 rounded-md px-2 py-2">
                      <div class="flex">
                        <p class="text-gray-400 truncate" style="max-width: 80%;"><span id="audio-name"></span> <span id="audio-streettop"></span></p>
                        <p class=" text-right ml-4"><span class="text-blue-600"><button type="button" onclick="document.getElementById('audio-address').classList.remove('hidden')">ändern</button></span></p>
                      </div>
                      <div class="mt-2">
                        <p class="text-gray-400 text-sm">Lieferung an</p>
                        <p class="text-gray-400 text-sm truncate" style="max-width: 90%;" id="audio-shipaddress"></p>
                      </div>
                    </div>
                  </div>
                  <div class="mt-4">
                    <div class="inline-block w-48">
                      <h1 class=" text-left">Durchgeführte arbeiten</h1>
                    </div>
                    <div class="inline-block w-48 ml-10" >
                      <select name="worktype" id="audio-worktype" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                        <option value="Überholung">Überholung</option>
                        <option value="Auftrag">Auftrag</option>
                        <option value="Retour">Retour</option>
                      </select>
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-48">
                      <h1 class=" text-left">Bearbeitungszeit</h1>
                    </div>
                    <div class="inline-block w-48 ml-10">
                      <input type="number" name="worktime" id="audio-worktime" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-48">
                      <h1 class=" text-left">An Telefonhistorie</h1>
                    </div>
                    <div class="inline-block w-48 ml-10">
                      <input id="tophone-no" name="tophone" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="tophone-yes" name="tophone" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Aufnahme Einverständniss 1</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="acceptone-no" name="acceptone" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="acceptone-yes" name="acceptone" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Mündlicher Vertrag</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="talkaccept-no" name="talkaccept" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="talkaccept-yes" name="talkaccept" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Gesprächspartner</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input type="text" name="talkname" id="audio-talkname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Versand nach Zahlungseingang</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="shipafterpay-no" name="shipafterpay" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="shipafterpay-yes" name="shipafterpay" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left text-red-600 font-semibold">Freigabe / Preis OK</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="priceok-no" name="priceok" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="priceok-yes" name="priceok" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left text-red-600 font-semibold">Rücknahmebelehrung</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="takebacktalk-no" name="takebacktalk" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="takebacktalk-yes" name="takebacktalk" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Geburstag</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input type="date" name="birthday" id="audio-birthday" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Aufnahme Einverständniss 2</h1>
                    </div>
                    <div class="inline-block w-44 ml-10">
                      <input id="accepttwo-no" name="accepttwo" type="radio" checked class="h-5 w-5 border-gray-300 text-red-800 focus:ring-red-800 float-right mr-3 bg-red-600">
                      <input id="accepttwo-yes" name="accepttwo" type="radio"  class="h-5 w-5 border-gray-300 text-green-800 focus:ring-green-800 float-right mr-6 bg-green-600">
                    </div>
                  </div>

                  <hr class="py-2">

                  <div class="mt-4">
                    <div class="inline-block w-52">
                      <h1 class=" text-left">Audiodatei hochladen</h1>
                    </div>
                    <div class="inline-block w-36 ml-10">
                      <div class=" bg-grey-lighter">
                        <label class="float-left w-full text-sm flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                            
                            <span class="mt-0 text-sm leading-normal"><span class="float-left" id="audiofile"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg></span>
                            <input type='file' oninput="document.getElementById('audiofile').innerHTML = this.value.split('\\')[this.value.split('\\').length - 1]" class="hidden" name="audiofile" id="emailvorlage-fileinput" />
                        </label>
                       
                    </div>
                    </div>
                    <a target="_blank" id="read-audiofile" class="inline-block hidden float-right" href="">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400 mr-2 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                      </svg>
                      
                    </a>
                  </div>
                  
                </div>
              </div>
                <button type="submit" onclick="" class="float-left mt-6 w-36 justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Speichern</button>
                <button type="button" onclick="document.getElementById('audiofile-modal').classList.add('hidden')" class="float-right mt-6 w-36 justify-center rounded-md bg-whute px-4 py-2 text-base font-medium text-black shadow-sm border border-gray-600 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Abbrechen</button>
            
            </div>
          </div>
        </div>
      </div>



      <div class="relative hidden z-10" id="audio-address" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-4 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-6" style="width: 30rem">
              <h1 class="font-semibold">Kundenadresse</h1>
              
              <div class="mt-4">
                <div class="w-48 inline-block">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Vorname</label>
                  <div class="mt-2">
                    <input type="text" name="firstname" value="{{$order->firstname}}" id="audio-firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
                <div class="w-48 inline-block ml-6 float-right">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Nachname</label>
                  <div class="mt-2">
                    <input type="text" name="lastname" value="{{$order->lastname}}" id="audio-lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <div class="w-48 inline-block">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Straße</label>
                  <div class="mt-2">
                    <input type="text" name="street" value="{{$order->home_street}}" id="audio-street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
                <div class="w-48 inline-block ml-6 float-right">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Nr</label>
                  <div class="mt-2">
                    <input type="text" name="streetno" value="{{$order->home_street_number}}" id="audio-streetno" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <div class="w-48 inline-block">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Postleitzahl</label>
                  <div class="mt-2">
                    <input type="text" name="zipcode" value="{{$order->home_zipcode}}" id="audio-zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
                <div class="w-48 inline-block ml-6 float-right">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Stadt</label>
                  <div class="mt-2">
                    <input type="text" name="city" value="{{$order->home_city}}" id="audio-city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Land</label>
                <select id="audio-country" name="country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                  <option value="{{$order->home_country}}" selected>{{$order->home_country}}</option>
                  @foreach ($countries as $countrie)
                      @if ($countrie->name == "Deutschland")
                       <option value="{{$countrie->id}}">{{$countrie->name}}</option>
                       @else 
                       <option value="{{$countrie->id}}">{{$countrie->name}}</option>
                      @endif
                  @endforeach
                </select>
              </div>
              <hr class="py-2">
              <div class="mt-4">
                <button type="button" onclick="saveAudioAdress()" class="inline-block bg-blue-600 hover:bg-blue-500 text-white font-semibold text-center px-4 py-2 rounded-md">Speichern</button>
                <button type="button" onclick="document.getElementById('audio-address').classList.add('hidden')" class="inline-block border border-gray-600 font-semibold float-right text-center px-4 py-2 rounded-md">Abbrechen</button>

              </div>

            </div>
          </div>
        </div>
      </div>
</form>
      <script>
        function saveAudioAdress() {
          
          let firstname = document.getElementById('audio-firstname').value;
          let lastname = document.getElementById('audio-lastname').value;
          let street = document.getElementById('audio-street').value;
          let streetno = document.getElementById('audio-streetno').value;
          let zipcode = document.getElementById('audio-zipcode').value;
          let city = document.getElementById('audio-city').value;
          let country = document.getElementById('audio-country').value;

          document.getElementById('audio-name').innerHTML = firstname + ' ' + lastname;
          document.getElementById('audio-streettop').innerHTML = street + ' ' + streetno + ', ' + zipcode + ', ' + city;
          document.getElementById('audio-shipaddress').innerHTML = firstname + ' ' + lastname + ', ' + street + ' ' + streetno + ', ' + zipcode + ', ' + city;

          document.getElementById('audio-address').classList.add('hidden');
        }
        saveAudioAdress();
      </script>