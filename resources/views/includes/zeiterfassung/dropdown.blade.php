<div id="zeiterfassung-dropdown-div-main">
<div class="absolute bg-white h-10 w-10 " style="top: 4.5rem; right: 9.5rem; transform: rotate(45deg)">

</div>
<div class="absolute bg-white px-4 pt-2 drop-shadow-md rounded-sm pb-3"  style="right: 2.5rem; width: 16.55rem; top: 5rem" >

    <button class=" bg-blue-400 hover:bg-blue-300 py-2 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4  float-left text-white  ml-4" style="margin-top: 0.2rem">
            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
        </svg>
        <p class="text-white text-sm font-medium text-center m-auto mr-4">Zeiterfassung öffnen</p>
    </button>

    <div class="w-full h-8 mt-2">
        <p class="float-left font-semibold text-md tracking-wider">Arbeitsdauer:</p>
    
        @php
            $hours = 0;
            $min = 0;
            $sec = 0;
            $usedZeiten = array();
        @endphp

        @isset($zeiten[0])
            @foreach ($zeiten as $zeit)
                @if (!in_array($zeit->id, $usedZeiten))

                    @php

                        if($zeiten->where("id", $zeit->id)->where("type", "feierabend")->first() != null) {
                            if($zeit->type == "start") {
                            $firstdate = $zeit->created_at;
                            $seconddate = $zeiten->where("id", $zeit->id)->where("type", "feierabend")->first()->created_at;
                        } else {
                            $seconddate = $zeit->created_at;
                            $firstdate = $zeiten->where("id", $zeit->id)->where("type", "start")->first()->created_at;
                        }

                        $diff = $firstdate->diff($seconddate);
                        $hours += floatval($diff->format("%H"));
                        $min += floatval($diff->format("%m"));
                        $sec += floatval($diff->format("%s"));
                    
                        if($sec >= 60) {
                            $min++;
                            $sec = 0;
                        }

                        if($min >= 60) {
                            $hours++;
                            $min = 0;
                        }

                        }

                        array_push($usedZeiten, $zeit->id);

                    @endphp

                @endif
            @endforeach
        @endisset

        <p class="float-right font-medium text-md" id="worked-time">{{$hours}}:@if ($min <= 9)0{{$min}}@else{{$min}}@endif:@if ($sec <= 9)0{{$sec}}@else{{$sec}}@endif
        </p>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 float-right text-gray-600 mr-1 mt-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg> 
    </div>

    <hr class="w-full">

    <div class="mt-4 w-full ">
        <div class="w-full h-10">
            @isset($zeiten[0])

            @php
                $newest = $zeiten->sortByDesc("created_at")->first();
            @endphp

                @if ($newest->type == "feierabend")
                    <button onclick="startZeiterfassung('{{$hours}}', '{{$min}}', '{{$sec}}')" type="button" class="px-4 py-2 cursor-pointer rounded-sm text-white bg-green-400 hover:bg-green-500 float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5 float-left mr-1">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                          </svg>              
                        <p class="float-right">START</p>
                    </button>
                @endif

                @if ($newest->type == "start")
                <button type="button" onclick="stopZeiterfassung('{{$newest->id}}')" class="px-4 py-2 cursor-pointer rounded-sm text-white bg-red-400 hover:bg-red-500 float-left">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5 float-left mr-1">
                        <path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z" />
                    </svg>              
                    <p class="float-right">STOP</p>
                </button>

                <script>
                    hr = "{{$hours}}";
                    mi = "{{$min}}";
                    se = "{{$sec}}";

                    runZeitefassungCurrentTime();
                </script>
                @endif

            @else
     
            <button onclick="startZeiterfassung('{{$hours}}', '{{$min}}', '{{$sec}}')" type="button" class="px-4 py-2 cursor-pointer rounded-sm text-white bg-green-400 hover:bg-green-500 float-right">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5 float-left mr-1">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                  </svg>              
                <p class="float-right">START</p>
            </button>
        @endisset
        </div>

        <div class="mt-4 w-full">
            <p class="font-semibold text-md tracking-wider">Online</p>

            @foreach ($onlineUsers as $on)
                <div class="w-full h-8 flex mt-2">
                    <img src="{{url("/")}}/employee/{{$on->id}}/profile.png" class="h-8 w-8 rounded-full" onerror="this.onerror=null; this.src='{{url("/")}}/img/santa.png'" >
                    <p class="ml-4 font-medium">{{$on->username}}</p>
                </div>
            @endforeach
            @if ($onlineUsers == null)
            <div class="flex text-gray-500 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>
                  <p class="ml-2">Keine Nutzer Online</p>
            </div>
              
            @endif
        </div>
    </div>

</div>
</div>