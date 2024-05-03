
    <div class="w-full mt-8">
        <div class="bg-white rounded-md px-8 py-2">
            <div class="flex">
                <p class="mr-24 mt-3 font-semibold text-lg">Workflow</p>
                <select onchange="getWorkflow(this.value)" id="order-workflow" required name="workflow" class="mt-2 ml-0.5 block w-60 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="" selected>Workflow auswählen</option>
                        @foreach ($flowNames as $name)
                            <option value="{{$name->id}}">{{$name->name}}</option>
                        @endforeach
                </select>
               @if ($order->workflow == null)
                <button id="choose-workflow-button" type="button" onclick="changeWorkflowOrder('{{$order->process_id}}')" class="text-white px-4 rounded-md bg-blue-600 hover:bg-blue-400 font-medium text-md h-10 mt-2 ml-6">
                    auswählen
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right mt-1 ml-1">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                    </svg>                          
                </button>
                @else
                <button id="choose-workflow-button" type="button" onclick="changeWorkflowOrder('{{$order->process_id}}')" class="text-white px-4 hidden rounded-md bg-blue-600 hover:bg-blue-400 font-medium text-md h-10 mt-2 ml-6">
                    auswählen
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right mt-1 ml-1">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                    </svg>                          
                </button>
               @endif

               @if ($order->workflow != null)
                <button type="button" id="add-workflow-button" onclick="addWorkflow('{{$order->process_id}}')" class="text-white px-4 rounded-md bg-blue-600 hover:bg-blue-400 font-medium text-md h-10 mt-2 ml-6">
                    Hinzufügen                         
                </button>
                @if ($workflows->where("used", true)->first() == null)
                <button type="button" id="delete-workflow-button" onclick='document.getElementById("delete-workflow-modal").classList.remove("hidden");' class="text-white px-4 rounded-md bg-red-600 hover:bg-red-400 font-medium text-md h-10 mt-2 ml-6">
                    Löschen                         
                </button>
                @endif
               @else
               <button type="button" id="add-workflow-button" onclick="addWorkflow('{{$order->process_id}}')" class="text-white px-4 hidden rounded-md bg-blue-600 hover:bg-blue-400 font-medium text-md h-10 mt-2 ml-6">
                Hinzufügen                         
                </button>
                <button type="button" id="delete-workflow-button" onclick='document.getElementById("delete-workflow-modal").classList.remove("hidden");' class="text-white hidden px-4 rounded-md bg-red-600 hover:bg-red-400 font-medium text-md h-10 mt-2 ml-6">
                    Löschen                         
                </button>
               @endif

            </div>

            @if ($order->workflowpause == "pause")
                <p onclick="pauseWorkflow('{{$order->process_id}}')" id="workflow-start" class="text-red-600 hover:text-red-400 cursor-pointer w-36">Workflow pausiert</p>
                <p onclick="pauseWorkflow('{{$order->process_id}}')" id="workflow-pause" class="text-green-600 hover:text-green-400 cursor-pointer hidden w-36">Workflow gestartet</p>
                @else 
                <p onclick="pauseWorkflow('{{$order->process_id}}')" id="workflow-pause" class="text-green-600 hover:text-green-400 cursor-pointer w-36">Workflow gestartet</p>
                <p onclick="pauseWorkflow('{{$order->process_id}}')" id="workflow-start" class="text-red-600 hover:text-red-400 cursor-pointer hidden w-36">Workflow pausiert</p>
            @endif

            @if ($order->workflow == null)
                <p id="no-workflow-set" class="text-3xl text-center font-bold text-red-800 mt-10">Kein Workflow ausgewählt</p>
                @else

            @endif

            <div id="main-ablauf-div" @if($order->workflow == null) class="hidden" @endif>
                
            <div class="mt-8">
                <div>
                  <div class="flow-root">

                      <ul role="list" class="-mb-8" id="workflow-ablauf">
                              @if ($workflows != null)
                                  @include('workflow.order_ablauf')
                              @endif
                      </ul>

                      <ul role="list" class="-mb-8 mt-8">
                          <li>
                              <div class="relative pb-8">
                                  <form action="{{url("/")}}/crm/workflow/order/neuer-punkt" method="POST" id="neuer-punkt-form">
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
                                              </select>
                          
                                              <button type="submit" class="hover:bg-gray-100 px-2 rounded-md font-medium text-md border border-gray-400 ml-4">
                                                  Schritt hinzufügen
                                              </button>
                                          </div>
                                        </div>
                                  
                                      </div>
                                    </div>
                                    <input type="hidden" name="id" id="workflow-id" value="{{$order->process_id}}">
                                  </form>
                              </div>
                                </li>
                                
  </ul>
