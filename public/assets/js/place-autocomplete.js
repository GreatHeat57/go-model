function initMap(){ 
  
  var e = document.getElementById("countryid");
  var country_code = e.options[e.selectedIndex].value;
  document.getElementById("pac-input").autocomplete = 'city-add';

  if(country_code){
    var options = { componentRestrictions: {country: country_code.toLowerCase() } };
    autocomplete.setOptions(options);
  }

  // else{
  //   var options = { types: ['(cities)'] };
  // }
  
  autocomplete.setFields(['address_components', 'geometry']);

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();

    location_being_changed = false;
    

    if (!place.geometry) {
      
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      // window.alert("No details available for input: '" + place.name + "'");
      // return false;
      document.getElementById("distance_range").style.display = "none";
    }else{
      
      $('#pac-input').removeClass('border-bottom-error');
      $('#is_place_select').val('1');
      document.getElementById("distance_range").style.display = "block";
      document.getElementById("latitude").value = place.geometry.location.lat();
      document.getElementById("longitude").value = place.geometry.location.lng();
    }
    
    // autocomplete.set('geometry.place',null);
    // autocomplete.set('geometry',null);
  });
}


function initMapRegister(){ 
  var e = document.getElementById("countryid");
  var country_code = e.options[e.selectedIndex].value;
  document.getElementById("pac-input").autocomplete = 'city-add';

  if(country_code){
    var options = { componentRestrictions: {country: country_code.toLowerCase() } };
    autocomplete.setOptions(options);
  }
  autocomplete.setFields(['address_components', 'geometry']);
  
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();

    location_being_changed = false;
    
    if (place.geometry) {

      if (document.getElementById("latitude") && document.getElementById("longitude")) {
        document.getElementById("latitude").value = place.geometry.location.lat();
        document.getElementById("longitude").value = place.geometry.location.lng();
      }
      $('#pac-input').removeClass('border-bottom-error');
      $('#is_place_select').val('1');
      if(place.address_components){

        placeToAddress(place);
      }else{
        $('#is_place_select').val('0');
      }
    }
  });
}

function placeToAddress(place){
    place.address_components.forEach(function(c) {
        switch(c.types[0]){
            case 'street_number':
                break;
            case 'route':
                break;
            case 'neighborhood': case 'locality':    // North Hollywood or Los Angeles?
              if (document.getElementById("geo_city")) {
                document.getElementById("geo_city").value = c.long_name;
              }
                break;
            case 'administrative_area_level_1':     //  Note some countries don't have states
              if (document.getElementById("geo_state")) {
                document.getElementById("geo_state").value = c.long_name;
              }
                break;
            case 'postal_code':
                break;
            case 'country':
              if (document.getElementById("geo_country")) {
                document.getElementById("geo_country").value = c.long_name;
              }
                break; 
        }
    });
    return true;
}