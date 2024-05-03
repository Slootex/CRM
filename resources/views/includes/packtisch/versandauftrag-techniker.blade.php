<div>
    
     <form action="{{url("/")}}/crm/packtisch/neuer-technikerversand" id="packtisch-versand-techniker-form" class="flex" enctype="multipart/form-data" method="POST">
        @csrf
        <div id="versand-techniker-address-check-modal">

        </div>
        <div class="grid grid-cols-3 gap-2" style="width: 50rem;">
            
            <p class="mt-8">Versandartikel</p>

            @php
            $deviceCounter = 0;
        @endphp
        @foreach ($order->devices as $device)

         
        @if ($device->usedShelfes != null && $order->warenausgang->where("component_number", $device->component_number)->first() == null && $order->intern->where("component_number", $device->component_number)->first() == null)
        <button class="w-full" type="button" onclick="toggleTechnikerversandDevice('{{$device->component_number}}')" class="">
            <div id="device-div-versand-techniker-{{$device->component_number}}" class=" px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 hover:border-blue-400 hover:text-blue-400">
                <p class="text-center float-left text-sm">{{$device->component_number}}</p>
                <svg id="versand-techniker-device-svg-{{$device->component_number}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right ml-1 mt-0.5 hidden">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
        </button>
        @php
            $deviceCounter++;
        @endphp
        @endif
    
        
        @endforeach

        @if ($deviceCounter == 0)
            <div>
                <p class="text-xl text-red-600 mt-8">Keine Geräte verfügbar</p>
            </div>
        @endif

        <script>

            let deviceCounterTechnikerVersand = 0;

            function checkTechnikerVersandBeforePost() {

                let street = document.getElementById("tec_street").value;

                if(deviceCounterTechnikerVersand != 0 && street != "") {
                    checkTechnikerVersandAddress();
                } else {
                    if(deviceCounterTechnikerVersand == 0) {
                        newErrorAlert("Kein Gerät!", "Achtung es wurde kein Gerät ausgewählt!");
                    }
                    if(street == "") {
                        newErrorAlert("Keine Versandaddresse", "Achtung es wurde keine Versandaddresse ausgewählt");
                    }
                }
            }

            function checkTechnikerVersandAddress() {

                let v_street    = document.getElementById("tec_street").value;
                let v_streetno  = document.getElementById("tec_street_number").value;
                let v_city      = document.getElementById("tec_city").value;
                let v_zipcode   = document.getElementById("tec_zipcode").value;
                let v_country   = document.getElementById("versand-techniker-country").value;

                loadData();

                $.post("{{url("/")}}/crm/packtisch/versand-checkaddress", { 
                    street: v_street,
                    streetno: v_streetno,
                    city: v_city,
                    zipcode: v_zipcode,
                    country: v_country,
                    type: "versand-techniker"
                })
                    .done(function( data ) {
                    if(data == "ok") {
                        document.getElementById("submit-techniker-versand").click();
                        savedPOST();
                    } else {
                        document.getElementById("versand-kunde-address-check").innerHTML = data;
                        adrType = "techniker";
                        savedPOST();
                    }
                    
                });
            }

            function toggleTechnikerversandDevice(id) {

            if(document.getElementById("device-input-versand-techniker-"+id)) {
                deviceCounterTechnikerVersand--;

                document.getElementById("device-input-versand-techniker-"+id).remove();
                document.getElementById("device-div-versand-techniker-"+id).classList.add("border-gray-300");
                document.getElementById("device-div-versand-techniker-"+id).classList.remove("border-blue-400");
                document.getElementById("device-div-versand-techniker-"+id).classList.add("text-gray-500");
                document.getElementById("device-div-versand-techniker-"+id).classList.remove("text-blue-500");
                document.getElementById("versand-techniker-device-svg-"+id).classList.add("hidden");
            } else {
                deviceCounterTechnikerVersand++;

                let div = document.getElementById("versand-techniker-inputlist");
            
                let input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("id", "device-input-versand-techniker-"+id);
                input.value = id;
                input.setAttribute("name", "device-"+id);
            
                div.appendChild(input);
            
                document.getElementById("device-div-versand-techniker-"+id).classList.remove("border-gray-300");
                document.getElementById("device-div-versand-techniker-"+id).classList.add("border-blue-400");
                document.getElementById("device-div-versand-techniker-"+id).classList.remove("text-gray-500");
                document.getElementById("device-div-versand-techniker-"+id).classList.add("text-blue-500");
                document.getElementById("versand-techniker-device-svg-"+id).classList.remove("hidden");

            }
        
        }

        function toggleVersandtechnikerExtraPictures() {

            if(!document.getElementById("versand-techniker-extrapicture"))  {
                let input = document.createElement("input");
                input.type  = "hidden";
                input.name  = "extrapicture";
                input.value = "true";
                input.setAttribute("id", "versand-techniker-extrapicture");

                document.getElementById("versand-techniker-inputlist").appendChild(input);

                document.getElementById("versand-techniker-extrapicture-button").classList.add("bg-blue-600");
                document.getElementById("versand-techniker-extrapicture-button").classList.remove("bg-gray-200");

                document.getElementById("versand-techniker-extrapicture-span").classList.add("translate-x-5");
                document.getElementById("versand-techniker-extrapicture-span").classList.remove("translate-x-0");
            } else {
                document.getElementById("versand-techniker-extrapicture").remove();

                document.getElementById("versand-techniker-extrapicture-button").classList.remove("bg-blue-600");
                document.getElementById("versand-techniker-extrapicture-button").classList.add("bg-gray-200");

                document.getElementById("versand-techniker-extrapicture-span").classList.remove("translate-x-5");
                document.getElementById("versand-techniker-extrapicture-span").classList.add("translate-x-0");
            }
        }

        function uploadTechnikerversandDocuments() {
            let parent = document.getElementById("versand-techniker-files-div");
            let fileCounter = 0;
            Array.from(document.getElementById("versand-techniker-fileinput").files)
              .forEach(parentFile => {
                let button      = document.createElement("button");
                button.classList.add("px-3", "py-1", "rounded-md", "border", "border-blue-400", "hover:border-red-400", "hover:text-red-400", "h-8", "text-blue-500", "mt-2");
                button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left sm:hidden xl:hidden 2xl:block">  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>      <p class="truncate overflow-hidden">'+ parentFile["name"]+"</p>";
                button.setAttribute("onclick", "deleteTechnikerversandFile('"+ parentFile["name"] +"')");
                button.setAttribute("id", "versand-techniker-filebutton-"+ parentFile["name"]);

                let br = document.createElement("br");
                br.setAttribute("id", "versand-techniker-br-"+ parentFile["name"]);

                let input = document.createElement("input");
                input.type = "file";
                input.setAttribute("id", "versand-techniker-fileinput-"+ parentFile["name"] );
                input.name = "extrafile-"+fileCounter + "[]";
                input.files = document.getElementById("versand-techniker-fileinput").files;
                input.classList.add("hidden");

                let name = document.createElement("input");
                name.type = "hidden";
                name.setAttribute("id", "versand-techniker-filename-"+ parentFile["name"] );
                name.name = "filename-"+fileCounter + fileCounter;
                name.value = parentFile["name"];

                parent.appendChild(input);   
                parent.appendChild(br);
                parent.appendChild(button);
                parent.appendChild(name);
                fileCounter++;
            });
        }

        function deleteTechnikerversandFile(id) {
            document.getElementById("versand-techniker-filebutton-"+id).remove();
            document.getElementById("versand-techniker-fileinput-"+id).remove();
            document.getElementById("versand-techniker-br-"+id).remove();
            document.getElementById("versand-techniker-filename-"+id).remove();
        }

        let oldshipping_tec = "Standard_tec";
        let shipcounter_tec = 0;
        function setShipping(typ) {
        
        
          if(typ == "Samstag_tec") {
            if(oldshipping_tec == "Express_tec") {
              if(shipcounter_tec == 0) {
              document.getElementById("Samstag_tec").classList.add("border-blue-600");

              document.getElementById("shippingtype_tec").value = typ;
              shipcounter_tec = 1;
            } else {
              document.getElementById("Samstag_tec").classList.remove("border-blue-600");


              document.getElementById("shippingtype_tec").value = oldshipping_tec;
              shipcounter_tec = 0;
            }
            }
          } else {
            document.getElementById("Standard_tec").classList.remove("border-blue-600");
            document.getElementById("Express_tec").classList.remove("border-blue-600");
            document.getElementById(typ).classList.add("border-blue-600");
            document.getElementById("shippingtype_tec").value = typ;

            if(typ == "Standard_tec") {
              document.getElementById("Samstag_tec").classList.remove("border-blue-600");
              document.getElementById("Samstag_tec").classList.add("bg-gray-100");
              shipcounter_tec = 1;

            }
            if(typ == "Express_tec") {
              document.getElementById("Samstag_tec").classList.remove("bg-gray-100");

            }

            oldshipping_tec = typ;
          }
        }
        function selectAllTechnikerversandDevices() {

        let devices = [@foreach($order->devices as $device) "{{$device->component_number}}", @endforeach , "last"];

        devices.forEach(device => {
            if(!document.getElementById("device-input-versand-techniker-"+device)) {
            
                if(device != "last") {
                    let div = document.getElementById("versand-techniker-inputlist");
                
                    let input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("id", "device-input-versand-techniker-"+device);
                    input.value = device;
                    input.setAttribute("name", "device-"+device);
                
                    div.appendChild(input);
                
                    document.getElementById("device-div-versand-techniker-"+device).classList.remove("border-gray-300");
                    document.getElementById("device-div-versand-techniker-"+device).classList.add("border-blue-400");
                    document.getElementById("device-div-versand-techniker-"+device).classList.remove("text-gray-500");
                    document.getElementById("device-div-versand-techniker-"+device).classList.add("text-blue-500");
                    document.getElementById("versand-techniker-device-svg-"+device).classList.remove("hidden");
                    deviceCounterTechnikerVersand++;

                    document.getElementById("techniker-versand-select-text").innerHTML = "Alle abwählen";
                }
            } else {
                if(device != "last") {

                
                    document.getElementById("device-div-versand-techniker-"+device).classList.add("border-gray-300");
                    document.getElementById("device-div-versand-techniker-"+device).classList.remove("border-blue-400");
                    document.getElementById("device-div-versand-techniker-"+device).classList.add("text-gray-500");
                    document.getElementById("device-div-versand-techniker-"+device).classList.remove("text-blue-500");
                    document.getElementById("versand-techniker-device-svg-"+device).classList.add("hidden");
                    deviceCounterTechnikerVersand--;

                    document.getElementById("device-input-versand-techniker-"+device).remove();

                    document.getElementById("techniker-versand-select-text").innerHTML = "Alle Teile auswählen";
                }
            }
        });
        }
        function toggleVersandtechnikerNachnahme() {
        
        if(document.getElementById("versand-techniker-input-nachnahme").value == "false") {
            document.getElementById("versand-techniker-nachnahme-button").classList.add("bg-blue-600");
            document.getElementById("versand-techniker-nachnahme-button").classList.remove("bg-gray-200");
        
            document.getElementById("versand-techniker-nachnahme-span").classList.add("translate-x-5");
            document.getElementById("versand-techniker-nachnahme-span").classList.remove("translate-x-0");
        
            document.getElementById("versand-techniker-input-nachnahme").value = "true";
        } else {
            document.getElementById("versand-techniker-nachnahme-button").classList.remove("bg-blue-600");
            document.getElementById("versand-techniker-nachnahme-button").classList.add("bg-gray-200");
        
            document.getElementById("versand-techniker-nachnahme-span").classList.remove("translate-x-5");
            document.getElementById("versand-techniker-nachnahme-span").classList.add("translate-x-0");
        
            document.getElementById("versand-techniker-input-nachnahme").value = "false";
        }
        }

        function turnOffVersandtechnikerNachnahme() {
        
        document.getElementById("versand-techniker-nachnahme-button").classList.remove("bg-blue-600");
        document.getElementById("versand-techniker-nachnahme-button").classList.add("bg-gray-200");
        
        document.getElementById("versand-techniker-nachnahme-span").classList.remove("translate-x-5");
        document.getElementById("versand-techniker-nachnahme-span").classList.add("translate-x-0");
        
        document.getElementById("versand-techniker-input-nachnahme").value = "false";
        }

        function turnOnVersandtechnikerNachnahme() {
        
        document.getElementById("versand-techniker-nachnahme-button").classList.add("bg-blue-600");
        document.getElementById("versand-techniker-nachnahme-button").classList.remove("bg-gray-200");
        
        document.getElementById("versand-techniker-nachnahme-span").classList.add("translate-x-5");
        document.getElementById("versand-techniker-nachnahme-span").classList.remove("translate-x-0");
        
        document.getElementById("versand-techniker-input-nachnahme").value = "true";
        }

        function getTechnikerversandContact(contact) {

            $.get("{{url('/')}}/versand-versenden/get-contact/"+contact, function(tec) {

                document.getElementById("tec_companyname").value    = tec["companyname"];
                if(tec["gender"] == "0") {
                    document.getElementById("versand-techniker-gender").value      = "Herr";
                } else {
                    document.getElementById("versand-techniker-gender").value      = "Frau";
                }
                document.getElementById("tec_firstname").value                  = tec["firstname"];
                document.getElementById("tec_lastname").value                   = tec["lastname"];
                document.getElementById("tec_street").value                     = tec["street"];
                document.getElementById("tec_street_number").value              = tec["streetno"];
                document.getElementById("tec_zipcode").value                    = tec["zipcode"];
                document.getElementById("tec_city").value                       = tec["city"];
                document.getElementById("tec_email").value                      = tec["email"];
                document.getElementById("tec_mobil").value                      = tec["mobilnumber"];
                document.getElementById("tec_phone").value                      = tec["phonenumber"];
                document.getElementById("versand-techniker-country").value      = tec["country"];
                document.getElementById("versand-techniker-language").innerHTML = tec["language"];

            });

        }

        initializeTechniker();
    function initializeTechniker() {

      var input2 = document.getElementById('tec_street');

      var autocomplete2 = new google.maps.places.Autocomplete(input2);


      autocomplete2.addListener('place_changed', function () {
        if(confirm("Soll die Addresse wirklich geändert werden?")) {

        var place2 = autocomplete2.getPlace();

        let types = [];
        let names = [];

        place2.address_components.forEach(comp => {
            types.push(comp.types[0]);
            names.push(comp["long_name"]);
        });

        let counter = 0
        document.getElementById("tec_street").value = "";
        document.getElementById("tec_street_number").value = "";
        document.getElementById("tec_city").value = "";
        document.getElementById("tec_zipcode").value = "";
        document.getElementById("versand-techniker-country").value = "";
        console.log(types);
        types.forEach(type => {
          let name = names[counter];
          if(type == "route") {
            let street    = name;
            document.getElementById("tec_street").value = street;
          }
          if(type == "street_number") {
            let number    = name;
            document.getElementById("tec_street_number").value = number;
          }
          if(type == "postal_town") {
            let city    = name;
            document.getElementById("tec_city").value = city;
          }
          if(type == "locality") {
            let city    = name;
            document.getElementById("tec_city").value = city;
          }
          if(type == "postal_code") {
            let zipcode    = name;
            document.getElementById("tec_zipcode").value = zipcode;
          }
          if(type == "country") {
            let country    = name;
            document.getElementById("versand-techniker-country").value = country;
          }
          counter++;
        });

    }
});
}
    </script>

    <div class="col-start-1">
        <p>Technikerinfo</p>
        <select onchange="getTechnikerInfoVersand(this.value)" class="rounded-md border border-gray-300 px-4 w-60" style="padding-bottom; .4rem; padding-top: .4rem;">
            @foreach($order->devices as $device)
                <option value="{{$device->component_number}}">{{$device->component_number}}</option>
            @endforeach 
        </select>
    </div>
    <script>
        function getTechnikerInfoVersand(device) {
            $.get("{{url('/')}}/crm/packtisch/get-techniker-info/"+device, function(data) {
                document.getElementById("versand-techniker-info").value = data;
            });
        }
    </script>
    <div class="col-span-2 ">
        <textarea name="tec_info" id="versand-techniker-info" class="rounded-md border border-gray-300 h-16 w-full"></textarea>
        <p class="text-xs" id="versand-techniker-language">Englisch, Keine Fehlerbeschreibung, Keine Fehlercodes</p>
    </div>
     

     <p class="  col-start-1">Zusatz / Dokumente</p>
     <div class="  ">
         <label class="border border-gray-300 flex flex-col items-center px-4 py-1 bg-white rounded-lg tracking-wide uppercase cursor-pointer hover:bg-blue hover:text-blue-400">
             
             <span class="mt-0 text-base leading-normal">
                 <span class="float-left" id="emailvorlage-file"></span>  
                 <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                     <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                 </svg>
             </span>
             <input type='file' oninput="uploadTechnikerversandDocuments()" multiple class="hidden" id="versand-techniker-fileinput" />
         </label>
         <div id="versand-techniker-files-div">
             <input type="file" class="hidden" id="versand-techniker-extradatein">
         </div>
     </div>


     <p class=" col-start-1">Extra Bilder machen</p>

     <button type="button" onclick="toggleVersandtechnikerExtraPictures()" id="versand-techniker-extrapicture-button" class=" bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
         <span id="versand-techniker-extrapicture-span" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
     </button>


    <p class="col-start-1">Zusatzkommentar Packtisch</p>
      <textarea name="info" id="" class="rounded-md border border-gray-300 h-16 col-span-2 "></textarea>

        </div>
        <div class="m-auto px-8">
            <div class="m-auto 2xl:w-0.5 bg-gray-200" style="height: 30rem">

            </div>
        </div>
        <div class="float-right"style="width: 50rem;">
            <div class="mt-8 grid grid-cols-3 gap-2">
            <p class="font-bold text-md col-start-1">Empfängeraddresse</p>

            <select id="location" required name="contact" onchange="getTechnikerversandContact(this.value)" class="mt-2 col-start-1 col-span-3 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option value="">Addressbuch</option>
                @foreach ($contacts as $contact)
                    <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                @endforeach
              </select>

            <div class="relative col-start-1 col-span-3 mt-8">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                <input value="{{$order->send_back_company_name ?: $order->company_name}}" type="text" name="companyname" id="tec_companyname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div>
                <select id="versand-techniker-gender" name="gender" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Anrede</option>
                  <option value="Herr">Herr</option>
                  <option value="Frau">Frau</option>
                </select>
                <script>
                    document.getElementById("versand-techniker-gender").value = "{{$order->send_back_gender ?: $order->gender}}";
                </script>
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                <input type="text" required value="{{substr($order->send_back_firstname,0,34) ?: substr($order->firstname,0,34) ?: substr($order->send_back_company_name,0,34) ?: substr($order->company_name,0,34)}}" name="firstname" id="tec_firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                <input type="text" required value="{{substr($order->send_back_lastname,0,34) ?: substr($order->lastname,0,35)}}" name="lastname" id="tec_lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2 col-start-1 col-span-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                @php
                    $send_back_street_kunde = $order->send_back_street ?: $order->home_street;
                    $send_back_street_kunde = str_replace("'", "", $send_back_street_kunde);
                @endphp
                <input type="text" required value="{{$order->send_back_street ?: $order->home_street}}" name="street" id="tec_street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2 col-start-3">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straßennummer</label>
                @php
                    $send_back_street_number_kunde = $order->send_back_street_number ?: $order->home_street_number;
                    $send_back_street_number_kunde = str_replace("'", "", $send_back_street_number_kunde);
                @endphp
                <input type="text" required value="{{$order->send_back_street_number ?: $order->home_street_number}}" name="street_number" id="tec_street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            <div class="relative mt-2">
                <label for="name" required class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                @php
                    $send_back_zipcode_kunde = $order->send_back_zipcode ?: $order->home_zipcode;
                    $send_back_zipcode_kunde = str_replace("'", "", $send_back_zipcode_kunde);
                @endphp
                <input type="text" value="{{$order->send_back_zipcode ?: $order->home_zipcode}}" name="zipcode" id="tec_zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                @php
                    $send_back_city_kunde = $order->send_back_city ?: $order->home_city;
                    $send_back_city_kunde = str_replace("'", "", $send_back_city_kunde);
                 @endphp
                <input type="text" required value="{{$order->send_back_city ?: $order->home_city}}" name="city" id="tec_city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div>
                <select id="versand-techniker-country" required name="country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Land</option>
                  @foreach ($countries as $country)
                      <option value="{{$country->name}}">{{$country->name}}</option>
                  @endforeach
                </select>
                <script>
                    document.getElementById("versand-techniker-country").value = "{{$order->send_back_country ?: $order->home_country}}";
                </script>
            </div>

            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Email</label>
                <input type="text" value="{{$order->email}}" name="email" id="tec_email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Mobil</label>
                <input type="text" value="{{$order->mobile_number}}" name="mobil" id="tec_mobil" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>
            <div class="relative mt-2">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Festnetz</label>
                <input type="text" value="{{$order->phone_number}}" name="phone" id="tec_phone" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
            </div>

            </div>

            <div class="mt-8 grid grid-cols-3 gap-2">
                <select id="location" name="carrier" class="mt-4 h-10 block w-full rounded-md border-gray-300 py-1.5 border text-gray-900 sm:text-sm">
                    <option>UPS Versand</option>
                </select>

                <div class="col-span-2 grid grid-flow-col mt-4">
                    <input type="hidden" name="shippingtype" id="shippingtype_tec" value="Standard_tec">
                    <button type="button" id="Standard_tec"  onclick="setShipping('Standard_tec')" class="rounded-md border border-blue-600 px-2 py-2">
                    <div>
                    <h1>Standard</h1>
                    <p>5,95€</p>
                    </div>
                </button>
                    <button type="button" id="Express_tec" onclick="setShipping('Express_tec')" class="rounded-md border px-2 py-2 ml-2">
                    <div>
                    <h1>Express</h1>
                    <p>8,95€</p>
                    </div>
                </button>
                    <button type="button" id="Samstag_tec" onclick="setShipping('Samstag_tec')" class="bg-gray-100 rounded-md border px-2 py-2 ml-2">
                    <div >
                    <h1>Samstagszustellung</h1>
                    <p>Nur mit Express möglich</p>
                    </div>
                </button>
                </div>
            </div>

  
        
        <div id="versand-techniker-inputlist">

        </div>
        <input type="hidden" name="process_id" value="{{$order->process_id}}">
        <input type="hidden" name="gummi" id="versand-techniker-input-gummi" value="false">
        <input type="hidden" name="prot"  id="versand-techniker-input-prot"  value="false">
        <input type="hidden" name="seal"  id="versand-techniker-input-seal"  value="false">
        <input type="hidden" name="nachnahme" id="versand-techniker-input-nachnahme" value="false">
        <button class="hidden" type="submit" id="submit-techniker-versand"></button>
    </form>
</div>
<div class="w-full h-10 mt-10">
    <hr>
    <button type="button" onclick="checkTechnikerVersandBeforePost();" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60  mt-7">An Packtisch senden</button>
</div>
<br>
<script>
var optionsTechniker = {
        error: function() {
            let title = "Unbekannter Fehler!";
            let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte schau das du ein  Gerät und eine Versandaddresse ausgewählt hast!";
            newErrorAlert(title, text);
        },
        success: function() {
            let title = "Versandauftrag (Techniker) erfolgreich!";
            let text = "Der Versandauftrag (Techniker) wurde erfolgreich an den Packtisch gesendet."; 
            newAlert(title, text);
            savedPOST();
        }
    };


</script>
