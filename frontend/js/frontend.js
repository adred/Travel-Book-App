jQuery(document).ready(function($){
    // Google Maps - Distance Matrix API
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

    var airportsWithCharge = [
        "Melbourne Airport",
        "Tullamarine Airport"
    ];

    bindCalc();

    function bindCalc() {
        $("#vehicle-type, #baby-seats").on("change", function(){
            if ($("#airport-type-con").is(":visible")) {
                addAirportTypes();
            }

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
            if ($(this).attr("id") == "origin") {
                showAirportTypes();
            }
            if ($("#airport-type-con").is(":visible")) {
                addAirportTypes();
            }

            count = 0;
            $.map(requiredFields, function(obj){
                if (obj.val()) {
                    ++count;
                }
                if (count == requiredFields.length) {
                    calculateDistance();
                }
            });
        });

        $(".airport-type").on("click", function(){
            addAirportTypes();
            activateEl($(this).parent(), $(".airport-type").closest("div").find("label"));

            count = 0;
            $.map(requiredFields, function(obj){
                if (obj.val()) {
                    ++count;
                }
                if (count == requiredFields.length) {
                    calculateDistance();
                }
            });
        });
    }

    function showAirportTypes() {
        $.map(airportsWithCharge, function(val){
            if ($("#origin").val().indexOf(val) !== -1) {
                $("#airport-type-con").slideDown(150);
            }
        });
    }

    function addAirportTypes() {
        requiredFields.push($("#airport-type-con").find("input"));
    }

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
                    "origin": $("#origin").val(),
                    "pickupDate": $("#pickup-date").val(),
                    "airportType": $(".airport-type:checked").val(),
                    "vehicleType": $("#vehicle-type").val(),
                    "babySeats": $("#baby-seats").val(),
                    "action": "tb_calculate",
                    "_wpnonce": TB_APP_Vars_Frontend.nonce
                };

            $.post(TB_APP_Vars_Frontend.ajaxurl, data, function(res) {
                res = $.parseJSON(res);

                if (!res.error) {
                    $("#quote-result-right").text("$" + res.quote + "*");
                    $("#metadata #duration span").text(response.rows[0].elements[0].duration.text);
                    $("#metadata #distance span").text(response.rows[0].elements[0].distance.text);
                } else {
                    console.log(res.message);
                }
            });
        }
    }

    function activateEl(target, all) {
        all.removeClass("active");
        target.addClass("active");
    }

    var selects = $("#booking-form .dropdown");
    selects.easyDropDown({
        cutOff: 10,
        onChange: function(selected){
            // do something
        }
    });

    // baby seats
    $("#babyseats-controls .carat-up").on("click", function(){
        var val = parseInt($("#baby-seats").val() ? $("#baby-seats").val() : 0) + 1;
        $("#baby-seats").val(val);
    });
    $("#babyseats-controls .carat-down").on("click", function(){
        var val = $("#baby-seats").val() != false && $("#baby-seats").val() != "NAN"  ? parseInt($("#baby-seats").val()) - 1 : 0;
        $("#baby-seats").val(val);
    });
});