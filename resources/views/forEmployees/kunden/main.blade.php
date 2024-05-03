<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script 
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script> 

</head>
<body>
@include('layouts/top-menu', ["menu" => "kunden"])

<div class="px-8">
    <div class="pt-5">
      <div class="h-16 w-full">
        <h1 class="text-4xl font-bold pt-2 pb-3 text-black float-left">Kundenübersicht</h1>
      </div>
<div>
    <div>
      <div>
        
        <div class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">

                <table class="w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      
                      
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900 pl-2">
                        
                        <div class=" float-left">
                          Erstellt
                          @isset($sorting)
                          @if ($sorting == "created_at-up")
                          <a href="{{url("/")}}/crm/kunden/sortieren-created_at-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "created_at-down")
                          <a href="{{url("/")}}/crm/kunden/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/kunden/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/kunden/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @endisset
                          
                          </div>                                                 
                      </th>
                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                      </th>
                      <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">  
                       
                        KD Nr
                      </th>
                      <th></th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                      
                        Firma
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        
                       
                        Vorname
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        Straße
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        Nr
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                      
                        PLZ
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        Stadt
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                       
                        Land
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                     
                        Telefon
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                      
                        E-Mail
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                   
                        Lieferadresse
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "updated_at-up")
                        <a href="{{url("/")}}/crm/kunden/sortieren-updated_at-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "updated_at-down")
                        <a href="{{url("/")}}/crm/kunden/sortieren-updated_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/kunden/sortieren-updated_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/kunden/sortieren-updated_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Geändert
                      </th>

                      <th scope="col" class=" py-3.5 text-left text-sm font-semibold text-gray-900">
                     
                        Mitarbeiter
                      </th>

                      

                      
                      <th id="kundendaten-filter-main-div" scope="col" class=" py-3.5 text-right pr-2 text-sm font-semibold text-gray-900">
                        <svg onclick="document.getElementById('kunden-filter-div').classList.toggle('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-600 hover:text-gray-400 cursor-pointer float-right">
                          <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                        </svg>
                        <div id="kunden-filter-div" class="hidden w-52 rounded-lg bg-white shadow-md absolute right-0 mr-8 mt-4 ">
                          <form action="{{url("/")}}/crm/kunden/filter" id="kunden-filtern-form" method="POST">
                            @CSRF

                          <div class=" ml-1 mr-6">
                            <p class="font-bold">Kundennummer</p>     
                            <input name="kundenid" class=" block w-40 float-right rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                          </div>

                          <div class="px-6 py-2 mt-10">

                            <div class=" ml-1">
                                <p class="font-bold">Bereich</p>     
                                <select name="area" class=" block w-40 float-right rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="Aufträge">Aufträge</option>
                                    <option value="Interessenten">Interessenten</option>
                                    <option value="Beide">Beide</option>
                                  </select>
                            </div>
                          </div>

                          <div class=" ml-1 mr-6 mt-12">
                            <p class="font-bold">Einträge pro Seite</p>     
                            <select name="count" class=" block w-40 float-right rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="300">300</option>
                                <option value="500">500</option>
            
                              </select>
                          </div>
