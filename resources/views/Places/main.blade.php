<html>
  <head><title>CRM P+</title>
    <title>Place Details</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg&callback=initMap&libraries=places&v=weekly">
    </script>
    @vite('resources/css/app.css')

  </head>
  <body>
    <div id="map"></div>

    <!-- 
      The `defer` attribute causes the callback to execute after the full HTML
      document has been parsed. For non-blocking uses, avoiding race conditions,
      and consistent behavior across browsers, consider loading using Promises.
      See https://developers.google.com/maps/documentation/javascript/load-maps-js-api
      for more information.
      -->
     
    <script>
        function initMap() {
  const myLatLng = { lat: -25.363, lng: 131.044 };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: myLatLng,
  });

  new google.maps.Marker({
    position: myLatLng,
    map,
    title: "Hello World!",
  });
}

window.initMap = initMap;

initMap();


    
    </script>
  </body>
</html>

