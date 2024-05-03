<div class="w-full">
    <table class="mt-10 m-auto w-full" id="neue-rechnung-table">
      <thead>
        <tr class="">
          <th class="">Pos</th>
          <th class="px-10 text-center">Menge</th>
          <th class="px-10 text-center">ArtNr</th>
          <th class="w-36 text-left">Bezeichnung</th>
          <th id="mwst-row" class="w-36 text-right">MwSt</th>
          <th class=" w-36 text-right">Netto Betrag</th>
          <th id="mwst-price-row" class=" w-36 text-right">MwSt Betrag</th>
          <th class="w-5 text-right"></th>
          <th class="pl-2 w-36 text-right">Brutto Betrag</th>
          <th class="pl-2 w-36 text-right"></th>
        </tr>
      </thead>
      <tbody>
        
        
        <tr class="border border-t-0 border-l-0 border-r-0" style="border:4px solid;border-style: double; border-left: none; border-right: none; border-top-style: solid; border-top: .1rem solid">
          <td class="text-left py-2 font-medium">Gesamt</td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-center py-2 "></td>
          <td class="text-right py-2 " id="neue-rechnung-modal-final-brutto">0,00</td>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    function editPosCalc(id) {
      console.log(id);
      let mwst = document.getElementById(id + "-rechnungspos-mwst-input").value;
      let netto = document.getElementById(id + "-rechnungspos-nettobetrag-input").value;

      document.getElementById(id + "-rechnungspos-bruttobetrag").innerHTML = calculateBrutto(netto, mwst);

    }
    function calculateBrutto(netto, mwst) {
      mwst = mwst.replace("%", "");
      mwst = mwst.replace(",", ".");
      netto = netto.replace(",", ".");

      let brutto = netto * (1 + mwst / 100);
      return brutto.toFixed(2);
    }
  </script>
