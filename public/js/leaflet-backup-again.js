let marker = [];
const map = L.map("map").setView([-8.7945, 115.1769], 14); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

var greenIcon = new L.Icon({
    iconUrl:
        "https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
    shadowUrl:
        "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41],
});

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

function clickZoom(e) {
    map.setView(e.target.getLatLng(), 16);
}

map.on("click", function (e) {
    if (user) {
        document.getElementById("create_hotel_button").click();
        document.getElementById("create_hotel_lat").value = e.latlng.lat;
        document.getElementById("create_hotel_lng").value = e.latlng.lng;
    }
});

marker.forEach(function (m, index) {
    m.on("click", function (e) {
        map.setView(e.target.getLatLng(), 16);
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

function goToMarker(id) {
    hotels.forEach(function (hotel, index) {
        if (hotel.id == id) {
            map.setView([hotel.lat, hotel.lng], 16);
        }
    });
}

function addRouting(lat, lng) {
    L.Routing.control({
        waypoints: [
            L.latLng(-8.523760814100195, 115.21073223010504),
            L.latLng(-8.796295620586948, 115.17598429035017),
        ],
        lineOptions: {
            styles: [{ color: "green", opacity: 1, weight: 5 }],
        },
        routeWhileDragging: false,
        createMarker: function (i, wp, nWps) {
            if (i == 0) {
                return L.marker([-8.796295620586948, 115.17598429035017], {
                    icon: greenIcon,
                    draggable: true,
                    bounceOnAdd: false,
                });
            }
        },
    }).addTo(map);
}
