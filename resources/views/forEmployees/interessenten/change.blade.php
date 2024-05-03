<div id="verlauf-erweitert">

</div>
<div id="custom-tracking-div">

</div>
<div id="custom-email-div-statuse" class="hidden">
  @include('includes.orders.custom-email-status')
</div>  
<div id="custom-email-div-auftrag" class="hidden">
  @include('includes.orders.custom-email-auftrag')
</div>  
<div id="custom-email-div-phone" class="hidden">
  @include('includes.orders.custom-email-phone')
</div>  
<div id="custom-email-div-dokumente" class="hidden">
  @include('includes.orders.custom-email-dokumente')
</div> 
<div class="relative z-20" id="auftrags-change" onkeydown="if(event.keyCode != 27) {detectedInput = true;}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-20 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
    <div class="w-full mt-10">
      <div id="hinweis"  class="relative @if($order->hinweis == null || $order->hinweis == "") hidden @endif m-auto overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 pb-6 z-10"  style="margin-right: 2rem; margin: auto;width: 95%;">
        <div class="px-4 py-3">
          <div >
            <div id="main-hinweis-div">
                  @include('forEmployees.orders.hinweis')
                  
              </div>
          </div>
        </div>
      </div>

      <div class="relative m-auto  transform overflow-hidden rounded-lg bg-white  text-left shadow-xl transition-all sm:my-8 pb-6" id="order-modal-child" style="width: 95%;">
          
<style>
    .h-11-5 {
        height: 2.95rem;
    }
</style>
<button class="float-right mt-8 mr-8 p-1 bg-red-600 rounded-md text-white font-semibold hover:bg-red-400" type="button" onclick="document.getElementById('auftrags-change').remove()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>
</button>

    <div class="mt-8">
        <div class="mx-auto w-full px-10 bg-white" >
          <div class="">
            <h1 class="text-black font-bold text-4xl mt-2">Interessentennummer {{$order->process_id}}</h1>
            <div class="flex mt-4">
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <p class=" text-gray-800 text-lg ml-2">@if($order->company_name != null)Firma: {{$order->company_name}},@endif {{$order->firstname}} {{$order->lastname}}</p>            
              
              </div>
              
              @if ($order->mobile_number != null || $order->phone_number != null)
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ml-6 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
                <p class=" text-gray-800 text-lg ml-2">{{$order->mobile_number ?: $order->phone_number}}</p>  
              </div>
              @endif
              
              @if ($order->activeOrdersCarData != null)
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ml-6 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <p class=" text-gray-800 text-lg ml-2">{{$order->activeOrdersCarData->car_company}} {{$order->activeOrdersCarData->car_model}}</p>    
              </div>    
              @endif    
  
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 ml-6 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <p class=" text-gray-800 text-lg ml-2" id="status-head-p">{{$order->statuse->sortByDesc("created_at")->first()->statuseMain->name}}</p>    
              </div>      
             
              @isset($nextCall)
                    @if ($nextCall->rückruf_time != null)
                    <div class="flex">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 ml-6 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      
                      
                      <p class="inline-block text-gray-800 text-lg ml-2">{{$nextCall->rückruf_time}}</p> 
                    </div>
                    @endif
              @endisset
            </div>


          </div>

        

            <div class="mt-10">
                <div class="hidden sm:block">
                  <div class="border-b border-t border-gray-200 h-11-5">
                    <nav class="-mb-px flex space-x-8 float-left mr-16" aria-label="Tabs">
                      <button id="Kundendaten-button" type="button" onclick="changeHeadTab('Kundendaten')" class="border-blue-300 text-blue-400 group inline-flex items-center border-b-2 border-t-2 py-3 px-1 text-sm font-medium" aria-current="page">
                        <svg id="Kundendaten-svg" class="text-blue-500 -ml-0.5 mr-2 h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                          <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                        <span>Kundendaten</span>
                      </button>

                      <button id="telefon-button" type="button" onclick="changeHeadTab('telefon')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">

                          <svg id="telefon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" hover:text-blue-500 -ml-0.5 mr-2 h-5 w-5">
                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                          </svg>
                          
                          
                        <span>Telefonhistorie</span>
                      </button>

                      <button id="status-button" type="button" onclick="changeHeadTab('status')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                          <svg id="status-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class=" hover:text-blue-500 -ml-0.5 mr-2 h-5 w-5">
                            <path fill-rule="evenodd" d="M10 2c-1.716 0-3.408.106-5.07.31C3.806 2.45 3 3.414 3 4.517V17.25a.75.75 0 001.075.676L10 15.082l5.925 2.844A.75.75 0 0017 17.25V4.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0010 2z" clip-rule="evenodd" />
                          </svg>
                          
                          
                        <span>Statuse</span>
                      </button>

                      <button id="dokumente-button" type="button" onclick="changeHeadTab('dokumente')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                          <svg id="dokumente-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" hover:text-blue-500 -ml-0.5 mr-2 h-5 w-5">
                            <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                          </svg>        
                        <span>Dokumente</span>
                      </button>
                    </nav>
                    @if ($order->archiv == true)
                      <a href="{{url("/")}}/crm/interessent-move-activeleads-{{$order->process_id}}" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 " style="margin-top: 0.3rem">zu Aktiven</a>
                    @else
                      <a href="{{url("/")}}/crm/interessent-move-archiv-{{$order->process_id}}" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 " style="margin-top: 0.3rem">zum Archiv</a>
                    @endif

                    <a href="{{url("/")}}/crm/interessent-move-active-{{$order->process_id}}" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 mr-6" style="margin-top: 0.3rem">zum Auftrag</a>

                    <button type="button" onclick="showHideHinweis()" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 mr-6 " style="margin-top: 0.3rem">wichtige Auftragsinformation</button>

                  </div>
                  
                </div>
              </div>
              
              <!-- Kundendaten -->
              <div id="Kundendaten" class="">
                @include('includes.kundenübersicht.body')
              </div>

              <!-- AUFTRAGSBODY -->

              <div id="Auftragsverlauf" class="hidden ">
                @include('includes.interessenten.verlauf')
              </div>

              
                
              </div>
                </div>
                </div>
              </div>
          </div>
  </div>
  <div class="hidden" id="esc-error-div">
    <div aria-live="assertive" class="pointer-events-none z-50 fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
      <div class="flex w-full flex-col items-center space-y-4 z-50 sm:items-end">
        <div class="pointer-events-auto w-full max-w-sm z-50 overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">Daten wurden verändert</p>
                <p class="mt-1 text-sm text-gray-500">Drücke nocheinmal ESC um ohne speichern zu verlassen</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
        </div>
        </div>
    </div>

</div>
</div>
</div>
</div>