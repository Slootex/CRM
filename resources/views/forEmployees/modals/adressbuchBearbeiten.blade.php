@isset($con)
<form action="{{url("/")}}/crm/contact/change/{{$con->id}}" id="contact-change-form" method="POST">
  @CSRF
  @else
  <form action="{{url("/")}}/crm/contact/new" id="contact-new-form" method="POST">
    @CSRF
@endisset  
  <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
      <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
        <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-8 sm:px-10" style=" width: 52rem">
          <div class="float-right mt-4">
            <button type="button" onclick="document.getElementById('contact-change-div').innerHTML = ''">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rounded-md bg-white text-gray-500 hover:text-gray-400 border border-gray-400 hover:border-gray-500  text-xl">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>         
          </div>
          <div>
            <h1 class="text-xl font-normal">@isset($con) Adresse ändern @else Neue Adresse @endisset</h1>
            <p class="text-sm text-gray-400">@isset($con) Kürzel, Adresse und Abholzeiten ändern bzw. löschen @else Kürzel, Adresse und Abholzeiten hinzufügen @endisset</p>
          </div>
          <div class="pt-8">
            <input type="text" required name="shortcut" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" placeholder="Kürzel" @isset($con) value="{{$con->shortcut}}" @endisset>
              <select name="language" id="" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2">
                @isset($con)
                @isset($con->language)
                <option value="{{$con->language}}">{{$con->language}}</option>
                @else
                <option value="">Sprache</option>

                @endisset
                @else
                @php
                $mostUsedCountries = array("Deutschland", "Polen", 
                      "Schweiz", "Österreich", 
                      "Luxemburg", "Niederlande", 
                      "Großbritannien", "Italien", 
                      "Schweden", "Litauen", 
                      "Spanien", "Ungarn");
                @endphp
                <option value="" class="font-bold">Meist genutzte Sprachen</option>
                @foreach ($countries->sortBy('name') as $country)
                  @if (in_array($country->name, $mostUsedCountries))
                    <option value="{{$country->name}}">{{$country->name}}</option>
                    @else
                  @endif
                @endforeach
                <option value="" class="font-bold">andere Sprachen</option>
                @foreach ($countries->sortBy('name') as $country)
                @if (!in_array($country->name, $mostUsedCountries))
                  <option value="{{$country->name}}">{{$country->name}}</option>
                  @else
                @endif
              @endforeach
                @endisset
                @isset($con)
                @php
                $mostUsedCountries = array("Deutschland", "Polen", 
                      "Schweiz", "Österreich", 
                      "Luxemburg", "Niederlande", 
                      "Großbritannien", "Italien", 
                      "Schweden", "Litauen", 
                      "Spanien", "Ungarn");
                @endphp
                <option value="" class="font-bold">Meist genutzte Sprachen</option>
                @foreach ($countries->sortBy('name') as $country)
                  @if (in_array($country->name, $mostUsedCountries))
                    @if ($country->name != $con->language)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                    @endif
                    @else
                  @endif
                @endforeach
                <option value="" class="font-bold">andere Sprachen</option>
                @foreach ($countries->sortBy('name') as $country)
                @if (!in_array($country->name, $mostUsedCountries))
                  @if ($country->name != $con->language)
                  <option value="{{$country->name}}">{{$country->name}}</option>
                  @endif
                  @else
                @endif
              @endforeach
                @endisset
              </select>
          </div>
          <div class="pt-2 pr-2">
            <input type="text" name="companyname" class="w-full h-9 bg-white border-gray-400 rounded-md" placeholder="Firma" @isset($con) value="{{$con->companyname}}" @endisset>
          </div>
          <div class="pt-2">
              <select name="gender" required id="" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1">
                @isset($con) 
                @if ($con->gender == "1")
                  <option value="1" selected>Herr</option>
                  <option value="2">Frau</option>
                @else
                  <option value="1">Herr</option>
                  <option value="2"selected>Frau</option>
                @endif

                @else
                  <option value="null">Anrede</option>
                  <option value="1">Herr</option>
                  <option value="2">Frau</option>
                @endisset
                
              </select>
              <input type="text" required name="firstname" id="" class="w-60 h-9 bg-white border-gray-400 rounded-md ml-2 pt-1" placeholder="Vorname" @isset($con) value="{{$con->firstname}}" @endisset>
              <input type="text" required name="lastname" id="" class="w-60 h-9 bg-white border-gray-400 rounded-md ml-2 pt-1" placeholder="Nachname" @isset($con) value="{{$con->lastname}}" @endisset>
            </div>
            <div class="pt-2">
              <input type="text" required id="street" name="street" style="width: 30.7rem;" class=" h-9 bg-white border-gray-400 rounded-md pt-1" placeholder="Straße" @isset($con) value="{{$con->street}}" @endisset>
              <input type="text" required id="streetno" name="streetno" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2" placeholder="Straßennummer" @isset($con) value="{{$con->streetno}}" @endisset>
            </div>
            <div class="pt-2">
              <input type="text" required id="zipcode" name="zipcode" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" placeholder="Postleitzahl" @isset($con) value="{{$con->zipcode}}" @endisset>
              <input type="text" required id="city" name="city" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2" placeholder="Stadt" @isset($con) value="{{$con->city}}" @endisset>
              <select name="country" required id="country" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2">
               
                @isset($con)
                <option value="{{$country->where("id", $con->country)->first()->id}}">{{$country->where("id", $con->country)->first()->name}}</option>
                @else
                @php
                $mostUsedCountries = array("Deutschland", "Polen", 
                      "Schweiz", "Österreich", 
                      "Luxemburg", "Niederlande", 
                      "Großbritannien", "Italien", 
                      "Schweden", "Litauen", 
                      "Spanien", "Ungarn");
                @endphp
                <option value="" class="font-bold">Meist genutzte Länder</option>
                @foreach ($countries->sortBy('name') as $country)
                  @if (in_array($country->name, $mostUsedCountries))
                    <option value="{{$country->name}}">{{$country->name}}</option>
                    @else
                  @endif
                @endforeach
                <option value="" class="font-bold">andere Länder</option>
                @foreach ($countries->sortBy('name') as $country)
                @if (!in_array($country->name, $mostUsedCountries))
                  <option value="{{$country->name}}">{{$country->name}}</option>
                  @else
                @endif
              @endforeach
                @endisset
                @isset($con)
               @php
                $mostUsedCountries = array("Deutschland", "Polen", 
                      "Schweiz", "Österreich", 
                      "Luxemburg", "Niederlande", 
                      "Großbritannien", "Italien", 
                      "Schweden", "Litauen", 
                      "Spanien", "Ungarn");
                @endphp
                <option value="" class="font-bold">Meist genutzte Länder</option>
                @foreach ($countries->sortBy('name') as $country)
                  @if (in_array($country->name, $mostUsedCountries))
                    @if ($country->name != $con->country)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                    @endif
                    @else
                  @endif
                @endforeach
                <option value="" class="font-bold">andere Länder</option>
                @foreach ($countries->sortBy('name') as $country)
                @if (!in_array($country->name, $mostUsedCountries))
                  @if ($country->name != $con->country)
                  <option value="{{$country->name}}">{{$country->name}}</option>
                  @endif
                  @else
                @endif
              @endforeach
              @endisset
              </select>                
            </div>
            <div class="pt-2">
              <input type="email" required name="email" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" placeholder="Email" @isset($con) value="{{$con->email}}" @endisset>
              <input type="text" name="mobilnumber" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2" placeholder="Mobil" @isset($con) value="{{$con->mobilnumber}}" @endisset>
              <input type="text" name="phonenumber" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2" placeholder="Festnetz" @isset($con) value="{{$con->phonenumber}}" @endisset>
            </div>
            <div class=" pt-6 pb-4">
              <hr>
            </div>
            <div>
              <h1 class="text-xl font-normal">Abholdetails</h1>
              <p class="text-sm text-gray-400">UPS Abholung machen können (Details)</p>
            </div>
            <div class="pt-8">
              <input type="number" name="weigth" placeholder="Gewicht" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" @isset($con) value="{{$con->weight}}" @endisset>
              <input type="number" name="packets" placeholder="Gesamtpackete" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2"@isset($con) value="{{$con->packets}}" @endisset>
              <select name="service" id="" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1 ml-2">
                @isset($con->servicecode)
                    @if ($con->servicecode == "11")
                      <option value="11">Standard</option>
                      <option value="65">Express</option>
                    @endif
                    @if ($con->servicecode == "65")
                    <option value="65">Express</option>
                    <option value="11">Standard</option>
                    @endif
                    @else
                    <option value="">Service</option>
                    <option value="65">Express</option>
                    <option value="11">Standard</option>
                @endisset

              </select>  
            </div>
            <div class="pt-6 flex">
              <div>
                <label for="start" class="font-normal">Abholzeit (von)</label>
                <br>
                <input type="time" oninput="changeTimePlusTwo(this.value)" name="pickuptimestart" id="start" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" @isset($con) value="{{$con->pickuptimestart}}" @endisset>
              </div>
              <p  class="mt-7 px-1 font-bold">-</p>
              <div>
                <label for="end" class="font-normal">Abholzeit (bis)</label>
                <br>
              <input type="time" oninput="changeTimeMinusTwo(this.value)" name="pickuptimeend" id="end" class="w-60 h-9 bg-white border-gray-400 rounded-md pt-1" @isset($con) value="{{$con->pickuptimeend}}" @endisset>
              </div>
            </div>
            <div class="pt-8">
              <hr>
            </div>

          <div class="mt-5 sm:mt-6">

            <button type="submit" onclick="loadData(); document.getElementById('contact-change-div').classList.remove('hidden');" class="float-left bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2 rounded-md">Speichern</button>
            <button type="button" onclick="document.getElementById('contact-change-div').innerHTML = ''" class="float-right font-medium bg-white hover:bg-gray-100 text-black px-4 py-2 rounded-md border border-gray-400">Abbrechen</button>
            @isset($con)
            <button type="button" onclick="deleteContact('{{$con->id}}')" class="float-right font-medium bg-red-600 hover:bg-red-400 text-white px-4 py-2 rounded-md mr-4">Löschen</button>

            @endisset
          </div>
        </div>
      </div>
    </div>
  </div>

  
</form>
