

<div class="relative z-50" id="email-new" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left  transition-all sm:my-8 sm:p-6">
  <div>           
             
              <div >
                  <div class="px-6">
                        <div class="">
                          
                          <button class="float-right" onclick='document.getElementById("custom-email-div-statuse").classList.add("hidden");' type="button">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hover:text-blue-400 ml-1 text-lg font-semibold leading-6 text-gray-500 hover:text-blue-400 mr-3 float-left mt-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          
                        </button>
                        <h1 class="ml-3 font-bold text-2xl">Neue Email</h1>
                        </div>
                    </div>

  
                  <div class="px-6 mt-1">
                    <input type="hidden" name="account" id="account-input-new" value="1">
                      <input type="text" name="cc" id="cc-statuse" placeholder="Empfänger (CC)" class="border-none text-2xl text-gray-600 font-semibold w-full h-12">
                      <input type="text" name="bcc" id="bcc-statuse" placeholder="Bcc" class="border-none text-lg text-gray-400 font-normal w-full h-8 ">
                      <hr class="py-2 mt-4 border-gray-300">
                      <div class="flex">
                        <input type="text" id="subject-new-statuse" name="subject" placeholder="Betreff" class="border-none text-2xl text-gray-600 font-semibold w-full h-12 mb-4">
                      
                     
                      </div>
                      <textarea name="text" id="text-new-email-statuse" cols="30" rows="10" class="w-full rounded-md h-44 overflow-auto border-none" placeholder="Text schreiben..."></textarea>
                      <script>
                           $('#text-new-email-statuse').trumbowyg()
                      </script>
                  </div>
                  <div class="mt-16  px-4">
                      <div class="float-left">
                        <label onclick="document.getElementById('file-email-statuse').click();" class="flex flex-col items-center py-1 bg-white text-blue rounded-lg tracking-wide uppercase  cursor-pointer hover:bg-blue hover:text-white">
                        
                          <span class="mt-0 text-base leading-normal text-gray-400"><span class="float-left text-gray-400" id="filename-email-statuse">
                            </span>  
                            <p class="float-left ml-2">Dateianhang</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                            </svg>                          
                          </span>
                      </label>
                      </div>
                      <button type="button" onclick="addEmailStatuse()" class="px-5 py-1 bg-blue-600 hover:bg-blue-500 text-md font-semibold text-white rounded-md float-right">E-Mail speichern</button>
                    </div>
  
  
            </div>
          </div>
        </div>
      </div>
  
  
              </div>
            </div>
        
  
    <script>
            function addEmailStatuse() {
               if(document.getElementById("subject-new-statuse").value != "") {
                document.getElementById("statuse-email-p").innerHTML = document.getElementById("subject-new-statuse").value;

                document.getElementById("statuse-email-subject").value = document.getElementById("subject-new-statuse").value;
                document.getElementById("statuse-email-bcc").value = document.getElementById("bcc-statuse").value;
                document.getElementById("statuse-email-cc").value = document.getElementById("cc-statuse").value;
                document.getElementById("statuse-email-body").value = $('#text-new-email-statuse').trumbowyg("html");

                document.getElementById("custom-email-div-statuse").classList.add("hidden");
                document.getElementById("statuse-email-remove").classList.remove("hidden");
               } else {
                  newErrorAlert("Betreff fehlt!", "Es muss ein Betreff definiert werden!");
               }
            }
    </script>
  
  
    