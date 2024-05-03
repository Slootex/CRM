<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Steubel Steuergeräte</title>
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
  @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "lagerplatzübersicht-packtisch"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-black">Lagerplatzübersicht @isset($filter)- Filter: {{$filter}} @endisset </h1>

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
          <nav class="flex space-x-10" aria-label="Tabs">
            <button onclick="document.getElementById('create-inventur').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Inventur erstellen</span> </button>

            <button type="button" onclick="document.getElementById('create-entsorgung').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Entsorgungsliste erstellen</span> </button>

            <button type="button" onclick="document.getElementById('uebersicht').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Platzübersicht</span> </button>

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
                  <div class="m-auto" style="">
                    <h1></h1>
                    <table class="m-auto divide-y divide-gray-300 rounded-xl w-full">
                      <thead class="bg-gray-50">
                        <tr>
                          <th class="rounded-tl-lg w-14"><input id="offers" onclick="selectAllShelfes()" aria-describedby="offers-description" name="offers" type="checkbox" class=" h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
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
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">Gerätenummer</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">Auftrag</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">Entsorgung</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">letzter Status</th>
                          <th scope="col" class="px-3 py-3 text-center font-medium text-normal text-gray-900">Inventur</th>
                          <th scope="col" class="px-3 pr-6 py-3 text-right font-medium text-normal text-gray-900 rounded-tr-lg">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($shelfes as $shelfe)
                        @if ($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first() != null)
                        @php
                                                                $usedShelfe = $usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first();

                        @endphp
                        @endif
                            <tr>
                              
                              <td class="py-2">
                                <input id="shelfe-checkbox-{{$shelfe->shelfe_id}}" onclick="setFirstSelect('{{$shelfe->shelfe_id}}')" aria-describedby="offers-description" name="offers" type="checkbox" class=" ml-4 float-left h-5 w-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-300">
                              </td>
                              <td class="text-center">{{$shelfe->shelfe_id}}</td>
                              <td class="text-center text-blue-400">@isset($usedShelfe) <a target="_blank" href="{{url("/")}}/crm/change/order/{{explode('-', $usedShelfe->component_number)[0]}}">{{$usedShelfe->component_number}}</a> @endisset</td>
                              <td class="text-center text-blue-400">@isset($usedShelfe) <a target="_blank" href="{{url("/")}}/crm/change/order/{{explode('-', $usedShelfe->component_number)[0]}}">{{explode('-', $usedShelfe->component_number)[0]}}</a> @endisset</td>
                              <td class="text-center">
                                @if ($usedShelfes->where("shelfe_id", $shelfe->shelfe_id)->first() != null)
                                @isset($usedShelfe->entsorgungssperre)
                                @if ($usedShelfe->entsorgungssperre == "yes")

                                <span class="text-red-600">Gesperrt</span>

                                @else
                              @php
                                $createDate = $usedShelfe->created_at;
                                $nowDate = new DateTime();
                              @endphp
                              @if($usedShelfe->entsorgung != null)
                                {{$createDate->diff($nowDate)->d + $usedShelfe->entsorgung->days}} Tage
                              @else 
                                {{$createDate->diff($nowDate)->d}} Tage
                              @endif
                            @endif
                            @else
                            @isset($usedShelfe)
                            @php
                                  $createDate = $usedShelfe->created_at;
                                  $nowDate = new DateTime();
                                @endphp
                                @if($usedShelfe->entsorgung != null)
                                {{90 - $createDate->diff($nowDate)->d + $usedShelfe->entsorgung->days}} Tage
                                @else 
                                {{90 - $createDate->diff($nowDate)->d}} Tage
                                @endif
                              @else
                              Nicht im Lager Error
                              @endisset
                             
                            @endisset
                                @endif
                                
                                </td>
                              <td class="text-center">
                                @isset($usedShelfe)
                                @php
                                    $process_id = explode("-", $usedShelfe->component_number)[0];
                                @endphp
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">@isset($statushistory->where("process_id", $process_id)->first()->last_status){{$statuses->where("id", $statushistory->where("process_id", $process_id)->sortByDesc("created_at")->first()->last_status)->first()->name}}@endisset</span>
                                @endisset
                              </td>
                              <td class="text-center">
                                <!--<span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">gefunden</span>-->
                              </td>
                              <td>
                                @isset($usedShelfe)
                                <a href="{{url("/")}}/crm/packtisch/lagerplatzübersicht/bearbeiten/{{$usedShelfe->component_number}}" class="bg-blue-100 rounded-md text-blue-600 font-medium px-4 py-2 float-right">bearbeiten</a>
                                @endisset
                              </td>
                            </tr>
                            @php
                                $usedShelfe = null;
                            @endphp
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


@isset($editShelfe)
    @include('forEmployees.modals.editShelfe')
@endisset

  <div class="hidden" id="uebersicht">
    @include('forEmployees.modals.lagerplatzÜbersicht')
  </div>
  <div class="hidden" id="create-inventur">
    @include('forEmployees.modals.createInventur')
  </div>

  <div class="hidden" id="create-entsorgung">
    @include('forEmployees.modals.createEntsorgung')
  </div>

  @if ($errors->any())
  @if ($errors->first() == "entsorgung-beauftragt")
      @include('forEmployees.modals.entsorgungBeauftragAlter')
  @endif
@endif



</body>
</html>