
<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
  <input type="hidden" id="system-mwst" value="19">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
      <div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
        <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 80rem;">
          <form action="{{url("/")}}/crm/buchhaltung/neue-rechnung" method="POST" id="neue-rechnung-form">
            @csrf
            <input type="hidden" name="rechnungsnummer" id="neue-rechnung-rechnungsnummer">
           <div class="px-6 pt-0 w-full">
            
            <div class="w-full h-10">
              <h1 class="text-2xl font-bold  float-left">Rechnungspositionen</h1>
            <div class="float-right">
              <button onclick="document.getElementById('neue-rechnung-modal').innerHTML = '';" class="float-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>         
            </div>
            </div>
              <div class="pb-4">
                <div class="float-left flex">
                    <select id="neue-rechnung-modal-select-type" name="type" onchange="changeNeueRechnungType(this.value)" class="block w-36 h-10 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                        <option value="Rechnung">Rechnung</option>
                        <option value="Angebot">Angebot</option>
                        <option value="Gutschrift">Gutschrift</option>
                    </select>
                    <div class="relative ml-4" id="zahlungsziel-neue-rechnung">
                        <label for="zahlungsziel" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-red-600">Zahlungsziel</label>
                        <input type="text" required name="zahlungsziel" id="zahlungsziel" class="block w-24 h-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="relative ml-4 hidden" id="vergleich-neue-rechnung">
                      <button class="px-4 h-10 rounded-md border border-gray-300 text-gray-600 hover:bg-blue-100">Vergleich erstellen</button>
                    </div>
                </div>

                <button type="button" onclick="neueRechnungsposition()" class="px-4 h-10 bg-blue-600 hover:bg-blue-500 text-white rounded-md float-right">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Neue Position                      
                </button>

                <div onclick="toggleMWST()" class="flex cursor-pointer float-right mr-4 rounded-md border border-gray-300 hover:bg-blue-100 px-4 h-10">
                    <div class="flex mt-2.5">
                      <p class="text-sm text-center font-medium">MwSt</p>
                      <button type="button" id="mwst-toggle-button" class="ml-2 group relative inline-flex h-5 w-10 flex-shrink-0 items-center justify-center rounded-full focus:outline-none" role="switch" aria-checked="true">
                          <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                          <span aria-hidden="true" id="mwst-toggle-button-color" class="bg-blue-600 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                          <span aria-hidden="true" id="mwst-toggle-button-translate" class="translate-x-5 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                      </button>
                    </div>
                    <input type="hidden" name="mwst-toggle" id="mwst-toggle" value="false">
                </div>
              </div>
              
              <div class="">
                <div class="mt-8 flow-root">
                  <div class=" -my-2 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle ">
                      <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                          <tr>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Pos</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Menge</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Art Nr.</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bezeichnung</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" id="neue-rechnung-table-mwst">MwSt</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Netto Betrag</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" id="neue-rechnung-table-mwstbetrag">MwSt Betrag</th>
                            <th scope="col" class=" py-3.5 text-right text-sm font-semibold text-gray-900">Brutto Betrag</th>
                            <th scope="col" class="py-3.5 text-right text-sm font-semibold text-gray-900">Aktion</th>

                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="neue-rechnung-positions">
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>

            <div class="mt-10 px-6">
                <button class="hidden" type="submit" id="neue-rechnung-submitbutton"></button>
                    <div class="flex float-left">
                        @if ($rechnungstexte->count() == 0)
                            <p class="text-red-600 font-bold bg-red-50 px-4 py-2 rounded-md float-left">Keine Rechnungstexte vorhanden (Bitte in den Einstellungen hinzufügen!)</p>
                        @else
                            <div class="py-2 px-4 rounded-md bg-yellow-100 float-left">
                                <div class="flex text-yellow-700 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mt-0.5">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                                    </svg>    
                                    <p class="ml-1">Rechnungstext</p>
                                    <p class="text-black ml-2 truncate" style="max-width: 8rem;" id="rechnungstext-name">{{$rechnungstexte[0]->title}}</p>
                                    <div onclick="document.getElementById('rechnungstext-select-div').classList.toggle('hidden')" class="flex cursor-pointer hover:text-yellow-400">
                                        <p class="ml-2">Ändern</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mt-0.5 ml-1">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                        </svg> 
                                    </div>                               
                                </div>
                            </div>
                            <div class="ml-4 hidden" id="rechnungstext-select-div">
                                <select onchange="document.getElementById('rechnungstext-name').innerHTML = this.value; document,getElementById('rechnungstext-select-div').classList.add('hidden')" name="rechnungstext" class="w-60 rounded-md border border-gray-300 h-9" style="padding: 5px">
                                    @foreach ($rechnungstexte as $text)
                                        <option value="{{$text->title}}">{{$text->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                </div>
                <button type="button" onclick="document.getElementById('neue-rechnung-submitbutton').click();" id="submitText" class="float-right h-10 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold py-1.5 w-24 text-center">Speichern</button>    
            </div>

            </form>
            </div>
        
      </div>

</div>
</div>
</div>



<div class="relative z-50 hidden " id="rechnung-neue-position-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

<div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
<div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
  <div class="relative transform overflow-hidden rounded-md bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 20rem;">
    <form action="{{url("/")}}/crm/buchhaltung/rechnung/neue-position/{{$kundenkonto->process_id}}" method="POST" onsubmit="loadData(); document.getElementById('rechnung-neue-position-modal').classList.add('hidden');" id="neue-position-form">
      @CSRF
      <input type="hidden" name="temp_id" value="" id="neue-position-temp-id">
      <input type="hidden" name="type" id="neue-position-type" value="rechnung">
      <input type="hidden" name="mwsttype" id="neue-positon-mwsttype" value="true">
      <div>
        <h1 class="text-left text-xl font-semibold" id="neue-position-header">Neue Rechnungsposition</h1>

        <div class="grid grid-cols-2 w-full pt-4">
          <p onclick="switchPositionsType('rechnung')" id="neue-position-menu-rechnung" class="cursor-pointer text-md text-left pl-2 font-medium text-blue-400 border border-blue-400 border-x-0 border-t-0 w-full hover:text-blue-400 hover:border-blue-400">Rechnung</p>
          <p onclick="switchPositionsType('rabatt')" id="neue-position-menu-rabatt" class="cursor-pointer text-md text-right pr-2 font-medium text-gray-400 border border-gray-400 border-x-0 border-t-0 w-full hover:text-blue-400 hover:border-blue-400">Rabatt</p>
        </div>
      </div>
      <div>

        <div class="py-2">
          <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Gespeicherte Artikel</label>
          <select id="neue-position-artikel" name="location" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
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

        <div class="py-2" >
          <label for="Artikelnummber" class="block text-sm font-medium leading-6 text-gray-900">Artikelnummer</label>
          <div class="mt-1">
            <input type="text" required name="artnr" id="neue-position-artikelnummer" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

        <div class="py-2" id="neue-position-div-bezeichnung">
          <label for="Bezeichnung" class="block text-sm font-medium leading-6 text-gray-900">Bezeichnung</label>
          <div class="mt-1">
            <input type="text" required name="bezeichnung" id="neue-position-bezeichnung" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

        <div class="py-2" id="neue-position-div-menge">
          <label for="Menge" class="block text-sm font-medium leading-6 text-gray-900">Menge</label>
          <div class="mt-1">
            <input type="number" required oninput="calculatePrice();" step="1" name="menge" id="neue-position-menge" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

        <div class="py-2" id="neue-position-div-epreis">
          <label for="Nettobetrag" class="block text-sm font-medium leading-6 text-gray-900">E-Preis</label>
          <div class="mt-1">
            <input type="number" required oninput="enforceNumberValidation(this); calculatePrice();" data-decimal="2" name="epreis" id="neue-position-epreis" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

        <div class="py-2" id="neue-position-div-netto">
          <label for="Nettobetrag" class="block text-sm font-medium leading-6 text-gray-900">Nettobetrag</label>
          <div class="mt-1">
            <input type="text" required readonly name="nettobetrag" id="neue-position-netto" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

        


        
        
        <div class="py-2">
          <label for="Bruttobetrag" class="block text-sm font-medium leading-6 text-gray-900">Bruttobetrag</label>
          <div class="mt-1">
            <input type="text" required readonly id="neue-position-brutto" oninput="enforceNumberValidation(this);" name="bruttobetrag" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
          </div>
        </div>

      </div>

     <div class="pt-7 float-left w-full">
      <button type="submit" class="hidden" id="new-position-button"></button>
      <input type="hidden" id="positions-mwst-check" value="">
       <button type="button" onclick="submitNeuePosition()" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white px-6 text-center">Speichern <svg id="loadingSig" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden text-white float-right ml-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
      </svg>
      </button>
       <button type="button" onclick="document.getElementById('rechnung-neue-position-modal').classList.add('hidden');" class="float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
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


<div class="relative hidden z-50" id="neuer-rabatt-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

<div class="fixed inset-0 z-50 overflow-y-auto">
<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
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

