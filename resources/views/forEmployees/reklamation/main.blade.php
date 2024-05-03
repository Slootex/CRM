<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>

@include('layouts/top-menu', ["menu" => "reklamation"])

<div class="px-8">
    <div class="pt-5">
      <div class="h-16 w-full">
        @isset($reklamationen[0]->archiv)
        @if ($reklamationen[0]->archiv == "true")
        <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Reklamationsübersicht-Archiv</h1>
      @else
        <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Reklamationsübersicht</h1>
      @endif
      @else
      @if ($_SERVER["REQUEST_URI"] == "/crm/reklamations%C3%BCbersicht-archiv")
      <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Reklamationsübersicht-Archiv</h1>
      @else
      <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Reklamationsübersicht</h1>

      @endif

        @endisset
      </div>
<div>
    <div>
      <div>
        
        <div class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                
                <table class="w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                     
                      
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900 pl-2">
                        
                        <div class=" float-left">
                          Erstellt
                          @isset($sorting)
                          @if ($sorting == "created_at-up")
                          <a href="{{url("/")}}/crm/reklamation/sortieren-created_at-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "created_at-down")
                          <a href="{{url("/")}}/crm/reklamation/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/reklamation/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/reklamation/sortieren-created_at-up">
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
                        @isset($sorting)
                        @if ($sorting == "process_id-up")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-process_id-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "process_id-down")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @endisset
                        
                        Auftrag
                      </th>


                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "firstname-up")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-firstname-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "firstname-down")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Name
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        HSN/TSN
                       </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        Fahrzeug
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        letzter Status
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "kategorie-up")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-kategorie-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "kategorie-down")
                        <a href="{{url("/")}}/crm/reklamation/sortieren-kategorie-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-kategorie-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/reklamation/sortieren-kategorie-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Kategorie
                      </th>


                      

                      
                      <th scope="col" class=" py-3.5 text-right text-sm font-semibold text-gray-900">
                        
                      </th>

                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">

                    @foreach ($reklamationen as $reklamation)
                      <tr class="hover:bg-blue-100">
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 "><p class="ml-2 pl-0.5">{{$reklamation->created_at->format("d.m.Y (H:i)")}}</p></td>
                        <td></td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">{{$reklamation->process_id}}</td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">{{$orders->where("process_id", $reklamation->process_id)->first()->firstname}} {{$orders->where("process_id", $reklamation->process_id)->first()->lastname}}</td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">
                          {{$orders->where("process_id", $reklamation->process_id)->first()->devices->first()->deviceData->hsn}}/
                          {{$orders->where("process_id", $reklamation->process_id)->first()->devices->first()->deviceData->tsn}}
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">
                          {{$orders->where("process_id", $reklamation->process_id)->first()->devices->first()->deviceData->car_company}}
                          {{$orders->where("process_id", $reklamation->process_id)->first()->devices->first()->deviceData->car_model}}
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm  ">
                          <div class="px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium" style="background-color: {{$allStats->where("id", $statusHistory->sortByDesc("created_at")->where("process_id", $reklamation->process_id)->first()->last_status)->first()->color}}">
                            {{$allStats->where("id", $statusHistory->sortByDesc("created_at")->where("process_id", $reklamation->process_id)->first()->last_status)->first()->name}}
                          </div>
                        </td>
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">
                          <form action="{{url("/")}}/crm/reklamation-kategorie-bearbeiten" id="" method="POST">
                            @CSRF
                            <input type="hidden" name="id" value="{{$reklamation->id}}" id="">
                            <select name="kategorie" onchange="document.getElementById('kategorie-verändern-submit').click()" id="" class="block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900  focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                              <option value="Reklamation" @if($reklamation->kategorie == "Reklamation") selected @endif>Reklamation</option>
                              <option value="Nachfrage" @if($reklamation->kategorie == "Nachfrage") selected @endif>Nachfrage</option>
                            </select>
                            <button type="submit" class="hidden" id="kategorie-verändern-submit"></button>
                          </form>
                        </td>
                       
                        <td class="whitespace-nowrap  py-1 text-sm text-gray-500 ">
                                 
                          <a href="{{url("/")}}/crm/reklamation/delete-{{$reklamation->id}}" onclick="loadData()" class="float-right">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-600 hover:text-red-400">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                          </a>         
                          @if ($reklamation->archiv == "true")
                            <a href="{{url("/")}}/crm/reklamation/archiv-toggle-{{$reklamation->id}}" class="float-right mr-2.5">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600 hover:text-green-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                              </svg>
                            </a>   
                          @else
                            <a href="{{url("/")}}/crm/reklamation/archiv-toggle-{{$reklamation->id}}" class="float-right mr-2.5">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600 hover:text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                              </svg>
                            </a>   
                          @endif 
                          <button type="button" onclick="showOrderChangeModal('{{$reklamation->process_id}}')" class="float-right">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3 text-blue-600 hover:text-blue-400 float-right ">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>    
                          </button>
                            
                        </td>
 
                      </tr>

                    @endforeach
      
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </div></div>
</body>
</html>