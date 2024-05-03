<h1 class="text-2xl font-medium pb-4 mt-8">Verlauf</h1>

<div class="w-full border border-gray-300  rounded-md">
<div class="w-full">
    <div class="w-full">
        <div class="flow-root">
          <div class=" 6">
            <div class="inline-block min-w-full py-2 align-middle overflow-auto max-h-96">
              <table class="min-w-full divide-y divide-gray-300 ">
                <thead>
                  <tr>
                    <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Datum</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Mitarbeiter</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Datei</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Kommentar</th>
                    <th scope="col" class="relative py-1 pl-3 pr-4">
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  @foreach ($order->files->sortByDesc("created_at") as $file)
                  <tr>
                    <td class="whitespace-nowrap py-1 pl-4 text-sm text-gray-500">{{$file->created_at->format("d.m.Y (H:i)")}}</td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                        @if($employees->where("id", $file->employee)->first() != null)
                            {{$employees->where("id", $file->employee)->first()->name}}
                        @endif
                    </td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                      <div onclick="inspectDokument('{{$file->id}}')" class="px-2 hover:bg-blue-100 cursor-pointer float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                        <p >{{$file->filename}}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                          <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>                            
                      </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                       @if (str_contains($file->filename, ".mp3") || str_contains($file->filename, ".wav") || str_contains($file->filename, ".ogg") || str_contains($file->filename, ".m4a")) 
                       <div class="">
                        <div onclick="inspectDokument('{{$file->id}}')" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2 mt-0.5">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <p class="pl-2">{{$file->type}}</p>
                          <p class="px-2 text-red-600">•</p>        
                          <p style="max-width: 9rem" class=" truncate whitespace-nowrap text-left">{{$file->description}}</p>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>        
                        </div>
                          <audio controls class="h-6 float-right">
                            <source src="{{url("/")}}/files/aufträge/{{$file->process_id}}/{{$file->filename}}?{{uniqid()}}" type="audio/mpeg">
                          </audio>
                       </div>
                        @else
                        <div onclick="inspectDokument('{{$file->id}}')" class="hover:bg-blue-100 cursor-pointer px-2 float-left py-0.5 text-sm rounded-xl text-center border border-gray-400 flex">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                            <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                          </svg> 
                          <p class="pl-2">{{$file->type}}</p>
                          <p class="px-2 text-red-600">•</p>        
                          <p style="max-width: 9rem" class=" truncate whitespace-nowrap text-left">{{$file->description}}</p>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>        
                        </div>   
                       @endif
                    </td>
                    <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium">
                      <svg onclick="inspectDokument('{{$file->id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="float-right w-6 h-6 text-blue-600 hover:text-blue-400 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                      </svg>                          
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