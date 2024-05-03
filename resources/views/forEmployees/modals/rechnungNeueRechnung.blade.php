
    <div class="relative z-40 hidden" id="rechnung-neue-rechnung-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
        <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
          <div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
            <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="margin-top: -10rem; width: 80rem;">
              
               <div class="px-6 pt-0 float-left w-full">
                
                <div class="w-full h-10">
                  <h1 class="text-2xl font-bold  float-left">Rechnungspositionen</h1>
                <div class="float-right mr-4">
                  <button onclick="document.getElementById('rechnung-neue-rechnung-modal').classList.add('hidden')" class="float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>         
                </div>
                </div>
                <form class="mt-2" action="" method="POST" id="neue-rechnung-zusammenfassen-form">
                  @CSRF
                  <div class="pb-4">
                    <select id="neue-rechnung-modal-select-type" name="type" onchange="document.getElementById('neue-rechnung-modal-type').value = this.value; changeNeueRechnungType(this.value)" class="float-left  block w-60 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      <option value="Rechnung">Rechnung</option>
                      <option value="Angebot">Angebot</option>
                      <option value="Gutschrift">Gutschrift</option>
                    </select>
                    <select id="neue-rechnung-modal-select-rechnungstext" required name="rechnungstext" onchange="document.getElementById('neue-rechnung-modal-type').value = this.value;" class="float-left ml-4 block w-60 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      <option value="">Rechnungstexte</option>
                      @foreach ($rechnungstexte as $text)
                          <option value="{{$text->id}}">{{$text->title}}</option>
                      @endforeach
                    </select>
                    <div class="relative float-left ml-4" id="zahlungsziel-neue-rechnung">
                      <label for="zahlungsziel" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-red-600">Zahlungsziel</label>
                      <input type="text" required name="zahlungsziel" id="zahlungsziel" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                    
                    <script>
                      let mwstState = false;
                      function toggleMwSt() {
                        if(mwstState == false) {
                          document.getElementById("rechnung-mwst-button").classList.remove("bg-gray-600");
                          document.getElementById("rechnung-mwst-button").classList.add("bg-green-600");
                          document.getElementById("neue-rechnung-mwst-check").checked = true;
                          document.getElementById("rechnung-mwst-button").innerHTML = "MwSt aktiviert";
                          mwstState = true;
                        } else {
                          document.getElementById("rechnung-mwst-button").classList.add("bg-gray-600");
                          document.getElementById("rechnung-mwst-button").classList.remove("bg-green-600");
                          document.getElementById("neue-rechnung-mwst-check").checked = false;
                          document.getElementById("rechnung-mwst-button").innerHTML = "MwSt deaktiviert";
                          mwstState = false;
                        }
                      }
                    </script>
          

                    <button type="button" onclick="neueRechnungsPosition()" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-md float-right">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Neue Position                      
                    </button>

                    <button type="button" onclick="neueRabattPosition()" class="px-4 py-1.5 bg-yellow-600 text-white rounded-md float-right mr-4">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Rabatt                   
                    </button>
                    <div class="relative float-right w-42 mr-4" id="zahlungsziel-neue-rechnung">
                      <button type="button" id="rechnung-mwst-button" onclick="toggleMwSt()" class="px-4 py-1.5 bg-gray-600 text-white rounded-md float-right">
                        MwSt deaktiviert                    
                      </button>
                      <input type="hidden" value="{{$mwst}}" name="mwst" id="mwst-neue-rechnung">
                      <input type="checkbox" id="neue-rechnung-mwst-check" class="hidden">
                    </div>
                  </div>
                  
                  @include('includes.orders.buchhaltung-pos-table')

                  <div class="pt-4">
                    <button class="hidden" type="submit" id="neue-rechnung-submitbutton"></button>
                    </button>
                    <button type="button" onclick="document.getElementById('neue-rechnung-submitbutton').click();" id="submitText" class="float-left bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold py-1.5 w-24 text-center">Speichern</button>    
                     <button type="button" onclick="document.getElementById('rechnung-neue-rechnung-modal').classList.add('hidden')" id="submitText" class="float-right bg-white text-black border border-gray-600 rounded-md font-semibold py-1.5 w-24 text-center">Abbrechen</button>    
                  </div>
                </form>
                </div>
            <script>
              let positionsCheckList = [];

              function neueRechnungZusammenfassen() {
                if(!positionsCheckList.length) {
                  document.getElementById('neue-rechnung-submitbutton').click();

                  document.getElementById("rechnung-neue-rechnung-modal").classList.add("hidden");

                } else {
                  let zahlart = false;
                  let zahlarttoomuch = false;
                  let zahlartremember = false;
                  positionsCheckList.forEach(element => {
                    if(element == "Überweisung" || element == "Nachnahme") {
                      zahlart = true;
                    }
                    if(element == "Überweisung" || element == "Nachnahme") {
                      if(zahlartremember == true) {
                        zahlarttoomuch = true;
                      }
                    }
                    if(element == "Überweisung" || element == "Nachnahme") {
                      zahlartremember = true;
                    }
                  });

                  if(zahlart == false) {
                    if(document.getElementById("neue-rechnung-modal-select-type").value != "Gutschrift") {
                      document.getElementById('zahlart-error').classList.remove('hidden');

                    } else {
                      document.getElementById('neue-rechnung-submitbutton').click();
                      document.getElementById("rechnung-neue-rechnung-modal").classList.add("hidden");

                    }
                  } else {
                    if(zahlarttoomuch == true) {
                      document.getElementById('zahlart-error-toomuch').classList.remove('hidden');
                    } else {
                      document.getElementById('neue-rechnung-submitbutton').click();
                      document.getElementById("rechnung-neue-rechnung-modal").classList.add("hidden");

                    }

                  }
                }

              }
            </script>
          </div>

    </div>
  </div>
</div>



