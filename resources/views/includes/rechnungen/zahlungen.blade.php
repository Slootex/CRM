
<div class="relative z-50 " aria-labelledby="modal-title" role="dialog" aria-modal="true" >

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
      <div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >

        <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style=" width: 70rem;">
          <button onclick='neueZahlungModal()' class="absolute right-0 mr-8 px-3 py-1 bg-blue-600 hover:bg-blue-500 font-medium text-white rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>                
            neue Zahlung</button>


            <div>
              <h1 class="text-center text-xl font-semibold">Zahlungen setzen</h1>
            </div>
            <div>
              <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300"  id="neue-zahlung-table">
                <thead>
                    <td class="pr-12 font-medium text-gray-600 text-left">BelegNr.</td>
                    <td class=" font-medium      text-gray-600 text-left">Transaction ID</td>
                    <td class=" font-medium      text-gray-600 text-left">Zahlungsdatum</td>
                    <td class=" font-medium      text-gray-600 text-left">Zahlart</td>
                    <td class=" font-medium      text-gray-600 text-left">Bemerkung</td>
                    <td class=" font-medium      text-gray-600 text-right">Betrag</td>
                    <td class=""></td>
                </thead>
                <tbody>
                  @php
                      $allZahlungen = 0.00;
                      $usedRechnungsnummern = array();
                  @endphp
                  @foreach ($rechnungen as $rechnung)
                  
                  @if (!in_array($rechnung->rechnungsnummer, $usedRechnungsnummern))
                    @foreach ($rechnung->zahlungen as $zahlung)
                      <tr class="border border-gray-400 border-l-0 border-r-0">
                        <td class="text-left font-medium py-2 text-gray-600">{{$zahlung->rechnungsnummer}}</td>
                        <td class="text-left text-gray-600">{{$zahlung->transactionid}}</td>
                        @if (str_contains($zahlung->zahlungsdatum, "T"))
                          <td class="text-left text-gray-600"><p id='{{$zahlung->id}}-zahlung-zahlungsdatum'>{{date("d.m.Y (H:i)", strtotime($zahlung->zahlungsdatum))}}</p>
                            <input type='datetime-local' class='hidden rounded-md h-6 w-36' id='{{$zahlung->id}}-zahlung-zahlungsdatum-input' value="{{$zahlung->zahlungsdatum}}"></td>
                        @else
                          <td class="text-left text-gray-600"><p id='{{$zahlung->id}}-zahlung-zahlungsdatum'>{{$zahlung->zahlungsdatum}}</p>
                            <input type='datetime-local' class='hidden rounded-md h-6 w-36' id='{{$zahlung->id}}-zahlung-zahlungsdatum-input' value="{{$zahlung->zahlungsdatum}}"></td>
                        @endif  
                        <td class="text-left text-gray-600"><p id='{{$zahlung->id}}-zahlung-zahlart'>{{$zahlung->zahlart}}</p>
                          <input type='text' class='hidden rounded-md h-6 w-36' id='{{$zahlung->id}}-zahlung-zahlart-input' value="{{$zahlung->zahlart}}"></td>

                        <td class="text-left text-gray-600"><p id='{{$zahlung->id}}-zahlung-bemerkung'>{{$zahlung->bemerkung}}</p>
                          <input type='text' class='hidden rounded-md h-6 w-36' id='{{$zahlung->id}}-zahlung-bemerkung-input' value="{{$zahlung->bemerkung}}"></td>

                          <td id="{{$zahlung->id}}-zahlung-betrag-td" class="text-right text-gray-600" id="neue-zahlung-betrag">
                            <p id='{{$zahlung->id}}-zahlung-betrag'>{{ number_format(floatval($zahlung->betrag), 2, ',', '.');}}€</p>
                            </td>
                        <td>
                            <button type="button" onclick="deleteZahlung('{{$zahlung->id}}')" class="float-right text-red-600 hover:text-red-400">löschen</button>
                        </td>
                      </tr>
                      @php
                          $allZahlungen += str_replace(",", ".", $zahlung->betrag);
                      @endphp
                    @endforeach
                  @endif
                  @php
                      array_push($usedRechnungsnummern, $rechnung->rechnungsnummer);
                  @endphp
              @endforeach

                  <tr class="border border-t-0 border-l-0 border-r-0 border-gray-400" style="border-style: double; border-left: none; border-right: none; border-top-style: solid;">
                    <td class="text-left font-medium py-2">Gesamt</td>
                    <td class="text-center text-gray-600"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center text-gray-600"></td>
                    <td class="text-right text-black" id="neue-zahlung-endbetrag">{{number_format(floatval($allZahlungen), 2, ',', '.');}}€</td>
                    <td class="text-blue-600"></td>
                  </tr>

                </tbody>
              </table>
                  </div>
                </div>
              </div>
            </div>

        
           
            
           <div class=" pt-7 float-right w-full ">
            <div class="w-full grid grid-cols-3">
                <p></p>
                <div>
                    @if ($rechnungen[0]->bezahlt == "true")
                    <button type="button" onclick="setBezahlt('{{$rechnungen[0]->rechnungsnummer}}')" class="m-auto text-white font-medium text-md px-4 py-2 bg-red-600 hover:bg-red-400 rounded-md flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                          </svg> 
                          <p class="ml-1">Als unbezahlt makieren</p>                         
                    </button>
                    @else
                    <button type="button" onclick="setBezahlt('{{$rechnungen[0]->rechnungsnummer}}')" class="m-auto text-white font-medium text-md px-4 py-2 bg-green-600 hover:bg-green-400 rounded-md flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                          </svg> 
                          <p class="ml-1">Als bezahlt makieren</p>                         
                    </button>
                    @endif
                </div>
                <div>
                    <button type="button" onclick="document.getElementById('zahlung-rechnung-modal').innerHTML = '';" class="col-start-3 float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Zurück</button>
                </div>
            </div>
         </div>
        
      </div>

      <script>

        function submitTEXT() {

          document.getElementById("loadingSig").classList.toggle("hidden");
          document.getElementById("submitText").classList.toggle("bg-blue-600 hover:bg-blue-500");
          document.getElementById("submitText").classList.toggle("bg-red-600");

        var meta = document.createElement('meta');
        meta.httpEquiv = "csrf-token";
        meta.content = "{{ session()->token() }}";
        document.getElementsByTagName('head')[0].appendChild(meta);

        
          $.post( "{{url("/")}}/crm/einstellungen/signatur", {
          body: $('#testt').trumbowyg('html'),
          '_token': $('meta[name=csrf-token]').attr('content'),
          } , function( data ) {
            document.getElementById("loadingSig").classList.toggle("hidden");
            document.getElementById("submitText").classList.toggle("bg-red-600")
            document.getElementById("submitText").classList.toggle("bg-blue-600 hover:bg-blue-500");
            savedPOST();
          });  
        
        }

        $.trumbowyg.svgPath = '/icons.svg';
        $('#testt').trumbowyg();