<br>
<br>
                          <div class="px-6 py-4">
                            <button type="submit" onclick="loadData();" class="w-full py-1 rounded-md bg-blue-600 hover:bg-blue-400 text-white px-4 font-medium text-md">Filtern</button>
                          </div>
                        </form>
                        </div>                        
                      </th>

                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white" id="kundendaten-table">
                    @php
                        $orderCounter = 0;
                        $usedKunden = array();
                    @endphp
                   

                    @foreach ($kunden as $kunde)
                    @php
                        $order = $kunde->merged_person_datas;
                        if($order == null) {
                          continue;
                        }
                    @endphp
                      @if (!in_array($order->kunden_id, $usedKunden))
                        <tr class="hover:bg-blue-100 @if($order->sperre == "true") bg-red-100 @endif" id="row-{{$order->kunden_id}}">
                          <td class="whitespace-nowrap pl-6 py-1 text-sm text-gray-500 ">{{$order->updated_at->format("d.m.Y (H:i)")}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">

                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">K{{$order->kunden_id}}</td>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">
                            <p class="truncate overflow-hidden whitespace-nowrap">{{$order->company_name}}</p>
                          </td>
                          <td class="truncate overflow-hidden whitespace-nowrap py-1 text-sm text-gray-500">
                            <p class="truncate overflow-hidden whitespace-nowrap" style="max-width: 10rem">{{$order->firstname}}</p>
                          </td>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">
                            <p class="truncate overflow-hidden whitespace-nowrap" style="max-width: 10rem">{{$order->lastname}}</p>

                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">{{$order->home_street}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500" >
                            {{$order->home_street_number}}
                          </td>
                          <td class="whitespace-nowrap  py-1  text-sm text-gray-500">{{$order->home_zipcode}}</td>
                          <td class="whitespace-nowrap  py-1  text-sm text-gray-500">{{$order->home_city}}</td>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">{{$order->home_country}}</td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            {{$order->mobile_number ?: $order->phone_number}}                           
                          </td>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">{{$order->email}}</td>
                          <td class="whitespace-nowrap py-1 text-sm text-gray-500">
                            {{$order->send_back_street ?: $order->home_street}} 
                            {{$order->send_back_street_number ?: $order->home_street_number}}
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            {{$order->updated_at->format("d.m.Y (H:i)")}}
                          </td>
                          <td class="whitespace-nowrap  py-1 text-sm text-gray-500">
                            @if ($users->where("id", $order->employee)->first() != null)
                            {{$users->where("id", $order->employee)->first()->username}}                       

                            @endif
                          </td>

                        
                          <td class="whitespace-nowrap pr-2 py-1 text-sm text-gray-500 ">
                            <button type="button" onclick="getKundendatenModal('{{$order->kunden_id}}')" class="float-right">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 hover:text-blue-400 float-right ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                              </svg>      
                            </button>                      
                          </td>
                        
                        </tr>
                        @php
                            array_push($usedKunden, $order->kunden_id);
                        @endphp
                      @endif
                    @php
                        $orderCounter++;
                    @endphp
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
    </div></div>

    <script>
      function getKundendatenModal(id) {
        loadData();
        $.get('{{url("/")}}/crm/get-kundendaten-modal-'+id, function(data) {
          $('#change-kunde-modal').html(data);
          $('#save-kundendaten-form').ajaxForm(function(data) { 
            document.getElementById("change-kunde-modal").innerHTML = data;
            savedPOST(); 
          });
          document.getElementById("change-kunde-modal").classList.remove("hidden");
          savedPOST();
        });
      }

      function toggleSperre(id) {

        if(document.getElementById("sperre-button").classList.contains("bg-red-600")) {
          document.getElementById("sperre-button").classList.add("bg-green-600", "hover:bg-green-400");
          document.getElementById("sperre-button").classList.remove("bg-red-600", "hover:bg-red-400");

          document.getElementById("row-"+id).classList.add("bg-red-100");
          
          document.getElementById("sperre-button").innerHTML = "Sperre aufheben";

          document.getElementById('sperre-modal').classList.remove('hidden');

          document.getElementById('bg-red').classList.remove('bg-white');
          document.getElementById('bg-red').classList.add('bg-red-200');
        } else {
          document.getElementById("sperre-button").classList.remove("bg-green-600", "hover:bg-green-400");
          document.getElementById("sperre-button").classList.add("bg-red-600", "hover:bg-red-400");

          document.getElementById("row-"+id).classList.remove("bg-red-100");

          document.getElementById("sperre-button").innerHTML = "Kunde Sperren";
          document.getElementById('sperre-modal').classList.add('hidden');
          document.getElementById('bg-red').classList.add('bg-white');
          document.getElementById('bg-red').classList.remove('bg-red-200');


        }

        $.get("{{url("/")}}/crm/kundendaten-kunde-sperren-"+id, function(data) {

         

        });

      }
    </script>


      <div>
        <form id="save-kundendaten-form" action="{{url("/")}}/crm/change-kundendaten" method="POST">
          @CSRF
          <div id="change-kunde-modal">
          </div>
        </form>
      </div>

    @isset($finishedEdit)

    <div class="relative z-10" id="finished-edit-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
            <div>
              <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Erfolgreich gespeichert</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Die änderungen wruden erfolgreich gespeichert!</p>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6">
              <button type="button" onclick="document.getElementById('finished-edit-modal').classList.add('hidden')" class="border border-gray-600 text-sm w-full font-medium px-4 py-2 rounded-md">Zurück</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endisset
    <script>
        $("#kunden-filtern-form").ajaxForm(function(data) { 
          document.getElementById("kundendaten-table").innerHTML = data;
          savedPOST(); 
        });
  
    </script>

</body>
</html>