<!DOCTYPE html>
<html lang="en" class="bg-gray-50 h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "packtisch"])
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow rounded mt-8">
       <h1 class="text-center text-2xl mt-8">Lagerplatz: {{$shelfe->shelfe_id}}</h1>
       <div class="mt-8 float-left mr-6">
        <label for="location" class="block text-sm font-medium text-gray-700">Lagerplatz</label>
        <select id="location" name="location" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
          <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} | Derzeitger Platz</option>
          @foreach ($shelfes as $i)
              <option value="{{$i->shelfe_id}}">{{$i->shelfe_id}}</option>
          @endforeach
        </select>
      </div>
      <div class="mt-14 float-left">
        <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
      </div>
      <br><br><br>
      <div class="mt-10">
        <p class="text-xl">Derzeitiges Gerät: <span class="text-green-600">@if($shelfe->component_number == "0") keins @else {{$shelfe->component_number}} @endif</span></p>
      </div>
      @php
      if($shelfe->component_number != "0" || $shelfe->component_number != "helpercode") {
        $datetime_1 = new DateTime($shelfe->deviceOrders->created_at);
        $datetime_2 = date("d.m.Y"); 

        $start_datetime = $datetime_1->modify("+90 days"); 
        if($extendtime != null) {
          $start_datetime = $datetime_1->modify("+". $extendtime->days ." days");  
        }
        
        $diff = $start_datetime->diff(new DateTime()); 
      } else {
        $diff = null;
      }
  @endphp
  <hr class="mt-10">
      <div class="mt-10">
        <h2 class="text-xl float-left mr-6">Zeit bis Entsorgung <span class="text-green-600">{{$diff->d}}</span> Tage und <span class="text-green-600">{{$diff->m}}</span> Monate, @if($diff->y != 0) {{$diff->y}} Jahre @endif</h2>
        <button type="button" onclick="window.location.href = '{{url('/')}}/crm/entsorgung/extendtime/{{$shelfe->component_number}}'" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">+ 90 Tage</button>
      </div>
      <br>
      <br>
    </div>
</body>
</html>