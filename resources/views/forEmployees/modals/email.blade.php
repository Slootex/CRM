<!DOCTYPE html>
<html lang="en" id="status-view">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite('resources/css/app.css')

</head>
<body>
    <div class="relative z-10 w-full" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on modal state.
      
          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
        <div class="fixed m-auto inset-0 z-10 overflow-y-auto ">
          <div class="flex  min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0" >
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8  sm:w-3/5  sm:p-6" >
              <div>
                <div class="mt-3 text-center sm:mt-5">
                  <div>
                    @if ($mail->status == null)
                    <p>Status: Email</p>
                    @else 
                    <p>Status: {{$mail->status}}</p>
                    @endif

                    @isset($mail->empfänger)
                        <p>Empfänger: {{$mail->empfänger}}</p>
                    @endisset

                    <p class="text-xl">{{$mail->subject}}</p>
                  </div>
                  <div class="mt-2">
                    @php
                    $gender_replace         = str_replace("[gender]", $lead->gender, $mail->body);
                    $firstname_replace      = str_replace("[firstname]", $lead->firstname, $gender_replace);
                    $lastname_replace       = str_replace("[lastname]", $lead->lastname, $firstname_replace);
                    $id_replace             = str_replace("[id]", $lead->process_id, $lastname_replace);
            
                    echo "<p>". $id_replace . "</p>";
                @endphp
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                <button type="button" onclick="test()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">Zurück</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function test() {
          window.location.href = "{{url("/")}}/crm/change/order/{{$lead->process_id}}/status";
        }
      </script>
</body>
</html>