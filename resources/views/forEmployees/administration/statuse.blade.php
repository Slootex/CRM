<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <link rel="stylesheet" href="{{url("/")}}/css/animations.css">
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-black"><p class="float-left">Einstellungen</p> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Statusliste</h1>

    <div class="mx-auto max-w-full sm:px-6 lg:px-8">

      <div class="mt-6">
        <div class="sm:hidden">
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option>System</option>
      
            <option>Custom</option>

          </select>
        </div>
        <div class="hidden sm:block">
          <nav class="flex space-x-24" aria-label="Tabs">
            <!-- Current: "bg-gray-200 text-gray-800", Default: "text-gray-600 hover:text-gray-800" -->
            <a href="#" onclick="changeTab('system', 'custom')" id="systemtab"  class=" bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md">System</a>
      
            <a href="#" onclick="changeTab('custom', 'system')" id="customtab" class="bg-gray-600 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md">Benutzer</a>
      
            <a href="#" onclick="newStatus()" class="bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md"><span class="mr-2">Neuen Status anlegen</span> </a>

           
          </nav>
        </div>
      </div>

      <script>
        function changeTab(tab, old) {

          document.getElementById(tab).classList.remove("hidden");
          document.getElementById(tab + "tab").classList.remove("bg-gray-600");
          document.getElementById(tab + "tab").classList.add("bg-blue-600","hover:bg-blue-500");
          document.getElementById(old + "tab").classList.remove("bg-blue-600","hover:bg-blue-500");
          document.getElementById(old + "tab").classList.add("bg-gray-600");
          document.getElementById(old).classList.add("hidden");

        }
      </script>
        
       
        <div class="px-4 sm:px-6 lg:px-8" id="system">
          

            <div class="mt-8 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-auto h-96 ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300 rounded-lg">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-3 text-left text-lg font-semibold text-gray-900">Name</th>
                          <th scope="col" class="px-3 py-3 text-right text-lg font-semibold text-gray-900">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @php
                        $counter1 = 0;
                    @endphp
                        @foreach ($systemstatus as $status)
                        <tr>
                            <td class="whitespace-nowrap px-3 py-3 text-lg text-gray-500 @if($counter1 == $systemstatus->count() -1) rounded-bl-lg @endif">{{$status->name}}</td>
                            <td class="relative whitespace-nowrap py-3 pl-3 pr-1 text-right text-lg font-medium @if($counter1 == $systemstatus->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="window.location.href = '{{url('/')}}/crm/statuse/bearbeiten/{{$status->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                        @php
                        $counter1++;
                    @endphp
                        @endforeach
          
                        <!-- More people... -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-xl hidden" id="custom">
            
  
            <div class="mt-16 rounded-xl">
                  <div class="">
                    <table class="m-auto divide-y divide-gray-300 rounded-xl" id="custom-status">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900 rounded-tl-lg">Name</th>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900">Bereich</th>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900">E-Mail Template</th>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900">Webseite (frontend)</th>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900">Kunde</th>
                          <th scope="col" class="px-3 py-3 text-center font-normal text-normal text-gray-900">Admin</th>
                          <th scope="col" class="px-3 pr-6 py-3 text-right font-normal text-normal text-gray-900 rounded-tr-lg">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @php
                        $counter2 = 0;
                    @endphp
                        @foreach ($customstatus as $status)
                        <tr id="{{$status->id}}-row">
                            <td class=" px-3 py-1 text-sm  text-center text-gray-500 @if($counter2 == $customstatus->count() -1) rounded-bl-lg @endif"><div id="{{$status->id}}-background-color" style="background-color: {{$status->text_color}}" class="rounded-lg w-auto font-medium"><p class="w-auto" id="{{$status->id}}-text-color" style="color: black">{{$status->name}}</p></div></td>
                            <td class="whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500" id="{{$status->id}}-bereich">@if($status->type == 1) Abholen @endif @if($status->type == 2) Aufträge @endif @if($status->type == 3) Versand @endif @if($status->type == 4) Kunde @endif @if($status->type == 5) Interessent @endif @if($status->type == 6) Einkäufe @endif @if($status->type == 7) Retouren @endif @if($status->type == 8) Packtisch @endif</td>
                            <td class="whitespace-nowrap px-3 py-1  text-center text-sm text-gray-500" id="{{$status->id}}-template">@isset($emails->where("id", $status->email_template)->first()->name){{$emails->where("id", $status->email_template)->first()->name}}@endisset</td>
                            <td class="px-3 py-1 text-sm text-gray-500 text-center font-bold" id="{{$status->id}}-public">@if($status->public == 1) <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                             @endif</td>
                            <td class="whitespace-nowrap  text-center px-3 py-1 text-sm text-gray-500" id="{{$status->id}}-kunde">@if($status->kunde == "yes") <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg> @endif</td>
                            <td class="whitespace-nowrap  text-center px-3 py-1 text-sm text-gray-500" id="{{$status->id}}-admin">@if($status->admin == "yes") <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-center m-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg> @endif</td>
                            <td class="relative whitespace-nowrap  py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter2 == $customstatus->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="readStatus('{{$status->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                        @php
                        $counter2++;
                    @endphp
                        @endforeach
          
                        <!-- More people... -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @include('forEmployees.modals.statusBearbeiten')


    </div>
      
    <br>
    <br>
    <br>
</body>
</html>