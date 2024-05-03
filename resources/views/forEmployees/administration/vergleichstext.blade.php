<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')


</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    
    
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
       <h1 class="py-6 text-4xl font-bold ml-10 text-black"><span class="float-left">Einstellungen</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Text-Vorlagen</h1>
        <div class="pt-6">
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('vergleich')" ><a href="#" id="vergleich-tab" class="py-2 px-4 bg-blue-600 text-white rounded-md">Vergleichstexte</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('rechnung')" ><a href="#" id="rechnung-tab" class="py-2 px-4 bg-gray-200 text-black hover:bg-blue-600 hover:text-white rounded-md">Rechnungstexte</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('mahnung')" ><a href="#" id="mahnung-tab" class="py-2 px-4 bg-gray-200 text-black hover:bg-blue-600 hover:text-white rounded-md">Mahnungstexte</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('phone')" ><a href="#" id="phone-tab" class="py-2 px-4 bg-gray-200 text-black hover:bg-blue-600 hover:text-white rounded-md">Telefonhistorietexte</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" ><a href="#" onclick="addText()" class="py-2 px-4 hover:bg-blue-500 rounded-md bg-blue-600 ">Neue Textvorlage erstellen</a></h1>
        </div>

          <br>
    
          <div id="vergleich">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col rounded-lg">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 rounded-lg">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 rounded-lg">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4 rounded-lg">
                        <thead class="bg-gray-50 rounded-lg">
                          <tr>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Text</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Aktiviert</th>
                            <th scope="col" class="px-3 py-2 text-right text-normal font-normal text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white rounded-lg">
                          @php
                              $counter1 = 0;
                          @endphp
                          @foreach ($vergleichstexte as $text)
                          <tr>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter1 == $vergleichstexte->count() -1) rounded-bl-lg @endif">{{$text->title}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 overflow-hidden w-96 text-ellipsis inline-block">{{$text->text}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$text->aktiviert}}</td>
                              <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter1 == $vergleichstexte->count() -1) rounded-br-lg @endif">
                                <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/bearbeiten/vergleich/{{$text->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                              </td>
                          </tr>
                          @php
                              $counter1++;
                          @endphp
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

          <div id="rechnung" class="hidden">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Text</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Aktiviert</th>
                            <th scope="col" class="px-3 py-2 text-right text-normal font-normal text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @php
                          $counter2 = 0;
                      @endphp
                          @foreach ($rechnungstexte as $text)
                          <tr>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter2 == $rechnungstexte->count() -1) rounded-bl-lg @endif">{{$text->title}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 overflow-hidden w-96 text-ellipsis inline-block">{{$text->text}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$text->aktiviert}}</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter2 == $rechnungstexte->count() -1) rounded-br-lg @endif">
                                <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/bearbeiten/rechnung/{{$text->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                              </td>
                          </tr>
                          @php
                              $counter2++;
                          @endphp
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

          <div id="mahnung" class="hidden">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Text</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Aktiviert</th>
                            <th scope="col" class="px-3 py-2 text-right text-normal font-normal text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @php
                          $counter3 = 0;
                      @endphp
                          @foreach ($mahnungstexte as $text)
                          <tr>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter3 == $mahnungstexte->count() -1) rounded-bl-lg @endif">{{$text->title}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 overflow-hidden w-96 text-ellipsis inline-block">{{$text->text}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$text->aktiviert}}</td>
                              <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter3 == $mahnungstexte->count() -1) rounded-br-lg @endif">
                                <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/bearbeiten/mahnung/{{$text->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                              </td>
                          </tr>
                          @php
                              $counter3++;	
                          @endphp
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
          <div id="phone" class="hidden">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Text</th>
                            <th scope="col" class="px-3 py-2 text-left text-normal font-normal text-gray-900">Aktiviert</th>
                            <th scope="col" class="px-3 py-2 text-right text-normal font-normal text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">

                          @php
                          $counter4 = 0;
                      @endphp
                          @foreach ($phonetexte as $text)
                          <tr>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter4 == $phonetexte->count() -1) rounded-bl-lg @endif">{{$text->title}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 overflow-hidden w-96 text-ellipsis inline-block">{{$text->text}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$text->aktiviert}}</td>
                              <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter4 == $phonetexte->count() -1) rounded-br-lg @endif">
                                <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/bearbeiten/phone/{{$text->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                              </td>
                          </tr>
                          @php
                              $counter4++;
                          @endphp
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
            let tabs = ["vergleich", "mahnung", "rechnung", "phone"];
            let currenttab = "vergleich";
            function changeTab(tab) {
              tabs.forEach(element => {
                if(element != tab) {
                  document.getElementById(element).classList.add("hidden");
                  document.getElementById(element + "-tab").classList.remove("bg-blue-600", "text-white", "hover:bg-blue-600", "hover:text-white");
                  document.getElementById(element + "-tab").classList.add("bg-gray-200", "text-black", "hover:bg-blue-600", "hover:text-white");
                } else {
                  document.getElementById(element).classList.remove("hidden");
                  document.getElementById(element + "-tab").classList.remove("bg-gray-200", "text-black", "hover:bg-blue-600", "hover:text-white");
                  document.getElementById(element + "-tab").classList.add("bg-blue-600", "text-white");

                  currenttab = element;
                }
              });
            }
            
            @isset($mahnung)
            changeTab("mahnung");
            @endisset
            
            @isset($rechnung)
            changeTab("rechnung");
            @endisset

            @isset($phone)
            changeTab("phone");
            @endisset

            function addText() {
              window.location.href = '{{url('/')}}/crm/vergleichsetting/bearbeiten/' + currenttab;
            }

            function readText(type) {
              
            }
          </script>

          @isset($bearbeiten)
              @if ($bearbeiten == true)
                  
                  <div id="edit">
                   
                    <form action="{{url("/")}}/crm/textvorlage/neu" id="submit-textvorlage-form" method="POST">
              
                    @CSRF
                    @include('forEmployees.modals.vergleichstexteBearbeiten')
                     
                  </form>
                  </div>
              @endif
          @endisset

    </div>
      

</body>
</html>