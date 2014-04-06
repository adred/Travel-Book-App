jQuery(document).ready(function($){
    var map;
    var geocoder;
    var bounds = new google.maps.LatLngBounds();

    var origin;
    var destination;

    $('#calculate').on('click', function(e){
        e.preventDefault();
        origin = $('#origin').val();
        destination = $('#destination').val();

        calculateDistance();
    });

    function calculateDistance() {
        var service = new google.maps.DistanceMatrixService

        service.getDistanceMatrix(
        {
            origins: [origin],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, callback);
    }

    function callback(response, status) {
        if (status != google.maps.DistanceMatrixStatus.OK) {
            alert('Error was: ' + status);
        } else {
            var origins = response.originAddresses;
            var destinations = response.destinationAddresses;

            if ($('#distance').length) {
                $('#distance').text(response.rows[0].elements[0].distance.text);
            }
            if ($('#hours').length) {
                $('#hours').text(response.rows[0].elements[0].duration.text);
            }
        }
    }
});