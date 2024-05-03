<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <link rel="stylesheet" href="{{url("/")}}/css/animations.css">
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-white float-left">
        Einstellungen
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 inline-block font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Versand Statuscodes</h1>
     <div class="float-right mt-8 mr-16">
        <a href="{{url("/")}}/crm/statuscodes-bearbeiten" type="button" class="float-right bg-gray-500 hover:bg-gray-400 rounded-md text-white font-medium mr-4 text-sm px-2 py-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </a>
      

     </div>
    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-10">
      <div class="overflow-hidden bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
              <div class="px-4 sm:px-6 lg:px-8">
                  <div class="sm:flex sm:items-center">
                      <div class="sm:flex-auto">
                      </div>
                      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                      </div>
                    </div>
                  <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                          <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                              <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 ">Versand-Dienstleister</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 ">Status</th>
                                <th scope="col" class="py-3.5 pr-3 pl-0.5 text-left text-sm font-semibold text-gray-900 "></th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Eigene Bezeichnung</th>
                                
                                <th scope="col" class="relative py-3.5 pl-3 text-right pr-4 text-sm font-semibold text-gray-900">
                                  Aktion
                                </th>
                              </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                             
                              @foreach ($carrier as $c)
                                  @foreach ($c->versandStatuscode as $status)
                                  <tr>
                                    <td class="pl-4 text-sm">{{$c->carrier}}</td>
                                    <td class="pl-4 text-sm">{{$status->status}}</td>
                                    <td class="">

                                      @if ($status->icon == "truck")
                                      <div  class="cursor-pointer border-yellow-600 hover:border-yellow-600 rounded-full border w-8 h-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-yellow-600 w-5 h-5  m-auto mt-1">
                                          <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.771-.59-1.43-1.375-1.489A41.568 41.568 0 006.5 3zM2 12v2.5A1.5 1.5 0 003.5 16h.041a3 3 0 015.918 0h.791a.75.75 0 00.75-.75V12H2z" />
                                          <path d="M6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.25 5a.75.75 0 00-.75.75v8.514a3.001 3.001 0 014.893 1.44c.37-.275.61-.719.595-1.227a24.905 24.905 0 00-1.784-8.549A1.486 1.486 0 0014.823 5H13.25zM14.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                      </div>
                                      @endif

                                      @if ($status->icon == "doc")
                                      <div class="cursor-pointer border-green-600 hover:border-green-600 rounded-full border w-8 h-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-green-600 w-5 h-5 mt-1 m-auto">
                                          <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                      </div>
                                      @endif

                                      @if ($status->icon == "warning")
                                      <div  class="cursor-pointer border-red-600 hover:border-red-600 rounded-full border w-8 h-8 ">
                                        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-5 h-5 m-auto mt-1">
                                          <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        
                                      </div>
                                      @endif

                                    </td>
                                    <td>
                                      <div>
                                        <p class="text-center rounded-md text-black font-medium px-2 py-1 w-auto text-sm">{{$status->bezeichnung}}</p>  
                                      </div>
                                    </td>
                                    <td>
                                      <a href="{{url("/")}}/crm/change-statuscode-{{$status->id}}" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-4 text-blue-600 hover:text-blue-400 float-right">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>                                        
                                      </a>
                                    </td>
                                  </tr>
                                @endforeach
                              @endforeach
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </div>
    </div>

      @isset($changedCode)
      <div class="relative z-10" id="change-status-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              
          <form action="{{url("/")}}/crm/save-statuscode" method="POST">
            @CSRF

                <h1 class="text-lg font-semibold">
                    Status: {{$changedCode->status}}
                </h1>
  
                <div class="mt-4">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Eigene Bezeichnung</label>
                  <div class="mt-2">
                    <select name="custom" id="" class="w-full h-10 rounded-md border border-gray-600">
                      @foreach ($selectCodes as $code)
                          @if (str_contains($code, $changedCode->bezeichnung))
                            <option value="{{$code->bezeichnung}}" selected>{{$code->bezeichnung}}</option>
                            @else
                            <option value="{{$code->bezeichnung}}">{{$code->bezeichnung}}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>
                </div>
  

                <div class="mt-4">
                  <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Icon</label>
                  <div class="mt-2 w-full flex">
                    <div id="icon-div-truck" onclick="changeIconSelect('truck', 'yellow')" class="cursor-pointer @if($changedCode->icon == "truck") border-yellow-600 @endif hover:border-yellow-600 rounded-full border w-8 h-8">
                      <svg id="icon-svg-truck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="@if($changedCode->icon == "truck") text-yellow-600 @else text-gray-600 @endif w-5 h-5  m-auto mt-1">
                        <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.771-.59-1.43-1.375-1.489A41.568 41.568 0 006.5 3zM2 12v2.5A1.5 1.5 0 003.5 16h.041a3 3 0 015.918 0h.791a.75.75 0 00.75-.75V12H2z" />
                        <path d="M6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.25 5a.75.75 0 00-.75.75v8.514a3.001 3.001 0 014.893 1.44c.37-.275.61-.719.595-1.227a24.905 24.905 0 00-1.784-8.549A1.486 1.486 0 0014.823 5H13.25zM14.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                      </svg>
                    </div>
                    
                    <div id="icon-div-doc" onclick="changeIconSelect('doc', 'green')" class="cursor-pointer @if($changedCode->icon == "doc") border-green-600 @endif hover:border-green-600 rounded-full border w-8 h-8 ml-3">
                      <svg id="icon-svg-doc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="@if($changedCode->icon == "doc") text-green-600 @else text-gray-600 @endif w-5 h-5 mt-1 m-auto">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>
                    </div>

                    <div id="icon-div-warning" onclick="changeIconSelect('warning', 'red')" class="cursor-pointer @if($changedCode->icon == "warning") border-red-600 @endif hover:border-red-600 rounded-full border w-8 h-8 ml-3">
                      <svg id="icon-svg-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="@if($changedCode->icon == "warning") text-red-600 @else text-gray-600 @endif w-5 h-5 m-auto mt-1">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                      </svg>
                      
                    </div>

                  </div>
                </div>
                <input type="hidden" name="icon" id="icon-input">
                @php
                    $color = "";
                    if($changedCode->icon == "truck") {
                      $color = "yellow";
                    }
                    if($changedCode->icon == "doc") {
                      $color = "green";
                    }
                    if($changedCode->icon == "warning") {
                      $color = "red";
                    }
                @endphp
                <script>
                  let lastIcon = "{{$changedCode->icon}}";
                  let lastColor = "{{$color}}";
                  function changeIconSelect(icon, color) {
                    if(lastIcon == "") {
                      document.getElementById("icon-div-"+icon).classList.add("border-"+color+"-600");
                      document.getElementById("icon-svg-"+icon).classList.add("text-"+color+"-600");
                      document.getElementById("icon-svg-"+icon).classList.remove("text-gray-600");

                      lastColor = color;
                      lastIcon = icon;
                    } else {
                      document.getElementById("icon-div-"+icon).classList.add("border-"+color+"-600");
                      document.getElementById("icon-svg-"+icon).classList.add("text-"+color+"-600");
                      document.getElementById("icon-svg-"+icon).classList.remove("text-gray-600");

                      document.getElementById("icon-div-"+lastIcon).classList.remove("border-"+lastColor+"-600");
                      document.getElementById("icon-svg-"+lastIcon).classList.remove("text-"+lastColor+"-600");
                      document.getElementById("icon-svg-"+lastIcon).classList.add("text-gray-600");

                      lastColor = color;
                      lastIcon = icon;
                    }

                    document.getElementById("icon-input").value = icon;
                  }
                </script>

                <input type="hidden" name="id" value="{{$changedCode->id}}">
                <div class="mt-4">
                  <button type="submit" class="px-4 py-2 rounded-md font-semibold text-white float-left bg-blue-600 hover:bg-blue-500">Speichern</button>
                  <button type="button" onclick="document.getElementById('change-status-modal').classList.add('hidden');" class="px-4 py-2 rounded-md font-semibold text-black float-right border border-gray-600">Abbrechen</button>
                </div>

          </form>
        </div>
      </div>
        </div>
      </div>
      @endisset

      @isset($changeCodeSelect)
      <div class="relative z-10" id="change-status-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 40rem">
              
    

                <h1 class="text-lg font-semibold float-left">
                    Statuslisten Auswahl bearbeiten
                </h1>
                <a href="{{url("/")}}/crm/statuscode-select-neu" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-sm font-medium px-2 py-2 text-white">+ neuer Status</a>
  
                <div>
                  <div class="inline-block min-w-full py-2 align-middle s">
                    <div class="overflow-hidden sm:rounded-lg">
                      <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="py-3.5  pr-3 text-left text-sm font-semibold text-gray-900 ">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 text-right pr-4 text-sm font-semibold text-gray-900">
                              Aktion
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          
                          @foreach ($changeCodeSelect as $status)
                              <tr>
                                <td class=" py-1 text-sm">{{$status->bezeichnung}}</td>

                                  <td class="py-1">
                                    <a href="{{url("/")}}/crm/statuscode-select-edit-{{$status->id}}" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-4 text-blue-600 hover:text-blue-400 float-right">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>                                        
                                      
                                    </a>
                                </td>
                              </tr>
                          @endforeach
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
  
                <div class="mt-4">
                  <button type="button" onclick="document.getElementById('change-status-modal').classList.add('hidden');" class="px-4 py-2 rounded-md font-semibold text-black float-right border border-gray-600 text-sm">Abbrechen</button>
                </div>

        </div>
      </div>
        </div>
      </div>
      @endisset



      @isset($newCodeSelect)
      <div class="relative z-10" id="new-status-select-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6 w-96">
              
    <form action="{{url("/")}}/crm/statuscodes-select-neu" method="POST">
      @CSRF
                <h1 class="text-lg font-semibold float-left">
                  @isset($editCodeSelect)
                    Statuscode bearbeiten
                    @else
                    neuer Statuscode
                  @endisset
                </h1>
                @isset($editCodeSelect)
                <input type="hidden" name="id" value="{{$editCodeSelect->id}}">
                @endisset 
                <input type="text" @isset($editCodeSelect) value="{{$editCodeSelect->bezeichnung}}" @endisset name="bezeichnung" placeholder="Bezeichnung" class="w-full h-10 rounded-md border border-gray-600 mb-2 mt-4">
  
                <div class="mt-4">
                  <button type="submit" class="px-4 py-2 rounded-md font-semibold text-white float-left bg-blue-600 hover:bg-blue-500">Speichern</button>

                  <button type="button" onclick="document.getElementById('new-status-select-modal').classList.add('hidden');" class="px-4 py-2 rounded-md font-semibold text-black float-right border border-gray-600 text-sm">Abbrechen</button>
                </div>
    </form>
        </div>
      </div>
        </div>
      </div>
      @endisset

</body>
</html>