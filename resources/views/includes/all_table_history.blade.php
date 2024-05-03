@isset($trackings)
    <div id="tracking">
      @include('forEmployees.modals.tracking')
    </div>
@endisset

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
      @php
          $allstat = collect($status_history);
          $emailhistory = collect($e_his);

          $one = $allstat->merge($emailhistory);
          $phones = collect($phonehistory);
          $auftrags = collect($auftragshistory);
          $two = $phones->merge($auftrags);
          $tree = $one->merge($two);
          $all = $tree->merge($files);
          $arr = $all->merge($warenausgang);
          $rrr = $arr->sortByDesc("created_at");

          $state = false;
      @endphp
    
     
    @foreach ($rrr as $a)
    <tr>
      <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$a->created_at->format("d.m.Y")}} ({{$a->created_at->format("H:i")}})</td>
      @foreach ($statuses as $stat)
      @if ($stat->id == $a->last_status)
      @if ($a->last_status != null)
      <td class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{$stat->color}} {{$stat->text_color}}" style="background-color: {{$stat->color}}; color: {{$stat->text_color}}">{{$stat->name}}</td>
      @php
          $state = true;
      @endphp
      @endif
      @endif
      @endforeach
        @if ($state == false)
        @isset ($a->message)
        <td class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5" style="background-color: lightgreen">Telefonhistory</td>
       
   
    @endisset
    @isset ($a->subject)
        <td class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5" style="background-color: lightgreen">{{$a->status}}</td>
        
       
    @endisset
    @isset ($a->description)
        <td class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5" style="background-color: lightgreen">Datei</td>
       
    @endisset
        @endif
        
    @php
    $state = false;
@endphp
  
  @isset($a->changed_employee)
  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$a->changed_employee}}</td>
  @else
  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$a->employee}}</td>
  @endisset

      @isset($a->filename)
      <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
        
        <a  class="text-blue-500 underline" target="_blank" rel="noopener noreferrer" href="{{url('/')}}/files/aufträge/{{$a->process_id}}/{{$a->filename}}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
        </svg>
        </a>
        
         @isset($a->component_number) <span>Gerät: {{$a->component_number}}</span> @endisset
         @isset($a->old_shelfe) <span>Lager: {{$a->old_shelfe}}</span> <br> @endisset
         @isset($a->info) <span>Packtischinfo: {{$a->info}} </span>@endisset
         @isset($a->fotoauftrag)
             <span>Fotoauftrag</span>
         @endisset
         @isset($a->nachnahme)
             <span>Nachnahme</span>
         @endisset
        
       @isset($a->street)
           <span>Lieferadresse: {{$a->street}} {{$a->streetno}}, {{$a->zipcode}}</span>
       @endisset
         @isset($a->label) Label: {{$a->label}} , <a href="{{url("/")}}/crm/shipping/status/{{$a->label}}/{{$person->process_id}}">Status</a> @endisset
         @isset($a->subject) Email: {{$a->subject}}  @endisset
         @isset($a->message) Nachricht: {{$a->message}}  @endisset
         @isset($a->subject) <svg onclick="readStatus('{{$a->process_id}}','{{$a->created_at}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg> {{$a->subject}}  @endisset

       </td>
       <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500">
         
         
         
        <svg onclick="readStatus('{{$a->last_status}}','{{$a->process_id}}')"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2 hidden">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
       </td>
@else
<td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
  @isset($a->component_number)
  @if ($files->where("component_number", $a->component_number)->first() != null)
  <a id="{{$a->created_at}}" target="_blank" rel="noopener noreferrer" class="text-blue-500 underline"  href="{{url('/')}}/crm/auftrag/pdf/{{$a->component_number}}/{{$a->process_id}}#toolbar=0"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
  </svg>
  </a>
  @endif
  @endisset
   <p class="float-left">
    @isset($a->component_number) <span>Gerät: {{$a->component_number}}</span> @endisset
    @isset($a->old_shelfe) <span>Lager: {{$a->old_shelfe}}</span> <br> @endisset
    @isset($warenausgang->where("label", $a->label)->first()->info) <span>Packtischinfo: {{$warenausgang->where("label", $a->label)->first()->info}} </span>@endisset
    @isset($warenausgang->where("label", $a->label)->first()->fotoauftrag)
        <span>Fotoauftrag</span>
    @endisset
    @isset($warenausgang->where("label", $a->label)->first()->nachnahme)
        <span>Nachnahme</span>
    @endisset
   
  @isset($warenausgang->where("label", $a->label)->first()->street)
      <span>Lieferadresse: {{$warenausgang->where("label", $a->label)->first()->street}} {{$warenausgang->where("label", $a->label)->first()->streetno}}, {{$warenausgang->where("label", $a->label)->first()->zipcode}}</span>
  @endisset
    @isset($a->label) Label: {{$a->label}}, <a href="{{url("/")}}/crm/shipping/status/{{$a->label}}/{{$person->process_id}}" class="text-blue-600" target="_blank">Status</a> @endisset
    @isset($a->subject) Email: {{$a->subject}}  @endisset
    @isset($a->message) Nachricht: {{$a->message}}  @endisset
    @isset($a->uuid) Gelesen: @if($emailUUIDS->where("uuid", $a->uuid)->first()->count == 0) Nein @else Ja ({{$emailUUIDS->where("uuid", $a->uuid)->first()->count}}) @endif @endisset</p>
   @isset($a->subject) <svg onclick="readStatus('{{$a->process_id}}','{{$a->created_at}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
  </svg>   @endisset
  </td>
 <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500">
   
  
   
  <svg onclick="readStatus('{{$a->last_status}}','{{$a->process_id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2 hidden">
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
  </svg>
 </td>

      @endisset
    </tr>
    @endforeach

     
    </tbody>
  </table>