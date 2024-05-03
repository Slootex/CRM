
                       
                        
    <form action="{{url("/")}}/crm/packtisch/neuer-abholauftrag" id="packtisch-abholauftrag-form" method="POST">
        @csrf
    <div class="grid grid-cols-3 " style="width: 50rem">
        
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
                    <input type="text" required name="street" id="abholung_street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Straßennummer</label>
                    <input type="text" required name="street_number" id="abholung_street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Postleitzahl</label>
                    <input type="text" required name="zipcode" id="abholung_zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Stadt</label>
                    <input type="text" required name="city" id="abholung_city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <select id="abholung_country" required name="country" class="mt-4 h-9 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option>Land</option>
                    @foreach ($countries as $abholung_country)
                        <option value="{{$abholung_country->name}}">{{$abholung_country->name}}</option>
                    @endforeach
                  </select>
            </div>
            <script>


  initializeAbholauftrag();
function initializeAbholauftrag() {

  var abholung_maps = document.getElementById('abholung_street');

  var abholung_maps_complete = new google.maps.places.Autocomplete(abholung_maps);

  abholung_maps_complete.addListener('place_changed', function () {

    var abholung_maps_places = abholung_maps_complete.getPlace();
    
    let types = [];
    let names = [];
      
    abholung_maps_places.address_components.forEach(comp => {
        types.push(comp.types[0]);
        names.push(comp["long_name"]);
    });

    let counter = 0
    document.getElementById("abholung_street").value = "";
    document.getElementById("abholung_street_number").value = "";
    document.getElementById("abholung_city").value = "";
    document.getElementById("abholung_zipcode").value = "";
    document.getElementById("abholung_country").value = "";

    types.forEach(type => {
      let name = names[counter];
      if(type == "route") {
        let abholung_street    = name;
        document.getElementById("abholung_street").value = abholung_street;
      }
      if(type == "street_number") {
        let number    = name;
        document.getElementById("abholung_street_number").value = number;
      }
      if(type == "postal_town") {
        let abholung_city    = name;
        document.getElementById("abholung_city").value = abholung_city;
      }
      if(type == "locality") {
        let abholung_city    = name;
        document.getElementById("abholung_city").value = abholung_city;
      }
      if(type == "postal_code") {
        let abholung_zipcode    = name;
        document.getElementById("abholung_zipcode").value = abholung_zipcode;
      }
      if(type == "country") {
        let abholung_country    = name;
        document.getElementById("abholung_country").value = abholung_country;
      }
      counter++;
    });




    // place variable will have all the information you are looking for.

    $('#lat').val(abholung_maps_places.geometry['location'].lat());

    $('#long').val(abholung_maps_places.geometry['location'].lng());

});

var input = document.getElementById('ab_abholung_street');

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
document.getElementById("ab_abholung_street").value = "";
document.getElementById("ab_abholung_street_number").value = "";
document.getElementById("ab_abholung_city").value = "";
document.getElementById("ab_abholung_zipcode").value = "";
document.getElementById("ab_abholung_country").value = "";
console.log(types);
types.forEach(type => {
let name = names[counter];
if(type == "route") {
  let abholung_street    = name;
  document.getElementById("ab_abholung_street").value = abholung_street;
}
if(type == "street_number") {
  let number    = name;
  document.getElementById("ab_abholung_street_number").value = number;
}
if(type == "postal_town") {
  let abholung_city    = name;
  document.getElementById("ab_abholung_city").value = abholung_city;
}
if(type == "locality") {
  let abholung_city    = name;
  document.getElementById("ab_abholung_city").value = abholung_city;
}
if(type == "postal_code") {
  let abholung_zipcode    = name;
  document.getElementById("ab_abholung_zipcode").value = abholung_zipcode;
}
if(type == "country") {
  let abholung_country    = name;
  document.getElementById("ab_abholung_country").value = abholung_country;
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
                    <button class="hidden" type="submit" id="abholauftrag-submit"></button>
                    <button type="button" onclick="checkBirthday()" class="float-right bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-60  mt-4">An Packtisch senden</button>
                </div>
      
    </div>
    <script>
      function checkBirthday() {
        if (document.getElementById("ab_geb").value == "") {
          document.getElementById("absendermodal").classList.remove("hidden");
          document.getElementById("ab_geb_req").classList.remove("hidden");


        } else {
          document.getElementById("ab_geb_req").classList.add("hidden");
          document.getElementById("abholauftrag-submit").click();
        }
      }
    </script>
    <div class="relative hidden z-50" style="margin-top: 29rem" id="absendermodal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
      <div class="fixed inset-0 bg-gray-500 bg-opaabholung_city-75 transition-opaabholung_city"></div>
    
      <div class="fixed m-auto inset-0 z-50 overflow-y-auto " >
        <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
          <div style="margin-top: -50rem" class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-96  sm:p-6">
            <div>
              <div class="mt-3 text-center sm:mt-5">
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Vorname</label>
                    <div class="mt-2">
                      <input type="text" required value="Gazi" name="ab_firstname" id="ab_firstname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div>
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Nachname</label>
                    <div class="mt-2">
                      <input type="text" required value="Ahmad" name="ab_lastname" id="ab_lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Straße</label>
                    <div class="mt-2">
                      <input type="text" required value="Strausberger Platz" name="ab_street" id="ab_abholung_street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Straßennummer</label>
                    <div class="mt-2">
                      <input type="text" required name="ab_street_number" value="13" id="ab_abholung_street_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Postleitzahl</label>
                    <div class="mt-2">
                      <input type="text" required name="ab_zipcode" value="10243" id="ab_abholung_zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="email" class="block text-sm text-left font-medium leading-6 text-gray-900">Stadt</label>
                    <div class="mt-2">
                      <input type="text" required name="ab_city" value="Berlin" id="ab_abholung_city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="location" class="block text-sm text-left font-medium leading-6 text-gray-900">Land</label>
                    <select id="ab_abholung_country" required name="ab_country" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      @foreach ($countries as $abholung_country)
                      @if ($abholung_country->name == "Deutschland")
                        <option selected value="{{$abholung_country->name}}">{{$abholung_country->name}}</option>
                        @else
                        <option value="{{$abholung_country->name}}">{{$abholung_country->name}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="mt-2">
                      <label for="email" class="block text-left text-sm font-medium leading-6 text-gray-900">Geb. Datum</label>
                      <div class="mt-2">
                        <input type="date" required name="ab_geb" id="ab_geb" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" >
                      </div>
                      <p class="text-xs text-red-600 hidden text-left" id="ab_geb_req">Geburstag fehlt</p>

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
    <input type="hidden" name="process_id" value="{{$order->process_id}}">
    </form>
