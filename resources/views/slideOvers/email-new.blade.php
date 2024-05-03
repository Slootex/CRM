

<div class="relative z-40 hidden" id="email-new" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left  transition-all sm:my-8 sm:p-6">
        
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
           
            <div >
                <div class="px-6">
                      <div class="">
                        
                        <button class="float-right" type="button" onclick="document.getElementById('email-new').classList.add('hidden'); clearInterval(autoEntwurfNewID)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hover:text-blue-400 ml-1 text-lg font-semibold leading-6 text-gray-500 hover:text-blue-400 mr-3 float-left mt-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        
                      </button>
                      <h1 class="ml-3 font-bold text-2xl">Neue Email</h1>
                      </div>
                  </div>
              <form action="{{url("/")}}/email-inbox/email-new" method="POST" id="newEmailForm" enctype="multipart/form-data">
                @CSRF

                <div class="px-6 mt-1">
                  <input type="hidden" name="account" id="account-input-new" value="1">
                    <input type="text" name="cc" id="new-cc-empf" placeholder="Empfänger (CC)" class="border-none text-2xl text-gray-600 font-semibold w-full h-12">
                    <input type="text" name="bcc" placeholder="Bcc" class="border-none text-lg text-gray-400 font-normal w-full h-8 ">
                    <hr class="py-2 mt-4 border-gray-300">
                    <input type="text" id="subject-new" name="subject" placeholder="Betreff" class="border-none text-2xl text-gray-600 font-semibold w-3/5 h-12 mb-4 inline-block">
                    <select name="" id="new-email-vorlagen" onchange="setVorlage(this.value)" class="border none text-2xl text-gray-600 font-semibold w-48 h-12 mb-4 inline-block ml-12">
                      <option value="">Vorlagen</option>
                    </select>
                    <textarea name="text" id="text-new-email" cols="30" rows="10" class="w-full rounded-md h-44 overflow-auto border-none" placeholder="Text schreiben..."></textarea>
                    <script>
                         $('#text-new-email').trumbowyg()
                    </script>
                </div>
                <div class="mt-16  px-4">
                    <div class="float-left">
                      <label class="flex flex-col items-center py-1 bg-white text-blue rounded-lg tracking-wide uppercase  cursor-pointer hover:bg-blue hover:text-white">
                      
                        <span class="mt-0 text-base leading-normal text-gray-400"><span class="float-left text-gray-400" id="filenamee">
                          </span>  
                          <p class="float-left ml-2">Dateianhang</p>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                          </svg>                          
                        </span>
                        <input type='file' oninput="document.getElementById('filenamee').innerHTML = this.value" id="emailAnhang" class="hidden" name="file" />
                    </label>
                    </div>
                    <button type="submit" onclick="loadData();  document.getElementById('email-new').classList.add('hidden');" class="px-5 py-1 bg-blue-600 hover:bg-blue-500 text-md font-semibold text-white rounded-md float-right">E-Mail senden</button>
                    <button type="button" onclick="saveEntwurfNewEmail()" class="text-blue-600 float-right mr-6 mt-1.5">Entwurf speichern</button>
                  </div>

          </form>

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
          $(document).ready(function() { 
  $('#newEmailForm').ajaxForm(function(item) { 


    var table = document.getElementById("emailGesendetTable");

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
  cell1.classList.add('whitespace-nowrap', "py-4", "pl-4", "pr-3", "text-sm", "font-medium", "text-green-400", "sm:pl-0", "text-center", "m-auto");
  cell1.innerHTML = '<svg class="w-2 h-2 m-auto text-green-400" fill="lightgreen"  stroke="lightgreen" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-green-400" cx="50" cy="50" r="50" color="lightgreen" /></svg>';
} else {
  cell1.classList.add('whitespace-nowrap', "py-4", "pl-4", "pr-3", "text-sm", "font-medium", "text-red-400", "sm:pl-0", "text-center", "m-auto");
  cell1.innerHTML = '<svg class="w-2 h-2 m-auto text-red-400" fill="red"  stroke="red" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle class="text-red-400" cx="50" cy="50" r="50" color="red" /></svg>';
}

cell2.classList.add("truncate","py-4", "pl-4", "pr-3", "text-sm", "font-medium", "text-gray-900", "sm:pl-0");
cell2.style.maxWidth = "7.5rem";
cell2.innerHTML = '<a href="#" onclick="showEmailRead(' + "'" + item["id"] + "'" +')">' + item["absender"] + '</a>';

cell3.classList.add("truncate","py-4", "px-3", "ml-4", "text-sm", "text-gray-500", "sm:pl-0");
cell3.style.maxWidth = "15rem";
cell3.innerHTML = item["subject"];

if(item["files"] != null) {
  cell4.classList.add("truncate","py-4",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>';
} else {
  cell4.classList.add("truncate","py-4",  "text-sm", "text-gray-500", "sm:pl-0", "text-right");
  cell4.innerHTML = '';
}

if(item["assigned"] != null) {
  cell5.classList.add("truncate","py-4", "pr-3", "text-sm", "text-blue-500", "sm:pl-0", "text-right");
  cell5.innerHTML = item["assigned"];
} 

cell6.classList.add("truncate","py-4", "w-16", "text-sm", "text-gray-500", "sm:pl-0", "text-center");
cell6.innerHTML = '<a href="#" onclick="showEmailRead(' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg></a><a href="#" onclick="emailZuweisenLaden(' + "'" +item["id"]+ "'" +')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right "><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg></a>';

      savedPOST();
            }); 
});

    function setVorlage(id) {

      $.get('{{url("/")}}/get-emailvorlage-' + id, function(data) {
        $('#text-new-email').trumbowyg("html", data["body"]);

      });
    }

    function saveEntwurfNewAuto() {
      saveEntwurfNewEmail();
    }

    var autoEntwurfNewID = null;
    function saveEntwurfNewEmail() {
      let subjectVar = document.getElementById('subject-new').value;
      var textVar = $('#text-new-email').trumbowyg("html");
      let empfVar = document.getElementById("new-cc-empf").value;

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      $.post( "{{url("/")}}/email-inbox/entwurf-speichern-neueemail", {
            subject: subjectVar, text: textVar, empf: empfVar,
            } , function( data ) {
            });  
    }
  </script>


  