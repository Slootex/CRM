
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-green-500 bg-green-100 rounded-full p-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>
                    </div>
                    <div>
                      <h1>Auftrag zusammenfassen</h1>

                      @php
                          $checkedShortcuts = array();
                      @endphp

                      @foreach ($technikerCollection as $tc)
                          @if (!in_array($tc->shortcut, $checkedShortcuts))
                          <h1>Techniker: {{$tc->shortcut}}</h1>
                              @foreach ($technikerCollection->where("shortcut", $tc->shortcut) as $technikerAuftrag)
                                  <h2>{{$tc->process_id}}</h2>
                              @endforeach
                            @php
                                array_push($checkedShortcuts, $tc->shortcut);
                            @endphp
                          @endif
                      @endforeach

                      <p class="py-6">=============</p>
                      <form action="{{url('/')}}/crm/techniker/zusammenfassen" method="POST">
                        @CSRF
                        <p>Zu welchem Techniker zusammenfassen?</p>
                        <select id="location" name="techniker" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                          @foreach ($technikerShortcuts as $shortcut)
                              <option value="{{$shortcut}}">{{$shortcut}}</option>
                          @endforeach
                        </select>
                        @foreach ($technikerShortcuts as $shortcut)
                            <input type="hidden" name="{{$shortcut}}" value="{{$shortcut}}">
                        @endforeach

                        <button type="submit">Zusammenfassen</button>
                      </form>


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
          document.getElementById('zusammenfassenBearbeiten').classList.add("hidden");
        }
      </script>
