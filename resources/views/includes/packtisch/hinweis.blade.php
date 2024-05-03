                 
<form action="{{url("/")}}/crm/packtisch/neuer-hinweis" id="packtisch-hinweis-form" method="POST">
  @csrf
  <div class="grid grid-cols-3" style="width: 50rem">
    <p class="mt-8">Typ</p>
    <select id="hinweis-type" required onchange="document.getElementById('hinweis-submit').innerHTML = 'an ' + this.value + ' senden'" name="type"class="mt-8 col-span-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
      <option value="Packtisch">Packtisch</option>
      <option value="Auftragsübersicht">Auftragsübersicht</option>
      <option value="Interessentenübersicht">Interessentenübersicht</option>
    </select>

    <p class="mt-8">Warnhinweis</p>
    <textarea rows="4" required name="hinweis" id="comment" class="block col-span-2 mt-8 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
  
    <p class="mt-8">Farbe</p>
    
    <button type="button" onclick="changeHinweisColor('Neutral')" id="hinweis-neutral-p" class="bg-gray-100 text-gray-600 px-2 py-1 rounded-lg w-36 mt-8 hover:bg-blue-100">
      <p>Neutral</p>
    </button>
    <button type="button" onclick="changeHinweisColor('Rot')" id="hinweis-rot-p" class="bg-red-100 text-red-600 px-2 py-1 rounded-lg w-36 mt-8 hover:bg-blue-100">
      <p>Rot</p>
    </button>

    <input type="color" required name="color" id="hinweis-color" class="hidden">
  
    <div class="mt-10 mb-4 col-start-3">
      <hr>
      <button id="hinweis-submit" type="submit" onclick="loadData()" class=" bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium  py-2 w-72 float-right mt-4">An Packtisch senden</button>
    </div>
  </div>
  <input type="hidden" name="process_id" value="{{$order->process_id}}">
</form>
<script>

  function changeHinweisColor(type) {
    if (type == "Neutral") {
      document.getElementById('hinweis-color').value = "#c4c4c4";
      document.getElementById('hinweis-rot-p').classList.add('bg-red-100', "text-red-600");
      document.getElementById('hinweis-rot-p').classList.remove('bg-blue-100', "text-blue-600");
      document.getElementById('hinweis-neutral-p').classList.add('bg-blue-100', "text-blue-600");
      document.getElementById('hinweis-neutral-p').classList.remove('bg-gray-100', "text-gray-600");

    } else {
      document.getElementById('hinweis-color').value = "#fc2803";
      document.getElementById('hinweis-rot-p').classList.remove('bg-red-100', "text-red-600");
      document.getElementById('hinweis-rot-p').classList.add('bg-blue-100', "text-blue-600");
      document.getElementById('hinweis-neutral-p').classList.remove('bg-blue-100', "text-blue-600");
      document.getElementById('hinweis-neutral-p').classList.add('bg-gray-100', "text-gray-600");
    }
  }

</script>