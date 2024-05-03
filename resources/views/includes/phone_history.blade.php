<div class=" w-full px-6 py-6">
    
    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<form action="{{url('/')}}/crm/phonehistory/new/{{$person->process_id}}" class="relative" method="POST">
    @CSRF
<div>
    <label for="email" class="block text-sm font-medium text-gray-700">Betreff</label>
    <div class="mt-1">
      <input type="text" name="subject" id="email" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="">
    </div>
  </div>
  <div class="">
    <label for="location" class="block text-sm font-medium text-gray-700 mt-36 2xl:mt-0">Nachricht</label>
    <select id="location" name="location" onchange="addMessageToPhone(this.value)" class="mt-1 block w-96 rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
      <option value="">Wählen</option>
      <option value="Kunde nicht erreicht">Kunde nicht erreicht</option>
      <option value="Rückruf erledigt">Rückruf erledigt</option>
      <option value="KD nicht erreicht, wollte Kunde eine NEUE Info zu seinem Auftrag geben, bitte weiterleiten">KD nicht erreicht, wollte Kunde eine NEUE Info zu seinem Auftrag geben, bitte weiterleiten</option>
      <option value="KD nicht erreicht, Mail geschickt">KD nicht erreicht, Mail geschickt</option>
      <option value="KD erreicht, warte auf Fehlerauslese per Mail">KD erreicht, warte auf Fehlerauslese per Mail</option>
      <option value="Fehlerauslese angekommen, wir schauen uns den Fall genau an">Fehlerauslese angekommen, wir schauen uns den Fall genau an</option>
      <option value="Reklamation eingegangen, Bitte Rückruf beim Kunden">Reklamation eingegangen, Bitte Rückruf beim Kunden</option>
      <option value="KD erreicht, Gerät kommt nach Berlin">KD erreicht, Gerät kommt nach Berlin</option>
      <option value="KD erreicht, warte auf Meldung von Kunden">KD erreicht, warte auf Meldung von Kunden</option>
    </select>
  </div>
 
 
 
 


  <script>
    function addMessageToPhone(message) {
      document.getElementById("message_phone").value += message + ", ";
    }
  </script>
</div>
  <br>
