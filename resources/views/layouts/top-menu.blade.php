


@isset($args)
    @include('layouts.args')
@endisset


@include('components.saveFinish')
@include('components.loadData')
@include('includes.alerts.error')
@include('includes.alerts.main')
<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
<script>
  const options = {
  bottom: '64px', // default: '32px'
  right: 'unset', // default: '32px'
  left: '32px', // default: 'unset'
  time: '0.5s', // default: '0.3s'
  mixColor: '#fff', // default: '#fff'
  backgroundColor: '#fff',  // default: '#fff'
  buttonColorDark: '#100f2c',  // default: '#100f2c'
  buttonColorLight: '#fff', // default: '#fff'
  saveInCookies: true, // default: true,
  label: '🌓', // default: ''
  autoMatchOsTheme: true // default: true
}

const darkmode = new Darkmode(options);
darkmode.showWidget();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<script src="{{url("/")}}/js/system.js"></script>
<link rel="stylesheet" href="{{url("/")}}/css/text.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script> 
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
<script>
  try {
    $(document).ready(function() {
    });
  } catch (error) {
    var my_awesome_script = document.createElement('script');

    my_awesome_script.setAttribute('src','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js');

    document.head.appendChild(my_awesome_script);
          

  }
</script>


    @php
        $checkMenuColor = false;
    @endphp

    @if ($menu == "auftrag")
    <header class="bg-blue-600" style="--tw-bg-opacity: 1;">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($menu == "interessent")
    <header class="bg-green-700">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($menu == "packtisch")
    <header class="bg-slate-700">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($menu == "reklamation")
    <header class="bg-rose-700">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($menu == "einkauf")
    <header class="bg-yellow-700">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($menu == "kunden")
    <header class="bg-teal-700">
      @php
          $checkMenuColor = true;
      @endphp
    @endif

    @if ($checkMenuColor == false)
    <header class="bg-slate-700">
      @endif
 
  
    <div class=" w-full" style="">
      <div class="">
      <nav class="inline-block px-8 " style=" z-index: 100;" aria-label="Global">


            @isset($menu)
              @if (auth()->user()->roles[0]->permissions->where("name", "see.leftmenu.aufträge")->first() != null)
                @if ($menu == "auftrag")
                  <a href="{{url("/")}}/crm/auftragsübersicht-aktiv" class="mt-2 border border-t-0 border-l-0 border-r-0 border-b-4 border-white mr-3 text-white py-2 inline-flex items-center text-lg " aria-current="page">Aufträge</a>
                @else
                  <a href="{{url("/")}}/crm/auftragsübersicht-aktiv" class="mt-2 text-white mr-3 
                  @if($menu == "auftrag")  hover:bg-blue-400 @endif
                  @if($menu == "interessent")  hover:bg-green-400 @endif
                  @if($menu == "packtisch") hover:bg-slate-400 @endif
                  @if($menu == "kunden")  hover:bg-teal-400 @endif
                  @if($menu == "reklamation") hover:bg-rose-400 @endif
                  @if($menu == "einkauf") hover:bg-yellow-400 @endif
                  py-2 px-3 inline-flex rounded-md items-center text-lg" aria-current="page">Aufträge</a>
                @endif
              @endif

              @if (auth()->user()->roles[0]->permissions->where("name", "see.leftmenu.interessenten")->first() != null)
                @if ($menu == "interessent")
                  <a href="{{url("/")}}/crm/interessentenübersicht-aktiv" class="border border-t-0 border-l-0 border-r-0 border-b-4 border-white py-2 mr-3 text-white px-3 inline-flex items-center text-lg font-medium">Interessenten</a>
                @else
                  <a href="{{url("/")}}/crm/interessentenübersicht-aktiv" class="text-white mr-3
                  @if($menu == "auftrag")  hover:bg-blue-400 @endif
                  @if($menu == "interessent")  hover:bg-green-400 @endif
                  @if($menu == "packtisch") hover:bg-slate-400 @endif
                  @if($menu == "kunden")  hover:bg-teal-400 @endif
                  @if($menu == "reklamation") hover:bg-rose-400 @endif
                  @if($menu == "einkauf") hover:bg-yellow-400 @endif
                  rounded-md px-3 py-2 inline-flex items-center text-lg ">Interessenten</a>
                @endif
              @endif

              @if (auth()->user()->roles[0]->permissions->where("name", "see.leftmenu.packtisch")->first() != null)
                @if (str_contains($menu, "packtisch"))
                  <a href="{{url("/")}}/crm/packtisch" class="py-2 border border-t-0 border-l-0 border-r-0 border-b-4 border-white mr-3 text-white px-3 inline-flex items-center text-lg font-medium">Packtisch</a>
                @else
                  <a href="{{url("/")}}/crm/packtisch" class="text-white mr-3 
                  @if($menu == "auftrag")  hover:bg-blue-400 @endif
                  @if($menu == "interessent")  hover:bg-green-400 @endif
                  @if($menu == "packtisch") hover:bg-slate-400 @endif
                  @if($menu == "kunden")  hover:bg-teal-400 @endif
                  @if($menu == "reklamation") hover:bg-rose-400 @endif
                  @if($menu == "einkauf") hover:bg-yellow-400 @endif
                  rounded-md py-2 px-3 inline-flex items-center text-lg ">Packtisch</a>
                @endif
              @endif

            

              @if (auth()->user()->roles[0]->permissions->where("name", "see.leftmenu.kunden")->first() != null)
              
              @if ($menu == "kunden")
              <a href="{{url("/")}}/crm/kundenübersicht-aktiv" class="py-2 border border-t-0 border-l-0 border-r-0 border-b-4 border-white mr-3 text-white px-3 inline-flex items-center text-lg font-medium">Kunde</a>
                @else
                <a href="{{url("/")}}/crm/kundenübersicht-aktiv" class="text-white mr-3 
                @if($menu == "auftrag")  hover:bg-blue-400 @endif
                @if($menu == "interessent")  hover:bg-green-400 @endif
                @if($menu == "packtisch") hover:bg-slate-400 @endif
                @if($menu == "kunden")  hover:bg-teal-400 @endif
                @if($menu == "reklamation") hover:bg-rose-400 @endif
                @if($menu == "einkauf") hover:bg-yellow-400 @endif
                   rounded-md
                   py-2 px-3 inline-flex items-center text-lg ">Kunde</a>
                @endif
              
              @endif

              @if (auth()->user()->roles[0]->permissions->where("name", "see.leftmenu.einkauf")->first() != null)
              @if ($menu == "einkauf")
              <a href="{{url("/")}}/crm/einkaufsübersicht-aktiv" class="border border-t-0 border-l-0 border-r-0 border-b-4 border-white mr-3 text-white py-2 px-3 inline-flex items-center text-lg font-medium">Einkauf</a>
                @else
                <a href="{{url("/")}}/crm/einkaufsübersicht-aktiv" class="text-white mr-3 
                @if($menu == "auftrag")  hover:bg-blue-400 @endif
                @if($menu == "interessent")  hover:bg-green-400 @endif
                @if($menu == "packtisch") hover:bg-slate-400 @endif
                @if($menu == "kunden")  hover:bg-teal-400 @endif
                @if($menu == "reklamation") hover:bg-rose-400 @endif
                @if($menu == "einkauf") hover:bg-yellow-400 @endif
                rounded-md
                py-2 px-3 inline-flex items-center text-lg ">Einkauf</a>
                @endif
              
              @endif              

              @if ($menu == "reklamation")
              <a href="{{url("/")}}/crm/reklamationsübersicht-aktiv" class="py-2 border border-t-0 border-l-0 border-r-0 border-b-4 border-white mr-3 text-white px-3 inline-flex items-center text-lg font-medium">Reklamation</a>
                @else
                <a href="{{url("/")}}/crm/reklamationsübersicht-aktiv" class="text-white mr-3  
                @if($menu == "auftrag")  hover:bg-blue-400 @endif
                @if($menu == "interessent")  hover:bg-green-400 @endif
                @if($menu == "packtisch") hover:bg-slate-400 @endif
                @if($menu == "kunden")  hover:bg-teal-400 @endif
                @if($menu == "reklamation") hover:bg-rose-400 @endif
                @if($menu == "einkauf") hover:bg-yellow-400 @endif
                rounded-md
                py-2 px-3 inline-flex items-center text-lg ">Reklamation</a>
                @endif
              
              
              
        @endisset
          
     
      </nav>
       
      <div class=" m-auto float-right h-10 mt-0.5 pr-4 justify-between">

      
      
        <div class="  float-right  lg:z-10 flex">
          <form action="{{url("/")}}/crm/globale-suche" method="POST" class="mr-4">
            @CSRF
            <div class="flex flex-1 pl-2 mr-10 lg:ml-6 rounded-md w-80 bg-white mt-2">
            <div class="w-full max-w-lg lg:max-w-xs ">
    
              <div class="" id="search-bar">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                  <button class="absolute inset-y-0 right-0 flex items-center pl-3 bg-transparent ">
                      <svg class="h-5 w-5 mr-3
                      text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                      </svg>
                  </button>
                  <input id="search" autocomplete="off" oninput="liveSearchGlobal(this.value)" name="global_keyword" class="outline-none focus:outline-none block border-0 rounded-md bg-transparent w-72  py-1.5 text-gray-400 placeholder:text-gray focus:ring-0 sm:text-lg sm:leading-6" placeholder="Suchen">
                  <div class="w-full hidden h-36 rounded-md bg-white drop-shadow-lg absolute px-4 py-2 max-h-36 overflow-y-scroll" id="extend-search-div">
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form> 

          <script>
            function liveSearchGlobal(key) {
              if(key != "") {
                  document.getElementById("extend-search-div").classList.remove("hidden");
                } else {
                  document.getElementById("extend-search-div").classList.add("hidden");
                }
              $.get("{{url("/")}}/crm/globale-suche/keyword/"+key, function(data) {
                
                $("#extend-search-div").html("");
                data.forEach(search => {
                  $("#extend-search-div").append('<div onclick="showOrderChangeModal('+"'"+ search["process_id"] +"'"+');" class="cursor-pointer flex text-left text-blue-600 hover:text-blue-400">'+search["process_id"] + ", " + search["firstname"] + " " + search["lastname"] +'</div>')
                });
                
              });
            }
          </script>
     
          <div onclick="getZeiterfassung('{{auth()->user()->id}}')" id="zeiterfassung-top" class="px-4 py-2 cursor-pointer mr-4 border-t-0 border-b-0 border-r-0 flex
            @if($menu == "auftrag")  hover:bg-blue-400 @endif
            @if($menu == "interessent")  hover:bg-green-400 @endif
            @if($menu == "packtisch") hover:bg-slate-400 @endif
            @if($menu == "kunden")  hover:bg-teal-400 @endif
            @if($menu == "reklamation") hover:bg-rose-400 @endif
            @if($menu == "einkauf") hover:bg-yellow-400 @endif">
            <div id="zeiterfassung-dropdown">

            </div>
            <div class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 mt-1.5 mr-1.5 text-white">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
              </svg>
              
              <p id="current-time-zeiterfassung" class="text-lg font-medium text-white mt-1"></p>
            </div>
           

            
          </div>
          <script>
            function startZeitefassungCurrentTime() {
              const today = new Date();
              let h = today.getHours();
              let m = today.getMinutes();
              m = checkTime(m);
              document.getElementById('current-time-zeiterfassung').innerHTML =  h + ":" + m + " Uhr";
              setTimeout(startZeitefassungCurrentTime, 1000);
            }

            function checkTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }

            startZeitefassungCurrentTime();

            function getZeiterfassung(id) {
              
              $.get("{{url("/")}}/crm/zeiterfassung-div-"+id, function(data) {
                $("#zeiterfassung-dropdown").html(data);

                document.getElementById("zeiterfassung-top").classList.remove("cursor-pointer");
                document.getElementById("zeiterfassung-top").setAttribute("onclick", "");
              });
            }

            let runZeiterfassungId = null;
            let hr = 0;
            let mi = 0;
            let se = 0;
            function runZeitefassungCurrentTime() {

              se++;
              if(se >= 60) {
                mi++;
                se = 0;
              }

              if(mi >= 60) {
                $hr++;
                $mi = 0;
              }
              h = checkRunTime(hr);

              m = checkRunTime(mi);
              s = checkRunTime(se);

              document.getElementById('worked-time').innerHTML =  h + ":" + m + ":" + s;
              runZeiterfassungId = setTimeout(runZeitefassungCurrentTime, 1000);

            }

            function checkRunTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }

           
            function startZeiterfassung(h,m,s) {
              

              hr = h;
              mi = m;
              se = s;
                $.get("{{url("/")}}/crm/zeiterfassung-starten", function(data) {
                  document.getElementById("zeiterfassung-dropdown").innerHTML = data;
                  runZeitefassungCurrentTime();

                  document.getElementById("top-time-text").innerHTML = "Am Arbeiten";
                });
            }

            function stopZeiterfassung(id) {
              clearInterval(runZeiterfassungId);
                $.get("{{url("/")}}/crm/zeiterfassung-stoppen-"+id, function(data) {
                  document.getElementById("zeiterfassung-dropdown").innerHTML = data;

                  document.getElementById("top-time-text").innerHTML = "Zeiterfassung aus";
                });
            }

          </script>
      
          
  
          <div onclick="showMenu()" class="relative cursor-pointer flex-shrink-0 px-4 py-1.5   @if($menu == "auftrag")  hover:bg-blue-400 @endif
          @if($menu == "interessent")  hover:bg-green-400 @endif
          @if($menu == "packtisch") hover:bg-slate-400 @endif
          @if($menu == "kunden")  hover:bg-teal-400 @endif
          @if($menu == "reklamation") hover:bg-rose-400 @endif
          @if($menu == "einkauf") hover:bg-yellow-400 @endif border-t-0 border-b-0 ">
            <div class="flex">
              <button type="button" class="flex rounded-full bg-white text-sm text-white focus:outline-none focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <img src="{{url("/")}}/employee/{{auth()->user()->id}}/profile.png" class="h-10 w-10 rounded-full" onerror="this.onerror=null; this.src='{{url("/")}}/img/santa.png'" >
              </button>
            </div>
  
            <script>
                var counter = 0;
                function showMenu() {
                  document.getElementById('dropdownMenu').classList.toggle('hidden');
                }
            </script>
            <div id="dropdownMenu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 px-2 ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            
              <p class="mt-2 mb-2 ml-2 font-semibold text-gray-800">Menü</p>
              
              <a href="#" onclick="loadEmailForhand('1')" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">E-Mail Posteingang</a>
              
              <a href="{{url("/")}}/crm/globale-aufträge" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Globale-Aufträge</a>
              
              <a href="{{url("/")}}/crm/adressbuch" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Adressbuch</a>

              <a href="{{url("/")}}/crm/aktivitätsmonitor" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Aktivitäten</a>
              
              <a href="{{url("/")}}/crm/dateiverteilen" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Datei-Manager</a>
              
              <p class="mt-2 mb-2 ml-2 font-semibold text-gray-800">Einstellungen</p>
              
              <a href="#" onclick="document.getElementById('dropdownMenu').classList.toggle('hidden'); document.getElementById('profileSettings').classList.toggle('hidden')" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Profil</a>
              
              <a href="{{url("/")}}/crm/workflow" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Workflow</a>

              <a href="{{url("/")}}/crm/benutzer" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Benutzer</a>
              
              <a href="{{url("/")}}/crm/rollen" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Berechtigungen</a>
              
              <a href="{{url("/")}}/crm/vergleichsetting" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Texte</a>
              
              <a href="{{url("/")}}/crm/email-vorlagen" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">E-Mails</a>
              
              <a href="{{url("/")}}/crm/statuse" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Statuse</a>
              
              <a href="{{url("/")}}/crm/buchhaltung-einstellungen" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Buchhaltung</a>

              <a href="{{url("/")}}/crm/unverifizierte-kundenliste" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Unverifizierte Kundenliste</a>
              
              <p class="mt-2 mb-2 ml-2 font-semibold text-gray-800">Lager</p>

              <a href="{{url("/")}}/crm/settings" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Lagerplätze</a>
              
              <p class="mt-2 mb-2 ml-2 font-semibold text-gray-800">Versand</p>
              
              <a href="{{url("/")}}/crm/versenden" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Versenden</a>
              
              <a href="{{url("/")}}/crm/abholung" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Abholungen</a>
              
              <a href="{{url("/")}}/crm/siegel" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Siegel</a>

              <a href="{{url("/")}}/crm/ups-statuscodes" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Statuscodes</a>
              
              <a href="{{url("/")}}/crm/logout" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Ausloggen</a>
              
            </div>
          </div>
        </div>
      </div>
      
      </div>


      <!-- Current: "bg-gray-900 text-white", Default: "text-white hover:bg-blue-600 hover:bg-blue-500 hover:text-white" -->
        
        @isset($packtisch)
        <nav class=" px-8 bg-slate-600 py-2" style=" z-index: 100;" aria-label="Global">

          <a href="{{url("/")}}/crm/packtisch" class="@if($menu == "packtisch-packtisch") bg-slate-500  text-white @else text-white @endif mr-3 hover:bg-slate-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Übersicht</a>

          <a href="{{url("/")}}/crm/packtisch/lagerplatzübersicht" class="mr-3 @if($menu == "lagerplatzübersicht-packtisch")  bg-slate-500 text-white @else text-white @endif hover:bg-slate-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Lagerplatzübersicht</a>

          <a href="{{url("/")}}/crm/packtisch/tagesabschluss" class="mr-3 @if($menu == "tagesabschluss-packtisch")  bg-slate-500 text-white @else text-white @endif hover:bg-slate-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Materialinventur</a>
          
          <a href="{{url("/")}}/crm/packtisch/freies-umlagern" class="mr-3 @if($menu == "umlagern-packtisch")  bg-slate-500 text-white @else text-white @endif hover:bg-slate-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">freies Umlagern</a>
          
          <a href="{{url("/")}}/crm/packtisch/historie" class="mr-3 @if($menu == "historie-packtisch")  bg-slate-500 text-white @else text-white @endif hover:bg-slate-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Historie</a>
          @endisset

        @if ($menu == "auftrag")
        <nav class=" pl-5 py-2 w-full bg-blue-500" style=" z-index: 100; " aria-label="Global">

        <a href="{{url("/")}}/crm/auftragsübersicht-archiv" class="@isset($undermenu) @if($undermenu == "archiv") bg-blue-400 ml-3 text-white @else text-white @endif @else text-white @endisset  font-medium hover:bg-blue-400 hover:text-white rounded-md py-2 px-3 inline-flex items-center text-sm " aria-current="page">Archiv</a>
        
        <a href="{{url("/")}}/crm/neuer/auftrag" class="@isset($undermenu) @if($undermenu == "neu") bg-blue-400   text-white @else text-white @endif  @else text-white @endisset mr-3 font-medium  hover:bg-blue-400 hover:text-white ml-2 rounded-md py-2 px-3 inline-flex items-center text-sm " aria-current="page">Neuer Auftrag</a>
       
          <button type="button" onclick="getStatistik() this.classList.toggle('text-gray-200'); this.classList.toggle('text-white');" class="py-2 font-medium float-right text-gray-200 hover:text-gray-50 text-sm text-right mr-8 mt-1">Statistik</button>
        
          <a href="{{url("/")}}/crm/überwachungssystem" class="float-right text-gray-200 hover:text-gray-50 text-sm mt-1 text-right mr-4 py-2 font-medium">Überwachungssystem</a>

          @endif 

        @if ($menu == "interessent")
        <nav class=" px-8 bg-green-600 py-2" style=" z-index: 100;" aria-label="Global">

        <a href="{{url("/")}}/crm/interessentenübersicht-archiv" class="@isset($undermenu) @if($undermenu == "archiv") bg-green-700  text-white @else text-white @endif  @else text-white @endisset font-medium hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Archiv</a>
        
        <a href="{{url("/")}}/crm/neuer/interessent" class="@isset($undermenu) @if($undermenu == "neu") bg-green-700 text-white @else text-white @endif  @else text-white @endisset font-medium mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Neuer Interessent</a>
       
        <button type="button" onclick="document.getElementById('statistik').classList.toggle('hidden'); this.classList.toggle('text-gray-200'); this.classList.toggle('text-white');" class="font-medium float-right py-2 text-gray-200 hover:text-gray-50 text-sm font-semibold mt-2 text-right mr-12">Statistik</button>
        
        <a href="{{url("/")}}/crm/überwachungssystem" class="float-right text-gray-200 hover:text-gray-50 text-sm mt-1 text-right mr-4 py-2 font-medium">Überwachungssystem</a>

        @endif 

        @if ($menu == "einkauf")
        <nav class=" px-8 bg-yellow-600 py-2" style=" z-index: 100;" aria-label="Global">

        <button id="einkauf-archiv-button" type="button" onclick="getEinkaufArchiv()" class="@isset($undermenu) @if($undermenu == "archiv") bg-yellow-500  text-white @else text-white @endif  @else text-white @endisset font-medium mr-3 hover:bg-yellow-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Archiv</button>
        
        <button type="button" onclick="getNeuerEinkauf()" class="@isset($undermenu) @if($undermenu == "neu") bg-yellow-500 text-white @else text-white @endif  @else text-white @endisset font-medium mr-3 hover:bg-yellow-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Neuer Einkauf</button>
               
        @endif 

        @if ($menu == "reklamation")
        <nav class=" px-8 bg-rose-600 py-2" style=" z-index: 100;" aria-label="Global">

        <a href="{{url("/")}}/crm/reklamationsübersicht-archiv" class="@isset($undermenu) @if($undermenu == "archiv") bg-rose-500  text-white @else text-white @endif  @else text-white @endisset font-medium mr-3 hover:bg-rose-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Archiv</a>
                       
        @endif 
  
        
      </nav>
      <nav id="einstellungen-tab" class="hidden px-8 bg-blue-600 py-2" style=" z-index: 100;" aria-label="Global">

        <a href="{{url("/")}}/crm/benutzer" class="@isset($undermenu) @if($undermenu == "benutzer") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Benutzer</a>
        <a href="{{url("/")}}/crm/rollen" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Berechtigungen</a>
        <a href="{{url("/")}}/crm/vergleichsetting" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Texte</a>
        <a href="{{url("/")}}/crm/email-vorlagen" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">E-Mails</a>
        <a href="{{url("/")}}/crm/statuse" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Statuse</a>
        <a href="{{url("/")}}/crm/buchhaltung-einstellungen" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Buchhaltung</a>
        <a href="{{url("/")}}/crm/unverifizierte-kundenliste" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Unv. Kundenliste</a>
        <a href="{{url("/")}}/crm/packtisch/lagerplatzübersicht" class="@isset($undermenu) @if($undermenu == "berechtigungen") bg-green-700  text-white @else text-white @endif  @else text-white @endisset mr-3 hover:bg-green-500 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Lagerplätze</a>


      </nav>
      

    </div>
    <hr style=" margin: auto; border-color:rgba(164, 164, 164, 0.253); width: 97%" style="m-auto ">


  </header>
  <div id="found-bpz-replace">

  </div>
  
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


  let userPhoneDays = [];
  let userPhoneTimes = new Map();
  let settedPhoneHours = [];
  let selectedDate = "";
  let picker = null;

  function saveNewDateTime() {

    let hour        = document.getElementById('callback-hour').value;
    let date        = document.getElementById('callback-input').value;
    let spaceDate   = document.getElementById('callback-spacing-input').value;

    date = spaceDate + " (" + hour + ")";
    document.getElementById('callback-input').value = date;
    document.getElementById('date-call-text').innerHTML = date;

    document.getElementById('datetimepicker-time').classList.add('hidden');

    picker.close();  
    }

    let usedTimes = [];
    function getCalenderMinutes(time) {

    let dateTimes = userPhoneTimes.get(selectedDate);

        if(usedTimes.length != 0) {
            usedTimes.forEach(time => {
            if(document.getElementById('datepicker-time-'+time)) {
                document.getElementById('datepicker-time-'+time).classList.remove("bg-red-200");
            }
        });
        usedPhoneMinutes = [];
    }
  }

  function getVerlaufErweitertView(event, id) {
    loadData();
    $.get("{{url("/")}}/crm/verlauf/get-"+id, function(data) {
      document.getElementById("verlauf-erweitert").innerHTML = data;
      savedPOST();
    })
  }

  function showHiddenTexts() {
    hiddenTexts.forEach(id => {

      if(document.getElementById("status-column-eye-open-"+id)) {
        if(document.getElementById("status-eye-open").classList.contains("hidden")) {
          document.getElementById("status-row-"+id).classList.remove("hidden");
        } else {
          if(document.getElementById("status-column-eye-close-"+id).classList.contains("hidden")) {
            document.getElementById("status-row-"+id).classList.add("hidden");
          } 
        }
      }
    });
    document.getElementById("status-eye-open").classList.toggle("hidden");
    document.getElementById("status-eye-close").classList.toggle("hidden");
  }

  function showHiddenTextsAuftrag() {
    console.log(hiddenTexts);
    hiddenTexts.forEach(id => {
      if(document.getElementById("auftrag-column-eye-open-"+id)) {
        if(document.getElementById("auftrag-eye-open").classList.contains("hidden")) {
          document.getElementById("auftrag-row-"+id).classList.remove("hidden");
        } else {
          if(document.getElementById("auftrag-column-eye-close-"+id).classList.contains("hidden")) {
            document.getElementById("auftrag-row-"+id).classList.add("hidden");
          } 
        }
      }
    });
    document.getElementById("auftrag-eye-open").classList.toggle("hidden");
    document.getElementById("auftrag-eye-close").classList.toggle("hidden");
  }

  function searchHsnTsn(hsn_v, tsn_v) {
    loadData();

    $.post( "{{url("/")}}/crm/neuer-auftrag/nummersuche", {
      hsn: hsn_v,
      tsn: tsn_v,
      '_token': $('meta[name=csrf-token]').attr('content'),

      } , function( data ) {  

        if(data != "empty") {
          document.getElementById("kundendaten-car_company").value = data["mf"].split(" ")[0];
          document.getElementById("kundendaten-car_model").value = data["mf"].replace(data["mf"].split(" ")[0], "");
          document.getElementById("kundendaten-ps").value = data["leistung"].replace("PS", "");
          document.getElementById("kundendaten-fueltype").value = data["fuel"];
          
        } else {
          document.getElementById("number-error").classList.toggle("hidden");
        }
      
      savedPOST();
    });
  }

  let lastSelectDeviceInfo = "";
  function getDeviceInfos(device) {
    loadData();

      document.getElementById("device-row-"+device).classList.toggle("bg-blue-100");
      if(document.getElementById("device-row-"+lastSelectDeviceInfo)) {
          document.getElementById("device-row-"+lastSelectDeviceInfo).classList.toggle("bg-blue-100");
      }
      selectKundendatenDevice(device);

      lastSelectDeviceInfo = device;
  }

  let hiddenTexts = []
  let oldPrimary = "";
  let selectedUsersPhone = [];
  let selectedUsersStatus = [];
  let selectedUsersdokumente = [];

  function showOrderChangeModal(id) {
        loadData();
        lastHeadTab = "Kundendaten";
        lastHistorieTab = "all";
        userPhoneDays = [];
        userPhoneTimes = new Map();
        settedPhoneHours = [];
        selectedDate = "";
        picker = null;
        hiddenTexts = [];
        lastAuftragTab = "placeholder";
        selectedUsersPhone = [];
        selectedUsersStatus = [];
        selectedUsersdokumente = [];
        lastSelectDeviceInfo = "";


        $.get("{{url('/')}}/crm/auftrag/bearbeiten-"+id, function(data) {

          $('#changeorder').html(data);

          $.get("{{url("/")}}/crm/auftrag/buchhaltung-view-"+id, function(data) {
            $("#Buchhaltung").html(data);
            $('#neue-position-form').ajaxForm(function(data) { 
              document.getElementById("neue-rechnung-positions").innerHTML = data; 
              savedPOST(); 
            });
            $('#neue-rechnung-form').ajaxForm(function(data) { 
              document.getElementById("buchhaltung-table-div").innerHTML = data; 
              savedPOST(); 
            });
            $('#neue-audio-form').ajaxForm(function(data) { 
              savedPOST(); 
            });
            
          });

      
          $.get("{{url("/")}}/crm/auftrag/auftragsverlauf-view-"+id, function(data) {
            $("#Auftragsverlauf").html(data);
            document.getElementById("auftrag-filter").value = "";


            $('#auftragstext-form-new').ajaxForm(function(data) { 
              updateVerlauf(data);

              document.getElementById("status-auftrag-text").innerHTML = "Status";
              document.getElementById("tracking-auftrag-text").innerHTML = "Tracking";
              document.getElementById("zuweisung-auftrag-text").innerHTML = "Zuweisung";
              document.getElementById("auftrag-textarea").innerHTML = "";
              document.getElementById("auftrag-textarea").value = "";
              document.getElementById("selected-zuweisung-dokumente-inputs").innerHTML  = "";
              document.getElementById("cc-auftrag").value                             = "";
              document.getElementById("bcc-auftrag").value                            = "";
              document.getElementById("subject-new-auftrag").value                    = "";
              document.getElementById("zuweisung-auftrag-days").value                 = "";
              document.getElementById("auftrag-email-p").innerHTML                    = "E-Mail";
              document.getElementById("filename-email-auftrag").innerHTML            = "";
              document.getElementById("auftrag-email-remove").classList.add("hidden");
              $('#text-new-email-auftrag').trumbowyg("html", "");

              selectedUsers.forEach(user => {
                  document.getElementById("zuweisung-auftrag-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-auftrag-check-"+user).classList.add("hidden");
                });
                selectedUsers = [];

              document.getElementById("status-head-p").innerHTML = document.getElementById("extra-status-auftrag").options[document.getElementById("extra-status-auftrag").selectedIndex].text

             });

             $('#telefontext-form').ajaxForm(function(data) { 
                loadData();
                document.getElementById("status-head-p").innerHTML = document.getElementById("status-veraluf-neuer-status-select").options[document.getElementById("status-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("phone-textarea").value = "";
                
                document.getElementById("phone-textarea-email").value = "";
                document.getElementById("phone-tracking-input").value = "";
                document.getElementById("phone-textarea").value = "";
                document.getElementById("phone-talked-to").value = "";
                document.getElementById("status-call-text-main").innerHTML = "Status buchen";
                document.getElementById("tracking-phone-text").innerHTML = "Tracking";
                document.getElementById("zuweisung-phone-text").innerHTML = "Zuweisung";
                document.getElementById("cc-phone").value                             = "";
                document.getElementById("bcc-phone").value                            = "";
                document.getElementById("subject-new-phone").value                    = "";
                document.getElementById("zuweisung-phone-days").value                 = "";
                document.getElementById("phone-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-phone").innerHTML             = "";
                document.getElementById("phone-email-remove").classList.add("hidden");
              $('#text-new-email-phone').trumbowyg("html", "");
                $('#phone-textarea-email').trumbowyg("html", "");

                selectedUsersPhone.forEach(user => {
                  document.getElementById("zuweisung-phone-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-phone-check-"+user).classList.add("hidden");
                });
                selectedUsersPhone = [];

                updateVerlauf(data);
             });

             $('#dokumente-upload-new-form').ajaxForm(function(data) { 
                loadData();

                document.getElementById("status-head-p").innerHTML                        = document.getElementById("dokumente-veraluf-neuer-status-select").options[document.getElementById("dokumente-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("dokumente-veraluf-neuer-status-select").value    = "";
                document.getElementById("dokumente-textarea").value                       = "";
                document.getElementById("dokumente-textarea-email").value                 = "";
                document.getElementById("dokumente-tracking-input").value                 = "";
                document.getElementById("dokumente-textarea").value                       = "";
                document.getElementById("tracking-dokumente-text").innerHTML              = "Tracking";
                document.getElementById("zuweisung-dokumente-text").innerHTML             = "Zuweisung";
                document.getElementById("status-dokumente-text").innerHTML                = "Status";
                document.getElementById("dokumente-p").innerHTML                          = document.getElementById("dokumente-p-backup").innerHTML;
                document.getElementById("dokumente-type-select").value                    = "";
                document.getElementById("selected-zuweisung-dokumente-inputs").innerHTML  = "";
                document.getElementById("cc-dokumente").value                             = "";
                document.getElementById("bcc-dokumente").value                            = "";
                document.getElementById("subject-new-dokumente").value                    = "";
                document.getElementById("zuweisung-dokumente-days").value                 = "";
                document.getElementById("dokumente-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-dokumente").innerHTML             = "";
                document.getElementById("dokumente-email-remove").classList.add("hidden");

                selectedUsersdokumente.forEach(user => {
                  document.getElementById("zuweisung-dokumente-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-dokumente-check-"+user).classList.add("hidden");
                });
                selectedUsersdokumente = [];
                

                $('#text-new-email-dokumente').trumbowyg("html", "");

                filterauftrag("6646", "");
             });
             
             
             $('#statuses-form').ajaxForm(function(data) { 
                loadData();
                updateVerlauf(data);

                document.getElementById("status-head-p").innerHTML = document.getElementById("status-veraluf-neuer-status-select").options[document.getElementById("status-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("status-veraluf-neuer-status-select").value = "";
                document.getElementById("status-textarea").value = "";
                document.getElementById("status-textarea-email").value = "";
                document.getElementById("status-tracking-input").value = "";
                document.getElementById("status-textarea").value = "";
                document.getElementById("tracking-status-text").innerHTML = "Tracking";
                document.getElementById("zuweisung-status-text").innerHTML = "Zuweisung";
                document.getElementById("cc-statuse").value                             = "";
                document.getElementById("bcc-statuse").value                            = "";
                document.getElementById("subject-new-statuse").value                    = "";
                document.getElementById("zuweisung-status-days").value                 = "";
                document.getElementById("statuse-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-statuse").innerHTML             = "";
                document.getElementById("statuse-email-remove").classList.add("hidden");

                selectedUsersStatus.forEach(user => {
                  document.getElementById("zuweisung-status-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-status-check-"+user).classList.add("hidden");
                });
                selectedUsersStatus = [];
                $('#text-new-email-statuse').trumbowyg("html", "");

                $('#statuse-textarea-email').trumbowyg("html", "");
                if(document.getElementById("email-vorlage-button").classList.contains("bg-blue-50")) {
                  document.getElementById("email-vorlage-button").click();
                }
             });
             
             $('#neue-position-form').ajaxForm(function(data) { 
              document.getElementById("neue-rechnung-positions").innerHTML = data; 
              savedPOST(); 
            });
            $('#neue-rechnung-form').ajaxForm(function(data) { 
              document.getElementById("buchhaltung-table-div").innerHTML = data; 
              savedPOST(); 
            });

             
              if(document.getElementById("packtisch-abholauftrag-form")) {
                $('#packtisch-abholauftrag-form').ajaxForm(function(data) { 
                  newAlert("Erfolg!", "Abholauftrag wurde erfolgreich erstellt");
                  updateVerlauf(data);
                });
              }

              if(document.getElementById("packtisch-fotoauftrag-form")) {
                $('#packtisch-fotoauftrag-form').ajaxForm(function(data) { 
                  newAlert("Erfolg!", "Fotoauftrag wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  document.getElementById("fotoauftrag-info").value = "";
                  deselectAllDevicesFotoauftrag();

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-umlagerungsauftrag-form")) {
                $('#packtisch-umlagerungsauftrag-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Umlagerungsauftrag wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  document.getElementById("umlagerungsauftrag-info").value = "";

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-entsorgung-form")) {
                $('#packtisch-entsorgung-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Umlagerungsauftrag wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  document.getElementById("entsorgungsauftrag-info").value = "";

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-nachforschungsauftrag-form")) {
                $('#packtisch-nachforschungsauftrag-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Nachforschungsauftrag wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  document.getElementById("nachforschungsauftrag-info").value = "";
                  deselectAllnachforschungDevices();
                  

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-versand-kunde-form")) {
                $('#packtisch-versand-kunde-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Versandauftrag (Kunde) wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-versand-techniker-form")) {
                $('#packtisch-versand-techniker-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Versandauftrag (Techniker) wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  savedPOST();
                });
              }

              if(document.getElementById("packtisch-hinweis-form")) {
                $('#packtisch-hinweis-form').ajaxForm(function(data) {
                  newAlert("Erfolg!", "Hinweis wurde erfolgreich erstellt");
                  updateVerlauf(data);

                  savedPOST();
                });
              }

            
          });

          $.get("{{url("/")}}/crm/auftrag/devicelist-view-"+id, function(data) {
            $("#devicelist").html(data);
            getDeviceInfos(document.getElementById("firstdevice").value);

          });

          document.getElementById("extend-search-div").classList.add("hidden");
          
          $.get("{{url("/")}}/crm/workflow-auftrag-"+id, function(data) {
            $("#workflow-manager").html(data);
          })



          savedPOST();



          $('#kundendaten-form').ajaxForm(function() { savedPOST(); });

          if(document.getElementById("kundendaten-bpz-form")) {
            $('#kundendaten-bpz-form').ajaxForm(function() { updateVerlauf(document.getElementById("process_id").value); });
          }


          picker = flatpickr("#datepicker-div", {
            wrap: true,
            dateFormat: "d.m.Y",
            "locale": "de",
            time_24hr: true,
            static: true,
            disableCustom: userPhoneDays,
            closeOnSelect: false,
            onChange: function(selectedDates, dateStr, instance) {

                selectedDate = dateStr;

                document.getElementById('datetimepicker-time').classList.remove('hidden');

                if(settedPhoneHours.length != 0) {
                    settedPhoneHours.forEach(time => {
                        document.getElementById('datepicker-time-'+time).classList.remove('bg-red-200');
                    });
                }
                settedPhoneHours = [];
                userPhoneTimes.get(dateStr).forEach(time => {
                        document.getElementById('datepicker-time-'+time).classList.add("bg-red-200");
                        settedPhoneHours.push(time);
                });
            }
        });

          initializeKundenSendBack();
          
          $('#auftragstext-form-new').ajaxForm(function(data) { 
              updateVerlauf(data);

              document.getElementById("status-auftrag-text").innerHTML = "Status";
              document.getElementById("tracking-auftrag-text").innerHTML = "Tracking";
              document.getElementById("zuweisung-auftrag-text").innerHTML = "Zuweisung";
              document.getElementById("auftrag-textarea").innerHTML = "";
              document.getElementById("auftrag-textarea").value = "";
              document.getElementById("selected-zuweisung-dokumente-inputs").innerHTML  = "";
              document.getElementById("cc-auftrag").value                             = "";
              document.getElementById("bcc-auftrag").value                            = "";
              document.getElementById("subject-new-auftrag").value                    = "";
              document.getElementById("zuweisung-auftrag-days").value                 = "";
              document.getElementById("auftrag-email-p").innerHTML                    = "E-Mail";
              document.getElementById("filename-email-auftrag").innerHTML            = "";
              document.getElementById("auftrag-email-remove").classList.add("hidden");
              $('#text-new-email-auftrag').trumbowyg("html", "");

              selectedUsers.forEach(user => {
                  document.getElementById("zuweisung-auftrag-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-auftrag-check-"+user).classList.add("hidden");
                });
                selectedUsers = [];

              document.getElementById("status-head-p").innerHTML = document.getElementById("extra-status-auftrag").options[document.getElementById("extra-status-auftrag").selectedIndex].text

             });

             $('#telefontext-form').ajaxForm(function(data) { 
                loadData();
                document.getElementById("status-head-p").innerHTML = document.getElementById("status-veraluf-neuer-status-select").options[document.getElementById("status-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("phone-textarea").value = "";
                
                document.getElementById("phone-textarea-email").value = "";
                document.getElementById("phone-tracking-input").value = "";
                document.getElementById("phone-textarea").value = "";
                document.getElementById("phone-talked-to").value = "";
                document.getElementById("status-call-text-main").innerHTML = "Status buchen";
                document.getElementById("tracking-phone-text").innerHTML = "Tracking";
                document.getElementById("zuweisung-phone-text").innerHTML = "Zuweisung";
                document.getElementById("cc-phone").value                             = "";
                document.getElementById("bcc-phone").value                            = "";
                document.getElementById("subject-new-phone").value                    = "";
                document.getElementById("zuweisung-phone-days").value                 = "";
                document.getElementById("phone-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-phone").innerHTML             = "";
                document.getElementById("phone-email-remove").classList.add("hidden");
              $('#text-new-email-phone').trumbowyg("html", "");
                $('#phone-textarea-email').trumbowyg("html", "");

                selectedUsersPhone.forEach(user => {
                  document.getElementById("zuweisung-phone-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-phone-check-"+user).classList.add("hidden");
                });
                selectedUsersPhone = [];

                updateVerlauf(data);
             });

             $('#dokumente-upload-new-form').ajaxForm(function(data) { 
                loadData();

                document.getElementById("status-head-p").innerHTML                        = document.getElementById("dokumente-veraluf-neuer-status-select").options[document.getElementById("dokumente-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("dokumente-veraluf-neuer-status-select").value    = "";
                document.getElementById("dokumente-textarea").value                       = "";
                document.getElementById("dokumente-textarea-email").value                 = "";
                document.getElementById("dokumente-tracking-input").value                 = "";
                document.getElementById("dokumente-textarea").value                       = "";
                document.getElementById("tracking-dokumente-text").innerHTML              = "Tracking";
                document.getElementById("zuweisung-dokumente-text").innerHTML             = "Zuweisung";
                document.getElementById("status-dokumente-text").innerHTML                = "Status";
                document.getElementById("dokumente-p").innerHTML                          = document.getElementById("dokumente-p-backup").innerHTML;
                document.getElementById("dokumente-type-select").value                    = "";
                document.getElementById("selected-zuweisung-dokumente-inputs").innerHTML  = "";
                document.getElementById("cc-dokumente").value                             = "";
                document.getElementById("bcc-dokumente").value                            = "";
                document.getElementById("subject-new-dokumente").value                    = "";
                document.getElementById("zuweisung-dokumente-days").value                 = "";
                document.getElementById("dokumente-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-dokumente").innerHTML             = "";
                document.getElementById("dokumente-email-remove").classList.add("hidden");

                selectedUsersdokumente.forEach(user => {
                  document.getElementById("zuweisung-dokumente-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-dokumente-check-"+user).classList.add("hidden");
                });
                selectedUsersdokumente = [];
                

                $('#text-new-email-dokumente').trumbowyg("html", "");

                filterauftrag("6646", "");
             });

              
             $('#statuses-form').ajaxForm(function(data) { 
                loadData();
                updateVerlauf(data);

                document.getElementById("status-head-p").innerHTML = document.getElementById("status-veraluf-neuer-status-select").options[document.getElementById("status-veraluf-neuer-status-select").selectedIndex].text
                document.getElementById("status-veraluf-neuer-status-select").value = "";
                document.getElementById("status-textarea").value = "";
                document.getElementById("status-textarea-email").value = "";
                document.getElementById("status-tracking-input").value = "";
                document.getElementById("status-textarea").value = "";
                document.getElementById("tracking-status-text").innerHTML = "Tracking";
                document.getElementById("zuweisung-status-text").innerHTML = "Zuweisung";
                document.getElementById("cc-statuse").value                             = "";
                document.getElementById("bcc-statuse").value                            = "";
                document.getElementById("subject-new-statuse").value                    = "";
                document.getElementById("zuweisung-status-days").value                 = "";
                document.getElementById("statuse-email-p").innerHTML                    = "E-Mail";
                document.getElementById("filename-email-statuse").innerHTML             = "";
                document.getElementById("statuse-email-remove").classList.add("hidden");

                selectedUsersStatus.forEach(user => {
                  document.getElementById("zuweisung-status-div-"+user).classList.remove("bg-blue-100");
                  document.getElementById("zuweisung-status-check-"+user).classList.add("hidden");
                });
                selectedUsersStatus = [];

                $('#text-new-email-statuse').trumbowyg("html", "");
                if(document.getElementById("email-vorlage-button").classList.contains("bg-blue-50")) {
                  document.getElementById("email-vorlage-button").click();
                }
             });

             $('#neue-position-form').ajaxForm(function(data) { 
              document.getElementById("neue-rechnung-positions").innerHTML = data; 
              savedPOST(); 
            });
            $('#neue-rechnung-form').ajaxForm(function(data) { 
              document.getElementById("buchhaltung-table-div").innerHTML = data; 
              savedPOST(); 
            });

        });
      }

      @isset($changeOrder)
      showOrderChangeModal('{{$changeOrder}}');
      @endisset

      function updateVerlauf(id, disable = null) {    
        loadData();    
        $.get("{{url("/")}}/crm/interessenten/get-verlauf-auftrag-"+id, function(data) {
         $("#auftragstext-div").html(data);
         savedPOST();
        });
      }



      function saveNewStatus() {

        let status = document.getElementById('extra-status-main').value;

        document.getElementById('status-call-text-main').innerHTML = status;
        document.getElementById("extra-status-div").classList.add('hidden')

      }

       document.addEventListener("click", (evt) => {
        const flyoutEl = document.getElementById("orders-filter-dropdown");
        let targetEl = evt.target; // clicked element    ^
      
        do {
          if(targetEl == flyoutEl) {
            // This is a click inside, does nothing, just return.
          }
          // Go up the DOM
          targetEl = targetEl.parentNode;
        } while (targetEl);
        // This is a click outside. 
          var motherDiv =document.getElementById('order-filter-div');


            if(document.getElementById("zeiterfassung-dropdown-div-main")) {
              if(!isDescendant(document.getElementById("zeiterfassung-dropdown-div-main"), evt.target)) {
                document.getElementById("zeiterfassung-dropdown-div-main").classList.add("hidden");
                document.getElementById("zeiterfassung-top").classList.add("cursor-pointer");
                document.getElementById("zeiterfassung-top").setAttribute("onclick", "getZeiterfassung('{{auth()->user()->id}}')");
              } 
            }
            
            if(document.getElementById("texts-div-phone")) {
              if(!isDescendant(document.getElementById("texts-div-phone-main"), evt.target)) {
                document.getElementById('texts-div-phone').classList.add('hidden');
              }
            }

            if(document.getElementById("zusammenfassen-button")) {

              if(!isDescendant(document.getElementById("warenausgang-table"), evt.target)) {
                let counter = 1;
                document.getElementById("zusammenfassen-button-main").checked = false;

                while(counter < 1000) {
                  if(document.getElementById("zusammenfassen-button-"+counter)) {

                    document.getElementById("zusammenfassen-button-"+counter).checked = false;
                  } else {

                    break;
                  }
                  counter++;
                }

                document.getElementById("zusammenfassen-button").classList.add("hidden");
              }
              if(!isDescendant(document.getElementById("sliderhistory"), evt.target)) {
                document.getElementById("historie-slider").classList.add("hidden");
              }
            }

            

            if (document.getElementById("auftrag-filter-div")) {
              if (!isDescendant(document.getElementById("auftrag-filter-div"), evt.target) && !isDescendant(document.getElementById("auftrag-filter-svg"), evt.target)) {
                document.getElementById('auftrag-filter-div').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-telefon-div")) {
              if (!isDescendant(document.getElementById("zuweisung-telefon-main"), evt.target)) {
                document.getElementById('zuweisung-telefon-div').classList.add('hidden');
              }
            }

            if (document.getElementById("extra-status-div-call")) {
              if (!isDescendant(document.getElementById("extra-status-div-main-call"), evt.target)) {
                document.getElementById('extra-status-div-call').classList.add('hidden');
              }
            }

            if (document.getElementById("tracking-div-call")) {
              if (!isDescendant(document.getElementById("tracking-div-main-call"), evt.target)) {
                document.getElementById('tracking-div-call').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-telefon-div-call")) {
              if (!isDescendant(document.getElementById("zuweisung-call-main"), evt.target)) {
                document.getElementById('zuweisung-telefon-div-call').classList.add('hidden');
              }
            }

            if (document.getElementById("texts-div-auftrag")) {
              if (!isDescendant(document.getElementById("texts-div-auftrag-main"), evt.target)) {
                document.getElementById('texts-div-auftrag').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-auftrag-div")) {
              if (!isDescendant(document.getElementById("zuweisung-auftrag-main"), evt.target)) {
                document.getElementById('zuweisung-auftrag-div').classList.add('hidden');
              }
            }

            if (document.getElementById("tracking-div-auftrag")) {
              if (!isDescendant(document.getElementById("tracking-div-auftrag-main"), evt.target)) {
                document.getElementById('tracking-div-auftrag').classList.add('hidden');
              }
            }

            if (document.getElementById("extra-status-div-auftrag")) {
              if (!isDescendant(document.getElementById("extra-status-div-auftrag-main"), evt.target)) {
                document.getElementById('extra-status-div-auftrag').classList.add('hidden');
              }
            }

            if (document.getElementById("tracking-div-status")) {
              if (!isDescendant(document.getElementById("tracking-div-status-main"), evt.target)) {
                document.getElementById('tracking-div-status').classList.add('hidden');
              }
            }

            if (document.getElementById("emailvorlage-div-status")) {
              if (!isDescendant(document.getElementById("emailvorlagen-main-status"), evt.target)) {
                document.getElementById('emailvorlage-div-status').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-telefon-div-call")) {
              if (!isDescendant(document.getElementById("zuweisung-call-main"), evt.target)) {
                document.getElementById('zuweisung-telefon-div-call').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-status-div-status")) {
              if (!isDescendant(document.getElementById("zuweisung-status-main"), evt.target)) {
                document.getElementById('zuweisung-status-div-status').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-auftrag-div-auftrag")) {
              if (!isDescendant(document.getElementById("zuweisung-auftrag-main"), evt.target)) {
                document.getElementById('zuweisung-auftrag-div-auftrag').classList.add('hidden');
              }
            }

            if (document.getElementById("zuweisung-dokumente-div-dokumente")) {
              if (!isDescendant(document.getElementById("zuweisung-dokumente-main"), evt.target)) {
                document.getElementById('zuweisung-dokumente-div-dokumente').classList.add('hidden');
              }
            }

            if (document.getElementById("status-buche-div")) {
              if (!isDescendant(document.getElementById("status-buche-div"), evt.target)) {
                document.getElementById('status-email-dropdown').classList.add('hidden');
              }
            }

            if (document.getElementById("tracking-div-dokumente-main")) {
              if (!isDescendant(document.getElementById("tracking-div-dokumente-main"), evt.target)) {
                document.getElementById('tracking-div-dokumente').classList.add('hidden');
              }
            }

            if (document.getElementById("texts-div-dokumente-main")) {
              if (!isDescendant(document.getElementById("texts-div-dokumente-main"), evt.target)) {
                document.getElementById('texts-div-dokumente').classList.add('hidden');
              }
            }

            if (document.getElementById("extra-status-div-dokumente-main")) {
              if (!isDescendant(document.getElementById("extra-status-div-dokumente-main"), evt.target)) {
                document.getElementById('extra-status-div-dokumente').classList.add('hidden');
              }
            }

            if(document.getElementById("kundendaten-filter-main-div")) {
              if (!isDescendant(document.getElementById("kundendaten-filter-main-div"), evt.target)) {
                document.getElementById('kunden-filter-div').classList.add('hidden');
              }
            }
            
       });

      function isDescendant(parent, child) {
         var node = child.parentNode;
         while (node != null) {
             if (node == parent) {
                 return true;
             }
             node = node.parentNode;
         }
         return false;
      }
      

    function zuweisungPhoneAddUser(id) {
        document.getElementById("zuweisung-phone-div-"+id).classList.toggle('bg-blue-100');
        document.getElementById('zuweisung-phone-check-'+id).classList.toggle('hidden');

        if (selectedUsersPhone.includes(id)) {
          selectedUsersPhone = selectedUsersPhone.filter(e => e !== id);
        } else {
          selectedUsersPhone.push(id);
        }
    }

    function zuweisungstatusAddUser(id) {
        document.getElementById("zuweisung-status-div-"+id).classList.toggle('bg-blue-100');
        document.getElementById('zuweisung-status-check-'+id).classList.toggle('hidden');

        if (selectedUsersStatus.includes(id)) {
          selectedUsersStatus = selectedUsersStatus.filter(e => e !== id);
        } else {
          selectedUsersStatus.push(id);
        }
    }

    function zuweisungdokumenteAddUser(id) {
        document.getElementById("zuweisung-dokumente-div-"+id).classList.toggle('bg-blue-100');
        document.getElementById('zuweisung-dokumente-check-'+id).classList.toggle('hidden');

        if (selectedUsersdokumente.includes(id)) {
          selectedUsersdokumente = selectedUsersdokumente.filter(e => e !== id);
        } else {
          selectedUsersdokumente.push(id);
        }
    }
</script>

<script>
  var optionsKundendaten = {
         error: function() {
             let title = "Unbekannter Fehler!";
             let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte schau das du mindestens eine Addresse ausgewählt hast.";
             savedPOST();
         },
         success: function() {
             let title = "Kundenstammdaten geändert!";
             let text = "Kundenstammdaten wurden erfolgreich geändert.";
             savedPOST();
         }
     };
 
 
 
  
 
     var optionsBPZs = {
         error: function() {
             let title = "Unbekannter Fehler!";
             let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte gebe dies deinem Teamleiter weiter";
             savedPOST();

         },
         success: function() {
             let title = "Beipackzettel Informationen gespeichert!";
             let text = "Beipackzettel Informationen wurden gepspeichert!";
             savedPOST();
         }
     };
 
     function checkBPZUpload(id) {
 
         let device = document.getElementById("kundendaten-selected-device").value;
 
         $.get("{{url("/")}}/crm/order/check-bpz-"+id+"-"+device, function(data) {

                 
              if(window.submitDevice) {
                document.getElementById("bpz-submit").click();

                if(usedInput != "" && usedInput != "undefined" && usedInput != null) {
                  submitDevice("awd", usedInput);
                }

                $.get("{{url("/")}}/crm/auftrag/devicelist-view-"+id, function(data) {
                  $("#devicelist").html(data);
                  savedPOST();
                  if(bpz == false) {
                    newAlert("Daten gespeichert!", "Die Kundendaten/Gerätedaten wurden erfolgreich gespeichert.");
                  }
                });
              } else {
                savedPOST();
                if(bpz == false) {
                  newAlert("Daten gespeichert!", "Die Kundendaten wurden erfolgreich gespeichert.");
                  }
              }
              if(document.getElementById("hinweis-edit-svg").classList.contains("hidden")) {
                  changeHinweisEditMode();
              }
                 savedPOST();
             
         });
     }
 
     function bpzNewFile() {
         document.getElementById("bpz-newfile-inp").value = document.getElementById("bpz-newfile-name").value;
         document.getElementById("bpz-submit").click();
    
         document.getElementById("checkbpz-modal").classList.add("hidden");

         newAlert("Daten gespeichert!", "Die Kundendaten/Gerätedaten wurden erfolgreich gespeichert.");
         
     } 
 
     function toggleKundendatenFahrzeuginformationen() {
 
         let data = document.getElementById("kundendaten-carinformation-state");
         
         if(data.value == "true") {
             document.getElementById("kundendaten-carinfo").classList.remove("bg-blue-600");
             document.getElementById("kundendaten-carinfo").classList.add("bg-gray-200");
             document.getElementById("kundendaten-carinfo-span").classList.remove("translate-x-5");
             document.getElementById("kundendaten-carinfo-span").classList.add("translate-x-0");
 
             data.value = "false";
         } else {
             document.getElementById("kundendaten-carinfo").classList.add("bg-blue-600");
             document.getElementById("kundendaten-carinfo").classList.remove("bg-gray-200");
             document.getElementById("kundendaten-carinfo-span").classList.add("translate-x-5");
             document.getElementById("kundendaten-carinfo-span").classList.remove("translate-x-0");
             data.value = "true";
         }
     }
 
     function toggleKundendatenFehlerspeicher() {
 
         let data = document.getElementById("kundendaten-carcache-state");
 
         if(data.value == "true") {
             document.getElementById("kundendaten-carcache").classList.remove("bg-blue-600");
             document.getElementById("kundendaten-carcache").classList.add("bg-gray-200");
             document.getElementById("kundendaten-carcache-span").classList.remove("translate-x-5");
             document.getElementById("kundendaten-carcache-span").classList.add("translate-x-0");
         
             data.value = "false";
         } else {
             document.getElementById("kundendaten-carcache").classList.add("bg-blue-600");
             document.getElementById("kundendaten-carcache").classList.remove("bg-gray-200");
             document.getElementById("kundendaten-carcache-span").classList.add("translate-x-5");
             document.getElementById("kundendaten-carcache-span").classList.remove("translate-x-0");
             data.value = "true";
         }
     }

     let bpz = false;
     function saveAll(id) {
        loadData(); 
        bpz = false;
        if(document.getElementById("bpz-submit")) {
          let resp = checkBPZUpload(id);
          if(resp == "stop") {
            bpz = true;
            return;
          }
        } else {
          savedPOST();
          newAlert("Daten gespeichert!", "Die Kundendaten wurden erfolgreich gespeichert.");
        }
        
    }
 
     function toggleKundendatenFehlernachricht() {
 
         let data = document.getElementById("kundendaten-carmessage-state");
 
         if(data.value == "true") {
             document.getElementById("kundendaten-carmessage").classList.remove("bg-blue-600");
             document.getElementById("kundendaten-carmessage").classList.add("bg-gray-200");
             document.getElementById("kundendaten-carmessage-span").classList.remove("translate-x-5");
             document.getElementById("kundendaten-carmessage-span").classList.add("translate-x-0");
         
             data.value = "false";
         } else {
             document.getElementById("kundendaten-carmessage").classList.add("bg-blue-600");
             document.getElementById("kundendaten-carmessage").classList.remove("bg-gray-200");
             document.getElementById("kundendaten-carmessage-span").classList.add("translate-x-5");
             document.getElementById("kundendaten-carmessage-span").classList.remove("translate-x-0");
             data.value = "true";
         }
     }
 
     function toggleKundendatenAnTechniker() {
 
         let data = document.getElementById("kundendaten-tecinfo-state");
         
         if(data.value == "true") {
             document.getElementById("kundendaten-tecinfo").classList.remove("bg-blue-600");
             document.getElementById("kundendaten-tecinfo").classList.add("bg-gray-200");
             document.getElementById("kundendaten-tecinfo-span").classList.remove("translate-x-5");
             document.getElementById("kundendaten-tecinfo-span").classList.add("translate-x-0");
         
             data.value = "false";
         } else {
             document.getElementById("kundendaten-tecinfo").classList.add("bg-blue-600");
             document.getElementById("kundendaten-tecinfo").classList.remove("bg-gray-200");
             document.getElementById("kundendaten-tecinfo-span").classList.add("translate-x-5");
             document.getElementById("kundendaten-tecinfo-span").classList.remove("translate-x-0");
             data.value = "true";
         }
     }
 
     function toggleAbweichendeAddresse() {
         document.getElementById("kundendaten-abweichende-lieferaddresse").classList.toggle("hidden");
 
     }
 
     @isset($kundendatenFirstDevice->component_number) 
         let lastKundendatenDevice = "{{$kundendatenFirstDevice->component_number}}";
     @else
         let lastKundendatenDevice = "";
     @endisset
 
     function selectKundendatenDevice(device) {
         
         $.get("{{url('/')}}/crm/auftrag-aktiv/bearbeiten-"+ device +"/get-devicedata", function(data) {
             for( var key in data ) {
                 if(document.getElementById("kundendaten-"+key)) {
                     document.getElementById("kundendaten-"+key).value = data[key];
                 }
                 if(key == "carinformation_state") {
                     let state = document.getElementById("kundendaten-carinformation-state");
 
                     if(data[key] == "true") {
                         document.getElementById("kundendaten-carinfo").classList.add("bg-blue-600");
                         document.getElementById("kundendaten-carinfo").classList.remove("bg-gray-200");
                         document.getElementById("kundendaten-carinfo-span").classList.add("translate-x-5");
                         document.getElementById("kundendaten-carinfo-span").classList.remove("translate-x-0");
 
                         state.value = "true";
                     } else {
                         document.getElementById("kundendaten-carinfo").classList.remove("bg-blue-600");
                         document.getElementById("kundendaten-carinfo").classList.add("bg-gray-200");
                         document.getElementById("kundendaten-carinfo-span").classList.remove("translate-x-5");
                         document.getElementById("kundendaten-carinfo-span").classList.add("translate-x-0");
 
                         state.value = "false";
                     }
                 }
 
                 if(key == "errormessage_state") {
                     let state = document.getElementById("kundendaten-carmessage-state");
 
                     if(data[key] == "true") {
                         document.getElementById("kundendaten-carmessage").classList.add("bg-blue-600");
                         document.getElementById("kundendaten-carmessage").classList.remove("bg-gray-200");
                         document.getElementById("kundendaten-carmessage-span").classList.add("translate-x-5");
                         document.getElementById("kundendaten-carmessage-span").classList.remove("translate-x-0");
 
                         state.value = "true";
                     } else {
                         document.getElementById("kundendaten-carmessage").classList.remove("bg-blue-600");
                         document.getElementById("kundendaten-carmessage").classList.add("bg-gray-200");
                         document.getElementById("kundendaten-carmessage-span").classList.remove("translate-x-5");
                         document.getElementById("kundendaten-carmessage-span").classList.add("translate-x-0");
 
                         state.value = "false";
                     }
                 }
 
                 if(key == "errorcache_state") {
                     let state = document.getElementById("kundendaten-carcache-state");
 
                     if(data[key] == "true") {
                         document.getElementById("kundendaten-carcache").classList.add("bg-blue-600");
                         document.getElementById("kundendaten-carcache").classList.remove("bg-gray-200");
                         document.getElementById("kundendaten-carcache-span").classList.add("translate-x-5");
                         document.getElementById("kundendaten-carcache-span").classList.remove("translate-x-0");
 
                         state.value = "true";
                     } else {
                         document.getElementById("kundendaten-carcache").classList.remove("bg-blue-600");
                         document.getElementById("kundendaten-carcache").classList.add("bg-gray-200");
                         document.getElementById("kundendaten-carcache-span").classList.remove("translate-x-5");
                         document.getElementById("kundendaten-carcache-span").classList.add("translate-x-0");
 
                         state.value = "false";
                     }
                 }
 
                 if(key == "tec_info_state") {
                     let state = document.getElementById("kundendaten-tecinfo-state");
 
                     if(data[key] == "true") {
                         document.getElementById("kundendaten-tecinfo").classList.add("bg-blue-600");
                         document.getElementById("kundendaten-tecinfo").classList.remove("bg-gray-200");
                         document.getElementById("kundendaten-tecinfo-span").classList.add("translate-x-5");
                         document.getElementById("kundendaten-tecinfo-span").classList.remove("translate-x-0");
 
                         state.value = "true";
                     } else {
                         document.getElementById("kundendaten-tecinfo").classList.remove("bg-blue-600");
                         document.getElementById("kundendaten-tecinfo").classList.add("bg-gray-200");
                         document.getElementById("kundendaten-tecinfo-span").classList.remove("translate-x-5");
                         document.getElementById("kundendaten-tecinfo-span").classList.add("translate-x-0");
 
                         state.value = "false";
                     }
                 }
                 document.getElementById("bpz-label-get").href = "{{url("/")}}/crm/label/get/"+device;
             }
             document.getElementById("bpz-edit-div").classList.remove("hidden");
             savedPOST();
 
             if(document.getElementById("device-div-kundendaten-"+lastKundendatenDevice)) {
              document.getElementById("device-div-kundendaten-"+lastKundendatenDevice).classList.remove("border-blue-400", "text-blue-500");
              document.getElementById("device-div-kundendaten-"+lastKundendatenDevice).classList.add("border-gray-300", "text-gray-500");
             }
             
             if(document.getElementById("kundendaten-device-svg-"+lastKundendatenDevice)) {
              document.getElementById("kundendaten-device-svg-"+lastKundendatenDevice).classList.add("hidden");
             }
             if(document.getElementById("kundendaten-device-svg-"+device)) {
              document.getElementById("kundendaten-device-svg-"+device).classList.remove("hidden");
             }
 
             document.getElementById("device-div-kundendaten-"+device).classList.add("border-blue-400", "text-blue-500");
             document.getElementById("device-div-kundendaten-"+device).classList.remove("border-gray-300", "text-gray-500");
 
             document.getElementById("kundendaten-selected-device").value = device;
             lastKundendatenDevice = device;
             document.getElementById("kundendaten-bpz-form").action = "{{url("/")}}/crm/auftrag-aktiv/bearbeiten-"+ device +"/beipackzettel-bearbeiten";

        
         });
 
     }
 
 
     
     function initializeKundenSendBack() {
 
 var input3 = document.getElementById('kundendaten-street');
 
 var autocomplete3 = new google.maps.places.Autocomplete(input3);
 
 autocomplete3.addListener('place_changed', function () {
 
   var place3 = autocomplete3.getPlace();
   
   let types = [];
   let names = [];
     
   place3.address_components.forEach(comp => {
       types.push(comp.types[0]);
       names.push(comp["long_name"]);
   });
 
   let counter = 0
   document.getElementById("kundendaten-street").value = "";
   document.getElementById("kundendaten-street_number").value = "";
   document.getElementById("kundendaten-city").value = "";
   document.getElementById("kundendaten-zipcode").value = "";
   document.getElementById("kundendaten-country").value = "";
   console.log(types);
   types.forEach(type => {
     let name = names[counter];
     if(type == "route") {
       let street    = name;
       document.getElementById("kundendaten-street").value = street;
     }
     if(type == "street_number") {
       let number    = name;
       document.getElementById("kundendaten-street_number").value = number;
     }
     if(type == "postal_town") {
       let city    = name;
       document.getElementById("kundendaten-city").value = city;
     }
     if(type == "locality") {
       let city    = name;
       document.getElementById("kundendaten-city").value = city;
     }
     if(type == "postal_code") {
       let zipcode    = name;
       document.getElementById("kundendaten-zipcode").value = zipcode;
     }
     if(type == "country") {
       let country    = name;
       document.getElementById("kundendaten-country").value = country;
     }
     counter++;
   });
 });
 
 
 var input4 = document.getElementById('kundendaten-back-street');
 
 var autocomplete4 = new google.maps.places.Autocomplete(input4);
 
 autocomplete4.addListener('place_changed', function () {
 
   var place4 = autocomplete4.getPlace();
   
   let types4 = [];
   let names4 = [];
     
   place4.address_components.forEach(comp => {
       types4.push(comp.types[0]);
       names4.push(comp["long_name"]);
   });
 
   let counter = 0
   document.getElementById("kundendaten-back-street").value = "";
   document.getElementById("kundendaten-back-street_number").value = "";
   document.getElementById("kundendaten-back-city").value = "";
   document.getElementById("kundendaten-back-zipcode").value = "";
   document.getElementById("kundendaten-back-country").value = "";
 
   types4.forEach(type => {
     let name = names4[counter];
     if(type == "route") {
       let street    = name;
       document.getElementById("kundendaten-back-street").value = street;
     }
     if(type == "street_number") {
       let number    = name;
       document.getElementById("kundendaten-back-street_number").value = number;
     }
     if(type == "postal_town") {
       let city    = name;
       document.getElementById("kundendaten-back-city").value = city;
     }
     if(type == "locality") {
       let city    = name;
       document.getElementById("kundendaten-back-city").value = city;
     }
     if(type == "postal_code") {
       let zipcode    = name;
       document.getElementById("kundendaten-back-zipcode").value = zipcode;
     }
     if(type == "country") {
       let country    = name;
       document.getElementById("kundendaten-back-country").value = country;
     }
     counter++;
   });
 });
     }
     
 </script>
<div id="placeholder">

</div>
<script>
  var lastAuftragTab = "placeholder";
  function changePacktischAuftrag(tab) {
      if(lastAuftragTab != tab) {
        document.getElementById(lastAuftragTab).classList.add("hidden");
        document.getElementById(tab).classList.remove("hidden");
        lastAuftragTab = tab;
      }
  }

  var lastHistorieTab = "all";
  function changeAuftraghistorieTab(tab) {

      if(tab != lastHistorieTab) {
        document.getElementById(tab+"-tab").classList.add("text-black", "bg-gray-300");
        document.getElementById(tab+"-tab").classList.remove("text-gray-600");

        document.getElementById(lastHistorieTab+"-tab").classList.remove("text-black", "bg-gray-300");
        document.getElementById(lastHistorieTab+"-tab").classList.add("text-gray-600");

        document.getElementById(tab+"-div").classList.remove("hidden");
        document.getElementById(lastHistorieTab+"-div").classList.add("hidden");

        if(tab != "historie") {
            document.getElementById("historie-div").classList.add("hidden");
        }
      }
      

      lastHistorieTab = tab;
  }

  let showHinweis = false;

  function changeHinweisEditMode(process_id) {
          if(document.getElementById("hinweis-finish-svg").classList.contains("hidden")) {
              document.getElementById("hinweis-edit-svg").classList.add("hidden");
              document.getElementById("hinweis-finish-svg").classList.remove("hidden");
              document.getElementById("hinweis-edit-text").classList.add("hidden");
              document.getElementById("hinweis-edit-svg").classList.add("hidden");
  
              document.getElementById("hinweis-edit-input").classList.remove("hidden");
  
              
          } else {
              document.getElementById("hinweis-edit-text").innerHTML = document.getElementById("hinweis-edit-input").value;
  
              document.getElementById("hinweis-edit-svg").classList.remove("hidden");
              document.getElementById("hinweis-finish-svg").classList.add("hidden");
              document.getElementById("hinweis-edit-text").classList.remove("hidden");
              document.getElementById("hinweis-edit-svg").classList.remove("hidden");
  
              document.getElementById("hinweis-edit-input").classList.add("hidden");
              
              if(document.getElementById("hinweis-edit-input").value == "") {
                  document.getElementById("hinweis").classList.add("hidden");
                  document.getElementById("hinweis-edit-input").classList.remove("hidden");
              } 
              
              let date = new Date().toLocaleDateString("de-DE");
  
              document.getElementById("hinweis-von-text").innerHTML = "von {{auth()->user()->username}} ("+date+")";
            
             
              let textVar = document.getElementById("hinweis-edit-input").value;
  
              $.post( "{{url("/")}}/crm/auftrag-hinweis-edit", { "_token": "{{ csrf_token() }}", id: process_id, text: textVar } );
  
              showHinweis = true;
          }
      }
      
      function deleteHinweis(process_id) {
          document.getElementById("hinweis-edit-input").value = "";
          document.getElementById("hinweis-edit-input").classList.remove("hidden");
          document.getElementById("hinweis-edit-text").innerHTML = "";
              document.getElementById("hinweis").classList.remove("pt-4", "mr-8", "pb-7");
              document.getElementById('hinweis').classList.add('hidden')
          showHinweis = false;
          $.post( "{{url("/")}}/crm/auftrag-hinweis-edit", { id: "process_id", text: "" } );
  
      }
  
      function showHideHinweis() {
        if(document.getElementById("hinweis").classList.contains("hidden")) {
              document.getElementById("hinweis").classList.add("pt-4", "mr-8", "pb-7");
              document.getElementById('hinweis').classList.remove('hidden')
              document.getElementById("hinweis-finish-svg").classList.add("hidden");
              document.getElementById("hinweis-edit-svg").classList.remove("hidden");
        } else {
          if(showHinweis == false) {
              document.getElementById("hinweis").classList.remove("pt-4", "mr-8", "pb-7");
              document.getElementById('hinweis').classList.add('hidden')
          }
        }
      }

  var lastHeadTab = "Kundendaten";
  var lastUpdatedDokumente = false;
  function changeHeadTab(tab) {

    if(lastHeadTab != tab) {
      document.getElementById(tab+"-button").classList.remove("text-black", "hover:border-blue-300", "hover:text-blue-500", "border-transparent");
      document.getElementById(tab+"-button").classList.add("border-blue-300", "text-blue-400",  "border-t-2", "border-b-2");
      document.getElementById(tab+"-svg").classList.add("text-blue-500");

      if(document.getElementById(tab+"-div")) {
        document.getElementById(tab+"-div").classList.remove("hidden");
      }
      if(document.getElementById(lastHeadTab+"-div")) {
        document.getElementById(lastHeadTab+"-div").classList.add("hidden");
      }
      
      document.getElementById(lastHeadTab+"-button").classList.add("text-black", "hover:border-blue-300", "hover:text-blue-500", "border-transparent");
      document.getElementById(lastHeadTab+"-button").classList.remove("border-blue-300", "text-blue-400", "border-t-2", "border-b-2");
      document.getElementById(lastHeadTab+"-svg").classList.remove("text-blue-500");

      if(document.getElementById(lastHeadTab)) {
        document.getElementById(lastHeadTab).classList.add("hidden");
      }
      if(document.getElementById(lastHeadTab+"-div-div")) {
        document.getElementById(lastHeadTab+"-div-div").classList.add("hidden");
      }
      if(document.getElementById(tab+"-div-div")) {
        document.getElementById(tab+"-div-div").classList.remove("hidden");
      }
      if(document.getElementById(tab)) {
        document.getElementById(tab).classList.remove("hidden");
      }
    }



      if(tab == "dokumente") {
        filterauftrag("6646", "");
        lastUpdatedDokumente = true;
      } else {
        if(lastHeadTab == "dokumente") {
          updateVerlauf(document.getElementById("process_id").value);
        }
      }
    

    if(tab != "Kundendaten") {
      document.getElementById("Auftragsverlauf").classList.remove("hidden");
    } else {
      document.getElementById("Auftragsverlauf").classList.add("hidden");
    }

    lastHeadTab = tab;
  }

  let detectedInput = false;

  document.body.addEventListener('keydown', function(e) {
    if(e.keyCode == 27) {
      if(detectedInput == false) {
        if(document.getElementById("auftrags-change")) {
          document.getElementById('auftrags-change').remove();
        }
        if(document.getElementById("email-inbox-div")) {
          document.getElementById("email-inbox-div").innerHTML = "";
        }
      } else {
        document.getElementById("esc-error-div").classList.remove('hidden');
        detectedInput = false;

        setTimeout(
          function() {
            document.getElementById("esc-error-div").classList.add('hidden');
          }, 1500);
      }
    }
  }, true);
</script>

<script>
  function searchTrackingnumber(inp, id) {
      loadData();
      if(inp == "") {
        inp = "all";
      }
      $.get("{{url("/")}}/crm/tracking/search-like-"+inp + "-"+id, function(data) {
          document.getElementById("tracking-table-list").innerHTML = data;
          savedPOST();
      })
  }

  function getSendungsverlaufTable(id, date) {
      loadData();
        $.get("{{url("/")}}/crm/tracking-get-history-"+id, function(datas) {
            if(datas.length != 0) {
                console.log(datas);
                var parent = document.getElementById("sendungsverlauf-liste");
                parent.innerHTML = "";

                if(typeof datas == "object") {
                  
                  datas = Object.entries(datas);
                }
                
                datas.forEach(data => {
                  saveD = data;
                  data = data[1];
                  if(data == null) {
                    data = saveD[0];
                  }
                    var html = '<li class="relative flex gap-x-4">  <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">    <div class="w-px bg-gray-200"></div>  </div>  <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>  </div>  <p class="flex-auto py-0.5 text-md leading-5 text-gray-500">'+ data["status"] +'</p>  <time datetime="2023-01-23T11:03" class="flex-none py-0.5 text-md leading-5 text-gray-500">'+ data["date"] +'</time></li>'
                    var div = document.createElement("div");
                    div.innerHTML = html;
                    parent.appendChild(div);
                });

                document.getElementById("sendungsverlauf-sendungsnummer").innerHTML = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-carrier").innerHTML               = datas[0][1]["carrier"];
                document.getElementById("tracking-trackingnumber").innerHTML        = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-created_at").innerHTML            = date;

                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ datas[0][1]["trackingnumber"];

                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("error-tracking").classList.add("hidden");
                document.getElementById("sendungsverlauf-div").classList.remove("hidden");

            } else {
                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ id;
                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("sendungsverlauf-div").classList.add("hidden");
                document.getElementById("error-tracking").classList.remove("hidden");

            }
            savedPOST();
        });
    }

    function hideText(id) {
      if(!document.getElementById("status-row-"+id).classList.contains("bg-gray-100")) {
        document.getElementById("status-row-"+id).classList.add("bg-gray-100");

        if(document.getElementById("status-eye-open").classList.contains("hidden")) {
          document.getElementById("status-row-"+id).classList.add("hidden");
        }
      } else {
        document.getElementById("status-row-"+id).classList.remove("bg-gray-100");
      }

      document.getElementById("status-column-eye-open-"+id).classList.toggle("hidden");
      document.getElementById("status-column-eye-close-"+id).classList.toggle("hidden");

      $.get("{{url("/")}}/crm/auftragsverlauf/hide-text-"+id, function(data) {
      })
    }

    function hideTextAuftrag(id) {
      if(!document.getElementById("auftrag-row-"+id).classList.contains("bg-gray-100")) {
        document.getElementById("auftrag-row-"+id).classList.add("bg-gray-100");

        if(document.getElementById("auftrag-eye-open").classList.contains("hidden")) {
          document.getElementById("auftrag-row-"+id).classList.add("hidden");
        }
      } else {
        document.getElementById("auftrag-row-"+id).classList.remove("bg-gray-100");
      }

      document.getElementById("auftrag-column-eye-open-"+id).classList.toggle("hidden");
      document.getElementById("auftrag-column-eye-close-"+id).classList.toggle("hidden");

      $.get("{{url("/")}}/crm/auftragsverlauf/hide-text-"+id, function(data) {
      })
    }
</script>
<script>$.trumbowyg.svgPath = '/icons.svg';</script>

<div id="dokumente-inspect">
</div>

<div id="versand-erweitert-modal">

</div>
<div id="verlauf-erweitert">

</div>
<div id="changeorder" onclick="checkToCloseModal(event)">

</div>










