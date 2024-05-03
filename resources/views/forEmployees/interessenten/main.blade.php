<!doctype html>
<html class="h-full">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script 
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
  </script>
  
  <link rel="stylesheet" type="text/css" href="{{url("/")}}/css/calender.css">
  <script src="{{url("/")}}/js/calender.js"></script>
  <script src="https://npmcdn.com/flatpickr/dist/l10n/de.js"></script>
  
</head>
@livewireScripts

<body>
@include('layouts/top-menu', ["menu" => "interessent"])

 <div>
  <div class="px-8">
    
    <div class="pt-5">
     
      <div class="h-16 w-full">
        <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Interessentenübersicht
          @isset($filter)- Filter: {{ucfirst($filter)}} @endisset @isset($filterKunde)- Filter: K{{$filterKunde}}, Kunde: {{$leads->where("kunden_id", $filterKunde)->first()->firstname}} {{$leads->where("kunden_id", $filterKunde)->first()->lastname}} @endisset
        </h1>

        <button onclick="getEmailInbox()">
          <div class="float-left w-14 h-12 bg-white hover:bg-gray-200 mt-2 ml-10 rounded-lg ">
            <div class="absolute w-16">
              @if ($emailRead != null)
              <div class="float-right bg-red-400 rounded-full w-4 h-4 mr-2   ">
  
              </div>
              @endif
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mt-0.5 m-auto text-gray-900">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
          </div>
        </button>
      </div>
      @isset($hinweise[0])
         <div class="w-full mb-4 py-3 px-4 rounded-md bg-gray-900 font-semibold text-2xl">
          @foreach ($hinweise as $hinweis)
          <div class="flex mt-2">
            <a href="{{url("/")}}/crm/hinweis-löschen-{{$hinweis->id}}" class="mt-1.5 mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-100 hover:text-red-500 float-right">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
              </svg>          
            </a>  
            <p style="color: {{$hinweis->color}}" class="">{{$hinweis->hinweis}}</p>
          </div>
          <p class="text-gray-400 ml-10 text-sm">von <span class="text-white">@if($users->where("id", $hinweis->employee)->first() != null) {{$users->where("id", $hinweis->employee)->first()->name}} @else {{$hinweis->employee}} @endif</span> am <span class="text-white">{{$hinweis->created_at->format("d.m.Y (H:i)")}}</span></p>


           @endforeach
         </div>
       @endisset
    </div> 


    <div>
    
      <dl id="statistik" class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4 lg:grid-cols-4 hidden">
        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Konvertierte Interessenten</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-blue-600">
              
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Heute</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 ml-14">30 Tage</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 float-right">mehr</a>

              </div>
            </div>
          </dd>
        </div>
        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Offene Interessenten</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-blue-600">

         
          
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Heute</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 ml-14">30 Tage</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 float-right">mehr</a>

              </div>
            </div>
          </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Verlorene Interessenten</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-blue-600">

           
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Heute</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 ml-14">30 Tage</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 float-right">mehr</a>

              </div>
            </div>
          </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Abschlussquote</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            /
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Heute</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 ml-14">30 Tage</a>
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 float-right">mehr</a>

              </div>
            </div>
          </dd>
        </div>

       
        
        
      </dl>
    </div>


    <div>
      <div>
        <div>
          
          <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                  <form action="{{url("/")}}/crm/interessenten/set-multi-status" id="multistatus-form" method="POST">
                    @CSRF
                  <table class="w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-3.5 pl-2  text-left text-sm font-semibold text-gray-900">
                          <input onclick="document.getElementById('set-status-dropdown').classList.remove('hidden'); if(this.checked == true) { checkedState = false; document.getElementById('quickstatus-input-bottom').checked = false } selectAllOrders()" id="main-checkbox" type="checkbox" class="border-gray-400 rounded-sm w-4 h-4">
                          
                          <div id="set-status-dropdown" class="absolute hidden inline-block text-left">
                            <div>
                              <button type="button" onclick="document.getElementById('select-status-quick').classList.toggle('hidden')" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                Status wählen
                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                              </button>
                            </div>
                            <div id="select-status-quick" class="hidden absolute left-0 z-50 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                              <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <div class="px-4 py-3">
                                  <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                  <select id="location" name="multistatus-status" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    @foreach ($allStats->sortBy("name") as $stat)
                                        <option value="{{$stat->id}}">{{$stat->name}}</option>
                                    @endforeach
                                  </select>

                                  <div class="w-full">
                                    <button type="submit" class="mt-4 bg-blue-600 rounded-md font-semibold text-white px-4 py-2 text-md">Speichern</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                        </th>
                        
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          <div class=" flex">
                            @isset($sorting)
                            @if ($sorting == "created_at-up")
                            <a href="{{url("/")}}/crm/interessenten/sortieren-created_at-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4   ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "created_at-down")
                            <a href="{{url("/")}}/crm/interessenten/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/interessenten/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/interessenten/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endisset

                            <p class="ml-2">Erstellt</p>
                            
                            </div>                                                 
                        </th>
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        </th>
                        <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">  
                          
                          
                          Prozent
                        </th>

                        <th scope="col" class="flex py-3.5 text-left text-sm font-semibold text-gray-900">
                          <div class="mt-1 flex">
                            @isset($sorting)
                          @if ($sorting == "process_id-up")
                          <a href="{{url("/")}}/crm/interessenten/sortieren-process_id-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "process_id-down")
                          <a href="{{url("/")}}/crm/interessenten/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/interessenten/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/interessenten/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                            @endisset

                          <p class="ml-2">Lead</p>
                          </div>
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Kunde
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        
                          Name
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Fahrzeug
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Telefonnummer
                        </th>

                        <th scope="col" class="flex py-3.5 text-left text-sm font-semibold text-gray-900">
                         <div class="flex mt-1">
                          @isset($sorting)
                          @if ($sorting == "status-up")
                          <a href="{{url("/")}}/crm/interessenten/sortieren-status-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "status-down")
                          <a href="{{url("/")}}/crm/interessenten/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/interessenten/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/interessenten/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                        @endisset

                          <p class="ml-2">Status</p>
                         </div>
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Zuweisung
                        </th>

                        <th scope="col" class=" py-3.5 flex text-left text-sm font-semibold text-gray-900">
                          
                         
                          <div class="flex mt-1">
                            @isset($sorting)
                            @if ($sorting == "updated_at-up")
                            <a href="{{url("/")}}/crm/interessenten/sortieren-updated_at-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "updated_at-down")
                            <a href="{{url("/")}}/crm/interessenten/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/interessenten/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/interessenten/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                              @endisset
                            
                              <p class="ml-2">Geändert</p>
                          </div>
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Mitarbeiter
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Versandmonito
                        </th>


                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Rückruf
                        </th>

                        
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          <button type="button" id="filter-button" onclick="document.getElementById('orders-filter-dropdown').classList.toggle('hidden');">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mt-1.5 text-gray-600 hover:text-gray-400">
                              <path  fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                            </svg>
                          </button>
                          <div id="order-filter-div">
                            @include('components.interessenten-filter')
                          </div>
                        </th>

                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      @php
                          $orderCounter = 0;
                      @endphp

                      @if(isset($sorting))
                        @if ($sorting == "status-up")
                          @php
                            $leads = $leads->sortByDesc(function($order) use ($allStats) {
                              if($order->statuse->sortByDesc('created_at')->first() != null) {
                                return $allStats->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                              }
                            });
                          @endphp
                        @endif
                          @if ($sorting == "status-down")
                            @php
                              $leads = $leads->sortBy(function($order) use ($allStats) {
                                if($order->statuse->sortByDesc('created_at')->first() != null) {
                                  return $allStats->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                                }
                              });
                            @endphp
                          @endif
                      @endif

                      @foreach ($leads->where("archiv", null) as $order)
                            @if ($order->statuse->sortByDesc("created_at")->first() == null || $order->statuse->sortByDesc("created_at")->first() != null)
                              @if (isset($statusfilter) )
                              
                              @if ($statusfilter != "all")
                                  @if ($order->statuse->sortByDesc("created_at")->first() != null)
                                  
                                  @if ($order->statuse->sortByDesc("created_at")->first()->last_status != $statusfilter)
                                    @php
                                        continue;
                                    @endphp
                                  @endif
                                @endif
                              @endif

                              @endif
                              @else

                              @php
                                    continue;
                              @endphp
                            @endif
                      @php
                          $columns = array( "firstname", 
                                            "lastname", 
                                            "phone_number", 
                                            "mobile_number", 
                                            "home_street", 
                                            "home_street_number", 
                                            "home_zipcode", 
                                            "home_country",
                                            "home_city");
                        $columnCounter = 0;
                        $allColumns    = count($columns);
                      @endphp
                      @foreach ($columns as $column)
                          @if ($order->$column != null)
                              @php
                                  $columnCounter++;
                              @endphp
                          @endif
                      @endforeach

                        <tr class="hover:bg-blue-100  border-l-0 border-r-0" id="row-{{$orderCounter}}" onclick="selectOrderDoubleClick('{{$order->process_id}}')">
                          <td class="whitespace-nowrap py-  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-{{$orderCounter}}" name="{{$order->process_id}}-order" value="{{$order->process_id}}" onclick=" selectQuickStatus('{{$orderCounter}}', 'yes')" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">{{$order->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            @if ($order->files != null)
                                
                            @endif
                          </td>
                          @php
                            $processBarColor = "";
                              if($columnCounter <= 2) {
                                $processBarColor = "bg-green-200";
                              } else {
                                 if($columnCounter <= 4) {
                                $processBarColor = "bg-green-400";
                                 } else {
                                  if($columnCounter <= 9) {
                                  $processBarColor = "bg-green-600";
                                  }
                                 } 
                              } 
                          @endphp
                          <td class="whitespace-nowrap text-center py-1 text-sm text-gray-500"><div class="w-24 h-4 rounded-md bg-gray-200">
                            <div style="width: {{(100/$allColumns)*$columnCounter}}%" class="{{$processBarColor}} h-4 rounded-md">
                              
                            </div>  
                          </div></td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500">{{$order->process_id}}</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500">
                            @if($leads->where("kunden_id", $order->kunden_id)->count() > 1) 
                            <a href="{{url("/")}}/crm/interessentenübersicht-aktiv/filter-{{$order->kunden_id}}" class="text-blue-600 hover:text-blue-400">
                              K{{$order->kunden_id}}
                            </a> 
                            @else 
                            K{{$order->kunden_id}} 
                            @endif
                          </td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500">{{$order->firstname}} {{$order->lastname}}</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500"></td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500">{{$order->phone_number ?: $order->mobile_number}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black" >
                           <div>
                            @if (isset($order->statuse->sortByDesc("created_at")->first()->statuseMain->color))
                            <div style="background-color: {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->color}}" class="px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium">
                              {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->name}}
                              <select id="quick-status-select-{{$orderCounter}}" onchange="setNewQuickStatus(this.value, '{{$order->process_id}}')" name="location" class="absolute hidden mt-2 block w-60 rounded-md border-0 py-1.5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="">neuen Status wählen</option>
                                @foreach ($allStats->sortBy("name") as $stat)
                                    <option value="{{$stat->id}}">{{$stat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            @endif       
                            
                            <div class="float-right">
                              <button type="button"  class="float-right" onclick="lastOpendQuickStatus = '{{$orderCounter}}'; document.getElementById('quick-status-select-{{$orderCounter}}').classList.toggle('hidden')">
                                <svg id="open-quick-status-{{$orderCounter}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                              </button>
                              
                            </div>
                           </div>
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black text-center">
                            @isset($order->zuweisung)
                              @if ($order->zuweisung->count() == 1)          
                                @php
                                  $zw = $order->zuweisung[0];
                                  array_push($usedZuweisung, $zw->employee);

                                  $createdDate = \Carbon\Carbon::parse($zw->created_at);
                                  $tage = $zw->tage;
                                  $today = \Carbon\Carbon::today();
                                  $diffInDays = $createdDate->diffInDaysFiltered(function ($date) {
                                      return !$date->isWeekend();
                                  }, $today);
                                  $days = $diffInDays - $tage;
                                  
                                @endphp    
                                
                                
                                @if ($zw->checked != true)
                                  @if ($days <= 0)
                                    <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-green-200 text-green-600">{{$users->where("id", $order->zuweisung[0]->employee)->first()->username}}</p>
                                  @endif
                                  @if ($days == 1)
                                      <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-yellow-200 text-yellow-600">{{$users->where("id", $order->zuweisung[0]->employee)->first()->username}}</p>
                                  @endif
                                  @if ($days == 2)
                                      <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-orange-200 text-orange-600">{{$users->where("id", $order->zuweisung[0]->employee)->first()->username}}</p>
                                  @endif
                                  @if ($days >= 3)
                                      <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-red-200 text-red-600">{{$users->where("id", $order->zuweisung[0]->employee)->first()->username}}</p>
                                  @endif
                                @endif

                              @else
                              <div class="grid grid-cols-2">
                                @php
                                    $usedZuweisung = array();
                                @endphp
                                @foreach ($order->zuweisung as $zw)
                                    @if (!in_array($zw->employee, $usedZuweisung))
                                      @if ($zw->checked == true)
                                          @php
                                              continue;
                                          @endphp
                                      @endif
                                        @php
                                            array_push($usedZuweisung, $zw->employee);

                                            $createdDate = \Carbon\Carbon::parse($zw->created_at);
                                            $tage = $zw->tage;
                                            $today = \Carbon\Carbon::today();
                                            $diffInDays = $createdDate->diffInDaysFiltered(function ($date) {
                                                return !$date->isWeekend();
                                            }, $today);
                                            $days = $diffInDays - $tage;
                                        @endphp
                                        
                                        <div class="float-left">
                                          @if ($days <= 0)
                                            <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-green-200 text-green-600">{{$users->where("id", $zw->employee)->first()->username}}</p>
                                        @endif
                                        @if ($days == 1)
                                            <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-yellow-200 text-yellow-600">{{$users->where("id", $zw->employee)->first()->username}}</p>
                                        @endif
                                        @if ($days == 2)
                                            <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-orange-200 text-orange-600">{{$users->where("id", $zw->employee)->first()->username}}</p>
                                        @endif
                                        @if ($days >= 3)
                                            <p class="m-auto px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-red-200 text-red-600">{{$users->where("id", $zw->employee)->first()->username}}</p>
                                        @endif
                                        </div>
                                    @endif
                                @endforeach
                              </div>
                              @endif
                        @endisset
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-left text-gray-500">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-gray-500">@isset($users->where("username", $order->employee)->first()->username) {{$users->where("username", $order->employee)->first()->username}} @endisset</td>
                          
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            @isset ($order->userTracking[0]->process_id)
                            <a href="{{url("/")}}/crm/tracking/interessenten-aktiv-{{$order->process_id}}" onclick="loadData()">
                              @if ($order->userTracking->count() > 1)
                              <div class="flex">
                                <div class="float-left h-7 border border-red-600 rounded-full flex px-2 hover:bg-red-100">

                                  <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class=" text-red-600 w-5 h-5 mt-1 m-auto">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                  </svg> 
                                  <p class="ml-2 mt-0.5">{{$order->userTracking->count()}}</p>

                                  </div>
                                
                              </div>
                                  @else
                                  
                                  @isset($order->userTracking[0]->trackings[0]->code)
                                  @if ($order->userTracking[0]->trackings[0]->code != null)
                                  @if ($order->userTracking[0]->trackings[0]->code->icon == "truck")

                                      <svg id="icon-svg-truck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="m-auto  mt-0.5 ml-0.5 text-yellow-600 w-5 h-5">
                                        <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.771-.59-1.43-1.375-1.489A41.568 41.568 0 006.5 3zM2 12v2.5A1.5 1.5 0 003.5 16h.041a3 3 0 015.918 0h.791a.75.75 0 00.75-.75V12H2z" />
                                        <path d="M6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.25 5a.75.75 0 00-.75.75v8.514a3.001 3.001 0 014.893 1.44c.37-.275.61-.719.595-1.227a24.905 24.905 0 00-1.784-8.549A1.486 1.486 0 0014.823 5H13.25zM14.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                      </svg>
                                  @endif

                                  @if ($order->userTracking[0]->trackings[0]->code->icon == "doc")

                                    <svg id="icon-svg-doc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-green-600 w-5 h-5 mt-0.5 m-auto" style="margin-left: 0.21rem;">
                                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                    </svg>
                                    
                                  @endif

                                  @if ($order->userTracking[0]->trackings[0]->code->icon == "warning")

                                  <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 mt-0.5 ml-0.5 w-5 h-5 m-auto">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                  </svg>
                                  @endif

                                @else
                                
                                <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-5 h-5 m-auto">
                                  <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                @endif
                                @else
                                <a class="text-red-600 hover:text-red-400" href="{{url("/")}}/crm/tracking/interessenten-aktiv-{{$order->process_id}}" onclick="loadData()">Status fehlt</a>

                                  @endisset
                              @endif
                            </a>
                            @else 
                            <a class="text-blue-600 hover:text-blue-400" href="{{url("/")}}/crm/tracking/interessenten-aktiv-{{$order->process_id}}" onclick="loadData()">neuer Tracker</a>
                            @endisset
                          </td>
                          <td>
                            @if(isset($order->callbacks->where("status", "Rückruf")->sortBy("created_at")->first()->rückruf_time)) 
                              {{$order->callbacks->where("status", "Rückruf")->sortBy("created_at")->first()->rückruf_time}} 
                              <span  class="text-gray-500">{{$users->where("id", $order->callbacks->where("status", "Rückruf")->sortBy("created_at")->first()->employee)->first()->username}}</span>
                              @endif
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                                                  
                          </td>
                          
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">

                            <button type="button" onclick="showOrderChangeModal('{{$order->process_id}}')">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 hover:text-blue-400 float-right mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                              </svg>  
                            </button>
                          </td>
   
                        </tr>
                      @php
                          $orderCounter++;
                      @endphp
                      @endforeach
        
                      <tr >
                        <td class="whitespace-nowrap py-4  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-bottom" name="all" onclick=" if(this.checked == true) { checkedState = false; document.getElementById('main-checkbox').checked = false } selectAllOrders();" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
                        <td>
                          <p class="absolute" style="margin-top: -1.1rem;">alle Auswählen ({{$orderCounter}} Aufträge) 
                        
                          <select style="padding-right: 0px; padding-bottom: 0px; padding-top: 0px;" name="bottom-sel" class="rounded-md border-gray-300 h-7 w-60 ml-4 mt-1.5">
                            <option value="archiv">Zum Archiv</option>
                            <option value="orders">Zu Aufträgen</option>
                            <option value="" class="font-bold text-lg">Statuse</option>
                            @foreach ($allStats as $stat)
                                <option value="{{$stat->id}}">{{$stat->name}}</option>
                            @endforeach
                          </select>

                          <button type="button" onclick="document.getElementById('multistatus-form').action = '{{url("/")}}/crm/auftrag/set-bottom'; document.getElementById('sub').click();" class="rounded-md text-white font-medium text-md bg-blue-600 hover:bg-blue-400 px-4 h-7 mt-1.5 absolute ml-4" >
                            Ausführen
                          </button>
                          <button class="hidden" id="sub"></button>
                        
                        </p></td>

                        <td></td>
                        <td class="text-lg font-semibold py-2"></td>
                     
                        <td class="text-lg font-semibold"></td>
                        <td></td>

                        <td></td>
                        <td class="text-lg font-bold"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>


                      </tr>
                    </tbody>
                  </form>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </div>
 <div id="email-inbox-div">

 </div>
<form action="{{url("/")}}/crm/interessenten-sort" method="POST">
  @CSRF
  <input type="hidden" id="status-filter" name="status">
  <input type="hidden" name="field" id="field-filter">
  <input type="hidden" name="direction" id="direction-filter">
  <input type="hidden" name="buchhaltung" id="buchhaltung-filter">
  <input type="hidden" name="count" id="count-filter">
  <button type="submit" class="hidden border-blue-400" id="submit-filter"></button>
</form>

<form action="{{url("/")}}/crm/set-quick-status" id="quick-status-form" method="POST">
@CSRF 
<input type="hidden" id="quick-status-value" name="status">
<input type="hidden" id="quick-status-process_id-value" name="process_id">
<button type="submit" class="hidden" id="submit-quick-status"></button>
</form>

<script>
let lastSelected = "";
    let selectedState = false
    function selectOrderDoubleClick(id) {
      
      if(lastSelected == id) {
        if(selectedState == true) {
          showOrderChangeModal(id);
          lastSelected = "";
          selectedState = false;
        } else {5
          lastSelected = "";
        }
      } else {
        lastSelected = id;
        selectedState = true;

        setTimeout(
          function() {
            selectedState = false;
        }, 200);
      }
    }


  window.addEventListener("contextmenu", e => e.preventDefault());
 
  var lastOpendQuickStatus = "0";
  function setNewQuickStatus(id, process_id) {

    document.getElementById('quick-status-value').value = id;
    document.getElementById('quick-status-process_id-value').value = process_id;

    document.getElementById('submit-quick-status').click();

  }

  function getEmailInbox() {
        loadData();
        $.get("{{url("/")}}/crm/get-emailinbox", function(data) {
          $('#email-inbox-div').html(data);
          savedPOST();
        });
      }

  function submitSort() {

    document.getElementById("status-filter").value = document.getElementById("status-dropdown").value;
    document.getElementById("field-filter").value = document.getElementById("field-dropdown").value;
    document.getElementById("direction-filter").value = document.getElementById("direction-dropdown").value;
    document.getElementById("buchhaltung-filter").value = document.getElementById("buchhaltung-dropdown").value;
    document.getElementById("count-filter").value = document.getElementById("count-dropdown").value;

    document.getElementById("submit-filter").click();

  }

  var checkedState = false;
  function selectAllOrders() {
    
    if(checkedState == false) {
      let allOrders = {{$leads->count()}}
      let counter = 0;
      while(counter < allOrders) {
        if(document.getElementById('quickstatus-input-'+counter)) {
          document.getElementById('quickstatus-input-'+counter).checked = true;
          document.getElementById("row-"+counter).classList.add("bg-blue-100");
        }
        counter++;
      }
      checkedState = true;
    } else {
      let allOrders = {{$leads->count()}}
      let counter = 0;
      while(counter < allOrders) {
        if(document.getElementById('quickstatus-input-'+counter)) {
          document.getElementById('quickstatus-input-'+counter).checked = false;
          document.getElementById("row-"+counter).classList.remove("bg-blue-100");
        }
        counter++;
      }
      document.getElementById('set-status-dropdown').classList.add('hidden');
      checkedState = false;
    }
  }

  var outsideOrderFilterState = false;
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

            if(!isDescendant(document.getElementById("filter-button"), evt.target)) {
              if(isDescendant(motherDiv, evt.target) == false) {
                document.getElementById("orders-filter-dropdown").classList.add("hidden");
              }
            } 
            if(evt.target != document.getElementById("open-quick-status-"+lastOpendQuickStatus) && evt.target != document.getElementById("quick-status-select-"+lastOpendQuickStatus)) {
                document.getElementById('quick-status-select-'+lastOpendQuickStatus).classList.add('hidden');
              }
              if(evt.target != document.getElementById("quick-order-dropdown")) {
                if(document.getElementById("quick-order-dropdown")) {
                  document.getElementById("quick-order-dropdown").remove();
                }
            }
            if(!isDescendant(document.getElementById("datepicker-main"), evt.target)) {
              document.getElementById("datetimepicker-time").classList.add('hidden');
            }

            if(!isDescendant(document.getElementById("texts-div-main"), evt.target)) {
              document.getElementById("texts-div").classList.add('hidden');
            }
            if(!isDescendant(document.getElementById("zuweisung-telefon-main"), evt.target)) {
              document.getElementById("zuweisung-telefon-div").classList.add('hidden');
            }
            if(!isDescendant(document.getElementById("zuweisung-dokumente-main"), evt.target)) {
              document.getElementById("zuweisung-dokumente-div").classList.add('hidden');
            }

            if(!isDescendant(document.getElementById("extra-status-div-main"), evt.target)) {
              document.getElementById("extra-status-div").classList.add('hidden');
            }

            if(!isDescendant(document.getElementById("tracking-div-main"), evt.target)) {
              document.getElementById("tracking-div").classList.add('hidden');
            }

            if(!isDescendant(document.getElementById("emailvorlagen-main"), evt.target)) {
              document.getElementById("emailvorlage-div").classList.add('hidden');
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

      let quickClickTimeState = false;
      let selectedBarcodesCounter = 0;
      function selectQuickStatus(id, fromManuel, event) {


          if(document.getElementById('row-'+id).classList.contains("bg-blue-100")) {
            document.getElementById('row-'+id).classList.remove('bg-blue-100');
            document.getElementById('quickstatus-input-'+id).checked = false
            selectedBarcodesCounter--;

          } else {
            document.getElementById('row-'+id).classList.add('bg-blue-100');
            document.getElementById('quickstatus-input-'+id).checked = true
            selectedBarcodesCounter++;
          }
            if(selectedBarcodesCounter == 0) {
            document.getElementById('set-status-dropdown').classList.add('hidden');
          } else {
            document.getElementById('set-status-dropdown').classList.remove('hidden');

          }
      }

      
      document.addEventListener('contextmenu', function(event) {
        
        var max = "{{$orderCounter}}";
        var counter = 0;
        if(document.getElementById("quick-order-dropdown")) {
          document.getElementById("quick-order-dropdown").remove();
        }
        while(counter <= max) {
          if(isDescendant(document.getElementById("row-"+counter), event.target)) {
            var div = document.createElement("div");
            var x = document.getElementById("row-"+counter).offsetX;
            var y = document.getElementById("row-"+counter).offsetY;

            div.classList.add("absolute", "px-4", "h-8", "rounded-md", "bg-white");
            div.style.left = x+"px";
            div.style.top = y+"px";
            div.setAttribute("id", "quick-order-dropdown");

            let a = document.createElement("a");
            a.classList.add("text-left", "font-semibold", "text-lg", "text-blue-600", "hover:text-blue-400");
            a.innerHTML = "bearbeiten";
            a.href = "adw" ;
            
            div.appendChild(a);
            event.target.appendChild(div);
          }
          counter++;
        }
        event.preventDefault();

      });

    

</script>
@isset($tracking)
@livewire('custom-tracking', ['process_id' => $tracking])

@endisset
</body>
</html>