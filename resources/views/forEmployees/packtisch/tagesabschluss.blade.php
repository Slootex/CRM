<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')
</head>
<body>
  @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "tagesabschluss-packtisch"])

    <form action="{{url("/")}}/crm/packtisch/tagesabschluss-absenden" method="POST">
        @CSRF
        <div class="bg-white w-3/5 rounded-md m-auto mt-10 p-10">
                        
            <div class="mb-10">
                <h1 class="text-3xl font-bold float-left">Materialinventur <span class="text-gray-500 font-medium text-2xl">(Letzte Inventur: @isset($inventar[0]->id) @if($abschluss->where("item", $inventar[0]->id)->first() != null) {{$abschluss->where("item", $inventar[0]->id)->first()->created_at->format("d.m.Y")}}) @endif @endisset</span></h1>
                <button type="button" onclick="document.getElementById('neues-produkt-leer-modal').classList.remove('hidden')" class="py-3 px-6 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold float-right text-md">+ Neues Produkt</button>
            </div>
    
    
            @foreach ($inventar as $item)
            <div class="h-40 w-full py-4">
                <div>
                    <div class="w-20 float-left">
                        <img src="{{url("/")}}/files/inventar/{{$item->id}}.png?{{rand()}}" onerror='this.src = "https://opengameart.org/sites/default/files/grasspres_0.png"' alt="" class="w-20 h-20 rounded-md shadow">
                        <a href="{{url("/")}}/crm/packtisch/tagesabschluss/produkt-bearbeiten/{{$item->id}}" class="text-blue-600 text-center mt-1">bearbeiten</a>
                    </div>
                    <div class="pl-4 float-left">
                        <p class="font-medium text-md">{{$item->name}}</p>
                        @isset($abschluss->where("item", $item->id)->first()->item)
                            <p class="text-md @if($item->min < $abschluss->where("item", $item->id)->first()->count) text-green-600 @else text-red-600 @endif py-1">Aktueller Bestand {{$abschluss->where("item", $item->id)->first()->count}} 
                              <span class="text-gray-400">· Zuletzt Bestellt: @if($bestellungen->sortByDesc("created_at")->where("itemid", $item->id)->first() != null) {{$bestellungen->sortByDesc("created_at")->where("itemid", $item->id)->first()->created_at->format("d.m.Y (H:i)")}} @else Keine daten @endif</span></p>
                            @else
                            <p class="text-md text-red-600 py-1">Aktueller Bestand / <span class="text-gray-400">· noch nicht erfasst</span></p>
                        @endisset
                        <p class="text-md text-gray-400">Mindestmenge {{$item->min}} · {{$item->einheit}} · <a href="{{url("/")}}/crm/packtisch/tagesabschluss/bestellungen/{{$item->id}}" class="text-blue-600 underline">Bestellhistorie</a> </p>
                        
                    </div>
                    <div class="float-right">
                        <input type="text" required name="{{$item->id}}" class="rounded-md border border-gray-600 text-md h-10 w-60 text-center mt-8" placeholder="Aktuelle Menge">
                    </div>
                </div>
            </div>
            @endforeach

            <div class="w-3/5 h-16 m-auto">
                <button onclick="loadData();" type="submit" class="float-left rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold px-10 text-2xl h-20">Abschließen</button>
                <a href="{{url("/")}}/crm/skip/tagesabschluss" class="float-right text-center pt-1 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-semibold px-10 text-2xl h-20">Überspringen <br> (noch {{7- $abschluss->where("item", "skip")->count()}} mal möglich)</a>
            </div>

        </div>
    </form>






    @isset($produkt)
<form action="{{url("/")}}/crm/packtisch/neues-inventar/{{$produkt->id}}" method="POST" enctype="multipart/form-data">

  @else
  <form action="{{url("/")}}/crm/packtisch/neues-inventar" method="POST" enctype="multipart/form-data">
