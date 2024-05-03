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

    <div style="width: 40%;" class="m-auto pb-60 rounded-md bg-white p-4 mt-10">
      <div class="w-full">
        <h1 class="text-3xl text-center font-bold">Versandschein abscannen</h1>
      </div>

      <div class="mt-4">
        <svg id="label" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-36 text-red-400 h-36 m-auto">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>        
      </div>

      <div class="mt-4">
        <p class="font-bold text-2xl text-blue-600 text-center">Sendungsnummer <span class="text-black">abscannen</span></p>
        <p class="text-center text-xl font-bold text-red-600 hidden" id="sendungsnummer-error">Sendungsnummer nicht erkannt</p>
      </div>
      
      <div class="mt-4 w-60 m-auto">
        <input type="text" id="input-check" onkeydown="checkLabel(event, this.value)" class="rounded-md bg-green-50 border border-gray-600 text-xl h-12 w-60 m-auto">
      </div>

      <div>
        <img src="{{url("/")}}/temp/{{$number}}.png" id="label-image" class="w-full  mt-48" style="transform: rotate(90deg)" frameborder="0">
      </div>

      <div class="w-32 m-auto">
        <button type="button" onclick="document.getElementById('label-image').printMe()" class="text-white text-xl font-semibold px-6 py-3 rounded-md m-auto mt-16 bg-blue-600 hover:bg-blue-500 absolute">Drucken</button>
      </div>

    </div>


<script>
  HTMLElement.prototype.printMe = printMe;
function printMe(query){
  var myframe = document.createElement('IFRAME');
  myframe.domain = document.domain;
  myframe.style.position = "absolute";
  myframe.style.top = "-10000px";
  document.body.appendChild(myframe);
  myframe.contentDocument.write(this.innerHTML) ;
  setTimeout(function(){
  myframe.focus();
  myframe.contentWindow.print();
  myframe.parentNode.removeChild(myframe) ;// remove frame
  },3000); // wait for images to load inside iframe
  window.focus();
 }
  function checkLabel(e, i) {
    if(e.keyCode === 13){
      if(i == "{{$number}}") {
        document.getElementById("sendungsnummer-error").classList.add("hidden");
        document.getElementById("label").classList.remove("text-red-400");
        document.getElementById("label").classList.add("text-bg-green-400");
        window.location.href = "{{url('/')}}/crm/packtisch";
      } else {
        document.getElementById("input-check").value = "";
        document.getElementById("sendungsnummer-error").classList.remove("hidden");
      }
    }
  }
</script>
</body>
</html>