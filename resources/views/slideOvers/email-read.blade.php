


<div class="relative z-30 hidden" id="email-read" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 overflow-hidden z-10 w-screen">
    <div class="flex min-h-full overflow-hidden items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform  rounded-lg bg-white px-4 pb-4 pt-5 text-left  transition-all sm:my-8 sm:p-6">
        
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
            <div class="flex h-full  flex-col bg-white py-4 ">
              <form action="{{url("/")}}/email-inbox/email-answer" class="overflow-hidden" method="POST" id="myForm" enctype="multipart/form-data">
                @CSRF
              <div class="px-6 float-right w-96 z-50">
                <div >
                  <div class="z-50 float-right">
                    
                    <button class="float-right z-50 " type="button" onclick="document.getElementById('email-read').classList.add('hidden'); clearInterval(autoEntwurfID);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 ml-1 hover:text-blue-400 text-lg font-semibold leading-6 text-gray-500 float-left mr-3 float-left mt-2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    
                  </button>
                  </div>
                  <div class="z-50 ">
                    <a href="{{url("/")}}" id="email-read-set-spam">
                      <div id="email-spam-true" class="hidden"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600 mt-4 mr-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="float-right mt-3 pt-0.5 text-red-600 mr-4" onmouseout="document.getElementById('spam-back-read').classList.add('hidden') document.getElementById('spam-set-read').classList.remove('hidden')" onmouseover="document.getElementById('spam-back-read').classList.remove('hidden') document.getElementById('spam-set-read').classList.add('hidden')"> <span id="spam-set-read">Spam Rückgänging</span> </p>
                                             
                      </div> 
                      <div id="email-spam-false" class="hidden">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-green-600 mt-4 mr-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="float-right mt-3 pt-0.5 text-green-600 mr-4" onmouseout="document.getElementById('spam-back-read').classList.add('hidden') document.getElementById('spam-set-read').classList.remove('hidden')" onmouseover="document.getElementById('spam-back-read').classList.remove('hidden') document.getElementById('spam-set-read').classList.add('hidden')"><span id="spam-set-read">Als Spam markieren</span> </p>

                          
                      </div>
                    </a>                
                  </div>
                </div>
              </div>
              <div class=" mt-2 flex-1 px-4 sm:px-6">
                
                
                <div class="mt-2">
                  <h1 class="text-2xl font-semibold text-gray-800">Betreff: <span id="subject-read"></span> <span class="text-red-600 ml-2 hidden" id="set-as-spam">[Als Spam markiert]</span></h1>
                  <h2 class="text-md font-normal text-gray-600">Absender: <span id="absender-read"></span></h2>
                </div>
                <hr class="py-1">
                  <p class="text-gray-400 text-right float-right w-full h-7 mr-4" class="" id="email-read_at"></p>
               
                <div>
                  <div id="text-read" class="px-2 h-60 overflow-auto">
                  
                  </div>
                </div>
                <hr class="py-1">
                <div>
                  <input style="padding-left: 0px" type="hidden" id="email-read-id" name="id" value="1">

                  <input style="padding-left: 0px"  type="text" id="subject-write" name="subject" class="border-none text-gray-600 text-2xl tracking-wide w-full rounded-md font-semibold mb-4" placeholder="Betreff">
                  <textarea name="text" id="text-write" cols="25" rows="10" class="w-full rounded-md h-44 overflow-auto border-none" placeholder="Text schreiben..."></textarea>
                  <script>
                     

                      
                  </script>

                  <div class="mt-4 ">
                    <div class="float-left">
                      <label class="flex flex-col items-center py-1 bg-white text-blue rounded-lg tracking-wide uppercase  cursor-pointer hover:bg-blue hover:text-white">
                      
                        <span class="mt-0 text-base leading-normal text-gray-400"><span class="float-left text-gray-400" id="filenamee">
                          </span>  
                          <p class="float-left">Dateianhang</p>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                          </svg>                          
                        </span>
                        <input type='file' oninput="document.getElementById('filenamee').innerHTML = this.value" id="emailAnhang" class="hidden" name="filee" />
                    </label>
                    </div>
                    <button type="submit" onclick="loadData()" class="px-5 py-1 bg-blue-600 hover:bg-blue-500 text-md font-semibold text-white rounded-md float-right">Antworten</button>
                    <button onclick="document.getElementById('show-verschieben').classList.toggle('hidden')" class="px-5 py-1 bg-blue-600 hover:bg-blue-500 text-md font-semibold text-white rounded-md float-right mr-4" type="button">
                      <p class="float-left">Verschieben</p>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                      </svg>
                    </button>
                    
                    </form>
                    
                    <div id="show-verschieben" class="hidden">
                      <div class="float-right z-50 absolute w-96 h-36 rounded-md right-0 bg-white px-2 py-1 drop-shadow-lg" style="bottom: 7rem; right: 4.5rem;">
                        
                          <label for="verschieben-options" class="block text-sm font-medium leading-6 text-gray-900">Verschieben zu:</label>
                          <select id="verschieben-options" name="location" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">

                          </select>
                        
                          <button type="button" onclick="emailVerschieben()" class="bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium px-4 py-2 mt-4">Durchführen</button>
                        
                      </div>
                      <div class="float-right absolute w-16 h-16 bg-white drop-shadow-lg z-40" style="right: 14rem; bottom: 6rem; transform: rotate(45deg)">

                      </div>
                    </div>

                  </div>


                </div>
                
            </div>
            
          </form>

          </div>
        </div>
      </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://malsup.github.io/jquery.form.js"></script> 

    <script>

      function emailVerschieben() {
        let id = document.getElementById("email-read-id").value;
        let account = document.getElementById("verschieben-options").value;
        console.log(id);

        $.get("{{url("/")}}/crm/email/verschieben-"+id+"-"+account, function(data) {
          document.getElementById(id).remove();
          document.getElementById("email-read").classList.add("hidden");
        })
      }

      $(document).ready(function() { 
  $('#myForm').ajaxForm(function(item) { 
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
      function saveEntwurf() {
        let subjectVar = document.getElementById('subject-write').value;
        let textVar = $('#text-write').trumbowyg('html');
        let idVar = document.getElementById("email-read-id").value;

        $.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});
        $.post( "{{url("/")}}/email-inbox/entwurf-speichern", {
              subject: subjectVar, text: textVar, id: idVar,
              } , function( data ) {
              });  
            
      }


      function sendEmail() {

        document.getElementById("email-loading").classList.toggle("hidden");
        document.getElementById("myForm").submit();

        let subjectVar = document.getElementById('subject-write').value;
        let textVar = $('#text-write').trumbowyg('html');
        let idVar = document.getElementById("email-read-id").value;
        let anhangVar = $("#emailAnhang").val();


        $.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});


       
            
      }
    </script>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="" style="display: none" id="saveEntwurf">
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
                <p class="text-sm font-medium text-gray-900">Erfolgreich gespeichert</p>
                <p class="mt-1 text-sm text-gray-500">Der Email Entwurf wurde erfolgreich gespeichert.</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button onclick="document.getElementById('saveEntwurf').style.display = 'none'" type="button" class="inline-flex rounded-md bg-white text-gray-500 hover:text-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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

  <div class="hidden" id="email-loading">
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
                <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">Wird geladen...</p>
                <p class="mt-1 text-sm text-gray-500">Der Vorgang wird geladen.</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button onclick="document.getElementById('email-loading').classList.toggle('hidden')" type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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