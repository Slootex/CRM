<div class="relative hidden z-10" id="globale-zahlung-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 50rem">
          <div class="float-right">
            <button onclick="document.getElementById('globale-zahlung-modal').classList.add('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-600 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
        <form action="{{url("/")}}/crm/neue-zahlung" method="POST">
            @CSRF
            <input type="hidden" name="global" value="true">
          <div>
            <h1 class="font-semibold text-xl">Kundenkonto suchen</h1>
          </div>
          <hr class="mt-4 mb-6">
          <div>
            <input type="text" id="globale-zahlung-keyword" class="h-10 rounded-md border border-gray-600 inline-block" style="width: 40rem" placeholder="Suchen">
            <button type="button" onclick="searchKundenkonto()" class="bg-blue-500 font-semibold px-4 py-2 rounded-md text-white inline-block float-right">Suchen</button>
          </div>

          <div class="mt-10" id="globale-zahlung-ergebnisse">
            <label for="globale-zahlung-table" class="text-gray-600 font-medium">Suchergebnisse</label>
            <div class=" flow-root">
              <div class="-mx-4 -my-2 overflow-auto h-36 ">
                <div class="inline-block min-w-full py-2 align-middle px-4">
                  <table id="globale-zahlung-table" class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr>
                        <th scope="col" class="py-1  pr-3 text-left text-sm font-semibold text-gray-900">Auftrag</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Kunde</th>
                        <th scope="col" class="pl-3 py-1 text-right text-sm font-semibold text-gray-900">
                          Aktion
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                     @foreach ($orders as $order)
                      <tr>
                        <td class="whitespace-nowrap py-1  pr-3 text-sm text-gray-500"><a class='text-blue-600 hover:text-blue-400' target='_blank' href='{{url("/")}}/crm/auftrag-bearbeiten-{{$order->process_id}}'>{{$order->process_id}}</a></td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$order->firstname}} {{$order->lastname}}</td>
                        <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm sm:pr-0">
                          <button class="text-blue-600 hover:text-blue-400" type="button" onclick="addGlobaleZahlungAuftrag('{{$order->process_id}}')">+ hinzufügen</button>
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

          <div class="mt-2">
            <h1 class="text-xl font-semibold">Neue Zahlung</h1>

            <hr class="mt-2 mb-2">

            <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Rechnungsnummer</label>
            <select id="gloable-zahlung-rechnungen" name="rechnungsnummer" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
              
            </select>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">TransaktionsID</label>
                <div class="mt-2">
                  <input type="text" name="transaktionsid" id="gloable-zahlung-transaktionsid" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Zahlungsdatum</label>
                <div class="mt-2">
                  <input type="date" name="zahlungsdatum" id="gloable-zahlung-datum" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="mt-4">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Zahlart</label>
                <select id="gloable-zahlung-zahlart" name="zahlart" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option value="Nachnahme">Nachnahme</option>
                <option value="Bar">Bar</option>
                <option value="Überweisung">Überweisung</option>
                </select>
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Geldbetrag</label>
                <div class="mt-2">
                  <input type="number" name="betrag" id="gloable-zahlung-betrag" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Bemerkung</label>
                <div class="mt-2">
                  <input type="email" name="bemerkung" id="gloable-zahlung-notiz" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

          </div>

          <div class="mt-5 sm:mt-6">
            <button type="submit" class="inline-block bg-blue-500 rounded-md font-semibold text-white px-4 py-2">Speichern</button>
            <button type="button" onclick="document.getElementById('globale-zahlung-modal').classList.add('hidden')" class="inline-block ml-8 text-black rounded-md border border-gray-600 px-4 py-2">Abbrechen</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>


  <script>
    function searchKundenkonto() {
        let keyword = document.getElementById('globale-zahlung-keyword').value;

        $.get('{{url("/")}}/crm/rechnung-get-kundenkonto-' + keyword, function(data) {

            $('#globale-zahlung-table').find( 'tr:not(:first)' ).remove();

            var table = document.getElementById('globale-zahlung-table');

            let row = table.insertRow(1);

            let cell1 = row.insertCell(0);
            cell1.innerHTML = "<a class='text-blue-600 hover:text-blue-400' target='_blank' href='{{url("/")}}/crm/auftrag-bearbeiten-"+ data["process_id"] +"'>" + data["process_id"] + "</a>";
            cell1.classList.add('whitespace-nowrap', "text-sm");

            let cell2 = row.insertCell(1);
            cell2.innerHTML = data["firstname"] + " " + data["lastname"];
            cell2.classList.add('whitespace-nowrap', "text-sm", "text-gray-500", "px-3");

            let cell3 = row.insertCell(2);
            cell3.innerHTML = "<button type='button' onclick='addGlobaleZahlungAuftrag(" + '"' + data["process_id"] + '"' + ")'>+ hinzuf\u00fcgen</button>";
            cell3.classList.add('text-blue-600', 'whitespace-nowrap', 'text-right', 'text-sm');

            document.getElementById('globale-zahlung-ergebnisse').classList.remove('hidden');
        });
    }

    function addGlobaleZahlungAuftrag(id) {

        $.get('{{url("/")}}/crm/rechnung-get-rechnungsnummer-' + id, function (data) {

            document.getElementById('gloable-zahlung-transaktionsid').value = uuidv4();

            $('#gloable-zahlung-rechnungen').empty();

            let usedNumbers = [];
            data.forEach(elem => {
                if(!usedNumbers.includes(elem["rechnungsnummer"])) {
                    if(elem["rechnungsnummer"].length != 4) {
                        let newOption = new Option(elem["rechnungsnummer"],elem["rechnungsnummer"]);
                        const select = document.getElementById('gloable-zahlung-rechnungen'); 
                        select.add(newOption,undefined);
                        usedNumbers.push(elem["rechnungsnummer"]);
                    }
                }
                
            });
        });

    }
  </script>