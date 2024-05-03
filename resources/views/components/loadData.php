<!-- Global notification live region, render this permanently at the end of the document -->
<div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-center px-4 py-6 sm:items-start sm:p-6  z-50 hidden" id="load-data-notification">
    <div class="flex w-full flex-col items-center space-y-4 sm:items-center">
      <!--
        Notification panel, dynamically insert this into the live region when it needs to be displayed
  
        Entering: "transform ease-out duration-300 transition"
          From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
          To: "translate-y-0 opacity-100 sm:translate-x-0"
        Leaving: "transition ease-in duration-100"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div id="load-data-notification-anim" class="animate__animated pointer-events-auto w-96 overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 " >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-blue-400 animate-spin" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>

             
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-xs font-medium text-gray-900 ">Daten werden geladen</p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
              <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" onclick="document.getElementById('load-data-notification').classList.toggle('hidden')">
                  <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>