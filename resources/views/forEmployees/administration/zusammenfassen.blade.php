<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        
        
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block w-96 py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-hidden  md:rounded-lg">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="mt-8 flex flex-col">
                          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                  <thead class="bg-gray-50">
                                    <tr>
                                      <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Gerät</th>
                                      <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        <span >Hinzufügen</span>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody class="divide-y divide-gray-200 bg-white">
                                   @foreach ($warenausgang as $ausgang)
                                   <tr>
                                    <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$ausgang->component_number}}</td>
                              
                                    <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                      <a href="#" class="text-blue-600 hover:text-blue-900">Hinzufügen</a>
                                    </td>
                                  </tr>
                                   @endforeach
                      
                                    <!-- More people... -->
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
            </div>
          </div>

          

    </div>
      

</body>
</html>