@php
    $minSites = 5;
@endphp

      @foreach ($wareneingang as $eingang)
          <tr>
            <td class="py-1 pl-6">{{$eingang->created_at->format("d.m.Y (H:i)")}}</td>
            <td class="py-1 text-blue-600">{{$eingang->process_id}}</td>
            <td class="py-1 text-left text-blue-600">@if(strlen($eingang->process_id) == 5) Wareneingang @else Hilfsgerät @endif</td>
            <td class="py-1 text-left">@if($users->where("id", $eingang->employee)->first() != null) {{$users->where("id", $eingang->employee)->first()->username}} @endif</td>
            <td class="py-1 text-left">@isset($eingang->shelfe->shelfe_id){{$eingang->shelfe->shelfe_id}}@endisset</td>
            <td class="py-1 text-left">{{$eingang->component_number}}</td>
            <td></td>
          </tr>
      @endforeach
