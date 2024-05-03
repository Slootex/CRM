<!DOCTYPE html>
<html lang="en" class="bg-white h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="js/test.js"></script>
    <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body onload="printJS('label_frame', 'html')">
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <div style="width: 40%;" class="m-auto pb-60 rounded-md bg-white p-4">
      <div class="w-full">
        <h1 class="text-3xl text-center font-bold">Versandschein bereits vorhanden</h1>
      </div>  
      
      <div class="mt-4 w-60 m-auto">
        <input type="text" oninput="checkLabel(event)" class="rounded-md bg-green-50 border border-gray-600 text-xl h-12 w-60 m-auto">
      </div>

      <div>
        <img src="{{url("/")}}/temp/{{$label}}.png" class="w-full  mt-48" style="transform: rotate(90deg)" frameborder="0">
      </div>

      <div class=" m-auto">
        <form action="{{url("/")}}/crm/shipping/new/{{$ausgang->shortcut}}/tec/tec" method="POST">
          @CSRF
          <button type="submit" class="text-white text-xl font-semibold px-6 py-3 rounded-md m-auto mt-16 bg-blue-600 hover:bg-blue-500 float-left">Neuen Versandschein erstellen</button>
          <button type="button" onclick="printLabel('{{$label}}')" class="text-white text-xl font-semibold px-6 py-3 rounded-md m-auto mt-16 bg-blue-600 hover:bg-blue-500 float-left">Aktuellen Versandschein nutzen</button>
        </form>
      </div>

    </div>


<script>
  function checkLabel(e) {
    if(e.keyCode === 13){
      if(document.getElementById("label").value == "{{$label}}") {
        document.getElementById("label").classList.remove("bg-red-200");
        document.getElementById("label").classList.add("bg-green-200");
        window.location.href = "{{url('/')}}/crm/packtisch";
      } else {
        if(document.getElementById("error").classList.contains("hidden")) {
          document.getElementById("error").classList.remove("hidden");
        }
        document.getElementById("label").value = "";
        document.getElementById("label").classList.add("bg-red-200");
        document.getElementById("error").innerHTML = ' <div aria-live="assertive" class="pointer-events-none fixed inset-0 mt-8 flex items-end px-4 py-6 sm:items-start sm:p-6 animate__fadeInDown animate__animated" id="error"><div class="flex w-full flex-col items-center space-y-4 sm:items-end"><div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 " >  <div class="p-4">    <div class="flex items-start">      <div class="flex-shrink-0">              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="h-6 w-6 text-red-400" >          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />        </svg>              </div>      <div class="ml-3 w-0 flex-1 pt-0.5">        <p class="text-sm font-medium text-gray-900">Falsche Sendungsnummer, bitte nochmal den richtigen abscannen</p>      </div>      <div class="ml-4 flex flex-shrink-0">        <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">          <span class="sr-only">Close</span>          <!-- Heroicon name: mini/x-mark -->          <svg onclick="document.getElementById(' + "'"+ "error" + "'" + ').classList.add(' + "'"+ "hidden" + "'" + ')" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />          </svg>                  </button>      </div>    </div>  </div></div></div></div>'
        
      }
    }
  }
</script>
</body>
</html>