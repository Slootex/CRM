<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none" , "undermenu" => "berechitungen"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-white"><p class="float-left">Einstellungen</p> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Rollen</h1>
    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">

    <div class="mx-auto max-w-full sm:px-6 lg:px-8">

      <div class="mt-6">
        <div class="sm:hidden">
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option>System</option>
      

          </select>
        </div>
        <div class="hidden sm:block">
          <nav class="flex space-x-24" aria-label="Tabs">
            <!-- Current: "bg-gray-200 text-gray-800", Default: "text-gray-600 hover:text-gray-800" -->
      
      
            <a href="{{url('/')}}/crm/rolle/neu" class="bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md"><span class="mr-2">Neue Rolle anlegen</span> </a>

           
          </nav>
        </div>
      </div>

      <script>
        function changeTab(tab, old) {

          document.getElementById(tab).classList.remove("hidden");
          document.getElementById(tab + "tab").classList.remove("text-gray-600");
          document.getElementById(tab + "tab").classList.add("text-blue-600");
          document.getElementById(old + "tab").classList.remove("text-blue-600");
          document.getElementById(old + "tab").classList.add("text-gray-600");
          document.getElementById(old).classList.add("hidden");

        }
      </script>
        
       
        <div class="px-4 sm:px-6 lg:px-8" id="system">
          

            <div class="mt-8 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-auto ">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-3 text-left text-lg font-semibold text-gray-900">Name</th>
                          <th scope="col" class="px-3 py-3 text-right text-lg font-semibold text-gray-900">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($roles as $role)
                        <tr>
                            <td class="whitespace-nowrap px-3 py-3 text-lg text-gray-500">{{$role->name}}</td>
                            <td class="relative whitespace-nowrap py-3 pl-3 pr-1 text-right text-lg font-medium ">
                              <button type="button" onclick="window.location.href = '{{url('/')}}/crm/statuse/bearbeiten/{{$role->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                        @endforeach
          
                        <!-- More people... -->
                      </tbody>
                    </table>

                    <div class="mt-6">
                      <div class="float-left">
                        <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Mitarbeiter</label>
                        <select id="location" name="location" class="mt-2 block w-96 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                          @foreach ($employees as $employee)
                              <option value="{{$employee->id}}">{{$employee->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="float-left px-10">
                        <h1 class="text-xl mt-8 font-bold">-></h1>
                      </div>
                      <div class="float-left">
                        <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Rolle</label>
                        <select id="location" name="location" class="mt-2 block w-96 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                          @foreach ($roles as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @isset($bearbeiten)
              @if ($bearbeiten == true)
              <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="width: 90%" id="bearbeiten">
                <!--
                  Background backdrop, show/hide based on modal state.
              
                  Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
              
                <div class="fixed inset-0 z-10 overflow-y-auto" >
                  <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
                    <!--
                      Modal panel, show/hide based on modal state.
              
                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div style="width: 90%" class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6">
                      <div>
                        
                        <div class="mt-1 text-center sm:mt-1">
                          <div class="mt-2">
                            <div class="w-full bg-gray-100 h-12 mt-0 border-2">
                              <h1 class="text-2xl font-semibold ml-6 mt-1">Bearbeiten</h1>
                            </div>
                            <form action="{{url("/")}}/crm/rolle/neu/" method="POST">
                              @CSRF
                              <br>
                              <label for="name" class="float-left mt-2 mr-6 text-xl">Rollen Name</label>
                              <input type="text" class="w-96 h-8 rounded-lg border-2 border-gray-200 shadow float-left mt-2" id="name" name="name">
                              <br>
                              <br>

                              <button type="button" onclick="changePermTab('siteperm')" class="px-4 py-1 text-xl bg-blue-600 hover:bg-blue-500 text-white hover:bg-blue-800 rounded-lg float-left mt-2 mb-2">Seitenrechte</button>
                              <button type="button" onclick="changePermTab('siteperm')" class="px-4 py-1 text-xl bg-blue-600 hover:bg-blue-500 text-white hover:bg-blue-800 rounded-lg float-left mt-2 mb-2 ml-6">Auftragsrechte</button>

                              <br>
                              <div id="siteperm" class="mt-16 ml-16">
                                <table>
                                  <th>
                                    <td class="px-10 bg-gray-100 rounded-lg text-2xl">Berechtigung</td>
                                    <td class="px-10 bg-gray-100 rounded-lg text-2xl">Aktion</td>
                                  </th>
                                  <tr class="py-2 bg-white">
                                    <td></td>
                                    <td class="text-xl py-2">Aufträge Tab sehen</td>
                                    <td><input id="comments" aria-describedby="comments-description" name="seeOrdersTabPerm" value="seeOrdersTab" type="checkbox" class=" mt-1 h-6 w-6 rounded border-gray-300 text-blue-600 focus:ring-blue-600"></td>
                                  </tr>

                                  <tr class="py-2 bg-gray-50">
                                    <td></td>
                                    <td class="text-xl py-2">Interessenten Tab sehen</td>
                                    <td><input id="comments" aria-describedby="comments-description" name="seeLeadsTabPerm" value="seeLeadsTab" type="checkbox" class=" mt-1 h-6 w-6 rounded border-gray-300 text-blue-600 focus:ring-blue-600"></td>
                                  </tr>

                                  <tr class="py-2 bg-white">
                                    <td></td>
                                    <td class="text-xl py-2">Packtisch Tab sehen</td>
                                    <td><input id="comments" aria-describedby="comments-description" name="seePackingTabPerm" value="seePackingTab" type="checkbox" class=" mt-1 h-6 w-6 rounded border-gray-300 text-blue-600 focus:ring-blue-600"></td>
                                  </tr>

                                 
                                </table>
                              
                              </div>
                              <button class="px-6 px-.5 bg-green-600 rounded-lg text-white text-xl mt-10 ml-16 float-left">Speichern</button>
                              <br>
                              <br>
                              <br>

                            </form>                          
                          </div>
                        </div>
                      </div>
                      <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" onclick="document.getElementById('bearbeiten').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              @endif
          @endisset

    </div>
      
    <br>
    <br>
    <br>
</body>
</html>