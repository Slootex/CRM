<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "auftrag"])


    <div class="mx-auto max-w-full sm:px-6 lg:px-8 mt-10">
        <hr style="width: 100%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" >

       <h1 class="py-6 text-4xl font-bold  text-white"><span class="float-left">Einstellungen</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Mahneinstellungen</h1>
     <hr style="width: 100%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" class="m-auto">
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-10">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-0 sm:p-4">
              <table class="w-full">
                <thead>
                    <tr class="border border-t-0 border-l-0 border-r-0">
                        <td class="pr-6 text-left font-medium">Bezeichnung</td>
                        <td class="px-6 text-center font-medium">Mahnstufe</td>
                        <td class="px-6 text-center font-medium">Mahngebür</td>
                        <td class="px-6 text-center font-medium">Aktiviert</td>
                        <td class="px-6 text-center font-medium">Zahlungsfrist</td>
                        <td class="px-6 text-center font-medium">Aktion</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahneinstellungen->sortBy("mahnstufe") as $mahnung)
                    <tr>
                        <td class="py-2 pt-4 text-left"><span id="{{$mahnung->id}}-mahnung-bezeichnung">{{$mahnung->bezeichnung}}</span> <input type="text" id="{{$mahnung->id}}-mahnung-bezeichnung-input" class="hidden rounded-md w-60 h-6 border-gray-600"></td>
                        <td class="py-2 pt-4 text-center text-gray-600"><span id="{{$mahnung->id}}-mahnung-mahnstufe">{{$mahnung->mahnstufe}}</span> <input id="{{$mahnung->id}}-mahnung-mahnstufe-input" type="text" class="hidden rounded-md w-10 h-6 border-gray-600"></td>
                        <td class="py-2 pt-4 text-center text-gray-600"><span id="{{$mahnung->id}}-mahnung-mahngebuer">{{$mahnung->mahngebür}}€</span> <input id="{{$mahnung->id}}-mahnung-mahngebuer-input" type="text" class="hidden rounded-md w-16 h-6 border-gray-600"></td>
                        <td class="py-2 pt-4 text-center text-gray-600">
                        @if ($mahnung->activ == "Ja")

                        <span id="{{$mahnung->id}}-mahnung-aktiviert">
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-on" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-6 h-6 m-auto text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-off" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden w-6 h-6 m-auto text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>                              
                            <!-- Enabled: "bg-blue-600 hover:bg-blue-500", Not Enabled: "bg-gray-200" -->
                            <button type="button" id="{{$mahnung->id}}-mahnung-button" onclick="changeActive('{{$mahnung->id}}')" class="bg-blue-600 hover:bg-blue-500 hidden relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true" id="{{$mahnung->id}}-mahnung-span" class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>   
                            <input type="hidden" id="{{$mahnung->id}}-mahnung-active-input" value="Ja">                       
                        </span>
                        
                        @endif
                        @if ($mahnung->activ == "Nein")

                        <span id="{{$mahnung->id}}-mahnung-aktiviert">
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-on" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden w-6 h-6 m-auto text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-off" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 m-auto text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>                              
                            <!-- Enabled: "bg-blue-600 hover:bg-blue-500", Not Enabled: "bg-gray-200" -->
                            <button type="button" id="{{$mahnung->id}}-mahnung-button" onclick="changeActive('{{$mahnung->id}}')" class="bg-gray-200 hidden relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true" id="{{$mahnung->id}}-mahnung-span" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>   
                            <input type="hidden" id="{{$mahnung->id}}-mahnung-active-input" value="Nein">                       
                        </span>
                            
                        @endif
                        @if ($mahnung->activ == null)
                        
                        <span id="{{$mahnung->id}}-mahnung-aktiviert">
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-on" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden w-6 h-6 m-auto text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="{{$mahnung->id}}-mahnung-active-off" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 m-auto text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>                              
                            <!-- Enabled: "bg-blue-600 hover:bg-blue-500", Not Enabled: "bg-gray-200" -->
                            <button type="button" id="{{$mahnung->id}}-mahnung-button" onclick="changeActive('{{$mahnung->id}}')" class="bg-gray-200 hidden relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true" id="{{$mahnung->id}}-mahnung-span" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>   
                            <input type="hidden" id="{{$mahnung->id}}-mahnung-active-input" value="Nein">                       
                        </span>

                        @endif
                        </td>
                        <td class="py-2 pt-4 text-center text-gray-600"><span id="{{$mahnung->id}}-mahnung-zahlungsfirst">{{$mahnung->zahlungsfrist}}</span> <input id="{{$mahnung->id}}-mahnung-zahlungsfirst-input" type="text" class="hidden rounded-md w-10 h-6 border-gray-600"></td>
                        <td class="py-2 pt-4 text-center"><button type="button" class="text-blue-600" id="{{$mahnung->id}}-mahnung-bearbeiten" onclick="changeToEditMode('{{$mahnung->id}}')">Bearbeiten</button> <button type="button" class="hidden text-green-600" id="{{$mahnung->id}}-mahnung-speichern" onclick="saveMahnung('{{$mahnung->id}}')">Speichern</button></td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>

