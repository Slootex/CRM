<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts/top-menu', ["menu" => "auftrag"])

    <div>
        <div class="relative overflow-hidden pb-32">
          <!-- Menu open: "bg-sky-900", Menu closed: "bg-transparent" -->

          <!-- Menu open: "bottom-0", Menu closed: "inset-y-0" -->
          
          <header class="relative py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
              <h1 class="text-3xl font-bold tracking-tight text-black">Einstellungen</h1>
            </div>
          </header>
        </div>
      
        <main class="relative -mt-32">
          <div class="mx-auto max-w-screen-xl px-4 pb-6 sm:px-6 lg:px-8 lg:pb-16">
            <div class="overflow-hidden rounded-lg bg-white shadow">
              <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                <aside class="py-6 lg:col-span-3">
                  <nav class="space-y-1">
                    <!-- Current: "bg-teal-50 border-teal-500 text-teal-700 hover:bg-teal-50 hover:text-teal-700", Default: "border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
                    <a href="#" onclick="changeTab('firmendaten')" id="firma" class="bg-teal-50 border-teal-500 text-teal-700 hover:bg-teal-50 hover:text-teal-700 group border-l-4 px-3 py-2 flex items-center text-sm font-medium" aria-current="page">
                      <!--
                        Heroicon name: outline/user-circle
      
                        Current: "text-teal-500 group-hover:text-teal-500", Default: "text-gray-400 group-hover:text-gray-500"
                      -->
                      <svg id="firmasvg" class="text-teal-500 group-hover:text-teal-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <span class="truncate">Firmendaten</span>
                    </a>
      
                    <a href="#" onclick="changeTab('systemdaten')" id="system" class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                      <!-- Heroicon name: outline/key -->
                      <svg id="systemsvg" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                      </svg>
                      <span class="truncate">Systemdaten</span>
                    </a>
                    <a href="#" onclick="changeTab('ausfall')" id="ausfall" class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                        <!-- Heroicon name: outline/key -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" id="ausfallsvg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                          </svg>
                          
                        <span class="truncate">Ausfalleintritt</span>
                    </a>
                    <a href="#" onclick="changeTab('regal')" id="regal" class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                      <!-- Heroicon name: outline/key -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        
                      <span class="truncate">Regale</span>
                  </a>
                  <a href="#" onclick="changeTab('permissions')" id="permission" class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                    <!-- Heroicon name: outline/key -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                      </svg>
                      
                    <span class="truncate">Regale</span>
                </a>
                  </nav>
                </aside>
                <div>
                  <form action="{{url('/')}}/shelfe/count/single" method="POST">
                    @CSRF
                    <select name="shelfe" id="">
                      @foreach ($shelfes as $shelfe)
                          <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                      @endforeach
                    </select>
                    @php
                        $deviceCount = 0;
                    @endphp
                    <select name="count" id="">
                      @while ($deviceCount <= 100)
                          <option value="{{$deviceCount}}">{{$deviceCount}}</option>
                      @php
                          $deviceCount++;
                      @endphp
                      @endwhile
                    </select>

                    <button type="submit">Speichern</button>
                  </form>
                  <form action="{{url('/')}}/shelfe/count/multiple" method="POST">
                    @CSRF
                    <select name="shelfe" id="">
                      @php
                          $usedShelfes = array();
                      @endphp
                      @foreach ($shelfes as $shelfe)
                          @if (!in_array(substr($shelfe->shelfe_id, 0, 1), $usedShelfes))
                            <option value="{{substr($shelfe->shelfe_id, 0, 1)}}">{{substr($shelfe->shelfe_id, 0, 1)}}</option>
                            @php
                                array_push($usedShelfes, substr($shelfe->shelfe_id, 0, 1));
                            @endphp
                          @endif
                      @endforeach
                    </select>
                    @php
                        $deviceCount = 0;
                    @endphp
                    <select name="count" id="">
                      @while ($deviceCount <= 100)
                          <option value="{{$deviceCount}}">{{$deviceCount}}</option>
                      @php
                          $deviceCount++;
                      @endphp
                      @endwhile
                    </select>

                    <button type="submit">Speichern</button>
                  </form>
                </div>
                <div class="divide-y divide-gray-200 lg:col-span-9"  id="firmendaten">
                  <!-- Profile section -->
                  <div class="py-6 px-4 sm:p-6 lg:pb-8">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Firmenname</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="float-left mr-10 mt-5">
                        <label class="text-base font-medium text-gray-900"></label>
                        <fieldset class="mt-4">
                          <legend class="sr-only">Notification method</legend>
                          <div class="space-y-4">
                            <div class="flex items-center float-left mr-10">
                              <input id="email" name="notification-method" type="radio" checked class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                              <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Herr</label>
                            </div>
                      
                            <div class="flex items-center ml-5">
                              <input id="sms" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                              <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">Frau</label>
                            </div>
                      
                          </div>
                        </fieldset>
                    </div>
                      <div class="mt-5 float-left mr-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Vorname</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Nachname</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5 float-left mr-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Straße</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 32.5rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Straßennummer</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.1rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5 float-left mr-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Postleitzahl</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 32.5rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Stadt</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.1rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5">
                        <label for="location" class="block text-sm font-medium text-gray-700">Stadt</label>
                        <select id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          <option>United States</option>
                          <option selected>Canada</option>
                          <option>Mexico</option>
                        </select>
                    </div>
                    <div class="mt-5 float-left mr-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 32.5rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>  
                    <div class="mt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Telefon</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.1rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    
                    <br>
                    <hr>
                    <br>
                    <div class="mt-5 float-left mr-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Bankname</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 32.5rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5 ">
                        <label for="email" class="block text-sm font-medium text-gray-700">IBAN</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.1rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5 ">
                        <label for="email" class="block text-sm font-medium text-gray-700">BIC</label>
                        <div class="mt-1">
                          <input type="email" name="email" id="email" style="width: 20.1rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                        </div>
                    </div>
                    <div class="mt-5 float-right pb-5">
                        <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
                    </div>
                  </div>
                </div>
                <div class="divide-y divide-gray-200 lg:col-span-9 hidden"  id="systemdaten">
                    <!-- Profile section -->
                    <div class="py-6 px-4 sm:p-6 lg:pb-8">
                      
                        <div class="mt-5 float-left mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">erlaubte Dateiendungen (Dokumente)</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">erlaubte Dateiendungen (Audio)</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 float-left mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">URL Kennwort</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">Super Kennwort</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="mt-5 mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">SMTP-Server-URL</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 float-left mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">SMTP-Benutzername</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 mr-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">SMTP-Passwort</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 mr-5 pb-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">SMTP-Port</label>
                            <div class="mt-1">
                              <input type="email" name="email" id="email" style="width: 20.3rem;" class="block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="GZA Motors">
                            </div>
                        </div>
                        <div class="mt-5 float-right pb-5">
                            <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 lg:col-span-9"  id="ausfall">
                    <!-- Profile section -->
                    <div class="py-6 px-4 sm:p-6 lg:pb-8">
                        <div>
                            <form action="{{url("/")}}/crm/allow/barcode" method="POST">
                                @CSRF
                            <label for="location" class="block text-sm font-medium text-gray-700">Barcode Eingeben erlaubt</label>
                            <select id="location" name="setting" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                              <option value="true">Ja</option>
                              <option selected value="false">Nein</option>
                            </select>
                            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>

                        </form>
                        <form action="{{url("/")}}/crm/change/barcodespecialchar" method="POST">
                          @CSRF
                      <label for="location" class="block text-sm font-medium text-gray-700">Specialchar</label>
                      <input type="text" name="char">
                      <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Speichern</button>

                  </form>
                          </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 lg:col-span-9 hidden"  id="regaldiv">
                  <!-- Profile section -->
                  <div class="py-6 px-4 sm:p-6 lg:pb-8">

                    <div class="float-left mr-16">
                      <p>Lagerplatz löschen</p>
                      <form action="{{url("/")}}/crm/delete/shelfe" method="POST">
                        @CSRF
                        <select name="shelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          <option value="" class="text-xl text-red-600 bg-green-300">REGAL 1</option>
                          @foreach ($shelfes as $shelfe)
                              <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} | {{$shelfe->component_number}}</option>
                          @endforeach
                          <option value="" class="text-xl text-red-600 bg-green-300">REGAL 2</option>
                          @foreach ($shelfes_archive as $shelfe)
                            <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} | {{$shelfe->component_number}}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="mt-1.5 ml-6 mr-6 inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Löschen</button>      

                      </form>
                    </div>
                    
                    <div>
                      <p>Lagerplatz hinzufügen</p>
                      <form action="{{url("/")}}/crm/add/shelfe" method="POST">
                        @CSRF
                        <input type="text" name="shelfe" id="email" class="block w-60 float-left rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="17B8">

                        <button type="submit" class="mt-1 ml-6 mr-6 inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Hinzufügen</button>      

                      </form>
                    </div>
                    <br>
                    <br>
                    <p>Aktive zu Archive</p>
                    <form action="{{url("/")}}/crm/shelfe/to-archive" method="POST">
                      @CSRF
                    <select name="oldshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @foreach ($shelfes as $shelfe)
                          <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} | {{$shelfe->component_number}}</option>
                      @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left ml-6 mr-6 mt-2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                    <select name="newshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      <option value="awd">Neues Fach</option>
                    </select>        
                    <button type="submit" class="mt-1.5 ml-6 mr-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zu Archive</button>      
                  </form>
                    <br>
                    
                    <form action="{{url("/")}}/crm/regal/to-archive" method="POST">
                      @CSRF
                    <select name="oldshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @php
                          $added_shelfes = [];
                      @endphp
                      @foreach ($shelfes as $shelfe)
                          @php
                              $splitA     = explode("A", $shelfe->shelfe_id);
                              $splitB     = explode("B", $shelfe->shelfe_id);
                          @endphp
                          
                            @if($splitA[0] != null && !in_array($splitA[0], $added_shelfes) && isset($splitA[1]))
                            <option value="{{$splitA[0]}}">{{$splitA[0]}}</option>

                             @php 
                              if(!str_contains($splitA[0], "A")) {
                                array_push($added_shelfes, $splitA[0]);
                              }
                             @endphp 
                             @endif
                      @endforeach
                    
                    </select>
                   
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left ml-6 mr-6 mt-2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                    <select name="newshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                      @foreach ($shelfes_archive as $shelfe)
                          <option value="newshelfe">Neues Regal</option>
                      @endforeach
                    </select>        
                    <button type="submit" class="mt-1.5 ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zu Archive</button>      
                  </form>
                  <br>
                  <br>
                  <br>
                  <p>Archive zu Aktive</p>
                  <form action="{{url("/")}}/crm/fach/to-aktive" method="POST">
                    @CSRF
                  <select name="oldshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @foreach ($shelfes_archive as $shelfe)
                      @if ($shelfe->process_id != "0")
                        <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}} || ({{$shelfe->shelfe_component_number}})</option>
                      @else
                        <option value="{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</option>
                      @endif
                  @endforeach
                  
                  </select>
                 
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left ml-6 mr-6 mt-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                  </svg>
                  <select name="newshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                    @foreach ($shelfes_archive as $shelfe)
                        <option value="newshelfe">Neues Regal</option>
                    @endforeach
                  </select>        
                  <button type="submit" class="mt-1.5 ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zu Archive</button>      
                </form>
                <br>
                
                <form action="{{url("/")}}/crm/regal/to-aktive" method="POST">
                  @CSRF
                <select name="oldshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  @php
                      $added_shelfes = [];
                  @endphp
                  @foreach ($shelfes_archive as $shelfe)
                      @php
                          $splitA     = explode("A", $shelfe->shelfe_id);
                          $splitB     = explode("B", $shelfe->shelfe_id);
                      @endphp
                      
                        @if($splitA[0] != null && !in_array($splitA[0], $added_shelfes) && isset($splitA[1]))
                        <option value="{{$splitA[0]}}">{{$splitA[0]}}</option>

                         @php 
                          if(!str_contains($splitA[0], "A")) {
                            array_push($added_shelfes, $splitA[0]);
                          }
                         @endphp 
                         @endif
                  @endforeach
                
                </select>
               
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left ml-6 mr-6 mt-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
                <select name="newshelfe" id="" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  @foreach ($shelfes_archive as $shelfe)
                      <option value="newshelfe">Neues Regal</option>
                  @endforeach
                </select>        
                <button type="submit" class="mt-1.5 ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Zu Archive</button>      
              </form>
              <br>
              <br>
              <div class="px-4 sm:px-6 lg:px-8 float-left">
                <div class="sm:flex sm:items-center">
                  <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900 text-center" >Aktive</h1>
                  </div>
                  <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                  </div>
                </div>
                <div class="mt-8 flex flex-col">
                  <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-96 py-2 align-middle md:px-6 lg:px-8">
                      <div class="overflow-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg h-96">
                        <table class="min-w-96 divide-y divide-gray-300">
                          <thead class="bg-gray-50">
                            <tr>
                              <th scope="col" class="pl-4 py-1 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Fach</th>
                              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Gerät</th>
                              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Bearbeiten</th>
                            </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($shelfes as $shelfe)
                            <tr>
                              <td class="whitespace-nowrap  pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$shelfe->shelfe_id}}</td>
                              @if ($shelfe->process_id != "0")
                                <td class="whitespace-nowrap px-3  text-sm text-gray-500">{{$shelfe->component_number}}</td>
                              @else
                                <td class="whitespace-nowrap px-3  text-sm text-gray-500 text-center">leer</td>
                              @endif
                              <td class="whitespace-nowrap px-3  text-sm text-blue-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 m-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                              </svg>
                              </td>

                            </tr>
                            @endforeach
              
                            <!-- More people... -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-4 sm:px-6 lg:px-8 float-right" style="margin-right: 10rem">
                <div class="sm:flex sm:items-center">
                  <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900 text-center">Archivierte</h1>
                  </div>
                  <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                  </div>
                </div>
                <div class="mt-8 flex flex-col">
                  <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-96 py-2 align-middle md:px-6 lg:px-8">
                      <div class="overflow-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg h-96">
                        <table class="min-w-96 divide-y divide-gray-300">
                          <thead class="bg-gray-50">
                            <tr>
                              <th scope="col" class="pl-4 py-1 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Fach</th>
                              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Gerät</th>
                              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Bearbeiten</th>
                            </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($shelfes_archive as $shelfe)
                            <tr>
                              <td class="whitespace-nowrap  pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$shelfe->shelfe_id}}</td>
                              @if ($shelfe->process_id != "0")
                                <td class="whitespace-nowrap px-3  text-sm text-gray-500">{{$shelfe->component_number}}</td>
                              @else
                                <td class="whitespace-nowrap px-3  text-sm text-gray-500 text-center">leer</td>
                              @endif
                              <td class="whitespace-nowrap px-3  text-sm text-blue-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 m-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                              </svg>
                              </td>

                            </tr>
                            @endforeach
              
                            <!-- More people... -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                  </div>
                </div>
                <div class="divide-y divide-gray-200 lg:col-span-9 hidden"  id="permissions">
                  <!-- Profile section -->
                  <div class="py-6 px-4 sm:p-6 lg:pb-8">
                      <div>
                          <form action="{{url("/")}}/crm/change/permission" method="POST">
                              @CSRF
                          <label for="location" class="block text-sm font-medium text-gray-700">Hinzufügen</label>
                          <select id="location" name="user" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                          </select>
                          <select id="location" name="permission" class="float-left ml-16 mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            <option value="packtisch.historie.anschauen">Packtisch Historie ansehen</option>
                          </select>
                          <button type="submit" class="inline-flex mt-1.5 ml-2 items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Hinzufügen</button>

                      </form>
                      <br>
                      <br>
                      <form action="{{url("/")}}/crm/delete/permission" method="POST">
                              @CSRF
                          <label for="location" class="block text-sm font-medium text-gray-700">Löschen</label>
                          <select id="location" name="user" class="float-left mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                          </select>
                          <select id="location" name="permission" class="float-left ml-16 mt-1 block w-60 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            <option value="packtisch.historie.anschauen">Packtisch Historie ansehen</option>
                          </select>
                          <button type="submit" class="inline-flex mt-1.5 ml-2 items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Löschen</button>

                      </form>
                        </div>
                        <div id="permissions" class="float-left mt-16">
                          <h1>Rechte</h1>
                          @foreach ($employees as $employee)
                          <select name="" id="" class="w-36">
                            <option value="">{{$employee->name}}</option>
                             
                           </select>
                          @endforeach
                        </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </main>
      </div>
      <script>
        function changeTab(tab) {
            if(tab == "firmendaten") {
                document.getElementById("firmendaten").classList.remove("hidden");
                document.getElementById("systemdaten").classList.remove("bg-teal-500");
                document.getElementById("systemdaten").classList.add("hidden");
                document.getElementById("system").classList.remove("text-teal-700");
                document.getElementById("system").classList.remove("border-teal-500");
                document.getElementById("systemsvg").classList.remove("text-teal-500");
                document.getElementById("system").classList.remove("bg-teal-50");
                document.getElementById("firma").classList.add("text-teal-700");
                document.getElementById("firma").classList.add("border-teal-500");
                document.getElementById("firmasvg").classList.add("text-teal-500");
                document.getElementById("firma").classList.add("bg-teal-50");
                document.getElementById("permissions").classList.add("hidden");

            } else if(tab == "systemdaten") {
                document.getElementById("firma").classList.remove("text-teal-700");
                document.getElementById("firma").classList.remove("border-teal-500");
                document.getElementById("firmasvg").classList.remove("text-teal-500");
                document.getElementById("firma").classList.remove("bg-teal-50");
                document.getElementById("system").classList.add("text-teal-700");
                document.getElementById("system").classList.add("border-teal-500");
                document.getElementById("systemsvg").classList.add("text-teal-500");
                document.getElementById("system").classList.add("bg-teal-50");
                document.getElementById("systemdaten").classList.remove("hidden");
                document.getElementById("firmendaten").classList.add("hidden");
                document.getElementById("permissions").classList.add("hidden");

            } else if(tab == "ausfall") {
                document.getElementById("firma").classList.remove("text-teal-700");
                document.getElementById("firma").classList.remove("border-teal-500");
                document.getElementById("firmasvg").classList.remove("text-teal-500");
                document.getElementById("firma").classList.remove("bg-teal-50");
                document.getElementById("system").classList.add("text-teal-700");
                document.getElementById("system").classList.add("border-teal-500");
                document.getElementById("systemsvg").classList.add("text-teal-500");
                document.getElementById("system").classList.add("bg-teal-50");
                document.getElementById("systemdaten").classList.add("hidden");
                document.getElementById("firmendaten").classList.add("hidden");
                document.getElementById("ausfall").classList.remove("hidden");
                document.getElementById("permissions").classList.add("hidden");

            } else if(tab == "regal") {
              document.getElementById("firma").classList.remove("text-teal-700");
                document.getElementById("firma").classList.remove("border-teal-500");
                document.getElementById("firmasvg").classList.remove("text-teal-500");
                document.getElementById("firma").classList.remove("bg-teal-50");
                document.getElementById("system").classList.add("text-teal-700");
                document.getElementById("system").classList.add("border-teal-500");
                document.getElementById("systemsvg").classList.add("text-teal-500");
                document.getElementById("system").classList.add("bg-teal-50");
                document.getElementById("systemdaten").classList.add("hidden");
                document.getElementById("firmendaten").classList.add("hidden");
                document.getElementById("regaldiv").classList.remove("hidden");
                document.getElementById("permissions").classList.add("hidden");
            } else if(tab == "permissions") {
              document.getElementById("firma").classList.remove("text-teal-700");
                document.getElementById("firma").classList.remove("border-teal-500");
                document.getElementById("firmasvg").classList.remove("text-teal-500");
                document.getElementById("firma").classList.remove("bg-teal-50");
                document.getElementById("system").classList.add("text-teal-700");
                document.getElementById("system").classList.add("border-teal-500");
                document.getElementById("systemsvg").classList.add("text-teal-500");
                document.getElementById("system").classList.add("bg-teal-50");
                document.getElementById("systemdaten").classList.add("hidden");
                document.getElementById("firmendaten").classList.add("hidden");
                document.getElementById("regaldiv").classList.add("hidden");
                document.getElementById("permissions").classList.remove("hidden");
            }
        }
      </script>
</body>
</html>