
    <div class="relative  z-10 hidden  " id="email-signatur" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
          <div class="flex  min-h-full items-end justify-center p-8 text-center sm:items-center sm:p-0" >
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style=" width: 60rem;">
              <a href="#"><p onclick="document.getElementById('email-signatur').classList.add('hidden')" class="float-right text-xl text-white bg-red-600 rounded-md px-1  py-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
              </p></a>
              

              <div class="px-6">
                <h1 class="text-xl font-semibold">Email Signatur bearbeiten</h1>
               </div>
 
            
               
               <div class="pt-6 px-6 float-left">
                 <textarea name="body" id="testt" class="">{{auth()->user()->signatur}}</textarea>
 
 
               </div>
                
               <div class="px-6 pt-7 float-left w-full">
                 <button type="button" id="submitText" onclick="submitTEXT()" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white px-6 text-center">Speichern <svg id="loadingSig" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden text-white float-right ml-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                </button>
                 <button type="button" onclick="document.getElementById('email-signatur').classList.add('hidden')" class="float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
             </div>
            
          </div>
          <script>

            function submitTEXT() {

              document.getElementById("loadingSig").classList.toggle("hidden");
              document.getElementById("submitText").classList.toggle("bg-blue-600 hover:bg-blue-500");
              document.getElementById("submitText").classList.toggle("bg-red-600");

            var meta = document.createElement('meta');
            meta.httpEquiv = "csrf-token";
            meta.content = "{{ session()->token() }}";
            document.getElementsByTagName('head')[0].appendChild(meta);

            
              $.post( "{{url("/")}}/crm/einstellungen/signatur", {
              body: $('#testt').trumbowyg('html'),
              '_token': $('meta[name=csrf-token]').attr('content'),
              } , function( data ) {
                document.getElementById("loadingSig").classList.toggle("hidden");
                document.getElementById("submitText").classList.toggle("bg-red-600")
                document.getElementById("submitText").classList.toggle("bg-blue-600 hover:bg-blue-500");
                savedPOST();
              });  
            
            }

            $.trumbowyg.svgPath = '/icons.svg';
            $('#testt').trumbowyg();


</script>
<style>
  .trumbowyg-box {
    width: 100%;
    border: none;
  }
  .trumbowyg-button-pane {
    float: left

  }
  .trumbowyg-button-group {
    float: left
  }
  .trumbowyg-editor {
    border: solid rgb(168, 168, 168) 1px;
  }
</style>
        </div>
      </div>
      
      <script>

      </script>
    </div>
