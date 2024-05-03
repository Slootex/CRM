<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script 
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
</head>

<body>
    @include('layouts/top-menu', ["menu" => "kunden"])

    <div class="px-8">
        <div class="pt-5">
          <div class="h-16 w-full">
            <h1 class="text-4xl font-bold pt-2 pb-3 text-white float-left">Einstellungen > Unverifizierte Kunden</h1>
          </div>
        </div>

        <div>
            <button type="button" class="text-white font-medium px-4 py-2  bg-blue-600 hover:bg-blue-400 rounded-md">Neu anlegen</button>
        </div>


        <div>
            <div class="px-4 bg-white rounded-md sm:px-6 lg:px-8">

                <div class="mt-8 flow-root">
                  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                      <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                          <tr>
                            <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Grund kurz beschrieben</th>
                            <th scope="col" class="py-1 text-right text-sm font-semibold text-gray-900">Aktion</th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          @foreach ($kunden as $kunde)
                            <tr>
                              <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$kunde->firstname}} {{$kunde->lastname}}</td>
                              <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$kunde->grund}}</td>
                              <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <button class="bg-blue-100 text-blue-600 hover:bg-blue-50 rounded-md px-4 py-2 font-medium">Bearbeiten</button>
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

    <div class="relative hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
             
            </div>
          </div>
        </div>
      </div>


</body>
</html>