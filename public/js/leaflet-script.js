let mode = "view";
let marker = [];
const map = L.map("map").setView([-8.7945, 115.1769], 16); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

const mapIcon = L.icon({
    iconUrl: "images/hotel.png",
    iconSize: [50, 50],
    iconAnchor: [25, 25], // x/2, y-1
});

hotels.forEach(function (hotel, index) {
    marker.push(
        new L.Marker([hotel.lat, hotel.lng], {
            icon: mapIcon,
            draggable: false,
        }).addTo(map)
    );
});

const viewButton = L.easyButton({
    states: [
        {
            onClick: function (map) {
                mode = "view";
                marker.forEach(function (m, index) {
                    m.dragging.disable();
                });
            },
            icon: "fa-solid fa-eye fa-lg",
        },
    ],
}).addTo(map);

const hotelButton = L.easyButton({
    states: [
        {
            onClick: function (map) {
                mode = "hotel";
                marker.forEach(function (m, index) {
                    m.dragging.enable();
                });
            },
            icon: "fa-solid fa-building fa-lg",
        },
    ],
}).addTo(map);

map.on("click", function (e) {
    if (mode === "hotel") {
        document.getElementById("buttonModal").click();
        document.getElementById("lat").value = e.latlng.lat;
        document.getElementById("lng").value = e.latlng.lng;
        //
    } else if (mode === "view") {
        //
    }
});

marker.forEach(function (m, index) {
    m.on("click", function (e) {
        if (mode === "hotel") {
            var popup = L.popup(e.latlng, {
                content: `
                <p>Hotel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].name}
                <br />
                Address &nbsp; : ${hotels[index].address}
                <br />
                Phone &nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].phone}
                <br />
                Lat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].lat}
                <br />
                Lng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${hotels[index].lng}
                <br />
                <div class="d-flex flex-row-reverse">
                <button class="btn btn-success btn-sm" onclick="updateModal(${index})">Edit</button>
                <a type="button" class="btn btn-danger btn-sm me-2 text-white" href="http://krisnadana-gis2.cleverapps.io/delete/${hotels[index].id}">Delete</a>
                </div>
                </p>`,
            }).openOn(map);
        } else if (mode === "view") {
            var popup = L.popup(e.latlng, {
                content: `
                <p>Hotel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].name}
                <br />
                Address &nbsp; : ${hotels[index].address}
                <br />
                Phone &nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].phone}
                <br />
                Lat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].lat}
                <br />
                Lng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${hotels[index].lng}
                </p>`,
            }).openOn(map);
        }
    });
    m.on("drag", function (e) {
        if (mode === "hotel") {
            var popup = L.popup(e.latlng, {
                content: `
                <p>Hotel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].name}
                <br />
                Address &nbsp; : ${hotels[index].address}
                <br />
                Phone &nbsp;&nbsp;&nbsp;&nbsp; : ${hotels[index].phone}
                <br />
                Lat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ${e.latlng.lat}
                <br />
                Lng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${e.latlng.lng}
                </p>`,
            }).openOn(map);
        }
    });
    m.on("dragend", function (e) {
        if (mode === "hotel") {
            // fetch(
            //     `http://localhost:8000/edit/${hotels[index].id}/${
            //         e.target.getLatLng().lat
            //     }/${e.target.getLatLng().lng}`
            // );
            fetch(
                `http://krisnadana-gis2.cleverapps.io/edit/${
                    hotels[index].id
                }/${e.target.getLatLng().lat}/${e.target.getLatLng().lng}`
            );
            // fetch(
            //     `<?php echo route('edit', ['id' => ${
            //         hotels[index].id
            //     }, 'lat' => ${e.target.getLatLng().lat}, 'lng' => ${
            //         e.target.getLatLng().lng
            //     }]) ?>;`
            // );
        }
    });
});

const updateModal = (index) => {
    document.getElementById("updateButtonModal").click();
    // document.getElementById(
    //     "update_form"
    // ).action = `http://localhost:8000/edit/${hotels[index].id}`;
    document.getElementById(
        "update_form"
    ).action = `http://krisnadana-gis2.cleverapps.io/edit/${hotels[index].id}`;
    document.getElementById("update_name").value = hotels[index].name;
    document.getElementById("update_address").value = hotels[index].address;
    document.getElementById("update_phone").value = hotels[index].phone;
    document.getElementById("update_lat").value = hotels[index].lat;
    document.getElementById("update_lng").value = hotels[index].lng;
};

// document
//     .getElementById("create-hotel-submit")
//     .addEventListener("click", function () {
//         fetch("http://localhost:8000/api/hotel", {
//             headers: {
//                 Accept: "application/json",
//                 "Content-Type": "application/json",
//             },
//             method: "POST",
//             body: JSON.stringify({
//                 hotel_name: document.getElementById("create-hotel-name").value,
//                 hotel_address: document.getElementById("create-hotel-address")
//                     .value,
//                 hotel_phone:
//                     document.getElementById("create-hotel-phone").value,
//                 hotel_lat: document.getElementById("create-hotel-lat").value,
//                 hotel_lng: document.getElementById("create-hotel-lng").value,
//             }),
//         })
//             .then((response) => response.json())
//             .then(alert(response.message))
//             .then(console.log("message"));
//     });
