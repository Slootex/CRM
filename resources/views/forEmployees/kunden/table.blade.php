@php
$orderCounter = 0;
$usedKunden = array();
@endphp


@foreach ($kunden as $kunde)
@php
if($area == "Aufträge") {
  $order = $kunde->active_orders_person_datas;
}
if($area == "Interessenten") {
  $order = $kunde->new_leads_person_datas;
}
if($area == "Beide") {
  $order = $kunde->merged_person_datas;
}

if($order == null) {
  continue;
}
@endphp
@if (!in_array($order->kunden_id, $usedKunden))
<tr class="hover:bg-blue-100 @if($order->sperre == "true") bg-red-100 @endif" id="row-{{$order->kunden_id}}">
  <td class="whitespace-nowrap pl-6 py-1 text-sm text-gray-500 ">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">

  </td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">K{{$order->kunden_id}}</td>
  <td class="whitespace-nowrap py-1 text-sm text-gray-500">
    <p class="truncate overflow-hidden whitespace-nowrap">{{$order->company_name}}</p>
  </td>
  <td class="truncate overflow-hidden whitespace-nowrap py-1 text-sm text-gray-500">
    <p class="truncate overflow-hidden whitespace-nowrap" style="max-width: 10rem">{{$order->firstname}}</p>
  </td>
  <td class="whitespace-nowrap py-1 text-sm text-gray-500">
    <p class="truncate overflow-hidden whitespace-nowrap" style="max-width: 10rem">{{$order->lastname}}</p>

  </td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">{{$order->home_street}}</td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500" >
    {{$order->home_street_number}}
  </td>
  <td class="whitespace-nowrap  py-1  text-sm text-gray-500">{{$order->home_zipcode}}</td>
  <td class="whitespace-nowrap  py-1  text-sm text-gray-500">{{$order->home_city}}</td>
  <td class="whitespace-nowrap py-1 text-sm text-gray-500">{{$order->home_country}}</td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
    {{$order->mobile_number ?: $order->phone_number}}                           
  </td>
  <td class="whitespace-nowrap py-1 text-sm text-gray-500">{{$order->email}}</td>
  <td class="whitespace-nowrap py-1 text-sm text-gray-500">
    {{$order->send_back_street ?: $order->home_street}} 
    {{$order->send_back_street_number ?: $order->home_street_number}}
  </td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
    {{$order->updated_at->format("d.m.Y (H:i)")}}
  </td>
  <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
    @if ($users->where("id", $order->employee)->first() != null)
    {{$users->where("id", $order->employee)->first()->username}}                       

    @endif
  </td>


  <td class="whitespace-nowrap pr-2 py-1 text-sm text-gray-500 ">
    <button type="button" onclick="getKundendatenModal('{{$order->kunden_id}}')" class="float-right">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 hover:text-blue-400 float-right ">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
      </svg>      
    </button>                      
  </td>

</tr>
@php
    array_push($usedKunden, $order->kunden_id);
@endphp
@endif
@php
$orderCounter++;
@endphp
@endforeach