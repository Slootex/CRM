<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
  <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
@include('layouts/top-menu', ["menu" => "auftrag"])

  <!-- TABLE BODY -->
  <div class="pt-5">
    <div class="h-16 w-full">
      <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left ml-8">Erweiterte-Suche: {{$search_option}}</h1>

    </div>
  </div> 
 
  <div class="px-4 sm:px-6 lg:px-8 mt-3">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        
      </div>
     
    </div>
    <div class="mt-4 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            
<table class="min-w-full divide-y divide-gray-300">
  <thead class="bg-gray-50">
    <tr>
      <th scope="col" class="py-2 pt-2.5 text-left text-sm font-semibold text-gray-900 pl-2">Erstellt</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Auftrag</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Kunde</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Name</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Telefonnummer</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Status</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Geändert</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Versandmonitor</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Packtisch</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Gerät</th>
      <th scope="col" class=" py-2 pt-2.5 text-left text-sm font-semibold text-gray-900">Bereich</th>
      <th scope="col" class=" py-2 pt-2.5 text-center text-sm font-semibold text-gray-900">
        </th>
    </tr>
  </thead>
  <tbody class="divide-y divide-gray-200 bg-white">
    @php
        $tableWhereFound = [
          "active_orders_person_datas" => "Aufträge-Aktiv",
          "rechnungen" => "Aufträge-Aktiv"

  ];
        $usedRow = array();
    @endphp
   @foreach ($orders as $search)
    @if (!in_array($search->process_id, $usedRow))
    @php
    array_push($usedRow, $search->process_id);
@endphp
    <tr onclick="">
      <td class="whitespace-nowrap pl-2 text-sm text-gray-500">{{$search->created_at->format("d.m.Y")}} ({{$search->created_at->format("H:m")}})</td>
      <td class="whitespace-nowrap  text-sm text-gray-500">{{$search->process_id}}</td>
      <td class="whitespace-nowrap  text-sm text-gray-500">K{{$search->kundenid ?: $search->kunden_id}}</td>
      <td class="whitespace-nowrap  text-sm text-gray-500">{{$search->firstname}} {{$search->lastname}}</td>
      <td class="whitespace-nowrap  text-sm text-gray-500">{{$search->phone_number ?: $search->mobile_number}}</td>
      <td class="whitespace-nowrap  text-sm text-gray-500">
        @if ($statusHistory->where("process_id", $search->process_id)->first() != null)
        <p class="px-4 py-1 rounded-lg text-black font-semibold text-center w-max" style="background-color: {{$statuses->where("id", $statusHistory->sortByDesc("created_at")->where("process_id", $search->process_id)->first()->last_status)->first()->color}}">
          {{$statuses->where("id", $statusHistory->sortByDesc("created_at")->where("process_id", $search->process_id)->first()->last_status)->first()->name}}
        </p>
        @endif
      </td>
      <td class="whitespace-nowrap  text-sm text-gray-500">{{$search->updated_at->format("d.m.Y (H:i)")}}</td>
      <td class="whitespace-nowrap  text-sm text-gray-500"></td>
      <td class="whitespace-nowrap  text-sm text-gray-500"></td>
      <td class="whitespace-nowrap  text-sm text-gray-500"></td>
      <td class="whitespace-nowrap  text-sm text-gray-500">@isset($tableWhereFound[$search->getTable()]) {{$tableWhereFound[$search->getTable()]}} @endisset</td>
      <td class="relative whitespace-nowrap py-1 pl-3 pr-3 text-center text-sm font-medium ">
          <a href="{{url('/')}}/crm/change/order/{{$search->process_id}}" class="text-blue-600 hover:text-blue-400 float-right">Bearbeiten</a>
      </td>
      </tr>

    @endif
   @endforeach
  </tbody>
</table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    var lastOpendQuickStatus = "0";
    function setNewQuickStatus(id, process_id) {
  
      document.getElementById('quick-status-value').value = id;
      document.getElementById('quick-status-process_id-value').value = process_id;
  
      document.getElementById('submit-quick-status').click();
  
    }
  
    function submitSort() {
  
      document.getElementById("status-filter").value = document.getElementById("status-dropdown").value;
      document.getElementById("field-filter").value = document.getElementById("field-dropdown").value;
      document.getElementById("direction-filter").value = document.getElementById("direction-dropdown").value;
      document.getElementById("buchhaltung-filter").value = document.getElementById("buchhaltung-dropdown").value;
      document.getElementById("count-filter").value = document.getElementById("count-dropdown").value;
  
      document.getElementById("submit-filter").click();
  
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
                document.getElementById("quick-order-dropdown").remove();
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
        function selectQuickStatus(id, fromManuel, event) {
          if(quickClickTimeState == true) {
            console.log(fromManuel);
  
  
            if(document.getElementById('row-'+id).classList.contains("border-blue-400")) {
              document.getElementById('row-'+id).classList.remove('bg-blue-100', "border-blue-400", "border");
              document.getElementById('quickstatus-input-'+id).checked = false
  
            } else {
              document.getElementById('row-'+id).classList.add('bg-blue-100', "border-blue-400", "border");
              document.getElementById('quickstatus-input-'+id).checked = true
  
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

  
  </script>
</body>
</html>