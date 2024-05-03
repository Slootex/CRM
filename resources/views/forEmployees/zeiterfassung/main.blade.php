<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{url('/')}}/js/countdown.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

  @vite('resources/css/app.css')
</head>
<body>

  <style>
    #test {
      -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" /></svg>');
  background-repeat: no-repeat;
  background-position-x: 100%;
  background-position-y: 5px;
    }
  </style>

@include('layouts/top-menu', ["menu" => "setting"])
  <div class="pl-16 pt-2">
    <h1 class="font-bold text-4xl text-black">Zeiterfassung</h1>
  </div>
  <div class="pt-4">
    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">
  </div>
  <div class="px-16 float-left">
    
    <div class="pt-4">
      <select name="" onchange="window.location.href = '{{url('/')}}/crm/zeiterfassungs/übersicht/' + this.value" id="test" class="w-48 h-9 rounded-md py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6" style=''>
        <option value="{{$selectedEmployee->id}}">{{$selectedEmployee->name}}</option>
        @foreach ($employees as $employee)
            @if ($employee->id != $selectedEmployee->id)
              <option value="{{$employee->id}}">{{$employee->name}}</option>
            @endif
        @endforeach
      </select>
    </div>

    <div class="pt-5">
      <div class="w-48 h-auto pb-3 bg-white rounded-md">
        <div class="absolute float-right right text-right w-48">
          <a href="#"><svg xmlns="http://www.w3.org/2000/svg" onclick="changeEditMode()" id="editSvg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right mt-2 mr-2 text-blue-800">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
          </svg></a>

          <a href="#"><svg xmlns="http://www.w3.org/2000/svg" onclick="checkEditMode()" id="checkSvg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden float-right mt-2 mr-2 text-green-800">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg></a>
          

          <script>
            function changeEditMode() {
                document.getElementById("editSvg").classList.add("hidden");
                document.getElementById("checkSvg").classList.remove("hidden");

                document.getElementById("workDays").classList.add("hidden");
                document.getElementById("workDaysEdit").classList.remove("hidden");
                document.getElementById("workDaysEdit").value = document.getElementById("workDays").innerHTML;

                document.getElementById("urlaubsp").classList.add("hidden");
                document.getElementById("urlaubsdiv").classList.remove("hidden");

                document.getElementById("workTime").classList.add("hidden");
                document.getElementById("workTimeEdit").classList.remove("hidden");
                document.getElementById("workTimeEdit").value = document.getElementById("workTime").innerHTML;

                document.getElementById("sollDay").classList.add("hidden");
                document.getElementById("sollDayEdit").classList.remove("hidden");
                document.getElementById("sollDayEdit").value = document.getElementById("sollDay").innerHTML;

                

            }

            function checkEditMode() {
              document.getElementById("editSvg").classList.remove("hidden");
                document.getElementById("checkSvg").classList.add("hidden");

                document.getElementById("workDays").classList.remove("hidden");
                document.getElementById("workDaysEdit").classList.add("hidden");
                document.getElementById("workDays").innerHTML = document.getElementById("workDaysEdit").value;

                document.getElementById("urlaubsp").classList.remove("hidden");
                document.getElementById("urlaubsdiv").classList.add("hidden");

                document.getElementById("workTime").classList.remove("hidden");
                document.getElementById("workTimeEdit").classList.add("hidden");
                document.getElementById("workTime").innerHTML = document.getElementById("workTimeEdit").value;
                document.getElementById("profilePOST").submit();
            }
          </script>
          
        </div>
        <form action="{{url("/")}}/crm/zeiterfassung/profilbearbeiten" method="POST" id="profilePOST">
          @CSRF
        <div class="w-full pt-3  bg-white rounded-t-md">

          <div class="pl-5 float-left mr-4">
            <img src="{{url("/")}}/employee/{{auth()->user()->id}}/profile.png" class="inline-block h-10 w-10 rounded-full" onerror="this.onerror=null; this.src='{{url("/")}}/img/santa.png'">
          </div>
          <div class="pl-4" style="margin-top: -.35rem;">
            <h3 class="font-semibold">{{$selectedEmployee->name}}</h3>
            <h3 class="pt-0 text-gray-400 text-sm">Übersicht</h3>
          </div>
          <div style="">

          </div>
        </div>
        <div style="">
          <hr>
        </div>

          <div class="text-center pt-2">
            <p class="text-sm font-semibold">Arbeitszeit (dt. Zeit)</p>
          </div>
          <div class="pt-1">
            <hr class="w-44 m-auto">
          </div>
          <div class="text-center pt-1">
            <p class="text-gray-800 text-sm"  id="workDays">{{$selectedEmployee->workdays}}</p>
              <input type="text" name="days" class="text-sm w-36 m-auto h-6 rounded-md border-gray-800 hidden text-center" id="workDaysEdit">
            <p class="text-gray-500 text-sm" id="workTime">{{$selectedEmployee->workhours}}</p>
            <input type="text" name="hours" class="text-sm w-36 m-auto h-6 rounded-md border-gray-800 hidden mt-2 text-center" id="workTimeEdit">
          </div>

          <div class="text-center pt-2">
            <p class="text-sm font-semibold">Soll-Zeit</p>
          </div>
          <div class="pt-1">
            <hr class="w-44 m-auto">
          </div>
          <div class="text-center pt-1">
            <p class="text-gray-800 text-sm" ><span id="sollDay">{{$selectedEmployee->soll}}</span> Stunden pro Tag</p>
              <input type="text" name="solldays" class="text-sm w-36 m-auto h-6 rounded-md border-gray-800 hidden text-center" id="sollDayEdit">
          </div>

          <div class="text-center pt-4">
            <p class="text-sm font-semibold">Resturlaub</p>
          </div>
          <div class="pt-1">
            <hr class="w-44 m-auto">
          </div>
          <div class="text-center pt-1">
            @php
                $vacationCounter = 0;
                $vacationDays = array();
            @endphp
            @foreach ($times as $time)
                @if ($time->reason == "Urlaub")
                    @if (!in_array($time->created_at->format("d.m.Y"), $vacationDays))
                      @php
                        $vacationCounter++;
                        array_push($vacationDays, $time->created_at->format("d.m.Y"));
                      @endphp
                    @endif
                @endif
            @endforeach
            <span id="urlaubsp" class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-800">+ {{$selectedEmployee->allowed_vacations - $vacationCounter}} Tage</span>
            <div class="hidden" id="urlaubsdiv">
              <label for="" class="text-sm">Erlaubte Urlaubstage</label>
              <input type="text" name="vacation" class="text-sm w-16 m-auto h-6 rounded-md border-gray-800  text-center m-auto" id="workDaysEdit" value="{{$selectedEmployee->allowed_vacations}}">
            </div>
          </div>
          <input type="hidden" name="employee" value="{{$selectedEmployee->id}}">

          <div class="text-center pt-4">
            <p class="text-sm font-semibold">Endsaldo des Monats</p>
          </div>
          <div class="pt-1">
            <hr class="w-44 m-auto">
          </div>
          @php
              $allHours = 0;
              $allMinutes = 0;
          @endphp
          
          <div class="text-center rounded-xl px-4 w-24 m-auto " id="testts">
           
          </div>
        </form>
      </div>
    </div>

    <div class="w-48 h-auto pb-3 px-2 bg-white rounded-md mt-4 py-2">
      <h1 class="text-black font-semibold text-center mb-2">Anwesende Mitarbeiter</h1>
      @isset($onlines)
          @foreach ($onlines as $online)
            <p class="w-2 h-2 bg-green-600 rounded-full inline-block float-left mt-2 "></p>
            <p class="text-black decoration-solid text-center"> {{$online->username}}</p>
            
          @endforeach
      @endisset
    </div>
  </div>


  <div class=" float-left pt-4" style="width: 73.5%">
    <div class="">
      <select name="" onchange="window.location.href = '{{url('/')}}/crm/zeiterfassung/changedate/{{$selectedEmployee->id}}/' + document.getElementById('zeiterfassung-month').value + '/' + this.value" id="zeiterfassung-year" class="float-left h-9 rounded-md py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
        
        @php
            $years = array(
              '2022',
              '2023',
              '2024',
              '2025',
              '2026',
              
      );
        @endphp
        
        @isset($year)
            <option value="{{$year}}" selected>{{$year}}</option>
            @foreach ($years as $selectYear)
                @if ($selectYear != $year)
                    <option value="{{$selectYear}}">{{$selectYear}}</option>
                @endif
            @endforeach
          @else
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>

        @endisset
        
      </select>
      
      <select name="" onchange="window.location.href = '{{url('/')}}/crm/zeiterfassung/changedate/{{$selectedEmployee->id}}/' + this.value + '/' + document.getElementById('zeiterfassung-year').value" id="zeiterfassung-month" class="ml-6 float-left h-9 rounded-md py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
        
        @php
            $months = array(
              "Januar" => "01",
              "Februar" => "02",
              "März" => "03",
              "April" => "04",
              "Mai" => "05",
              "Juni" => "06",
              "Juli" => "07",
              "August" => "08",
              "September" => "09",
              "Oktober" => "10",
              "November" => "11",
              "Dezember" => "12",
            )
        @endphp
        
        @isset($month)
          @foreach ($months as $arrayMonth => $item)
            @if ($item != $month)
                <option value="{{$item}}">{{$arrayMonth}}</option>
                @else
                <option value="{{$item}}" selected>{{$arrayMonth}}</option>
            @endif
          @endforeach
        @else
          @foreach ($months as $month => $item)
            <option value="{{$item}}">{{$month}}</option>
          @endforeach
        @endisset

      </select>
      <script>
        @php
        $trans = array(
          'Monday'    => 'Montag',
          'Tuesday'   => 'Dienstag',
          'Wednesday' => 'Mittwoch',
          'Thursday'  => 'Donnerstag',
          'Friday'    => 'Freitag',
          'Saturday'  => 'Samstag',
          'Sunday'    => 'Sonntag',
          'Mon'       => 'Mo',
          'Tue'       => 'Di',
          'Wed'       => 'Mi',
          'Thu'       => 'Do',
          'Fri'       => 'Fr',
          'Sat'       => 'Sa',
          'Sun'       => 'So',
          'Jan'   => 'Januar',
          'Feb'  => 'Februar',
          'Mar'     => 'März',
          'May'       => 'Mai',
          'Jun'      => 'Juni',
          'Sep'     => 'September',
          'Jul'      => 'Juli',
          'Aug'      => 'August',
          'Nov'      => 'November',
          'Oct'   => 'Oktober',
          'Dec'  => 'Dezember',
          );
          $dateMonth = date('M');
          $dateMonth = $trans[$dateMonth];
        @endphp

        @isset($year)
        document.getElementById('zeiterfassung-year').value = "{{$year}}";
        document.getElementById('zeiterfassung-month').value = "{{$month}}";
        @else
        @php
          $currentDateDate = new DateTime();
        @endphp
        document.getElementById('zeiterfassung-year').value = "{{$currentDateDate->format('Y')}}";
        document.getElementById('zeiterfassung-month').value = "{{$currentDateDate->format('m')}}";

        @endisset

    </script>
    
      <button onclick="window.location.href = '{{url('/')}}/crm/zeiterfassung/drucken/{{$selectedEmployee->id}}/' + document.getElementById('zeiterfassung-month').value + '/' + document.getElementById('zeiterfassung-year').value" class="float-left ml-6 rounded-md bg-blue-600 hover:bg-blue-500 w-12 h-9"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 m-auto text-white ">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
      </svg>
    </button>
      <button onclick="document.getElementById('newZeiterfassung').classList.remove('hidden')" class="float-right rounded-md bg-blue-600 hover:bg-blue-500 py-.5 px-4 h-9 text-white font-medium">Neue Zeit buchen</button>
      
      <form action="{{url("/")}}/crm/zeiterfassung/upload-csv" id="uploadCSV" method="POST" enctype="multipart/form-data" class="ml-4">
        <button type="submit" class="hidden" id="csvupload-button"></button>

        @CSRF
        <label class="float-left w-10 ml-6 flex flex-col items-center px-6 py-1.5 bg-blue-600 hover:bg-blue-500 text-blue rounded-lg tracking-wide uppercase cursor-pointer hover:bg-blue hover:text-white">
      
          <span class="mt-0 text-base leading-normal"><span class="float-left" id="emailvorlage-file"></span>  <svg class="w-5 h-5 float-left mt-1  text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
          </svg></span>
          <input type='file' oninput="document.getElementById('csvupload-button').click();" class="hidden" name="file" />
      </label>
       </form>
       <button onclick="getFeiertage()" class="float-left rounded-md bg-blue-600 hover:bg-blue-500 py-.5 px-4 h-9 text-white font-medium ml-6">Feiertage</button>

    </div>
    @php
        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));    
   @endphp
    <div class="pt-14">
      <table class="w-full bg-white rounded-md">
          <td class="py-4 w-20 text-left pl-6 border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold">Datum</td>
            <td class="py-4 w-20 border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold text-left pr-6">Tag</td>
            <td class="py-4 w-60 border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold px-4">Zeiten</td>
            <td class="py-4 w-60 border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold px-4">Stunden</td>
            <td class="py-4 w-60 border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold px-4">Hinweis</td>
            <td class="py-4 w-auto border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold pl-12">Grund</td>
            <td class="py-4 w-auto border border-l-0 border-t-0 border-r-0 border-gray-300 font-semibold text-right pr-6">Aktion</td>
        
            @php
                if(!isset($year)) {
                  $year = date("Y");
                  $month = date("m");
                }
                      
                        $allDates  = new DateTime($year . "-". $month. "-31");
                        
                      if($allDates->format("d") != "31") {
                        $allDates  = new DateTime($year . "-". $month. "-30");
                      }
                      if($allDates->format("d") != "30" && $allDates->format("d") != "31") {
                        $allDates  = new DateTime($year . "-". $month. "-29");
                      }
                      if($allDates->format("d") != "29" && $allDates->format("d") != "30" && $allDates->format("d") != "31") {
                        $allDates  = new DateTime($year . "-". $month. "-28");
                      }
                      
                  $dayCounter = 1;
                  $usedDays = array();
            @endphp




            @while ($dayCounter <= $allDates->format("d"))
            @if ($dayCounter <= 9)
                @php
                    $dayCounter = "0" . $dayCounter;
                @endphp
            @endif
            @if ($times->whereBetween("created_at", [$allDates->format("Y-m-". $dayCounter ." 00:00:00"), $allDates->format("Y-m-". $dayCounter ." 23:59:59")])->where("employee", $selectedEmployee->id)->first() != null)
            @php
                $getTimes = $times->whereBetween("created_at", [$allDates->format("Y-m-". $dayCounter ." 00:00:00"), $allDates->format("Y-m-". $dayCounter ." 23:59:59")])->where("employee", $selectedEmployee->id);
                    $currentDate = new DateTime($year."-".$month."-".$dayCounter);
            @endphp
            
            <tr class="border border-gray-200 @if($feiertage->where('datum', $dayCounter .$allDates->format(".m.Y"))->first() != null) bg-gray-300 @endif">
              <td class="pl-4 text-gray-500 text-sm text-left">{{ $dayCounter .$allDates->format(".m.Y")}}</td>
              <td class="text-sm text-gray-500">{{strtr($currentDate->format("D"), $trans)}}</td>
              <td class="text-sm py-2 w-96">
                @php
                    $timesCounter = 0;
                    $usedTimes = array();
                @endphp
                @foreach ($getTimes as $time)
                  @if ($time->type == "start")
                    @if($times->where("id", $time->id)->where("type", "feierabend")->first() != null)
                      @if ($timesCounter < 3)
                      <p class="float-left w-28 border text-center rounded-xl @if($time->reason == "Urlaub") line-through @endif mr-2 px-2  border-gray-600 inline-block font-medium">{{$time->created_at->format("H:i")}} - {{$times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i")}}</p>
                      @php
                          $timesCounter++;
                          array_push($usedTimes, $time->main_id);
                      @endphp
                      @endif
                    @else
                    @if ($timesCounter < 3)
                    <p class="float-left w-36  text-center border mr-2 @if($time->reason == "Urlaub") line-through @endif rounded-xl px-2 border-gray-600 inline-block font-medium">{{$time->created_at->format("H:i")}} -                     <a href='#stop' onclick="document.getElementById('stopZeiterfassung').classList.remove('hidden'); document.getElementById('stopZeiterfassungId').value = '{{$time->id}}'; document.getElementById('dateShowStop').value = '{{$time->created_at->format('Y-m-d ') . date('H:i')}}'" class="text-blue-600">Zeit fehlt</a>
                    </p>
                    @php
                        array_push($usedTimes, $time->main_id);
                    @endphp
                    @endif
                    @endif
                  @endif
                @endforeach
           
                <div id="{{$dayCounter}}" class="hidden" >
                  @foreach ($getTimes as $time)
                    @if (!in_array($time->main_id, $usedTimes))
                      @if ($time->type == "start")
                        @if($times->where("id", $time->id)->where("type", "feierabend")->first() != null)
                          <p class="float-left w-28  mr-2 text-center border  rounded-xl px-2 w-auto border-gray-600 inline-block font-medium">{{$time->created_at->format("H:i")}} - {{$times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i")}}</p>
                          </p>
                          @else 
                          <p class="float-left w-36 mt-2 mr-2 text-center border  rounded-xl px-2 w-auto border-gray-600 inline-block font-medium">{{$time->created_at->format("H:i")}} -                     <a href='#stop' onclick="document.getElementById('stopZeiterfassung').classList.remove('hidden'); document.getElementById('stopZeiterfassungId').value = '{{$time->id}}'; document.getElementById('dateShowStop').value = '{{$time->created_at->format('Y-m-d ') . date('H:i')}}'" class="text-blue-600">Zeit fehlt</a>
                          </p>
                        @endif
                      @endif
                    @endif
                @endforeach
                </div>
                @if ($timesCounter > 2)
                <p id="{{$dayCounter}}-p" class=" px-2 w-auto pt-2  inline-block font-medium text-blue-600" onclick="showMore('{{$dayCounter}}')">mehr
                </p>
                @endif
              </td>
              <td class="text-sm text-gray-500 pl-4">

                @if ($time->reason != "Urlaub")
                @php
                $hours = 0;
                $minutes = 0;
                @endphp
                @foreach ($getTimes as $time)
                   @if ($time->type == "start")
                   @if($times->where("id", $time->id)->where("type", "feierabend")->first() != null)

                   @php
                   $startdate = new DateTime($time->created_at);
                   $diff_date = $startdate->diff(new DateTime($times->where("type", "feierabend")->where("id", $time->id)->first()->created_at));

                   $hours += $diff_date->h;
                   $minutes += $diff_date->i;
                   if($minutes >= 60) {
                    $hours++;
                    $minutes -= 60;
                   }
               @endphp

               @endif
                   @endif
                @endforeach
               
               @if ($feiertage->where('datum', $dayCounter .$allDates->format(".m.Y"))->first() == null)
               @php
               $hours = explode(":", $selectedEmployee->soll)[0] - $hours;
               $minutes = explode(":", $selectedEmployee->soll)[1] - $minutes;

               if($minutes < 0) {
                 $hours--;
                 $minutes += 60;
               }

               $allHours += $hours;
               $allMinutes += $minutes;

               @endphp
               @if ($hours < 0)
                  <span class="text-yellow-600">@if($hours <= 8)+0{{$hours * -1}}@else+{{$hours * -1}}@endif:@if($minutes <=9 )0{{$minutes }}@else{{$minutes }}@endif</span>
                @endif

                @if ($hours > 0)
                  <span class="text-red-600">@if($hours <= 8)-0{{$hours}}@else-{{$hours}}@endif:@if($minutes <=9 )0{{$minutes}}@else{{$minutes}}@endif</span>
                @endif

                @if ($hours == 0)
                  @if ($minutes == 0)
                  <span class="text-green-600">00:00</span>
                  @else
                  <span class="text-red-600">- 00:{{$minutes}}</span>
                  @endif
                @endif
                @else 
                @php
                
                if($minutes < 0) {
                  $hours--;
                  $minutes += 60;
                }

                $allHours += $hours;
                $allMinutes += $minutes;

                @endphp
                <span class="text-green-600">@if($hours <= 8)+0{{$hours}}@else+{{$hours}}@endif:@if($minutes <=9 )0{{$minutes}}@else{{$minutes}}@endif</span>


               @endif
                @endif
                
              </td>
              <td class="text-sm">
                @isset($getTimes[0]->info)
                  @if ($getTimes[0]->info != "")
                    {{$getTimes[0]->info}}
                  @endif
                @endisset
              </td>
              <td class="text-sm appearance-none pl-6 w-16 text-right">{{$time->reason}}</td>
              <td class="text-sm w-60">
                
              
                <button onclick="deleteIndex('{{$time->id}}')" class="py-1.5 px-4 bg-red-200 rounded-md text-red-600 float-right ml-2 mr-4">Löschen</button>
                @if ($getTimes->where('id', $time->id)->where('type', 'feierabend')->first() != null)
                <button onclick="editIndex('{{$time->id}}', '{{$time->created_at->format('Y-m-d H:i')}}', '{{$getTimes->where('id', $time->id)->where('type', 'feierabend')->first()->created_at}}', '@isset($getTimes[0]) {{$getTimes[0]->info}} @endisset')" class="py-1.5 px-4 bg-blue-200 rounded-md text-blue-600 float-right ml-2">Bearbeiten</button>
                @else 
                <button onclick="editIndex('{{$time->id}}', '{{$time->created_at->format('Y-m-d H:i')}}', '', '@isset($getTimes[0]) {{$getTimes[0]->info}} @endisset')" class="py-1.5 px-4 bg-blue-200 rounded-md text-blue-600 float-right ml-2">Bearbeiten</button>
                @endif
             
                @php
                    $usedTimes = array();
                @endphp

                @foreach ($getTimes as $time)
                @if (!in_array($time->main_id, $usedTimes))
                  @if ($time->type == "start")
                    @if($times->where("id", $time->id)->where("type", "feierabend")->first() == null)
                    <button onclick="document.getElementById('stopZeiterfassung').classList.remove('hidden'); document.getElementById('stopZeiterfassungId').value = '{{$time->id}}'; document.getElementById('dateShowStop').value = '{{$time->created_at->format('Y-m-d ') . date('H:i')}}'" class="py-1.5 mr-4 mt-1 px-4 bg-red-200 rounded-md text-red-600 float-right mb-1">Zeit Stoppen</button>
                    @endif
                  @endif
                @endif
                @endforeach
              </td>
            </tr>
            @else
            @php
              $currentDate = new DateTime($year."-".$month."-".$dayCounter);
            @endphp
            <tr class="border border-gray-200 @if(isset($feiertage->where('datum', $dayCounter .$allDates->format(".m.Y"))->first()->created_at)) bg-gray-300 @endif">
              <td class="pl-4 text-gray-500 text-sm">{{ $dayCounter .$allDates->format(".m.Y")}}</td>
              <td class="text-sm text-gray-500">{{strtr($currentDate->format("D"), $trans)}}</td>
              <td class="text-sm"></td>
              @php
                  
              @endphp
              <td class="text-sm text-gray-500 pl-4">
                @if($feiertage->where('datum', $dayCounter .$allDates->format(".m.Y"))->first() == null)
                  @if(strtr($currentDate->format("D"), $trans) != "Sa" && strtr($currentDate->format("D"), $trans) != "So" ) <span class="text-red-600">-{{$selectedEmployee->soll}}</span> @if($selectedEmployee->soll != null) @php $allHours += explode(":", $selectedEmployee->soll)[0]; $allMinutes += explode(":", $selectedEmployee->soll)[1]; @endphp @endif @endif
                @endif
              </td>
              <td class="text-sm">@if($feiertage->where('datum', $dayCounter .$allDates->format(".m"))->first() != null) {{$feiertage->where('datum', $dayCounter .$allDates->format(".m"))->first()->bezeichnung}} @endif</td>
              <td class="text-sm appearance-none pt-2 pl-6 w-16 "></td>

              <td class="text-sm w-60">
                 </td>
            </tr>
            @endif
                  
                @php
                    $dayCounter++;
                    array_push($usedDays, $dayCounter . ".". $month . "." . $year);
                @endphp
            @endwhile
        
          
      </table>
    </div>
  </div>

  <script>
    function editIndex(id, start, end, info) {
      document.getElementById("bearbeiteZeiterfassungId").value = id;
      document.getElementById("start").value = start;
      document.getElementById("end").value = end;
      document.getElementById("infochangeChange").value = info;
      document.getElementById("bearbeitenZeiterfassung").classList.remove("hidden");
    }

    function showTimeWindow() {
      window.location.href = '{{url("/")}}/crm/zeiterfassung/newtime/{{$selectedEmployee->id}}';
    }

    function deleteIndex(id) {
      document.getElementById('deleteIndex').value = id;
      document.getElementById("deleteIndexFinalCheck").classList.remove("hidden");
    }

    let extendsList = [];
    function showMore(id) {
      if(!extendsList.includes(id)) {
        document.getElementById(id).classList.remove("hidden");
        document.getElementById(id + "-p").innerHTML = "weniger";
        extendsList.push(id);
      } else {
       let elementCounter = 0;
       extendsList.forEach(element => {
        if(element == id) {
          document.getElementById(id).classList.add("hidden");
          document.getElementById(id + "-p").innerHTML = "mehr";
          extendsList.splice(elementCounter, 1);
        }
        elementCounter++;
       });
      }
    }

    let hours = {{$allHours}};
    let minutes = {{$allMinutes}};
    
    let minuteCounter = 0;
    let minuteSetter = 0;
    let leftminutes = minutes;
    while(minuteCounter < minutes) {
      if(minuteSetter == 60) {
        hours++;
        minuteSetter = 0;
        leftminutes -= 60;
      }
      minuteSetter++;
      minuteCounter++;
    }

    if(leftminutes < 0) {
      hours--;
      leftminutes += 60;
    }

    if(hours > 0) {
      document.getElementById("testts").classList.add("text-red-600");
      document.getElementById("testts").classList.add("bg-red-200");
      document.getElementById("testts").innerHTML = "- " + hours + ":" + leftminutes;

    }
    if(hours < 0) {
      document.getElementById("testts").classList.add("text-green-600");
      document.getElementById("testts").classList.add("bg-green-200");

      document.getElementById("testts").innerHTML = "+ " + hours * -1 + ":" + leftminutes;

    }

  </script>

  <div id="deleteIndexFinalCheck" class="hidden">
    @include('forEmployees.modals.deleteZeiterfassungIndex')
    <input type="hidden" id="deleteIndex" name="deleteIndex" value="null">
  </div>
  <div id="newZeiterfassung" class="hidden">
    @include('forEmployees.modals.newZeiterfassung')
  </div>
  <div id="stopZeiterfassung" class="hidden">
    @include('forEmployees.modals.stopZeiterfassung')
  </div>
  <div id="bearbeitenZeiterfassung" class="hidden">
    @include('forEmployees.modals.bearbeitenZeiterfassung')
  </div>



  
  <div class="relative @if(isset($uploadcsv)) @else hidden @endif z-10" aria-labelledby="modal-title" id="feiertage-upload" role="dialog" aria-modal="true" >
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
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 w-96  sm:p-6">
          <div>
            <div class="mt-3 text-center sm:mt-5">
              <div>
              </div>
              <div class="mt-2">
                <h1 class="text-center text-xl font-semibold">Hochgeladene Feiertage</h1>


                <div>
                  <table>
                    <tr>
                      <td class="py-4 w-60 text-left">Datum</td>
                      <td class="py-4 w-60 text-right">Bezeichnung</td>
                    </tr>
                    @foreach ($feiertage as $tag)

                    <tr>
                      <td class="py-1 text-left">{{$tag->datum}}</td>
                      <td class="py-1 text-right">{{$tag->bezeichnung}}</td>
                    </tr>

                     
                  @endforeach
                  </table>
                 
                </div>

              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
            <button type="button" onclick="document.getElementById('feiertage-upload').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<div id="feiertage-div">

</div>

  <script>
    function getFeiertage() {
      loadData();
      $.get("{{url("/")}}/crm/zeiterfassung/feiertage", function(data) {
        document.getElementById("feiertage-div").innerHTML = data;
        savedPOST();  
      })
    }

    function deleteFeiertag(id) {
      document.getElementById(id+"-feiertag").remove();
      $.get("{{url("/")}}/crm/zeiterfassung/delete-feiertag-"+id, function(data) {
      })
    }
  </script>

@include('layouts.error')
</body>
</html>