<div class="relative z-50 hidden " id="rechnung-neue-position-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
    <div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
      <div class="relative transform overflow-hidden rounded-md bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 20rem;">
        <form action="{{url("/")}}/crm/neue-rechnung/{{$kundenkonto->process_id}}" method="POST" id="neue-rechnung-form">
          @CSRF
          <input type="hidden" name="type" value="Rechnung" id="neue-rechnung-modal-type">
          <input type="hidden" name="vorläufige_id" value="" id="neue-rechnung-modal-temp-id">
          <input type="hidden" name="rabatt_type" value="prozent" >
          <div>
            <h1 class="text-left text-xl font-semibold">Neue Position</h1>
          </div>
          <div>

            <div class="py-2">
              <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Gespeicherte Artikel</label>
              <select id="rechnung-gespeicherte-artikel" onchange="addGespeicherterArtikel(this.value)" name="location" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                <option value="">Auswählen</option>
                <option class="font-bold text-lg" value=""><p class="font-bold">Artikel</p></option>
                @foreach ($artikel as $art)
                    @if ($art->artname != "Nachnahme" && $art->artname != "Überweisung" && $art->artname != "Barzahlung")
                      <option value="{{$art->artnr}}">{{$art->artname}}</option>
                    @endif
                @endforeach

                <option class="font-bold text-lg" value=""><p class="font-bold">Zahlarten</p></option>
                @foreach ($artikel as $art)
                    @if ($art->artname == "Nachnahme" || $art->artname == "Überweisung" || $art->artname == "Barzahlung")
                      <option value="{{$art->artnr}}">{{$art->artname}}</option>
                    @endif
                @endforeach
              </select>
            </div>

            <div class="py-2">
              <label for="Menge" class="block text-sm font-medium leading-6 text-gray-900">Menge</label>
              <div class="mt-1">
                <input type="number" oninput="changeMenge(this.value)" name="menge" id="neue-rechnung-modal-Menge" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>

            <div class="py-2">
              <label for="Artikelnummber" class="block text-sm font-medium leading-6 text-gray-900">Artikelnummer</label>
              <div class="mt-1">
                <input type="text" name="artikelnummer" id="neue-rechnung-modal-Artikelnummber" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>

            <div class="py-2">
              <label for="Bezeichnung" class="block text-sm font-medium leading-6 text-gray-900">Bezeichnung</label>
              <div class="mt-1">
                <input type="text" name="bezeichnung" id="neue-rechnung-modal-Bezeichnung" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>

            <div class="py-2">
              <label for="Nettobetrag" class="block text-sm font-medium leading-6 text-gray-900">E-Preis</label>
              <div class="mt-1">
                <input type="text" oninput="changeEpreis(this.value)" name="epreis" id="neue-rechnung-modal-Epreis" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>

            <div class="py-2">
              <label for="Nettobetrag" class="block text-sm font-medium leading-6 text-gray-900">Nettobetrag</label>
              <div class="mt-1">
                <input type="text" oninput="neueRechnungBruttoBerechnen(this.value)" name="nettobetrag" id="neue-rechnung-modal-Nettobetrag" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>

            


            
            
            <div class="py-2">
              <label for="Bruttobetrag" class="block text-sm font-medium leading-6 text-gray-900">Bruttobetrag</label>
              <div class="mt-1">
                <input type="text" id="neue-rechnung-modal-brutto" name="bruttobetrag" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
              </div>
            </div>


            <div class="hidden">
              <input type="hidden" name="mwst" id="neue-rechnung-modal-mwst">
                               <div >
                <input type="hidden"  name="rabatt" id="neue-rechnung-modal-Rabatt" class="block float-left w-40 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">

              </div>
            </div>
          </div>

         <div class="pt-7 float-left w-full">
          <button type="submit" class="hidden" id="new-positon-button"></button>
          <input type="hidden" id="positions-mwst-check" value="">
           <button type="button" onclick="postNewPosition()" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white px-6 text-center">Speichern <svg id="loadingSig" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden text-white float-right ml-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
          </svg>
          </button>
           <button type="button" onclick="document.getElementById('rechnung-neue-position-modal').classList.add('hidden')" class="float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
       </div>
    </div>
  </div>
</div>
</div>

<div class="relative z-50 hidden" id="zahlart-error" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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

  <div class="fixed inset-0 z-50 overflow-y-auto">
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
      <div style="margin-top: -40rem;" class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Keine Zahlart</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Achtung es wurde keine Zahlart hinzugefügt!</p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="document.getElementById('zahlart-error').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="relative z-50 hidden" id="zahlart-error-toomuch" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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

  <div class="fixed inset-0 z-50 overflow-y-auto">
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
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Nur eine Zahlart</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Achtung es darf nur eine Zahlart existieren!</p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="document.getElementById('zahlart-error-toomuch').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="relative z-20 hidden" id="neue-postions-mwst-error" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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

  <div class="fixed inset-0 z-50 overflow-y-auto">
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
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Verschiedene MwSt</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Achtung die MwSt unter scheidet sich von den bereits hinzugefügten Positionen!</p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="document.getElementById('neue-postions-mwst-error').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>







<!-- Warning Modal -->
<div id="warning-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-4">MwSt nicht 19%</h2>
    <p class="text-gray-700 mb-6">Achtung die MwSt beträgt nicht 19%, trotzdem fortfahren?</p>
    <div class="flex justify-end">
      <button id="understand-btn" class="bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 px-6 text-white mr-2">Weiter</button>
      <button id="back-btn" class="bg-white text-black rounded-md font-semibold py-1.5 px-6 border border-gray-600">Zurück</button>
    </div>
  </div>
</div>

<!-- Add script to show/hide warning modal -->
<script>
  function showWarningModal() {
    document.getElementById("warning-modal").classList.remove("hidden");
  }

  function hideWarningModal() {
    document.getElementById("warning-modal").classList.add("hidden");
  }

  document.getElementById("understand-btn").addEventListener("click", function() {
    checkMWST = true;
    saveChangePos(saveCheckId);
    hideWarningModal();

  });

  document.getElementById("back-btn").addEventListener("click", function() {
    hideWarningModal();
  });
