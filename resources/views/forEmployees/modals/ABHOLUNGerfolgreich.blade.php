
    <div class="relative  z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
      
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto " style="width: 60rem;">
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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-3/5  sm:p-6" style="height: 40rem;">
              
              <div>
                <div class=" text-center ">
                  <div>
                  </div>
                  <div >
                    <div style="position: absolute;" class="ml-6 float-left">
                        
                          @if ($pickup->status == "511")
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 @if ($pickup->status != "511") text-green-600 @else text-red-600 @endif  @if ($pickup->status != "511") bg-green-100 @else bg-red-100 @endif rounded-full p-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          @else
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 @if ($pickup->status != "511") text-green-600 @else text-red-600 @endif  @if ($pickup->status != "511") bg-green-100 @else bg-red-100 @endif rounded-full p-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>
                          @endif
                          
                    </div>
                    <div class="">
                       <div class="pt-2 ">
                        @if ($pickup->status == "511")
                          <h1 class="text-center text-xl font-semibold text-red-600">Abholung gelöscht</h1>
                          @else
                          <h1 class="text-center text-xl font-semibold">Abholung beauftragt</h1>
                        @endif
                       </div>

                        <h2 class="text-lg font-normal mt-12 float-left" style="position: absolute">Erstelldatum</h2>
                        <h3 class="float-left ml-60 italic text-gray-700" style="margin-top: 3.25rem;">{{$pickup->created_at->format("d.m.Y (H:i)")}}</h3>

                        <h2 class="text-lg font-normal mt-20 float-left" style="position: absolute">Mitarbeiter</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->employee}}</h3>
                        
                        <h2 class="text-lg font-normal  float-left text-left" style="position: absolute; margin-top: 7.1rem">Referenznummer/Hinweis</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2 text-left">{{$pickup->refrence}}/{{$pickup->notice}}</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 9rem">Firma</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->companyname}}</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 11rem">Name</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->firstname}} {{$pickup->lastname}}</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 13rem">Adresse</h2>
                        <h3 class="float-left ml-60 italic text-blue-400 mt-2">{{$pickup->street}} {{$pickup->streetnumber}}</h3>
                        <h3 class="float-left ml-60 italic text-blue-400 mt-2">{{$pickup->zipcode}} {{$pickup->city}}</h3>
                        
                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 17rem">Email</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->email}}</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 19rem">Telefon</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">@if($pickup->mobilnumber != null) {{$pickup->mobilnumber}} @else {{$pickup->phonenumber}} @endif</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 21rem">Service</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">UPS Saver</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 23rem">Zahlart</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">Keine Zahlung benötigt</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 25rem">Transactionidentifier</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->id}}</h3>

                        <h2 class="text-lg font-normal  float-left" style="position: absolute; margin-top: 27rem">PRN</h2>
                        <h3 class="float-left ml-60 italic text-gray-700 mt-2">{{$pickup->prn}}</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div style="margin-top: 30rem;" class=" sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                <button type="button" onclick="test()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function test() {
          document.getElementById('pickupFinish').classList.add("hidden");
        }
      </script>
