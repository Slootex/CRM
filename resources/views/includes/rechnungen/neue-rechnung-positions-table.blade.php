@php
    $posCounter = 1;
    $finalBrutto = 0;
    $rabattRechnung = null;
@endphp
@foreach ($rechnungen as $rechnung)
    @if ($rechnung->bezeichnung === 'Rabatt')
        @php
            $rabattRechnung = $rechnung;
            continue;
        @endphp
    @endif

    <tr>
        <td class="whitespace-nowrap py-1.5 text-sm text-gray-600 text-left">{{$posCounter}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{$rechnung->menge}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{$rechnung->artnr}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{$rechnung->bezeichnung}}</td>
        @if ($rechnung->mwst != "no")
            <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">@if((($rechnung->nettobetrag/100)*19)+$rechnung->nettobetrag != 0) 19% @endif</td>
        @endif
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{number_format($rechnung->nettobetrag, 2, ',', '')}}</td>
        @if ($rechnung->mwst != "no")
            <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{ number_format(($rechnung->nettobetrag/100)*19, 2, ',', '') }}</td>
            @php
                $rechnung->bruttobetrag = $rechnung->nettobetrag + (($rechnung->nettobetrag/100)*19);
            @endphp
        @endif
        <td class="whitespace-nowrap py-1.5 text-sm text-gray-600 text-right">
            {{number_format($rechnung->bruttobetrag, 2, ',', '')}}
        </td>
        <td class="whitespace-nowrap py-1.5 text-sm text-right"><button type="button" onclick="deletePosition('{{$rechnung->id}}')" class="text-red-600 hover:text-red-400">löschen</button></td>
    </tr>

    @php
        $posCounter++;
        if((($rechnung->nettobetrag/100)*19)+$rechnung->nettobetrag == 0) {
            $finalBrutto -= $rechnung->bruttobetrag;
        } else {
            $finalBrutto += $rechnung->bruttobetrag;
        }
    @endphp
@endforeach

@if ($rabattRechnung)
    <tr>
        <td class="whitespace-nowrap py-1.5 text-sm text-gray-600 text-left">{{$posCounter}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{$rabattRechnung->artnr}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left">{{$rabattRechnung->bezeichnung}}</td>
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
        @if ($rechnungen[0]->mwst != "no")
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
        @endif
        @if ($rechnungen[0]->mwst != "no")
            <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
        @endif
        <td class="whitespace-nowrap py-1.5 text-sm text-gray-600 text-right">
            -{{number_format($rabattRechnung->bruttobetrag, 2, ',', '')}}
        </td>
        <td class="whitespace-nowrap py-1.5 text-sm text-right"><button type="button" onclick="deletePosition('{{$rechnung->id}}')" class="text-red-600 hover:text-red-400">löschen</button></td>
    </tr>

    @php
        $finalBrutto -= $rabattRechnung->bruttobetrag;
    @endphp
@endif


@if($finalBrutto != 0)
<tr>
    <td class="border border-gray-300 border-l-0 border-r-0 whitespace-nowrap py-1.5 text-sm text-black text-left font-bold">Gesamt</td>
    <td class="border border-gray-300 border-l-0 border-r-0"></td>
    <td class="border border-gray-300 border-l-0 border-r-0"></td>
    @if ($rechnungen[0]->mwst != "no")
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
    @endif
    @if ($rechnungen[0]->mwst != "no")
        <td class="whitespace-nowrap px-3 py-1.5 text-sm text-gray-600 text-left"></td>
    @endif
    <td class="border border-gray-300 border-l-0 border-r-0"></td>
    <td class="border border-gray-300 border-l-0 border-r-0"></td>
    <td class="border border-gray-300 border-l-0 border-r-0 whitespace-nowrap py-1.5 text-sm text-black text-right font-bold">
        {{number_format($finalBrutto, 2, ',', '')}}
    </td>
    <td class="border border-gray-300 border-l-0 border-r-0"></td>
    
</tr>

@endif