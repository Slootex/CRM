<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    @vite('resources/js/app.js')


    @vite('resources/css/app.css')
</head> 
<body>
    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])

    <form action="{{url("/")}}/crm/packtisch/abholung-abschließen/{{$intern->id}}" method="POST">
        @csrf
        <div style="width: 40%" class=" bg-white rounded-md m-auto mt-6 pb-16">
          @if ($intern->info != "")
            <div class="w-full px-8">
              <div class="m-auto bg-red-100 rounded-md mt-6 px-4 py-2 w-full">
                <p class="text-2xl text-red-800">{{$intern->info}}</p>
              </div>
            </div>
          @endif

            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Abholauftrag</h1>
                        <button type="button" onclick="document.getElementById('problem-melden-modal').classList.remove('hidden')" class="float-right  mt-1 bg-red-400 rounded-md text-white font-semibold px-3 py-1">Problem melden</button>
                      </div>
                    <div class="w-full">
                        <div class="flow-root mt-6">
                        <ul role="list" class="-mb-8">
                            <li class="" id="step-1">
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
                                        <p class="text-gray-500 text-xl">Bitte ein Paket abholen</p>
                                        <p class="text-gray-500 text-xl mt-4">Vollmachtnehmer</p>
                                        <p class="text-xl font-semibold text-green-600">{{$intern->abholung_abfirstname}} {{$intern->abholung_ablastname}}</p>
                                        <p class="text-xl font-semibold text-green-600">{{$intern->abholung_abstreet}}</p>
                                        <p class="text-xl font-semibold text-green-600">{{$intern->abholung_abzipcode}} {{$intern->abholung_abcity}}</p>
                                        <p class="text-xl font-semibold text-green-600 mt-4">Geburtstag: 
                                          
                                          @php
                                            $date = new DateTime($intern->abholung_birthday);
                                          @endphp
                                          {{$date->format("d.m.Y")}}</p>

                                        <p class="text-gray-500 text-xl mt-4">Sendungsnummer</p>
                                        <p class="text-blue-600 font-semibold text-xl">{{$intern->abholung_trackingnumber}}</p>

                                        <p class="text-gray-500 text-xl mt-4">Abholadresse:</p>
                                        <p class="text-xl font-semibold text-blue-600">{{$intern->abholung_company}}</p>
                                        <p class="text-xl font-semibold text-blue-600">{{$intern->abholung_firstname}} {{$intern->abholung_lastname}}</p>
                                        <p class="text-xl font-semibold text-blue-600">{{$intern->abholung_street}}</p>
                                        <p class="text-xl font-semibold text-blue-600">{{$intern->abholung_zipcode}} {{$intern->abholung_city}}</p>
                                      </div>
                                     
                                    </div>
                                  </div>
                                </div>
                              </li>

                              <li class="" id="step-1">
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
                                      <div class="flex">
                                        <div>
                                          <p class="text-gray-500 text-xl">Vollmacht ausdrucken</p>
                                        <a href="{{url("/")}}/crm/packtisch/abholauftrag-get-document/{{$intern->id}}" target="_blank" class="mt-2 px-2 py-1 rounded-md text-white font-semibold bg-blue-600 hover:bg-blue-500 flex">Dokumente abrufen 
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-2 mt-0.5">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                          </svg>                                          
                                        </a> 
                                      </div> 
                                        
                                        <div onclick="document.getElementById('abhol-doc').contentWindow.print()" class="p-1 w-12 h-12 rounded-full bg-green-600 hover:bg-green-400 cursor-pointer mt-4 ml-6">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 mt-0.5 h-8 text-center m-auto text-white">
                                            <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                          </svg>                                          
                                        </div>
                                      </div>
                                     
                                    </div>
                                  </div>
                                </div>
                              </li>


                              <li class="" id="step-2">
                                <div class="relative">
                                  <div class="relative flex space-x-3">
                                    
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                      <div class="m-auto w-full">
                                        <button type="submit" id="einlagern-button" class="text-white inline-block font-semibold py-3 rounded-md bg-blue-600 hover:bg-blue-500 text-xl" style="width: 35rem">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white mr-4 inline-block">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                                            </svg>
                                            <p class="inline-block" id="submit-type-text">Abholung abgeschlossen</p>
    
                                          </button>
                                         
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

    <iframe src="{{url("/")}}/crm/packtisch/abholauftrag-get-document/{{$intern->id}}" class="hidden" id="abhol-doc" frameborder="0"></iframe>

</body>
</html>