<h1 class="text-2xl font-medium pb-4" style="margin-top: -.85rem">Dateien</h1>
<form action="{{url("/")}}/crm/auftrag/upload-dokumente" id="dokumente-upload-new-form" method="POST" enctype="multipart/form-data">
    @CSRF
    <button class="hidden" type="submit" id="submit-dokumenteform-btn"></button>
    <input type="file" class="hidden" multiple name="files" oninput="
    if(this.files.length > 1) {
        document.getElementById('dokumente-p').innerHTML = this.files.length + ' Dateien ausgewählt'
    } else {
        document.getElementById('dokumente-p').innerHTML = this.files[0].name
    }
    " id="dokumente-input">
<div>
    <input type="hidden" name="process_id" value="{{$order->process_id}}">
    <div class="grid grid-cols-2 gap-2">
        <div onclick="document.getElementById('dokumente-input').click();" id="dokumente-p" class="cursor-pointer w-full rounded-md border border-gray-300 hover:border-blue-400 hover:text-blue-400 px-4 py-2 text-center">
            <div class="m-auto w-24">
                <div class="flex m-auto">
                    <p>DATEIEN</p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 ml-2">
                        <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                    </svg>              
                </div>
            </div>
        </div>
        <div class="hidden" id="dokumente-p-backup">
            <div class="m-auto w-24">
                <div class="flex m-auto">
                    <p>DATEIEN</p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 ml-2">
                        <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                    </svg>              
                </div>
            </div>
        </div>
        <div class="w-full">
            <select class="w-full py-2 rounded-md border border-gray-300" name="type" id="dokumente-type-select">
                <option value="">Dateityp auswählen</option>
                <option value="Rechnung">Rechnung</option>
                <option value="Reklamation">Reklamation</option>
                <option value="Beipackzettel">Beipackzettel</option>
                <option value="Gerätefotos">Gerätefotos</option>
                <option value="Auftragsdokumente">Auftragsdokumente</option>
                <option value="Audio">Audio</option>
            </select>
        </div>
    </div>


    <div class="border border-gray-300 rounded-md mt-4" >
        <div class="">
            <textarea name="description" id="dokumente-textarea"  class="w-full h-36 border-0 text-lg focus:ring-0 focus:ring-offset-0 resize-none" placeholder="Text ..."></textarea>
    
            <div id="dokumente-textarea-div" class="hidden">
                <textarea name="emailbody" id="dokumente-textarea-email" style="padding-left: 3px" class="w-full border-0 text-lg" placeholder="Text ..."></textarea>
            </div>

        </div>
    
    
    <div class="flex border border-t-0 border-l-0 border-r-0 border-gray-300 w-full" style="display: flex; justify-content: flex-end">
        <div class="flex ml-6 font-medium text-md  mt-1" id="extra-status-div-dokumente-main">
            <button type="button" onclick="document.getElementById('extra-status-div-dokumente').classList.remove('hidden')" class="flex z-40 text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                    <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                  </svg>             
                <p id="status-dokumente-text" class="ml-2 ">Status</p>
            </button>   
            <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10 bg-white shadow-xl" id="extra-status-div-dokumente">
                <select name="extrastatus" id="dokumente-veraluf-neuer-status-select" class="w-full m-auto h-10 pr-1 rounded-md mt-1">
                    <option value="">Status wählen</option>
                    @foreach ($statuses as $status)
                        <option value="{{$status->name}}">{{$status->name}}</option>
                    @endforeach
                </select>
        
                <button type="button" onclick="saveNewStatus()" class="mt-4 px-2 py-1 rounded-sm bg-blue-600 w-full hover:bg-blue-400 text-white">Übernehmen</button>
        
            </div>         
        </div>
        
        <script>
            function saveNewStatus() {
        
                let status = document.getElementById('dokumente-veraluf-neuer-status-select').value;
                
                document.getElementById('status-dokumente-text').innerHTML = status;
                document.getElementById("extra-status-div-dokumente").classList.add('hidden')
        
            }
        </script>
        
        <div class=" flex  ml-6" id="emailvorlagen-main-dokumente">
            <button type="button" onclick="document.getElementById('custom-email-div-dokumente').classList.toggle('hidden');" class="flex z-40 font-medium text-md text-gray-400 hover:text-blue-400 px-2 mt-1 py-1 rounded-2xl bg-gray-50 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <p class="font-medium text-md" id="dokumente-email-p">E-Mail</p>
            </button>    
            <button type="button" onclick="document.getElementById('dokumente-email-subject').value = ''; document.getElementById('dokumente-email-p').innerHTML = 'E-Mail'; this.classList.add('hidden');" id="dokumente-email-remove" class="hidden text-red-600 hover:text-red-400 ">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
              </svg>            
            </button>
            <input type="hidden" id="dokumente-email-subject" name="subject">  
            <input type="hidden" id="dokumente-email-bcc" name="bcc">   
            <input type="hidden" id="dokumente-email-cc" name="cc">   
            <input type="hidden" id="dokumente-email-body" name="body">   
            <input type='file' oninput="document.getElementById('filename-email-dokumente').innerHTML = this.value" id="file-email-dokumente" class="hidden" name="emailfile" />
   
        </div>
        <script>
            function addEmailVorlage() {
                document.getElementById('emailvorlage-div').classList.add('hidden'); 
        
                let email = document.getElementById('emailvorlage').value;
        
                let subject = email.split('°°')[0];
                let body = email.split('°°')[1];
        
                document.getElementById('title').value = subject;
                $('#phone-textarea-email').trumbowyg('html', body);
        
            }
        </script>
        
        <div class=" flex text-gray-600 text-lg ml-6 mt-0.5" id="tracking-div-dokumente-main">
            <button type="button" onclick="document.getElementById('tracking-div-dokumente').classList.remove('hidden')" class="flex z-40 text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                    <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                  </svg>              
                <p id="tracking-dokumente-text" class="ml-2 ">Tracking</p>
            </button>        
            <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10 bg-white shadow-xl" id="tracking-div-dokumente">
                <div class="w-full pr-0.5">
                    <input type="text" name="trackingnumber" id="dokumente-tracking-input" class="rounded-md w-full" placeholder="Sendungsnummer">
                </div>
                <button type="button" onclick="addTrackingnumberdokumente()" class="mt-4 px-2 py-1 rounded-sm bg-blue-600 w-full hover:bg-blue-400 text-white">Übernehmen</button>
        
            </div>
        </div>
        <script>
            function addTrackingnumberdokumente() {
                document.getElementById('tracking-dokumente-text').innerHTML = document.getElementById('dokumente-tracking-input').value;
        
                document.getElementById('tracking-div-dokumente').classList.add('hidden');
            }
            function addTextdokumente(text) {
        
        let textarea = document.getElementById('dokumente-textarea').value;
        
        document.getElementById('dokumente-textarea').value = textarea + " " + text;
        
        }

        function inspectDokument(id) {
            $.get("{{url("/")}}/crm/get-dokument-"+id, function(data) {
                document.getElementById("dokumente-inspect").innerHTML = data;
            })
        }
        </script>
        
              
      <div class=" flex text-gray-600 text-lg ml-6 mt-0.5 mr-4" id="zuweisung-dokumente-main">

        <button type="button"  onclick="document.getElementById('zuweisung-dokumente-div-dokumente').classList.toggle('hidden')" class="flex z-40  text-md text-gray-400 hover:text-blue-400 px-2 py-1 rounded-2xl bg-gray-50 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z" clip-rule="evenodd" />
              </svg>       
            <p id="zuweisung-dokumente-text" class="ml-2">Zuweisung</p>
        </button>            
        <div class="hidden z-50 pl-4 py-2 rounded-md absolute float-left mt-10 text-black bg-white shadow-xl mr-12" id="zuweisung-dokumente-div-dokumente" style="height: 29rem; right: 0rem;" >
            <div style="max-height: 20rem;" class="overflow-auto">
                <label for="zuweisung-select-dokumente" class="block text-sm font-medium leading-6 mt-1">Nutzer</label>
                @foreach ($employees as $user)
                    <div onclick="zuweisungdokumenteAddUser('{{$user->id}}')" id="zuweisung-dokumente-div-{{$user->id}}" class=" py-1 hover:bg-blue-200 cursor-pointer px-2 py-1">
                        <div class="flex">
                            <div class="">
                                <div class="flex">
                                    <img src="{{url("/")}}/employee/{{$user->id}}/profile.png" class="w-8 h-8 rounded-full" onerror='this.src = "https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/default-avatar.png"' alt="">
                                    <p class="text-lg ml-2 mt-0.5">{{$user->username}}</p>
                                  </div>
                            </div>
                           <div class="w-full hidden" id="zuweisung-dokumente-check-{{$user->id}}">
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
                <input type="number" placeholder="Tage" id="zuweisung-dokumente-days" class="rounded-md border-gray-300 w-full">
                <button type="button" onclick="zuweisungSpeicherndokumente()" class="bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium text-md px-4 py-2 w-full mt-4">Speichern</button>
            </div>
        </div>
    </div>
