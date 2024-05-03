<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="{{url("/")}}/js/loading-bar.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="{{url("/")}}/css/loading-bar.css">
<script src="{{url('/')}}/js/text.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>

    @include('layouts.top-menu', ["packtisch" => "packtisch", "menu" => "packtisch"])
    <div class="mt-10 px-10">
        <h1 class="text-2xl font-bold">Intern bearbeiten</h1>
        <form action="{{url("/")}}/crm/packtisch/intern-ändern-{{$intern->id}}" method="POST">
            @CSRF
            <div class="grid grid-cols-3 col-span-2 mt-4 pt-1 float-left" style="width: 50%">

                    <p class="mt-8 col-start-1">Zusatzkommentar Packtisch</p>
                    <textarea name="info" id="" class=" mt-8 rounded-md border border-gray-300 h-16 ml-4 mb-10"  style="width:19rem">{{$intern->info}}</textarea>
                    <p></p>
                    <div class="col-start-2" style="width:20rem">
                        <button type="submit" class="float-right bg-blue-600 hover:bg-blue-400 text-white rounded-md font-medium text-md px-4 py-2">Speichern</button>
                        <a href="{{url("/")}}/crm/packtisch/intern-löschen-{{$intern->id}}" class="float-right rounded-md bg-red-600 hover:bg-red-400 text-white text-md px-4 py-2 mr-4 font-medium">Löschen</a>
                    </div>
            </div>
        </form>
    </div>
</body>
</html>