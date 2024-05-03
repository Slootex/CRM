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
    @include('forEmployees.modals.packtisch.einlagernProblemMelden')

    <form action="{{url("/")}}/crm/packtisch/abholung-abschließen/{{$intern->id}}" method="POST">
        @csrf
        @include('includes.packtisch.scan-history')

        <div style="width: 50rem" class=" bg-white rounded-md m-auto mt-6 pb-16">
            <div class="inline-block px-8 py-4 w-full">
                <div style="width: 100%">
                    <div class="w-full">
                        <h1 class="font-bold inline-block text-3xl text-blue-800 mb-5">Nachforschungsauftrag</h1>
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
                                        <p class="text-gray-600 text-xl">Bitte Gerät suchen</p>

                                        <p class="text-gray-500 text-xl mt-4">Aktueller Status <span class="text-blue-600 font-semibold">"Verloren"</span></p>

                                        <p class="text-gray-500 text-xl mt-4">Letzte bekannte Gerätenummer <span class="text-blue-600 font-semibold">{{$intern->component_number}}</span></p>
                                        <p class="text-gray-500 text-xl mt-2">Letzter bekannter Lagerplatz <span class="text-blue-600 font-semibold">@isset($shelfe) {{$shelfe->shelfe_id}} @else Unbekannt @endisset</span></p>

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
                                      <div class="">
                                        <p class="text-gray-600 text-xl pb-1">Auftragsdokumente</p>
                                          @foreach ($files->where("process_id", "nachforschungsauftrag-auftrag") as $file)
                                          <div class="mt-1 px-3 py-1 rounded-md text-blue-600 hover:text-blue-400 border border-blue-500 hover:border-blue-400 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left mt-1 mr-1">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>    
                                            <a class="float-left" href="{{url("/")}}/files/aufträge/{{$intern->process_id}}/{{$file->filename}}" target="_blank">                                            
                                              <p >{{$file->filename}}</p>
                                            </a>
                                          </div>
                                          @endforeach
                                      </div>

                                     

                                      
                                     
                                    </div>
                                    
                                  </div>
                                  <div class="ml-16"><p class="text-gray-600 text-xl mt-6">Zusätzliche Hinweise</p>
                                    <p class="text-gray-500 text-xl w-96">* {{$intern->info}}</p>
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
                                      <div class="">
                                        <p class="text-gray-600 text-xl pb-1">Extradokumente</p>
                                          @foreach ($files->where("process_id", "nachforschungsauftrag") as $file)
                                          <div class="mt-1 px-3 py-1 rounded-md text-blue-600 hover:text-blue-400 border border-blue-500 hover:border-blue-400 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 float-left mt-1 mr-1">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>    
                                            <a class="float-left" href="{{url("/")}}/files/aufträge/{{$intern->process_id}}/{{$file->filename}}" target="_blank">                                            
                                              <p >{{$file->filename}}</p>
                                            </a>
                                          </div>
                                              
                                          @endforeach
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>


                              <li class="" id="step-2">
                                <div class="relative">
                                  <div class="relative flex space-x-3">
                                    
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-4">
                                      <div class="m-auto w-full">
                                        <button type="button" onclick="document.getElementById('found-modal').classList.remove('hidden')" id="einlagern-button" class="text-white inline-block font-semibold py-1 ml-16 rounded-md bg-green-600 text-xl" style="width: 14rem">

                                          <p class="inline-block" id="submit-type-text">Gefunden</p>
  
                                        </button>
                                        <button type="button" onclick="document.getElementById('not-found-modal').classList.remove('hidden')" id="einlagern-button" class="text-white inline-block font-semibold py-1 ml-16 rounded-md bg-red-600 text-xl" style="width: 14rem">

                                            <p class="inline-block" id="submit-type-text">Nicht gefunden</p>
    
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

<form action="{{url("/")}}/crm/packtisch/nachforschungsauftrag-abschließen/{{$intern->id}}" method="POST">
  @CSRF
  <div class="relative hidden z-10" id="found-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div>
            <input type="hidden" name="foundtype" value="found">
            <div class=" text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Gefunden</h3>
              <div class="">
                <p class="text-sm text-gray-500">Bitte beschreibe wo du das Teil gefunden hast.</p>
                <textarea name="text" id="" class="h-36 w-full rounded-md border border-gray-600 mt-4"></textarea>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6 ">
            <button type="button" onclick="document.getElementById('found-modal').classList.add('hidden')" class="float-right  justify-center rounded-md bg-white border border-gray-600 px-3 py-2 text-sm font-semibold text-black shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2  sm:col-start-2">Abbrechen</button>

            <button type="submit" class="float-left mt-3  justify-center rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 sm:col-start-1 sm:mt-0">Speichern</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<form action="{{url("/")}}/crm/packtisch/nachforschungsauftrag-abschließen/{{$intern->id}}" method="POST">
  @CSRF
  <div class="relative hidden z-10" id="not-found-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div>
            <input type="hidden" name="foundtype" value="not_found">
            <div class=" text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Nicht gefunden</h3>
              <div class="">
                <p class="text-sm text-gray-500">Bitte beschreibe, wo Du gesucht hast und wieso das evtl. doch weg ist?</p>
                <textarea name="text" id="" class="h-36 w-full rounded-md border border-gray-600 mt-4"></textarea>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6">
            <button type="button" onclick="document.getElementById('not-found-modal').classList.add('hidden')" class="float-right justify-center rounded-md bg-white border border-gray-600 px-3 py-2 text-sm font-semibold text-black shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2  sm:col-start-2">Abbrechen</button>

            <button type="submit" class="mt-3 float-left justify-center rounded-md bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 sm:col-start-1 sm:mt-0">Speichern</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>





</body>
</html>