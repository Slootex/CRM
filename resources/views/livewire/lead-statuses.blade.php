<table class="table table-white table-sm table-bordered table-hover mb-0">
    <thead><tr class="bg-white text-primary">
        <th><strong>Datum</strong></th>
        <th><strong>Status</strong></th>
        <th><strong>Mitarbeiter</strong></th>
        <th><strong>Email-Vorlage</strong></th>
        <th><strong>Nachricht</strong></th>
        <th><strong>Gelesen</strong></th>
        <th><strong>&nbsp;</strong></th>
    </tr></thead>
<tbody>			<tr>
<td>{{$order_id->created_at}}</td>
@foreach ($statuses as $status)
        @if ($status->id == $order_id->current_status)
            <td>{{$status->name}}</td>
        @endif
@endforeach
<td>Lucas Gloede<td>
<td>Later</td>
<td>Later</td>
<td>Later</td>
</tr>
@foreach ($status_historys as $status_history)
<tr>
    <td>{{$status_history->created_at}}</td>
    @foreach ($statuses as $status)
        @if ($status->id == $status_history->last_status)
            <td>{{$status->name}}</td>
        @endif
    @endforeach
    @foreach ($employees as $employee)
        @if ($employee->id == $status_history->changed_employee)
            <td>{{$employee->name}}</td>
        @endif
    @endforeach
    <td>Later</td>
    <td>Later</td>
    <td>Later</td>
</tr>
@endforeach


</tbody></table>