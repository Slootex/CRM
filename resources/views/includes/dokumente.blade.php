<form action="{{url("/")}}/crm/upload/files/{{$person->process_id}}/dokumente" method="POST" enctype="multipart/form-data">
    @CSRF
  <div class="bg-white px-0 py-0 shadow sm:rounded-lg sm:p-6 mt-6  w-full">
    <div class="px-0 sm:px-6 lg:px-8 mb-8">
      <div class="px-0 sm:px-6 lg:px-8 mb-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-normal text-gray-900">Dokumente</h1>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <div class="float-left mr-8" style="margin-top: .1rem">
              <select id="location" name="type" class="mt-0 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                <option value="Undefiniert">Undefiniert</option>
                <option value="Auftragsdokumente">Auftragsdokumente</option>
                <option value="Bilder">Bilder</option>
                <option value="Reklamation">Reklamation</option>
                <option value="Kundenupload">Kundenupload</option>
              </select>
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
             neues Dokument</button>
             <input id="file-upload" name="file[]" type="file" class="ml-0 mr-2 mt-1 float-left border border-gray-600 bg-blue-200 rounded-lg" onchange="dokumenteDateiText()">

          </div>
        </div>
       
        <div class="mt-3 flex flex-col">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum</th>
                      <th scope="col" class="px-1 py-2 text-left text-sm font-semibold text-gray-900">Dateiname</th>
                      <th scope="col" class="px-1 py-2 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                      <th scope="col" class="px-1 py-2 text-left text-sm font-semibold text-gray-900">Beschreibung</th>
                      <th scope="col" class="px-1 py-2 text-left text-sm font-semibold text-gray-900">Bereich</th>
                      <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                   
                    @foreach ($files as $file)
                    <tr>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$file->created_at->format("d.m.Y")}} ({{$file->created_at->format("H:i")}})</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-blue-500"><a href="{{url("/")}}/files/aufträge/{{$file->process_id}}/{{$file->filename}}" target="_blank" rel="noopener noreferrer">{{$file->filename}}</a></td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$file->employee}}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$file->description}}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$file->type}}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-red-600"><a href="/crm/delete/file/{{$file->process_id}}/{{$file->filename}}/dokumente">Löschen</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <br>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>