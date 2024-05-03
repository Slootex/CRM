<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "setting"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-black float-left">Einstellungen > Buchhaltung </h1>
    
    <div class="w mx-auto sm:px-6 lg:px-8 mt-16" style="width: 45rem;">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                      <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Artikelliste</h1>
                      </div>
                      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button" onclick="newArtikel()" class="block rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">neuer Artikel</button>
                      </div>
                    </div>
                    <div class="mt-2 flow-root">
                      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                          <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                              <tr>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Netto</th>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Brutto</th>

                                <th scope="col" class="relative  pl-3 pr-4 sm:pr-0">
                                </th>
                              </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                              @foreach ($artikelliste as $artikel)
                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{$artikel->artname}}</td>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{$artikel->netto}} €</td>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{$artikel->brutto}} €</td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/crm/buchhaltung-artikel-bearbeiten-{{$artikel->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 float-right">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>   
                                    </a>                                   
                                </td>
                              </tr>
                              @endforeach
                  
                              <!-- More people... -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="sm:flex sm:items-center">
                      <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Zahlungsziel</h1>
                      </div>
                    
                    </div>
                    <div class="mt-2 flow-root">
                      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                          <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                              <tr>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Tage</th>
                                <th scope="col" class="relative  pl-3 pr-4 sm:pr-0">
                                  <span class="sr-only">Edit</span>
                                </th>
                              </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{$globalsettings->where("id", "1")->first()->value}}</td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/crm/buchhaltung-zahlungsziel-bearbeiten">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 float-right">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>   
                                    </a>                                   
                                </td>
                              </tr>
                  
                              <!-- More people... -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="sm:flex sm:items-center">
                      <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">MwSt.</h1>
                      </div>
                    
                    </div>
                    <div class="mt-2 flow-root">
                      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                          <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                              <tr>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Prozent</th>
                                <th scope="col" class="relative  pl-3 pr-4 sm:pr-0">
                                  <span class="sr-only">Edit</span>
                                </th>
                              </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{$globalsettings->where("id", "2")->first()->value}}</td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <button onclick="document.getElementById('mwst-setting-modal').classList.remove('hidden')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 float-right">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>   
                                    </button>                                   
                                </td>
                              </tr>
                  
                              <!-- More people... -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>



                  
                  <div class="px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="sm:flex sm:items-center">
                      <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Dokumente</h1>
                      </div>
                    
                    </div>
                    <div class="mt-2 flow-root">
                      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                          <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                              <tr>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                                <th scope="col" class=" pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Hochladen</th>
                                <th scope="col" class="relative  pl-3 pr-4 sm:pr-0">
                                  <span class="sr-only">Edit</span>
                                </th>
                              </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Angebot ohne MwSt <span class="text-gray-400">(angebot_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-angebot-hochladen" enctype="multipart/form-data" method="POST" id="angebot-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('angebot-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/angebot_pdf.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>         
                                    </a>                            
                                </td>
                              </tr>

                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Angebot mit MwSt <span class="text-gray-400">(angebot_mwst_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-angebotmwst-hochladen" enctype="multipart/form-data" method="POST" id="angebotmwst-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('angebotmwst-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/angebot_mwst.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>                   
                                        </a>                            
                                </td>
                              </tr>

                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Rechnung ohne MwSt <span class="text-gray-400">(rechnung_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-rechnung-hochladen" enctype="multipart/form-data" method="POST" id="rechnung-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('rechnung-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/rechnung_pdf.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>                   
                                        </a>                            
                                </td>
                              </tr>

                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Rechnung mit MwSt <span class="text-gray-400">(angebot_mwst_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-rechnungmwst-hochladen" enctype="multipart/form-data" method="POST" id="rechnungmwst-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('rechnungmwst-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/rechnung_mwst.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>                   
                                        </a>                            
                                </td>
                              </tr>

                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Gutschrift mit MwSt <span class="text-gray-400">(gutschrift_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-gutschrift-hochladen" enctype="multipart/form-data" method="POST" id="gutschrift-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('gutschrift-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/gutschrift_pdf.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>                   
                                        </a>                            
                                </td>
                              </tr>

                              <tr>
                                <td class="whitespace-nowrap  pl-4 pr-3 text-sm text-gray-900 sm:pl-0">Gutschrift mit MwSt <span class="text-gray-400">(gutschrift_mwst_pdf.pdf)</span></td>
                                <td><div class=" bg-grey-lighter">
                                    <form action="{{url("/")}}/crm/buchhaltung-gutschriftmwst-hochladen" enctype="multipart/form-data" method="POST" id="gutschriftmwst-hochladen">
                                        @CSRF
                                        <label class="float-left w-36 mr-2 flex flex-col items-center px-4 py-1 bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                        
                                            <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1 ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg></span>
                                            <input type='file' oninput="document.getElementById('emailvorlage-file').innerHTML = this.value; document.getElementById('gutschriftmwst-hochladen').submit()" class="hidden" name="file" id="emailvorlage-fileinput" />
                                        </label>
                                    </form>
                                    
                                </div></td>
                                <td class="relative whitespace-nowrap  pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="{{url("/")}}/pdf/gutschrift_mwst.pdf" target="_blank" class="float-right" id="emailvorlage-bearbeiten-remove-pdf">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                          </svg>                   
                                        </a>                            
                                </td>
                              </tr>

                              <!-- More people... -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>

    <div class="relative hidden z-10" id="neuer-artikel-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <form action="{{url("/")}}/crm/buchhaltung-neuer-artikel" method="POST">
                @CSRF
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              <div>

                <div class=" text-left">
                  <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">neuer Artikel</h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">Fügen Sie einen neuen Artikel hinzu.</p>
                  </div>
                </div>
                <hr class="mt-2">

                <div class="mt-2">
                  <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Artikelnummer</label>
                  <div class="mt-2">
                    <input type="text" name="artnr" id="new-artikel-uuid" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="mt-2">
                  <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Name</label>
                  <div class="mt-2">
                    <input type="text" name="name"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="mt-2">
                  <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Netto</label>
                  <div class="mt-2">
                    <input type="text" name="netto"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="mt-2">
                  <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">MwSt</label>
                  <div class="mt-2">
                    <input type="text" name="mwst"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="mt-2">
                  <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Brutto</label>
                  <div class="mt-2">
                    <input type="text" name="brutto"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                  </div>
                </div>


              </div>
              <div class="mt-5 sm:mt-6">
                <button type="submit" class="inline-flex items-center gap-x-1.5 rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    Speichern
                  </button>

                  <button type="button" onclick="document.getElementById('neuer-artikel-modal').classList.add('hidden')" class="float-right rounded-md bg-white border border-gray-600 px-2.5 py-1.5 text-sm font-semibold text-black shadow-sm hover:bg-white/20">Abbrechen</button>

              </div>
            </div>
            </form>
          </div>
        </div>
      </div>


      @isset($artikelEdit)
      <div class="relative z-10" id="bearbeiten-artikel-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <form action="{{url("/")}}/crm/buchhaltung-bearbeiten-artikel-{{$artikelEdit->id}}" method="POST">
                @CSRF
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              <div class=" text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Artikel bearbeiten</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Bearbeiten Sie den Artikel.</p>
                </div>
              </div>
              <hr class="mt-2">
              <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                  <input type="text" name="name" value="{{$artikelEdit->artname}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                </div>
              </div>

              <div class="mt-2">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Netto</label>
                <div class="mt-2">
                  <input type="number" name="netto" value="{{$artikelEdit->netto}}"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                </div>
              </div>

              <div class="mt-2">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">MwSt</label>
                <div class="mt-2">
                  <input type="number" name="mwst" value="{{$artikelEdit->mwst}}"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                </div>
              </div>

              <div class="mt-2">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Brutto</label>
                <div class="mt-2">
                  <input type="number" name="brutto" value="{{$artikelEdit->brutto}}"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" >
                </div>
              </div>

              <button type="submit" class="bg-blue-600 hover:bg-blue-500 font-semibold text-white px-4 py-2 rounded-md float-left mr-2 mt-4">Speichern</button>
              <button type="button" onclick="document.getElementById('bearbeiten-artikel-modal').classList.add('hidden')" class="font-semibold mt-4 ml-2 px-4 py-2 border border-gray-600 float-right rounded-md">Abbrechen</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      @endisset


      @isset($zahlziel)
      <div class="relative z-10" id="bearbeiten-zahlziel-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <form action="{{url("/")}}/crm/buchhaltung-bearbeiten-zahlziel" method="POST">
                @CSRF
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              <div>

                <div class=" text-left">
                  <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Zahlungsziel bearbeiten</h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">Bearbeiten Sie das Zahlungsziel.</p>
                  </div>
                </div>
                <hr class="mt-2">

                <label for="neuezahlungname" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Tage</label>
                <div class="mt-2">
                  <input type="text" value="{{$zahlziel->value}}" name="name" id="neuezahlungname" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>


              </div>
              <div class="mt-5 sm:mt-6">
                <button type="submit" class="inline-flex items-center gap-x-1.5 rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    Speichern
                  </button>

                  <button type="button" onclick="document.getElementById('bearbeiten-zahlziel-modal').classList.add('hidden')" class="float-right ml-4 rounded-md bg-white border border-gray-600 px-2.5 py-1.5 text-sm font-semibold text-black shadow-sm hover:bg-white/20">Abbrechen</button>

              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
      @endisset


      
    <div class="relative hidden z-10" id="mwst-setting-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true" >
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
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8   sm:p-6" >
              <form action="{{url("/")}}/crm/change/mwst-setting" method="POST">
                @CSRF
                <div class="relative">
                  <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">MwSt.</label>
                  <input type="number" name="mwst" id="mwst-setting" value="{{$globalsettings->where("id", "2")->first()->value}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>
                <button class="bg-blue-600 hover:bg-blue-500 rounded-md px-2 py-1 text-white mt-6">Speichern</button>
              </form>
            </div>
          </div>
        </div>
      </div>
<script>
  function newArtikel() {

    document.getElementById("new-artikel-uuid").value = Math.floor(Math.random() * (9000 - 1000 + 1)) + 1000;

    document.getElementById('neuer-artikel-modal').classList.remove('hidden');
  }
</script>

</body>
</html>
