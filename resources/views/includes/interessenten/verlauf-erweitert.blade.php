<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-50 w-screen">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div style="" class="text-xl relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6">
            @isset($tracking)

                <div class="flex">
                    <p class="w-48 font-medium">Erstellt</p>
                    <p class="ml-10">{{$verlauf->created_at->format("d.m.Y (H:i)")}}</p>
                </div>

                <div class="flex mt-2">
                    <p class="w-48 font-medium">Mitarbeiter</p>
                    <p class="ml-10">{{$employees->where("id", $verlauf->employee)->first()->name}}</p>
                </div>

                <div class="flex mt-2">
                    <p class="w-48 font-medium">Status</p>
                    <p class="ml-10">{{$verlauf->status}}</p>
                </div>

                @if ($verlauf->status == "E-Mail")
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Empfänger</p>
                    <p class="ml-10">{{$verlauf->email_empf}}</p>
                </div>
                @endif

                <div class="flex mt-2">
                    <p class="w-48 font-medium">Info</p>
                </div>

                <div class="mt-8">
                    <p class="font-semibold">Sendungsverlauf</p>
        
                    <ul role="list" class="space-y-6 mt-2 overflow-auto h-96 w-full">
                        <li class="relative flex gap-x-4">
                            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                              <div class="w-px bg-gray-200"></div>
                            </div>
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                              <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                            </div>
                            <p class=" py-0.5 text-sm leading-5 font-semibold float-left">Sendungsnummer</p>
                            <div class="px-2 float-left py-0.5 text-sm rounded-xl text-center font-medium border border-gray-400">
                                  <p class="rounded-full bg-blue-500 w-2 h-2 inline-block"></p>
                                  <p class="ml-2 inline-block font-medium " id="sendungsverlauf-sendungsnummer">{{$tracking[0]->trackingnumber}}</p>
                            </div>
                            <time datetime="2023-01-23T10:32" class="flex-none py-0.5 text-sm leading-5 text-gray-500" id="tracking-created_at"></time>
                          </li>
                        @foreach ($tracking as $t)
                        <li class="relative  gap-x-4">
                            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                              <div class="w-px bg-gray-200"></div>
                            </div>
                            <div class="relative flex h-2 w-6 flex-none items-center justify-center bg-white">
                              <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                            </div>
                            <p class=" py-0.5 text-sm leading-5 font-semibold float-left ml-10" style="margin-top: -1.1rem">{{$t->status}}</p>
                            @php
                                $date = new DateTime($t->event_date);
                                $date = $date->format("d.m.Y (H:i)");
                            @endphp
                            <time datetime="2023-01-23T10:32" class="flex-none py-0.5 text-sm leading-5 text-gray-500 text-right float-right mr-8" id="tracking-created_at">{{$date}}</time>
                          </li>
                        @endforeach
                        
                        
                      </ul>
                      
                   
                  </div>
                  <button onclick="document.getElementById('verlauf-erweitert').innerHTML = ''" type="button" class="float-right mt-4 px-4 py-2 rounded-md border border-gray-600 font-medium text-md">
                    Zurück
                </button>
                @else

                <div class="flex">
                    <p class="w-48 font-medium">Erstellt</p>
                    <p class="ml-10">{{$verlauf->created_at->format("d.m.Y (H:i)")}}</p>
                </div>
    
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Mitarbeiter</p>
                    <p class="ml-10">{{$employees->where("id", $verlauf->employee)->first()->name}}</p>
                </div>
    
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Status</p>
                    <p class="ml-10">{{$verlauf->status}}</p>
                </div>
    
                @if ($verlauf->status == 38)
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Empfänger</p>
                    <p class="ml-10">{{$verlauf->empfänger}}</p>
                </div>
                @endif

                @if ($verlauf->status == 38)
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Betreff</p>
                    <p class="ml-10">{{$verlauf->betreff}}</p>
                </div>
                @endif

                
                @if ($verlauf->status == 4196 || $verlauf->status == 3736)
                    @isset($device)
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Gerät</p>
                        <p class="ml-10">{{$verlauf->device}}</p>
                    </div>
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Lagerplatz</p>
                        <p class="ml-10">{{$verlauf->shelfe}}</p>
                    </div>
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Öffnungsspuren?</p>
                        <p class="ml-10">@if($device->opened == "off") Nein @else Ja @endif</p>
                    </div>
                    @endisset
                @endif

                @if ($verlauf->status == 4196 || $verlauf->status == 3736)
                    @isset($device)
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Fremde Kleber?</p>
                        <p class="ml-10">@if($device->sticker == "off") Nein @else Ja @endif</p>
                    </div>
                    @endisset
                @endif

                @if ($verlauf->status == 4196 || $verlauf->status == 3736)
                    @isset($device)
                    @if ($files->where("filename", $device->component_number . "-a.pdf")->first() != null)
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Auftragsdokumente</p>
                        <p class="ml-10">Ja</p>
                        <a target="_blank" href="{{url("/")}}/files/aufträge/{{$verlauf->process_id}}/{{$device->component_number}}-a.pdf" class="mt-1 ml-4 text-blue-600 hover:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                          </svg>
                          </a>
                    </div>

                    @else

                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Auftragsdokumente</p>
                        <p class="ml-10">Nein</p>
                    </div>
                    @endif
                    @endisset
                @endif

                @if ($verlauf->status == 4196 || $verlauf->status == 3736)
                @isset($device)
                @if ($files->where("filename", $device->component_number . "-g.pdf")->first() != null)
                <div class="flex mt-2">
                    <p class="w-48 font-medium">Gerätedokumente</p>
                    <p class="ml-10">Ja</p>
                    <a target="_blank" href="{{url("/")}}/files/aufträge/{{$verlauf->process_id}}/{{$device->component_number}}-g.pdf" class="mt-1 ml-4 text-blue-600 hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                      </svg>
                      </a>
                </div>

                @else

                <div class="flex mt-2">
                    <p class="w-48 font-medium">Gerätedokumente</p>
                    <p class="ml-10">Nein</p>
                </div>
                @endif
                @endisset
            @endif

    
                

                <!--- EMAIL --->
                @if ($verlauf->status == 38)
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Body</p>
                    </div>
                    <div class="mt-1 border border-gray-300 rounded-md w-full px-4 py-2 max-h-96 overflow-auto">
                        @php
                            echo $verlauf->email;
                        @endphp
                    </div>

                    <div>
                        <p class="mt-4 font-semibold">Anhang</p>
                        <div class="mt-1 border border-gray-300 rounded-md hover:border-blue-400 hover:text-blue-400 float-left px-4 py-2 overflow-auto">
                            <a target="_blank" href="{{url("/")}}/files/aufträge/{{$verlauf->process_id}}/{{$verlauf->file}}">{{$verlauf->file}}</a>
                        </div>
                    </div>
                @else
                    <div class="flex mt-2">
                        <p class="w-48 font-medium">Info</p>
                    </div>
                    <textarea name="" id="verlauf-erweitert-text" disabled class="mt-1 border border-gray-300 rounded-md w-full">{{$verlauf->message}}</textarea>
                @endif
                <button onclick="document.getElementById('verlauf-erweitert').innerHTML = ''" type="button" class="float-right mt-4 px-4 py-2 rounded-md border border-gray-600 font-medium text-md">
                    Zurück
                </button>
            @endisset
        </div>
      </div>
    </div>
  </div>