<!DOCTYPE html>
<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/admin_head.php"); ?>
<?php echo $page['style']; ?>
<?php echo $_SESSION["admin"]["style"]; ?>
<?php echo $maindata['style_backend']; ?>
</head>
<body>
<div id="header" class="bg-<?php echo $_SESSION["admin"]["bgcolor_header_footer"]; ?> border-bottom border-<?php echo $_SESSION["admin"]["border_header_footer"]; ?> mb-3">
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<nav class="navbar navbar-expand-lg navbar-<?php echo $_SESSION["admin"]["bgcolor_header_footer"]; ?> p-0">
					<?php if($maindata['logo_url'] != ""){ ?><a href="<?php echo $maindata['logo_url']; ?>"<?php echo $maindata['logo_url'] == "#" ? " onclick=\"toggleFullscreen()\"" : ""; ?>><img src="/uploads/company/<?php echo intval($_SESSION["admin"]["company_id"]); ?>/img/logo_backend.png" alt="Logo" style="width: 32px;margin: 2px" /></a><?php } ?>
					<?php 
						$navigation = new navigation($conn, 2, "interested_interesteds");
						echo $navigation->show();
					?>
					<button type="button" style="padding: 0 4px" class="navbar-toggler bg-<?php echo $_SESSION["admin"]["bgcolor_navbar_burgermenu"]; ?> rounded-0" data-toggle="collapse" data-target="#navbar_1" aria-controls="navbar_1" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="navbar_1" class="navbar-collapse collapse justify-content-end">
						<ul id="menu-1" class="navbar-nav mr-0">
							<li class="nav-item"><span class="nav-link text-<?php echo $_SESSION["admin"]["color_text"]; ?> pr-0">Willkommen, <?php echo $_SESSION["admin"]["company_name"]; ?> - </span></li>
							<li class="nav-item"><a href="/crm/zugangsdaten" title="Zugangsdaten" class="nav-link text-<?php echo $_SESSION["admin"]["color_link"]; ?>"><?php echo $_SESSION["admin"]["name"] ?></a></li>
						</ul>
						<span class="text-<?php echo $_SESSION["admin"]["color_text"]; ?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
						<ul id="menu-1" class="navbar-nav mr-0">
							<?php 
								$navigation = new navigation($conn, 1, "interested_interesteds");
								echo $navigation->show();
							?>
							<li class="nav-item"><a href="<?php echo $maindata['logout_index']; ?>" title="Abmelden" class="nav-link text-<?php echo $_SESSION["admin"]["color_link"]; ?> py-1">Abmelden <sup id="autologout"></sup></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
</div>
<section>
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<?php include("includes/admin_alert.php"); ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
<?php echo $html; ?>
			</div>
		</div>
	</div>
</section>
<?php include("includes/admin_footer.php"); ?>
<?php include("includes/admin_script.php"); ?>
<?php echo getScriptRecallDates($conn); ?>
<?php echo $page['script']; ?>
<?php echo $maindata['script_backend_activate'] == 1 ? $maindata['script_backend'] : ""; ?>
<?php if($show_autocomplete_script == 1){ ?>
<script>
var countryToId = {<?php echo $countryToId; ?>};

var placeSearch, autocomplete_route, autocomplete_differing_route;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
//  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {

	autocomplete_route = new google.maps.places.Autocomplete(document.getElementById('route'), {types: ['geocode']});
	autocomplete_route.setFields(['address_component']);
	autocomplete_route.addListener('place_changed', fillInAddress);

	autocomplete_postal_code = new google.maps.places.Autocomplete(document.getElementById('postal_code'), {types: ['(regions)']});
	autocomplete_postal_code.setFields(['address_component']);
	autocomplete_postal_code.addListener('place_changed', fillInPostalCode);

	autocomplete_locality = new google.maps.places.Autocomplete(document.getElementById('locality'), {types: ['(cities)']});
	autocomplete_locality.setFields(['address_component']);
	autocomplete_locality.addListener('place_changed', fillInLocality);

	autocomplete_differing_route = new google.maps.places.Autocomplete(document.getElementById('differing_route'), {types: ['geocode']});
	autocomplete_differing_route.setFields(['address_component']);
	autocomplete_differing_route.addListener('place_changed', fillInDifferingAddress);

	autocomplete_differing_postal_code = new google.maps.places.Autocomplete(document.getElementById('differing_postal_code'), {types: ['(regions)']});
	autocomplete_differing_postal_code.setFields(['address_component']);
	autocomplete_differing_postal_code.addListener('place_changed', fillInDifferingPostalCode);

	autocomplete_differing_locality = new google.maps.places.Autocomplete(document.getElementById('differing_locality'), {types: ['(cities)']});
	autocomplete_differing_locality.setFields(['address_component']);
	autocomplete_differing_locality.addListener('place_changed', fillInDifferingLocality);

}

