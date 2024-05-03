<!--

    $args[0] = Errortyp
    $args[1] = Liste der Verfügbaren Geräte
    $args[2] = Gescannter Barcode

-->
<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
          <form action="{{url("/")}}/crm/packtisch/muttergerät-auswählen-einlagern" method="POST">
            @csrf
            <h1 class="text-2xl font-bold">Mutter Gerät auswählen</h1>
            <p class="text-md text-gray-500">Das Gerät aus wählen wofür das AT erstellt werden soll</p>

            <div class="py-2 mt-4">
              <select name="mother" class="rounded-md w-full">
                  @foreach ($args[1] as $device)
                      <option value="{{$device->component_number}}">{{$device->component_number}}</option>
                  @endforeach
              </select>
            </div>

            <input type="hidden" name="barcode" value="{{$args[2]}}">
  
            <div class="mt-6">
              <button class="w-full px-4 py-2 rounded-md text-white text-md font-medium bg-blue-600 hover:bg-blue-400">Auswählen</button>
            </div>  
          </form>
        </div>
      </div>
    </div>
  </div>