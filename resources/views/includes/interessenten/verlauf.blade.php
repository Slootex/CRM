<div class="mt-4 pl-1">
    <div class="overflow-hidden rounded-lg bg-white">
      <div id="status-div" class="hidden">
        <div >
          <div id="statusess">
            @include('includes.orders.statuses')
          </div>
        </div>
      </div>

    
    <div id="telefon-div" class="hidden mt-4">
      @include('includes.orders.auftragsverlauf')
    </div>

    <div id="dokumente-div" class="hidden mt-4">
      @include('includes.interessenten.dokumente')
    </div>

    <div id="auftragstext-div">
      @include('includes.orders.historienverlauf')
    </div>
    