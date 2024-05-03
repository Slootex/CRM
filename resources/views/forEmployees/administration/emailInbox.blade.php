<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <script src="{{url('/')}}/js/loading-bar.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/loading-bar.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-white"><p class="float-left">Einstellungen</p> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Email-Eingang <span class="font-normal">(Techniker)</span></h1>
     <button type="button" onclick="refresh()" class="float-left ml-8 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
    </svg>
    </button>
     <button type="button" onclick="zuweisenAutomatisch()" class="float-left ml-10 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Aufträgen zuweisen (Automatisch)</button>
<form action="{{url('/')}}/crm/emailInbox/zuweisenManuel" method="POST">
  @CSRF
  <button type="button" onclick="document.getElementById('aufträge').classList.remove('hidden')" class="ml-10 float-left inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Aufträgen zuweisen (Manuel)</button>

    <div id="aufträge" class="hidden">

      <h1 class="float-left text-white text-xl font-semibold ml-5">-></h1>

      <select name="auftrag" onchange="document.getElementById('finalManuelZuweisen').classList.remove('hidden')" class="ml-5 float-left block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        <option value="">Auftrag wählen</option>
        @foreach ($orders as $order)
            <option value="{{$order->process_id}}">{{$order->process_id}}</option>
        @endforeach
      </select>

      <div id="finalManuelZuweisen" class="hidden">

        <h1 class="float-left text-white text-xl font-semibold ml-5">-></h1>

        <button type="submit" class="float-left ml-5 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zuweisen</button>
      </div>
    </div>
    <button type="button" onclick="document.getElementById('archiv').classList.add('hidden'); document.getElementById('custom').classList.remove('hidden')" class="ml-10 float-left inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Aktiv</button>
    <button type="button" onclick="document.getElementById('archiv').classList.remove('hidden'); document.getElementById('custom').classList.add('hidden')" class="ml-10 float-left inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Archive</button>
     <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">

    <div class="mx-auto max-w-full sm:px-6 lg:px-8">


      
      <div class="rounded-lg md:rounded-lg" id="custom">
            
  
        <div class="mt-8 flex flex-col rounded-lg md:rounded-lg">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 rounded-lg md:rounded-lg">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 rounded-lg md:rounded-lg" >
              <div class="overflow-auto  shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th></th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Absender</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Betreff</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Angeschaut</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Zuweisungen</th>
                      <th scope="col" class="px-3 py-3 text-right font-semibold text-lg text-gray-900">
                        <span >Aktion</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($emails as $email)
                    @unless(isset($inboxHistory->where("email_id", $email->id)->first()->id))

                    <tr>
                      <td class="w-6"><input type="checkbox" class="m-auto rounded-sm text-center ml-2" name="{{$email->id}}-email" value="{{$email->id}}"></td>
                        <td class=" px-3 py-1 text-sm  text-center text-gray-500"><div style="background-color: coral" class="rounded-lg w-auto "><p class="w-auto" style="color: rgb(117, 11, 11)">{{$email->fromAddress}}</p></div></td>
                        <td class="whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500">{{$email->subject}}</td>
                        <td class="whitespace-nowrap px-3 py-1  text-center text-sm text-gray-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="m-auto w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          </td>
                       
                        <td class="whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500">@foreach ($emailHistory as $history)
                            @if ($history->id == $email->id)
                                {{$history->process_id}}, <a href="{{url('/')}}/crm/zuweisen/zurück/{{$email->id}}/{{$history->process_id}}" class="underline text-red-600">zurück</a> <br>
                            @endif
                        @endforeach</td>

                        <td class="relative whitespace-nowrap  py-1 pl-3 pr-1 text-right text-sm font-medium ">
                          <button type="button" onclick="lookupEmail('{{$email->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Anschauen</button>
                          <button type="button" onclick="window.location.href = '{{url('/')}}/crm/mailinbox/zum/archiv/{{$email->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">zum Archiv</button>

                        </td>
                    </tr>
                    @endunless
                    @endforeach
      
                    <!-- More people... -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="rounded-lg md:rounded-lg hidden" id="archiv">
            
  
        <div class="mt-8 flex flex-col rounded-lg md:rounded-lg">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 rounded-lg md:rounded-lg">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 rounded-lg md:rounded-lg" >
              <div class="overflow-auto  shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th></th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Absender</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Betreff</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Angeschaut</th>
                      <th scope="col" class="px-3 py-3 text-center font-semibold text-lg text-gray-900">Zuweisungen</th>
                      <th scope="col" class="px-3 py-3 text-right font-semibold text-lg text-gray-900">
                        <span >Aktion</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($emails as $email)
                    @isset($inboxHistory->where("email_id", $email->id)->first()->id)
                    <tr>
                      <td class="w-6"><input type="checkbox" class="m-auto rounded-sm text-center ml-2" name="{{$email->id}}-email" value="{{$email->id}}"></td>
                        <td class=" px-3 py-1 text-sm  text-center text-gray-500"><div style="background-color: coral" class="rounded-lg w-auto "><p class="w-auto" style="color: rgb(117, 11, 11)">{{$email->fromAddress}}</p></div></td>
                        <td class="whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500">{{$email->subject}}</td>
                        <td class="whitespace-nowrap px-3 py-1  text-center text-sm text-gray-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="m-auto w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          </td>
                       
                        <td class="whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500">@foreach ($emailHistory as $history)
                            @if ($history->id == $email->id)
                                {{$history->process_id}}, <a href="{{url('/')}}/crm/zuweisen/zurück/{{$email->id}}/{{$history->process_id}}" class="underline text-red-600">zurück</a> <br>
                            @endif
                        @endforeach</td>

                        <td class="relative whitespace-nowrap  py-1 pl-3 pr-1 text-right text-sm font-medium ">
                          <button type="button" onclick="lookupEmail('{{$email->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Anschauen</button>
                          <button type="button" onclick="window.location.href = '{{url('/')}}/crm/mailinbox/zum/aktiv/{{$email->id}}'" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">zu Aktive</button>

                        </td>
                    </tr>
                    @endisset
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
                <div id="emailModal">
                    @include('forEmployees.modals.emailInbox-email', ["changeEmail" => $changeEmail])
                </div>
              
              @endif
          @endisset

    </div>
  </form>
    <br>
    <br>
    <br>
    <style type="text/css">
      .ldBar-label {
        color: #09f;
        font-family: 'varela round';
        font-size: 4em;
        font-weight: 900;
      }
      
    </style>
      
    <div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="progressbar">
      <!--
        Background backdrop, show/hide based on modal state.
    
        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
      <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
        <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
          <!--
            Modal panel, show/hide based on modal state.
    
            Entering: "ease-out duration-300"
              From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100 translate-y-0 sm:scale-100"
              To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          -->
          <div class="relative transform overflow-hidden rounded-lg bg-none px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-6" >
            <div class="myBar label-center"></div>

          </div>
        </div>
      </div>
    </div>
       
    <script>
      let bar;
      function zuweisenAutomatisch() {

        document.getElementById("progressbar").classList.remove("hidden");

        let intervalID = window.setInterval(myCallback, 45);

        bar = new ldBar(".myBar", {
         "stroke": '#f00',
         "stroke-width": 0,
         "preset": "fan",
         "value": 0
        });

        window.location.href = '{{url("/")}}/crm/emailInbox/zuweisen';

      }

      function refresh() {

        document.getElementById("progressbar").classList.remove("hidden");

        @isset($bearbeiten)
        let intervalID = window.setInterval(myCallback, 45);
        @else
        let intervalID = window.setInterval(myCallback, 30);
        @endisset

        bar = new ldBar(".myBar", {
         "stroke": '#f00',
         "stroke-width": 0,
         "preset": "fan",
         "value": 0
        });

        window.location.href = '{{url("/")}}/crm/mailinbox';

        }

        function lookupEmail(emailId) {

        document.getElementById("progressbar").classList.remove("hidden");

        let intervalID = window.setInterval(myCallback, 38);

        bar = new ldBar(".myBar", {
         "stroke": '#f00',
         "stroke-width": 0,
         "preset": "fan",
         "value": 0
        });

        window.location.href = '{{url('/')}}/crm/emailInbox/anschauen/' + emailId;

        }

      let count = 0;
      function myCallback() {
        bar.set(count++);
      }
    </script>
</body>
</html>