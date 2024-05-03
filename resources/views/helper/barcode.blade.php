
<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
</head>
<body onload="test()" style="height: 1vw" class="w-96">
    <script>
        function test() {
            var element = document.getElementById("barcode");
            JsBarcode(element, "{{$barcode}}", {
                height: 43,
                fontSize: 13,
                width: 1,
                textMargin: -2,
                marginTop: -8

            });
        }
   </script>
   <svg id="barcode" class="w-96"></svg>
</body>
</html>
