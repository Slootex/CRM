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

    <div class="overflow-hidden w-3/5 bg-white m-auto h-auto mt-16 px-6 py-2">
       <form action="{{url("/")}}/crm/vollmacht" method="POST">
        @CSRF
        <div class="ml-16">
          <label for="email" class="block text-normal font-medium text-gray-700">Datum</label>
          <div class="mt-1">
            <input type="text" name="date" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" >
          </div>
      </div>
      <div class="ml-16 mt-6">
          <label for="email" class="block text-normal font-medium text-gray-700">Sendungsnummer</label>
          <div class="mt-1">
            <input type="text" name="label" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" >
          </div>
      </div>
      <div class="ml-16">
          <label for="email" class="block text-normal font-medium text-gray-700">Name und Adresse</label>
          <div class="mt-1">
            <input type="text" name="adress" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" >
          </div>
      </div>
      <button class=" h-6 bg-blue-600 hover:bg-blue-500 rounded-lg text-white px-2 py.5 ml-96 mt-6 mb-6">Absenden</button>
       </form>
    </div>

     
</body>
</html>