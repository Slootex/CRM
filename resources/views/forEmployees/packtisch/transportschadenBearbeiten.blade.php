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
    <div class="w-3/5 bg-white m-auto mt-16 h-auto shadow" style="height: 35rem;">
       <form action="{{url("/")}}/crm/transportschaden/beenden" method="POST">
        @CSRF
        <div class="float-left mt-6 ml-5">
            <label for="comment" class="block font-medium text-gray-700" style="resize: none;">Tranportschaden beschreibung</label>
            <div class="mt-1">
              <textarea rows="4" name="comment" id="comment" disabled class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{$transportschaden->borken_report}}</textarea>
            </div>
            <div>
                <h1 class="text-xl mt-4">Gerät: <a class="text-green-600 underline" href="{{url("/")}}/crm/change/order/{{$transportschaden->process_id}}" target="_blank" rel="noopener noreferrer">{{$transportschaden->component_number}}</a></h1>
                <h2 class="text-xl mt-4">Derzeitiger Lagerplatz: <span class="text-green-600">{{$shelfe->shelfe_id}}</span></h2>
            </div>
          </div>
        
        <embed class="float-right" style="width: 30rem; height: 35rem;" src="{{url("/")}}/crm/auftrag/pdf/{{$transportschaden->component_number}}/{{$transportschaden->process_id}}#toolbar=0" type="">
       </form>
      </div>
</body>
</html>