var AutoComplete = function(options) {
    this.input = options.input;
    this.init();
}

AutoComplete.prototype.init = function () {
    var input = document.getElementById(this.input);
    var autocomplete = new google.maps.places.Autocomplete(input);
    var infowindow = new google.maps.InfoWindow();

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();

        var address = '';
        if (place.address_components) {
          address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
          ].join(' ');
        }
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    });
}

jQuery(document).ready(function($){
    new AutoComplete({input: "origin"});
    new AutoComplete({input: "destination"});
});