

    <h1 class="text-2xl font-medium pb-4" style="margin-top: -.85rem">Auftragsverlauf</h1>
    <form action="{{url("/")}}/crm/interessent/neuer-auftragshistorientext" id="auftragstext-form-new" method="POST" >
        @CSRF
        <input type="hidden" name="id" value="{{$order->process_id}}">

        <button class="hidden" id="submit-auftragform-btn"></button>
        <div class="border border-gray-300 rounded-md mt-4" >
            <div class="">
        <textarea name="text" id="auftrag-textarea" style="max-width: 90%" class="overflow-auto w-full flex h-36 border-0 text-lg focus:ring-0 focus:ring-offset-0 focus:outline-none px-4 py-2 resize-none" placeholder="Text ..."></textarea>

        <div id="auftrag-textarea-div" class="hidden">
            <textarea name="emailbody" id="auftrag-textarea-email" style="padding-left: 3px" class="w-full border-0 text-lg" placeholder="Text ..."></textarea>
        </div>
        <script>
            $('#auftrag-textarea-email').trumbowyg();
        //$('#emailvorlagen-text').trumbowyg('html', template["body"]);
        </script>
    </div>


<div class="flex border border-t-0 border-l-0 border-r-0 border-gray-300 w-full" style="display: flex; justify-content: flex-end">
    <div class="flex ml-6 font-medium text-md  mt-1" id="extra-status-div-auftrag-main">
        <button type="button" onclick="document.getElementById('extra-status-div-auftrag').classList.remove('hidden')" class="flex z-40 text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
              </svg>             
            <p id="status-auftrag-text" class="ml-2 ">Status</p>
        </button>   
        <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10 bg-white shadow-xl" id="extra-status-div-auftrag">
            <select name="extrastatus" id="extra-status-auftrag" class="w-full m-auto h-10 pr-1 rounded-md mt-1">
                <option value="">Status wählen</option>
                @foreach ($statuses as $status)
                    <option value="{{$status->name}}">{{$status->name}}</option>
                @endforeach
            </select>
    
            <button type="button" onclick="saveNewStatusAuftrag()" class="mt-4 px-2 py-1 rounded-sm bg-blue-600 w-full hover:bg-blue-400 text-white">Übernehmen</button>
    
        </div>         
    </div>
    
    <script>
        function saveNewStatusAuftrag() {
            console.log("awd");
            let auftrag = document.getElementById('extra-status-auftrag').value;
            
            document.getElementById('status-auftrag-text').innerHTML = auftrag;
            document.getElementById("extra-status-div-auftrag").classList.add('hidden')
    
        }
    </script>
    
    <div class=" flex  ml-6" id="emailvorlagen-main-auftrag">
        <button type="button" onclick="document.getElementById('custom-email-div-auftrag').classList.toggle('hidden');" class="flex z-40 font-medium text-md text-gray-400 hover:text-blue-400 px-2 mt-1 py-1 rounded-2xl bg-gray-50 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p class="font-medium text-md" id="auftrag-email-p">E-Mail</p>
        </button>    
        <button type="button" onclick="document.getElementById('auftrag-email-subject').value = ''; document.getElementById('auftrag-email-p').innerHTML = 'E-Mail'; this.classList.add('hidden');" id="auftrag-email-remove" class="hidden text-red-600 hover:text-red-400 " style="margin-top: -0.225rem">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
          </svg>            
        </button>
        <input type="hidden" id="auftrag-email-subject" name="subject">  
        <input type="hidden" id="auftrag-email-bcc" name="bcc">   
        <input type="hidden" id="auftrag-email-cc" name="cc">   
        <input type="hidden" id="auftrag-email-body" name="body">   
        <input type='file' oninput="document.getElementById('filename-email-auftrag').innerHTML = this.value" id="file-email-auftrag" class="hidden" name="emailfile" />

    </div>
    <script>
        function addEmailVorlage() {
            document.getElementById('emailvorlage-div').classList.add('hidden'); 
    
            let email = document.getElementById('emailvorlage').value;
    
            let subject = email.split('°°')[0];
            let body = email.split('°°')[1];
    
            document.getElementById('title').value = subject;
            $('#auftrag-textarea-email').trumbowyg('html', body);
    
        }
    </script>
    
    <script>
        function addEmailVorlage() {
            document.getElementById('emailvorlage-div').classList.add('hidden'); 
    
            let email = document.getElementById('emailvorlage').value;
    
            let subject = email.split('°°')[0];
            let body = email.split('°°')[1];
    
            document.getElementById('title').value = subject;
            $('#auftrag-textarea-email').trumbowyg('html', body);
    
        }
    </script>
    
    <div class=" flex text-gray-600 text-lg ml-6 mt-0.5" id="tracking-div-auftrag-main">
        <button type="button" onclick="document.getElementById('tracking-div-auftrag').classList.remove('hidden')" class="flex z-40 text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
              </svg>              
            <p id="tracking-auftrag-text" class="ml-2 ">Tracking</p>
        </button>        
        <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10 bg-white shadow-xl" id="tracking-div-auftrag">
            <div class="w-full pr-0.5">
                <input type="text" name="trackingnumber" id="auftrag-tracking-input" class="rounded-md w-full" placeholder="Sendungsnummer">
            </div>
            <button type="button" onclick="addTrackingnumberAuftrag()" class="mt-4 px-2 py-1 rounded-sm bg-blue-600 w-full hover:bg-blue-400 text-white">Übernehmen</button>
    
        </div>
    </div>
    <script>
        function addTrackingnumberAuftrag() {
            document.getElementById('tracking-auftrag-text').innerHTML = document.getElementById('auftrag-tracking-input').value;
    
            document.getElementById('tracking-div-auftrag').classList.add('hidden');
        }
        function addTextAuftrag(text) {
          let textarea = document.getElementById('auftrag-textarea').value;
          
          document.getElementById('auftrag-textarea').innerHTML = textarea + " " + text;
        }
    </script>
    
    <div class=" flex text-gray-600 text-lg ml-6 mt-0.5 mr-4" id="zuweisung-auftrag-main">

      <button type="button"  onclick="document.getElementById('zuweisung-auftrag-div-auftrag').classList.toggle('hidden')" class="flex z-40  text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
              <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z" clip-rule="evenodd" />
            </svg>       
          <p id="zuweisung-auftrag-text" class="ml-2">Zuweisung</p>
      </button>            
      <div class="hidden z-50 pl-4 py-2 rounded-md absolute float-left mt-10 text-black bg-white shadow-xl mr-12" id="zuweisung-auftrag-div-auftrag" style="height: 29rem; right: 0rem;" >
        <div style="max-height: 20rem;" class="overflow-auto">
              <label for="zuweisung-select-auftrag" class="block text-sm font-medium leading-6 mt-1">Nutzer</label>
              @foreach ($employees as $user)
                  <div onclick="zuweisungauftragAddUser('{{$user->id}}')" id="zuweisung-auftrag-div-{{$user->id}}" class=" py-1 hover:bg-blue-200 cursor-pointer px-2 py-1">
                      <div class="flex">
                          <div class="">
                              <div class="flex">
                                  <img src="{{url("/")}}/employee/{{$user->id}}/profile.png" class="w-8 h-8 rounded-full" onerror='this.src = "https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/default-avatar.png"' alt="">
                                  <p class="text-lg ml-2 mt-0.5">{{$user->username}}</p>
                                </div>
                          </div>
                         <div class="w-full hidden" id="zuweisung-auftrag-check-{{$user->id}}">
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
              <input type="number" placeholder="Tage" id="zuweisung-auftrag-days" class="rounded-md border-gray-300 w-full">
              <button type="button" onclick="zuweisungSpeichernauftrag()" class="bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium text-md px-4 py-2 w-full mt-4">Speichern</button>
          </div>
      </div>
  </div>
