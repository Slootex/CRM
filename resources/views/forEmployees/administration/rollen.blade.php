<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="js/pdf.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    @vite('resources/css/app.css')
</head>
<body>

  @include('layouts.top-menu', ["menu" => "settings" , "undermenu" => "berechtigungen"])
  <h1 class="py-6 text-4xl font-bold ml-10 text-black float-left">Einstellungen > Berechtigungen </h1>
  <div class="mt-6">
    <div class="sm:hidden">
      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
      <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        <option>System</option>
  
        <option>Custom</option>

      </select>
    </div>
    <div class="hidden sm:block ml-10 float-left">
      <nav class="flex space-x-10" aria-label="Tabs">
        @foreach ($rollen as $rolle)
          <button type="button" onclick="changeRoleTab('{{$rolle->id}}')" id="tab-button-{{$rolle->id}}" class=" @if($rolle->id == $rollen[0]->id) bg-blue-600 text-white @else hover:bg-blue-600 bg-gray-200 text-black hover:text-white  @endif px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">{{$rolle->name}}</span> </button>
        @endforeach
        <button type="button" onclick="document.getElementById('new-role-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-600 px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Neue Rolle anlegen</span> </button>


      </nav>
    </div>
    <button type="button" onclick="window.location.href = '{{url("/")}}/crm/benutzer'" class="float-right bg-yellow-600 text-white mr-12 hover:text-gray-600 px-5 py-2 font-medium text-normal rounded-md text-center">Benutzer</button>

  </div>
    <div class="mt-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden  shadow sm:rounded-lg">
                    <div class="px-4 sm:p-6">
                        <div class="mt-8 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                  @foreach ($rollen as $rolle)
                                  <table class="min-w-full divide-y divide-gray-300 @if($rolle->id != $rollen[0]->id) hidden @endif" id="table-{{$rolle->id}}">
                                    <thead class="bg-gray-50">
                                      <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Bereich</th>
                                        <th scope="col" class="px-3 py-3.5 pr-6 text-right text-sm font-semibold text-gray-900">Zugriff</th>
   
                                      </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Packtisch</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "packtisch")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p class="">{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach


                                  
                                      
                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Einstellungen</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "einstellungen")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Auftrag</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "auftrag")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Interessent</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "interessent")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">E-Mail</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "e-mail")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      
                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Einkauf</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "einkauf")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Statistik</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "statistik")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Buchhaltung</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "buchhaltung")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p >{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach

                                      <tr>
                                        <td class="px-6 py-1"><h1 class="text-xl font-medium ">Linkes Menü</h1></td>
                                        <td></td>
                                      </tr>
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom != "true")
                                          @if ($perm->area == "leftmenu")
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p class="">{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                              
                                                <button type="button" onclick="changeInput('{{$rolle->id}}-{{$perm->permissions_id}}')" class="group mt-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                                  <span class="sr-only">Use setting</span>
                                                  <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                                  <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                                                  <span aria-hidden="true" id="span-1-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) bg-blue-600 hover:bg-blue-500 @else bg-gray-200 @endif pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                                  <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                                  <span aria-hidden="true" id="span-2-{{$rolle->id}}-{{$perm->permissions_id}}" class="@if($rolle->roleid->where("permission_id", $perm->permissions_id)->first() != null) translate-x-5 @else translate-x-0 @endif pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          @endif
                                        @endif
                                      @endforeach



                                      @isset($rolle->roleid[0]->permission )
                                      @if ($rolle->roleid[0]->permission != null)
                                      @if ($rolle->roleid[0]->permission->where("custom", "true")->first() != null)
                                        <tr>
                                          <td class="px-6 py-1"><h1 class="text-xl font-medium ">Selbsthinzugefügte Rechte</h1></td>
                                          <td></td>
                                        </tr>
                                      @endif
                                    @endif
                                      @endisset
                                       
                                      @foreach ($perms as $perm)
                                        @if ($perm->custom == "true")
                                            @if ($rolle->roleid->where("permission_id", $perm->permissions_id)->first())
                                            <tr>
                                              <td class="px-6 py-1">
                                                <p class="">{{$perm->name}}</p>
                                                <p class="text-gray-600">{{$perm->description}}</p>
                                                <p class="text-gray-400">{{$perm->url}}</p>
                                              </td>
                                              <td class="text-right px-6 ">
                                                <a href="{{url("/")}}/crm/delete-permission-{{$perm->id}}">
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 float-right">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                  </svg> 
                                                </a>                                                                                               
                                              </td>
                                            </tr>
                                            @endif
                                        @endif
                                      @endforeach
                                      
                                      <tr class="py-1">
                                        <td class="py-2">
                                          @isset(auth()->user()->roles[0])
                                            @if (auth()->user()->roles[0]->permissions->where("name", "set.roles_perms")->first() != null)
                                            <a href="{{url("/")}}/crm/rolle-löschen-{{$rolle->id}}" class="bg-red-600 ml-6 rounded-md text-center text-white font-semibold text-md px-4 py-2 mt-1 mb-1 mr-6 inline-block">Löschen</a>
                                            @endif 
                                          @endisset
                                        </td>
                                        <td class="text-right">
                                          <form action="{{url("/")}}/crm/changerole-permission-{{$rolle->id}}" method="POST">
                                            @CSRF
                                            <div id="inputs-{{$rolle->id}}">

                                            </div>
                                            
                                          @isset(auth()->user()->roles[0])
                                            @if (auth()->user()->roles[0]->permissions->where("name", "set.roles_perms")->first() != null)
                                              <button type="button" onclick="document.getElementById('new-permission-modal').classList.remove('hidden'); document.getElementById('new-permission-input').value = '{{$rolle->id}}'" class="bg-green-600 rounded-md text-white font-semibold text-md px-4 py-2 mt-1 mb-1 mr-6 inline-block">neue Berechtigung</button>
                                              <button type="submit" class="bg-blue-600 hover:bg-blue-500 rounded-md text-white font-semibold text-md px-4 py-2 mt-1 mb-1 mr-6 inline-block">Speichern</button>
                                            @endif
                                          @endisset
                                        </form>
                                        </td>
                                      </tr>
                                    
                                    </tbody>
                                  </table>
                                  @endforeach
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                  </div>
            </div>
          </div>
    </div>
    

    <script>
      function changeInput(id) {
        if(document.getElementById('span-1-'+id).classList.contains('bg-blue-600 hover:bg-blue-500')) {

          document.getElementById('span-1-'+id).classList.remove('bg-blue-600 hover:bg-blue-500');
          document.getElementById('span-1-'+id).classList.add('bg-gray-200');
          document.getElementById('span-2-'+id).classList.remove('translate-x-5');
          document.getElementById('span-2-'+id).classList.add('translate-x-0');

          if(document.getElementById('input-'+id)) {
            document.getElementById('input-'+id).value = "delete";
          } else {
            let input = document.createElement('input');
            input.setAttribute('id', 'input-'+id);
            input.value   = "delete";
            input.name    = 'permission-' + id;
            input.classList.add('hidden');
            
            document.getElementById('inputs-' + id.split("-")[0]).appendChild(input);
          }

        } else {

          document.getElementById('span-1-'+id).classList.add('bg-blue-600 hover:bg-blue-500');
          document.getElementById('span-1-'+id).classList.remove('bg-gray-200');
          document.getElementById('span-2-'+id).classList.add('translate-x-5');
          document.getElementById('span-2-'+id).classList.remove('translate-x-0');

          let input = document.createElement('input');
          input.setAttribute('id', 'input-'+id);
          input.value   = id;
          input.name    = 'permission-' + id;
          input.classList.add('hidden');
          
          document.getElementById('inputs-' + id.split("-")[0]).appendChild(input);
        }
      }

      let rollenIds = [@foreach($rollen as $rolle) "{{$rolle->id}}", @endforeach "2"];
      function changeRoleTab(id) {

        rollenIds.forEach(rollenId => {
          if(id != rollenId) {
            document.getElementById('table-'+rollenId).classList.add('hidden');
            document.getElementById('tab-button-'+rollenId).classList.remove('bg-blue-600', "text-white");
            document.getElementById('tab-button-'+rollenId).classList.add("text-black", "bg-gray-200");
          } else {
            document.getElementById('table-'+rollenId).classList.remove('hidden');
            document.getElementById('tab-button-'+rollenId).classList.add('bg-blue-600', "text-white");
            document.getElementById('tab-button-'+rollenId).classList.remove("text-black", "bg-gray-200");
          }
        });

      }
    </script>

@include('forEmployees.modals.new-role')

@include('forEmployees.modals.new-permission')

@include('layouts.error')

</body>
</html>