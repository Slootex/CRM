<div class="absolute inline-block text-left h-96 hidden z-50" id="orders-filter-dropdown">
    <div class="absolute right-0 z-50 mt-2 w-60 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
      <div class="py-1" role="none">
        <div class="px-6 py-2">
            <div class="float-left mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                  </svg>                  
            </div>
            <div class="float-right ml-1">
                <p class="font-bold">Statusfilter</p>     
                <select id="status-dropdown" name="location" class=" block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="all">Alle</option>
                    @if ($statuses->count() <= 2)
                        @isset($statuses[0]->id)
                        <option value="{{$statuses[0]->id}}" selected>{{$statuses[0]->name}}</option>
                        @endisset
                    @endif
                    @foreach ($allStats->sortBy("name") as $stat)
                        <option value="{{$stat->id}}">{{$stat->name}}</option>
                    @endforeach
                  </select>
            </div>
        </div>

        <div class="px-6 py-2 mt-14">
            <div class="float-left mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                  </svg>            
            </div>
            <div class="float-right ml-1">
                <p class="font-bold">Sortierfeld</p>     
                <select id="field-dropdown" name="location" class=" block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="created_at">Erstellt</option>
                    <option value="process_id">Auftrag</option>
                    <option value="kunden_id">Kunde</option>
                    <option value="firstname">Name</option>
                    <option value="car_model">Fahrzeug</option>
                    <option value="phone_number">Telefonnummer</option>
                    <option value="status">Status</option>
                    <option value="updated_at">Geändert</option>
                    <option value="employee">Mitarbeiter</option>

                  </select>
            </div>
        </div>

        <div class="px-6 py-2 mt-14">
            <div class="float-left mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                  </svg>     
            </div>
            <div class="float-right ml-1">
                <p class="font-bold">Sortierrichtung</p>     
                <select id="direction-dropdown" name="location" class=" block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="up" @if(isset($sorting)) @if(explode("-", $sorting)[1] == "up") selected @endif @endif>Aufsteigend</option>
                    <option value="down" @if(isset($sorting)) @if(explode("-", $sorting)[1] != "up") selected @endif @endif>Absteigend</option>
                  </select>
            </div>
        </div>

        <div class="px-6 py-2 mt-14">
            <div class="float-left mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                  </svg>
                  
            </div>
            <div class="float-right ml-1">
                <p class="font-bold">Zuweisungen</p>     
                <select id="buchhaltung-dropdown" name="zuweisung" class=" block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="">Auswählen</option>  
                  @foreach ($users as $user)
                      <option value="{{$user->id}}">{{$user->username}}</option>
                  @endforeach
                  </select>
                  @isset($sort_type)
                  <script>
                    document.getElementById("field-dropdown").value = "{{$sort_type}}";
                  </script>
                  @endisset
            </div>
        </div>

        

        <div class="px-6 py-2 mt-14">
            <div class="float-left mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                  </svg>
                     
            </div>
            <div class="float-right ml-1">
                <p class="font-bold">Einträge pro Seite</p>     
                <select id="count-dropdown" name="location" class=" block w-36 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="300">300</option>
                    <option value="500">500</option>

                  </select>
                  
            </div>
        </div>
        @isset($sort_count)
        <script>
          document.getElementById("count-dropdown").value = "{{$sort_count}}";
        </script>
        @endisset
        <div class="h-14 bg-gray-100">
            <hr class="mt-16">
            <button type="button" onclick="window.location.href = '{{url("/")}}/crm/interessentenübersicht-aktiv'" class="float-left w-28 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block m-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
    Reset                  
            </button>

            <button type="button" onclick="submitSort()" class="float-right w-28 mt-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block m-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  
    Ok                  
            </button>
        </div>
       
      </div>
    </div>
  </div>