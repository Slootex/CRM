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
    <div class="overflow-hidden w-3/5 rounded-lg bg-white shadow-xl m-auto mt-16">
        <div class="px-4 py-5 sm:p-6">
            <form action="/crm/to/packtisch/einlagerungsauftrag/{{$device->process_id."-".$device->component_id."-".$device->component_type."-".$device->component_count}}" method="POST">
                @CSRF
            <h1 class="text-center text-xl mt-5 mb-5">{{$device->process_id."-".$device->component_id."-".$device->component_type."-".$device->component_count}}</h1>
            <div class="m-auto">
                <label for="location" class="block text-sm font-medium text-gray-700">Lagerplatz</label>
                <select id="location" name="shelfe" class="float-left mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @foreach ($shelfes as $shelfe)
                        @if ($shelfe->process_id == "0" && $shelfe->status == "0")
                            <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>                       
                        @endif
                    @endforeach
                  </select>
                <select id="location" class="hidden" name="compo-{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}" class="float-left mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  @foreach ($shelfes as $shelfe)
                      @if ($shelfe->process_id == "0" && $shelfe->status == "0")
                          <option value="{{$shelfe->shelfe_id}}+{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}">{{$shelfe->shelfe_id}}</option>                       
                      @endif
                  @endforeach
                </select>
              </div>
              <select onchange="changeAuftrag()" name="auftrag" id="auftrag" class="mt-1 hidden block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                <option value="Fotoauftrag">neuer Fotoauftrag</option>
                <option value="Umlagerungsauftrag" selected>neuer Umlagerungsauftrag</option>
                <option value="Neuer Versandauftrag - Techniker">Neuer Versandauftrag - Techniker</option>
                <option value="Neuer Versandauftrag - Kunde">Neuer Versandauftrag - Kunde</option>
              </select>
              <button type="submit" class="mt-1 ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zuweisen</button>
            </form>
        </div>
      </div>
</body>
</html>