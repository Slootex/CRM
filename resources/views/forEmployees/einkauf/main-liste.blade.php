@foreach ($einkäufe as $einkauf)
    <tr>
        <td class="pl-8">{{$einkauf->created_at->format("d.m.Y (H:i)")}}</td>
        <td class="pl-6">{{$einkauf->process_id}}</td>
        <td class="pl-6">{{ucfirst($einkauf->type)}}</td>
        <td class="pl-6">{{$einkauf->price}}</td>
        <td class="pl-6">
            @php
                $rechnungsdatum = $einkauf->rechnungs_datum;
                $parts = explode("-", $rechnungsdatum);
                $rechnungsdatum = $parts[1] . "." . $parts[2] . "." . $parts[0];
            @endphp
                        {{$rechnungsdatum}}
        </td>
        <td class="pl-6">{{$einkauf->rechnungsnummer}}</td>
        <td class="pl-6">{{$einkauf->status}}</td>
        <td class="pl-6">{{$einkauf->lieferantendaten}}</td>
        <td class="pl-6">{{$einkauf->tracking}}</td>
        <td>
            <button type="button" onclick="getEditEinkauf('{{$einkauf->id}}', '{{$einkauf->pos_id}}')" class="text-blue-600 hover:text-blue-400 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg> 
            </button>            
        </td>
    </tr>
@endforeach