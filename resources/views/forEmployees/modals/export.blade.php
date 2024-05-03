<!-- FILEPATH: /c:/xampp/htdocs/crm/resources/views/forEmployees/modals/export.blade.php -->

<!-- Modal backdrop -->

<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Auftragsdaten export</h2>
                    <div class="ml-3">
                        <button type="button" onclick="document.getElementById('export-data-modal').classList.add('hidden')" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Close</span>
                            <!-- Heroicon name: x -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                
                
                <div class=" mt-4 ">
                    <div onclick="addExportPoint('kundendaten')" id="kundendaten" class="flex cursor-pointer hover:text-blue-400">
                        <button type="button" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                            <span class="sr-only">Use setting</span>
                            <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                            <span aria-hidden="true" id="kundendaten-t" class="bg-gray-200 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                            <span aria-hidden="true" id="kundendaten-b" class="translate-x-0 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                          </button>                      
                        <span class="ml-2">Kundendaten</span>
                    </div>
                    <div class="mt-2">
                        <div class="ml-8">
                            <div id="geräte" onclick="addExportPoint('geräte')" class="cursor-pointer hover:text-blue-400 flex" id="device-export">
                                <button type="button" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                    <span aria-hidden="true" id="geräte-t" class="bg-gray-200 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span aria-hidden="true" id="geräte-b" class="translate-x-0 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                  </button>
                                  
                                <span class="ml-2">Geräte</span>
                            </div>
                            <div id="historien" onclick="addExportPoint('historien')" class="flex cursor-pointer hover:text-blue-400 mt-1" id="history-export">
                                <button type="button" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                    <span aria-hidden="true" id="historien-t" class="bg-gray-200 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span aria-hidden="true" id="historien-b" class="translate-x-0 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                  </button>
                                <span class="ml-2">Historien</span>
                            </div>
                            <div id="rechnungen" onclick="addExportPoint('rechnungen')" class="flex cursor-pointer hover:text-blue-400 mt-1" id="bill-export">
                                <button type="button" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                    <span aria-hidden="true" id="rechnungen-t" class="bg-gray-200 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span aria-hidden="true" id="rechnungen-b" class="translate-x-0 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                  </button>
                                <span class="ml-2">Rechnungen</span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="geräte" id="geräte-input">
                    <input type="hidden" name="historien" id="historien-input">
                    <input type="hidden" name="rechnungen-addon" id="rechnungen-input">
                    <input type="hidden" name="rechnungen-pdf" id="rechnungenpdf-input">
                    <input type="hidden" name="kundendaten" id="kundendaten-input">

                    <div id="rechnungenpdf" onclick="addExportPoint('rechnungenpdf')" class="flex mt-4 cursor-pointer hover:text-blue-400" id="bill-export">
                        <button type="button" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false">
                            <span class="sr-only">Use setting</span>
                            <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                            <span aria-hidden="true" id="rechnungenpdf-t" class="bg-gray-200 pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out"></span>
                            <span aria-hidden="true" id="rechnungenpdf-b" class="translate-x-0 pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                          </button>
                        <span class="ml-2">Rechnungen als PDF</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-3 py-3">
                <!-- Modal buttons -->
                <div class="mb-4 w-full h-5">
                    <button type="button" onclick="exportOrderData()" class="float-left w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Exportieren
                    </button>
                    <button onclick="document.getElementById('export-data-modal').classList.add('hidden')" type="button" class="mr-2 float-right mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Zurück
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function addExportPoint(id) {
        const data = document.getElementById(id);
        if(data.classList.contains('text-blue-600')) {
            data.classList.remove('text-blue-600');
            document.getElementById(id + '-input').value = "";
            document.getElementById(id+"-t").classList.add("bg-gray-200");
            document.getElementById(id+"-t").classList.remove("bg-blue-600");
            document.getElementById(id+"-b").classList.remove("translate-x-5");
            document.getElementById(id+"-b").classList.add("translate-x-0");

        } else {
            data.classList.add('text-blue-600');
            document.getElementById(id+"-t").classList.remove("bg-gray-200");
            document.getElementById(id+"-t").classList.add("bg-blue-600");
            document.getElementById(id+"-b").classList.add("translate-x-5");
            document.getElementById(id+"-b").classList.remove("translate-x-0");
            document.getElementById(id + '-input').value = "true";
            if(id != "rechnungenpdf" && id != "kundendaten") {
                if(!document.getElementById('kundendaten').classList.contains('text-blue-600')) {
                    addExportPoint('kundendaten');
                }
            }
        }

        
    }



    const dataExport = document.getElementById('data-export');
    const billExport = document.getElementById('bill-export');

    dataExport.addEventListener('click', () => {
        dataExport.classList.toggle('text-blue-600');
        if(document.getElementById('data-input').value = "true") {
            document.getElementById('data-input').value = "";
        } else {
            document.getElementById('data-input').value = "true";
        }
    });

    billExport.addEventListener('click', () => {
        billExport.classList.toggle('text-blue-600');
        if(document.getElementById('rechnung-input').value = "true") {
            document.getElementById('rechnung-input').value = "";
        } else {
            document.getElementById('rechnung-input').value = "true";
        }
    });
</script>
            
            
