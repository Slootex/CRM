<div class=" w-full px-6 py-6">
  <script src="https://api.geoapify.com/v1/geocode/autocomplete?text=Mosco&apiKey=678d18e9877b413492a30ac82eaa1b51"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
  <script src="{{url('/')}}/js/text.js"></script>
  <form action="/crm/send/email/order/{{$person->process_id}}" method="post">
    @CSRF
  <label for="location" class="block text-sm font-medium text-gray-700">Email-Vorlage</label>
  <select id="emailid" name="email_template" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
    @foreach ($email_templates as $temp)
        <option value="{{$temp->id}}">{{$temp->name}}</option>
    @endforeach
  </select>
  <fieldset class="space-y-5 mt-6 float-left">
    <div class="relative flex items-start">
      <div class="flex h-5 items-center">
        <input id="tec_email_check" onclick="tec_email()" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      </div>
      <div class="ml-3 text-sm">
        <label for="comments" class="font-medium text-gray-700">An Techniker?</label>
      </div>
    </div>
  
  </fieldset>
  <fieldset class="space-y-5 mt-6 float-left ml-10">
    <div class="relative flex items-start">
      <div class="flex h-5 items-center">
        <input id="tec_email_check" onclick="showAnhang()" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      </div>
      <div class="ml-3 text-sm">
        <label for="comments" class="font-medium text-gray-700">Anhang?</label>
      </div>
    </div>
  
  </fieldset>
  <script>
    var tec_check = false
    function tec_email() {
      if(tec_check == false) {
        document.getElementById("tec_email").classList.remove("hidden");
        tec_check = true;
      } else {
        document.getElementById("tec_email").classList.add("hidden");
        tec_check = false;
      }
    }
    let anhangCheck = false
    function showAnhang() {
      if(anhangCheck == false) {
        document.getElementById("anhang").classList.remove("hidden");
        anhangCheck = true;
      } else {
        document.getElementById("anhang").classList.add("hidden");
        anhangCheck = false;
      }
    }
  </script>
  <div class="float-left mt-2 ml-3 hidden" id="tec_email">
    <label for="location" class="block text-sm font-medium text-gray-700">Techniker</label>
    <select id="location" name="shortcut" class="mt-1 block w-36 rounded-md border-gray-300 py-2 pl-3 pr-2 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
      <option value="null">Techniker</option>
      @foreach ($contacts as $contact)
          <option value="{{$contact->shortcut}}">{{$contact->shortcut}}</option>
      @endforeach
    </select>
  </div>
  <div class="float-left mt-2 ml-3 hidden" id="anhang">
    <label for="location" class="block text-sm font-medium text-gray-700">Datei</label>
    <select id="location" name="file" class="mt-1 block w-36 rounded-md border-gray-300 py-2 pl-3 pr-2 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
      <option value="null">Anhang</option>
      @foreach ($files as $file)
          <option value="{{$file->filename}}">{{$file->filename}}</option>
      @endforeach
    </select>
  </div>
  <button type="button" onclick="window.location.href = '{{url('/')}}/crm/email/bearbeiten/order/{{$person->process_id}}/' + document.getElementById('emailid').value" class="mt-8 float-right ml-4 inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
    <!-- Heroicon name: mini/envelope -->
    Bearbeiten
  </button>
  <button type="submit" class="mt-8 float-right inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    <!-- Heroicon name: mini/envelope -->
    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
      <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
    </svg>
    Senden
  </button>
  </form>
  <br>
  <br>
  @isset($email)
  <div>
    <div class="w-full px-8 bg-gray-100 py-2">
      <h1 class="text-xl font-bold">Email bearbeiten</h1>
    </div>
    <div class="bg-gray-50 w-full px-8 py-2">
      <label for="email" class="block text-sm font-medium text-gray-700">Betreff</label>
      <div class="mt-1">
        <input type="text" value="{{$email->subject}}" name="email" id="betreff" class="block w-96 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
      </div>
      
      <script>
         $( document ).ready(function() {
                              $.trumbowyg.svgPath = '/icons.svg';
                              $('#trumbowyg-demo').trumbowyg();
                          });
                         

                          function postEmailChange() {
                              var bereichvar      = document.getElementById("absender").value;
                              var betreffvar      = document.getElementById("betreff").value;
                              var bodyvar         = $('#trumbowyg-demo').trumbowyg('html');
                              $.ajaxSetup({
                                headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                              });
                               $.ajax({
                                   url: "{{url('/')}}/crm/email/custom/send",
                                   method: "POST",
                                   data: { absender: bereichvar, betreff: betreffvar, body: bodyvar, process_id: '{{$person->process_id}}' }
                               }).done(results => {
                                console.log(results);
                                  window.location.href   = "{{url('/')}}/crm/change/order/{{$person->process_id}}/status";                                                                                                                                                                             
                               })                             
                          }
      </script>
      <br>
      <textarea class="mt-6" name="example" id="trumbowyg-demo">{{$email->body}}</textarea>
      <button type="button" onclick="postEmailChange()" class="mt-8 inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <!-- Heroicon name: mini/envelope -->
        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
          <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
        </svg>
        Senden
      </button>
    </div>
  </div>
  @endisset

</div>

<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Status</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
        <th scope="col" class="px-1 py-1 text-left text-sm font-semibold text-gray-900">Info</th>
        <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-6">
          <span class="sr-only">Edit</span>
        </th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @foreach ($e_his as $e)
         @isset($e->id)
         <tr>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$e->created_at->format("d.m.Y")}} ({{$e->created_at->format("H:i")}})</td> 
          <td class="inline-flex rounded-full bg-green-100 px-2  text-xs font-semibold leading-5">Eingang</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$e->employee}}</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{substr($e->body, 0, 50)}}...</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500"><svg onclick="readStatus('{{$e->process_id}}','{{$e->created_at}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          </td>

        </tr>
        @else
        <tr>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$e->created_at->format("d.m.Y")}} ({{$e->created_at->format("H:i")}})</td> 
          <td class="inline-flex rounded-full bg-green-100 px-2  text-xs font-semibold leading-5">Email</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{$e->employee}}</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{substr($e->body, 0, 50)}}...</td>
          <td class="whitespace-nowrap px-3 py-1 text-sm text-blue-500"><svg onclick="readStatus('{{$e->process_id}}','{{$e->created_at}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          </td>

        </tr>
         @endisset
      @endforeach

    </tbody>
  </table>