<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<body>
    

        <form action="tables/see" method="POST">
            @CSRF
            <select name="table" id="">
                @foreach ($tables as $table)
                    <option value="{{$table}}">{{$table}}</option>
                @endforeach
            </select>
            <button type="submit">Absenden</button>
        </form>

</body>
</html>