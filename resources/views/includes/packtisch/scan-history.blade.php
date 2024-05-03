<div class="w-96 float-right absolute ml-28  rounded-md bg-white px-4 py-2 hidden overflow-auto" id="scan-error-div" style="max-height: 40rem;">
    <h1 class="text-gray-800 text-3xl font-bold">Scan Historie</h1>

    <div id="scan-error-body">

    </div>

  </div>

  <script>
    function scanNotFound(scan, bereich) {
      document.getElementById("scan-error-div").classList.remove("hidden");
      let div = document.createElement("p");
      div.innerHTML = ('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-red-600 float-left mr-2 mt-0.5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg><p class="text-red-700 font-medium text-xl mt-4" ><span class="text-red-500">"' + scan + '"</span> nicht gefunden</p>');
      
      document.getElementById("scan-error-body").prepend(div);

      newScan(scan, "Nicht gefunden", bereich);

    }

    function scanFound(scan, bereich) {
      document.getElementById("scan-error-div").classList.remove("hidden");
      let div = document.createElement("p");
      div.innerHTML = ('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 float-left text-green-600 mt-0.5 mr-2"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg><p class="text-green-700 font-medium text-xl mt-4" >"'+ scan +'" gefunden</p>');

      document.getElementById("scan-error-body").prepend(div);

      newScan(scan, "Gefunden", bereich);
    }

    function newScan(scan, type, bereich) {
      $.get("{{url("/")}}/crm/scanhistory/new/"+scan+"/"+type+"/"+bereich, function(data) {
        
      });
      
    }
  </script>