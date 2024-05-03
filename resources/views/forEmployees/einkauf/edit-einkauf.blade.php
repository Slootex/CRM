<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-2 text-left shadow-xl transition-all sm:my-8" style="width: 80rem">

        <form action="{{url("/")}}/crm/einkaufsübersicht-aktiv/neuer-einkauf" method="POST" id="neuer-einkauf-form">
            @CSRF
            <input type="hidden" name="einkauf-edit-state" value="true">
            <input type="hidden" value="{{$selectedEinkauf->pos_id}}" name="id" id="einkauf-pos-id">
            <input type="hidden" name="type" id="einkauf-type" value="{{$selectedEinkauf->type}}">

            <div>
                <div class="hidden sm:block">
                  <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" onclick="changeType('einkauf')" id="einkauf-button" class="@if($selectedEinkauf->type == "einkauf") border-blue-500 text-blue-600 @else border-transparent text-gray-500 @endif whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" aria-current="page">Einkauf</button>
                        <button type="button" onclick="changeType('retoure')" id="retoure-button" class="@if($selectedEinkauf->type == "retoure") border-blue-500 text-blue-600 @else border-transparent text-gray-500 @endif hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">Retoure</button>
                      </nav>
                  </div>
                </div>
              </div>

            <div class="flex">
                <div class="mt-4" style="width: 70rem">
                    <div class="grid grid-cols-4 gap-2">
                        <div class="mt-6">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Rechnungsdatum</label>
                            <div class="mt-1">
                                <input type="date" value="{{$selectedEinkauf->rechnungs_datum}}" required name="date" id="einkauf-rechnungsdatum" class="block w-52 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                <script>
                                    var currentDateEinkauf = new Date();
                                    document.getElementById("einkauf-rechnungsdatum").valueAsDate = currentDateEinkauf;
                                </script>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="email" id="einkauf-auftrag-text-base" class="block text-sm font-medium leading-6 text-gray-900">Auftragsnummer</label>
                            <label for="email" id="einkauf-auftrag-text-not-found" class="block hidden text-sm font-medium leading-6 text-red-600">Auftragsnummer nicht gefunden</label>
                            <label for="email" id="einkauf-auftrag-text-found" class="block hidden text-sm font-medium leading-6 text-green-600">Auftragsnummer gefunden</label>

                            <div class="mt-1 float-left">
                                <input autocomplete="off" value="{{$selectedEinkauf->process_id}}" onfocus='document.getElementById("order-list").classList.remove("hidden");' oninput="getOrderList(this.value)" type="text" required name="process_id" id="einkauf-process_id" class="block w-52 rounded-tl-md rounded-bl-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <div class="overflow-y-scroll hidden w-52 h-36 bg-white absolute z-50 rounded-bl-md rounded-br-md shadow-md" id="order-list">
                                    @foreach ($orders as $order)
                                        <button class="w-full text-left hover:bg-gray-200 px-2 py-1" onclick="setOrder('{{$order->process_id}}')">{{$order->process_id}}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-1 float-left">
                                <button type="button" onclick="checkAuftragsnummer(document.getElementById('einkauf-process_id').value)" class="bg-blue-600 rounded-tr-md rounded-br-md hover:bg-blue-400 text-white p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>                              
                                </button>
                            </div>
                        </div>
    
                        <div class="col-span-2">
                            <div class="float-left ml-8">
                                <label for="price" class="block text-sm font-medium leading-6 text-gray-900 w-32">Gesamt-Nettopreis inkl. Versand</label>
                                <div class="relative mt-1 rounded-md shadow-sm ">
                                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 w-6">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                  </div>
                                  <input type="text" value="{{$selectedEinkauf->price}}" required name="price" id="price" class="block w-20 rounded-md border-0 py-1.5 pl-6 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                </div>
                            </div>
    
                            <button onclick="addNewPosition(document.getElementById('einkauf-pos-id').value)" type="button" class="text-white bg-blue-600 hover:bg-blue-400 rounded-md font-medium px-4 py-2 w-60 mt-12 float-right mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                <p>neue Position</p>                              
                            </button>
                        </div>
                    </div>
    
                    <div id="einkauf-auftrag-liste">
                        @include('forEmployees.einkauf.einkaufs-liste-modal')
                    </div>
                </div>
                <div class="ml-2 mr-2 w-0.5 bg-gray-200 mt-4 mb-4" style="height: 50rem">
                </div>
                <div class="pl-4">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Addressbuch</label>
                            <select id="location" onchange="getContact(this.value)" name="contact" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="{{$selectedEinkauf->contact}}" selected>{{$contacts->where("id", $selectedEinkauf->contact)->first()->shortcut}}</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Lieferantendaten</label>
                            <div class="mt-1">
                              <textarea rows="4" name="lieferant" id="comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{$selectedEinkauf->lieferantendaten}}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Plattform</label>
                            <div class="mt-1">
                              <input type="text" value="{{$selectedEinkauf->plattform}}" name="plattform" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                            <div class="mt-1">
                              <input type="text" value="{{$selectedEinkauf->url}}" name="url" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                            </div>
                        </div>
                    
                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Bestellnummer / Rechnungsnummer</label>
                            <div class="mt-1">
                              <input type="text" value="{{$selectedEinkauf->rechnungsnummer}}" name="rechnungsnummer" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Artikelbezeichnung</label>
                            <div class="mt-1">
                              <input type="text" value="{{$selectedEinkauf->bezeichnung}}" name="bezeichnung" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Zahlart</label>
                            <select id="location" name="zahlart" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="Paypal">Paypal</option>
                                <option value="Überweisung">Überweisung</option>
                                <option value="Kreditkarte">Kreditkarte</option>
                                <option value="Nachnahme">Nachnahme</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                            <select id="location" name="status" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="Bestellt">Bestellt</option>
                                <option value="Unterwegs">Unterwegs</option>
                                <option value="Erhalten">Erhalten</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Sendungsnummer</label>
                            <div class="mt-1 float-left w-full" >
                                <input type="text" value="{{$selectedEinkauf->tracking}}" name="tracking" class="block w-full rounded-tl-md rounded-bl-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                </div>
            </div>
            <hr class="border-gray-200 w- mb-4">
            <div class=>

                <button type="submit" onclick="loadData()" class="float-left rounded-md bg-blue-600 hover:bg-blue-400 px-4 py-2 text-white font-medium">Speichern</button>

                <button type="button" onclick="document.getElementById('einkauf-modal-div').innerHTML = '';" class="rounded-md text-black border border-gray-400 font-medium px-4 py-2 float-right">Zurück</button>

                @if ($selectedEinkauf->archiv == "true")
                    <button type="button" onclick="deleteEinkaufReverse('{{$selectedEinkauf->pos_id}}')" class="bg-red-600 hover:bg-red-400 rounded-md text-white font-medium px-4 py-2 float-right mr-9">zurück zu Aktiv</button>
                @else
                    <button type="button" onclick="deleteEinkauf('{{$selectedEinkauf->pos_id}}')" class="bg-red-600 hover:bg-red-400 rounded-md text-white font-medium px-4 py-2 float-right mr-9">Löschen</button>
                @endif

            </div>
        </form>
        </div>
      </div>
    </div>
  </div>



