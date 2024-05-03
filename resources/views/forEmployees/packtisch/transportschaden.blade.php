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
    <div class="w-3/5 bg-white m-auto mt-16 h-auto shadow">
       <form action="{{url("/")}}/crm/transportschaden" method="POST">
        @CSRF
        <br>
        <div class="w-96 h-60 m-auto blur-md invert drop-shadow-2xl md:filter-none">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-36 h-36 m-auto text-red-600" style="filter: drop-shadow(0px 0px 7px rgba(0, 0, 0, 0.507));">
             <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
           </svg>  
           <h1 class="text-red-500 text-3xl text-center">Transportschaden melden</h1>      
           <hr class="w-36 m-auto mt-2 mb-2">  
           <h1 class="text-gray-400 text-xl text-center">Gerät: {{$comp}}</h1>        
        </div>
        <br>
        
        <br>
        <div>
         <div class="ml-7">
             <label for="comment" class="block text-xl font-medium text-gray-700">Welcher Schaden ist am Gerät</label>
             <div class="mt-1">
               <textarea rows="4" name="broken-report" id="comment" class="block w-3/5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
             </div>
           </div>
 
           <div class="mt-5 mb-3">
             <h1 class="ml-7 text-lg float-left mr-5">Bilder Hochladen als:  <span class="text-green-600 font-bold">{{$process_id}}</span></h1>
             <h2 class="text-lg text-gray-400 underline"><a href="{{url('/')}}/crm/auftrag/pdf/{{$comp}}/{{$process_id}}#toolbar=0" target="_blank" rel="noopener noreferrer">Bilder Anschauen</a></h2>
           </div>
 
         <div class="mt-5 ml-7">
             <label for="text" class="block text-xl font-medium text-gray-700 mb-1">Barcode: {{$comp}}</label>
             <input type="text" name="barcode" id="text" class="block w-60 h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" >
           </div>
         <div class="mt-5 ml-7">
             <label for="text" class="block text-xl font-medium text-gray-700 mb-1">Lagerplatz: {{$shelfe->shelfe_id}}</label>
           <input type="text" name="shelfe" id="text" class="block w-60 h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" >
         </div>
       </div>
       <button type="submit" class=" ml-7 mt-5 w-60 text-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Absenden</button>
 <br>
 <br>
       <br>
       </form>
      </div>
</body>
</html>