@endisset
    @CSRF
    <div class="relative @if(!isset($produkt)) hidden @endif z-10" id="neues-produkt-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              <div>
                <h1 class="text-2xl">Produkt bearbeiten</h1>
              </div>
              <div class="pt-4">
                @isset($produkt)
                  <img src="{{url("/")}}/files/inventar/{{$produkt->id}}.png?{{rand()}}" onerror='this.src = "https://opengameart.org/sites/default/files/grasspres_0.png"' alt="" class="w-12 h-12 rounded-md shadow float-left mr-2">
                @else
                  <img src="https://opengameart.org/sites/default/files/grasspres_0.png" alt="" class="w-12 h-12 rounded-md shadow float-left mr-2">
                @endisset
                <div class=" bg-grey-lighter ml-2">
                    <label class="float-left ml-2 w-36 overflow-hidden truncate mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue-500">
                        
                        <span class="mt-0 text-base leading-normal w-36 overflow-hidden truncate"><span class="float-left overflow-hidden truncate w-36 px-2" id="imagefile"></span> <svg class="w-5 h-5 float-left mt-1 ml-2" id="filesvg" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg> <span class="ml-3" id="filetext">Bearbeiten</span> </span>
                        <input type='file' oninput="document.getElementById('imagefile').innerHTML = this.value.split('\\')[this.value.split('\\').length - 1]; document.getElementById('filesvg').remove(); document.getElementById('filetext').remove()" class="hidden" name="file" id="emailvorlage-fileinput" />
                    </label>
                    @isset($produkt->id)
                    <a href="{{url("/")}}/crm/packtisch/materialinventur/bild-löschen-{{$produkt->id}}" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                      </svg>                    
                    </a>
                    <a href="{{url("/")}}/files/inventar/{{$produkt->id}}.png?{{rand()}}" target="_blank" class="float-right" id="emailvorlage-bearbeiten-ansehen-pdf">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400 mr-2 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                      </svg>
                    </a>
                    @endisset
                </div>
            </div>

            <div>
                <input type="text" name="name" @isset($produkt) value="{{$produkt->name}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Produktname">
            </div>

            <div>
                <input type="text" name="menge" @isset($produkt) value="{{$produkt->min}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-40 float-left" placeholder="Mindestmenge">
                <input type="text" name="einheit" @isset($produkt) value="{{$produkt->einheit}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-40 float-right" placeholder="Verpackgunseinheit">
            </div>
            
            <div>
              <input type="text" name="epreis" @isset($produkt) value="{{$produkt->epreis}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="E-Preis">
            </div>

            <div>
                <input type="text" name="addresse" @isset($produkt) value="{{$produkt->addresse}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Addresse (URL)">
            </div>

            

            <div>
              <input type="text" name="timediff" @isset($produkt) value="{{$produkt->timediff}}" @endisset class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Verbrauchstage">
            </div>

            <div>
                <button onclick="loadData();"  type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 font-semibold text-md float-left text-white mt-6">Speichern</button>
                <button type="button" onclick="document.getElementById('neues-produkt-modal').classList.add('hidden')" class="rounded-md bg-white px-4 py-2 font-semibold text-md float-right border border-gray-600 mt-6">Abbrechen</button>
            </div>

            @isset($produkt)
            <br>
            <br>
            <br>
            <div class="w-full h-16">
              <button type="button" onclick="window.location.href = '{{url("/")}}/crm/inventar/löschen-{{$produkt->id}}'" class="w-full py-2 rounded-mt mt-4 bg-red-400 hover:bg-red-300 text-white font-medium text-md rounded-md">Produkt löschen</button> 
            </div>
            @endisset

            </div>
          </div>
        </div>
      </div>
    </form>

      <form action="{{url("/")}}/crm/packtisch/neues-inventar" method="POST" enctype="multipart/form-data">

        @CSRF
        <div class="relative hidden z-10" id="neues-produkt-leer-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
              <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                  <div>
                    <h1 class="text-2xl">Neues Produkt hinzufügen</h1>
                  </div>
                  <div class="pt-4">
                      <img src="https://opengameart.org/sites/default/files/grasspres_0.png" alt="" class="w-12 h-12 rounded-md shadow float-left mr-2">
                    <div class=" bg-grey-lighter ml-2">
                        <label class="float-left ml-2 w-36 overflow-hidden truncate mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue-500">
                            
                            <span class="mt-0 text-base leading-normal w-36 overflow-hidden truncate"><span class="float-left overflow-hidden truncate w-36 px-2" id="imagefile-new"></span> <svg class="w-5 h-5 float-left mt-1 ml-2" id="filesvg-new" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg> <span class="ml-3" id="filetext-new">Bearbeiten</span> </span>
                            <input type='file' oninput="document.getElementById('imagefile-new').innerHTML = this.value.split('\\')[this.value.split('\\').length - 1]; document.getElementById('filesvg-new').remove(); document.getElementById('filetext-new').remove()" class="hidden" name="file" id="emailvorlage-fileinput" />
                        </label>
                        
                    </div>
                </div>
    
                <div>
                    <input type="text" name="name" class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Produktname">
                </div>
    
                <div>
                    <input type="text" name="menge" class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-40 float-left" placeholder="Mindestmenge">
                    <input type="text" name="einheit"  class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-40 float-right" placeholder="Verpackgunseinheit">
                </div>
                
                <div>
                  <input type="text" name="epreis" class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="E-Preis">
                </div>
    
                <div>
                    <input type="text" name="addresse"  class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Addresse (URL)">
                </div>
    
                
    
                <div>
                  <input type="text" name="timediff"  class="rounded-md mt-4 border border-gray-300 text-left px-2 text-md h-10 w-full" placeholder="Verbrauchstage">
                </div>
    
                <div>
                    <button onclick="loadData();"  type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 font-semibold text-md float-left text-white mt-6">Speichern</button>
                    <button type="button" onclick="document.getElementById('neues-produkt-leer-modal').classList.add('hidden')" class="rounded-md bg-white px-4 py-2 font-semibold text-md float-right border border-gray-600 mt-6">Abbrechen</button>
                </div>
    

                </div>
              </div>
            </div>
          </div>
        </form>
