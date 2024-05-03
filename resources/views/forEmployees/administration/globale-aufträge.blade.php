<!DOCTYPE html>
<html lang="en" class="bg-white h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>   
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts/top-menu', ["menu" => "auftrag"])

    <div class="overflow-hidden w-3/5 m-auto h-auto mt-36 rounded-lg bg-white shadow-xl">
        <div class="px-4 py-5 sm:p-6">
          <h1 class="text-2xl">Globale Aufträge</h1>
          
          <button type="button" onclick="document.getElementById('globaler-auftrag').classList.remove('hidden')" style="margin-top: -1.5rem" class="ml-4 bg-blue-600 float-right rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-400">
            <p class="text-white">Globaler Abholauftrag</p>      
          </button> 
          
          <button type="button" onclick="document.getElementById('hinweis').classList.remove('hidden')" style="margin-top: -1.5rem" class="bg-blue-600 ml-4 float-right rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-400">
            <p class="text-white">Globaler Hinweis</p>      
          </button> 

          <button type="button" onclick="document.getElementById('globale-zahlung-modal').classList.remove('hidden')" style="margin-top: -1.5rem" class="bg-blue-600 float-right rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-400">
            <p class="text-white">Globale Zahlung</p>      
          </button> 

          <button type="button" onclick="document.getElementById('globale-nachforschung').classList.remove('hidden')" style="margin-top: -1.5rem" class="mr-4 bg-blue-600 float-right rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-400">
            <p class="text-white">Globaler Nachforschungsauftrag</p>      
          </button> 
      @include('forEmployees.modals.globaleZahlung')    
        
      <div id="hinweis" class="hidden">
                         
<form action="{{url("/")}}/crm/packtisch/neuer-hinweis" id="packtisch-hinweis-form" method="POST">
  @csrf
  <div class="grid grid-cols-3 px-6"  style="width: 53.5%">
    <p class="mt-8">Typ</p>
    <select id="hinweis-type" onchange="document.getElementById('hinweis-submit').innerHTML = 'an ' + this.value + ' senden'" name="type"class="mt-8 col-span-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
      <option value="Packtisch">Packtisch</option>
      <option value="Auftragsübersicht">Auftragsübersicht</option>
      <option value="Interessentenübersicht">Interessentenübersicht</option>
    </select>

    <p class="mt-8">Warnhinweis</p>
    <textarea rows="4" name="hinweis" id="comment" class="block col-span-2 mt-8 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
  
    <p class="mt-8">Farbe</p>
    <input type="color" value="#eb4034" name="color" id="email" class="block col-span-2 mt-8 h-9 w-full rounded-md border-0  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
  
    <div class="mt-10 col-start-3 mb-4">
      <hr>
      <button id="hinweis-submit" type="submit" onclick="loadData()" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-72  mt-4">An Packtisch senden</button>
    </div>
  </div>
  <input type="hidden" name="process_id" value="Globaler Auftrag">
</form>
<script>

  
var optionsHinweis = {
        error: function() {
            let title = "Unbekannter Fehler!";
            let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte gib diesen einem Teamleiter weiter!";
            newErrorAlert(text, title);
        },
        success: function() {
          let title = "Hinweis erfolgreich!";
          let text = "Der Hinweis wurde erfolgreich an den/die" + document.getElementById("hinweis-type").value + " gesendet."; 
          newAlert(title, text);
          savedPOST();
        }
    };

</script>
      </div>
@include('includes.alerts.main')

      <div id="globale-nachforschung" class="hidden">
        <form action="{{url("/")}}/crm/packtisch/neuer-nachforschungsauftrag" id="nachforschung-form" method="POST">
          @csrf
          <input type="hidden" name="process_id" value="Global">
          <div class="grid grid-cols-3 w-full">
            <p class="mt-8">Gerätenummer</p>

            <div class="mt-8">
              <div class="">
                <input type="text" name="device-124" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
            </div>

            <p class="mt-8 col-start-1">Aktuelle Auftragsdokumente</p>
            <label class="border w-36 mt-8 h-10 border-gray-400 mr-2 flex flex-col items-center px-4 py-1 bg-white rounded-lg tracking-wide uppercase cursor-pointer hover:bg-blue hover:text-blue-400">
                    
              <span class="mt-0 text-base leading-normal">
                  <span class="float-left" id="emailvorlage-file"></span>  
                  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                  </svg>
              </span>
              <input type='file' oninput="uploadNachforschungDocuments()" multiple class="hidden" id="nachforschung-fileinput" />
            </label>
            <div id="nachforschung-files-div" class="mt-2">
                <input type="file" class="hidden" id="nachforschung-extradatein">
            </div>

            <p class="mt-8 col-start-1">Zusatzkommentar an Packtisch</p>
            <textarea rows="4" name="info" id="comment" class="block w-full mt-8 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>

          </div>

          <button onclick="loadData();" class="bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium px-4 py-2" type="submit">an Packtisch</button>
        </form>
      </div>