</script>
<script>
        let rechnungsPosCounter = 1;
        let bruttoPreise        = [];
        let checkMWST           = false;
        let saveCheckId         = "";
      

        function postNewPosition() {
          if(document.getElementById("neue-rechnung-mwst-check").checked) {
            document.getElementById("neue-rechnung-modal-mwst").value = document.getElementById("mwst-neue-rechnung").value;
          } else {
            document.getElementById("neue-rechnung-modal-mwst").value = "0";
          }
              document.getElementById("new-positon-button").click();
        }

        function changeEpreis(price) {
          document.getElementById("neue-rechnung-modal-Nettobetrag").value = price * document.getElementById("neue-rechnung-modal-Menge").value;

          neueRechnungBruttoBerechnen(this.value)
        }
        
        function changeMenge(menge) {
          if(menge != "") {
            let preis = document.getElementById("neue-rechnung-modal-Nettobetrag").value;
            let netto = menge * preis;
            document.getElementById("neue-rechnung-modal-Nettobetrag").value = netto;

            neueRechnungBruttoBerechnen();

          }
        }




        $(document).ready(function() { 
            $('#neue-rechnung-form').ajaxForm(function( data ) { 
                positionsCheckList.push(data["bezeichnung"]);
                let table = document.getElementById("neue-rechnung-table");

                let row   = table.insertRow(1);
                row.classList.add("update-row-animation");
                row.setAttribute("id", data["id"] + "-rechnungspos-row");



                let cell1 = row.insertCell(0);
                cell1.classList.add("text-left", "py-2");
                cell1.innerHTML = rechnungsPosCounter + "<input type='text' class='hidden' id='" +'"' + data["id"] + '"' + "-rechnungspos-pos-input'>";
                rechnungsPosCounter++;
                cell1.setAttribute("id", data["id"] + "-rechnungspos-pos");

                let cell2 = row.insertCell(1);
                cell2.classList.add("text-center", "py-2");
                cell2.innerHTML = "<p id='" + data["id"] + "-rechnungspos-menge'>" + data["menge"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-menge-input'>";

                
                let cell3 = row.insertCell(2);
                cell3.classList.add("text-center", "py-2");
                cell3.innerHTML = "<p id='" + data["id"] + "-rechnungspos-artnr'>" + data["artnr"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-artnr-input'>";


                let cell4 = row.insertCell(3);
                cell4.classList.add("text-left", "py-2");
                cell4.innerHTML = "<p id='" + data["id"] + "-rechnungspos-bezeichnung'>" + data["bezeichnung"] + "</p><input type='text'  class='hidden rounded-md h-6 w-36' id='" + data["id"] + "-rechnungspos-bezeichnung-input'>";


                let cell5 = row.insertCell(4);
                cell5.classList.add("text-right", "py-2");
                cell5.innerHTML = "<p id='" + data["id"] + "-rechnungspos-mwst'>" + parseFloat(data["mwst"]).toFixed(2).replace(".", ",") + "%</p><input type='text' oninput=editPosCalc('" + data["id"] + "') class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-mwst-input'>";


                let cell6 = row.insertCell(5);
                cell6.classList.add("text-right", "py-2");
                cell6.innerHTML = "<p id='" + data["id"] + "-rechnungspos-nettobetrag'>" + parseFloat(data["nettobetrag"]).toFixed(2).replace(".", ",") + "</p><input type='text' oninput=editPosCalc('" + data["id"] + "') class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-nettobetrag-input'>";

              

                let cell7 = row.insertCell(6);
                cell7.classList.add("text-right", "py-2");
                if(data["mwst"] != "0") {
                  cell7.innerHTML = "<p id='" + data["id"] + "-rechnungspos-mwstbetrag'>" + parseFloat(data["mwstbet"]).toFixed(2).replace(".", ",") + "</p><input type='text' oninput=editPosCalc('" + data["id"] + "') class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-mwstbetrag-input'>";

                } else {
                  cell7.innerHTML = "";
                }
                
                let cell8 = row.insertCell(7);
                cell8.classList.add("text-right", "py-2");
                cell8.innerHTML = "";


                let cell9 = row.insertCell(8);
                cell9.classList.add("text-right", "py-2");
                cell9.innerHTML = "<p id='" + data["id"] + "-rechnungspos-bruttobetrag'>" + parseFloat(data["bruttobetrag"]).toFixed(2).replace(".", ",") + "</p><input type='text' oninput=editPosCalc('"+data["id"]+"') class='hidden rounded-md h-6 w-16' id='"+data["id"]+"-rechnungspos-bruttobetrag-input'>";


                let cell10 = row.insertCell(9);
                cell10.classList.add("text-center", "py-2");
                cell10.innerHTML = '<button type="button" onclick="editRechnungPos(' + "'" + data["id"] + "'" + ')">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />  </svg></button> <button type="button" onclick="deleteRechnungsPos(' + "'" + data["id"] + "'" + ')"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>';
                cell10.setAttribute("id", data["id"] + "-rechnungspos-button");


                let finalBruttoPreis = parseFloat(document.getElementById("neue-rechnung-modal-final-brutto").innerHTML.replace("", "")) + parseFloat(data["bruttobetrag"]);

                document.getElementById(data["id"] + "-rechnungspos-bruttobetrag-input").value = parseFloat(data["bruttobetrag"]).toFixed(2).replace(".", ",");

                document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = parseFloat(finalBruttoPreis).toFixed(2).replace(".", ",") + "\u20AC";

                document.getElementById("rechnung-neue-position-modal").classList.add("hidden");

                savedPOST();
            }); 
        }); 

    function deleteRechnungsPos(id) {
      $.get('{{url("/")}}/crm/rechnung/delete-pos/' + id, function( data ) {
        document.getElementById(id + "-rechnungspos-row").remove();

        positionCounter = 0;
        positionsCheckList.forEach(element => {
          if(element == data["bezeichnung"]) {
            positionsCheckList.splice(positionCounter, 1);
          }
          positionCounter++;
        });

        positionsCheckList.forEach(element => {
          if(element == "Nachnahme") {
            document.getElementById(data["rechnungsnummer"] + "-rechnung-zahlart").innerHTML = "Nachnahme";
          }
          if(element == "Überweisung") {
            document.getElementById(data["rechnungsnummer"] + "-rechnung-zahlart").innerHTML = "Überweisung";
          }
          if(element == "Bar") {
            document.getElementById(data["rechnungsnummer"] + "-rechnung-zahlart").innerHTML = "Bar";
          }
        });

        let gesamtBrutto = parseFloat(document.getElementById("neue-rechnung-modal-final-brutto").innerHTML);
        let Brutto       = parseFloat(data["bruttobetrag"]);
        let newBrutto    = gesamtBrutto - Brutto;

        if(document.getElementById("neue-rechnung-modal-final-brutto")) {
          document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = newBrutto.toFixed(2) + "";
          gesamtBrutto = parseFloat(document.getElementById(data["rechnungsnummer"] + '-rechnung-endzahlungsbetrag').innerHTML.replace("", "").replace(" ", ""));
          newBrutto    = gesamtBrutto - newBrutto;
          document.getElementById(data["rechnungsnummer"] + '-rechnung-endzahlungsbetrag').innerHTML = newBrutto.toFixed(2) + " ";

          let endBrutto = parseFloat(document.getElementById('neue-rechnung-modal-final-brutto').innerHTML.replace("€", ""));
          if(data["rabatt_type"] == "prozent") {
            
          }
        }





      });
    }

    function neueRechnungsPosition(id) {
      document.getElementById("neue-rechnung-modal-Menge").value = "";
      document.getElementById("neue-rechnung-modal-Artikelnummber").value = "";
      document.getElementById("neue-rechnung-modal-Bezeichnung").value = "";
      document.getElementById("neue-rechnung-modal-Nettobetrag").value = "";
      document.getElementById("neue-rechnung-modal-Rabatt").value = "";
      document.getElementById("neue-rechnung-modal-brutto").value = "";
      document.getElementById("rechnung-gespeicherte-artikel").value = "";

      document.getElementById("rechnung-neue-position-modal").classList.remove("hidden");
    }
    
    let mwstCustom = {{$mwst}};
    function neueRechnungBruttoBerechnen(netto) {
      let onepercent  = netto/100;
      let mwstprice   = onepercent*mwstCustom;
      let brutto      = parseFloat(netto)+parseFloat(mwstprice);

      document.getElementById('neue-rechnung-modal-brutto').value = brutto.toFixed(2);

      neueRechnungBruttoRabattBerechnen(document.getElementById("neue-rechnung-modal-Rabatt").value);
    }

    function neueRechnungBruttoRabattBerechnen(rabatt) {
      if(rabattType == "prozent") {
        if(rabatt != "") {
          let rabattOnePercent = parseFloat(document.getElementById('neue-rechnung-modal-Nettobetrag').value)/100;
          let rabattPercent    = rabattOnePercent*parseFloat(rabatt.replace(",", "."));
          let netto = parseFloat(document.getElementById('neue-rechnung-modal-Nettobetrag').value) - rabattPercent;
          let onepercent  = netto/100;
          let mwstprice   = onepercent*mwstCustom.replace(",", ".");
          let brutto      = parseFloat(netto)+parseFloat(mwstprice);

          document.getElementById('neue-rechnung-modal-brutto').value = brutto.toFixed(2);
        } else {
          rabatt = "0";
          let netto = parseFloat(document.getElementById('neue-rechnung-modal-Nettobetrag').value) - parseFloat(rabatt.replace(",", "."));
          let onepercent  = netto/100;
          let mwstprice   = onepercent*mwstCustom.replace(",", ".");
          let brutto      = parseFloat(netto)+parseFloat(mwstprice);

          document.getElementById('neue-rechnung-modal-brutto').value = brutto.toFixed(2);
        }
      }

      if(rabattType == "euro") {
        if(rabatt != "") {
          let netto = parseFloat(document.getElementById('neue-rechnung-modal-Nettobetrag').value) - parseFloat(rabatt.replace(",", "."));
          let onepercent  = netto/100;
          let mwstprice   = onepercent*mwstCustom.replace(",", ".");
          let brutto      = parseFloat(netto)+parseFloat(mwstprice);

          document.getElementById('neue-rechnung-modal-brutto').value = brutto.toFixed(2);
        } else {
          rabatt = "0";
          let netto = parseFloat(document.getElementById('neue-rechnung-modal-Nettobetrag').value) - parseFloat(rabatt.replace(",", "."));
          let onepercent  = netto/100;
          let mwstprice   = onepercent*mwstCustom.replace(",", ".");
          let brutto      = parseFloat(netto)+parseFloat(mwstprice);

          document.getElementById('neue-rechnung-modal-brutto').value = brutto.toFixed(2);
        }
      }
    }


    function neueRechnungBruttoMwStBerechnen(mwst) {

    }

    let rabattType = "prozent";
    function changeRabattType(type) {

      if(type == "prozent") {
        document.getElementById("neue-rechnung-rabatt-prozent").classList.remove("text-gray-600");
        document.getElementById("neue-rechnung-rabatt-prozent").classList.add("text-blue-400");

        document.getElementById("neue-rechnung-rabatt-euro").classList.add("text-gray-600");
        document.getElementById("neue-rechnung-rabatt-euro").classList.remove("text-blue-400");
        rabattType = "prozent";
      }
      if(type == "euro") {
        document.getElementById("neue-rechnung-rabatt-prozent").classList.add("text-gray-600");
        document.getElementById("neue-rechnung-rabatt-prozent").classList.remove("text-blue-400");

        document.getElementById("neue-rechnung-rabatt-euro").classList.remove("text-gray-600");
        document.getElementById("neue-rechnung-rabatt-euro").classList.add("text-blue-400");
        rabattType = "euro";
      }

      document.getElementById("neue-rechnung-modal-rabatt-type-input").value = rabattType;

      let rabatt = document.getElementById("neue-rechnung-modal-Rabatt").value;
      neueRechnungBruttoRabattBerechnen(rabatt);
    }

    function editRechnungPos(id) {
      
      document.getElementById(id + '-rechnungspos-menge').classList.add('hidden');
      document.getElementById(id + '-rechnungspos-menge-input').value = document.getElementById(id + '-rechnungspos-menge').innerHTML;
      document.getElementById(id + '-rechnungspos-menge-input').classList.remove("hidden");

      let bezeichnung = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;
      if(bezeichnung != "Überweisung" && bezeichnung != "Nachnahme") {
        document.getElementById(id + '-rechnungspos-artnr').classList.add('hidden');
        document.getElementById(id + '-rechnungspos-artnr-input').value = document.getElementById(id + '-rechnungspos-artnr').innerHTML;
        document.getElementById(id + '-rechnungspos-artnr-input').classList.remove("hidden");

        document.getElementById(id + '-rechnungspos-bezeichnung').classList.add('hidden');
        document.getElementById(id + '-rechnungspos-bezeichnung-input').value = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;
        document.getElementById(id + '-rechnungspos-bezeichnung-input').classList.remove("hidden");
      } else {
        document.getElementById(id + '-rechnungspos-artnr-input').value = document.getElementById(id + '-rechnungspos-artnr').innerHTML;

        document.getElementById(id + '-rechnungspos-bezeichnung-input').value = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;
      }

      document.getElementById(id + '-rechnungspos-mwst').classList.add('hidden');
      document.getElementById(id + '-rechnungspos-mwst-input').value = document.getElementById(id + '-rechnungspos-mwst').innerHTML;
      document.getElementById(id + '-rechnungspos-mwst-input').classList.remove("hidden");

      document.getElementById(id + '-rechnungspos-nettobetrag').classList.add('hidden');
      document.getElementById(id + '-rechnungspos-nettobetrag-input').value = document.getElementById(id + '-rechnungspos-nettobetrag').innerHTML;
      document.getElementById(id + '-rechnungspos-nettobetrag-input').classList.remove("hidden");

    



      document.getElementById(id + '-rechnungspos-button').innerHTML = '<button type="button" onclick="saveChangePos(' + "'" + id + "'" + ')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6 text-blue-400 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></button>'
    }

    function addGespeicherterArtikel(artikel) {

      let menge;
      let artnr;
      let bezeichnung;
      let nettobetrag;
      let rabatt;
      let mwst;
      let bruttobetrag;

      switch (artikel) {
        @foreach($artikel as $art)
        case "{{$art->artnr}}":
          menge = 1;
          artnr = "{{$art->artnr}}";
          bezeichnung = "{{$art->artname}}";
          nettobetrag = "{{$art->netto}}";
          rabatt = "0";
          mwst = "{{$art->mwst}}";
          bruttobetrag = "{{$art->brutto}}";
          break;
        @endforeach
        
        default:
          break;
      }


      if(menge != null) {
        document.getElementById("neue-rechnung-modal-Menge").value          = menge;
      }
      if(bezeichnung != null) {
        document.getElementById("neue-rechnung-modal-Bezeichnung").value    = bezeichnung;
      }
      if(artnr != null) {
        document.getElementById("neue-rechnung-modal-Artikelnummber").value = artnr;
      }
      if(nettobetrag != null) {
        document.getElementById("neue-rechnung-modal-Nettobetrag").value    = nettobetrag;
        document.getElementById("neue-rechnung-modal-Epreis").value     = nettobetrag;
      }
      if(rabatt != null) {
        document.getElementById("neue-rechnung-modal-Rabatt").value         = rabatt;
      }
    
      if(bruttobetrag != null) {
        document.getElementById("neue-rechnung-modal-brutto").value         = bruttobetrag;
      }

      
      neueRechnungBruttoMwStBerechnen(mwst);
    }
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    function saveChangePos(prodID) {
      if(saveCheckId != "") {
        prodID = saveCheckId;
      }
      let mengeInp           = document.getElementById(prodID + '-rechnungspos-menge-input').value;
      let artnrInp           = document.getElementById(prodID + '-rechnungspos-artnr-input').value;
      let bezeichnungInp     = document.getElementById(prodID + '-rechnungspos-bezeichnung-input').value;
      let nettobetragInp     = document.getElementById(prodID + '-rechnungspos-nettobetrag-input').value;
      let rabattInp          = "0";
      let mwstInp            = document.getElementById(prodID + '-rechnungspos-mwst-input').value;
      let bruttobetragInp    = document.getElementById(prodID + '-rechnungspos-bruttobetrag-input').value;
      let bruttoInp          = document.getElementById(prodID + '-rechnungspos-bruttobetrag').innerHTML.replace("€", "");

      if(!mwstInp.includes("19") && checkMWST == false && mwstState == true) {
        document.getElementById("warning-modal").classList.remove("hidden");
        saveCheckId = prodID;
      } else {
        document.getElementById(prodID + "-rechnungspos-row").classList.remove("update-row-animation");

      $.post( "{{url("/")}}/crm/change-pos", { id: prodID, menge: mengeInp, artnr: artnrInp, bezeichnung: bezeichnungInp, nettobetrag: nettobetragInp, rabatt: rabattInp, mwst: mwstInp, bruttobetrag: bruttoInp})
        .done(function( data ) {
          if(data["bezeichnung"] != "Überweisung" && data["bezeichnung"] != "Nachnahme") {
            document.getElementById(data["id"] + '-rechnungspos-artnr').classList.remove('hidden');
            document.getElementById(data["id"] + '-rechnungspos-artnr').innerHTML = document.getElementById(data["id"] + '-rechnungspos-artnr-input').value;
            document.getElementById(data["id"] + '-rechnungspos-artnr-input').classList.add("hidden");
            
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung').classList.remove('hidden');
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung').innerHTML = document.getElementById(data["id"] + '-rechnungspos-bezeichnung-input').value;
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung-input').classList.add("hidden");
          }

          document.getElementById(data["id"] + '-rechnungspos-menge').classList.remove('hidden');
          document.getElementById(data["id"] + '-rechnungspos-menge').innerHTML = document.getElementById(data["id"] + '-rechnungspos-menge-input').value;
          document.getElementById(data["id"] + '-rechnungspos-menge-input').classList.add("hidden");

          document.getElementById(data["id"] + '-rechnungspos-nettobetrag').classList.remove('hidden');
          document.getElementById(data["id"] + '-rechnungspos-nettobetrag').innerHTML = document.getElementById(data["id"] + '-rechnungspos-nettobetrag-input').value;
          document.getElementById(data["id"] + '-rechnungspos-nettobetrag-input').classList.add("hidden");



          document.getElementById(data["id"] + '-rechnungspos-mwst').classList.remove('hidden');
          document.getElementById(data["id"] + '-rechnungspos-mwst').innerHTML = document.getElementById(data["id"] + '-rechnungspos-mwst-input').value;
          document.getElementById(data["id"] + '-rechnungspos-mwst-input').classList.add("hidden");

          document.getElementById(data["id"] + '-rechnungspos-button').innerHTML = '<button type="button" onclick="editRechnungPos(' + "'" + data["id"] + "'" + ')">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />  </svg></button> <button type="button" onclick="deleteRechnungsPos(' + "'" + data["id"] + "'" + ')"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>'

          document.getElementById(data["id"] + "-rechnungspos-row").classList.add("update-row-animation");

          let gesamt = document.getElementById("neue-rechnung-modal-final-brutto").innerHTML.replace("€", "");
          gesamt = parseFloat(gesamt) - parseFloat(bruttobetragInp);
          gesamt = parseFloat(gesamt) + parseFloat(data["bruttobetrag"]);
          document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = Intl.NumberFormat('de-DE').format(parseFloat(gesamt).toFixed(2)) + "€";
          document.getElementById(prodID + '-rechnungspos-bruttobetrag-input').value = data["bruttobetrag"];
          saveCheckId = "";
      });
      }

    }

    function loadRechnungPos(id) {
      rechnungsPosCounter = 1;
      positionsCheckList = [];
      $("#neue-rechnung-table tr:not(:first):not(:last)").remove();
      document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = "00.00";
      $.get("{{url("/")}}/crm/get-positions/" + id, function(positions) {
        document.getElementById("positions-mwst-check").value = positions[0]["mwst"];

        document.getElementById('neue-rechnung-modal-temp-id').value = positions[0]["rechnungsnummer"];
        document.getElementById("zahlungsziel").value = positions[0]["zahlungsziel"];
        document.getElementById("neue-rechnung-modal-select-rechnungstext").value = positions[0]["rechnungstext"];
        let finalBrutto = 0;
        document.getElementById("neue-rechnung-zusammenfassen-form").action = "{{url("/")}}/crm/rechnung-zusammenfassen/" + id;
        positions.forEach(data => {
          positionsCheckList.push(data["bezeichnung"]);
          let table = document.getElementById("neue-rechnung-table");

          let row   = table.insertRow(1);
          row.classList.add("update-row-animation");
          row.setAttribute("id", data["id"] + "-rechnungspos-row");

          let cell1 = row.insertCell(0);
          cell1.classList.add("text-left", "py-2");
          cell1.innerHTML = rechnungsPosCounter + "<input type='text' class='hidden' id='" +'"' + data["id"] + '"' + "-rechnungspos-pos-input'>";
          rechnungsPosCounter++;
          cell1.setAttribute("id", data["id"] + "-rechnungspos-pos");

          let cell2 = row.insertCell(1);
          cell2.classList.add("text-center", "py-2");
          cell2.innerHTML = "<p id='" + data["id"] + "-rechnungspos-menge'>" + data["menge"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-menge-input'>";


          let cell3 = row.insertCell(2);
          cell3.classList.add("text-center", "py-2");
          cell3.innerHTML = "<p id='" + data["id"] + "-rechnungspos-artnr'>" + data["artnr"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-artnr-input'>";


          let cell4 = row.insertCell(3);
          cell4.classList.add("text-left", "py-2");
          cell4.innerHTML = "<p id='" + data["id"] + "-rechnungspos-bezeichnung'>" + data["bezeichnung"] + "</p><input type='text' class='hidden rounded-md h-6 w-36' id='" + data["id"] + "-rechnungspos-bezeichnung-input'>";


          let cell5 = row.insertCell(4);
          cell5.classList.add("text-right", "py-2");
          cell5.innerHTML = "<p id='" + data["id"] + "-rechnungspos-mwst'>" + parseFloat(data["mwst"]).toFixed(2).replace(".", ",") + "%</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-mwst-input'>";


          let cell6 = row.insertCell(5);
          cell6.classList.add("text-right", "py-2");
          cell6.innerHTML = "<p id='" + data["id"] + "-rechnungspos-nettobetrag'>" + parseFloat(data["nettobetrag"]).toFixed(2).replace(".", ",") + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-nettobetrag-input'>";


          let onepercent  = data["nettobetrag"]/100;
          let mwstprice   = onepercent*data["mwst"];

          let cell7 = row.insertCell(6);
          cell7.classList.add("text-right", "py-2");
          cell7.innerHTML = "<p id='" + data["id"] + "-rechnungspos-mwstbetrag'>" + parseFloat(mwstprice).toFixed(2).replace(".", ",") + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-mwstbetrag-input'>";


          let cell8 = row.insertCell(7);
          cell8.classList.add("text-right", "py-2");
          cell8.innerHTML = "<p id='" + data["id"] + "-rechnungspos-rabatt'>" + parseFloat(data["rabatt"]).toFixed(2).replace(".", ",") + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-rabatt-input'>";


          let cell9 = row.insertCell(8);
          cell9.classList.add("text-right", "py-2");
          cell9.innerHTML = "<p id='" + data["id"] + "-rechnungspos-bruttobetrag'>" + parseFloat(data["bruttobetrag"]).toFixed(2).replace(".", ",") + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='"+data["id"]+"'>";


          let cell10 = row.insertCell(9);
          cell10.classList.add("text-center", "py-2");
          cell10.innerHTML = '<button type="button" onclick="editRechnungPos(' + "'" + data["id"] + "'" + ')">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />  </svg></button> <button type="button" onclick="deleteRechnungsPos(' + "'" + data["id"] + "'" + ')"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>';
          cell10.setAttribute("id", data["id"] + "-rechnungspos-button");


          finalBrutto += parseFloat(data["bruttobetrag"]);

          document.getElementById("rechnung-neue-rechnung-modal").classList.remove("hidden");
        });
        console.log(finalBrutto);
        document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = parseFloat(finalBrutto).toFixed(2).replace(".", ",") + "\u20AC";
        document.getElementById("rechnung-neue-rechnung-modal").classList.remove("hidden");
      });

      

    }

    function changeNeueRechnungType(type) {
      if(type != "Rechnung") {
            document.getElementById("zahlungsziel-neue-rechnung").classList.add("hidden");
            document.getElementById("zahlungsziel").value = "None";
        } else {
            document.getElementById("zahlungsziel-neue-rechnung").classList.remove("hidden");
            document.getElementById("zahlungsziel").value = "";
        }
      }

      function changeRabattTypeNB(type) {

        if(type == "netto") {
          document.getElementById('rabatt-netto').classList.add('text-blue-400');
          document.getElementById('rabatt-brutto').classList.remove("text-blue-400");
          document.getElementById('rabatt-type-input-bn').value = "Netto";
        } else {
          document.getElementById('rabatt-netto').classList.remove('text-blue-400');
          document.getElementById('rabatt-brutto').classList.add("text-blue-400");
          document.getElementById('rabatt-type-input-bn').value = "Brutto";
        }
      }

      function neueRabattPosition() {

        document.getElementById('neuer-rabatt-modal').classList.remove('hidden');
        document.getElementById('neue-rechnung-modal-Rabatt').value = "";
      }

</script>


<div class="relative hidden z-50" id="neuer-rabatt-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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

  <div class="fixed inset-0 z-50 overflow-y-auto">
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
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
        <div>
          <div class=" text-left ">
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">neue Rabattposition</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Es darf nur eine Rabattposition existieren</p>
            </div>

            <div class="mt-4">
              <p class="float-right absolute right-0 mr-20 text-blue-400" id="neue-rechnung-rabatt-prozent"><button type="button" onclick="changeRabattType('prozent')">%</button></p>
              <p class="float-right absolute right-0 mr-28 text-gray-600" id="neue-rechnung-rabatt-euro"><button type="button" onclick="changeRabattType('euro')">€</button></p>


              <label for="Rabatt" class="block text-sm font-medium leading-6 text-gray-900">Rabatt</label>
              <div class="mt-1">
                <input type="text" name="rabatt" id="neue-rechnung-modal-Rabatt-Rabatt" class="block float-left w-52 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
                <div class="w-24 float-right -mt-1">
                  <button type="button" onclick="changeRabattTypeNB('netto')" id="rabatt-netto" class="font-medium text-blue-400">Netto</button>
                  <input type="hidden" id="rabatt-type-input-bn" value="Netto">
                  <input type="hidden" name="rabatt_bn" value="prozent" id="neue-rechnung-modal-rabatt-type-input">
                  <br>
                  <button type="button" onclick="changeRabattTypeNB('brutto')" id="rabatt-brutto" class="font-medium">Brutto</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-20">
          <p class="text-red-600 text-sm hidden" id="rabatt-state">Rabattposition existiert bereits!</p>
          <button type="button" onclick="neueRabattPositionSpeichern()" class="bg-blue-600 hover:bg-blue-500 rounded-md font-semibold text-white px-4 py-2 float-left">Speichern</button>
          <button type="button" onclick="document.getElementById('neuer-rabatt-modal').classList.add('hidden')" class="border border-gray-600 rounded-md font-semibold text-black px-4 py-2 float-right">Abbrechen</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function neueRabattPositionSpeichern() {

    if(rabattState == false) {
      let rabattinput = document.getElementById('neue-rechnung-modal-Rabatt-Rabatt').value;
    let rabatttype  = document.getElementById('neue-rechnung-modal-rabatt-type-input').value;
    let rabattbn    = document.getElementById('rabatt-type-input-bn').value;
    let rechnungsnummer = document.getElementById('neue-rechnung-modal-temp-id').value;

    $.post( "{{url("/")}}/crm/neue-rabattposition", { rabatt: rabattinput, type: rabatttype, bn: rabattbn, id: rechnungsnummer })
    .done(function( data ) {
      

      let table = document.getElementById("neue-rechnung-table");

      let row   = table.insertRow(1);
      row.classList.add("update-row-animation");
      row.setAttribute("id", data["id"] + "-rechnungspos-row");



      let cell1 = row.insertCell(0);
      cell1.classList.add("text-left", "py-2");
      cell1.innerHTML = rechnungsPosCounter + "<input type='text' class='hidden' id='" +'"' + data["id"] + '"' + "-rechnungspos-pos-input'>";
      rechnungsPosCounter++;
      cell1.setAttribute("id", data["id"] + "-rechnungspos-pos");

      let cell2 = row.insertCell(1);
      cell2.classList.add("text-center", "py-2");
      cell2.innerHTML = "<p id='" + data["id"] + "-rechnungspos-menge'>" + data["menge"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-menge-input'>";

                
      let cell3 = row.insertCell(2);
      cell3.classList.add("text-center", "py-2");
      cell3.innerHTML = "<p id='" + data["id"] + "-rechnungspos-artnr'>" + data["artnr"] + "</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-artnr-input'>";


      let cell4 = row.insertCell(3);
      cell4.classList.add("text-left", "py-2");
      cell4.innerHTML = "<p id='" + data["id"] + "-rechnungspos-bezeichnung'>" + data["bezeichnung"] + "</p><input type='text' class='hidden rounded-md h-6 w-36' id='" + data["id"] + "-rechnungspos-bezeichnung-input'>";


      let cell5 = row.insertCell(4);
      cell5.classList.add("text-right", "py-2");
      cell5.innerHTML = "";


      let cell6 = row.insertCell(5);
      cell6.classList.add("text-right", "py-2");
      cell6.innerHTML = "";



      let cell7 = row.insertCell(6);
      cell7.classList.add("text-right", "py-2");
      cell7.innerHTML = "";

                
      let cell8 = row.insertCell(7);
      cell8.classList.add("text-right", "py-2");
      if(data["rabatt_type"] == "prozent") {
        cell8.innerHTML = "<p id='" + data["id"] + "-rechnungspos-rabatt'>" + parseFloat(data["rabatt"]).toFixed(2).replace(".", ",") + "%</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-rabatt-input'>";
      } else {
        cell8.innerHTML = "<p id='" + data["id"] + "-rechnungspos-rabatt'>" + parseFloat(data["rabatt"]).toFixed(2).replace(".", ",") + "€</p><input type='text' class='hidden rounded-md h-6 w-16' id='" + data["id"] + "-rechnungspos-rabatt-input'>";
      }


      let cell9 = row.insertCell(8);
      cell9.classList.add("text-right", "py-2");
      
      cell9.innerHTML =  "<p id='"+ data["id"] +"-rechnungspos-bruttobetrag'>"+ parseFloat(data["rabatt"]).toFixed(2).replace(".", ",")+"</p>"


      let cell10 = row.insertCell(9);
      cell10.classList.add("text-center", "py-2");
      cell10.innerHTML = '<button type="button" onclick="editRabattPos(' + "'" + data["id"] + "'" + ')">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />  </svg></button> <button type="button" onclick="deleteRechnungsPos(' + "'" + data["id"] + "'" + ')"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>';
      cell10.setAttribute("id", data["id"] + "-rechnungspos-button");

      var brutto;

      if(data["rabatt_type"] == "prozent") {
        brutto = document.getElementById("neue-rechnung-modal-final-brutto").innerHTML.replace("€", "").replace(",", ".");
        brutto = parseFloat(brutto);
        let bruttoPart = brutto/100;
        let bruttopercent = bruttoPart*parseFloat(data["rabatt"].replace(",", "."));
        brutto = brutto - bruttopercent;
      } else {
        brutto = document.getElementById("neue-rechnung-modal-final-brutto").innerHTML.replace("€", "").replace(",", ".");
        brutto = parseFloat(brutto);
        brutto = brutto - parseFloat(data["rabatt"].replace(",", "."));
      }

      document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = brutto.toFixed(2) + "€";
      document.getElementById("rechnung-neue-position-modal").classList.add("hidden");
      document.getElementById('neuer-rabatt-modal').classList.add('hidden')
      savedPOST();

      rabattState = true;
    });
    } else {
      document.getElementById('rabatt-state').classList.remove('hidden');
      
    }
  }

  function editRabattPos(id) {
    document.getElementById(id + '-rechnungspos-menge').classList.add('hidden');
    document.getElementById(id + '-rechnungspos-menge-input').value = document.getElementById(id + '-rechnungspos-menge').innerHTML;
    document.getElementById(id + '-rechnungspos-menge-input').classList.remove("hidden");

    let bezeichnung = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;

    if(bezeichnung != "Überweisung" && bezeichnung != "Nachnahme") {

      document.getElementById(id + '-rechnungspos-artnr').classList.add('hidden');
      document.getElementById(id + '-rechnungspos-artnr-input').value = document.getElementById(id + '-rechnungspos-artnr').innerHTML;
      document.getElementById(id + '-rechnungspos-artnr-input').classList.remove("hidden");
      document.getElementById(id + '-rechnungspos-bezeichnung').classList.add('hidden');
      document.getElementById(id + '-rechnungspos-bezeichnung-input').value = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;
      document.getElementById(id + '-rechnungspos-bezeichnung-input').classList.remove("hidden");

    } else {

      document.getElementById(id + '-rechnungspos-artnr-input').value = document.getElementById(id + '-rechnungspos-artnr').innerHTML;
      document.getElementById(id + '-rechnungspos-bezeichnung-input').value = document.getElementById(id + '-rechnungspos-bezeichnung').innerHTML;

    }


    document.getElementById(id + '-rechnungspos-rabatt').classList.add('hidden');
    document.getElementById(id + '-rechnungspos-rabatt-input').value = document.getElementById(id + '-rechnungspos-rabatt').innerHTML;
    document.getElementById(id + '-rechnungspos-rabatt-input').classList.remove("hidden");

    document.getElementById(id + '-rechnungspos-button').innerHTML = '<button type="button" onclick="saveChangeRabatt(' + "'" + id + "'" + ')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6 text-blue-400 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></button>'

  }

  function saveChangeRabatt(prodID) {
      let mengeInp           = document.getElementById(prodID + '-rechnungspos-menge-input').value;
      let artnrInp           = document.getElementById(prodID + '-rechnungspos-artnr-input').value;
      let bezeichnungInp     = document.getElementById(prodID + '-rechnungspos-bezeichnung-input').value;
      let rabattInp          = document.getElementById(prodID + '-rechnungspos-rabatt-input').value;

      document.getElementById(prodID + "-rechnungspos-row").classList.remove("update-row-animation");

      $.post( "{{url("/")}}/crm/change-rabattpos", { id: prodID, menge: mengeInp, artnr: artnrInp, bezeichnung: bezeichnungInp, rabatt: rabattInp})
        .done(function( data ) {
          if(data["bezeichnung"] != "Überweisung" && data["bezeichnung"] != "Nachnahme") {
            document.getElementById(data["id"] + '-rechnungspos-artnr').classList.remove('hidden');
            document.getElementById(data["id"] + '-rechnungspos-artnr').innerHTML = document.getElementById(data["id"] + '-rechnungspos-artnr-input').value;
            document.getElementById(data["id"] + '-rechnungspos-artnr-input').classList.add("hidden");
            
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung').classList.remove('hidden');
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung').innerHTML = data["bezeichnung"];
            document.getElementById(data["id"] + '-rechnungspos-bezeichnung-input').classList.add("hidden");
          }

          document.getElementById(data["id"] + '-rechnungspos-menge').classList.remove('hidden');
          document.getElementById(data["id"] + '-rechnungspos-menge').innerHTML = document.getElementById(data["id"] + '-rechnungspos-menge-input').value;
          document.getElementById(data["id"] + '-rechnungspos-menge-input').classList.add("hidden");


          document.getElementById(data["id"] + '-rechnungspos-rabatt').classList.remove('hidden');
          let type = "error";
          if(data["rabatt_type"] == "euro") {
            type = "€";
            let brutto = document.getElementById('neue-rechnung-modal-final-brutto').innerHTML.replace(type, "");
            let newBrutto = parseFloat(brutto) + parseFloat(data["old_rabatt"]);
            newBrutto = newBrutto - parseFloat(data["rabatt"]);
            document.getElementById('neue-rechnung-modal-final-brutto').innerHTML = newBrutto.toFixed(2) + type;
          }
          if(data["rabatt_type"] == "prozent") {
            type = "%";
            let brutto = document.getElementById('neue-rechnung-modal-final-brutto').innerHTML.replace(type, "");
            let newBrutto = parseFloat(brutto) + parseFloat(data["old_rabatt"]);
            newBrutto = newBrutto - parseFloat(data["rabatt"]);
            document.getElementById('neue-rechnung-modal-final-brutto').innerHTML = newBrutto.toFixed(2) + type;
          }
          document.getElementById(data["id"] + '-rechnungspos-rabatt').innerHTML = data["rabatt"] + type;
          document.getElementById(data["id"] + '-rechnungspos-rabatt-input').classList.add("hidden");

          document.getElementById(data["id"] + '-rechnungspos-bruttobetrag').classList.remove('hidden');
          document.getElementById(data["id"] + '-rechnungspos-bruttobetrag').innerHTML = data["rabatt"];

          document.getElementById(data["id"] + '-rechnungspos-button').innerHTML = '<button type="button" onclick="editRabattPos(' + "'" + data["id"] + "'" + ')">  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />  </svg></button> <button type="button" onclick="deleteRechnungsPos(' + "'" + data["id"] + "'" + ')"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>'

          document.getElementById(data["id"] + "-rechnungspos-row").classList.add("update-row-animation");
      });
  }

</script>