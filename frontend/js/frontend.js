jQuery(document).ready(function($){
    var map;
    var geocoder;
    var bounds = new google.maps.LatLngBounds();

    var requiredFields = [
        $("#origin"), 
        $("#destination"), 
        $("#pickup-date"),
        $("#vehicle-type"),
        $("#baby-seats")
    ];

    $("#vehicle-type, #baby-seats").on("change", function(){
        count = 0;
        $.map(requiredFields, function(obj){
            if (obj.val()) {
                ++count
            }
            if (count == requiredFields.length) {
                calculateDistance();
            }
        });
    });

    $("#origin, #destination, #pickup-date").on("focusout", function(){
        count = 0;
        $.map(requiredFields, function(obj){
            if (obj.val()) {
                ++count;
            }
            if (count == requiredFields.length) {
                calculateDistance();
            }
        });
    })


    function calculateDistance() {
        var service = new google.maps.DistanceMatrixService

        service.getDistanceMatrix({
            origins: [$("#origin").val()],
            destinations: [$("#destination").val()],
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
                    "pickupDate": $("#pickup-date").val(),
                    "airport": "Melbourne",
                    "airportType": "International",
                    "vehicleType": $("#vehicle-type").val(),
                    "babySeats": $("#baby-seats").val(),
                    "action": "tb_calculate",
                    "_wpnonce": TB_APP_Vars_Frontend.nonce
                };

            $.post(TB_APP_Vars_Frontend.ajaxurl, data, function(res) {
                res = $.parseJSON(res);

                if (!res.error) {
                    $("#quote-result-right").text("$" + res.quote);
                    console.log(response + "\n");
                    console.log("distance: " + response.rows[0].elements[0].distance.text + "\n");
                    console.log("duration: " + response.rows[0].elements[0].duration.text + "\n");
                } else {
                    console.log(res.message);
                }
            });
        }
    }
});