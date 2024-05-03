
<div class="flex mt-8">
    <h1 class="text-2xl font-medium pb-1">Verlauf</h1>
    <svg onclick="showHiddenTexts()" id="status-eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hidden w-5 h-5 ml-4 mt-2 hover:text-red-400 cursor-pointer">
        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
    </svg>      
    <svg onclick="showHiddenTexts()" id="status-eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-4 mt-2 hover:text-green-400 cursor-pointer">
        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
        <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
    </svg>
    
</div>

<nav class="flex" aria-label="Breadcrumb">
  <ol role="list" class="flex items-center space-x-4"> 
    @php
        $statusFlow = array("Anfrage", 
                            "Prüfung", 
                            "Technik", 
                            "Im Zulauf", 
                            "Info", 
                            "Buchhaltung", 
                            "Reklamation", 
                            "Abgeschlossen", 
                            "Archiv");
    @endphp

    @foreach ($statusFlow as $stat)
    @if ($stat == "Anfrage")
    <li>
      <div class="flex items-center">
        <a href="#" class="text-md font-medium hover:text-gray-700">Anfrage</a>
      </div>
    </li>
    @else
    <li>
      <div class="flex items-center">
        <svg class="h-6 w-6 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
        </svg>
        <a href="#" class="ml-4 text-md font-medium @if($order->statuse->sortByDesc("created_at")->first()->statuseMain->main == $stat) text-blue-400 @endif hover:text-gray-700" aria-current="page">{{$stat}}</a>
      </div>
    </li>
    @endif
    @endforeach
  </ol>
</nav>

<div class="w-full border border-gray-300 mt-2 rounded-md">

