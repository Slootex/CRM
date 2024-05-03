<p class="text-white float-left mr-10">Scannermodus</p>

<form action="{{url("/")}}/crm/set-scannermode" method="POST">
    @CSRF
    <button onload="setMode()" type="submit" id="scannermode-main" class="bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" role="switch" aria-checked="false">

        <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
        <span id="scannermode-1" class="translate-x-0 pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
          <!-- Enabled: "opacity-0 ease-out duration-100", Not Enabled: "opacity-100 ease-in duration-200" -->
          <span id="scannermode-2" class="opacity-100 ease-in duration-200 absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
              <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
          <!-- Enabled: "opacity-100 ease-in duration-200", Not Enabled: "opacity-0 ease-out duration-100" -->
          <span id="scannermode-3" class="opacity-0 ease-out duration-100 absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
            <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
              <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
            </svg>
          </span>
        </span>
      </button> 
      <input type="hidden" id="modeinput" name="mode">
</form>

  <script>
    let scannerState = false;

  
        $.get("{{url("/")}}/crm/get-scannermode", function(data, status){
          if(data == "true") {
            scannerState = true;
            document.getElementById("modeinput").value = "true";
            document.getElementById("scannermode-1").classList.add("translate-x-5");
            document.getElementById("scannermode-1").classList.remove("translate-x-0");

            document.getElementById("scannermode-2").classList.add("opacity-0");
            document.getElementById("scannermode-2").classList.add("duration-100");
            document.getElementById("scannermode-2").classList.add("duration-100");

            document.getElementById("scannermode-2").classList.remove("duration-200");
            document.getElementById("scannermode-2").classList.remove("ease-in");
            document.getElementById("scannermode-2").classList.remove("opacity-100");

            document.getElementById("scannermode-3").classList.add("duration-200");
            document.getElementById("scannermode-3").classList.add("ease-in");
            document.getElementById("scannermode-3").classList.add("opacity-100");

            document.getElementById("scannermode-3").classList.remove("duration-100");
            document.getElementById("scannermode-3").classList.remove("ease-out");
            document.getElementById("scannermode-3").classList.remove("opacity-0");

            document.getElementById("scannermode-main").classList.add("bg-blue-400");
            document.getElementById("scannermode-main").classList.remove("bg-gray-200");
          
          } else {
            scannerState = false;
            document.getElementById("modeinput").value = "false";
            document.getElementById("scannermode-1").classList.remove("translate-x-5");
            document.getElementById("scannermode-1").classList.add("translate-x-0");

            document.getElementById("scannermode-2").classList.remove("opacity-0");
            document.getElementById("scannermode-2").classList.remove("duration-100");
            document.getElementById("scannermode-2").classList.remove("duration-100");

            document.getElementById("scannermode-2").classList.add("duration-200");
            document.getElementById("scannermode-2").classList.add("ease-in");
            document.getElementById("scannermode-2").classList.add("opacity-100");

            document.getElementById("scannermode-3").classList.remove("duration-200");
            document.getElementById("scannermode-3").classList.remove("ease-in");
            document.getElementById("scannermode-3").classList.remove("opacity-100");

            document.getElementById("scannermode-3").classList.add("duration-100");
            document.getElementById("scannermode-3").classList.add("ease-out");
            document.getElementById("scannermode-3").classList.add("opacity-0");

            document.getElementById("scannermode-main").classList.remove("bg-blue-400");
            document.getElementById("scannermode-main").classList.add("bg-gray-200");
          
        }
        });
    

    function changeMode() {
        if(scannerState == false) {
            
            scannerState = true;
            document.getElementById("scannermode-1").classList.add("translate-x-5");
            document.getElementById("scannermode-1").classList.remove("translate-x-0");

            document.getElementById("scannermode-2").classList.add("opacity-0");
            document.getElementById("scannermode-2").classList.add("duration-100");
            document.getElementById("scannermode-2").classList.add("duration-100");

            document.getElementById("scannermode-2").classList.remove("duration-200");
            document.getElementById("scannermode-2").classList.remove("ease-in");
            document.getElementById("scannermode-2").classList.remove("opacity-100");

            document.getElementById("scannermode-3").classList.add("duration-200");
            document.getElementById("scannermode-3").classList.add("ease-in");
            document.getElementById("scannermode-3").classList.add("opacity-100");

            document.getElementById("scannermode-3").classList.remove("duration-100");
            document.getElementById("scannermode-3").classList.remove("ease-out");
            document.getElementById("scannermode-3").classList.remove("opacity-0");

            document.getElementById("scannermode-main").classList.add("bg-blue-400");
            document.getElementById("scannermode-main").classList.remove("bg-gray-200");
          } else {
            $.post( "{{url("/")}}/crm/set-scannermode", { mode: false })
            .done(function( data ) {
              console.log(data)
            });
            scannerState = false;
            document.getElementById("scannermode-1").classList.remove("translate-x-5");
            document.getElementById("scannermode-1").classList.add("translate-x-0");

            document.getElementById("scannermode-2").classList.remove("opacity-0");
            document.getElementById("scannermode-2").classList.remove("duration-100");
            document.getElementById("scannermode-2").classList.remove("duration-100");

            document.getElementById("scannermode-2").classList.add("duration-200");
            document.getElementById("scannermode-2").classList.add("ease-in");
            document.getElementById("scannermode-2").classList.add("opacity-100");

            document.getElementById("scannermode-3").classList.remove("duration-200");
            document.getElementById("scannermode-3").classList.remove("ease-in");
            document.getElementById("scannermode-3").classList.remove("opacity-100");

            document.getElementById("scannermode-3").classList.add("duration-100");
            document.getElementById("scannermode-3").classList.add("ease-out");
            document.getElementById("scannermode-3").classList.add("opacity-0");

            document.getElementById("scannermode-main").classList.remove("bg-blue-400");
            document.getElementById("scannermode-main").classList.add("bg-gray-200");
        }
    }
  </script>