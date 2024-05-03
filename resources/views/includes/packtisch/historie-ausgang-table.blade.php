
    @php
        $labelList = array();
    @endphp
    @foreach ($warenausgang as $as)
        @if (!in_array($as->label, $labelList))
          <tr>
            <td class="py-1 pl-6">{{$as->created_at->format("d.m.Y (H:i)")}}</td>
            <td class="py-1 text-left text-blue-600">@if(isset($as->shortcut) && $as->shortcut != "") {{$contacts->where("id", $as->shortcut)->first()->shortcut}} @else {{$as->process_id}} @endif</td>
            <td class="py-1 text-left">{{$as->ex_space}}</td>
            <td class="py-1 text-left">@if($users->where("id", $as->employee)->first() != null) {{$users->where("id", $as->employee)->first()->username}} @endif</td>
            <td class="py-1 text-center text-blue-600"><a target="_blank" href="https://www.ups.com/track?track=yes&trackNums={{$as->label}}&loc=de_de&requester=ST/trackdetails">{{$as->label}}</a></td>
            <td class="py-1 text-center">@if($trackings->where("label", $as->label)->first() != null)<p class="px-2 py-1 rounded-md bg-red-200 text-red-600 w-60  inline-block text-ellipsis whitespace-nowrap">{{$trackings->where("label", $as->label)->first()->status}}</p>@endif</td>
            <td class="py-1 text-center text-blue-600"><button onclick="getHistory('{{$as->label}}')">bearbeiten</button></td>
          </tr>
          @php
              array_push($labelList, $as->label)
          @endphp
        @endif
    @endforeach
