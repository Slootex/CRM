<div class="relative hidden z-10" id="device-pdf-cont" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div id="device-pdf-head" class=" relative transform overflow-scroll rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 w-3/5 sm:p-6">
          <div class="w-full h-16">
            
              <div class="float-right bg-red-500 hover:bg-red-400 rounded-md p-1 cursor-pointer" onclick="document.getElementById('device-pdf-cont').classList.add('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                  </svg>              
              </div>
          </div>

          <div id="device-pdf-div" class="overflow-scroll">

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    currentImageDevice = "";
    function getCurrentDevImg() {
        document.getElementById("device-pdf-div").innerHTML = "";

        let process_id = currentImageDevice.split("-")[0];

    //Gerätedokumente
        let div = document.createElement("div");
        div.classList.add("px-4", "py-2", "rounded-md", "border", "border-blue-400");

        let p = document.createElement("p");
        p.innerHTML = "Gerätedokumente";
        p.classList.add("text-xl", "font-semibold");
        div.appendChild(p);

        let pdf = document.createElement("iframe");
        pdf.src = "{{url("/")}}/files/aufträge/"+process_id+"/"+currentImageDevice+"-g.pdf";
        pdf.classList.add("w-full", "mt-4");
        pdf.style.height = "50rem";
        div.appendChild(pdf);

        document.getElementById("device-pdf-div").appendChild(div);

    //Auftragsdokumente
        div = document.createElement("div");
        div.classList.add("px-4", "py-2", "rounded-md", "border", "border-blue-400", "mt-6");

        p = document.createElement("p");
        p.innerHTML = "Auftragsdokumente";
        p.classList.add("text-xl", "font-semibold");
        div.appendChild(p);

        pdf = document.createElement("iframe");
        pdf.src = "{{url("/")}}/files/aufträge/"+process_id+"/"+currentImageDevice+"-a.pdf";
        pdf.classList.add("w-full", "mt-4");
        pdf.style.height = "50rem";
        div.appendChild(pdf);

        document.getElementById("device-pdf-div").appendChild(div);



    }


    function getAllDevImgs() {
        loadData();

        document.getElementById("device-pdf-div").innerHTML = "";

        let process_id = currentImageDevice.split("-")[0];

        $.get("{{url("/")}}/crm/packtisch/sildeover/all-files-"+process_id, function(files) {

            files.forEach(file => {
                if(file["manager"] == true) {
                    let div = document.createElement("div");
                    div.classList.add("px-4", "py-2", "rounded-md", "border", "border-blue-400", "mt-6");

                    let p = document.createElement("p");
                    p.innerHTML = file["filename"] + " <span class='text-gray-500 font-normal text-lg'>("+file["type"] + ")</span>";
                    p.classList.add("text-xl", "font-semibold");
                    div.appendChild(p);

                    let pdf = document.createElement("iframe");
                    pdf.src = "{{url("/")}}/files/aufträge/"+process_id+"/"+file["filename"];
                    pdf.classList.add("w-full", "mt-4");
                    pdf.style.height = "50rem";
                    div.appendChild(pdf);

                    document.getElementById("device-pdf-head").appendChild(div);
                }
            });
            savedPOST();
        });

    }
  </script>