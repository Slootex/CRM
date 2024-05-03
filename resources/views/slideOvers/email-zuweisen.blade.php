

<script>
    let orders = [];
    $.get( "{{url("/")}}/email-inbox/get-orders", function( data ) {
        
      data.forEach(item => {
            orders.push(item["process_id"] + ", " + item["firstname"] + " " + item["lastname"]);
          // Find a <table> element with id="myTable":
          var table = document.getElementById("zuweisen-table");

          // Create an empty <tr> element and add it to the 1st position of the table:
          var row = table.insertRow(1);
          row.style.border = "solid lightgray 1px";
          row.style.borderRadius = "25px";
          row.style.borderLeft = "none";
          row.style.borderRight = "none";

          // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);


          // Add some text to the new cells:
          cell1.classList.add("truncate","py-2", "text-sm", "font-medium", "text-gray-900", "pl-3", "text-left");
          cell1.innerHTML = item["process_id"];
          
          cell2.classList.add("truncate","py-2",  "text-sm", "font-medium", "text-gray-900", "sm:pl-0", "text-left");
          cell2.innerHTML = item["firstname"] + " " + item["lastname"];

          cell3.classList.add("truncate","py-2",  "text-sm", "font-medium", "text-gray-900", "sm:pl-0", "text-left");

          let type = "";
            if(data["archiv"] == "1") {
               type = "Archiv";
            } else {
               type = "Aktiv";
            }

          cell3.innerHTML = item["area"] + "-" + type;

          cell4.classList.add("truncate","py-2",  "text-sm", "text-gray-500", "pr-3", "text-right");
          cell4.innerHTML = "<button onclick='emailZuweisen("+'"'+item["process_id"]+'"'+")'><span class='font-semibold text-black'>+</span> E-Mail zuweisen<button>";
      });
      $(function () {
       $('#emailOrderQuickSearch').autocomplete({
         source: orders,
         select: function( event, ui ) {
            let order = ui["item"]["label"].split(",")[0];
            $.get( "{{url("/")}}/email-inbox/get-order/" + order, function( data ) {
                $("#zuweisen-table tr").not(':first').remove();
                var table = document.getElementById("zuweisen-table");

                var row = table.insertRow(1);
                row.style.border = "solid lightgray 1px";
                row.style.borderRadius = "25px";
                row.style.borderLeft = "none";
                row.style.borderRight = "none";
                
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                
                
                cell1.classList.add("truncate","py-2", "text-sm", "font-medium", "text-gray-900", "pl-3", "text-left");
                cell1.innerHTML = data["process_id"];
                
                cell2.classList.add("truncate","py-2",  "text-sm", "font-medium", "text-gray-900", "sm:pl-0", "text-left");
                cell2.innerHTML = data["firstname"] + " " + data["lastname"];
                
                cell3.classList.add("truncate","py-2",  "text-sm", "text-gray-500", "pr-3", "text-right");
                cell3.innerHTML = "<button onclick='emailZuweisen("+'"'+data["process_id"]+'"'+")'><span class='font-semibold text-black'>+</span> E-Mail zuweisen<button>";

            });
            
         }
       });
     });
    });


    

    function refreshOrders() {
        $.get( "{{url("/")}}/email-inbox/get-orders", function( data ) {
        $("#zuweisen-table tr").not(':first').remove();
        document.getElementById("emailOrderQuickSearch").value = "";

        data.forEach(item => {
            // Find a <table> element with id="myTable":
            var table = document.getElementById("zuweisen-table");
  
            // Create an empty <tr> element and add it to the 1st position of the table:
            var row = table.insertRow(1);
            row.style.border = "solid lightgray 1px";
            row.style.borderRadius = "25px";
            row.style.borderLeft = "none";
            row.style.borderRight = "none";
  
            // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
  
  
            // Add some text to the new cells:
            cell1.classList.add("truncate","py-2", "text-sm", "font-medium", "text-gray-900", "pl-3", "text-left");
            cell1.innerHTML = item["process_id"];
            
            cell2.classList.add("truncate","py-2",  "text-sm", "font-medium", "text-gray-900", "sm:pl-0", "text-left");
            cell2.innerHTML = item["firstname"] + " " + item["lastname"];
  
            cell3.classList.add("truncate","py-2",  "text-sm", "text-gray-500", "pr-3", "text-right");
            cell3.innerHTML = "<button onclick='emailZuweisen("+'"'+item["process_id"]+'"'+")'><span class='font-semibold text-black'>+</span> E-Mail zuweisen<button>";
        });
    });

  }

    function emailZuweisen(process_id) {
      loadData();
        $.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});
        let email = document.getElementById("zuweisen-id").value;
        $.post( "{{url("/")}}/crm/emailInbox/zuweisenManuel", {
              id: process_id, email_id: email
              } , function( item ) {
                document.getElementById("email-zuweisen").classList.toggle("hidden");
                  $("#" + document.getElementById("zuweisen-main-id").value).remove();

                  var table = document.getElementById("emailZugewiesenTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
  row.classList.add("cursor-pointer","hover:bg-blue-100");
  row.setAttribute("onclick", "showEmailRead(event,'"+item["id"]+"')");

  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
  var cell2 = row.insertCell(0);
  cell2.setAttribute("id", item["id"] + "-read");
  var cell3 = row.insertCell(1);
  var cell4 = row.insertCell(2);
  var cell5 = row.insertCell(3);
  var cell6 = row.insertCell(4);
  
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1 ml-2" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1 ml-2" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate", "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  

  cell5.classList.add("truncate", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = "<a href='{{url('/')}}/crm/change/order/"+ process_id +"' target='_blank'>" + process_id + "</a>" + '<svg xmlns="http://www.w3.org/2000/svg" onclick="deleteZuweisung('+ "'" + item["id"] + "'" + ')" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600 hover:text-red-400 cursor-pointer float-right"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>';
  cell5.setAttribute("id", "assigned-"+item["id"]);

  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  savedPOST();

              });  
    }
</script>



<div class="relative z-30 hidden"  id="email-zuweisen" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-10 w-screen ">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div style="width: 85rem;" class="relative transform overflow-hidden rounded-lg bg-white px-8 pb-4 pt-5 text-left  transition-all sm:my-8 sm:p-6">
        
          <!--
            Slide-over panel, show/hide based on slide-over state.
  
            Entering: "transform transition ease-in-out duration-500 sm:duration-700"
              From: "translate-x-full"
              To: "translate-x-0"
            Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
              From: "translate-x-0"
              To: "translate-x-full"
          -->
<div>           
           
            <div class="flex flex-col overflow-y-scroll bg-white py-0 px-4 w-full" style="height: 42rem">
                <div>
                    <div class="float-right">
                      <div class="float-right">
                        
                        <button class="float-right" onclick="document.getElementById('email-zuweisen').classList.toggle('hidden')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 ml-1 hover:text-blue-400 text-lg font-semibold leading-6 text-gray-500 float-left mr-3 float-left mt-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        
                      </button>
                      </div>
                    </div>
                    <div class="py-0">
                        <h1 class="font-semibold text-lg">E-Mail zuweisen</h1>
                        <p>Absender: <span id="zuweisen-absender"></span></p>
                        <p>Betreff: <span id="zuweisen-betreff"></span></p>
                        <input type="hidden" id="zuweisen-id">
                        <input type="hidden" id="zuweisen-main-id">
                    </div>
                    <div class="pt-2 w-full pr-3">
                        <input type="text" autocomplete="off" placeholder="Auftrag suchen..." oninput="if(this.value == '') { refreshOrders() }" id="emailOrderQuickSearch" class="rounded-md border-gray-600 w-full" oninput="searchEmailOrder(this.value)">
                    </div>
                    
                    <div class="pt-6 " id="auftrag-table">
                        <label for="" class="pb-2 text-lg font-semibold">Auftragsübersicht</label>
                        
                        <table id="zuweisen-table" class="m-auto mt-4 w-full">
                            <td class="text-lg font-semibold text-left pr-36 pb-6 pl-3">Auftrag</td>
                            <td class="text-lg font-semibold text-left px-0 pr-16 pb-6">Kunde</td>
                            <td class="text-lg font-semibold text-left px-0 pr-16 pb-6">Bereich</td>
                            <td class="text-lg font-semibold text-right pl-36 pb-6 pr-3">Aktion</td>
                        </table>
                    </div>

                    

                  </div>
                 
        </div>
      </div>
    </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div

  
