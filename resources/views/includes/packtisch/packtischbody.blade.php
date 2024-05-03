
<div id="Versandauftrag-Kunde" class="hidden">
  @include('includes.packtisch.versandauftrag-kunde')
</div>
            
            <div id="Abholauftrag" class="hidden">
                @include('includes.packtisch.abholauftrag')
            </div>

            <div id="Fotoauftrag" class="hidden">
                @include('includes.packtisch.fotoauftrag')
            </div>

            <div id="Umlagerungsauftrag" class="hidden">
                @include('includes.packtisch.umlagerungsauftrag')
            </div>

            <div id="Hinweis" class="hidden">
                @include('includes.packtisch.hinweis')
            </div>

            <div id="Nachforschungsauftrag" class="hidden">
              @include('includes.packtisch.nachforschungsauftrag')
            </div>

            <div id="Entsorgungsauftrag" class="hidden">
              @include('includes.packtisch.entsorgungsauftrag')
            </div>

           

            <div id="Versandauftrag-Techniker" class="hidden">
              @include('includes.packtisch.versandauftrag-techniker')
            </div>

          

            <script>
                function setAbsender() {
                  document.getElementById("absendermodal").classList.add("hidden");
                  document.getElementById("absender").value = document.getElementById("ab_firstname").value + " " + document.getElementById("ab_lastname").value + ", " + document.getElementById("ab_street").value + " " + document.getElementById("ab_street_number").value + ", " + document.getElementById("ab_zipcode").value + ", " + document.getElementById("ab_country").value;
                }
              </script>
             

       