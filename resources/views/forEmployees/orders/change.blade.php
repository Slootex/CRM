
<div class="relative z-40" id="auftrags-change" onkeydown="if(event.keyCode != 27) {detectedInput = true;}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
  <div id="neue-audio-modal">
  </div>
  <div id="neue-rechnung-modal">
  </div>
  <div id="edit-rechnung-modal">
  </div>
  <div id="email-rechnung-modal">
  </div>
  <div id="zahlung-rechnung-modal">
  </div>
  <form id="save-kundendaten-form" action="{{url("/")}}/crm/change-kundendaten" method="POST">
    @CSRF
  <div id="stammdaten-modal">
  </div>
  </form>
  <div id="delete-rechnung-modal" class="hidden">
    @include('includes.rechnungen.rechnung-delete')
  </div>
  <div class="relative z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="number-error">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left -xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
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
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div class="fixed inset-0 z-40 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div id="hinweis"  class="relative @if($order->hinweis == null || $order->hinweis == "") hidden @endif m-auto overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 pb-6 z-10"  style="margin-right: 2rem; margin: auto;width: 95%;">
          <div class="px-4 py-3">
            <div >
              <div id="main-hinweis-div">
                    @include('forEmployees.orders.hinweis')
                    
                </div>
            </div>
          </div>
        </div>
      <div class="relative m-auto  transform rounded-lg bg-white  text-left shadow-xl transition-all sm:my-8 pb-6 pt-1" id="order-modal-child" style="width: 95%;">
          
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

    <div class="mt-4">
        <div class="mx-auto w-full px-10 bg-white" >
          <div >
            <div class="flex">
              <h1 class="text-gray-800 font-bold text-4xl mt-2">Auftragsnummer {{$order->process_id}}</h1>           
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 ml-4 text-green-600 mt-4">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.902 7.098a3.75 3.75 0 0 1 3.903-.884.75.75 0 1 0 .498-1.415A5.25 5.25 0 0 0 8.005 9.75H7.5a.75.75 0 0 0 0 1.5h.054a5.281 5.281 0 0 0 0 1.5H7.5a.75.75 0 0 0 0 1.5h.505a5.25 5.25 0 0 0 6.494 2.701.75.75 0 1 0-.498-1.415 3.75 3.75 0 0 1-4.252-1.286h3.001a.75.75 0 0 0 0-1.5H9.075a3.77 3.77 0 0 1 0-1.5h3.675a.75.75 0 0 0 0-1.5h-3c.105-.14.221-.274.348-.402Z" clip-rule="evenodd" />
              </svg>               
            </div>
            <div class="flex mt-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
              <p class=" text-black text-lg ml-2">@if($order->company_name != null)Firma: {{$order->company_name}},@endif {{$order->firstname}} {{$order->lastname}}</p>            
          
            @if ($order->mobile_number != null || $order->phone_number != null)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ml-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>
            <p class=" text-black text-lg ml-2">{{$order->mobile_number ?: $order->phone_number}}</p>     
            @endif
            @isset ($order->activeOrdersCarData->car_company)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ml-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <p class=" text-black text-lg ml-2">{{$order->activeOrdersCarData->car_company}} {{$order->activeOrdersCarData->car_model}}</p>        
            @endisset    

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 ml-6 mt-0.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <p id="status-head-p" class=" text-black text-lg ml-2">{{$order->statuse->sortByDesc("created_at")->first()->statuseMain->name}}</p>        
            </div>
           


          </div>
<!-- Warning Modal -->
<div class="fixed inset-0 flex items-center justify-center z-50 hidden shadow-lg" id="warning-modal">
  <div class="bg-white rounded-lg p-8">
    <h2 class="text-xl font-bold mb-4">Hinweis löschen</h2>
    <p class="text-gray-800">Wollen Sie sicher den Hinweis löschen?</p>
    <div class="flex justify-end mt-6">
      <button class="px-4 py-2 bg-red-600 text-white rounded-md mr-2" onclick="continueAction()">Löschen</button>
      <button class="px-4 py-2 bg-white text-black border border-gray-400 rounded-md" onclick="hideWarningModal()">Zurück</button>
    </div>
  </div>
