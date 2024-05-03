<div class="relative z-10" id="trackinghistory-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 85rem">
          <button type="button"  onclick="document.getElementById('trackinghistory-modal').classList.add('hidden')" class="px-2 py-2 rounded-md float-right bg-red-600 hover:bg-red-400"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <img src="{{url("/")}}/temp/{{$wt->label}}.png" style="transform: rotate(90deg)" class="hidden" id="label-img" alt="">

          <div>
            <h1 class="text-2xl pl-4">Details zum Auftrag <button type="button" onclick="showOrderChangeModal('{{$versandartikel[0]->process_id}}')" class="text-blue-400 hover:text-blue-300 underline cursor-pointer">{{$wt->process_id}}</button></h1>
            
          </div>
        <div class="float-left" style="width: 60%">
          <div>
            <div class="w-full h-16 pl-4 mt-8">
              <button type="button" onclick="printJS('label-img', 'html');" class="bg-green-600 hover:bg-green-400 rounded-md text-white text-xl font-semibold px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 float-left mt-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                <p class="float-right  ml-1 mt-1.5">Versandschein erneut drucken</p>
              </button>
            </div>
          </div>
          <div class="pl-4 mt-4">
            <div class="grid grid-cols-3 gap-2">
              <div class="col-span-2">
                <p class="font-semibold text-lg">Absender</p>
                <input type="text" disabled class="h-12 w-full text-center border border-gray-300 text-gray-500 rounded-md" value="Gazi Ahmad, Strausbergerplatz 13, 10243 Berlin">
              </div>
            </div>
          </div>
          <div class="pl-4 mt-4">
            <div class="grid grid-cols-3  gap-2">
              <div class="col-span-2">
                <p class="font-semibold text-lg">Empfänger</p>
              <input type="text" disabled class="text-center h-12 w-full border border-gray-300 text-gray-500 rounded-md" value="{{$wt->firstname." ".$wt->lastname}}, {{$wt->street." ".$wt->streetno}}, {{$wt->zipcode}} {{$wt->city}}">
              </div>
            </div>
          </div>
          <div class="mt-4">
            <p class=" text-lg mb-2 ml-4">Versandartikel</p>
            <div class="grid grid-cols-3 gap-2">
              @foreach ($versandartikel as $artikel)
                <div class="px-2 py-1 rounded-md border border-gray-300 text-center  ml-4">
                  <p class="text-center text-gray-400">{{$artikel->component_number}}</p>
                  <p class="text-center text-gray-400">@isset($versandartikel[0]->seal) (Siegel:@if($siegel->where("component_number", $artikel->component_number)->first() != null) {{$siegel->where("component_number", $artikel->component_number)->first()->code}}@else Unbekannt @endif) @endisset</p>
                </div>
              @endforeach
            </div>
          </div>
          
          <div class="mt-4 ">
            <p class=" text-lg mb-2 ml-4">Zusatzartikel</p>
            <div class="grid grid-cols-3 gap-2">
              @isset($versandartikel[0]->gummi)
                <div class="px-2 py-1 rounded-md border border-gray-300 text-center ml-4">
                  <p class="text-center text-gray-400">Gummibärchen</p>
                </div>
              @endisset
              @isset($versandartikel[0]->seal)
                <div class="px-2 py-1 rounded-md border border-gray-300 text-center ml-4">
                    <p class="text-center text-gray-400">Versiegeln</p>
                </div>
              @endisset
              @isset($versandartikel[0]->prot)
                <div class="px-2 py-1 rounded-md border border-gray-300 text-center ml-4">
                    <p class="text-center text-gray-400">Überspannungsschutz</p>
                </div>
              @endisset
          </div>
          </div>

          @if (isset($versandartikel[0]->bpz1) || isset($versandartikel[0]->bpz2))
          
          <div class="mt-4">
            <p class=" text-lg mb-2 ml-4">Beipackzettel</p>
               <div class="grid grid-cols-3 gap-2">
                  @isset($versandartikel[0]->bpz1)
                    <div class="px-2 py-1 rounded-md border border-gray-300 text-center ml-4">
                      <p class="text-center text-black overflow-hidden truncate">{{$versandartikel[0]->bpz1}}</p>
                    </div>
                  @endisset
                  @isset($versandartikel[0]->bpz2)
                    <div class="px-2 py-1 rounded-md border border-gray-300 text-center ml-4">
                      <p class="text-center text-black overflow-hidden truncate">{{$versandartikel[0]->bpz2}}</p>
                    </div>
                  @endisset
               </div>

          </div>
          @endif

          @isset ($files[0])
          <div class=" mt-4">
            <p class=" text-lg mb-2 ml-4">Zusatzdokumente</p>
                <div class="grid grid-cols-3 gap-2">
                  @foreach ($files as $file)
                    <a href="{{url("/")}}/files/aufträge/{{$file->process_id}}/{{$file->filename}}" target="_blank" class="ml-4 max-w-full flex px-2 py-1 overflow-hidden truncate hover:text-blue-400 hover:border-blue-400 rounded-md border border-blue-600">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="m-auto w-6 h-6 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                      </svg>
                      <p class="">
                        {{$file->filename}}
                      </p>
                    </a>
                  @endforeach
                </div>
          </div>
          @endisset

          @isset($versandartikel[0]->fotoauftrag)
          <div class="mt-4">
            <p class="text-lg mb-2 ml-4">Fotoauftrag</p>
            <div class="grid grid-cols-3 gap-2">
            @foreach ($versandartikel as $at)
            @if ($at->fotoauftrag == "on")

              <div>
                <a href="{{url("/")}}/files/aufträge/{{$at->process_id}}/{{$at->component_number}}-g.pdf" target="_blank" class="flex px-2 py-1 rounded-md border border-green-600 hover:border-green-400 hover:text-green-400 text-green-600 text-center ml-4">
                  <p class="text-center m-auto">{{$at->component_number}}</p>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 m-auto  ml-0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                  </svg>                    
                </a>
              </div>
            @else   

              <div class="flex px-2 py-1 rounded-md border border-red-600 text-center ml-4">
                <p class="flex">
                  <p class="text-center text-red-600 m-auto">{{$at->component_number}}</p>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 m-auto text-red-600 ml-0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                  </svg>                    
                </p>
              </div>
            @endif
            @endforeach
          </div>
          </div>

          @endisset

          @isset($versandartikel[0]->info)
          <div class="mt-4">
            <p class=" text-lg mb-2 ml-4">Packtisch Kommentar</p>
                <div class="grid grid-cols-3 gap-2">
                  <div class="px-2 py-1 rounded-md border border-gray-300 col-span-2 ml-4">
                    <p class="text-left text-black">
                      {{$versandartikel[0]->info}}
                    </p>
                    <br>
                    <br>
                  </div>
                </div>
          </div>
          @endisset

          <div class="mt-4">
            <p class=" text-lg mb-2 ml-4 font-semibold">Verpackt von</p>
                <div class="grid grid-cols-3 gap-2">
                  <div class="px-2 py-1 col-span-2 rounded-md border border-gray-300 ml-4">
                    <p class="text-center text-black">
                      {{$users->where("id", $versandartikel[0]->employee)->first()->username}} <span class="">am</span> {{$versandartikel[0]->created_at->format("d.m.Y (H:i)")}}
                    </p>
                  </div>
                </div>
          </div>

          <div class="mt-16 grid grid-cols-3 gap-2">
            <a href="#" onclick="warenausgangBack('{{$versandartikel[0]->label}}')" class="hover:bg-red-400 px-4 py-2 rounded-md text-md font-medium text-white bg-red-600 text-center ml-4">Warenausgang rückgängig</a>
            <a href="#" onclick="deleteLabelWarenausgang('{{$versandartikel[0]->label}}')" class="hover:bg-red-400 px-4 py-2 rounded-md text-md font-medium text-white bg-red-600 text-center ml-4">Versandschein löschen</a>

          </div>
