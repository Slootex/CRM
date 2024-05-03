
    <div class="relative hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="emailvorlage-bearbeiten-modal">
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
          <div class="flex  min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style=" width: 60rem;">
              <a href="#"><p onclick="document.getElementById('emailvorlage-bearbeiten-modal').classList.add('hidden')" class="float-right text-xl text-white bg-red-600 rounded-md px-1  py-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
              </p></a>
              

              <div class="px-6">
               <h1 class="text-xl font-semibold" id="emailvorlage-titel"></h1>
               <p class="text-normal text-gray-600">Name, Absender, Empfänger, Beipackzettel ändern</p>
              </div>

              <div class="px-6 pt-6">
                <select name="bereich" id="emailvorlage-bereich" class="rounded-md w-96 border-gray-600 h-9">
                  @php
                      $areas = array(
                        "0" => "Abholung",
                        "1" => "Aufträge",
                        "2" => "Versand",
                        "3" => "Kunden",
                        "4" => "Interessenten",
                        "5" => "Einkäufe",
                        "6" => "Retouren",
                        "7" => "Packtisch"
                      )
                  @endphp
                      <option value="8">Bereich</option>
                      @foreach ($areas as $key => $item)
                      <option value="{{$key}}">{{$item}}</option>
                      @endforeach
                </select>
              </div>

              <div class="px-6 pt-6 float-left">
                <input type="text" name="name" class="border-gray-600 rounded-md w-96 h-9" placeholder="Name" id="emailvorlage-name">
              </div>
              <div class="pt-6 pr-6 float-right">
                <input type="text" name="empfänger" class="border-gray-600 rounded-md w-96 h-9" placeholder="Empfänger" id="emailvorlage-emp">
              </div>
              <div class="px-6 pt-6 float-left">
                <input type="text" name="absender" class="border-gray-600 rounded-md w-96 h-9" placeholder="Absender" id="emailvorlage-absender">
              </div>
              <div class="pt-6 pr-6 float-right">
                <input type="text" name="subject" class="border-gray-600 rounded-md w-96 h-9" placeholder="Betreff" id="emailvorlage-subject">
              </div>
              <div class="pt-6 px-6 float-left">
                <select name="" onchange="addShortcut(this.value)" id="shortcut" class="border-gray-600 rounded-md w-96 h-9">
                  <option value="[order_number]">Auftragsnummer</option>
                  <option value="[status_number]">Vorgangsnummer</option>
                  <option value="[status]">Vorgangsname</option>
                  <option value="[date]">Datum</option>
                  <option value="[machine]">Automarke</option>
                  <option value="[model]">Automodell</option>
                  <option value="[constructionyear]">Baujahr</option>
                  <option value="[carid]">Fahrzeug-Identifizierungsnummer</option>
                  <option value="[vin_html]">Fahrzeugdaten</option>
                  <option value="[kw]">Fahrleistung (PS)</option>
                  <option value="[mileage]">Kilometerstand</option>
                  <option value="[mechanism]">Getriebe</option>
                  <option value="[fuel]">Kraftstoffart</option>
                  <option value="[manufacturer]">Hersteller</option>
                  <option value="[serial]">Teile.-/Herstellernummer</option>
                  <option value="[fromthiscar]">Stammt das Gerät aus dem angegebenen Fahrzeug?</option>
                  <option value="[files]">Dateien</option>
                  <option value="[compare-pdf]">Vergleich-PDF</option>
                  <option value="[description]">Was wurde bereits am Fahrzeug gemacht? Fehlerspeicher ausgelesen (Code/Text)?</option>
                  <option value="[companyname]">Firma</option>
                  <option value="[gender]">Anrede</option>
                  <option value="[sexual]">Sexual</option>
                  <option value="[firstname]">Vorname</option>
                  <option value="[lastname]">Nachname</option>
                  <option value="[street]">Straße</option>
                  <option value="[streetno]">Hausnummer</option>
                  <option value="[zipcode]">Postleitzahl</option>
                  <option value="[city]">Ort</option>
                  <option value="[country]">Land</option>
                  <option value="[phonenumber]">Telefonnummer</option>
                  <option value="[mobilnumber]">Mobilnummer</option>
                  <option value="[email]">Email</option>
                  <option value="[differing_shipping_address]">Abweichende Lieferadresse (komplett als Tabelle)</option>
                  <option value="[differing_companyname]">Firma - Abweichende Lieferadresse</option>
                  <option value="[differing_firstname]">Vorname - Abweichende Lieferadresse</option>
                  <option value="[differing_lastname]">Nachname - Abweichende Lieferadresse</option>
                  <option value="[differing_street]">Straße - Abweichende Lieferadresse</option>
                  <option value="[differing_streetno]">Hausnummer - Abweichende Lieferadresse</option>
                  <option value="[zipcode]">Postleitzahl - Abweichende Lieferadresse</option>
                  <option value="[differing_city]">Ort - Abweichende Lieferadresse</option>
                  <option value="[differing_country]">Land - Abweichende Lieferadresse</option>
                  <option value="[question]">Fragen</option>
                  <option value="[pricemwst]">Euro zzgl. MwSt.</option>
                  <option value="[radio_shipping]">DE Rückversand</option>
                  <option value="[radio_payment]">Zahlart</option>
                  <option value="[recall]">Rückruf</option>
                  <option value="[track]">Tracking-Email</option>
            
                </select>
              </div>
              <div class="pt-6 pr-6 float-right">
                <div class=" bg-grey-lighter">
                  <label class="float-left w-80 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                      
                      <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                          <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                      </svg></span>
                      <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value" class="hidden" name="filee" id="emailvorlage-fileinput" />
                  </label>
                  <button type="button" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>                    
                  </button>
                  <a target="_blank" class="float-right" id="emailvorlage-bearbeiten-ansehen-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400 mr-2 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    
                  </a>
              </div>
              </div>
              
              <div class="pt-6 px-6 float-left">
                <textarea name="body" id="emailvorlagen-text" class=""></textarea>


              </div>
               
              <div class="px-6 pt-7 float-left w-full">
                <button type="submit" onclick="loadData();" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white w-24 text-center">Speichern</button>
                <button type="button" onclick="document.getElementById('emailvorlage-bearbeiten-modal').classList.add('hidden')" class="float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
                <button type="button"  id="emailvorlage-delete-button" class="float-right bg-red-600 rounded-md font-semibold py-1.5 text-white w-24 text-center mr-2">Löschen</button> 
            </div>
            
          </div>
          <script>

            function addShortcut(val) {
              document.getElementById("emailvorlagen-text").innerHTML = "awd";
            }

            $('#emailvorlagen-text').trumbowyg();
            const btn = document.getElementById('shortcut');
            btn.addEventListener('change', function(event){
                $('#emailvorlagen-text').trumbowyg('execCmd', {
                    cmd: 'insertText',
                    param: document.getElementById('shortcut').value,
                    forceCss: false
                });
            });
            


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
      
      <script>
        function deletePDF(id) {
            if(confirm("Möchten Sie die Datei vollständig löschen?")) {
              document.getElementById('emailvorlage-file').innerHTML    = ""; 
              document.getElementById('emailvorlage-fileinput').value     = null;
              document.getElementById(id + "-template-file").innerHTML = "";
              $.get("{{url("/")}}/crm/email-vorlage/pdf-entfernen/" + id, function( data ) {
              });
            }
        }
      </script>
