let marker = [];
const map = L.map("map").setView([-8.7945, 115.1769], 14); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

let markerClusters = L.markerClusterGroup();

hotels.forEach(function (hotel, index) {
    if (user) {
        marker.push(
            new L.Marker([hotel.lat, hotel.lng], {
                icon: L.icon({
                    iconUrl: hotel.icon,
                    iconSize: [50, 50],
                    iconAnchor: [25, 25], // x/2, y-1
                }),
                draggable: true,
            })
        );
    } else {
        marker.push(
            new L.Marker([hotel.lat, hotel.lng], {
                icon: L.icon({
                    iconUrl: hotel.icon,
                    iconSize: [50, 50],
                    iconAnchor: [25, 25], // x/2, y-1
                }),
                draggable: false,
            })
        );
    }
    markerClusters.addLayer(L.layerGroup(marker));
});

map.addLayer(markerClusters);

map.on("click", function (e) {
    if (user) {
        document.getElementById("create_hotel_button").click();
        document.getElementById("create_hotel_lat").value = e.latlng.lat;
        document.getElementById("create_hotel_lng").value = e.latlng.lng;
    }
});

marker.forEach(function (m, index) {
    m.on("click", function (e) {
        document.getElementById(`hotel_button_${hotels[index].id}`).click();
    });
    if (user) {
        m.on("dragend", function (e) {
            document.getElementById(
                `edit_hotel_location_lat_${hotels[index].id}`
            ).value = e.target.getLatLng().lat;
            document.getElementById(
                `edit_hotel_location_lng_${hotels[index].id}`
            ).value = e.target.getLatLng().lng;
            document
                .getElementById(
                    `edit_hotel_location_button_${hotels[index].id}`
                )
                .click();
        });
    }
});