<script>
  $( document ).ready(function() {
    $('#nachforschung-form').ajaxForm(function() { newAlert("Erfolgreich!", "Der Nachforschungsauftrag wurde erfolgreich übermittelt"); savedPOST(); });

  });

</script>
      <div id="globaler-auftrag" class="hidden">
        
                       
                        
    <form action="{{url("/")}}/crm/packtisch/neuer-abholauftrag" id="packtisch-abholauftrag-form" method="POST">
      @csrf
  <div class="grid grid-cols-3 w-full">
      <input type="hidden" name="global" value="true">
      <p class="mt-8">Vollmachtnehmer</p>
      <div class="mt-8 col-span-2">
          <div class="flex">
          <div class="relative mt-2 items-center flex-auto">
            <input type="text" name="absender" id="absender" value="Gazi Ahmad, Strausberger Platz 13, 10243, Berlin" disabled class="block text-md h-12 w-full text-gray-400 rounded-md border-0 py-1.5 pr-14 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:leading-6">
            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
              <kbd class="inline-flex items-center rounded px-1 font-sans text-xs text-blue-400 underline"><button type="button" onclick="document.getElementById('absendermodal').classList.remove('hidden')">ändern</button></kbd>
            </div>
          </div>
        </div>
      </div>

        <p class="mt-8">Sendungsnummer</p>
          <div class="mt-8">
              <div class="relative  rounded-md shadow-sm">
                <input type="text" required name="trackingnumber" id="account-number" class="block z-10 w-full rounded-md border-0 py-1.5 pr-10 text-gray-600 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
           </div>
          <p></p>

          <p class="mt-8">Abholaddresse</p>
          <div class="mt-8 grid grid-cols-3 col-span-2 gap-2">
              <div class="relative">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Firma</label>
                  <input type="text" name="company" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>

              <div class="relative">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Vorname</label>
                <input type="text" required name="firstname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>

              <div class="relative">
                <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Name</label>
                <input type="text" required name="lastname" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>

              <div class="relative col-span-2 mt-4">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straße</label>
                  <input type="text" required name="street" id="street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
              <div class="relative mt-4">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straßennummer</label>
                  <input type="text" required name="street_number" id="street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>

              <div class="relative mt-4">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                  <input type="text" required name="zipcode" id="zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
              <div class="relative mt-4">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                  <input type="text" required name="city" id="city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
              <select id="country" required name="country" class="mt-4 h-9 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option>Land</option>
                  @foreach ($countries as $country)
                      <option value="{{$country->name}}">{{$country->name}}</option>
                  @endforeach
                </select>
          </div>
          <script>

            function uploadNachforschungDocuments() {

              let parent = document.getElementById("nachforschung-files-div");
              let fileCounter = 0;
              Array.from(document.getElementById("nachforschung-fileinput").files)
                .forEach(parentFile => {
                  let button      = document.createElement("button");
                  button.classList.add("px-3", "py-1", "rounded-md", "border", "border-blue-400", "hover:border-red-400", "hover:text-red-400", "h-8", "text-blue-500", "mt-2");
                  button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left sm:hidden xl:hidden 2xl:block">  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>      '+ parentFile["name"];
                  button.setAttribute("onclick", "deleteNachforschungFile('"+ parentFile["name"] +"')");
                  button.setAttribute("id", "nachforschung-filebutton-"+ parentFile["name"]);
                
                  let br = document.createElement("br");
                  br.setAttribute("id", "nachforschung-br-"+ parentFile["name"]);
                
                  let input = document.createElement("input");
                  input.type = "file";
                  input.setAttribute("id", "nachforschung-fileinput-"+ parentFile["name"] );
                  input.name = "extrafile-"+fileCounter + "[]";
                  input.files = document.getElementById("nachforschung-fileinput").files;
                  input.classList.add("hidden");
                
                  let name = document.createElement("input");
                  name.type = "hidden";
                  name.setAttribute("id", "nachforschung-filename-"+ parentFile["name"] );
                  name.name = "filename-"+fileCounter + fileCounter;
                  name.value = parentFile["name"];
                
                  parent.appendChild(input);   
                  parent.appendChild(br);
                  parent.appendChild(button);
                  parent.appendChild(name);
                  fileCounter++;
               });
            }

            function deleteNachforschungFile(id) {
              document.getElementById("nachforschung-filebutton-"+id).remove();
              document.getElementById("nachforschung-fileinput-"+id).remove();
              document.getElementById("nachforschung-br-"+id).remove();
              document.getElementById("nachforschung-filename-"+id).remove();
            }
              
  var optionsAbholung = {
      error: function() {
          let title = "Unbekannter Fehler!";
          let text = "Es wurde ein Unbekannter Fehler endeckt! Bitte schau das du eine Abholaddresse ausgewählt hast!";
          newErrorAlert(text, title);
      },
      success: function() {
        let title = "Abholauftrag erfolgreich!";
        let text = "Der Abholauftrag wurde erfolgreich an den Packtishc gesendet.";
        newAlert(title, text);
        savedPOST();
      }
  };


