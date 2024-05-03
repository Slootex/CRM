
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>   




    <div class="mt-16 m-auto" style="width: 75rem;">
            <div style="margin-left: 72rem; margin-top: 44rem;" class="absolute pt-3 text-blue-700 ">
                  
            </div>
            @CSRF
            <div class="bg-white px-4 -md border border-gray-300  sm:rounded-md h-auto" id="rechnungsadresse" style="height: 48rem;">
            
              <div class="float-left pt-2">
                <h2 class="text-black pt-3 pl-3 text-xl font-semibold">Rechnungsadresse</h2>
              </div>

              <script>
                function loadKundenDaten(id) {
                  $.post( "{{url("/")}}/crm/neuer-auftrag/auftragsuche", {
          kunden_id: id,
          '_token': $('meta[name=csrf-token]').attr('content'),
          } , function( data ) {
          console.log(data);
            if(data == "empty") {
              document.getElementById("kunde-error").classList.toggle("hidden");
            } else {
              document.getElementById("home_companyname").value = data["company_name"];
              document.getElementById("home_gender").value = data["gender"];
              document.getElementById("firstname").value = data["firstname"];
              document.getElementById("lastname").value = data["lastname"];
              document.getElementById("home_street").value = data["home_street"];
              document.getElementById("home_street_number").value = data["home_street_number"];
              document.getElementById("home_zipcode").value = data["home_zipcode"];
              document.getElementById("home_city").value = data["home_city"];
              document.getElementById("home_country").value = data["home_country"];
              document.getElementById("home_email").value = data["email"];
              document.getElementById("mobil_number").value = data["mobile_number"];
              document.getElementById("phone_number").value = data["phone_number"];

              document.getElementById("send_back_company_name").value = data["company_name"];
              document.getElementById("send_back_salutation").value = data["send_back_gender"];
              document.getElementById("send_back_firstname").value = data["send_back_firstname"];
              document.getElementById("send_back_lastname").value = data["send_back_lastname"];
              document.getElementById("send_back_street").value = data["send_back_street"];
              document.getElementById("send_back_street_number").value = data["send_back_street_number"];
              document.getElementById("send_back_zipcode").value = data["send_back_zipcode"];
              document.getElementById("send_back_city").value = data["send_back_city"];
              document.getElementById("send_back_country").value = data["send_back_country"];

            }
        });
                }
              </script>
              
              <div class="pl-12 pt-2 pl-16 float-left" style="width: 60rem;">
                <div class="float-left">
                  <div>
                    <div class="mt-2 flex rounded-md -sm">
                      <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 text-gray-500 sm:text-sm">K - </span>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); loadKundenDaten(this.value) }" type="text" @isset($k) @else value="{{$kunden_id}}" @endisset name="kunden_id" id="kunden_id" class="block h-11 w-60 min-w-0 flex-1 rounded-none rounded-r-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6" placeholder="Kundennummer">
                    </div>
                  </div>
                </div>
                <div class="float-left pl-6 pt-2">
                  <div>
                    <button type="button" onclick="loadKundenDaten(document.getElementById('kunden_id').value)" class="bg-blue-600 hover:bg-blue-500 px-4 font-semibold text-lg py-2 text-white rounded-md ">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2 float-left">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                      </svg>
                      Kundendaten laden                      
                    </button>
                  </div>
                </div>
                <div class="pt-20">
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Firma</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="name" id="home_companyname" class="block w-full bg-white h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
                <div class="pt-4">
                  <div class="float-left">
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Anrede</label>
                    <select id="home_gender" name="gender" class=" block w-24 w-11 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                      <option value="Herr">Herr</option>
                      <option value="Frau">Frau</option>
                    </select>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Vorname</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="firstname" id="firstname" class="block w-96 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Name</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="lastname" id="lastname" class="block w-96 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                </div>
                <div class="float-left pt-4">
                  <div class="float-left pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straße</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" placeholder="Geben Sie eine Adresse ein" style="width: 37rem;" name="home_street" id="home_street" class="block  h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straßennummer</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="home_street_number" id="home_street_number" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                </div>
                <div class="float-left pt-4">
                  <div class="float-left pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Postleitzahl</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="home_zipcode" id="home_zipcode" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Stadt</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="home_city" id="home_city" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4">
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Land</label>
                    <select id="home_country" name="home_country" class=" block w-24 w-72 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                      <option value="" class="font-bold">Häufigste Länder</option>
                      @php
                      $mostUsedCountries = array("Großbritannien", 
                              "Italien", "Litauen", 
                              "Luxemburg", "Niederlande", 
                              "Österreich", "Polen", 
                              "Schweden", "Schweiz", 
                              "Spanien", "Ungarn");
                  @endphp
                      @foreach ($countries->sortBy('name') as $country)
                        @if (in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endif
                      @endforeach
                      <option value="" class="font-bold">Andere Länder</option>
                      @foreach ($countries->sortBy('name') as $country)
                        @if (!in_array($country->name, $mostUsedCountries))
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="float-left pt-4">
                  <div class="float-left pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">E-Mail</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="email" id="home_email" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Mobil</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="mobil_number" id="mobil_number" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div class="float-left pl-4 pt-6">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Festnetz</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="phone_number" id="phone_number" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                  <div style="padding-top: 6.5rem;">
                    <div class="relative">
                      <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Faxnumer</label>
                      <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="home_fax" id="home_fax" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                    </div>
                  </div>
                </div>
                <div>
                  <div class="w-full float-right">
                    <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Versand</label>
                    <fieldset class="ml-6 float-left w-96 pt-6">
                      <div class="space-y-4">
                        <div class="pr-4">
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="email" name="shipping_type" value="Standard" type="radio" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                          <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Standard</label>
                        </div>
                  
                        <div>
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="sms" name="shipping_type" value="Express" type="radio" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                          <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Express</label>
                        </div>
                  
                        <div class="">
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="push" name="shipping_type" value="International" type="radio" class="h-5 w-5 mt-1 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                          <label for="push" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left">International</label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="w-full h-16 pr-16">
                    <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Zahlart</label>
                    <fieldset class="ml-8 float-left w-96 pt-6">
                      <div class="space-y-4">
                        <div class="pr-4">
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="email" name="payment_type" value="Nachnahme" type="radio" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                          <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Nachnahme</label>
                        </div>
                  
                        <div>
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="sms" name="payment_type" value="Überweisung" type="radio" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                          <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Überweisung</label>
                        </div>
                  
                        <div class="">
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="push" name="payment_type" value="Bar" type="radio" class="h-5 w-5 mt-1 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                          <label for="push" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left">Bar</label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="relative w-96 h-16 float-left mt-8">
                    <button type="button" onclick="document.getElementById('alt_adr').classList.toggle('hidden'); this.classList.toggle('bg-blue-600 hover:bg-blue-500'); this.classList.toggle('bg-green-600')" class="bg-blue-600 hover:bg-blue-500 px-4 font-semibold text-lg py-2 text-white rounded-md ">
                      abweichende Lieferanschrift              
                    </button>
                  </div>
                </div>
              </div>
              





                    <script>

                      google.maps.event.addDomListener(window, 'load', initialize);
                    
                        function initialize() {
                    
                          var input = document.getElementById('home_street');
                          var input2 = document.getElementById('send_back_street');
                    
                          var autocomplete = new google.maps.places.Autocomplete(input);
                          var autocomplete2 = new google.maps.places.Autocomplete(input2);

                          autocomplete2.addListener('place_changed', function () {
                    
                            var place = autocomplete2.getPlace();
                            
                            let types = [];
                            let names = [];
                              
                            place2.address_components.forEach(comp => {
                                types.push(comp.types[0]);
                                names.push(comp["long_name"]);
                            });
                            console.log(types);
                            console.log(names);
                            let counter = 0
                            document.getElementById("send_back_street").value = "";
                            document.getElementById("send_back_street_number").value = "";
                            document.getElementById("send_back_city").value = "";
                            document.getElementById("send_back_zipcode").value = "";
                            document.getElementById("send_back_country").value = "";
                            console.log(types);
                            types.forEach(type => {
                              let name = names[counter];
                              if(type == "route") {
                                let street    = name;
                                document.getElementById("send_back_street").value = street;
                              }
                              if(type == "street_number") {
                                let number    = name;
                                document.getElementById("send_back_street_number").value = number;
                              }
                              if(type == "postal_town") {
                                let city    = name;
                                document.getElementById("send_back_city").value = city;
                              }
                              if(type == "locality") {
                                let city    = name;
                                document.getElementById("send_back_city").value = city;
                              }
                              if(type == "postal_code") {
                                let zipcode    = name;
                                document.getElementById("send_back_zipcode").value = zipcode;
                              }
                              if(type == "country") {
                                let country    = name;
                                document.getElementById("send_back_country").value = country;
                              }
                              counter++;
                            });
  
  
  
                      
                            // place variable will have all the information you are looking for.
                      
                            $('#lat').val(place.geometry['location'].lat());
                      
                            $('#long').val(place.geometry['location'].lng());
                      
                        });


                          autocomplete.addListener('place_changed', function () {
                    
                          var place = autocomplete.getPlace();
                            
                          let types = [];
                          let names = [];
                            
                          place.address_components.forEach(comp => {
                              types.push(comp.types[0]);
                              names.push(comp["long_name"]);
                          });
                          console.log(types);
                          console.log(names);
                          let counter = 0
                          document.getElementById("home_street").value = "";
                          document.getElementById("home_street_number").value = "";
                          document.getElementById("home_city").value = "";
                          document.getElementById("home_zipcode").value = "";
                          document.getElementById("home_country").value = "";

                          types.forEach(type => {
                            let name = names[counter];
                            if(type == "route") {
                              let street    = name;
                              document.getElementById("home_street").value = street;
                            }
                            if(type == "street_number") {
                              let number    = name;
                              document.getElementById("home_street_number").value = number;
                            }
                            if(type == "postal_town") {
                              let city    = name;
                              document.getElementById("home_city").value = city;
                            }
                            if(type == "locality") {
                              let city    = name;
                              document.getElementById("home_city").value = city;
                            }
                            if(type == "postal_code") {
                              let zipcode    = name;
                              document.getElementById("home_zipcode").value = zipcode;
                            }
                            if(type == "country") {
                              let country    = name;
                              document.getElementById("home_country").value = country;
                            }
                            counter++;
                          });



                    
                          // place variable will have all the information you are looking for.
                    
                          $('#lat').val(place.geometry['location'].lat());
                    
                          $('#long').val(place.geometry['location'].lng());
                    
                        });
                    
                      }
                    
                    </script>

                   
                     
          
                   
                  </div>

                  <div class="bg-white px-4 -md border border-gray-300  sm:rounded-md h-auto hidden" id="alt_adr" style="height: 25rem;">
            
                    <div class="float-left pt-2">
                      <h2 class="text-black pt-3 pl-3 text-xl font-semibold">Alternative Adresse</h2>
                    </div>
                    
                    <div class="pl-12 pt-2 pl-16 float-left" style="width: 60rem;">
                      
                      
                      <div class="pt-20">
                        <div class="relative">
                          <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Firma</label>
                          <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_company_name" id="send_back_company_name" class="block w-full bg-white h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                        </div>
                      </div>
                      <div class="pt-4">
                        <div class="float-left">
                          <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Anrede</label>
                          <select id="send_back_salutation" name="send_back_salutation" class=" block w-24 w-11 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                            <option>Herr</option>
                          </select>
                        </div>
                        <div class="float-left pl-4 pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Vorname</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_firstname" id="send_back_firstname" class="block w-96 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                        <div class="float-left pl-4 pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Name</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_lastname" id="send_back_lastname" class="block w-96 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                      </div>
                      <div class="float-left pt-4">
                        <div class="float-left pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straße</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" style="width: 37rem;" placeholder="Geben Sie eine Adresse ein" name="send_back_street" id="send_back_street" class="block  h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                        <div class="float-left pl-4 pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Straßennummer</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_street_number" id="send_back_street_number" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                      </div>
                      <div class="float-left pt-4">
                        <div class="float-left pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Postleitzahl</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_zipcode" id="send_back_zipcode" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                        <div class="float-left pl-4 pt-6">
                          <div class="relative">
                            <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Stadt</label>
                            <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="send_back_city" id="send_back_city" class="block w-72 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                          </div>
                        </div>
                        <div class="float-left pl-4">
                          <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Land</label>
                          <select id="send_back_country" name="send_back_country" class=" block w-24 w-72 rounded-md border-0 py-2 pb-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                            <option value="" class="font-bold">Häufigste Länder</option>
                            @php
                            $mostUsedCountries = array("Großbritannien", 
                                    "Italien", "Litauen", 
                                    "Luxemburg", "Niederlande", 
                                    "Österreich", "Polen", 
                                    "Schweden", "Schweiz", 
                                    "Spanien", "Ungarn", "Deutschland");
                        @endphp
                            @foreach ($countries->sortBy('name') as $country)
                              @if (in_array($country->name, $mostUsedCountries))
                                  <option value="{{$country->name}}">{{$country->name}}</option>
                              @endif
                            @endforeach
                            <option value="" class="font-bold">Andere Länder</option>
                            @foreach ($countries->sortBy('name') as $country)
                              @if (!in_array($country->name, $mostUsedCountries))
                                  <option value="{{$country->name}}">{{$country->name}}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div>
                        
                      
                      </div>
                    </div>
                    
      
      
      
      
      
                          <script>
      
                            google.maps.event.addDomListener(window, 'load', initialize);
                          
                              function initialize() {
                          
                                var input = document.getElementById('home_street');
                                var input2 = document.getElementById('send_back_street');
                          
                                var autocomplete = new google.maps.places.Autocomplete(input);
                                var autocomplete2 = new google.maps.places.Autocomplete(input2);
      
                                autocomplete2.addListener('place_changed', function () {
                          
                                var place = autocomplete2.getPlace();      
      
      
                                let types = [];
                                let names = [];
                                  
                                place.address_components.forEach(comp => {
                                    types.push(comp.types[0]);
                                    names.push(comp["long_name"]);
                                });
                                console.log(types);
                                console.log(names);
                                let counter = 0
                                document.getElementById("send_back_street").value = "";
                                document.getElementById("send_back_street_number").value = "";
                                document.getElementById("send_back_city").value = "";
                                document.getElementById("send_back_zipcode").value = "";
                                document.getElementById("send_back_country").value = "";
      
                                types.forEach(type => {
                                  let name = names[counter];
                                  if(type == "route") {
                                    let street    = name;
                                    document.getElementById("send_back_street").value = street;
                                  }
                                  if(type == "street_number") {
                                    let number    = name;
                                    document.getElementById("send_back_street_number").value = number;
                                  }
                                  if(type == "postal_town") {
                                    let city    = name;
                                    document.getElementById("send_back_city").value = city;
                                  }
                                  if(type == "locality") {
                                    let city    = name;
                                    document.getElementById("send_back_city").value = city;
                                  }
                                  if(type == "postal_code") {
                                    let zipcode    = name;
                                    document.getElementById("send_back_zipcode").value = zipcode;
                                  }
                                  if(type == "country") {
                                    let country    = name;
                                    document.getElementById("send_back_country").value = country;
                                  }
                                  counter++;
                                });
      
      
      
                          
                                // place variable will have all the information you are looking for.
                          
                                $('#lat').val(place.geometry['location'].lat());
                          
                                $('#long').val(place.geometry['location'].lng());
                              });
      
      
                                autocomplete.addListener('place_changed', function () {
                          
                                var place = autocomplete.getPlace();
                                  
                                let types = [];
                                let names = [];
                                  
                                place.address_components.forEach(comp => {
                                    types.push(comp.types[0]);
                                    names.push(comp["long_name"]);
                                });
                                console.log(types);
                                console.log(names);
                                let counter = 0
                                document.getElementById("home_street").value = "";
                                document.getElementById("home_street_number").value = "";
                                document.getElementById("home_city").value = "";
                                document.getElementById("home_zipcode").value = "";
                                document.getElementById("home_country").value = "";
      
                                types.forEach(type => {
                                  let name = names[counter];
                                  if(type == "route") {
                                    let street    = name;
                                    document.getElementById("home_street").value = street;
                                  }
                                  if(type == "street_number") {
                                    let number    = name;
                                    document.getElementById("home_street_number").value = number;
                                  }
                                  if(type == "postal_town") {
                                    let city    = name;
                                    document.getElementById("home_city").value = city;
                                  }
                                  if(type == "locality") {
                                    let city    = name;
                                    document.getElementById("home_city").value = city;
                                  }
                                  if(type == "postal_code") {
                                    let zipcode    = name;
                                    document.getElementById("home_zipcode").value = zipcode;
                                  }
                                  if(type == "country") {
                                    let country    = name;
                                    document.getElementById("home_country").value = country;
                                  }
                                  counter++;
                                });
      
      
      
                          
                                // place variable will have all the information you are looking for.
                          
                                $('#lat').val(place.geometry['location'].lat());
                          
                                $('#long').val(place.geometry['location'].lng());
                          
                              });
                          
                            }
                          
                          </script>
      
                         
                           
                
                         
                        </div>


               
          
            <div class="bg-white px-4 -md border border-gray-300   sm:rounded-md m-auto mt-8" id="fahrzeugdaten" style="height: 30.5rem; width: 75rem;">
              <div style="margin-left: 71rem; " class="absolute pt-3 text-blue-700">
                      
              </div>
              <div style="margin-left: 71rem; margin-top: 27rem;" class="absolute pt-3 text-blue-700">
                     
              </div>
              <script>$(document).ready(function () {
                $(function () {
                  const availableTags = [
                    "Alfa-Romeo",
            "Audi",
            "Bentley",
            "BMW",
            "Cadillac",
            "Can-Am",
            "Chevrolet",
            "Chrysler",
            "Citroen",
            "Dacia",
            "DAF",
            "Daihatsu",
            "Dodge",
            "Ducati",
            "Ferrari",
            "Fiat",
            "Ford",
            "Ford USAs",
            "Honda",
            "Hyundai",
            "Lveco",
            "Jaguar",
            "Jeep",
            "Kia",
            "Lancia",
            "Land Rover",
            "LDV",
            "Lexus",
            "Licoln",
            "Maserati",
            "Mazda",
            "Mercedes-Benz",
            "MG",
            "Microcar",
            "Mini",
            "Mitsubishi",
            "Moto-Guzzi",
            "New-Holland",
            "Nissan",
            "Opel",
            "Peugeot",
            "Porsche",
            "Renault",
            "Rover",
            "Saab",
            "Scania",
            "Seat",
            "Skoda",
            "Smart",
            "Ssangyong",
            "Subaru",
            "Suzuki",
            "Toyota",
            "Valtra",
            "Volvo",
            "VW",
            "Wiesmann",
            
                  ];
                  $('#tags').autocomplete({
                    source: availableTags,
                    select: function( event, ui ) {
                      document.getElementById('box-car').innerHTML = ui["item"]["label"];
                    }
                  });
                });
              });
            

</script>
              <div class="absolute pt-3 overflow-auto break-words " style="max-width: 14rem;">
                <h2 class="text-black pt-3 pl-3 text-xl font-semibold">Fahrzeugdaten</h2>
                <div class="px-3 py-3 border-2 border-blue-700 rounded-lg mt-2 hidden ml-3" id="box">
                  <h3 class="font-medium"><span id="box-car"></span> <span id="box-model"></span></h3>
                  <p class="text-gray-500"><span id="box-km"></span></p>
                  <p class="text-gray-500"><span id="box-year"></span></p>
                  <p class="text-gray-500"><span id="box-ps"></span></p>
                  <p class="text-gray-500"><span id="box-fin"></span></p>
                  <p class="text-gray-500"><span id="box-fuel">Benzin</span> / <span id="box-getr">Schaltung</span></p>
                  <p class="text-gray-500"><span id="box-zul"></span></p>
                </div>
              </div>
              <div class="ml-60 pl-.5 pt-7">
                <div class="grid grid-cols-6 gap-8">
                  
                    <div class="w-40">
                      <label for="email" class="block text-md font-medium leading-6 text-gray-900">Schlüsselnummer</label>
                      <div class="mt-2">
                        <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); searchNumber() }" name="hsn" id="hsn" class="block h-11 w-40 rounded-md border-0 rounded-tr-none rounded-br-none border-r-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6" placeholder="HSN">
                      </div>
                    </div>
                    <div class="w-40">
                      <div class="mt-8">
                        <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); searchNumber() }" name="tsn" id="tsn" class="h-11 block w-40 rounded-md border-0 rounded-tl-none rounded-bl-none border-l-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6" placeholder="TSN">
                      </div>
                    </div>
                    <div class="mt-8 ml-8">
                      <button type="button" onclick="searchNumber()" class="bg-blue-600 hover:bg-blue-500 px-4 font-semibold text-lg py-1 h-11 text-white rounded-md w-72">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2 float-left">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        Fahrzeugdaten suchen                      
                      </button>
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-8 mt-8">
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Automarke</label>
                    <input type="text" onkeypress="if(event.keyCode == 13) { event.preventDefault(); }" name="car_company" oninput="document.getElementById('box').classList.remove('hidden'); document.getElementById('box-car').innerHTML = this.value" id="tags" class="block w-80 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative ml-44">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Automodell</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="car_model" id="car-model" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-model').innerHTML = this.value" style="width: 34.2rem;" class="block h-11 rounded-md border-0 py-1.5 ml-4  text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
                <div class="grid grid-cols-3 gap-2 mt-8">
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">Kilometerstand</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="mileage" id="kilo" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-km').innerHTML = this.value + ' KM'" class="block w-80 h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative ml-6">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Baujar</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="production_year" id="home_city" style="width: 16rem;" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-year').innerHTML = this.value + ' Baujahr'" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Fahrleistung (PS)</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="car_power" id="ps" style="width: 16rem;" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-ps').innerHTML = this.value + ' PS'" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
                <div>
                  <div class="relative mt-8">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium text-gray-900">FIN / VIN</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="car_identification_number" id="home_city" style="width: 56rem;" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-fin').innerHTML =  'FIN ' +this.value "  class="block  h-11 rounded-md border-0 py-1.5 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
                <div class="w-full h-16 pr-16">
                  <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Getriebe</label>
                  <fieldset class="ml-8 float-left w-96 pt-6">
                    <div class="space-y-4">
                      <div class="pr-4">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="email" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-getr').innerHTML = 'Schaltung'" name="transmission" value="Schaltung" type="radio" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Schaltung</label>
                      </div>
                
                      <div>
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="sms" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-getr').innerHTML = 'Automatik'" name="transmission" value="Automatik" type="radio" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                        <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Automatik</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div class="w-full h-16 pr-16">
                  <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Kraftstoffart</label>
                  <fieldset class="ml-0 float-left w-96 pt-6">
                    <div class="space-y-4">
                      <div class="pr-4">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="benzin" name="fuel_type" oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-fuel').innerHTML = 'Benzin'" value="Benzin" type="radio" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Benzin</label>
                      </div>
                
                      <div>
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="diesel" name="fuel_type"  oninput="document.getElementById('box').classList.remove('hidden');document.getElementById('box-fuel').innerHTML = 'Diesel'" value="Diesel" type="radio" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                        <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Diesel</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>

            </div>

            <div class="bg-white px-4 -md border border-gray-300   sm:rounded-md m-auto mt-8" style="height: 17.5rem; width: 75rem;" id="gerätedaten">
              <div style="margin-left: 71rem; " class="absolute pt-3 text-blue-700">
                     
              </div>
              <div class="absolute pt-2">
                <h2 class="text-black pt-3 pl-3 text-xl font-semibold">1. Gerät</h2>
              </div>
              
              <div class="ml-60 pl-.5 pt-7">
                <div class="grid grid-cols-3 gap-2">
                  <div>
                    <label for="location" class="block text-md font-medium leading-6 text-gray-900">Bauteil</label>
                    <select id="location" name="broken_component" class="mt-2 block w-80 h-11 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
                      <option value="1" selected>Unbekanntes-Steuergerät</option>
                      @foreach ($components->sortBy("name") as $comp)
                          @if ($comp->id != 1)
                          <option value="{{$comp->id}}">{{$comp->name}}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="relative ml-6 mt-8">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Hersteller</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="device_manufacturer" id="home_city" style="width: 16rem;" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                  <div class="relative mt-8">
                    <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Teile./Herstellernummer</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="device_partnumber" id="home_city" style="width: 16rem;" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
                <div class="w-full h-16 pr-16">
                  <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Wurde das Steuergerät geöffnet?</label>
                  <fieldset class="ml-0 float-left w-96 pt-6">
                    <div class="space-y-4 float-right w-60">
                      <div class="pr-2 mt-4 float-right">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="email" name="opend" type="radio" value="yes" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Nein</label>
                      </div>
                
                      <div class="float-right">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="sms" name="opend" type="radio" value="no" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                        <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Ja</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div class="w-full h-16 pr-16">
                  <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Stammt das Gerät aus einem anderen Fahrzeug</label>
                  <fieldset class="ml-0 float-left w-96 pt-6">
                    <div class="space-y-4 float-left w-60 pl-1 ml-20">
                      <div class="pr-4 float-left mt-4 ">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="email" name="from_car" type="radio" value="yes" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-4">Ja</label>
                      </div>
                
                      <div class="pr-4 float-left">
                        <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"id="sms" name="from_car" type="radio" value="no" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
                        <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Nein</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              @php
                  $randomid = random_int(1000,100000);
                  
              @endphp
              <div class="float-right pr-2 pt-2 pb-2" id="add-device-button-{{$randomid}}">
                  <button type="button" onclick="lastRandId = '{{$randomid}}'; addDeviceData()" class="float-right text-blue-600 hover:text-blue-400">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>          
                  </button>
              </div>
            </div>            <div id="new-devicedata-div">

            </div>

            <script>
              let lastRandId = "{{$randomid}}";
              let beforeRandId = "";
              let beforeboreRandId = "";
              let deviceCount = 1;
              function addDeviceData() {
                loadData();
                $.get("{{url("/")}}/crm/new-order/new-devicedata", function(data) {
                    console.log(beforeRandId);
                    if(document.getElementById("add-device-button-"+lastRandId)) {
                      document.getElementById("add-device-button-"+lastRandId).classList.add("hidden");
                      
                    }
                    if(document.getElementById("add-device-button-"+beforeRandId)) {
                      document.getElementById("add-device-button-"+beforeRandId).classList.add("hidden");
                    }

                    if(document.getElementById("delete-device-button-"+lastRandId)) {
                      document.getElementById("delete-device-button-"+lastRandId).classList.add("hidden");

                    }
                    beforeboreRandId = beforeRandId;
                    beforeRandId = lastRandId;
                  $("#new-devicedata-div").append(data);
                  
                        if(document.getElementById("delete-device-button-"+lastRandId)) {
                          document.getElementById("delete-device-button-"+lastRandId).setAttribute("onclick", "deleteDeviceData('"+lastRandId+"', '"+beforeRandId+"')");

                        }

                      
                  deviceCount++;
                  if(document.getElementById("device-count-"+lastRandId)) {
                    document.getElementById("device-count-"+lastRandId).innerHTML = deviceCount + ". Gerät";
                  }
                  
                  savedPOST();
                });
                console.log(beforeRandId);
              }

              function deleteDeviceData(id, last) {
                console.log(beforeRandId)
                document.getElementById('add-device-button-'+last).classList.remove('hidden');
                document.getElementById('devicedata-'+id).remove()
                deviceCount--;
                if(document.getElementById("delete-device-button-"+last)) {
                      document.getElementById("delete-device-button-"+last).classList.remove("hidden");

                    }
              }
            </script>
      
            <div class="bg-white px-4 -md border border-gray-300  sm:rounded-md m-auto mt-8 h-auto py-4" style=" width: 75rem;" id="fehlerbeschreibung">
              <div style="margin-left: 71rem; " class="absolute pt-0 text-blue-700">
                      
              </div>
              <div class="absolute pt-0">
                <h2 class="text-black pt-0 pl-3 text-xl font-semibold">Fehlerbeschreibung</h2>
              </div>

              <div class="ml-60 pl-.5 pt-0">
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label for="comment" class="block text-md font-medium leading-6 text-gray-900">Fehlerursache</label>
                    <div class="mt-2">
                      <textarea rows="4" name="error_message" id="comment" class="block h-36 w-96 rounded-md border-0 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:py-1.5 sm:text-md sm:leading-6"></textarea>
                    </div>
                  </div>
                  <div class="ml-0">
                    <label for="comment" class="block text-md font-medium leading-6 text-gray-900">Fehlerspeicher</label>
                    <div class="mt-2">
                      <textarea rows="4" name="error_message_cache" id="comment" class="block h-36 w-96 rounded-md border-0 text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:py-1.5 sm:text-md sm:leading-6"></textarea>
                    </div>
                  </div>
                </div>
                <div class="grid grid-cols-6 gap-2 mt-6">
                  <div class="col-span-2 float-left flex text-gray-600 text-lg  mt-8">
                   <div class="border border-gray-400 flex px-2 pt-2 rounded-lg cursor-pointer hover:text-blue-400" onclick="document.getElementById('dokumente-input').click()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                    </svg>
                    <p class="ml-2">Dokumente <span id="dokumente-count"></span></p>              
                   </div>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"oninput="setDokumenteFileNames()" type="file" name="filee[]" class="hidden" multiple id="dokumente-input">
                    <svg onclick="deleteDocuments()" id="dokumente-delete-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden mt-1.5 ml-2 w-8 h-8 text-red-600 hover:text-red-400 cursor-pointer">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>                    
                  </div>
                  <script>
                      function setDokumenteFileNames() {
                          let fileCount = document.getElementById("dokumente-input").files.length;
                          document.getElementById("dokumente-count").innerHTML = " | " + fileCount + " Datein";
                          document.getElementById("dokumente-delete-svg").classList.remove("hidden");
                      }

                      function deleteDocuments() {
                        document.getElementById("dokumente-input").value = null;
                        document.getElementById("dokumente-count").innerHTML = "";
                        document.getElementById("dokumente-delete-svg").classList.add("hidden");
                      }
                  </script>
                 
                  <div class="relative ml-32 pl-3 mt-8">
                    <label for="name" class="absolute -top-2 pl-3 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Zusatzkommentar</label>
                    <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="text" name="name" id="home_city" class="block ml-4 w-96 h-11 rounded-md border-0 py-1.5   text-gray-900 -sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
                  </div>
                </div>
              </div>

              <div class="float-right mt-4 py-6">
                <div class="relative inline-block text-left float-right ml-1">
                  <div class="float-right">
                    <button onclick="toggleCreateDropDown()" type="button" class="inline-flex h-14 w-full justify-center bg-blue-600 hover:bg-blue-500 text-white rounded-md px-3 py-2 rounded-tl-none rounded-bl-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 mt-1 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                      </svg>                      
                    </button>
                  </div>
                
                  <!--
                    Dropdown menu, show/hide based on menu state.
                
                    Entering: "transition ease-out duration-100"
                      From: "transform opacity-0 scale-95"
                      To: "transform opacity-100 scale-100"
                    Leaving: "transition ease-in duration-75"
                      From: "transform opacity-100 scale-100"
                      To: "transform opacity-0 scale-95"
                  -->
                  <div id="createDropDown" class="hidden absolute right-0 z-10 mt-16 w-56 origin-top-right rounded-md bg-white -lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                      <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                      <a href="#createText" onclick="setCreateText('email')" class="text-gray-700 block px-4 py-2 text-sm hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left text-gray-500 mr-2">
                          <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                          <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                        
                        PDF per E-Mail                      
                      </a>
                      <a href="#createText" onclick="setCreateText('fax')" class="text-gray-700 block px-4 py-2 text-sm hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left text-gray-500 mr-2">
                          <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 003 3h.27l-.155 1.705A1.875 1.875 0 007.232 22.5h9.536a1.875 1.875 0 001.867-2.045l-.155-1.705h.27a3 3 0 003-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0018 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM16.5 6.205v-2.83A.375.375 0 0016.125 3h-8.25a.375.375 0 00-.375.375v2.83a49.353 49.353 0 019 0zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 01-.374.409H7.232a.375.375 0 01-.374-.409l.526-5.784a.373.373 0 01.333-.337 41.741 41.741 0 018.566 0zm.967-3.97a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H18a.75.75 0 01-.75-.75V10.5zM15 9.75a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V10.5a.75.75 0 00-.75-.75H15z" clip-rule="evenodd" />
                        </svg>
                        PDF per Fax                        
                      </a>
                      <a href="#createText" onclick="setCreateText('none')" class="text-gray-700 block px-4 py-2 text-sm  hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 float-left text-gray-500 mr-2">
                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                        </svg>
                        ohne PDF abschließen  
                       </a>
                    </div>
                  </div>
                </div>
                <input onkeypress="if(event.keyCode == 13) { event.preventDefault(); }"type="hidden" name="email_type" id="emailtype" value="email">
                <button type="submit" class="hidden" id="submit-button"></button>
                <button type="button" onclick="checkBeforeSubmit()" class="bg-blue-600 hover:bg-blue-500 text-white rounded-md px-6 py-1 rounded-tr-none rounded-br-none float-right">
                  <p class="font-semibold">Auftrag erstellen & an Packtisch senden</p>
                  <p id="createText">(PDF per E-Mail)</p>
                </button>
                
              
              
                
              </div>
              <br>
              <br>
              <br>
              <br>
            </div>
  
    </div>
    
            </div>
          
    </div>
    <div id="duplikate-div">

    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      let oldDuplikat = "";
      function changeDuplikat(id) {
      
        if(document.getElementById("duplikat-div-"+oldDuplikat)) {
          document.getElementById("duplikat-div-"+oldDuplikat).classList.remove("bg-blue-100");
        }
      
        document.getElementById("duplikat-div-"+id).classList.add("bg-blue-100");
      
        oldDuplikat = id;
      }

      function setDuplikat() {

        loadData();
        $.get("{{url("/")}}/crm/get-order-row-"+oldDuplikat, function(data) {

          document.getElementById("home_companyname").value = data["company_name"];
          document.getElementById("home_gender").value = data["gender"];
          document.getElementById("firstname").value = data["firstname"];
          document.getElementById("lastname").value = data["lastname"];
          document.getElementById("home_street").value = data["home_street"];
          document.getElementById("home_street_number").value = data["home_street_number"];
          document.getElementById("home_zipcode").value = data["home_zipcode"];
          document.getElementById("home_city").value = data["home_city"];
          document.getElementById("home_country").value = data["home_country"];
          document.getElementById("home_email").value = data["email"];
          document.getElementById("mobil_number").value = data["mobile_number"];
          document.getElementById("phone_number").value = data["phone_number"];

          document.getElementById("send_back_company_name").value = data["company_name"];
          document.getElementById("send_back_salutation").value = data["send_back_gender"];
          document.getElementById("send_back_firstname").value = data["send_back_firstname"];
          document.getElementById("send_back_lastname").value = data["send_back_lastname"];
          document.getElementById("send_back_street").value = data["send_back_street"];
          document.getElementById("send_back_street_number").value = data["send_back_street_number"];
          document.getElementById("send_back_zipcode").value = data["send_back_zipcode"];
          document.getElementById("send_back_city").value = data["send_back_city"];
          document.getElementById("send_back_country").value = data["send_back_country"];

          document.getElementById("check-new-order").remove();

          savedPOST();
        });

      }

    
      
      var counter = 0
      function diff_street() {
        var elem        = document.getElementById("different_street_div");
        if(counter == 0) {
          different_street_div.classList.remove("hidden");
          counter = 1;
        } else {
          different_street_div.classList.add("hidden");
          counter = 0;
        }
      }
      
      function toggleCreateDropDown() {
          document.getElementById("createDropDown").classList.toggle("hidden");
      }

      function setCreateText(text) {
        if(text == "email") {
          document.getElementById("createText").innerHTML = "(PDF per E-Mail)";
          document.getElementById("emailtype").value = "email";
        }
        if(text == "fax") {
          document.getElementById("createText").innerHTML = "(PDF per Fax)";
          document.getElementById("emailtype").value = "fax";
        }
        if(text == "none") {
          document.getElementById("createText").innerHTML = "(Ohne PDF abschließen)";
          document.getElementById("emailtype").value = "none";
        }
      }

      function searchNumber() {
        hsn_v = document.getElementById("hsn").value;
        tsn_v = document.getElementById("tsn").value.toUpperCase();

        $.post( "{{url("/")}}/crm/neuer-auftrag/nummersuche", {
          hsn: hsn_v,
          tsn: tsn_v,
          '_token': $('meta[name=csrf-token]').attr('content'),
          } , function( data ) {          
          if(data != "empty") {
            document.getElementById('box').classList.remove('hidden');
            document.getElementById("tags").value = data["MF"].split(" ")[0];
            document.getElementById("box-car").innerHTML = document.getElementById("tags").value;
            document.getElementById("car-model").value = data["MF"].replace(data["MF"].split(" ")[0], "");
            document.getElementById("box-model").innerHTML = document.getElementById("car-model").value;
            document.getElementById("box-zul").innerHTML = data["zulassungen"] + " Zulassungen (DE)";
            document.getElementById("ps").value = data["leistung"].replace("PS", "");
            document.getElementById("box-ps").innerHTML = document.getElementById("ps").value + " PS";
            if(data["fuel"] == "Benzin") {
              document.getElementById("benzin").checked = true;
              document.getElementById("box-fuel").innerHTML = "Benzin";
            } else{
              document.getElementById("diesel").checked = true;
              document.getElementById("box-fuel").innerHTML = "Diesel";
            }
          } else {
            document.getElementById("number-error").classList.toggle("hidden");
          }
        });
      }
    </script>



<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="number-error">
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

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left -xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation-triangle -->
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
          </div>
         
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Kein Daten gefunden!</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Es konnten kein Fahrzeugdaten gefunden werden.</p>
                </div>
              </div>
         
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="document.getElementById('number-error').classList.toggle('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white -sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="kunde-error">
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

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left -xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation-triangle -->
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
          </div>
         
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Kein Daten gefunden!</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Es konnten kein Kundendaten zu der Kundennummer gefunden werden.</p>
                </div>
              </div>
         
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="document.getElementById('kunde-error').classList.toggle('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white -sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Zurück</button>
        </div>
      </div>
    </div>
  </div>
</div>

