<!doctype html>
<html class="h-full bg-gray-50">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{url('/')}}/js/countdown.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

  @vite('resources/css/app.css')
</head>
<body>

@include('layouts/top-menu', ["menu" => "setting"])

  <!-- TABLE BODY -->

 
  <div class="px-4 sm:px-6 lg:px-8 mt-5">
    
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Mitarbeiter Zeiterfassung</h1>
          </div>
          
        </div>
        <div class="mt-8 flex flex-col">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-1 pl-4 pr-3 text-left text-xl font-semibold text-gray-900 sm:pl-6">Mitarbeiter</th>
                      <th scope="col" class="px-3 py-1 text-left text-xl font-semibold text-gray-900">Status</th>
                      <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6 text-right">
                        <span>Aktion</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($times as $time)
                    <tr class="@if($time->type == 'feierabend') bg-yellow-400 @endif
                    @if($time->type == 'pause') bg-red-400 @endif
                    @if($time->type == 'start') bg-green-400 @endif
                    @if($time->type == 'weiter') bg-green-400 @endif" >
                        <td class="whitespace-nowrap py-1 pl-4 pr-3 text-xl font-medium text-gray-900 sm:pl-6">{{$employees->where("id", $time->employee)->first()->name}}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-xl text-black">@if($time->type == 'weiter') Am Arbeiten @endif @if($time->type == 'feierabend') Feierabend @endif @if($time->type == 'pause') Pause @endif @if($time->type == 'start') Am Arbeiten @endif</td>
                            </td>

                        <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-xl font-medium sm:pr-6">
                          <a href="{{url('/')}}/crm/zeiterfassung/{{$employees->where("id", $time->employee)->first()->user}}" class="text-blue-600 hover:text-blue-900">Anschauen</a>
                        </td>
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
         
  </div>

  <script>

  </script>

</body>
</html>