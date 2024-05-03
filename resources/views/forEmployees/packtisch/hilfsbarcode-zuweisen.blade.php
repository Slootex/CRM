<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    @vite('resources/js/app.js')


    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-10">
        <h1 class="text-3xl font-bold text-white mb-4">Wareneingang - Auftrag zuweisen</h1>
        <div class="overflow-hidden bg-white shadow sm:rounded-lg" style="height: 43rem">
            <div class="px-4 py-5 sm:p-6">

              <div id="choose-order-div" class="float-left" style="width: 35rem;">
                <div>
                  <h1 class="text-2xl font-bold mb-2">Einen Auftrag zuweisen</h1>
                </div>
                <div>
                  <input type="text" class="w-96 h-12 rounded-md text-xl border border-gray-600 inline-block" id="order-number" placeholder="Auftragsnummer">
                  <button type="button" onclick="searchOrderNumber()" class="bg-blue-600 hover:bg-blue-500 rounded-md font-semibold text-white text-xl px-4 py-2 float-right">Suchen</button>
                </div>
                <div class="mt-8 flow-root">
                  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="overflow-auto h-36 inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                      <table class="min-w-full divide-y divide-gray-300" id="orders-table">
                        <thead>
                          <tr>
                            <th scope="col" class=" pl-4 pr-3 text-left text-md font-semibold text-gray-900 sm:pl-0">Vorname</th>
                            <th scope="col" class="px-3  text-left text-md font-semibold text-gray-900">Nachname</th>
                            <th scope="col" class="px-3  text-left text-md font-semibold text-gray-900">Auftrag</th>
                            <th scope="col" class="  text-right text-md font-semibold text-gray-900">Aktion</th>

                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          
                          @foreach ($orders as $order)
                              <tr>
                                <td class="whitespace-nowrap text-sm text-gray-500">{{$order->firstname}}</td>
                                <td class="whitespace-nowrap text-sm text-gray-500 px-4">{{$order->lastname}}</td>
                                <td class="whitespace-nowrap text-sm text-gray-500 px-4"><a class='text-blue-600 hover:text-blue-400' target='_blank' href='{{url("/")}}/crm/auftrag-bearbeiten-{{$order->process_id}}'>{{$order->process_id}}</a><div class="inline-block hidden">  <input type="radio" checked="" id="org-58916" name="type-58916" class="w-4 hidden h-4 rounded-full inline-block">  <p class="inline-block ml-2 font-semibold">ORG</p></div><div class="inline-block ml-8 hiden">  <input id="at-58916" type="radio" name="type-58916" class="w-4 h-4 hidden rounded-full inline-block">  <p class="inline-block ml-2 font-semibold hidden">AT</p></div></td>
                                <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                  <button type="button" class="text-blue-600" onclick="addOrderHelpercode('{{$order->process_id}}')">+ auswählen</button>
                                </td>
                              </tr>
                          @endforeach
              
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="mt-10 mb-10 hidden float-left" id="used-device-div">
                  <h1 class="text-2xl font-bold">Ausgewähltes Gerät</h1>
                  <div class="w-60 h-28 rounded-lg shadow-md border border-gray-300 mt-4 px-2 py-2">
                    <h2 class="text-2xl font-semibold">Hilfsgerät</h2>
                    <p class="text-xl mt-2" id="used-device-number">12345-12-ORG-2</p>
                    <div class="inline-block">  <input type="radio" onclick="changeSetTypeORG()" id="used-device-org" name="type" class="w-4 h-4 rounded-full inline-block">  <p class="inline-block ml-2 font-semibold">ORG</p></div><div class="inline-block ml-8">  <input  type="radio" id="used-device-at" onclick="changeSetTypeAT()" name="type" class="w-4 h-4 rounded-full inline-block">  <p class="inline-block ml-2 font-semibold">AT</p></div>
                  </div>
                </div>

                <div class="mt-16 hidden pt-2 float-left ml-10 mb-10" id="used-device-mother-div">
                  <div class="w-60 h-28 rounded-lg shadow-md border border-gray-300 mt-4 px-2 py-2">
                    <h2 class="text-2xl font-semibold">Muttergerät</h2>
                    <p class="text-xl mt-2" id="used-device-mother-number">12345-12-ORG-2</p>
                    <button type="button" id="change-mother-device" class="text-blue-600">ändern</button>
                  </div>
                </div>
                <div class="hidden" id="extra-comment-div">
                  <div class="mt-2">
                    <textarea rows="4" name="comment" id="comment" placeholder="Zusatzkommentar an Packtisch" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>

                <button type="button" onclick="sendRequest()" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-md text-white font-semibold hidden mt-4" id="finish-button">An Packtisch senden</button>
              </div>
             
              <div class="float-right" id="order-documents-div" style="width: 34.2rem; height: 25rem">
                <div>
                  <h1 class="text-2xl font-bold mb-2">Dokumente zum Hilfsgerät</h1>
                </div>

                <iframe src="{{url("/")}}/hilfsbarcode-documents-{{$id}}#toolbar=0&navpanes=0&scrollbar=0" class="w-full" style="height: 35rem" frameborder="0"></iframe>
                
              </div>
              <div class="hidden w-full" id="extra-comment-div-new">
                <div class="mt-2">
                  <textarea onkeydown="document.getElementById('comment-new-inp').value = this.value" rows="4" name="comment" id="comment" placeholder="Zusatzkommentar an Packtisch" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                </div>
              </div>



            </div>

          </div>
          <div class="relative">
            <!-- your div content here -->
            <a href="{{url("/")}}/crm/wareneingang/hilfsbarcode-rückgängig-{{$id}}" id="zuweisen-back-button" class="absolute bottom-0 right-0 mb-4 mr-4 px-4 py-2 bg-red-600 hover:bg-red-500 rounded-md text-white font-semibold mr-60">Zum Archiv</a>


            <button id="new-order-button" onclick="loadData(); addNewAuftrag(); document.getElementById('extra-comment-div-new').classList.toggle('hidden'); this.classList.add('bg-red-600', 'hover:bg-red-500'); this.classList.remove('bg-blue-600', 'hover:bg-blue-500'); this.innerHTML = 'Keinen neuen Auftrag erstellen'; this.setAttribute('onclick', 'removeAuftrag()')" class="absolute bottom-0 right-0 mb-4 mr-4 px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-md text-white font-semibold">Neuen Auftrag erfassen</button>
          </div>
      </div>

      <form action="{{url("/")}}/crm/zuweisung/neuer-auftrag" method="POST">
        @CSRF
        <textarea class="hidden" name="comment" id="comment-new-inp"></textarea>
        <input type="hidden" name="old" value="{{$id}}">
        
        <div id="auftrag-div">

        </div>
      </form>

      <script>
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

          function checkBeforeSubmit() {
        
        let i_zipcode = document.getElementById("home_zipcode").value;
        let i_city = document.getElementById("home_city").value;
        let i_hsn = document.getElementById("hsn").value;
        let i_tsn = document.getElementById("tsn").value;
        let i_email = document.getElementById("home_email").value;
        let i_phone = document.getElementById("phone_number").value;
        let i_firstname = document.getElementById("firstname").value;
        let i_lastname = document.getElementById("lastname").value


        $.post( "{{url("/")}}/crm/neuer-auftrag-check", 
        { 
          zipcode: i_zipcode,
          city: i_city,
          hsn: i_hsn,
          tsn: i_tsn,
          email: i_email,
          phone: i_phone,
          firstname: i_firstname,
          lastname: i_lastname
         })
          .done(function( data ) {
            if(data == "empty") {
              document.getElementById("submit-button").click();
            } else {
              document.getElementById("duplikate-div").innerHTML = data;
            }
          });

      }

        let usedNumbers = [];
        function searchOrderNumber() {
          if(!usedNumbers.includes(document.getElementById('order-number').value)) {
            loadData();
          let id = document.getElementById('order-number').value;

          $.get('{{url("/")}}/email-inbox/get-order/' + id, function(data) {
            if(data["process_id"] != null) {

            $("#orders-table:not(:first)").remove();
            
            var table = document.getElementById("orders-table");

            var row = table.insertRow(1);
            
            var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);


                cell1.classList.add('whitespace-nowrap','text-sm','text-gray-500');
                cell1.innerHTML = data["firstname"];

                cell2.classList.add('whitespace-nowrap','text-sm','text-gray-500', "px-4");
                cell2.innerHTML = data["lastname"];

                cell3.classList.add('whitespace-nowrap','text-sm','text-gray-500', "px-4");
                cell3.innerHTML = "<a class='text-blue-600 hover:text-blue-400' target='_blank' href='{{url("/")}}/crm/auftrag-bearbeiten-"+data["process_id"]+"'>"+data["process_id"]+"</a>" + '<div class="inline-block hidden">  <input type="radio" checked id="org-'+data["process_id"]+'" name="type-'+data["process_id"]+'" class="w-4 hidden h-4 rounded-full inline-block">  <p class="inline-block ml-2 font-semibold">ORG</p></div><div class="inline-block ml-8 hiden">  <input id="at-'+data["process_id"]+'" type="radio" name="type-'+data["process_id"]+'" class="w-4 h-4 hidden rounded-full inline-block">  <p class="inline-block ml-2 font-semibold hidden">AT</p></div>';

                cell4.classList.add('relative', "whitespace-nowrap", "pl-3", "pr-4", "text-right", "text-sm", "font-medium", "sm:pr-0");
                cell4.innerHTML = '<button type="button" class="text-blue-600" onclick="addOrderHelpercode('+"'"+data["process_id"] +"'"+')">+ ausw\u00e4hlen</button>';

                usedNumbers.push(data["process_id"]);

              } else {
              document.getElementById('not-found-modal').classList.remove('hidden');
             }
            savedPOST();
          });
          }
        }

        function addNewAuftrag() {
          document.getElementById('choose-order-div').classList.add('hidden'); 
          document.getElementById('order-documents-div').style.width = '100%';
          document.getElementById('zuweisen-back-button').classList.add('hidden')

          $.get("{{url("/")}}/crm/zuweisen/neuer-auftrag", function(data) {
            document.getElementById("auftrag-div").innerHTML = data;
            savedPOST();
          })
        }

        function removeAuftrag() {
          document.getElementById('choose-order-div').classList.remove('hidden'); 
          document.getElementById('order-documents-div').style.width = '34.2%';
          document.getElementById('zuweisen-back-button').classList.remove('hidden');
          document.getElementById("auftrag-div").innerHTML = "";
          document.getElementById("new-order-button").setAttribute('onclick', "loadData(); addNewAuftrag(); this.classList.add('bg-red-600', 'hover:bg-red-500'); this.classList.remove('bg-blue-600', 'hover:bg-blue-500'); this.innerHTML = 'Keinen neuen Auftrag erstellen'; this.setAttribute('onclick', 'removeAuftrag()')");
          document.getElementById("new-order-button").classList.add('bg-blue-600', 'hover:bg-blue-500');
          document.getElementById("new-order-button").classList.remove('bg-red-600', 'hover:bg-red-500');
          document.getElementById("new-order-button").innerHTML = "Neuen Auftrag erfassen";
        }

        let choosenNumber = "";
        function addOrderHelpercode(id) {
          loadData();
              
              $.get("{{url("/")}}/crm/generateHelpercodeORG-"+id+ "-{{$id}}", function(data) {
                document.getElementById('used-device-number').innerHTML = id+"-"+data[0]+"-"+data[1]+"-"+data[2];
                document.getElementById('used-device-org').checked = true;
                document.getElementById('used-device-div').classList.remove('hidden');
                document.getElementById('extra-comment-div').classList.remove('hidden');
                document.getElementById('finish-button').classList.remove('hidden');
                document.getElementById('used-device-mother-div').classList.add('hidden');
                choosenNumber = id;
                savedPOST();
              });

            


            if(document.getElementById('at-'+id).checked) {

                $.get('{{url("/")}}/crm/generateHelpercodeATwithORG-'+id, function(data) {
                  document.getElementById('used-device-number').innerHTML = id+"-"+data[0][0]+"-"+data[0][1]+"-"+data[0][2];
                  document.getElementById('used-device-mother-number').innerHTML = data[1]["component_number"];
                  document.getElementById('used-device-at').checked = true;
                  document.getElementById('used-device-mother-div').classList.remove('hidden');
                  document.getElementById('used-device-div').classList.remove('hidden');
                  document.getElementById("change-mother-device").setAttribute("onclick", "changeMotherDevice('"+id+"')");
                  document.getElementById('extra-comment-div').classList.remove('hidden');
            document.getElementById('finish-button').classList.remove('hidden');
                  savedPOST();
                });
                choosenNumber = id;

            }
     

         
        }
        function changeSetTypeAT() {
          loadData();
            $.get('{{url("/")}}/crm/generateHelpercodeATwithORG-'+choosenNumber, function(data) {
              if(data[0] == null) {
                document.getElementById("used-device-org").click();
                newErrorAlert("Kein ORG vorhanden", "Um ein AT erstellen zu können muss vorher ein ORG dem Auftrag zugeteilt werden");
              } else {
                document.getElementById('used-device-number').innerHTML = choosenNumber+"-"+data[0][0]+"-"+data[0][1]+"-"+data[0][2];
                document.getElementById('used-device-mother-number').innerHTML = data[1]["component_number"];
                document.getElementById('used-device-mother-div').classList.remove('hidden');
                document.getElementById("change-mother-device").setAttribute("onclick", "changeMotherDevice('"+choosenNumber+"')");
                savedPOST();
              }
          });
          
        }

        function changeSetTypeORG() {
          loadData();
          $.get("{{url("/")}}/crm/generateHelpercodeORG-"+choosenNumber+ "-{{$id}}", function(data) {
            document.getElementById('used-device-number').innerHTML = choosenNumber+"-"+data[0]+"-"+data[1]+"-"+data[2];
                document.getElementById('used-device-org').checked = true;
                document.getElementById('used-device-div').classList.remove('hidden');
                document.getElementById('used-device-mother-div').classList.add('hidden');
                savedPOST();
          });
        }

        function changeMotherDevice(id) {
          loadData();
          $("#all-mother-devices-select").find("option").remove();

          $.get('{{url("/")}}/crm/get-devices-'+id, function(data) {
            var select = document.getElementById("all-mother-devices-select");

            data.forEach(element => {
              var option = document.createElement("option");
              option.text = element["component_number"];
              option.value = element["component_number"];
              select.add(option);
            });

            document.getElementById('all-mother-devices-modal').classList.remove('hidden');
            savedPOST();
          });
        }

        function setNewMotherdevice(id) {
          loadData();
          $.get('{{url("/")}}/crm/generateATbyORG-'+id, function(data) {

            document.getElementById('used-device-mother-number').innerHTML = data[1]["component_number"];
            document.getElementById('used-device-number').innerHTML = choosenNumber+"-"+data[0][0]+"-"+data[0][1]+"-"+data[0][2];
            document.getElementById('all-mother-devices-modal').classList.add('hidden');
            savedPOST();
          });
        }

        function sendRequest() {
          loadData();

          let devicename = document.getElementById('used-device-number').innerHTML;
          let motherdevice = null;
          if(document.getElementById('used-device-org').checked) {
            motherdevice = "null";
          } else {
            motherdevice = document.getElementById('used-device-mother-number').innerHTML;
          }

          document.getElementById('devicename').value = devicename;

          document.getElementById("comment-inp").value = document.getElementById("comment").value;
          
          document.getElementById('final-submit-button').click();
        }
      </script>

