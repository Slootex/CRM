<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    @vite('resources/js/app.js')


    @vite('resources/css/app.css')
</head>
<body>


    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    @isset($args)
      @include('includes.errors.'.$args[0])
    @endisset
    @isset($hinweise[0])
    <div class="px-8 pt-5">
      <div class="w-full mb-4 py-3 px-4 rounded-md bg-gray-900 font-semibold text-2xl ">
        @foreach ($hinweise as $hinweis)
        <div class="flex mt-2">
          <a href="{{url("/")}}/crm/hinweis-löschen-{{$hinweis->id}}" class="mt-1.5 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-100 hover:text-red-500 float-right">
              <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
            </svg>          
          </a>  
          <p style="color: {{$hinweis->color}}" class="">{{$hinweis->hinweis}}</p>
        </div>
        <p class="text-gray-500 ml-10 text-sm">von <span class="text-white">@if($employees->where("id", $hinweis->employee)->first() != null) {{$employees->where("id", $hinweis->employee)->first()->name}} @else {{$hinweis->employee}} @endif</span> am <span class="text-white">{{$hinweis->created_at->format("d.m.Y (H:i)")}}</span></p>
   
   
         @endforeach
       </div>
    </div>
  @endisset
    
      <div class="flex m-auto h-16 mt-16"> 
        <div  style="width: 53vw; margin-left: 29.4vw">
          <form action="{{url("/")}}/crm/packtisch/new-component" class="flex" method="POST">
            @CSRF
            <input type="text" name="barcode" placeholder="||||| Barcode" class="text-3xl  bg-blue-100 rounded-md h-16 text-center" style="width: 42vw">
            <div class="w-16 h-16 ml-4  mr-8">
              <input type="checkbox" name="at" onclick="document.getElementById('at-p').classList.toggle('hidden')" class="absolute w-16 h-16 rounded-md bg-blue-100 text-center">
              <p id="at-p" class="absolute text-gray-500 text-4xl ml-3 pt-0.5 mt-2 pointer-events-none">AT</p>
            </div>
          </form>
        </div>
        <div class="float-right absolute" style="right: 4rem">
          <div id="sliderhistory" class="inline-block float-right ">
            <button onclick="document.getElementById('historie-slider').classList.toggle('hidden')" class="bg-blue-600 hover:bg-blue-500 inline-block float-right rounded-md p-1 text-white font-semibold ml-4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>            
            </button>
            <div id="sliderhistory-main">

            </div>
          </div>
          
          <a href="{{url("/")}}/crm/packtisch/kein-barcode" class="bg-red-400 hover:bg-red-300 md:mt-8 sm:mt-4 lg:mt-0 inline-block float-right rounded-md py-5 px-4 text-white font-semibold" >Kein Barcode</a>
        </div>
      </div>
      
      
      <!--
      <div class="mt-6 w-full px-16">
        <div class="w-full bg-slate-900 rounded-lg shadow-md border border-slate-700 h-24 m-auto">
          <div class="float-left mt-8 ml-8">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
              <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
            </svg>            
          </div>
          <div class="float-left mt-4 pt-0.5 ml-4">
            <p class="font-bold text-3xl text-white">Bitte erst Warenausgang, dann Wareneingang</p>
            <p class="text-slate-600">geschrieben von <span class="font-medium text-white">Gazi Ahmad</span> am Samstag, 06.05.2023 (08:15 Uhr)</p>
          </div>
        </div>
      </div>
      
      -->
    <div class="px-14 w-full flex">
      <div class=" mt-3  @if($interns->count() == 0) hidden @endif" style="@if($ausgang->count() == 0) width: 100%; @else width: 42%; @endif ">
        <div class="py-4">
          <h1 class="text-black font-bold text-3xl">Aufträge</h1>
        </div>
        <div class="mt-1">
          <table class="bg-gray-100 rounded-md w-full">
            <thead>
              <tr class="">
                <td class="w-4"></td>
                <td class="font-semibold py-2 text-xl  pl-2">Erstellt</td>
                <td class="font-semibold py-2 text-center text-xl ">Auftrag</td>
                <td class="font-semibold py-2 text-center text-xl ">Gerät</td>
                <td class="font-semibold py-2 text-xl text-black">Kommentar</td>
                <td class="font-semibold py-2 text-xl  text-right pr-2">Aktion</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($interns->sortByDesc('created_at') as $intern)
                  <tr class="border border-l-0 border-r-0 bg-white">
                    <td>
                      <a href="{{url("/")}}/crm/packtisch/intern-bearbeiten-{{$intern->id}}" class="text-blue-600 hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left mr-2 ml-2">
                          <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                      </a>     
                    </td>
                    <td class="pl-2">{{$intern->created_at->format("d.m.Y")}}</td>
                    <td class=" text-center ">{{$intern->auftrag_id}}</td>
                    <td class=" text-center ">
                      @if (strlen($intern->process_id) == 5)
                      <button class="text-blue-400 hover:text-blue-200" onclick="showOrderChangeModal('{{$intern->process_id}}')">{{$intern->process_id}}</button>
                      @else
                      <p>{{$intern->process_id}} </p>
                      @endif
                      </td>
                    <td style="max-width: 12rem" class="overflow-hidden truncate">{{$intern->info}}</td>
                    <td>
                      @if ($intern->info != null && $intern->info != null)

                      <a href="{{url("/")}}/crm/packtisch/intern-bearbeiten-{{strtolower($intern->auftrag_id)}}/{{$intern->id}}" class="py-2 w-60 text-center rounded-sm bg-yellow-600 hover:bg-yellow-500 text-white font-semibold text-xl float-right mr-2">
                      {{$intern->auftrag_id}}
                      @else

                      <a href="{{url("/")}}/crm/packtisch/intern-bearbeiten-{{strtolower($intern->auftrag_id)}}/{{$intern->id}}" class="py-2 w-60 text-center rounded-sm bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xl float-right mr-2">
                      {{$intern->auftrag_id}}
                      @endif
                      </a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="@if($ausgang->count() == 0) hidden @endif @if($interns->count() == 0) mt-3 @else float-right absolute mr-14 mt-2 pt-0.5 right-0 @endif" style="@if($interns->count() == 0) width: 100%; @else width: 42%; @endif ">
        <div class="py-4 flex">
          <h1 class="text-black font-bold text-3xl inline-block">Warenausgang</h1>
          @isset(auth()->user()->roles[0])
            @if (auth()->user()->roles[0]->permissions->where("name", "stop.warenausgang")->first() != null)
            @if (auth()->user()->warenausgangsperre == "true")
            <a type="button" href="{{url("/")}}/crm/packtisch/warenausgang-entsperren">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 p-1 bg-slate-300 rounded-md inline-block text-green-600 ml-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>

            </a>
            @else
              <a type="button" href="{{url("/")}}/crm/packtisch/warenausgang-sperren">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor"  class="w-9 h-9 p-0.5 bg-slate-300 hover:bg-slate-500 rounded-md inline-block text-red-600 ml-4 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>

              </a>
          @endif
        @endif
          @endisset

          <div class="mt-2">
            <a href="{{url("/")}}/crm/warenausgang/pick-list" target="_blank" class="text-md text-black font-semibold px-4 py-2 rounded-md bg-slate-300 hover:bg-slate-500 ml-4">Pickliste</a>

          </div>
        </div>
        <div>
          <form action="{{url("/")}}/crm/techniker/zusammenfassen" method="POST">
            @CSRF
          <table class="bg-gray-100 rounded-md w-full " id="warenausgang-table">
            <thead>
              <tr class="">
                <td class="font-semibold py-2 text-xl w-24 pl-2"><input onclick="selectAllWarenausgang()" id="zusammenfassen-button-main" type="checkbox" class="rounded-sm w-4 h-4 float-left"> <button type="button" id="zusammenfassen-button" class="float-left px-2 py-1 rounded-md border hidden border-gray-600 text-lg font-medium absolute bg-gray-100 shadow-md">Zusammenfassen</button> </td>
                <td class="font-semibold py-2 text-left pl-2 text-xl ">Erstellt</td>
                <td class="font-semibold py-2 text-center text-xl ">Sortcut</td>
                <td class="font-semibold py-2 text-xl  text-center">Gerät</td>
                <td class="font-semibold py-2 text-xl text-black">Kommentar</td>
                <td class="font-semibold py-2 text-xl  text-right pr-2">Aktion</td>
              </tr>
            </thead>
            <tbody>
              @if (auth()->user()->warenausgangsperre != "true")
              @php
              $checkedAusgänge = array();
              $entsorgung = false;
              $warenausgangCount = 0;
              @endphp
          @foreach ($ausgang->sortByDesc("created_at") as $as)
              @if (!in_array($as->process_id, $checkedAusgänge) && !in_array($as->shortcut, $checkedAusgänge) && $as->einlagerungid == null)
              @php
                  $warenausgangCount++;
              @endphp
                @if ($as->ex_space == "Entsorgung")

                    @if ($entsorgung == false)
                    <tr class="border border-l-0 border-r-0 @if($as->locked == "true") bg-red-100 h-12 @else bg-white @endif">
                      <td>
    
                        <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-{{$as->id}}" class="text-blue-600 hover:text-blue-400">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left mr-2 @if($as->shortcut != "" || $as->shortcut != null) ml-2 @else ml-8 @endif">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                          </svg>
                        </a>     
    
                        @if ($as->locked != "true")
                        <a href="{{url("/")}}/crm/packtisch/ausgang-sperren-{{$as->id}}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-red-600 hover:text-red-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                          </svg>
                        </a>
                        @else
                        <a href="{{url("/")}}/crm/packtisch/ausgang-entsperren-{{$as->id}}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-green-600 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                          </svg>                      
                        </a>
                        @endif
    
                      </td>
                      <td class="pl-2">{{$as->created_at->format("d.m.Y")}} @if($as->locked == "true") <span class="text-red-600 font-semibold ml-36">Warenausgang gesperrt</span> @endif</td>
                      <td class="text-center ">
                          <td class="text-center  ">Entsorgung</td>
                       
    
                      
                      <td class="w-36" style=""><p class="w-48 overflow-hidden whitespace-nowrap text-ellipsis">{{$as->info}}</p></td>
                      <td>
                        @if($as->locked != "true")
                          @if ($as->ex_space == "Entsorgung")
                          <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-entsorgung" class="text-center py-2 w-36 rounded-sm bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xl float-right mr-2">Ausgang</a>
                              @else
                                @if($as->shortcut != "" && $as->shortcut != null)
                                
                                  <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-techniker/{{$as->shortcut}}" class="text-center py-2 w-36 rounded-sm @if ($as->info != null && $as->info != null) bg-yellow-600 hover:bg-yellow-500 @else bg-blue-600 hover:bg-blue-500 @endif text-white font-semibold text-xl float-right mr-2">
                                    Ausgang
                                  </a>

                                  @else

                                <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten/{{$as->id}}" class="text-center py-2 w-36 rounded-sm @if ($as->info != null && $as->info != null) bg-yellow-600 hover:bg-yellow-500 @else bg-blue-600 hover:bg-blue-500 @endif text-white font-semibold text-xl float-right mr-2">
                                  Ausgang
                                </a>
                                @endif
                          @endif
                        @endif
                        
                      </td>
                    </tr>
                    @php
                        $entsorgung = true;
                    @endphp
                    @endif

                    @else
                    <tr class="border border-l-0 border-r-0 @if($as->locked == "true") bg-red-100 h-12 @else bg-white @endif">
                      <td>
                        @if($as->shortcut != "") <input id="zusammenfassen-button-{{$warenausgangCount}}" type="checkbox" onclick="document.getElementById('zusammenfassen-button').classList.remove('hidden'); addContactChange('{{$contacts->where('id', $as->shortcut)->first()->shortcut}}')" class="rounded-sm w-4 h-4 ml-2 float-left" name="zusammenfassen-{{$as->shortcut}}" value="{{$as->shortcut}}"> @endif
    
                        <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-{{$as->id}}" class="text-blue-600 hover:text-blue-400">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left mr-2 @if($as->shortcut != "" || $as->shortcut != null) ml-2 @else ml-8 @endif">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                          </svg>
                        </a>     
    
                        @if ($as->locked != "true")
                        <a href="{{url("/")}}/crm/packtisch/ausgang-sperren-{{$as->id}}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-red-600 hover:text-red-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                          </svg>
                        </a>
                        @else
                        <a href="{{url("/")}}/crm/packtisch/ausgang-entsperren-{{$as->id}}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-green-600 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                          </svg>                      
                        </a>
                        @endif
    
                      </td>
                      <td class="pl-2">{{$as->created_at->format("d.m.Y")}} @if($as->locked == "true") <span class="text-red-600 font-semibold ml-2">Warenausgang gesperrt</span> @endif</td>
                      <td class="text-center text-blue-400 hover:text-blue-200 ">@if($as->shortcut != "")<span class="text-black"> {{$contacts->where("id", $as->shortcut)->first()->shortcut}}</span> @else <button type="button" onclick="showOrderChangeModal('{{$as->process_id}}')">{{$as->process_id}}</button> @endif</td>
                      @if ($as->shortcut != "" && $as->shortcut != null)
                        @if ($as->where("shortcut", $as->shortcut)->count() > 1)
                          <td class="text-center text-black"><span class="">{{$as->where("shortcut", $as->shortcut)->where("einlagerungid", null)->count()}}</span> Geräte</td>
                        @else
                          <td class="text-center  ">{{$as->component_number}}</td>
                        @endif
                        @else
                        @if ($as->where("process_id", $as->process_id)->count() > 1)
                          <td class="text-center"><span class="">{{$as->where("process_id", $as->process_id)->where("einlagerungid", null)->count()}}</span> Geräte</td>
                          @else
                          <td class="text-center  ">{{$as->component_number}}</td>
                        @endif
                      @endif
    
                      
                      <td class="w-36" style=""><p class="w-48 overflow-hidden whitespace-nowrap text-ellipsis">{{$as->info}}</p></td>
                      <td>
                        @if($as->locked != "true")
                          @if ($as->ex_space == "Entsorgung")
                          <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-entsorgung" class="text-center py-2 w-36 rounded-sm bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xl float-right mr-2">Ausgang</a>
                              @else
                                @if($as->shortcut != "" && $as->shortcut != null)
                                
                                  @if ($as->info != null && $as->info != null)
                                  <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-techniker/{{$as->shortcut}}" class="text-center py-2 w-36 rounded-sm bg-yellow-600 hover:bg-yellow-500 text-white font-semibold text-xl float-right mr-2">
    
                                  Ausgang
                                  @else
                                  <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten-techniker/{{$as->shortcut}}" class="text-center py-2 w-36 rounded-sm bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xl float-right mr-2">
    
                                  Ausgang
                                  @endif</a>
                                  @else
                                <a href="{{url("/")}}/crm/packtisch/warenausgang-bearbeiten/{{$as->id}}" class="text-center py-2 w-36 rounded-sm @if ($as->info != null && $as->info != null) bg-yellow-600 hover:bg-yellow-500 @else bg-blue-600 hover:bg-blue-500 @endif text-white font-semibold text-xl float-right mr-2">
                                  Ausgang
                                </a>
                                @endif
                          @endif
                        @endif
                        
                      </td>
                    </tr>
                @endif
                @php
                    if($as->shortcut != null && $as->shortcut != "") {
                      array_push($checkedAusgänge, $as->shortcut);
                    } else {
                      array_push($checkedAusgänge, $as->process_id);
                    }
                @endphp
              @endif
          @endforeach

                    @else

                        

              @endif
            </tbody>
          </table>

          <div class="relative hidden z-10" id="zusammenfassen-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
          
            <div class="fixed inset-0 z-10 overflow-y-auto">
              <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
               
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                  <div>
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                      <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                      <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Bitte Techniker auswählen</h3>
                      <div class="mt-2">
                        <p class="text-sm text-gray-500">Bitte wählen Sie den Techniker aus zu dem alle Geräte zusammengefasst werden sollen.</p>
                      </div>
                      <div class="mt-2">
                        	<select name="techniker" id="contact-change-select" class="w-full rounded-md border border-gray-600">
                            
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="mt-5 sm:mt-6">
                    <button class="float-left px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-500 font-semibold text-white text-xl" type="submit">Zusammenfassen</button>
                    <button type="button" onclick="document.getElementById('zusammenfassen-modal').classList.add('hidden')" class="float-right px-4 py-2 rounded-md font-semibold text-xl border border-gray-600">Zurück</button>
                  </div>
                </div>
              </div>
            </div>
          </div>


          </form>
          @if (auth()->user()->warenausgangsperre == "true")
          <div class=" h-60 bg-gray-500 m-auto w-full" >
            <div class="pt-12">
              <div class="rounded-md bg-white m-auto h-24" style="width: 26rem">
                <div class="pt-4 pl-4 float-left">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-600 bg-red-100 rounded-full p-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                  </svg> 
                </div>        
                <p class="float-left pt-4 pl-2 font-semibold">Warenausgang Gesperrt von 
                  
                  {{$employees->where
                    (
                    "id",
                    $ausgang->where("sperre_von", "!=", null)->first()->sperre_von
                    )->first()->username
                  }}
                
                </p>
                <p class="float-left pt-1 pl-2 text-gray-400">Gesperrt seit {{$ausgang->where("sperre_von", "!=", null)->first()->updated_at->format("d.m.Y (H:i)")}}</p>       
       
              </div>
            </div>
          </div>

          @endif
        </div>
        
      </div>
    </div>

      <div class="@if($interns->count() != 0 || $ausgang->count() != 0) hidden @endif">
        <div class="mt-16 m-auto " style="width: 41.4vw">
          <h1 class="text-8xl font-bold text-black text-left">Fertig, sehr gut!</h1>

          <p class="text-gray-800 text-2xl mt-10">Bitte erfassen Sie die restlichen Packmaterialien, über den Materialinventur. Gibt es spezielle Informationen, wenden Sie sich bitte im direkten Kontakt an Ihren Ansprechpartner</p>
        
          <button type="button" onclick="window.location.href = '{{url("/")}}/crm/packtisch/tagesabschluss'" class="bg-red-400 hover:bg-red-200 rounded-md px-8 py-4 text-white text-2xl font-semibold mt-10">Materialinventur</button>

          <div class="mt-24">
            <div class="grid grid-cols-3 gap-16">
              <p class="text-black font-semibold text-3xl">{{$wareneingang->count()}}</p>
              <p class="text-black font-semibold text-3xl">{{$intern_history->count()}}</p>
              <p class="text-black font-semibold text-3xl">{{$warenausgang_history->count()}}</p>
            </div>
            <div class="grid grid-cols-3 gap-16">
              <p class="text-black text-xl">Wareneingänge</p>
              <p class="text-black text-xl">Aufträge</p>
              <p class="text-black text-xl">Warenausgänge</p>
            </div>
          </div>
        </div>
      </div>

      
      
 