function fillInAddress() {

  var place = autocomplete_route.getPlace();

  for (var component in componentForm) {
 	  if(component == "country"){
 		$('#' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }else{
        document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
      }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "country"){
 		$('#' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
		setSelect('#' + addressType);
	  }else{
        document.getElementById(addressType).value = val;
      }
    }
  }
}

function fillInPostalCode() {

  var place = autocomplete_postal_code.getPlace();

  for (var component in componentForm) {
 	  if(component == "postal_code"){
        document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
      }
 	  if(component == "locality"){
        document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
      }
 	  if(component == "country"){
 		$('#' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "postal_code"){
        document.getElementById(addressType).value = val;
      }
 	  if(addressType == "locality"){
        document.getElementById(addressType).value = val;
      }
	  if(addressType == "country"){
 		$('#' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
	  }
    }
  }
}

function fillInLocality() {

  var place = autocomplete_locality.getPlace();

  for (var component in componentForm) {
 	  if(component == "locality"){
        document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
      }
	  if(component == "country"){
 		$('#' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "locality"){
        document.getElementById(addressType).value = val;
      }
	  if(addressType == "country"){
 		$('#' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
	  }
    }
  }
}

function fillInDifferingAddress() {

  var place = autocomplete_differing_route.getPlace();

  for (var component in componentForm) {
 	  if(component == "country"){
 		$('#differing_' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }else{
        document.getElementById('differing_'+component).value = '';
		document.getElementById('differing_'+component).disabled = false;
      }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "country"){
 		$('#differing_' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#differing_' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
		setSelect('#differing_' + addressType);
	  }else{
        document.getElementById('differing_'+addressType).value = val;
      }
    }
  }
}

function fillInDifferingPostalCode() {

  var place = autocomplete_differing_postal_code.getPlace();

  for (var component in componentForm) {
 	  if(component == "postal_code"){
        document.getElementById('differing_'+component).value = '';
		document.getElementById('differing_'+component).disabled = false;
      }
 	  if(component == "locality"){
        document.getElementById('differing_'+component).value = '';
		document.getElementById('differing_'+component).disabled = false;
      }
 	  if(component == "country"){
 		$('#differing_' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "postal_code"){
        document.getElementById('differing_'+addressType).value = val;
      }
 	  if(addressType == "locality"){
        document.getElementById('differing_'+addressType).value = val;
      }
	  if(addressType == "country"){
 		$('#differing_' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#differing_' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
	  }
    }
  }
}

function fillInDifferingLocality() {

  var place = autocomplete_differing_locality.getPlace();

  for (var component in componentForm) {
 	  if(component == "locality"){
        document.getElementById('differing_'+component).value = '';
		document.getElementById('differing_'+component).disabled = false;
      }
	  if(component == "country"){
 		$('#differing_' + component + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
	  }
  }

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
	  if(addressType == "locality"){
        document.getElementById('differing_'+addressType).value = val;
      }
	  if(addressType == "country"){
 		$('#differing_' + addressType + ' option:selected').each(function(){
			$(this).removeAttr('selected');
		});
		$('#differing_' + addressType + ' option[value=\'' + countryToId[val] + '\']').attr('selected', 'selected')
	  }
    }
  }
}

function geolocate(component) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({center: geolocation, radius: position.coords.accuracy});
	  if(component == "route"){
        autocomplete_route.setBounds(circle.getBounds());
	  }
	  if(component == "postal_code"){
        autocomplete_postal_code.setBounds(circle.getBounds());
	  }
	  if(component == "locality"){
        autocomplete_locality.setBounds(circle.getBounds());
	  }
	  if(component == "differing_route"){
        autocomplete_differing_route.setBounds(circle.getBounds());
	  }
	  if(component == "differing_postal_code"){
        autocomplete_differing_postal_code.setBounds(circle.getBounds());
	  }
	  if(component == "differing_locality"){
        autocomplete_differing_locality.setBounds(circle.getBounds());
	  }
   });
  }
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArYMLRm2wBreM1jy2-T6H9iDakjmzKU5M&libraries=places&callback=initAutocomplete"
	async defer></script>
<?php } ?>
</body>
</html>