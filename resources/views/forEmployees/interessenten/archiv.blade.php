<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
@livewireScripts
<body>
@include('layouts/top-menu', ["menu" => "interessent", "undermenu" => "archiv"])


<div id="auftragmain">
 <div>
  <div class="px-8">
    
    <div class="pt-5">
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
         <p class="text-black ml-10 text-sm">von <span class="text-white">@if($employees->where("id", $hinweis->employee)->first() != null) {{$employees->where("id", $hinweis->employee)->first()->name}} @else {{$hinweis->employee}} @endif</span> am <span class="text-white">{{$hinweis->created_at->format("d.m.Y (H:i)")}}</span></p>


          @endforeach
        </div>
      @endisset
     <div class="h-16 w-full">
       <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Interessentenarchiv @isset($filter)- Filter: {{ucfirst($filter)}} @endisset @isset($filterKunde)- Filter: K{{$filterKunde}}, Kunde: {{$active_orders->where("kunden_id", $filterKunde)->first()->firstname}} {{$active_orders->where("kunden_id", $filterKunde)->first()->lastname}} @endisset</h1>

       <button onclick="getEmailInbox()">
         <div class="float-left w-14 h-12 bg-white hover:bg-gray-200 mt-2 ml-10 rounded-lg ">
           <div class="absolute w-16">
             @isset($emailRead)
             @if ($emailRead != null)
             <div class="float-right bg-red-400 rounded-full w-4 h-4 mr-2   ">
 
             </div>
             @endif
             @endisset
           </div>
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mt-0.5 m-auto text-gray-900">
             <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
           </svg>
         </div>
       </button>

      
     </div>
   </div>  
                       

    <div>
      <div>
        <div>
          
          <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                  <form action="{{url("/")}}/crm/auftrag/set-multi-status" id="multistatus-form" method="POST">
                    @CSRF
                    <input type="hidden" name="rechnung" id="rechnung-input">
                    <input type="hidden" name="data" id="data-input">
                    <div id="export-data-modal" class="hidden">
                      @include('forEmployees.modals.export')
                      </div>
                  <table class="w-full divide-y divide-gray-300">
                    <thead class="bg-gray-100">
                      <tr>
                        <th scope="col" class="py-3.5 pl-2  text-left text-sm font-semibold text-gray-900">
                          <input onclick="document.getElementById('set-status-dropdown').classList.remove('hidden'); selectAllOrders()" type="checkbox" class="border-gray-400 rounded-sm w-4 h-4">
                          
                          <div id="set-status-dropdown" class="absolute hidden inline-block text-left">
                            <div class="px-2 py-2 bg-white rounded-md">
                              <div>
                                <button type="button" onclick="document.getElementById('multistatus-form').action = '{{url("/")}}/crm/auftrag/set-multi-status';  document.getElementById('select-status-quick').classList.toggle('hidden')" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                  Status wählen
                                  <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                  </svg>
                                </button>
                              </div>
                              <div>
                                <button type="button" onclick="document.getElementById('export-data-modal').classList.remove('hidden')" class="mt-4 inline-flex w-full justify-center gap-x-1.5 rounded-md bg-blue-600 hover:bg-blue-400 px-3 py-1 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                  Exportieren

                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                  </svg>
                                  
                                </button>
                              </div>

                              
                            </div>
                          
                            <!-- Modal -->
                            <div id="quick-message-modal" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
                              <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                              <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                                <!-- Add margin if you want to see some of the overlay behind the modal-->
                                <div class="modal-content py-4 text-left px-6">
                                  <!--Title-->
                                  <div class="flex justify-between items-center pb-3">
                                    <p class="text-2xl font-bold">neue Auftragsnachricht</p>
                                    <div class="modal-close cursor-pointer z-50">
                                      <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M18 1.5L16.5 0 9 7.5 1.5 0 0 1.5 7.5 9 0 16.5 1.5 18 9 10.5 16.5 18 18 16.5 10.5 9z" />
                                      </svg>
                                    </div>
                                  </div>

                                  <!--Body-->
                                  
                                  <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
                                      Nachricht
                                    </label>
                                    <textarea name="message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message-quick" type="text" placeholder=""></textarea>
                                  </div>

                                  <!--Footer-->
                                  <div class="flex justify-between pt-2">
