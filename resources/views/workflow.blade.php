<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body>
@include('layouts/top-menu', ["menu" => "auftrag"])
@php
    $id = random_int(1000,1000000);
@endphp
<h1 class="text-4xl font-bold pt-2 pb-3 text-black pl-16 pt-8">Workflow Manager</h1>
    <div class="w-full px-8 mt-8">
        <div class="bg-white rounded-md px-8 py-2">
            <div class="w-full">
                <form action="{{url("/")}}/crm/workflow/neuer-workflow" onsubmit="loadData()" method="POST" id="neuer-workflow-form">
                    @CSRF
                <div class="inline-block">
                    <div class="flex">
                        <p class="mr-10 w-48 mt-3 font-semibold text-lg">Workflow Auftrag</p>
                        <select onchange="getWorkflow(this.value)" id="workflow" required name="workflow" class="mt-2 ml-0.5 block w-60 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                          <option value="new" selected>neuer Workflow Auftrag</option>
                          @foreach ($flowNames as $name)
                              <option value="{{$name->id}}">{{$name->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="flex mt-4">
                        <p class="mr-10 mt-1 font-semibold text-lg w-48">Bearbeitungszeit</p>
                        <input type="number" required name="time" id="time" class="block w-36 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
    
                    </div>
                    <div class="flex mt-4">
                        <p class="mr-10 mt-1 w-48 font-semibold text-lg">Name</p>
                        <input type="text" required name="name" id="name" class="block w-36 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <p onclick="deleteWorkflow()" id="delete-workflow-button" class="hidden inline-block text-right float-right mt-20 cursor-pointer text-red-600 hover:text-red-400 ml-8">löschen</p>
                <button type="submit" class="inline-block text-right float-right mt-20 cursor-pointer text-blue-600 hover:text-blue-400">neuen Workflow speichern</button>
                <input type="hidden" name="id" value="{{$id}}" id="new-workflow-id">
                </form>
            </div>

            <div class="mt-8">
                  <div>
                    <div class="flow-root">

                        <ul role="list" class="-mb-8" id="workflow-ablauf">
                                
                        </ul>

                        <ul role="list" class="-mb-8 mt-8">
                            <li>
                                <div class="relative pb-8">
                                    <form action="{{url("/")}}/crm/workflow/neuer-punkt" method="POST" id="neuer-punkt-form">
                                        @CSRF
                                      <div class="relative flex space-x-3">
                                        <div>
                                          <span class="h-8 w-8 rounded-full bg-white border border-blue-600 flex items-center justify-center ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                              </svg>                                  
                                          </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                          <div style="width: 45rem" class="rounded-md border border-gray-300 px-4 py-2">
                                            <h1 class="text-xl font-bold">Schritt auswählen</h1>
                                            
                                            <div id="neuer-punkt-Status-setzen" class="flex hidden">
                                                <p class="mr-8 mt-4">Status wählen</p>
                                                <select name="Status setzen" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="">Status</option>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-Status-prüfen" class="flex hidden">
                                                <p class="mr-8 mt-4">Status wählen</p>
                                                <select name="Status prüfen" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="">Status</option>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-E-Mail-senden" class="flex hidden">
                                                <p class="mr-8 mt-4">E-Mail wählen</p>
                                                <select name="E-Mail senden" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="">E-Mails</option>
                                                    @foreach ($emails as $mail)
                                                        <option value="{{$mail->id}}">{{$mail->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-Rechnung-erstellen" class="flex hidden">
                                                <p class="mr-8 mt-4">Rechnungsart auswählen</p>
                                                <select name="Rechnung erstellen" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="">Rechnungsart</option>
                                                    <option value="Rechnung">Rechnung</option>
                                                    <option value="Angebot">Angebot</option>
                                                    <option value="Gutschrift">Gutschrift</option>
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-Packtisch" class="flex hidden">
                                                <p class="mr-8 mt-4">Packtischauftrag auswählen</p>
                                                <select name="Packtisch" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="">Packtischauftrag</option>
                                                    <option value="Rechnung">Fotoauftrag</option>
                                                    <option value="Angebot">Nachforschungsauftrag</option>
                                                    <option value="Umlagerungsauftrag">Umlagerungsauftrag</option>
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-Verschieben" class="hidden flex">
                                                <p class="mr-8 mt-4">Verschieben zu</p>
                                                    <select name="Verschieben" class="mt-4 w-60 cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                        <option value="Auftrag-Aktiv">Auftrag-Aktiv</option>
                                                        <option value="Auftrag-Archiv">Auftrag-Archiv</option>
                                                        <option value="Interessenten-Aktiv">Interessenten-Aktiv</option>
                                                        <option value="Interessenten-Archiv">Interessenten-Archiv</option>
                                                    </select>       
                                            </div>

                                            <div id="neuer-punkt-Versandauftrag-Techniker" class="hidden flex">
                                                <p class="mr-8 mt-4">Optional:</p>
                                                <select name="Versandauftrag Techniker" id="">
                                                    <option value="">Techniker</option>
                                                    
                                                </select>
                                            </div>

                                            <div id="neuer-punkt-Wareneingang-prüfen" class="hidden flex">
                                                     
                                            </div>


                                            <div class="float-right flex mt-8">
                                                <select name="aktion" required onclick="changeAkionTab(this.value)" class="cursor-pointer rounded-md border border-gray-400 ml-4 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                                                    <option value="" class="font-semibold text-md">Aktion</option>
                                                    <option value="Rechnung erstellen">Rechnung erstellen</option>
                                                    <option value="Versandauftrag Techniker">Versandauftrag Techniker</option>
                                                    <option value="Versandauftrag Kunde">Versandauftrag Kunde</option>
                                                    <option value="Packtisch">Packtisch</option>
                                                    <option value="Entsorgung">Entsorgung</option>
                                                    <option value="E-Mail senden">E-Mail senden</option>
                                                    <option value="Status setzen">Status setzen</option>
                                                    <option value="Zuweisung">Zuweisung</option>
                                                    <option value="Verschieben">Verschieben</option>
                                                    <option value="" class="font-semibold text-md">Prüfung</option>
                                                    <option value="Status prüfen">Status prüfen</option>
                                                    <option value="Wareneingang prüfen">Wareneingang prüfen</option>
                                                    <option value="Posteingang prüfen">Posteingang prüfen</option>
                                                </select>
                            
                                                <button type="submit" class="hover:bg-gray-100 px-2 rounded-md font-medium text-md border border-gray-400 ml-4">
                                                    Schritt hinzufügen
                                                </button>
                                            </div>
                                          </div>
                                    
                                        </div>
                                      </div>
                                      <input type="hidden" name="id" id="workflow-id" value="{{$id}}">
                                    </form>
                                </div>
                                  </li>
                                  
    </ul>
</div>
                  </div>
            </div>
        </div>
    </div>
<script>        
    $('#neuer-punkt-form').ajaxForm(function(data) {
      $("#workflow-ablauf").html(data);
    });
    
    $('#neuer-workflow-form').ajaxForm(function(data) {
        $("#workflow-ablauf").html("");
        let name = document.getElementById("name").value;
        document.getElementById("time").value = "";
        document.getElementById("name").value = "";
        document.getElementById("workflow").value = "new";
        savedPOST();
        $.get("{{url("/")}}/crm/workflow/get-infos-"+name, function(data) {
            var x = document.getElementById("workflow");
            var option = document.createElement("option");
            option.text = data["name"];
            option.value = data["id"];
            x.add(option);
        });
    });
   


    let oldAktionTab = "";
    function changeAkionTab(tab) {
        if(document.getElementById("neuer-punkt-"+oldAktionTab.replace(" ", "-"))) {
            document.getElementById("neuer-punkt-"+oldAktionTab.replace(" ", "-")).classList.add("hidden");
        }
        oldAktionTab = tab;
        document.getElementById("neuer-punkt-"+tab.replace(" ", "-")).classList.remove("hidden");

    }

    function getWorkflow(id) {
        loadData();
        if(id != "new") {
            $.get("{{url("/")}}/crm/workflow/get-workflow-"+id, function(data) {
            $("#workflow-ablauf").html(data);
            $.get("{{url("/")}}/crm/workflow/get-infos-"+id, function(data) {
                document.getElementById("time").value = data["bearbeitungszeit"];
                document.getElementById("name").value = data["name"];
                document.getElementById("delete-workflow-button").classList.remove("hidden");
                savedPOST();
            });
        })
        } else {
            $("#workflow-ablauf").html("");
            document.getElementById("time").value = "";
            document.getElementById("name").value = "";
            document.getElementById("delete-workflow-button").classList.add("hidden");
            savedPOST();
        }
        
    }

    function deleteWorkflowPoint(id) {
        loadData();
        $.get("{{url("/")}}/crm/workflow/delete-point-"+id, function(data) {
            $("#workflow-ablauf").html(data);
            savedPOST();
        });
    }

    function deleteWorkflow() {
        loadData();
        let id = document.getElementById("workflow").value;
        $.get("{{url("/")}}/crm/workflow/delete-workflow-"+id, function(data) {
            $("#workflow-ablauf").html("");
            document.getElementById("workflow").value = "new";
            document.getElementById("time").value = "";
            document.getElementById("name").value = "";
            document.getElementById("delete-workflow-button").classList.add("hidden");
            $('#workflow option').each(function() {
                if ( $(this).val() == id ) {
                    $(this).remove();
                }
            });
            savedPOST();
        });
    }

</script>
</body>
</html>