@php
    $firstCheck = false;
@endphp
@if ($workflows->where("checked", true)->count() != 0)
    <script>
      document.getElementById("delete-workflow-button").classList.add("hidden");
    </script>
    @else
    @isset($workflows[0])
    <script>
      document.getElementById("delete-workflow-button").classList.remove("hidden");
    </script>
    @endisset
@endif
@foreach ($workflows as $workflow)

<li>
  <div class="relative pb-8">
    
        @if ($workflow->checked == true)
        @if (str_contains($workflow->checked, "Error"))
        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-red-600" aria-hidden="true"></span>
            <div class="relative flex space-x-3">
                <div>
                    <span class="h-8 w-8 rounded-full bg-red-600 flex items-center justify-center ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                        </svg>
                    </span>
        @else
        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-blue-600" aria-hidden="true"></span>
            <div class="relative flex space-x-3">
                <div>
                    <span class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                        </svg>
                    </span>
        @endif
        @else

        @if ($firstCheck == false)

        @if (str_contains($workflow->checked, "Error"))
        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-red-200" aria-hidden="true"></span>
        <div class="relative flex space-x-3">
            <div>
                <span class="h-8 w-8 rounded-full border border-gray-400 flex items-center justify-center bg-white">
                  
                </span>
        @else
        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
        <div class="relative flex space-x-3">
            <div>
                <div>
                    <span class="h-8 w-8 rounded-full bg-white border border-blue-500 flex items-center justify-center">
                      <div class="w-3 h-3 rounded-full bg-blue-600">
                      </div>
                    </span>
                  </div>
        @endif


        @php
            $firstCheck = true;
        @endphp
        @else

 
          <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
          <div class="relative flex space-x-3">
              <div>
                  <span class="h-8 w-8 rounded-full border border-gray-400 flex items-center justify-center bg-white">
          
                  </span>
                      
        @endif
        @endif
      </div>
      <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
        <div>
          <div class="flex z-10">
            <p class="text-sm text-gray-500">{{$workflow->aktion}}</p>
            <svg onclick="document.getElementById('edit-workflow-{{$workflow->id}}').classList.toggle('hidden')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600 hover:text-blue-400 ml-1 cursor-pointer">
              <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
            </svg>
          </div>
          
          @switch($workflow->aktion)
              @case("Versandauftrag Kunde")
              <div class="absolute bg-white rounded-md px-4 py-2 hidden z-50 drop-shadow-lg border-gray-200 border" id="edit-workflow-{{$workflow->id}}">
                <div class="text-left text-black">
                  <p class="font-bold text-lg">Gerätetyp auswählen</p>
    
                  <div class="flex mb-2 py-2">
                    <div id="org-{{$workflow->id}}" onclick="changeDeviceWorkflow('{{$workflow->id}}', '{{$workflow->process_id}}', 'org')" class="flex border
                      @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "org")
                          border-gray-400
                          @else
                          border-blue-400
                          text-blue-400
                          @endif
                          @else
                          border-gray-400
                        @endisset
                       rounded-md px-2 py-1 hover:border-blue-400 hover:text-blue-400 cursor-pointer">
                      <p class="text-center font-medium">ORG</p>
                      <svg id="org-check-{{$workflow->id}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-1 
                        @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "org")
                            hidden
                          @endif
                          @else
                            hidden
                        @endisset">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>                      
                    </div>
                    <div id="at-{{$workflow->id}}" onclick="changeDeviceWorkflow('{{$workflow->id}}', '{{$workflow->process_id}}', 'at')" class="border 
                      @isset($workflow->workflowAddon->used) 

                      @if ($workflow->workflowAddon->used != "at")
                          border-gray-400
                          @else
                          border-blue-400
                          text-blue-400
                          @endif
                          @else
                          border-gray-400
                        @endisset
                       rounded-md px-2 py-1 ml-4 hover:border-blue-400 hover:text-blue-400 cursor-pointer flex">
                      <p class="text-center font-medium">AT</p>
                      <svg id="at-check-{{$workflow->id}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-1 
                         @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "at")
                            hidden

                          @endif
                          @else
                            hidden
                        @endisset
                        ">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>                      
                    </div>
                  </div>
                </div>
              </div>
                  @break


              @case("Versandauftrag Techniker")


              <div class="absolute bg-white rounded-md px-4 py-2 hidden z-50 drop-shadow-lg border-gray-200 border" id="edit-workflow-{{$workflow->id}}">
                <div class="text-left text-black">

                  <div class="mb-6">
                    <p class="font-bold text-lg">Techniker auswählen</p>
                    
                    <select name="" id="" onchange="changeTechnikerWorkflow('{{$workflow->id}}', '{{$workflow->process_id}}', this.value)" class="rounded-md border-gray-400">
                      <option value="">Bitte auswählen</option>
                      @foreach ($tecs as $tec)
                          <option value="{{$tec->shortcut}}">{{$tec->shortcut}}</option>
                      @endforeach
                    </select>
                  </div>

                  <p class="font-bold text-lg">Gerätetyp auswählen</p>
    
                  <div class="flex mb-2 py-2">
                    <div id="org-{{$workflow->id}}" onclick="changeDeviceWorkflow('{{$workflow->id}}', '{{$workflow->process_id}}', 'org')" class="flex border
                      @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "org")
                          border-gray-400
                          @else
                          border-blue-400
                          text-blue-400
                          @endif
                          @else
                          border-gray-400
                        @endisset
                       rounded-md px-2 py-1 hover:border-blue-400 hover:text-blue-400 cursor-pointer">
                      <p class="text-center font-medium">ORG</p>
                      <svg id="org-check-{{$workflow->id}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-1 
                        @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "org")
                            hidden
                          @endif
                          @else
                            hidden
                        @endisset">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>                      
                    </div>
                    <div id="at-{{$workflow->id}}" onclick="changeDeviceWorkflow('{{$workflow->id}}', '{{$workflow->process_id}}', 'at')" class="border 
                      @isset($workflow->workflowAddon->used) 

                      @if ($workflow->workflowAddon->used != "at")
                          border-gray-400
                          @else
                          border-blue-400
                          text-blue-400
                          @endif
                          @else
                          border-gray-400
                        @endisset
                       rounded-md px-2 py-1 ml-4 hover:border-blue-400 hover:text-blue-400 cursor-pointer flex">
                      <p class="text-center font-medium">AT</p>
                      <svg id="at-check-{{$workflow->id}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-1 
                         @isset($workflow->workflowAddon->used) 
                          @if ($workflow->workflowAddon->used != "at")
                            hidden

                          @endif
                          @else
                            hidden
                        @endisset
                        ">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>                      
                    </div>
                  </div>
                </div>
              </div>
                  @break
              @default
                  
          @endswitch

          <p class="z-10">
              @if (str_contains($workflow->aktion, "Status"))
                  @if ($statuses->where("id", $workflow->addon)->first() != null)
                      {{$statuses->where("id", $workflow->addon)->first()->name}}
                  @endif
              @endif

              @if (str_contains($workflow->aktion, "E-Mail"))
                  @if ($emails->where("id", $workflow->addon)->first() != null)
                      {{$emails->where("id", $workflow->addon)->first()->name}}
                  @endif
              @endif

              @if (str_contains($workflow->aktion, "Rechnung"))
                  {{$workflow->addon}}
              @endif

              @if (str_contains($workflow->aktion, "Packtisch"))
                  {{$workflow->addon}}
              @endif

              @if (str_contains($workflow->aktion, "Verschieben"))
                        {{$workflow->addon}}
              @endif

              @if (str_contains($workflow->checked, "Error"))
                  <span class="text-red-400">{{$workflow->checked}}</span>
              @endif
          </p>

        </div>
        
        <div class="whitespace-nowrap text-right text-sm text-gray-500 flex">

          @if ($workflow->checked != true)
          <p onclick="document.getElementById('edit-workflow-aktion-select-{{$workflow->id}}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-400 cursor-pointer">ändern</p>
          @endif 

          
          <div id="edit-workflow-aktion-select-{{$workflow->id}}" class="hidden absolute right-0 z-10 mt-6 mt-2 px-2 py-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            
            <form action="{{url("/")}}/crm/workflow/order/edit-{{$workflow->id}}" method="POST" id="edit-workflow-form-{{$workflow->id}}">
              @CSRF
            <div class="py-1" role="none">
              <select name="aktion" id="edit-workflow-aktion-{{$workflow->id}}" required onclick="changeAkionTab(this.value)" class="cursor-pointer rounded-md border border-gray-400 h-8 font-medium text-md" style="padding-top: 0px; padding-bottom: 0px;">
                <option value="" class="font-semibold text-md">Aktion</option>
                <option value="Rechnung erstellen">Rechnung erstellen</option>
                <option value="Versandauftrag Techniker">Versandauftrag Techniker</option>
                <option value="Versandauftrag Kunde">Versandauftrag Kunde</option>
                <option value="Packtisch">Packtisch</option>
                <option value="Entsorgung">Entsorgung</option>
                <option value="E-Mail senden">E-Mail senden</option>
                <option value="Status setzen">Status setzen</option>
                <option value="Zuweisung">Zuweisung</option>
                <option value="Verschieben">Verschieben</option>

                <option value="" class="font-semibold text-md">Prüfung</option>
                <option value="Status prüfen">Status prüfen</option>
            </select>
            <button type="submit" onclick="loadData()" class="hover:bg-gray-100 px-2 py-1 rounded-md font-medium text-md border border-gray-400 ml-4">
              Schritt ändern
          </button>
            </div>
            </form>
          </div>
          <script>
            document.getElementById("edit-workflow-aktion-{{$workflow->id}}").value = "{{$workflow->aktion}}";
          </script>
          
          @if ($workflow->checked != true)
          <svg onclick="deleteWorkflowPoint('{{$workflow->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 hover:text-red-400 cursor-pointer ml-1">
              <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>    
            @endif                              
        </div>
        
      </div>
    </div>
  </div>
