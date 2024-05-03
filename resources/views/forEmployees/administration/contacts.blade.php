<!DOCTYPE html>
<html lang="en" class="bg-white">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{url('/')}}/css/text.css">
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places">
</script>   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

</head>
<body>
    @include('layouts.top-menu', ["menu" => "none"])

    <hr style="width: 95%; margin: auto; border-color:rgba(92, 106, 177, 0.253)" style="m-auto">
    <h1 class="py-6 text-4xl font-bold ml-8 text-black flex">
      <span class="">Einstellungen</span> 
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 font-bold">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
    Adressbuch</h1>

    <div class="mx-auto max-w-full sm:px-8 lg:px-8">

            <button onclick="getNewContact()" class="mt-8 bg-blue-600 hover:bg-blue-400 text-white px-5 py-2 font-medium text-normal rounded-md flex">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mt-0.5">
                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
              </svg>
              <p class="ml-2">Neue Adresse anlegen</p>                
            </button>

        
        <div class="mt-4 flow-root" id="contacts-table">
                
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
        </div> 
    </div>
  </div>

  <div id="contact-change-div">

  </div>

  <script>
    function getNewContact() {
      loadData();
      $.get("{{url('/')}}/crm/adressbuch/neu", function(data, status){
        document.getElementById('contact-change-div').classList.remove('hidden');
        document.getElementById("contact-change-div").innerHTML = data;

        $('#contact-new-form').ajaxForm(function(data) {
          document.getElementById("contacts-table").innerHTML = data;
          document.getElementById('contact-change-div').innerHTML = '';
          savedPOST();
        });

        savedPOST();
      });
    }

    function getEditContact(contact) {
      loadData();
      $.get("{{url('/')}}/crm/adressbuch/edit-"+contact, function(data, status){
        document.getElementById('contact-change-div').classList.remove('hidden');
        document.getElementById("contact-change-div").innerHTML = data;

        $('#contact-change-form').ajaxForm(function(data) {
          document.getElementById("contacts-table").innerHTML = data;
          document.getElementById('contact-change-div').innerHTML = '';
          savedPOST();
        });

        savedPOST();
      });
    }

    function changeTimePlusTwo(value) {
      if(parseInt(value.split(':')[0]) <= 9) {
        plus = parseInt(value.split(':')[0]) + 2;
        document.getElementById('end').value = "0" + plus + ':' + value.split(':')[1];
      } else {
        document.getElementById('end').value = parseInt(value.split(':')[0]) + 2 + ':' + value.split(':')[1];
      }
    }

    function changeTimeMinusTwo(value) {
      if(parseInt(value.split(':')[0]) <= 9) {
        plus = parseInt(value.split(':')[0]) - 2;
        document.getElementById('start').value = "0" + plus + ':' + value.split(':')[1];
      } else {
        document.getElementById('start').value = parseInt(value.split(':')[0]) - 2 + ':' + value.split(':')[1];
      }
    }

    function deleteContact(id) {
      loadData();
      $.get("{{url("/")}}/crm/contact/delete/"+id, function(data) {
        document.getElementById("contacts-table").innerHTML = data;
        document.getElementById('contact-change-div').innerHTML = ''
        savedPOST();
      });
    }

  </script>
      
</body>
</html>