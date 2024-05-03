<form action="{{url("/")}}/crm/orders/neuer-status" onsubmit="loadData();" id="statuses-form" method="POST">
  @CSRF
<div>

  <div class="flex">
    <h1 class="text-2xl font-medium">Status</h1>
    <div class="bg-red-600 hover:bg-red-400 rounded-md px-2 py-1 text-black ml-4">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
      </svg>    
    </div>
    <div class="bg-blue-600 hover:bg-red-400 rounded-md px-2 py-1 text-white ml-4">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
      </svg>    
    </div>
  </div>
  <button class="hidden" type="submit" id="submit-statusform-btn"></button>
  <p class="text-sm py-2 text-red-400">Website abfrage aktiviert</p>

  <div class="">
    <select name="extrastatus" required id="status-veraluf-neuer-status-select" class="rounded-md border-gray-300 w-full h-12 text-xl mt-2">
      <option value="" class="font-bold text-gray-400" disabled selected >Bitte wählen</option>
      @foreach ($statuses as $status)
          <option value="{{$status->name}}" style="background-color: {{$status->text_color}}">{{$status->name}}</option>
      @endforeach
    </select>
  
    <div class="border border-gray-300 rounded-md mt-4" >
      <div class="">
        <textarea name="text" id="status-textarea"  class="w-full h-36 border-0 text-lg focus:ring-0 focus:ring-offset-0 resize-none" placeholder="Text ..."></textarea>

          <div id="status-textarea-div" class="hidden">
              <textarea name="emailbody" id="status-textarea-email" style="padding-left: 3px" class="w-full border-0 text-lg" placeholder="Text ..."></textarea>
          </div>
          <script>
              $('#status-textarea-email').trumbowyg();
              //$('#emailvorlagen-text').trumbowyg('html', template["body"]);
          </script>
      </div>
  
  
  <div class="flex border border-t-0 border-l-0 border-r-0 border-gray-300 w-full" style="display: flex; justify-content: flex-end">
     
      
      <div class=" flex  ml-6" id="emailvorlagen-main-status">
          <button type="button" onclick="document.getElementById('custom-email-div-statuse').classList.toggle('hidden');" class="flex z-40 font-medium text-md text-gray-400 hover:text-blue-400 px-2 mt-1 py-1 rounded-2xl bg-gray-50 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
              </svg>
              <p class="font-medium text-md" id="statuse-email-p">E-Mail</p>
          </button>    
          <button type="button" onclick="document.getElementById('statuse-email-subject').value = ''; document.getElementById('statuse-email-p').innerHTML = 'E-Mail'; this.classList.add('hidden');" id="statuse-email-remove" class="hidden text-red-600 hover:text-red-400 ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>            
          </button>
          <input type="hidden" id="statuse-email-subject" name="subject">  
          <input type="hidden" id="statuse-email-bcc" name="bcc">   
          <input type="hidden" id="statuse-email-cc" name="cc">   
          <input type="hidden" id="statuse-email-body" name="body">   
          <input type='file' oninput="document.getElementById('filename-email-statuse').innerHTML = this.value" id="file-email-statuse" class="hidden" name="emailfile" />
 
      </div>
      <script>
          function addEmailVorlage() {
              document.getElementById('emailvorlage-div').classList.add('hidden'); 
      
              let email = document.getElementById('emailvorlage').value;
      
              let subject = email.split('°°')[0];
              let body = email.split('°°')[1];
      
              document.getElementById('title').value = subject;
              $('#status-textarea-email').trumbowyg('html', body);
      
          }
      </script>
      
      <div class=" flex text-gray-600 text-lg ml-6 mt-0.5" id="tracking-div-status-main">
          <button type="button" onclick="document.getElementById('tracking-div-status').classList.remove('hidden')" class="flex z-40 text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                  <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>              
              <p id="tracking-status-text" class="ml-2">Tracking</p>
          </button>        
          <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10 bg-white shadow-xl" id="tracking-div-status">
              <div class="w-full pr-0.5">
                  <input type="text" name="trackingnumber" id="status-tracking-input" class="rounded-md w-full" placeholder="Sendungsnummer">
              </div>
              <button type="button" onclick="addTrackingnumber()" class="mt-4 px-2 py-1 rounded-sm bg-blue-600 w-full hover:bg-blue-400 text-white">Übernehmen</button>
      
          </div>
      </div>
      <script>
          function addTrackingnumber() {
              document.getElementById('tracking-status-text').innerHTML = document.getElementById('status-tracking-input').value;
      
              document.getElementById('tracking-div-status').classList.add('hidden');
          }
          function addTextstatus(text) {
            let textarea = document.getElementById('status-textarea').innerHTML;
            document.getElementById('status-textarea').innerHTML = textarea + " " + text;
          }
      </script>
      
      <div class=" flex text-gray-600 text-lg ml-6 mt-0.5 mr-4" id="zuweisung-status-main">

        <button type="button"  onclick="document.getElementById('zuweisung-status-div-status').classList.toggle('hidden')" class="flex z-40  text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z" clip-rule="evenodd" />
              </svg>       
            <p id="zuweisung-status-text" class="ml-2">Zuweisung</p>
        </button>            
        <div class="hidden z-50 pl-4 py-2 rounded-md absolute float-left mt-10 text-black bg-white shadow-xl mr-12" id="zuweisung-status-div-status" style="height: 29rem; right: 0rem;" >
            <div style="max-height: 20rem;" class="overflow-auto">
                <label for="zuweisung-select-status" class="block text-sm font-medium leading-6 mt-1">Nutzer</label>
                @foreach ($employees as $user)
                    <div onclick="zuweisungstatusAddUser('{{$user->id}}')" id="zuweisung-status-div-{{$user->id}}" class=" py-1 hover:bg-blue-200 cursor-pointer px-2 py-1">
                        <div class="flex">
                            <div class="">
                                <div class="flex">
                                    <img src="{{url("/")}}/employee/{{$user->id}}/profile.png" class="w-8 h-8 rounded-full" onerror='this.src = "https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/default-avatar.png"' alt="">
                                    <p class="text-lg ml-2 mt-0.5">{{$user->username}}</p>
                                  </div>
                            </div>
                           <div class="w-full hidden" id="zuweisung-status-check-{{$user->id}}">
                            <div class="w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right text-blue-600 mt-1">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                  </svg> 
                               </div>
                           </div>
                        </div>                        
                    </div>
                @endforeach
            </div>

            <div class="w-full mt-4 pr-4">
                <input type="number" placeholder="Tage" id="zuweisung-status-days" class="rounded-md border-gray-300 w-full">
                <button type="button" onclick="zuweisungSpeichernstatus()" class="bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium text-md px-4 py-2 w-full mt-4">Speichern</button>
            </div>
        </div>
    </div>
