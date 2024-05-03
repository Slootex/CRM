

@if ($errors->any())
    @if ($errors->first() == "auftrag-gesperrt")
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="main-error">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: rem;">
            <div class="sm:flex sm:items-start">
    
              <div class="mt-3 text-center sm:mt-0 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Auftrag gesperrt!</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Was wurde dem Kunden mitgeteilt bzw. was hat der Kunde gesagt?</p>
                </div>
                <div>
                  <div>
                    <div class="mt-2">
                      <textarea rows="4" name="comment" id="comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nachricht"></textarea>
                    </div>
                  </div>
                </div>
              </div>
                </div>
              <div class="mt-5">
    
                <button type="button" onclick="document.getElementById('main-error').classList.add('hidden')" class=" rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  sm:text-sm float-left">Rückruf vereinbaren</button>
                <button type="button" onclick="document.getElementById('main-error').classList.add('hidden')" class=" rounded-md mr-4 shadow-sm bg-white text-black border px-4 py-2  border-gray-600 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm float-right font-medium">Abbrechen</button>
    
              </div>
          </div>
        </div>
      </div>
    </div>
    @else 
    
@if($errors->any())
<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="main-error">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 40rem;">
        <div class="sm:flex sm:items-start">


            <!-- Heroicon name: outline/exclamation-triangle -->
            @if ($errors->first() == "email-change")
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
            @else
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">

            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            @endif
            
          </div>
          @if ($errors->first() == "contact gelöscht")
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Kontakt gelöscht</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Kontakt wurde erfolgreich gelöscht</p>
            </div>
          </div>


              @else 


          @if ($errors->first() == "email-delete")
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Email Gelöscht</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Die Email wurde erfolgreich gelöscht</p>
            </div>
          </div>


          @else

          @if ($errors->first() == "email-change")
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Email bearbeitet</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Die Email wurde erfolgreich bearbeitet</p>
            </div>
          </div>


          @else

        


          @if ($errors->first() == "Address not Found")
            @if (session()->get("new-street") != "NOT_FOUND")
           
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Adresse nicht verifiziert</h3>
                <div class="mt-2 ">
                  <ul role="list" class="grid grid-cols-1 gap-60 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 bg-white">
                    <li class="col-span-1 flex flex-col divide-y divide-gray-200 border border-gray-200 rounded-lg bg-white text-center px-2 w-64">
                    
                      <div class=" py-2  ">
                        <input type="radio" class="float-left" name="address">

                        <h2 class="text-left text-xl font-semibold pt-1 px-6">Gesuchte Adresse:</h2>
                        <div class=" py-1 px-6">
                          <p class="text-gray-600 text-left py-1">{{ session()->get("verify-street") }}</p>
                          <p class="text-gray-600 text-left py-1">{{ session()->get("verify-zipcode-city") }}</p>
                          <p class="text-gray-600 text-left py-1">{{ session()->get("verify-country") }}</p>
                        </div>
                      </div>

                    </li>
                  
                    <li class="col-span-1 flex flex-col divide-y divide-gray-200 border border-gray-200 rounded-lg bg-white text-center px-2 w-64 ml-16">
                    
                      <div class=" py-2 ">
                        <input type="radio" class="float-left" name="address">

                        <h2 class="text-left text-xl font-semibold pt-1 px-6">Vorschlag:</h2>
                        <div class=" py-1 px-6">
                          <p class="text-gray-600 text-left py-1">{{ session()->get("new-street") }}</p>
                          <p class="text-gray-600 text-left py-1">{{ session()->get("new-zipcode-city") }}</p>
                          <p class="text-gray-600 text-left py-1">{{ session()->get("new-country") }}</p>
                        </div>
                      </div>

                    </li>
                  
                    <!-- More people... -->
                  </ul>
                
                </div>
              </div>

            @else

            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Adresse nicht gefunden</h3>
              <div class="mt-2 border rounded-md">
                Es konnte keine Adresse zu der Eingabe gefunden werden!
              </div>
            </div>
            @endif
         


          @else
        
         @if ($errors->first() != "entsorgung-beauftragt" && $errors->first() != "entsorgung-keine-geräte")
         <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
          <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Achtung Fehlermeldung!</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">{{$errors->first()}}</p>
          </div>
        </div>
         @endif
        
     
          
          @endif


         @endif
         
         @endif
         
         @endif
         

         
      
          
        
        </div>
        @if ($errors->first() != "auftrag-gesperrt")
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          @if(session()->get("new-street") != null)
            <button type="button" onclick="document.getElementById('main-error').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Speichern</button>
          @else
          <button type="button" onclick="document.getElementById('main-error').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Zurück</button>
          @endif
        </div>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endif
    @endif
@endif