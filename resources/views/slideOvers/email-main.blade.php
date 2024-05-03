<script>
    let barr;
    let i = 0;
    let width = 1;
    let elem;
    let id;
    let emailIds = []
    let loadEmailsDone = false;
    function loadEmails(account = 12) {
        document.getElementById("dd").classList.add("hidden");
        document.getElementById("myProgress").classList.remove("hidden");
        document.getElementById("progresstext").classList.remove("hidden");
        document.getElementById("ldsvg").classList.add("hidden");



        if (i == 0) {
    i = 1;
    elem = document.getElementById("brr");
    width = 1;
    id = setInterval(frame, 12);
    let emailRefreshCounter = 0;
    document.getElementById("email-account").value = account;

    $.get("{{url('/')}}/email-inbox/refresh/" + account, function(data, status){

      $("#emailInboxTable tr").not(':first').remove();
      $("#emailZugewiesenTable tr").not(':first').remove();
      $("#emailGesendetTable tr").not(':first').remove();

      if(data.length == 0) {
        document.getElementById("emailInboxTable").classList.add("hidden");
        document.getElementById("no-emails-text").classList.remove("hidden");

        document.getElementById("no-emails-text").innerHTML = "<p class='text-center mt-2 text-red-800 font-bold text-3xl'>Keine Emails vorhanden</p>"
      }  else {
        document.getElementById("emailInboxTable").classList.remove("hidden");
        document.getElementById("no-emails-text").classList.add("hidden");

      }

      let subjects = []
        data.forEach(item => {
         if(item["spam"] == "true") {
  
          if(!subjects.includes(item["subject"])) {
  
            var table = document.getElementById("spamTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
  row.classList.add("cursor-pointer","hover:bg-blue-100");
  row.setAttribute("onclick", "showEmailRead(event,'"+item["id"]+"')");

  
  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    var cell2 = row.insertCell(0);
  cell2.setAttribute("id", item["id"] + "-read");
  var cell4 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell5 = row.insertCell(3);
  var cell6 = row.insertCell(4);
  console.log("awd");
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1 ml-2" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] == null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-red-500", "sm:pl-0", "text-right");
  cell5.innerHTML = '<p id="'+item["id"]+'-not-assigned">manuel</p>';
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
  
  
          }
         } else {
          if(!subjects.includes(item["subject"])) {
            if(item["assigned"] == null) {
                if(item["absender"] != "act.crm_mail@steubel.de") {
                  // Find a <table> element with id="myTable":
          var table = document.getElementById("emailInboxTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
  row.classList.add("cursor-pointer","hover:bg-blue-100");
  row.setAttribute("onclick", "showEmailRead(event,'"+item["id"]+"')");

  
  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
  var cell2 = row.insertCell(0);
  cell2.setAttribute("id", item["id"] + "-read");
  var cell4 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell5 = row.insertCell(3);
  var cell6 = row.insertCell(4);
  
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] == null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-red-500", "sm:pl-0", "text-right");
  cell5.innerHTML = '<p id="'+item["email_id"]+'-not-assigned">manuel</p>';
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
                }
  
  
  
  
  
            } else {
  
  
  
              if(item["absender"] != "act.crm_mail@steubel.de") {
  
                var table = document.getElementById("emailZugewiesenTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
  row.classList.add("cursor-pointer","hover:bg-blue-100");
  row.setAttribute("onclick", "showEmailRead(event,'"+item["id"]+"')");

  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
  var cell2 = row.insertCell(0);
  cell2.setAttribute("id", item["id"] + "-read");
  var cell4 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell5 = row.insertCell(3);
  var cell6 = row.insertCell(4);
  
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
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
  
  if(item["assigned"] != null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = "<a href='{{url('/')}}/crm/change/order/"+ item["assigned"] +"' target='_blank'>" + item["assigned"] + "</a>" + '<svg xmlns="http://www.w3.org/2000/svg" onclick="deleteZuweisung('+ "'" + item["id"] + "'" + ')" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600 hover:text-red-400 cursor-pointer float-right"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>';
  cell5.setAttribute("id", "assigned-"+item["id"]);
} 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
              }
            }
  
          }
          if(item["absender"] == "act.crm_mail@steubel.de") {
            var table = document.getElementById("emailGesendetTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
  row.setAttribute("onclick", "showEmailRead(event,'"+item["id"]+"')");

  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    var cell2 = row.insertCell(0);
  cell2.setAttribute("id", item["id"] + "-read");
  var cell4 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell5 = row.insertCell(3);
  var cell6 = row.insertCell(4);
  
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] != null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = "<a href='{{url('/')}}/crm/change/order/"+ item["assigned"] +"' target='_blank'>" + item["assigned"] + "</a>";
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#"  class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
           } 
         }
         
          });
          savedPOST();

          
          
          document.getElementById("dd").classList.remove("hidden");
        document.getElementById("myProgress").classList.add("hidden");
        document.getElementById("progresstext").classList.add("hidden");
        document.getElementById("ldsvg").classList.remove("hidden");
          document.getElementById("load-data-notification").classList.add("hidden");
          document.getElementById("emailSlideover").classList.remove("hidden");

         i = 0;
         clearInterval(id);


  });
 
  }

    }
    function frame() {
        console.log(width);
      if (width >= 100) {
        clearInterval(id);
        i = 0;
        width = 0;
      } else {
        width++;
        document.getElementById("brr").style.width = width + "%";
        i++;
      }
    }

    function emailZuweisenLaden(id) {
      let account = document.getElementById('email-account').value;
      $.get("{{url('/')}}/email-inbox/getEmail/"+account+"/" + id, function(item, status){

        document.getElementById("zuweisen-absender").innerHTML = item["absender"];
        document.getElementById("zuweisen-betreff").innerHTML = item["subject"];
        document.getElementById("email-zuweisen").classList.toggle("hidden");
        document.getElementById("zuweisen-id").value = item["id"];
        document.getElementById("zuweisen-main-id").value = item["id"];
      });
    }

    function autoAssign() {
      loadData();
      let account = document.getElementById("email-account").value;

      $.get("{{url('/')}}/crm/emailInbox/zuweisen-"+account, function(data, status){

        data.forEach(item => {
          $("#" + item).remove();
        });


        loadEmails(account);
        savedPOST();
      });
    }
   
</script>
<style type="text/css">
   #myProgress {
  width: 26rem;
  height: .7rem;
  background-color: rgb(208, 208, 208);
}

