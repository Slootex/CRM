<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="{{url('/')}}/js/text.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

  
    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">
    <h1 class="py-6 text-4xl font-bold ml-10 text-white"><span class="float-left">Einstellungen</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     Datei-Manager</h1>

    <div class="m-auto sm:px-6 lg:px-8" style="width: 80rem">

      <div class="mt-6">
        <div class="sm:hidden">
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option>System</option>
      
            <option>Custom</option>

          </select>
        </div>
        <div class="hidden sm:block">
          <form action="{{url("/")}}/crm/dateimanager/upload" method="POST" enctype="multipart/form-data">
            @CSRF
            <nav class=" w-full" aria-label="Tabs">
                <!-- Current: "bg-gray-200 text-gray-800", Default: "text-gray-600 hover:text-gray-800" -->
                
                <div class=" inline-block float-left  items-center justify-center bg-grey-lighter">
                    <label class="w-64 flex flex-col items-center px-4 py-1.5 bg-white text-blue rounded-lg g tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                        
                        <span class="mt-0 text-base leading-normal"><span class="float-left" id="filename">Datei</span>  <svg class="w-5 h-5 float-left  ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg></span>
                        <input type='file' oninput="document.getElementById('filename').innerHTML = this.value" class="hidden" name="file" />
                    </label>
                </div>
                <button type="submit"  class="bg-blue-600 hover:bg-blue-500 inline-block text-white hover:text-gray-800 px-5 py-2 ml-16 font-medium text-normal rounded-md"><span class="">Hochladen</span> </button>
                <button type="button" onclick="document.getElementById('bookmark-files').classList.remove('hidden')" class="inline-block float-right bg-yellow-600 rounded-md w-12 h-12 text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 m-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                  </svg>                  
                </button>
              </nav>
          </form>
          
        </div>
        
      </div>

      <script>
        function changeTab(tab, old) {

          document.getElementById(tab).classList.remove("hidden");
          document.getElementById(tab + "tab").classList.remove("text-gray-600");
          document.getElementById(tab + "tab").classList.add("text-blue-600");
          document.getElementById(old + "tab").classList.remove("text-blue-600");
          document.getElementById(old + "tab").classList.add("text-gray-600");
          document.getElementById(old).classList.add("hidden");

        }
      </script>
        
       
        <div class="px-4 sm:px-6 lg:px-8 hidden" id="system">
          

            <div class=" flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-hidden sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-hidden h-96 ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-normal text-gray-900">Datum</th>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-normal text-gray-900">Name</th>
                          <th scope="col" class="px-3 py-1 text-left text-normal font-normal text-gray-900">Größe</th>
                          <th scope="col" class="px-3 pr-6 py-1 text-right text-normal font-normal text-gray-900">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                     
                       
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-lg md:rounded-lg" id="custom">
            
  

                    <table class="divide-y divide-gray-300 m-auto mt-16 rounded-t-lg" style="width: 76rem;">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-3 py-1 text-center font-normal text-normal text-gray-900 rounded-tl-lg">Datum</th>
                          <th scope="col" class="px-3 py-1 text-left pl-16 font-normal text-normal text-gray-900">Name</th>
                          <th scope="col" class="px-3 py-1 text-center font-normal text-normal text-gray-900">Größe</th>
                          <th scope="col" class="px-3 py-1 pr-7 text-right font-normal text-normal text-gray-900 rounded-tr-lg">
                            <span >Aktion</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white ">
                       
                        @foreach ($files as $file)
                        @if ($file->dateimangager_system != "true")
                        <tr>
                          <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-center ">{{$file->created_at->format("d.m.Y")}}</td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-center">
                        <a href="#" onclick="changeInputHidden('{{$file->id}}')" id="{{$file->id}}-change" >
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 rounded-lg p-1 bg-green-600 text-white ml-0 mr-6 float-left">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                      </a>
                      <a href="#" onclick="changeInputShow('{{$file->id}}', '{{explode('.', $file->filename)[1]}}')" id="{{$file->id}}-check" class="hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 rounded-lg p-1 bg-blue-600 hover:bg-blue-500 text-white ml-0 mr-6 float-left">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>                          
                      </a>
                        <div id="{{$file->id}}" onmouseover="document.getElementById('{{$file->id}}-dropdown').classList.remove('hidden')" onmouseout="document.getElementById('{{$file->id}}-dropdown').classList.add('hidden')">
                          <a target="_blank"  id="{{$file->id}}-a" class="text-blue-600 underline float-left mt-1" href="{{url("/")}}/dateimanager/{{$file->filename}}">{{$file->filename}}</a> 
                          <input type="text" id="{{$file->id}}-input" class="hidden float-left h-7 rounded border-gray-600" style="width: 7rem;" value="{{explode('.', $file->filename)[0]}}">

                          <div class="absolute mt-6 inline-block text-left ml-36 hidden" id="{{$file->id}}-dropdown" >

                          
                            <!--
                              Dropdown menu, show/hide based on menu state.
                          
                              Entering: "transition ease-out duration-100"
                                From: "transform opacity-0 scale-95"
                                To: "transform opacity-100 scale-100"
                              Leaving: "transition ease-in duration-75"
                                From: "transform opacity-100 scale-100"
                                To: "transform opacity-0 scale-95"
                            -->
                            <div class="absolute right-0 z-10 mt-2  origin-top-right rounded-md bg-gray-50 text-blue-400 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                              <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <p class="text-blue-400 block px-4 py-2 text-md" role="menuitem" tabindex="-1" id="menu-item-0">{{public_path()}}\dateimanager\{{$file->filename}}</p>
                              </div>
                            </div>
                          </div>


                        </div>
                       
                      </td>
                      <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-700 text-center">{{$file->größe}} KB</td>
                      <td class="whitespace-nowrap px-3 py-2 pr-6 text-sm text-red-600 underline text-right"><a href="{{url("/")}}/crm/dateimanager/löschen/{{$file->id}}">Löschen</a></td>
                      </tr>
                        @endif
                        @endforeach

                      
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   

            function changeInputHidden(id) {
              document.getElementById(id + "-a").classList.add("hidden");
              document.getElementById(id + "-input").classList.remove("hidden");
              document.getElementById(id + "-change").classList.add("hidden");
              document.getElementById(id + "-check").classList.remove("hidden");
              
            }

            function changeInputShow(id, ext) {
              if(!document.getElementById(id + "-input").value.includes(".")) {
                document.getElementById(id + "-a").classList.remove("hidden");
                document.getElementById(id + "-input").classList.add("hidden");
                document.getElementById(id + "-change").classList.remove("hidden");
                document.getElementById(id + "-check").classList.add("hidden");
                document.getElementById(id + "-a").innerHTML = document.getElementById(id + "-input").value + "." + ext;

                $.post( "{{url('/')}}/crm/dateimanger/edit", { name: document.getElementById(id + "-input").value + "." + ext , id: id } )
                .done(function(data) {
                 window.location.href = "{{url("/")}}/crm/dateimanager";
                });
              } else {
                document.getElementById("ext-error").classList.toggle("hidden");
              }
             
            }
          </script>
         
    </div>
      
    <br>
    <br>
    <br>

    @isset($deletedFiles)
        <div id="finishFiles">
          @include('forEmployees.modals.dateiVerteilungFinish')
        </div>
    @endisset


    <div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ext-error">
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
    
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <!--
            Modal panel, show/hide based on modal state.
    
            Entering: "ease-out duration-300"
              From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100 translate-y-0 sm:scale-100"
              To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          -->
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left  transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation-triangle -->
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Fehlermeldung!</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Der Dateiname darf keinen Punkt(.) enthalten</p>
                </div>
              </div>
    
    
    
    
    
             
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
              <button type="button" onclick="document.getElementById('ext-error').classList.toggle('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Zurück</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 hidden animate__animated" id="saved">
      <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <!--
          Notification panel, dynamically insert this into the live region when it needs to be displayed
    
          Entering: "transform ease-out duration-300 transition"
            From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            To: "translate-y-0 opacity-100 sm:translate-x-0"
          Leaving: "transition ease-in duration-100"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">Erfolgreich</p>
                <p class="mt-1 text-sm text-gray-500">Die Datei wurde erfolgreich gespeichert</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@include('forEmployees.modals.dateimanger-system')
    
</body>
</html>