@isset($bestellung)
<div class="relative z-10" id="bestellung-ubersicht-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6">
          <div class="h-12">
            <h1 class="text-2xl font-semibold float-left">Bestellübersicht <span class="text-gray-400 text-lg">@isset($selectedItem->name) ({{$selectedItem->name}}) @endisset</span></h1>
            <button type="button" onclick="document.getElementById('neues-produkt-leer-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 font-semibold text-white rounded-md text-md px-4 py-2 float-right">+ neue Bestellung</button>
          </div>
          <div class="pt-8">
            <table class="">
                <tr class="">
                    <th class="w-60">Produktname</th>
                    <th class="w-60">Bestellte Menge</th>
                    <th class="w-60">VPE</th>
                    <th class="w-60">URL</th>
                    <th class="w-60">Preis</th>
                    <th class="w-60">Zuletzt bestellt</th>
                </tr>
                @foreach ($bestellung as $item)
                    <tr>
                        <td>{{$inventar->where("id", $item->itemid)->first()->name}}</td>
                        <td>{{$item->menge}}</td>
                        <td>{{$inventar->where("id", $item->itemid)->first()->einheit}}</td>
                        <td class="text-blue-400"><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
                        <td>{{str_replace(",", ".", $inventar->where("id", $item->itemid)->first()->epreis)*$item->menge}} €</td>
                        <td>{{$item->updated_at->format("d.m.Y")}}
                          <a href="{{url("/")}}/crm/packtisch/tagesabschluss/bestellung-löschen-{{$item->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right text-red-600">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                          </a>
                        </td>
                    </tr>
                @endforeach
            </table>
          </div>
          <div class="pt-4">
            <button type="button" onclick="document.getElementById('bestellung-ubersicht-modal').classList.add('hidden')" class="bg-white rounded-md text-black font-semibold px-4 py-2 mt-4 float-right border border-gray-600">Zurück</button>
        </div>
        </div>
      </div>
    </div>
  </div>

  <div class="relative hidden z-10" id="neue-bestellung-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-96 sm:p-6">
           @isset($selectedItem->id)
           <form action="{{url("/")}}/crm/packtisch/inventar-neue-bestellung/{{$selectedItem->id}}" method="POST">
            @CSRF
            <h1 class="pb-4 text-md font-medium">Neue Bestellung</h1>
            <input type="text" name="url" class="w-full rounded-md text-md h-10 border border-gray-600" placeholder="URL">
            <input type="text" name="menge" class="w-full mt-4 rounded-md text-md h-10 border border-gray-600" placeholder="Menge">
            <button onclick="loadData();"  type="submit" class="bg-blue-600 hover:bg-blue-500 rounded-md text-white font-semibold px-4 py-2 mt-4 float-left">Hinzufügen</button>
            <button type="button" onclick="document.getElementById('neue-bestellung-modal').classList.add('hidden')" class="bg-white rounded-md text-black font-semibold px-4 py-2 mt-4 float-right border border-gray-600">Abbrechen</button>
        </form>               
           @endisset
        </div>
      </div>
    </div>
  </div>


@endisset


</body>
</html>