initializeAbholauftrag();
function initializeAbholauftrag() {

var input2 = document.getElementById('street');

var autocomplete2 = new google.maps.places.Autocomplete(input2);

autocomplete2.addListener('place_changed', function () {

  var place2 = autocomplete2.getPlace();
  
  let types = [];
  let names = [];
    
  place2.address_components.forEach(comp => {
      types.push(comp.types[0]);
      names.push(comp["long_name"]);
  });

  let counter = 0
  document.getElementById("street").value = "";
  document.getElementById("street_number").value = "";
  document.getElementById("city").value = "";
  document.getElementById("zipcode").value = "";
  document.getElementById("country").value = "";
  console.log(types);
  types.forEach(type => {
    let name = names[counter];
    if(type == "route") {
      let street    = name;
      document.getElementById("street").value = street;
    }
    if(type == "street_number") {
      let number    = name;
      document.getElementById("street_number").value = number;
    }
    if(type == "postal_town") {
      let city    = name;
      document.getElementById("city").value = city;
    }
    if(type == "locality") {
      let city    = name;
      document.getElementById("city").value = city;
    }
    if(type == "postal_code") {
      let zipcode    = name;
      document.getElementById("zipcode").value = zipcode;
    }
    if(type == "country") {
      let country    = name;
      document.getElementById("country").value = country;
    }
    counter++;
  });




  // place variable will have all the information you are looking for.

  $('#lat').val(place2.geometry['location'].lat());

  $('#long').val(place2.geometry['location'].lng());

});

var input = document.getElementById('ab_street');

var autocomplete = new google.maps.places.Autocomplete(input);

autocomplete.addListener('place_changed', function () {

var place = autocomplete.getPlace();

let types = [];
let names = [];

place.address_components.forEach(comp => {
types.push(comp.types[0]);
names.push(comp["long_name"]);
});

let counter = 0
document.getElementById("ab_street").value = "";
document.getElementById("ab_street_number").value = "";
document.getElementById("ab_city").value = "";
document.getElementById("ab_zipcode").value = "";
document.getElementById("ab_country").value = "";
console.log(types);
types.forEach(type => {
let name = names[counter];
if(type == "route") {
let street    = name;
document.getElementById("ab_street").value = street;
}
if(type == "street_number") {
let number    = name;
document.getElementById("ab_street_number").value = number;
}
if(type == "postal_town") {
let city    = name;
document.getElementById("ab_city").value = city;
}
if(type == "locality") {
let city    = name;
document.getElementById("ab_city").value = city;
}
if(type == "postal_code") {
let zipcode    = name;
document.getElementById("ab_zipcode").value = zipcode;
}
if(type == "country") {
let country    = name;
document.getElementById("ab_country").value = country;
}
counter++;
});




// place variable will have all the information you are looking for.

$('#lat').val(place.geometry['location'].lat());

$('#long').val(place.geometry['location'].lng());

});
}

          </script>
          
          

            <p class="mt-8">Zusatzkommentar Packtisch</p>
            <textarea name="info" id="" class="mt-8 rounded-md border border-gray-300 h-16 col-span-2" cols="30" rows="10"></textarea>

            <hr class="mt-10">
            <hr class="mt-10">
              <div class="mt-10 mb-4">
                  <hr>
                  <button type="submit" onclick="getGeb()" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60  mt-4">An Packtisch senden</button>
              </div>

              <script>
                function getGeb() {
                  if(document.getElementById("ab_geb").value == "") {
                    document.getElementById("absendermodal").classList.remove("hidden");
                  }
                }
              </script>

              
  <div class="relative hidden z-10" id="absendermodal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
      <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
        <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-96  sm:p-6">
            <div>
              <div class="mt-3 text-center sm:mt-5">
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Vorname</label>
                    <div class="mt-2">
                      <input type="text" value="Gazi" name="ab_firstname" id="ab_firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div>
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Nachname</label>
                    <div class="mt-2">
                      <input type="text" value="Ahmad" name="ab_lastname" id="ab_lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Straße</label>
                    <div class="mt-2">
                      <input type="text" value="Strausberger Platz" name="ab_street" id="ab_street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Straßennummer</label>
                    <div class="mt-2">
                      <input type="text" name="ab_street_number" value="13" id="ab_street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Postleitzahl</label>
                    <div class="mt-2">
                      <input type="text" name="ab_zipcode" value="10243" id="ab_zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Stadt</label>
                    <div class="mt-2">
                      <input type="text" name="ab_city" value="Berlin" id="ab_city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="location" class="block text-sm text-left font-medium leading-6 text-gray-900">Land</label>
                    <select id="ab_country" name="ab_country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      @foreach ($countries as $country)
                      @if ($country->name == "Deutschland")
                        <option selected value="{{$country->name}}">{{$country->name}}</option>
                        @else
                        <option value="{{$country->name}}">{{$country->name}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="mt-2">
                      <label for="email" class="block text-left text-sm font-medium leading-6 text-gray-900">Geb. Datum</label>
                      <div class="mt-2">
                        <input type="date" required name="ab_geb" id="ab_geb" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                      </div>
                    </div>
                </div>
                <div class="mt-2">
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6 ">
              <button type="button" onclick="document.getElementById('absendermodal').classList.add('hidden')" class=" w-36 justify-center rounded-md border px-4 py-2 text-base font-medium text-black shadow-sm  focus:outline-none focus:ring-2cus:ring-offset-2  sm:text-sm float-right">Zurück</button>
              <button type="button" onclick="setAbsender()" class="float-left w-36 rounded-md border px-4 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-500 shadow-sm  focus:outline-none focus:ring-2cus:ring-offset-2 ">Speichern</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function setAbsender() {
                  document.getElementById("absendermodal").classList.add("hidden");
                  document.getElementById("absender").value = document.getElementById("ab_firstname").value + " " + document.getElementById("ab_lastname").value + ", " + document.getElementById("ab_street").value + " " + document.getElementById("ab_street_number").value + ", " + document.getElementById("ab_zipcode").value + ", " + document.getElementById("ab_country").value;
                }
  </script>
  <input type="hidden" name="process_id" value="Globaler Auftrag">
  </form>

      </div>
                        

      </div>
      </div>

      <script>
        function addShelfe() {

            var shelfe  = document.getElementById("shelfe").value;

            var input   = document.createElement("input");
            input.type  = "text";
            input.className = "hidden";
            input.setAttribute("name", "shelfe-" + shelfe);
            input.setAttribute("id", "shelfe-" + shelfe);

            document.getElementById("shelfes").appendChild(input);

            var text    = document.createElement("p");
            text.innerHTML = shelfe;
            text.className = "mt-5 float-left"
            text.setAttribute("id", "p-shelfe-" + shelfe);
            document.getElementById("shelfes").appendChild(text);   


            var button = document.createElement("button");
            button.innerHTML = "-";
            button.className = "mt-5 ml-2 inline-flex items-center rounded-md border border-transparent bg-red-600 px-2 py-1 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2";
            button.setAttribute("id", "b-shelfe-" + shelfe);
            button.setAttribute("onclick", "removeShelfe('"+ shelfe +"')");
            document.getElementById("shelfes").appendChild(button);   

            var br      = document.createElement("br");
            br.setAttribute("id", "br-shelfe-" + shelfe);

            document.getElementById("shelfes").appendChild(br);   



        }

        function removeShelfe(shelfe) {
            document.getElementById("b-shelfe-" + shelfe).remove();
            document.getElementById("br-shelfe-" + shelfe).remove();
            document.getElementById("shelfe-" + shelfe).remove();
            document.getElementById("p-shelfe-" + shelfe).remove();


        }
      </script>

      @isset($abholung)
          <script>
            newAlert("Erfolgreich!", "Der Abholauftrag wurde erfolgreich an den Packtisch gesendet!");
          </script>
      @endisset


</body>
</html>