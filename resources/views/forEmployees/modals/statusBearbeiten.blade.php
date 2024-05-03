<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="bearbeiten">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-10 overflow-y-auto" >
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"  id="backgroundBodyStatusChange">
        <div style="width: 27rem;" class="relative transform overflow-hidden py-3 text-left shadow-xl transition-all sm:my-8">
          <div style="width: 25.75rem;" class="m-auto rounded-lg bg-white drop-shadow-lg">
            <div class="float-right mr-4 mt-4">
              <button onclick="document.getElementById('bearbeiten').classList.add('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>         
            </div>
            <div class="text-center">
              <div class="">
                <div>
                    <h1 class="text-left pl-4 pt-2 text-lg font-normal">Status ändern</h1>
                    <h1 class="text-left pl-4 pt-0 text-sm font-normal text-gray-600">Name, Farbe und Email Vorlage ändern</h1>
                </div>
                <form action="{{url("/")}}/crm/change/status/" method="POST" id="status-bearbeiten">
                  @CSRF
                  <div class="w-full2">
                      <div class="pl-4 mt-4">
                          <label for="location" class="block text-sm font-normal text-gray-700 text-left">Bereich</label>
                          <select id="bereich" name="area" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                              <option value="1">Abholen</option>
                              <option value="2">Aufträge</option>
                              <option value="3">Versand</option>
                              <option value="4">Kunden</option>
                              <option value="5">Interessenten</option>
                              <option value="6">Einkäufe</option>
                              <option value="7">Retouren</option>
                              <option value="8">Packtisch</option>
                          </select>
                      </div>
                      <div class="pl-4 mt-4">
                          <label for="email" class="block text-sm font-normal text-gray-700 text-left">Name</label>
                          <div class="mt-1">
                            <input type="text" name="name" id="status-name" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                          </div>
                      </div>
                      <div class="pl-4 mt-4">
                        <label for="email" class="block text-sm font-normal text-gray-700 text-left">Email Template</label>
                        <div class="mt-1">
                          <meta name="csrf-token" content="{{ csrf_token() }}">

                          <select id="temp" name="email" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            @foreach ($emails as $email)
                                <option value="{{$email->id}}">{{$email->name}}</option>
                            @endforeach
                        </select>                          </div>
                    </div>
                      <div class="pl-4 mt-4">
                        <label for="email" class="block text-sm font-normal text-gray-700 text-left">Hintergrund-Farbe</label>
                        <div class="mt-1">
                          <meta name="csrf-token" content="{{ csrf_token() }}">

                          <input type="color" oninput="" name="color" id="back-color" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                      </div>
                      <div class="pl-4 mt-4">
                        <label for="email" class="block text-sm font-normal text-gray-700 text-left">Text-Farbe</label>
                        <div class="mt-1">
                          <meta name="csrf-token" content="{{ csrf_token() }}">

                          <input type="color" oninput="" name="text_color" id="text-color" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                      </div>
                    <div class="py-4">
                        <hr>
                    </div>
                    <div class="pl-4">
                      <div class="float-left" style="width: 20rem;">
                        <h1 class="text-sm font-normal text-left">Frontend Webseite</h1>
                        <p style="font-size: .76rem; font-weight: 400" class="  text-gray-600 text-left">Dieser Status wird Online auf der Website angezeigt</p>
                      </div>
                      <div class="py-2">
                        <button type="button" id="frontButton" onclick="changeFrontend()" class=" bg-gray-20 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2" role="switch" aria-checked="false">
                            <span class="sr-only">Use setting</span>
                            <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                            <span aria-hidden="true" id="frontSpan" class="translate-x-0 pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                          </button>
                      </div>
                    </div>
                    <input type="hidden" name="state" id="state" >
                            <script>
                                let frontState = false;
                                function changeFrontend() {
                                    if(frontState == false) {

                                        document.getElementById("state").value = "on";

                                        document.getElementById("frontButton").classList.remove("bg-gray-200");
                                        document.getElementById("frontButton").classList.add("bg-lime-600");

                                        document.getElementById("frontSpan").classList.remove("translate-x-0");
                                        document.getElementById("frontSpan").classList.add("translate-x-5");
                                        frontState = true;
                                    } else {
                                        document.getElementById("state").value = "off";
                                        
                                        document.getElementById("frontButton").classList.add("bg-gray-200");
                                        document.getElementById("frontButton").classList.remove("bg-lime-600");

                                        document.getElementById("frontSpan").classList.add("translate-x-0");
                                        document.getElementById("frontSpan").classList.remove("translate-x-5");
                                        frontState = false;
                                    }
                                }
                            </script>
                    <div class="py-4">
                        <hr>
                    </div>
                    <div class="pl-4">
                        <div class="float-left" style="width: 20rem;">
                          <h1 class="text-sm font-normal text-left">E-Mail Administrator</h1>
                          <p style="font-size: .76rem; font-weight: 400" class=" font-light text-gray-600 text-left">Sobald der Status gebucht wird, wird eine Kopie der E-Mail an den Administrator geschickt</p>
                        </div>
                        <div class="py-2">
                          <button type="button" id="adminButton" onclick="changeEmailAdminInput()" class="bg-gray-200 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2" role="switch" aria-checked="false">
                              <span class="sr-only">Use setting</span>
                              <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                              <span aria-hidden="true" id="adminSpan" class="translate-x-0 pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                      </div>
                      <input type="hidden" name="admin" id="admin">
                            <script>
                                let adminState = false;
                                function changeEmailAdminInput() {
                                    if(adminState == false) {

                                        document.getElementById("admin").value = "yes";

                                        document.getElementById("adminButton").classList.remove("bg-gray-200");
                                        document.getElementById("adminButton").classList.add("bg-lime-600");

                                        document.getElementById("adminSpan").classList.remove("translate-x-0");
                                        document.getElementById("adminSpan").classList.add("translate-x-5");
                                        adminState = true;
                                    } else {
                                        document.getElementById("admin").value = "no";
                                        
                                        document.getElementById("adminButton").classList.add("bg-gray-200");
                                        document.getElementById("adminButton").classList.remove("bg-lime-600");

                                        document.getElementById("adminSpan").classList.add("translate-x-0");
                                        document.getElementById("adminSpan").classList.remove("translate-x-5");
                                        adminState = false;
                                    }
                                }
                            </script>
                      

                    <div class="py-4">
                      <hr>
                  </div>
                  <div class="pl-4 mt-2">
                      <div class="float-left" style="width: 20rem;">
                        <h1 class="text-sm font-normal text-left">Statistik</h1>
                        <p style="font-size: .76rem; font-weight: 400" class=" font-light text-gray-600 text-left">Ist der Status aktiv wird der Auftrag mit diesem Status für die Statistik mitgezählt</p>
                      </div>
                      <div class="py-2">
                        <select name="statistik" id="statistik" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          <option value="neukunde">Neukunde</option>
                          <option value="prüfung">Prüfung</option>
                          <option value="reklamation">Reklamation</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="py-4 w-full mt-4">
                      <hr>
                  </div>

                    <div class="pl-4">
                        <div class="float-left" style="width: 20rem;">
                          <h1 class="text-sm font-normal text-left">E-Mail Kunde</h1>
                          <p style="font-size: .76rem; font-weight: 400" class=" font-light text-gray-600 text-left">Sobald der Status gebucht wird, wird eine E-Mail an den Kunde geschickt</p>
                        </div>
                        <div class="py-2">
                          <button type="button" onclick="changeEmailKunde()" id="kundenButton" class=" bg-gray-200 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2" role="switch" aria-checked="false">
                              <span class="sr-only">Use setting</span>
                              <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                              <span aria-hidden="true" id="kundenSpan" class="translate-x-0 pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="kunde" id="kunde" >
                            <script>
                                let kundeState = false;
                                function changeEmailKunde() {
                                    if(kundeState == false) {

                                        document.getElementById("kunde").value = "yes";

                                        document.getElementById("kundenButton").classList.remove("bg-gray-200");
                                        document.getElementById("kundenButton").classList.add("bg-lime-600");

                                        document.getElementById("kundenSpan").classList.remove("translate-x-0");
                                        document.getElementById("kundenSpan").classList.add("translate-x-5");
                                        kundeState = true;
                                    } else {
                                        document.getElementById("kunde").value = "no";
                                        
                                        document.getElementById("kundenButton").classList.add("bg-gray-200");
                                        document.getElementById("kundenButton").classList.remove("bg-lime-600");

                                        document.getElementById("kundenSpan").classList.add("translate-x-0");
                                        document.getElementById("kundenSpan").classList.remove("translate-x-5");
                                        kundeState = false;
                                    }
                                }
                            </script>
                        </div>
                      </div>
                      <div class=" w-full mt-16">
                        <hr>
                    </div>
                    <div class="float-right pr-4 pt-4">
                        <button type="button" onclick="document.getElementById('bearbeiten').classList.add('hidden')" class="ml-4 inline-flex items-center rounded-md border border-black bg-white px-3 py-2 text-sm font-medium leading-4 text-black shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">Abbrechen</button>
                    </div>
                      <div class="float-left pt-4 pl-4">
                        <button type="submit"  class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
                     </div>
                     <div class="w-96" style="height: 4rem;">

                     </div>
                     
                    
                      </div>
                </form>                          </div>
            </div>
           
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <script>
    function readStatus(id) {
      $.get("{{url('/')}}/crm/statuse/bearbeiten/" + id, function( stat ) {

        document.getElementById("bereich").value      = stat["type"];
        document.getElementById("status-name").value  = stat["name"];
        document.getElementById("temp").value         = stat["email_template"];
        document.getElementById("back-color").value   = stat["color"];
        document.getElementById("text-color").value   = stat["text_color"]; 
        document.getElementById("state").value        = stat["status_status"];
        if(stat["public"] == "0" || stat["public"] == null) {
          frontState = true;
        }
        if(stat["public"] == "1") {
          frontState = false;
        }
        changeFrontend();

        if(stat["admin"] == "yes") {
          adminState = false;
        }
        if(stat["admin"] == "no" || stat["admin"] == null) {
          adminState = true;
        }
        changeEmailAdminInput();

        if(stat["kunde"] == "yes") {
          kundeState = false;
        }
        if(stat["kunde"] == "no" || stat["kunde"] == null) {
          kundeState = true;
        }
        changeEmailKunde();

        document.getElementById("statistik").value = stat["statistik"];

        document.getElementById('status-bearbeiten').action = '{{url("/")}}/crm/change/status/' + id;


        document.getElementById("bearbeiten").classList.remove('hidden');

        document.getElementById(id + "-row").classList.remove("update-row-animation");

        
      });
    }

    $(document).ready(function() { 
            $('#status-bearbeiten').ajaxForm(function( stat ) {
              if(document.getElementById(stat["id"] + "-background-color")) {
                document.getElementById(stat["id"] + "-background-color").style.backgroundColor = stat["color"];
                document.getElementById(stat["id"] + "-text-color").style.color                 = stat["text_color"];
                document.getElementById(stat["id"] + "-text-color").innerHTML                   = stat["name"];
                switch (stat["type"]) {
                  case "1":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Abholen";
                    break;
                  case "2":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Aufträge";
                    break;
                  case "3":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Versand";
                    break;
                  case "4":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Kunden";
                    break;
                  case "5":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Interessenten";
                    break;
                  case "6":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Einkäufe";
                    break;
                  case "7":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Retouren";
                    break;
                  case "8":
                    document.getElementById(stat["id"] + "-bereich").innerHTML = "Packtisch";
                    break;
                
                  default:
                    break;
                }

                document.getElementById(stat["id"] + "-template").innerHTML = stat["email_template"];

                if(stat["public"] == "1") {
                  document.getElementById(stat["id"] + "-public").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                if(stat["public"] == "0") {
                  document.getElementById(stat["id"] + "-public").innerHTML = '';
                }

                if(stat["kunde"] == "yes") {
                  document.getElementById(stat["id"] + "-kunde").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                if(stat["kunde"] == "no") {
                  document.getElementById(stat["id"] + "-kunde").innerHTML = '';
                }

                if(stat["admin"] == "yes") {
                  document.getElementById(stat["id"] + "-admin").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                if(stat["admin"] == "no") {
                  document.getElementById(stat["id"] + "-admin").innerHTML = '';
                }


                document.getElementById(stat["id"] + "-row").classList.add("update-row-animation");
                document.getElementById('bearbeiten').classList.add('hidden');

                savedPOST();

              } else {
                
                let table = document.getElementById('custom-status');

                let row   = table.insertRow(1);
                row.setAttribute('id', stat["sys_id"] + "-row");

                let cell1 = row.insertCell(0);
                cell1.innerHTML = '<div id="' + stat["sys_id"] + '-background-color" style="background-color: ' + stat["color"] + '" class="rounded-lg w-auto "><p class="w-auto" id="' + stat["sys_id"] + '-text-color" style="color: ' + stat["text_color"] + '">' + stat["name"] + '</p></div>';
                cell1.classList.add("px-3", "py-1", "text-sm", "text-center", "text-gray-500");

                let cell2 = row.insertCell(1);
                switch (stat["type"]) {
                  case "1":
                    cell2.innerHTML = "Abholen";
                    break;
                  case "2":
                    cell2.innerHTML = "Aufträge";
                    break;
                  case "3":
                    cell2.innerHTML = "Versand";
                    break;
                  case "4":
                    cell2.innerHTML = "Kunden";
                    break;
                  case "5":
                    cell2.innerHTML = "Interessenten";
                    break;
                  case "6":
                    cell2.innerHTML = "Einkäufe";
                    break;
                  case "7":
                    cell2.innerHTML = "Retouren";
                    break;
                  case "8":
                    cell2.innerHTML = "Packtisch";
                    break;
                
                  default:
                    break;
                }
                cell2.classList.add("whitespace-nowrap", "px-3", "py-1", "text-center", "text-sm", "text-gray-500");
                cell2.setAttribute("id", stat["sys_id"] + "-bereich");
                
                let cell3 = row.insertCell(2);
                cell3.innerHTML = stat["email_template"];
                cell3.classList.add("whitespace-nowrap", "px-3", "py-1", "text-center", "text-sm", "text-gray-500");
                cell3.setAttribute("id", stat["sys_id"] + "-template");

                let cell4 = row.insertCell(3);
                if(stat["public"] == "0") {
                  cell4.innerHTML = "";
                }
                if(stat["public"] == "1") {
                  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                cell4.classList.add("px-3", "py-1", "text-sm", "text-gray-500", "text-center", "font-bold");
                cell4.setAttribute("id", stat["sys_id"] + "-public");

                let cell5 = row.insertCell(4);
                if(stat["kunde"] == "no") {
                  cell5.innerHTML = "";
                }
                if(stat["kunde"] == "yes") {
                  cell5.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                cell5.classList.add("px-3", "py-1", "text-sm", "text-gray-500", "text-center", "font-bold");
                cell5.setAttribute("id", stat["sys_id"] + "-kunde");

                let cell6 = row.insertCell(5);
                if(stat["admin"] == "no") {
                  cell6.innerHTML = "";
                }
                if(stat["admin"] == "yes") {
                  cell6.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
                }
                cell6.classList.add("px-3", "py-1", "text-sm", "text-gray-500", "text-center", "font-bold");
                cell6.setAttribute("id", stat["sys_id"] + "-admin");

                let cell7 = row.insertCell(6);
                cell7.innerHTML = '<button type="button" onclick="readStatus(' + "'" + stat["sys_id"] + "'" + ')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>'
                cell7.classList.add("relative", "whitespace-nowrap", "py-1", "pl-3", "pr-1", "text-right", "text-sm", "font-medium");
                
                document.getElementById('bearbeiten').classList.add('hidden');
                row.classList.add("update-row-animation");

                savedPOST();
              }
               
            }); 
        }); 
        
        function deleteStatus(id) {
          
          $.get("{{url('/')}}/crm/status/delete/" + id, function() {
            document.getElementById(id + "-row").classList.add("remove-row-animation");
            document.getElementById('bearbeiten').classList.add('hidden');
            setTimeout(
            function() {
              document.getElementById(id + "-row").remove();
            }, 1400);
            savedPOST();
          });
        }

        function newStatus() {
          document.getElementById("bereich").value    = 1;
          document.getElementById("status-name").value  = "";
          document.getElementById("temp").value         = 1;
          document.getElementById("back-color").value   = "#fffff";
          document.getElementById("text-color").value   = "#fffff"; 
          document.getElementById("state").value        = "off";

          frontState = true;
          changeFrontend();

          adminState = true;
          changeEmailAdminInput();

          kundeState = true;
          changeEmailKunde();

          document.getElementById('status-bearbeiten').action = '{{url("/")}}/crm/change/status';

          document.getElementById("bearbeiten").classList.remove('hidden');
        }
  </script>