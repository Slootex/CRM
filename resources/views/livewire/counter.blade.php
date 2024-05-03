
<table class="min-w-full divide-y divide-gray-300" wire:poll>
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Erstellt</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Auftragsnummer</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kunde</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Geändert</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Zuteilung</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Telefonnummer</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">letzte Zahlung</th>
        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Aktion</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      @foreach ($active_orders[0] as $order)
      <tr wire:poll wire:key="{{$order->process_id}}">
      <td wire:poll wire:key="{{$order->process_id}}" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->created_at->format("d.m.Y")}} ({{$order->created_at->format("h:m")}})</td>
      <td wire:poll wire:key="{{$order->process_id}}" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->process_id}}</td>
      <td wire:poll wire:key="{{$order->process_id}}" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->firstname}} {{$order->lastname}}</td>
      <td wire:poll wire:key="{{$order->process_id}}" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          @foreach ($order_ids as $order_id)
              @if ($order_id->process_id == $order->process_id)
                  @foreach ($statuses as $status)
                      @if ($status->id == $order_id->current_status)
                      <span wire:key="{{$order->process_id}}" wire:poll class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 text-black" style="background-color: {{$status->color}}">{{$status->name}}</span>
                      
                      @endif
                  @endforeach
              @endif
          @endforeach
      </td>
      <td  wire:key="{{$order->process_id}}" wire:poll class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->updated_at->format("d.m.Y")}} ({{$order->updated_at->format("h:m")}})</td>
      <td  wire:key="{{$order->process_id}}" wire:poll class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@foreach ($employees as $employee)
          @if ($employee->id == $order->employee)
              {{$employee->name}}
          @endif
      @endforeach</td>
      <td wire:key="{{$order->process_id}}" wire:poll class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->zuteilung}}</td>
      <td wire:key="{{$order->process_id}}" wire:poll class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->phone_number}}</td>
      <td wire:key="{{$order->process_id}}" wire:poll class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->last_payment}}</td>
      <td wire:key="{{$order->process_id}}" wire:poll class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6">
          <a wire:key="{{$order->process_id}}"     wire:poll href="{{url('/')}}/crm/change/order/{{$order->process_id}}" class="text-blue-600 hover:text-blue-900">Bearbeiten</a>
      </td>
      </tr>
      @endforeach
     

      <!-- More people... -->
    </tbody>
  </table>