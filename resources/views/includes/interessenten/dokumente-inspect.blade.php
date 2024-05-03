<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6"  style="height: 60rem">
          
            <div class="w-full">
                <iframe src="{{url("/")}}/files/aufträge/{{$process_id}}/{{$filename}}" frameborder="0" class="w-full h-full" style="height: 54rem"></iframe>
            </div>
            <div class="mt-4 w-full">
              <button type="button" onclick="document.getElementById('dokumente-inspect').innerHTML = ''" class="float-right px-4 py-2 rounded-md border border-gray-600 text-md font-medium">Zurück</button>
            </div>
         
        </div>
      </div>
    </div>
  </div>