<form action="{{url("/")}}/crm/packtisch/neuer-nachforschungsauftrag" id="packtisch-nachforschungsauftrag-form" enctype="multipart/form-data" method="POST" >
    @csrf
    <div class="grid grid-cols-3 " style="width: 50rem">
        <p class="mt-8 w-60">Geräte auswählen</p>

        <div class="col-span-2 mt-8">
            <button type="button" onclick="selectAllnachforschungDevices()" class="text-left">
                <p class="text-blue-600 hover:text-blue-400 text-sm" id="nach-select-text">Alle Teile auswählen</p>
            </button>
            <div class="grid grid-cols-3 w-full gap-2">
                @php
                    $deviceCounter = 0;
                @endphp

                @foreach ($order->devices as $device)
                @if ($device->usedShelfes != null && $order->warenausgang->where("component_number", $device->component_number)->first() == null && $order->intern->where("component_number", $device->component_number)->first() == null)

                <div>
    
                    <button class="w-full" type="button" onclick="togglenachforschungDevice('{{$device->component_number}}')">
                        <div id="device-div-nachforschung-{{$device->component_number}}" class="px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                            <p class="text-center float-left text-sm">{{$device->component_number}}</p>
                            <svg id="nachforschung-device-svg-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right ml-1 mt-0.5 hidden">
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
                            document.getElementById("nach-select-text").innerHTML "";
                        </script>
                    </div>
                @endif

            </div>
        </div>

        <p class="mt-8 w-60 col-start-1">Aktuelle Auftragsdokumente</p>
        <div class="mt-8 max-h-96 overflow-auto">
            @php
            $fileCounter = 0;
        @endphp
            @foreach ($order->files as $file)
            <div class=" mt-2">
                <button type="button" onclick="selectnachforschungAuftradsdatein('{{$file->id}}')">
                    <div id="nachforschung-auftragsdatei-div-{{$file->id}}" class="px-3 py-1 rounded-md border border-gray-300 hover:border-blue-400 hover:text-blue-400 text-gray-500 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                          </svg>      
                          <p class="ml-2 float-left text-sm overflow-hidden truncate" style="max-width: 8rem">{{$file->filename}}</p>      
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="nachforschung-doc-check-{{$file->id}}" class="w-5 h-5 float-right ml-1 mt-0.5 hidden">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>      
                    </div>
                </button>
                <a href="{{url("/")}}/files/aufträge/{{$file->process_id}}/{{$file->filename}}" target="_blank" class="float-righ" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-2 text-blue-600 hover:text-blue-400 float-right">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                  </svg>
                </a>
            </div>
            @php
                $fileCounter++;
            @endphp
            @endforeach
        </div>


            <p class="mt-8 w-60 col-start-1">Zusatz / Dokumente</p>
            <div class=" mt-8 col-span-2">
                <div class="grid grid-cols-3">
                    <label class="border border-gray-300 mr-2 flex flex-col items-center px-4 py-1 bg-white rounded-lg tracking-wide uppercase cursor-pointer hover:bg-blue hover:text-blue-400">
                    
                        <span class="mt-0 text-base leading-normal">
                            <span class="float-left" id="emailvorlage-file"></span>  
                            <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                        </span>
                        <input type='file' oninput="uploadnachforschungDocuments()" multiple class="hidden" id="nachforchungsauftrag-fileinput" />
                    </label>
                </div>
                <input type="file" class="hidden" id="nachforschung-extradatein">

                <div id="nachforschung-files-div">
                </div>
            </div>

            <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>
              <textarea name="info" id="nachforschungsauftrag-info" class="mt-8 rounded-md border border-gray-300 h-16 col-span-2" cols="30" rows="10"></textarea>


                <div class="mt-10 mb-4 col-start-3">
                    <hr>
                    <button type="submit" onclick="loadData()" class=" bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60 float-right mt-4">An Packtisch senden</button>
                </div>
    </div>
    <div id="nachforschung-inputlist" class="col-span-2">
    </div>
    <input type="hidden" name="process_id" value="{{$order->process_id}}">

</form>

