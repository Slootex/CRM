<!DOCTYPE html>
<html lang="en" class="bg-gray-50 h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts/top-menu', ["menu" => "auftrag"])

    <div class="overflow-hidden rounded-lg bg-white shadow w-3/5 m-auto mt-40">
        <div class="px-4 py-5 sm:p-6 w-full">
            <h1 class="text-center text-xl ">Hilfsbarcode: <span class="text-blue-600">{{$barcode->helper_code}}</span></h1>
          <div class="pl-5 pt-5 pb-5 border w-full bg-gray-100">
            <div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    
  </div>
  <div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="overflow-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg max-h-96">
          <table class="min-w-full divide-y divide-gray-300 ">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Vorname</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nachname</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Auftragsnummer</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Gerätetyp</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Gerät</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right" style="padding-right: 1.5rem">Aktion</th>
             
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($orders as $order)
                <tr>
                    <td class="whitespace-nowrap text-sm text-gray-500">{{$order->firstname}}</td>
                    <td class="whitespace-nowrap text-sm text-gray-500">{{$order->lastname}}</td>
                    <td class="whitespace-nowrap text-sm text-gray-500">{{$order->process_id}}</td>
                    <form action="{{url("/")}}/crm/hilfscode/zuweisen/{{$order->process_id}}" method="POST">
                        @CSRF
                        <td class="whitespace-nowraptext-sm text-gray-500"><div>
                            <input type="text" class="hidden" name="helper" value="{{$barcode->helper_code}}">
                            <div>
                           
                              <fieldset class="mt-0">
                                <legend class="sr-only">Notification method</legend>
                                <div class="">
                                  <div class="flex items-center float-left mr-6">
                                    <input id="email" name="notification-method" type="radio" name="typ" value="org" onclick="changeType(this.value, '{{$order->process_id}}')" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="email" class="ml-3 block text-sm font-medium text-gray-700">ORG</label>
                                  </div>
                            
                                  <div class="flex items-center">
                                    <input id="sms" name="notification-method" type="radio" name="typ" value="at" onclick="changeType(this.value, '{{$order->process_id}}')" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">AT</label>
                                  </div>
                            
                                  
                                </div>
                              </fieldset>
                            </div></td>
                          <td class="whitespace-nowraptext-sm text-gray-500"><div>
                            <select id="device-{{$order->process_id}}" onchange="showZuteilen(this.value, '{{$order->process_id}}')" name="device" class="hidden mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                              <option value="null" selected>Auswählen</option>
                              @if ($devices->where("process_id", $order->process_id)->where("component_type", "ORG") != null)
                              @foreach ($devices->where("process_id", $order->process_id)->where("component_type", "ORG") as $device)
                                <option value="{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}">{{$device->process_id. "-". $device->component_id. "-". $device->component_type. "-". $device->component_count}}</option>
                              @endforeach
                              
                              @endif
                              
                            </select>
                          </div></td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <button type="submit" id="button-zuteilen-{{$order->process_id}}" class="hidden inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zuteilen</button>
                    </td>
                </form>
                  </tr>
                @endforeach
              <!-- More people... -->
            </tbody>
          </table>

        </div>
        <button type="button" onclick="window.location.href = '{{url('/')}}/crm/hilfscode/versenden/{{$barcode->helper_code}}'" class="inline-flex items-center rounded-md float-right mt-16 w-60 border border-transparent bg-blue-600 hover:bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Versenden</button>
      </div>
    </div>
  </div>
</div>
          </div>

        </div>
      </div>

      <script>
        function changeType(val ,proc) {
          console.log("device-"+ proc);
          if(val == "org") {
            document.getElementById("device-"+ proc).classList.add("hidden");
            showZuteilen(val, proc);
                    } else {
                      document.getElementById("device-"+ proc).classList.remove("hidden");

                    }
        }

        function showZuteilen(val, pro) {
          document.getElementById("button-zuteilen-" + pro).classList.remove("hidden");
        }
      </script>
</body>
</html>