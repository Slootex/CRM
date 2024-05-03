@if($texts->where("status", "Telefonhistorie")->where("hide", null)->first() != null)
<h1 class="text-2xl font-medium pb-4">Verlauf</h1>

<div class="w-full border border-gray-300  rounded-md">

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
                  <th scope="col" class="relative py-1 pl-3 pr-4">
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach ($texts->where("status", "Telefonhistorie")->sortByDesc("created_at") as $text)
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
                
                <tr @if($text->hide == true) class="hidden" @endif>
                  <td class="whitespace-nowrap pl-4 text-sm text-gray-500">{{$text->created_at->format("d.m.Y (H:i)")}}</td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500">@if($employees->where("id", $text->employee)->first() != null){{$employees->where("id", $text->employee)->first()->name}} @else {{$text->employee}} @endif</td>
                  <td class="whitespace-nowrap px-3 text-sm text-gray-500 float-left">
                    <div  class="px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex" style="@if($statuses->where("name", $text->status)->first() != null) color: {{$statuses->where("name", $text->status)->first()->text_color}}; @endif">
                      <p >{{$text->status}}</p>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                      </svg>                            
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500" style="max-width: 20rem">
                    @if ($text->status == "Rückruf")
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1 w-5 h-5 text-gray-400 float-left mr-2">
                      <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                    </svg>   
                    <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-red-400 bg-red-100 flex">
                                               
                      <p class="pl-2 text-red-600">{{$text->status}}</p>
                      <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-800 @endif" id="read-status-{{$text->id}}">•</p>        
                      <p style="max-width: 100%" class=" truncate whitespace-nowrap text-red-600 text-left">{{$text->rückruf_time}} - @php echo $text->message; @endphp</p>
                    </div>
                    @else

                      @if ($text->status == "Telefonhistorie")
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1 text-gray-400 float-left mr-2">
                        <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                      </svg> 
                      <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5  text-sm rounded-xl text-center border border-gray-400 flex">
                        
                        <p class="pl-2">{{$text->status}}</p>
                        <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                        <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">@php echo $text->message; @endphp</p>       
                      </div>
                      @else
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1 w-5 h-5 text-gray-400 float-left mr-2">
                        <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                      </svg> 
                      <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')"style="max-width: 90%"  class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                        
                        <p class="pl-2">{{$text->status}}</p>
                        <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                        <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->message)}}</p>     
                      </div>
                      
                    @endif
                    @endif
                    


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
@endif
    


    <div id="entsorgung-modal">

    </div>

    <script>


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