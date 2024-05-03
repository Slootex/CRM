
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
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-3/5  sm:p-6" style="height: 50rem;">
              <div class="float-right mr-4 mt-4">
                <button onclick="hide()">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>         
              </div>
              <div>
                <div class="mt-3 text-center sm:mt-5">
                  <div>
                  </div>
                  <div class="mt-2">
                  <div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-xl font-semibold text-gray-900">Zahlungen</h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">Drucken</button>
    </div>
  </div>
 @isset($bookings)
 <div class="-mx-4 mt-8 flex flex-col sm:-mx-6 md:mx-0">
  <table class="min-w-full divide-y divide-gray-300">
    <thead>
      <tr>
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">Datum</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">Zweck</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">Versand</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">Zahlung</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">Samstagszuschlag</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">MwSt</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">Nettobetrag</th>
        <th scope="col" class=" py-3.5 px-3 text-center text-sm font-semibold text-gray-900 sm:table-cell">MwSt-Betrag</th>
        <th scope="col" class="py-3.5 pl-3 pr-4 text-center text-sm font-semibold text-green-600 sm:pr-6 md:pr-0">Bruttobetrag</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($bookings as $booking)
      <tr class="border-b border-gray-200">
        
        <td class="py-4 pl-1 pr-4 text-left text-sm text-black sm:pr-6 md:pr-0">{{$booking->created_at->format("d.m.Y (H:i)")}}</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->purpose}}</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->shipping_type}}</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->payment_type}}</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->samstagszuschlag}}</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">19 %</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->netto}} €</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-black sm:pr-6 md:pr-0">{{$booking->mwst_betrag}} €</td>
          <td class="py-4 pl-3 pr-4 text-center text-sm text-green-600 sm:pr-6 md:pr-0">{{$booking->brutto}} €</td>

        </tr>
      @endforeach
      <tr>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        @isset($booking)
        <td class="text-green-600">{{$booking->latest()->first()->open_sum}} €</td>
        @endisset
      </tr>

      <!-- More projects... -->
    </tbody>
    
  </table>
</div>
@else
      <h1>Keine Buchungen verfügbar</h1>
 @endisset
</div>
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                <button type="button" onclick="hide()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function hide() {
          document.getElementById('booking-history').classList.add('hidden');
        }
      </script>
