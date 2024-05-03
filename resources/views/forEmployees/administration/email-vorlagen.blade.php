<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
  <script src="{{url('/')}}/js/text.js"></script>
  <link rel="stylesheet" href="{{url("/")}}/css/animations.css">
  <link rel="stylesheet" href="{{url('/')}}/css/text.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  @vite('resources/css/app.css')



</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    
  
    <h1 class="py-6 text-4xl font-bold ml-10 text-black"><span class="float-left">Einstellungen</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 float-left font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
     E-Mail-Vorlagen</h1>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        
        <div class="pt-6">
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('system')" ><a href="#" id="system-tab" class="py-2 px-4 bg-gray-700 rounded-md">System</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('benutzer')" ><a href="#" id="benutzer-tab" class="py-2 px-4 hover:bg-gray-700 rounded-md">Benutzer</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" onclick="changeTab('fest')" ><a href="#" id="fest-tab" class="py-2 px-4 hover:bg-gray-700 rounded-md">Fester Empfänger</a></h1>
          <h1 class="float-left px-6 text-white text-normal font-semibold" ><a onclick="neueEmailVorlage()"  href="#" id="fest-tab" class="py-2 bg-blue-600 hover:bg-blue-500 px-4 hover:bg-blue-700 rounded-md">neue E-Mail Vorlage</a></h1>
    
        </div>
    
          <br>
    
          <div id="system">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Bereich</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Betreff</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Datei</th>
                            <th scope="col" class="px-3 w-36 py-2 text-right text-normal font-semibold text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @php
                          $counter1 = 0;
                      @endphp
                          @foreach ($systememails as $text)
                          @if ($text->empfänger == "" || $text->empfänger == null)
                          <tr id="{{$text->id}}-template-row">
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter1 == $systememails->count() -1) rounded-bl-lg @endif" id="{{$text->id}}-template-name">{{$text->name}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-type">
                            @if ($text->type == 0)
                              Abholen
                            @endif
                            @if ($text->type == 1)
                              Aufträge
                            @endif  
                            @if ($text->type == 2)
                              Versand
                            @endif  
                            @if ($text->type == 3)
                              Kunden
                            @endif  
                            @if ($text->type == 4)
                              Interessenten
                            @endif    
                            @if ($text->type == 5)
                              Einkäufe
                            @endif  
                            @if ($text->type == 6)
                              Retouren
                            @endif  
                            @if ($text->type == 7)
                              Packtisch
                            @endif  
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-subject">{{$text->subject}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-file">@if ($text->file != "")
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                              </svg>               
                            @endif</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter1 == $systememails->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="readEmailBearbeiten('{{$text->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                          @endif
                          @php
                              
                              $counter1++;
                          @endphp
                          @endforeach
            
                          <!-- More people... -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="benutzer" class="hidden">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4" id="custom-email-table">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Bereich</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Betreff</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Datei</th>
                            <th scope="col" class="px-3 w-36 py-2 text-right text-normal font-semibold text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @php
                          $counter2 = 0;
                      @endphp
                          @foreach ($customemails as $text)
                          @if ($text->empfänger == "" || $text->empfänger == null)
                          <tr id="{{$text->id}}-template-row">
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter2 == $customemails->count() -1) rounded-bl-lg @endif" id="{{$text->id}}-template-name">{{$text->name}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-type">
                            @if ($text->type == 0)
                              Abholen
                            @endif
                            @if ($text->type == 1)
                              Aufträge
                            @endif  
                            @if ($text->type == 2)
                              Versand
                            @endif  
                            @if ($text->type == 3)
                              Kunden
                            @endif  
                            @if ($text->type == 4)
                              Interessenten
                            @endif    
                            @if ($text->type == 5)
                              Einkäufe
                            @endif  
                            @if ($text->type == 6)
                              Retouren
                            @endif  
                            @if ($text->type == 7)
                              Packtisch
                            @endif  
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-subject">{{$text->subject}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-file">@if ($text->file != "")
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                              </svg>               
                            @endif</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter2 == $customemails->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="readEmailBearbeiten('{{$text->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                          @endif
                          @php
                              
                          $counter2++;
                      @endphp
                          @endforeach
            
                          <!-- More people... -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="fest" class="hidden">
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden  ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="w-3/5 m-auto divide-y divide-gray-300 mt-4" id="festemp-email-table">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900 rounded-tl-lg">Name</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Bereich</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Betreff</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Empfänger</th>
                            <th scope="col" class="px-3 w-36 py-2 text-left text-normal font-semibold text-gray-900">Datei</th>
                            <th scope="col" class="px-3 w-36 py-2 text-right text-normal font-semibold text-gray-900 rounded-tr-lg">
                              <span >Aktion</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @php
                          $counter3 = 0;
                      @endphp
                          @foreach ($customemails as $text)
                          @if ($text->empfänger != null && $text->empfänger != "")
                          <tr id="{{$text->id}}-template-row">
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter3 == $customemails->count() -1) rounded-bl-lg @endif" id="{{$text->id}}-template-name">{{$text->name}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-type">
                            @if ($text->type == 0)
                              Abholen
                            @endif
                            @if ($text->type == 1)
                              Aufträge
                            @endif  
                            @if ($text->type == 2)
                              Versand
                            @endif  
                            @if ($text->type == 3)
                              Kunden
                            @endif  
                            @if ($text->type == 4)
                              Interessenten
                            @endif    
                            @if ($text->type == 5)
                              Einkäufe
                            @endif  
                            @if ($text->type == 6)
                              Retouren
                            @endif  
                            @if ($text->type == 7)
                              Packtisch
                            @endif  
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-subject">{{$text->subject}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-empfänger">{{$text->empfänger}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-file">@if ($text->file != "")
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                              </svg>               
                            @endif</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter3 == $customemails->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="readEmailBearbeiten('{{$text->id}}') " class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                          @endif
                          @php
                              
                          $counter3++;
                      @endphp
                          @endforeach
                          @php
                          $counter4 = 0;
                      @endphp
                          @foreach ($systememails as $text)
                          @if ($text->empfänger != null && $text->empfänger != "")
                          <tr id="{{$text->id}}-template-row">
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 @if($counter4 == $systememails->count() -1) rounded-bl-lg @endif" id="{{$text->id}}-template-name">{{$text->name}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-type">
                            @if ($text->type == 0)
                              Abholen
                            @endif
                            @if ($text->type == 1)
                              Aufträge
                            @endif  
                            @if ($text->type == 2)
                              Versand
                            @endif  
                            @if ($text->type == 3)
                              Kunden
                            @endif  
                            @if ($text->type == 4)
                              Interessenten
                            @endif    
                            @if ($text->type == 5)
                              Einkäufe
                            @endif  
                            @if ($text->type == 6)
                              Retouren
                            @endif  
                            @if ($text->type == 7)
                              Packtisch
                            @endif  
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-subject">{{$text->subject}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-empfänger">{{$text->empfänger}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" id="{{$text->id}}-template-file">@if ($text->file != "")
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                              </svg>                           
                            @endif</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-1 text-right text-sm font-medium @if($counter4 == $systememails->count() -1) rounded-br-lg @endif">
                              <button type="button" onclick="readEmailBearbeiten('{{$text->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                            </td>
                        </tr>
                          @endif
                          @php
                              
                          $counter4++;
                      @endphp
                          @endforeach
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          
            
                          <!-- More people... -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         

          <script>
            let tabs = ["system", "benutzer", "fest"];
            let currenttab = "system";
            function changeTab(tab) {
              tabs.forEach(element => {
                if(element != tab) {
                  document.getElementById(element).classList.add("hidden");
                  document.getElementById(element + "-tab").classList.remove("bg-gray-700");
                } else {
                  document.getElementById(element).classList.remove("hidden");
                  document.getElementById(element + "-tab").classList.add("bg-gray-700");

                  currenttab = element;
                }
              });
            }

          </script>
          


        
         <form id="emailvorlage-bearbeiten-form" method="POST" enctype="multipart/form-data">
            @CSRF
            @include('forEmployees.modals.emailVorlagenBearbeiten')
        </form>
    </div>

    <script>

      function readEmailBearbeiten(id) {

        $.get('{{url('/')}}/crm/emailsetting/bearbeiten/' + id, function( data ) {

          let template  = data[0];
          let file      = data[1];

          document.getElementById('emailvorlage-bearbeiten-form').action = '{{url("/")}}/crm/emailsetting/change/' + id;

          document.getElementById('emailvorlage-bereich').value     = template["type"];
          
          document.getElementById('emailvorlage-name').value       = template["name"];
          document.getElementById('emailvorlage-emp').value  = template["empfänger"];
          document.getElementById('emailvorlage-absender').value   = template["absender"];
          document.getElementById('emailvorlage-subject').value    = template["subject"]; 

          if(template["file"] != null) {
            document.getElementById('emailvorlage-file').innerHTML    = template["file"]; 
          } else {
            document.getElementById('emailvorlage-file').innerHTML    = ""; 
          }
          document.getElementById('emailvorlage-fileinput').value     = null; 

          document.getElementById('emailvorlage-delete-button').setAttribute("onclick", "deleteEmailVorlage('" + template['id'] + "')");

          document.getElementById("emailvorlage-bearbeiten-remove-pdf").setAttribute("onclick", "deletePDF('" + template["id"] + "')");

          if(template["file"] != null) {
            let filesplit = template["file"].split(".");
            let file_ext  = filesplit[filesplit.length - 1];
            document.getElementById("emailvorlage-bearbeiten-ansehen-pdf").setAttribute("href", "{{url("/")}}/mailAttachs/template-" + template["id"] + "." + file_ext);
          }

          $('#emailvorlagen-text').trumbowyg('empty');
          $('#emailvorlagen-text').trumbowyg('html', template["body"]);

          document.getElementById(template["id"] + '-template-row').classList.remove('update-row-animation');

          document.getElementById('emailvorlage-bearbeiten-modal').classList.remove('hidden');

        });

      }


      $(document).ready(function() { 
        $('#emailvorlage-bearbeiten-form').ajaxForm(function( data ) { 
          let template  = data[0];
          let file      = data[1];

          if(document.getElementById(template["id"] + "-template-row")) {
            if(template["type"] == 0) {
            document.getElementById(template["id"] + '-template-type').innerHTML    = "Abholen";
            }
            if(template["type"] == 1) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Aufträge";
            }
            if(template["type"] == 2) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Versand";
            }
            if(template["type"] == 3) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Kunden";
            }
            if(template["type"] == 4) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Interessenten";
            }
            if(template["type"] == 5) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Einkäufe";
            }
            if(template["type"] == 6) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Retouren";
            }
            if(template["type"] == 7) {
              document.getElementById(template["id"] + '-template-type').innerHTML    = "Packtisch";
            }

            document.getElementById(template["id"] + '-template-name').innerHTML        = template["name"];

            if(document.getElementById(template["id"] + '-template-empfänger')) {
              document.getElementById(template["id"] + '-template-empfänger').innerHTML = template["empfänger"];
            }

            document.getElementById(template["id"] + '-template-subject').innerHTML     = template["subject"];

            if(template["file"] != null) {
              document.getElementById(template["id"] + '-template-file').innerHTML      = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">   <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /> </svg>';
            }

            document.getElementById('emailvorlage-bearbeiten-modal').classList.add('hidden');
            document.getElementById(template["id"] + '-template-row').classList.add('update-row-animation');

          } else {
            let table;
            if(template["empfänger"] != null) {
              table     = document.getElementById('festemp-email-table');
            } else {
              table     = document.getElementById('custom-email-table');
            }

            let row = table.insertRow(-1);
            row.setAttribute("id", template["id"] + "-template-row");

            let cell1 = row.insertCell(0);
            cell1.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
            cell1.setAttribute("id", template["id"] + "-template-name");
            cell1.innerHTML = template["name"];

            let cell2 = row.insertCell(1);
            cell2.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
            cell2.setAttribute("id", template["id"] + "-template-type");
            if(template["type"] == 0) {
              cell2.innerHTML    = "Abholen";
            }
            if(template["type"] == 1) {
              cell2.innerHTML    = "Aufträge";
            }
            if(template["type"] == 2) {
              cell2.innerHTML    = "Versand";
            }
            if(template["type"] == 3) {
              cell2.innerHTML    = "Kunden";
            }
            if(template["type"] == 4) {
              cell2.innerHTML    = "Interessenten";
            }
            if(template["type"] == 5) {
              cell2.innerHTML    = "Einkäufe";
            }
            if(template["type"] == 6) {
              cell2.innerHTML    = "Retouren";
            }
            if(template["type"] == 7) {
              cell2.innerHTML    = "Packtisch";
            }

            let cell3 = row.insertCell(2);
            cell3.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
            cell3.setAttribute("id", template["id"] + "-template-subject");
            cell3.innerHTML = template["subject"];

            if(template["empfänger"] == null) {
              let cell4 = row.insertCell(3);
              cell4.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
              cell4.setAttribute("id", template["id"] + "-template-file");
              if(template["file"] != null) {
                cell4.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">   <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /> </svg>';
              }

              let cell5 = row.insertCell(4);
              cell5.classList.add("relative", "whitespace-nowrap", "py-1", "pl-3", "pr-1", "text-right", "text-sm", "font-medium");
              cell5.innerHTML = '<button type="button" onclick="readEmailBearbeiten(' + "'" + template["id"] + "'" + ')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>'
            } else {
              let cell4 = row.insertCell(3);
              cell4.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
              cell4.setAttribute("id", template["id"] + "-template-empfänger");
              cell4.innerHTML = template["empfänger"];

              let cell5 = row.insertCell(4);
              cell5.classList.add("whitespace-nowrap", "px-3", "py-1", "text-sm", "text-gray-500");
              cell5.setAttribute("id", template["id"] + "-template-file");
              if(template["file"] != null) {
                cell5.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">   <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /> </svg>';;
              }
            
              let cell6 = row.insertCell(5);
              cell6.classList.add("relative", "whitespace-nowrap", "py-1", "pl-3", "pr-1", "text-right", "text-sm", "font-medium");
              cell6.innerHTML = '<button type="button" onclick="readEmailBearbeiten(' + "'" + template["id"] + "'" + ')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200  px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>'
            }
            document.getElementById('emailvorlage-bearbeiten-modal').classList.add('hidden');
            document.getElementById(template["id"] + '-template-row').classList.add('update-row-animation');
            
            document.getElementById(template["id"] + '-template-row').scrollIntoView();


          }

          savedPOST();
        }); 
      });

      function deleteEmailVorlage(id) {

        $.get("{{url('/')}}/crm/emailsetting/löschen/" + id, function() {
          document.getElementById('emailvorlage-bearbeiten-modal').classList.add('hidden');
          document.getElementById(id + '-template-row').classList.add('remove-row-animation');

          setTimeout(
            function() {
              document.getElementById(id + '-template-row').classList.add('hidden');
            }, 1400);
        });
      }

      function neueEmailVorlage() {
          document.getElementById('emailvorlage-bearbeiten-form').action = '{{url("/")}}/crm/emailsetting/change';

          document.getElementById('emailvorlage-bereich').value    = 0;
          
          document.getElementById('emailvorlage-name').value       = "";
          document.getElementById('emailvorlage-empfänger').value  = "";
          document.getElementById('emailvorlage-absender').value   = "";
          document.getElementById('emailvorlage-subject').value    = "";

          document.getElementById('emailvorlage-file').innerHTML    = ""; 

          document.getElementById('emailvorlage-fileinput').value     = null; 

          document.getElementById('emailvorlage-delete-button').classList.add("hidden");


          $('#emailvorlagen-text').trumbowyg('empty');

          document.getElementById('emailvorlage-bearbeiten-modal').classList.remove('hidden');

      }

    </script>
      

</body>
</html>