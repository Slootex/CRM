                    
                    
<form action="{{url("/")}}/crm/packtisch/neuer-umlagerungsauftrag" id="packtisch-umlagerungsauftrag-form" method="POST">
    @csrf
    <div class="grid grid-cols-3" style="width: 50rem">
        <p class="mt-8">Umlagerungsauftrag</p>
        <div class="mt-8 col-span-2">
            <div class=" flow-root">
              <div class=" overflow-x-auto">
                <div class="inline-block min-w-full align-middle ">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr>
                        <th scope="col" class="py-1 text-left text-sm font-bold text-blue-700">Gerätenummer</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-bold text-blue-700">Lagerplatz</th>
                        <th scope="col" class=" py-1 text-right text-sm font-bold text-blue-700">Zielplatz</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($order->devices as $device)

                        <tr>
                            <td class="whitespace-nowrap py-1 text-sm text-gray-500">
                                <div id="device-div-umlagerungsauftrag-{{$device->component_number}}" class="px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                                    <p class="text-center w-32 float-left">{{$device->component_number}}</p>
                                    <svg id="umlagerungsauftrag-device-svg-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                      </svg>
                                      
                                      
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                <p class="pl-6">
                                    @if ($device->usedShelfes != null)
                                        {{$device->usedShelfes->shelfe_id}}
                                        @else
                                        Nicht im Lager
                                    @endif
                                </p>
                            </td>
                            <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                                <select name="shelfe-{{$device->component_number}}" id="shelfe-select-umlagerungsauftrag-{{$device->component_number}}" @if($device->usedShelfes != null) onclick="selectUmlagerungsauftragDevice('{{$device->component_number}}', '{{$device->usedShelfes->shelfe_id}}')" @else onclick="selectUmlagerungsauftragDevice('{{$device->component_number}}', 'empty')" @endif class="block w-28 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 float-right">
                                    @foreach ($shelfes as $shelfe)
                                        @if ($device->usedShelfes != null)
                                            @if ($shelfe->shelfe_id == $device->usedShelfes->shelfe_id)
                                                <option selected value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                            @else
                                                <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                            @endif
                                            @else
                                                <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                        @endif
                                    @endforeach
                                  </select>
                            </td>
    
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>

              <textarea name="info" id="umlagerungsauftrag-info" class="mt-8 rounded-md border border-gray-300 h-16 col-span-2" cols="30" rows="10"></textarea>


                <div class="mt-10 col-start-3 mb-4">
                    <hr>
                    <button type="submit" onclick="loadData();" class=" bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60 float-right mt-4">An Packtisch senden</button>
                </div>
    </div>
    <div id="umlagerungsauftrag-inputlist">

    </div>
    <input type="hidden" name="process_id" value="{{$order->process_id}}">
</form>

<script>

var optionsUmlagerung = {
        error: function() {
            let title = "Unbekannter Fehler!";
            let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte schau das du mindestens ein Gerät zum verändern ausgewählt hast!";
            newErrorAlert(text, title);
        },
        success: function() {
            let title = "Umlagerungsauftrag erfolgreich!";
            let text = "Der Umlagerungsauftrag wurde erfolgreich an den Packtisch gesendet."; 
            newAlert(title, text);
            savedPOST();
        }
    };



    function selectUmlagerungsauftragDevice(device, oldShelfe) {

        let newShelfe = document.getElementById('shelfe-select-umlagerungsauftrag-'+device).value;

        if(oldShelfe != "empty") {
            if(newShelfe == oldShelfe) {
            document.getElementById("device-input-umlagerungsauftrag-"+device).remove();
            document.getElementById("device-div-umlagerungsauftrag-"+device).classList.add("border-gray-300");
            document.getElementById("device-div-umlagerungsauftrag-"+device).classList.remove("border-blue-400");
            document.getElementById("device-div-umlagerungsauftrag-"+device).classList.add("text-gray-500");
            document.getElementById("device-div-umlagerungsauftrag-"+device).classList.remove("text-blue-500");
            document.getElementById("umlagerungsauftrag-device-svg-"+device).classList.add("hidden");
        } else {
            if(!document.getElementById("device-input-umlagerungsauftrag-"+device)) {
                let div = document.getElementById("umlagerungsauftrag-inputlist");

                let input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("id", "device-input-umlagerungsauftrag-"+device);
                input.value = device;
                input.setAttribute("name", "device-"+device);

                div.appendChild(input);

                document.getElementById("device-div-umlagerungsauftrag-"+device).classList.remove("border-gray-300");
                document.getElementById("device-div-umlagerungsauftrag-"+device).classList.add("border-blue-400");
                document.getElementById("device-div-umlagerungsauftrag-"+device).classList.remove("text-gray-500");
                document.getElementById("device-div-umlagerungsauftrag-"+device).classList.add("text-blue-500");
                document.getElementById("umlagerungsauftrag-device-svg-"+device).classList.remove("hidden");

            }
            
        }
        }

    }
</script>