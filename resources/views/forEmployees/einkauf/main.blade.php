<!doctype html>
<html class="h-full bg-white">
<head><title>CRM P+</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  @vite('resources/css/app.css')
  <script 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&libraries=places&callback=initMap">
</script>
</head>
<body>
@include('layouts/top-menu', ["menu" => "einkauf"])

<div>
    <div>
      <div>
        
        <div class="mt-8 flow-root px-8">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block w-full py-2 align-middle sm:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <form action="{{url("/")}}/crm/auftrag/set-multi-status" method="POST">
                  @CSRF
                <table class="w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900 pl-2">
                        
                        <div class=" float-left">
                          Erstellt
                          @isset($sorting)
                          @if ($sorting == "created_at-up")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-down">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                            
                           
                                                          
                          
                          </a>@else
                          @if ($sorting == "created_at-down")
                          <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                            </a>
                          @endif
                          @endif
                          @else 
                          <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                              <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                            </svg>
                          </a>
                          @endisset
                          
                          </div>                                                 
                      </th>

                      <th scope="col" class="py-1 text-left text-sm font-semibold text-gray-900">  
                        @isset($sorting)
                        @if ($sorting == "process_id-up")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "process_id-down")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-process_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @endisset
                        
                        Auftrag
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "kunden_id-up")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-kunden_id-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "kunden_id-down")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-kunden_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-kunden_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-kunden_id-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                          @endisset
                        Kategorie
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "firstname-up")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "firstname-down")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-firstname-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Preis
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        Rechnungsdatum
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "phone_number-up")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-phone_number-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "phone_number-down")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-phone_number-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-phone_number-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-phone_number-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Rechnungsnummer
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        @isset($sorting)
                        @if ($sorting == "status-up")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-status-down">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                          
                         
                                                        
                        
                        </a>@else
                        @if ($sorting == "status-down")
                        <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                          </a>
                        @endif
                        @endif
                        @else 
                        <a href="{{url("/")}}/crm/aufträge/sortieren-status-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      @endisset
                        Status
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        Lieferantendaten
                      </th>

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                        <a href="{{url("/")}}/crm/aufträge/sortieren-created_at-up">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 float-left mr-2 ">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        Sendungsverfolgung
                      </th>

                     

                      <th scope="col" class=" py-1 text-left text-sm font-semibold text-gray-900">
                      
                      </th>

                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white" id="einkauf-liste">
                    @include('forEmployees.einkauf.main-liste')
                  </tbody>
                </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div id="einkauf-modal-div">

</div>