</div>
                </div>
          </div>
            </div>
        </div>
    </div>
    <script>
        let paused = false;
        $('#neuer-punkt-form').ajaxForm(function(data) {
            if(paused == false) {
                    document.getElementById("workflow-pause").classList.toggle("hidden");
                    document.getElementById("workflow-start").classList.toggle("hidden");
                    paused = true;
                }
                $("#workflow-ablauf").html(data);

            pauseWorkflow(id);

            savedPOST();
        });

        function changeWorkflowOrder(id) {
            loadData();

            let workflow = document.getElementById("order-workflow").value;
            if(workflow != "") {
                $.get("{{url("/")}}/crm/workflow/order/change-"+id+"-"+workflow, function(data) {
                    
                    $("#workflow-ablauf").html(data);
                    document.getElementById("main-ablauf-div").classList.remove("hidden");
                    if(document.getElementById("no-workflow-set") != null) {
                        document.getElementById("no-workflow-set").classList.add("hidden");
                    }

                    document.getElementById("choose-workflow-button").classList.add("hidden");
                    document.getElementById("add-workflow-button").classList.remove("hidden");
                    document.getElementById("delete-workflow-button").classList.remove("hidden");

                    savedPOST();
                });
            }
        }

        function deleteWorkflowPoint(id) {
            $.get("{{url("/")}}/crm/workflow/order/delete-"+id, function(data) {
                if(paused == false) {
                    pauseWorkflow(id);
                    if(document.getElementById("workflow-start").classList.contains("hidden")) {
                        document.getElementById("workflow-pause").classList.toggle("hidden");
                        document.getElementById("workflow-start").classList.toggle("hidden");
                    }
                    paused = true;

                }
                $("#workflow-ablauf").html(data);
                savedPOST();
                
            })
        }

        function pauseWorkflow(id) {
            loadData();
            $.get("{{url("/")}}/crm/workflow/order/pause-"+id, function(data) {
          
                    $("#workflow-ablauf").html(data);

                    if(!data.includes("Error")) {
                        document.getElementById("workflow-pause").classList.toggle("hidden");
                        document.getElementById("workflow-start").classList.toggle("hidden");
                        if(paused == true) {
                            paused = false;
                        }
                    } else {
                        $.get("{{url("/")}}/crm/workflow/order/pause-"+id, function(data) {
          
                            $("#workflow-ablauf").html(data);

                            if(!data.includes("Error")) {
                                document.getElementById("workflow-pause").classList.toggle("hidden");
                                document.getElementById("workflow-start").classList.toggle("hidden");
                                if(paused == true) {
                                    paused = false;
                                }
                            } else {
                            }

                           
      
                        })
                    }
                    savedPOST();
            })
        }

        function addWorkflow(id) {
            loadData();

            let workflow = document.getElementById("order-workflow").value;
            
            $.get("{{url("/")}}/crm/workflow/order/append-workflow/"+id+"/"+workflow, function(data) {
                $("#workflow-ablauf").html(data);

                savedPOST();
            })
        }

        function deleteWorkflow(id) {
            loadData();
            $.get("{{url("/")}}/crm/workflow/order/delete-workflow-"+id, function(data) {
                $("#workflow-ablauf").html(data);

                document.getElementById("delete-workflow-modal").classList.add("hidden");

                document.getElementById("choose-workflow-button").classList.remove("hidden");
                document.getElementById("add-workflow-button").classList.add("hidden");
                document.getElementById("delete-workflow-button").classList.add("hidden");

                savedPOST();
            })
        }
    </script>


<div class="relative z-50 hidden" id="delete-workflow-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Workflow löschen</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">Sind Sie sicher das der gesamte Workflow gelöscht werden soll?</p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:ml-10 sm:mt-4 sm:pl-4">
            <button type="button" onclick="deleteWorkflow('{{$order->process_id}}')" class="float-left w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Löschen</button>
            <button type="button" onclick='document.getElementById("delete-workflow-modal").classList.add("hidden");' class="mt-3 float-right w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>
