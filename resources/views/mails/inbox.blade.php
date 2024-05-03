<div id="emailSlideover" class="">
    @include('slideOvers.email-main')
  </div>
  
  <script>
    function loadEmailForhand(id) {
      loadData();
      $("#emailInboxTable tr").not(':first').remove();
      $("#emailZugewiesenTable tr").not(':first').remove();
      $("#emailGesendetTable tr").not(':first').remove();
      $.get("{{url('/')}}/email-inbox/getEmails/"+id, function(data, status){
        let subjects = []

        
      if(data.length == 0) {
        document.getElementById("emailInboxTable").classList.add("hidden");
        document.getElementById("no-emails-text").classList.remove("hidden");

        document.getElementById("no-emails-text").innerHTML = "<p class='text-center mt-2 text-red-800 font-bold text-3xl'>Keine Emails vorhanden</p>"

      }  else {
        document.getElementById("emailInboxTable").classList.remove("hidden");
        document.getElementById("no-emails-text").classList.add("hidden");
      }

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
  
  // Add some text to the new cells:
  let check = "";
  if(item["read_at"] != null) {
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 ml-2" style="margin-top: 0.4rem;" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 ml-2" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 ml-2" style="margin-top: 0.4rem;" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 ml-2" style="margin-top: 0.4rem;" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
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
  check = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 ml-2" style="margin-top: 0.4rem;" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
  } else {
  check = '<svg class="w-2 h-2 m-auto text-gray-400 float-left mr-2 ml-2" style="margin-top: 0.4rem;" fill="gray"  stroke="gray" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-gray-400" cx="50" cy="50" r="50" color="gray" /></svg>';
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
          document.getElementById("load-data-notification").classList.add("hidden");
          document.getElementById("emailSlideover").classList.remove("hidden");



          @foreach($accounts as $account)


            $('#email-account').append('<option value="{{$account->id}}">{{$account->user}}</option>');
            $('#verschieben-options').append('<option value="{{$account->id}}">{{$account->user}}</option>');
            $('#delete-email-account').append('<option value="{{$account->id}}">{{$account->user}}</option>');

          @endforeach

          @if(!isset($accounts[0]))
          $('#email-account').append('<option value="new-account">Keine Accounts</option>');
          @endif

          
          $('#email-account').append('<option value="new-account">Neuer Account</option>');
          $('#email-account').append('<option value="delete-account">Account löschen</option>');


          loadData();
          
          $('#new-email-form').ajaxForm(function(data) {
            
            if(data != "not-found") {
              
              $('#email-account').prepend('<option value="'+data["id"]+'">'+data["user"]+'</option>');
              $('#delete-email-account').append('<option value="'+data["id"]+'">'+data["user"]+'</option>');
              $('#verschieben-options').append('<option value="'+data["id"]+'">'+data["user"]+'</option>');

              loadEmails(data["id"]);

              document.getElementById("add-mail-account-modal").classList.add("hidden");

              newSaveAlert("Erfolgreich!", "Der Account wurde erfolgreich hinzugefügt!");
            } else {
              newErrorAlert("Account nicht gefunden", "Der Account konnte nicht gefunden werden. Bitte überprüfen Sie die Eingabe und versuchen Sie es erneut.");
            }

            savedPOST();
          });
          savedPOST();
    });
    
    }
  </script>
  
  <script>
         $.trumbowyg.svgPath = '/icons.svg';
  
  function saveEntwurfAuto() {
    saveEntwurf();
  }
  var autoEntwurfID = null;
  function showEmailRead(e,id) {
   

    if(e.target.id != "zuweisen-svg") {
    loadData();
    let account = document.getElementById('email-account').value
    $.get("{{url('/')}}/email-inbox/getEmail/"+account+"/" + id, function(item, status){


      document.getElementById(id + "-read").innerHTML = '<svg class="w-2 h-2 m-auto text-green-400 float-left mr-2 mt-1" fill="lightgreen" stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen"></circle></svg><a href="#" class="hover:text-blue-400" onclick="showEmailRead(event,'+"'"+ item["id"] +"'"+')">'+item["absender"]+'</a>'
      $('#text-write').trumbowyg('empty');
        
        document.getElementById("subject-read").innerHTML = item["subject"];
        document.getElementById("absender-read").innerHTML = item["absender"];
        document.getElementById("text-read").innerHTML = item["text"];
        document.getElementById("email-read").classList.remove("hidden");
        document.getElementById("email-read-id").value = item["id"];
        document.getElementById("email-read_at").innerHTML = "Gelesen: " + item["read_at"];
        document.getElementById("email-read").classList.remove("hidden");
        document.getElementById('email-read-set-spam').href = "{{url("/")}}/crm/set-spam-" + item["id"];
  
        if(item["spam"] == "true") {
          document.getElementById('email-spam-false').classList.add('hidden');
          document.getElementById('email-spam-true').classList.remove('hidden');
          document.getElementById('set-as-spam').classList.remove("hidden");
        } else {
          document.getElementById('email-spam-false').classList.remove('hidden');
          document.getElementById('email-spam-true').classList.add('hidden');
          document.getElementById('set-as-spam').classList.add("hidden");
        }
  
  
  
        $.trumbowyg.svgPath = '/icons.svg';
            let trumbowyg = $('#text-write').trumbowyg();
  
            try {
          if(item["email_inbox_entwurf"]["subject"] != null) {
            document.getElementById("subject-write").value = item["email_inbox_entwurf"]["subject"];
            $('#text-write').trumbowyg('html', item["email_inbox_entwurf"]["text"]);
  
          }
        
        } catch (error) {
          document.getElementById("subject-write").value = item["subject"];
  
        }
  
        autoEntwurfID = window.setInterval(saveEntwurfAuto, 5000);
        savedPOST();
    });
  }
  }

  function deleteZuweisung(id) {

    document.getElementById("assigned-"+id).innerHTML = "";

    var html = $('#'+id).html();
    $('#emailInboxTable tr:last').after("<tr>" + html + "</tr>");
   
    document.getElementById(id).remove();
    $.get("{{url("/")}}/crm/email/delete-zuweisung-"+id, function(data) {});
    

  }

  </script>
  <script>
      @if(isset($accounts[0]))
      loadEmailForhand('{{$accounts[0]->id}}');
      @else
      
          $('#email-account').append('<option value="new-account">Keine Accounts</option>');

          
          $('#email-account').append('<option value="new-account">Neuer Account</option>');
      @endif
  </script>