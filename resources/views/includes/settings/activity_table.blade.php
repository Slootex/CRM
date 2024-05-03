<table class="min-w-full divide-y divide-gray-300">
    <thead>
      <tr>
        <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">URL</th>
        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">IP</th>
        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">Region</th>
        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900">
          <p class="float-left">Datum</p>
          <svg onclick="document.getElementById('filter-div').classList.remove('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 float-right cursor-pointer hover:text-blue-500">
            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
          </svg>    
          <div id="filter-div" class="hidden absolute w-32 h-32 bg-white drop-shadow-lg rounded-md" style="right: 2rem; top: 11.5rem">

            <form action="{{url("/")}}/crm/aktivitätsmonitor/filter" method="POST">
              @CSRF
              <select name="filter" id="filter" class="w-28 ml-2 mt-4 rounded-md border-gray-400 h-8" style="padding-top: 2px; padding-bottom: 2px">
                <option value="">Alle</option>
                <option value="Unbekannt">Unbekannt</option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->username ?: $user->name}}</option>
                @endforeach
              </select>
              @isset($filter)
              <script>

                    document.getElementById("filter").value = "{{$filter}}";
                  
              </script>
              @endisset
              <button type="submit" class="bg-blue-600 hover:bg-blue-500 rounded-md text-white font-medium text-md px-9 py-1 mt-10 ml-2">
                Filtern
              </button>
            </form>

          </div>                  
        </th>

      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
     @foreach ($activitys as $ac)
        <tr>
            <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">@if($users->where("id", $ac->user)->first()) {{$users->where("id", $ac->user)->first()->username}} @else {{$ac->user}} @endif</td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-900 ">{{$ac->url}}</td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-900 ">{{$ac->ip}}</td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-900 ">{{$ac->region}}</td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-900 ">{{$ac->created_at->format("d.m.Y (H:i)")}}</td>
        </tr>
     @endforeach

      <!-- More people... -->
    </tbody>
  </table>