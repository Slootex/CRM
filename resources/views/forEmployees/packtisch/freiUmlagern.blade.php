<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="js/pdf.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    @vite('resources/css/app.css')
</head>
<body>

  @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "umlagern-packtisch"])


  <form action="{{url("/")}}/crm/packtisch/freies-umlagern-save" method="POST">
    @csrf

    <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
        <div class="inline-block px-8 py-4 w-full">
            <div style="width: 100%">
              <div class="w-full">
                <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Freies Geräteumlagern</h1>
              </div>
              <div class="w-full">
                <div class="flow-root mt-6">
                <ul role="list" class="-mb-8">

                  <li>
                    <div class="relative pb-8">
                      <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                              </svg>
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                          <div>
                            <p class="text-xl text-gray-600">Gerätenummer</p>
                            <input name="device" oninput="if(this.value.length >= 13) {document.getElementById('shelfe').classList.remove('hidden')}" type="text" class="w-96 rounded-md h-12 border border-gray-600 text-xl text-center">
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="hidden" id="shelfe">
                    <div class="relative pb-8">
                      <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                              </svg>
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                          <div>
                            <p class="text-xl text-gray-600">Neuer Lagerplatz</p>
                            <input name="shelfe" type="text" oninput="if(this.value.length >= 3) {document.getElementById('final-button-shelfe').classList.remove('hidden')}" class="w-96 rounded-md h-12 border border-gray-600 text-xl text-center">
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="hidden" id="final-button-shelfe">
                    <div class="relative pb-8">
                      <span class="absolute left-7 top-7 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      <div class="relative flex space-x-3">
                        <div>
                          <span class="h-14 w-14 rounded-full flex items-center justify-center ring-8 ring-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-14 h-14 text-green-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                              </svg>
                              
                          </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                          <div class="w-full">
                            <button type="submit" class="font-semibold text-white bg-blue-600 hover:bg-blue-500 rounded-md text-xl py-2 w-full">Gerät umlagern</button>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                </div>
              </div>
            </div>
        </div>
    </div>
  </form>
  

</body>
</html>