<div id="selected-zuweisung-auftrag-inputs">

</div>

<script>
  let selectedUsers = [];
  function zuweisungauftragAddUser(id) {
      document.getElementById("zuweisung-auftrag-div-"+id).classList.toggle('bg-blue-100');
      document.getElementById('zuweisung-auftrag-check-'+id).classList.toggle('hidden');

      if (selectedUsers.includes(id)) {
          selectedUsers = selectedUsers.filter(e => e !== id);
      } else {
          selectedUsers.push(id);
      }
  }

  function zuweisungSpeichernauftrag() {
      document.getElementById("selected-zuweisung-auftrag-inputs").innerHTML = '';

      selectedUsers.forEach(user => {
          let input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'zuweisung[]';
          input.value = user;
          document.getElementById("selected-zuweisung-auftrag-inputs").appendChild(input);
      });

      let tage = document.createElement("input");
      tage.type = 'hidden';
      tage.name = 'tage';
      tage.value = document.getElementById('zuweisung-auftrag-days').value;
      document.getElementById("selected-zuweisung-auftrag-inputs").appendChild(tage);

      document.getElementById('zuweisung-auftrag-text').innerHTML = selectedUsers.length + " Nutzer ausgewählt";

      document.getElementById('zuweisung-auftrag-div-auftrag').classList.add('hidden');
  }
