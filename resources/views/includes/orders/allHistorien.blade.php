@isset($texts[0])
<h1 class="text-2xl font-medium pb-4" style="margin-top: -1rem">Verlauf</h1>

<div class="w-full border border-gray-300  rounded-md">
  <div class="w-full">
      <div class=" flow-root">
        <div class="">
          <div class="inline-block min-w-full overflow-auto py-2 align-middle max-h-96">
            <table class="min-w-full divide-y divide-gray-300">
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
                @foreach ($texts->where("hide", null)->sortByDesc("created_at") as $text)
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
                  <td class="whitespace-nowrap  pl-4 text-sm text-gray-500">{{$text->created_at->format("d.m.Y (H:i)")}}</td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500">@if($employees->where("id", $text->employee)->first() != null){{$employees->where("id", $text->employee)->first()->name}} @else {{$text->employee}} @endif</td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500 float-left">
                    <div  class="mt-1 px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex" style="@if($statuses->where("name", $text->status)->first() != null) color: {{$statuses->where("name", $text->status)->first()->text_color}}; @endif">
                      <p >{{$text->status}}</p>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                      </svg>                            
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3  text-sm text-gray-500" style="max-width: 20rem">
                    @if ($text->status == "Rückruf")
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                      <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                    </svg>   
                    <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="mt-1 hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-red-400 bg-red-100 flex">
                                               
                      <p class="pl-2 text-red-600">{{$text->status}}</p>
                      <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-800 @endif" id="read-status-{{$text->id}}">•</p>        
                      <p style="max-width: 100%" class=" truncate whitespace-nowrap text-red-600 text-left">{{$text->rückruf_time}} - @php echo $text->message; @endphp</p>
                    </div>
                    @else

                      @if ($text->status == "Telefonhistorie")
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-1.5 text-gray-400 float-left mr-2">
                        <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                      </svg> 
                      <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')" style="max-width: 90%" class="mt-1  hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5  text-sm rounded-xl text-center border border-gray-400 flex">
                        
                        <p class="pl-2">{{$text->status}}</p>
                        <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                        <p style="max-width: 90%" class=" truncate whitespace-nowrap text-left">@php echo $text->message; @endphp</p>       
                      </div>

                      @else

                      @if ($text->message == "Neuer Status gebucht")
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                          <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                        </svg> 
                        <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')"style="max-width: 90%"  class="mt-1  hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">

                          <p class="pl-2">Status</p>
                          <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                          <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->status)}}</p>     
                        </div>

                          @else
                          
                          @if ($text->status == "Entsorgung")
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <div onclick="getEntsorgungModal('{{$text->message}}')"style="max-width: 90%"  class="mt-1 hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                            
                            <p class="pl-2">{{$text->status}}</p>
                            <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                            <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->message)}}</p>     
                          </div>
                          @else

                          @if ($text->status == "Sendungsverfolgung")
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <div onclick="getTrackingDetails('{{$text->message}}', '{{$text->created_at->format('d.m.Y (H:i)')}}')"style="max-width: 90%"  class="mt-1 hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                            
                            <p class="pl-2">{{$text->status}}</p>
                            <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                            <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->message)}}</p>     
                          </div>

                          @else

                          @if ($text->status == "Kundenversand-versendet")
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <div onclick="getVersandDetails('{{$text->message}}')"style="max-width: 90%"  class="mt-1 hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                            
                            <p class="pl-2">{{$text->status}}</p>
                            <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                            <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->message)}}</p>     
                          </div>

                          @else
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-1.5 w-5 h-5 text-gray-400 float-left mr-2">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <div onclick="getVerlaufErweitert(event ,'{{$text->id}}')"style="max-width: 90%"  class="mt-1 hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                            <p class="pl-2">{{$text->status}}</p>
                            <p class="px-2 @if($text->read_state == "true") text-green-600 @else text-red-600 @endif" id="read-status-{{$text->id}}">•</p>        
                            <p style="max-width: 100%" class=" truncate whitespace-nowrap text-left">{{strip_tags($text->message)}}</p>     
                          </div>
                          @endif
                          @endif

                          
                          @endif
                      @endif
                      
                    @endif
                    @endif
                    


                  </td>
                  <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium ">
                    <svg onclick="getVerlaufErweitert(event, '{{$text->id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right mt-1 w-6 h-6 text-blue-600 hover:text-blue-400 cursor-pointer">
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
@foreach ($texts as $text)
<script>
  hiddenTexts.push('{{$text->id}}');
