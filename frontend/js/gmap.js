var GMap = function GMap(options) {
    this.input = options.input;
    this.mapCanvas = options.mapCanvas;
    this.defaultLatLng = options.defaultLatLng.split(",");
    this.init();
}

GMap.prototype.init = function () {
    var styles = [
        {
            "featureType":"water",
            "stylers":[
                {"color":"#242841"}
            ]
        },{
            "featureType":"landscape",
            "stylers":[
                {"color":"#1E223B"}
            ]
        },{
            "featureType":"poi",
            "elementType":"geometry",
            "stylers":[
                {"color":"#30344D"}
            ]
        },{
            "featureType":"road.highway",
            "elementType":"geometry.fill",
            "stylers":[
                {"color":"#494D66"}
            ]
        },{
            "featureType":"road.highway",
            "elementType":"geometry.stroke",
            "stylers":[
                {"color":"#61657C"}
            ]
        },{
            "featureType":"road.arterial",
            "elementType":"geometry.fill",
            "stylers":[
                {"color":"#12162F"}
            ]
        },{
            "featureType":"road.arterial",
            "elementType":"geometry.stroke",
            "stylers":[
                {"color":"#272B46"}
            ]
        },{
            "featureType":"road.local",
            "elementType":"geometry",
            "stylers":[
                {"color":"#2A2E47"}
            ]
        },{
            "elementType":"labels.text.fill",
            "stylers":[
                {"color":"#999DB6"}
            ]
        },{
            "elementType":"labels.text.stroke",
            "stylers":[
                {"color":"#131730"}
            ]
        },{
            "featureType":"transit",
            "stylers":[
                {"color":"#2A2E47"}
            ]
        },{
            "featureType":"administrative",
            "elementType":"geometry.fill",
            "stylers":[
                {"color":"#000000"}
            ]
        },{
            "featureType":"administrative",
            "elementType":"geometry.stroke",
            "stylers":[
                {"color":"#2F334C"},
                {"lightness":14},
                {"weight":1.4}
            ]
        }
    ];

    var mapOptions = {
        center: new google.maps.LatLng(this.defaultLatLng[0] ? this.defaultLatLng[0] : -33.8688, this.defaultLatLng[1] ? this.defaultLatLng[1]: 151.2195),
        zoom: 13,
        disableDefaultUI: true
    };

    var map = new google.maps.Map(document.getElementById(this.mapCanvas), mapOptions);
        map.setOptions({styles: styles});
    var input = document.getElementById(this.input);
    var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    google.maps.event.addListener(autocomplete, "place_changed", function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);


        var address = "";
        if (place.address_components) {
          address = [
            (place.address_components[0] && place.address_components[0].short_name || ""),
            (place.address_components[1] && place.address_components[1].short_name || ""),
            (place.address_components[2] && place.address_components[2].short_name || "")
          ].join(" ");
        }
        infowindow.setContent("<div><strong>" + place.name + "</strong><br>" + address);
        infowindow.open(map, marker);
    });
}