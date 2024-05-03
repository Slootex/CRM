<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-16" >
        <div class="overflow-hidden rounded-lg bg-white shadow" id="test" style="height: 50rem">
            <div class="px-4 py-5 sm:p-6">
                <div>
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Dokumente</label>
                    <select id="location" name="location" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                      <option>Rechnung MWST</option>
                      <option>Rechnung Ohne MWST</option>
                    </select>
                  </div>
                  
                  
                
                  <!-- Static sidebar for desktop -->
                  <form action="{{url("/")}}/save-pdf" method="POST" enctype="multipart/form-data">
                    @CSRF
                    <input type="hidden" name="type" value="rechnung">
                    <div class=" float-left absolute lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col mt-60" style="height: 39.9rem;">
                      <!-- Sidebar component, swap this element with another sidebar if you like -->
                      <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-blue-600 hover:bg-blue-500 px-6 pb-4">
  
                        <nav class="flex flex-1 flex-col">
                          <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                              <ul role="list" class="-mx-2 space-y-1">
                                <li class="">
                                  <p class="text-white font-medium mt-4">Header-Logo</p>
                                  <label class=" w-full mt-2 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                      <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                          <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                      </svg></span>
                                      <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value" class="hidden" name="filee" id="emailvorlage-fileinput" />
                                  </label>
                                </li>
  
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Firma</p>
                                  <div>
                                      <input type="text" name="top-1" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Straße</p>
                                  <div>
                                      <input type="text" name="top-2" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Postleitzahl / Stadt</p>
                                  <div>
                                      <input type="text" name="top-3" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Land</p>
                                  <div>
                                      <input type="text" name="top-4" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Telefon</p>
                                  <div>
                                      <input type="text" name="top-5" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Fax</p>
                                  <div>
                                      <input type="text" name="top-6" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Erstell-Email</p>
                                  <div>
                                      <input type="text" name="top-7" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <p class="text-white font-medium mt-4">Bottom-Website</p>
                                  <div>
                                      <input type="text" name="top-8" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    </div>
                                </li>
                                <li >
                                  <button class="bg-white rounded-md px-4 py-2 w-full mt-6">Speichern</button>
                                </li>
                                
                              </ul>
                            </li>
  
                          </ul>
                        </nav>
                      </div>
                    </div>
                  </form>
                  <iframe src="{{url("/")}}/pdf/rechnung_mwst_pdf.pdf" class="ml-72 mt-4 pt-0.5 h-full" style="width:56.5rem; height: 40rem" frameborder="0"></iframe>
                </div>
                <div>
                </div>
            </div>
          </div>
    </div>

    <script>



    </script>

</body>
</html>