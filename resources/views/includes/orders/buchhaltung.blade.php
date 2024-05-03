

    <div class=" mx-auto"> <!--mx-auto-->
        <div class="overflow-hidden bg-white shadow mt-8 sm:rounded-lg m-auto" id="rechnung-bg-width" >
            <div class=" py-5 ">
                <div class="">         
                        <div class="float-right pb-4">

                            <button onclick="loadNeueRechnungModal('{{$kundenkonto->process_id}}')" class="bg-blue-600 hover:bg-blue-500 hover:bg-blue-400 text-white rounded-md px-6 py-1 float-right">
                              <p class="font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  <span id="neue-rechnung-text-type">neue Rechnung</span>                                  
                              </p>
                            </button>
                          </div>
                </div>
               
             <br>
             <br>
                <div id="buchhaltung-table-div" class="mt-2">
                    @include('includes.orders.buchhaltung-table')
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleCreateDropDown() {
            document.getElementById("createDropDown").classList.toggle("hidden");
        }

        function loadNeueZahlungModal(id) {
            document.getElementById('rechnung-neue-zahlung-modal').classList.remove('hidden');
        }

        function loadNeueRechnungModal(id) {
            $.get("{{url("/")}}/crm/buchhaltung/neue-rechnung-"+id, function(data) {
                document.getElementById("neue-rechnung-modal").innerHTML = data;
                document.getElementById('neue-position-temp-id').value = getRandomInt(10000, 99999);
                document.getElementById('neue-rechnung-rechnungsnummer').value = document.getElementById('neue-position-temp-id').value;
            })
        }

        function copyRechnung(id) {
            loadData();
            $.get("{{url("/")}}/crm/buchhaltung/rechnung-kopieren-"+id, function(data) {
                document.getElementById("buchhaltung-table-div").innerHTML = data;
                savedPOST();
            })
        }

        function getRandomInt(min, max) {
          min = Math.ceil(min);
          max = Math.floor(max);
          return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function toggleMWST() {
          loadData();

            const rechnungsnummer = document.getElementById('neue-position-temp-id').value;
            const button = document.getElementById('mwst-toggle-button');
            const color = document.getElementById('mwst-toggle-button-color');
            const translate = document.getElementById('mwst-toggle-button-translate');
            
            if (button.getAttribute('aria-checked') === 'false') {

                $.get("{{url("/")}}/crm/buchhaltung/rechnung/mwst-on/"+rechnungsnummer, function(data) {
                  document.getElementById("neue-rechnung-positions").innerHTML = data;

                  button.setAttribute('aria-checked', 'true');
                  color.classList.remove('bg-gray-200');
                  color.classList.add('bg-blue-600');
                  translate.classList.add('translate-x-5');
                  translate.classList.remove('translate-x-0');
                  document.getElementById("mwst-toggle").value = "true";
                  document.getElementById('neue-rechnung-table-mwst').classList.remove('hidden');
                  document.getElementById('neue-rechnung-table-mwstbetrag').classList.remove('hidden');
                  document.getElementById('neue-positon-mwsttype').value = "true";
                  savedPOST();
                })

            } else {

                $.get("{{url("/")}}/crm/buchhaltung/rechnung/mwst-off/"+rechnungsnummer, function(data) {
                  document.getElementById("neue-rechnung-positions").innerHTML = data;

                  button.setAttribute('aria-checked', 'false');
                  color.classList.remove('bg-blue-600');
                  color.classList.add('bg-gray-200');
                  translate.classList.remove('translate-x-5');
                  translate.classList.add('translate-x-0');
                  document.getElementById("mwst-toggle").value = "false";
                  document.getElementById('neue-rechnung-table-mwst').classList.add('hidden');
                  document.getElementById('neue-rechnung-table-mwstbetrag').classList.add('hidden');
                  document.getElementById('neue-positon-mwsttype').value = "false";
                  savedPOST();
                })
            }
        }
        

        function loadAudioFile(id) {
          $.get("{{url("/")}}/crm/buchhaltung/rechnung/audio/"+id, function(data) {
            document.getElementById("neue-audio-modal").innerHTML = data;
            $('#neue-audio-form').ajaxForm(function(data) { 
              savedPOST(); 
            });
          })
        }

        function getEmailModal(id) {
          $.get("{{url("/")}}/crm/buchhaltung/get-email-"+id, function(data) {
            document.getElementById("email-rechnung-modal").innerHTML = data;
            $('#rechnung-email-form').ajaxForm(function(data) { 
              newAlert("E-Mail gesendet!", "Die E-Mail wurde erfolgreich versendet.");
              document.getElementById('email-rechnung-modal').innerHTML = '';
              savedPOST(); 
            });
            $('#text-new-email').trumbowyg();
          })
        }

        function neueRechnungsposition() {
            document.getElementById('rechnung-neue-position-modal').classList.remove('hidden');
            usedRabatt = false;
            $('#neue-position-form').ajaxForm(function(data) { 
              document.getElementById("neue-rechnung-positions").innerHTML = data; 
              savedPOST(); 
            });
            $('#neue-rechnung-form').ajaxForm(function(data) { 
              document.getElementById("buchhaltung-table-div").innerHTML = data; 
              document.getElementById("neue-rechnung-positions").innerHTML = ""; 
              savedPOST(); 
            });
        }

        let usedRabatt = false;
        function switchPositionsType(type) {
            if(type == 'rechnung') {
              document.getElementById('neue-position-menu-rechnung').classList.add('text-blue-400');
              document.getElementById('neue-position-menu-rechnung').classList.add('border-blue-400');
              document.getElementById('neue-position-menu-rechnung').classList.remove('border-gray-400');
              document.getElementById('neue-position-menu-rechnung').classList.remove('text-gray-400');
              document.getElementById('neue-position-menu-rabatt').classList.remove('text-blue-400');
              document.getElementById('neue-position-menu-rabatt').classList.remove('border-blue-400');
              document.getElementById('neue-position-menu-rabatt').classList.add('border-gray-400');
              document.getElementById('neue-position-menu-rabatt').classList.add('text-gray-400');
              document.getElementById('neue-position-div-menge').classList.remove('hidden');
              document.getElementById('neue-position-div-epreis').classList.remove('hidden');
              document.getElementById('neue-position-div-netto').classList.remove('hidden');
              document.getElementById('neue-position-div-bezeichnung').classList.remove('hidden');
              document.getElementById('neue-position-type').value = 'rechnung';
              document.getElementById('neue-position-header').innerHTML = 'neue Rechnungsposition';
              document.getElementById('neue-position-brutto').setAttribute('readonly', 'readonly');
              document.getElementById('neue-position-artikelnummer').setAttribute('required', 'required');
              document.getElementById('neue-position-bezeichnung').setAttribute('required', 'required');
              document.getElementById('neue-position-menge').setAttribute('required', 'required');
              document.getElementById('neue-position-epreis').setAttribute('required', 'required');
              document.getElementById('neue-position-netto').setAttribute('required', 'required');
              document.getElementById('neue-position-brutto').setAttribute('required', 'required');


              document.getElementById('neue-position-menge').value = "";
              document.getElementById('neue-position-epreis').value = "";
              document.getElementById('neue-position-netto').value = "";
              document.getElementById('neue-position-brutto').value = "";
              document.getElementById('neue-position-bezeichnung').value = "";
              document.getElementById('neue-position-artikelnummer').value = "";
              document.getElementById('neue-position-artikel').value = "";
            } else {

              document.getElementById('neue-position-menge').value = "";
              document.getElementById('neue-position-epreis').value = "";
              document.getElementById('neue-position-netto').value = "";
              document.getElementById('neue-position-brutto').value = "";
              document.getElementById('neue-position-bezeichnung').value = "Rabatt";
              document.getElementById('neue-position-artikelnummer').value = "";
              document.getElementById('neue-position-artikel').value = "";

              document.getElementById('neue-position-artikelnummer').removeAttribute('required');
              document.getElementById('neue-position-bezeichnung').removeAttribute('required');
              document.getElementById('neue-position-menge').removeAttribute('required');
              document.getElementById('neue-position-epreis').removeAttribute('required');
              document.getElementById('neue-position-netto').removeAttribute('required');
              document.getElementById('neue-position-brutto').removeAttribute('required');


              document.getElementById('neue-position-menu-rabatt').classList.add('text-blue-400');
              document.getElementById('neue-position-menu-rabatt').classList.add('border-blue-400');
              document.getElementById('neue-position-menu-rabatt').classList.remove('border-gray-400');
              document.getElementById('neue-position-menu-rabatt').classList.remove('text-gray-400');
              document.getElementById('neue-position-menu-rechnung').classList.remove('text-blue-400');
              document.getElementById('neue-position-menu-rechnung').classList.remove('border-blue-400');
              document.getElementById('neue-position-menu-rechnung').classList.add('border-gray-400');
              document.getElementById('neue-position-menu-rechnung').classList.add('text-gray-400');
              document.getElementById('neue-position-div-menge').classList.add('hidden');
              document.getElementById('neue-position-div-epreis').classList.add('hidden');
              document.getElementById('neue-position-div-netto').classList.add('hidden');
              document.getElementById('neue-position-div-bezeichnung').classList.add('hidden');
              document.getElementById('neue-position-type').value = 'rabatt';
              document.getElementById('neue-position-header').innerHTML = 'neue Rabattposition';
              document.getElementById('neue-position-brutto').removeAttribute('readonly');
            }
        }

        function changeNeueRechnungType(type) {
          if(type == "Gutschrift") {
            document.getElementById("vergleich-neue-rechnung").classList.remove("hidden");
            document.getElementById("zahlungsziel-neue-rechnung").classList.add("hidden");
          } else {
            document.getElementById("vergleich-neue-rechnung").classList.add("hidden");
            document.getElementById("zahlungsziel-neue-rechnung").classList.remove("hidden");
          }
        }

        function deletePosition(id) {
          loadData();
          const mwsttype = document.getElementById("neue-positon-mwsttype").value;
          
          $.get("{{url("/")}}/crm/buchhaltung/position-delete/"+id+"/"+mwsttype, function(data) {
            document.getElementById("neue-rechnung-positions").innerHTML = data;
            savedPOST();
          });
        }

        function deleteRechnung(id) {
          loadData();
          $.get("{{url("/")}}/crm/buchhaltung/rechnung-delete-"+id, function(data) {
            document.getElementById("buchhaltung-table-div").innerHTML = data;
            document.getElementById('delete-rechnung-modal').classList.add('hidden')
            savedPOST();
          });
        }

        function editRechnung(id) {
          $.get("{{url('/')}}/crm/buchhaltung/get-rechnung-"+id, function(data) {
            document.getElementById("edit-rechnung-modal").innerHTML = data;

            usedRabatt = false;
            $('#neue-position-form').ajaxForm(function(data) { 
              document.getElementById("neue-rechnung-positions").innerHTML = data; 
              savedPOST(); 
            });
            $('#edit-rechnung-form').ajaxForm(function(data) { 
              document.getElementById("buchhaltung-table-div").innerHTML = data; 
              document.getElementById('edit-rechnung-modal').innerHTML = '';
              savedPOST(); 
            });

            savedPOST();
          });
        }


        function submitNeuePosition() {
          if(usedRabatt == false && document.getElementById('neue-position-bezeichnung').value == "Rabatt") {
              document.getElementById('new-position-button').click();
              usedRabatt = true;
          } else {
            if(document.getElementById('neue-position-bezeichnung').value == "Rabatt") {
              newErrorAlert("Rabatt existiert!", "Es existiert bereits eine Rabattposition! Sie können nur eine Rabattposition pro Rechnung erstellen.")
              return;
            } else {
              document.getElementById('new-position-button').click();
            }
          }

          setTimeout(function() {
            if(!document.getElementById('neue-position-menge').classList.contains("hidden")) {
              document.getElementById('neue-position-menge').value = "";
              document.getElementById('neue-position-epreis').value = "";
              document.getElementById('neue-position-netto').value = "";
              document.getElementById('neue-position-artikel').value = "";
              document.getElementById('neue-position-bezeichnung').value = "";
            }
            document.getElementById('neue-position-artikelnummer').value = "";
            document.getElementById('neue-position-brutto').value = "";
          }, 1000);
        }

        function getZahlungen(id) {
          $.get("{{url("/")}}/crm/buchhaltung/get-zahlungen-"+id, function(data) {
            document.getElementById("zahlung-rechnung-modal").innerHTML = data;
            
          });
        }

        function neueZahlungModal() {
          document.getElementById("rechnung-neue-zahlung").classList.remove('hidden');
          $('#neue-zahlung-form').ajaxForm(function(data) { 
            document.getElementById("zahlung-rechnung-modal").innerHTML = data;
            $.get("{{url("/")}}/crm/buchhaltung/get-rechnungen-{{$kundenkonto->process_id}}", function(data) {
              document.getElementById("buchhaltung-table-div").innerHTML = data;
            });
            savedPOST();
          });
        }

        function enforceNumberValidation(ele) {
            if ($(ele).data('decimal') != null) {
                // found valid rule for decimal
                var decimal = parseInt($(ele).data('decimal')) || 0;
                var val = $(ele).val();
                if (decimal > 0) {
                    var splitVal = val.split('.');
                    if (splitVal.length == 2 && splitVal[1].length > decimal) {
                        // user entered invalid input
                        $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
                    }
                } else if (decimal == 0) {
                    // do not allow decimal place
                    var splitVal = val.split('.');
                    if (splitVal.length > 1) {
                        // user entered invalid input
                        $(ele).val(splitVal[0]); // always trim everything after '.'
                    }
                }
            }
        }

        function setBezahlt(id) {
          loadData();
          $.get("{{url("/")}}/crm/set-bezahlt-"+id, function(data) {
            document.getElementById("zahlung-rechnung-modal").innerHTML = data;
            $.get("{{url("/")}}/crm/buchhaltung/get-rechnungen-{{$kundenkonto->process_id}}", function(data) {
              document.getElementById("buchhaltung-table-div").innerHTML = data;
              savedPOST();
            });
          });
        }

        function deleteZahlung(id) {
          loadData();
          $.get("{{url("/")}}/crm/delete-zahlung-"+id, function(data) {
            document.getElementById("zahlung-rechnung-modal").innerHTML = data;
            $.get("{{url("/")}}/crm/buchhaltung/get-rechnungen-{{$kundenkonto->process_id}}", function(data) {
              document.getElementById("buchhaltung-table-div").innerHTML = data;
              savedPOST();
            });
          });
        }

        function calculatePrice() {
          let menge   = document.getElementById('neue-position-menge');
          let epreis  = document.getElementById('neue-position-epreis');
          let netto   = document.getElementById('neue-position-netto');
          let brutto  = document.getElementById('neue-position-brutto');
          let mwst    = document.getElementById('system-mwst').value;

          if(menge.value != "" && epreis.value != "") {
            let nettobetrag = parseInt(menge.value)*parseFloat(epreis.value);
            netto.value = parseFloat(nettobetrag).toFixed(2);
          } else {
            netto.value = "";
          }

          if(netto.value != "") {
            let bruttobetrag = parseFloat(netto.value) + ((parseFloat(netto.value)*parseFloat(mwst))/100);
            brutto.value = parseFloat(bruttobetrag).toFixed(2);
          } else {
            brutto.value = "";
          }

        }
    </script>
    