</script>
@endforeach
@endisset


<div id="entsorgung-modal">

</div>


<script>

function getVersandErweitert(event, id) {
  $.get("{{url("/")}}/crm/order/versand-info-"+id, function(data) {
    document.getElementById("versand-erweitert-modal").innerHTML = data;
  })
}

function getSendungsverlauf(id, date) {
      loadData();
        $.get("{{url("/")}}/crm/tracking-get-history-"+id, function(datas) {
            if(datas.length != 0) {
                console.log(datas);
                var parent = document.getElementById("sendungsverlauf-liste");
                parent.innerHTML = "";

                if(typeof datas == "object") {
                  
                  datas = Object.entries(datas);
                }
                
                datas.forEach(data => {
                  saveD = data;
                  data = data[1];
                  if(data == null) {
                    data = saveD[0];
                  }
                    var html = '<li class="relative flex gap-x-4">  <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">    <div class="w-px bg-gray-200"></div>  </div>  <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>  </div>  <p class="flex-auto py-0.5 text-md leading-5 text-gray-500">'+ data["status"] +'</p>  <time datetime="2023-01-23T11:03" class="flex-none py-0.5 text-md leading-5 text-gray-500">'+ data["date"] +'</time></li>'
                    var div = document.createElement("div");
                    div.innerHTML = html;
                    parent.appendChild(div);
                });

                document.getElementById("sendungsverlauf-sendungsnummer").innerHTML = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-carrier").innerHTML               = datas[0][1]["carrier"];
                document.getElementById("tracking-trackingnumber").innerHTML        = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-created_at").innerHTML            = date;

                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ datas[0][1]["trackingnumber"];

                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("error-tracking").classList.add("hidden");
                document.getElementById("sendungsverlauf-div").classList.remove("hidden");

            } else {
                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ id;
                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("sendungsverlauf-div").classList.add("hidden");
                document.getElementById("error-tracking").classList.remove("hidden");

            }
            savedPOST();
        });
        
    }
  function getTrackingDetails(id, date) {
    loadData();
    $.get("{{url("/")}}/crm/tracking-get/{{$order->process_id}}", function(data) {
          document.getElementById("custom-tracking-div").innerHTML = data;
          $.get("{{url("/")}}/crm/tracking-get-history-"+id, function(datas) {
            if(datas.length != 0) {
                console.log(datas);
                var parent = document.getElementById("sendungsverlauf-liste");
                parent.innerHTML = "";

                if(typeof datas == "object") {
                  
                  datas = Object.entries(datas);
                }
                
                datas.forEach(data => {
                  saveD = data;
                  data = data[1];
                  if(data == null) {
                    data = saveD[0];
                  }
                    var html = '<li class="relative flex gap-x-4">  <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">    <div class="w-px bg-gray-200"></div>  </div>  <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>  </div>  <p class="flex-auto py-0.5 text-md leading-5 text-gray-500">'+ data["status"] +'</p>  <time datetime="2023-01-23T11:03" class="flex-none py-0.5 text-md leading-5 text-gray-500">'+ data["date"] +'</time></li>'
                    var div = document.createElement("div");
                    div.innerHTML = html;
                    parent.appendChild(div);
                });

                document.getElementById("sendungsverlauf-sendungsnummer").innerHTML = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-carrier").innerHTML               = datas[0][1]["carrier"];
                document.getElementById("tracking-trackingnumber").innerHTML        = datas[0][1]["trackingnumber"];
                document.getElementById("tracking-created_at").innerHTML            = date;

                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ datas[0][1]["trackingnumber"];

                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("error-tracking").classList.add("hidden");
                document.getElementById("sendungsverlauf-div").classList.remove("hidden");

            } else {
                document.getElementById("delete-tracking").href = "{{url("/")}}/crm/tracking/delete-sendungsnummer-"+ id;
                document.getElementById("delete-tracking").classList.remove("hidden");
                document.getElementById("sendungsverlauf-div").classList.add("hidden");
                document.getElementById("error-tracking").classList.remove("hidden");

            }
            savedPOST();
        });
    });
  }

  function getVersandDetails(id) {
    loadData();
    $.get("{{url("/")}}/crm/packtisch/allhistory-tracking/"+id, function(data) {
      savedPOST();
      document.getElementById("verlauf-erweitert").innerHTML = data;

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