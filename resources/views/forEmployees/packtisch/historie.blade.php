<!DOCTYPE html>
<html lang="en" class="bg-white h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    @vite('resources/css/app.css')
</head>
<body>
  @php
      $minSites = 5;
  @endphp
  @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "historie-packtisch"])

    
   
    <script>
      function changeWindow(t) {
        let windows = ["eingang", "intern", "ausgang"];

        windows.forEach(element => {
          if(element != t) {
            document.getElementById(element).classList.add("hidden");
            document.getElementById(element + "-tab").classList.remove("bg-blue-600", "text-white");
            document.getElementById(element + "-tab").classList.add("bg-gray-300", "text-black");

          } else {
            document.getElementById(element).classList.remove("hidden");
            document.getElementById(element + "-tab").classList.add("bg-blue-600", "text-white");
            document.getElementById(element + "-tab").classList.remove("bg-gray-300", "text-black");

          }
        });
      }
    </script>
    <div>
      <div class="mt-6 ml-8 inline-block">
        <button class=" px-4 rounded-lg py-2 font-medium bg-blue-600 hover:bg-blue-600 text-white hover:text-white shadow" onclick="changeWindow('eingang')" id="eingang-tab">Wareneingang</button>
      </div>
      <div class="mt-6 ml-20 inline-block">
        <button class=" px-4 rounded-lg py-2 font-medium bg-gray-300 hover:bg-blue-600 hover:text-white text-black shadow" onclick="changeWindow('intern')" id="intern-tab">Intern</button>
      </div>
      <div class="mt-6 ml-20 inline-block">
        <button class=" px-4 rounded-lg py-2 font-medium bg-gray-300 text-black hover:text-white hover:bg-blue-600 shadow" onclick="changeWindow('ausgang')" id="ausgang-tab">Warenausgang</button>
      </div>
    </div>
    <div class="px-4 sm:px-6 lg:px-8 " id="eingang">
      
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-4xl font-bold text-black py-3">Packtisch > Wareneingang <span id="filter-text-eingang" class="text-2xl text-gray-500"></span></h1>
          </div>
          
        </div>
        
        <div class="mt-8 flex flex-col ">
          <div class="-my-2 -mx-4  m-auto overflow-x-hidden sm:-mx-6 lg:-mx-8">
            <div class=" m-auto py-2 align-middle md:px-6 lg:px-8 ">
              <div class="shadow m-auto ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y m-auto divide-gray-300  max-">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-3.5 w-48 pl-4 text-left text-sm font-semibold text-gray-900">Erstellt</th>
                      <th scope="col" class=" w-36 py-3.5 text-left text-sm font-semibold text-gray-900">Auftrag</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Typ</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Lagerplatz</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Gerät</th>
                      <th>
                        <svg  onclick="document.getElementById('eingang-filter').classList.toggle('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 cursor-pointer float-right text-gray-500 hover:text-gray-400 mr-2">
                          <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
                        </svg>

                      <form action="{{url("/")}}/crm/packtisch/historie/filter/eingang" id="wareneingang-filter-form" method="POST">
                        @csrf
                        <div id="eingang-filter" class="hidden">
                          <div class="absolute w-10 h-10 bg-white rounded-md drop-shadow-xl  mt-12" style="right: 2rem; transform: rotate(45deg)">

                          </div>
                          <div class="absolute  bg-white drop-shadow-xl mt-16 px-4 py-2" style="right: 1.5rem">
                            <h3 class="text-2xl font-bold text-left">Wareneingang - Zeitfilter</h3>

                            <hr class="mt-4">
                            
                            <div class="mt-6">
                              <div class="float-left mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 mt-3 float-left text-gray-600">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                </svg>
                                
                                      
                              </div>
                              <div class="flex">
                                <div class=" ml-5">
                                  <p class="font-bold text-left">Von</p>  
                                  @php
                                      $currentDate = new DateTime();
                                  @endphp
                                  <div class="">
                                    <input  type="date" id="von-dropdown-eingang" name="von" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}"  class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>      
                                </div>
                              
                                <div class="px-6 mt-8">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                                  </svg>
                                </div>
                              
                                <div class=" mt-1">
                                  <p class="font-bold text-left">Bis</p>  
                                  <div class="">
                                    <input  type="date" id="bis-dropdown-eingang" name="bis" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}" class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>    
                                </div>
                              </div>
                          </div>

                            <div class="">
                                <hr class="mt-6">

                                <button type="button" onclick="document.getElementById('eingang-filter').classList.add('hidden')" class="float-right w-28 mt-4 hover:text-gray-500">
                                  Zurück                 
                                </button>

                                <button type="submit" onclick="loadData(); document.getElementById('eingang-filter').classList.add('hidden')" class="float-left w-28 mt-4 hover:text-blue-400 flex">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  m-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                      </svg> 
                                      Speichern           
                                </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="eingang-table" class="divide-y divide-gray-200 bg-white"> 
                    @foreach ($wareneingang as $eingang)
                        <tr>
                          <td class="py-1 pl-6">{{$eingang->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="py-1 text-blue-600">{{$eingang->process_id}}</td>
                          <td class="py-1 text-left text-blue-600">@if(strlen($eingang->process_id) == 5) Wareneingang @else Hilfsgerät @endif</td>
                          <td class="py-1 text-left">@if($users->where("id", $eingang->employee)->first() != null) {{$users->where("id", $eingang->employee)->first()->username}} @endif</td>
                          <td class="py-1 text-left">@isset($eingang->shelfe->shelfe_id){{$eingang->shelfe->shelfe_id}}@endisset</td>
                          <td class="py-1 text-left">{{$eingang->component_number}}</td>
                          <td></td>
                        </tr>
                    @endforeach
              </tbody>
            </table>
           
                  
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6" id="eingang-sites">
          <div class="float-right">
            <div class="flex">
              @php
              $site = 1;
          @endphp
            @for ($i = 1; $i < $wareneingangCount; $i++)
                @if (0 === ($i % $minSites))

                <div id="{{$site}}-eingang" onclick="getEingangSite('{{$site}}')" class="ml-2 @if($site == 1) bg-blue-600 text-white @else bg-gray-200 text-black @endif rounded-md py-1 px-2 hover:bg-blue-600 hover:text-white cursor-pointer">
                  <p class="text-center ">{{$site}}</p> 
                </div>
                  @php
                      $site++;
                  @endphp
                @endif
          @endfor
                      
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="px-4 sm:px-6 lg:px-8  hidden" id="intern">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-4xl font-bold text-black py-3 ">Packtisch > Intern <span id="filter-text-intern" class="text-2xl text-gray-500"></span></h1>
            </div>
            
          </div>
          
        <div class="mt-8 flex flex-col ">
          <div class="-my-2 -mx-4  m-auto overflow-x-hidden sm:-mx-6 lg:-mx-8">
            <div class=" m-auto py-2 align-middle md:px-6 lg:px-8 ">
              <div class=" shadow m-auto ring-1 ring-black ring-opacity-5 md:rounded-lg ">
                <table class="min-w-full divide-y m-auto divide-gray-300  max-">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-3.5 w-48 pl-4 text-left text-sm font-semibold text-gray-900">Erstellt</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Typ</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                      <th scope="col" class=" py-3.5 text-center text-sm font-semibold text-gray-900">Packtisch Info</th>
                      <th scope="col" class=" py-3.5 text-center text-sm font-semibold text-gray-900">Gerät</th>
                      <th>
                        <svg  onclick="document.getElementById('intern-filter').classList.toggle('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 cursor-pointer float-right text-gray-500 hover:text-gray-400 mr-2">
                          <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
                        </svg>

                      <form action="{{url("/")}}/crm/packtisch/historie/filter/intern" id="intern-filter-form" method="POST">
                        @csrf
                        <div id="intern-filter" class="hidden">
                          <div class="absolute w-10 h-10 bg-white rounded-md drop-shadow-xl  mt-12" style="right: 2rem; transform: rotate(45deg)">

                          </div>
                          <div class="absolute  bg-white drop-shadow-xl mt-16 px-4 py-2" style="right: 1.5rem">
                            <h3 class="text-2xl font-bold text-left">Intern - Zeitfilter</h3>

                            <hr class="mt-4">
                            
                            <div class="mt-6">
                              <div class="float-left mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 mt-3 float-left text-gray-600">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                </svg>
                                
                                      
                              </div>
                              <div class="flex">
                                <div class=" ml-5">
                                  <p class="font-bold text-left">Von</p>  
                                  @php
                                      $currentDate = new DateTime();
                                  @endphp
                                  <div class="">
                                    <input  type="date" id="von-dropdown-intern" name="von" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}"  class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>      
                                </div>
                              
                                <div class="px-6 mt-8">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                                  </svg>
                                </div>
                              
                                <div class=" mt-1">
                                  <p class="font-bold text-left">Bis</p>  
                                  <div class="">
                                    <input  type="date" id="bis-dropdown-intern" name="bis" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}" class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>    
                                </div>
                              </div>
                          </div>

                            <div class="">
                                <hr class="mt-6">

                                <button type="button" onclick="document.getElementById('intern-filter').classList.add('hidden')" class="float-right w-28 mt-4 hover:text-gray-500">
                                  Zurück                 
                                </button>

                                <button type="submit" onclick="loadData(); document.getElementById('intern-filter').classList.add('hidden')" class="float-left w-28 mt-4 hover:text-blue-400 flex">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  m-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                      </svg> 
                                      Speichern           
                                </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="intern-table" class="divide-y divide-gray-200 bg-white"> 
                    @foreach ($intern as $in)
                        <tr>
                          <td class="py-1 pl-6">{{$in->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="py-1 text-left text-blue-600">{{$in->auftrag_id}}</td>
                          <td class="py-1 text-left">@if($users->where("id", $in->employee)->first() != null) {{$users->where("id", $in->employee)->first()->username}} @endif</td>
                          <td class="py-1 text-center">{{$in->info}}</td>
                          <td class="py-1 text-center">{{$in->component_number}}</td>
                        </tr>
                    @endforeach
              </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-6" id="intern-sites">
          <div class="float-right">
            <div class="flex">
              @php
              $site = 1;
          @endphp
            @for ($i = 1; $i < $internCount; $i++)
                @if (0 === ($i % $minSites))

                <div id="{{$site}}-intern" onclick="getInternSite('{{$site}}')" class="ml-2 @if($site == 1) bg-blue-600 text-white @else bg-gray-200 text-black @endif rounded-md py-1 px-2 hover:bg-blue-600 hover:text-white cursor-pointer">
                  <p class="text-center ">{{$site}}</p> 
                </div>
                  @php
                      $site++;
                  @endphp
                @endif
          @endfor
                      
              </div>
            </div>
          </div>
        </div>
      </div>

      </div>

      <div class="px-4 sm:px-6 lg:px-8 hidden" id="ausgang">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-4xl font-bold text-black py-3">Packtisch > Warenausgang <span id="filter-text-ausgang" class="text-2xl text-gray-500"></span></h1>
            </div>
            
          
        </div>
        <div class="mt-8 flex flex-col ">
          <div class="-my-2 -mx-4 o m-auto overflow-x-hidden sm:-mx-6 lg:-mx-8">
            <div class=" m-auto py-2 align-middle md:px-6 lg:px-8 ">
              <div class=" m-auto ring-1 ring-black ring-opacity-5 md:rounded-lg ">
                <table class="min-w-full divide-y m-auto divide-gray-300  ">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-3.5 w-48 pl-4 text-left text-sm font-semibold text-gray-900">Erstellt</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Auftrag</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Typ</th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                      <th scope="col" class=" py-3.5 text-center text-sm font-semibold text-gray-900">Label</th>
                      <th scope="col" class=" py-3.5 text-center text-sm font-semibold text-gray-900">Letzer Status</th>
                      <th scope="col" class="text-center text-sm w-36 font-semibold">
                        <span class="text-center">Aktion</span>
                      </th>
                      <th>
                        <svg  onclick="document.getElementById('ausgang-filter').classList.toggle('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 cursor-pointer float-right text-gray-500 hover:text-gray-400 mr-2">
                          <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
                        </svg>

                      <form action="{{url("/")}}/crm/packtisch/historie/filter/ausgang" id="ausgang-filter-form" method="POST">
                        @csrf
                        <div id="ausgang-filter" class="hidden">
                          <div class="absolute w-10 h-10 bg-white rounded-md drop-shadow-xl  mt-12" style="right: 2rem; transform: rotate(45deg)">

                          </div>
                          <div class="absolute  bg-white drop-shadow-xl mt-16 px-4 py-2" style="right: 1.5rem">
                            <h3 class="text-2xl font-bold text-left">Warenausgang - Zeitfilter</h3>

                            <hr class="mt-4">
                            
                            <div class="mt-6">
                              <div class="float-left mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7 mt-3 float-left text-gray-600">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                </svg>
                                
                                      
                              </div>
                              <div class="flex">
                                <div class=" ml-5">
                                  <p class="font-bold text-left">Von</p>  
                                  @php
                                      $currentDate = new DateTime();
                                  @endphp
                                  <div class="">
                                    <input  type="date" id="von-dropdown-ausgang" name="von" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}"  class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>      
                                </div>
                              
                                <div class="px-6 mt-8">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                                  </svg>
                                </div>
                              
                                <div class=" mt-1">
                                  <p class="font-bold text-left">Bis</p>  
                                  <div class="">
                                    <input  type="date" id="bis-dropdown-ausgang" name="bis" min="2023-01-01" value="{{$currentDate->format("Y-m-d")}}" class="float-left block w-48 rounded-md border-0 py-1.5  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                                  </div>    
                                </div>
                              </div>
                          </div>

                            <div class="">
                                <hr class="mt-6">

                                <button type="button" onclick="document.getElementById('ausgang-filter').classList.add('hidden')" class="float-right w-28 mt-4 hover:text-gray-500">
                                  Zurück                 
                                </button>

                                <button type="submit" onclick="loadData(); document.getElementById('ausgang-filter').classList.add('hidden')" class="float-left w-28 mt-4 hover:text-blue-400 flex">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  m-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                      </svg> 
                                      Speichern           
                                </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="ausgang-table" class="divide-y divide-gray-200 bg-white"> 
                    @php
                        $labelList = array();
                        $warenausgangCount = 0;
                    @endphp
                    @foreach ($warenausgang as $as)
                        @if (!in_array($as->label, $labelList))
                          <tr>
                            <td class="py-1 pl-6">{{$as->created_at->format("d.m.Y (H:i)")}}</td>
                            <td class="py-1 text-left text-blue-600">@if(isset($as->shortcut) && $as->shortcut != "") {{$contacts->where("id", $as->shortcut)->first()->shortcut}} @else {{$as->process_id}} @endif</td>
                            <td class="py-1 text-left">{{$as->ex_space}}</td>
                            <td class="py-1 text-left">@if($users->where("id", $as->employee)->first() != null) {{$users->where("id", $as->employee)->first()->username}} @endif</td>
                            <td class="py-1 text-center text-blue-600"><a target="_blank" href="https://www.ups.com/track?track=yes&trackNums={{$as->label}}&loc=de_de&requester=ST/trackdetails">{{$as->label}}</a></td>
                            <td class="py-1 text-center">@if($trackings->where("label", $as->label)->first() != null)<p class="px-2 py-1 rounded-md bg-red-200 text-red-600 w-60  inline-block text-ellipsis whitespace-nowrap">{{$trackings->where("label", $as->label)->first()->status}}</p>@endif</td>
                            <td class="py-1 text-center text-blue-600"><button onclick="getHistory('{{$as->label}}')">bearbeiten</button></td>
                          </tr>
                          @php
                              array_push($labelList, $as->label);
                              $warenausgangCount++;
                          @endphp
                        @endif
                    @endforeach
              </tbody>
            </table>
           
                  
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6" id="ausgang-sites">
          <div class="float-right">
            <div class="flex">
              @php
              $site = 1;
              @endphp
                @for ($i = 1; $i < $warenausgangCount; $i++)
                    @if (0 === ($i % $minSites))

                    <div id="{{$site}}-ausgang" onclick="getAusgangSite('{{$site}}')" class="ml-2 @if($site == 1) bg-blue-600 text-white @else bg-gray-200 text-black @endif rounded-md py-1 px-2 hover:bg-blue-600 hover:text-white cursor-pointer">
                      <p class="text-center ">{{$site}}</p> 
                    </div>
                      @php
                          $site++;
                      @endphp
                    @endif
              @endfor
                      
              </div>
            </div>
      </div>
     
      <div id="tracking-his">

      </div>

      <script>
        function getHistory(id) {
          loadData();
          $.get("{{url("/")}}/crm/packtisch/allhistory-tracking/"+id, function(data) {
            document.getElementById("tracking-his").innerHTML = data;
            savedPOST();
          })
        }

        function deleteLabelWarenausgang(id) {
          loadData();
          $.get("{{url("/")}}/crm/warenausgang/label/delete/"+id, function(data) {
            document.getElementById('tracking-his').innerHTML = data;
            newAlert("Label gelöscht", "Das Label wurde erfolgreich gelöscht.");
            savedPOST();

          })
        }

        let lastUsedEingangSite = "1";
        function getEingangSite(site) {
          loadData();

          $.get("{{url("/")}}/crm/packtisch/historie/eingang-site-"+site, function(data) {
            document.getElementById("eingang-table").innerHTML = data;

            document.getElementById(site + "-eingang").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-eingang").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedEingangSite + "-eingang").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedEingangSite + "-eingang").classList.remove("bg-blue-600", "text-white");

            lastUsedEingangSite = site;
            savedPOST();
          })
        }

        let lastUsedInternSite = "1";
        function getInternSite(site) {
          loadData();

          $.get("{{url("/")}}/crm/packtisch/historie/intern-site-"+site, function(data) {
            document.getElementById("intern-table").innerHTML = data;

            document.getElementById(site + "-intern").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-intern").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedInternSite + "-intern").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedInternSite + "-intern").classList.remove("bg-blue-600", "text-white");

            lastUsedInternSite = site;
            savedPOST();
          })
        }

        let lastUsedWarenausgangSite = "1";
        function getAusgangSite(site) {
          loadData();

          $.get("{{url("/")}}/crm/packtisch/historie/ausgang-site-"+site, function(data) {
            document.getElementById("ausgang-table").innerHTML = data;

            document.getElementById(site + "-ausgang").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-ausgang").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedWarenausgangSite + "-ausgang").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedWarenausgangSite + "-ausgang").classList.remove("bg-blue-600", "text-white");

            lastUsedWarenausgangSite = site;
            savedPOST();
          })
        }

        function warenausgangBack(id) {
          loadData();

          $.get("{{url("/")}}/crm/warenausgang/zurück/"+id, function(data) {
            document.getElementById('tracking-his').innerHTML = data;
            newAlert("Warenausgang Rückgängig gemacht!", "Das Label wurde gelöscht und ein Einlagerungsauftrag wurde an den Packtisch gesendet. Dieser erstellt automatisch nach abschluss einen Versandauftrag.");
            savedPOST();
          })
        }

        $( document ).ready(function() {
          $('#wareneingang-filter-form').ajaxForm(function(data)  {

            document.getElementById("eingang-table").innerHTML = data;

            site = "1";
            document.getElementById(site + "-eingang").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-eingang").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedWarenausgangSite + "-eingang").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedWarenausgangSite + "-eingang").classList.remove("bg-blue-600", "text-white");
            lastUsedWarenausgangSite = "1";

            let von = document.getElementById("von-dropdown-eingang").value;
            let bis = document.getElementById("bis-dropdown-eingang").value;
            let formattedVon = von.split("-")[2] + "." + von.split("-")[1] + "." + von.split("-")[0];
            let formattedBis = bis.split("-")[2] + "." + bis.split("-")[1] + "." + bis.split("-")[0];

            document.getElementById("filter-text-eingang").innerHTML = " (Filter: Von " + formattedVon + " bis " + formattedBis + ")";

            document.getElementById("eingang-sites").classList.add("hidden");

            savedPOST();
          });

          $('#intern-filter-form').ajaxForm(function(data)  {

            document.getElementById("intern-table").innerHTML = data;

            site = "1";
            document.getElementById(site + "-intern").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-intern").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedWarenausgangSite + "-intern").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedWarenausgangSite + "-intern").classList.remove("bg-blue-600", "text-white");
            lastUsedWarenausgangSite = "1";

            let von = document.getElementById("von-dropdown-intern").value;
            let bis = document.getElementById("bis-dropdown-intern").value;
            let formattedVon = von.split("-")[2] + "." + von.split("-")[1] + "." + von.split("-")[0];
            let formattedBis = bis.split("-")[2] + "." + bis.split("-")[1] + "." + bis.split("-")[0];

            document.getElementById("filter-text-intern").innerHTML = " (Filter: Von " + formattedVon + " bis " + formattedBis + ")";

            document.getElementById("intern-sites").classList.add("hidden");

            savedPOST();
          });
          $('#ausgang-filter-form').ajaxForm(function(data)  {

            document.getElementById("ausgang-table").innerHTML = data;

            site = "1";
            document.getElementById(site + "-ausgang").classList.remove("bg-gray-200", "text-white");
            document.getElementById(site + "-ausgang").classList.add("bg-blue-600", "text-white");

            document.getElementById(lastUsedWarenausgangSite + "-ausgang").classList.add("bg-gray-200", "text-white");
            document.getElementById(lastUsedWarenausgangSite + "-ausgang").classList.remove("bg-blue-600", "text-white");
            lastUsedWarenausgangSite = "1";

            let von = document.getElementById("von-dropdown-ausgang").value;
            let bis = document.getElementById("bis-dropdown-ausgang").value;
            let formattedVon = von.split("-")[2] + "." + von.split("-")[1] + "." + von.split("-")[0];
            let formattedBis = bis.split("-")[2] + "." + bis.split("-")[1] + "." + bis.split("-")[0];

            document.getElementById("filter-text-ausgang").innerHTML = " (Filter: Von " + formattedVon + " bis " + formattedBis + ")";

            document.getElementById("ausgang-sites").classList.add("hidden");

            savedPOST();
          });
        });
        
      </script>
</body>
</html>
