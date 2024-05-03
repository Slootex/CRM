<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<body>
    

    <table style=" overflow-x:scroll; width:800px; display:block; margin:auto;" id="table">
        <th>
            @foreach ($columns as $column)
                <td style="padding-left: 10px; padding-right: 10px; text-align: center; border: solid black 1px;">{{$column}}</td>
            @endforeach
        </th>
        @foreach ($tables as $table)
        <form action="{{url("/")}}/change/records/{{$tablename}}" method="POST">
            @CSRF
        <tr>
            <td></td>
            @php
                $counter = 0;
            @endphp
            @foreach ($table as $item)
            
                    <td style="padding-left: 10px; padding-right: 10px; text-align: center; border: solid black 1px;"><textarea name="{{$columns[$counter]}}" id="" cols="10" rows="1">{{$item}}</textarea></td>
                    @php
                        $counter++;
                    @endphp
                    @endforeach
                <td>    <button type="submit">Einträge ändern</button>
                </td>
        </tr>
        </form>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
    <form action="{{url("/")}}/new/record/{{$tablename}}" method="POST">
    @CSRF
    <tr>
        <td></td>
        @foreach ($columns as $column)
            <td style="text-align: center;">{{$column}}</td>
        @endforeach
    </tr>
        <tr style="padding-top: 100px;">
            <td></td>
        @foreach ($columns as $column)
                    <td style="padding-left: 10px; padding-right: 10px; text-align: center; border: solid black 1px;"><textarea name="{{$column}}" id="" cols="10" rows="1"></textarea></td>
        @endforeach
        <td><button type="submit">Neuer Eintrag</button></td>
        </tr>
        
    </form>
    </table>
    <button type="button" onclick="addRow()">Eintrag hinzufügen</button>

    <script>

        function getRandomInt(max) {
        return Math.floor(Math.random() * max);
        }

        function addRow() {
            var table       = document.getElementById("table");
            var form        = document.createElement("form");
            var row         = table.insertRow({{count($tables) + 1}});
            row.appendChild(form);
            var length      = {{count($columns)}}
            var counter     = 1;
            var column      = row.insertCell(0);
            var columns     = [];
            @foreach($columns as $column)
                columns.push("{{$column}}");
            @endforeach

            while(counter < length) {
                var column = row.insertCell(counter);
                column.style     = "padding-left: 10px; padding-right: 10px; text-align: center; border: solid black 1px;";
                column.innerHTML = '<textarea name="'+ getRandomInt(1000) +'" id="" cols="10" rows="1">{{$item}}</textarea>';
                counter++;
            }
            var column = row.insertCell(counter);
                column.style     = "padding-left: 10px; padding-right: 10px; text-align: center; border: solid black 1px;";
                column.innerHTML = '<textarea name="'+ getRandomInt(1000) +'" id="" cols="10" rows="1">{{$item}}</textarea>';

        }
    </script>
</body>
</html>