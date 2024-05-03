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
<body onscroll="scrollBody()">
@include('layouts/top-menu', ["menu" => "auftrag"])
@include('includes.orders.buchhaltung-vergleich')


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
          <p class="ml-10 text-sm text-gray-400">von <span class="text-white">@if($users->where("id", $hinweis->employee)->first() != null) {{$users->where("id", $hinweis->employee)->first()->name}} @else {{$hinweis->employee}} @endif</span> am <span class="text-white">{{$hinweis->created_at->format("d.m.Y (H:i)")}}</span></p>


           @endforeach
         </div>
       @endisset
      <div class="h-16 w-full">
        <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Auftragsübersicht
           @isset($filter)- Filter: {{ucfirst($filter)}} @endisset @isset($filterKunde)- Filter: K{{$filterKunde}}, Kunde: {{$active_orders->where("kunden_id", $filterKunde)->first()->firstname}} {{$active_orders->where("kunden_id", $filterKunde)->first()->lastname}} @endisset
          
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
    </div>  

    <div id="statistik-div">
    
      
    </div>

    <script>
      function getStatistik() {
        $.get("{{url("/")}}/crm/auftragsübersicht/statistik", function(data) {
          document.getElementById("statistik-div").innerHTML = data;
        })
      }
    </script>

        @if (isset($hilfscodes[0]))
          @if ($hilfscodes[0]->archiv == null || $hilfscodes[0]->archiv == 1)
            @if ($hilfscodes->where("archiv", null)->first() != null)
            <div class="mt-4 flow-root" style="width: 25rem">
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
                  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th class="py-1 pl-2 text-left text-sm font-semibold text-gray-900">
                            Erstellt
                          </th>
                          <th class="py-1 pl-2 text-left text-sm font-semibold text-gray-900">
                            Hilfsbarcode
                          </th>
                          <th class="py-1 pr-2 text-right text-sm font-semibold text-gray-900">
                            Aktion
                          </th>
                        </tr>
                        @foreach ($hilfscodes->where("archiv", null) as $code)
                        <tr class="bg-red-200 border-l-0 border-r-0">
                          <td class="whitespace-nowrap  py-1 text-sm text-black pl-2">{{$code->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap text-left pl-2 py-1 text-sm text-black">{{$code->process_id}}</td>
                          <td class="whitespace-nowrap text-right py-1 text-sm text-black ">
                            <a class="text-blue-600 hover:text-blue-400 pr-2" href="{{url("/")}}/crm/wareneingang-zuweisen-{{$code->process_id}}">
                              Auftrag zuweisen
                            </a>  
                          </td>
                          
                        </tr>
                        @endforeach
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            @endif
          @endif
        @endif
                    

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
                          <input onclick="document.getElementById('set-status-dropdown').classList.remove('hidden'); if(this.checked == true) { checkedState = false; document.getElementById('quickstatus-input-bottom').checked = false } selectAllOrders()" id="main-checkbox" type="checkbox" class="border-gray-400 rounded-sm w-4 h-4">
                          
                          <div id="set-status-dropdown" class="fixed hidden inline-block text-left">
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

                              <div class="mt-4">
                                <button type="button" onclick="document.getElementById('quick-message-modal').classList.remove('hidden')" class="mt-4 inline-flex w-full justify-center gap-x-1.5 rounded-md bg-blue-600 hover:bg-blue-400 px-3 py-1 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                  neue Auftraginfo

                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                  </svg>
                                  
                                  
                                </button>                              </div>
                            </div>
                          
                            <div id="quick-message-modal" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
                              <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
                              <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                                <div class="modal-content py-4 text-left px-6">
                                  <div class="flex justify-between items-center pb-3">
                                    <p class="text-2xl font-bold">neue Auftragsnachricht</p>
                                    <div onclick="document.getElementById('quick-message-modal').classList.add('hidden')" class="modal-close hover:text-blue-400 text-gray-600 cursor-pointer z-50">
                                      <svg  class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M18 1.5L16.5 0 9 7.5 1.5 0 0 1.5 7.5 9 0 16.5 1.5 18 9 10.5 16.5 18 18 16.5 10.5 9z" />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
                                      Nachricht
                                    </label>
                                    <textarea name="message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message-quick" type="text" placeholder=""></textarea>
                                  </div>

                                  <div class="flex justify-between pt-2">
<script>
  function postMessageNew() {
    document.getElementById('multistatus-form').action = '{{url("/")}}/crm/auftrag/neuer-text-quick';

    document.getElementById("submit-message-quick").click();
  }
</script>
                                    <button onclick="postMessageNew()" id="save-message" class="px-4 py-2 bg-blue-800 text-gray-100 rounded hover:bg-blue-700 focus:outline-none focus:bg-blue-700" type="button">Speichern</button>
                                    <button onclick="document.getElementById('quick-message-modal').classList.add('hidden')" class="modal-close hover:text-blue-400 px-4 py-2 bg-white border border-gray-400 text-black rounded" type="button">Abbrechen</button>
                                    <button class="hidden" id="submit-message-quick" type="submit"></button>
                                  </div>

                                </div>
                              </div>
                            </div>

                            <div id="select-status-quick" class="hidden absolute left-0 z-50 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                              <div class="py-1" role="none">
                                <div class="px-4 py-3">
                                  <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                  <select id="location" name="multistatus-status" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
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
                        
                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          <div class="flex float-left">
                            
                            @isset($sorting)
                            @if ($sorting == "created_at-up")
                            <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "created_at-down")
                            <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4   mt-0.5 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                              </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
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
                         <div class="float-left flex">
                          
                          @isset($sorting)
                          @if ($sorting == "process_id-up")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "process_id-down")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4   mt-0.5 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @endisset

                          <p class="ml-2">Auftrag</p>
                         </div>
                          
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Kunde
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        
                          <div class="float-left flex">
                          
                            @isset($sorting)
                            @if ($sorting == "firstname-up")
                            <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-down">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                              
                             
                                                            
                            
                            </a>@else
                            @if ($sorting == "firstname-down")
                            <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4   mt-0.5 ">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @else 
                            <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                              </svg>
                              </a>
                            @endif
                            @endif
                            @else 
                            <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  mt-0.5 ">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                              </svg>
                            </a>
                            @endisset
  
                            <p class="ml-2">Name</p>
                           </div>                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                          Fahrzeug
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                         
                          Telefonnummer
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          <div class="float-left flex">
                            @isset($sorting)
                          @if ($sorting == "status-up")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-status-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "status-down")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
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

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                         <div class="float-left flex">
                          @isset($sorting)
                          @if ($sorting == "updated_at-up")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-updated_at-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "updated_at-down")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-updated_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-updated_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-updated_at-up">
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

                        <th scope="col" class=" py-3.5 text-center text-sm font-semibold text-gray-900">
                          
                        Workflow
                      </th>

                     

                        <th scope="col" class=" py-3.5 text-left ml-3 text-sm font-semibold text-gray-900">
                          
                          Monitor
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">

                          Track
                        </th>

                        <th scope="col" class=" py-3.5 text-center pr-2 text-sm font-semibold text-gray-900">
                         
                          P
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                          
                         Zuteilung
                        </th>

                        <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900 pr-2">
                            
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-right">
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
                            @include('components.orders-filter')
                          </div>
                        </th>

                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      @php
                          $orderCounter = 0;
                          $workflowCount = 0;
                      @endphp
                     
                    @if(isset($sorting))
                        @if ($sorting == "status-up")
                          @php
                            $active_orders = $active_orders->sortByDesc(function($order) use ($allStats) {
                              return $allStats->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                            });
                          @endphp
                        @endif
                          @if ($sorting == "status-down")
                            @php
                              $active_orders = $active_orders->sortBy(function($order) use ($allStats) {
                                return $allStats->where('id', $order->statuse->sortByDesc('created_at')->first()->last_status)->first()->name;
                              });
                            @endphp
                          @endif
                      @endif
                     

                      @php
                      $gesamt = 0;
                  @endphp
                  @php
                      if(isset($area)) {
                        if($area == "activ") {
                          $active_orders = $active_orders->where("archiv", false);
                        } else {
                          if($area == "archiv") {
                            $active_orders = $active_orders->where("archiv", true);
                          } else {
                            $active_orders = $active_orders;
                          }
                        }
                      } else {
                        if($active_orders != null) {
                          $active_orders = $active_orders->where("archiv", false);
                        }
                      }
                  @endphp
                      @foreach ($active_orders as $order)


                        @if ($order != null)
                        <tr class="hover:bg-blue-100 border-l-0 border-r-0" id="row-{{$orderCounter}}" onclick="selectOrderDoubleClick('{{$order->process_id}}'); ">
                          <td class="whitespace-nowrap py-  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-{{$orderCounter}}" name="{{$order->process_id}}-order" value="{{$order->process_id}}" onclick="selectQuickStatus('{{$orderCounter}}', 'yes')" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black ">{{$order->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            
                          </td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">{{$order->process_id}}</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">@if($active_orders->where("kunden_id", $order->kunden_id)->count() > 1) <a href="{{url("/")}}/crm/auftragsübersicht-aktiv/filter-{{$order->kunden_id}}" class="text-blue-600 hover:text-blue-400">K{{$order->kunden_id}}</a> @else K{{$order->kunden_id}} @endif</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">
                            <p class="truncate overflow-hidden whitespace-nowrap max-w-xs">{{$order->firstname}} {{$order->lastname}}</p>

                          
                          </td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">@isset($order->deviceData[0]) {{$order->deviceData[0]->car_company}} {{$order->deviceData[0]->car_model}} @endisset</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">{{$order->phone_number ?: $order->mobile_number}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black" >
                           <div>
                            <div style="background-color: {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->color}}" class="px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium">
                              {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->name}}
                              <select id="quick-status-select-{{$orderCounter}}" onchange="setNewQuickStatus(this.value, '{{$order->process_id}}')" name="location" class="absolute hidden mt-2 block w-60 rounded-md border-0 py-1.5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                <option value="">neuen Status wählen</option>
                                @foreach ($allStats->sortBy("name") as $stat)
                                    <option value="{{$stat->id}}">{{$stat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            
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
                          <td class="whitespace-nowrap  py-1 text-sm text-black text-center">
                            @isset($order->zuweisung)
                              @if ($order->zuweisung->count() == 1)          
                                @php
                                  $zw = $order->zuweisung[0];

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
                          <td class="whitespace-nowrap  py-1 text-sm text-black">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">@isset($order->user->name){{$order->user->name}}@endisset</td>
                          
                          <td class="whitespace-nowrap  py-1 text-sm text-black pr-5">

                               @if (!isset($order->workflow[0]))
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600 m-auto">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>  
                                @php
                                    $workflowCount++;
                                @endphp
                              @else
                                @if($order->workflowpause != "pause")          
                                  @if ($order->workflowpause == "error")
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600 m-auto">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                  </svg>                                  
                                  @else
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-600 m-auto">
                                    <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                                  </svg>
                                  
                                  
                                  @endif
                                @else
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600 m-auto">
                                    <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm5-2.25A.75.75 0 017.75 7h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5zm4 0a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5z" clip-rule="evenodd" />
                                  </svg>                                 
                                @endif                                                 
                               @endif               
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black"><div class=" px-2 float-left py-0.5 text-sm rounded-xl text-left font-medium bg-green-200 text-green-600"><p>7 Tage</p></div></td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            @isset ($order->userTracking[0]->process_id)
                            <button onclick="getTracking('{{$order->process_id}}')" type="button" class="text-blue-600 hover:text-blue-400">
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
                                  
                                  @if (isset($order->userTracking[0]->trackings[0]->code))
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
                              @endif
                                </button>
                            @else
                            <button onclick="getTracking('{{$order->process_id}}')" type="button" class="text-blue-600 hover:text-blue-400">
                              neuer Tracker
                            </button>
                            @endisset
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-black">
                            
                            @if (isset($order->warenausgang[0]->process_id) || isset($order->intern[0]->process_id))
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                            </svg>      
                            @endif                         
                          </td>
                          <td class="whitespace-nowrap text-left py-1 text-sm text-black">
                            1_ecu_pl
                          </td>
                          <td class="whitespace-nowrap text-right  py-1 text-sm pr-2">
                           
                            @isset ($order->rechnungen[0]->bezeichnung)
                              @php
                                  $usedRechnungen = array();
                                  $gezahlt = 0;
                                  $zuzahlen = 0;
                                  $length = false;
                              @endphp
                                @foreach ($order->rechnungen as $rechnung)
                                  @if (strlen($rechnung->rechnungsnummer) != 4)
                                      @php
                                          $length = true;
                                      @endphp
                                  
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
                               @endif
                                @endforeach
                                @php
                                if (isset($order->einkäufe[0])) {
                                  foreach($order->einkäufe as $einkauf) {
                                    $zuzahlen += $einkauf->price;
                                  }
                                }
                                $gesamt += -$zuzahlen + $gezahlt;
                            @endphp
                               
                               

                                @if($zuzahlen - $gezahlt < 0)
                                  <p class="text-gray-600 float-right">+{{number_format($gezahlt - $zuzahlen, 2, ",", ".")}}  &#8364;</p>
                                @else
                                  @if ($zuzahlen - $gezahlt == 0)
                                    @if ($length == false)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-yellow-600 float-right">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>        
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-5 h-5 text-green-600">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>   
                                    @endif                      
                                  @else
                                    <p class="text-red-600 float-right">{{number_format($gezahlt - $zuzahlen, 2, ",", ".")}} &#8364;</p>
                                  @endif
                                @endif

                                @isset($order->rechnungen[0]->rechnungsnummer)
                                @if ($order->rechnungen->where("rechnungsnummer", $order->rechnungen[0]->rechnungsnummer)->where("bezeichnung", "Nachnahme")->first() != null)
                                  @if ($length == true)
                                  <p class="float-right mr-2 text-xs text-gray-400 mt-0.5">NN</p>
                                  @endif
                                @endif
                              @endisset
                                
                              @else

                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-yellow-600 float-right">
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
                            <script>
                              $(document).on("middleclick", "#row-{{$orderCounter}}", function (e) {
                                showOrderChangeModal('{{$order->process_id}}')
                              });
                            </script>            
                          </td>
                          
                        </tr>
                        @endif
                      @php
                          $orderCounter++;
                      @endphp

                      
                      @endforeach

                      @isset ($buchhaltung)
                          <tr>
                            <td></td>
                            <td class="font-semibold">Gesamtsumme</td>
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right text-sm pr-2">
                              @if($gesamt > 0)
                                  <p class="text-gray-600 float-right">+{{number_format($gesamt, 2, ",", ".")}}  &#8364;</p>
                                @else
                                  @if ($gesamt == 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-6 h-6 text-green-600">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>                                  
                                  @else
                                    <p class="text-red-600 float-right">{{number_format($gesamt, 2, ",", ".")}} &#8364;</p>
                                  @endif
                                @endif
                            </td>
<td></td>
                          </tr>
                      @endisset

                      <tr >
                        <td class="whitespace-nowrap py-4  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-bottom" name="all" onclick=" if(this.checked == true) { checkedState = false; document.getElementById('main-checkbox').checked = false } selectAllOrders();" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
                        <td><p class="absolute" style="margin-top: -1.1rem;">alle Auswählen ({{$orderCounter}} Aufträge) 
                        
                          <select style="padding-right: 0px; padding-bottom: 0px; padding-top: 0px;" name="bottom-sel" class="rounded-md border-gray-300 h-7 w-60 ml-4 mt-1.5">
                            <option value="archiv">Zum Archiv</option>
                            <option value="archiv">Zu Interessenten</option>
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
                        <td></td>


                      </tr>
        
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
  <input type="hidden" id="von-filter" name="von">
  <input type="hidden" id="bis-filter" name="bis">
  <input type="hidden" name="field" id="field-filter">
  <input type="hidden" name="direction" id="direction-filter">
  <input type="hidden" name="buchhaltung" id="buchhaltung-filter">
  <input type="hidden" name="count" id="count-filter">
  <input type="hidden" name="area" id="area-filter">
  <input type="hidden" name="zuweisung" id="zuweisung-filter">
  <button type="submit" class="hidden border-blue-400" id="submit-filter"></button>
</form>

<form action="{{url("/")}}/crm/set-quick-status" method="POST">
@CSRF 
<input type="hidden" id="quick-status-value" name="status">
<input type="hidden" id="quick-status-process_id-value" name="process_id">
<button type="submit" class="hidden" id="submit-quick-status"></button>
</form>

<script>
  $(document).on("mousedown", function (e1) {
  if (e1.which === 2) {
    $(document).one("mouseup", function (e2) {
      if (e1.target === e2.target) {
        var e3 = $.event.fix(e2);
        e3.type = "middleclick";
        $(e2.target).trigger(e3);
      }
    });
  }
}); 

  var lastOpendQuickStatus = "0";
  function setNewQuickStatus(id, process_id) {
    
    loadData();

    $.get("{{url("/")}}/crm/status/check-reklamation-"+id + "-" + process_id, function(data) {
      if(data != "ok" && data != "one-device") {

        document.getElementById("reklamation-select-device").innerHTML = data;

        document.getElementById("reklamation-select-status").value = id;

        savedPOST();

      } else {
        if(data == "one-device") {

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
    document.getElementById("von-filter").value = document.getElementById("von-dropdown").value;
    document.getElementById("bis-filter").value = document.getElementById("bis-dropdown").value;
    document.getElementById("area-filter").value = document.getElementById("area-dropdown").value;
    document.getElementById("zuweisung-filter").value = document.getElementById("zuweisung-dropdown").value;

    document.getElementById("submit-filter").click();

  }

  var checkedState = false;
  function selectAllOrders() {

    if(checkedState == false) {
      let allOrders = {{$active_orders->count()}}
      let counter = 0;
      while(counter < allOrders) {
        document.getElementById('quickstatus-input-'+counter).checked = true;
        document.getElementById('row-'+counter).classList.add('bg-blue-100');

        counter++;
      }

      checkedState = true;
    } else {
      let allOrders = {{$active_orders->count()}}
      let counter = 0;
      while(counter < allOrders) {
        document.getElementById('quickstatus-input-'+counter).checked = false;
        document.getElementById('row-'+counter).classList.remove('bg-blue-100');
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

            if (!isDescendant(document.getElementById("filter-button"), evt.target)) {
              if (isDescendant(motherDiv, evt.target) == false) {
                if (document.getElementById("orders-filter-dropdown")) {
                  document.getElementById("orders-filter-dropdown").classList.add("hidden");
                }
              }
            }
            if (evt.target != document.getElementById("open-quick-status-" + lastOpendQuickStatus) && evt.target != document.getElementById("quick-status-select-" + lastOpendQuickStatus)) {
              if (document.getElementById('quick-status-select-' + lastOpendQuickStatus)) {
                document.getElementById('quick-status-select-' + lastOpendQuickStatus).classList.add('hidden');
              }
            }
            if (evt.target != document.getElementById("quick-order-dropdown")) {
              if (document.getElementById("quick-order-dropdown")) {
                document.getElementById("quick-order-dropdown").remove();
              }
            }
            if (document.getElementById("datetimepicker-time")) {
              if (!isDescendant(document.getElementById("datepicker-main"), evt.target)) {
                document.getElementById("datetimepicker-time").classList.add('hidden');
              }
            }
            if (document.getElementById("texts-div")) {
              if (!isDescendant(document.getElementById("texts-div-main"), evt.target)) {
                document.getElementById("texts-div").classList.add('hidden');
              }
            }
            if (document.getElementById("extra-status-div")) {
              if (!isDescendant(document.getElementById("extra-status-div-main"), evt.target)) {
                document.getElementById("extra-status-div").classList.add('hidden');
              }
            }
            if (document.getElementById("tracking-div")) {
              if (!isDescendant(document.getElementById("tracking-div-main"), evt.target)) {
                document.getElementById("tracking-div").classList.add('hidden');
              }
            }
            if (document.getElementById("emailvorlage-div")) {
              if (!isDescendant(document.getElementById("emailvorlagen-main"), evt.target)) {
                document.getElementById("emailvorlage-div").classList.add('hidden');
              }
            }
            
          
      });

      

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

            div.classList.add("absolute", "px-4", "h-16", "rounded-md", "bg-white");
            div.style.left = x+"px";
            div.style.top = y+"px";
            div.setAttribute("id", "quick-order-dropdown");
            
            let process_id = document.getElementById('order-id-row-'+counter).value;

            let b = document.createElement("button");
            b.classList.add("text-left", "font-semibold", "text-lg", "text-blue-600", "hover:text-blue-400");
            b.innerHTML = "bearbeiten";
            b.type = "button";
            b.setAttribute("onclick", "showOrderChangeModal('"+ process_id +"')")

            let a = document.createElement("a");
            a.classList.add("text-left", "font-semibold", "text-lg", "text-blue-600", "hover:text-blue-400", "mt-4");
            a.innerHTML = "neuer Tab öffnen";
            a.href = "{{url('/')}}/crm/auftrag-bearbeiten-"+process_id;
            a.target = "_blank";

            let br = document.createElement("br");
            
            div.appendChild(b);
            div.appendChild(br);
            div.appendChild(a);

            event.target.appendChild(div);
          }
          counter++;
        }
        event.preventDefault();

      });

      let loadingMailbox = false;
      function getEmailInbox() {
        loadData();
        if(loadingMailbox == false) {
          loadingMailbox = true;
          $.get("{{url("/")}}/crm/get-emailinbox", function(data) {
          $('#email-inbox-div').html(data);
          savedPOST();
          loadingMailbox = false;
        });
        }
      }

      function exportOrderData() {
        loadData();
        document.getElementById('multistatus-form').action = '{{url("/")}}/crm/export-order-files';
        document.getElementById("submit-statusquick").click();
        savedPOST();

        document.getElementById("from_date").setAttribute("required", "");
        document.getElementById("to_date").setAttribute("required", "");
      }

      function getTracking(id) {
        loadData()
        $.get("{{url("/")}}/crm/tracking-get/"+id, function(data) {
          document.getElementById("custom-tracking-div").innerHTML = data;
          $('#newTrackingIdForm').ajaxForm(function(data) { 
              getTracking(data["process_id"]);
              savedPOST();
          }); 
          savedPOST();
        });
      }
      
      let usedInput = "";
    let called = false;
    function changeDeviceInput(id) {

        if(document.getElementById("component-"+id).classList.contains("hidden")) {
            if(usedInput != "") {
                
                    if(usedInput != id) {
                      changeDeviceInput(usedInput);
                    }
                
            }
            document.getElementById("component-"+id).classList.remove("hidden");
            document.getElementById("model-"+id).classList.remove("hidden");
            document.getElementById("fin-"+id).classList.remove("hidden");
            if(document.getElementById("shelfe-"+id)) {
              document.getElementById("shelfe-"+id).classList.remove("hidden");
            }
            document.getElementById("info-"+id).classList.remove("hidden");
            document.getElementById("sticker-"+id).classList.remove("hidden");
            document.getElementById("opened-"+id).classList.remove("hidden");

            document.getElementById("device-component-"+id).classList.add("hidden");
            if (document.getElementById("device-model-"+id)) {
                document.getElementById("device-model-"+id).classList.add("hidden");
            }
            if (document.getElementById("device-fin-"+id)) {
                document.getElementById("device-fin-"+id).classList.add("hidden");
            }
            if (document.getElementById("device-shelfe-"+id)) {
                document.getElementById("device-shelfe-"+id).classList.add("hidden");
            }
            document.getElementById("device-info-"+id).classList.add("hidden");
            document.getElementById("device-sticker-"+id).classList.add("hidden");
            document.getElementById("device-opened-"+id).classList.add("hidden");

            document.getElementById("submit-device-"+id).classList.remove("hidden");
            document.getElementById("change-device-"+id).classList.add("hidden");

            usedInput = id;
        } else {
            if(usedInput == id) {
              usedInput = "";
                called = false;
            }

            document.getElementById("component-"+id).classList.add("hidden");
            document.getElementById("model-"+id).classList.add("hidden");
            document.getElementById("fin-"+id).classList.add("hidden");
            if(document.getElementById("shelfe-"+id)) {
              document.getElementById("shelfe-"+id).classList.add("hidden");
            }
            document.getElementById("info-"+id).classList.add("hidden");
            document.getElementById("sticker-"+id).classList.add("hidden");
            document.getElementById("opened-"+id).classList.add("hidden");

            document.getElementById("device-component-"+id).classList.remove("hidden");
            if (document.getElementById("device-model-"+id)) {
                document.getElementById("device-model-"+id).classList.remove("hidden");
            }
            if (document.getElementById("device-fin-"+id)) {
                document.getElementById("device-fin-"+id).classList.remove("hidden");
            }
            if (document.getElementById("device-shelfe-"+id)) {
                document.getElementById("device-shelfe-"+id).classList.remove("hidden");
            }
            document.getElementById("device-info-"+id).classList.remove("hidden");
            document.getElementById("device-sticker-"+id).classList.remove("hidden");
            document.getElementById("device-opened-"+id).classList.remove("hidden");



            document.getElementById("submit-device-"+id).classList.add("hidden");
            document.getElementById("change-device-"+id).classList.remove("hidden");
        }
    }

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


</script>
</div>

<div id="custom-tracking-div">

</div>

</div>

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

</form>
</body>
</html>