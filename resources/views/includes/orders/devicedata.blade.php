<script>
    lastRandId = "{{$randid}}";
</script>
<div class="bg-white px-4 shadow-md  sm:rounded-md m-auto mt-8" style="height: 17.5rem; width: 75rem;" id="devicedata-{{$randid}}">
    <div class="float-right cursor-pointer text-red-600 hover:text-red-400 pt-2 pr-2" id="delete-device-button-{{$randid}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
          
    </div>
    <div class="absolute pt-2">
      <h2 class="text-black pt-3 pl-3 text-xl font-semibold" id="device-count-{{$randid}}">Gerätedaten</h2>
    </div>
    
    <div class="ml-60 pl-.5 pt-7">
      <div class="grid grid-cols-3 gap-2">
        <div>
          <label for="location" class="block text-md font-medium leading-6 text-gray-900">Bauteil</label>
          <select id="location" name="broken_component-{{$randid}}" class="mt-2 block w-80 h-11 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-md sm:leading-6">
            <option value="1" selected>Unbekanntes-Steuergerät</option>
            @foreach ($components->sortBy("name") as $comp)
                @if ($comp->id != 1)
                <option value="{{$comp->id}}">{{$comp->name}}</option>
                @endif
            @endforeach
          </select>
        </div>
        <div class="relative ml-6 mt-8">
          <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Hersteller</label>
          <input type="text" name="device_manufacturer-{{$randid}}" id="home_city" style="width: 16rem;" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
        </div>
        <div class="relative mt-8">
          <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-sm font-medium  ml-4 text-gray-900">Teile./Herstellernummer</label>
          <input type="text" name="device_partnumber-{{$randid}}" id="home_city" style="width: 16rem;" class="block ml-4  h-11 rounded-md border-0 py-1.5   text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-md sm:leading-6">
        </div>
      </div>
      <div class="w-full h-16 pr-16">
        <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Wurde das Steuergerät geöffnet?</label>
        <fieldset class="ml-0 float-left w-96 pt-6">
          <div class="space-y-4 float-right w-60">
            <div class="pr-2 mt-4 float-right">
              <input id="email" name="opend-{{$randid}}" type="radio" value="yes" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
              <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Nein</label>
            </div>
      
            <div class="float-right">
              <input id="sms" name="opend-{{$randid}}" type="radio" value="no" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
              <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Ja</label>
            </div>
          </div>
        </fieldset>
      </div>
      <div class="w-full h-16 pr-16">
        <label class="text-lg font-semibold text-gray-900 float-left pt-9 pr-16">Stammt das Gerät aus einem anderen Fahrzeug</label>
        <fieldset class="ml-0 float-left w-96 pt-6">
          <div class="space-y-4 float-left w-60 pl-1 ml-20">
            <div class="pr-4 float-left mt-4 ">
              <input id="email" name="from_car-{{$randid}}" type="radio" value="yes" checked class="float-left mt-1 h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600">
              <label for="email" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-4">Ja</label>
            </div>
      
            <div class="pr-4 float-left">
              <input id="sms" name="from_car-{{$randid}}" type="radio" value="no" class="h-5 mt-1 w-5 border-gray-300 text-blue-600 focus:ring-blue-600 float-left">
              <label for="sms" class="ml-3 block text-md font-medium leading-6 text-gray-900 float-left pr-8">Nein</label>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div id="add-device-button-{{$randid}}" class="float-right pr-2 pt-2 pb-2">
        <button type="button" onclick="addDeviceData()" class="float-right text-blue-600 hover:text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>          
        </button>
    </div>
  </div>