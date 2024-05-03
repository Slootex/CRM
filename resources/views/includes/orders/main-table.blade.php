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
$active_orders = $active_orders->where("archiv", false);
}
@endphp
@foreach ($active_orders as $order)


<tr class="hover:bg-blue-100 border-l-0 border-r-0" id="row-{{$orderCounter}}" onclick="selectQuickStatus('{{$orderCounter}}', 'no', event)">
<td class="whitespace-nowrap py-  text-sm font-medium text-gray-900"><input type="checkbox" id="quickstatus-input-{{$orderCounter}}" name="{{$order->process_id}}-order" value="{{$order->process_id}}" onclick="document.getElementById('set-status-dropdown').classList.remove('hidden'); selectQuickStatus('{{$orderCounter}}', 'yes')" class="border-gray-400 rounded-sm w-4 h-4 ml-2 mr-2"></td>
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
  @isset($order->statuse->sortByDesc("created_at")->first()->statuseMain->name)
  <div style="background-color: {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->color}}" class="px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium">
    {{$order->statuse->sortByDesc("created_at")->first()->statuseMain->name}}
    <select id="quick-status-select-{{$orderCounter}}" onchange="setNewQuickStatus(this.value, '{{$order->process_id}}')" name="location" class="absolute hidden mt-2 block w-60 rounded-md border-0 py-1.5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
      <option value="">neuen Status wählen</option>
      @foreach ($allStats->sortBy("name") as $stat)
          <option value="{{$stat->id}}">{{$stat->name}}</option>
      @endforeach
    </select>
  </div>
  @endisset
  
  
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
  <p class="ml-10 px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium bg-red-200 text-red-600">Dennis</p>
</td>
<td class="whitespace-nowrap  py-1 text-sm text-black">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
<td class="whitespace-nowrap text-left py-1 text-sm text-black">@isset($order->user->name){{$order->user->name}}@endisset</td>
<td class="whitespace-nowrap  py-1 text-sm text-black">
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
<td class="whitespace-nowrap  py-1 text-sm text-black"><div class="ml-12 px-2 float-left py-0.5 text-sm rounded-xl text-left font-medium bg-green-200 text-green-600"><p>7 Tage</p></div></td>
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
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-6 h-6 text-green-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>                                  
        @else
          <p class="text-red-600 float-right">{{number_format($gezahlt - $zuzahlen, 2, ",", ".")}} &#8364;</p>
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
  <script>
    $(document).on("middleclick", "#row-{{$orderCounter}}", function (e) {
      showOrderChangeModal('{{$order->process_id}}')
    });
  </script>            
</td>

</tr>
@php
$orderCounter++;
@endphp


@endforeach