</li>
<script>
    $('#edit-workflow-form-{{$workflow->id}}').ajaxForm(function(data) {
      $("#workflow-ablauf").html(data);
      savedPOST();
    });
    console.log("awd");
  </script>
@endforeach


<script>


  let lastDeviceWorkflow = "";
  function changeDeviceWorkflow(workflow, id, type) {
    document.getElementById(type + "-" + workflow).classList.add("border-blue-400");
    document.getElementById(type + "-" + workflow).classList.add("text-blue-400");
    document.getElementById(type + "-check-" + workflow).classList.remove("hidden");

    if (lastDeviceWorkflow != "") {
      document.getElementById(lastDeviceWorkflow + "-" + workflow).classList.remove("border-blue-400");
      document.getElementById(lastDeviceWorkflow + "-" + workflow).classList.remove("text-blue-400");
      document.getElementById(lastDeviceWorkflow + "-check-" + workflow).classList.add("hidden");
    }

    $.get("{{url('/')}}/crm/workflow/order/change-device/" + id + "/" + type, function(data) {
    });

    lastDeviceWorkflow = type;
  }

  function changeTechnikerWorkflow(workflow, id, tec) {
    $.get("{{url('/')}}/crm/workflow/order/change-techniker/" + id + "/" + type, function(data) {
    });
  }
</script>

<!--<li>
  <div class="relative pb-8">
    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
    <div class="relative flex space-x-3">
      <div>
        <span class="h-8 w-8 rounded-full bg-white border border-blue-500 flex items-center justify-center">
          <div class="w-3 h-3 rounded-full bg-blue-600">

          </div>
        </span>
      </div>
      <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
        <div>
          <p class="text-sm text-gray-500">Completed phone screening with <a href="#" class="font-medium text-gray-900">Martha Gardner</a></p>
        </div>
        <div class="whitespace-nowrap text-right text-sm text-gray-500">
          <time datetime="2020-09-28">Sep 28</time>
        </div>
      </div>
    </div>
  </div>
</li>
<li>
  <div class="relative pb-8">
    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
    <div class="relative flex space-x-3">
      <div>
        <span class="h-8 w-8 rounded-full bg-white border border-gray-300 flex items-center justify-center ">
          
        </span>
      </div>
      <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
        <div>
          <p class="text-sm text-gray-500">Advanced to interview by <a href="#" class="font-medium text-gray-900">Bethany Blake</a></p>
        </div>
        
      </div>
    </div>
  </div>
</li>-->


