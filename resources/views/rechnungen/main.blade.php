<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "auftrag"])
    <style>
        .spin-slow {
            animation: spin 3s linear infinite;
        }
    </style>
        @include('forEmployees.modals.neueAudioRechnung')
    <div class="container mx-auto sm:px-6 lg:px-8"> <!--mx-auto-->
        <div class="overflow-hidden bg-white shadow mt-8 sm:rounded-lg lg:mt-36 m-auto" id="rechnung-bg-width" >
            <div class="px-4 py-5 sm:p-6">
                <div class="">
                    <div>
                        <button type="button" class="absolute border-0" onclick="loadArtikelSettings()">
                            <svg id="rechnung-setting-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-400 hover:text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>    
                        </button>
                        <div class="absolute bg-slate-50 w-72 h-0 rounded-md shadow-xl border-gray-600 z-20 mt-10 overflow-hidden" id="rechnung-setting-dropdown">
                            <h1 class="text-lg font-medium py-4 px-4 float-left">Artikelliste</h1>

                            <button class="float-right py-4 px-1.5" onclick="showNeuenArtikelDropdown()">
                                <svg id="rechnung-setting-neu-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 hover:text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>                                  
                            </button>

                            <table class="w-full" id="benutzen-artikel-table">
                                <thead class="w-full border border-l-0 border-r-0 border-t-0">
                                        <td class="px-4 text-left">ArtNr.</td>
                                        <td class="px-4 text-center">Art. Name</td>
                                        <td class="w-6"></td>
                                </thead>
                                <tbody>
                                    @foreach ($artikel as $art)
                                    <input type="hidden" id="{{$art->id}}-artikel-netto" value="{{$art->netto}}">
                                    <input type="hidden" id="{{$art->id}}-artikel-mwst" value="{{$art->mwst}}">                                         
                                    <input type="hidden" id="{{$art->id}}-artikel-brutto" value="{{$art->brutto}}">                                         
                                    <input type="hidden" id="{{$art->id}}-artikel-name" value="{{$art->artname}}">
                                    <input type="hidden" id="{{$art->id}}-artikel-nr" value="{{$art->artnr}}">        
        
                                    <tr class="border border-l-0 border-r-0 border-t-0 w-full overflow-hidden" id="{{$art->id}}-neuer-artikel-row">
                                        <td class="overflow-hidden text-left px-4 py-2 " id="{{$art->id}}-neuer-artikel-nr">{{$art->artnr}}</td>
                                        <td class="overflow-hidden text-center py-2" id="{{$art->id}}-neuer-artikel-name">{{$art->artname}}</td>
                                        <td class="overflow-hidden w-6">
                                            <td class="w-6">
                                            <button type="button float-right" onclick="editArtikel('{{$art->id}}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600 mr-1.5 hover:text-blue-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>     
                                            </button>
                                                                             

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                           
                        </div>

                        
                        <div class="absolute bg-white w-72 h-0 rounded-md shadow-xl  border-gray-600 z-30 mt-24 overflow-hidden" style="height: 0px;" id="rechnung-setting-neu-dropdown">
                            <form action="{{url("/")}}/crm/neuer-artikel" method="POST" id="neuer-artikel-form">
                                @CSRF
                                <h1 class="text-lg font-medium py-4 px-4 float-left">Neuer Artikel</h1>
                                <hr class="py-4">
                                <div class="relative mt-6 px-4">
                                    <label for="name" class="absolute -top-2 left-2 ml-2 inline-block bg-white px-1 text-xs font-medium text-gray-400">Artikelnummer</label>
                                    <input type="text" name="artnummer" id="neuer-artikel-nummer" class="bg-gray-100 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Artikelname</label>
                                    <input type="text" name="artname" id="neuer-artikel-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Netto</label>
                                    <input type="text" oninput="neuerArtikelNettoBrutto(this.value)" name="netto" id="neuer-artikel-netto" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">MwSt</label>
                                    <input type="text" oninput="neuerArtikelNettoBrutto(document.getElementById('neuer-artikel-netto').value);" value="19" name="mwst" id="neuer-artikel-mwst" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Brutto</label>
                                    <input type="text" name="brutto" id="neuer-artikel-brutto" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>

                                <button type="button" onclick="showNeuenArtikelDropdown()" class="text-black font-medium border border-gray-600 rounded-md text-center px-4 py-1 hover:bg-red-400 mt-4 ml-4 float-left">Abbrechen</button>
                                <button type="submit" class="text-white font-medium border border-gray-600 rounded-md text-center px-4 py-1 bg-blue-600 hover:bg-blue-500 hover:bg-blue-400 mt-4 mr-4 float-right">Speichern</button>
                            </form>
                        </div> 


                        <div class="absolute bg-white w-72 rounded-md shadow-xl hidden border-gray-600 z-10 mt-6 overflow-hidden" style="height: 28rem;" id="rechnung-setting-bearbeiten-dropdown">
                            <form action="{{url("/")}}/crm/bearbeiten-artikel" method="POST" id="bearbeiten-artikel-form">
                                @CSRF
                                <h1 class="text-lg font-medium py-4 px-4 float-left">Artikel verändern</h1>
                                <hr class="py-4">
                                <div class="relative mt-6 px-4">
                                    <label for="name" class="absolute -top-2 left-2 ml-2 inline-block bg-white px-1 text-xs font-medium text-gray-400">Artikelnummer</label>
                                    <input type="text" name="artnummer" id="bearbeiten-artikel-nr" class="bg-gray-100 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Artikelname</label>
                                    <input type="text" name="artname" id="bearbeiten-artikel-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Netto</label>
                                    <input type="text" oninput="neuerArtikelNettoBrutto(this.value)" name="netto" id="bearbeiten-artikel-netto" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">MwSt</label>
                                    <input type="text" oninput="neuerArtikelNettoBrutto(document.getElementById('neuer-artikel-netto').value);" value="19" name="mwst" id="bearbeiten-artikel-mwst" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="relative mt-8 px-4">
                                    <label for="name" class="absolute -top-2 left-6 inline-block bg-white px-1 text-xs font-medium text-gray-900">Brutto</label>
                                    <input type="text" name="brutto" id="bearbeiten-artikel-brutto" class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>

                                

                                <button type="button" onclick="document.getElementById('rechnung-setting-bearbeiten-dropdown').classList.remove('slide-right-in-animation'); document.getElementById('rechnung-setting-bearbeiten-dropdown').classList.add('slide-left-out-animation'); setTimeout( function() {document.getElementById('rechnung-setting-bearbeiten-dropdown').classList.add('hidden');}, 1000);" class="text-black font-medium border border-gray-600 rounded-md text-center px-4 py-1 hover:bg-red-400 mt-4 ml-4 float-left">Abbrechen</button>
                                <button type="submit" class="text-white font-medium border border-gray-600 rounded-md text-center px-4 py-1 bg-blue-600 hover:bg-blue-500 hover:bg-blue-400 mt-4 mr-4 float-right">Speichern</button>
                            </form>
                        </div>                           
                    </div>
                    <input type="hidden" class="rainbow-effect-animation animate-spin hidden">

                    <div class="float-left ml-8 mt-0.5">
                        <button type="button" onclick="document.getElementById('mwst-setting-modal').classList.remove('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400 hover:text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185zM9.75 9h.008v.008H9.75V9zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 4.5h.008v.008h-.008V13.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>   
                        </button> 
                        @include('forEmployees.modals.mwst-setting')                      
                    </div>
                   

                        <div class="float-right pb-4">
                            <div class="relative inline-block text-left float-right ml-1">
                              <div class="float-right">
                                <button onclick="toggleCreateDropDown()" type="button" class="inline-flex h-8 w-full justify-center hover:bg-blue-400 bg-blue-600 hover:bg-blue-500 text-white rounded-md px-3 py-1 rounded-tl-none rounded-bl-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 mt-0 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
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
                              <div id="createDropDown" class="hidden absolute right-0 z-10 mt-16 w-56 origin-top-right rounded-md bg-slate-50 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                  <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                  <a href="#createText" onclick="document.getElementById('neue-rechnung-modal-select-type').value = 'Rechnung'; document.getElementById('neue-rechnung-text-type').innerHTML = 'neue Rechnung'; document.getElementById('neue-rechnung-modal-type').value = 'Rechnung'" class="text-gray-700 block px-4 py-2 text-sm hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-0">

                                    
                                    neue Rechnung                     
                                  </a>
                                  <a href="#createText" onclick="document.getElementById('neue-rechnung-modal-select-type').value = 'Angebot'; document.getElementById('neue-rechnung-text-type').innerHTML = 'neues Angebot'; document.getElementById('neue-rechnung-modal-type').value = 'Angebot'" class="text-gray-700 block px-4 py-2 text-sm hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-0">

                                    neues Angebot                        
                                  </a>
                                  <a href="#createText" onclick="document.getElementById('neue-rechnung-modal-select-type').value = 'Gutschrift'; document.getElementById('neue-rechnung-text-type').innerHTML = 'neue Gutschrift'; document.getElementById('neue-rechnung-modal-type').value = 'Gutschrift'" class="text-gray-700 block px-4 py-2 text-sm  hover:text-blue-400" role="menuitem" tabindex="-1" id="menu-item-1">

                                    neue Gutschrift  
                                   </a>
                                </div>
                              </div>
                            </div>
                            <button onclick="loadNeueRechnungModal('12345')" class="bg-blue-600 hover:bg-blue-500 hover:bg-blue-400 text-white rounded-md px-6 py-1 rounded-tr-none rounded-br-none float-right">
                              <p class="font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  <span id="neue-rechnung-text-type">neue Rechnung</span>                                  
                              </p>
                            </button>
                          </div>
                </div>
                <div class="mr-16">
                    <button onclick="loadNeueZahlungModal('12345')" class="bg-blue-600 hover:bg-blue-500 hover:bg-blue-400 text-white rounded-md px-6 py-1 float-right mr-10">
                        <p class="font-semibold">
                            <span id="neue-rechnung-text-type">neue Zahlung</span>                                  
                        </p>
                      </button>
                </div>
             
                <div class="w-full">
                    <table class="mt-4 w-full" id="main-rechnung-table">
                        <thead>
                            <th class="border border-l-0 border-r-0 border-t-0 border-gray-600">
                                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium pr-4 text-xl w-60">Buchungen</td>
                                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-0 text-xl text-center">Offener Betrag</td>
                                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-0 pl-20 text-xl w-60">Aktion</td>
                                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-8 text-xl w-60 text-right">Mahnung</td>
                            </th>
                        </thead>
                        <tbody>
                            
                                @isset($kundenkonto->rechnungen)
                                @php
                                    $usedRechnungsnummern = array();
                                @endphp
                                    @foreach ($kundenkonto->rechnungen as $rechnung)
                                        @if (!in_array($rechnung->rechnungsnummer, $usedRechnungsnummern))
                                        @if (str_contains($rechnung->rechnungsnummer, "F") || str_contains($rechnung->rechnungsnummer, "G") || str_contains($rechnung->rechnungsnummer, "A"))
                                            
                                       
                                        <tr class="border border-l-0 border-r-0 border-t-0 border-gray-600" id="{{$rechnung->rechnungsnummer}}-rechnung-row">
                                            <td class=""></td>
                                            <td class="py-2" id="rechnung-cell2-{{$rechnung->rechnungsnummer}}" >
                                                <div class="rounded-lg py-2 px-4 @if($rechnung->deleted == "deleted") bg-red-50 @else bg-blue-50 @endif">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-5 float-left text-white bg-blue-400 rounded-full mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                </svg>
                                                <p class="text-lg mt-4"><span class="absolute font-light">{{$rechnung->created_at->format("d.m.Y (H:i)")}}</span><span class="ml-52">{{$rechnung->type}}</span></p>                                      
                                                <p class="text-lg ml-7 "><span class="absolute font-medium">Ersteller</span><span class="ml-52">{{$employees->where("id", $rechnung->mitarbeiter)->first()->name}}</span></p>                                      
                                                <p class="text-lg ml-7 "><span class="absolute font-medium">BelegNr.</span><span class="ml-52">{{$rechnung->rechnungsnummer}}</span></p>                                      
                                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Standart")->first() != null)
                                                    <p class="text-lg ml-7 "><span class="absolute font-medium">Versandart</span><span class="ml-52">Standart</span></p> 
                                                @endif           
                                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Express")->first() != null)
                                                    <p class="text-lg ml-7 "><span class="absolute font-medium">Versandart</span><span class="ml-52">Express</span></p> 
                                                @endif

                                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Überweisung")->first() != null)
                                                    <p class="text-lg ml-7 "><span class="absolute font-medium">Zahlungsart</span><span class="ml-52" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Überweisung</span></p>                                      
                                                @endif   
                                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Bar")->first() != null)
                                                    <p class="text-lg ml-7 "><span class="absolute font-medium">Zahlungsart</span><span class="ml-52" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Bar</span></p>                                      
                                                @endif   
                                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Nachnahme")->first() != null)
                                                    <p class="text-lg ml-7 "><span class="absolute font-medium">Zahlungsart</span><span class="ml-52" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Nachnahme</span></p>                                      
                                                @endif                             
                                                <p class="text-lg ml-7 "><span class="absolute font-medium">Rechnungsbetrag</span><span class="ml-52">
                                                    @php
                                                        $rechnungsbetrag = 0;
                                                    @endphp
                                                @foreach ($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer) as $rechnungskosten)
                                                    @php
                                                        $rechnungsbetrag += $rechnungskosten->bruttobetrag;
                                                    @endphp
                                                @endforeach 
                                                {{number_format((float)$rechnungsbetrag, 2, ',', '.')}}€   
                                                </span></p>                                      
                                                @if ($rechnung->zahlungsziel != null)
                                                <p class="text-lg ml-7 "><span class="absolute font-medium">Zahlungsziel</span><span class="ml-52">{{$rechnung->zahlungsziel}} Tage</span></p>                                                          
                                                @endif
                                                <p class="text-lg ml-7 "><span class="absolute font-medium">Rechnungstext</span></p>
                                                <p class="text-md ml-7 mt-7 text-gray-600 mb-2">@isset($rechnungstexte->where("id", $rechnung->rechnungstext)->first()->title) {{$rechnungstexte->where("id", $rechnung->rechnungstext)->first()->title}} @endisset</p>                                    
                                                </div>
                                            </td>
                                            <td class="text-center top-0" style="vertical-align:top">
                                                @php
                                                    $zahlungsbetrag = 0.00;
                                                @endphp
                                                @foreach ($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->first()->zahlungen as $zahlungen)
                                                    @php
                                                        $zahlungsbetrag += str_replace(",", ".", $zahlungen->betrag);
                                                    @endphp
                                                @endforeach

                                                @if ($rechnung->bezahlt == "true")

                                                <p class="mt-4" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 m-auto text-green-600 mt-0"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg> </p>

                                                <button type="button" onclick="window.location.href = '{{url('/')}}/crm/set-bezahlt-{{$rechnung->rechnungsnummer}}'" class="float-right  text-red-600" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right mr-36" style="margin-top: -2.2rem">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                                      </svg>
                                                </button>
                                                    @else

                                                    @if ($rechnungsbetrag == $zahlungsbetrag)
                                                        <p class="mt-4" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 m-auto text-green-600 mt-0"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg> </p>
                                                    @endif
                                                    @if ($zahlungsbetrag < $rechnungsbetrag)
                                                        <p class="mt-4   text-red-600" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag">- {{number_format(floatval($rechnungsbetrag - $zahlungsbetrag), 2, ',', '.');}} € <p>
                                                    @endif
                                                    @if ($zahlungsbetrag > $rechnungsbetrag)
                                                        <p class="mt-4   text-green-600" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag">+ {{number_format(floatval($zahlungsbetrag - $rechnungsbetrag), 2, ',', '.');}} €<p>
                                                    @endif

                                                    <button type="button" onclick="window.location.href = '{{url('/')}}/crm/set-bezahlt-{{$rechnung->rechnungsnummer}}'" class="float-right  text-green-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right mr-36" style="margin-top: -1.5rem">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                                          </svg>
                                                    </button>
                                                @endif

                                                
                                                  
                                                
                                                  
                                                  <input type="hidden" id="{{$rechnung->rechnungsnummer}}-rechnung-endrechnungsbetrag" value="{{$rechnungsbetrag}}">
                                                  <input type="hidden" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetraginput" value="{{$zahlungsbetrag}}">

            
                                            </td>
            
                                            <td style="vertical-align:top">
                                                <button type="button" class="top-0 mt-4">
                                                    <div class="bg-black rounded-md float-left p-1 mr-1" onclick="loadAudioFile('{{$rechnung->rechnungsnummer}}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                                                          </svg>
                                                          
                                                    </div> 
                                                </button>
                                                <button type="button" class="top-0 mt-4">
                                                    <div class="bg-green-600 rounded-md float-left p-1 mr-1" onclick="loadRechnungPos('{{$rechnung->rechnungsnummer}}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>  
                                                    </div> 
                                                </button>
                                                <button type="button" onclick="deleteRechnung('{{$rechnung->rechnungsnummer}}')">
                                                    <div class="bg-red-600 rounded-md float-left p-1 mr-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                          </svg>
                                                          
                                                    </div> 
                                                </button> 
                                                <a type="button" target="_blank" href="{{url("/")}}/crm/rechnung-pdf/{{$rechnung->rechnungsnummer}}">
                                                    <div class="bg-yellow-600 rounded-md float-left p-1 mr-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                          </svg>
                                                           
                                                    </div>
                                                </a>  
                                                <button type="button">
                                                    <div class="bg-blue-600 hover:bg-blue-500 rounded-md float-left p-1 mr-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                          </svg>
                                                          
                                                    </div>  
                                                </button> 
                                                
                                                @isset($rechnung->deleted)
                                                    <div id="{{$rechnung->rechnungsnummer}}-deleted" class="bg-red-50 h-12 py-2 px-2 rounded-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 float-left top-0 text-red-400">
                                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                                          </svg> 
                                                        <h1 class="text-red-600 font-semibold text-xs float-left ml-2">Rechnung storniert</h1>
                                                        <h1 class="text-red-600 font-semibold text-xs float-left ml-2">• <span id="{{$rechnung->rechnungsnummer}}-deleted-from" class="font-normal ml-1">{{$rechnung->deleted_from}}, am {{$rechnung->deleted_at}}</span></h1>
                                                                                                                 
                                                    </div>
                                                @endisset

                                                @if($rechnung->bezahlt == "true")
                                                    <div id="{{$rechnung->rechnungsnummer}}-bezahlt" class="bg-blue-50 h-12 mt-2 py-2 px-2 rounded-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-left top-0 text-blue-400">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                        </svg>   
                                                        
                                                        <h1 class="text-blue-600 font-semibold text-xs float-left ml-2 ">
                                                            Rechnung <span class="underline underline-offset-2">manuell</span> bezahlt gesetzt
                                                        </h1>
                                                        <h1 class="text-blue-600 font-semibold text-xs float-left ml-2">• <span id="{{$rechnung->rechnungsnummer}}-deleted-from" class="font-normal ml-1">{{$rechnung->deleted_from}}, am {{$rechnung->deleted_at}}</span></h1>
                                                                                                                                                                 
                                                    </div>
                                                @endif

                                                    @isset($rechnung->audiofiles->rechnungsnummer)
                                                        @else
                                                        <div class="bg-yellow-50 w-60 px-4 py-1 mt-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block text-yellow-400">
                                                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                                              </svg>
                                                              
                                                            <p class="text-yellow-600 font-semibold inline-block">Audiodatei fehlt!</p>                                                      
                                                        </div>
                                                    @endisset


                                            </td>
                                            
                                            <td style="vertical-align:top" class="w-72">
                                                <div class="py-2 w-72 float-right px-2 @if($rechnung->mahnungen->isEmpty()) hidden @endif" id="{{$rechnung->rechnungsnummer}}-mahnverlauf">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-yellow-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                      </svg>
                                                      <div class="ml-8" id="{{$rechnung->rechnungsnummer}}-mahnverlauf-p">
                                                        @if ($rechnung->mahnungen->isEmpty())
                                                        <p><span id="{{$rechnung->rechnungsnummer}}-mahnverlauf-zahlungserinnerung-date">{{$rechnung->created_at->format("d.m.Y")}}</span> <span class="text-yellow-700 underline" id="{{$rechnung->rechnungsnummer}}-mahnverlauf-zahlungserinnerung"><a href="{{url("/")}}/crm/mahnung/pdf-1/{{$rechnung->rechnungsnummer}}" target="_blank">Zahlungserinnrung</a></span></p>

                                                        @endif                                                        
                                                        @foreach ($rechnung->mahnungen as $mahnung)
                                                            <p><span >{{$mahnung->created_at->format("d.m.Y")}}</span> <span class="text-yellow-700 underline" ><a href="{{url("/")}}/crm/mahnung/pdf-{{$mahnung->mahnstufe}}/{{$rechnung->rechnungsnummer}}" target="_blank">{{$mahneinstellungen->where("mahnstufe", $mahnung->mahnstufe)->first()->bezeichnung}}</a></span></p>
                                                        @endforeach
                                                      </div>
                                                </div>

                                                    <div class="bg-red-50 rounded-md py-2 w-60 mr-2 float-right px-2   @if ($rechnung->mahnungen->isEmpty()) hidden @endif @if ($rechnung->mahnungen->where("process_id", "sperre")->first() != null) hidden @endif" id="{{$rechnung->rechnungsnummer}}-mahnstatus">

                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5  float-left text-red-400">
                                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                                        </svg>
                                                        
                                                      @if (!$rechnung->mahnungen->isEmpty())

                                                        <div class="ml-8">
                                                            <h1 class="text-red-600 font-normal text-xs">Laufendes Mahnverfahren</h1>
                                                            <p class=" text-red-500 font-light text-xs">• nächste Mahnstufe</p>

                                                            <p class=" text-red-500 font-light ml-2.5 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-status">
                                                                {{$mahneinstellungen->where("mahnstufe", $rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->mahnstufe )->first()->bezeichnung}}
                                                               am {{$rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->created_at->modify("+ " . $mahneinstellungen->where("mahnstufe", $rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->mahnstufe )->first()->zahlungsfrist . "days")->format("d.m.Y")}}</p>
                                                        </div>

                                                        @else
                                                        <div class="ml-8">
                                                            <h1 class="text-red-600 font-normal text-xs">Laufendes Mahnverfahren</h1>
                                                            <p class=" text-red-500 font-light text-xs">• nächste Mahnstufe</p>

                                                            <p class=" text-red-500 font-light ml-3 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-status"></p>
                                                            <p class=" text-red-500 font-light ml-3 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-date"></p>
                                                        </div>
                                                          
                                                      @endif
                                                  </div>


                                                  @if ($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->first() != null)
                                                  @isset($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->created_at)
                                                      
                                                 
                                                    <div class="bg-red-100 w-72 @if ($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->first() == null) hidden @endif px-2" id="{{$rechnung->rechnungsnummer}}-mahnsperre">

                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  float-left text-red-400">
                                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                                        </svg>
                                                        
                                                        <div class="ml-8">
                                                            <h1 class="text-red-600 font-normal">Mahnsperre gesetzt</h1>
                                                            <p class=" text-red-500 font-light">• <span id="{{$rechnung->rechnungsnummer}}-mahnsperre-datum">{{$rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->created_at->format("d.m.Y")}}</span></p>
                                                            <p class=" text-red-500 font-light ml-3" id="{{$rechnung->rechnungsnummer}}-mahnsperre-mitarbeiter">durch {{$employees->where("id", $rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->employee)->first()->name}}</p>
                                                            <p class="text-red-800 font-light text-center underline"><button type="button" class="underline" onclick="stopMahnsperre('{{$rechnung->rechnungsnummer}}')">Mahnsperre aufheben</button></p>
                                                        </div>
                                                        
                                                  </div>
                                                  @endisset
                                                  @else
                                                  <div class="bg-red-100 w-72 hidden  px-2" id="{{$rechnung->rechnungsnummer}}-mahnsperre">

                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  float-left text-red-400">
                                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                                        </svg>
                                                        
                                                        <div class="ml-8">
                                                            <h1 class="text-red-600 font-normal">Mahnsperre gesetzt</h1>
                                                            <p class=" text-red-500 font-light">• <span id="{{$rechnung->rechnungsnummer}}-mahnsperre-datum"></span></p>
                                                            <p class=" text-red-500 font-light ml-3" id="{{$rechnung->rechnungsnummer}}-mahnsperre-mitarbeiter"></p>
                                                            <p class="text-red-800 font-light text-center underline"><button type="button" class="underline" onclick="stopMahnsperre('{{$rechnung->rechnungsnummer}}')">Mahnsperre aufheben</button></p>
                                                        </div>
                                                        
                                                  </div>
                                                  @endif


                                                <div id="{{$rechnung->rechnungsnummer}}-mahneinstellung-buttons" class="@if($rechnung->mahnungen->isEmpty()) hidden @endif">
                                                    <div class="w-96">
                                                        @if ($rechnung->mahnungen->where("mahnstufe", "6")->first() != null)
                                                            <button type="button" onclick="skipMahnLevel('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">Inkasso übergabe</button>
                                                        @else 
                                                            <button type="button" onclick="skipMahnLevel('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">nächste Mahnstufe</button>
                                                        @endif
                                                        <button type="button" onclick="startMahnsperre('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 mr-6 bg-blue-600 hover:bg-blue-500 text-white font- rounded-md pt-1 float-right">Mahnsperre</button>
                                                    </div>
                                                </div>

                                                
                                                <div id="{{$rechnung->rechnungsnummer}}-mahnlauf-buttons" @if (!$rechnung->mahnungen->isEmpty()) class="hidden" @endif>
                                                    <button type="button" onclick="startMahnlauf('{{$rechnung->rechnungsnummer}}')" class="py-1 px-4 mt-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">Mahnlauf starten</button>
                                                 </div>
                                                
                                                 
                                            </td>
                                        </tr>  
                                        @endif
                                        @php
                                            array_push($usedRechnungsnummern, $rechnung->rechnungsnummer);
                                        @endphp

                                        @endif
                                    @endforeach
                                @endisset
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        let rabattState = false;
        function changeRechnungAnsicht() {
            document.getElementById('einfach-svg').classList.toggle("text-blue-400");
            document.getElementById('einfach-svg').classList.toggle("text-gray-500");
            document.getElementById('einfach-text').classList.toggle("text-gray-500");
            document.getElementById('einfach-button').classList.toggle("font-semibold");

            document.getElementById('detail-svg').classList.toggle("text-gray-500");
            document.getElementById('detail-svg').classList.toggle("text-blue-400");
            document.getElementById('detail-text').classList.toggle("text-gray-500");
            document.getElementById('detail-button').classList.toggle("font-semibold");

            document.getElementById('hidden-top-1').classList.toggle("hidden");
            document.getElementById('hidden-top-2').classList.toggle("hidden");
            document.getElementById('hidden-top-3').classList.toggle("hidden");
            document.getElementById('hidden-top-4').classList.toggle("hidden");
            document.getElementById('hidden-top-5').classList.toggle("hidden");
            document.getElementById('hidden-top-6').classList.toggle("hidden");
            document.getElementById('hidden-top-7').classList.toggle("hidden");
            document.getElementById('hidden-top-8').classList.toggle("hidden");
            document.getElementById('hidden-tr-1').classList.toggle("hidden");
            document.getElementById('hidden-tr-2').classList.toggle("hidden");
            document.getElementById('hidden-tr-3').classList.toggle("hidden");
            document.getElementById('hidden-tr-4').classList.toggle("hidden");
            document.getElementById('hidden-tr-5').classList.toggle("hidden");
            document.getElementById('hidden-tr-6').classList.toggle("hidden");
            document.getElementById('hidden-tr-7').classList.toggle("hidden");
            document.getElementById('hidden-tr-8').classList.toggle("hidden");


            var x = document.getElementById("rechnung-bg-width");
            if (x.style.width === "116rem") {
              x.style.width = "180rem";
            } else {
              x.style.width = "116rem";
            }
        }

        function toggleCreateDropDown() {
          document.getElementById("createDropDown").classList.toggle("hidden");
      }

      function loadNeueZahlungModal(id) {
        document.getElementById('rechnung-neue-zahlung-modal').classList.remove('hidden');
      }

      function loadNeueRechnungModal(id) {
        rechnungState = false;
        document.getElementById('rabatt-state').classList.add('hidden');
        let tempID = Math.floor(Math.random() * 10000);
        document.getElementById("positions-mwst-check").value = "";
        document.getElementById("neue-rechnung-modal-temp-id").value = tempID;
        document.getElementById("neue-rechnung-zusammenfassen-form").action = "{{url("/")}}/crm/rechnung-zusammenfassen/" + tempID;
        document.getElementById('zahlungsziel').value = "";
        finalBruttoPreis = 0;
        bruttoPreise = [];
        rechnungsPosCounter = 1;
        $('#neue-rechnung-table tr:not(:first):not(:last)').remove();
        document.getElementById("neue-rechnung-modal-final-brutto").innerHTML = "0,00\u20AC";
        document.getElementById('rechnung-neue-rechnung-modal').classList.remove('hidden');

        if(document.getElementById("neue-rechnung-modal-select-type").value != "Rechnung") {
            document.getElementById("zahlungsziel-neue-rechnung").classList.add("hidden");
            document.getElementById("zahlungsziel").value = "None";
        } else {
            document.getElementById("zahlungsziel-neue-rechnung").classList.remove("hidden");
            document.getElementById("zahlungsziel").value = "";
        }
      }

      let artikelSettingState = false;
      function loadArtikelSettings() {
        if(artikelSettingState == false) {
            document.getElementById("rechnung-setting-dropdown").classList.add("border");
            document.getElementById("rechnung-setting-svg").classList.remove("spin-backward-animation");
            document.getElementById("rechnung-setting-svg").classList.add("spin-forward-animation");
            document.getElementById("rechnung-setting-dropdown").classList.remove("hidden");
            document.getElementById("rechnung-setting-dropdown").classList.remove("collaps-animation");
            document.getElementById("rechnung-setting-dropdown").classList.add("expand-animation");
            artikelSettingState = true;
        } else {
            document.getElementById("rechnung-setting-dropdown").classList.remove("border");
            document.getElementById("rechnung-setting-svg").classList.remove("spin-forward-animation");
            document.getElementById("rechnung-setting-svg").classList.add("spin-backward-animation");
            document.getElementById("rechnung-setting-dropdown").classList.remove("expand-animation");
            document.getElementById("rechnung-setting-dropdown").classList.add("collaps-animation");
            document.getElementById("rechnung-setting-neu-dropdown").classList.remove("border");
            document.getElementById("rechnung-setting-neu-dropdown").classList.remove("expand-animation");
            document.getElementById("rechnung-setting-neu-dropdown").classList.add("collaps-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.remove("turnto-x-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.add("turnto-plus-animation");
            document.getElementById("neuer-artikel-name").value = "";
            document.getElementById("neuer-artikel-netto").value = "";
            document.getElementById("neuer-artikel-mwst").value = "";
            document.getElementById("neuer-artikel-brutto").value = "";

            artikelSettingNeuState = false;
            artikelSettingState = false;
        }
      }

      let artikelSettingNeuState = false;
      function showNeuenArtikelDropdown() {
        if(artikelSettingNeuState == false) {
            document.getElementById("rechnung-setting-neu-dropdown").classList.add("border");
            document.getElementById("rechnung-setting-neu-dropdown").classList.remove("collaps-animation");
            document.getElementById("rechnung-setting-neu-dropdown").classList.add("expand-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.remove("turnto-plus-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.add("turnto-x-animation");
            document.getElementById("neuer-artikel-nummer").value = Math.floor(Math.random() * 10000);


            artikelSettingNeuState = true;
        } else {
            document.getElementById("rechnung-setting-neu-dropdown").classList.remove("border");
            document.getElementById("rechnung-setting-neu-dropdown").classList.remove("expand-animation");
            document.getElementById("rechnung-setting-neu-dropdown").classList.add("collaps-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.remove("turnto-x-animation");
            document.getElementById("rechnung-setting-neu-svg").classList.add("turnto-plus-animation");
            document.getElementById("neuer-artikel-name").value = "";
            document.getElementById("neuer-artikel-netto").value = "";
            document.getElementById("neuer-artikel-mwst").value = "";
            document.getElementById("neuer-artikel-brutto").value = "";

            artikelSettingNeuState = false;
        }
      }

      $(document).ready(function() { 
            $('#neuer-artikel-form').ajaxForm(function( data ) { 
                let table = document.getElementById("benutzen-artikel-table");

                let row = table.insertRow(1);
                row.classList.add("update-row-animation");


                let cell1 = row.insertCell(0);
                cell1.innerHTML = data["artnr"];
                cell1.classList.add("text-left", "px-4", "py-2");

                let cell2 = row.insertCell(1);
                cell2.innerHTML = data["artname"];
                cell2.classList.add("text-center", "py-2");

                let cell3 = row.insertCell(2);
                cell3.innerHTML = '<button type="button float-right"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600 mr-1.5 hover:text-blue-400">                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />                                    </svg>                                     </button>  '
                cell3.classList.add("w-6");

                document.getElementById("rechnung-setting-neu-dropdown").classList.remove("border");
                document.getElementById("rechnung-setting-neu-dropdown").classList.remove("expand-animation");
                document.getElementById("rechnung-setting-neu-dropdown").classList.add("collaps-animation");
                document.getElementById("rechnung-setting-neu-svg").classList.remove("turnto-x-animation");
                document.getElementById("rechnung-setting-neu-svg").classList.add("turnto-plus-animation");
                document.getElementById("neuer-artikel-name").value = "";
                document.getElementById("neuer-artikel-netto").value = "";
                document.getElementById("neuer-artikel-mwst").value = "";
                document.getElementById("neuer-artikel-brutto").value = "";

                
            }); 

            $('#bearbeiten-artikel-form').ajaxForm(function( data ) {
                document.getElementById(data["id"] + "-neuer-artikel-nr").innerHTML = data["artnr"];
                document.getElementById(data["id"] + "-neuer-artikel-name").innerHTML = data["artname"];


                document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.remove("slide-right-in-animation");
                document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.add("slide-left-out-animation");
                document.getElementById(data["id"] + "-neuer-artikel-row").classList.remove("slide-right-in-animation");
                document.getElementById(data["id"] + "-neuer-artikel-row").classList.add("slide-left-out-animation");
                setTimeout( function() 
                {
                    document.getElementById(data["id"] + "-neuer-artikel-row").classList.remove("slide-left-out-animation");
                    document.getElementById(data["id"] + "-neuer-artikel-row").classList.remove("absolute");
                    document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.add("hidden");
                }, 1000);
            });

        }); 
   

            function neuerArtikelNettoBrutto(netto) {
                let mwst = parseFloat(netto)/parseFloat(document.getElementById("neuer-artikel-mwst").value).toFixed(2);
                let brutto = parseFloat(netto)+parseFloat(mwst);
                document.getElementById("neuer-artikel-brutto").value = brutto.toFixed(2);
            }

            function editArtikel(id) {

                document.getElementById(id + "-neuer-artikel-row").classList.add("absolute");
                document.getElementById(id + "-neuer-artikel-row").classList.add("slide-right-in-animation");
                document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.remove("hidden");
                document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.remove("slide-left-out-animation");
                document.getElementById("rechnung-setting-bearbeiten-dropdown").classList.add("slide-right-in-animation");
                document.getElementById("bearbeiten-artikel-name").value = document.getElementById(id + "-artikel-name").value;
                document.getElementById("bearbeiten-artikel-mwst").value = document.getElementById(id + "-artikel-mwst").value;
                document.getElementById("bearbeiten-artikel-netto").value = document.getElementById(id + "-artikel-netto").value;
                document.getElementById("bearbeiten-artikel-brutto").value = document.getElementById(id + "-artikel-brutto").value;
                document.getElementById("bearbeiten-artikel-nr").value = document.getElementById(id + "-artikel-nr").value;

                
                
            }

            function deleteRechnung(id) {
                if (confirm('Achtung soll die Rechnung wirklich gelöscht werden?')) {
                    window.location.href = "{{url("/")}}/crm/delete-rechnung/"+id;
                } else {
                  // Do nothing!
                  console.log('Thing was not saved to the database.');
                }
            }

            function startMahnlauf(id) {

                if(confirm("Möchten sie mit sicherheit einen Mahnlauf starten?")) {



                    $.get("{{url("/")}}/crm/mahnlaufstarten/" + id, function( data ) {
                        let mahnung = data[0];
                        let einstellung = data[1];

                        document.getElementById(id + "-mahnverlauf-zahlungserinnerung-date").innerHTML =  mahnung["date"];
                        document.getElementById(id + "-mahnverlauf-zahlungserinnerung").innerHTML = einstellung["bezeichnung"];
                        document.getElementById(id + "-mahnstatus-status").innerHTML = einstellung["nextlevel"];
                        document.getElementById(id + "-mahnstatus-date").innerHTML = "am " + einstellung["nextleveldate"];


                        document.getElementById(id + "-mahnverlauf").classList.remove("hidden");
                        document.getElementById(id + "-mahnstatus").classList.remove("hidden");
                        document.getElementById(id + "-mahnlauf-buttons").classList.add("hidden");
                        document.getElementById(id + "-mahneinstellung-buttons").classList.remove("hidden");
                    });

                } else {

                }
            }
            
            function skipMahnLevel(id) {

                if(confirm("Möchten Sie mit sicherheit die Mahnstufe erhöhen?")) {
                    $.get("{{url("/")}}/crm/skip-mahnlevel/" + id, function( data ) {
                    if(data != "error-max-level") {
                        let mahnung = data[0];
                        let einstellung = data[1];
                        if(mahnung["mahnstufe"] != "6") {
                            

                            let p = document.createElement("p");
                            p.innerHTML = '<span id=>'+ mahnung["date"] +'</span><span class="text-yellow-700 underline"><a href="{{url("/")}}/crm/mahnung/pdf-' + einstellung["mahnstufe"] + '/'+ mahnung["rechnungsnummer"] +'" target="_blank"> '+ einstellung["bezeichnung"] +'</a></span>';
                            document.getElementById(id + "-mahnverlauf-p").appendChild(p);

                            document.getElementById(id + "-mahnstatus-status").innerHTML = einstellung["nextlevel"];
                            document.getElementById(id + "-mahnstatus-date").innerHTML = "am " + einstellung["nextleveldate"];
                        } else {
                            let p = document.createElement("p");
                            p.innerHTML = '<span id=>'+ mahnung["date"] +'</span><span class="text-yellow-700 underline"><a href="{{url("/")}}/crm/mahnung/pdf-' + einstellung["mahnstufe"] + '/'+ mahnung["rechnungsnummer"] +'" target="_blank"> '+ einstellung["bezeichnung"] +'</a></span>';
                            document.getElementById(id + "-mahnverlauf-p").appendChild(p);

                            document.getElementById(id + "-mahnstatus-status").innerHTML = "Inkassoübergabe";
                            document.getElementById(id + "-mahnstatus-date").innerHTML = "am muss gazi fragen";
                        } 
                    } else {
                        alert("Achtung! das maximale Level wurde bereits erreicht");
                    }
                });
                }
            }

            function startMahnsperre(id) {
                if(confirm("Möchten Sie mit sicherheit eine Mahnsperre eröffnen?")) {
                    $.get("{{url("/")}}/crm/start-mahnsperre/" + id, function( mahnung ) {

                    document.getElementById(id + "-mahnstatus").classList.add("hidden");
                    document.getElementById(id + "-mahnsperre").classList.remove("hidden");
                    document.getElementById(id + "-mahnsperre-datum").innerHTML = mahnung["datum"];
                    document.getElementById(id + "-mahnsperre-mitarbeiter").innerHTML = "durch " + mahnung["mitarbeiter"];

                    document.getElementById(id + "-mahneinstellung-buttons").classList.add("hidden");
                });
                }
            }

            function stopMahnsperre(id) {
                
                $.get("{{url("/")}}/crm/stop-mahnsperre/" + id, function( data ) {
                    let mahnung = data[0];
                    let einstellung = data[1];

                    document.getElementById(id + "-mahnstatus-status").innerHTML = einstellung["nextlevel"];
                    document.getElementById(id + "-mahnstatus-date").innerHTML = "am " + einstellung["nextleveldate"];


                    document.getElementById(id + "-mahnverlauf").classList.remove("hidden");
                    document.getElementById(id + "-mahnstatus").classList.remove("hidden");
                    document.getElementById(id + "-mahnlauf-buttons").classList.add("hidden");
                    document.getElementById(id + "-mahneinstellung-buttons").classList.remove("hidden");
                    document.getElementById(id + "-mahnsperre").classList.add("hidden");
                });
            }

            function loadAudioFile(id) {

                $.get('{{url("/")}}/crm/rechnung/get-audio-file/' + id, function( data ) {
                    if(data == "") {
                        document.getElementById("audiofile-modal").classList.remove("hidden");
                        document.getElementById("audio-rechnungsnummer").value = id;
                    } else {

                        document.getElementById('audio-name').innerHTML = data["firstname"] + ' ' + data["lastname"];
                        document.getElementById('audio-streettop').innerHTML = data["street"] + ' ' + data["streetno"] + ', ' + data["zipcode"] + ', ' + data["city"];
                        document.getElementById('audio-shipaddress').innerHTML = data["firstname"] + ' ' + data["lastname"] + ', ' + data["street"] + ' ' + data["streetno"] + ', ' + data["zipcode"] + ', ' + data["city"];

                        document.getElementById('audio-firstname').value = data["firstname"];
                        document.getElementById('audio-lastname').value = data["lastname"];
                        document.getElementById('audio-street').value = data["street"];
                        document.getElementById('audio-streetno').value = data["streetno"];
                        document.getElementById('audio-zipcode').value = data["zipcode"];
                        document.getElementById('audio-city').value = data["city"];
                        document.getElementById('audio-country').value = data["country"];
                        document.getElementById('audio-talkname').value = data["talkname"];
                        document.getElementById('audio-worktype').value = data["worktype"];
                        document.getElementById('audio-worktime').value = data["worktime"];
                        document.getElementById('audio-birthday').value = data["birthday"];
                        
                        document.getElementById('read-audiofile').href = "{{url("/")}}/audiofiles/" + id + ".mp3";
                        document.getElementById('read-audiofile').classList.remove('hidden');

                        if(data["tophone"] == "on") {
                            document.getElementById('tophone-no').checked = false;
                            document.getElementById('tophone-yes').checked = true;

                        } else {
                            document.getElementById('tophone-no').checked = true;
                            document.getElementById('tophone-yes').checked = false;
                        }

                        if(data["acceptone"] == "on") {
                            document.getElementById('acceptone-no').checked = false;
                            document.getElementById('acceptone-yes').checked = true;

                        } else {
                            document.getElementById('acceptone-no').checked = true;
                            document.getElementById('acceptone-yes').checked = false;
                        }

                        if(data["talkaccept"] == "on") {
                            document.getElementById('talkaccept-no').checked = false;
                            document.getElementById('talkaccept-yes').checked = true;

                        } else {
                            document.getElementById('talkaccept-no').checked = true;
                            document.getElementById('talkaccept-yes').checked = false;
                        }

                        if(data["shipafterpay"] == "on") {
                            document.getElementById('shipafterpay-no').checked = false;
                            document.getElementById('shipafterpay-yes').checked = true;

                        } else {
                            document.getElementById('shipafterpay-no').checked = true;
                            document.getElementById('shipafterpay-yes').checked = false;
                        }

                        if(data["priceok"] == "on") {
                            document.getElementById('priceok-no').checked = false;
                            document.getElementById('priceok-yes').checked = true;

                        } else {
                            document.getElementById('priceok-no').checked = true;
                            document.getElementById('priceok-yes').checked = false;
                        }

                        if(data["takebacktalk"] == "on") {
                            document.getElementById('takebacktalk-no').checked = false;
                            document.getElementById('takebacktalk-yes').checked = true;

                        } else {
                            document.getElementById('takebacktalk-no').checked = true;
                            document.getElementById('takebacktalk-yes').checked = false;
                        }

                        
                        if(data["accepttwo"] == "on") {
                            document.getElementById('accepttwo-no').checked = false;
                            document.getElementById('accepttwo-yes').checked = true;

                        } else {
                            document.getElementById('accepttwo-no').checked = true;
                            document.getElementById('accepttwo-yes').checked = false;
                        }


                        document.getElementById("audio-rechnungsnummer").value = id;
                        document.getElementById("audiofile-modal").classList.remove("hidden");

                    }
                });

            }
    </script>

    @include('forEmployees.modals.rechnungNeueZahlung')
    @include('forEmployees.modals.rechnungNeueRechnung')

</body>
</html>