<div class="w-full">
  <div class="w-full">
      <div class="flow-root">
        <div class="">
          <div class="inline-block min-w-full py-2 align-middle overflow-auto max-h-96">
            <table class="min-w-full divide-y divide-gray-300 ">
              <thead>
                <tr>
                  <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 ">Datum</th>
                  <th scope="col" class="px-3 py-1  text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                  <th scope="col" class="px-3 py-1 float-left text-left text-sm font-semibold text-gray-900">Status</th>
                  <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-full">Info</th>
                  <th scope="col" class="relative py-1 pl-3 pr-4 overflow-visible">
                    <div class="overflow-visible">
                      <svg onclick="document.getElementById('status-filter-div').classList.toggle('hidden');" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 hover:text-blue-400 cursor-pointer">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                      </svg>  
                    </div>    
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach ($texts->where("status_state", true)->sortByDesc("created_at") as $text)
                @php
                  

                    $string = $text->message;
                    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $results);  
                    foreach ($results as $result) {
                      foreach ($result as $url) {
                        if(str_contains($url, ".")) {
                          $string = str_replace($url, "<a id='link' class='text-blue-600 hover:text-blue-400' href='$url' target='_blank'>Link öffnen</a>", $string);
                        }
                      }
                    }
                  
                    $text->message = $string;
                    
                @endphp
                
                <tr @if($text->hide == true) class="hidden bg-gray-100" @else class="h-8" @endif id="status-row-{{$text->id}}">
                    <td class="whitespace-nowrap pl-4 text-sm text-gray-500">
                        <div class="flex">
                                <svg id="status-column-eye-open-{{$text->id}}" onclick="hideText('{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 hover:text-red-400 cursor-pointer @if($text->hide != true) hidden @endif">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
                                </svg> 
                                <svg id="status-column-eye-close-{{$text->id}}" onclick="hideText('{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 hover:text-green-400 cursor-pointer @if($text->hide == true) hidden @endif">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>                                  
                            <p class="ml-1">{{$text->created_at->format("d.m.Y (H:i)")}}</p>
                        </div>
                    </td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500">@if($employees->where("id", $text->employee)->first() != null){{$employees->where("id", $text->employee)->first()->name}} @else {{$text->employee}} @endif</td>
                  <td class="whitespace-nowrap px-3 text-sm text-gray-500 float-left">
                    <div  class="px-2 float-left py-0.5 text-sm rounded-xl text-center bg-gray-100 text-black flex mt-1" style="@if($statuses->where("name", $text->status)->first() != null) background-color: {{$statuses->where("name", $text->status)->first()->color}}; @endif">
                      <p >{{$text->status}}</p>                         
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 text-sm text-gray-500" style="max-width: 25rem;">
                   <div class="flex mt-1" style="max-width: 80%;">
                    @if ($text->status == "Rückruf")
                    <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-red-400 bg-red-100 flex">
                                               
                      <p class="pl-2 text-red-600">{{$text->status}}</p>
                      <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-800 @endif" id="read-status-{{$text->id}}">•</p>        
                      <p style="max-width: 100%" class=" truncate whitespace-nowrap text-red-600 text-left">{{$text->rückruf_time}} - @php echo $text->message; @endphp</p>
                    </div>
                    @else

                      @if ($text->status == "Telefonhistorie")
                      <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5  text-sm rounded-xl text-center bg-gray-100 flex">
                        
                        <p class="pl-2">{{$text->status}}</p>
                        <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                        <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">@php echo $text->message; @endphp</p>       
                      </div>
                      @else 
                      <div class="flex" style="max-width: 100%">
                        <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')"  class="hover:bg-blue-100 cursor-pointer pl-2 float-left py-0.5 text-sm rounded-xl text-center text-gray-700 bg-gray-100 truncate">
                          <p style="max-width: 100%" class="truncate text-left">
                            <div class="flex">
                                @php 
                                  echo str_replace("py-1", "", $text->message);
                              @endphp
                            </div>
                          </p>               
                      </div>
                      
                      @if (str_contains($text->message, "@") && !str_contains($text->status, "Email"))
                        @if ($text->checked == null)
                          <p class="mt-0.5">
                              <svg onclick="setStatusZuweisungChecked('{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-2 text-green-600 hover:text-green-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                              </svg>
                          </p>

                        @else

                          <p class="mt-0.5">
                              <svg onclick="setStatusZuweisungChecked('{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-2 text-red-600 hover:text-red-400 cursor-pointer">
                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                              </svg>
                          </p>
                        @endif
                      @endif

                      
                      @if ($text->checked != null)
                      <p class="mt-0.5 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 0 0 1.33 0l1.713-3.293a.783.783 0 0 1 .642-.413 41.102 41.102 0 0 0 3.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0 0 10 2ZM6.75 6a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5Z" clip-rule="evenodd" />
                        </svg>      
                        <span class="bg-transparent text-gray-400 ml-2">{{$text->checked}}, {{$employees->where("id", $text->checked_by)->first()->username}} {{$text->checked_date}}</span>
                      </p>
                      @endif
                      </div>
                      
                    @endif
                    @endif
                   </div>
                    


                  </td>
                  <td class="relative whitespace-nowrap pl-3 text-right text-sm font-medium pr-4">
                    <svg onclick="getVerlaufErweitert(event, '{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-6 h-6 text-blue-600 hover:text-blue-400 cursor-pointer">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>                          
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
</div>
</div>
    


    <div id="entsorgung-modal">

    </div>

    <script>

      function setStatusZuweisungChecked(id) {
        loadData();
        $.get("{{url("/")}}/crm/order/zuweisung-checked/"+id, function(data) {
          updateVerlauf(data);
        })
      }


      function getEntsorgungModal(text) {
        loadData();
        let component_number = text.split(" ")[1];

        $.get("{{url("/")}}/crm/auftrag/get-entsorgung/"+component_number, function(data) {
          document.getElementById("entsorgung-modal").innerHTML = data;
          savedPOST();
        })
      }

      function getMinus(id) {
        loadData();

        $.get("{{url("/")}}/crm/entsorgung/minustime/"+id, function(data) {
          $.get("{{url("/")}}/crm/auftrag/get-entsorgung/"+id, function(data) {
          document.getElementById("entsorgung-modal").innerHTML = data;
          savedPOST();

        })
        })
      }

      function getEntSperren(id) {
        loadData();
        $.get("{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-aktivieren/"+id, function(data) {
          $.get("{{url("/")}}/crm/auftrag/get-entsorgung/"+id, function(data) {
          document.getElementById("entsorgung-modal").innerHTML = data;
          savedPOST();

        })
        })
      }

      function getEntSperrenAkt(id) {
        loadData();
        $.get("{{url("/")}}/crm/packtisch/lagerplatzübersicht/entsorgungssperre-deaktivieren/"+id, function(data) {
          $.get("{{url("/")}}/crm/auftrag/get-entsorgung/"+id, function(data) {
          document.getElementById("entsorgung-modal").innerHTML = data;
          savedPOST();

        })
        })
      }

      function getPlus(id) {
        loadData();

        $.get("{{url("/")}}/crm/entsorgung/extendtime/"+id, function(data) {
          $.get("{{url("/")}}/crm/auftrag/get-entsorgung/"+id, function(data) {
          document.getElementById("entsorgung-modal").innerHTML = data;
          savedPOST();

        })
        })
      }

     
    </script>