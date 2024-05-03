<input  wire:keydown.enter="test" id="search" name="search" class="block w-full rounded-md border border-transparent bg-gray-700 py-3 pl-10 pr-3 text-sm placeholder-gray-400 focus:border-white focus:bg-white focus:text-gray-900 focus:placeholder-gray-800 focus:outline-none focus:ring-white sm:text-sm" placeholder="Search" type="search">
<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
</div>
<table class="min-w-full divide-y divide-gray-300">
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
      @foreach ($active_orders as $order)
      <tr>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->created_at->format("d.m.Y")}} ({{$order->created_at->format("h:m")}})</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->process_id}}</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->firstname}} {{$order->lastname}}</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          @foreach ($order_ids as $order_id)
              @if ($order_id->process_id == $order->process_id)
                  @foreach ($statuses as $status)
                      @if ($status->id == $order_id->current_status)
                      <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 text-black" style="background-color: {{$status->color}}">{{$status->name}}</span>
                      
                      @endif
                  @endforeach
              @endif
          @endforeach
      </td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->updated_at->format("d.m.Y")}} ({{$order->updated_at->format("h:m")}})</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@foreach ($employees as $employee)
          @if ($employee->id == $order->employee)
              {{$employee->name}}
          @endif
      @endforeach</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->zuteilung}}</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->phone_number}}</td>
      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$order->last_payment}}</td>
      <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6">
          <a href="{{url('/')}}/crm/change/order/{{$order->process_id}}" class="text-blue-600 hover:text-blue-900">Bearbeiten</a>
      </td>
      </tr>
      @endforeach
     

      <!-- More people... -->
    </tbody>
  </table>