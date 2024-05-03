@if($component_name == "warenausgang")
<embed src="{{url("/")}}/files/aufträge/{{$process_id}}/warenausgang.pdf#toolbar=0&zoom=70" height="1000" width="1000" type="application/pdf">
@else
<embed src="{{url("/")}}/files/aufträge/{{$process_id}}/{{$component_name}}_aktuell_.pdf#toolbar=0&zoom=70" height="1000" width="1000" type="application/pdf">
@endif