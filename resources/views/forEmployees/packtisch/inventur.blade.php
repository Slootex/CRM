<!DOCTYPE html>
<html lang="en" class="bg-gray-50 h-full">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.top-menu', ["menu" => "packtisch"])
    
    <div class="overflow-hidden rounded-lg bg-white shadow-xl h-96 m-auto mt-16" style="width: 90rem">
        <div class="px-4 py-5 sm:p-6">

            <div class="float-left w-60 bg-blue-200 rounded overflow-auto" style="height: 21rem" id="table">
                
            </div>

            <div class="mt-5">
                <div class="mt-1">
                  <input type="text" name="email" id="barcode" onkeydown="addBarcode(event)"  style="margin-left: 31.5rem" class="block w-96 h-12 bg-green-200 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Barcode | | | | |">
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="float-left ml-36 mt-4 mr-2 text-xl">Barcode: </p>
                <div id="code">

                </div>
                <br>
                <br>
                <p class="float-left ml-36 mt-4 mr-2 text-xl">Lagerplatz: </p>
                <div id="lagerplatz" >

                </div>
            </div>
            <div class="float-right w-60 bg-blue-200 rounded overflow-auto" style="height: 21rem; margin-top: -8.5rem" id="shelfes">
                @foreach ($shelfes as $shelfe)
                    <p class="mt-4 ml-2" id="shelfe-{{$shelfe->shelfe_id}}">{{$shelfe->shelfe_id}}</p>
                   
                @endforeach
            </div>
            <form action="{{url("/")}}/crm/finish/inventur" method="POST" id="form">
                @CSRF
            <div id="inputs">

            </div>
            <button type="submit" class="mt-36 ml-4 w-96 text-center inline-flex items-center rounded-md border border-transparent bg-blue-600 hover:bg-blue-500 px-3 py-2 text-l font-medium leading-4 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><span class="text-center" style="margin-left: 6.3rem">Inventur Abschließen</span></button>
        </form>

        </div>
      </div>
      <script>
       
        var codes;
        var barcodestate;
        var shelfecode;
        var shelfe;

        function containsOnlyNumbers(str) {
            return /^[0-9]+$/.test(str);
        }

        function addBarcode(e) {
            if(e.keyCode == 13) {
                code = document.getElementById("barcode").value;
            if(code.length <= 5) {
                    if(shelfecode != true) {
                        
                        if(code.includes("A") || code.includes("B")) {
                            var barcode  = document.getElementById("lagerplatz").value;

                            var text    = document.createElement("p");
                            text.innerHTML = code;
                            text.className = "mt-4 ml-2 float-left"
                            text.setAttribute("id", "pp-shelfe-" + code);
                            document.getElementById("lagerplatz").appendChild(text);   

                            document.getElementById("barcode").value = "";
                            shelfecode = true;
                            shelfe = code;
                        }   else {
                            
                    }
                    if(barcodestate != true) {
                        if(code.length == 4) {
                            if(containsOnlyNumbers(code)) {
                                var barcode  = document.getElementById("code").value;

                                var text    = document.createElement("p");
                                text.innerHTML = code;
                                text.className = "mt-4 ml-2 float-left"
                                text.setAttribute("id", "pp-barcode-" + code);
                                document.getElementById("code").appendChild(text);   
                                                            
                                document.getElementById("barcode").value = "";
                                barcodestate = true;
                                codes = code;
                                
                            }
                            else {
                        alert("ERROR BARCODE NICHT ERKANNT");
                    document.getElementById("barcode").value = "";
                    }
                        }
                        
                        
                    } else {
                        if(code.length == 4) {
                            if(containsOnlyNumbers(code)) {
                                var barcode  = document.getElementById("code").value;

                                var text    = document.createElement("p");
                                text.innerHTML = code;
                                text.className = "mt-4 ml-2 float-left"
                                text.setAttribute("id", "pp-barcode-" + code);
                                document.getElementById("code").appendChild(text);   
                                                            
                                document.getElementById("barcode").value = "";
                                barcodestate = true;
                                codes = code;
                            } else {
                                
                            }
                        }
                    }
                    } else {
                        if(barcodestate != true) {
                        if(code.length == 4) {
                            if(containsOnlyNumbers(code)) {
                                var barcode  = document.getElementById("code").value;

                                var text    = document.createElement("p");
                                text.innerHTML = code;
                                text.className = "mt-4 ml-2 float-left"
                                text.setAttribute("id", "pp-barcode-" + code);
                                document.getElementById("code").appendChild(text);   
                                                            
                                document.getElementById("barcode").value = "";
                                barcodestate = true;
                                codes = code;
                            } else {
                                
                            }
                        }
                        
                    } else {
                        alert("ERROR BARCODE NICHT ERKANNT");
                    document.getElementById("barcode").value = "";
                    }
                    }
                    
                    
            
            } 
            if(code.length >= 6) {
                if(code.includes("ORG") || code.includes("AT")) {
                    var barcode  = document.getElementById("code").value;

                    var text    = document.createElement("p");
                    text.innerHTML = code;
                    text.className = "mt-4 ml-2 float-left"
                    text.setAttribute("id", "pp-barcode-" + code);
                    document.getElementById("code").appendChild(text);   

                    document.getElementById("barcode").value = "";
                    barcodestate = true;
                    codes = code;
                } else {
                    alert("ERROR BARCODE NICHT ERKANNT");
                    document.getElementById("barcode").value = "";

                }
            }
            console.log(barcode);
            console.log(shelfecode);
            if(barcodestate == true && shelfecode == true) {
                console.log(codes);
                barcodestate = false;
                shelfecode = false;
                document.getElementById("pp-barcode-" + codes).remove();
                document.getElementById("pp-shelfe-" + shelfe).remove();
                document.getElementById("shelfe-" + shelfe).remove();

                var input   = document.createElement("input");
                input.type  = "text";
                input.className = "hidden";
                input.setAttribute("name", "barcode:" + codes);
                input.setAttribute("value", codes + ":" + shelfe);
                input.setAttribute("id", "barcode-" + codes);

                document.getElementById("inputs").appendChild(input);

                var text    = document.createElement("p");
                text.innerHTML = codes+ ", " + shelfe;
                text.className = "mt-5 float-left"
                text.setAttribute("id", "p-barcode-" + codes);
                document.getElementById("table").appendChild(text);   


                var button = document.createElement("button");
                button.innerHTML = "-";
                button.className = "mt-5 ml-2 inline-flex items-center rounded-md border border-transparent bg-red-100 px-2 py-1 text-sm font-medium leading-4 text-black shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2";
                button.setAttribute("id", "b-barcode-" + codes);
                button.setAttribute("onclick", "removeShelfe('"+ codes +"')");
                document.getElementById("table").appendChild(button);   

                var br      = document.createElement("br");
                br.setAttribute("id", "br-barcode-" + codes);

                document.getElementById("table").appendChild(br);   

                document.getElementById("barcode").value = "";
            }
        }
        }
        function removeShelfe(shelfe) {

            var text    = document.createElement("p");
                text.innerHTML = shelfe;
                text.className = "mt-4 ml-2"
                text.setAttribute("id", "shelfe" + codes);
                document.getElementById("shelfes").insertBefore(text, document.getElementById("shelfes").firstChild);   

            document.getElementById("b-barcode-" + shelfe).remove();
            document.getElementById("br-barcode-" + shelfe).remove();
            document.getElementById("barcode-" + shelfe).remove();
            document.getElementById("p-barcode-" + shelfe).remove();


        }
      </script>

</body>
</html>