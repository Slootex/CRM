<div class="relative hidden z-10" id="problem-melden-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8">
          @isset($device->component_number)
            <form action="{{url("/")}}/crm/packtisch/problem-melden/{{$device->process_id}}/{{$device->component_number}}" method="POST">
          @else
            @isset($barcode)
                <form action="{{url("/")}}/crm/packtisch/problem-melden/{{$barcode}}/{{$barcode}}" method="POST">
              @else
                @isset($intern)
                <form action="{{url("/")}}/crm/packtisch/problem-melden/{{$intern->process_id}}/{{$intern->component_number}}" method="POST">
                    @else
                    @isset($ausgänge[0])
                    <form action="{{url("/")}}/crm/packtisch/problem-melden/{{$ausgänge[0]->process_id}}/{{$ausgänge[0]->component_number}}" method="POST">
                      @else
                      @isset($kunde)
                      <form action="{{url("/")}}/crm/packtisch/problem-melden/{{$kunde->process_id}}/{{$kunde->process_id."-".$device[0]."-".$device[1]."-".$device[2]}}" method="POST">
                      @endisset
                    @endisset
                @endisset
            @endisset
          @endisset
          @CSRF
          <div class="sm:flex sm:items-start">

            <div class="mt-3 text-center sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Problem melden</h3>
              <div >
                <p class="text-sm text-gray-500 mb-2">Bitte das Problem kurz beschreiben. Was funktioniert nicht?</p>
                <hr class="py-2">
                <p class="text-sm text-gray-500">Text</p>
                <textarea name="text" id="" class="w-96 h-16 rounded-md border border-gray-400"></textarea>
              </div>
            </div>
          </div>
          <hr class="mt-4">
          <div class="mt-5 sm:mt-4 ">
            <button type="submit"  class="float-left justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-400 sm:w-auto">Speichern</button>
            <button type="button" onclick="document.getElementById('problem-melden-modal').classList.add('hidden')" class="mt-3 float-right justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Zurück</button>
          </div>
            </form>
        </div>
      </div>
    </div>
  </div>