<div id="selected-zuweisung-status-inputs">

</div>

<script>


    function zuweisungSpeichernstatus() {
        document.getElementById("selected-zuweisung-status-inputs").innerHTML = '';

        selectedUsersStatus.forEach(user => {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'zuweisung[]';
            input.value = user;
            document.getElementById("selected-zuweisung-status-inputs").appendChild(input);
        });

        let tage = document.createElement("input");
        tage.type = 'hidden';
        tage.name = 'tage';
        tage.value = document.getElementById('zuweisung-status-days').value;
        document.getElementById("selected-zuweisung-status-inputs").appendChild(tage);

        document.getElementById('zuweisung-status-text').innerHTML = selectedUsersStatus.length + " Nutzer ausgewählt";

        document.getElementById('zuweisung-status-div-status').classList.add('hidden');
    }
</script>
  </div>
  
  <div id="texts-div-main" class="flex py-2">
      <button type="button" onclick="document.getElementById('texts-div').classList.remove('hidden')" class="flex text-gray-500 italic hover:text-blue-400 ml-3 mt-2 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 mt-0.5">
              <path fill-rule="evenodd" d="M.99 5.24A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25l.01 9.5A2.25 2.25 0 0 1 16.76 17H3.26A2.267 2.267 0 0 1 1 14.74l-.01-9.5Zm8.26 9.52v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.615c0 .414.336.75.75.75h5.373a.75.75 0 0 0 .627-.74Zm1.5 0a.75.75 0 0 0 .627.74h5.373a.75.75 0 0 0 .75-.75v-.615a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625Zm6.75-3.63v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75ZM17.5 7.5v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75Z" clip-rule="evenodd" />
            </svg>  
            <p class="ml-2 mt-1">Textvorlagen</p>    
            
      </button>
      <div class="hidden px-2 py-1 rounded-md z-50 absolute float-left mt-10 text-black bg-white shadow-xl" id="texts-div" style="width: 28rem" >
          <div class="flex hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD nicht erreicht')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD nicht erreicht</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD nicht erreicht, SVN einholen')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD nicht erreicht, SVN einholen</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD nicht erreicht, Erstgespräch')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD nicht erreicht, Erstgespräch</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD nicht erreicht, Mail geschickt')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD nicht erreicht, Mail geschickt</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD erreicht, warte auf Fehlerauslese per Mail')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD erreicht, warte auf Fehlerauslese per Mail</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('KD erreicht, Gerät kommt nach Berlin')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">KD erreicht, Gerät kommt nach Berlin</p>
          </div>
          <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextstatus('Rückruf erledigt')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
              <p class="ml-2">Rückruf erledigt</p>
          </div>
  </div>
  <div class="w-full" id="status-buche-div">
        <button type="button" onclick="document.getElementById('status-email-dropdown').classList.remove('hidden');" class="float-right rounded-l-none mr-4 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
          </svg>          
        </button>
        <button type="submit" class="float-right font-medium rounded-r-none mr-1 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-400 text-white">
          <p class="">Status buchen</p>
        </button>
        <div style="right: 4.4rem;" class="absolute w-56 rounded-md bg-white shadow-xl hidden mt-10 z-50 px-4 py-2" id="status-email-dropdown">
          <div onclick="statusAddEmail('all')" class="w-full  py-1 hover:text-blue-400 cursor-pointer">
            <p class=" float-left text-md">E-Mail senden</p>
            <svg id="status-all-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right mt-0.5 hidden text-blue-400">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
            </svg>            
          </div>

          <div onclick="statusAddEmail('admin')" class="w-full py-1 hover:text-blue-400 mt-3 cursor-pointer">
            <p class=" float-left text-md">CC: Administrator</p>
            <svg id="status-admin-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right mt-0.5 hidden text-blue-400">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
            </svg>            
          </div>

          <div onclick="statusAddEmail('kunde')" class="w-full py-1 hover:text-blue-400 mt-3 cursor-pointer">
            <p class=" float-left text-md">CC: Kunde</p>
            <svg id="status-kunde-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right mt-0.5 hidden text-blue-400">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
            </svg>            
          </div>
        </div>
  </div>
  </div>  
  
  </div>  
  </div>
