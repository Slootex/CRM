<form action="{{url("/")}}/crm/interessent/neuer-telefontext" id="telefontext-form" method="POST">
    @CSRF
    <input type="hidden" name="id" value="{{$order->process_id}}">
<div>
    <input type="text" style="" id="title" name="name" class="w-full h-12 text-xl font-medium border border-gray-300 border-t-0 border-l-0 border-r-0" placeholder="Gesprochen mit ...">

    <textarea name="text" style="" id="phone-textarea" class="w-full h-36 border-0 text-lg" placeholder="Text ..."></textarea>

    <div id="phone-textarea-div" class="hidden">
        <textarea name="emailbody" style="" id="phone-textarea-email" class="w-full border-0 text-lg" placeholder="Text ..."></textarea>
    </div>
    <script>
        $('#phone-textarea-email').trumbowyg();
      //$('#emailvorlagen-text').trumbowyg('html', template["body"]);
    </script>
</div>


<div class="w-full h-10">



    <div class="float-right flex text-gray-600 text-lg ml-6" id="extra-status-div-main">
        <button type="button" onclick="document.getElementById('extra-status-div').classList.remove('hidden')" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p id="status-call-text-main">Status buchen</p>
        </button>
        <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10" id="extra-status-div" style="background-color: #1F2937;">
            <select name="extrastatus" id="extra-status-main" class="w-full m-auto h-10 pr-1 rounded-md mt-1">
                <option value="">Status wählen</option>
                @foreach ($statuses as $status)
                    <option value="{{$status->name}}">{{$status->name}}</option>
                @endforeach
            </select>

            <button type="button" onclick="saveNewStatus()" class="mt-4 px-2 py-1 rounded-sm bg-red-400 w-full hover:bg-red-200 text-white">Übernehmen</button>

        </div>         
    </div>



    <div class="float-right flex text-gray-600 text-lg ml-6" id="emailvorlagen-main">
        <button type="button" id="email-vorlage-button" onclick="setEmailvorlage(this)" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p>E-Mail Vorlagen</p>
        </button>  
        <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10" id="emailvorlage-div" style="background-color: #1F2937;">
            <select name="status" id="emailvorlage" class="w-full m-auto h-10 pr-1 rounded-md mt-1">
                <option value="">Vorlage wählen</option>
                @foreach ($emails as $email)
                    <option value="{{$email->subject}}°°{{$email->body}}">{{$email->name}}</option>
                @endforeach
            </select>

            <button type="button" onclick="addEmailVorlage()" class="mt-4 px-2 py-1 rounded-sm bg-red-400 w-full hover:bg-red-200 text-white">Übernehmen</button>

        </div>       
        <script>
            function setEmailvorlage(main) {
                if(main.classList.contains('bg-blue-200')) {
                    document.getElementById('phone-textarea-div').classList.toggle('hidden'); 
                    document.getElementById('phone-textarea').classList.toggle('hidden'); 
                    document.getElementById('emailvorlage-div').classList.add('hidden'); 
                    main.classList.toggle('bg-blue-200')
                    document.getElementById('title').value = "";
                    document.getElementById('title').placeholder = "Gesprochen mit...";
                    $('#phone-textarea-email').trumbowyg("clear");
                    $('#phone-textarea-email').trumbowyg("html", "");


                } else {
                    document.getElementById('title').placeholder = "Betreff...";
                    main.classList.toggle('bg-blue-200')

                    document.getElementById('emailvorlage-div').classList.remove('hidden'); 

                    document.getElementById('phone-textarea-div').classList.toggle('hidden'); 
                    document.getElementById('phone-textarea').classList.toggle('hidden'); 
                    $('#phone-textarea-email').trumbowyg("clear");
                    $('#phone-textarea-email').trumbowyg("html", "");

                }
            }    
        </script>      
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

    <div class="float-right flex text-gray-600 text-lg ml-6" id="tracking-div-main">
        <button type="button" onclick="document.getElementById('tracking-div').classList.remove('hidden')" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p id="tracking-call-text">Sendungsverfolgung</p>
        </button>           
        <div class="hidden w-56 px-2 py-2 rounded-md absolute mt-10" id="tracking-div" style="background-color: #1F2937;">
            <input type="text" name="trackingnumber" id="phone-tracking-input" class="rounded-md pr-1" placeholder="Sendungsnummer">

            <button type="button" onclick="addTrackingnumber()" class="mt-4 px-2 py-1 rounded-sm bg-red-400 w-full hover:bg-red-200 text-white">Übernehmen</button>

        </div>
    </div>
    <script>
        function addTrackingnumber() {
            document.getElementById('tracking-call-text').innerHTML = document.getElementById('phone-tracking-input').value;

            document.getElementById('tracking-div').classList.add('hidden');
        }
    </script>

    <div class="float-right flex text-gray-600 text-lg ml-6" id="zuweisung-telefon-main">
        <button type="button" onclick="document.getElementById('zuweisung-telefon-div').classList.toggle('hidden')" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p id="zuweisung-text-p">Zuweisung</p> 
        </button>             
        <div class="hidden px-2 py-2 rounded-md absolute float-left mt-10 text-white" id="zuweisung-telefon-div" style="background-color: #1F2937; width: 14rem" >
            <div>
                <label for="zuweisung-select" class="block text-sm font-medium leading-6 text-white mt-1">Nutzer</label>
                <select id="zuweisung-select" name="zuweisung" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Auswählen</option>
                    @foreach ($employees as $user)
                    @if ($user->username != null)
                        <option value="{{$user->username}}">{{$user->username}}</option>
                    @endif
                  @endforeach
                </select>

                <button type="button" onclick="document.getElementById('zuweisung-text-p').innerHTML = document.getElementById('zuweisung-select').value" class="text-md font-medium bg-blue-600 hover:bg-blue-400 px-4 py-2 rounded-md text-white mt-4 w-full">Speichern</button>
            </div>
        </div>
    </div>
    <div class="float-right flex text-gray-600 text-lg ml-6" id="texts-div-main">
        <button type="button" onclick="document.getElementById('texts-div').classList.remove('hidden')" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p id="status-call-text">Textvorlagen</p>
        </button>     
        <div class="hidden px-2 py-1 rounded-md absolute float-left mt-10 text-white" id="texts-div" style="background-color: #1F2937; width: 28rem" >
            <div class="flex hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD nicht erreicht')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD nicht erreicht, SVN einholen')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, SVN einholen</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD nicht erreicht, Erstgespräch')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, Erstgespräch</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD nicht erreicht, Mail geschickt')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD nicht erreicht, Mail geschickt</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD erreicht, warte auf Fehlerauslese per Mail')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD erreicht, warte auf Fehlerauslese per Mail</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('KD erreicht, Gerät kommt nach Berlin')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">KD erreicht, Gerät kommt nach Berlin</p>
            </div>
            <div class="flex mt-2 hover:text-blue-400 cursor-pointer" onclick="addTextPhone('Rückruf erledigt')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <p class="ml-2">Rückruf erledigt</p>
            </div>
        </div>  
    </div>

    <script>
        function addTextPhone(text) {

            let textarea = document.getElementById('phone-textarea').value;

            document.getElementById('phone-textarea').value = textarea + " " + text;

        }
    </script>

    <div class="float-right z-40" id="datepicker-main">
        <div id="datepicker-div" class="float-right flex  text-lg ml-6" style="box-shadow: none;">
            <button data-toggle title="toggle" onclick="document.getElementById('datetimepicker-time').classList.toggle('hidden')" type="button" class="flex z-40 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <p id="date-call-text">Rückruf</p>
            </button>
            <input type="hidden" name="rückruf" id="callback-input" oninput="document.getElementById('date-call-text').innerHTML = this.value" class="" >
            <input type="hidden" class="hidden" id="callback-spacing-input" data-input>

            <script>
               

                @foreach($phoneTimes as $time)     
                          
                    @php 
                        $parts = explode(" ", $time->rückruf_time);
                        $hmTimes = $parts[1];
                        $date = $parts[0];

                        $parts = explode(".", $parts[0]);

                        
                    @endphp        
                    userPhoneDays.push('{{$parts[2]}}-{{$parts[1]}}-{{$parts[0]}}');
                    
                    if(userPhoneTimes.has('{{$date}}')) {
                        let arrayTimes = userPhoneTimes.get('{{$date}}');
                        arrayTimes.push('{{str_replace(["(", ")"], "", $hmTimes)}}');
                        userPhoneTimes.set('{{$date}}', arrayTimes);
                    } else {
                        let arrayTimes = [];
                        arrayTimes.push('{{str_replace(["(", ")"], "", $hmTimes)}}');
                        userPhoneTimes.set('{{$date}}', arrayTimes);

                    }

                @endforeach

            </script>
            <div id="datetimepicker-time" class="fixed rounded-md z-50 overflow-auto p-2" style="background-color: #3f4458; margin-left: -1.54rem; margin-top: 20rem;width: 19.32rem; padding-top: 1.4rem">
                <div class="flex z-50 overflow-auto">
                    <select name="" onchange="getCalenderTime(this.value)" id="callback-hour" class="text-center w-full font-medium rounded-md border border-gray-300 appearance-none h-8" style="background-image: none; padding-right: 0px; padding-left: 0px; padding-top: 1px; padding-bottom: 1px">
                        @php
                            $hours = ["06", "07", "08", "09", "10",
                                      "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
                                      "21", "22"];

                            $minutes = ["00", "05", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55"];
                        @endphp
                        @foreach ($hours as $hour)
                            @foreach ($minutes as $minute)
                            <option id="datepicker-time-{{$hour}}:{{$minute}}" value="{{$hour}}:{{$minute}}">{{$hour}}:{{$minute}}</option>
                            @endforeach
                        @endforeach
                    </select>

                </div>
                
                <button type="button" onclick="saveNewDateTime()" class="mt-4 px-2 py-1 rounded-sm bg-red-400 w-full hover:bg-red-200 text-white">Übernehmen</button>
            </div>
        </div>
    </div>
    
</div>

<hr class="py-2 w-full">

<div class="w-full mb-10">


    <div class="float-right">
        <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-400 text-white font-medium">
            Speichern
        </button>
    </div>

</div>
</form>
