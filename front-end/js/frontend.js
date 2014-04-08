jQuery(document).ready(function($){
    var map;
    var geocoder;
    var bounds = new google.maps.LatLngBounds();

    var origin;
    var destination;

    $("#calculate").on("click", function(e){
        e.preventDefault();
        // origin = $("#origin").val();
        // destination = $("#destination").val();
        // pickupDate = $("#pickup-date").val();
        // vehicleType = $("#vehicle-type").val();
        // babySeats = $("#baby-seats").val();

        //calculateDistance();
    });

    origin = 'Vancouver, BC, Canada';
    destination ='Victoria, BC, Canada';
    pickupDate = '04/21/2014';
    vehicleType = 'sedan';
    babySeats = 1;

    calculateDistance();

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
            alert("Error was: " + status);
        } else {
            var distance = response.rows[0].elements[0].distance.text.split(" ")[0];
            var data = {
                    "distance": distance,
                    "pickupDate": pickupDate,
                    "vehicleType": vehicleType,
                    "babySeats": 1,
                    "action": "tb_calculate",
                    "_wpnonce": TB_APP_Vars_Frontend.nonce
                };

            $.post(TB_APP_Vars_Frontend.ajaxurl, data, function(res) {
                //res = $.parseJSON(res);

                console.log(res);

                // if (!res.error) {
                //     console.log(res.quote);
                // } else {
                //     console.log(res.message);
                // }
            });
        }
    }
});