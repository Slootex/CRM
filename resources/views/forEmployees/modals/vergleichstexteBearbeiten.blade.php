
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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-8 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:p-6" style="width: 30rem;">
              <a href="#"><p onclick="document.getElementById('edit').classList.add('hidden')" class="float-right text-xl text-white bg-red-600 rounded-md px-1  py-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
              </p></a>
              

              <div class="px-0">
               <h1 class="text-xl font-semibold">@if(!isset($rechnung->text) && !isset($mahnung->text) && !isset($vergleich->text) && !isset($phone->text)) Neue Textvorlage @else Textvorlage ändern @endif</h1>
               <p class="text-normal text-gray-600">@if(!isset($rechnung->text) && !isset($mahnung->text) && !isset($vergleich->text) && !isset($phone->text)) Textvorlage auswählen und Text erstellen @else Textvorlage auswählen und Text ändern @endif</p>
              </div>
              <div class="px-0 pt-8">
                @php
                    $types = array(
                      "rechnung" => "Rechnungstext",
                      "vergleich" => "Vergleichstext",
                      "mahnung" => "Mahnugnstext",
                      "phone" => "Telefonhistorientext"
                    )
                @endphp
                <label for="type" class="text-normal font-semibold">Textvorlagen</label>
                <select name="type" id="type" class="rounded-md border-gray-600 w-full">
                    @isset($rechnung)
                                <option value="rechnung" selected>Rechnungstext</option>
                                @php
                                  $sel = "rechnung";
                              @endphp
                    @endisset
                    @isset($vergleich)
                              <option value="vergleich" selected>Vergleichstext</option>
                               @php
                                  $sel = "vergleich";
                              @endphp
                    @endisset
                    @isset($mahnung)
                              <option value="mahnung" selected>Mahnungstext</option>
                              @php
                                  $sel = "mahnung";
                              @endphp
                    @endisset
                    @isset($phone)
                    <option value="phone" selected>Telefonhistorentext</option>
                    @php
                        $sel = "phone";
                    @endphp
          @endisset

                  @foreach ($types as $type => $item)
                    @isset($sel)
                        @if ($sel != $type)
                            <option value="{{$type}}">{{$item}}</option>
                        @endif
                        @else
                        <option value="{{$type}}">{{$item}}</option>

                    @endisset

                         
                          
                  @endforeach
                </select>
              </div>

              <div class="px-0 pt-8">
                <label for="type" class="text-normal font-semibold">Name</label>
                @isset($rechnung->title)
                  <input type="text" name="title" id="type" class="rounded-md border-gray-600 w-full" value="{{$rechnung->title}}">
                @endisset 
                @isset($mahnung->title) 
                  <input type="text" name="title" id="type" class="rounded-md border-gray-600 w-full" value="{{$mahnung->title}}">
                @endisset 
                @isset($vergleich->title) 
                  <input type="text" name="title" id="type" class="rounded-md border-gray-600 w-full" value="{{$vergleich->title}}">
                @endisset
                @isset($phone->title) 
                  <input type="text" name="title" id="type" class="rounded-md border-gray-600 w-full" value="{{$phone->title}}">
                @endisset
                @if (!isset($rechnung->title) && !isset($mahnung->title) && !isset($vergleich->title) && !isset($phone->title))
                <input type="text" name="title" id="type" class="rounded-md border-gray-600 w-full" >
                @endif
              </div>
              <div class="pt-8 bg-grey-lighter">

               
                  @isset($rechnung->title)
                  <button type="button" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-red-600 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>                    
                  </button>
                  <a target="_blank" class="float-right" href="{{url("/")}}/pdf/" id="emailvorlage-bearbeiten-ansehen-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-400 mr-2 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    
                  </a>                  @endisset 
                  @isset($mahnung->title) 
                  <p class="float-left mt-1 font-semibold">Vorschau</p>
                  <a target="_blank" href="{{url("/")}}/crm/mahnung/pdf-1/F387254" class="float-right" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-400 mr-2 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    
                  </a>
                  @else
                  <label class="float-left mt-610 border-gray-600 w-80 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border cursor-pointer hover:bg-blue hover:text-white">
                    
                    <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg></span>
                    <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value" class="hidden" name="file" id="emailvorlage-fileinput" />
                </label>                 
                   @endisset 
                  @isset($vergleich->title) 
                  <button type="button" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-red-600 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>                    
                  </button>
                  <a target="_blank" class="float-right" id="emailvorlage-bearbeiten-ansehen-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-400 mr-2 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    
                  </a>                  @endisset
                  @isset($phone->title) 
                  <button type="button" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-red-600 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>                    
                  </button>
                  <a target="_blank" class="float-right" id="emailvorlage-bearbeiten-ansehen-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-400 mr-2 mt-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    
                  </a>                  @endisset
                
            </div>
            <br>
              <div class="px-0 pt-8">
                <label for="type" class="text-normal font-semibold">Aktiviert</label>
                  @isset($rechnung->aktiviert)
                  @if ($rechnung->aktiviert == "Ja")
                  <input type="hidden" name="activate" value="Ja" id="activate-input">
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-green-600 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-6 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <script>
                    let activateState = true;
  </script>
                  @else 
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-red-200 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-0 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <input type="hidden" name="activate" value="Nein" id="activate-input">
                  <script>
                    let activateState = false;
  </script>

                  @endif
                @endisset 
                @isset($mahnung->aktiviert) 
                @if ($mahnung->aktiviert == "Ja")
                <input type="hidden" name="activate" value="Ja" id="activate-input">
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-green-600 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-6 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <script>
                    let activateState = true;
  </script>
                  @else 
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-red-200 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-0 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <input type="hidden" name="activate" value="Nein" id="activate-input">
                  <script>
                    let activateState = false;
  </script>
                @endif
                @endisset 
                @isset($vergleich->aktiviert) 
                @if ($vergleich->aktiviert == "Ja")
                <input type="hidden" name="activate" value="Ja" id="activate-input">
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-green-600 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-6 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <script>
                    let activateState = true;
  </script>
                  @else 
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-red-200 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-0 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <input type="hidden" name="activate" value="Nein" id="activate-input">
                  <script>
                    let activateState = false;
  </script>
                @endif                @endisset
                @isset($phone->aktiviert) 
                @if ($phone->aktiviert == "Ja")
                <script>
                  let activateState = true;