<script>
  let selectedContacts = [];
  function addContactChange(con) {

    var selectobject = document.getElementById("contact-change-select");

    for (var i=0; i<selectobject.length; i++) {
              selectobject.remove(i);
    }

    if(!selectedContacts.includes(con)) {

      selectedContacts.push(con);

      selectedContacts.forEach(item => {
        var x = document.getElementById("contact-change-select");
        var option = document.createElement("option");
        option.value = item;
        option.text = item;
        option.setAttr
        x.add(option);
      });

    } else {

      let counter = 0;
      selectedContacts.forEach(item => {

          if(item == con) {
            selectedContacts.splice(counter, 1);
          } else {
            counter++;
          }

      });

    
    }
  }

  $.get("{{url("/")}}/crm/packtisch/get/sliderhistory", function(data) {
    document.getElementById("sliderhistory-main").innerHTML = data;
  })
</script>

      


        <div class=" @if($interns->count() == 0 && $ausgang->count() == 0) hidden @endif absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 float-left text-black">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg>
          <p class="float-left text-black mt-0.5">Wareneingänge: {{$wareneingang->count()}}</p>
  
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 float-left text-black ml-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <p class="float-left text-black mt-0.5">Aufträge: {{$intern_history->count()}}</p>
  
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 float-left text-black ml-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
          </svg>
          <p class="float-left text-black mt-0.5 mr-8">Warenausgänge: {{$warenausgang_history->count()}}</p>
  
          <a href="{{url("/")}}/crm/packtisch/tagesabschluss" class="float-left text-center py-1 px-4 rounded-md text-white bg-red-400 hover:bg-red-200 ">Materialinventur</a>
  
          
          
        </div>

        <div id="tracking-his">

        </div>
        

        @isset($tracking)
        <script>
          getHistory('{{$tracking}}');
          function getHistory(id) {
            $.get("{{url("/")}}/crm/packtisch/allhistory-tracking/"+id, function(data) {
              document.getElementById("tracking-his").innerHTML = data;
            })
          }
        </script>
        @endisset

        <script>

          function selectAllWarenausgang() {
            let warenausgangCount = {{$ausgang->count()}}
            let counter = 1;

            if(document.getElementById("zusammenfassen-button-main").checked) {
              while(counter < warenausgangCount) {
                if(document.getElementById("zusammenfassen-button-"+counter)) {
                  document.getElementById("zusammenfassen-button-"+counter).checked = true;
                }
                counter++;
              }

              document.getElementById("zusammenfassen-button").classList.remove("hidden");
            } else {
              while(counter < warenausgangCount) {
                if(document.getElementById("zusammenfassen-button-"+counter)) {
                  document.getElementById("zusammenfassen-button-"+counter).checked = false;
                }
                counter++;
              }

              document.getElementById("zusammenfassen-button").classList.add("hidden");
            }
          }

        </script>