<script>    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadEinkaufTable(einkauf) {

            document.getElementById("einkauf-auftrag-liste").innerHTML = einkauf;
            savedPOST();

    }

    function getNeuerEinkauf() {

        loadData();
        $.get("{{url("/")}}/crm/einkauf/neuer-einkauf", function(data) {
            document.getElementById("einkauf-modal-div").innerHTML = data;

            var currentDateEinkauf = new Date();
            document.getElementById("einkauf-rechnungsdatum").valueAsDate = currentDateEinkauf;

            $('#neuer-einkauf-form').ajaxForm(function(einkauf) { 

                document.getElementById("einkauf-liste").innerHTML = einkauf;
                document.getElementById('einkauf-modal-div').innerHTML = '';
                
                savedPOST();
            });
            document.getElementById("einkauf-pos-id").value = Math.floor(Math.random() * 100000);

            savedPOST();
        });

    }

    function submitPositionChange(idPos) {

    let mengePos = document.getElementById("einkauf-pos-menge-"+idPos).value;
    let artnrPos = document.getElementById("einkauf-pos-artnr-"+idPos).value;
    let bezPos = document.getElementById("einkauf-pos-bezeichnung-"+idPos).value;
    let mwstPos = document.getElementById("einkauf-pos-mwst-"+idPos).value;
    let nettoPos = document.getElementById("einkauf-pos-netto-"+idPos).value;
    let mwstBetPos = document.getElementById("einkauf-pos-mwstbetrag-"+idPos).value;
    let rabattPos = document.getElementById("einkauf-pos-rabatt-"+idPos).value;
    let bruttoPos = document.getElementById("einkauf-pos-brutto-"+idPos).value;

    loadData();
    $.post( "{{url("/")}}/crm/kunde-bearbeiten/position", {   
        menge: mengePos,  
        artnr: artnrPos,  
        bezeichnung: bezPos,  
        mwst: mwstPos,  
        netto: nettoPos,  
        mwstbetrag: mwstBetPos, 
        rabatt: rabattPos,  
        brutto: bruttoPos,  
        id: idPos,
    })
      .done(function( einkauf ) {
        loadEinkaufTable(einkauf);
      });
    }

    function showPositionChange(id) {

        loadData();
        $.get("{{url("/")}}/crm/kunde-bearbeiten/position-"+id, function(einkauf) {
            loadEinkaufTable(einkauf);
        });
    }

    function deletePosition(id) {

        loadData();
        $.get("{{url("/")}}/crm/kunde-bearbeiten/delete-position-"+id, function(einkauf) {
            loadEinkaufTable(einkauf);
        });
    }

    function checkAuftragsnummer(id) {

        loadData();
        $.get("{{url("/")}}/crm/check-auftragsnummer-"+id, function(data) {
            if(data == "found") {
                document.getElementById("einkauf-auftrag-text-base").classList.add("hidden");
                document.getElementById("einkauf-auftrag-text-not-found").classList.add("hidden");
                document.getElementById("einkauf-auftrag-text-found").classList.remove("hidden");
            } else {
                document.getElementById("einkauf-auftrag-text-base").classList.add("hidden");
                document.getElementById("einkauf-auftrag-text-found").classList.add("hidden");
                document.getElementById("einkauf-auftrag-text-not-found").classList.remove("hidden");
            }
            savedPOST();
        });
    }

    function addNewPosition(idPos) {
        
        $.post( "{{url("/")}}/crm/einkauf-aktiv/neue-position", {   
            id: idPos
    })
      .done(function( einkauf ) {
        loadEinkaufTable(einkauf);
      });
    }

    function getEditEinkauf(id, pos) {
        loadData();
        $.get("{{url("/")}}/crm/kunde-bearbeiten/get-einkauf-"+id, function(einkauf) {
            document.getElementById("einkauf-modal-div").innerHTML = einkauf;

            $('#neuer-einkauf-form').ajaxForm(function(einkauf) { 

                document.getElementById("einkauf-liste").innerHTML = einkauf;
                document.getElementById('einkauf-modal-div').innerHTML = '';
                savedPOST();
            });

            document.getElementById("einkauf-pos-id").value = pos;

            savedPOST();
        });
    }
  
    function deleteEinkauf(id) {
      
      loadData();
      $.get("{{url("/")}}/crm/einkauf/delete-einkauf-"+id, function(einkauf) {

        document.getElementById("einkauf-liste").innerHTML = einkauf;
        document.getElementById("einkauf-modal-div").innerHTML = "";
        savedPOST();
      });
    }

    function deleteEinkaufReverse(id) {
      
      loadData();
      $.get("{{url("/")}}/crm/einkauf/delete-reverse-"+id, function(einkauf) {

        document.getElementById("einkauf-liste").innerHTML = einkauf;
        document.getElementById("einkauf-modal-div").innerHTML = "";
        savedPOST();
      });
    }

    function getEinkaufArchiv() {

      loadData();
      $.get("{{url("/")}}/crm/einkauf/archiv", function(einkauf) {
        document.getElementById("einkauf-liste").innerHTML = einkauf;
        document.getElementById("einkauf-archiv-button").classList.add("bg-blue-800");
        savedPOST();
      });

    }

    function getOrderList(input) {
      if(input == "") {
        input = "null";
      }
        $.get("{{url("/")}}/crm/get-orders-like-"+input, function(data) {
            let parent = document.getElementById('order-list');
            document.getElementById('order-list').innerHTML = '';
            data.forEach(order => {
                let button = document.createElement('button');
                button.setAttribute('onclick', 'setOrder("'+order["process_id"]+'")');
                button.setAttribute('class', 'w-full text-left hover:bg-gray-200 px-2 py-1');
                button.setAttribute('type', 'button');
                button.innerHTML = order["process_id"] + ", " + order["firstname"] + " " + order["lastname"];
                parent.appendChild(button);


            });
        })
    }

    function setOrder(id) {
      document.getElementById("order-list").classList.add("hidden");
      document.getElementById('einkauf-process_id').value = id;
      checkAuftragsnummer(document.getElementById('einkauf-process_id').value)
    }

    function changeType(type) {
      document.getElementById('einkauf-button').classList.remove('border-blue-500', 'text-blue-600');
      document.getElementById('einkauf-button').classList.add('border-transparent', 'text-gray-500');
      document.getElementById('retoure-button').classList.remove('border-blue-500', 'text-blue-600');
      document.getElementById('retoure-button').classList.add('border-transparent', 'text-gray-500');

      document.getElementById(type+'-button').classList.add('border-blue-500', 'text-blue-600');
      document.getElementById(type+'-button').classList.remove('border-transparent', 'text-gray-500');

      document.getElementById('einkauf-type').value = type;
    }
</script>
<script>
  function getContact(id) {
      $.get("{{url("/")}}/versand-versenden/get-contact/"+id, function(data) {
          document.getElementById("comment").value = data["firstname"] + " " + data["lastname"] + ", " + data["street"] + " " + data["streetno"] + ", " + data["zipcode"] + ", " + data["city"];
      })
  }
</script>

</body>
</html>