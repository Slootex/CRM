<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
    @include('layouts.top-menu', ["menu" => "packtisch"])
</head>
<body>
    <div class=" bg-white m-auto mt-16 h-auto shadow px-8 py-8" style="height: 35rem; width: 85rem;">
        <div>
            <h2 class="text-sm font-medium text-gray-500">Lagerbestände</h2>
            <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-96 lg:grid-cols-4">                         
              @foreach ($items as $item)
              
                @if ($item->item != "skip")
                <li class="col-span-1 flex rounded-md shadow-sm w-96 float-left ">
                  <div class="flex-shrink-0 flex items-center justify-center w-16 @if($item->count <=2) bg-red-600 @else bg-green-600 @endif text-white text-2xl font-medium rounded-l-md">{{$item->count}}</div>
                  <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                      <a href="#" class="font-medium text-gray-900 hover:text-gray-600">{{$item->item}}</a>
                    
                      <p class="text-gray-500">Im Lager: <span class="text-green-600">{{$item->count}}</span></p>
                      <p class="text-gray-500">Mitarbeiter: <span class="text-green-600">{{$item->employee}}</span></p>
                    
                      <p class="text-gray-400">Geprüft am: <span class="text-green-600">{{$item->created_at->format("d.m.Y")}} ({{$item->created_at->format("H:m")}})</span></p>

                    </div>
                    <div class="flex-shrink-0 pr-2">
                      <button type="button" onclick="window.location.href = '{{url('/')}}/crm/lagerbestandt/bestellen/{{$item->item}}'" style="background-color: rgb(8 145 178);" class="inline-flex h-8 w-auto items-center justify-center rounded-full px-2 py-1 bg-transparent text-white hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bestellen <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        </button>
                    </div>
                  </div>
                </li>
              @endif
              @endforeach
            </ul>
          </div>
      </div>

    
</body>
</html>