<script>
  function toggleScansHistorie() {
    document.getElementById("done-orders").classList.toggle("hidden");
    document.getElementById("scan-tab").classList.toggle("hidden");
  }
</script>
<script>
  function printLabel(label) {
    let div = document.getElementById('labelprint');

    let img = document.createElement('img');
    img.src = "{{url("/")}}/temp/" + label + ".png";
    img.classList.add('hidden', 'w-full', 'h-full');
    img.style.transform = "rotate(90deg)";

    div.appendChild(img);

    printJS('labelprint', 'html')
  }
</script>
<script>
  function editWareneingang(id) {
    loadData();
    $.get("{{url("/")}}/crm/packtisch/get/wareneingang-bearbeiten-"+id, function(data) {
      document.getElementById("wareneingang-edit-div").innerHTML = data;
      document.getElementById('wareneingang-edit-div').classList.remove('hidden');

      savedPOST();
    })
  }

  function showAuftragsfotos(id, dev) {
    document.getElementById("dokumente-append").innerHTML = "";

    let iframe = document.createElement("iframe");
    iframe.src = "{{url("/")}}/files/aufträge/"+id+"/"+dev+"-a.pdf";
    iframe.classList.add("w-full", "h-full");
    iframe.style.height = "50rem";

    document.getElementById("dokumente-div").classList.remove('hidden');
    document.getElementById("dokumente-append").appendChild(iframe);
  }

  function showGerätedokumente(id, dev) {
    document.getElementById("dokumente-append").innerHTML = "";

    let iframe = document.createElement("iframe");
    iframe.src = "{{url("/")}}/files/aufträge/"+id+"/"+dev+"-g.pdf";
    iframe.classList.add("w-full", "h-full");
    iframe.style.height = "50rem";

    document.getElementById("dokumente-div").classList.remove('hidden');
    document.getElementById("dokumente-append").appendChild(iframe);
  }
</script>
</body>
</html>