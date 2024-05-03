<!DOCTYPE html>
<html lang="en" class="bg-white h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>   
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts/top-menu', ["menu" => "einstellungen"])


    <div class="px-8">
        <hr style="margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">
        <h1 class="py-6 text-4xl font-bold text-black">Überwachungssystem Protokoll</h1>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8 bg-white rounded-md">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr>
                        <th scope="col" class="py-1 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Erstellt</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Kategorie</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Text</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Ausgelendet</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      @foreach ($überwachungen->sortByDesc("created_at") as $überwachung)
                        <tr>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">{{$überwachung->created_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">@if($employees->where("id", $überwachung->employee)->first() != null){{$employees->where("id", $überwachung->employee)->first()->username}} @else {{$überwachung->employee}} @endif</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$überwachung->type}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$überwachung->text}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                            @if ($überwachung->ausgeblendet != null)
                              {{$überwachung->updated_at->format("d.m.Y (H:i)")}} von
                            @endif
                            
                            @if($employees->where("id", $überwachung->ausgeblendet)->first() != null)
                              {{$employees->where("id", $überwachung->ausgeblendet)->first()->username}} @else {{$überwachung->ausgeblendet}} 
                            @endif 
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>

</body>
</html>