</script>

</div>

<div id="texts-div-auftrag-main" class="flex py-2">
    <button type="button" onclick="document.getElementById('texts-div-auftrag').classList.remove('hidden')" class="flex text-gray-500 italic hover:text-blue-400 ml-3 mt-2 mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 mt-0.5">
            <path fill-rule="evenodd" d="M.99 5.24A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25l.01 9.5A2.25 2.25 0 0 1 16.76 17H3.26A2.267 2.267 0 0 1 1 14.74l-.01-9.5Zm8.26 9.52v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.615c0 .414.336.75.75.75h5.373a.75.75 0 0 0 .627-.74Zm1.5 0a.75.75 0 0 0 .627.74h5.373a.75.75 0 0 0 .75-.75v-.615a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625Zm6.75-3.63v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75ZM17.5 7.5v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75Z" clip-rule="evenodd" />
          </svg>  
          <p class="ml-2 mt-1">Textvorlagen</p>    
          
    </button>
    <div class="hidden px-2 py-1 rounded-md z-50 absolute float-left mt-10 text-black bg-white shadow-xl" id="texts-div-auftrag" style="width: 28rem" >
        <div class="flex hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD nicht erreicht')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD nicht erreicht</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD nicht erreicht, SVN einholen')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD nicht erreicht, SVN einholen</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD nicht erreicht, Erstgespräch')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD nicht erreicht, Erstgespräch</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD nicht erreicht, Mail geschickt')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD nicht erreicht, Mail geschickt</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD erreicht, warte auf Fehlerauslese per Mail')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD erreicht, warte auf Fehlerauslese per Mail</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('KD erreicht, Gerät kommt nach Berlin')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">KD erreicht, Gerät kommt nach Berlin</p>
        </div>
        <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextAuftrag('Rückruf erledigt')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <p class="ml-2">Rückruf erledigt</p>
        </div>
</div>
<div class="w-full">
    <button type="button" onclick="document.getElementById('submit-auftragform-btn').click(); loadData();" class="float-right mr-4 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium">
        Speichern
    </button>
</div>
</div>  

</div>
    </form>
  
</div>

<script>

