<div class="relative">
    
  
    <!--
      Flyout menu, show/hide based on flyout menu state.
  
      Entering: "transition ease-out duration-200"
        From: "opacity-0 translate-y-1"
        To: "opacity-100 translate-y-0"
      Leaving: "transition ease-in duration-150"
        From: "opacity-100 translate-y-0"
        To: "opacity-0 translate-y-1"
    -->
    <div class="absolute left-1/2 z-10 mt-5 flex w-60 -translate-x-1/2 px-4">
      <div class="w-screen flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
        <div class="">
          <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50 px-4">
            <div class="mt-4 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600 group-hover:text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
              </svg>              
            </div>
            <div>
                <label for="location" class="block text-xs font-medium leading-6 text-gray-900">Status</label>
                <select id="location" name="location" class="text-xs h-8 block rounded-md border-0 w-24 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-xs ">
                  <option value="archive">Archive</option>
                  <option value="aktive">Aktiv</option>
                </select>
            </div>
          </div>
  
          <div class="group relative flex gap-x-6 rounded-lg px-4 hover:bg-gray-50 px-4">
            <div class="mt-4 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600 group-hover:text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                  </svg>
            </div>
            <div>
                <label for="location" class="block text-xs font-medium leading-6 text-gray-900">Menge</label>
                <select id="location" name="location" class="text-xs h-8 block rounded-md border-0 w-24 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-xs ">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
          </div>

          <div class="group relative flex gap-x-6 rounded-lg px-4 hover:bg-gray-50 px-4">
            <div class="mt-4 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-red-50 group-hover:bg-red-50 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-red-600 group-hover:text-red-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
            </div>
            <label for="location" onclick="windows.location.href" class="block text-xs font-medium leading-6 text-gray-900 ml-7 mt-1.5 text-red-700 underline italic">Löschen</label>
                          
            
        </div>

        <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50 mt-6">
          <a href="#" onclick="showActionMenu()" class="flex h-12 items-center justify-center  font-semibold text-gray-900 hover:bg-gray-100">
            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z" clip-rule="evenodd" />
            </svg>
            Zurück
          </a>
  
          <a href="#" class="flex  h-12 items-center justify-center  font-semibold text-gray-900 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 flex-none text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
              </svg>
            Absenden
          </a>
        </div>
      </div>
    </div>
  </div>