</div>

<script>
  function showWarningModal() {
    document.getElementById('warning-modal').classList.remove("hidden");
  }

  function hideWarningModal() {
    document.getElementById('warning-modal').classList.add("hidden");
  }

  function continueAction() {
    deleteHinweis();
    hideWarningModal();
  }
</script>



          <div class="w-full flex ">
            <div class="w-full" id="devicelist">
                @isset($deviceCount)
                <div class="bg-white rounded-md mt-4 h-full pb-4" >
                  <div class="px-4 sm:px-6 lg:px-8 h-full">
                      <div class=" flow-root h-full">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 h-full">
                          <div class="inline-block min-w-full align-middle h-full border border-gray-300 rounded-md ">
                            <table class="min-w-full divide-y divide-gray-300 ">
                              <thead>
                                <tr>
                                  <th scope="col" class="py-3 pl-4 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class=" py-3 text-left text-sm font-semibold text-gray-900"></th>
                                  <th scope="col" class="py-3 pr-4 text-right text-sm font-semibold text-gray-900"></th>
                                </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200">

                              @for ($i = 0; $i < $deviceCount; $i++)
                                  <tr>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                    <td class="py-4"></td>
                                  </tr>
                              @endfor
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                @endisset
            </div >
            
          </div>

          <div id="versand-kunde-address-check">

          </div>
          

            <div class="mt-4">
                <div class="hidden sm:block">
                  <div class="border-b border-t border-gray-200 h-11-5">
                    <nav class="-mb-px flex space-x-8 float-left mr-16" aria-label="Tabs">
                      <button id="Kundendaten-button" type="button" onclick="changeHeadTab('Kundendaten')" class="border-blue-300 text-blue-400 group inline-flex items-center border-b-2 border-t-2 py-3 px-1 text-sm font-medium" aria-current="page">
                        <svg id="Kundendaten-svg" class="text-blue-500 -ml-0.5 mr-2 h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                          <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                        <span>Kundendaten</span>
                      </button>

                      <button id="historie-auftrag-button" type="button" onclick="changeHeadTab('historie-auftrag')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                          <svg id="historie-auftrag-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" hover:text-blue-500 -ml-0.5 mr-2 h-5 w-5">
                            <path fill-rule="evenodd" d="M.99 5.24A2.25 2.25 0 013.25 3h13.5A2.25 2.25 0 0119 5.25l.01 9.5A2.25 2.25 0 0116.76 17H3.26A2.267 2.267 0 011 14.74l-.01-9.5zm8.26 9.52v-.625a.75.75 0 00-.75-.75H3.25a.75.75 0 00-.75.75v.615c0 .414.336.75.75.75h5.373a.75.75 0 00.627-.74zm1.5 0a.75.75 0 00.627.74h5.373a.75.75 0 00.75-.75v-.615a.75.75 0 00-.75-.75H11.5a.75.75 0 00-.75.75v.625zm6.75-3.63v-.625a.75.75 0 00-.75-.75H11.5a.75.75 0 00-.75.75v.625c0 .414.336.75.75.75h5.25a.75.75 0 00.75-.75zm-8.25 0v-.625a.75.75 0 00-.75-.75H3.25a.75.75 0 00-.75.75v.625c0 .414.336.75.75.75H8.5a.75.75 0 00.75-.75zM17.5 7.5v-.625a.75.75 0 00-.75-.75H11.5a.75.75 0 00-.75.75V7.5c0 .414.336.75.75.75h5.25a.75.75 0 00.75-.75zm-8.25 0v-.625a.75.75 0 00-.75-.75H3.25a.75.75 0 00-.75.75V7.5c0 .414.336.75.75.75H8.5a.75.75 0 00.75-.75z" clip-rule="evenodd" />
                          </svg>
                        <span>Auftragshistorie</span>
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

                      <button id="Auftragsbody-Packtisch-button" type="button" onclick="changeHeadTab('Auftragsbody-Packtisch')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                          <svg id="Auftragsbody-Packtisch-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" hover:text-blue-500 -ml-0.5 mr-2 h-5 w-5">
                            <path fill-rule="evenodd" d="M1.045 6.954a2.75 2.75 0 01.217-.678L2.53 3.58A2.75 2.75 0 015.019 2h9.962a2.75 2.75 0 012.488 1.58l1.27 2.696c.101.216.174.444.216.678A1 1 0 0119 7.25v1.5a2.75 2.75 0 01-2.75 2.75H3.75A2.75 2.75 0 011 8.75v-1.5a1 1 0 01.045-.296zm2.843-2.736A1.25 1.25 0 015.02 3.5h9.962c.484 0 .925.28 1.13.718l.957 2.032H14a1 1 0 00-.86.49l-.606 1.02a1 1 0 01-.86.49H8.236a1 1 0 01-.894-.553l-.448-.894A1 1 0 006 6.25H2.932l.956-2.032z" clip-rule="evenodd" />
                            <path d="M1 14a1 1 0 011-1h4a1 1 0 01.894.553l.448.894a1 1 0 00.894.553h3.438a1 1 0 00.86-.49l.606-1.02A1 1 0 0114 13h4a1 1 0 011 1v2a2 2 0 01-2 2H3a2 2 0 01-2-2v-2z" />
                          </svg>
                          
                          
                          
                        <span>Packtisch</span>
                      </button>

                      <button id="Buchhaltung-button" type="button" onclick="changeHeadTab('Buchhaltung')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                        <svg id="Buchhaltung-svg" class="  -ml-0.5 mr-2 h-5 w-5 hover:text-blue-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 1c-1.716 0-3.408.106-5.07.31C3.806 1.45 3 2.414 3 3.517V16.75A2.25 2.25 0 005.25 19h9.5A2.25 2.25 0 0017 16.75V3.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0010 1zM5.99 8.75A.75.75 0 016.74 8h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm1.417-5.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm1.42-5.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zM12.5 8.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm0 2.166a.75.75 0 01.75.75v2.167a.75.75 0 11-1.5 0v-2.167a.75.75 0 01.75-.75zM6.75 4a.75.75 0 00-.75.75v.5c0 .414.336.75.75.75h6.5a.75.75 0 00.75-.75v-.5a.75.75 0 00-.75-.75h-6.5z" clip-rule="evenodd" />
                        </svg>                        
                        <span>Buchhaltung</span>
                      </button>

                      <button id="workflow-manager-button" type="button" onclick="changeHeadTab('workflow-manager')" class="border-transparent text-black hover:border-blue-300 hover:text-blue-500 group inline-flex items-center border-b-2 py-3 px-1 text-sm font-medium">
                        <svg id="workflow-manager-svg" class="  -ml-0.5 mr-2 h-5 w-5 hover:text-blue-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" >
                          <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z" clip-rule="evenodd" />
                        </svg>
                        
                        
                        <span>Workflow</span>
                      </button>
                      
                    </nav>



                    <div class="">
                      @if ($order->archiv == true)
                        <a href="{{url("/")}}/crm/auftrag-move-active-{{$order->process_id}}" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 " style="margin-top: 0.3rem">zu Aktiven</a>
                      @else
                        <button onclick="document.getElementById('check-password-moveToOrdersArchive').classList.remove('hidden')" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 " style="margin-top: 0.3rem">zum Archiv</button>
                      @endif

                      <a href="{{url("/")}}/crm/interessent-move-leads-{{$order->process_id}}" class="float-right mr-6 bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 " style="margin-top: 0.3rem">zu Interessenten</a>
                      <button type="button" onclick="showHideHinweis(); ; document.getElementById('main-hinweis-div').classList.remove('hidden')" class="float-right bg-blue-600 hover:bg-blue-500 rounded-sm text-white text-sm font-medium px-4 py-1.5 mr-6 " style="margin-top: 0.3rem">wichtige Auftragsinformation</button>

                      </div>
                  </div>
                  
                </div>
              </div>

              <input type="hidden" id="process_id" value="{{$order->process_id}}">

           

              <!-- Kundendaten -->
              <div id="Kundendaten" class="mt-8">
                @include('includes.kundenübersicht.body')
              </div>
              <div id="Buchhaltung" class="hidden px-4">
              </div>
              <!-- AUFTRAGSBODY -->
                <div id="Auftragsverlauf" class="hidden">
                  
                  
                </div>

                <div id="workflow-manager" class="hidden">
                  
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
    <div class="relative hidden z-50" id="check-password-moveToOrdersArchive" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
           <p>Bitte mit Passwort eingabe bestätigen</p>
            <div class="mt-4">
            <input type="password" class="w-full px-4 py-2 rounded-md border border-gray-300" placeholder="Passwort">
           </div>
           <div class="mt-4">
              <button type="button" onclick="moveToOrdersArchive('{{$order->process_id}}')" class="bg-blue-600 hover:bg-blue-400 rounded-md font-medium px-4 py-2 text-white mt-4 float-left">Bestätigen</button>
              <button type="button" onclick="document.getElementById('check-password-moveToOrdersArchive').classList.add('hidden')" class="border border-gray-400 rounded-md text-black font-medium px-4 py-2 float-right mt-4">Zurück</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <script>
      function moveToOrdersArchive(id) {
        loadData();
        let password = document.querySelector("#check-password-moveToOrdersArchive input").value;

        $.get("{{url('/')}}/crm/check/secret-"+password, function(data, status){
          if(data == "ok") {
            window.location.href = "{{url('/')}}/crm/auftrag-move-archiv-"+id;
          } else {
            newErrorAlert("Fehler", "Passwor wurde falsch eingeben");
          }
          savedPOST();
        });
      }

      function getStammdaten(id) {
        loadData();
        $.get("{{url('/')}}/crm/get/stammdaten-"+id, function(data, status){
          document.getElementById("stammdaten-modal").innerHTML = data;
          $('#save-kundendaten-form').ajaxForm(function(data) { 
            document.getElementById("stammdaten-modal").innerHTML = data;
            $.get("{{url("/")}}/crm/auftrag/kundendaten-"+id, function(data) {
              document.getElementById("Kundendaten").innerHTML = data;
              savedPOST();
            });
            savedPOST(); 
          });
          savedPOST();
        });
      }

      function toggleDatenAbweichendeAddresse(id) {
                   
                   toggleAbweichendeAddresseDaten();
   
                   $.get("{{url('/')}}/crm/kundendaten-lieferaddresse-toggle-"+id, function(data) {
                       
                   });
   
               }
               function toggleAbweichendeAddresseDaten() {
                        document.getElementById("alt_adr").classList.toggle("hidden");
                        
                }
                function toggleSperre(id) {

if(document.getElementById("sperre-button").classList.contains("bg-red-600")) {
  document.getElementById("sperre-button").classList.add("bg-green-600", "hover:bg-green-400");
  document.getElementById("sperre-button").classList.remove("bg-red-600", "hover:bg-red-400");

  
  document.getElementById("sperre-button").innerHTML = "Sperre aufheben";

  document.getElementById('sperre-modal').classList.remove('hidden');

  document.getElementById('bg-red').classList.remove('bg-white');
  document.getElementById('bg-red').classList.add('bg-red-200');
  document.getElementById("sperre-modal").classList.remove("hidden");
} else {
  document.getElementById("sperre-button").classList.remove("bg-green-600", "hover:bg-green-400");
  document.getElementById("sperre-button").classList.add("bg-red-600", "hover:bg-red-400");


  document.getElementById("sperre-button").innerHTML = "Kunde Sperren";
  document.getElementById('sperre-modal').classList.add('hidden');
  document.getElementById('bg-red').classList.add('bg-white');
  document.getElementById('bg-red').classList.remove('bg-red-200');
  document.getElementById("sperre-modal").classList.add("hidden");


}

$.get("{{url("/")}}/crm/kundendaten-kunde-sperren-"+id, function(data) {

 

});

}
    </script>
  </div>

    
