<form action="{{url("/")}}/crm/status/set-reklamation-devices" method="POST">
    @CSRF
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:p-6" style="width: 60rem;">
                @php
                $deviceCounter = 0;
            @endphp
                        <h1 class="text-2xl font-semibold">Geräte auswählen</h1>
                        <p class="mt-1 text-gray-500 text-md">Bitte wähle die Geräte für die Reklamation aus.</p>
            @foreach ($devices as $device)
            @if ($deviceCounter == 4)
                <p></p>
            @endif
            <div>
    
    
                <button class="@if($deviceCounter != 0) ml-8 @endif mt-4 float-left" type="button" @if($device->reklamation != "true")  onclick="toggleReklamationSelectDevice('{{$device->component_number}}')"@endif>  
                    <div id="device-div-reklamation-select-{{$device->component_number}}" class="px-2 py-1 h-8 rounded-md border border-gray-300 text-gray-500 @if($device->reklamation != "true") hover:border-blue-400 hover:text-blue-400 @else hover:border-red-400 hover:text-red-400 @endif">
                        <p class="text-center float-left text-sm">{{$device->component_number}}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="reklamation-select-device-svg-{{$device->component_number}}" class="hidden w-5 h-5 float-right ml-1 mt-0.5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                          </svg>    
                    </div>
                </button>
                
            </div>
        
            @php
                $deviceCounter++;
            @endphp
            @endforeach
    
            <div class="w-full h-12 mt-10 float-left mb-4">
                <button type="submit" class="float-left mt-8 bg-blue-600 hover:bg-blue-400 rounded-md text-white font-medium px-4 py-2" type="submit">
                    Speichern
                </button>
        
                <button type="button" onclick="document.getElementById('reklamation-select-device').remove();" class="float-right mt-8 border border-gray-400 rounded-md font-medium px-4 py-2">
                    Zurück
                </button>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div id="reklamation-select-inputlist">
    
      </div>
      <input type="hidden" id="reklamation-select-status" name="status">
</form>