</script>
<style>
.trumbowyg-box {
width: 100%;
border: none;
}
.trumbowyg-button-pane {
float: left

}
.trumbowyg-button-group {
float: left
}
.trumbowyg-editor {
border: solid rgb(168, 168, 168) 1px;
}
</style>
</div>
</div>
</div>














<div class="relative z-50 hidden" id="rechnung-neue-zahlung" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
    <div class="flex min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
      <div class="relative transform overflow-hidden rounded-md bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style=" width: 20rem;">
        <form action="{{url("/")}}/crm/neue-zahlung" method="POST" id="neue-zahlung-form">
          @CSRF
          <input type="hidden" name="rechnungsnummer" value="{{$rechnungen[0]->rechnungsnummer}}">
          <div>
            <h1 class="text-left text-xl font-semibold">Neue Zahlung</h1>
          </div>
          <div>
             

              <div class="py-2">
                <label for="TransaktionsID" class="block text-sm font-medium leading-6 text-gray-900">TransaktionsID</label>
                <div class="mt-1">
                  <input required type="text" name="transaktionsid" id="neue-zahlung-TransaktionsID" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
                </div>
              </div>

              <div class="py-2">
                <label for="Zahlungsdatum" class="block text-sm font-medium leading-6 text-gray-900">Zahlungsdatum</label>
                <div class="mt-1">
                  @php
                      $date = new DateTime();
                  @endphp
                  <input required value="{{$date->format("Y-m-d") . "T" . $date->format("H:i")}}" type="datetime-local" name="zahlungsdatum" id="neue-zahlung-Zahlungsdatum" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
                </div>
              </div>

              <div class="py-2">
                <label for="Zahlart" class="block text-sm font-medium leading-6 text-gray-900">Zahlart</label>
                <select id="neue-zahlung-Zahlart" name="zahlart" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                  <option value="Nachnahme">Nachnahme</option>
                  <option value="Bar">Bar</option>
                  <option value="Überweisung">Überweisung</option>
                </select>
              </div>

              <div class="py-2">
                <label for="Geldbetrag" class="block text-sm font-medium leading-6 text-gray-900">Geldbetrag</label>
                <div class="mt-1">
                  <input type="text" onkeypress="enforceNumberValidation(this)" data-decimal="2" name="betrag" id="neue-zahlung-Geldbetrag" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
                </div>
              </div>

              <div class="py-2">
                <label for="Bemerkung" class="block text-sm font-medium leading-6 text-gray-900">Bemerkung</label>
                <div class="mt-1">
                  <input type="text" name="bemerkung" id="neue-zahlung-Bemerkung" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="">
                </div>
              </div>
            
          </div>

         <div class="pt-7 float-left w-full">
           <button type="submit"  class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white px-6 text-center">Speichern <svg id="loadingSig" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden text-white float-right ml-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
          </svg>
          </button>
          <button class="hidden" onclick="checkDate()" type="submit" id="submit-zahlung-enu"></button>
           <button type="button" onclick="document.getElementById('rechnung-neue-zahlung-setzen-modal').classList.add('hidden')" class=" float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
       </div>

       <script>
        function checkRecnung() {
          if(document.getElementById("neue-zahlung-rechnungsnummern").value != "") {
            
          } else {
            newErrorAlert("Keine Rechnungen", "Es können nur Zahlungen gemacht werden wenn eine Rechnung existiert!");
          }
        }

        const elementThree = document.getElementById("neue-zahlung-Geldbetrag");

