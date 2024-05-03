<div class=" w-full px-6 py-6">
    <form action="/crm/change/status/order/{{$person->process_id}}" method="post">
        @CSRF
      <input type="hidden" id="no_email" name="email_sender" value="123" class="custom-control-input">
    
      <label for="location" class="block text-sm font-medium text-gray-700">Status</label>
      <select id="location" name="lead_status_id" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @foreach ($statuses->sortBy('name') as $status)
            <option value="{{$status->id}}" style="background-color: {{$status->color}}; color: {{$status->text_color}}">{{$status->name}}</option>
        @endforeach
      </select>
      <fieldset class="space-y-5 float-left">
        <legend class="sr-only">Notifications</legend>
        <div class="relative flex items-start">
          <div class="flex h-5 items-center">
            <input id="comments" aria-describedby="comments-description" name="no_email" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
          </div>
          <div class="ml-3 text-sm">
            <label for="comments" class="font-medium text-gray-700">Email senden</label>
          </div>
        </div>
        
      </fieldset>
      <button type="submit" class="mt-3 float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <!-- Heroicon name: mini/envelope -->
        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
          <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
        </svg>
        Abspeichern
      </button>
  
    <div class="float-left mr-16">
      <fieldset class="mt-1">
        <div class="space-y-4">
          <div class="flex items-center float-left ml-4 mr-4">
            <input id="email" onclick="window.location.href = '{{url('/')}}/crm/remove-blacklist/{{$person->process_id}}'" name="notification-method" type="radio" @if($person->blacklist_status == "no" || $person->blacklist_status == null) checked @endif class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500">
            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Online</label>
          </div>
    
          <div class="flex items-center ml-4 ">
            <input id="sms" onclick="window.location.href = '{{url('/')}}/crm/add-blacklist/{{$person->process_id}}'" @if($person->blacklist_status == "yes") checked @endif name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-500">
            <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Offline</label>
          </div>
    
        </div>
      </fieldset>
    </div>
    <fieldset class="space-y-5 float-left">
      <div class="relative flex items-start">
        <div class="flex h-5 items-center">
          <input id="comments" aria-describedby="comments-description" name="public" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        </div>
        <div class="ml-3 text-sm">
          <label for="comments" class="font-medium text-gray-700">Öffentlich</label>
        </div>
      </div>
      
    </fieldset>
    <br>
    <br>
  </form>
</div>

<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Status</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Info</th>
        <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
          <span class="sr-only">Edit</span>
        </th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @foreach ($status_history as $status)
         @if (is_numeric($status->last_status))
         <tr>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$status->created_at->format("d.m.Y")}} ({{$status->created_at->format("H:i")}})</td>
          @foreach ($statuses as $stat)
              @if ($stat->id == $status->last_status)
                <td class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5" style="background-color: {{$stat->color}}">{{$stat->name}}</td>
              @endif
          @endforeach
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$status->changed_employee}}</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">@isset($status->component_number) <span>Gerät: {{$status->component_number}}</span> @endisset
            @isset($status->old_shelfe) <span>Lager: {{$status->old_shelfe}}</span> <br> @endisset
            @isset($status->bpz1) BPZ-1: {{$status->bpz1}}  @endisset
            @isset($status->bpz2) BPZ-2: {{$status->bpz2}} <br> @endisset
            @isset($status->label) Label: {{$status->label}}, <a href="{{url("/")}}/crm/shipping/status/{{$status->label}}">Status</a>  @endisset</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500"><svg onclick="readStatus('{{$status->last_status}}','{{$status->process_id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          </td>

        </tr>
         @endif
      @endforeach

    </tbody>
  </table>

 