<div id="selected-zuweisung-dokumente-inputs">

</div>

<script>


    function zuweisungSpeicherndokumente() {
        document.getElementById("selected-zuweisung-dokumente-inputs").innerHTML = '';

        selectedUsersdokumente.forEach(user => {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'zuweisung[]';
            input.value = user;
            document.getElementById("selected-zuweisung-dokumente-inputs").appendChild(input);
        });

        let tage = document.createElement("input");
        tage.type = 'hidden';
        tage.name = 'tage';
        tage.value = document.getElementById('zuweisung-dokumente-days').value;
        document.getElementById("selected-zuweisung-dokumente-inputs").appendChild(tage);

        document.getElementById('zuweisung-dokumente-text').innerHTML = selectedUsersdokumente.length + " Nutzer ausgewählt";

        document.getElementById('zuweisung-dokumente-div-dokumente').classList.add('hidden');
    }
</script>
    
    </div>
    
    <div id="texts-div-dokumente-main" class="flex py-2">
        <button type="button" onclick="document.getElementById('texts-div-dokumente').classList.remove('hidden')" class="flex text-gray-500 italic hover:text-blue-400 ml-3 mt-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 mt-0.5">
                <path fill-rule="evenodd" d="M.99 5.24A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25l.01 9.5A2.25 2.25 0 0 1 16.76 17H3.26A2.267 2.267 0 0 1 1 14.74l-.01-9.5Zm8.26 9.52v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.615c0 .414.336.75.75.75h5.373a.75.75 0 0 0 .627-.74Zm1.5 0a.75.75 0 0 0 .627.74h5.373a.75.75 0 0 0 .75-.75v-.615a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625Zm6.75-3.63v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75v.625c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75ZM17.5 7.5v-.625a.75.75 0 0 0-.75-.75H11.5a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75h5.25a.75.75 0 0 0 .75-.75Zm-8.25 0v-.625a.75.75 0 0 0-.75-.75H3.25a.75.75 0 0 0-.75.75V7.5c0 .414.336.75.75.75H8.5a.75.75 0 0 0 .75-.75Z" clip-rule="evenodd" />
              </svg>  
              <p class="ml-2 mt-1">Textvorlagen</p>    
              
        </button>
        <div class="hidden px-2 py-1 rounded-md z-50 absolute float-left mt-10 text-black bg-white shadow-xl" id="texts-div-dokumente" style="width: 28rem" >
            <div class="flex hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD nicht erreicht')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD nicht erreicht, SVN einholen')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, SVN einholen</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD nicht erreicht, Erstgespräch')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, Erstgespräch</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD nicht erreicht, Mail geschickt')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, Mail geschickt</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD erreicht, warte auf Fehlerauslese per Mail')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD erreicht, warte auf Fehlerauslese per Mail</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('KD erreicht, Gerät kommt nach Berlin')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD erreicht, Gerät kommt nach Berlin</p>
            </div>
            <div class="flex mt-2 hover:bg-blue-200 cursor-pointer" onclick="addTextdokumente('Rückruf erledigt')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">Rückruf erledigt</p>
            </div>
    </div>
    <div class="w-full">
        <button type="button" onclick="document.getElementById('submit-dokumenteform-btn').click(); loadData();" class="float-right mr-4 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium">
            Speichern
        </button>
    </div>
    </div>  
    
    </div>
</div>
</form>
<br>
<br>