

<div class="relative z-50" id="email-new" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left  transition-all sm:my-8 sm:p-6">
          
  <div>           
             
              <div >
                  <div class="px-6">
                        <div class="">
                          
                          <button class="float-right" type="button" onclick="document.getElementById('email-rechnung-modal').innerHTML = ''; clearInterval(autoEntwurfNewID)">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hover:text-blue-400 ml-1 text-lg font-semibold leading-6 text-gray-500 hover:text-blue-400 float-left mt-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          
                        </button>
                        <h1 class="font-bold text-2xl">Rechnung {{$rechnung->rechnungsnummer}} - Email an Kunden</h1>
                        </div>
                    </div>
                <form action="{{url("/")}}/crm/buchhaltung/rechnung-email" method="POST" id="rechnung-email-form" enctype="multipart/form-data">
                  @CSRF
                    <input type="hidden" name="rechnungsnummer" value="{{$rechnung->rechnungsnummer}}">
                  <div class="px-6 mt-1">
                    <input type="hidden" name="account" id="account-input-new" value="1">
                      <input style="padding-left: 0rem" type="text" name="cc" id="new-cc-empf" value="{{$order->email}}" placeholder="Empfänger" class="border-none text-2xl text-gray-600 font-semibold w-full h-12">
                      <hr class="py-2 mt-4 border-gray-300">
                      <input style="padding-left: 0rem" type="text" id="subject-new" name="subject" value="{{$email->subject}}" placeholder="Betreff" class="border-none text-2xl text-gray-600 font-semibold w-full h-12 mb-4 inline-block">
                      <textarea name="text" id="text-new-email" cols="30" rows="10" class="w-full rounded-md h-44 overflow-auto border-none" placeholder="Text schreiben...">{{$email->body}}</textarea>

                  </div>
                  <div class="mt-16  px-6">
                    <a target="_blank" href="{{url("/")}}/crm/rechnung-pdf/{{$rechnung->rechnungsnummer}}" class="float-left text-gray-400 hover:text-blue-400 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                          </svg>                          
                        <p class="ml-1">Rechnung im Anhang hinterlegt</p>
                        </a>
                      <button type="submit" onclick="loadData();  document.getElementById('email-new').classList.add('hidden');" class="px-5 py-1 bg-blue-600 hover:bg-blue-500 text-md font-semibold text-white rounded-md float-right">E-Mail senden</button>
                    </div>
  
            </form>
  
            </div>
          </div>
        </div>
      </div>
  
  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    