#brr {
  width: 1%;
  height: .7rem;
}
  </style>

<link rel="stylesheet" href="http://localhost:8000/css/loading-bar.css">
<script src="http://localhost:8000/js/loading-bar.js"></script>

<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 96%">
        

                  <div class="">
                    
                    <h2 class="text-3xl font-bold leading-6 text-gray-900 float-left mr-3 float-left mt-4 ml-7" id="dd">E-Mail Postfach</h2>
                    <h2 class="mt-0 hidden font-base" id="progresstext">Nachrichten werden abgerufen...</h2>
                    <div id="myProgress" class="hidden rounded-lg">
                        <div id="brr" class="bg-blue-600 hover:bg-blue-500 rounded-lg">

                        </div>
                    </div>
                  <button onclick="loadEmails(document.getElementById('email-account').value)" id="ldsvg" class="float-left mt-4 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-blue-400 float-left">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                  </button>
                  
                  <div id="email-account-dropdown" class="float-left ml-4 w-56 origin-top-right rounded-md" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                      <select name="" class="border border-gray-400 rounded-md" id="email-account" onchange="changeEmailAccount(this.value)">


                      </select>
                    </div>
                  </div>

                  <input type="text" oninput="searchLive(this.value)" class="float-left w-60 rounded-md border border-gray-400 mt-1" placeholder="Suche...">

                  </div>
                  
                  <div class="ml-3 flex h-7 items-center mt-2 float-right">
                    <div class="px-4">
                        <button onclick="autoAssign()" id="autoassign" class="bg-blue-600 hover:bg-blue-500  text-white font-medium px-6 py-1 rounded-md text-lg">Verteilen</button>
                    </div>
                    <div class="px-4">
                      <button onclick="getAssignProxs(); loadData();" id="autoassign" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-6 py-1 rounded-md text-lg">Autoerkennung</button>
                  </div>
                    <div class=" px-4">
                        <button type="button" onclick="loadNewEmail();" class="bg-blue-600 hover:bg-blue-500 text-white border border-gray-600 font-medium px-1 py-1 rounded-md text-lg"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                      </div>
                      <div>
                       <form action="{{url("/")}}/crm/emailinbox/upload-eml" id="uploadEML" method="POST" enctype="multipart/form-data">
                        <button type="submit" class="hidden" id="emlupload-button"></button>

                        @CSRF
                        <label class="float-left w-10 mr-2 flex flex-col items-center px-4 py-1 bg-blue-600 hover:bg-blue-500 text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                      
                          <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1  text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                          </svg></span>
                          <input type='file' oninput="document.getElementById('emlupload-button').click();" class="hidden" name="file" />
                      </label>
                       </form>
                      </div>
                      
                    <button onclick="document.getElementById('emailSlideover').classList.add('hidden')" type="button" class="rounded-md bg-white text-gray-400 hover:text-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                      <span class="sr-only">Close panel</span>
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
      
              <div class="relative mt-16 flex-1 px-4 sm:px-6">
                <div>
                    <div class="sm:hidden">
                      <label for="tabs" class="sr-only">Select a tab</label>
                      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                      <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        <option selected>My Account</option>
                  
                        <option>Company</option>
                  
                        <option>Team Members</option>
                  
                      </select>
                    </div>
                    <div class="hidden sm:block">
                      <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                          <!-- Current: "border-blue-500 text-blue-600", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                          <a href="#" onclick="setEmailTab('main')" id="main-main" class="border-blue-500 text-blue-600 whitespace-nowrap border-b-2 py-0 px-1 text-base font-medium" aria-current="page">Nicht Verteilt</a>
                  
                          <a href="#" onclick="setEmailTab('zugewiesen')" id="zugewiesen-zugewiesen" class=" text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-0 px-1 text-base font-medium">Verteilte</a>
                  
                          <a href="#" onclick="setEmailTab('gesendet')" id="gesendet-gesendet" class=" text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-0 px-1 text-base font-medium">Gesendete</a>
                        
                          <a href="#" onclick="setEmailTab('spam')" id="spam-spam" class=" text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-0 px-1 text-base font-medium">Spam</a>

                        </nav>
                      </div>
                      <div class="px-6 " id="main">
                        <div class="mt-8 flow-root">
                          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle px-3">
                              <table class="min-w-full divide-y divide-gray-300" id="emailInboxTable">
                                <thead>
                                  <tr>
                                    <th scope="col" class="py-1.5 pr-3 text-left text-sm font-semibold text-gray-900 truncate ">Absender</th>
                                    <th scope="col" class="px-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-4"></th>
                                    <th scope="col" class=" py-1.5 text-left text-sm font-semibold text-gray-900 w-60">Betreff</th>
                                    <th scope="col" class="pl-3.5 pr-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-16">Zuweisung</th>
                                    <th scope="col" class="relative py-1.5 pl-0 sm:pr-0 text-right pr-8">
                                      <span >Aktion</span>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                  
                      
                                  <!-- More people... -->
                                </tbody>
                              </table>
                              <div id="no-emails-text">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="px-6 sm:px-6 lg:px-8 hidden" id="zugewiesen">
                        <div class="mt-8 flow-root">
                          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle px-1">
                              <table class="min-w-full divide-y divide-gray-300" id="emailZugewiesenTable">
                                <thead>
                                  <tr>
                                    <th scope="col" class="py-1.5 pr-3 text-left text-sm font-semibold text-gray-900  truncate ">Absender</th>
                                    <th scope="col" class=" py-1.5 text-left text-sm font-semibold text-gray-900 w-60">Betreff</th>
                                    <th scope="col" class="px-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-4"></th>
                                    <th scope="col" class="pl-3.5 pr-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-16">Zuweisung</th>
                                    <th scope="col" class="relative py-1.5 pl-0 sm:pr-0 text-right pr-8">
                                      <span >Aktion</span>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                  
                      
                                  <!-- More people... -->
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="px-6 hidden" id="gesendet">
                        <div class="mt-8 flow-root">
                          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle px-3">
                              <table class="min-w-full divide-y divide-gray-300" id="emailGesendetTable">
                                <thead>
                                  <tr>
                                    <th scope="col" class="py-1.5 pr-3 text-left text-sm font-semibold text-gray-900 truncate ">Absender</th>
                                    <th scope="col" class=" py-1.5 text-left text-sm font-semibold text-gray-900 w-60">Betreff</th>
                                    <th scope="col" class="px-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-4"></th>
                                    <th scope="col" class="pl-3.5 pr-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-16">Zuweisung</th>
                                    <th scope="col" class="relative py-1.5 pl-0 sm:pr-0 text-right pr-8">
                                      <span >Aktion</span>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                  
                      
                                  <!-- More people... -->
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="px-6 sm:px-6 lg:px-8 hidden" id="spam">
                        <div class="mt-8 flow-root">
                          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <button type="button" onclick="loadCustomSpamAddressAdd()" class="bg-blue-600 hover:bg-blue-500 rounded-md  px-4 py-2 text-white font-medium float-right hover:bg-blue-400">+ Spam E-Mail hinzufügen</button>

                            <div class="inline-block min-w-full py-2 align-middle px-1">

                              <table class="min-w-full divide-y divide-gray-300" id="spamTable">
                                <thead>
                                  <tr>
                                    <th scope="col" class="py-1.5 pr-3 text-left text-sm font-semibold text-gray-900 truncate ">Absender</th>
                                    <th scope="col" class=" py-1.5 text-left text-sm font-semibold text-gray-900 w-60">Betreff</th>
                                    <th scope="col" class="px-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-4"></th>
                                    <th scope="col" class="pl-3.5 pr-0 py-1.5 text-right text-sm font-semibold text-gray-900 w-16">Zuweisung</th>
                                    <th scope="col" class="relative py-1.5 pl-0 sm:pr-0 text-right pr-8">
                                      <span >Aktion</span>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                  
                      
                                  <!-- More people... -->
                                </tbody>
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
      </div>
    </div>
  </div>

  <script>
    function getAssignProxs() {
      let account = document.getElementById("email-account").value;
      $.get("{{url('/')}}/crm/emailInbox/getAssignProxs/"+account, function(data){
        console.log(data);
        data.forEach(item => {
          let emailid = item.split("*")[0];
          let id = item.split("*")[1];

          if(document.getElementById(emailid + "-not-assigned")) {
            document.getElementById(emailid + "-not-assigned").classList.remove("text-red-500");
            document.getElementById(emailid + "-not-assigned").classList.add("text-blue-400");
            document.getElementById(emailid + "-not-assigned").innerHTML = id;
          }


          
        });
        savedPOST();
      });

    }

    function setEmailTab(tab) {
      document.getElementById("main").classList.add("hidden");
      document.getElementById("zugewiesen").classList.add("hidden");
      document.getElementById("gesendet").classList.add("hidden");
      document.getElementById("spam").classList.add("hidden");

      document.getElementById("zugewiesen-zugewiesen").classList.remove("text-blue-600");
      document.getElementById("gesendet-gesendet").classList.remove("text-blue-600");
      document.getElementById("spam-spam").classList.remove("text-blue-600");

      document.getElementById("main-main").classList.remove("text-blue-600");
      document.getElementById("zugewiesen-zugewiesen").classList.remove("border-blue-500");
      document.getElementById("gesendet-gesendet").classList.remove("border-blue-500");
      document.getElementById("spam-spam").classList.remove("border-blue-500");

      document.getElementById("main-main").classList.remove("border-blue-500");
      document.getElementById(tab + "-" + tab).classList.remove("text-gray-500");

      document.getElementById(tab + "-" + tab).classList.add("text-blue-600");
      document.getElementById(tab + "-" + tab).classList.add("border-blue-500");

      document.getElementById(tab).classList.toggle("hidden");

    }
  </script>

  @include('slideOvers.email-read')
  @include('slideOvers.email-new')

  <div class="hidden" id="assign-finish">
    <div aria-live="assertive" class="z-50 pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
      <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <!--
          Notification panel, dynamically insert this into the live region when it needs to be displayed
    
          Entering: "transform ease-out duration-300 transition"
            From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            To: "translate-y-0 opacity-100 sm:translate-x-0"
          Leaving: "transition ease-in duration-100"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0" >
                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">Erfolgreich verteilt</p>
                <p class="mt-1 text-sm text-gray-500">Die Emails wurden erfolgreich den Aufträgen zugeordnet.</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button onclick="document.getElementById('assign-finish').classList.toggle('hidden')" type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="hidden" id="email-send">
    <div aria-live="assertive" class="z-50 pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
      <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <!--
          Notification panel, dynamically insert this into the live region when it needs to be displayed
    
          Entering: "transform ease-out duration-300 transition"
            From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            To: "translate-y-0 opacity-100 sm:translate-x-0"
          Leaving: "transition ease-in duration-100"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0" >
                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">Erfolgreich versendet</p>
                <p class="mt-1 text-sm text-gray-500">Die Email wurde erfolgreich versendet.</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button onclick="document.getElementById('emai-send').classList.toggle('hidden')" type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
              $(document).ready(function() { 
        $('#uploadEML').ajaxForm(function(item) { 
          var table = document.getElementById("emailInboxTable");

// Create an empty <tr> element and add it to the 1st position of the table:
var row = table.insertRow(1);
row.setAttribute("id", item["id"]);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
var cell1 = row.insertCell(0);
cell1.setAttribute("id", item["id"] + "-read");
var cell2 = row.insertCell(1);
var cell3 = row.insertCell(2);
var cell4 = row.insertCell(3);
var cell5 = row.insertCell(4);
var cell6 = row.insertCell(5);

// Add some text to the new cells:
if(item["read_at"] != null) {
cell1.classList.add('whitespace-nowrap', "py-0", "pl-4", "pr-3", "text-sm", "font-medium", "text-green-400", "sm:pl-0", "text-center", "m-auto");
cell1.innerHTML = '<svg class="w-2 h-2 m-auto text-green-400" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
} else {
cell1.classList.add('whitespace-nowrap', "py-0", "pl-4", "pr-3", "text-sm", "font-medium", "text-red-400", "sm:pl-0", "text-center", "m-auto");
cell1.innerHTML = '<svg class="w-2 h-2 m-auto text-red-400" fill="red"  stroke="red" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-red-400" cx="50" cy="50" r="50" color="red" /></svg>';
}

cell2.classList.add("truncate","py-0", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
cell2.style.maxWidth = "7.5rem";
cell2.innerHTML = '<a href="#" onclick="showEmailRead(' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';

cell3.classList.add("truncate","py-0", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
cell3.style.maxWidth = "15rem";
cell3.innerHTML = item["subject"];

if(item["files"] != null) {
cell4.classList.add("truncate","py-0",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
} else {
cell4.classList.add("truncate","py-0",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
cell4.innerHTML = '';
}

if(item["assigned"] != null) {
cell5.classList.add("truncate","py-0", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
cell5.innerHTML = item["assigned"];
} 

cell6.classList.add("truncate","py-0", "w-16", "text-sm", "sm:pl-0", "text-center");
cell6.innerHTML = '<a href="#" onclick="showEmailRead(' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-gray-500 hover:text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-gray-500 hover:text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';

savedPOST();
        });
      });
      

      function loadNewEmail() {

        let select = document.getElementById('new-email-vorlagen');

        $.get('{{url("/")}}/get-emailvorlagen', function(data) {
          vorlagen = data[0];
          vorlagen.forEach(element => {
            var option = document.createElement("option");
            option.text = element["name"];
            option.value = element["id"];
            select.add(option);
          });

          autoEntwurfID = window.setInterval(saveEntwurfNewAuto, 5000);

          document.getElementById('subject-new').value = "{{auth()->user()->email_entwurf_subject}}";

          $('#text-new-email').trumbowyg("html", data[1]["email_entwurf_body"]);
          document.getElementById("new-cc-empf").value = "{{auth()->user()->email_entwurf_cc}}";

          document.getElementById('email-new').classList.remove('hidden');
        });

      }

      function changeEmailAccount(id) {
        if(id != "new-account" && id != "delete-account") {
          document.getElementById('account-input-new').value = id;
          loadEmails(id);
        } else {
          if(id == "new-account") {
            document.getElementById("add-mail-account-modal").classList.remove("hidden");
          } else {
            document.getElementById("delete-mail-account-modal").classList.remove("hidden");
          }
        }
      }

      function loadCustomSpamAddressAdd() {

      }
  </script>

<!-- Delete Mail Account Modal -->

  <div id="delete-mail-account-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="">
            <div class=" flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:h-10 sm:w-10 ml-4 mb-2">
              <!-- Heroicon name: outline/mail-open -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" class="w-7 h-7 text-blue-600 ">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Accounts
              </h3>
              <!-- Add delete email account select -->
              <div class="mt-4">
                <label for="delete-email-account" class="block text-sm font-medium text-gray-700">E-Mail Account löschen:</label>
                <div class="mt-1">
                  <select id="delete-email-account" name="delete-email-account" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Account auswählen</option>
                    <!-- Add options dynamically using JavaScript or Blade template -->
                    <!-- Example: -->
                    <!-- <option value="account1">Account 1</option> -->
                    <!-- <option value="account2">Account 2</option> -->
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button type="button" onclick="deleteMailAccount(document.getElementById('delete-email-account').value)" class="float-left bg-red-600 hover:bg-red-400 rounded-md text-white font-medium px-4 py-2  ml-4 mt-8 mb-4">Löschen</button>
          <button class="float-right border border-gray-400 bg-white rounded-md px-4 py-2 text-black font-medium ml-4 mt-8 mb-4" type="button" onclick="document.getElementById('delete-mail-account-modal').classList.add('hidden')">Zurück</button>


        </div>
      </div>
    </div>
  </div>


<script>
  // Function to close the modal
  function closeModal() {
    document.getElementById('add-mail-account-modal').classList.add('hidden');
  }

  function deleteMailAccount(id) {
    loadData();
    
    $.get("{{url("/")}}/crm/delete-account-"+id, function(data) {
      let newAcc = "";

      $('#email-account').empty();
      $('#delete-email-account').empty();
      $('#verschieben-options').empty();

      $('#delete-email-account').append('<option value="">Account auswählen</option>');

      data.forEach(acc => {
        $('#email-account').append('<option value="'+acc["id"]+'">'+acc["user"]+'</option>');
        $('#delete-email-account').append('<option value="'+acc["id"]+'">'+acc["user"]+'</option>');
        $('#verschieben-options').append('<option value="'+acc["id"]+'">'+acc["user"]+'</option>');
        newAcc = acc["id"];
      });

      $('#email-account').append('<option value="new-account">Neuer Account</option>');
      $('#email-account').append('<option value="delete-account">Account löschen</option>');


      document.getElementById('delete-mail-account-modal').classList.add('hidden');

      

      savedPOST();
      loadData();

      document.getElementById("email-account").value = newAcc;
      loadEmails(newAcc);
    });
  }
</script>

  <!-- Add Mail Account Modal -->
<form action="{{url("/")}}/crm/email/neuer-account" id="new-email-form" method="POST">
  @CSRF
<div id="add-mail-account-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="">
          <div class=" flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:h-10 sm:w-10 ml-4 mb-2">
            <!-- Heroicon name: outline/mail-open -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" class="w-7 h-7 text-blue-600 ">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Neuen E-Mail Account hinzufügen
            </h3>
            <div class="mt-4">
              <form>
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="server">
                    Server
                  </label>
                  <input name="server" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="server" type="text" placeholder="iuh12oihu123.google.com">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="port">
                    Port
                  </label>
                  <input name="port" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="port" type="text" placeholder="993">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="user">
                    Nutzername
                  </label>
                  <input name="user" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="user" type="text" placeholder="Nutzername">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="password">
                    Passwort
                  </label>
                  <input name="passwort" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Passwort">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
          Hinzufügen
        </button>
        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('add-mail-account-modal').classList.toggle('hidden')">
          Zurück
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function searchLive(inp) {
    loadData();
    document.getElementById("dd").classList.add("hidden");

        document.getElementById("ldsvg").classList.add("hidden");

        i = 0;
        if (i == 0) {
    i = 1;
    elem = document.getElementById("brr");
    width = 1;
    let emailRefreshCounter = 0;
    account = document.getElementById("email-account").value;
          
    if(inp == "") {
      inp = "allemails";
    }

    $.get("{{url('/')}}/email-inbox/search/" + account + "-"+inp, function(data, status){
      
        
      $("#emailInboxTable tr").not(':first').remove();
      $("#emailZugewiesenTable tr").not(':first').remove();
      $("#emailGesendetTable tr").not(':first').remove();
        console.log(data);
        let subjects = []
        data.forEach(item => {
         if(item["spam"] == "true") {
  
          if(!subjects.includes(item["subject"])) {
  
            var table = document.getElementById("spamTable");
  
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] == null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-red-500", "sm:pl-0", "text-right");
  cell5.innerHTML = 'manuel';
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
  
  
          }
         } else {
          if(!subjects.includes(item["subject"])) {
            if(item["assigned"] == null) {
                if(item["absender"] != "act.crm_mail@steubel.de") {
                  // Find a <table> element with id="myTable":
          var table = document.getElementById("emailInboxTable");
  
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] == null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-red-500", "sm:pl-0", "text-right");
  cell5.innerHTML = 'manuel';
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
                }
  
  
  
  
  
            } else {
  
  
  
              if(item["absender"] != "act.crm_mail@steubel.de") {
  
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
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
  
  if(item["assigned"] != null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = "<a href='{{url('/')}}/crm/change/order/"+ item["assigned"] +"' target='_blank'>" + item["assigned"] + "</a>" + '<svg xmlns="http://www.w3.org/2000/svg" onclick="deleteZuweisung('+ "'" + item["id"] + "'" + ')" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600 hover:text-red-400 cursor-pointer float-right"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>';
  cell5.setAttribute("id", "assigned-"+item["id"]);
} 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
  subjects.push(item["subject"]);
              }
            }
  
          }
          if(item["absender"] == "act.crm_mail@steubel.de") {
            var table = document.getElementById("emailGesendetTable");
  
  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(1);
  row.setAttribute("id", item["id"]);
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 mt-1" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
  }
  
  cell2.classList.add("truncate", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
  cell2.style.maxWidth = "7.5rem";
  cell2.innerHTML = check + '<a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';
  
  cell3.classList.add("truncate", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
  cell3.style.maxWidth = "15rem";
  cell3.innerHTML = item["subject"];
  
  if(item["files"] != null) {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
  } else {
  cell4.classList.add("truncate",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
  }
  
  if(item["assigned"] != null) {
  cell5.classList.add("truncate", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = "<a href='{{url('/')}}/crm/change/order/"+ item["assigned"] +"' target='_blank'>" + item["assigned"] + "</a>";
  } 
  
  cell6.classList.add("truncate", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
  cell6.innerHTML = '<a href="#"  class="hover:text-blue-400" onclick="showEmailRead(event,' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" class="hover:text-blue-400" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg id="zuweisen-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';
  
           } 
         }
         
          });
          savedPOST();
          document.getElementById("dd").classList.remove("hidden");
        document.getElementById("myProgress").classList.add("hidden");
        document.getElementById("progresstext").classList.add("hidden");
        document.getElementById("ldsvg").classList.remove("hidden");
          document.getElementById("load-data-notification").classList.add("hidden");
          document.getElementById("emailSlideover").classList.remove("hidden");

         i = 0;
          savedPOST();
  });
 
  }
  }
</script>
  @include('slideOvers.email-zuweisen')
  @include('forEmployees.modals.email-spam-custom-add')