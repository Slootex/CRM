
      @foreach ($workflows as $workflow)
      <script>
        $('#edit-workflow-form-{{$workflow->id}}').ajaxForm(function(data) {
          $("#workflow-ablauf").html(data);
          savedPOST();
        });
      </script>
      <li>
        <div class="relative pb-8">
          <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-blue-600" aria-hidden="true"></span>
          <div class="relative flex space-x-3">
            <div>
              <span class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                  </svg>
                  
              </span>
            </div>
            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
              <div>
                <p class="text-sm text-gray-500">{{$workflow->aktion}}</p>
                <p>
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
                </p>
              </div>
              
              <div class="whitespace-nowrap text-right text-sm text-gray-500 flex">
                <p onclick="document.getElementById('edit-workflow-aktion-select-{{$workflow->id}}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-400 cursor-pointer">ändern</p>

                <div id="edit-workflow-aktion-select-{{$workflow->id}}" class="hidden absolute right-0 z-10 mt-6 mt-2 px-2 py-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                  <form action="{{url("/")}}/crm/workflow/edit-workflow-{{$workflow->id}}" method="POST" id="edit-workflow-form-{{$workflow->id}}">
                    @CSRF
                  <div class="py-1 mt-16" role="none">
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
                
                <svg onclick="deleteWorkflowPoint('{{$workflow->id}}')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 hover:text-red-400 cursor-pointer ml-1">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                  </svg>                                  
              </div>
            </div>
          </div>
        </div>
      </li>
      @endforeach
      
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

      
