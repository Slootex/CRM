
          

          <div id="shelfeparent">
            @php
                $schrankCounter = 1;
                $regalCounter = 1;
                $packCounter = 1;
                $rowCounter = 1;
                $created = false;
            @endphp
            <script>
              let parent = document.getElementById("shelfeparent");
              let schrank;
              let shelfe;
              @foreach($allShelfes as $shelfe)
                @if($created == false)
                  shelfe = document.createElement("div");
                  if("{{$shelfe->shelfe_id}}".includes("19B")) {
                    shelfe.classList.add('mr-1');
                }
                if("{{$shelfe->shelfe_id}}".includes("9B")) {
                    shelfe.classList.add('mr-1');
                }
                  @if($packCounter == 1)
                    shelfe.classList.add("grid", "grid-cols-1", "w-10", "float-left", "mt-2", "text-sm");
                    @php
                      $packCounter = 2;
                    @endphp
                    @else
                      @if($rowCounter == 10)
                        shelfe.classList.add("grid", "grid-cols-1", "w-10",  "float-left", "mt-2", "text-sm");
                        @php
                          $rowCounter = 1;
                        @endphp
                        @else 
                        shelfe.classList.add("grid", "grid-cols-1", "w-10", "float-left", "mr-1", "mt-2", "text-sm");

                        @php
                          $rowCounter++;
                        @endphp
                      @endif
                    @php
                      $packCounter = 1;
                    @endphp
                  @endif
                  shelfe.setAttribute("id", "shelfe-{{$regalCounter}}");
                  parent.appendChild(shelfe);
                  @php
                    $created = true;
                  @endphp
                @endif

                schrank = document.createElement("div");
                schrank.setAttribute("id", "schrank-{{$shelfe->shelfe_id}}");
                schrank.classList.add("w-10", "border", "border-gray-600", "text-center", "text-sm");
                
                schrank.innerHTML = "<a href='{{url("/")}}/crm/lagerplatübersicht/filter/{{$shelfe->shelfe_id}}'>{{ $shelfe->shelfe_id }}</a>";
                document.getElementById("shelfe-{{$regalCounter}}").appendChild(schrank);

                @if($schrankCounter == 11)
                  @php
                    $schrankCounter = 1;
                    $regalCounter++;
                    $created = false;
                  @endphp
                  @else
                  @php
                    $schrankCounter++;
                  @endphp
                @endif

                

              @endforeach

            </script>
          </div>
          
          