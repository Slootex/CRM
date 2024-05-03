<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "setting"])

    <h1 class="py-6 text-4xl font-bold ml-10 text-black">Einstellungen > Siegel </h1>

    <div class=" m-auto mt-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="hidden sm:block">
                <form action="{{url("/")}}/crm/siegel/hochladen" method="POST" enctype="multipart/form-data">
                  @CSRF
                  <nav class=" w-full" aria-label="Tabs">                      
                      <div class=" inline-block float-left  items-center justify-center bg-grey-lighter">
                          <label class="w-64  flex flex-col items-center px-4 py-1.5 bg-white text-blue rounded-lg g tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue-400">
                              
                              <span class="mt-0 text-base leading-normal overflow-hidden truncate" style="max-width: 13rem" id="filename"><span class="float-left">Datei</span>  <svg class="w-5 h-5 float-left  ml-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                  <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                              </svg></span>
                              <input type='file' oninput="document.getElementById('filename').innerHTML = this.value.split('\\')[this.value.split('\\').length - 1]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="hidden" name="file" />
                          </label>
                      </div>
                      <button type="submit"  class="bg-blue-600 hover:bg-blue-500 inline-block text-white hover:text-gray-800 px-5 py-2 ml-16 font-medium text-normal rounded-md"><span class="">Hochladen</span> </button>
                      <button type="button" onclick="document.getElementById('seal-settings-modal').classList.remove('hidden')" class="float-right bg-blue-600 hover:bg-blue-400 text-white rounded-md p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                          <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                        </svg>  
                      </button>
                    </nav>
                </form>
                
              </div>            
              <div class="mt-8 flow-root">
                
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Siegel</th>
                          <th scope="col" class="px-3 py-1 text-center text-sm font-semibold text-gray-900">Benutzt</th>
                          <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Benutzt von</th>
                          <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Benutzt am</th>
                          <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Benutztes Gerät</th>
                          <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
                            <p class="text-right">Aktion</p>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($seals as $seal)
                        <tr>
                            <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$seal->code}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                @if($seal->used)  
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="m-auto w-5 h-5 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                    </svg>                                  
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="m-auto w-5 h-5 text-red-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                                    </svg>                                  
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">@isset($seal->user){{$seal->user->username}}@endisset</td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                              @if ($seal->used_date != null)
                                @php
                                  $date = new DateTime($seal->used_date);
                                @endphp
                                {{$date->format("d.m.Y (H:i)")}}
                              @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$seal->component_number}}</td>
                            <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                              <a href="{{url("/")}}/crm/siegel/löschen-{{$seal->id}}" class="text-red-600 hover:text-red-400">löschen</a>
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

    <div class="relative hidden z-10" id="seal-settings-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4  text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm py-4">
            <div >
              <h2 class="text-xl font-bold">Siegel Löschzeit</h2>
              <p class="text-sm text-gray-500 mt-0.5">Hier können Sie die Zeit festlegen nach dem ein Benutzes Siegel gelöscht wird.</p>
            </div>
            <div class="mt-6">
              <div>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <form onsubmit="event.preventDefault();" action="placeholder" method="POST">
                    <input value="{{$data->seal_days}}" required id="seal-days" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" type="number" name="days" class="block w-full rounded-md border-0 py-1.5 pl-4 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="0"">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                      <span class="text-gray-500 sm:text-sm">Tage</span>
                    </div>
                    <button type="submit" class="hidden" id="submit-settings"></button>
                  </form>
                </div>
              </div>
            </div>

            <div class="mt-8">
              <button type="button" onclick="editSealSettings()" class="float-left bg-blue-600 hover:bg-blue-400 text-white text-md font-medium px-4 py-2 rounded-md">Speichern</button>
              <button type="button" onclick="document.getElementById('seal-settings-modal').classList.add('hidden')" class="float-right text-black hover:bg-gray-200 rounded-md border border-black text-md font-medium px-4 py-2 ">Abbrechen</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      function editSealSettings() {
        let days = document.getElementById("seal-days").value;
        if(days != "") {

          loadData();
          $.get("{{url("/")}}/crm/siegel/edit-setting-"+days, function(data) {
            document.getElementById("seal-settings-modal").classList.add("hidden");
            savedPOST();
          });
        } else {
          document.getElementById("submit-settings").click();
        }
      }
    </script>
</body>
</html>