function checkauftragDays(e, inp) {
    if(e.keyCode == 13) {
      if(inp != "") {
        let days = inp;
        let textarea = document.getElementById("auftrag-textarea");
        let currentText = textarea.innerHTML;
        textarea.innerHTML = currentText + " <span class='text-green-600 bg-green-50'>" + days + " Tage</span> <span class='text-black'>.";

        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("auftrag-textarea"));
        sel.collapseToEnd();

        document.getElementById("auftrag-textarea-time").remove();
      } else {
        newErrorAlert("Kein Tage!", "Bitte die anzahl der Tage angeben");
      }
    }
  }

  
  function filterauftrag(user = null, type = null) {
            loadData();
            if(user == null) {
                let user = document.getElementById("auftrag-filter").value;
            }
            if(type == null) {
                let type = document.getElementById("auftrag-filter-type").value;
            }
            if(type != "") {
                user = "empty";
            } else {
                type = "empty";
            }

            $.get("{{url("/")}}/crm/auftrag/auftrag/filter/"+user + "-{{$order->process_id}}/" + type, function(data) {
                $("#auftragstext-div").html(data);
                document.getElementById('auftrag-filter-div').classList.add('hidden');
                document.getElementById('auftrag-filter').value = user;
                savedPOST();
            })
        }

    function setAuftragZuweisungChecked(id) {
        loadData();
        $.get("{{url("/")}}/crm/order/zuweisung-checked/"+id, function(data) {
          updateVerlauf(data);
        })
    }

      function auftragTextCheckShortcut(e, inp) {
    if(e.keyCode == 40) {
      if(document.getElementById("auftrag-textarea-shortcut")) {
        let children = document.getElementById("auftrag-textarea-shortcut").children;
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
      if(document.getElementById("auftrag-textarea-shortcut")) {
        let children = document.getElementById("auftrag-textarea-shortcut").children;
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
      if(document.getElementById("auftrag-textarea-shortcut")) {

        e.preventDefault();
        let selectedShortcut = document.querySelector(".bg-blue-200");
        usedShortcutId = Math.random().toString(36).substring(2, 15);
        if (selectedShortcut) {
          let shortcutText = selectedShortcut.textContent;
          
          let textarea = document.getElementById("auftrag-textarea");
          let currentText = textarea.innerHTML;

          textarea.innerHTML =  currentText + "<span class='text-blue-600'>" +selectedShortcut.textContent + "</span><span id='"+usedShortcutId+"'>:";

        }
      
        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("auftrag-textarea"));
        sel.collapseToEnd();

        document.getElementById("auftrag-textarea-shortcut").remove();
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

        let textarea = document.getElementById("auftrag-textarea");
        let currentText = textarea.innerHTML;
        textarea.innerHTML = currentText.replace("#", "");

        let days = document.createElement("div");
        days.classList.add("absolute", "z-50", "bg-white", "border", "border-gray-300", "rounded-md", "px-2", "py-2", "text-md", "shadow-md", "w-36", "h-36");
        days.id = "auftrag-textarea-time";
        days.style.left = getCursorPos(document.getElementById("auftrag-textarea"))[0] + "px";
        days.style.top = getCursorPos(document.getElementById("auftrag-textarea"))[1] + 24 + "px";
        days.innerHTML = "<label>Tage</label><input type='number' id='auftrag-textarea-time-input' onkeydown='checkauftragDays(event, this.value)' class='w-full rounded-md border border-gray-300' placeholder='Tage'> <button type='button' onclick='startauftragDays()' class='mt-4 text-center px-4 py-2 w-full rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium text-md'>Speichern</button>";
        document.body.appendChild(days);

        let sel = window.getSelection();
        sel.selectAllChildren(document.getElementById("auftrag-textarea"));
        sel.collapseToEnd();

        document.getElementById("auftrag-textarea-time-input").focus();
        document.getElementById("auftrag-textarea-time-input").click();
      }

    }

      if(e.keyCode == 81) {
        if(document.getElementById("auftrag-textarea-shortcut")) {
          document.getElementById("auftrag-textarea-shortcut").remove();
          shortCutSave = "";
        }

        var pos = getCursorPos(document.getElementById("auftrag-textarea"));
        var x = pos[0];
        var y = pos[1] + 24;
        
        var div = document.createElement("div");
        div.style.left = x + "px";
        div.style.top = y + "px";
        div.classList.add("absolute", "z-50", "bg-white", "border", "border-gray-300", "rounded-md", "px-2", "text-md", "shadow-md");
        div.id = "auftrag-textarea-shortcut";

        users.forEach(user => {
          let d = document.createElement("div");
          d.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
          d.innerHTML = "<p class='text-md'>"+user+"</p>";

          div.appendChild(d);
        });

        document.body.appendChild(div);
      }
      if(document.getElementById("auftrag-textarea-shortcut")) {
        if(e.keyCode == 32) { 
          document.getElementById("auftrag-textarea-shortcut").remove();
          shortCutSave = "";
        } else {
          if(e.keyCode != 81 && e.keyCode != 16 && e.keyCode != 8) {

            shortCutSave += String.fromCharCode(e.keyCode);
            document.getElementById("auftrag-textarea-shortcut").innerHTML = "";

            if(shortCutSave.length == 0) {

            } else {
              let filteredUsers = users.filter(user => user.includes(shortCutSave.toLowerCase()));

              filteredUsers.forEach(u => {
                let div = document.createElement("div");
                div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                div.innerHTML = "<p class='text-md'>"+u+"</p>";

                document.getElementById("auftrag-textarea-shortcut").appendChild(div);
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
                document.getElementById("auftrag-textarea-shortcut").remove();
                shortCutSave = "";
              } else {
                if(shortCutSave.length == 0) {

                  users.forEach(u => {
                    let div = document.createElement("div");
                    div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                    div.innerHTML = "<p class='text-md'>@"+u+"</p>";

                    document.getElementById("auftrag-textarea-shortcut").appendChild(div);
                  });

                } else {

                  document.getElementById("auftrag-textarea-shortcut").innerHTML = "";

                  let filteredUsers = users.filter(user => user.includes(shortCutSave.toLowerCase()));

                  filteredUsers.forEach(u => {
                    let div = document.createElement("div");
                    div.classList.add("flex", "hover:bg-blue-200", "cursor-pointer");
                    div.innerHTML = "<p class='text-md'>"+u+"</p>";

                    document.getElementById("auftrag-textarea-shortcut").appendChild(div);
                  });
                }
              }
            
            }
          }
        }
      }
  }
</script>
<div class="w-full mb-10">
    


</div>
<br>



