@isset ($order->devices[0])
<div class="pb-4 h-full">
<div class="bg-white rounded-md mt-4 h-full " >
    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class=" flow-root h-full">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 h-full">
            <div class="inline-block min-w-full align-middle h-full border border-gray-300 rounded-md">
              <table class="min-w-full divide-y divide-gray-300 ">
                <thead>
                  <tr>
                    <th scope="col" class="py-1 pl-4 text-left text-sm font-semibold text-gray-900">Gerätedaten</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">Bauteil</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">Model</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">Hersteller Nr</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">Lagerplatz</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">Bemerkung</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">OS</th>
                    <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">FS</th>
                    <th scope="col" class=" py-1 text-right text-sm font-semibold text-gray-900">Letzter Ort</th>
                    <th scope="col" class=" py-1 text-right text-sm font-semibold text-gray-900">Letzte Änderung</th>
                    <th scope="col" class="py-1 pr-4 text-right text-sm font-semibold text-gray-900">
                      Aktion
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->devices as $device)
                    
                    <tr id="device-row-{{$device->component_number}}">

                            <input type="hidden" name="component_number" value="{{$device->component_number}}">
                        <td class="whitespace-nowrap pl-4 py-1 text-sm text-gray-500"><p class="text-blue-400 hover:text-blue-200 cursor-pointer" onclick="getDeviceInfos('{{$device->component_number}}')">{{$device->component_number}}</p></td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            <p id="device-component-{{$device->component_number}}">@isset($device->deviceData){{$device->deviceData->component}}@endisset</p>
                            <select name="component" style="padding: 0px; padding-left: 2px; appearance: none;" id="component-{{$device->component_number}}" class="rounded-md h-6 w-36 border-gray-300 hidden">
                                @foreach ($components as $comp)
                                    @if ($device->component == $comp->shortcut)
                                        <option value="{{$comp->shortcut}}" selected>{{$comp->shortcut}}</option>
                                    @else
                                        <option value="{{$comp->shortcut}}">{{$comp->shortcut}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">@if($device->deviceData != null) <p id="device-model-{{$device->component_number}}">{{$device->deviceData->car_model}}</p> @endif
                            <input type="text" id="model-{{$device->component_number}}" class="rounded-md h-6 w-16 border-gray-300 hidden" value="@if($device->deviceData != null) {{$device->deviceData->car_model}} @endif" name="model">
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">@if($device->deviceData != null) <p id="device-fin-{{$device->component_number}}">{{$device->deviceData->fin}}</p> @endif
                            <input type="text" id="fin-{{$device->component_number}}" class="rounded-md h-6 w-16 border-gray-300 hidden" value="@if($device->deviceData != null) {{$device->deviceData->fin}} @endif" name="fin">

                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            @if($device->usedShelfes != null) 
                                <p id="device-shelfe-{{$device->component_number}}">{{$device->usedShelfes->shelfe_id}}</p> 
                            @else 
                                <p id="device-shelfe-{{$device->component_number}}"></p>  
                            @endif

                            @if ($device->usedShelfse != null)
                            <select style="padding: 0px; padding-left: 2px; appearance: none;" name="shelfe" id="shelfe-{{$device->component_number}}" class="appearance-none rounded-md h-6 w-16 border-gray-300 hidden">
                                @foreach ($shelfes as $shelfe)
                                    @if ($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first() == null)
                                        @if ($device->shelfe != null)
                                            @if ($device->usedShelfes->shelfe_id == $shelfe->shelfe_id)
                                                <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                            @else
                                                <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                            @endif
                                        @else
                                            <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                                        @endif
                                    @endif
                                    @if ( $device->usedShelfes != null)
                                    @if ($shelfe->shelfe_id == $device->usedShelfes->shelfe_id)
                                    <option value="{{$shelfe->shelfe_id}}" selected>{{$shelfe->shelfe_id}}</option>
                                    @endif
                                    @endif
                                @endforeach
                            </select>
                            @endif
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            <p id="device-info-{{$device->component_number}}">{{$device->info}}</p>
                            <input type="text" id="info-{{$device->component_number}}" class="rounded-md h-6 w-36 border-gray-300 hidden" value="{{$device->info}}" name="info">
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">@if($device->opened == "on") <p id="device-opened-{{$device->component_number}}" class="text-red-600 font-semibold">JA</p> @else <p id="device-opened-{{$device->component_number}}" class="text-red-600 font-semibold"></p> @endif
                        <input id="opened-{{$device->component_number}}" type="checkbox" name="opened" @if($device->opened == "on") checked @endif class="hidden">
                        
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500">@if($device->sticker == "on") <p id="device-sticker-{{$device->component_number}}" class="text-red-600 font-semibold">JA</p> @else <p id="device-sticker-{{$device->component_number}}" class="text-red-600 font-semibold"></p> @endif
                            <input id="sticker-{{$device->component_number}}" type="checkbox" name="sticker" @if($device->sticker == "on") checked @endif class="hidden">

                        
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-right text-gray-500">{{$device->ort}}</td>
                        <td class="whitespace-nowrap text-right py-1 text-sm text-gray-500">{{$device->updated_at->format("d.m.Y (H:i)")}}</td>
                        <td class="relative pr-4 whitespace-nowrap py-1 text-right text-sm text-gray-500 ">


                         @if ($device->primary_device == "true")
                            <button id="primary-device-true-{{$device->component_number}}" type="button" onclick="togglePrimaryDevice('{{$device->component_number}}')" class="float-right text-blue-600 hover:text-blue-400"> 
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                  </svg>                                                           
                            </button>
                            <button id="primary-device-false-{{$device->component_number}}" type="button" onclick="togglePrimaryDevice('{{$device->component_number}}')" type="button" class="hidden float-right text-blue-600 hover:text-blue-400"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>                          
                             </button>
                            @else
                            <button id="primary-device-true-{{$device->component_number}}" type="button" onclick="togglePrimaryDevice('{{$device->component_number}}')" class="hidden float-right text-blue-600 hover:text-blue-400"> 
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                  </svg>                                                           
                            </button>
                            <button id="primary-device-false-{{$device->component_number}}" type="button" onclick="togglePrimaryDevice('{{$device->component_number}}')" type="button" class="float-right text-blue-600 hover:text-blue-400"> 
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                               </svg>                          
                            </button>
                         @endif

                         @if ($device->files != null)
                            <a href="{{url("/")}}/files/aufträge/{{$order->process_id}}/{{$device->component_number}}-g.pdf" target="_blank" class="float-right text-blue-600 hover:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                </svg>                              
                            </a>
                         @endif

                         <button id="change-device-{{$device->component_number}}" class="text-blue-600 hover:text-blue-400" type="button" onclick="changeDeviceInput('{{$device->component_number}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                              </svg>
                         </button>
                         
                         <button id="submit-device-{{$device->component_number}}" class="text-blue-600 hover:text-blue-400 hidden" type="button" onclick="submitDevice(event, '{{$device->component_number}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                              </svg>
                         </button>
                        </td>
                        <script>
            $('#submit-device-form').ajaxForm(function(data) { 
                $("#devicelist").html(data);
                savedPOST();
            });
                            
                        </script>
                      </tr>
                    </form>

                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</div>
</div>
@endisset

<form id="submit-device-form" action="{{url("/")}}/crm/order/change-device-data" method="POST">
    @CSRF
    <input type="hidden" name="component" id="input-component">
    <input type="hidden" name="fin" id="input-fin">
    <input type="hidden" name="shelfe" id="input-shelfe">
    <input type="hidden" name="info" id="input-info">
    <input type="hidden" name="model" id="input-model">
    <input type="hidden" name="sticker" id="input-sticker">
    <input type="hidden" name="opened" id="input-opened">

    <input type="hidden" name="component_number" id="input-component-number">
    </form>

<script>

    

    function submitDevice(e, id){
        loadData();
        let shelfe = "";
        if(document.getElementById("shelfe-"+id)) {
            shelfe = document.getElementById("shelfe-"+id).value;
        }

        let shelfeDevice = "";
        if(document.getElementById("device-shelfe-"+id)) {
            shelfeDevice = document.getElementById("device-shelfe-"+id).innerHTML;
        } else {
            shelfeDevice = "empty";
        }

        if(shelfe != shelfeDevice && shelfe != "") {
            if(confirm("Soll der Lagerplatz wirklich geändert werden?")) {
                document.getElementById("input-component-number").value = id;
                document.getElementById("input-component").value = document.getElementById("component-"+id).value;
                document.getElementById("input-model").value = document.getElementById("model-"+id).value;
                document.getElementById("input-fin").value = document.getElementById("fin-"+id).value;

                if(document.getElementById("shelfe-"+id)) {
                    document.getElementById("input-shelfe").value = document.getElementById("shelfe-"+id).value;
                }

                document.getElementById("input-info").value = document.getElementById("info-"+id).value;
                document.getElementById("input-sticker").value = document.getElementById("sticker-"+id).checked;
                document.getElementById("input-opened").value = document.getElementById("opened-"+id).checked;
                $('#submit-device-form').submit();

            } else {
                changeDeviceInput(id);
                savedPOST();
            }
        } else {
            document.getElementById("input-component-number").value = id;
            document.getElementById("input-component").value = document.getElementById("component-"+id).value;
            document.getElementById("input-model").value = document.getElementById("model-"+id).value;
            document.getElementById("input-fin").value = document.getElementById("fin-"+id).value;

            if(document.getElementById("shelfe-"+id)) {
                    document.getElementById("input-shelfe").value = document.getElementById("shelfe-"+id).value;
            }

            document.getElementById("input-info").value = document.getElementById("info-"+id).value;
            console.log(document.getElementById("sticker-"+id).value)
            document.getElementById("input-sticker").value = document.getElementById("sticker-"+id).checked;
                document.getElementById("input-opened").value = document.getElementById("opened-"+id).checked;
            $('#submit-device-form').submit();

        }
       
    }

    @if($order->devices->where("primary_device", "true")->first() != null)
        oldPrimary = "{{$order->devices->where("primary_device", "true")->first()->component_number}}";
    @endif
    function togglePrimaryDevice(device) {
            if(!oldPrimary.includes("-")) {
                if(document.getElementById("primary-device-false-"+device).classList.contains("hidden")) {
                    document.getElementById("primary-device-false-"+device).classList.remove("hidden");
                    document.getElementById("primary-device-true-"+device).classList.add("hidden");
                } else {
                    document.getElementById("primary-device-false-"+device).classList.add("hidden");
                    document.getElementById("primary-device-true-"+device).classList.remove("hidden");
                }
            } else {

            if(!document.getElementById("primary-device-true-"+oldPrimary).classList.contains("hidden")) {

                if(document.getElementById("primary-device-false-"+device).classList.contains("hidden")) {
                    document.getElementById("primary-device-false-"+device).classList.remove("hidden");
                    document.getElementById("primary-device-true-"+device).classList.add("hidden");
                } else {
                    document.getElementById("primary-device-false-"+device).classList.add("hidden");
                    document.getElementById("primary-device-true-"+device).classList.remove("hidden");
                }

                document.getElementById("primary-device-true-"+oldPrimary).classList.add("hidden");
                document.getElementById("primary-device-false-"+oldPrimary).classList.remove("hidden");


                } else {
                    
                if(document.getElementById("primary-device-false-"+device).classList.contains("hidden")) {
                    document.getElementById("primary-device-false-"+device).classList.remove("hidden");
                    document.getElementById("primary-device-true-"+device).classList.add("hidden");
                } else {
                    document.getElementById("primary-device-false-"+device).classList.add("hidden");
                    document.getElementById("primary-device-true-"+device).classList.remove("hidden");
                }
        }
            }

        oldPrimary = device;

        $.get("{{url("/")}}/crm/auftrag-gerät-toggle-primarydevice-"+device, function(data) {});
    }

    function setAsReklamation(device) {

        if(document.getElementById("device-row-"+device).classList.contains("bg-red-100")) {
            document.getElementById("device-row-"+device).classList.remove("bg-red-100");
            document.getElementById("reklamation-button-"+device).classList.remove("text-green-600", "hover:text-green-400");
            document.getElementById("reklamation-button-"+device).classList.add("text-red-600", "hover:text-red-400");
        } else {
            document.getElementById("device-row-"+device).classList.add("bg-red-100");
            document.getElementById("reklamation-button-"+device).classList.add("text-green-600", "hover:text-green-400");
            document.getElementById("reklamation-button-"+device).classList.remove("text-red-600", "hover:text-red-400");
        }

        if(document.getElementById("device-row-"+device).classList.contains("bg-red-100")) {
            if(confirm("Soll die Reklamation wirklich rückgängig gemacht werden?")) {
                $.get("{{url("/")}}/crm/auftrag-toggle-device-reklamation-"+device, function(data){});
            } else {
                newAlert("Nicht gesetzt", "Die Reklamation wurde nicht zurück gesetzt");
            }
        } else {
            if(confirm("Soll das Gerät wirklich als Reklamation gesetzt werden?")) {
                $.get("{{url("/")}}/crm/auftrag-toggle-device-reklamation-"+device, function(data){});
            } else {
                newAlert("Nicht gesetzt", "Die Reklamation wurde nicht gesetzt");
            }
        }

    }

</script>