
    <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
    
      <div class="fixed m-auto inset-0 z-10 overflow-y-auto " >
        <div class="flex  min-h-full items-end justify-center text-center sm:items-center sm:p-0" >
          <!--
            Modal panel, show/hide based on modal state.
    
            Entering: "ease-out duration-300"
              From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100 translate-y-0 sm:scale-100"
              To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          -->
          <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8  sm:w-3/5 ">
            <div>
              <div class="">
                <div>
                </div>
                <div>
                  <div class="w-full h-16 bg-gray-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9 text-blue-600 float-left mt-4 ml-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                      </svg>
                      <p class="mt-4 text-2xl text-blue-600 font-semibold float-left">{{$ausgang->shipping_type}} UPS Standard <a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums={{$ausgang->label}}&loc=de_de" class="text-blue-400 underline" target="_blank">{{$ausgang->label}}</a></p>
                        
                  </div>
                  <div class="w-96 h-60 bg-gray-100 border-2 mt-10 ml-10 float-left">
                      <div class="pl-4 pt-4">
                          <h1 class="text-blue-600 font-semibold">Absender</h1>
                          <p  class="text-blue-600 tracking-wider">GZA MOTORS</p>
                          <p  class="text-blue-600 tracking-wider">Herr Gazi Ahmad</p>
                          <p  class="text-blue-600 tracking-wider">Strausberger Platz 13</p>
                          <p  class="text-blue-600 tracking-wider">10243 Berlin</p>
                          <p  class="text-blue-600 tracking-wider">Deutschland</p>
                          <p  class="text-blue-600 tracking-wider">info@gzamotors.de</p>
                          <p  class="text-blue-600 tracking-wider">042159564922</p>
                      </div>
                  </div>

                  <div class="w-96 h-60 bg-gray-100 border-2 mt-10 mr-10 float-right">
                      <div class="pl-4 pt-4">
                          <h1 class="text-blue-600 font-semibold">Empfänger</h1>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->companyname}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->gender}} {{$ausgang->firstname}} {{$ausgang->firstname}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->street}} {{$ausgang->streetno}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->zipcode}} {{$ausgang->city}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->country}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->email}}</p>
                          <p  class="text-blue-600 tracking-wider">{{$ausgang->mobilnumber}} {{$ausgang->phonenumber}}</p>
                      </div>
                  </div>

                  <div class="ml-10 bg-gray-100 border-2" style="margin-top: 20rem; width: 65.8rem">
                      <div class="pl-4 pt-4 pb-4">
                          <a href="{{url('/')}}/temp/{{$ausgang->process_id . $ausgang->shortcut}}.png"  target="_blank" rel="noopener noreferrer"><div style="" class="float-right mr-4 w-11 h-11 bg-green-600 rounded-lg hover:bg-green-500">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9 text-white m-auto mt-1">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>                                  
                          </div></a>
                          <h1 class="text-blue-600 font-semibold text-2xl tracking-widest text-center">Verlauf</h1>

                          @isset($trackings)
                            @if ($trackings != "null")
                            @foreach ($trackings as $tracking)
                            @php
                                    $rawDate = $tracking->date;

                                    $year = substr($rawDate, 0, 4);

                                    $month = substr($rawDate, 4, 2);

                                    $day = substr($rawDate, 6, 2);


                                    $counter = 1;
                                    $length = count($trackings);
                            @endphp
                                <p class="text-center text-yellow-600 py-2">{{$day . ".". $month. ".". $year}} <span class="text-black">|</span> <span class="text-black">{{$tracking->status->description}}</span></p>
                                @if ($counter != $length)
                                <div class="m-auto" style="margin-left: -4rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 m-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                      </svg>                                      
                                </div>
                                @php
                                    $counter++;
                                @endphp
                                @endif
                                @endforeach
                                @endif

                            @endisset
                            
                          @isset($DBtrackings)
                          @foreach ($DBtrackings as $tracking)
                          @php
                                 

                                  $counter = 1;
                                  $length = count($DBtrackings);
                          @endphp
                              <p class="text-center text-yellow-600 py-2">{{$tracking->created_at->format("d.m.Y")}} <span class="text-black">|</span> <span class="text-black">{{$tracking->status}}</span></p>
                              @if ($counter != $length)
                              <div class="m-auto" style="margin-left: -4rem;">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 m-auto">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                    </svg>                                      
                              </div>
                              @php
                                  $counter++;
                              @endphp
                              @endif
                              @endforeach
                              @endisset
                      </div>
                  </div>
                  <div class="ml-10 bg-gray-100 border-2 mt-16" style=" width: 65.8rem">
                      <div class="pl-4 pt-4 pb-4">
                          <h1 class="text-blue-600 font-semibold text-2xl tracking-widest text-center">Versand-Informationen</h1>
                          <p class="text-yellow-600">Maße / Gewicht<span class="text-black">: {{$ausgang->length}}x{{$ausgang->width}}x{{$ausgang->height}} cm / {{$ausgang->weight}} kg</span></p>
                          <p class="text-yellow-600">Hinweis<span class="text-black">: {{$ausgang->info}}</span></p>
                          <p class="text-yellow-600">Versandart<span class="text-black">: {{$ausgang->shipping_type}} UPS Standard</span></p>

                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-16 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 mt-16 pb-4 pr-4">
              <button type="button" onclick="closeTracking()" class="inline-flex w-26 justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      function closeTracking() {
        document.getElementById('tracking').classList.add("hidden");
      }
    </script>
