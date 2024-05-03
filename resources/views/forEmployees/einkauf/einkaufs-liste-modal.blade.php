<div class="">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-1 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Pos</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Menge</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">ArtNr</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Bezeichnung</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">MwSt</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Nettobetrag</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">MwSt Betrag</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Rabatt</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Bruttobetrag</th>
                <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-0">
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @php
                  $positionCounter = 1;
                  $netto = 0;
                  $mwstbetrag = 0;
                  $rabatt = 0;
                  $brutto = 0;
              @endphp
              @foreach ($einkaufsListe as $item)
                  <tr>
                    <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$positionCounter}}</td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                      @if ($item->new == "true")
                        <input type="text" name="menge" value="{{$item->menge}}" id="einkauf-pos-menge-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->menge}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                      @if ($item->new == "true")
                        <input type="text" name="artnr" value="{{$item->artnr}}" id="einkauf-pos-artnr-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->artnr}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                      @if ($item->new == "true")
                        <input type="text" name="bezeichnung" value="{{$item->bezeichnung}}" id="einkauf-pos-bezeichnung-{{$item->id}}" class="block w-36 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->bezeichnung}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if ($item->new == "true")
                        <input type="text" name="mwst" value="{{$item->mwst}}" id="einkauf-pos-mwst-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->mwst}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if ($item->new == "true")
                        <input type="text" name="netto" value="{{$item->netto}}" id="einkauf-pos-netto-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->netto}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if ($item->new == "true")
                        <input type="text" name="mwstbetrag" value="{{$item->mwstbetrag}}" id="einkauf-pos-mwstbetrag-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->mwstbetrag}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if ($item->new == "true")
                        <input type="text" name="rabatt" value="{{$item->rabatt}}" id="einkauf-pos-rabatt-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->rabatt}}
                      @endif
                    </td>

                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if ($item->new == "true")
                        <input type="text" name="brutto" value="{{$item->brutto}}" id="einkauf-pos-brutto-{{$item->id}}" class="block w-16 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      @else
                        {{$item->brutto}}
                      @endif
                    </td>

                    <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">

                      @if ($item->new == "true")

                        <button type="button" onclick="submitPositionChange('{{$item->id}}')" class="float-left">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>                          
                        </button>

                      @else
                        <button type="button" onclick="showPositionChange('{{$item->id}}')" class="float-left">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:text-blue-400 float-left">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>  
                        </button>
                      @endif

                      <button type="button" onclick="deletePosition('{{$item->id}}')" class="float-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 hover:text-red-400 float-left">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>   
                      </button>                                      
                      
                    </td>
                  </tr>
                  @php
                      $positionCounter++;
                      try {
                        $netto += floatval(str_replace(",", ".", $item->netto));
                      } catch(Exception $e) {

                      }

                      try {
                        $mwstbetrag += floatval(str_replace(",", ".", $item->mwstbetrag));
                      } catch(Exception $e) {

                      }

                      try {
                        $rabatt += floatval(str_replace(",", ".", $item->rabatt));
                      } catch(Exception $e) {

                      }

                      try {
                        $brutto += floatval(str_replace(",", ".", $item->brutto));
                      } catch(Exception $e) {

                      }
                  @endphp
              @endforeach

              <tr>
                <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Gesamt</td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-1 text-sm @if($netto < 0) text-red-500 @else text-green-500 @endif">
                  {{$netto}}&#8364;
                </td>

                <td class="whitespace-nowrap px-3 py-1 text-sm @if($mwstbetrag < 0) text-red-500 @else text-green-500 @endif">
                  {{$mwstbetrag}}&#8364;
                </td>

                <td class="whitespace-nowrap px-3 py-1 text-sm @if($rabatt < 0) text-red-500 @else text-green-500 @endif">
                  {{$rabatt}}&#8364;
                </td>

                <td class="whitespace-nowrap px-3 py-1 text-sm @if($brutto < 0) text-red-500 @else text-green-500 @endif">
                  {{$brutto}}&#8364;
                </td>
                
                <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                           
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>