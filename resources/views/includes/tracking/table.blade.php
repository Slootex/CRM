@isset($trackings[0])
<div class="w-full mt-24">
  <div class="w-full">
      <div class="mt-8 flow-root">
        <div class=" overflow-y-scroll  max-h-96">
          <div class="inline-block min-w-full py-2 align-middle ">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr>
                  <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 w-36">Datum</th>
                  <th scope="col" class="px-3 py-1  text-left text-sm font-semibold text-gray-900">Sendungsnummer</th>
                  <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Lieferant</th>
                  <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-full">Status</th>
                  <th scope="col" class="relative py-1 pl-3 pr-4 sm:pr-0">
                      <div class="relative float-right w-96">
                          <label for="name" class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">Suche</label>
                          <input type="text" oninput="searchTrackingnumber(this.value, '{{$trackings[0]->process_id}}')" value="@isset($inp){{$inp}}@endisset" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Sendungsnummer">
                      </div>
                  </th>
                </tr>
              </thead>

              <tbody>
                @php
                    $usedtrackings = array();
                @endphp
                  @foreach ($trackings->sortByDesc("created_at") as $users)
                      @foreach ($users->trackings->sortByDesc("event_date") as $tracking)
                        @if (!in_array($tracking->trackingnumber, $usedtrackings))
                        <tr>
                          @php
                              $date = new DateTime($tracking->event_date);
                          @endphp
                          <td class="w-36"><p class="w-36">{{$date->format("d.m.Y (H:i)")}}</p></td>
                          <td>{{$tracking->trackingnumber}}</td>
                          <td class="text-center">{{$tracking->carrier}}</td>
                          <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                              <div onclick="getTrackingDetails('{{$tracking->trackingnumber}}', '{{$tracking->created_at->format('d.m.Y (H:i)')}}')" style="max-width: 90%" class="hover:bg-blue-100 cursor-pointer px-2 float-left h-6 text-sm rounded-xl text-center border border-gray-400 @isset($tracking->code->color) @else bg-white @endisset flex" style="@isset($tracking->code->color) background-color: {{$tracking->code->color}} @endisset">
                                                   
                                  <p class="pl-2 text-black">
                                      @isset($tracking->code->bezeichnung)
                                          {{$tracking->code->bezeichnung}}
                                      @endisset
                                  </p>
                                  <p class="px-2 text-gray-600 ">•</p>        
                                  <p class=" truncate whitespace-nowrap text-blue-600 text-left">{{$tracking->status}}</p>
                              </div>
                          </td>
  
                      </tr>

                      @php
                          array_push($usedtrackings, $tracking->trackingnumber)
                      @endphp
                        @endif
                      @endforeach
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

@endisset