<script>
    function changeActive(id) {
        document.getElementById(id +'-mahnung-button').classList.toggle('bg-blue-600', 'hover:bg-blue-500');
        document.getElementById(id +'-mahnung-button').classList.toggle('bg-gray-200'); 
        document.getElementById(id +'-mahnung-span').classList.toggle('translate-x-5'); 
        document.getElementById(id +'-mahnung-span').classList.toggle('translate-x-0');

        if(document.getElementById(id +'-mahnung-button').classList.contains('bg-gray-200')) {
            document.getElementById(id +'-mahnung-active-input').value = "Nein";

        }
        if(document.getElementById(id +'-mahnung-button').classList.contains('bg-blue-600', 'hover:bg-blue-500')) {
            document.getElementById(id +'-mahnung-active-input').value = "Ja";
        }
        
    }

    function changeToEditMode(id) {
        document.getElementById(id +"-mahnung-bezeichnung").classList.add("hidden");
        document.getElementById(id +"-mahnung-mahnstufe").classList.add("hidden");
        document.getElementById(id +"-mahnung-mahngebuer").classList.add("hidden");
        document.getElementById(id +"-mahnung-zahlungsfirst").classList.add("hidden");
        document.getElementById(id +"-mahnung-bearbeiten").classList.add("hidden");

        document.getElementById(id +"-mahnung-bezeichnung-input").value =         document.getElementById(id +"-mahnung-bezeichnung").innerHTML;
        document.getElementById(id +"-mahnung-mahnstufe-input").value =         document.getElementById(id +"-mahnung-mahnstufe").innerHTML;
        document.getElementById(id +"-mahnung-mahngebuer-input").value =         document.getElementById(id +"-mahnung-mahngebuer").innerHTML;
        document.getElementById(id +"-mahnung-zahlungsfirst-input").value =         document.getElementById(id +"-mahnung-zahlungsfirst").innerHTML;
        document.getElementById(id +"-mahnung-speichern").value =               document.getElementById(id +"-mahnung-bearbeiten").innerHTML;

        document.getElementById(id +"-mahnung-button").classList.toggle('hidden');
        document.getElementById(id +"-mahnung-active-off").classList.add("hidden");
        document.getElementById(id +"-mahnung-active-on").classList.add("hidden");

        document.getElementById(id +"-mahnung-bezeichnung-input").classList.remove("hidden");
        document.getElementById(id +"-mahnung-mahnstufe-input").classList.remove("hidden");
        document.getElementById(id +"-mahnung-mahngebuer-input").classList.remove("hidden");
        document.getElementById(id +"-mahnung-zahlungsfirst-input").classList.remove("hidden");
        document.getElementById(id +"-mahnung-speichern").classList.remove("hidden");
    }
    var meta = document.createElement('meta');

    meta.httpEquiv = "csrf-token";
            meta.content = "{{ session()->token() }}";
    function saveMahnung(id) {

        bez =               document.getElementById(id +"-mahnung-bezeichnung-input").value;
        mahnstf =           document.getElementById(id +"-mahnung-mahnstufe-input").value;
        mahngeb =           document.getElementById(id +"-mahnung-mahngebuer-input").value;
        zahlfrst =          document.getElementById(id +"-mahnung-zahlungsfirst-input").value;
        activeinput =            document.getElementById(id +"-mahnung-active-input").value;


        document.getElementById(id +"-mahnung-bezeichnung").classList.remove("hidden");
        document.getElementById(id +"-mahnung-mahnstufe").classList.remove("hidden");
        document.getElementById(id +"-mahnung-mahngebuer").classList.remove("hidden");
        document.getElementById(id +"-mahnung-zahlungsfirst").classList.remove("hidden");
        document.getElementById(id +"-mahnung-bearbeiten").classList.remove("hidden");


        document.getElementById(id +"-mahnung-bezeichnung-input").classList.add("hidden");
        document.getElementById(id +"-mahnung-mahnstufe-input").classList.add("hidden");
        document.getElementById(id +"-mahnung-mahngebuer-input").classList.add("hidden");
        document.getElementById(id +"-mahnung-zahlungsfirst-input").classList.add("hidden");
        document.getElementById(id +"-mahnung-speichern").classList.add("hidden");

        document.getElementById(id +"-mahnung-button").classList.toggle('hidden');
        if(activeinput == "Ja") {
            document.getElementById(id +"-mahnung-active-off").classList.add("hidden");
            document.getElementById(id +"-mahnung-active-on").classList.remove("hidden");
        } else {
            document.getElementById(id +"-mahnung-active-off").classList.remove("hidden");
            document.getElementById(id +"-mahnung-active-on").classList.add("hidden");
        }

        document.getElementById(id +"-mahnung-bezeichnung").innerHTML = document.getElementById(id +"-mahnung-bezeichnung-input").value;
        document.getElementById(id +"-mahnung-mahnstufe").innerHTML = document.getElementById(id +"-mahnung-mahnstufe-input").value;
        document.getElementById(id +"-mahnung-mahngebuer").innerHTML = document.getElementById(id +"-mahnung-mahngebuer-input").value;
        document.getElementById(id +"-mahnung-zahlungsfirst").innerHTML = document.getElementById(id +"-mahnung-zahlungsfirst-input").value;

        $.post( "{{url("/")}}/crm/mahneinstellungen-neu", { mahnid: id, bezeichnung: bez, active: activeinput, mahnstufe: mahnstf, mahngebuer: mahngeb, zahlungsfrist: zahlfrst, '_token': $('meta[name=csrf-token]').attr('content') })
            .done(function( data ) {
              
            });

    }

</script>
</body>
</html>