<div class="flex items-start space-x-4">
    
    <div class="min-w-0 flex-1 ">
      
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
          <label for="comment" class="sr-only">Add your comment</label>
          <textarea rows="3" name="comment" id="message_phone" class="block w-full resize-none border-0 py-3 focus:ring-0 sm:text-sm" placeholder="Kommentar"></textarea>
  
          <!-- Spacer element to match the height of the toolbar -->
        
        </div>
  
        <div class="absolute inset-x-0 bottom-0 flex justify-between pl-3 pr-2">
          <div class="flex items-center space-x-5">
            <div class="flex items-center">
              <button type="button" class="-m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                <!-- Heroicon name: mini/paper-clip -->
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Attach a file</span>
              </button>
            </div>
            <script>
                var state = true;
                function showEmoji() {
                    if(state == false) {
                        document.getElementById('emoji').classList.add('hidden')
                        state = true;
                    } else {
                        document.getElementById('emoji').classList.remove('hidden')
                        state = false;
                    }
                }
            </script>
            <div class="flex items-center">
              <div>
                <label id="listbox-label" class="sr-only"> Your mood </label>
                <div class="relative">
                  <button type="button" onclick="showEmoji()" class="float-left relative -m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                    <span class="flex items-center justify-center">
                      <!-- Placeholder label, show/hide based on listbox state. -->
                      <span>
                        <!-- Heroicon name: mini/face-smile -->
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-4.464a.75.75 0 10-1.061-1.061 3.5 3.5 0 01-4.95 0 .75.75 0 00-1.06 1.06 5 5 0 007.07 0zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only"> Add your mood </span>
                      </span>
                      <!-- Selected item label, show/hide based on listbox state. -->
                     
                    </span>
                  </button>
  
                  <!--
                    Select popover, show/hide based on select state.
  
                    Entering: ""
                      From: ""
                      To: ""
                    Leaving: "transition ease-in duration-100"
                      From: "opacity-100"
                      To: "opacity-0"
                  -->
                 <script>
                    var last = "wichtig";
                    function changeEmoji(el) {
                        document.getElementById(el).classList.remove("hidden");
                        document.getElementById(last).classList.add("hidden");
                        document.getElementById("emoji").classList.add("hidden");
                        state = true;
                        last = el;
                    }
                 </script>
                 
                  <ul id="emoji" class="hidden absolute z-10 mt-1 -ml-6 w-60 rounded-lg bg-white py-3 text-base shadow ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-5">
                    <!--
                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
  
                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                    -->
                    <li onclick="changeEmoji('wichtig')" class="bg-white relative cursor-default select-none py-2 px-3 hover:bg-gray-100" id="listbox-option-0" role="option">
                      <div class="flex items-center">
                        <div class="bg-red-500 w-8 h-8 rounded-full flex items-center justify-center">
                          <!-- Heroicon name: mini/fire -->
                          <svg class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.278.352.594.672.943.954.332.269.786-.049.773-.476a5.977 5.977 0 01.572-2.759 6.026 6.026 0 012.486-2.665c.247-.14.55-.016.677.238A6.967 6.967 0 0013.5 4.938zM14 12a4 4 0 01-4 4c-1.913 0-3.52-1.398-3.91-3.182-.093-.429.44-.643.814-.413a4.043 4.043 0 001.601.564c.303.038.531-.24.51-.544a5.975 5.975 0 011.315-4.192.447.447 0 01.431-.16A4.001 4.001 0 0114 12z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <span class="ml-3 block truncate font-medium">Wichtig</span>
                      </div>
                    </li>

                    
                    <!--
                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
  
                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                    -->
                    <li onclick="changeEmoji('update')" class="bg-white relative cursor-default select-none py-2 px-3 hover:bg-gray-100" id="listbox-option-1" role="option">
                      <div class="flex items-center">
                        <div class="bg-pink-400 w-8 h-8 rounded-full flex items-center justify-center">
                          <!-- Heroicon name: mini/heart -->
                          <svg class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z" />
                          </svg>
                        </div>
                        <span class="ml-3 block truncate font-medium">Update</span>
                      </div>
                    </li>
  
                    <!--
                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
  
                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                    -->
                    <li onclick="changeEmoji('sofort')" class="bg-white relative cursor-default select-none py-2 px-3 hover:bg-gray-100" id="listbox-option-2" role="option">
                      <div class="flex items-center">
                        <div class="bg-green-400 w-8 h-8 rounded-full flex items-center justify-center">
                          <!-- Heroicon name: mini/face-smile -->
                          <svg class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-4.464a.75.75 0 10-1.061-1.061 3.5 3.5 0 01-4.95 0 .75.75 0 00-1.06 1.06 5 5 0 007.07 0zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <span class="ml-3 block truncate font-medium">Sofort Bearbeiten</span>
                      </div>
                    </li>
  
                  </ul>
                  <div id="wichtig" class="ml-4 hidden bg-red-500 w-8 h-8 rounded-full flex items-center justify-center float-left">

                  <svg class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.278.352.594.672.943.954.332.269.786-.049.773-.476a5.977 5.977 0 01.572-2.759 6.026 6.026 0 012.486-2.665c.247-.14.55-.016.677.238A6.967 6.967 0 0013.5 4.938zM14 12a4 4 0 01-4 4c-1.913 0-3.52-1.398-3.91-3.182-.093-.429.44-.643.814-.413a4.043 4.043 0 001.601.564c.303.038.531-.24.51-.544a5.975 5.975 0 011.315-4.192.447.447 0 01.431-.16A4.001 4.001 0 0114 12z" clip-rule="evenodd" />
                  </svg>
                  </div>
                  <div  id="update" class="ml-4 hidden bg-green-400 w-8 h-8 rounded-full flex items-center justify-center float-left">

                  <svg  class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" >
                    <path d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z" />
                  </svg>
                  </div>
                  <div id="sofort" class="ml-4 hidden bg-green-400 w-8 h-8 rounded-full flex items-center justify-center float-left">

                  <svg  class="text-white flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" >
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-4.464a.75.75 0 10-1.061-1.061 3.5 3.5 0 01-4.95 0 .75.75 0 00-1.06 1.06 5 5 0 007.07 0zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z" clip-rule="evenodd" />
                  </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="flex-shrink-0">
            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Hinzufügen</button>
          </div>
        </div>
        
      </form>
    </div>
  </div>
  </div>
  <br>
  
  <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum</th>
          <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Status</th>
          <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
          <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Info</th>
          <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-white">
        @foreach ($phonehistory as $phone)
            <tr>
              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$phone->created_at->format("d.m.Y")}} ({{$phone->created_at->format("H:i")}})</td> 
              <td class="inline-flex rounded-full bg-green-100 px-2  text-xs font-semibold leading-5">Telefon</td>
              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$phone->employee}}</td>
              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{substr($phone->message, 0, 100)}}...</td>
              <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500"><svg onclick="readStatus('{{$phone->process_id}}','{{$phone->created_at}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
              </td>
  
            </tr>
        @endforeach
  
      </tbody>
    </table>