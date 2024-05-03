<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-white"><p class="float-left">Einstellungen</p> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Lager</h1>
    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">

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
            <a href="#" class="bg-gray-600 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Lagerplatzverwaltung</span> </a>

      
            <a href="{{url('/')}}/crm/status/neu" class="bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-800 px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Neue Lagerplätze anlegen</span> </a>

           
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
        
       
          

          <div class="rounded-xl" id="custom">
            
  
            <div class="mt-10 rounded-xl">
                  <div class="m-auto" style="width: 50rem;">
                    <h1></h1>
                    <table class="m-auto divide-y divide-gray-300 rounded-xl w-full">
                      <thead class="bg-gray-50">
                        <tr>
                          <th class="rounded-tl-lg "><input id="offers" onclick="selectAllShelfes()" aria-describedby="offers-description" name="offers" type="checkbox" class=" h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
                          </th>
                          <th  class=" py-3 text-center font-medium text-normal text-gray-900"><h1 id="shelfe-table-top">Fach</h1> 
                           <a href="#filter" onclick="showActionMenu()">
                            <div id="shelfe-action" class="hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right mr-1 text-yellow-600">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                            </svg>
                            
                            <div class="m-auto border border-gray-600 font-medium bg-white text-center py-.5 pl-2 rounded px-1">
                              
                              <h1 class="">Aktion 
                              </h1> 
                              
                            </div>
                            
                            
                          
                          </div></a>
                             <div id="aktion-filter" class="animate__animated hidden">
                              @include('includes.lagerplatz_aktion')
                             </div>
                            
                          </th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">Status</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">IST-Lager</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">SOLL-Lager</th>
                          <th scope="col" class="px-3 pr-6 py-3 text-right font-medium text-normal text-gray-900 rounded-tr-lg">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                       
                        @php
                            $usedShelfes = array();
                        @endphp
                        @foreach ($shelfes as $shelfe)
                        @if (in_array(explode("A", $shelfe->shelfe_id)[0], $usedShelfes) || in_array(explode("B", $shelfe->shelfe_id)[0], $usedShelfes))
                          <tr>
                            <td class="py-2">
                              <input id="shelfe-checkbox-{{$shelfe->shelfe_id}}" onclick="setFirstSelect('{{$shelfe->shelfe_id}}')" aria-describedby="offers-description" name="offers" type="checkbox" class="ml-3 m-auto h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
                            </td>
                            <td class="text-center font-medium">{{$shelfe->shelfe_id}}</td>
                            <td class="text-center" >Archiv</td>
                            <td class="text-center">leer</td>
                            <td class="text-center"><div id="{{$shelfe->shelfe_id}}-soll">5</div><div ><input type="text" class="w-16 h-4 rounded border-gray-600 text-center hidden" value="5" id="{{$shelfe->shelfe_id}}-soll-input" ></div></td>
                            <td class="float-right mr-2">
                              <button type="button" class="rounded-md bg-blue-50 py-1.5 px-2.5 text-sm font-semibold text-blue-600 shadow-sm hover:bg-blue-100">Bearbeiten</button>
                              <button type="button" class="rounded-md bg-red-300 py-1.5 px-2.5 text-sm font-semibold text-black shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-300">löschen</button>
                            </td>

                          </tr>

                        @else

                         @if (str_contains($shelfe->shelfe_id, "A"))
                             <tr>
                              <td class="py-2">
                                <input id="shelfe-checkbox-{{explode("A", $shelfe->shelfe_id)[0]}}d" onclick="setRegalSelect('{{explode('A', $shelfe->shelfe_id)[0]}}')" aria-describedby="offers-description" name="offers" type="checkbox" class="ml-3 m-auto h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
                              </td>
                              <td class="text-center font-medium">Regal {{explode("A", $shelfe->shelfe_id)[0]}}</td>
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                              <td class="float-right mr-2">
                              </td>
                            
                            </tr>
                            <tr>
                              <td class="py-2">
                                <input id="shelfe-checkbox-{{$shelfe->shelfe_id}}" onclick="setRegalSelect('{{$shelfe->shelfe_id}}')" aria-describedby="offers-description" name="offers" type="checkbox" class="ml-3 m-auto h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
                              </td>
                              <td class="text-center font-medium">{{$shelfe->shelfe_id}}</td>
                              <td class="text-center">Archiv</td>
                              <td class="text-center">leer</td>
                              <td class="text-center"><div id="{{$shelfe->shelfe_id}}-soll">5</div><div><input type="text" class="w-16 h-4 rounded border-gray-600 text-center hidden" value="5" id="{{$shelfe->shelfe_id}}-soll-input" ></div></td>
                              <td class="float-right mr-2">
                                <button type="button" class="rounded-md bg-blue-50 py-1.5 px-2.5 text-sm font-semibold text-blue-600 shadow-sm hover:bg-blue-100">Bearbeiten</button>
                                <button type="button" class="rounded-md bg-red-300 py-1.5 px-2.5 text-sm font-semibold text-black shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-300">löschen</button>
                              </td>
                            
                            </tr>
                         @endif
                          

                          @php
                              if(str_contains($shelfe->shelfe_id, "A")) {
                                array_push($usedShelfes, explode("A", $shelfe->shelfe_id)[0]);
                              }
                              if(str_contains($shelfe->shelfe_id, "B")) {
                                array_push($usedShelfes, explode("B", $shelfe->shelfe_id)[0]);
                              }
                          @endphp

                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @isset($bearbeiten)
              @if ($bearbeiten == true)
              <div>
                @isset($stat) 
                  @include('forEmployees.modals.statusBearbeiten', ["stat" => $stat]) 
                  @else
                  @include('forEmployees.modals.statusBearbeiten')
                @endisset
              </div>
              
              @endif
          @endisset

    </div>
      
    <br>
    <br>
    <br>

    <script>
      let selectedShelfes = [];
      function setFirstSelect(shelfe) {
          if(selectedShelfes.includes(shelfe)) {

            let shelfeCounter = 0;

            selectedShelfes.forEach(item => {

              if(item == shelfe) {
                selectedShelfes.splice(shelfeCounter, 1);
                document.getElementById("shelfe-checkbox-" + shelfe).checked = false;

              }
              shelfeCounter++;

            });
          } else {
            selectedShelfes.push(shelfe);
          }
          if(!selectedShelfes.includes(shelfe)) {
                document.getElementById(shelfe + "-soll-input").classList.add("hidden");
                document.getElementById(shelfe + "-soll").classList.remove("hidden");
                document.getElementById(shelfe + "-soll").innerHTML = document.getElementById(shelfe + "-soll-input").value;
                document.getElementById("shelfe-checkbox-" + shelfe).checked = false;
          } else {
            if(selectedShelfes.length <= 0) {
            document.getElementById("shelfe-table-top").classList.remove("hidden");
            document.getElementById("shelfe-action").classList.add("hidden");
            document.getElementById("shelfe-checkbox-" + shelfe).checked = false;
           

          } else {
            document.getElementById(shelfe + "-soll-input").classList.remove("hidden");
            document.getElementById(shelfe + "-soll").classList.add("hidden");
            document.getElementById("shelfe-action").classList.remove("hidden");
            document.getElementById("shelfe-table-top").classList.add("hidden");
            document.getElementById("shelfe-checkbox-" + shelfe).checked = true;
          }
          }

          
      }

      function setRegalSelect(regal) {
        counter = 1;
        while(counter <= 11) {
            setFirstSelect(regal + "A" + counter);
            setFirstSelect(regal + "B" + counter);
            counter++;

        }
        


      }

      let menuState = false;
      function showActionMenu() {
        document.getElementById("aktion-filter").style.setProperty('--animate-duration', '.25s');
        if(menuState == false) {
          document.getElementById("aktion-filter").classList.add("animate__zoomIn");
          document.getElementById("aktion-filter").classList.remove("animate__zoomOut");
          document.getElementById("aktion-filter").classList.remove("hidden");
          menuState = true;
        } else {
          document.getElementById("aktion-filter").classList.remove("animate__zoomIn");
          document.getElementById("aktion-filter").classList.add("animate__zoomOut");
          setTimeout(() => {
            document.getElementById("aktion-filter").classList.add("hidden");
          }, 250);
          menuState = false;
        }
      }



      let allShelfeState = false;
      function selectAllShelfes() {
        let shelfes = [ @foreach($shelfes as $shelfe) "{{$shelfe->shelfe_id}}", @endforeach "1A2" ];
        checkState = false;
        shelfes.forEach(shelfe => {
          shelfeCounter = 0;
            if(allShelfeState == false) {
              document.getElementById("shelfe-checkbox-" + shelfe).checked = true;
              document.getElementById(shelfe + "-soll-input").classList.remove("hidden");
              document.getElementById(shelfe + "-soll").classList.add("hidden");
              document.getElementById("shelfe-action").classList.remove("hidden");
              document.getElementById("shelfe-table-top").classList.add("hidden");
              if(!selectedShelfes.includes(shelfe)) {
                    selectedShelfes.push(shelfe);
              }
              
              checkState = true;
            } else {
              if(selectedShelfes.includes(shelfe)) {
                selectedShelfes.forEach(item => {
                  if(item == shelfe) {
                    selectedShelfes.splice(shelfeCounter, 1);
                  
                  }
                    shelfeCounter++;

                  });
              }
              
              document.getElementById("shelfe-checkbox-" + shelfe).checked = false;
              document.getElementById(shelfe + "-soll-input").classList.add("hidden");
              document.getElementById(shelfe + "-soll").classList.remove("hidden");
              document.getElementById("shelfe-action").classList.add("hidden");
              document.getElementById("shelfe-table-top").classList.remove("hidden");
              document.getElementById(shelfe + "-soll").innerHTML = document.getElementById(shelfe + "-soll-input").value;
            }
        });
        if(checkState == true) {
          allShelfeState = true;
        } else {
          allShelfeState = false;
        }
      }
    </script>
</body>
</html>