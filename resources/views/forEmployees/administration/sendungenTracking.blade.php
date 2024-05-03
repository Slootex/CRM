<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script> 
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <div class="mx-auto max-w-full px-6">
        
        <div class="m-auto w-60 bg-gray-100 h-10 mt-10">
            <button type="button"  onclick="window.location.href = '{{url('/')}}/crm/kontakt/neu'" class="items-center w-full rounded border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-1 text-lg font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><span style="margin-right: -1rem">Aktualisieren</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              </button>
        </div>

        <div class="">
            <div class="mt-8 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-auto h-96 shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-semibold text-gray-900">Datum</th>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-semibold text-gray-900">Lieferung an</th>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-semibold text-gray-900">Sendungsnummer</th>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-semibold text-gray-900">Status</th>
                          <th scope="col" class="px-3 py-1 text-right text-normal font-semibold text-gray-900">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($trackings as $tracking)
                        <tr>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$tracking->created_at->format("d.m.Y (H:i)")}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$warenausgang->where("label", $tracking->label)->first()->shortcut}} {{$warenausgang->where("label", $tracking->label)->first()->lastname}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$tracking->label}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">@isset($statuses->where("id", $tracking->status)->first()->name) {{$statuses->where("id", $tracking->status)->first()->name}} @endisset {{$tracking->status}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500 text-right"><a href="{{url("/")}}/crm/sendung/anschauen/{{$tracking->label}}">Anschauen</a></td>
                            
                        </tr>
                        @endforeach
          
                        <!-- More people... -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @isset($bearbeiten)
          @if ($bearbeiten == true)
          <div class="w-full bg-gray-100 h-12 mt-16 border-2">
            <h1 class="text-2xl font-semibold ml-6 mt-1">Bearbeiten</h1>
          </div>
         
      @endif
          @endisset
          <script>

            var tabs = ["info", "admin", "einstellungen"]
    
            function changeTab(tab) {
                tabs.forEach(item => {
                    if(item != tab) {
                        document.getElementById(item).classList.add("hidden");
                        document.getElementById(item + "-tab").classList.remove("bg-gray-100");
                    } 
                    document.getElementById(tab).classList.remove("hidden");
                    document.getElementById(tab + "-tab").classList.add("bg-gray-100");
                });
            }
        </script>
    </div>
      
    <br>
    <br>
    <br>
</body>
</html>