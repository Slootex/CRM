
<div class=" pl-1" >
   
       
        <div id="Auftragsbody-Packtisch-div-div" class="hidden mt-8" style="width: 50rem">   
            <div >
                <div class="grid grid-cols-3 " >
                    <p class="mt-1">Packtisch</p>
                    <select id="location" name="location" onchange="changePacktischAuftrag(this.value)" class="mt-2 block rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="">Auftrag auswählen</option>
                        <option value="Abholauftrag">Abholauftrag</option>
                        <option value="Fotoauftrag">Fotoauftrag</option>
                        <option value="Umlagerungsauftrag">Umlagerungsauftrag</option>
                        <option value="Entsorgungsauftrag">Entsorgungsauftrag</option>
                        <option value="Nachforschungsauftrag">Nachforschungsauftrag</option>
                        <option value="Versandauftrag-Kunde">Versandauftrag - Kunde</option>
                        <option value="Versandauftrag-Techniker">Versandauftrag - Techniker</option>
                        <option value="Hinweis">Hinweis</option>
                      </select>
                    <p></p>
                </div>  
            </div>
        </div>

          <div id="status-div" class="hidden mt-8 ">
            <div>
                

                    <div id="statusess">
                        @include('includes.orders.statuses')

                    </div>

             
                  
            </div>
          </div>

        <div id="historie-auftrag-div" class="hidden mt-8 ">
            <div class="pr-1">
                

                    @include('includes.orders.auftragshistorieverlauf')
        
                  </form>
                  
            </div>
          </div>
        <div id="telefon-div" class="hidden mt-8">
            <div >
                

                    @include('includes.orders.auftragsverlauf')
        
                  
            </div>
          </div>

          

          <div id="dokumente-div" class="hidden mt-8">
            @include('includes.interessenten.dokumente')
        </div>

        <div id="Auftragsbody-Packtisch-div" class="px-1">
            @include('includes.packtisch.packtischbody')
            
          </div>



          <div id="tracking" class="px-4 hidden mt-8">
            
            <div id="tracking-table-list">

            </div>
          </div>

          
</div>
<div id="auftragstext-div">
  @include('includes.orders.historienverlauf')
</div>

            