</script>
                <input type="hidden" name="activate" value="Ja" id="activate-input">
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-green-600 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-6 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  @else 
                  <script>
                    let activateState = false;
  </script>
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-red-200 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-0 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                  <input type="hidden" name="activate" value="Nein" id="activate-input">
                @endif                @endisset
                @if (!isset($rechnung->aktiviert) && !isset($mahnung->aktiviert) && !isset($vergleich->aktiviert) && !isset($phone->aktiviert))
                
                <input type="hidden" name="activate" value="Nein" id="activate-input">
                  <button type="button" id="activate-button" onclick="changeActivate()" class=" float-right bg-red-200 relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" role="switch" aria-checked="false">
                    <span class="sr-only">Use setting</span>
                    <span aria-hidden="true" id="activate-span" class="translate-x-0 pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                  </button>
                @endif
              </div>
              <script>

@isset($rechnung->aktiviert)
                  @if($rechnung->aktiviert == "Ja")
                     activateState = true;
                  @else
                     activateState = false;
                     @endif
                  @else 
                   activateState = false;
                @endisset

                @isset($mahnung->aktiviert)
                @if($mahnung->aktiviert == "Ja")
                 activateState = true;
                @else
                 activateState = false;
                 @endif
                @else 
                 activateState = false;
                @endisset

                @isset($vergleich->aktiviert)
                @if($vergleich->aktiviert == "Ja")
                 activateState = true;
                @else
                 activateState = false;
                 @endif
                @else 
                 activateState = false;
                @endisset

                @isset($phone->aktiviert)
                @if($phone->aktiviert == "Ja")
                 activateState = true;
                @else
                 activateState = false;
                 @endif
                @else 
                 activateState = false;
                @endisset

                function changeActivate() {
                  document.getElementById("activate-button").classList.toggle("bg-green-600");
                  document.getElementById("activate-button").classList.toggle("bg-red-200");

                  document.getElementById("activate-span").classList.toggle("translate-x-6");
                  document.getElementById("activate-span").classList.toggle("translate-x-0");

                  if(activateState == false) {
                    document.getElementById("activate-input").value = "Ja";
                    activateState = true;
                  } else {
                    document.getElementById("activate-input").value = "Nein";
                    activateState = false;
                  }


                }
              </script>
              <div class="px-0 pt-8">
                <label for="type" class="text-normal font-semibold">Text</label>
                @isset($vergleich->text) 
                  <textarea type="text" name="textarea" id="text" class="rounded-md border-gray-600 w-full h-56">{{$vergleich->text}}</textarea>
                  <input type="hidden" name="id" value="{{$vergleich->id}}">
                @endisset
                @isset($mahnung->text) 
                <textarea type="text" name="textarea" id="text" class="rounded-md border-gray-600 w-full h-56">{{$mahnung->text}}</textarea>
                <input type="hidden" name="id" value="{{$mahnung->id}}">
                @endisset
                @isset($rechnung->text) 
                <textarea type="text" name="textarea" id="text" class="rounded-md border-gray-600 w-full h-56">{{$rechnung->text}}</textarea>
                <input type="hidden" name="id" value="{{$rechnung->id}}">
                @endisset
                @isset($phone->text) 
                <textarea type="text" name="textarea" id="text" class="rounded-md border-gray-600 w-full h-56">{{$phone->text}}</textarea>
                <input type="hidden" name="id" value="{{$phone->id}}">
                @endisset
                @if (!isset($rechnung->text) && !isset($mahnung->text) && !isset($vergleich->text) && !isset($phone->text))
                <textarea type="text" name="textarea" id="text" class="rounded-md border-gray-600 w-full h-56"></textarea>
                @endif
              </div>
              <div class="px-0 pt-8">
                <button class="hidden" type="submit" id="submit-edit-text"></button>
                <button type="button" onclick="submitTextvorlage()" class="float-left bg-blue-600 hover:bg-blue-500 rounded-md font-semibold py-1.5 text-white w-24 text-center">Speichern</button>
                <button type="button" onclick="document.getElementById('edit').classList.add('hidden')" class="float-right bg-white text-black rounded-md font-semibold py-1.5 w-24 text-center border border-gray-600">Abbrechen</button>
                @isset($rechnung->id) <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/löschen/rechnung/{{$rechnung->id}}'" class="float-right bg-red-600 rounded-md font-semibold py-1.5 text-white w-24 text-center mr-2">Löschen</button> @endisset
                @isset($vergleich->id) <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/löschen/vergleich/{{$vergleich->id}}'" class="float-right bg-red-600 rounded-md font-semibold py-1.5 text-white w-24 text-center mr-2">Löschen</button> @endisset
                @isset($mahnung->id) <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/löschen/mahnung/{{$mahnung->id}}'" class="float-right bg-red-600 rounded-md font-semibold py-1.5 text-white w-24 text-center mr-2">Löschen</button> @endisset
                @isset($phone->id) <button type="button" onclick="window.location.href = '{{url('/')}}/crm/vergleichsetting/löschen/phone/{{$phone->id}}'" class="float-right bg-red-600 rounded-md font-semibold py-1.5 text-white w-24 text-center mr-2">Löschen</button> @endisset

              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="text" id="text-input" name="text" class="hidden">
      <script>

        $('#submit-textvorlage-form').ajaxForm(function() { savedPOST() });

        $('#text').trumbowyg();

        function submitTextvorlage() {
          loadData();
          document.getElementById("text-input").value = $('#text').trumbowyg('html');

          document.getElementById("submit-edit-text").click();
        }
      </script>