<script>
    function selectnachforschungAuftradsdatein(id) {
        let parentDiv = document.getElementById("nachforschung-auftragsdatei-div-"+id);
        let parentFilesDiv = document.getElementById("nachforschung-files-div");

        if(parentDiv.classList.contains("text-blue-500")) {
            parentDiv.classList.add("border-gray-300", "hover:border-blue-400", "hover:text-blue-400", "text-gray-500");
            parentDiv.classList.remove("text-blue-500", "border-blue-400", "hover:text-red-400", "hover:border-red-400");
            document.getElementById("nachforschung-doc-check-"+id).classList.add("hidden");
            document.getElementById("nachforschung-auftragsdatei-input-"+id).remove();
        } else {
            parentDiv.classList.remove("border-gray-300", "hover:border-blue-400", "hover:text-blue-400", "text-gray-500");
            parentDiv.classList.add("text-blue-500", "border-blue-400", "hover:text-red-400", "hover:border-red-400");
            document.getElementById("nachforschung-doc-check-"+id).classList.remove("hidden");

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "devicefile-"+id;
            input.value = id;
            input.setAttribute("id", "nachforschung-auftragsdatei-input-"+id);

            document.getElementById("nachforschung-files-div").appendChild(input);
        }
    }

    function uploadnachforschungDocuments() {
        let parent = document.getElementById("nachforschung-files-div");
        let fileCounter = 0;
        Array.from(document.getElementById("nachforchungsauftrag-fileinput").files)
          .forEach(parentFile => {
            let button = document.createElement("button");
            button.classList.add("px-3", "py-1", "rounded-md", "border", "border-blue-400", "hover:border-red-400", "hover:text-red-400", "h-8", "text-blue-500", "mt-2");
            button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left sm:hidden xl:hidden 2xl:block">  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>      '+ parentFile["name"];
            button.setAttribute("onclick", "deletenachforschungFile('"+ parentFile["name"] +"')");
            button.setAttribute("id", "nachforschung-filebutton-"+ parentFile["name"]);

            let br = document.createElement("br");
            br.setAttribute("id", "nachforschung-br-"+ parentFile["name"]);

            let input = document.createElement("input");
            input.type = "file";
            input.setAttribute("id", "nachforschung-fileinput-"+ parentFile["name"] );
            input.name = "extrafile-"+fileCounter + "[]";
            input.files = document.getElementById("nachforchungsauftrag-fileinput").files;
            input.classList.add("hidden");

            let name = document.createElement("input");
            name.type = "hidden";
            name.setAttribute("id", "nachforschung-filename-"+ parentFile["name"] );
            name.name = "filename-"+fileCounter + fileCounter;
            name.value = parentFile["name"];

            parent.appendChild(input);   
            parent.appendChild(br);
            parent.appendChild(button);
            parent.appendChild(name);
            fileCounter++;
        });
    }

    function deletenachforschungFile(id) {
        document.getElementById("nachforschung-filebutton-"+id).remove();
        document.getElementById("nachforschung-fileinput-"+id).remove();
        document.getElementById("nachforschung-br-"+id).remove();
        document.getElementById("nachforschung-filename-"+id).remove();
    }

    
function togglenachforschungDevice(id) {

if(document.getElementById("device-input-nachforschung-"+id)) {
    document.getElementById("device-input-nachforschung-"+id).remove();
    document.getElementById("device-div-nachforschung-"+id).classList.add("border-gray-300");
    document.getElementById("device-div-nachforschung-"+id).classList.remove("border-blue-400");
    document.getElementById("device-div-nachforschung-"+id).classList.add("text-gray-500");
    document.getElementById("device-div-nachforschung-"+id).classList.remove("text-blue-500");
    document.getElementById("nachforschung-device-svg-"+id).classList.add("hidden");
    
} else {

    let div = document.getElementById("nachforschung-inputlist");

    let input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("id", "device-input-nachforschung-"+id);
    input.value = id;
    input.setAttribute("name", "device-"+id);

    div.appendChild(input);

    document.getElementById("device-div-nachforschung-"+id).classList.remove("border-gray-300");
    document.getElementById("device-div-nachforschung-"+id).classList.add("border-blue-400");
    document.getElementById("device-div-nachforschung-"+id).classList.remove("text-gray-500");
    document.getElementById("device-div-nachforschung-"+id).classList.add("text-blue-500");
    document.getElementById("nachforschung-device-svg-"+id).classList.remove("hidden");

}
}

function deselectAllnachforschungDevices() {
    let devices = [@foreach($order->devices as $device) "{{$device->component_number}}", @endforeach , "last"];

    devices.forEach(device => {
        if (document.getElementById("device-input-nachforschung-" + device)) {
            document.getElementById("device-input-nachforschung-" + device).remove();
            document.getElementById("device-div-nachforschung-" + device).classList.add("border-gray-300");
            document.getElementById("device-div-nachforschung-" + device).classList.remove("border-blue-400");
            document.getElementById("device-div-nachforschung-" + device).classList.add("text-gray-500");
            document.getElementById("device-div-nachforschung-" + device).classList.remove("text-blue-500");
            document.getElementById("nachforschung-device-svg-" + device).classList.add("hidden");
        }
    });

    document.getElementById("nachforschung-inputlist").innerHTML = "";
    document.getElementById("nachforschung-files-div").innerHTML = "";


    let files = [@foreach($order->files as $file) "{{$file->id}}", @endforeach , "last"];
    files.forEach(file => {
        let parentDiv = document.getElementById("nachforschung-auftragsdatei-div-"+file);
        let parentFilesDiv = document.getElementById("nachforschung-files-div");

        if(parentDiv.classList.contains("text-blue-500")) {
            parentDiv.classList.add("border-gray-300", "hover:border-blue-400", "hover:text-blue-400", "text-gray-500");
            parentDiv.classList.remove("text-blue-500", "border-blue-400", "hover:text-red-400", "hover:border-red-400");
            document.getElementById("nachforschung-doc-check-"+file).classList.add("hidden");
            document.getElementById("nachforschung-auftragsdatei-input-"+file).remove();
        }
    });


}


function selectAllnachforschungDevices() {

let devices = [@foreach($order->devices as $device) "{{$device->component_number}}", @endforeach , "last"];

devices.forEach(device => {
    if(!document.getElementById("device-input-nachforschung-"+device)) {

        if(device != "last") {
            let div = document.getElementById("nachforschung-inputlist");

            let input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("id", "device-input-nachforschung-"+device);
            input.value = device;
            input.setAttribute("name", "device-"+device);

            div.appendChild(input);

            document.getElementById("device-div-nachforschung-"+device).classList.remove("border-gray-300");
            document.getElementById("device-div-nachforschung-"+device).classList.add("border-blue-400");
            document.getElementById("device-div-nachforschung-"+device).classList.remove("text-gray-500");
            document.getElementById("device-div-nachforschung-"+device).classList.add("text-blue-500");
            document.getElementById("nachforschung-device-svg-"+device).classList.remove("hidden");

        }
    } 
});
}
</script>