<form action="{{url("/")}}/crm/packtisch/neuer-entsorgungsauftrag" id="packtisch-entsorgung-form" method="POST">
    @csrf
    <input type="hidden" name="process_id" value="{{$order->process_id}}" id="">
    <div class="grid grid-cols-3" style="width: 50rem">
        <p class="mt-8">Gerät fotografieren?</p>

    
    <div class="col-span-2 mt-8">
        <button type="button" onclick="selectAllentsorgungungsauftragDevices()" class="text-left">
            <p class="text-blue-600 hover:text-blue-400 text-sm" id="ent-select-text">Alle Teile auswählen</p>
        </button>
        <div class="grid grid-cols-3 w-full gap-2">
            @php
                $deviceCounter = 0;
            @endphp
            @foreach ($order->devices as $device)
            @if ($device->usedShelfes != null && $order->warenausgang->where("component_number", $device->component_number)->first() == null && $order->intern->where("component_number", $device->component_number)->first() == null)

            <div>

                <button class="w-full" type="button" onclick="toggleentsorgungungsauftragDevice('{{$device->component_number}}')">
                    <div id="device-div-entsorgung-{{$device->component_number}}" class="px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                        <p class="text-center float-left text-sm">{{$device->component_number}}</p>
                        <svg id="entsorgung-device-svg-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right ml-1 mt-0.5 hidden">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
                
            </div>
            @php
                $deviceCounter++;
            @endphp
            @endif
        
            @endforeach

            @if ($deviceCounter == 0)
                <div>
                    <p class="text-xl text-red-600 w-60">Keine Geräte verfügbar</p>
                    <script>
                        document.getElementById("ent-select-text").innerHTML "";
                    </script>
                </div>
                @endif
        </div>
    </div>

        <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>
        <textarea name="info" id="entsorgungsauftrag-info" class="mt-8 rounded-md border border-gray-300 h-16 col-span-2" cols="30" rows="10"></textarea>

        <div class="mt-10 mb-4 col-start-3">
            <hr>
            <button type="submit" onclick="loadData()" class=" bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium float-right py-2 w-60  mt-4">An Packtisch senden</button>
        </div>
    

    </div>


    <div id="entsorgung-inputlist">

    </div>
</form>


<script>

function toggleentsorgungungsauftragDevice(id) {

if(document.getElementById("device-input-entsorgung-"+id)) {
    document.getElementById("device-input-entsorgung-"+id).remove();
    document.getElementById("device-div-entsorgung-"+id).classList.add("border-gray-300");
    document.getElementById("device-div-entsorgung-"+id).classList.remove("border-blue-400");
    document.getElementById("device-div-entsorgung-"+id).classList.add("text-gray-500");
    document.getElementById("device-div-entsorgung-"+id).classList.remove("text-blue-500");
    document.getElementById("entsorgung-device-svg-"+id).classList.add("hidden");
    
} else {

    let div = document.getElementById("entsorgung-inputlist");

    let input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("id", "device-input-entsorgung-"+id);
    input.value = id;
    input.setAttribute("name", "device-"+id);

    div.appendChild(input);

    document.getElementById("device-div-entsorgung-"+id).classList.remove("border-gray-300");
    document.getElementById("device-div-entsorgung-"+id).classList.add("border-blue-400");
    document.getElementById("device-div-entsorgung-"+id).classList.remove("text-gray-500");
    document.getElementById("device-div-entsorgung-"+id).classList.add("text-blue-500");
    document.getElementById("entsorgung-device-svg-"+id).classList.remove("hidden");

}
}

function selectAllentsorgungungsauftragDevices() {

let devices = [@foreach($order->devices as $device) "{{$device->component_number}}", @endforeach , "last"];

devices.forEach(device => {
    if(!document.getElementById("device-input-entsorgung-"+device)) {

        if(device != "last") {
            let div = document.getElementById("entsorgung-inputlist");

            let input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("id", "device-input-entsorgung-"+device);
            input.value = device;
            input.setAttribute("name", "device-"+device);

            div.appendChild(input);

            document.getElementById("device-div-entsorgung-"+device).classList.remove("border-gray-300");
            document.getElementById("device-div-entsorgung-"+device).classList.add("border-blue-400");
            document.getElementById("device-div-entsorgung-"+device).classList.remove("text-gray-500");
            document.getElementById("device-div-entsorgung-"+device).classList.add("text-blue-500");
            document.getElementById("entsorgung-device-svg-"+device).classList.remove("hidden");

        }
    } 
});
}

function toggleEntsorgungNachnahme() {

if(document.getElementById("versand-entsorgung-input-nachnahme").value == "false") {
    document.getElementById("versand-entsorgung-nachnahme-button").classList.add("bg-blue-600");
    document.getElementById("versand-entsorgung-nachnahme-button").classList.remove("bg-gray-200");

    document.getElementById("versand-entsorgung-nachnahme-span").classList.add("translate-x-5");
    document.getElementById("versand-entsorgung-nachnahme-span").classList.remove("translate-x-0");

    document.getElementById("versand-entsorgung-input-nachnahme").value = "true";
} else {
    document.getElementById("versand-entsorgung-nachnahme-button").classList.remove("bg-blue-600");
    document.getElementById("versand-entsorgung-nachnahme-button").classList.add("bg-gray-200");

    document.getElementById("versand-entsorgung-nachnahme-span").classList.remove("translate-x-5");
    document.getElementById("versand-entsorgung-nachnahme-span").classList.add("translate-x-0");

    document.getElementById("versand-entsorgung-input-nachnahme").value = "false";
}
}

function turnOffEntsorgungNachnahme() {

    document.getElementById("versand-entsorgung-nachnahme-button").classList.remove("bg-blue-600");
    document.getElementById("versand-entsorgung-nachnahme-button").classList.add("bg-gray-200");

    document.getElementById("versand-entsorgung-nachnahme-span").classList.remove("translate-x-5");
    document.getElementById("versand-entsorgung-nachnahme-span").classList.add("translate-x-0");

    document.getElementById("versand-entsorgung-input-nachnahme").value = "false";
}

function turnOnEntsorgungNachnahme() {

    document.getElementById("versand-entsorgung-nachnahme-button").classList.add("bg-blue-600");
    document.getElementById("versand-entsorgung-nachnahme-button").classList.remove("bg-gray-200");

    document.getElementById("versand-entsorgung-nachnahme-span").classList.add("translate-x-5");
    document.getElementById("versand-entsorgung-nachnahme-span").classList.remove("translate-x-0");

    document.getElementById("versand-entsorgung-input-nachnahme").value = "true";
}

</script>