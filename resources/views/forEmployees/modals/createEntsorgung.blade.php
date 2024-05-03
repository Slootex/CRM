
    <form action="{{url("/")}}/crm/entsorgung/beauftragen" method="POST">
      @CSRF
    <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 40%">
              <div class="float-right mr-4 mt-4">
                <button onclick="document.getElementById('create-entsorgung').classList.add('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
              <div class="" >
                <h1 class="col-start-1 col-span-1 font-bold text-xl">Empfängeradresse auswählen</h1>
                <div class="mt-4">
                  <label for="location" class="block text-md font-medium leading-6 text-gray-900">Addressbuch</label>
                  <select onchange="changeContact(this.value)" id="location" name="contact" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    @foreach ($contacts as $contact)
                        <option value="{{$contact->id}}">{{$contact->shortcut}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mt-4">
                  <label for="email" class="block text-md font-medium leading-6 text-gray-900">Firma</label>
                  <div class="">
                    <input type="text" name="companyname" id="companyname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="grid grid-cols-3 grid-rows-6 gap-x-10 gap-y-0">
                  <div class="mt-4">
                    <label for="location" class="block text-md font-medium leading-6 text-gray-900">Anrede</label>
                    <select id="location" name="gebder" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      <option value="Herr">Herr</option>
                      <option value="Frau">Frau</option>
                    </select>
                  </div>
                  <div class="mt-4">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Vorname</label>
                    <div class="">
                      <input type="text" name="firstname" id="firstname_send" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="mt-4">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Nachname</label>
                    <div class="">
                      <input type="text" required name="lastname" id="lastname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
    
                  <div class="col-span-2 mt-0.5">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Straße</label>
                    <div class="">
                      <input type="text" required name="street" id="street" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="mt-0.5">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Straßennummer</label>
                    <div class="">
                      <input type="text" required name="streetno" id="streetno" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
    
                  <div class="">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Postleitzahl</label>
                    <div class="">
                      <input type="text" required name="zipcode" id="zipcode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Stadt</label>
                    <div class="">
                      <input type="text" required name="city" id="city" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="">
                    <label for="location" class="block text-md font-medium leading-6 text-gray-900">Land</label>
                    <select id="country" required name="country" class=" block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      @foreach ($countries as $country)
                          <option value="{{$country->id}}">{{$country->name}}</option>
                          
                      @endforeach
                    </select>
                  </div>
    
                  <div class="">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Email</label>
                    <div class="">
                      <input type="text" name="email" id="email-e" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Mobil</label>
                    <div class="">
                      <input type="text" name="mobil" id="mobil" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
                  <div class="">
                    <label for="email" class="block text-md font-medium leading-6 text-gray-900">Festnetz</label>
                    <div class="">
                      <input type="text" name="phone" id="phone" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>
    
             
    
                <div class="mt-8">
                  <h1>Versand</h1>
                </div>
                <div class="col-span-2 mt-4">
                  <input type="hidden" name="shippingtype" id="shippingtype" value="Standard">
                  <button type="button" onclick="setShipping('Standard')">
                    <div id="Standard" class="float-left rounded-md border border-blue-600 px-4 py-2">
                    <h1>Standard</h1>
                    <p>5,95€</p>
                  </div>
                </button>
                  <button type="button" onclick="setShipping('Express')">
                    <div id="Express" class="float-left rounded-md border px-4 py-2 ml-4">
                    <h1>Express</h1>
                    <p>8,95€</p>
                  </div>
                </button>
                  <button type="button" onclick="setShipping('Samstag')">
                    <div id="Samstag" class="float-left bg-gray-100 rounded-md border px-4 py-2 ml-4">
                    <h1>Samstagszustellung</h1>
                    <p>Nur mit Express möglich</p>
                  </div>
                </button>
                </div>
    
                <div class="col-span-3 mt-4">           
    
                  <label for="email" class="block font-bold text-xl leading-6 text-gray-900">Zusatzkommentar Packtisch</label>
                  <div class="">
                    <input type="text" name="extcomment" id="email" class="block w-full h-12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
    
                
               
              </div>
             <div class="mt-4">
              <button type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 float-left">An Packtisch senden</button>
              <button type="button" onclick="document.getElementById('create-entsorgung').classList.add('hidden')" class="rounded-md bg-white border border-gray-600 text-black px-4 py-2 float-right">Abbrechen</button>

             </div>
    
            </div>
             
            </div>
          </div>
        </div>
      </div>
    </form>
<script>
        function changeContact(id) {

$.get( "{{url("/")}}/versand-versenden/get-contact/" + id, function( data ) {
  document.getElementById("firstname_send").value = data["firstname"];
  document.getElementById("lastname").value = data["lastname"];
  document.getElementById("companyname").value = data["companyname"];
  document.getElementById("street").value = data["street"];
  document.getElementById("streetno").value = data["streetno"];
  document.getElementById("zipcode").value = data["zipcode"];
  document.getElementById("city").value = data["city"];
  document.getElementById("email-e").value = data["email"];
  if(data["servicecode"] == "065") {
    document.getElementById("Standard").classList.remove("border-blue-600");
    document.getElementById("Express").classList.add("border-blue-600");
    document.getElementById("shippingtype").value = "Express";

  }
  if(data["servicecode"] == "011") {
    document.getElementById("Standard").classList.add("border-blue-600");
    document.getElementById("Express").classList.remove("border-blue-600");
    document.getElementById("shippingtype").value = "Standard";

  }
  document.getElementById("country").value = data["country"];
  document.getElementById("phone").value = data["phonenumber"];
  document.getElementById("mobil").value = data["mobilnumber"];
});
}


let oldshipping = "Standard";
      let shipcounter = 0;
      function setShipping(typ) {
        
        
        if(typ == "Samstag") {
          if(oldshipping == "Express") {
            if(shipcounter == 0) {
            document.getElementById("Samstag").classList.add("border-blue-600");

            document.getElementById("shippingtype").value = typ;
            shipcounter = 1;
          } else {
            document.getElementById("Samstag").classList.remove("border-blue-600");


            document.getElementById("shippingtype").value = oldshipping;
            shipcounter = 0;
          }
          }
        } else {
          document.getElementById("Standard").classList.remove("border-blue-600");
          document.getElementById("Express").classList.remove("border-blue-600");
          document.getElementById(typ).classList.add("border-blue-600");
          document.getElementById("shippingtype").value = typ;

          if(typ == "Standard") {
            document.getElementById("Samstag").classList.remove("border-blue-600");
            document.getElementById("Samstag").classList.add("bg-gray-100");
            shipcounter = 1;

          }
          if(typ == "Express") {
            document.getElementById("Samstag").classList.remove("bg-gray-100");

          }

          oldshipping = typ;
        }


        

      }
</script>