var lastValue = "";

elementThree.addEventListener("input", function (e) {
var inputValue = e.target.value;
var regex = /^\d+[,]?\d{0,2}$/;
var result = regex.test(inputValue);

if (result) {
lastValue = inputValue;
return (this.value = inputValue);
} else if (!result && inputValue != "" && lastValue != "") {
return (this.value = lastValue);
} else if (!result) {
lastValue = "";
return (this.value = "");
}
});
       </script>



       
<div class="relative hidden z-10" id="errorDateCheck" aria-labelledby="modal-title" role="dialog" aria-modal="true">
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
<div class="fixed inset-0 z-10 overflow-y-auto">
  <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
      <div class="sm:flex sm:items-start">
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
          <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
        </div>
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
          <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Datum könnte falsch sein</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">Achtung das Datum ist älter als 60 Tage wollen sie trotzdem fortfahren?</p>
          </div>
        </div>
      </div>
      <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        <button type="button" onclick="document.getElementById('errorDateCheck').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Nein</button>
        <button type="button" onclick="submitDateCheck()" class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Ja</button>
      
        <div class="hidden">
          <button id="submitneuezahlungbutton" type="submit"></button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<input type="hidden" name="dateCheck" id="checkdateinput" value="no">
      </form>
    </div>
  </div>
</div>
</div>