</div>
<input type="hidden" id="status-email-all" value="false" name="email-all">
<input type="hidden" id="status-email-admin" value="false" name="email-admin">
<input type="hidden" id="status-email-kunde" value="false" name="email-kunde">

<script>
  function statusAddEmail(type) { 
    if (type == "all") {
      if (document.getElementById("status-email-all").value == "false") {
        document.getElementById("status-email-all").value = "true";
        document.getElementById("status-email-dropdown").children[0].classList.add("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.remove("hidden");
      } else {
        document.getElementById("status-email-all").value = "false";
        document.getElementById("status-email-dropdown").children[0].classList.remove("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.add("hidden");
      }
    } else if (type == "admin") {
      if (document.getElementById("status-email-admin").value == "false") {
        document.getElementById("status-email-admin").value = "true";
        document.getElementById("status-email-dropdown").children[1].classList.add("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.remove("hidden");
      } else {
        document.getElementById("status-email-admin").value = "false";
        document.getElementById("status-email-dropdown").children[1].classList.remove("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.add("hidden");
      }
    } else if (type == "kunde") {
      if (document.getElementById("status-email-kunde").value == "false") {
        document.getElementById("status-email-kunde").value = "true";
        document.getElementById("status-email-dropdown").children[2].classList.add("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.remove("hidden");
      } else {
        document.getElementById("status-email-kunde").value = "false";
        document.getElementById("status-email-dropdown").children[2].classList.remove("text-blue-200");
        document.getElementById("status-"+type+"-svg").classList.add("hidden");
      }
    }
  }
</script>


<input type="hidden" id="status-process_id" name="id" value="{{$order->process_id}}">
 
</form>



<script>
  function getEntsorgungModal(text) {
    loadData();
    let component_number = text.split(" ")[1];

    $.get("{{url("/")}}/crm/status/get-entsorgung/"+component_number, function(data) {
      document.getElementById("entsorgung-modal").innerHTML = data;
      savedPOST();
    })
  }

  function getMinus(id) {
    loadData();

    $.get("{{url("/")}}/crm/entsorgung/minustime/"+id, function(data) {
      $.get("{{url("/")}}/crm/status/get-entsorgung/"+id, function(data) {
      document.getElementById("entsorgung-modal").innerHTML = data;
      savedPOST();

    })
    })
  }

  function getEntSperren(id) {
    loadData();
    $.get("{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-aktivieren/"+id, function(data) {
      $.get("{{url("/")}}/crm/status/get-entsorgung/"+id, function(data) {
      document.getElementById("entsorgung-modal").innerHTML = data;
      savedPOST();

    })
    })
  }

  function getEntSperrenAkt(id) {
    loadData();
    $.get("{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-deaktivieren/"+id, function(data) {
      $.get("{{url("/")}}/crm/status/get-entsorgung/"+id, function(data) {
      document.getElementById("entsorgung-modal").innerHTML = data;
      savedPOST();

    })
    })
  }

  function getPlus(id) {
    loadData();

    $.get("{{url("/")}}/crm/entsorgung/extendtime/"+id, function(data) {
      $.get("{{url("/")}}/crm/status/get-entsorgung/"+id, function(data) {
      document.getElementById("entsorgung-modal").innerHTML = data;
      savedPOST();

    })
    })
  }

  function checkStatusDays(e, inp) {
    if(e.keyCode == 13) {
      if(inp != "") {
        let days = inp;
        let textarea = document.getElementById("status-textarea");
        let currentText = textarea.innerHTML;
        textarea.innerHTML = currentText + " <span class='text-green-600 bg-green-50'>" + days + " Tage</span> <span class='text-black'>.";

        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("status-textarea"));
        sel.collapseToEnd();

        document.getElementById("status-textarea-time").remove();
      } else {
        newErrorAlert("Kein Tage!", "Bitte die anzahl der Tage angeben");
      }
    }
  }

  function filterStatuse() {
    loadData();
    let user = document.getElementById("status-filter").value;
    
    $.get("{{url("/")}}/crm/auftrag/status/filter/"+user + "-{{$order->process_id}}", function(data) {
      $("#statusess").html(data);
      document.getElementById('status-filter-div').classList.add('hidden');
      document.getElementById('status-filter').value = user;
      savedPOST();
    })
  }

  function startStatusDays() {

      let inp = document.getElementById("status-textarea-time-input").value;

      if(inp != "") {
        let days = inp;
        let textarea = document.getElementById("status-textarea");
        let currentText = textarea.innerHTML;
        textarea.innerHTML = currentText + " <span class='text-green-600 bg-green-50'>" + days + " Tage</span> <span class='text-black'>.";

        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("status-textarea"));
        sel.collapseToEnd();

        document.getElementById("status-textarea-time").remove();
      } else {
        newErrorAlert("Kein Tage!", "Bitte die anzahl der Tage angeben");
      }
  }

  let users = [];
  @foreach($employees as $user)
    users.push("{{$user->username}}");
  @endforeach
  let shortCutSave = "";
  let usedShortcut = false;
  let usedShortcutId = null;
  function statusTextCheckShortcut(e, inp) {
    if(e.keyCode == 40) {
      if(document.getElementById("status-textarea-shortcut")) {
        let children = document.getElementById("status-textarea-shortcut").children;
        let selected = -1;
        for(let i = 0; i < children.length; i++) {
          if(children[i].classList.contains("bg-blue-200")) {
            selected = i;
          }
        }
        if(selected == -1) {
          children[0].classList.add("bg-blue-200");
        } else {
          if(selected == children.length - 1) {
            children[selected].classList.remove("bg-blue-200");
            children[0].classList.add("bg-blue-200");
          } else {
            children[selected].classList.remove("bg-blue-200");
            children[selected+1].classList.add("bg-blue-200");
          }
        }
      } return;
    }

    if(e.keyCode == 38) {
      if(document.getElementById("status-textarea-shortcut")) {
        let children = document.getElementById("status-textarea-shortcut").children;
        let selected = -1;
        for(let i = 0; i < children.length; i++) {
          if(children[i].classList.contains("bg-blue-200")) {
            selected = i;
          }
        }
        if(selected == -1) {
          children[children.length - 1].classList.add("bg-blue-200");
        } else {
          if(selected == 0) {
            children[selected].classList.remove("bg-blue-200");
            children[children.length - 1].classList.add("bg-blue-200");
          } else {
            children[selected].classList.remove("bg-blue-200");
            children[selected-1].classList.add("bg-blue-200");
          }
        }
      } return;
    }

    
    if(e.keyCode == 13) {
      if(document.getElementById("status-textarea-shortcut")) {

        e.preventDefault();
        let selectedShortcut = document.querySelector(".bg-blue-200");
        usedShortcutId = Math.random().toString(36).substring(2, 15);
        if (selectedShortcut) {
          let shortcutText = selectedShortcut.textContent;
          
          let textarea = document.getElementById("status-textarea");
          let currentText = textarea.innerHTML;

          textarea.innerHTML =  currentText + "<span class='text-blue-600'>" +selectedShortcut.textContent + "</span><span id='"+usedShortcutId+"'>:";

        }
      
        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("status-textarea"));
        sel.collapseToEnd();

        document.getElementById("status-textarea-shortcut").remove();
        shortCutSave = "";

        usedShortcut = true;
        return;
      }
    } 

    if(e.keyCode == 191) {
      if(usedShortcut == true) {
        e.preventDefault();
        document.getElementById(usedShortcutId).classList.add("bg-green-50", "text-green-600", "px-2", "rounded-md");
        usedShortcut = false;
        usedShortcutId = null;

        let textarea = document.getElementById("status-textarea");
        let currentText = textarea.innerHTML;
        textarea.innerHTML = currentText.replace("#", "");

        let days = document.createElement("div");
        days.classList.add("absolute", "z-50", "bg-white", "border", "border-gray-300", "rounded-md", "px-2", "py-2", "text-md", "shadow-md", "w-36", "h-36");
        days.id = "status-textarea-time";
        days.style.left = getCursorPos(document.getElementById("status-textarea"))[0] + "px";
        days.style.top = getCursorPos(document.getElementById("status-textarea"))[1] + 24 + "px";
        days.innerHTML = "<label>Tage</label><input type='number' id='status-textarea-time-input' onkeydown='checkStatusDays(event, this.value)' class='w-full rounded-md border border-gray-300' placeholder='Tage'> <button type='button' onclick='startStatusDays()' class='mt-4 text-center px-4 py-2 w-full rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium text-md'>Speichern</button>";
        document.body.appendChild(days);

        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("status-textarea"));
        sel.collapseToEnd();

        document.getElementById("status-textarea-time-input").focus();
        document.getElementById("status-textarea-time-input").click();
      }

    }

      if(e.keyCode == 81) {
        if(document.getElementById("status-textarea-shortcut")) {
          document.getElementById("status-textarea-shortcut").remove();
          shortCutSave = "";
        }

        var pos = getCursorPos(document.getElementById("status-textarea"));
        var x = pos[0];
        var y = pos[1] + 24;
        
        var div = document.createElement("div");
        div.style.left = x + "px";
        div.style.top = y + "px";
        div.classList.add("absolute", "z-50", "bg-white", "border", "border-gray-300", "rounded-md", "px-2", "text-md", "shadow-md");
        div.id = "status-textarea-shortcut";

        users.forEach(user => {
          let d = document.createElement("div");
          d.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
          d.innerHTML = "<p class='text-md'>"+user+"</p>";

          div.appendChild(d);
        });

        document.body.appendChild(div);
      }
      if(document.getElementById("status-textarea-shortcut")) {
        if(e.keyCode == 32) { 
          document.getElementById("status-textarea-shortcut").remove();
          shortCutSave = "";
        } else {
          if(e.keyCode != 81 && e.keyCode != 16 && e.keyCode != 8) {

            shortCutSave += String.fromCharCode(e.keyCode);
            document.getElementById("status-textarea-shortcut").innerHTML = "";

            if(shortCutSave.length == 0) {

            } else {
              let filteredUsers = users.filter(user => user.includes(shortCutSave.toLowerCase()));

              filteredUsers.forEach(u => {
                let div = document.createElement("div");
                div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                div.innerHTML = "<p class='text-md'>"+u+"</p>";

                document.getElementById("status-textarea-shortcut").appendChild(div);
              });
            }



          } else {
            if(e.keyCode == 8) {
              if(shortCutSave == 0) {
                shortCutSave = -1;
              } else {
                shortCutSave = shortCutSave.slice(0, -1);
              }
              if(shortCutSave.length == -1) {
                document.getElementById("status-textarea-shortcut").remove();
                shortCutSave = "";
              } else {
                if(shortCutSave.length == 0) {

                  users.forEach(u => {
                    let div = document.createElement("div");
                    div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                    div.innerHTML = "<p class='text-md'>@"+u+"</p>";

                    document.getElementById("status-textarea-shortcut").appendChild(div);
                  });

                } else {

                  document.getElementById("status-textarea-shortcut").innerHTML = "";

                  let filteredUsers = users.filter(user => user.includes(shortCutSave.toLowerCase()));

                  filteredUsers.forEach(u => {
                    let div = document.createElement("div");
                    div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                    div.innerHTML = "<p class='text-md'>"+u+"</p>";

                    document.getElementById("status-textarea-shortcut").appendChild(div);
                  });
                }
              }
            
            }
          }
        }
      }
  }

  function getCursorPos(input) {
    let inp = input;
    let sel = document.getSelection();
    let bound = sel.getRangeAt(0).getBoundingClientRect();

    return [bound.left, bound.top];
}

 
</script>