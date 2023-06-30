let marker = [];
let countRouting = 0;

// Initialize Map
const map = L.map("map").setView([-8.7945, 115.1769], 14); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

let markerClusters = L.markerClusterGroup(); //c

if (mode == "view" || mode == "routing") {
    hotels.forEach(function (hotel, index) {
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
        markerClusters.addLayer(L.layerGroup(marker));
    });
    map.addLayer(markerClusters);
} else {
    hotels.forEach(function (hotel, index) {
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
        markerClusters.addLayer(L.layerGroup(marker));
    });
    map.addLayer(markerClusters);
}

function clickZoom(e) {
    map.setView(e.target.getLatLng(), 16);
}

function goToMarker(id) {
    hotels.forEach(function (hotel, index) {
        if (hotel.id == id) {
            map.setView([hotel.lat, hotel.lng], 16);
        }
    });
}

if (user) {
    // Initialize view mode
    const viewButton = L.easyButton({
        states: [
            {
                icon: "fa-solid fa-eye fa-lg",
            },
        ],
        id: "viewButton",
        position: "topleft",
    }).addTo(map);

    // Initialize hotel mode
    const hotelButton = L.easyButton({
        states: [
            {
                icon: "fa-solid fa-building fa-lg",
            },
        ],
        id: "hotelButton",
        position: "topleft",
    }).addTo(map);
}

if (!user) {
    const viewButton = L.easyButton({
        states: [
            {
                icon: "fa-solid fa-eye fa-lg",
            },
        ],
        id: "viewButton",
        position: "topleft",
    }).addTo(map);
}

if (mode == "routing") {
    const routingButton = L.easyButton({
        states: [
            {
                icon: "fa-solid fa-location fa-lg",
            },
        ],
        id: "routingButton",
        position: "topleft",
    }).addTo(map);
}

// Listener for Map when Clicked
map.on("click", function (e) {
    if (user && mode == "hotel") {
        document.getElementById("create_hotel_button").click();
        document.getElementById("create_hotel_lat").value = e.latlng.lat;
        document.getElementById("create_hotel_lng").value = e.latlng.lng;
    }
    if (mode == "routing" && countRouting == 0) {
        let greenIcon = new L.Icon({
            iconUrl:
                "https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
            shadowUrl:
                "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41],
        });

        console.log(hotels[routing_hotel]);
        L.Routing.control({
            waypoints: [
                e.latlng,
                L.latLng(hotels[routing_hotel].lat, hotels[routing_hotel].lng),
            ],
            lineOptions: {
                styles: [{ color: "green", opacity: 1, weight: 5 }],
            },
            routeWhileDragging: false,
            createMarker: function (i, wp, nWps, e) {
                if (i == 0) {
                    return L.marker(wp.latLng, {
                        icon: greenIcon,
                        draggable: true,
                        bounceOnAdd: false,
                    });
                }
            },
        }).addTo(map);
        countRouting++;
    }
});

// Add Listeners to Marker
marker.forEach(function (m, index) {
    m.on("click", function (e) {
        map.setView(e.target.getLatLng(), 16);
        document.getElementById(`hotel_button_${hotels[index].id}`).click();
    });
    if (user && mode == "hotel") {
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
