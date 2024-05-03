
    @foreach ($intern as $in)
        <tr>
          <td class="py-1 pl-6">{{$in->created_at->format("d.m.Y (H:i)")}}</td>
          <td class="py-1 text-left text-blue-600">{{$in->auftrag_id}}</td>
          <td class="py-1 text-left">@if($users->where("id", $in->employee)->first() != null) {{$users->where("id", $in->employee)->first()->username}} @endif</td>
          <td class="py-1 text-center">{{$in->info}}</td>
          <td class="py-1 text-center">{{$in->component_number}}</td>
        </tr>
    @endforeach