<form action="{{url("/")}}/crm/set-helpercode" method="POST">

  @csrf
  <input type="hidden" name="device" id="devicename">
  <input type="hidden" name="old" id="old" value="{{$id}}">
  <textarea class="hidden" name="comment" id="comment-inp"></textarea>
  <button type="submit" class="hidden" id="final-submit-button"></button>
</form>

<div class="relative hidden z-10" id="all-mother-devices-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
        <div>
          <div>
            <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Muttergerät</label>
            <select id="all-mother-devices-select" name="" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </select>
          </div>
        </div>
        <div class="mt-5 sm:mt-6">
          <button type="button" onclick="setNewMotherdevice(document.getElementById('all-mother-devices-select').value)" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-md font-semibold text-white float-left">neues Muttergerät</button>
          <button type="button" onclick="document.getElementById('all-mother-devices-modal').classList.add('hidden')" class="px-4 py-2 border border-gray-600 rounded-md text-black font-semibold float-right">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="relative hidden z-10" id="not-found-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">

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
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Auftrag nicht gefunden!</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Der gesuchte Auftrag konnte nicht gefunden werden!</p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:ml-10 sm:mt-4 sm:flex sm:pl-4">
          <button type="button" onclick="document.getElementById('not-found-modal').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>


</body>
</html>