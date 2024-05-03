<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Kürzel</th>
              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Name</th>
              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Straße</th>
              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">E-Mail</th>
              <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Telefonnummer</th>
              <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
                <p class="text-right">Aktion</p>
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            @foreach ($contacts as $contact)
            <tr>
                <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$contact->shortcut}}</td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$contact->firstname}} {{$contact->lastname}}</td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$contact->street}} {{$contact->streetno}}</td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$contact->email}}</td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$contact->mobilnumber ?: $contact->phonenumber}}</td>
                <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <button type="button" onclick="getEditContact('{{$contact->id}}')" class="inline-flex items-center rounded-md border border-transparent bg-gray-200 shadow px-3 py-2 text-sm font-medium leading-4 text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Bearbeiten</button>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>