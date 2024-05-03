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

  @include('layouts.top-menu', ["menu" => "settings", "undermenu" => "benutzer"])

  <h1 class="py-6 text-4xl font-bold ml-10 text-black float-left">Einstellungen > Benutzer </h1>

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
          <button type="button" onclick="document.getElementById('new-profil-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-600 px-5 py-2 font-medium text-normal rounded-md text-center"><span class="">Neuen Benutzer anlegen</span> </button>

        </nav>
    </div>
    <button type="button" onclick="window.location.href = '{{url("/")}}/crm/rollen'" class="float-right bg-yellow-600 text-white mr-12 hover:text-gray-600 px-5 py-2 font-medium text-normal rounded-md text-center">Rollen</button>
  </div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="overflow-hidden  shadow sm:rounded-lg">
            <div class="px-4 sm:p-6">
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                          <table class="min-w-full divide-y divide-gray-300 " id="table-">
                            <thead class="bg-gray-50">
                                <tr>
                                  <th scope="col" class="py-3.5 pl-3  text-left text-sm font-semibold text-gray-900 ">Name</th>
                                  <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Nutzername</th>
                                  <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Passwort</th>
                                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">E-Mail</th>
                                  <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Signatur</th>
                                  <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Rolle</th>
                                  <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Zuletzt geändert</th>
                                  <th scope="col" class="px-3 py-3.5 pr-4 text-right text-sm font-semibold text-gray-900">Aktion</th>
                                </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="px-3 py-1">
                                        {{$user->name}}
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        {{$user->username}}
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        *********
                                    </td>
                                    <td class="px-3 py-1 text-left">
                                        {{$user->email}}
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($user->signatur != null)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 m-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                          </svg>                                          
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @foreach ($user->getRoleNames() as $roleName)
                                            {{$roleName}} 
                                        @endforeach
                                    </td>
                                    <td class="pl-8 py-1 text-center">
                                      {{$user->updated_at->format("d.m.Y")}}
                                    </td>
                                    <td class="px-3 py-1">
                                      @isset(auth()->user()->roles[0])
                                        @if(auth()->user()->roles[0]->permissions->where("name", "change.userprofile")->first() != null)
                                          <a href="{{url("/")}}/crm/benutzer-bearbeiten-{{$user->id}}" class="float-right bg-blue-200 text-blue-600 rounded-md font-semibold px-3 py-1.5">bearbeiten</a>
                                        @endif
                                      @endisset
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

@isset($changedUser)
    @include('forEmployees.modals.change-profil')
@endisset
@include('forEmployees.modals.neues-profil')

</body>
</html>