</div>
          <div class="float-left ">
            <ul role="list" class="space-y-6">

              
              <li class="relative flex gap-x-4">
                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                  <div class="w-px bg-gray-200"></div>
                </div>
                <div class="relative flex h-8 w-8 flex-none items-center justify-center bg-white -ml-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                  </svg>
                  </div>
                <p class="flex-auto py-0.5 text-xl leading-5 text-blue-600"><span class="font-semibold">UPS Standard</p>
              </li>


              <li class="relative flex gap-x-4">
                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                  <div class="w-px bg-gray-200"></div>
                </div>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                  <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                </div>
                <p class="flex-auto py-0.5 text-md leading-5 text-gray-500"><span class="font-medium text-gray-900">Sendungsverlauf</span></p>
              </li>

              <li class="relative flex gap-x-4">
                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                  <div class="w-px bg-gray-200"></div>
                </div>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                  <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                </div>
                <a href="https://www.ups.com/track?track=yes&trackNums={{$versandartikel[0]->label}}&loc=de_de&requester=ST/trackdetails" target="_blank" class="flex-auto py-0.5 text-md leading-5 text-gray-500"><span class="font-normal text-gray-900">Sendungsnummer <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200 ml-2">
                  <svg class="h-1.5 w-1.5 fill-blue-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  {{$versandartikel[0]->label}}
                </span></span></a>
              </li>
              @php
                  $trackingStatuses = array();
              @endphp
              @foreach ($trackinghistory as $hs)
              @if (!in_array($hs->status, $trackingStatuses))
              <li class="relative flex gap-x-4">
                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                  <div class="w-px bg-gray-200"></div>
                </div>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                  <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                </div>
                <p class="flex-auto py-0.5 text-md leading-5 text-gray-500"><span class="font-medium text-gray-900">{{$hs->created_at->format('d.m.Y')}}</span> {{$hs->status}}</p>
              </li>
              @php
                  array_push($trackingStatuses, $hs->status);
              @endphp
              @endif
              @endforeach
            </ul>
          </div>
        </div>
        
      </div>
    </div>
  </div>
