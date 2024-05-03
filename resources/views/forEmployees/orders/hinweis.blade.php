<div  class=" w-full pt-4 m-auto pb-7 px-4 py-4"  >

<h1 class="text-2xl font-bold">Wichtige Auftragsinformation</h1>

                  <div class="w-full">
                      <div class="">
                        <svg onclick="changeHinweisEditMode('{{$order->process_id}}')" id="hinweis-edit-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-2 mr-4 w-5 h-5  float-right hover:text-blue-400 text-blue-600 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        <svg onclick="changeHinweisEditMode('{{$order->process_id}}')" id="hinweis-finish-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden mt-2 mr-4 w-5 h-5 float-right hover:text-green-400 text-green-600 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>
                      </div>
                      
                             
                          
                               
                  </div>
                  <hr class="mt-1 mb-2 ">
              
                  <div class="px-4 flex">
                      <svg id="hinweis-edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-400 ml-5 mt-2">
                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                      </svg>          
                      <p id="hinweis-edit-text" class="ml-4 text-red-800 font-semibold text-2xl">{{$order->hinweis}}</p>
              
              
              
                      <textarea id="hinweis-edit-input" class="w-full h-24 hidden  rounded-md">{{$order->hinweis}}</textarea>



                  </div>  
                  <p class="text-sm mt-1 ml-20 text-red-400 font-medium" id="hinweis-von-text">{{$order->hinweis_sign}}</p>
</div>

