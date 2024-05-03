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

    <div class="overflow-hidden rounded-lg bg-white shadow m-auto mt-16" style="width: 93%">
        <div class="px-4 py-5 sm:p-6 w-full">
            <h1 class="text-center text-normal ">Hilfsbarcode: <span class="text-blue-600">{{$barcode->helper_code}}</span></h1>
          <div class="pl-5 pt-5 pb-5 w-full">
            <div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    
  </div>
  <form action="{{url('/')}}/crm/hilfscode-an-packtisch/{{$barcode->helper_code}}" method="POST">
    @CSRF
  <div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="bg-white px-8 py-8 shadow sm:rounded-lg sm:p-6 mt-6 pr-60 w-full" >
                
            <div class="mt-5 md:col-span-2 md:mt-0 float-left" style="width: 40%">
              <div class="grid grid-cols-6 gap-2">
                  <div class="col-span-4 sm:col-span-4">
                      <h3>Rechnungsinformationen</h3>
                  </div>
                <div class="col-span-4 sm:col-span-4">
                  <input type="hidden" name="employee" id="" value="{{session()->get("username")}}">
                  <input type="hidden" name="pricemwst" value="19">
                    <label for="first-name" class="block text-normal font-normal text-gray-700">Firma</label>
                    <input type="text" name="companyname" value="" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                  </div>
                <div class="col-span-2 sm:col-span-2">
                    <label for="location" class="block text-normal font-normal text-gray-700">Anrede</label>
                    <select id="location" name="gender" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 h-10 sm:text-l">
                      <option value="Herr">Herr</option>
                      <option value="Frau">Frau</option>

                    </select>
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="first-name" class="block text-normal font-normal text-gray-700">Vorname</label>
                  <input type="text" value="" name="firstname" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
      
                <div class="col-span-6 sm:col-span-3">
                  <label for="last-name" class="block text-normal font-normal text-gray-700">Nachname</label>
                  <input type="text" name="lastname" value="" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
      
                <div class="col-span-6 sm:col-span-4">
                  <label for="email-address" class="block text-normal font-normal text-gray-700">Straße</label>
                  <input type="text" oninput="geolocate('home_street')" name="street" value="" id="home_street"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
                <div id="test">

                </div>
                <div class="col-span-2 sm:col-span-2">
                    <label for="email-address" class="block text-normal font-normal text-gray-700">Straßennummer</label>
                    <input type="text" name="streetno" value="" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                  </div>
                <div class="col-span-2 sm:col-span-2">
                    <label for="email-address" class="block text-normal font-normal text-gray-700">Postleitzahl</label>
                    <input type="text" name="zipcode" id="email-address" value="" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
                <div class="col-span-2 sm:col-span-2">
                    <label for="email-address" class="block text-normal font-normal text-gray-700">Stadt</label>
                    <input type="text" name="city" id="email-address" value="" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
      
                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-normal font-normal text-gray-700">Land</label>
                  <select id="country" name="home_country" value="" autocomplete="country-name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 h-10 sm:text-l">
                  
                    @foreach ($countries as $country)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                    @endforeach
                  </select>
                </div>
      
      
                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                  <label for="city" class="block text-normal font-normal text-gray-700">Email</label>
                  <input type="text" name="email" id="city" value="" autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
      
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                  <label for="region" class="block text-normal font-normal text-gray-700">Mobil</label>
                  <input type="text" name="mobilnumber" id="region" value="" autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
      
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                  <label for="postal-code" class="block text-normal font-normal text-gray-700">Festnetz</label>
                  <input type="text" name="phonenumber" id="postal-code" value="" autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10 sm:text-xl">
                </div>
                
                
              </div>
            </div>
            
            <div style="margin-left: 35vw">
              <div style="border-left: 0.05vw solid rgb(197, 197, 197);height:500px; width: .1vw; margin-left: 15%;">

              <div class="col-span-5 sm:col-span-4 mt-8" style="margin-left: 5rem">
                  <label class="text-base font-normal text-gray-900">Versand</label>
                  <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                      <div class="flex items-center w-16 mt-0">
                        <input id="emartshil" name="type" type="radio" value="standard" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="email" class="ml-3 block text-normal font-normal text-gray-700">Standart</label>
                      </div>
                      <br>
                      <div class="flex items-center w-16">
                        <input id="smawrs" name="type" type="radio" value="express"  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="sms" class="ml-3 block text-normal font-normal text-gray-700">Express</label>
                      </div>
                      <br>
                      <div class="flex items-center w-26">
                        <input id="smsdfgs" name="type" type="radio" value="international"  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="sms" class="ml-3 block text-normal font-normal text-gray-700">International</label>
                      </div>
                      <br>
                      <div class="flex items-center w-16">
                        <input id="ssdfgms" name="type" type="radio" value="samstagszustellung"  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="sms" class="ml-3 block text-normal font-normal text-gray-700">Samstagszustellung</label>
                      </div>
                      <br>
                    </div>
                  </fieldset>
                
                <br>
                <br>
                <div class="col-span-6 sm:col-span-3">
                  <label class="text-base font-normal text-gray-900">Zahlart</label>
                  <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                      <div class="flex items-center">
                        <input id="awd" name="payment_type" type="radio" value="nachnahme"  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="email" class="ml-3 block text-normal font-normal text-gray-700">Nachnahme</label>
                      </div>
                      <div class="flex items-center">
                        <input id="awdawda" name="payment_type" type="radio" value="transfer" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="sms" class="ml-3 block text-normal font-normal text-gray-700">Überweisung</label>
                      </div>
                      <div class="flex items-center">
                        <input id="sawdawdadams" name="payment_type" type="radio" value="cash"  class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="sms" class="ml-3 block text-normal font-normal text-gray-700">Bar</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-sm font-normal text-gray-700">BPZ 1</label>
                  <select id="country" name="kfile1" autocomplete="country-name" class="mt-1 float-left block w-60 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @isset($bpzs)
                    <option selected value="{{$bpzs->Datei_1}}">{{$bpzs->Datei_1}}</option>
                    @else 
                    <option value="0">Bitte auswählen</option>
                    @endisset
                    <option value="BPZ Sonstige">BPZ Sonstige</option>
                    <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                    <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                    <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                    <option value="BPZ Prüfung">BPZ Prüfung</option>
                    <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                    <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                    <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                    <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                    <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                    <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                    <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                    <option value="BPZ BSI">BPZ BSI</option>
                    <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                    <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                    <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                    <option value="ALL Hinweis">ALL Hinweis</option>
                  </select>
                </div>
                <input type="text" hidden value="Kunde" name="ktype">

                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-sm font-normal text-gray-700 float-left">BPZ 2</label>
                  <select id="country" name="kfile2" autocomplete="country-name" class="mt-1 block w-60 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @isset($bpzs)
                    <option selected value="{{$bpzs->Datei_2}}">{{$bpzs->Datei_2}}</option> 
                    @else
                    <option value="0">Bitte auswählen</option>
                    @endisset
                    <option value="BPZ Sonstige">BPZ Sonstige</option>
                    <option value="BPZ Servolenkungssteuergerät">BPZ Servolenkungssteuergerät</option>
                    <option value="BPZ SBC-Steuergerät">BPZ SBC-Steuergerät</option>
                    <option value="BPZ SBC-Steuergerät">BPZ Radio Tacho</option>
                    <option value="BPZ Prüfung">BPZ Prüfung</option>
                    <option value="BPZ Motor-Steuergerät TECH 2">BPZ Motor-Steuergerät TECH 2</option>
                    <option value="BPZ Motor-Steuergerät SET">BPZ Motor-Steuergerät SET</option>
                    <option value="BPZ Motor-Steuergerät IMMO">BPZ Motor-Steuergerät IMMO</option>
                    <option value="BPZ Motor-Steuergerät">BPZ Motor-Steuergerät</option>
                    <option value="BPZ Lenkungssteuergerät">BPZ Lenkungssteuergerät</option>
                    <option value="BPZ ECU AMERIKA 2 SCHLÜSSEL">BPZ ECU AMERIKA 2 SCHLÜSSEL</option>
                    <option value="BPZ Drosselklappe">BPZ Drosselklappe</option>
                    <option value="BPZ BSI">BPZ BSI</option>
                    <option value="BPZ Airbag-Steuergerät">BPZ Airbag-Steuergerät</option>
                    <option value="BPZ ABS Motorrad">BPZ ABS Motorrad</option>
                    <option value="BPZ ABS ESP-Steuergerät">BPZ ABS ESP-Steuergerät</option>
                    <option value="ALL Hinweis">ALL Hinweis</option>
                  </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-sm font-normal text-gray-700">Überspannungsschutz</label>
                  <select id="country" name="spannungsschutz" autocomplete="country-name" class="mt-1 block w-60 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    <option value="ja">Ja</option>
                    <option value="nein" selected>Nein</option>
                  </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-sm font-normal text-gray-700">Gummibärchen</label>
                  <select id="country" name="gummi" autocomplete="country-name" class="mt-1 block w-60 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    <option value="ja" selected>Ja</option>
                    <option value="nein">Nein</option>
                  </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label for="country" class="block text-sm font-normal text-gray-700">Versiegeln</label>
                  <select id="country" name="vp_si" autocomplete="country-name" class="mt-1 block w-60 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    <option value="ja" selected>Ja</option>
                    <option value="nein">Nein</option>
                  </select>
                </div>
                </div>
                <select id="user_packing_carriers_service" hidden name="carriers_service" class="custom-select">
                  <option value="11">UPS Standard - 0,00 €</option>
                  <option value="65" selected>UPS Saver - 0,00 €</option>
                </select>
                <label id="amount_label_user" class="col-sm-2 col-form-label" style="display: none" for="amount">Betrag</label>
                  <div id="amount_amount_user" class="col-sm-4" style="display: none">
                    <div class="input-group">
                      <input type="text" id="amount_amount_user" name="amount" value="0,00" class="form-control">
                      <span class="input-group-append">
                        <span class="input-group-text">€</span>
                      </span>
                    </div>
                  </div>
                  
                  <div class="form-group row" hidden>
                    <label class="col-sm-4 col-form-label">Maße / Gewicht</label>
                    <div class="col-sm-2">
                      <input type="number" id="user_packing_length" name="length" step="1" value="30" class="form-control" placeholder="Länge" data-toggle="tooltip" data-placement="top" title="" data-original-title="Länge">
                    </div>
                    <div class="col-sm-2">
                      <input type="number" id="user_packing_width" name="width" step="1" value="20" class="form-control" placeholder="Breite" data-toggle="tooltip" data-placement="top" title="" data-original-title="Breite">
                    </div>
                    <div class="col-sm-2">
                      <input type="number" id="user_packing_height" name="height" step="1" value="10" class="form-control" placeholder="Höhe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Höhe">
                    </div>
                    <div class="col-sm-2">
                      <input type="number" id="user_packing_weight" name="weight" step="0.1" value="5.0" class="form-control" placeholder="Gewicht" data-toggle="tooltip" data-placement="top" title="" data-original-title="Gewicht">
                    </div>
                  </div>
              </div>
              </div>
              <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-normal font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Versenden</button>

          </div>
      
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
              </div>
          </div>
            </div>

          
          </div>
        </div>
    </div>
  </div>
  </form>
</div>
          </div>

        </div>
      </div>
</body>
</html>