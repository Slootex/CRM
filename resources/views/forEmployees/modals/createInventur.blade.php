<form action="{{url("/")}}/crm/inventur/beauftragen" method="POST">
  @CSRF
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
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 40rem;">
        <div class="float-right mr-4 mt-4">
          <button onclick="document.getElementById('create-inventur').classList.add('hidden')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>         
        </div>
        <div>
         <h1 class="text-xl font-bold">Inventur erstellen</h1>
        </div>

        <div class="mt-6">
          <p class="inline-block">Letzte Inventur</p>
          <p class="pl-36 ml-3 inline-block">25.11.2023</p>
        </div>

        <div class="mt-6">
          <p class="float-left">Zusatzkommenter Packtisch</p>
          <textarea name="kommentar" id="" class="ml-16 inline-block w-72 h-12 rounded-md border-gray-600"></textarea>
        </div>
        
        <div class="mt-8">
          <button type="submit" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md text-white px-4 py-2">An Packtisch senden</button>
          <button type="button" onclick="document.getElementById('create-inventur').classList.add('hidden')" class="float-right bg-white rounded-md text-black border border-gray-600 px-4 py-2">Abbrechen</button>
        </div>

      </div>
    </div>
  </div>
</div>


</form>