<script>
  function postMessageNew() {
    document.getElementById('multistatus-form').action = '{{url("/")}}/crm/auftrag/neuer-text-quick';
    document.getElementById("submit-message-quick").click();
  }
</script>
                                    <button onclick="postMessageNew()" id="save-message" class="px-4 py-2 bg-blue-800 text-gray-100 rounded hover:bg-blue-700 focus:outline-none focus:bg-blue-700" type="button">Speichern</button>
                                    <button class="modal-close px-4 py-2 bg-white border border-gray-400 text-black rounded" type="button">Abbrechen</button>
                                    <button class="hidden" id="submit-message-quick" type="submit"></button>
                                  </div>

                                </div>
                              </div>
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
                                    <button type="submit" id="submit-statusquick" class="mt-4 bg-blue-600 rounded-md font-semibold text-white px-4 py-2 text-md">Speichern</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                        </th>
                        
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900 pl-2">
                          
                          <div class=" float-left">
                            Erstellt
                            @isset($sorting)
                            @if ($sorting == "created_at-up")
                            <a href="{{url("/")}}/crm/archiv/sortieren-created_at-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "created_at-down")
                            <a href="{{url("/")}}/crm/archiv/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/archiv/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                              </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/archiv/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endisset
                            
                            </div>                                                 
                        </th>
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        </th>
                        <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">  
                         
                          Auftrag
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

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          @isset($sorting)
                          @if ($sorting == "status-up")
                          <a href="{{url("/")}}/crm/archiv/sortieren-status-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "status-down")
                          <a href="{{url("/")}}/crm/archiv/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/archiv/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/archiv/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                        @endisset
                          Status
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Zuweisung
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          @isset($sorting)
                            @if ($sorting == "updated_at-up")
                            <a href="{{url("/")}}/crm/archiv/sortieren-updated_at-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "updated_at-down")
                            <a href="{{url("/")}}/crm/archiv/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/archiv/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                              </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/archiv/sortieren-updated_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endisset
                          Geändert
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                         
                          Mitarbeiter
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Workflow
                        </th>

                     

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Montior
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">

                          Track
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                         
                          P
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                         Zuteilung
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                            
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-right mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0012 2.25z" />
                          </svg>
                          
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          <button type="button" id="filter-button" class="w-4 h-4" onclick="document.getElementById('orders-filter-dropdown').classList.toggle('hidden');">
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
                            $active_orders = $active_orders->sortByDesc(function($order) use ($statuses) {
                              return $statuses->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                            });
                          @endphp
                        @endif
                          @if ($sorting == "status-down")
                            @php
                              $active_orders = $active_orders->sortBy(function($order) use ($statuses) {
                                return $statuses->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                              });
                            @endphp
                          @endif
                      @endif


                      @foreach ($active_orders->where("archiv", true) as $order)

                        <tr class="hover:bg-blue-100 border-l-0 border-r-0" id="row-{{$orderCounter}}" onclick="selectQuickStatus('{{$orderCounter}}', 'no', event)">
                          <td class="whitespace-nowrap py-  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-{{$orderCounter}}" name="{{$order->process_id}}-order" value="{{$order->process_id}}" onclick="document.getElementById('set-status-dropdown').classList.remove('hidden'); selectQuickStatus('{{$orderCounter}}', 'yes')" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black ">{{$order->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            @if ($order->files != null)
                                
                            @endif
                          </td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">{{$order->process_id}}</td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">@if($active_orders->where("kunden_id", $order->kunden_id)->count() > 1)  @endif K{{$order->kunden_id}}</td>
                          <td class="whitespace-nowrap text-left pl-6 py-1 text-sm text-black">
                            <p class="truncate overflow-hidden whitespace-nowrap w-36">{{$order->firstname}} {{$order->lastname}}</p>

                          
                          </td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">@isset($order->activeOrdersCarData->car_company){{$order->activeOrdersCarData->car_company}} {{$order->activeOrdersCarData->car_model}}@endisset</td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">{{$order->phone_number ?: $order->mobile_number}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black" >
                           <div>
                            @if ($order->statuse->sortByDesc("created_at")->first() != null)
                              @if ($order->statuse->sortByDesc("created_at")->first()->statuseMain != null)
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
                            @endif
                            
                            <div class="float-right">
                             
                              <button type="button"  class="float-right" onclick="lastOpendQuickStatus = '{{$orderCounter}}'; document.getElementById('quick-status-select-{{$orderCounter}}').classList.toggle('hidden')">
                                <svg id="open-quick-status-{{$orderCounter}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                              </button>
                              <div class="float-right border border-gray-400 rounded-full pt-0.5 mr-2 h-6 w-6">
                                <p class="text-center text-xs text-gray-600">22</p>
                              </div>
                            </div>
                           </div>
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            <p class="ml-6 px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-red-200 text-red-600">Dennis</p>
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">@isset($users->where("id", $order->employee)->first()->username){{$users->where("id", $order->employee)->first()->username}}@endisset</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black m-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>                            
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black"><div class="ml-6 px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-green-200 text-green-600"><p>7 Tage</p></div></td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            @isset ($order->userTracking[0]->process_id)
                            <a href="{{url("/")}}/crm/tracking/auftrag-aktiv-{{$order->process_id}}" onclick="loadData()">
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
                                  
                                  @if ($order->userTracking[0]->trackings[0]->code != null)
                                    @if ($order->userTracking[0]->trackings[0]->code->icon == "truck")
                                    <div class="w-7 h-7 border border-yellow-600 rounded-full hover:bg-yellow-100">

                                        <svg id="icon-svg-truck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="m-auto  mt-0.5 ml-0.5 text-yellow-600 w-5 h-5">
                                          <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.771-.59-1.43-1.375-1.489A41.568 41.568 0 006.5 3zM2 12v2.5A1.5 1.5 0 003.5 16h.041a3 3 0 015.918 0h.791a.75.75 0 00.75-.75V12H2z" />
                                          <path d="M6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.25 5a.75.75 0 00-.75.75v8.514a3.001 3.001 0 014.893 1.44c.37-.275.61-.719.595-1.227a24.905 24.905 0 00-1.784-8.549A1.486 1.486 0 0014.823 5H13.25zM14.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                      </div>
                                    @endif

                                    @if ($order->userTracking[0]->trackings[0]->code->icon == "doc")
                                    <div class="w-7 h-7 border border-green-600 rounded-full hover:bg-green-100">

                                      <svg id="icon-svg-doc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-green-600 w-5 h-5 mt-0.5 m-auto" style="margin-left: 0.21rem;">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                      
                                    </div>
                                    @endif

                                    @if ($order->userTracking[0]->trackings[0]->code->icon == "warning")
                                    <div class="w-7 h-7 border border-red-600 rounded-full hover:bg-red-100">

                                    <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 mt-0.5 ml-0.5 w-5 h-5 m-auto">
                                      <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    </div>
                                    @endif

                                  @else
                                  
                                  <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-5 h-5 m-auto">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                  </svg>
                                  @endif
                              @endif
                            </a>
                            
                            @endisset
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black m-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                            </svg>                        
                          </td>
                          <td class="whitespace-nowrap text-center py-1 text-sm text-black">
                            1_ecu_pl
                          </td>
                          <td class="whitespace-nowrap text-right pr-2 py-1 text-sm ">
                            @isset ($order->rechnungen[0]->bezeichnung)
                              @php
                                  $usedRechnungen = array();
                                  $gezahlt = 0;
                                  $zuzahlen = 0;
                              @endphp
                                @foreach ($order->rechnungen as $rechnung)
                                    @if (!in_array($rechnung->rechnungsnummer, $usedRechnungen))

                                      @php
                                        array_push($usedRechnungen, $rechnung->rechnungsnummer);
                                      @endphp

                                      @foreach ($rechnung->zahlungen as $zahlung)
                                          @php
                                              $gezahlt += $zahlung->betrag;
                                          @endphp
                                      @endforeach
                                    @endif
                                    @php
                                    $zuzahlen += $rechnung->bruttobetrag;
                                @endphp
                                @endforeach

                               
                               

                                @if($zuzahlen - $gezahlt < 0)
                                  <p class="text-gray-600 float-right">+{{number_format($gezahlt - $zuzahlen, 1)}} &#8364;</p>
                                @else
                                  @if ($zuzahlen - $gezahlt == 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-6 h-6 text-green-600">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>                                  
                                  @else
                                    <p class="text-red-600 float-right">{{$gezahlt - $zuzahlen}} &#8364;</p>
                                  @endif
                                @endif

                                @isset($order->rechnungen[0]->rechnungsnummer)
                                @if ($order->rechnungen->where("rechnungsnummer", $order->rechnungen[0]->rechnungsnummer)->where("bezeichnung", "Nachnahme")->first() != null)
                                  <p class="float-right mr-2 text-xs text-gray-400 mt-0.5">NN</p>
                                @endif
                              @endisset
                                
                              @else

                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-600 float-right">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                              </svg>                              

                            @endisset
                            
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black ">
                            <button type="button" onclick="showOrderChangeModal('{{$order->process_id}}')">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 hover:text-blue-400 float-right mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                              </svg>       
                            </button>  
                            <input type="hidden" id="order-id-row-{{$orderCounter}}" value="{{$order->process_id}}">                   
                          </td>
                          
                        </tr>
                      @php
                          $orderCounter++;
                      @endphp
                      @endforeach
        
                      <!-- More people... -->
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
  
  <div id="email-inbox-div">

  </div>
<div id="testdiv">

</div>
<form action="{{url("/")}}/crm/orders-sort" method="POST">
  @CSRF
  <input type="hidden" id="status-filter" name="status">
  <input type="hidden" name="field" id="field-filter">
  <input type="hidden" name="direction" id="direction-filter">
  <input type="hidden" name="buchhaltung" id="buchhaltung-filter">
  <input type="hidden" name="count" id="count-filter">
  <button type="submit" class="hidden border-blue-400" id="submit-filter"></button>
</form>

<form action="{{url("/")}}/crm/set-quick-status" method="POST">
@CSRF 
<input type="hidden" id="quick-status-value" name="status">
<input type="hidden" id="quick-status-process_id-value" name="process_id">
<button type="submit" class="hidden" id="submit-quick-status"></button>
</form>

<script>
  var lastOpendQuickStatus = "0";
  function setNewQuickStatus(id, process_id) {

    loadData();

    $.get("{{url("/")}}/crm/status/check-reklamation-"+id + "-" + process_id, function(data) {
      if(data != "ok" && data != "one-device") {

        document.getElementById("reklamation-select-device").innerHTML = data;

        document.getElementById("reklamation-select-status").value = id;

        savedPOST();

      } else {
        if(data = "one-device") {

         document.getElementById("reklamation-one-device").value = process_id;
         document.getElementById("reklamation-one-device-status").value = id;

         document.getElementById("reklamation-one-device-button").click();

        } else {
          document.getElementById('quick-status-value').value = id;
          document.getElementById('quick-status-process_id-value').value = process_id;

          document.getElementById('submit-quick-status').click();
        }
      }
    })

  }

  function toggleReklamationSelectDevice(device) {

if(document.getElementById("device-input-reklamation-select-"+device)) {
    document.getElementById("device-input-reklamation-select-"+device).remove();
    document.getElementById("device-div-reklamation-select-"+device).classList.add("border-gray-300");
    document.getElementById("device-div-reklamation-select-"+device).classList.remove("border-blue-400");
    document.getElementById("device-div-reklamation-select-"+device).classList.add("text-black");
    document.getElementById("device-div-reklamation-select-"+device).classList.remove("text-blue-500");
    document.getElementById("reklamation-select-device-svg-"+device).classList.add("hidden");
    
} else {

    let div = document.getElementById("reklamation-select-inputlist");

    let input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("id", "device-input-reklamation-select-"+device);
    input.value = device;
    input.setAttribute("name", "device-"+device);

    div.appendChild(input);

    document.getElementById("device-div-reklamation-select-"+device).classList.remove("border-gray-300");
    document.getElementById("device-div-reklamation-select-"+device).classList.add("border-blue-400");
    document.getElementById("device-div-reklamation-select-"+device).classList.remove("text-black");
    document.getElementById("device-div-reklamation-select-"+device).classList.add("text-blue-500");
    document.getElementById("reklamation-select-device-svg-"+device).classList.remove("hidden");

}

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
      let allOrders = {{$active_orders->count()}}
      let counter = 0;
      while(counter < allOrders) {
        document.getElementById('quickstatus-input-'+counter).checked = true;
        counter++;
      }

      checkedState = true;
    } else {
      let allOrders = {{$active_orders->count()}}
      let counter = 0;
      while(counter < allOrders) {
        document.getElementById('quickstatus-input-'+counter).checked = false;
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
            if(document.getElementById("datetimepicker-time")) {
              if(!isDescendant(document.getElementById("datepicker-main"), evt.target)) {
                document.getElementById("datetimepicker-time").classList.add('hidden');
              }
            }

            if(document.getElementById("texts-div")) {
              if(!isDescendant(document.getElementById("texts-div-main"), evt.target)) {
                document.getElementById("texts-div").classList.add('hidden');
              }
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
        if(quickClickTimeState == true) {
          console.log(fromManuel);


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

          quickClickTimeState = false;
        } else {
          quickClickTimeState = true;
          setTimeout(
            function() {
              quickClickTimeState = false;
            }, 200);
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
            
            let process_id = document.getElementById('order-id-row-'+counter).value;

            let a = document.createElement("button");
            a.classList.add("text-left", "font-semibold", "text-lg", "text-blue-600", "hover:text-blue-400");
            a.innerHTML = "bearbeiten";
            a.type = "button";
            a.setAttribute("onclick", "showOrderChangeModal('"+ process_id +"')")
            
            div.appendChild(a);
            event.target.appendChild(div);
          }
          counter++;
        }
        event.preventDefault();

      });


      function getEmailInbox() {
        loadData();
        $.get("{{url("/")}}/crm/get-emailinbox", function(data) {
          $('#email-inbox-div').html(data);
          savedPOST();
        });
      }

      function exportOrderData() {
        loadData();
        document.getElementById('multistatus-form').action = '{{url("/")}}/crm/export-order-files';
        document.getElementById("submit-statusquick").click();
        savedPOST();
      }

</script>
</div>

@isset($tracking)
@livewire('custom-tracking', ['process_id' => $tracking])

@endisset


</div>

@include('includes.alerts.main')
@include('includes.alerts.error')
<div id="reklamation-select-device">

</div>
<div id="export-order-div">

</div>

<form action="{{url("/")}}/crm/status/reklamation-one-device" method="POST">
  @CSRF
  <input type="hidden" id="reklamation-one-device" name="device">
  <input type="hidden" id="reklamation-one-device-status" name="status">
  <button class="hidden" type="submit" id="reklamation-one-device-button"></button>
</form>
</body>
</html>