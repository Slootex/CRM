<div class="overflow-auto" style="height: 40rem">
    <table class="mt-4 w-full" id="main-rechnung-table">
        <thead>
            <th class="border border-l-0 border-r-0 border-t-0 border-gray-600">
                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium pr-4 text-xl w-60">Buchungen</td>
                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-0 text-xl text-center">Offener Betrag</td>
                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-0 text-xl ">Zahlungen</td>
                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-0 pl-20 text-xl w-60">Aktion</td>
                <td class="border border-l-0 border-r-0 border-t-0 border-gray-600 pb-4 font-medium px-8 text-xl w-60 text-right">Mahnung</td>
            </th>
        </thead>
        <tbody>
            
                @isset($kundenkonto->rechnungen)
                @php
                    $usedRechnungsnummern = array();
                @endphp
                    @foreach ($kundenkonto->rechnungen as $rechnung)
                        @if (!in_array($rechnung->rechnungsnummer, $usedRechnungsnummern))
                        @if (str_contains($rechnung->rechnungsnummer, "F") || str_contains($rechnung->rechnungsnummer, "G") || str_contains($rechnung->rechnungsnummer, "A"))
                            
                       
                        <tr class="border border-l-0 border-r-0 border-t-0 border-gray-600" id="{{$rechnung->rechnungsnummer}}-rechnung-row">
                            <td class=""></td>
                            <td class="py-2 flex w-96" id="rechnung-cell2-{{$rechnung->rechnungsnummer}}" >
                                <div class="rounded-lg py-2 px-4 w-96 @if($rechnung->deleted == "deleted") bg-red-50 @else bg-blue-50 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-5 float-left text-white bg-blue-400 rounded-full mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <p class="text-lg mt-4"><span class=" font-light">{{$rechnung->created_at->format("d.m.Y (H:i)")}}</span>
                                    <span class="float-right">
                                        @if(substr($rechnung->rechnungsnummer, 0, 1) == "F") Rechnung @endif
                                        @if(substr($rechnung->rechnungsnummer, 0, 1) == "A") Angebot @endif
                                        @if(substr($rechnung->rechnungsnummer, 0, 1) == "G") Gutschrift @endif

                                    </span></p>                                      
                                <p class="text-lg ml-7 "><span class=" font-medium">Ersteller</span><span class="float-right">{{$employees->where("id", $rechnung->mitarbeiter)->first()->name}}</span></p>                                      
                                <p class="text-lg ml-7 "><span class=" font-medium">BelegNr.</span><span class="float-right">{{$rechnung->rechnungsnummer}}</span></p>                                      
                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Standart")->first() != null)
                                    <p class="text-lg ml-7 "><span class=" font-medium">Versandart</span><span class="float-right">Standart</span></p> 
                                @endif           
                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Express")->first() != null)
                                    <p class="text-lg ml-7 "><span class=" font-medium">Versandart</span><span class="float-right">Express</span></p> 
                                @endif

                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Überweisung")->first() != null)
                                    <p class="text-lg ml-7 "><span class=" font-medium">Zahlungsart</span><span class="float-right" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Überweisung</span></p>                                      
                                @endif   
                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Bar")->first() != null)
                                    <p class="text-lg ml-7 "><span class=" font-medium">Zahlungsart</span><span class="float-right" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Bar</span></p>                                      
                                @endif   
                                @if($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->where("bezeichnung", "Nachnahme")->first() != null)
                                    <p class="text-lg ml-7 "><span class=" font-medium">Zahlungsart</span><span class="float-right" id="{{$rechnung->rechnungsnummer}}-rechnung-zahlart">Nachnahme</span></p>                                      
                                @endif                             
                                <p class="text-lg ml-7 "><span class=" font-medium">Rechnungsbetrag</span><span class="float-right">
                                    @php
                                        $rechnungsbetrag = 0;
                                    @endphp
                                @foreach ($kundenkonto->rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer) as $rechnungskosten)
                                    @php
                                        if($rechnungskosten->mwst == "no") {
                                            $rechnungsbetrag += $rechnungskosten->bruttobetrag;
                                        } else {
                                            $rechnungsbetrag += $rechnungskosten->nettobetrag * 1.19;
                                        }
                                    @endphp
                                @endforeach 
                                {{number_format((float)$rechnungsbetrag, 2, ',', '.')}}€   
                                </span></p>                                      
                                @if ($rechnung->zahlungsziel != null)
                                <p class="text-lg ml-7 "><span class=" font-medium">Zahlungsziel</span><span class="float-right">{{$rechnung->zahlungsziel}} Tage</span></p>                                                          
                                @endif
                                <p class="text-lg ml-7 "><span class=" font-medium">Rechnungstext</span></p>
                                <p class="text-md ml-7 mt-7 text-gray-600 mb-2">@isset($rechnungstexte->where("id", $rechnung->rechnungstext)->first()->title) {{$rechnungstexte->where("id", $rechnung->rechnungstext)->first()->title}} @endisset</p>                                    
                                </div>
                            </td>
                            <td class="text-center top-0" style="vertical-align:top">
                                @php
                                    $zahlungsbetrag = 0.00;
                                @endphp
                                @foreach ($rechnung->zahlungen as $zahlung)
                                    @php
                                        $zahlungsbetrag += str_replace(",", ".", $zahlung->betrag);
                                    @endphp
                                @endforeach

                                @if ($rechnung->bezahlt == "true")

                                <p class="mt-4" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 m-auto text-green-600 mt-0"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg> </p>

                                
                                    @else

                                    @if ($rechnungsbetrag == $zahlungsbetrag)
                                        <p class="mt-4" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 m-auto text-green-600 mt-0"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg> </p>
                                    @endif
                                    @if ($zahlungsbetrag < $rechnungsbetrag)
                                        <p class="mt-4   text-red-600" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag">- {{number_format(floatval($rechnungsbetrag - $zahlungsbetrag), 2, ',', '.');}} € <p>
                                    @endif
                                    @if ($zahlungsbetrag > $rechnungsbetrag)
                                        <p class="mt-4   text-green-600" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetrag">+ {{number_format(floatval($zahlungsbetrag - $rechnungsbetrag), 2, ',', '.');}} €<p>
                                    @endif

                                    
                                @endif

                                
                                  
                                
                                  
                                  <input type="hidden" id="{{$rechnung->rechnungsnummer}}-rechnung-endrechnungsbetrag" value="{{$rechnungsbetrag}}">
                                  <input type="hidden" id="{{$rechnung->rechnungsnummer}}-rechnung-endzahlungsbetraginput" value="{{$zahlungsbetrag}}">


                            </td>
                            <td class="top-0" style="vertical-align:top">
                                <button type="button" onclick="getZahlungen('{{$rechnung->rechnungsnummer}}')" class="mt-4 ml-3 text-white font-medium text-md bg-blue-600 hover:bg-blue-400 rounded-md px-4 py-2">
                                    Konto
                                </button>
                            </td>

                            <td style="vertical-align:top">
                                <button type="button" class="top-0 mt-4">
                                    <div class="bg-black hover:bg-slate-800 rounded-md float-left p-1 mr-1" onclick="loadAudioFile('{{$rechnung->rechnungsnummer}}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                                          </svg>
                                          
                                    </div> 
                                </button>
                                <button type="button" class="top-0 mt-4">
                                    <div class="bg-green-600 hover:bg-green-400 rounded-md float-left p-1 mr-1" onclick="editRechnung('{{$rechnung->rechnungsnummer}}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>  
                                    </div> 
                                </button>
                                <button type="button" onclick="document.getElementById('delete-rechnung-modal').classList.remove('hidden'); document.getElementById('delete-id').value = '{{$rechnung->rechnungsnummer}}';">
                                    <div class="bg-red-600 hover:bg-red-400 rounded-md float-left p-1 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                          </svg>
                                          
                                    </div> 
                                </button> 
                                <a type="button" target="_blank" href="{{url("/")}}/crm/rechnung-pdf/{{$rechnung->rechnungsnummer}}">
                                    <div class="bg-yellow-600 hover:bg-yellow-400 rounded-md float-left p-1 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                          </svg>
                                           
                                    </div>
                                </a>  
                                <button type="button" onclick="getEmailModal('{{$rechnung->rechnungsnummer}}')">
                                    <div class="bg-blue-600 hover:bg-blue-400 rounded-md float-left p-1 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                          </svg>
                                          
                                    </div>  
                                </button> 

                                <button type="button" onclick="copyRechnung('{{$rechnung->rechnungsnummer}}')">
                                    <div class="bg-rose-600 hover:bg-rose-400 rounded-md float-left p-1 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 float-left text-white"">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                          </svg>
                                          
                                          
                                    </div>  
                                </button> 
                                
                                @isset($rechnung->deleted)
                                    <div id="{{$rechnung->rechnungsnummer}}-deleted" class="bg-red-50 h-12 py-2 px-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 float-left top-0 text-red-400">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                          </svg> 
                                        <h1 class="text-red-600 font-semibold text-xs float-left ml-2">Rechnung storniert</h1>
                                        <h1 class="text-red-600 font-semibold text-xs float-left ml-2">• <span id="{{$rechnung->rechnungsnummer}}-deleted-from" class="font-normal ml-1">{{$rechnung->deleted_from}}, am {{$rechnung->deleted_at}}</span></h1>
                                                                                                 
                                    </div>
                                @endisset

                                @if($rechnung->bezahlt == "true")
                                    <div id="{{$rechnung->rechnungsnummer}}-bezahlt" class="bg-blue-50 h-12 mt-2 py-2 px-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-left top-0 text-blue-400">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>   
                                        
                                        <h1 class="text-blue-600 font-semibold text-xs float-left ml-2 ">
                                            Rechnung <span class="underline underline-offset-2">manuell</span> bezahlt gesetzt
                                        </h1>
                                        <h1 class="text-blue-600 font-semibold text-xs float-left ml-2">• <span id="{{$rechnung->rechnungsnummer}}-deleted-from" class="font-normal ml-1">{{$rechnung->bezahlt_from}}, am {{$rechnung->bezahlt_at}}</span></h1>
                                                                                                                                                 
                                    </div>
                                @endif

                                    @isset($rechnung->audiofiles->rechnungsnummer)
                                        @else
                                        <div class="bg-yellow-50 w-60 px-4 py-1 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block text-yellow-400">
                                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                              </svg>
                                              
                                            <p class="text-yellow-600 font-semibold inline-block">Audiodatei fehlt!</p>                                                      
                                        </div>
                                    @endisset


                            </td>
                            
                            <td style="vertical-align:top" class="w-72">
                                <div class="py-2 w-72 float-right px-2 @if($rechnung->mahnungen->isEmpty()) hidden @endif" id="{{$rechnung->rechnungsnummer}}-mahnverlauf">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left text-yellow-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                      </svg>
                                      <div class="ml-8" id="{{$rechnung->rechnungsnummer}}-mahnverlauf-p">
                                        @if ($rechnung->mahnungen->isEmpty())
                                        <p><span id="{{$rechnung->rechnungsnummer}}-mahnverlauf-zahlungserinnerung-date">{{$rechnung->created_at->format("d.m.Y")}}</span> <span class="text-yellow-700 underline" id="{{$rechnung->rechnungsnummer}}-mahnverlauf-zahlungserinnerung"><a href="{{url("/")}}/crm/mahnung/pdf-1/{{$rechnung->rechnungsnummer}}" target="_blank">Zahlungserinnrung</a></span></p>

                                        @endif                                                        
                                        @foreach ($rechnung->mahnungen as $mahnung)
                                            <p><span >{{$mahnung->created_at->format("d.m.Y")}}</span> <span class="text-yellow-700 underline" ><a href="{{url("/")}}/crm/mahnung/pdf-{{$mahnung->mahnstufe}}/{{$rechnung->rechnungsnummer}}" target="_blank">{{$mahneinstellungen->where("mahnstufe", $mahnung->mahnstufe)->first()->bezeichnung}}</a></span></p>
                                        @endforeach
                                      </div>
                                </div>

                                    <div class="bg-red-50 rounded-md py-2 w-60 mr-2 float-right px-2   @if ($rechnung->mahnungen->isEmpty()) hidden @endif @if ($rechnung->mahnungen->where("process_id", "sperre")->first() != null) hidden @endif" id="{{$rechnung->rechnungsnummer}}-mahnstatus">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5  float-left text-red-400">
                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                        </svg>
                                        
                                      @if (!$rechnung->mahnungen->isEmpty())

                                        <div class="ml-8">
                                            <h1 class="text-red-600 font-normal text-xs">Laufendes Mahnverfahren</h1>
                                            <p class=" text-red-500 font-light text-xs">• nächste Mahnstufe</p>

                                            <p class=" text-red-500 font-light ml-2.5 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-status">
                                                {{$mahneinstellungen->where("mahnstufe", $rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->mahnstufe )->first()->bezeichnung}}
                                               am {{$rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->created_at->modify("+ " . $mahneinstellungen->where("mahnstufe", $rechnung->mahnungen->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->count() - 1)->mahnstufe )->first()->zahlungsfrist . "days")->format("d.m.Y")}}</p>
                                        </div>

                                        @else
                                        <div class="ml-8">
                                            <h1 class="text-red-600 font-normal text-xs">Laufendes Mahnverfahren</h1>
                                            <p class=" text-red-500 font-light text-xs">• nächste Mahnstufe</p>

                                            <p class=" text-red-500 font-light ml-3 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-status"></p>
                                            <p class=" text-red-500 font-light ml-3 text-xs" id="{{$rechnung->rechnungsnummer}}-mahnstatus-date"></p>
                                        </div>
                                          
                                      @endif
                                  </div>


                                  @if ($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->first() != null)
                                  @isset($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->created_at)
                                      
                                 
                                    <div class="bg-red-100 w-72 @if ($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->first() == null) hidden @endif px-2" id="{{$rechnung->rechnungsnummer}}-mahnsperre">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  float-left text-red-400">
                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                        </svg>
                                        
                                        <div class="ml-8">
                                            <h1 class="text-red-600 font-normal">Mahnsperre gesetzt</h1>
                                            <p class=" text-red-500 font-light">• <span id="{{$rechnung->rechnungsnummer}}-mahnsperre-datum">{{$rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->created_at->format("d.m.Y")}}</span></p>
                                            <p class=" text-red-500 font-light ml-3" id="{{$rechnung->rechnungsnummer}}-mahnsperre-mitarbeiter">durch {{$employees->where("id", $rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->get($rechnung->mahnungen->where("process_id", "sperre")->where("rechnungsnummer", $rechnung->rechnungsnummer)->count())->employee)->first()->name}}</p>
                                            <p class="text-red-800 font-light text-center underline"><button type="button" class="underline" onclick="stopMahnsperre('{{$rechnung->rechnungsnummer}}')">Mahnsperre aufheben</button></p>
                                        </div>
                                        
                                  </div>
                                  @endisset
                                  @else
                                  <div class="bg-red-100 w-72 hidden  px-2" id="{{$rechnung->rechnungsnummer}}-mahnsperre">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  float-left text-red-400">
                                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                        </svg>
                                        
                                        <div class="ml-8">
                                            <h1 class="text-red-600 font-normal">Mahnsperre gesetzt</h1>
                                            <p class=" text-red-500 font-light">• <span id="{{$rechnung->rechnungsnummer}}-mahnsperre-datum"></span></p>
                                            <p class=" text-red-500 font-light ml-3" id="{{$rechnung->rechnungsnummer}}-mahnsperre-mitarbeiter"></p>
                                            <p class="text-red-800 font-light text-center underline"><button type="button" class="underline" onclick="stopMahnsperre('{{$rechnung->rechnungsnummer}}')">Mahnsperre aufheben</button></p>
                                        </div>
                                        
                                  </div>
                                  @endif


                                <div id="{{$rechnung->rechnungsnummer}}-mahneinstellung-buttons" class="@if($rechnung->mahnungen->isEmpty()) hidden @endif">
                                    <div class="w-96">
                                        @if ($rechnung->mahnungen->where("mahnstufe", "6")->first() != null)
                                            <button type="button" onclick="skipMahnLevel('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">Inkasso übergabe</button>
                                        @else 
                                            <button type="button" onclick="skipMahnLevel('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">nächste Mahnstufe</button>
                                        @endif
                                        <button type="button" onclick="startMahnsperre('{{$rechnung->rechnungsnummer}}')" class="py-1 mt-10 mb-2 px-4 mr-6 bg-blue-600 hover:bg-blue-500 text-white font- rounded-md pt-1 float-right">Mahnsperre</button>
                                    </div>
                                </div>

                                
                                <div id="{{$rechnung->rechnungsnummer}}-mahnlauf-buttons" @if (!$rechnung->mahnungen->isEmpty()) class="hidden" @endif>
                                    <button type="button" onclick="startMahnlauf('{{$rechnung->rechnungsnummer}}')" class="py-1 px-4 mt-4 bg-red-600 text-white font-medium rounded-md pt-1 w-46 float-right">Mahnlauf starten</button>
                                 </div>
                                
                                 
                            </td>
                        </tr>  
                        @endif
                        @php
                            array_push($usedRechnungsnummern, $rechnung->rechnungsnummer);
                        @endphp

                        @endif
                    @endforeach
                @endisset

                @isset($einkäufe)
                    @if ($einkäufe != null)

                    @php
                        $einkaufList = array();
                    @endphp

                        @foreach ($einkäufe as $einkauf)
                            @if (!in_array($einkauf->pos_id, $einkaufList))

                            <tr class="border border-l-0 border-r-0 border-t-0 border-gray-600">
                                <td></td>
                                <td class="py-2 flex w-96">
                                    <div class="rounded-lg py-2 px-4 w-96 bg-yellow-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-5 float-left text-white bg-blue-400 rounded-full mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <p class="text-lg mt-4"><span class=" font-light">{{$einkauf->created_at->format("d.m.Y (H:i)")}}</span><span class="float-right">Einkauf</span></p>                                      
                                    <p class="text-lg ml-7 "><span class=" font-medium">Status</span><span class="float-right">{{$einkauf->status}}</span></p>                                      
                                    <p class="text-lg ml-7 "><span class=" font-medium">URL</span><span class="float-right">{{$einkauf->url}}</span></p> 
                                    <p class="text-lg ml-7 "><span class=" font-medium">Zahlart</span><span class="float-right">{{$einkauf->zahlart}}</span></p> 
                                    <p class="text-lg ml-7 "><span class=" font-medium">Einkaufsbetrag</span><span class="float-right">
                                        
                                        {{number_format((float)$einkauf->price, 2, ',', '.')}} €   
                                    </span></p>                                      
                                    <p class="text-lg ml-7 "><span class=" font-medium">Label</span><span class="float-right">{{$einkauf->tracking}}</span></p>                                                          
                                    
                                
                                    </div>
                                </td>
                                <td class="text-center top-0" style="vertical-align:top">

                                    <p class="mt-4   text-red-600">{{number_format((float)$einkauf->price, 2, ',', '.')}} €<p>
                                        

                                </td>
    
                                <td style="vertical-align:top">
                                    
    
                                </td>
                                
                                <td style="vertical-align:top" class="w-72">
                                    
                                    
                                     
                                </td>
                            </tr>  

                                @php
                                    array_push($einkaufList, $einkauf);
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endisset

        </tbody>
    </table>
</div>